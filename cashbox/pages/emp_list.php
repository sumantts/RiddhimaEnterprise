<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	$sql = "SELECT * FROM employee_list ORDER BY emp_id DESC";	
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
														<th>Sl#</th>
														<th>Emp. Name</th>
														<th>Phone</th>
														<th>Email</th>
														<th>Address</th>	
														<th>Action</th>
													</tr>
												</thead>
												<tbody>	
												<?php
												$i = 1;
												while ($row = $result->fetch_array()){ 
												?>
													<tr id="emp_id_<?=$row['emp_id']?>">
														<td><?=$i?></td>
														<td><?=$row['emp_name']?></td>
														<td><?=$row['emp_ph_primary']?> / <?=$row['emp_ph_secondary']?></td>
														<td><?=$row['emp_email']?></td>
														<td><?=$row['emp_address']?></td>
														<td>
															<a onclick="updateEmpModal('<?=$row['emp_id']?>')" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
															<a onclick="deleteEmployee('<?=$row['emp_id']?>')" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>
														</td>
													</tr>
												<?php 
												$i++;
												} ?>
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
					  <span class="close" onClick="closeEmployeeModal()">&times;</span>
					  
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
								<label for="emp_aadhar_no">Aadhar Card No</label>
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

					<div class="form-row">							
						<div class="col-md-12">
							<span id="emp_form_error" class="text-danger"> </span>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary" id="saveEmployee">OK</button>	
					<input type="hidden" id="emp_id" name="emp_id" value="0">
					<input type="hidden" id="created_by" value="<?=$login_id?>">
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>