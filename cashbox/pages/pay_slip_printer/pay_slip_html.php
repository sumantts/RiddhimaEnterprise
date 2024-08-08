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
			<th colspan='5' style='text-align: center;'>Riddhima Enterprise <br>
			Address: 1637,Babanpur Lock Gate. Bengal Enamel, 24 pgs(N), Pin - 743122 West Bengal, India</th>			
			<th colspan='4' style='text-align: left; padding-left: 5px;'>
			Ph. No: 7890101632<br>
			Email: rajibbiswas.bapi@gmail.com</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='6' style='text-align: left; padding-left: 5px;'>
			Emp. Name: ".$salary_detail_data->emp_name."<br>
			Emp. Ph: ".$emp_ph_primary."<br>
			Basic Pay: ".$basic_pay."<br>
			</th>
			<th colspan='6' style='text-align: left; padding-left: 5px;'>
			Pay Slip For: ".date('F-Y', strtotime($for_the_month))."<br>
			Working Days: ".$salary_detail_data->working_days."<br>
			Holi Days: ".$salary_detail_data->holi_days."<br>
			Effective Days: ".$salary_detail_data->effective_working_days."<br>
			Attendance: ".$salary_detail_data->attendance_count."<br>
			</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: center;'> Allowances </th>
			<th colspan='3' style='text-align: center;'>Amount</th>
			<th colspan='3' style='text-align: center;'> Deductions </th>
			<th colspan='3' style='text-align: center;'>Amount</th>";
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>Basic Pay</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->effectiveBasicPay, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>PF</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->deduction_1, 2)."</th>";
		$message .="</tr>";		
		$message .="</tr>";			
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>HRA</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->allounce_1, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>ESI</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->deduction_2, 2)."</th>";
		$message .="</tr>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>Medical</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->allounce_2, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>Gratuity</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->deduction_3, 2)."</th>";
		$message .="</tr>";	 	
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>Special Allowance</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->allounce_4, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>";
		$message .="</tr>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>Overtime (".$overtime_hours." hrs)</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>".number_format($salary_detail_data->overtime_amount, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>";
		$message .="</tr>";	
		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'> Total Allowance </th>
			<th colspan='3' style='text-align: right;padding-right: 5px;'>".number_format($total_allounce, 2)."</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'> Deduction Total </th>
			<th colspan='3' style='text-align: right;padding-right: 5px;'>".number_format($salary_detail_data->total_deduction, 2)."</th>";
		$message .="</tr>";
		
		$message .="<tr> <th colspan='12' style='text-align: center;'>&nbsp;</th> </tr>";
		
		$message .="<tr> <th colspan='6' style='text-align: left; padding-left: 5px;'> Net Pay: ".number_format($net_pay, 2)."/-<br> ".digitToinWordConverter($net_pay)."<br> </th> <th colspan='6' style='text-align: left; padding-left: 5px;'> Receiver Signature:<br> Date:  </th></tr>";
		
		$message .="</tbody>";
	$message .="</table>";

    $message .="</body>";
$message .="</html>";

?>