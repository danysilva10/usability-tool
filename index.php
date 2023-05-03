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
    <title>Login</title>
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
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['id'] = $row['Id'];
                }else{
                    echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                        </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button>";
            
                }
                if(isset($_SESSION['valid'])){
                    header("Location: home.php");
                }
                }else{

            
            ?>

            <header>Login</header>
            <form action="" method="post">
                <div class="input-group">
                    <div class="field input">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <i class="fa-solid fa-lock"></i> 
                        <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" required>
                    </div>
    
                    <div class="field-btn">
                        <input type="submit" class="btn sign" name="submit" value="Login" required>
                    </div>
    
                    <div class="links">
                        Don't have account? <a href="register.php">Sign Up Now</a>
                    </div>
                </div>
    
                
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>