<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['code'])){
    header("Location: participants-form.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/general.css">
    <link rel="stylesheet" href="styles/welcome-test.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>

</head>
<body>
    <main>
        <div class="welcome-div container d-flex flex-column justify-content-between vh-100">
                 <?php
                    $study_id = urldecode($_GET['id']);

                    $result = mysqli_query($con,"SELECT * FROM studies WHERE Id='$study_id'") or die("Select Error");
                    $row = mysqli_fetch_assoc($result);
                    $title = $row['Title'];
                    $instructions = $row['Instructions'];
                    $user_id = $row['User_id'];

                    $result_user = mysqli_query($con,"SELECT * FROM users WHERE Id='$user_id'") or die("Select Error");
                    $row_user = mysqli_fetch_assoc($result_user);
                    $username = $row_user['Username'];
                ?>
            <div class="top-text mb-3">
                <div class="text-center">
                    <h1> Welcome to the Usability Test Study </h1>
                    <h2> made by <?php echo $username?> </h2>
                </div>
            </div>
            <div class="middle-text text-center mb-3">
                <div class="mb-3">
                    Study ID: <?php echo $study_id?>
                </div>
                <div class="mb-3">
                    Title: <?php echo $title?>
                </div>
                <div class="mb-3">
                    Instructions: <?php echo $instructions?>
                </div>
            </div>
            <div class="bottom-text">
                <div class="text-center">
                    <h5 class="jump-out">Press ENTER to start the test.</h5>
                </div>
            </div>
        </div>
        
    </main>
    <script>
		// Listen for the Enter key press event
		document.addEventListener('keydown', function(event) {
			if (event.code === 'Enter') {
				// Redirect to the countdown page when Enter is pressed
                window.location.href = "webgazer-calibration.php?id=<?php echo urlencode($study_id) ?>";
                //window.location.href = "WebGazer-master/www/calibration.html";
				//window.location.href = "countdown.php?id=<?php echo urlencode($study_id) ?>";
			}
		});
        // Fade in
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.container').classList.add('show');
        });
	</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</body>
</html>