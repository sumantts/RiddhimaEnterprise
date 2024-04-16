<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>Riddhima Enterprise - Tax Invoice</title>";
$message .="</head>";

$message .="<body class='watermark'>";
$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse; font-size: 14px; width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='16' style='text-align: center;'>Riddhima Enterprise - Tax Invoice</th>";
		$message .="</tr>";
		
		// $message .="<tr>";
		// 	$message .="<th colspan='7' style='text-align: center;'>1637,Babanpur lock gate Bengal Enamel, 24 pgs(N) 743122 			West Bengal, India</th><th colspan='3' style='text-align: center;'>GSTIN NO</th><th colspan='4' style='text-align: center;'>19AJOP3803P1Z8</th>";
		// $message .="</tr>";
		
		// $message .="<tr>";
		// 	$message .="<th colspan='14' style='text-align: center;'>Tax Invoice</th>";
		// $message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='4'><img src='../../../assets/img/riddhima_logo32.png'></th>
			<th colspan='6' style='text-align: center; width: 50%;'>
			BILL NO: ".strtoupper($formated_bill_no)."</br> 
			SHIP TO </br> 
			Shop: ".$customer_name."</br> 
			Address: ".$customer_address."</th>
			
			<th colspan='6' style='text-align: center;'>
			STATE CODE: 19 | DATE: ".date('d-M-Y', strtotime($create_date))."</br> 
			BILL FROM </br> 
			".$bill_description->createdBy->org_name."</br> 
			Address: ".$bill_description->createdBy->address."</th>";
		$message .="</tr>";
		
		// $message .="<tr>";
		// 	$message .="<th colspan='8' style='text-align: center;'> SHIP TO </th><th colspan='8' style='text-align: center;'> BILL FROM </th>";
		// $message .="</tr>";
		
		// $message .="<tr>";
		// 	$message .="<th colspan='8' style='text-align: center;'>Shop: ".$customer_name."</th><th colspan='8' style='text-align: center;'> ".$bill_description->createdBy->org_name." </th>";
		// $message .="</tr>";
		
		// $message .="<tr>";
		// 	$message .="<th colspan='8' style='text-align: center;'>Address: ".$customer_address."</th><th colspan='8' style='text-align: center;'>Address: ".$bill_description->createdBy->address." </th>";
		// $message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='4' style='text-align: center;'> Contact No: </th><th colspan='4' style='text-align: center;'> ".$phone_number." </th><th colspan='4' style='text-align: center;'> Contact No: </th><th colspan='4' style='text-align: center;'> ".$bill_description->createdBy->contact_no." </th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='4' style='text-align: center;'> GSTIN No: </th><th colspan='4' style='text-align: center;'> ".$customer_gstin_no." </th><th colspan='4' style='text-align: center;'> GSTIN No: </th><th colspan='4' style='text-align: center;'> ".$bill_description->createdBy->gstin_no." </th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='4' style='text-align: center;'> Email Id: </th><th colspan='4' style='text-align: center;'> ".$customer_email." </th><th colspan='4' style='text-align: center;'> Email Id: </th><th colspan='4' style='text-align: center;'> ".$bill_description->createdBy->email." </th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th> Sl.No.</th>";
			$message .="<th colspan='2'>Products</th>";
			$message .="<th>HS Code</th>";
			$message .="<th>Qty.</th>";								
			//$message .="<th> Wt.(gm)</th>";							
			$message .="<th> Rate</th>";							
			$message .="<th>Amount</th>";							
			$message .="<th>Tax value</th>";							
			$message .="<th>CGST Rate</th>";							
			$message .="<th>CGST Amount</th>";							
			$message .="<th>SGST Rate</th>";						
			$message .="<th>SGST Amount</th>";						
			$message .="<th>Net Weight</th>";						
			$message .="<th>Net Value</th>";
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";							
		
		$fineItems = $bill_description->fineItems;
		$netWeight = 0;
		for($i = 0; $i < sizeof($fineItems); $i++){
			$netWeight += $fineItems[$i]->net_weight_total;

			$message .="<tr>";
				$message .="<td style='padding-left: 5px;'>".$fineItems[$i]->slno."</td>";
				$message .="<td colspan='2' style='text-align: left; padding-left: 5px; font-weight: bold;'>".$fineItems[$i]->products."</td>";
				$message .="<td style='text-align: left; padding-left: 5px;'>".$fineItems[$i]->hs_code."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->qty."</td>";
				//$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->net_weight."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->rate."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->amount."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->tax_value."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->cgst_rate."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->cgst_amount."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->sgst_rate."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$fineItems[$i]->sgst_amount."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$fineItems[$i]->net_weight_total."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$fineItems[$i]->net_value."</td>";
			$message .="</tr>";	
		}			
		
		if($netWeight > 999){			
			$netWeightTxt = $netWeight / 1000 ." kg";
		}else{
			$netWeightTxt = $netWeight." gm";
		}
		
		$message .="<tr>";
			$message .="<td colspan='3' style='text-align: center; padding-left: 5px; font-weight: bold;'>TOTAL</td>";
			$message .="<td>&nbsp;</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->subTotalQty."</td>";
			//$message .="<td>&nbsp;</td>";
			$message .="<td>&nbsp;</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->subTotalAmount."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->subTotalTaxValue."</td>";
			$message .="<td>&nbsp;</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->subTotalCgst."</td>";
			$message .="<td>&nbsp;</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->subTotalSgst."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$netWeightTxt."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->fineItemsSubTotal."</td>";
		$message .="</tr>";						
		
		$discount_text = '';
		if($bill_description->discountType == 1){
			$discount_text = 'Fixed';
		}else if($bill_description->discountType == 2){
			$discount_text = 'Percentage ('.$bill_description->discountRate.'%)';
		}else{}

		$message .="<tr>";
			$message .="<td colspan='6' style='text-align: center; padding-left: 5px;'>TOTAL AMOUNT IN WORD</td>";
			$message .="<td style='text-align: center; padding-left: 5px;'>PAID AMOUNT</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->totalCash."</td>";
			$message .="<td style='text-align: center; padding-left: 5px;'>DISCOUNT ".$discount_text."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->discountAmount."</td>";
			$message .="<td colspan='3' style='text-align: center; padding-left: 5px;'>TOTAL AMOUNT</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->fineItemsSubTotal."</td>";
		$message .="</tr>";							
		
		$message .="<tr>";
			$message .="<td colspan='6' style='text-align: center; padding-left: 5px; text-transform: uppercase;'> ".digitToinWordConverter($bill_description->roundedUpFineItemsSubTotal)."</td>";
			$message .="<td colspan='3' style='text-align: center; padding-left: 5px;'>DUE AMOUNT</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->dueCash."</td>";
			$message .="<td colspan='3' style='text-align: center; padding-left: 5px;'>ROUNDED</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$bill_description->roundedUpFineItemsSubTotal."</td>";
		$message .="</tr>";	
		

		$message .="</tbody>";
	$message .="</table>";

	$message .="<table  style='border-collapse:collapse;font-size: 12px; width: 100%;border: none;'>";
		$message .="<tbody>";
			$message .="<tr>";
				$message .="<td colspan='10' style='text-align: center;'> Bank Details:</br>
				Bank Name: ".$bank_name.", Branch: ".$branch_name."</br>
				A/c No: ".$acc_no." </br>
				A/c name: ".$ac_name."</br>
				IFSC Code: ".$ifsc_code."; Branch Code: ".$branch_code."
				</td>";
				$message .="<td colspan='4' style='text-align: center;' > Authorize Signature </td>";
			$message .="</tr>";
		$message .="</tbody>";
	$message .="</table>";

    $message .="</body>";
$message .="</html>";

?>