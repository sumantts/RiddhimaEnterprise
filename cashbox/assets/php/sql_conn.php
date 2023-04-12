<?php

	$host = 'localhost';	

	if($_SERVER['HTTP_HOST'] == 'localhost'){
		//Localhost connection
		$username = 'root';
		$password = '';
		$dbname = 'riddhi';
	}else{
		//Server connection
		$username = 'theriddhi_riddhi';
		$password = 'riddhi123!@#';
		$dbname = 'theriddhi_riddhi';
	}
	
	$sitename = 'Riddhi Enterprise';

	// $bank_name = 'SBI';
	// $branch_name = 'Anandamath, Icchapore';
	// $acc_no = '40015926141';
	// $ac_name = 'Ms Riddhima Enterprise';
	// $ifsc_code = 'SBIN0017370';
	// $branch_code = '17370';

	$stock_lower_limit = 5;
	
	$mysqli = new mysqli($host, $username, $password, $dbname);

	// Check connection
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
	}else{
		//echo "Connected Successfully";
	}
	
	$con = mysqli_connect($host, $username, $password, $dbname);
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
	}
	session_start();
	
	// $sql = "SELECT login.login_id, login.user_data, login.net_due_amount, login.zone_id, bill_details.bill_id, bill_details.customer_id, bill_details.create_date, cashbook_entry.bill_id, cashbook_entry.cb_amount, cashbook_entry.cb_date FROM login LEFT JOIN bill_details ON login.login_id = bill_details.customer_id LEFT JOIN cashbook_entry ON bill_details.bill_id = cashbook_entry.bill_id WHERE login.net_due_amount >= 0 AND login.zone_id = 2 GROUP BY login.login_id";
	// $result = $mysqli->query($sql);
	// if ($result->num_rows > 0) {
	// 	$row = $result->fetch_array();
	// 	$user_data = $row['user_data'];	
	// 	echo 'user_data:'. $user_data;
	// }




	/*
	Added the database “theriddhi_riddhi”.

	username: theriddhi_riddhi
	password: riddhi123!@#	

	You have successfully created a MySQL user named “theriddhi_riddhi”.

	User: theriddhi_riddhi
	Database: theriddhi_riddhi

	Success: You saved “theriddhi_riddhi”’s privileges on the database “theriddhi_riddhi”.

	*/
		 
?>
