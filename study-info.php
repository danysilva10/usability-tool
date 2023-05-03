<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/existing-studies.css">
    <link rel="stylesheet" href="styles/study-info.css">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>
</head>
<body>
        <div class="nav">
            <?php 
                
                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_id = $result['Id'];
                }
            ?>

            <div class="row user-name">
                <p><b>Welcome, <?php echo $res_Uname?></b></p>
            </div>
            <div class="row middle-links">
                <div class="middle-titles d-grid gap-2 d-flex justify-content-md-center">
                    <a href="home.php">Home</a>
                    <a href="create-study.php">New Study</a>
                    <a class="current-link" href="existing-studies.php">Previous Studies</a>
                </div>
                
            </div>
            <div class="right-links">
                <a href="php/logout.php"> <button class="btnLogOut">Log Out</button> </a> 
            </div>
        </div>
        
        <main>
            <div id="containerId" class="container">
                <div class="col-10 offset-1">
                    <?php 
                        $study_id = urldecode($_GET['id']);
    
                        $result = mysqli_query($con,"SELECT * FROM studies WHERE Id='$study_id'") or die("Select Error");
                        $row = mysqli_fetch_assoc($result);
                        $title = $row['Title'];
                        $code = $row['Code'];
                        $status = $row['Status'];
                        $date = $row['CurrentDate'];
                    ?>
                    <div class="row mb-3">
                        <h1 style="color: green;"><?php echo $title ?></h1>
                    </div>
                    <div class="row">
                        <div class="col-8 prev-div">
                            <div class="row mb-3 study-prev">
                                <div id="carouselExampleIndicators" class="carousel carousel-dark c-slide">
                                    
                                    <div class="carousel-inner c-inner">
                                        <?php 
                                            $query = mysqli_query($con,"SELECT*FROM screens WHERE Study_id=$study_id");
                                            $count = 0;

                                            while($result = mysqli_fetch_assoc($query)) {
                                                $screen_id = $result['Id'];
                                                $query_screen = mysqli_query($con, "SELECT*FROM screen_contents WHERE Screen_id=$screen_id");
                                                $result_screen = mysqli_fetch_assoc($query_screen);

                                                if($result['Screen_type'] === "Image") {
                                                    $image_url = $result_screen['Screen_image'];

                                                    if($count === 0) {
                                                        echo "<div class='carousel-item active c-item'>
                                                                <img src='php/uploads/$image_url' class='d-block w-100 c-img' alt='Ola1'>
                                                            </div>";
                                                    } else {
                                                        echo "<div class='carousel-item c-item'>
                                                                <img src='php/uploads/$image_url' class='d-block w-100 c-img' alt='Ola1'>
                                                            </div>";
                                                    }
                                                } else if($result['Screen_type'] === "Text") {
                                                    $text = $result_screen['Screen_text'];
                                                    
                                                    if($count === 0) {
                                                        echo "<div class='carousel-item active c-item'>
                                                            <p>$text</p>
                                                        </div>";
                                                    } else {
                                                        echo "<div class='carousel-item c-item'>
                                                            <p>$text</p>
                                                        </div>";
                                                    }
                                                }
                                                $count++;
                                            }
                                        ?>
                                    </div>
                                    
                                    <div class="carousel-indicators">
                                        <?php 
                                            for($i = 0; $i<$count; $i++) {
                                                if($i === 0) {
                                                    echo "<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$i' class='active' aria-current='true' aria-label='Slide $i'></button>";
                                                } else {
                                                    echo "<button type='button' data-bs-target='#carouselExampleIndicators' data-bs-slide-to='$i' aria-label='Slide $i'></button>";
                                                }
                                            }
                                        ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                        <a href="php/export.php?study_id=<?php echo $study_id ?>" class="btn btn-outline-secondary">Export csv data</a>
                                        <a href="php/heatmap-example.php?study_id=<?php echo $study_id ?>" class="btn btn-outline-secondary">Heatmap</a>
                                        <button type="button" onclick="window.location.href='#'" class="btn btn-outline-secondary">Gaze Plot</button>
                                    
                                </div>
                            </div>
                        </div>
                        <?php /*
                            if(isset($_POST['export-csv-btn'])) {
                                // get the data to be inserted into the database
                                $name = "Teste";
                                $age = 20;
                                $gender = "Male";
                                $studyId = 113;
                            
                                // insert the data into the database
                                //$query = mysqli_query($con, "INSERT INTO participants (Study_id, Name, Age, Gender) VALUES ('$studyId', '$name', '$age', '$gender')");
                            
                                // Open output stream for writing CSV data
                                $output = fopen('php://output', 'w');

                                // Write headers for CSV columns
                                fputcsv($output, array('Name', 'Age', 'Gender'));

                                // Retrieve participants data from database
                                $study_id = urldecode($_GET['id']);
                                $query = mysqli_query($con,"SELECT * FROM participants WHERE Study_id=$study_id");
                                
                                // Loop through participants data and write to CSV
                                while($result = mysqli_fetch_assoc($query)) {
                                    $name = $result['Name'];
                                    $age = $result['Age'];
                                    $gender = $result['Gender'];

                                    fputcsv($output, array($name, $age, $gender));
                                }
                                
                                header('Content-Type: text/csv; charset=utf-8');
                                header('Content-Disposition: attachment; filename=participants.csv');

                                // Close output stream
                                fclose($output);
                                exit();
                            
                            }   */
                        ?>
                        <div class="col-4 participants-list">
                            <p class="text-center"><strong>Participants List</strong></p>
                            <hr>
                            <div style="overflow-y: scroll; max-height: 400px;">
                                <?php 
                                    $query = mysqli_query($con,"SELECT*FROM participants WHERE Study_id=$study_id");
                                    $count = 1;
                                    while($result = mysqli_fetch_assoc($query)){
                                        echo "<p class='mb-2'>".$count.". ".$result['Name'].", ".$result['Age'].", ".$result['Gender']."</p>";
                                        $count++;
                                    }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <p class="mb-0"><strong>ID Code: </strong><?php echo $code ?></p>
                        <p class="mb-0"><strong>Status: </strong><?php echo $status ?></p>
                        <p class="mb-0"><strong>Date: </strong><?php echo $date ?></p>
                    </div>
                    <div class="row mb-3">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <form method="post" action="php/delete-study.php">
                                <input type="hidden" name="study_id" value="<?php echo $study_id ?>">
                                <button type="submit" name="delete-btn" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this study?')">Delete</button>
                                <button type="submit" name="update-btn" class="btn btn-outline-success add-screens-btn" onclick="return confirm('Are you sure you want to complete this study?')">Complete Study</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
</body>
</html>