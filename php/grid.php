<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Grid Example</title>
	<style>
		body {
			margin: 0;
			padding: 0;
		}
		.cell {
			width: 20px;
			height: 20px;
			float: left;
			box-sizing: border-box;
			border: 1px solid #000;
			background-color: #fff;
		}
	</style>
</head>
<body>
	<div style="width: 800px; height:600px;">
		<?php
			$rows = ceil(($_SERVER['HTTP_REFERER'] ?? 600) / 20);
			$cols = ceil(($_SERVER['HTTP_REFERER'] ?? 800) / 20);
			for ($i=0; $i<$rows*$cols; $i++) {
				echo "<div class='cell'></div>";
			}
		?>
	</div>
	
</body>
</html>
