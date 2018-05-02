<?php
	include("config.php");
?>

<html>
<head>
	<title>Car Rental Database</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Car Rental</h1>

	<?php
		$MID = $_POST['modelID'];
		$result = pg_query_params($db, 'SELECT * FROM model,vehicle,vehicle_class WHERE model.model_ID = $1 AND vehicle.model_ID = model.model_ID AND model.class_name = vehicle_class.class_name AND vehicle.available = True', array($MID));

		$line = pg_fetch_array($result);

		echo "<h2>$line[3] $line[1] $line[2]</h2>\n\n";

		echo "<table>\n";
		do {
			echo "\t<tr>\n";
			echo "\t\t<td>Color: $line[9]</td>\n";
			echo "\t\t<td>Seats: $line[4]</td>\n";
			echo "\t\t<td>Doors: $line[5]</td>\n";
			echo "\t\t<td>Price Per Day: $line[14]</td>\n";
			echo "\t\t<td><form action=\"customerRent.php\" method=\"post\">\n";
			echo "\t\t<input type=\"hidden\" name=\"vehicleID\" value=$line[7]></input>\n";
			echo "\t\t<button type=\"submit\">Rent</button>\n";
			echo "\t\t</form></td>\n";
			echo "\t</tr>\n";
		} while($line = pg_fetch_array($result));
		echo "</table>\n";
	?>

	<h2><a href = "index.php">Back to Car Selection</a></h2>
</body>
</html>