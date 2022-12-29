<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>Riddhima Enterprise - Tax Invoice</title>";
$message .="</head>";

//$message .="<body style='background-image: url(../../../assets/img/logo.jpg); background-repeat: no-repeat; background-attachment: fixed;  background-size: 100% 100%;'>";
$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse;font-size: 12px;width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='9' style='text-align: center;'>Riddhima Enterprise - Tax Invoice</th>";
		$message .="</tr>";
		
		
		$message .="<tr>";
			$message .="<th> Sl.No.</th>";
			$message .="<th>Bill Number</th>";
			$message .="<th colspan='2'>Customer Name</th>";
			$message .="<th>Phone Number</th>";								
			$message .="<th>Total Bill Amount</th>";							
			$message .="<th>Paid Amount</th>";								
			$message .="<th>Today's Collection</th>";								
			$message .="<th>Due Amount</th>";							
			$message .="<th>Bill Created On</th>";	
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";							
		
		$a = 0; $b = 0; $c = 0; $d = 0;
		while ($row_bill = $result_bill->fetch_array()){ 
			$i++;
			$bill_id = $row_bill['bill_id'];
			$bill_description = json_decode(base64_decode($row_bill['bill_description']));
			//$create_date = $row_bill['create_date'];

			if(isset($bill_description->create_date_new)){
				$create_date = $bill_description->create_date_new;
			}else{
				$create_date = $row_bill['create_date'];
			}

			if(strtotime($create_date) >= strtotime($from_date) && strtotime($create_date) <= strtotime($to_date)){
				$formated_bill_no = 'RE/'.date('M', strtotime($create_date)).'/'.$bill_id;

				$roundedUpFineItemsSubTotal = $bill_description->roundedUpFineItemsSubTotal;
				$totalCash = $bill_description->totalCash;
				$dueCash = $bill_description->dueCash;

				$a = $a + $roundedUpFineItemsSubTotal;
				$b = $b + $totalCash;
				$c = $c + $dueCash;

				//Get from date to to date collection only
				$sql_cb_bill = "SELECT * FROM cashbook_entry WHERE bill_id = '".$bill_id."' AND cb_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ";
				$result_cb_bill = $mysqli->query($sql_cb_bill);
				$cb_amount = 0;
				while ($row_cb_bill = $result_cb_bill->fetch_array()){ 
					$cb_amount = $cb_amount + $row_cb_bill['cb_amount'];
				}
				$d = $d + $cb_amount;


				$message .="<tr>";
					$message .="<td style='padding-left: 5px;'>".$i."</td>";
					$message .="<td>".$formated_bill_no."</td>";
					$message .="<td colspan='2'>".$bill_description->customer_name."</td>";
					$message .="<td >".$bill_description->phone_number."</td>";
					$message .="<td style='text-align: right; padding-right: 5px;'>".$roundedUpFineItemsSubTotal."</td>";
					$message .="<td style='text-align: right; padding-right: 5px;'>".$totalCash."</td>";
					$message .="<td style='text-align: right; padding-right: 5px;'>".$cb_amount."</td>";
					$message .="<td style='text-align: right; padding-right: 5px;'>".$dueCash."</td>";
					$message .="<td >".date('d-M-Y H:i', strtotime($create_date))."</td>";
				$message .="</tr>";	
			}//end if
		}						
		
		$message .="<tr>";
			$message .="<td>#</td>";
			$message .="<td colspan='4' style='text-align: center; padding-left: 5px; font-weight: bold;'>TOTAL</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$a."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$b."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$d."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$c."</td>";
			$message .="<td>&nbsp;</td>";
		$message .="</tr>";						
		/****
		$message .="<tr>";
			$message .="<td colspan='11' style='text-align: center; padding-left: 5px;'>TOTAL AMOUNT IN WORD</td>";
			$message .="<td colspan='2' style='text-align: center; padding-left: 5px;'>TOTAL AMOUNT</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->fineItemsSubTotal."</td>";
		$message .="</tr>";							
		
		$message .="<tr>";
			$message .="<td colspan='11' style='text-align: center; padding-left: 5px; text-transform: uppercase;'> ".digitToinWordConverter($bill_description->roundedUpFineItemsSubTotal)."</td>";
			$message .="<td colspan='2' style='text-align: center; padding-left: 5px;'>ROUNDED AMOUNT</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->roundedUpFineItemsSubTotal."</td>";
		$message .="</tr>";	
		****/

		$message .="</tbody>";
	$message .="</table>";

	/***
	$message .="<table  style='border-collapse:collapse; width: 100%;border: none;'>";
		$message .="<tbody>";
			$message .="<tr>";
				$message .="<td colspan='10' style='text-align: center;'>&nbsp;</td>";
				$message .="<td colspan='4' style='text-align: center;' > Authorize Signature </td>";
			$message .="</tr>";
		$message .="</tbody>";
	$message .="</table>";
****/
    $message .="</body>";
$message .="</html>";

?>