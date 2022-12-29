<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['from_date'])){
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		$search_cu_id = 0;//$_GET['search_cu_id'];
		$user_type = $_GET['user_type'];
		$created_by = $_GET['created_by'];
		$login_id = $_GET['login_id'];
	}

	if($user_type == '5'){		
		$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";		
	}else{
		$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";	
	}

	$result_bill = $mysqli->query($sql_bill);							
		
	$fineItemsArr = array();
	$i = 0;
	while ($row_bill = $result_bill->fetch_array()){ 
		$i++;
		$bill_id = $row_bill['bill_id'];
		//echo 'bill_id:'.$bill_id;
		//echo "<br>";
		$bill_description = json_decode(base64_decode($row_bill['bill_description']));
		if($i == 1){
			//echo json_encode($bill_description);
		}

		$fineItems = $bill_description->fineItems;
		$virtual_create_date = $bill_description->create_date_new;
		if($virtual_create_date != ''){
			if(strtotime($virtual_create_date) >= strtotime($from_date) && strtotime($virtual_create_date) <= strtotime($to_date)){
				//echo 'virtual_create_date: '.$virtual_create_date;
				//echo "<br>";

				for($j = 0; $j < sizeof($fineItems); $j++){
					
					array_push($fineItemsArr, $fineItems[$j]);
				}//end for
			}//end if
		}//end if
	}//end while

	//echo json_encode($fineItemsArr);
	// echo "<br>";
	// echo "<br>";
	// echo "<br>";

	
	$sql = "SELECT * FROM item_master ORDER BY item_name ASC";	
	$result = $mysqli->query($sql);
	$mainArray = array();
	while ($row = $result->fetch_array()){
		$subObj = new stdClass();
		$subObj->item_id = $row['item_id'];
		$subObj->item_name = $row['item_name'];
		$subObj->hs_code = $row['hs_code'];
		$subObj->products = array();
		$subObj->productNewQty = 0;
		$subObj->gotaMoslaQty = 0;

		array_push($mainArray, $subObj);
	}
	// echo json_encode($mainArray);
	// echo "<br>";
	// echo "<br>";
	// echo "<br>";

	$masterItems = $mainArray;
	$orderItems = $fineItemsArr;
	//echo json_encode($orderItems);
	for($m = 0; $m < sizeof($masterItems); $m++){
		$productNewQty = $masterItems[$m]->productNewQty;
		$gotaMoslaQty = $masterItems[$m]->gotaMoslaQty;
		//echo 'item_id: '.$masterItems[$m]->item_id;
		//echo "<br>";

		for($n = 0; $n < sizeof($orderItems); $n++){
			//if($orderItems[$n]->item_id == '21'){
				if($masterItems[$m]->item_id == $orderItems[$n]->item_id){
					$qty = $orderItems[$n]->qty;
					$gotaMoslaQty .= $orderItems[$n]->qty.' kg/. ';
					//echo 'qty: '.$qty;
					//echo "<br>";
					$productNewQty = $productNewQty + $qty;
				}//end if
			//}
		}//end for n
		$masterItems[$m]->productNewQty = $productNewQty;
		$masterItems[$m]->gotaMoslaQty = $gotaMoslaQty;
	}//end for m

	//echo json_encode($masterItems);

	for($j = 0; $j < sizeof($mainArray); $j++){
		for($k = 0; $k < sizeof($fineItemsArr); $k++){
			if($mainArray[$j]->hs_code == $fineItemsArr[$k]->hs_code){
				array_push($mainArray[$j]->products, $fineItemsArr[$k]);
			}//end if
		}//end for k
	}//end for j

?>


<?php
// include autoloader
include('product_report_html.php');
echo $message;

require_once '../../assets/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->setDefaultFont('Courier');
$dompdf->setOptions($options);
$dompdf->loadHtml($message);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
//$dompdf->stream("gst_report.pdf");

?>

<script>
window.print();
</script>