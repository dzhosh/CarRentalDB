<?php
	include("config.php");
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$EID = trim($_POST['EID']);
		$Pass = trim($_POST['Pass']);

		$result = pg_query_params($db, 'SELECT epassword,databaseaccess FROM employee WHERE employeeno=$1', array($EID));
		if(!$result || pg_num_rows($result) != 1) {
			echo "Invalid EID.";
		}
		else {
			$line = pg_fetch_array($result);
			if($Pass == $line[0]){
				$_SESSION['user'] = $EID;
				header("location: employee.php");
			}
			else {
				echo "Incorrect EID or Password.";
			}
		}
	}
?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<form action="" method="post">
		<div class="login">
			<label for="EID"><b>Employee ID</b></label>
			<input type="number" min="0" name="EID" required><br>
			<label for="Pass"><b>Password</b></label>
			<input type="password" placeholder="Password" name="Pass" required><br>
			<button type="submit">Login</button>
		</div>
	</form>
	<form action="index.php" method="">
		<button type="submit">Back to Home</button>
	</form>
</body>
</html>