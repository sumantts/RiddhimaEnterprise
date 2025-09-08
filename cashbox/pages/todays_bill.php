<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	//Fetch customer start
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];
	$salesman_type = 5;

	$sql_customer = "SELECT * FROM customer_master ORDER BY customer_name ASC";	
	$result_customer = $mysqli->query($sql_customer);

	$sql_item = "SELECT * FROM item_master WHERE item_quantity > 0 ORDER BY item_name ASC";	
	$result_item = $mysqli->query($sql_item);

	if(isset($_POST["search_cu_id"])){
		$from_date = $_POST["from_date"];
		$to_date = $_POST["to_date"];
		$search_cu_id = $_POST["search_cu_id"];
		$user_type = $_POST["ser_user_type"];
		$created_by = $_POST["ser_created_by"];
		$login_id = $_POST["ser_login_id"];

		if($user_type == '5'){
			if($search_cu_id > 0){
				$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND customer_id = '" .$search_cu_id. "' AND create_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
			}else{
				$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
			}
		}else{
			if($search_cu_id > 0){
				$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND customer_id = '" .$search_cu_id. "' AND create_date BETWEEN '".$from_date." 00:00:01' AND '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
			}else{
				$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND create_date BETWEEN '".$from_date." 00:00:01' AND  '" .$to_date. " 23:59:00' ORDER BY bill_id DESC";
			}
		}

		//Collection Report
		$collectionReport = 1;
	}else{
	    $from_date = date('Y-m-d');
	    $to_date = date('Y-m-d');
		$collectionReport = 0;
		//$create_date = date("Y-m-d H:i:s", strtotime("-1 months"));
		$create_date = date('Y-m-d').' 00:01:01';
		$create_date1 = date('Y-m-d').' 23:58:01';
		$search_cu_id = 0;
		if($user_type == '5'){
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$created_by."' AND create_date >= '".$create_date."' AND create_date <= '".$create_date1."' ORDER BY bill_id DESC";	
		}else{
			$sql_bill = "SELECT * FROM bill_details WHERE created_by = '".$login_id."' AND create_date >= '".$create_date."' AND create_date <= '".$create_date1."' ORDER BY bill_id DESC";
		}
	}
	
	$result_bill = $mysqli->query($sql_bill);
	
	if($user_type == '5'){
		$sql = "SELECT * FROM login WHERE created_by = '".$created_by."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);
	}else{
		$sql = "SELECT * FROM login WHERE created_by = '".$login_id."' ORDER BY login_id DESC";	
		$result = $mysqli->query($sql);
	}
	//Fetch customer end

	//Fetch created by users details
	if($user_type == '5'){
		$sql_cb = "SELECT * FROM login WHERE login_id = '".$created_by."'";	
	}else{
		$sql_cb = "SELECT * FROM login WHERE login_id = '".$login_id."'";	
	}
	$result_cb = $mysqli->query($sql_cb);
	$row_cb = $result_cb->fetch_array();
	$cb_user_data1 = $row_cb['user_data'];
	$cb_user_data = json_decode($cb_user_data1);


?>

<style>
	/* Make the Select2 container full width */
	.select2-container {
	width: 100% !important;
	}

	/* Match height with standard form controls */
	.select2-selection--single {
	height: 38px !important; /* or whatever height suits your UI */
	padding: 4px 12px;
	border: 1px solid #ccc;
	border-radius: 4px;
	}

	/* Align the text vertically */
	.select2-selection__rendered {
	line-height: 30px !important;
	}

	/* Remove weird padding/margin in selection arrow */
	.select2-selection__arrow {
	height: 38px !important;
	}

</style>

        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#">Bill Details</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
							<!-- Search Panel -->
							<div class="col-lg-12">
							<form action="?p=todays-bill" method="POST" name="form_search">
								<div class="form-row">
									<div class="form-group col-md-3">
									<label for="inputCity">From Date(dd-mm-YYYY) </label>
									<input type="date" class="form-control" id="from_date" name="from_date" value="<?=date('Y-m-d', strtotime($from_date))?>">
									</div>

									<div class="form-group col-md-3">
									<label for="inputCity">To Date(dd-mm-YYYY)</label>
									<input type="date" class="form-control" id="to_date" name="to_date" value="<?=date('Y-m-d', strtotime($to_date))?>">
									</div>

									<div class="form-group col-md-3">
									<label for="inputState">Customer</label>
									<select id="search_cu_id" class="form-control" name="search_cu_id">
										<option value="0">Choose customer</option>
										<?php
										while ($row_customer = $result->fetch_array()){ 
											$user_data1 = $row_customer['user_data'];
											$user_data = json_decode($user_data1);

										?>
										<option value="<?=$row_customer['login_id']?>" <?php if($row_customer['login_id'] == $search_cu_id){?> selected <?php } ?> ><?=$user_data->org_name?></option>
										<?php } ?>
									</select>
									</div>

									<div class="form-group col-md-3" style="margin-top: 25px;">	
									<label for="inputState">&nbsp;</label>	
									<input type="hidden" name="ser_user_type" id="ser_user_type" value="<?=$user_type?>">	
									<input type="hidden" name="ser_created_by" id="ser_created_by" value="<?=$created_by?>">	
									<input type="hidden" name="ser_login_id" id="ser_login_id" value="<?=$login_id?>">						
									<button type="submit" class="btn btn-primary" name="search_btn">Search</button>	
									<?php if(isset($_POST['search_btn']) && mysqli_num_rows($result_bill) > 0){ ?>				
									<button type="button" onClick="printBillAll()" class="btn btn-primary" name="Print_btn">Print</button>
									<?php } ?>
									</div>
								</div>
								</form>
							</div>
							<!-- Search Panel end -->
                            <div class="col-lg-12">							
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openBillModal('0')">New Bill</a></div>
								
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
														<th>Sl.No.</th>
														<th>Bill Number</th>
														<th>Customer Name</th>
														<th>Phone Number</th>
														<th>Total Bill Amount</th>
														<th>Paid Amount</th>
														<th>Discount</th>
														<th>Due Amount</th>
														<th>Bill Created On</th>
														<th>Action</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Sl.No.</th>
														<th>Bill Number</th>
														<th>Customer Name</th>
														<th>Phone Number</th>
														<th>Total Bill Amount</th>
														<th>Paid Amount</th>
														<th>Discount</th>
														<th>Due Amount</th>
														<th>Bill Created On</th>
														<th>Action</th>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												if(mysqli_num_rows($result_bill) > 0){
													$i = 0;
													while ($row_bill = $result_bill->fetch_array()){ 
														$create_date = '';
														$i++;
														$bill_id = $row_bill['bill_id'];
														$bill_description = json_decode(base64_decode($row_bill['bill_description']));
														
														/*if(isset($bill_description->create_date_new)){
															$create_date = $bill_description->create_date_new;
														}else{
															$create_date = $row_bill['create_date'];
														}*/
														$create_date = $row_bill['create_date'];

														if(isset($_POST["search_cu_id"])){
															if(strtotime($create_date) >= strtotime($from_date) && strtotime($create_date) <= strtotime($to_date)){
																$formated_bill_no = 'RE/'.date('M', strtotime($create_date)).'/'.$bill_id;
																if(isset($bill_description->discountAmount)){
																	$discountAmount = $bill_description->discountAmount;
																}else{
																	$discountAmount = '0.00';
																}
																?>
																<tr id="bill_row_<?=$bill_id?>">
																	<td><?=$i?></td>
																	<td><?=$formated_bill_no?></td>
																	<td><?=$bill_description->customer_name?></td>
																	<td><?=$bill_description->phone_number?></td>
																	<td style="text-align: right;"><?=$bill_description->roundedUpFineItemsSubTotal?></td>
																	<td style="text-align: right;"><?=$bill_description->totalCash?></td>
																	<td style="text-align: right;"><?=$discountAmount?></td>
																	<td style="text-align: right;"><?=$bill_description->dueCash?></td>
																	<td><?=date('d-M-Y h:i a', strtotime($create_date))?></td>
																	
																	<td>
																		<a style="cursor: pointer;" onclick="openBillModal('<?=$bill_id?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>
																		
																		<a style="cursor: pointer;" target="_blank" href="pages/bill_printer/bill_pdf.php?bill_id=<?php echo $bill_id; ?>"><i class="fa fa-print" aria-hidden="true"></i></a>

																		<a style="cursor: pointer;" id="saveLoanProd_<?=$bill_id?>" onclick="deleteBill(<?=$bill_id?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
																	</td>
																</tr>
																<?php 
															} //end 
														}else{
															//if(strtotime($create_date) >= strtotime($from_date) && strtotime($create_date) <= strtotime($to_date)){
																$formated_bill_no = 'RE/'.date('M', strtotime($create_date)).'/'.$bill_id;
																if(isset($bill_description->discountAmount)){
																	$discountAmount = $bill_description->discountAmount;
																}else{
																	$discountAmount = '0.00';
																}
																
																?>
																<tr id="bill_row_<?=$bill_id?>">
																	<td><?=$i?></td>
																	<td><?=$formated_bill_no?></td>
																	<td><?=$bill_description->customer_name?></td>
																	<td><?=$bill_description->phone_number?></td>
																	<td style="text-align: right;"><?=$bill_description->roundedUpFineItemsSubTotal?></td>
																	<td style="text-align: right;"><?=$bill_description->totalCash?></td>
																	<td style="text-align: right;"><?=$discountAmount?></td>
																	<td style="text-align: right;"><?=$bill_description->dueCash?></td>
																	<td><?=date('d-M-Y h:i a', strtotime($create_date))?></td>
																	
																	<td>
																		<a style="cursor: pointer;" onclick="openBillModal('<?=$bill_id?>')"><i class="fa fa-edit" aria-hidden="true"></i></a>
																		
																		<a style="cursor: pointer;" target="_blank" href="pages/bill_printer/bill_pdf.php?bill_id=<?php echo $bill_id; ?>"><i class="fa fa-print" aria-hidden="true"></i></a>

																		<a style="cursor: pointer;" id="saveLoanProd_<?=$bill_id?>" onclick="deleteBill(<?=$bill_id?>)"><i class="fa fa-trash" aria-hidden="true"></i></a>
																	</td>
																</tr>
																<?php 
															//} //end 
														}//end if
													}//end while
													}else{
													?>												
														</tr><td colspan='10'>No record found</td></tr>
													<?php 
													} 
													?>
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
				  <div class="modal-content-bill">
					<div class="modal-header">
						<h3>Create/Update Bill</h3>
					  <span class="close" onClick="closeCustomerModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>

					<div class="form-row">
                        <div class="col-md-4">
							<div class="form-group" >
								<label for="zone_id">Zone Name*</label>
								<select class="form-control" id="zone_id">
									<option value="">Select Zone</option>
								</select>
								<small id="zone_id_error" class="form-text text-muted"></small>
							</div>
						</div>

                        <div class="col-md-4">
							<div class="form-group" id="bill_customer_id_block1">
								<label for="exampleInputEmail1">Customer Name*</label>
								<select class="form-control" id="bill_customer_id"></select>
								<small id="customer_id_error" class="form-text text-muted"></small>
							</div>
							<div class="form-group" id="bill_customer_id_block2" style="display: none;">
								<label for="exampleInputEmail1">Customer Name*</label>	:<label for="exampleInputEmail1" id="edit_customer_name"></label>
							</div>
						</div>
							
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Old Due Amount</label>
								<input type="number" class="form-control text-right" id="net_due_amount" readonly>								
								<small id="rate_type_error" class="form-text text-muted"></small>
							</div>						
						</div>
							
						<div class="col-md-2">
							<div class="form-group">
								<label for="create_date_new">Create Date</label>
								<input type="date" class="form-control text-right" id="create_date_new" value="<?=date('Y-m-d', strtotime($from_date))?>">								
								<small id="create_date_new_error" class="form-text text-muted"></small>
							</div>						
						</div>
					</div>					

					<div class="form-row">
                        <div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Item*</label>
								<select class="form-control" id="bill_item_id">
									<option value="0" selected>---- Select Item ----</option>
								</select>
								<small id="item_id_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Quantity*</label>
								<input type="number" class="form-control text-right" id="bill_item_quantity" placeholder="Quantity" step="1">
								<small id="bill_item_quantity_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Rate</label>
								<input type="number" class="form-control text-right" id="bill_item_rate" placeholder="Rate" step="0.01" <?php if($user_type != '0'){ ?> readonly="readonly" <?php } ?>>
								<input type="hidden" id="hidden_item_amount" value="0.00">
								<small id="bill_item_rate_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">Weight(gm)</label>
								<input type="number" class="form-control text-right" id="bill_net_weight" placeholder="gm" step="0.01" <?php if($user_type != '0'){ ?> readonly="readonly" <?php } ?>>
								<small id="bill_net_weight_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">CGST</label>
								<input type="number" class="form-control text-right" id="bill_cgst_rate" placeholder="GST" step="0.01" <?php if($user_type != '0'){ ?> readonly="readonly" <?php } ?>>
								<input type="hidden" id="cgst_tax_value" value="0.00">
								<small id="bill_cgst_rate_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="exampleInputEmail1">SGST</label>
								<input type="number" class="form-control text-right" id="bill_sgst_rate" placeholder="SGST" step="0.01" <?php if($user_type != '0'){ ?> readonly="readonly" <?php } ?>>
								<input type="hidden" id="sgst_tax_value" value="0.00">
								<small id="bill_sgst_rate_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="exampleInputEmail1">Value</label>
								<input type="number" class="form-control text-right" id="bill_item_value" placeholder="Value" readonly="readonly">
								<input type="hidden" id="tax_value" value="0.00">
								<small id="bill_item_value_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-1">
							<div class="form-group">
							<a type="button" id="addBillItem" style="margin-top: 35px; cursor: pointer;"><i class="fa fa-save" aria-hidden="true"></i></a>
							</div>
						</div>

					</div>

					
					<!-- Item Add Part End -->

					<!-- Table Start -->
					<table class="table table-sm" id="billedItem">
						<thead>
							<tr>
							<th scope="col">Sl.No.</th>
							<th scope="col" class="text-left">Products</th>
							<th scope="col" class="text-left">HS Code</th>
							<th scope="col" class="text-right">Qty</th>
							<th scope="col" class="text-right">Rate</th>
							<th scope="col" class="text-right">Amount</th>
							<th scope="col" class="text-right">Tax Value</th>
							<th scope="col" class="text-right">CGST Rate</th>
							<th scope="col" class="text-right">CGST Amount</th>
							<th scope="col" class="text-right">SGST Rate</th>
							<th scope="col" class="text-right">SGST Amount</th>
							<th scope="col" class="text-right">Net Value</th>
							<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody id="tbody_billedItem">
						</tbody>
						<thead>
							<tr>
							<th scope="col" class="text-center" colspan="3">TOTAL</th>
							<th scope="col" class="text-right"  id="subTotalQty">00</th>
							<th scope="col">&nbsp;</th>
							<th scope="col" class="text-right"  id="subTotalAmount">0.00</th>
							<th scope="col" class="text-right"  id="subTotalTaxValue">0.00</th>
							<th scope="col">&nbsp;</th>
							<th scope="col" class="text-right"  id="subTotalCgst">0.00</th>
							<th scope="col">&nbsp;</th>
							<th scope="col" class="text-right"  id="subTotalSgst">0.00</th>
							<th scope="col" class="text-right" id="fineItemsSubTotal">0.00</th>
							<th scope="col">&nbsp;</th>
							</tr>
						</thead>
						</table>
					<!-- table End -->

					<div class="form-row">						
						<div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputEmail1">Payment Type</label></br>								
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="payment_type" id="cash" value="cash">
									<label class="form-check-label" for="cash">Paid</label>
								</div>

								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="payment_type" id="due" value="due">
									<label class="form-check-label" for="due">Due</label>
								</div>
							</div>
						</div>

						<div class="col-md-2" id="totalCashBlock" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Total cash</label>
								<input type="number" class="form-control text-right" id="totalCash" placeholder="Total cash"  value="0.00">
								<input type="hidden" id="hidden_totalCash" value="0.00" >
								<small id="totalCash_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-2" id="discountTypeBlock" style="display: none;">
							<div class="form-group">
								<label for="discountType"> Discount Type</label>
								<select id="discountType" class="form-control" name="discountType">
									<option value="0">Choose Discount Type</option>
									<option value="1">Fixed</option>
									<option value="2">Percentage</option>
								</select>
								<input type="hidden" id="hidden_discountType" value="0.00" >
								<small id="discountType_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-1" id="discountRateBlock" style="display: none;">
							<div class="form-group">
								<label for="discountRate"> Rate</label>
								<input type="number" class="form-control text-right" id="discountRate" value="0.00">
								<input type="hidden" id="hidden_discountRate" value="0.00" >
								<small id="discountRate_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-1" id="discountAmountBlock" style="display: none;">
							<div class="form-group">
								<label for="discountAmount"> Amount</label>
								<input type="number" class="form-control text-right" id="discountAmount" value="0.00" readonly>
								<input type="hidden" id="hidden_discountAmount" value="0.00" >
								<small id="discountAmount_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-2" id="totalDueBlock" style="display: none;">
							<div class="form-group">
								<label for="exampleInputEmail1">Total Due</label>
								<input type="number" class="form-control text-right" id="dueCash" placeholder="Total Due" readonly>								
								<input type="hidden" value="0.00" id="old_due_amount">
								<small id="dueCash_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-3">
							<div class="form-group mt-4">
								<input type="hidden" name="current_bill_id" id="current_bill_id" value="0">
								<input type="hidden" name="oldDue" id="oldDue" value="0">
								<input type="hidden" name="oldJama" id="oldJama" value="0">
								<input type="hidden" name="user_type" id="user_type" value="<?=$user_type?>">
								<input type="hidden" name="login_id" id="login_id" value="<?=$login_id?>">
								<input type="hidden" name="created_by" id="created_by" value="<?=$created_by?>">

								<!-- Create by user info -->								
								<input type="hidden" name="cb_org_name" id="cb_org_name" value="<?=$cb_user_data->org_name?>">								
								<input type="hidden" name="cb_contact_person" id="cb_contact_person" value="<?=$cb_user_data->contact_person?>">								
								<input type="hidden" name="cb_phone_number" id="cb_phone_number" value="<?=$cb_user_data->phone_number?>">								
								<input type="hidden" name="cb_whatsapp_number" id="cb_whatsapp_number" value="<?=$cb_user_data->whatsapp_number?>">								
								<input type="hidden" name="cb_email_id" id="cb_email_id" value="<?=$cb_user_data->email_id?>">								
								<input type="hidden" name="cb_address" id="cb_address" value="<?=$cb_user_data->address?>">							
								<input type="hidden" name="cb_pin_code" id="cb_pin_code" value="<?=$cb_user_data->pin_code?>">							
								<input type="hidden" name="cb_gstin_no" id="cb_gstin_no" value="<?=$cb_user_data->gstin_no?>">
								<!-- //Create by user info -->
								<button type="button" class="btn btn-primary" id="createFinalBill">Create Final Bill</button>	
								<small id="addBillItem_error" class="form-text text-muted"></small>
							</div>
						</div>

					</div>

					</form>	

					<!-- Payment History -->
					<div class="form-row" id="paymentHistoryList">					
					</div>
					<div class="form-row" id="discountHistory">					
					</div>
					<!-- Payment History -->

					</div>
					<div class="modal-footer">
					  <!-- <h5>Please check all the details above before the final bill </h5> -->
					</div>
				  </div>
				</div>
				<!-- //The Modal -->

				<?php include('common/footer.php'); ?>

<!-- Select2 Dropdown -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#bill_customer_id').select2({
        dropdownParent: $('#myModalCustomer')
    });
    $('#bill_item_id').select2({
        dropdownParent: $('#myModalCustomer')
    });
    $('#zone_id').select2({
        dropdownParent: $('#myModalCustomer')
    });
    $('#search_cu_id').select2();
</script>
<!-- //Select2 Dropdown -->