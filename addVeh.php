<?php
	include("session.php");

	$result = pg_query_params($db,'SELECT * FROM employee WHERE employeeno = $1',array($user[0]));
	$managerLine = pg_fetch_array($result);
?>

<html>
<head>
	<title>Add Vehicle</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Add Vehicle</h1>
	<div class="rental">
		<form action="processAction.php" method="post">
			<label for="LicensePlate"><b>License Plate</b></label>
			<input type="text" placeholder="License Plate" name="LicensePlate" required><br>
			<label for="Year"><b>Year</b></label>
			<input type="number" placeholder="Year" name="Year" required><br>
			<label for="Manufacturer"><b>Manufacturer</b></label>
			<input type="text" placeholder="Manufacturer" name="Manufacturer" required><br>
			<label for="ModelName"><b>Model Name</b></label>
			<input type="text" placeholder="Model Name" name="ModelName" required><br>
			<label for="Mileage"><b>Mileage</b></label>
			<input type="number" min="0" name="Mileage" required><br>
			<label for="Color"><b>Color</b></label>
			<input type="text" placeholder="Color" name="Color" required><br>
			<label for="Seats"><b>Seats</b></label>
			<input type="number" min="1" max="8" name="Seats" required><br>
			<label for="Doors"><b>Doors</b></label>
			<input type="number" min="1" max="4" name="Doors" required><br>
			<select name="ClassName">
				<option value="Economy">Economy</option><br>
				<option value="Standard">Standard</option><br>
				<option value="Compact">Compact</option><br>
				<option value="Luxury">Luxury</option><br>
			</select>
			<input type="hidden" name="Location" value=<?php echo "\"$managerLine[6]\"";?>>
			<input type="hidden" name="action" value="addVeh">
			<button type="submit">Add Vehicle</button>
		</form>
	</div>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>

</body>
</html>