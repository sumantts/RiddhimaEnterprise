<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
	
	$user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

	$sql = "SELECT * FROM holiday_list ORDER BY holiday_date ASC";	
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
								<div class="form-group mt-1 mb-1"><a class="btn btn-primary" href="#" id="btn" onClick="openHolidayModal()">Add New</a></div>
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
														<th>Title</th>
														<th>Date</th> 														
														<?php if($user_type == 0){?>
														<th>Action</th>
														<?php }?>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>SL#</th>
														<th>Title</th>
														<th>Date</th> 														
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
													<tr id="h_id_<?=$row['h_id']?>">
														<td><?=$i?></td>
														<td><?=$row['holiday_title']?></td>
														<td><?=date('d-F-Y', strtotime($row['holiday_date']))?></td> 
														<td>
														<a onclick="updateHolidayModal('<?=$row['h_id']?>')" style="cursor: pointer;"><i class="fa fa-edit" aria-hidden="true"></i></a>
														<a onclick="deleteHoliday('<?=$row['h_id']?>')" style="cursor: pointer;"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
						<h3>Create/Update <?=$title?></h3>
					  <span class="close" onClick="closeHolidayModal()">&times;</span>
					  
					</div>
					<div class="modal-body">
						
					<form>
					<div class="form-row">
                        <div class="col-md-8">
							<div class="form-group">
								<label for="holiday_title">Title</label>
								<input type="hidden" class="form-control" id="h_id" value="0">
								<input type="text" class="form-control" id="holiday_title" >
								<small id="holiday_title_error" class="form-text text-muted"></small>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="holiday_date">Date</label>
								<input type="date" class="form-control" id="holiday_date" >
								<small id="holiday_date_error" class="form-text text-muted"></small>
							</div>
						</div> 
					</div>
					
					<button type="button" class="btn btn-primary" id="saveHoliday">OK</button>	
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