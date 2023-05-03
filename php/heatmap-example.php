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
<html>
<head>
    <meta charset="UTF-8">
    <title>Minimal Heatmap Example</title>
    <style>
      #heatmapCanvas {
        image-rendering: pixelated;
        background-color: lightgray;
      }
    </style>
</head>
<body>
    <canvas id="heatmapCanvas"></canvas>

    <script>
        var canvas = document.getElementById('heatmapCanvas');
        ctx = canvas.getContext('2d');

        canvas.width = 800;
        canvas.height = 600;

        // Define the size of each grid cell
        var cellSize = 20;

        // Calculate the number of rows and columns in the grid
        var numRows = Math.ceil(canvas.height / cellSize);
        var numCols = Math.ceil(canvas.width / cellSize);

        console.log(numRows);
        console.log(numCols);

        // Create an array to store the grid data
        var grid = new Array(numRows);
        for (var i = 0; i < numRows; i++) {
            grid[i] = new Array(numCols);
        }

        // Initialize the grid with zeros
        for (var i = 0; i < numRows; i++) {
            for (var j = 0; j < numCols; j++) {
                grid[i][j] = 0;
            }
        }

        console.log(grid);
        var points = <?php echo $heatmapDataJson; ?>;

        

        // Loop through each data point and add its intensity to the corresponding cell in the grid
        points.forEach(function(point) {
        var row = Math.floor(point.y / cellSize);
        var col = Math.floor(point.x / cellSize);
        grid[row][col] += point.value;
        });

        // Create a color gradient for the heatmap
        var gradient = {
        0.4: 'blue',
        0.6: 'cyan',
        0.7: 'lime',
        0.8: 'yellow',
        1.0: 'red'
        };

        // Create an array to store the pixel data for the heatmap
        var imageData = ctx.createImageData(canvas.width, canvas.height);
        var data = imageData.data;

        // Loop through each pixel on the canvas and set its color based on the intensity of the corresponding cell in the grid
        for (var x = 0; x < canvas.width; x++) {
        for (var y = 0; y < canvas.height; y++) {
            var row = Math.floor(y / cellSize);
            var col = Math.floor(x / cellSize);
            var intensity = grid[row][col];

            // Calculate the color of the pixel based on the intensity
            var color = interpolateColor(gradient, intensity / max);

            // Set the color of the pixel in the imageData array
            var index = (y * canvas.width + x) * 4;
            data[index + 0] = color[0];
            data[index + 1] = color[1];
            data[index + 2] = color[2];
            data[index + 3] = 255;
        }
        }

        // Set the imageData array as the pixel data for the canvas
        ctx.putImageData(imageData, 0, 0);

        // A helper function to interpolate a color from a color gradient
        function interpolateColor(gradient, value) {
        var keys = Object.keys(gradient);
        var index = 0;

        while (value > keys[index]) {
            index++;
        }

        var key1 = keys[index - 1];
        var key2 = keys[index];
        var color1 = hexToRgb(gradient[key1]);
        var color2 = hexToRgb(gradient[key2]);
        var ratio = (value - key1) / (key2 - key1);

        return [    Math.round((color2[0] - color1[0]) * ratio + color1[0]),
            Math.round((color2[1] - color1[1]) * ratio + color1[1]),
            Math.round((color2[2] - color1[2]) * ratio + color1[2])
        ];
        }

        // A helper function to convert a hex color string to an RGB array
        function hexToRgb(hex) {
        var r = parseInt(hex.substring(1, 3), 16);
        var g = parseInt(hex.substring(3, 5), 16);
        var b = parseInt(hex.substring(5, 7), 16);
        return [r, g, b];
        }

    </script>
</body>
</html>

