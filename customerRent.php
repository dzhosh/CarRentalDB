<?php
	include("config.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$VID = $_POST['vehicleID'];

		$result = pg_query_params($db, 'SELECT year,manufacturer,model_name FROM model,vehicle WHERE vehicle.model_id = model.model_id AND license_plate=$1', array($VID));
		$line = pg_fetch_array($result);
		$car = "$line[0] $line[1] $line[2]";
	}
?>

<html>
<head>
	<title>Rent</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Rent Car:</h1>
	<div class="rental">
		<h3><?php echo "$car"; ?></h3>
		<form action="processAction.php" method="post">
			<label for="FirstName"><b>First Name</b></label>
			<input type="text" placeholder="First Name" name="FirstName" required><br>
			<label for="LastName"><b>Last Name</b></label>
			<input type="text" placeholder="Last Name" name="LastName" required><br>
			<label for="SSN"><b>SSN</b></label>
			<input type="password" placeholder="XXXXXXXXX" name="SSN" required><br>
			<label for="Addr1"><b>Street Address</b></label>
			<input type="text" placeholder="Address1" name="Addr1" required><br>
			<label for="Zip"><b>Zip Code</b></label>
			<input type="text" placeholder="XXXXX" name="Zip" required><br>
			<label for="License"><b>License No</b></label>
			<input type="text" placeholder="XXXXXXXXXX" name="License" required><br>
			<label for="Birthday"><b>Date of Birth</b></label>
			<input type="date" name="Birthday" required><br><br>

			<label for="Return"><b>Return Date</b></label>
			<input type="date" name="Return" required><br>
			<input type="hidden" name="EID" value="0">
			<input type="hidden" name="action" value="processRent">
			<input type="hidden" name="LicensePlate" value=<?php echo "\"$VID\"";?>><br>
			<button type="submit">Rent</button>
		</form>
		<form action="index.php" method="">
			<button type="submit">Back to Home</button>
		</form>

	</div>
</body>
</html>