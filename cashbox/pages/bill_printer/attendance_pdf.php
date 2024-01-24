<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['sr_month_name'])){
		$month_name = $_GET['sr_month_name'];
		$emp_id = $_GET['sr_emp_name'];
		$sr_month_name_text = $_GET['sr_month_name_text'];
		$sr_emp_name_text = $_GET['sr_emp_name_text'];
	}
	
	if($month_name < 10){
		$present_date_start = date('Y').'-0'.$month_name.'-01';
		$present_date_end = date('Y').'-0'.$month_name.'-31';
	}else{
		$present_date_start = date('Y').'-'.$month_name.'-01';
		$present_date_end = date('Y').'-'.$month_name.'-31';
	}

	$total_attendance = 0;
	$sql = "SELECT * FROM employee_attendance WHERE emp_id = '".$emp_id."' AND present_date >= '".$present_date_start."' AND  present_date <= '" .$present_date_end. "' AND present_status = 1 ORDER BY present_date";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		$total_attendance = $result->num_rows;
	}
	?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"  crossorigin="anonymous">

    <title>Attendance Report</title>
		
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
    <h4 class="text-center">Attendance Report of: <?=$sr_emp_name_text?> for the month of: <?=$sr_month_name_text?> <?=date('Y')?></h4>
	<table>
		<thead>
			<tr>
			<th scope="col" class="text-center">Date</th>
			<th scope="col" class="text-left">Present/Absent</th>
			<th scope="col" class="text-left"> Half day</th>
			<th scope="col" class="text-left"> Full Day</th>
			<th scope="col" class="text-left"> Late Hour</th>
			<th scope="col" class="text-left"> Overtime Hour</th>
			<th scope="col" class="text-left"> Note</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$half_count = 0;
			$full_day_count = 0;
			$net_late_hours = 0;
			$net_overtime_hours = 0;
			
			while($row = $result->fetch_array()){
				if($row['half_day'] == 1){
					$half_count++;
				}
				if($row['full_day'] == 1){
					$full_day_count++;
				}
				$net_late_hours = $net_late_hours + $row['late_hours'];
				$net_overtime_hours = $net_overtime_hours + $row['overtime_hours'];
		?>
				<tr>
					<td scope="row" class="text-center"><?=date('d-m-Y', strtotime($row['present_date']))?></td>
					<td class="text-center"><?=($row['present_status'] == 1)? 'Present' : 'Absent'?></td>
					<td class="text-center"><?=($row['half_day'] == 1)? 'Yes' : 'No'?></td>
					<td class="text-center"><?=($row['full_day'] == 1)? 'Yes' : 'No'?></td>
					<td class="text-right"><?=$row['late_hours']?></td>
					<td class="text-right"><?=$row['overtime_hours']?></td>
					<td><?=$row['attendance_note']?></td>			
				</tr>
		<?php		
			}//end while
		?>

		<tr>
			<th scope="col" class="text-center" colspan="2">Total Present: <?=$total_attendance?> Days</th>
			<th scope="col" class="text-center"><?=$half_count?></th>
			<th scope="col" class="text-center"><?=$full_day_count?></th>
			<th scope="col" class="text-center"><?=$net_late_hours?> Hrs</th>
			<th scope="col" class="text-center"><?=$net_overtime_hours?> Hrs</th>
		</tr>
		
		
		</tbody>
	</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>




