<?php
	$host = "host=127.0.0.1";
	$port = "port=5432";
	$dbname = "dbname=carrentaldb";
	$credentials = "user=postgres password=mypass";

	$db = pg_connect("$host $port $dbname $credentials");

	if(!$db){
		echo "Error Connecting to Database.\n";
	}

	try{
		$dbh = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=carrentaldb;user=postgres;password=mypass");
		if (!$dbh) {
			echo "Error Connecting to Database.";
		}
	}
	catch (PDOException $e){
		echo $e->getMessage();
	}
?>