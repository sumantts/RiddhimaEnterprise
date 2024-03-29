<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	
	//Fetch customer start
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];
	$salesman_type = 5;

	$sql = "SELECT * FROM zone_master WHERE created_by = '" .$login_id. "' ORDER BY zone_id DESC";	
	$result = $mysqli->query($sql);
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
									<!-- <div class="form-group col-md-3">
									<label for="inputCity">Before Date(dd-mm-YYYY) </label>
									<input type="date" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-d', strtotime($from_date))?>">
									</div> -->

									<div class="form-group col-md-3">
									<label for="inputState">Zone</label>
									<select id="search_zone_id" class="form-control" name="search_zone_id">
										<option value="0"> Select Zone </option>
										<?php
										while ($row = $result->fetch_array()){  
										?>
										<option value="<?=$row['zone_id']?>"><?=$row['zone_name']?></option>
										<?php } ?>
									</select>
									</div>

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>	
									<input type="hidden" name="ser_user_type" id="ser_user_type" value="<?=$user_type?>">	
									<input type="hidden" name="ser_created_by" id="ser_created_by" value="<?=$created_by?>">	
									<input type="hidden" name="ser_login_id" id="ser_login_id" value="<?=$login_id?>">										
									
									<button type="button" onClick="zoneDataSheet()" class="btn btn-primary" name="Print_btn">Print</button>
									
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
    $('#bill_customer_id').select2({
        dropdownParent: $('#myModalCustomer')
    });
</script>
<!-- //Select2 Dropdown -->