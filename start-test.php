<?php
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['code'])){
    header("Location: participants-form.php");
   }

   // Get the study ID from the URL parameter
   $study_id = urldecode($_GET['id']);
   
   // Get the screens for this study from the database
    $result = mysqli_query($con,"SELECT s.*, c.Screen_text, c.Screen_image FROM screens s JOIN screen_contents c ON s.Id = c.Screen_id WHERE s.Study_id = '$study_id'") or die("Select Error");
    $screens = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

    <script src="https://webgazer.cs.brown.edu/webgazer.js?"> </script>
    <script src="https://kit.fontawesome.com/bd6b28b390.js" crossorigin="anonymous"></script>
    <style>
        #countdown-container {
            display: flex;
            justify-content: center;
            align-items: center; 
            font-weight: bold;
            font-size: 22px;
            height: 100vh;
        }

        #text-display {
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div id="countdown-container">
		<h2>The test will begin in <span id="countdown-number">5</span> seconds.</h2>
	</div>

    <main>
        <!-- Create a div to display the screens -->
        <div class="row text-center">
            <div id="image-display"></div>
            <div id="text-display"></div>
        </div>
        
    </main>
    
    <script>
        var xhr = new XMLHttpRequest();
        var isImageScreen = false;
        var currentTime = false;
        var endStudy = false;
        var timestamp = 0;
        var img_count = 1;
        var screenPositions = [];
        // Start the countdown when the page loads
		window.onload = function() {

            webgazer.setGazeListener(function(data, elapsedTime) {
                if (isImageScreen) {
                    if (currentTime) {
                        timestamp = elapsedTime;
                        currentTime = false;
                    }
                    
                    if (elapsedTime % 50 < 20) { // store position every 50ms
                        var position = {
                            x: data.x.toFixed(3),
                            y: data.y.toFixed(3),
                            timestamp: (elapsedTime-timestamp).toFixed(3),
                            imgNum: img_count
                        }
                        screenPositions.push(position);
                        console.log(position); // or do something else with x and y
                    }
                }
                if (endStudy) {
                    webgazer.pause();
                    webgazer.end();
                    console.log("done");
                    console.log(screenPositions);

                    // Create a new XMLHttpRequest object
                    var xhr = new XMLHttpRequest();
                    
                    // Open a POST request to the store-data.php page
                    xhr.open("POST", "php/store-data.php?id=" + <?php echo json_encode($study_id); ?> , true);

                    // Set the request header to indicate that we are sending JSON data
                    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                    // Convert the screenPositions object to a JSON string and send it as the request body
                    xhr.send(JSON.stringify(screenPositions));

                    // Redirect to the success page>
                    console.log("sucessoo");
                }
            }).begin();

			var count = 5;
			var countdownElement = document.getElementById('countdown-number');
			var countdownInterval = setInterval(function() {
				count--;
				countdownElement.innerHTML = count;
				if (count == 0) {
					clearInterval(countdownInterval);
					// countdown is done
                    document.getElementById("countdown-container").remove();
                    displayScreen();
				}
			}, 1000);
		};
        

        // Define a variable to keep track of the current screen index
        var currentScreenIndex = 0;
        // Define a function to display the current screen and schedule the next one
        function displayScreen() {
            isImageScreen = false;
            // Get the current screen
            var imageElem = document.getElementById('image-display');
            var textElem = document.getElementById('text-display');
            let screens = <?php echo json_encode($screens); ?>;
    
            if (currentScreenIndex < screens.length) {
                var screen = screens[currentScreenIndex];
                
                if (screen.Screen_type == 'Image') {
                    isImageScreen = true;
                    currentTime = true;
                    textElem.innerText = '';
                    textElem.style.height = "0";
                    imageElem.innerHTML = `<img src="php/uploads/${screen.Screen_image}" alt="Screen Image">`;
                    var imgElem = imageElem.querySelector('img');
                    imgElem.style.height = "100vh";
                    imageElem.style.height = "100vh";
                    imageElem.style.backgroundColor = "black";
                    setTimeout(function() {
                        currentScreenIndex++;
                        img_count++;
                        displayScreen();
                    }, screen.Screen_time * 1000);
                } else {
                    imageElem.innerHTML = '';
                    imageElem.style.height = "0";
                    textElem.style.height = "100vh";
                    textElem.innerHTML = screen.Screen_text;
                    setTimeout(function() {
                        currentScreenIndex++;
                        displayScreen();
                    }, screen.Screen_time * 1000);
                }
            } else {
                imageElem.innerHTML = '';
                imageElem.style.height = "0";
                textElem.innerText = '';
                textElem.style.height = "100vh";
                textElem.innerText = "This is the end of the study, thank you!"
                endStudy = true;
                console.log("this is first");
                // All screens have been displayed, do something else
            }
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>

</body>
</html>