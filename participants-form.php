<?php
    session_start();
    session_destroy();
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Code</title>
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/form.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
                
                include("php/config.php");
                if(isset($_POST['submit'])){
                $code = mysqli_real_escape_string($con,$_POST['code']);

                $result = mysqli_query($con,"SELECT * FROM studies WHERE Code='$code'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);
                if(is_array($row) && !empty($row)){
                    $_SESSION['code'] = $code;
                    $_SESSION['participant_name'] = mysqli_real_escape_string($con,$_POST['username']);
                    $_SESSION['participant_age'] = mysqli_real_escape_string($con,$_POST['age']);
                    $_SESSION['participant_gender'] = mysqli_real_escape_string($con,$_POST['gender']);
                    $study_id = $row['Id'];
                    //mysqli_query($con, "INSERT INTO participants(Study_id, Name, Age, Gender) VALUES('$study_id', '$participant_name', '$participant_age', '$participant_gender')") or die("Error Occured");
                    //$_SESSION['participant_id'] = mysqli_insert_id($con);
                    header("Location: welcome-test.php?id=".urlencode($study_id));

                } else {
                    echo "<div class='message'>
                        <p>That code doesn't exist!</p>
                        </div> <br>";
                    echo "<a href='usability-study.php'><button class='btn'>Go Back</button>";
                }
                }else{

            
            ?>

            <header>Usability Test</header>
            <form action="" method="post">
                <div class="input-group">

                    <div class="field input">
                        <input type="text" placeholder="Enter Code" name="code" id="code" autocomplete="off" required>
                    </div>
                    
                    <div>
                        <hr>
                    </div>

                    <div class="field input">
                        <input type="text" placeholder="Name" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <input type="number" placeholder="Age" name="age" id="age" autocomplete="off" required>
                    </div>

                    <div class="select-div">
                        <select class="form-select" name="gender" id="gender-select" required>
                            <option value="">Select gender..</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
    
                    <div class="field-btn">
                        <input type="submit" class="btn sign" name="submit" value="Continue" required>
                    </div>
                </div>
    
                
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>