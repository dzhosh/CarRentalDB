<?php
	include("config.php");
	session_start();

	$errorMessage = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if($_POST['action'] == "processRent"){
			$fname = trim($_POST['FirstName']);
			$lname = trim($_POST['LastName']);
			$ssn = trim($_POST['SSN']);
			$addr = trim($_POST['Addr1']);
			$zip = trim($_POST['Zip']);
			$license = trim($_POST['License']);
			$bdate = trim($_POST['Birthday']);
			$return = trim($_POST['Return']);
			$eid = trim($_POST['EID']);
			$plate = trim($_POST['LicensePlate']);
			$location = 1;

			$result = pg_query_params($db, 'SELECT * FROM customer WHERE ssn=$1', array($ssn));
			if(!$result || pg_num_rows($result) != 1) {
				$stmt = $dbh->prepare("INSERT INTO customer(ssn, first_name, last_name, street, zip_code, license, birthdate) VALUES(:ssn, :fname, :lname, :addr, :zip, :license, :bdate)");
				$stmt->bindParam(':ssn', $ssn);
				$stmt->bindParam(':fname', $fname);
				$stmt->bindParam(':lname', $lname);
				$stmt->bindParam(':addr', $addr);
				$stmt->bindParam(':zip', $zip);
				$stmt->bindParam(':fname', $fname);
				$stmt->bindParam(':license', $license);
				$stmt->bindParam(':bdate', $bdate);
				$stmtResult = $stmt->execute();
				$errorMessage = "Invalid data submitted for customer information.\n";
			}
			if ($stmtResult != false){
				$meta = pg_fetch_array(pg_query('SELECT * FROM meta'));
				$rental = $meta[1]+1;
				$stmt = $dbh->prepare("INSERT INTO rental(rental_id, return_date, customer_ssn, vehicle_license_plate, processing_emp, rental_location_id) VALUES(:rental, :return, :ssn, :plate, :eid, :location)");
				$stmt->bindParam(':rental', $rental);
				$stmt->bindParam(':return', $return);
				$stmt->bindParam(':ssn', $ssn);
				$stmt->bindParam(':plate', $plate);
				$stmt->bindParam(':eid', $eid);
				$stmt->bindParam(':location', $location);
				$stmtResult = $stmt->execute();
				$errorMessage = "Invalid return date.\n";
				if(!$stmtResult){
					pg_query('UPDATE meta SET rental_no = rental_no + 1');
					$stmtResult = pg_query_params($db, 'UPDATE vehicle SET available = false WHERE license_plate = $1', array($plate));
				}
			}
		}
		else if ($_POST['action'] == "processReturn"){
			$plate = trim($_POST['LicensePlate']);
			$result = pg_query_params($db, 'SELECT * FROM vehicle WHERE license_plate = $1', array($plate));
			if (pg_num_rows($result) < 1){
				$stmtResult = false;
			}
			else {
				pg_query_params($db, 'UPDATE vehicle SET available = true WHERE license_plate = $1', array($plate));
				$stmtResult = true;
			}
			$errorMessage = "License Plate $plate was not found.\n";
		}
		else if ($_POST['action'] == "addEmp"){
			$fname = trim($_POST['FirstName']);
			$lname = trim($_POST['LastName']);
			$ssn = trim($_POST['SSN']);
			$phone = trim($_POST['Phone']);
			$salary = trim($_POST['Salary']);
			$location = trim($_POST['Location']);
			$dbAccess = trim($_POST['DBAccess']);
			$password = trim($_POST['Pass']);

			$meta = pg_fetch_array(pg_query('SELECT * FROM meta'));
			$eid = $meta[2]+1;

			$stmt = $dbh->prepare("INSERT INTO employee(employeeno, essn, salary, first_name, last_name, phone, location_id, databaseaccess, epassword) VALUES(:eid, :ssn, :salary, :fname, :lname, :phone, :location, :dbAccess, :password)");
			$stmt->bindParam(':eid', $eid);
			$stmt->bindParam(':ssn', $ssn);
			$stmt->bindParam(':salary', $salary);
			$stmt->bindParam(':fname', $fname);
			$stmt->bindParam(':lname', $lname);
			$stmt->bindParam(':phone', $phone);
			$stmt->bindParam(':location', $location);
			$stmt->bindParam(':dbAccess', $dbAccess);
			$stmt->bindParam(':password', $password);
			$stmtResult = $stmt->execute();
			$errorMessage = "Invalid data submitted for employee information.\n";

			if($stmtResult != false){
				pg_query('UPDATE meta SET employee_no = employee_no + 1');
			}
		}
		else if ($_POST['action'] == "remEmp"){
			$eid = trim($_POST['EID']);
			$result = pg_query_params($db, 'SELECT * FROM employee WHERE employeeno = $1', array($eid));
			if (pg_num_rows($result) < 1){
				$stmtResult = false;
			}
			else {
				pg_query_params($db, 'DELETE FROM employee WHERE employeeno = $1', array($eid));
				$stmtResult = true;
			}
			$errorMessage = "Employee ID $eid not found.\n";
		}
		else if ($_POST['action'] == "addVeh"){
			$plate = trim($_POST['LicensePlate']);
			$mile = trim($_POST['Mileage']);
			$color = trim($_POST['Color']);
			$modelName = trim($_POST['ModelName']);
			$manufacturer = trim($_POST['Manufacturer']);
			$year = trim($_POST['Year']);
			$seats = trim($_POST['Seats']);
			$doors = trim($_POST['Doors']);
			$className = trim($_POST['ClassName']);
			$location = trim($_POST['Location']);
			$available = true;

			$stmt = $dbh->prepare("SELECT model_id FROM model WHERE model_id = :modelName AND manufacturer = :manufacturer AND year = :year");
			$stmt->bindParam(':modelName', $modelName);
			$stmt->bindParam(':manufacturer', $manufacturer);
			$stmt->bindParam(':year', $year);
			$stmtResult = $stmt->execute();
			$rows = $stmt->rowCount();
			if($rows == 0){
				$meta = pg_fetch_array(pg_query('SELECT * FROM meta'));
				$model = $meta[4]+1;

				$stmt2 = $dbh->prepare("INSERT INTO model(model_id, manufacturer, model_name, year, seats, doors, class_name) VALUES(:model, :manufacturer, :modelName, :year, :seats, :doors, :className)");
				$stmt2->bindParam(':model', $model);
				$stmt2->bindParam(':manufacturer', $manufacturer);
				$stmt2->bindParam(':modelName', $modelName);
				$stmt2->bindParam(':year', $year);
				$stmt2->bindParam(':seats', $seats);
				$stmt2->bindParam(':doors', $doors);
				$stmt2->bindParam(':className', $className);
				$stmtResult = $stmt2->execute();
			}
			if ($stmtResult == false){
				$errorMessage = "Invalid data in model information [Model, Manufacturer, Year].\n";
			}
			else {
				pg_query('UPDATE meta SET model_no = model_no + 1');

				$stmt3 = $dbh->prepare("INSERT INTO vehicle(license_plate, mileage, color, model_id, location_id, available) VALUES(:plate, :mileage, :color, :model, :location, :available)");
				$stmt3->bindParam(':plate', $plate);
				$stmt3->bindParam(':mileage', $mile);
				$stmt3->bindParam(':color', $color);
				$stmt3->bindParam(':model', $model);
				$stmt3->bindParam(':location', $location);
				$stmt3->bindParam(':available', $available);
				$stmtResult = $stmt3->execute();

				if ($stmtResult == false){
					$errorMessage = "Invalid License Plate.\n";
				}
				else {
					pg_query('UPDATE meta SET car_no = car_no + 1');
				}
			}
		}
		else if ($_POST['action'] == "remVeh"){
			$plate = trim($_POST['LicensePlate']);
			$result = pg_query_params($db, 'SELECT * FROM vehicle WHERE license_plate = $1', array($plate));
			if (pg_num_rows($result) < 1){
				$stmtResult = false;
			}
			else {
				pg_query_params($db, 'DELETE FROM vehicle WHERE license_plate = $1', array($plate));
				$stmtResult = true;
			}
			$errorMessage = "Vehicle with license plate $plate not found.\n";
		}
		else if ($_POST['action'] == "updateDB"){
			$query = trim($_POST['SQL']);
			$result = pg_query($query);

			if ($result == false){
				$stmtResult = false;
				$errorMessage = "Error in SQL statement.";
			}
			else {
				$stmtResult = true;
			}
		}
	}
	else {
		$errorMessage = "Unknown action.\n";
	}
?>
<html>
<head>
	<title>Processing</title>
</head>
<body>
	<?php
		if ($stmtResult == false){
			echo "Error performing operation.<br>\n";
			echo "$errorMessage";
		}
		else {
			echo "Successfully performed operation.\n";
		}
		echo "<form action=\"employee.php\" method=\"\">\n";
		echo "\t<button type=\"submit\">Back to Home</button>\n";
		echo "</form>\n";
	?>
</body>
</html>