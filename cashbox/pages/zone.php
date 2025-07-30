<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

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
                            <li class="breadcrumb-item"><a href="#">Master Entry</a></li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-12">
							
							<?php if($user_type == 0){?>
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openZoneModal()">Create Zone</a></div>
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
														<th>SL#</th>
														<th>Zone Name</th>
														<th>Area</th>
														<th>Pincode</th>														
														<?php if($user_type == 0){?>
														<th>Action</th>
														<?php }?>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>SL#</th>
														<th>Zone Name</th>
														<th>Area</th>
														<th>Pincode</th>														
														<?php if($user_type == 0){?>
														<th>Action</th>
														<?php }?>
													</tr>
												</tfoot>
												<tbody>	
												<?php
												$i = 1;
												while ($row = $result->fetch_array()){ 
													
												?>
													<tr id="zone_id_<?=$row['zone_id']?>">
														<td><?=$i?></td>
														<td><?=$row['zone_name']?></td>
														<td><?=$row['zone_area']?></td>
														<td><?=$row['zone_pincode']?></td>
														<td>
														<a onclick="updateZoneModal('<?=$row['zone_id']?>')" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
														<a onclick="deleteZone('<?=$row['zone_id']?>')" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
						<h3>Create/Update Zone</h3>
					  <span class="close" onClick="closeZoneModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Zone Name</label>
								<input type="hidden" class="form-control" id="zone_id" value="0">
								<input type="text" class="form-control" id="zone_name" placeholder="Zone Name">
								<small id="zone_name_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Area/Location</label>
								<input type="text" class="form-control" id="zone_area" placeholder="Area/Location">
								<small id="zone_area_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">Pincode</label>
								<input type="number" class="form-control" id="zone_pincode" placeholder="Pincode" >
								<small id="zone_pincode_error" class="form-text text-muted"></small>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="salesman">Salesman</label>
								<select class="form-control" id="salesman_id" name="salesman_id">
									<option value="">Select</opyion>				
								</select>
								<small id="login_id_error" class="form-text text-muted"></small>
							</div>
						</div>

					</div>
					
					<button type="button" class="btn btn-primary" id="saveZone">OK</button>	
					<input type="hidden" id="user_type" value="<?=$user_type?>">
					<input type="hidden" id="created_by" value="<?=$created_by?>">
					<input type="hidden" id="login_id" value="<?=$login_id?>">
					</form>	
					</div>
					<div class="modal-footer">
					  <h3> </h3>
					</div>
				  </div>
				</div>
				<!-- //The Modal -->
				<?php include('common/footer.php'); ?>