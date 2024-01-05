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
			Emp. Name: <br>
			Emp. Ph: <br>
			Emp. Designation.
			</th>
			<th colspan='6' style='text-align: left; padding-left: 5px;'>
			Pay Slip For: January 2024<br>
			Total Days: 30<br>
			Effective Days: 30<br>
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
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'> Basic </th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>0.00</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'> Professional Tax </th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>0.00</th>";
		$message .="</tr>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>";
		$message .="</tr>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>";
		$message .="</tr>";		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'>&nbsp;</th>
			<th colspan='3' style='text-align: right; padding-right: 5px;'>&nbsp;</th>";
		$message .="</tr>";	
		
		$message .="<tr>";
			$message .="<th colspan='3' style='text-align: left; padding-left: 5px;'> Gross Total </th>
			<th colspan='3' style='text-align: right;padding-right: 5px;'>00.00</th>
			<th colspan='3' style='text-align: left; padding-left: 5px;'> Deduction Total </th>
			<th colspan='3' style='text-align: right;padding-right: 5px;'>00.00</th>";
		$message .="</tr>";
		
		$message .="<tr> <th colspan='12' style='text-align: center;'>&nbsp;</th> </tr>";
		
		$message .="<tr> <th colspan='12' style='text-align: left; padding-left: 5px;'>
		3 Days Extra Work<br>
		Net Pay: 0.00<br>
		Net pay in word<br>
		</th> </tr>";
		
		$message .="</tbody>";
	$message .="</table>";

    $message .="</body>";
$message .="</html>";

?>