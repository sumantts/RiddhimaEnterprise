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
			$message .="<th colspan='8' style='text-align: center;'>Riddhima Enterprise - GST report (From: ".date('d/m/Y', strtotime($from_date))." To: ".date('d/m/Y', strtotime($to_date)).")</th>";
		$message .="</tr>";
		
		$message .="<tr>";
			$message .="<th colspan='2'> Product Name</th>";
			$message .="<th> HS Code</th>";
			$message .="<th>Quantity</th>";	
			$message .="<th>Price</th>";	
			$message .="<th>Basic Amount</th>";	
			$message .="<th>CGST</th>";	
			$message .="<th>SGST</th>";	
			$message .="<th>GST</th>";	
			$message .="<th>Net Amount</th>";	
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";

		$a = 0; $b = ''; $c = 0; $d = 0; $e = 0; $f = 0; $g = 0;
		for($x = 0; $x < sizeof($masterItems); $x++){
			$item_id = $masterItems[$x]->item_id;
			$item_name = $masterItems[$x]->item_name;
			$hs_code = $masterItems[$x]->hs_code;
			$productNewQty = $masterItems[$x]->productNewQty;
			$productRate = number_format((float)$masterItems[$x]->productRate, 2, '.', '');
			$productBasicAmount = number_format((float)$masterItems[$x]->productBasicAmount, 2, '.', '');
			$productcGST = number_format((float)$masterItems[$x]->productcGST, 2, '.', '');
			$productsGST = number_format((float)$masterItems[$x]->productsGST, 2, '.', '');
			$productGST = number_format((float)$masterItems[$x]->productGST, 2, '.', '');
			$productNetAmount = number_format((float)$masterItems[$x]->productNetAmount, 2, '.', '');

			$a = $a + $productNewQty;
			//$b = $b + $productRate;
			$c = $c + $productBasicAmount;
			$c = number_format((float)$c, 2, '.', '');
			$d = $d + $productGST;
			$d = number_format((float)$d, 2, '.', '');
			$e = $e + $productNetAmount;
			$e = number_format((float)$e, 2, '.', '');
			$f = $f + $productcGST;
			$f = number_format((float)$f, 2, '.', '');
			$g = $g + $productsGST;
			$g = number_format((float)$g, 2, '.', '');

			$str = $masterItems[$x]->item_name;
			$firstPos = strpos($str, '(');
			$lastPos = strpos($str, ')');
			$quantityString = substr($str, $firstPos, $lastPos);
			$quantityString1 = ltrim($quantityString, '(');
			$quantityString2 = substr($quantityString1, 0, -1);

			$prodNameString = substr($str, 0, $firstPos);

			if($productNewQty > 0){
				$message .="<tr>";
				$message .="<td colspan='2' style='padding-left: 5px;'>".$item_name."</td>";
				$message .="<td>".$hs_code."</td>";						
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productNewQty."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productRate."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productBasicAmount."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productcGST."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productsGST."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productGST."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".$productNetAmount."</td>";
				$message .="</tr>";	
			}

		}//end for x
			
			$message .="<tr>";
				$message .="<td colspan='3' style='text-align: center; padding-left: 5px; font-weight: bold;'>TOTAL</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$a."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$b."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$c."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$f."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$g."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$d."</td>";
				$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".$e."</td>";
			$message .="</tr>";	

		$message .="</tbody>";
	$message .="</table>";
	
    $message .="</body>";
$message .="</html>";

?>