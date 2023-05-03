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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    
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
                    <a class="current-link" href="#">Home</a>
                    <a href="create-study.php">New Study</a>
                    <a href="existing-studies.php">Previous Studies</a>
                </div>
                
            </div>
            <div class="right-links">
                <a href="php/logout.php"> <button class="btnLogOut">Log Out</button> </a> 
            </div>
        </div>

        <div>
            <div class="container">
                <div class="col-8 offset-2">
                    <div class="row mb-3 text-center">
                        <h1>Usability Testing Tool</h1>
                    </div>
                    
                    <div class="row mb-3 description">
                        <p>
                        There are currently several tools available on the market that may be used for usability testing, but many of them are targeted at businesses and may be difficult for people without a background in design or development to acquire or use.
                        </br></br>The goal of this thesis is to address this issue by developing a web-based tool that can be used by anyone, regardless of their level of experience or expertise, to design and develop user-friendly digital products or services. Through the research process, it became clear that there is a strong demand for a tool like this, as it would allow individuals and small organizations to conduct usability testing on their own, without the need for expensive equipment or specialized knowledge.
                        </br></br>Overall, the proposed tool has the potential to make a significant impact in the field of usability testing and user experience design, by making it more accessible and affordable for a wider range of users.
                        </p>
                    </div>

                    <div class="row">
                        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                            <button type="button" onclick="window.location.href='create-study.php'" class="create-btn"><i class="fa-solid fa-plus"></i>Create New Study</button>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
</body>
</html>