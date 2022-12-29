<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['from_date'])){
		$from_date = $_GET['from_date'];
		$search_zone_id = $_GET['search_zone_id'];
		$search_cu_id = $_GET['search_cu_id'];
		$user_type = $_GET['user_type'];
		$created_by = $_GET['created_by'];
		$login_id = $_GET['login_id'];
	}

	$sql_zone = "SELECT login.login_id, login.user_data, login.net_due_amount, login.zone_id, bill_details.bill_id, bill_details.customer_id, bill_details.create_date, cashbook_entry.cb_id, cashbook_entry.bill_id, cashbook_entry.cb_amount, cashbook_entry.cb_date FROM login LEFT JOIN bill_details ON login.login_id = bill_details.customer_id LEFT JOIN cashbook_entry ON bill_details.bill_id = cashbook_entry.bill_id WHERE login.net_due_amount > 0 AND login.zone_id = '" .$search_zone_id. "' AND bill_details.create_date <= '" .$from_date. "' ORDER BY (cashbook_entry.cb_date) DESC";

	$result_zone = $mysqli->query($sql_zone);
	$i = 0;
?>


<?php
// include autoloader
include('zone_report_html.php');
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
//window.print();
</script>