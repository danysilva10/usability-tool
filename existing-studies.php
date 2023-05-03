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
                <div class="col-8 offset-2">
                    <div class="row">
                        <?php 
                            $query = mysqli_query($con,"SELECT*FROM studies WHERE User_id=$id ORDER BY Id DESC");
                            $check = false;
                            while($result = mysqli_fetch_assoc($query)){

                                $check = true;
                                $study_id = $result['Id'];
                                $query_participants = mysqli_query($con, "SELECT COUNT(*) as count FROM participants WHERE Study_id=$study_id");
                                $count_participants = mysqli_fetch_assoc($query_participants)['count'];
                                
                                echo "<div class='col-4 study-div'>
                                        <a href='study-info.php?id=".urlencode($study_id)."'>
                                            <div class='row title-prev text-center align-items-center'>
                                                <p class='m-0'><strong>".$result['Title']."</strong></p>
                                            </div>
                                            <div class='row description-prev'>
                                                <div class='row pt-1'>
                                                    <p class='m-0 date'>".$result['CurrentDate']."</p>
                                                </div>
                                                <div class='row'>
                                                    <p class='m-0 date'>".$result['Status']." &#183; ".$count_participants." participants</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>";
                            }
                            if($check = false) {
                                echo "<div class='text-center'><p style='color: gray'><i>No studies done yet.</i></p></div>";
                            }
                        ?>

                    </div>
                </div>
            </div>
        </main>
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
</body>
</html>