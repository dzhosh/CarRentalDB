<?php
	include("config.php");
	session_start();

	$userID = $_SESSION['user'];

	$result = pg_query_params($db, 'SELECT employeeno,databaseaccess FROM employee WHERE employeeno=$1', array($userID));
	$user = pg_fetch_array($result);

	if(!isset($_SESSION['user'])){
		header("location:index.php");
	}
?>