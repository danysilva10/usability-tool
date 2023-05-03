<?php
    include("config.php");

    $study_id = $_GET['study_id'];
    $query = mysqli_query($con,"SELECT * FROM participants WHERE Study_id=$study_id");
    $heatmapData = array();

    while($result = mysqli_fetch_assoc($query)) {

        $data = json_decode($result['Eye_data'], true);

        foreach ($data as $position) {
            $heatmapData[] = array(
                'x' => $position['x'],
                'y' => $position['y'],
                'timestamp' => $position['timestamp'],
                'imgNum' => $position['imgNum']
            );
        }
    }
    $heatmapDataJson = json_encode($heatmapData);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heatmap Example</title>

</head>
<body>
    <!-- Create a canvas element to hold the heatmap -->
    <canvas id="heatmapCanvas"></canvas>

    <script>
        
        var canvas = document.getElementById('heatmapCanvas');
        var ctx = canvas.getContext('2d');

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        // Define the gradient color scale
        var gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
        gradient.addColorStop(0, 'green');
        gradient.addColorStop(0.5, 'yellow');
        gradient.addColorStop(1, 'red');

        var heatmapData = <?php echo $heatmapDataJson; ?>;

        // Loop through the data and calculate the intensity for each point
        var intensityData = {};
        var maxIntensity = 0;
        for (var i = 0; i < heatmapData.length; i++) {
            var point = heatmapData[i];
            var timestamp = point.timestamp;
            if (!intensityData[timestamp]) {
                intensityData[timestamp] = {};
            }
            if (!intensityData[timestamp][point.imgNum]) {
                intensityData[timestamp][point.imgNum] = 0;
            }
            intensityData[timestamp][point.imgNum]++;
            if (intensityData[timestamp][point.imgNum] > maxIntensity) {
                maxIntensity = intensityData[timestamp][point.imgNum];
            }
        }

        // Draw the heatmap
        for (var i = 0; i < heatmapData.length; i++) {
            var point = heatmapData[i];
            var radius = 10;
            var timestamp = point.timestamp;
            var imgNum = point.imgNum;
            var intensity = intensityData[timestamp][imgNum] / maxIntensity;
            ctx.beginPath();
            ctx.arc(point.x, point.y, radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = gradient;
            ctx.globalAlpha = intensity;
            ctx.fill();
        }

    </script>
</body>
</html>
