<?php
	include('../../assets/php/sql_conn.php');
	
	if(isset($_GET["from_date"]) && $_GET["to_date"] != ''){
		$from_date = $_GET["from_date"];
		$to_date = $_GET["to_date"];
		$user_type = $_GET["user_type"];
		$created_by = $_GET["created_by"];
		$login_id = $_GET["login_id"];

		if($user_type == 5){
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '".$created_by."' AND cb_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ";
		}else{
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '".$login_id."' AND cb_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ";
		}
		$result = $mysqli->query($sql);

		$return_result = array();
		
		$user_CSV = array();
		$user_CSV[0] = array('Date', 'Particulars', 'Amount','Date', 'Particulars', 'Amount');
				
		try {			
			$net_pay = 0.00;
			$net_received = 0.00;
			while($row = $result->fetch_array()){
				$receive_payment = $row['receive_payment'];
				$cb_narration = $row['cb_narration'];
				$receive = '';
				$payment = '';
				$receive_dt = '';
				$payment_dt = '';
				$receive_amt = '';
				$payment_amt = '';

				if($receive_payment == 0){
					$receive = $cb_narration;
					$receive_dt = date('d-m-Y', strtotime($row['cb_date']));
					$receive_amt = $row['cb_amount'];
					$net_received = $net_received + $receive_amt;
				}else{
					$payment = $cb_narration;
					$payment_dt = date('d-m-Y', strtotime($row['cb_date']));
					$payment_amt = $row['cb_amount'];
					$net_pay = $net_pay + $payment_amt;
				}
				
				$csv_data[0] = $payment_dt;
				$csv_data[1] = $payment;
				$csv_data[2] = $payment_amt;
				$csv_data[3] = $receive_dt;
				$csv_data[4] = $receive;
				$csv_data[5] = $receive_amt;
				
				array_push($user_CSV, $csv_data);
			}
			
			$net_received1 = number_format($net_received, 2);	
			$net_pay1 = number_format($net_pay, 2);		
			$user_CSV_temp = array('', 'Total', $net_pay, '', 'Total', $net_received);			
			array_push($user_CSV, $user_CSV_temp);
			
		} catch (PDOException $e) {
			die("Error occurred:" . $e->getMessage());
		}	
		//$return_result['status'] = $status;
		
		//echo json_encode($return_result);		
		//echo json_encode($user_CSV);
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="cash_book.csv"');		

		// very simple to increment with i++ if looping through a database result 
		//$user_CSV[1] = array('Quentin', 'Del Viento', 34);
		

		$fp = fopen('php://output', 'wb');
		foreach ($user_CSV as $line) {
			// though CSV stands for "comma separated value"
			// in many countries (including France) separator is ";"
			fputcsv($fp, $line, ',');
		}
		fclose($fp);
	}//end isset
	