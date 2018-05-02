<html>
<head>
	<title>Remove Vehicle</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<h1>Remove Vehicle</h1>
	<form action="processAction.php" method="post">
		<div class="form">
			<label for="LicensePlate"><b>License Plate</b></label>
			<input type="text" min="0" name="LicensePlate" required>
			<input type="hidden" name="action" value="remVeh">
			<button type="submit">Submit</button>
		</div>
	</form>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>
</body>
</html>