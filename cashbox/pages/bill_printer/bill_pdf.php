<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['bill_id'])){
		$bill_id = $_GET['bill_id'];
	}else{
		$firstKey = array_key_first($_REQUEST);
		$bill_id = $_REQUEST[$firstKey];
	}

	$sql_bill = "SELECT * FROM bill_details  WHERE bill_id = '" .$bill_id. "'";	
	$result_bill = $mysqli->query($sql_bill);
	$row_bill = $result_bill->fetch_array();
	$bill_description = json_decode(base64_decode($row_bill['bill_description']));

	//echo json_encode($bill_description);
	$create_date = $row_bill['create_date'];
	
	//Customer details
	$customer_name = $bill_description->customer_name;
	$phone_number = $bill_description->phone_number; 
	$customer_address = str_replace('_', ' ', $bill_description->customer_address); 
	$customer_gstin_no = $bill_description->customer_gstin_no; 
	$customer_email = $bill_description->email_id; 

	$created_by = $row_bill['created_by'];
	$get_sql = "SELECT * FROM login WHERE login_id = '" .$created_by. "'";
	$get_sql_result = $mysqli->query($get_sql);
	$get_sql_row = $get_sql_result->fetch_array();
	$bank_ac_info1 = $get_sql_row['bank_ac_info'];
	$bank_ac_info = json_decode($bank_ac_info1);
	$bank_name = $bank_ac_info->bank_name;//'SBI';
	$branch_name = $bank_ac_info->branch_name;//'Anandamath, Icchapore';
	$acc_no = $bank_ac_info->acc_no;//'40015926141';
	$ac_name = $bank_ac_info->ac_name;//'Ms Riddhima Enterprise';
	$ifsc_code = $bank_ac_info->ifsc_code;//'SBIN0017370';
	$branch_code = $bank_ac_info->branch_code;//'17370';

	//Get Payment History	
	$payHistory = array();
	$payHistoryText = '';
	$sqlPay = "SELECT * FROM cashbook_entry WHERE bill_id = '".$bill_id."'";
	$resultPay = $mysqli->query($sqlPay);

	if ($resultPay->num_rows > 0) {
		while($rowPay = $resultPay->fetch_array()){
			$payHistoryObj = new stdClass();
			$payHistoryObj->cb_amount = $rowPay['cb_amount'];
			$payHistoryObj->cb_date = $rowPay['cb_date'];
			array_push($payHistory, $payHistoryObj);
			$payHistoryText .= "<div class='col-md-12'>Rs. ".$rowPay['cb_amount']."/- Paid on ".date('d-F-Y h:i A', strtotime($rowPay['cb_date']))."</div>";
		}
	}//end if

	$formated_bill_no = 'RE/'.date('M', strtotime($create_date)).'/'.$bill_id;

	function digitToinWordConverter($number){
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
			'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			'7' => 'seven', '8' => 'eight', '9' => 'nine',
			'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			'13' => 'thirteen', '14' => 'fourteen',
			'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			'60' => 'sixty', '70' => 'seventy',
			'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			} else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
			"." . $words[$point / 10] . " " . 
				$words[$point = $point % 10] : '';
		return $result . "Rupees  Only.";
		
	}//end fun
?>


<?php
// include autoloader
include('bill_html.php');
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
//$dompdf->stream("jewellery_bill.pdf");

?>

<script>
window.print();
</script>