<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	$sql = "SELECT * FROM item_master ORDER BY item_id DESC";	
	$result = $mysqli->query($sql);

?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Employee Accounts</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
							
							<?php if($user_type == 0){?>
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openItemModal()">Add Employee</a></div>
							<?php }?>
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
														<th>Item Name</th>
														<th>CGST & SGST</th>
														<th>Quantity</th>
														<?php if($user_type > 0 && $user_type < 4){?>
														<th>Price</th>
														<?php }?>
														<?php if($user_type == 0){?>
														<th>Stokist Price</th>														
														<th>Dealer Price</th>
														<th>Wholesaler Price</th>
														<th>Retailer Price</th>
														<th>Action</th>
														<?php }?>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Item Name</th>
														<th>CGST & SGST</th>
														<th>Quantity</th>
														<?php if($user_type > 0 && $user_type < 4){?>
														<th>Price</th>
														<?php }?>
														<?php if($user_type == 0){?>
														<th>Stokist Price</th>														
														<th>Dealer Price</th>
														<th>Wholesaler Price</th>
														<th>Retailer Price</th>
														<th>Action</th>
														<?php }?>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												while ($row = $result->fetch_array()){ 
													//Fetch customer start												
													
													if($user_type == '5'){
														$get_sql = "SELECT * FROM login WHERE login_id = '" .$created_by. "'";														
													}else{
														$get_sql = "SELECT * FROM login WHERE login_id = '".$login_id."'";															
													}
													if($user_type == '1'){
														$rate_type_txt = 'stokist_price';
													}else if($user_type == '2'){
														$rate_type_txt = 'dealer_price';
													}else if($user_type == '3'){
														$rate_type_txt = 'wholesaler_price';
													}else{
														$rate_type_txt = '';
													}
													if($rate_type_txt != ''){
														$rate_price = $row[$rate_type_txt];
													}else{
														$rate_price = 0;
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
													
												?>
													<tr id="item_id_<?=$row['item_id']?>">
														<td><?=$row['item_name']?><br><?=$row['hs_code']?></td>
														<td style="text-align: right;"><?=$row['cgst_rate']?> & <?=$row['sgst_rate']?></td>
														<td style="text-align: right;">
															<?php
															if($item_quantity <= $stock_lower_limit){
															?>
																<span class="badge badge-pill badge-danger">Below Stock</span>
															<?php	
															echo $item_quantity;
															}else{
																echo $item_quantity;
															}
															?>
														</td>
														<?php if($user_type > 0 && $user_type < 4){?>
															<td style="text-align: right;"><?=$rate_price?></td>
														<?php }?>

														<?php if($user_type == 0){?>
														<td style="text-align: right;"><?=$row['stokist_price']?></td>
														<td style="text-align: right;"><?=$row['dealer_price']?></td>
														<td style="text-align: right;"><?=$row['wholesaler_price']?></td>
														<td style="text-align: right;"><?=$row['retailer_price']?></td>

														
														<td>
														<a onclick="updateItemModal('<?=$row['item_id']?>')" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
														<a onclick="deleteItem('<?=$row['item_id']?>')" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>
														</td>
														<?php }?>
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
				<div id="myModal" class="modal">
				  <!-- Modal content -->
				  <div class="modal-content">
					<div class="modal-header">
						<h3>Add/Update Employee</h3>
					  <span class="close" onClick="closeItemModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-4">
							<div class="form-group">
								<label for="emp_name" class="text-danger">Employee Name*</label>
								<input type="text" class="form-control" id="emp_name" name="emp_name" maxlength="50">
								<small id="emp_name_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_ph_primary" class="text-danger">Primary Phone Number*</label>
								<input type="number" class="form-control" id="emp_ph_primary" name="emp_ph_primary" maxlength="10">
								<small id="emp_ph_primary_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_ph_secondary">Secondary Phone Number</label>
								<input type="number" class="form-control" id="emp_ph_secondary" name="emp_ph_secondary" maxlength="10">
								<small id="emp_ph_secondary_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_email">Email ID</label>
								<input type="text" class="form-control" id="emp_email" name="emp_email" >
								<small id="emp_email_error" class="form-text text-muted"></small>
							</div>
						</div>	

						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_aadhar_no" class="text-danger">Aadhar Card No*</label>
								<input type="number" class="form-control" id="emp_aadhar_no" name="emp_aadhar_no" maxlength="12">
								<small id="emp_aadhar_no_error" class="form-text text-muted"></small>
							</div>
						</div>	

						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_pan_no">PAN Card No</label>
								<input type="text" class="form-control" id="emp_pan_no" name="emp_pan_no" >
								<small id="emp_pan_no_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">	
						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_pf_no">PF No</label>
								<input type="text" class="form-control" id="emp_pf_no" name="emp_pf_no" >
								<small id="emp_pf_no_error" class="form-text text-muted"></small>
							</div>
						</div>	

						<div class="col-md-4">
							<div class="form-group">
								<label for="emp_basic_pay" class="text-danger">Basic Pay*</label>
								<input type="number" class="form-control" id="emp_basic_pay" name="emp_basic_pay" >
								<small id="emp_basic_pay_error" class="form-text text-muted"></small>
							</div>
						</div>	

						<div class="col-md-4">
							<div class="form-group">
								<label for="payment_type" class="text-danger">Payment Type*</label>
								<select class="form-control" id="payment_type" name="payment_type">
									<option value="0">Select</option>
									<option value="1">Salaried</option>
									<option value="2">No Work No Pay</option>
								</select>
								<small id="payment_type_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">							
						<div class="col-md-12">
							<div class="form-group">
								<label for="emp_address" class="text-danger">Address*</label>
								<textarea class="form-control" id="emp_address" name="emp_address"></textarea>
								<small id="emp_address_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary" id="saveEmployee">OK</button>	
					<input type="hidden" id="user_type" value="<?=$_SESSION["user_type"]?>">
					<input type="hidden" id="created_by" value="<?=$created_by?>">
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>