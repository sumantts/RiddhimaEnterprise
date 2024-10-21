<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');

	$user_type = $_SESSION["user_type"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"]; 
?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Product</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
							<!-- Search Panel -->
							<div class="col-lg-12">
								<form action="#" method="POST" name="myFormRet" id="myFormRet">
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="billNumber" class="text-danger">Bill Number*</label>
											<input type="text" class="form-control" id="billNumber" name="billNumber" value="" required>
										</div>

										<div class="form-group col-md-3" style="margin-top: 25px;">	
											<label for="inputState">&nbsp;</label>	
											<button type="submit" class="btn btn-primary" name="search_btn">Search</button>
										</div>										
									</div>

									<div class="row" id="customerInfo"> </div>
								</form>
							</div>
							<!-- Search Panel end --> 
							 
							<!-- Search Panel -->
							<div class="col-lg-12 d-none" id="paymentRcvDiv">
								<form action="#" method="POST" name="myFormRetu1" id="myFormRetu1">
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="returnAmount" class="text-danger">Return Amount*</label>
											<input type="number" class="form-control" id="returnAmount" name="returnAmount" value="" required>
										</div>
										<div class="form-group col-md-3">
											<label for="returnDate" class="text-danger">Date*</label>
											<input type="date" class="form-control" id="returnDate" name="returnDate" value="<?=date('Y-m-d')?>" required>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<label for="returnNote">Note</label>
											<textarea class="form-control" id="returnNote" name="returnNote"></textarea>
										</div>

										<div class="form-group col-md-3" style="margin-top: 25px;">	
											<label for="inputState2">&nbsp;</label>	
											<input type="hidden" name="customer_id" id="customer_id" value="">
											<button type="submit" class="btn btn-primary" name="save_btn2">Save</button>
										</div>										
									</div> 
								</form>
							</div>
							<!-- Search Panel end --> 

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