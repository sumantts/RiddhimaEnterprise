<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$user_type = $_SESSION["user_type"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	if(isset($_POST['search_btn'])){
		$from_date = $_POST["from_date"];
		$to_date = $_POST["to_date"];
		$search_cu_id = $_POST["search_cu_id"];
		$user_type = $_POST["ser_user_type"];
		$created_by = $_POST["ser_created_by"];
		$login_id = $_POST["ser_login_id"];

		if($user_type == 5){
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '".$created_by."' AND cb_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ";
		}else{
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '".$login_id."' AND cb_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ";
		}
	}else{
		if($user_type == 5){
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '" .$created_by. "'";
		}else{
			$sql = "SELECT * FROM cashbook_entry WHERE cb_created_by = '" .$login_id. "'";
		}	
	}

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
							<form action="?p=cashbook" method="POST" name="form_search">
								<div class="form-row">
									<div class="form-group col-md-3">
									<label for="inputCity">From Date(dd-mm-YYYY) </label>
									<input type="date" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-d', strtotime($from_date))?>">
									</div>

									<div class="form-group col-md-3">
									<label for="inputCity">To Date(dd-mm-YYYY)</label>
									<input type="date" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime($to_date))?>">
									</div>

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>	
									<input type="hidden" name="ser_user_type" id="ser_user_type" value="<?=$user_type?>">	
									<input type="hidden" name="ser_created_by" id="ser_created_by" value="<?=$created_by?>">	
									<input type="hidden" name="ser_login_id" id="ser_login_id" value="<?=$login_id?>">						
									<button type="submit" class="btn btn-primary" name="search_btn">Search</button>	
									<?php if(isset($_POST['search_btn']) && mysqli_num_rows($result) > 0){ ?>				
									<button type="button" onClick="csvDownload()" class="btn btn-primary" name="Print_btn">CSV</button>
									<?php } ?>
									</div>
								</div>
								</form>
							</div>
							<!-- Search Panel end -->
                            <div class="col-lg-12">							
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="cashBookNewEntry()">New Entry</a></div>
								
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
														<th>Date</th>
														<th>Payment</th>
														<th>Receive</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>SL#</th>
														<th>Date</th>
														<th>Payment</th>
														<th>Receive</th>
														<th>Amount</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												$i = 0;
												while ($row = $result->fetch_array()){ 
													$i++;
													$receive_payment = $row['receive_payment'];
													$cb_narration = $row['cb_narration'];
													$receive = '';
													$payment = '';
													if($receive_payment == 0){
														$receive = $cb_narration;
													}else{
														$payment = $cb_narration;
													}
												?>
													<tr id="cb_id_<?=$row['cb_id']?>">
														<td><?=$i?></td>
														<td><?=date('d-m-Y', strtotime($row['cb_date']))?></td>
														<td><?=$payment?></td>
														<td><?=$receive?></td>
														<td style="text-align: right;"><?=$row['cb_amount']?></td>
														<td>
														<a style="cursor: pointer;" onclick="updateCashBookModal('<?=$row['cb_id']?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>
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
						<h3>Add/Update <?=$title?></h3>
					  <span class="close" onClick="closeCustomerModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Date</label>
								<input type="date" class="form-control" id="cb_date">
								<small id="cb_date_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">Receive/Payment</label>
								<select id="receive_payment" class="form-control" name="receive_payment">
									<option value="">Select Receive/Payment</option>
									<option value="0">Receive</option>
									<option value="1">Payment</option>
								</select>
								<small id="receive_payment_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">						
						<div class="col-md-10">
							<div class="form-group">
								<label for="exampleInputEmail1">Narration</label>
								<input type="text" class="form-control" id="cb_narration" placeholder="Narration">
								<small id="cb_narration_error" class="form-text text-muted"></small>
							</div>
						</div>

                        <div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Amount</label>
								<input type="number" class="form-control" id="cb_amount" placeholder="Amount" value="0.00">
								<small id="cb_amount_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>
					
					<input type="hidden" id="user_type" value="<?=$user_type?>">
					<input type="hidden" id="created_by" value="<?=$created_by?>">
					<input type="hidden" id="cb_id" value="0">
					<button type="button" class="btn btn-primary" id="saveCashbook">OK</button>	
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				
				<?php include('common/footer.php'); ?>