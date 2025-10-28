<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>Riddhima Enterprise - Product report</title>";
	$message .="<style type='text/css'>";
    $message .="table { page-break-inside:auto }";
    $message .="tr    { page-break-inside:avoid; page-break-after:auto }";
    $message .="thead { display:table-header-group }";
    $message .="tfoot { display:table-footer-group }";
	$message .="</style>";
$message .="</head>";

$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse;font-size: 12px;width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
		if($search_zone_id > 0){
			$message .="<th colspan='8' style='text-align: center;'>Riddhima Enterprise - Product report<br>From: ".date('d-F-Y', strtotime($from_date))." To: ".date('d-F-Y', strtotime($to_date))."<br> Zone: ".$zone_name."(".$zone_area.")</th>";
		}else{
			$message .="<th colspan='8' style='text-align: center;'>Riddhima Enterprise - Product report<br>From: ".date('d-F-Y', strtotime($from_date))." To: ".date('d-F-Y', strtotime($to_date))."</th>";
		}
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th>SL.No.</th>";	
			$message .="<th>Id</th>";	
			$message .="<th colspan='2'> Product Name</th>";
			$message .="<th> HS Code</th>";
			$message .="<th>Quantity</th>";	
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";

		$a = 0;
		$sl = 1;
		for($x = 0; $x < sizeof($masterItems); $x++){
			$item_id = $masterItems[$x]->item_id;
			$item_name = $masterItems[$x]->item_name;
			$hs_code = $masterItems[$x]->hs_code;
			$productNewQty = $masterItems[$x]->productNewQty;
			$gotaMoslaQty = $masterItems[$x]->gotaMoslaQty;
			$a = $a + $productNewQty;

			$str = $masterItems[$x]->item_name;
			$firstPos = strpos($str, '(');
			$lastPos = strpos($str, ')');
			$quantityString = substr($str, $firstPos, $lastPos);
			$quantityString1 = ltrim($quantityString, '(');
			$quantityString2 = substr($quantityString1, 0, -1);

			$prodNameString = substr($str, 0, $firstPos);

			if($productNewQty > 0){
				$message .="<tr>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$sl."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$item_id."</td>";
				if (strpos($item_name, 'GOTA') !== false) {
					$message .="<td colspan='2' style='padding-left: 5px;'>".$item_name." ( " .$gotaMoslaQty." )</td>";
				}else{
					$message .="<td colspan='2' style='padding-left: 5px;'>".$item_name."</td>";
				}
				$message .="<td>".$hs_code."</td>";						
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productNewQty."</td>";
				$message .="</tr>";	
				$sl++;
			}

		}//end for x
		
		$message .="<tr>";
			$message .="<td colspan='5' style='text-align: center; padding-left: 5px; font-weight: bold;'>TOTAL</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$a."</td>";
		$message .="</tr>";	

		$message .="</tbody>";
	$message .="</table>";
	
    $message .="</body>";
$message .="</html>";

?>