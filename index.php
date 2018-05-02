<html>
<head>
	<title>Car Rental Database</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form action="login.php" method="post">
		<div class="container">
			<label for="EID"><b>Employee ID</b></label>
			<input type="number" min="0" name="EID" required><br>
			<label for="Pass"><b>Password</b></label>
			<input type="password" placeholder="Password" name="Pass" required><br>
			<button type="submit">Login</button>
		</div>
	</form>

	<h1>Car Rental</h1>

	<?php
	include("config.php");

	$query = 'SELECT * FROM model,vehicle_class,(SELECT DISTINCT model_id FROM vehicle WHERE available = True) AS avail WHERE model.class_name = vehicle_class.class_name AND model.model_id = avail.model_id';
	$result = pg_query($query);

	echo "<table>\n";
	while ($line = pg_fetch_array($result)) {
		echo "\t<tr>\n";
		echo "\t\t<td>$line[3] $line[1] $line[2]</td>\n";
		echo "\t\t<td>$line[7]</td>\n";
		echo "\t\t<td>\n";
		echo "\t\t\t<form action=\"vehicle.php\" method=\"post\">\n";
		echo "\t\t\t<input type=\"hidden\" name=\"modelID\" value=$line[0]></input>\n";
		echo "\t\t\t<button type=\"submit\">View More/Purchase</button>\n";
		echo "\t\t\t</form>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";
	?>
</body>
</html>