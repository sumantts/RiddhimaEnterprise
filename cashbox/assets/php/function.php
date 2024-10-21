<?php
	include('sql_conn.php');
	$fn = '';
	if(isset($_POST["fn"])){
	$fn = $_POST["fn"];
	}
	
	//Login function
	if($fn == 'doLogin'){
		$return_result = array();
		$username = $_POST["username"];
		$password = $_POST["password"];
		$status = true;	
		$login_id = '';
	
		$sql = "SELECT * FROM login WHERE username = '".$username."' && password = '".$password."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$login_id = $row['login_id'];			
			$username = $row['username'];
			$user_type = $row['user_type'];	
			$created_by = $row['created_by'];	

			$_SESSION["user_type"] = $user_type;
			$_SESSION["username"] = $username;
			$_SESSION["login_id"] = $login_id;
			$_SESSION["created_by"] = $created_by;

		} else {
			$status = false;
		}
		$mysqli->close();
					
		
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function doLogin
	
	//Save Employee function start
	if($fn == 'saveEmployee'){
		$return_result = array();
		$emp_id = $_POST['emp_id'];
		$emp_name = $_POST['emp_name'];
		$emp_ph_primary = $_POST['emp_ph_primary'];
		$emp_ph_secondary = $_POST['emp_ph_secondary'];
		$emp_email = $_POST['emp_email'];
		$emp_aadhar_no = $_POST['emp_aadhar_no'];
		$emp_pan_no = $_POST['emp_pan_no'];		
		$emp_pf_no = $_POST['emp_pf_no'];		
		$emp_basic_pay = $_POST['emp_basic_pay'];
		$payment_type = $_POST['payment_type'];
		$emp_address = $_POST['emp_address'];
		$created_by = $_POST['created_by'];

		$message = '';
		
		if ($emp_id > 0) {
			$status = true;	
			//update
			$sql_update = "UPDATE employee_list SET emp_name = '".$emp_name."', emp_ph_primary = '".$emp_ph_primary."', emp_ph_secondary = '".$emp_ph_secondary."', emp_email = '".$emp_email."', emp_aadhar_no = '".$emp_aadhar_no."', emp_pan_no = '".$emp_pan_no."', emp_pf_no = '".$emp_pf_no."', emp_basic_pay = '".$emp_basic_pay."', payment_type = '".$payment_type."', emp_address = '" .$emp_address. "' WHERE emp_id = '" .$emp_id. "' ";
			$mysqli->query($sql_update);
		} else {
			$sql = "SELECT * FROM employee_list WHERE emp_ph_primary = '".$emp_ph_primary."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$status = false;	
				$message = 'Primary Phone No Duplicate';
			}else{	
				//Insert
				$sql_insert = "INSERT INTO employee_list (emp_name, emp_ph_primary,	emp_ph_secondary, emp_email, emp_aadhar_no,	emp_pan_no, emp_pf_no, emp_basic_pay, payment_type, emp_address, created_by) VALUES('".$emp_name."', '".$emp_ph_primary."', '".$emp_ph_secondary."', '".$emp_email."', '".$emp_aadhar_no."', '".$emp_pan_no."', '".$emp_pf_no."', '".$emp_basic_pay."', '".$payment_type."', '".$emp_address."', '".$created_by. "')";
				$result_insert = $mysqli->query($sql_insert);
				$emp_id = $mysqli->insert_id;

				if($emp_id > 0){
					$status = true;
				}else{
					$status = false;	
					$message = 'Employee Insert Query Error';
				}
			}
		}//end if else
		
		$mysqli->close();

		$return_result['emp_id'] = $emp_id;
		$return_result['status'] = $status;
		$return_result['message'] = $message;
		//sleep(1);
		echo json_encode($return_result);
	}//end function save Employee
	
	//Save Item function
	if($fn == 'saveItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$item_name = $_POST["item_name"];
		$hs_code = $_POST["hs_code"];
		$cgst_rate = $_POST["cgst_rate"];
		$sgst_rate = $_POST["sgst_rate"];
		$item_quantity = $_POST["item_quantity"];
		
		$stokist_price = $_POST["stokist_price"];
		$dealer_price = $_POST["dealer_price"];
		$wholesaler_price = $_POST["wholesaler_price"];
		$retailer_price = $_POST["retailer_price"];
		$net_weight = $_POST["net_weight"];
		$login_id = $_POST["login_id"];
		$message = '';
		
		if ($item_id > 0) {
			$status = true;	
			//update
			$sql_update = "UPDATE item_master SET item_name = '".$item_name."', hs_code = '".$hs_code."', cgst_rate = '".$cgst_rate."', sgst_rate = '".$sgst_rate."', item_quantity = '".$item_quantity."', stokist_price = '".$stokist_price."', dealer_price = '".$dealer_price."', wholesaler_price = '".$wholesaler_price."', retailer_price = '".$retailer_price."', net_weight = '" .$net_weight. "' WHERE item_id = '" .$item_id. "' ";
			$mysqli->query($sql_update);			

			//Update user's stock quantity start
			$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();
				$stock_quantity1 = $row['stock_quantity'];
				$stock_quantity = json_decode($stock_quantity1);					
				if(sizeof($stock_quantity) > 0){
					for($i = 0; $i < sizeof($stock_quantity); $i++){
						if($stock_quantity[$i]->item_id == $item_id){
							$stock_quantity[$i]->item_quantity = $item_quantity;
							break;
						}
					}//end for
				}else{
					$stock_quantity = array();
					$stockObj = new stdClass();
					$stockObj->hs_code = $hs_code;
					$stockObj->item_quantity = $item_quantity;
					$stockObj->item_id = $item_id;
					array_push($stock_quantity, $stockObj);
				}
				$stock_quantity_new = json_encode($stock_quantity);

				$update_sql = "UPDATE login SET stock_quantity = '" .$stock_quantity_new. "' WHERE login_id = '".$login_id."'";
				$mysqli->query($update_sql);
			}
			//Update user's stock quantity end
		} else {
			$sql = "SELECT * FROM item_master WHERE item_name = '".$item_name."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$status = false;	
				$message = 'Item Already Exist';
			}else{
				$status = true;	
				
				//Insert
				$sql_insert = "INSERT INTO item_master (item_name, hs_code, cgst_rate, sgst_rate, item_quantity, stokist_price, dealer_price, wholesaler_price, retailer_price, net_weight) VALUES('".$item_name."', '".$hs_code."', '".$cgst_rate."', '".$sgst_rate."', '" .$item_quantity. "', '" .$stokist_price. "', '" .$dealer_price. "', '" .$wholesaler_price. "', '" .$retailer_price. "', '" .$net_weight. "')";
				$result_insert = $mysqli->query($sql_insert);
				$item_id = $mysqli->insert_id;

				//Update user's stock quantity start
				$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";
				$result = $mysqli->query($sql);

				if ($result->num_rows > 0) {
					$row = $result->fetch_array();
					$stock_quantity1 = $row['stock_quantity'];
					if($stock_quantity1 != ''){
						$stock_quantity = json_decode($stock_quantity1);
					}else{
						$stock_quantity = array();
					}
					$stockObj = new stdClass();
					$stockObj->hs_code = $hs_code;
					$stockObj->item_quantity = $item_quantity;
					$stockObj->item_id = $item_id;
					array_push($stock_quantity, $stockObj);
					$stock_quantity_new = json_encode($stock_quantity);

					$update_sql = "UPDATE login SET stock_quantity = '" .$stock_quantity_new. "' WHERE login_id = '".$login_id."'";
					$mysqli->query($update_sql);
				}
				//Update user's stock quantity end
			}

		}//end if else

		
		$mysqli->close();

		$return_result['item_id'] = $item_id;
		$return_result['status'] = $status;
		$return_result['message'] = $message;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveItem
	
	//Update settings function
	if($fn == 'updateSettings'){
		$return_result = array();
		$status = true;

		$login_id = $_POST["login_id"];
		$bank_name = $_POST["bank_name"];
		$branch_name = $_POST["branch_name"];
		$acc_no = $_POST["acc_no"];
		$ac_name = $_POST["ac_name"];
		$ifsc_code = $_POST["ifsc_code"];
		$branch_code = $_POST["branch_code"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$bank_ac_info = new stdClass();
		$bank_ac_info->bank_name = $bank_name;
		$bank_ac_info->branch_name = $branch_name;
		$bank_ac_info->acc_no = $acc_no;
		$bank_ac_info->ac_name = $ac_name;
		$bank_ac_info->ifsc_code = $ifsc_code;
		$bank_ac_info->branch_code = $branch_code;
		$bank_ac_info1 = json_encode($bank_ac_info);

		$update_sql = "UPDATE login SET username = '" .$username. "', password = '" .$password. "', bank_ac_info = '" .$bank_ac_info1. "' WHERE login_id = '".$login_id."'";
		$mysqli->query($update_sql);
		$mysqli->close();
		
		$return_result['status'] = $status;
		
		//sleep(1);
		echo json_encode($return_result);
	}//end function updateSettings

	//Get Item
	if($fn == 'getItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$login_id = $_POST["login_id"];
		$user_type = $_POST["user_type"];
		$created_by = $_POST["created_by"];

		$status = true;	
	
		$sql = "SELECT * FROM item_master WHERE item_id = '".$item_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$item_id = $row['item_id'];
			$item_name = $row['item_name'];
			$hs_code = $row['hs_code'];
			$cgst_rate = $row['cgst_rate'];
			$sgst_rate = $row['sgst_rate'];

			if($user_type == '5'){
				$get_sql = "SELECT * FROM login WHERE login_id = '" .$created_by. "'";														
			}else{
				$get_sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";															
			}
			$get_sql_result = $mysqli->query($get_sql);
			$get_sql_row = $get_sql_result->fetch_array();
			$stock_quantity1 = $get_sql_row['stock_quantity'];
			$stock_quantity = json_decode($stock_quantity1);
			$item_quantity = 0;
			for($i = 0; $i < sizeof($stock_quantity); $i++){
				if($stock_quantity[$i]->item_id == $row['item_id']){
					$item_quantity = $stock_quantity[$i]->item_quantity;
				}
			}
			//$item_quantity = $row['item_quantity'];

			$stokist_price = $row['stokist_price'];
			$dealer_price = $row['dealer_price'];
			$wholesaler_price = $row['wholesaler_price'];
			$retailer_price = $row['retailer_price'];
			$net_weight = $row['net_weight'];
		}
		
		$mysqli->close();

		$return_result['item_id'] = $item_id;
		$return_result['item_name'] = $item_name;
		$return_result['hs_code'] = $hs_code;
		$return_result['cgst_rate'] = $cgst_rate;
		$return_result['sgst_rate'] = $sgst_rate;
		$return_result['item_quantity'] = $item_quantity;
		
		$return_result['stokist_price'] = $stokist_price;
		$return_result['dealer_price'] = $dealer_price;
		$return_result['wholesaler_price'] = $wholesaler_price;
		$return_result['retailer_price'] = $retailer_price;
		$return_result['net_weight'] = $net_weight;

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getItem

	//Get Emp
	if($fn == 'getEmployee'){
		$return_result = array();
		$emp_id = $_POST["emp_id"];
		$status = true;	
	
		$sql = "SELECT * FROM employee_list WHERE emp_id = '".$emp_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$emp_name = $row['emp_name'];
			$emp_ph_primary = $row['emp_ph_primary'];
			$emp_ph_secondary = $row['emp_ph_secondary'];
			$emp_email = $row['emp_email'];
			$emp_aadhar_no = $row['emp_aadhar_no'];
			$emp_pan_no = $row['emp_pan_no'];
			$emp_pf_no = $row['emp_pf_no'];
			$emp_basic_pay = $row['emp_basic_pay'];
			$payment_type = $row['payment_type'];
			$emp_address = $row['emp_address'];
		}

		$return_result['emp_name'] = $emp_name;
		$return_result['emp_ph_primary'] = $emp_ph_primary;
		$return_result['emp_ph_secondary'] = $emp_ph_secondary;
		$return_result['emp_email'] = $emp_email;
		$return_result['emp_aadhar_no'] = $emp_aadhar_no;
		$return_result['emp_pan_no'] = $emp_pan_no;		
		$return_result['emp_pf_no'] = $emp_pf_no;
		$return_result['emp_basic_pay'] = $emp_basic_pay;
		$return_result['payment_type'] = $payment_type;
		$return_result['emp_address'] = $emp_address;

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getEmployee

	//Delete Employee function
	if($fn == 'deleteEmployee'){
		$return_result = array();
		$emp_id = $_POST["emp_id"];
		$status = true;	

		$sql = "DELETE FROM employee_list WHERE emp_id = '".$emp_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function delete Employee

	//Delete Item function
	if($fn == 'deleteItem'){
		$return_result = array();
		$item_id = $_POST["item_id"];
		$login_id = $_POST["login_id"];
		$status = true;	

		$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$stock_quantity1 = $row['stock_quantity'];
			$stock_quantity = json_decode($stock_quantity1);

			if(sizeof($stock_quantity) > 0){
				$stock_quantity_temp = array();
				for($i = 0; $i < sizeof($stock_quantity); $i++){
					if($stock_quantity[$i]->item_id != $item_id){
						array_push($stock_quantity_temp, $stock_quantity[$i]);
					}
				}//end for

				$stock_quantity_temp1 = json_encode($stock_quantity_temp);
				$sql1 = "UPDATE login SET stock_quantity = '" .$stock_quantity_temp1. "' WHERE login_id = '".$login_id."'";	
				$result1 = $mysqli->query($sql1);
			}//end if
		}

		$sql = "DELETE FROM item_master WHERE item_id = '".$item_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function deleteItem

	//Add Stock Qty for saler
	if($fn == 'updateStockQtyAdd'){
		$return_result = array();
		$bill_item_id = $_POST["bill_item_id"];
		$qty = $_POST["qty"];
		$user_type = $_POST["user_type"];
		$login_id = $_POST["login_id"];
		$created_by = $_POST["created_by"];
		$temp_bill_id = $_POST["temp_bill_id"];
		$bill_edit = $_POST["bill_edit"];
		$customer_id = $_POST["customer_id"];

		$status = true;	

		if($user_type == '5'){
			$sql = "SELECT * FROM login WHERE created_by = '".$created_by."'";	
			$result = $mysqli->query($sql);
		}else{
			$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
			$result = $mysqli->query($sql);
		}
		$row_customer = $result->fetch_array();
		$b_stock_quantity1 = $row_customer['stock_quantity'];
		$b_stock_quantity = json_decode($b_stock_quantity1);
		
		for($i = 0; $i < sizeof($b_stock_quantity); $i++){
			if($b_stock_quantity[$i]->item_id == $bill_item_id){
				$old_item_quantity = $b_stock_quantity[$i]->item_quantity;
				$now_item_quantity = $old_item_quantity + $qty;
				$b_stock_quantity[$i]->item_quantity = $now_item_quantity;
				break;
			}
		}//end for
		
		$stock_quantity_temp = json_encode($b_stock_quantity);
		if($user_type == '5'){
			$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE created_by = '".$created_by."'";
		}else{
			$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE login_id = '".$login_id."'";
		}
		$mysqli->query($sql_update);

		//Deduct stock quantity for Buyer
		if($bill_edit == '1' && $temp_bill_id > 0){
			$sql_byr = "SELECT * FROM login WHERE login_id = '".$customer_id."'";	
			$result_byr = $mysqli->query($sql_byr);
			$row_byr = $result_byr->fetch_array();
			$byr_stock_quantity1 = $row_byr['stock_quantity'];
			$byr_stock_quantity = json_decode($byr_stock_quantity1);
			
			for($i = 0; $i < sizeof($byr_stock_quantity); $i++){
				if($byr_stock_quantity[$i]->item_id == $bill_item_id){
					$old_item_quantity_byr = $byr_stock_quantity[$i]->item_quantity;
					$now_item_quantity_byr = $old_item_quantity_byr - $qty;
					$byr_stock_quantity[$i]->item_quantity = $now_item_quantity_byr;
					break;
				}
			}//end for

			$byr_stock_quantity_temp = json_encode($byr_stock_quantity);
			
			$sql_update = "UPDATE login SET  stock_quantity = '".$byr_stock_quantity_temp."' WHERE login_id = '".$customer_id."'";
			
			$mysqli->query($sql_update);
			
		}
		//Deduct stock quantity for Buyer end

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function updateStockQtyAdd

	//updateStockQtyMinus
	if($fn == 'updateStockQtyMinus'){
		$return_result = array();
		$bill_item_id = $_POST["bill_item_id"];
		$qty = $_POST["qty"];
		$user_type = $_POST["user_type"];
		$login_id = $_POST["login_id"];
		$created_by = $_POST["created_by"];
		$temp_bill_id = $_POST["temp_bill_id"];
		$bill_edit = $_POST["bill_edit"];
		$customer_id = $_POST["customer_id"];

		$status = true;	
		//Deduct stock quantity from saler
		if($user_type == '5'){
			$sql = "SELECT * FROM login WHERE created_by = '".$created_by."'";	
			$result = $mysqli->query($sql);
		}else{
			$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
			$result = $mysqli->query($sql);
		}
		$row_customer = $result->fetch_array();
		$b_stock_quantity1 = $row_customer['stock_quantity'];
		$b_stock_quantity = json_decode($b_stock_quantity1);
		
		for($i = 0; $i < sizeof($b_stock_quantity); $i++){
			if($b_stock_quantity[$i]->item_id == $bill_item_id){
				$old_item_quantity = $b_stock_quantity[$i]->item_quantity;
				$now_item_quantity = $old_item_quantity - $qty;
				$b_stock_quantity[$i]->item_quantity = $now_item_quantity;
				break;
			}
		}//end for
		
		$stock_quantity_temp = json_encode($b_stock_quantity);
		if($user_type == '5'){
			$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE created_by = '".$created_by."'";
		}else{
			$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE login_id = '".$login_id."'";
		}
		$mysqli->query($sql_update);

		//Add stock quantity for Buyer
		if($bill_edit == '1' && $temp_bill_id > 0){
			$sql_byr = "SELECT * FROM login WHERE login_id = '".$customer_id."'";	
			$result_byr = $mysqli->query($sql_byr);
			$row_byr = $result_byr->fetch_array();
			$byr_stock_quantity1 = $row_byr['stock_quantity'];
			$byr_stock_quantity = json_decode($byr_stock_quantity1);
			
			for($i = 0; $i < sizeof($byr_stock_quantity); $i++){
				if($byr_stock_quantity[$i]->item_id == $bill_item_id){
					$old_item_quantity_byr = $byr_stock_quantity[$i]->item_quantity;
					$now_item_quantity_byr = $old_item_quantity_byr + $qty;
					$byr_stock_quantity[$i]->item_quantity = $now_item_quantity_byr;
					break;
				}
			}//end for

			$byr_stock_quantity_temp = json_encode($byr_stock_quantity);
			
			$sql_update = "UPDATE login SET  stock_quantity = '".$byr_stock_quantity_temp."' WHERE login_id = '".$customer_id."'";
			
			$mysqli->query($sql_update);
			
		}
		//Add stock quantity for Buyer end

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function updateStockQtyMinus

	//////////////////////////// END ITEM PART ///////////////////////////////////////

	///////////////////////////// ZONE MANAGEMENT //////////////////////////////////////
	//Save Zone function
	if($fn == 'saveZone'){
		$return_result = array();
		$zone_id = $_POST["zone_id"];
		$zone_name = $_POST["zone_name"];
		$zone_area = $_POST["zone_area"];
		$zone_pincode = $_POST["zone_pincode"];
		$login_id = $_POST["login_id"];
		$message = '';
		
		if ($zone_id > 0) {
			$status = true;	
			//update
			$sql_update = "UPDATE zone_master SET zone_name = '".$zone_name."', zone_area = '".$zone_area."', zone_pincode = '".$zone_pincode."', created_by = '".$login_id."' WHERE zone_id = '" .$zone_id. "' ";
			$mysqli->query($sql_update);			
		} else {
			$sql = "SELECT * FROM zone_master WHERE zone_name = '".$zone_name."' OR zone_pincode = '".$zone_pincode."' ";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$status = false;	
				$message = 'Zone Name or Pincode Already Exist';
			}else{
				$status = true;	
				
				//Insert
				$sql_insert = "INSERT INTO zone_master (zone_name, zone_area, zone_pincode, created_by) VALUES('".$zone_name."', '".$zone_area."', '".$zone_pincode."', '".$login_id."')";
				$result_insert = $mysqli->query($sql_insert);
				$zone_id = $mysqli->insert_id;
			}//end if else
			
			$mysqli->close();
		}

		$return_result['zone_id'] = $zone_id;
		$return_result['status'] = $status;
		$return_result['message'] = $message;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveItem

	//Get Zone
	if($fn == 'getZone'){
		$return_result = array();
		$zone_id = $_POST["zone_id"];
		$login_id = $_POST["login_id"];
		$user_type = $_POST["user_type"];
		$created_by = $_POST["created_by"];

		$status = true;	
	
		$sql = "SELECT * FROM zone_master WHERE zone_id = '".$zone_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$zone_id = $row['zone_id'];
			$zone_name = $row['zone_name'];
			$zone_area = $row['zone_area'];
			$zone_pincode = $row['zone_pincode'];
		}
		
		$mysqli->close();

		$return_result['zone_id'] = $zone_id;
		$return_result['zone_name'] = $zone_name;
		$return_result['zone_area'] = $zone_area;
		$return_result['zone_pincode'] = $zone_pincode;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getItem

	//Delete Item function
	if($fn == 'deleteZone'){
		$return_result = array();
		$zone_id = $_POST["zone_id"];
		$login_id = $_POST["login_id"];
		$status = true;	
		
		$sql = "DELETE FROM zone_master WHERE zone_id = '".$zone_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function deleteItem

	//updateUserZone function
	if($fn == 'updateUserZone'){
		$return_result = array();
		$zone_id = $_POST["zone_id"];
		$login_id = $_POST["login_id"];
		$status = true;	
		
		$sql = "UPDATE login SET zone_id = '" .$zone_id. "' WHERE login_id = '".$login_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function updateUserZone
	///////////////////////////// ZONE MANAGEMENT END /////////////////////////////////

	///////////////////////////// HOLIDAY MANAGEMENT //////////////////////////////////////
	//Save Zone function
	if($fn == 'saveHoliday'){
		$return_result = array();
		$h_id = $_POST["h_id"];
		$holiday_title = $_POST["holiday_title"];
		$holiday_date = $_POST["holiday_date"]; 
		$message = '';
		
		if ($h_id > 0) {
			$status = true;	
			//update
			$sql_update = "UPDATE holiday_list SET holiday_title = '".$holiday_title."', holiday_date = '".$holiday_date."' WHERE h_id = '" .$h_id. "' ";
			$mysqli->query($sql_update);			
		} else {
			$sql = "SELECT * FROM holiday_list WHERE holiday_date = '".$holiday_date."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$status = false;	
				$message = 'Holiday Already Exist';
			}else{
				$status = true;	
				
				//Insert
				$sql_insert = "INSERT INTO holiday_list (holiday_title, holiday_date) VALUES('".$holiday_title."', '".$holiday_date."')";
				$result_insert = $mysqli->query($sql_insert);
				$h_id = $mysqli->insert_id;
			}//end if else
			
			$mysqli->close();
		}

		$return_result['h_id'] = $h_id;
		$return_result['status'] = $status;
		$return_result['message'] = $message;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveItem

	//Get Zone
	if($fn == 'getHoliday'){
		$return_result = array();
		$h_id = $_POST["h_id"]; 

		$status = true;	
	
		$sql = "SELECT * FROM holiday_list WHERE h_id = '".$h_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$h_id = $row['h_id'];
			$holiday_title = $row['holiday_title'];
			$holiday_date = $row['holiday_date']; 
		}
		
		$mysqli->close();

		$return_result['h_id'] = $h_id;
		$return_result['holiday_title'] = $holiday_title;
		$return_result['holiday_date'] = $holiday_date; 
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getItem

	//Delete Item function
	if($fn == 'deleteHoliday'){
		$return_result = array();
		$h_id = $_POST["h_id"]; 
		$status = true;	
		
		$sql = "DELETE FROM holiday_list WHERE h_id = '".$h_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function deleteItem

	//updateUserZone function
	if($fn == 'updateUserZone'){
		$return_result = array();
		$zone_id = $_POST["zone_id"];
		$login_id = $_POST["login_id"];
		$status = true;	
		
		$sql = "UPDATE login SET zone_id = '" .$zone_id. "' WHERE login_id = '".$login_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function updateUserZone
	///////////////////////////// HOLIDAY MANAGEMENT END /////////////////////////////////

	/////////////////////////// User part start //////////////////////////////////////
	if($fn == 'saveUser'){
		$return_result = array();	

		$login_id = $_POST["login_id"];
		$logged_in_user_type = $_POST["logged_in_user_type"];
		$created_by = $_POST["created_by"];

		$update_login_id = $_POST["update_login_id"];
		$user_type = $_POST["user_type"];
		$user_data = $_POST["user_data"];
		$user_data1 = json_encode($user_data);
		$whatsapp_number = $_POST["whatsapp_number"];

		$status = true;	

		if ($update_login_id > 0) {
			//update
			$status = true;	
			$sql_update = "UPDATE login SET user_data = '".$user_data1."' WHERE login_id = '" .$update_login_id. "' ";
			$mysqli->query($sql_update);
		} else {
			/*$check_sql = "SELECT * FROM login WHERE username = '" .$whatsapp_number. "' ";
			$result_check_sql = $mysqli->query($check_sql);
			if($result_check_sql->num_rows > 0){
				$status = false;	
			}else{
			}*/

			//Insert
			$stock_quantity1 = array();
			$stock_quantity = json_encode($stock_quantity1);

			$bank_ac_info = new stdClass();
			$bank_ac_info->bank_name = '';
			$bank_ac_info->branch_name = '';
			$bank_ac_info->acc_no = '';
			$bank_ac_info->ac_name = '';
			$bank_ac_info->ifsc_code = '';
			$bank_ac_info->branch_code = '';
			$bank_ac_info1 = json_encode($bank_ac_info);

			if($logged_in_user_type == '5'){
				$sql_insert = "INSERT INTO login (username, password, user_type, user_data, salesman_id, created_by, stock_quantity, bank_ac_info) VALUES('".$whatsapp_number."', '".$whatsapp_number."', '".$user_type."', '".$user_data1."', '".$login_id."', '" .$created_by. "', '" .$stock_quantity. "', '" .$bank_ac_info1. "')";
			}else{
				$salesman_id = 0;
				$sql_insert = "INSERT INTO login (username, password, user_type, user_data, salesman_id, created_by, stock_quantity, bank_ac_info) VALUES('".$whatsapp_number."', '".$whatsapp_number."', '".$user_type."', '".$user_data1."', '".$salesman_id."', '" .$login_id. "', '" .$stock_quantity. "', '" .$bank_ac_info1. "')";
			}
			$result_insert = $mysqli->query($sql_insert);
			$update_login_id = $mysqli->insert_id;
			if($update_login_id > 0){
				$status = true;	
			}else{
				$status = false;	
			}
		}
		$mysqli->close();

		$return_result['update_login_id'] = $update_login_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer
	////////////////////// user part end ////////////////////////////

	/////////////////////////// START CUSTOMER PART //////////////////////////////////	
	//Save Customer function
	if($fn == 'saveCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$customer_name = $_POST["customer_name"];
		$phone_number = $_POST["phone_number"];
		$customer_gstin_no = $_POST["customer_gstin_no"];
		$customer_address = $_POST["customer_address"];
		$customer_email = $_POST["customer_email"];

		$status = true;	

		if ($customer_id > 0) {
			//update
			$sql_update = "UPDATE customer_master SET customer_name = '".$customer_name."', phone_number = '".$phone_number."', customer_address = '".$customer_address."', customer_gstin_no = '".$customer_gstin_no."', customer_email = '" .$customer_email. "' WHERE customer_id = '" .$customer_id. "' ";
			$mysqli->query($sql_update);
		} else {
			//Insert
			$sql_insert = "INSERT INTO customer_master (customer_name, phone_number, customer_address, customer_gstin_no, customer_email) VALUES('".$customer_name."', '".$phone_number."', '".$customer_address."', '".$customer_gstin_no."', '".$customer_email."')";
			$result_insert = $mysqli->query($sql_insert);
			$customer_id = $mysqli->insert_id;
		}
		$mysqli->close();

		$return_result['customer_id'] = $customer_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer
	
	//Get User
	if($fn == 'getUser'){
		$return_result = array();
		$login_id = $_POST["login_id"];
		$status = false;	
	
		$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;	
			$row = $result->fetch_array();
			$user_data1 = $row['user_data'];
			$user_data = json_decode($user_data1);
			$return_result['user_data'] = $user_data;
			
			$user_type = $row['user_type'];
			$return_result['user_type'] = $user_type;
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function get User
	
	//Get User All start
	if($fn == 'getUserAll'){
		$return_result = array();
		
		$fetchUserType = $_POST["fetchUserType"];
		$login_id = $_POST["login_id"];
		$user_type = $_POST["logged_in_user_type"];
		$created_by = $_POST["created_by"];
		
		$status = false;	
		$users = array();	
		$zones = array();
	
		if($user_type == '0'){
			$sql = "SELECT * FROM login WHERE user_type = '" .$fetchUserType. "' ORDER BY login_id DESC";

			$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
			$zone_result = $mysqli->query($zone_sql);

		}else if($user_type == '5'){	
			//$sql = "SELECT * FROM login WHERE user_type = '".$fetchUserType."' AND salesman_id = '".$login_id."' ORDER BY login_id DESC";	
			$get_sql = "SELECT * FROM login WHERE login_id = '" .$created_by. "'";
			$get_sql_result = $mysqli->query($get_sql);
			$get_sql_row = $get_sql_result->fetch_array();
			$user_type_temp = $get_sql_row['user_type'];
			$login_id_temp = $get_sql_row['login_id'];

			if($user_type_temp == '0'){
				$next_user_type1 = $user_type_temp;
				$salesman_type = 0;
			}else{
				$next_user_type1 = $user_type_temp + 1;
				$salesman_type = $user_type_temp;
			}

			$sql = "SELECT * FROM login WHERE user_type = '".$fetchUserType."' AND created_by = '".$login_id_temp."' ORDER BY login_id DESC";

			$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$created_by. "' ORDER BY zone_id DESC";	
			$zone_result = $mysqli->query($zone_sql);
			
		}else{
			$sql = "SELECT * FROM login WHERE user_type = '".$fetchUserType."' AND created_by = '".$login_id."' ORDER BY login_id DESC";

			$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
			$zone_result = $mysqli->query($zone_sql);
		}

		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$status = true;	
			while($row = $result->fetch_array()){
				$user_data1 = $row['user_data'];
				$user_data = json_decode($user_data1);				
				$user_type = $row['user_type'];				
				$login_id  = $row['login_id'];			
				$net_due_amount  = $row['net_due_amount'];		
				$zone_id  = $row['zone_id'];
				
				$user = new stdClass();
				$user->login_id = $login_id;
				$user->user_data = $user_data;
				$user->user_type = $user_type;
				$user->net_due_amount = $net_due_amount;
				$user->zone_id = $zone_id;

				array_push($users, $user);
			}//end while
		}//end if

		//Zone List
		while ($zone_row = $zone_result->fetch_array()){ 				
			$zone_id = $zone_row['zone_id'];				
			$zone_name  = $zone_row['zone_name'];	

			$zone = new stdClass();
			$zone->zone_id = $zone_id;
			$zone->zone_name = $zone_name;
			array_push($zones, $zone);
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		$return_result['users'] = $users;
		$return_result['zones'] = $zones;
		//sleep(1);
		echo json_encode($return_result);
	}//end 
	//function get User all end

	//Delete User function
	if($fn == 'deleteUser'){
		$return_result = array();
		$login_id = $_POST["login_id"];
		$status = true;	
		$sql = "DELETE FROM login WHERE login_id = '".$login_id."'";
		$result = $mysqli->query($sql);
		/*$sql = "SELECT * FROM login WHERE parent_id = '".$login_id."'";
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			$status = false;	
		}else{
			$status = true;	
			$sql = "DELETE FROM login WHERE login_id = '".$login_id."'";
			$result = $mysqli->query($sql);
		}*/
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function delete User
	
	//Get Customer
	if($fn == 'getCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "SELECT * FROM customer_master WHERE customer_id = '".$customer_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$return_result['customer_id'] = $row['customer_id'];
			$return_result['customer_name'] = $row['customer_name'];
			$return_result['phone_number'] = $row['phone_number'];
			$return_result['customer_address'] = $row['customer_address'];
			$return_result['customer_gstin_no'] = $row['customer_gstin_no'];
			$return_result['customer_email'] = $row['customer_email'];
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getCustomer

	//Delete Item function
	if($fn == 'deleteCustomer'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "DELETE FROM customer_master WHERE customer_id = '".$customer_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function deleteCustomer

	//miniStatement start
	if($fn == 'miniStatement'){
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$status = true;	
	
		$sql = "SELECT * FROM bill_details WHERE customer_id = '".$customer_id."' ORDER BY create_date DESC LIMIT 3
		";
		$result = $mysqli->query($sql);

		$i = 0;

		if ($result->num_rows > 0) {
			$subTotalfineItemsTotalSubTotal = 0;
			$subTotaljamaItemsSubTotal = 0;
			$subTotalnetMetalBalance = 0;
			$subTotaltotalCash = 0; 

			$miniStatement = array();

			while ($row_bill = $result->fetch_array()){ 
				$miniStatementObj = new stdClass();
				$i++;
				$bill_id = $row_bill['bill_id'];
				$bill_description = json_decode(base64_decode($row_bill['bill_description']));
				
				$miniStatementObj->i = $i;
				$miniStatementObj->billId = $bill_description->billId;
				$miniStatementObj->fineItemsTotalSubTotal = $bill_description->fineItemsTotalSubTotal;
				$miniStatementObj->jamaItemsSubTotal = $bill_description->jamaItemsSubTotal;
				$miniStatementObj->netMetalBalance = $bill_description->netMetalBalance;
				$miniStatementObj->netMetalBalance = $bill_description->netMetalBalance;
				$miniStatementObj->totalCash = $bill_description->totalCash;
				$miniStatementObj->create_date = date('d-m-Y', strtotime($row_bill['create_date']));

				array_push($miniStatement, $miniStatementObj);

				$subTotalfineItemsTotalSubTotal = ($subTotalfineItemsTotalSubTotal + $bill_description->fineItemsTotalSubTotal);
				$subTotaljamaItemsSubTotal = ($subTotaljamaItemsSubTotal + $bill_description->jamaItemsSubTotal);
				$subTotalnetMetalBalance = ($subTotalnetMetalBalance + $bill_description->netMetalBalance);
				$subTotaltotalCash = ($subTotaltotalCash + $bill_description->totalCash);
			}//end while
			$return_result['miniStatement'] = $miniStatement;

			$return_result['subTotalfineItemsTotalSubTotal'] = round($subTotalfineItemsTotalSubTotal, 2);
			$return_result['subTotaljamaItemsSubTotal'] = round($subTotaljamaItemsSubTotal, 2);
			$return_result['subTotalnetMetalBalance'] = round($subTotalnetMetalBalance, 2);
			$return_result['subTotaltotalCash'] = round($subTotaltotalCash, 2);
		}//end if
		
		$mysqli->close();
		$return_result['i'] = $i;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getCustomer

	//////////////////////////////////// END CUSTOMER PART //////////////////////////////////////////

	/////////////////////////////////// START BILL PART ////////////////////////////////////////////
	
	if($fn == 'getCustomerList'){
		$user_type = $_POST["user_type"];
		$login_id = $_POST["login_id"];
		$created_by = $_POST["created_by"];

		$return_result = array();
		$status = true;	
		$customers = array();
		
		$salesman_type = 5;	
		if($user_type == '5'){
			$get_sql = "SELECT * FROM login WHERE login_id = '" .$created_by. "'";
			$get_sql_result = $mysqli->query($get_sql);
			$get_sql_row = $get_sql_result->fetch_array();
			$user_type_temp = $get_sql_row['user_type'];
			$login_id_temp = $get_sql_row['login_id'];

			if($user_type_temp == '0'){
				$next_user_type1 = $user_type_temp;
				$salesman_type = 0;
			}else{
				$next_user_type1 = $user_type_temp + 1;
				$salesman_type = $user_type_temp;
			}

			$sql = "SELECT * FROM login WHERE created_by = '".$login_id_temp."' ORDER BY login_id DESC";	
			$result = $mysqli->query($sql);
		}else{
			$sql = "SELECT * FROM login WHERE created_by = '".$login_id."' ORDER BY login_id DESC";	
			$result = $mysqli->query($sql);
		}
		while($row_customer = $result->fetch_array()){
			$b_login_id = $row_customer['login_id'];
			$b_username = $row_customer['username'];
			$b_password = $row_customer['password'];
			$b_user_type = $row_customer['user_type'];
			$b_user_data1 = $row_customer['user_data'];			
			$b_stock_quantity1 = $row_customer['stock_quantity'];
			$b_user_data = json_decode($b_user_data1);
			$b_stock_quantity = json_decode($b_stock_quantity1);		
			$net_due_amount = $row_customer['net_due_amount'];
			
			$customer_obj = new stdClass();

			$customer_obj->b_login_id = $b_login_id;
			$customer_obj->b_username = $b_username;
			$customer_obj->b_password = $b_password;
			$customer_obj->b_user_type = $b_user_type;
			$customer_obj->b_user_data = $b_user_data;
			$customer_obj->b_stock_quantity = $b_stock_quantity;
			$customer_obj->net_due_amount = $net_due_amount;

			if($b_user_type > 0 && $b_user_type  < 5){
				array_push($customers, $customer_obj);
			}
		}//end while

		$return_result['customers'] = $customers;
		$return_result['status'] = $status;

		echo json_encode($return_result);
	}//end function getCustomerList

	//Populate Item List
	if($fn == 'populateItemList'){
		$b_user_type = $_POST["b_user_type"];	
		$login_id = $_POST["login_id"];
		$user_type = $_POST["user_type"];
		$created_by = $_POST["created_by"];

		$return_result = array();
		$status = true;	
		$items = array();

		if($b_user_type == '1'){
			$rate_type_txt = 'stokist_price';
		}else if($b_user_type == '2'){
			$rate_type_txt = 'dealer_price';
		}else if($b_user_type == '3'){
			$rate_type_txt = 'wholesaler_price';
		}else if($b_user_type == '4'){
			$rate_type_txt = 'retailer_price';
		}else{
			$rate_type_txt = '';
		}

		//Update user's stock quantity start
		if($user_type == '5'){
			$sql = "SELECT * FROM login WHERE login_id = '".$created_by."'";
		}else{
			$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";
		}
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$stock_quantity1 = $row['stock_quantity'];
			$stock_quantity1 = $row['stock_quantity'];

			$user_type = $row['user_type'];
			if($stock_quantity1 != ''){
				$stock_quantity = json_decode($stock_quantity1);
			}//end if
		}//end if
		
		$sql2 = "SELECT * FROM item_master ORDER BY item_name ASC";	
		$result2 = $mysqli->query($sql2);
		while($row = $result2->fetch_array()){
			$item_obj = new stdClass();
			$item_id  = $row['item_id'];
			$item_quantity = 0;

			$item_obj->item_id  = $row['item_id'];
			$item_obj->item_name = $row['item_name'];
			$item_obj->hs_code = $row['hs_code'];
			$item_obj->cgst_rate = $row['cgst_rate'];
			$item_obj->sgst_rate = $row['sgst_rate'];
			$item_obj->net_weight = $row['net_weight'];

			if($rate_type_txt != ''){
				$item_obj->item_rate = $row[$rate_type_txt];
			}else{
				$item_obj->item_rate = 0;
			}

			for($i = 0; $i < sizeof($stock_quantity); $i++){
				if($stock_quantity[$i]->item_id == $item_id){
					$item_quantity = $stock_quantity[$i]->item_quantity;
					break;
				}
			}//end for
			$item_obj->item_quantity = $item_quantity;

			if($item_quantity > 0){
				array_push($items, $item_obj);
			}
		}//end while
		$return_result['items'] = $items;
		$return_result['status'] = $status;

		echo json_encode($return_result);
	}//end function populateItemList


	//Save Bill function
	if($fn == 'saveBill'){
	    date_default_timezone_set("Asia/Calcutta");
		$return_result = array();
		$customer_id = $_POST["customer_id"];
		$bill_description = $_POST["bill_description"];
		$bill_description1 = json_decode($bill_description);
		$bill_id = $_POST["bill_id"];
		$final_bill = $_POST["final_bill"];
		$bill_edit = $_POST["bill_edit"];
		$paymentType = $_POST["paymentType"];

		$user_type = $_POST["user_type"];
		$login_id = $_POST["login_id"];
		$created_by = $_POST["created_by"];
		if($_POST["old_due_amount"] > 0){
			$old_due_amount = $_POST["old_due_amount"];		
		}else{
			$old_due_amount = 0;
		}

		$totalCash = $_POST["totalCash"];
		$hidden_totalCash = $_POST["hidden_totalCash"];

		$receive_payment = 0;
		$cb_amount = 0;
		$cb_narration = '';
		$create_date = date('Y-m-d H:i:s');
		

		$status = true;	

		if ($bill_id > 0) {
			//update
			$sql_update = "UPDATE bill_details SET bill_description = '".base64_encode($bill_description)."' WHERE bill_id = '" .$bill_id. "' ";
			$mysqli->query($sql_update);
			$current_bill_id = $bill_id;
		} else {
			//Insert
			if($user_type == '5'){
				$sql_insert = "INSERT INTO bill_details (customer_id, bill_description, created_by, salesman_id, create_date) VALUES('".$customer_id."', '".base64_encode($bill_description)."', '".$created_by."', '" .$login_id. "', '" .$create_date. "')";
			}else{
				$salesman_id = 0;
				$sql_insert = "INSERT INTO bill_details (customer_id, bill_description, created_by, salesman_id, create_date) VALUES('".$customer_id."', '".base64_encode($bill_description)."', '".$login_id."', '" .$salesman_id. "', '" .$create_date. "')";
			}
			$result_insert = $mysqli->query($sql_insert);
			$current_bill_id = $mysqli->insert_id;
		}

		//For the New Bill creation
		if($bill_edit == 0 && $final_bill == 1){
			$fineItems = $bill_description1->fineItems;
			
			//Update user's stock quantity start
			$sql = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();
				$stock_quantity1 = $row['stock_quantity'];				
				$stock_quantity = json_decode($stock_quantity1);
				$stock_quantity_new = array();
				if(sizeof($stock_quantity) > 0){
					//stock update
					for($i = 0; $i < sizeof($fineItems); $i++){
						$old_qty = 0;
						for($j = 0; $j < sizeof($stock_quantity); $j++){
							if($fineItems[$i]->item_id == $stock_quantity[$j]->item_id){
								$old_qty = $stock_quantity[$j]->item_quantity;				
							}
						}//end for
						
						$stockObj = new stdClass();
						$stockObj->hs_code = $fineItems[$i]->hs_code;
						$stockObj->item_quantity = $fineItems[$i]->qty + $old_qty;
						$stockObj->item_id = $fineItems[$i]->item_id;
						array_push($stock_quantity_new, $stockObj);
					}//end outer for
				}else{
					//stock insert
					$stock_quantity_new = array();
					for($i = 0; $i < sizeof($fineItems); $i++){						
						$stockObj = new stdClass();
						$stockObj->hs_code = $fineItems[$i]->hs_code;
						$stockObj->item_quantity = $fineItems[$i]->qty;
						$stockObj->item_id = $fineItems[$i]->item_id;
						array_push($stock_quantity_new, $stockObj);
					}//end outer for
				}
				$stock_quantity_new1 = json_encode($stock_quantity_new);

				$update_sql = "UPDATE login SET stock_quantity = '" .$stock_quantity_new1. "' WHERE login_id = '".$customer_id."'";
				$mysqli->query($update_sql);
			}
			//Update user's stock quantity end			
		}//en if

		if($final_bill == 1){
			$latest_due = 0;
			$sql = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
			$result = $mysqli->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_array();
				$net_due_amount = $row['net_due_amount'];
			}

			if($bill_id > 0){				
				$latest_due = $net_due_amount - $old_due_amount + $bill_description1->dueCash;
			}else{
				$latest_due = $net_due_amount + $bill_description1->dueCash;
			}
			$update_sql1 = "UPDATE login SET net_due_amount = '" .$latest_due. "' WHERE login_id = '".$customer_id."'";
			$mysqli->query($update_sql1);

			//Save for cashbook table
			if($user_type == '5'){
				$cb_created_by = $created_by;
			}else{
				$cb_created_by = $login_id;
			}			
			$cb_date = date('Y-m-d H:i:s');				
			if($totalCash > $hidden_totalCash){
				$cb_amount = $totalCash - $hidden_totalCash;
				$receive_payment = 0;
				$cb_narration = 'Cash Received by Bill: '.$bill_id;
			}
			if($hidden_totalCash > $totalCash){
				$cb_amount = $hidden_totalCash - $totalCash;
				$receive_payment = 1;
				$cb_narration = 'Sale Return by Bill: '.$bill_id;
			}
			if($cb_amount > 0){
				$sql_insert = "INSERT INTO cashbook_entry (receive_payment, bill_id, cb_narration, cb_amount, cb_date, cb_created_by) VALUES('".$receive_payment."', '".$bill_id."', '".$cb_narration."', '".$cb_amount."', '".$cb_date."', '".$cb_created_by."')";
				$result_insert = $mysqli->query($sql_insert);
			}
			//Save for cashbook table end
		}//end if

		$mysqli->close();
		$create_date = date('d-M-Y H:i');
		$return_result['current_bill_id'] = $current_bill_id;
		$return_result['create_date'] = $create_date;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer

	//Delete Bill function
	if($fn == 'deleteBill'){
		$return_result = array();
		$bill_id = $_POST["bill_id"];
		$user_type = $_POST["user_type"];
		$login_id = $_POST["login_id"];
		$created_by = $_POST["created_by"];

		$status = true;	

		//Update stock quantity
		$sql = "SELECT * FROM bill_details WHERE bill_id = '".$bill_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$customer_id = $row['customer_id'];
			$bill_description = json_decode(base64_decode($row['bill_description']));

			//Update Due Amount of this customer
			$dueCash = $bill_description->dueCash;
			$roundedUpFineItemsSubTotal = $bill_description->roundedUpFineItemsSubTotal;

			if($dueCash == $roundedUpFineItemsSubTotal){
				$status = true;	
				$latest_due = 0;
				$sql = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
				$result = $mysqli->query($sql);

				if ($result->num_rows > 0) {
					$row = $result->fetch_array();
					$net_due_amount = $row['net_due_amount'];
				}

				$latest_due = $net_due_amount - $dueCash;
				$update_sql1 = "UPDATE login SET net_due_amount = '" .$latest_due. "' WHERE login_id = '".$customer_id."'";
				$mysqli->query($update_sql1);
			}else{
				$status = false;	
			}//end if
			//end due amount update

			if($status == true){
				$items = $bill_description->fineItems;
				$item_id = 0;
				$qty = 0;
				for($i = 0; $i < sizeof($items); $i++){
					$item_id = $items[$i]->item_id;
					$qty = $items[$i]->qty;
									
					//Deduct Item quantity from the customer start				
					$sql_byr = "SELECT * FROM login WHERE login_id = '".$customer_id."'";	
					$result_byr = $mysqli->query($sql_byr);
					$row_byr = $result_byr->fetch_array();
					$byr_stock_quantity1 = $row_byr['stock_quantity'];
					$byr_stock_quantity = json_decode($byr_stock_quantity1);
					
					for($j = 0; $j < sizeof($byr_stock_quantity); $j++){
						if($byr_stock_quantity[$j]->item_id == $item_id){
							$old_item_quantity_byr = $byr_stock_quantity[$j]->item_quantity;
							$now_item_quantity_byr = $old_item_quantity_byr - $qty;
							$byr_stock_quantity[$j]->item_quantity = $now_item_quantity_byr;
							break;
						}
					}//end for
				
					$byr_stock_quantity_temp = json_encode($byr_stock_quantity);
					
					$sql_update = "UPDATE login SET  stock_quantity = '".$byr_stock_quantity_temp."' WHERE login_id = '".$customer_id."'";
					
					$mysqli->query($sql_update);
					//Deduct Item quantity from the customer end

					//Add Item quantity to the saler start
					if($user_type == '5'){
						$sql = "SELECT * FROM login WHERE created_by = '".$created_by."'";	
						$result = $mysqli->query($sql);
					}else{
						$sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
						$result = $mysqli->query($sql);
					}
					$row_customer = $result->fetch_array();
					$b_stock_quantity1 = $row_customer['stock_quantity'];
					$b_stock_quantity = json_decode($b_stock_quantity1);
					
					for($k = 0; $k < sizeof($b_stock_quantity); $k++){
						if($b_stock_quantity[$k]->item_id == $item_id){
							$old_item_quantity = $b_stock_quantity[$k]->item_quantity;
							$now_item_quantity = $old_item_quantity + $qty;
							$b_stock_quantity[$k]->item_quantity = $now_item_quantity;
							break;
						}
					}//end for
					
					$stock_quantity_temp = json_encode($b_stock_quantity);
					if($user_type == '5'){
						$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE created_by = '".$created_by."'";
					}else{
						$sql_update = "UPDATE login SET  stock_quantity = '".$stock_quantity_temp."' WHERE login_id = '".$login_id."'";
					}
					$mysqli->query($sql_update);
					//Add Item quantity to the saler end

					$sql = "SELECT * FROM item_master WHERE item_id = '".$item_id."'";
					$result = $mysqli->query($sql);

					if ($result->num_rows > 0) {
						$row = $result->fetch_array();
						$item_quantity = $row['item_quantity'];
					}
					//$sql_update = "UPDATE item_master SET  item_quantity = '".$now_stock."' WHERE item_id = '" .$item_id. "' ";
					//$mysqli->query($sql_update);

				}//end for
			}//end if
		}//end if

		//Delete Original Bill
		if($status == true){
			$sql = "DELETE FROM bill_details WHERE bill_id = '".$bill_id."'";
			$result = $mysqli->query($sql);
		}//end if

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function deleteBill
	
	//Get getBillDetails
	if($fn == 'getBillDetails'){
		$return_result = array();
		$bill_id = $_POST["bill_id"];
		$status = true;	
	
		$sql = "SELECT * FROM bill_details WHERE bill_id = '".$bill_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$customer_id = $row['customer_id'];
			$bill_description = json_decode(base64_decode($row['bill_description']));
		}

		//Last due 
		$net_due_amount = 0;
		if($customer_id > 0){
			$sql1 = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
			$result1 = $mysqli->query($sql1);

			if ($result1->num_rows > 0) {
				$row1 = $result1->fetch_array();
				$net_due_amount = $row1['net_due_amount'];
			}
		}//end

		//Get Payment History	
		$payHistory = array();
		$sqlPay = "SELECT * FROM cashbook_entry WHERE bill_id = '".$bill_id."'";
		$resultPay = $mysqli->query($sqlPay);

		if ($resultPay->num_rows > 0) {
			while($rowPay = $resultPay->fetch_array()){
				$payHistoryObj = new stdClass();
				$payHistoryObj->cb_amount = $rowPay['cb_amount'];
				$payHistoryObj->cb_date = $rowPay['cb_date'];
				$payHistoryObj->cb_note = $rowPay['cb_note'];
				$payHistoryObj->cb_formated_date = date('d-F-Y h:i A', strtotime($rowPay['cb_date']));
				array_push($payHistory, $payHistoryObj);
			}
		}

		if($bill_description == null){
			$status = false;
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		$return_result['customer_id'] = $customer_id;
		$return_result['bill_description'] = $bill_description;
		$return_result['net_due_amount'] = $net_due_amount;
		$return_result['payHistory'] = $payHistory;
		//sleep(1);
		echo json_encode($return_result);
	}//end function getBillDetails

	/////////////////////////////////// END BILL PART ////////////////////////////////////////////

	/////////////////////////// START CASHBOOK PART //////////////////////////////////	
	//Save Customer function
	if($fn == 'saveCashbook'){
		$return_result = array();
		$login_id = $_POST['login_id'];
		$user_type = $_POST['user_type'];
		$created_by = $_POST['created_by'];

		$cb_date = $_POST['cb_date'].' '.date('H:i:s');
		$receive_payment = $_POST['receive_payment'];
		$cb_narration = $_POST['cb_narration'];
		$cb_amount = $_POST['cb_amount'];
		$cb_id = $_POST['cb_id'];

		if($user_type == 5){
			$cb_created_by = $created_by;
		}else{
			$cb_created_by = $login_id;
		}

		$status = true;	

		if ($cb_id > 0) {
			//update
			$sql_update = "UPDATE cashbook_entry SET receive_payment = '".$receive_payment."', cb_narration = '".$cb_narration."', cb_amount = '".$cb_amount."', cb_date = '".$cb_date."', cb_created_by = '" .$cb_created_by. "' WHERE cb_id = '" .$cb_id. "' ";
			$mysqli->query($sql_update);
		} else {
			//Insert
			$sql_insert = "INSERT INTO cashbook_entry (receive_payment, cb_narration, cb_amount, cb_date, cb_created_by) VALUES('".$receive_payment."', '".$cb_narration."', '".$cb_amount."', '".$cb_date."', '".$cb_created_by."')";
			$result_insert = $mysqli->query($sql_insert);
			$cb_id = $mysqli->insert_id;
		}
		$mysqli->close();

		$return_result['cb_id'] = $cb_id;
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function saveCustomer
	
	//Get CashBook
	if($fn == 'getCashBook'){
		$return_result = array();
		$cb_id = $_POST["cb_id"];
		$status = true;	
	
		$sql = "SELECT * FROM cashbook_entry WHERE cb_id = '".$cb_id."'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$return_result['receive_payment'] = $row['receive_payment'];
			$return_result['cb_narration'] = $row['cb_narration'];
			$return_result['cb_amount'] = $row['cb_amount'];
			$return_result['cb_date'] = $row['cb_date'];
		}
		
		$mysqli->close();
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function 	
	
	//Get Attendance
	if($fn == 'getUserAttendance'){
		$return_result = array();
		$month_name = $_POST["month_name"];
		$emp_id = $_POST["emp_id"];
		$emp_basic_pay = $_POST["emp_basic_pay"];
		$status = true;	
		$total_attendance = 0;
		$absent_count = 0;
		$half_day_count = 0;
		$full_day_count = 0;
		$effectiveBasicPay = 0;
		$onedaypay = 0;
		$one_hour_pay = 0;
		$overtime_amount = 0;
		$effective_working_days = 0;
		$holi_days = 0;
		$overtime_arr = array();
		$late_arr = array();
	
		if($month_name < 10){
			$present_date_start = date('Y').'-0'.$month_name.'-01';
			$present_date_end = date('Y').'-0'.$month_name.'-31';
		}else{
			$present_date_start = date('Y').'-'.$month_name.'-01';
			$present_date_end = date('Y').'-'.$month_name.'-31';
		}

		$sql = "SELECT * FROM employee_attendance WHERE emp_id = '".$emp_id."' AND present_date >= '".$present_date_start."' AND  present_date <= '" .$present_date_end. "'";
		$result = $mysqli->query($sql);

		if ($result->num_rows > 0) {
			//$total_attendance = $result->num_rows;
			while($row = $result->fetch_array()){
				$present_status = $row['present_status'];
				$half_day = $row['half_day'];
				$full_day = $row['full_day'];
				$late_hours = $row['late_hours'];
				$overtime_hours = $row['overtime_hours']; 

				if($present_status == 1){
					$total_attendance++;
				}else{
					$absent_count++;
				}//end if

				if($half_day == 1){
					$half_day_count++;
				}

				if($full_day == 1){
					$full_day_count++;
				}

				if($overtime_hours > 0){
					array_push($overtime_arr, $overtime_hours);
				}

				if($late_hours > 0){
					array_push($late_arr, $late_hours);
				}
			}//end while
		}//end if

		//OT Calculation Start
		$total_ot_hr = 0;
		$total_ot_min = 0;
		$ot_min_to_hr = 0;
		$ot_min_to_min = 0;
		if(sizeof($overtime_arr) > 0){
			foreach($overtime_arr as $key => $val){
				$overtime_arr_exp = explode(":", $val);
				$hour = $overtime_arr_exp[0];
				$min = $overtime_arr_exp[1];
				$total_ot_hr = $total_ot_hr + $hour;
				$total_ot_min = $total_ot_min + $min;
			}
		}//end if
		if($total_ot_min >= 60){
			$ot_min_to_hr =  (int) ($total_ot_min / 60);
			$ot_min_to_min = ($total_ot_min % 60);
			$total_ot_hr = $total_ot_hr + $ot_min_to_hr;
			$total_ot_min = $ot_min_to_min;
		}
		//OT Calculation End

		//LT Calculation Start
		/*$total_ot_hr = 0;
		$total_ot_min = 0;
		$ot_min_to_hr = 0;
		$ot_min_to_min = 0;
		if(sizeof($overtime_arr) > 0){
			foreach($overtime_arr as $key => $val){
				$overtime_arr_exp = explode(":", $val);
				$hour = $overtime_arr_exp[0];
				$min = $overtime_arr_exp[1];
				$total_ot_hr = $total_ot_hr + $hour;
				$total_ot_min = $total_ot_min + $min;
			}
		}//end if
		if($total_ot_min > 60){
			$ot_min_to_hr =  (int) ($total_ot_min / 60);
			$ot_min_to_min = ($total_ot_min % 60);
			$total_ot_hr = $total_ot_hr + $ot_min_to_hr;
			$total_ot_min = $ot_min_to_min;
		}*/
		//LT Calculation End

		//Working Days Calculation start
		//function getBusinessDays1($startDate, $endDate) {
		$start = new DateTime($present_date_start);
		$end = new DateTime($present_date_end);
		$businessDays = 0;
		while ($start <= $end) {
			$dayOfWeek = $start->format('N');
			if ($dayOfWeek < 7) {
				$businessDays++;
			}
			$start->add(new DateInterval('P1D'));
		}
		//return $businessDays;
		//}
		//$startDate = '2024-05-01';
		//$endDate = '2024-05-10';
		//echo "Business days: " . getBusinessDays1($startDate, $endDate);
		//Working Days Calculation end
		
		//Holiday and effective day
		$sql2 = "SELECT * FROM holiday_list WHERE holiday_date >= '".$present_date_start."' AND  holiday_date <= '" .$present_date_end. "'";
		$result2 = $mysqli->query($sql2);

		if ($result2->num_rows > 0) {
			//$total_attendance = $result->num_rows;
			while($row2 = $result2->fetch_array()){
				$h_id = $row2['h_id'];
				$holi_days++;
			}
		}//end if
		$effective_working_days = $businessDays - $holi_days;

		//Effective basic pay 
		$effectiveBasicPay = ceil(($emp_basic_pay / $effective_working_days) * $total_attendance);

		//One day pay
		$onedaypay = $emp_basic_pay / $effective_working_days;
		$one_hour_pay = $onedaypay / 8;
		$overtime_amount = ceil($one_hour_pay * $total_ot_hr);
		
		$mysqli->close();
		$return_result['status'] = $status;
		$return_result['total_attendance'] = $total_attendance;
		$return_result['absent_count'] = $absent_count;
		$return_result['half_day_count'] = $half_day_count;
		$return_result['full_day_count'] = $full_day_count;
		$return_result['total_ot_hr'] = $total_ot_hr;
		$return_result['total_ot_min'] = $total_ot_min;
		$return_result['businessDays'] = $businessDays;
		$return_result['effectiveBasicPay'] = $effectiveBasicPay;
		$return_result['overtime_amount'] = $overtime_amount;
		$return_result['effective_working_days'] = $effective_working_days;
		$return_result['holi_days'] = $holi_days;
		//sleep(1);
		echo json_encode($return_result);
	}//end function 	
	
	//Generate PaySlip
	if($fn == 'generatePaySlip'){
		$return_result = array();
		$emp_sal_id = $_POST["emp_sal_id"];
		$month_name = $_POST["month_name"];
		$pay_year = $_POST["pay_year"];
		$emp_id = $_POST["emp_id"];
		$total_allounce = $_POST["total_allounce"];
		$total_deduction = $_POST["total_deduction"];
		$net_pay = $_POST["net_pay"];
		$emp_basic_pay = $_POST["emp_basic_pay"];
		$salary_detail_data = $_POST["salary_detail_data"];

		$status = true;	
	
		if($month_name < 10){
			$for_the_month = $pay_year.'-0'.$month_name.'-01';
		}else{
			$for_the_month = $pay_year.'-'.$month_name.'-01';
		}
		
		if ($emp_sal_id > 0) {
			//Update SQL
			$sql_update = "UPDATE employee_salary SET emp_id = '" .$emp_id. "', total_allounce = '" .$total_allounce. "', total_deduction = '" .$total_deduction. "', basic_pay = '" .$emp_basic_pay. "', net_pay = '" .$net_pay. "', salary_detail_data = '" .$salary_detail_data. "', for_the_month = '" .$for_the_month. "' WHERE emp_sal_id = '".$emp_sal_id."' ";
			$result_sql_update = $mysqli->query($sql_update);	
		}else{
			//Insert SQL
			$sql_insert = "INSERT INTO employee_salary (emp_id, total_allounce, total_deduction, basic_pay, net_pay, salary_detail_data, for_the_month) VALUES ('" .$emp_id. "', '" .$total_allounce. "', '" .$total_deduction. "', '" .$emp_basic_pay. "', '" .$net_pay. "', '" .$salary_detail_data. "', '" .$for_the_month. "')";
			$result_sql_insert = $mysqli->query($sql_insert);			
			$emp_sal_id = $mysqli->insert_id;
		}

		$mysqli->close();
		$return_result['status'] = $status;
		$return_result['emp_sal_id'] = $emp_sal_id;
		//sleep(1);
		echo json_encode($return_result);
	}//end function 

	//Edit PaySlip
	if($fn == 'getPaySlip'){
		$return_result = array();
		$emp_sal_id = $_POST["emp_sal_id"];
		$status = true;	
	
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

		$month_name1 = date('m', strtotime($for_the_month));
		$return_result['month_name'] = (int) $month_name1;
		$return_result['emp_id'] = $emp_id;
		$return_result['total_allounce'] = $total_allounce;
		$return_result['total_deduction'] = $total_deduction;
		$return_result['basic_pay'] = $basic_pay;
		$return_result['net_pay'] = $net_pay;
		$return_result['salary_detail_data'] = $salary_detail_data;	

		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function 

	//Delete PaySlip function
	if($fn == 'deletePaySlip'){
		$return_result = array();
		$emp_sal_id = $_POST["emp_sal_id"];
		$status = true;	

		$sql = "DELETE FROM employee_salary WHERE emp_sal_id = '".$emp_sal_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end 

	//Delete Item function
	if($fn == 'deleteCashbook'){
		$return_result = array();
		$cb_id = $_POST["cb_id"];
		$status = true;	
	
		$sql = "DELETE FROM cashbook_entry WHERE cb_id = '".$cb_id."'";
		$result = $mysqli->query($sql);
		$return_result['status'] = $status;
		//sleep(1);
		echo json_encode($return_result);
	}//end function  
	/////////////////////////// END CASHBOOK PART //////////////////////////////////

	//Receive payment Function start
	if($fn == 'updatepaymentInfo'){
		$return_result = array();
		$billNumber = $_POST["billNumber"];
		$collectionAmount = $_POST["collectionAmount"];
		$collectionDate = $_POST["collectionDate"];
		$collectionNote = $_POST["collectionNote"];
		$customer_id = $_POST["customer_id"];
		$status = true;
		$latest_due = 0;
		$net_due_amount = 0;
		$bill_description_en = '';

		//Update Login table
		$sql = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$net_due_amount = $row['net_due_amount'];
		}
		$latest_due = $net_due_amount - $collectionAmount;
		$update_sql1 = "UPDATE login SET net_due_amount = '" .$latest_due. "' WHERE login_id = '".$customer_id."'";
		$mysqli->query($update_sql1);

		//Update Bill Details
		$sql1 = "SELECT * FROM bill_details WHERE bill_id = '".$billNumber."'";
		$result1 = $mysqli->query($sql1);

		if ($result1->num_rows > 0) {
			$row1 = $result1->fetch_array();
			$bill_description = json_decode(base64_decode($row1['bill_description']));

			//Update Due Amount of this customer
			$roundedUpFineItemsSubTotal = $bill_description->roundedUpFineItemsSubTotal;
			$totalCash = $bill_description->totalCash;
			$dueCash = $bill_description->dueCash;

			//calculate new
			$totalCash = $totalCash + $collectionAmount;
			$dueCash = $roundedUpFineItemsSubTotal - $totalCash;

			//update new 
			$bill_description->totalCash = $totalCash;
			$bill_description->dueCash = $dueCash;
		}

		$bill_description_en = json_encode($bill_description);
		$sql_update = "UPDATE bill_details SET bill_description = '".base64_encode($bill_description_en)."' WHERE bill_id = '" .$billNumber. "' ";
		$mysqli->query($sql_update);

		//Insert into Cashbook
		$receive_payment = 0;
		$cb_narration = 'Cash Received by Bill: '.$billNumber;
		$cb_date = $collectionDate.' '.date('H:i:s');
		$login_id = $_SESSION["login_id"]; 
		$sql_insert = "INSERT INTO cashbook_entry (receive_payment, bill_id, cb_narration, cb_note, cb_amount, cb_date, cb_created_by) VALUES('".$receive_payment."', '".$billNumber."', '".$cb_narration."', '".$collectionNote."', '".$collectionAmount."', '".$cb_date."', '".$login_id."')";
		$result_insert = $mysqli->query($sql_insert);

		$return_result['status'] = $status;
		echo json_encode($return_result);
	}//Receive payment Function end	

	//Return Product Amount start
	if($fn == 'returnProductAmount'){
		$return_result = array();
		$billNumber = $_POST["billNumber"];
		$returnAmount = $_POST["returnAmount"];
		$returnDate = $_POST["returnDate"];
		$returnNote = $_POST["returnNote"];
		$customer_id = $_POST["customer_id"];
		$status = true;
		$latest_due = 0;
		$net_due_amount = 0;
		$bill_description_en = '';

		//Update Login table
		$sql = "SELECT * FROM login WHERE login_id = '".$customer_id."'";
		$result = $mysqli->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			$net_due_amount = $row['net_due_amount'];
		}
		$latest_due = $net_due_amount - $returnAmount;
		$update_sql1 = "UPDATE login SET net_due_amount = '" .$latest_due. "' WHERE login_id = '".$customer_id."'";
		$mysqli->query($update_sql1);

		//Update Bill Details
		$sql1 = "SELECT * FROM bill_details WHERE bill_id = '".$billNumber."'";
		$result1 = $mysqli->query($sql1);

		if ($result1->num_rows > 0) {
			$row1 = $result1->fetch_array();
			$bill_description = json_decode(base64_decode($row1['bill_description']));

			//Update Due Amount of this customer
			$roundedUpFineItemsSubTotal = $bill_description->roundedUpFineItemsSubTotal;
			$totalCash = $bill_description->totalCash;
			$dueCash = $bill_description->dueCash;

			//calculate new
			$totalCash = $totalCash + $returnAmount;
			$dueCash = $roundedUpFineItemsSubTotal - $totalCash;

			//update new 
			$bill_description->totalCash = $totalCash;
			$bill_description->dueCash = $dueCash;
		}

		$bill_description_en = json_encode($bill_description);
		$sql_update = "UPDATE bill_details SET bill_description = '".base64_encode($bill_description_en)."' WHERE bill_id = '" .$billNumber. "' ";
		$mysqli->query($sql_update);

		//Insert into Cashbook
		$receive_payment = 1;
		$cb_narration = 'Cash Return by Bill: '.$billNumber;
		$cb_date = $returnDate.' '.date('H:i:s');
		$login_id = $_SESSION["login_id"]; 
		$sql_insert = "INSERT INTO cashbook_entry (receive_payment, bill_id, cb_narration, cb_note, cb_amount, cb_date, cb_created_by) VALUES('".$receive_payment."', '".$billNumber."', '".$cb_narration."', '".$returnNote."', '".$returnAmount."', '".$cb_date."', '".$login_id."')";
		$result_insert = $mysqli->query($sql_insert);

		$return_result['status'] = $status;
		echo json_encode($return_result);
	}//Receive payment Function end	
	
	?>