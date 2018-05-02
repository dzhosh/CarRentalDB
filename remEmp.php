<html>
<head>
	<title>Remove Employee</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<h1>Remove Employee</h1>
	<form action="processAction.php" method="post">
		<div class="form">
			<label for="EID"><b>Employee ID</b></label>
			<input type="number" min="0" name="EID" required>
			<input type="hidden" name="action" value="remEmp">
			<button type="submit">Submit</button>
		</div>
	</form>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>
</body>
</html>