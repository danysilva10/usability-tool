<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['code'])){
    header("Location: participants-form.php");
   }
   $study_id = urldecode($_GET['id']);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Calibration Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/general.css">
  <script src="https://webgazer.cs.brown.edu/webgazer.js?"></script>
  <script>
    // Set up Webgazer
    webgazer.clearData();
    webgazer.setRegression('ridge')
             .setTracker('clmtrackr')
             .setGazeListener(function(data, elapsedTime) {
                 // do something with gaze data
             })
             .begin();

    // Set up calibration points
    var calibrationPoints = [
        [50, 50], // top left
        [window.innerWidth / 2, 50], // top center
        [window.innerWidth - 50, 50], // top right
        [50, window.innerHeight / 2], // middle left
        [window.innerWidth - 50, window.innerHeight / 2], // middle right
        [50, window.innerHeight - 50], // bottom left
        [window.innerWidth / 2, window.innerHeight - 50], // bottom center
        [window.innerWidth - 50, window.innerHeight - 50], // bottom right
        [window.innerWidth / 2, window.innerHeight / 2] // center
    ];

    var currentPoint = 0;
    var numClicks = 0;

    // Set up event listener for click on calibration point
    document.addEventListener('click', function(event) {
        // Get click coordinates
        var x = event.clientX;
        var y = event.clientY;

        // Record data point for Webgazer
        webgazer.recordScreenPosition(x, y, 'calibration');

        // Increment number of clicks on current dot
        numClicks++;

        // Move to next calibration point or finish calibration
        if (numClicks === 9) {
            numClicks = 0;
            if (currentPoint < calibrationPoints.length - 1) {
                currentPoint++;
                // Move calibration point
                var point = calibrationPoints[currentPoint];
                var pointElement = document.getElementById('calibration-point');
                pointElement.style.left = point[0] + 'px';
                pointElement.style.top = point[1] + 'px';
            } else {
                // Finish calibration
                webgazer.end();
                window.location.href = "start-test.php?id=<?php echo urlencode($study_id) ?>";
            }
        }
    });

  </script>
  <style>
    #calibration-point {
      position: absolute;
      top: 50px;
      left: 50px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background-color: red;
      z-index: 100;
    }
  </style>
</head>
<body>
  <div id="calibration-point"></div>
  <p class="text-center">Click on the red dot 9 times, then follow the instructions to move to the next point.</p>
</body>
</html>
