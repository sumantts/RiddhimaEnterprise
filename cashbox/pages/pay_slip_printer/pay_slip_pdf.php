<?php
	include('../../assets/php/sql_conn.php');		

	if(isset($_GET['emp_sal_id'])){
		$emp_sal_id = $_GET['emp_sal_id'];
	}
	
	$sql = "SELECT * FROM employee_salary WHERE emp_sal_id = '".$emp_sal_id."'";
	$result = $mysqli->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		$emp_id = $row['emp_id'];
		$total_allounce = $row['total_allounce'];
		$total_deduction = $row['total_deduction'];
		$basic_pay = $row['basic_pay'];
		$net_pay = $row['net_pay'];
		$salary_detail_data = $row['salary_detail_data'];
		$for_the_month = $row['for_the_month'];
	}
	
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
include('pay_slip_html.php');
echo $message;


?>

<script>
//window.print();
</script>