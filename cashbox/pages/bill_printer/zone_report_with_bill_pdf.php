<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['from_date'])){
		$from_date = $_GET['from_date'];
		$search_zone_id = $_GET['search_zone_id'];
		$zone_name = $_GET['zone_name'];
		$search_cu_id = $_GET['search_cu_id'];
		$user_type = $_GET['user_type'];
		$created_by = $_GET['created_by'];
		$login_id = $_GET['login_id'];
	}

	$sql_zone = "SELECT * FROM login WHERE net_due_amount > 0 AND zone_id = '" .$search_zone_id. "'";
	$result_zone = $mysqli->query($sql_zone);

	$a = 0; $b = 0; $c = 0; $d = 0; $i = 0; $j = 0;	$x = 0;
	$row_zone = [];
	$row_zone1 = [];
	while($row_zone2 = $result_zone->fetch_array()){
		if($x == 0){
			array_push($row_zone, $row_zone2);
		}else{
			$duplicate = false;
			for($y = 0; $y < sizeof($row_zone); $y++){
				//echo 'cb id:'.$row_zone2['cb_id'];
				//echo 'cb id:'.$row_zone[$y]['cb_id'];

				if($row_zone2['login_id'] == $row_zone[$y]['login_id']){
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

	?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"  crossorigin="anonymous">

    <title>Zone Report With Bill</title>
		
	<style>
	table, td, th {
	border: 1px solid;
	}

	table {
	width: 100%;
	border-collapse: collapse;
	}
	</style>
  </head>
  <body>
    <h4 class="text-center">Zone report of: <?=$zone_name?>; Before dated: <?=date('d-m-Y', strtotime($from_date))?></h4>
	<table>
		<thead>
			<tr>
			<th scope="col" class="text-center">Sl#</th>
			<th scope="col" class="text-center">Customer Name</th>
			<th scope="col" class="text-center" style="border-bottom: hidden;">Bill Detail</th>
			<th scope="col" class="text-center">Net Due Amount</th>
			</tr>
		</thead>
		<tbody>
		<?php
			for ($i = 0; $i < sizeof($row_zone); $i++){ 
				$j++;
				$user_data1 = $row_zone[$i]['user_data'];
				$user_data = json_decode($user_data1);
				$net_due_amount = $row_zone[$i]['net_due_amount'];
				$login_id = $row_zone[$i]['login_id'];
				$a = $a + $net_due_amount;
		?>
				<tr>
				<th scope="row" class="text-center"><?=$i+1?></th>
				<td class="text-center" style="border-right-color: #fff;"><?=$user_data->org_name?></td>
				<td style="border-bottom: hidden;">
					<table>
						<tr>
							<td>Bill No.</td>
							<td>Paid Amount</td>
							<td>Due Amount</td>
							<td>Collected Amount</td>
						</tr>
						<?php			
							$from_date1 = $from_date.' 00:00:01';			
							$sql_bill = "SELECT * FROM bill_details WHERE customer_id = '".$login_id."' AND create_date < '".$from_date1."' ORDER BY bill_id DESC";
							$result_bill = $mysqli->query($sql_bill);
							while ($row_bill = $result_bill->fetch_array()){ 
								$dueAmount = 0;
								$paidAmount = 0;
								$bill_id = $row_bill['bill_id'];
								$bill_description = json_decode(base64_decode($row_bill['bill_description']));	

								if(isset($bill_description->create_date_new)){
									$create_date = $bill_description->create_date_new;
								}else{
									$create_date = $row_bill['create_date'];
								}							
								$formated_bill_no = 'RE/'.date('M', strtotime($create_date)).'/'.$bill_id;
								$paidAmount = $bill_description->totalCash;
								$dueAmount = $bill_description->dueCash;
								if($dueAmount > 0){
								?>
								<tr>
									<td><?=$formated_bill_no?></td>
									<td><?=$paidAmount?></td>
									<td><?=$dueAmount?></td>
									<td>&nbsp;</td>
								</tr>
						<?php
								}//end if
							}//end while
						?>
					</table>
				</td>
				<td class="text-right" style="border-left: hidden;"><?=$net_due_amount?></td>
				</tr>
		<?php		
			}//end for
		?>
		<tr><th scope="row" colspan="3" class="text-center">Total Due</th><th scope="row" class="text-right"><?=number_format($a, 2)?></th></tr>	
		<tr><th scope="row" colspan="3" class="text-center">Today's collection</th><th scope="row" class="text-right"> &nbsp;</th></tr>	
		<tr>
			<th scope="row" class="text-left">Collected By</th><th scope="row" class="text-right"> &nbsp;</th>
			<th scope="row" class="text-left">Date</th><th scope="row" class="text-left"> &nbsp;</th></tr>
		</tbody>
	</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>




