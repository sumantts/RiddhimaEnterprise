<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['from_date'])){
		$from_date = $_GET['from_date'];
		$to_date = $_GET['to_date'];
		$search_cu_id = $_GET['search_cu_id'];
		$user_type = $_GET['user_type'];
		$created_by = $_GET['created_by'];
		$login_id = $_GET['login_id'];
	}

	if($user_type == '5'){
		if($search_cu_id > 0){
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND customer_id = '" .$search_cu_id. "' AND create_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
		}else{
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
		}
	}else{
		if($search_cu_id > 0){
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND customer_id = '" .$search_cu_id. "' AND create_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
		}else{
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
		}
	}

	$result_bill = $mysqli->query($sql_bill);
	$i = 0;
?>


<?php
// include autoloader
include('all_bill_html.php');
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
//$dompdf->stream("collection_report.pdf");

?>

<script>
window.print();
</script>