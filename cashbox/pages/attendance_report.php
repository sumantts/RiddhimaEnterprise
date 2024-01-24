<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	//Fetch customer start
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
                            <li class="breadcrumb-item"><a href="#">Reports</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
							<!-- Search Panel -->
							<div class="col-lg-12">
								<div class="form-row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="sr_month_name">Month Name</label>
											<select class="form-control" id="sr_month_name" >
												<option value='0'>Select</option>
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
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="sr_emp_name">Employee Name</label>
											<select class="form-control" id="sr_emp_name" >
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
										</div>
									</div>

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>
									
									<button type="button" onClick="attendanceReport()" class="btn btn-primary" name="Print_btn">Print</button>
									
									</div>
								</div>
							</div>
							<!-- Search Panel end -->
							
                        </div>
                    </div>
                </main>
				

				<?php include('common/footer.php'); ?>

<!-- Select2 Dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#sr_month_name').select2({});
    $('#sr_emp_name').select2({});
</script>
<!-- //Select2 Dropdown -->