<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['emp_sal_id'])){
		$emp_sal_id = $_GET['emp_sal_id'];
	}
	
	$first_day = '';
	$last_day = '';

	$sql = "SELECT employee_salary.emp_id, employee_salary.total_allounce, employee_salary.total_deduction, employee_salary.basic_pay, employee_salary.net_pay, employee_salary.salary_detail_data, employee_salary.for_the_month, employee_list.emp_ph_primary FROM employee_salary JOIN employee_list ON employee_list.emp_id = employee_salary.emp_id WHERE employee_salary.emp_sal_id = '".$emp_sal_id."'";
	$result = $mysqli->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		$emp_id = $row['emp_id'];
		$total_allounce = $row['total_allounce'];
		$total_deduction = $row['total_deduction'];
		$basic_pay = $row['basic_pay'];
		$net_pay = $row['net_pay'];
		$salary_detail_data = json_decode($row['salary_detail_data']);
		$for_the_month = $row['for_the_month'];
		$emp_ph_primary = $row['emp_ph_primary'];
	}
	
	$curmnth = date('m', strtotime($for_the_month));
	$curyear = date('Y', strtotime($for_the_month));

	$first_day = $curyear.'-'.$curmnth.'-01';
	$last_day = $curyear.'-'.$curmnth.'-31';

	function get_days_in_month($month, $year)
	{
		if ($month == "02")
		{
			if ($year % 4 == 0) return 29;
			else return 28;
		}
		else if ($month == "01" || $month == "03" || $month == "05" || $month == "07" || $month == "08" || $month == "10" || $month == "12") return 31;
		else return 30;
	}
	$totDays = get_days_in_month($curmnth, $curyear);

	function digitToinWordConverter($number){
		$no = floor($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'One', '2' => 'Two',
			'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
			'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
			'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
			'13' => 'Thirteen', '14' => 'Fourteen',
			'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
			'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
			'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
			'60' => 'Sixty', '70' => 'Seventy',
			'80' => 'Eighty', '90' => 'Ninety');
		$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
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

	$total_allounce = $salary_detail_data->effectiveBasicPay + $salary_detail_data->total_allounce + $salary_detail_data->overtime_amount;

	if(isset($salary_detail_data->overtime_hours)){
		if($salary_detail_data->overtime_hours > 0){
			$overtime_hours = $salary_detail_data->overtime_hours;
		}
	}else{
		$overtime_hours = 0;
	}
	//echo json_encode($salary_detail_data);
	//exit();




?>


<?php
// include autoloader
include('attendance_html.php');
echo $message;


?>

<script>
//window.print();
</script>