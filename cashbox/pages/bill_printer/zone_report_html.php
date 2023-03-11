<?php
$message = "";

$message .="<!DOCTYPE html>";
$message .="<html lang='en'>";

$message .="<head>";
	$message .="<meta charset='utf-8'>";
	$message .="<title>Riddhima Enterprise - Zone Collection Report</title>";
$message .="</head>";

$message .="<body>";
	
$message .="<table border='1' style='border-collapse:collapse;font-size: 12px;width: 100%;'>";
		$message .="<thead>";
		
		$message .="<tr>";
			$message .="<th colspan='6' style='text-align: center;'>Riddhima Enterprise - Zone Collection Report: ".$zone_name." Before dated: ".date('d-m-Y', strtotime($from_date))."</th>";
		$message .="</tr>";
		
		
		$message .="<tr>";
			$message .="<th> Sl.No.</th>";
			$message .="<th>Customer Name</th>";
			$message .="<th>Cashbook Id</th>";
			$message .="<th>Last payment Date</th>";								
			$message .="<th>Last payment Amount</th>";							
			$message .="<th>Due Amount</th>";								
			$message .="<th>Today Collo.</th>";		
		$message .="</tr>";
		$message .="</thead>";

		$message .="<tbody>";							
		
		$a = 0; $b = 0; $c = 0; $d = 0; $j = 0;
		$row_zone = [];
		$row_zone1 = [];
		$x = 0;
		while($row_zone2 = $result_zone->fetch_array()){
			if($x == 0){
				array_push($row_zone, $row_zone2);
			}else{
				$duplicate = false;
				for($y = 0; $y < sizeof($row_zone); $y++){
					//echo 'cb id:'.$row_zone2['cb_id'];
					//echo 'cb id:'.$row_zone[$y]['cb_id'];

					if($row_zone2['customer_id'] == $row_zone[$y]['customer_id']){
						$duplicate = true;
						break;
					}
				}//end for

				if($duplicate == false){
					array_push($row_zone, $row_zone2);
				}
			}
			
			$x++;
		}//end while

//echo json_encode($row_zone);

		//for ($x = 0; $x < sizeof($row_zone); $x++){ 
		//}//end for

		for ($i = 0; $i < sizeof($row_zone); $i++){ 
			$j++;
			$user_data1 = $row_zone[$i]['user_data'];
			$user_data = json_decode($user_data1);
			$cb_date = $row_zone[$i]['cb_date'];
			$cb_amount = $row_zone[$i]['cb_amount'];
			$net_due_amount = $row_zone[$i]['net_due_amount'];
			$user_data1 = $row_zone[$i]['user_data'];
			$cb_id = $row_zone[$i]['cb_id'];

			$a = $a + $net_due_amount;

			$message .="<tr>";
				$message .="<td style='padding-left: 5px;'>".$j."</td>";
				$message .="<td>".$user_data->org_name."</td>";
				$message .="<td>".$cb_id."</td>";
				$message .="<td >". date('d/m/Y', strtotime($cb_date)) ."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".number_format((float)$cb_amount, 2, '.', '')."</td>";
				$message .="<td style='text-align: right; padding-right: 5px;'>".number_format((float)$net_due_amount, 2, '.', '')."</td>";
				$message .="<td style='padding-right: 5px;'> </td>";
				
			$message .="</tr>";	
				
		}						
		
		$message .="<tr>";
			$message .="<td>#</td>";
			$message .="<td colspan='4' style='text-align: center; padding-left: 5px; font-weight: bold;'>TOTAL</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".number_format((float)$a, 2, '.', '')."</td>";
			$message .="<td style='text-align: right; padding-right: 5px; font-weight: bold;'>".number_format((float)$b, 2, '.', '')."</td>";
		$message .="</tr>";	

		$message .="</tbody>";
	$message .="</table>";
    $message .="</body>";
$message .="</html>";

?>