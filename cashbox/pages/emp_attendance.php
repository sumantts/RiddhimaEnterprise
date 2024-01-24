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
		$sql = "SELECT employee_attendance.emp_att_id, employee_attendance.present_status, employee_attendance.half_day, employee_attendance.full_day, employee_attendance.late_hours, employee_attendance.overtime_hours, employee_attendance.attendance_note, employee_list.emp_name, employee_list.emp_id FROM employee_attendance JOIN employee_list ON employee_list.emp_id = employee_attendance.emp_id WHERE employee_attendance.present_date = '" .$search_present_date. "' ";	
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
		$present_date = $_POST['present_date'];
		$half_day_text = $_POST['half_day_text'];
		$full_day_text = $_POST['full_day_text'];
		$late_hours = $_POST['late_hours'];
		$overtime_hours = $_POST['overtime_hours'];
		$attendance_note = $_POST['attendance_note'];

		for($i = 0; $i < sizeof($emp_id_all); $i++){
			$emp_id = $emp_id_all[$i];
			$present_status = $present_status_text[$i];
			$half_day = $half_day_text[$i];
			$full_day = $full_day_text[$i];
			$late_hours1 = $late_hours[$i];
			$overtime_hours1 = $overtime_hours[$i];
			$attendance_note1 = $attendance_note[$i];

			$chk_sql = "SELECT * FROM employee_attendance WHERE emp_id = '" .$emp_id. "' AND present_date = '" .$present_date. "' ";	
			$chk_result = $mysqli->query($chk_sql);
			if($chk_result->num_rows > 0){
				$upd_sql = "UPDATE employee_attendance SET present_status = '".$present_status."', half_day = '".$half_day."', full_day = '".$full_day."', late_hours = '".$late_hours1."', overtime_hours = '".$overtime_hours1."', attendance_note = '".$attendance_note1."' WHERE emp_id = '" .$emp_id. "' AND present_date = '" .$present_date. "' ";
				$mysqli->query($upd_sql);
			}else{
				$sql2 = "INSERT INTO employee_attendance (emp_id, present_date, present_status, half_day, full_day, late_hours, overtime_hours, attendance_note) VALUES ('" .$emp_id. "', '" .$present_date. "', '".$present_status."', '".$half_day."', '".$full_day."', '".$late_hours1."', '".$overtime_hours1."', '".$attendance_note1."')";	
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
														<th>Half Day</th>	
														<th>Full Day</th>	
														<th>Late Hour</th>	
														<th>Overtime Hour</th>	
														<th>Note</th>
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
																	<td><?=($row['half_day'] == 1)? 'Yes' : 'No'?></td>
																	<td><?=($row['full_day'] == 1)? 'Yes' : 'No'?></td>
																	<td style="text-align: right;"><?=$row['late_hours']?></td>
																	<td style="text-align: right;"><?=$row['overtime_hours']?></td>
																	<td><?=$row['attendance_note']?></td>
																<?php } else {?>
																	<td style="text-align: center;">
																		<input type="checkbox" name="present_status[]" id="attendance_<?=$row['emp_id']?>" class="check_class" data-emp_id="<?=$row['emp_id']?>">
																		<input type="hidden" name="present_status_text[]" id="present_status_text_<?=$row['emp_id']?>" value="0" >
																	</td>
																	<td style="text-align: center;">
																		<input type="checkbox" name="half_day[]" id="half_day_<?=$row['emp_id']?>" class="check_class_hd" data-emp_id="<?=$row['emp_id']?>">
																		<input type="hidden" name="half_day_text[]" id="half_day_text_<?=$row['emp_id']?>" value="0" >
																	</td>
																	<td style="text-align: center;">
																		<input type="checkbox" name="full_day[]" id="full_day_<?=$row['emp_id']?>" class="check_class_fd" data-emp_id="<?=$row['emp_id']?>">
																		<input type="hidden" name="full_day_text[]" id="full_day_text_<?=$row['emp_id']?>" value="0" >
																	</td>
																	<td>
																		<input type="text" class="form-control" name="late_hours[]" value="0" style="text-align: right; width: 100px;">
																	</td>
																	<td>
																		<input type="text" class="form-control" name="overtime_hours[]" value="0" style="text-align: right; width: 100px;">
																	</td>
																	<td>
																		<input type="text" class="form-control" name="attendance_note[]" value="" >
																	</td>
																<?php } ?>

															</tr>
														<?php 
														$i++;
														} ?>
														<?php if(!isset($_POST['search_present_date'])){ ?>
														<tr>
															<td colspan="8">
																<input type="hidden" name="present_date" id="present_date" value="<?=date('Y-m-d')?>">
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
				
				<?php include('common/footer.php'); ?>