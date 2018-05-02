<?php
	include("session.php");

	$result = pg_query_params($db,'SELECT * FROM employee WHERE employeeno = $1',array($user[0]));
	$managerLine = pg_fetch_array($result);
?>

<html>
<head>
	<title>Add Employee</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Add Employee</h1>
	<div class="rental">
		<form action="processAction.php" method="post">
			<label for="FirstName"><b>First Name</b></label>
			<input type="text" placeholder="First Name" name="FirstName" required><br>
			<label for="LastName"><b>Last Name</b></label>
			<input type="text" placeholder="Last Name" name="LastName" required><br>
			<label for="SSN"><b>SSN</b></label>
			<input type="password" placeholder="XXXXXXXXX" name="SSN" required><br>
			<label for="Phone"><b>Phone Number</b></label>
			<input type="text" placeholder="XXXXXXXXXX" name="Phone" required><br>
			<label for="Salary"><b>Salary</b></label>
			<input type="number" min="12000" name="Salary" required><br>
			<label for="Pass"><b>Password</b></label>
			<input type="password" placeholder="Enter Password" name="Pass" required><br>
			<label for="DBAccess"><b>Database Access</b></label>
			<input type="number" min="1" max="3" name="DBAccess" required><br>
			<input type="hidden" name="Location" value=<?php echo "\"$managerLine[6]\"";?>>
			<input type="hidden" name="action" value="addEmp">
			<button type="submit">Add Employee</button>
		</form>
	</div>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>

</body>
</html>