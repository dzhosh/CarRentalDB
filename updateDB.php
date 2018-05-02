<html>
<head>
	<title>Update Database</title>
</head>

<body>
	<h1>Update Database</h1>
	Insert SQL statement to be executed. 
	<!-- Only implemented for ease of SQL queries through browser
	while testing. This is obviously a security flaw. -->
	<form action="processAction.php" method="post">
		<div class="container">
			<label for="SQL"><b>SQL Query</b></label>
			<input type="text" name="SQL" required>
			<input type="hidden" name="action" value="updateDB">
			<button type="submit">Submit</button>
		</div>
	</form>
	<form action="employee.php" method="">
		<button type="submit">Back to Employee Home</button>
	</form>
</body>
</html>