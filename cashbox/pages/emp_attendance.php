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
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openItemModal()">Add Items</a></div>
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
						<h3>Add/Update Item</h3>
					  <span class="close" onClick="closeItemModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Item Name</label>
								<input type="hidden" class="form-control" id="item_id" value="0">
								<input type="text" class="form-control" id="item_name" placeholder="Item Name">
								<small id="item_name_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<!-- <div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Rate</label>
								<input type="number" class="form-control" id="item_rate" placeholder="Rate" value="0">
								<small id="item_rate_error" class="form-text text-muted"></small>
							</div>
						</div> -->
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">HS Code</label>
								<input type="number" class="form-control" id="hs_code" placeholder="HS Code">
								<small id="hs_code_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">CGST Rate</label>
								<input type="number" class="form-control" id="cgst_rate" placeholder="CGST Rate" value="2.50">
								<small id="cgst_rate_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">							
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">SGST Rate</label>
								<input type="number" class="form-control" id="sgst_rate" placeholder="SGST Rate" value="2.50">
								<small id="sgst_rate_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Quantity</label>
								<input type="number" class="form-control" id="item_quantity" placeholder="Quantity" value="<?=$stock_lower_limit?>">
								<input type="hidden" id="hidden_stock_lower_limit" value="<?=$stock_lower_limit?>">
								<small id="item_quantity_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Stokist Price</label>
								<input type="number" class="form-control" id="stokist_price" placeholder="Stokist Price" value="0.00">
								<small id="stokist_price_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">							
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Dealer Price</label>
								<input type="number" class="form-control" id="dealer_price" placeholder="Dealer Price" value="0.00">
								<small id="dealer_price_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Wholesaler Price</label>
								<input type="number" class="form-control" id="wholesaler_price" placeholder="Wholesaler Price" value="0.00">
								<small id="wholesaler_price_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Retailer Price</label>
								<input type="number" class="form-control" id="retailer_price" placeholder="Retailer Price" value="0.00">
								<small id="retailer_price_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					<div class="form-row">							
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Net Weight/Packet(gm)</label>
								<input type="number" class="form-control" id="net_weight" placeholder="Net Weight/Packet" value="0.00">
								<small id="net_weight_error" class="form-text text-muted"></small>
							</div>
						</div>
					</div>

					
					<button type="button" class="btn btn-primary" id="saveItem">OK</button>	
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