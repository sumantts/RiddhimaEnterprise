<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	
	//Fetch customer start
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];
	$salesman_type = 5;

	$sql_customer = "SELECT * FROM customer_master ORDER BY customer_name ASC";	
	$result_customer = $mysqli->query($sql_customer);

	$sql_item = "SELECT * FROM item_master WHERE item_quantity > 0 ORDER BY item_name ASC";	
	$result_item = $mysqli->query($sql_item);

	if(isset($_POST["from_date"])){
		$from_date = $_POST["from_date"];
		$to_date = $_POST["to_date"];
		$search_cu_id = 0;//$_POST["search_cu_id"];
		$user_type = $_POST["ser_user_type"];
		$created_by = $_POST["ser_created_by"];
		$login_id = $_POST["ser_login_id"];
		$search_zone_id = $_POST["search_zone_id"];

		if($user_type == '5'){		
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";		
		}else{
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";	
		}
	
		$result_bill = $mysqli->query($sql_bill);
	}else{
		
		$from_date = date('d-m-Y');
		$to_date = date('d-m-Y');
		$search_zone_id = 0;
		
	}
	
	if($user_type == '5'){
		$sql = "SELECT * FROM login WHERE created_by = '".$created_by."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);
	}else{
		$sql = "SELECT * FROM login WHERE created_by = '".$login_id."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);
	}
	//Fetch customer end

	//Fetch created by users details
	if($user_type == '5'){
		$sql_cb = "SELECT * FROM login WHERE login_id = '".$created_by."'";	
	}else{
		$sql_cb = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
	}
	$result_cb = $mysqli->query($sql_cb);
	$row_cb = $result_cb->fetch_array();
	$cb_user_data1 = $row_cb['user_data'];
	$cb_user_data = json_decode($cb_user_data1);


?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Reports</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
							<!-- Search Panel -->
							<div class="col-lg-12">
							<form action="?p=product_report" method="POST" name="form_search">
								<div class="form-row">
									<div class="form-group col-md-3">
									<label for="inputCity">From Date(dd-mm-YYYY) </label>
									<input type="date" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-d', strtotime($from_date))?>">
									</div>

									<div class="form-group col-md-3">
									<label for="inputCity">To Date(dd-mm-YYYY)</label>
									<input type="date" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime($to_date))?>">
									</div>
									

									<div class="form-group col-md-3">
									<label for="inputState">Zone</label>
									<select id="search_zone_id" class="form-control" name="search_zone_id">
										<option value="0"> Select Zone </option>
										<?php
										$sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
										$result = $mysqli->query($sql);
										while ($row = $result->fetch_array()){  
										?>
										<option value="<?=$row['zone_id']?>" <?php if($row['zone_id'] == $search_zone_id){?> selected <?php } ?> ><?=$row['zone_name']?></option>
										<?php } ?>
									</select>
									</div>
									

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>	
									<input type="hidden" name="ser_user_type" id="ser_user_type" value="<?=$user_type?>">	
									<input type="hidden" name="ser_created_by" id="ser_created_by" value="<?=$created_by?>">	
									<input type="hidden" name="ser_login_id" id="ser_login_id" value="<?=$login_id?>">						
									<button type="submit" class="btn btn-primary" name="search_btn">Search</button>	
									<?php if(isset($_POST['search_btn']) && mysqli_num_rows($result_bill) > 0){ ?>				
									<button type="button" onClick="printProductReport()" class="btn btn-primary" name="Print_btn">Print</button>
									<?php } ?>
									</div>
								</div>
								</form>
							</div>
							<!-- Search Panel end -->
                             
                        </div>
                    </div>
                </main>
				
				
				
				<?php include('common/footer.php'); ?>