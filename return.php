<html>
<head>
	<title>Return</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<h1>Return</h1>
	<form action="processAction.php" method="post">
		<div class="form">
			<label for="LicensePlate"><b>License Plate</b></label>
			<input type="text" name="LicensePlate" required>
			<input type="hidden" name="action" value="processReturn">
			<button type="submit">Submit</button>
		</div>
	</form>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>
</body>
</html>