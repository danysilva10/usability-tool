<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //verifyng the unique email

            $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

            if(mysqli_num_rows($verify_query) !=0 ) {
                echo "<div class='message'>
                        <p>This email is used, try another one please!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button> ";

            }
            else {
                mysqli_query($con, "INSERT INTO users(Username, Email, Password) VALUES('$username', '$email', '$password')") or die("Error Occured");

                echo "<div class='message'>
                        <p>Registration successfully!</p>
                      </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button> ";
            }
        }else{

        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="input-group">
                    <div class="field input">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" placeholder="Name" name="username" id="username" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" placeholder="Email" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <i class="fa-solid fa-lock"></i> 
                        <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" required>
                    </div>
    
                    <div class="field-btn">
                        <input type="submit" class="btn sign" name="submit" value="Sign Up" required>
                    </div>
    
                    <div class="links">
                        Already a member? <a href="index.php">Sign In</a>
                    </div>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>