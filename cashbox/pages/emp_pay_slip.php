<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	$sql = "SELECT * FROM employee_list ORDER BY emp_id DESC";	
	$result = $mysqli->query($sql);

	$ps_sql = "SELECT * FROM employee_salary ORDER BY emp_id DESC";	
	$ps_result = $mysqli->query($ps_sql);

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
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openPaySlipModal()">Add New</a></div>
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
														<th>Basic Pay</th>
														<th>Allowance</th>
														<th>Deduction</th>	
														<th>Net Pay</th>	
														<th>Action</th>
													</tr>
												</thead>
												<tbody>													
													<?php
													$i = 1;
													while ($ps_row = $ps_result->fetch_array()){ 
														$salary_detail_data = json_decode($ps_row['salary_detail_data']);
													?>
														<tr id="emp_sal_id_<?=$ps_row['emp_sal_id']?>">
															<td><?=$i?></td>
															<td><?=$salary_detail_data->emp_name?></td>
															<td style="text-align: right;"> <?=$ps_row['basic_pay']?></td>
															<td style="text-align: right;"><?=$ps_row['total_allounce']?></td>
															<td style="text-align: right;"><?=$ps_row['total_deduction']?></td>
															<td style="text-align: right;"><?=$ps_row['net_pay']?></td>
															<td>
																<a style="cursor: pointer;" target="_blank" href="pages/pay_slip_printer/pay_slip_pdf.php?emp_sal_id=<?=$ps_row['emp_sal_id']?>"><i class="fa fa-print" aria-hidden="true"></i></a>
																<a onclick="editPaySlip('<?=$ps_row['emp_sal_id']?>')" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
																<a onclick="deletePaySlip('<?=$ps_row['emp_sal_id']?>')" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
						<h3>Add/Update PaySlip</h3>
					  <span class="close" onClick="closeEmployeeModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="month_name">Month Name</label>
									<select class="form-control" id="month_name" >
										<option value="0">Select</option>
										<option value='1'>Janaury</option>
										<option value='2'>February</option>
										<option value='3'>March</option>
										<option value='4'>April</option>
										<option value='5'>May</option>
										<option value='6'>June</option>
										<option value='7'>July</option>
										<option value='8'>August</option>
										<option value='9'>September</option>
										<option value='10'>October</option>
										<option value='11'>November</option>
										<option value='12'>December</option>
									</select>
									<small id="month_name_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="exampleInputEmail1">Employee Name</label>
									<select class="form-control" id="emp_name" >
										<option value="0">Select</option>
										<?php
										$i = 1;
										while ($row = $result->fetch_array()){ 
										?>
										<option value="<?=$row['emp_id']?>" emp_basic_pay="<?=$row['emp_basic_pay']?>"><?=$row['emp_name']?></option>
										<?php 
										$i++;
										} ?>
									</select>
									<small id="item_name_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="exampleInputEmail1">Basic Pay</label>
									<input type="text" class="form-control" id="emp_basic_pay" readonly  value="0">
									<small id="emp_basic_pay_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="attendance_count">Attendance</label>
									<input type="number" class="form-control" id="attendance_count" readonly  value="0">
									<small id="attendance_count_error" class="form-text text-muted"></small>
								</div>
							</div>

							<!-- <div class="col-md-4 mt-4">					
							<button type="button" class="btn btn-primary" id="saveItem">OK</button>
							</div> -->
						</div>
						
						<hr>

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="allounce_1">Allounce 1</label>
									<input type="number" class="form-control" id="allounce_1" value="0">
									<small id="allounce_1_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="allounce_2">Allounce 2</label>
									<input type="number" class="form-control" id="allounce_2" value="0">
									<small id="allounce_2_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="allounce_3">Allounce 3</label>
									<input type="number" class="form-control" id="allounce_3" value="0">
									<small id="allounce_3_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="allounce_4">Allounce 4</label>
									<input type="number" class="form-control" id="allounce_4" value="0">
									<small id="allounce_4_error" class="form-text text-muted"></small>
								</div>
							</div>
						</div>

						<hr>

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="deduction_1">Deduction 1</label>
									<input type="number" class="form-control" id="deduction_1"  value="0">
									<small id="deduction_1_error" class="form-text text-muted"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="deduction_2">Deduction 2</label>
									<input type="number" class="form-control" id="deduction_2"  value="0">
									<small id="deduction_2_error" class="form-text text-muted"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="deduction_3">Deduction 3</label>
									<input type="number" class="form-control" id="deduction_3"  value="0">
									<small id="deduction_3_error" class="form-text text-muted"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="deduction_4">Deduction 4</label>
									<input type="number" class="form-control" id="deduction_4"  value="0">
									<small id="deduction_4_error" class="form-text text-muted"></small>
								</div>
							</div>
						</div>

						<hr>

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="net_pay">Net Pay</label>
									<input type="number" class="form-control" id="net_pay" value="0" >
									<small id="net_pay_error" class="form-text text-muted"></small>
								</div>
							</div>

							<div class="col-md-2 mt-4">					
							<button type="button" class="btn btn-primary" id="calculatePaySlip">Calculate</button>
							</div>

							<div class="col-md-4 mt-4">	
								<input type="hidden" name="emp_sal_id" id="emp_sal_id" value="0">
							<button type="button" class="btn btn-primary" id="generatePaySlip">Generate PaySlip</button>
							</div>
						</div>
						

						<div class="form-row">							
							<div class="col-md-12">
								<span id="emp_form_error" class="text-danger"> </span>
							</div>
						</div>
						
						
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>