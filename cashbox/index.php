<?php
	include('assets/php/sql_conn.php');	
	
	if(isset($_GET["p"])){
		$p = $_GET["p"];
	}else{
		$p = '';
	}
	
	switch($p){
		case 'login':
		include('pages/login.php');
		break;
		
		case 'dashboard':
		$title = "Dashboard";
		include('pages/dashboard.php');		
		break;
		
		case 'dashboard-all':
		$title = "Dashboard All";
		include('pages/dashboard-all.php');		
		break;
		
		case 'items':
		$title = "Items";
		include('pages/items.php');		
		break;
		
		case 'customers':
		$title = "Customers";
		include('pages/customers.php');		
		break;
		
		case 'users':
		$title = "Users";
		include('pages/users.php');		
		break;
		
		case 'emp-list':
		$title = "Employee List";
		include('pages/emp_list.php');		
		break;
		
		case 'emp-attendance':
		$title = "Employee Attendance";
		include('pages/emp_attendance.php');		
		break;
		
		case 'emp-pay':
		$title = "Employee Pay";
		include('pages/emp_pay.php');		
		break;
		
		case 'emp-pay-slip':
		$title = "Employee PaySlip";
		include('pages/emp_pay_slip.php');		
		break;
		
		case 'todays-bill':
		$title = "Today's Bill";
		include('pages/todays_bill.php');		
		break;
		
		case 'bill':
		$title = "Bill List";
		include('pages/bill.php');		
		break;
		
		case 'new_bill':
		$title = "New Bill";
		include('pages/new_bill.php');		
		break;
		
		case 'settings':
		$title = "Settings";
		include('pages/settings.php');		
		break;
		
		case 'cashbook':
		$title = "Cashbook";
		include('pages/cashbook.php');		
		break;
		
		case 'gst_report':
		$title = "GST report";
		include('pages/gst_report.php');		
		break;
		
		case 'product_report':
		$title = "Product report";
		include('pages/product_report.php');		
		break;
		
		case 'zone':
		$title = "Zone Management";
		include('pages/zone.php');		
		break;
		
		case 'zone_report':
		$title = "Zone Report";
		include('pages/zone_report.php');		
		break;
		
		case 'zone_report_wi_bill':
		$title = "Zone Report With Bill";
		include('pages/zone_report_wi_bill.php');		
		break;
		
		case 'zone_data_sheet':
		$title = "Zone Data Sheet";
		include('pages/zone_data_sheet.php');		
		break;
				
		default:
		include('pages/login.php');
	}

?>