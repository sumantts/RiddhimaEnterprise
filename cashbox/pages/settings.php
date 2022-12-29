<?php 
	if(!$_SESSION["login_id"]){header('location:?p=login');}
	include('common/header.php');
    
    $user_type = $_SESSION["user_type"];
	$username = $_SESSION["username"];
	$login_id = $_SESSION["login_id"];
	$created_by = $_SESSION["created_by"];

    $sql = "SELECT * FROM login WHERE login_id = '" .$login_id. "'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_array()){ 
        $username_update = $row['username'];
        $password = $row['password'];
        $bank_ac_info1 = $row['bank_ac_info'];
        $bank_ac_info = json_decode($bank_ac_info1);
    }//end

	?>
        <div id="layoutSidenav">
            <?php include('common/leftmenu.php');?>
            <div id="layoutSidenav_content">
                
            <main>
                    <div class="container">
                    <h3 class="mt-4"><?=$title?></h3>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="#"><?=$title?></a></li>
                        </ol>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg">
                                    <!--<div class="card-header"><h3 class="text-center font-weight-light my-4">Withdrawal/Payment</h3></div>-->
                                    <div class="card-body">
                                        <form>
                                            <div class="form-row">                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="bank_name">Bank Name</label>
                                                        <input class="form-control" id="bank_name" type="text" placeholder="Bank Name" value="<?=$bank_ac_info->bank_name?>" />
								                        <small id="bank_name_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="branch_name">Branch Name</label>
                                                        <input class="form-control" id="branch_name" type="text" placeholder="SBranch Name" value="<?=$bank_ac_info->branch_name?>" />
								                        <small id="branch_name_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="acc_no">A/c No.</label>
                                                        <input class="form-control" id="acc_no" type="number" placeholder="A/c No." value="<?=$bank_ac_info->acc_no?>" />
								                        <small id="acc_no_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="ac_name">A/c Name</label>
                                                        <input class="form-control" id="ac_name" type="text" placeholder="A/c Name" value="<?=$bank_ac_info->ac_name?>" />
								                        <small id="ac_name_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="ifsc_code">IFSC Code</label>
                                                        <input class="form-control" id="ifsc_code" type="text" placeholder="IFSC Code" value="<?=$bank_ac_info->ifsc_code?>" />
								                        <small id="ifsc_code_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="branch_code">Branch Code</label>
                                                        <input class="form-control" id="branch_code" type="text" placeholder="Branch Code" value="<?=$bank_ac_info->branch_code?>" />
								                        <small id="branch_code_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="username">Username</label>
                                                        <input class="form-control" id="username" type="text" placeholder="Username" value="<?=$username_update?>" />
								                        <small id="username_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div>                                               
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="password">Password</label>
                                                        <input class="form-control" id="password" type="password" placeholder="******" value="<?=$password?>" />
								                        <small id="password_error" class="form-text text-muted"></small>
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            
                                            <div class="form-group mt-4 mb-0"><a class="btn btn-primary" href="javascript:void(0)" id="updateSettings">Update</a></div>
								            <small id="settings_update_msg" class="form-text text-muted"></small>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

				
				<?php include('common/footer.php'); ?>