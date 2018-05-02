<?php
	include("session.php");

	$query = 'SELECT * FROM model,vehicle_class,(SELECT * FROM vehicle WHERE available = True) AS avail WHERE model.class_name = vehicle_class.class_name AND model.model_id = avail.model_id';
	$result = pg_query($query);
	if(!$result || pg_num_rows($result) < 1){
		echo "There are no cars to rent.";
	}
?>

<html>
<head>
	<title>Rent</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Rent Car</h1>
	<div class="rental">
		<form action="processAction.php" method="post">
			<h3>Customer Info</h3>
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
			<h3>Rental Info</h3>
			<label for="Return"><b>Return Date</b></label>
			<input type="date" name="Return" required><br>
			<input type="hidden" name="EID" value=<?php echo "\"$user[0]\"";?>>
			<input type="hidden" name="action" value="processRent">
			<select name="LicensePlate">
			<?php
			while($line = pg_fetch_array($result)){
				echo "<option value=\"$line[9]\">$line[3] $line[1] $line[2]: $line[9]</option><br>";
			}
			?>
			</select>
			<button type="submit">Rent</button>
		</form>
	</div>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>

</body>
</html>