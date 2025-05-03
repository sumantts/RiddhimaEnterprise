<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>Riddhima Enterprise - PaySlip</title>";
$message .="</head>";

$message .="<body class='watermark'>";
$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse; font-size: 14px; width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='3'><img src='../../../assets/img/riddhima_logo32.png'></th>
			<th colspan='2' style='text-align: center;'>Riddhima Enterprise <br>
			Address: 1637,Babanpur Lock Gate. Bengal Enamel, 24 pgs(N), Pin - 743122 West Bengal, India</th>			
			<th colspan='3' style='text-align: left; padding-left: 5px;'>
			Ph. No: 7890101632<br>
			Email: rajibbiswas.bapi@gmail.com</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='4' style='text-align: left; padding-left: 5px;'>
			Emp. Name: ".$salary_detail_data->emp_name."<br>
			Emp. Ph: ".$emp_ph_primary."<br>
			Basic Pay: ".$basic_pay."<br>
			</th>
			<th colspan='4' style='text-align: left; padding-left: 5px;'>
			Pay Slip For: ".date('F-Y', strtotime($for_the_month))."<br>
			Working Days: ".$salary_detail_data->working_days."<br>
			Holi Days: ".$salary_detail_data->holi_days."<br>
			Effective Days: ".$salary_detail_data->effective_working_days."<br>
			Attendance: ".$salary_detail_data->attendance_count."<br>
			</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th style='text-align: center;'> SL# </th>
			<th style='text-align: center;'> Date </th>
			<th style='text-align: center;'>Attendance</th>
			<th style='text-align: center;'>Half Day</th>
			<th style='text-align: center;'>Full Day</th>
			<th style='text-align: center;'>Late Hour</th>
			<th style='text-align: center;'>Overtime Hour</th>
			<th style='text-align: center;'>Note</th>";
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";	

		$sql = "SELECT * FROM employee_attendance WHERE emp_id = '".$emp_id."' AND present_date >= '".$first_day."' AND present_date <= '".$last_day."' ORDER BY present_date ASC";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$sl = 1;
			while($row = $result->fetch_array()){
				$present_date = date('d-F-Y', strtotime($row['present_date']));		
				$present_status	 = ($row['present_status'] == 1)? 'Yes' : '';		
				$half_day_status = ($row['half_day'] == 1)? 'Yes' : '';			
				$full_day_status = ($row['full_day'] == 1)? 'Yes' : ''; 		
				$late_hours = ($row['late_hours'] > 0)? $row['late_hours'].' hr' : '';	
				$overtime_hours = ($row['overtime_hours'] > 0)? $row['overtime_hours'].' hr' : '';		
				$attendance_note = $row['attendance_note'];
				$present_date_raw = $row['present_date'];

				$sql1 = "SELECT * FROM holiday_list WHERE holiday_date = '".$present_date_raw."'";
				$result1 = $mysqli->query($sql1);

				if ($result1->num_rows > 0) { 
					$row1 = $result1->fetch_array();		
					$present_status = $row1['holiday_title'];	
					$half_day_status = $row1['holiday_title'];	
					$full_day_status = $row1['holiday_title'];	
					$late_hours = $row1['holiday_title'];	
					$overtime_hours = $row1['holiday_title'];	
					$attendance_note = $row1['holiday_title'];
				}
			
				$message .="<tr>";
					$message .="<th style='text-align: center;'>$sl</th>
					<th style='text-align: center;'>$present_date</th>
					<th style='text-align: center;'>$present_status</th>
					<th style='text-align: center;'>$half_day_status</th>
					<th style='text-align: center;'>$full_day_status</th>
					<th style='text-align: center;'>$late_hours</th>
					<th style='text-align: center;'>$overtime_hours</th>
					<th style='text-align: center;'>$attendance_note</th>";
				$message .="</tr>";		

				$sl++;
			}
		}else{
			$message .="<tr>";
				$message .="<th style='text-align: left; padding-left: 5px;' colspan='8'>Sorry! No record found</th>";
			$message .="</tr>";
		}	
		
		$message .="</tbody>";
	$message .="</table>";

    $message .="</body>";
$message .="</html>";

?>