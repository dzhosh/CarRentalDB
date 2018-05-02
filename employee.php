<?php
	include("session.php");
?>

<html>
<head>
	<title>Access</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Employee Access</h1>

	<?php
		if($user[1]==0){
			echo "You have no database access privileges.";
		}
		else {
			if ($user[1]>=1){
				echo "\t\t<a href=rent.php>Process Rental</a><br>\n";
				echo "\t\t<a href=return.php>Process Return</a><br>\n";
			}
			if ($user[1]>=2){
				echo "\t\t<a href=addEmp.php>Add Employee</a><br>\n";
				echo "\t\t<a href=remEmp.php>Remove Employee</a><br>\n";
				echo "\t\t<a href=addVeh.php>Add Vehicle</a><br>\n";
				echo "\t\t<a href=remVeh.php>Remove Vehicle</a><br>\n";
			}
			if ($user[1]>=3){
				echo "\t\t<a href=updateDB.php>Update Database</a><br>\n";
			}
		}
	?>

	<h2><a href="logout.php">Log Out</a></h2>
</body>
</html>