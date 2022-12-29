<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];
	$salesman_type = 5;
	
	if($user_type == '0'){
		$sql = "SELECT * FROM login WHERE user_type = '0' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);

		$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
		$zone_result = $mysqli->query($zone_sql);

	}else if($user_type == '5'){
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

		$sql = "SELECT * FROM login WHERE user_type = '".$next_user_type1."' AND created_by = '".$login_id_temp."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);

		$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$created_by. "' ORDER BY zone_id DESC";	
		$zone_result = $mysqli->query($zone_sql);
	}else{
		$next_user_type = $user_type + 1;
		$sql = "SELECT * FROM login WHERE user_type = '".$next_user_type."' AND created_by = '".$login_id."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);

		$zone_sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
		$zone_result = $mysqli->query($zone_sql);
	}
?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <!-- <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Master Entry</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol> -->
                        <div class="row">
                            <div class="col-lg-12">
							<!-- Alert Div -->
							<div class="alert alert-primary d-flex align-items-center hide" role="alert" id="alert_msg">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
								<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
							</svg>
							<div id="alert_msg_txt"> </div>
							</div>
							<!-- Alert Div -->

							<!-- Tabs navs -->
							<ul class="nav nav-tabs">
							<!-- Super Admin View -->
							<?php if($user_type == '0' || $salesman_type == '0'){ ?>
								<li class="active"><a data-toggle="tab" href="#SuperAdmin" id="clickSuperAdmin">Super Admin</a></li>
								<li><a data-toggle="tab" href="#stockist" id="clickStockist">Stockist</a></li>
								<li><a data-toggle="tab" href="#dealer" id="clickDealer">Dealer</a></li>
								<li><a data-toggle="tab" href="#wholesaler" id="clickWholesaler">Wholesaler</a></li>
								<li><a data-toggle="tab" href="#retailer" id="clickRetailer">Retailer</a></li>
								<li><a data-toggle="tab" href="#salesman" id="clickSalesMan">Sales Man</a></li>
							<?php }?>

							<!-- Stockist View -->
							<?php if($user_type == '1' || $salesman_type == '1'){ ?>
								<li class="active"><a data-toggle="tab" href="#dealer" id="clickDealer">Dealer</a></li>
								<li><a data-toggle="tab" href="#wholesaler" id="clickWholesaler">Wholesaler</a></li>
								<li><a data-toggle="tab" href="#retailer" id="clickRetailer">Retailer</a></li>
								<li><a data-toggle="tab" href="#salesman" id="clickSalesMan">Sales Man</a></li>								
							<?php } ?>

							<!-- Dealer View -->
							<?php if($user_type == '2' || $salesman_type == '2'){ ?>
								<li class="active"><a data-toggle="tab" href="#wholesaler" id="clickWholesaler">Wholesaler</a></li>
								<li><a data-toggle="tab" href="#retailer" id="clickRetailer">Retailer</a></li>
								<li><a data-toggle="tab" href="#salesman" id="clickSalesMan">Sales Man</a></li>								
							<?php } ?>

							<!-- Wholesaler View -->
							<?php if($user_type == '3' || $salesman_type == '3'){ ?>
								<li class="active"><a data-toggle="tab" href="#retailer" id="clickRetailer">Retailer</a></li>
								<li><a data-toggle="tab" href="#salesman" id="clickSalesMan">Sales Man</a></li>								
							<?php } ?>
							
							</ul>

							<div class="tab-content">
								<!-- Super Admin -->
								<div id="SuperAdmin" class="tab-pane fade in active">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('0')">New Super Admin</a></div>
								</div>
								<!-- Super Admin -->

								<!-- stockist start -->
								<div id="stockist" class="tab-pane fade">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('1')">New Stockist</a></div>
								
								</div>
								<!-- stockist End -->

								<!-- Dealer Start -->
								<div id="dealer" class="tab-pane fade">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('2')">New Dealer</a></div>
								</div>
								<!-- Dealer end -->

								<!-- Wholesaler Start -->
								<div id="wholesaler" class="tab-pane fade">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('3')">New Wholesaler</a></div>
								</div>
								<!-- Wholesaler end -->

								<!-- Retailer Start -->
								<div id="retailer" class="tab-pane fade">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('4')">New Retailer</a></div>
								</div>
								<!-- Retailer end -->

								<!-- Sales Man Start -->
								<div id="salesman" class="tab-pane fade">
									<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openCreateUserModal('5')">New Sales Man</a></div>
								</div>
								<!-- Sales Man end -->

							</div>
							<!-- Tabs content -->
								
									<div class="card mb-4">
										<div class="card-header">
											<i class="fas fa-table mr-1"></i>
											<?=$title?>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
													<thead>
														<tr>
															<th>SL#</th>
															<th>Organization Name</th>
															<th>Contact Person</th>
															<th>Phone/Whatsapp Number</th>
															<th>Address</th>
															<th>Zone</th>
															<th>Amount Due</th>
															<th>Action</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th>SL#</th>
															<th>Organization Name</th>
															<th>Contact Person</th>
															<th>Phone/Whatsapp Number</th>
															<th>Address</th>
															<th>Zone</th>
															<th>Amount Due</th>
															<th>Action</th>
														</tr>
													</tfoot>
													<tbody>	
													<?php
													while ($row = $result->fetch_array()){ 
														$user_data1 = $row['user_data'];
														$user_data = json_decode($user_data1);
													?>
														<tr id="user_id_<?=$row['login_id']?>">
															<td><?=$row['login_id']?></td>
															<td><?=$user_data->org_name?></td>
															<td><?=$user_data->contact_person?></td>
															<td><?=$user_data->phone_number."/".$user_data->whatsapp_number?></td>
															<td><?=$user_data->address?></td>
															<td>
																<select name="zone_id_<?=$row['login_id']?>" id="zone_id_<?=$row['login_id']?>" onChange="updateUserZone(<?=$row['login_id']?>)">
																	<option value="0">Select Zone</option>
																<?php
																while ($zone_row = $zone_result->fetch_array()){ 
																?>
																	<option value="<?=$zone_row['zone_id']?>" <?php if($zone_row['zone_id'] == $row['zone_id']){?> selected <?php } ?> ><?=$zone_row['zone_name']?></option>
																<?php
																}
																?>
																</select>
															</td>
															<td><?=$row['net_due_amount']?></td>
															<td>
															<a style="cursor: pointer;" onclick="updateUserModal('<?=$row['login_id']?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>
															<a  style="cursor: pointer;" onclick="deleteUser('<?=$row['login_id']?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
															</td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
							
								
                            </div>
                        </div>
                    </div>
                </main>
				
				<!-- The Modal -->
				<div id="myModalCustomer" class="modal">
				  <!-- Modal content -->
				  <div class="modal-content">
					<div class="modal-header">
						<h3 id="modal_heading">Add/Update User</h3>
					  <span class="close" onClick="closeCustomerModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1" >Organization Name*</label>
								<input type="text" class="form-control" id="org_name" placeholder="Organization Name">
								<small id="org_name_error" class="form-text text-muted"></small>
								
								<input type="hidden" class="form-control" id="logged_in_user_type" value="<?=$user_type?>">
								<input type="hidden" class="form-control" id="user_type" value="">
								<input type="hidden" class="form-control" id="update_login_id" value="0">
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Contact Person*</label>
								<input type="text" class="form-control" id="contact_person" placeholder="Contact Person">
								<small id="contact_person_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">						
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Phone Number</label>
								<input type="number" class="form-control" id="phone_number" placeholder="Phone Number" value="9999999999">
								<small id="phone_number_error" class="form-text text-muted"></small>
							</div>
						</div>	

						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Whatsapp Number</label>
								<input type="number" class="form-control" id="whatsapp_number" placeholder="Whatsapp Number" value="9999999999">
								<small id="whatsapp_number_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">	
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Email Id</label>
								<input type="text" class="form-control" id="email_id" placeholder="Email Id" value="riddhi@theriddhi.com">
								<small id="email_id_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Address*</label>
								<input type="text" class="form-control" id="address" placeholder="Address">
								<small id="address_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">	
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Pin Code*</label>
								<input type="number" class="form-control" id="pin_code" placeholder="Pin Code">
								<small id="pin_code_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">GSTIN No</label>
								<input type="text" class="form-control" id="gstin_no" placeholder="GSTIN No">
								<small id="gstin_no_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>	
					
					<button type="button" class="btn btn-primary" id="saveUser">OK</button>	
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				
				<?php include('common/footer.php'); ?>