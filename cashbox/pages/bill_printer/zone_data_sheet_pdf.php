<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['search_zone_id'])){
		//$from_date = $_GET['from_date'];
		$search_zone_id = $_GET['search_zone_id'];
		$zone_name = $_GET['zone_name'];
		$search_cu_id = $_GET['search_cu_id'];
		$user_type = $_GET['user_type'];
		$created_by = $_GET['created_by'];
		$login_id = $_GET['login_id'];
	}

	$sql_zone = "SELECT * FROM login WHERE zone_id = '" .$search_zone_id. "'";
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

    <title>Zone Data Sheet</title>
		
	<style>
	table, td, th {
	border: 1px solid;
	padding-left: 2px;
	}

	table {
	width: 100%;
	border-collapse: collapse;
	}
	</style>
  </head>
  <body>
    <h4 class="text-center">Zone Data Sheet Report (<?=$zone_name?>)</h4>
	<table>
		<thead>
			<tr>
			<th scope="col" class="text-center">Sl#</th>
			<th scope="col" class="text-left">Customer Name</th>
			<th scope="col" class="text-left">Contact Person</th>
			<th scope="col" class="text-left"> Address</th>
			<th scope="col" class="text-left"> Phone Number</th>
			</tr>
		</thead>
		<tbody>
		<?php
			for ($i = 0; $i < sizeof($row_zone); $i++){ 
				$j++;
				$user_data1 = $row_zone[$i]['user_data'];
				$user_data = json_decode($user_data1);
		?>
				<tr>
				<th scope="row" class="text-center"><?=$i+1?></th>
				<td class="text-left" ><?=$user_data->org_name?></td>
				<td class="text-left" ><?=$user_data->contact_person?></td>
				<td class="text-left" ><?=$user_data->address?></td>
				<td class="text-left" ><?=$user_data->phone_number?></td>
			
				</tr>
		<?php		
			}//end for
		?>
		
		
		</tbody>
	</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>




