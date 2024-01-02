<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	//$sql = "SELECT * FROM employee_list ORDER BY emp_id DESC";	
	//$result = $mysqli->query($sql);

	if(isset($_POST['search_present_date'])){
		$search_present_date = $_POST['search_present_date'];
		$sql = "SELECT employee_attendance.emp_att_id, employee_attendance.present_status, employee_list.emp_name, employee_list.emp_id FROM employee_attendance JOIN employee_list ON employee_list.emp_id = employee_attendance.emp_id WHERE employee_attendance.present_date = '" .$search_present_date. "' ";	
		$result = $mysqli->query($sql);
	}else{
		$search_present_date = date('Y-m-d');
		$sql = "SELECT * FROM employee_list ORDER BY emp_id DESC";	
		$result = $mysqli->query($sql);
	}//end if

	if(isset($_POST['save_attendance'])){
		$emp_id_all = $_POST['emp_id_all'];
		$present_status = $_POST['present_status'];
		$present_status_text = $_POST['present_status_text'];

		/*echo 'emp_id_all: ' . json_encode($emp_id_all);

		echo 'present_status: ' . json_encode($present_status);

		echo 'present_status_text: ' . json_encode($present_status_text);
		exit();*/

		for($i = 0; $i < sizeof($emp_id_all); $i++){
			$emp_id = $emp_id_all[$i];
			$present_date = date('Y-m-d');
			$present_status = $present_status_text[$i];

			$chk_sql = "SELECT * FROM employee_attendance WHERE emp_id = '" .$emp_id. "' AND present_date = '" .$present_date. "' ";	
			$chk_result = $mysqli->query($chk_sql);
			if($chk_result->num_rows > 0){
				$upd_sql = "UPDATE employee_attendance SET present_status = '".$present_status."' WHERE emp_id = '" .$emp_id. "' AND present_date = '" .$present_date. "' ";
				$mysqli->query($upd_sql);
			}else{
				$sql2 = "INSERT INTO employee_attendance (emp_id, present_date, present_status) VALUES ('" .$emp_id. "', '" .$present_date. "', '".$present_status."')";	
				$result2 = $mysqli->query($sql2);
			}
		}//end for
	}//end if

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
							<!-- Search Panel -->
							<div class="col-lg-12">
							<form action="" method="POST" name="form_search">
								<div class="form-row">
									<div class="form-group col-md-3">
									<label for="inputCity">Date</label>
									<input type="date" class="form-control" id="search_present_date" name="search_present_date" value="<?=date('Y-m-d', strtotime($search_present_date))?>">
									</div>

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>	
									<button type="submit" class="btn btn-primary" name="search_btn">Search</button>	
									</div>
								</div>
								</form>
							</div>
							<!-- Search Panel end -->

                            <div class="col-lg-12">
							
							<?php if($user_type == 0){?>
								<!-- <div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openItemModal()">Add Employee</a></div> -->
							<?php }?>
								<div class="card mb-4">
									<div class="card-header">
										<i class="fas fa-table mr-1"></i>
										<?=$title?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="myTable"  cellspacing="0">
												<thead>
													<tr>
														<th>Sl#</th>
														<th>Emp. Name</th>	
														<th>Attendance</th>
													</tr>
												</thead>
												<tbody>	
													<form name="attendance_sheet" id="attendance_sheet" action="" method="POST">
														<?php
														$i = 1;
														while ($row = $result->fetch_array()){ 
														?>
															<tr id="emp_id_<?=$row['emp_id']?>">
																<td><?=$i?></td>
																<td>
																	<?=$row['emp_name']?>
																	<input type="hidden" name="emp_id_all[]" value="<?=$row['emp_id']?>">
																</td>
																<?php if(isset($_POST['search_present_date'])){ ?>
																	<td><?=($row['present_status'] == 1)? 'Present' : 'Absent'?></td>
																<?php } else {?>
																	<td>
																		<input type="checkbox" name="present_status[]" id="attendance_<?=$row['emp_id']?>" class="check_class" data-emp_id="<?=$row['emp_id']?>">
																		<input type="hidden" name="present_status_text[]" id="present_status_text_<?=$row['emp_id']?>" value="0" >
																	</td>
																<?php } ?>

															</tr>
														<?php 
														$i++;
														} ?>
														<?php if(!isset($_POST['search_present_date'])){ ?>
														<tr>
															<td colspan="3">
																<input type="submit" class="btn btn-primary" name="save_attendance" id="save_attendance" value="Save">
															</td>
														</tr>
														<?php } ?>
													</form>
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