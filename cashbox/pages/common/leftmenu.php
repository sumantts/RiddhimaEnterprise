<div id="layoutSidenav_nav">
	<nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
		<div class="sb-sidenav-menu">
			<div class="nav">
				<!--<div class="sb-sidenav-menu-heading">Core</div>-->
				<a class="nav-link <?php if($p == 'dashboard'){?>active<?php } ?>" href="?p=dashboard">
					<div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
					Dashboard
				</a>
				<!--<div class="sb-sidenav-menu-heading">Interface</div>-->

				<a class="nav-link collapsed <?php if($p == 'items' || $p == 'customers' || $p == 'users' || $p == 'zone'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Master Entry
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'items' || $p == 'customers' || $p == 'users' || $p == 'zone'){?>show<?php } ?>" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'items'){?>active<?php } ?>" href="?p=items">Items</a>
					<a class="nav-link <?php if($p == 'users'){?>active<?php } ?>" href="?p=users">Users</a>
					<a class="nav-link <?php if($p == 'zone'){?>active<?php } ?>" href="?p=zone">Zone Management</a>				
					</nav>
				</div>

				<a class="nav-link collapsed <?php if($p == 'bill' || $p == 'todays-bill'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts1" aria-expanded="false" aria-controls="collapseLayouts1">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Bill Details
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'bill' || $p == 'todays-bill'){?>show<?php } ?>" id="collapseLayouts1" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'todays-bill'){?>active<?php } ?>" href="?p=todays-bill">Today's Bill</a>
					<!--<a class="nav-link <?php if($p == 'bill'){?>active<?php } ?>" href="?p=bill">Old Bill List</a>-->				
					</nav>
				</div>

				<a class="nav-link collapsed <?php if($p == 'cashbook' || $p == 'gst_report' || $p == 'product_report' || $p == 'zone_report' || $p == 'zone_report_wi_bill' || $p == 'zone_data_sheet'){?>active<?php } ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
					<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
					Reports
					<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
				</a>
				<div class="collapse  <?php if($p == 'cashbook' || $p == 'gst_report' || $p == 'product_report' || $p == 'zone_report' || $p == 'zone_report_wi_bill' || $p == 'zone_data_sheet'){?>show<?php } ?>" id="collapseLayouts2" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
					<nav class="sb-sidenav-menu-nested nav">
					<a class="nav-link <?php if($p == 'cashbook'){?>active<?php } ?>" href="?p=cashbook">Cashbook</a>
					<a class="nav-link <?php if($p == 'gst_report'){?>active<?php } ?>" href="?p=gst_report"> GST report</a>
					<a class="nav-link <?php if($p == 'product_report'){?>active<?php } ?>" href="?p=product_report"> Product report</a>
					<a class="nav-link <?php if($p == 'zone_report'){?>active<?php } ?>" href="?p=zone_report"> Zone Report</a>
					<a class="nav-link <?php if($p == 'zone_report_wi_bill'){?>active<?php } ?>" href="?p=zone_report_wi_bill"> Zone Report W/I Bill</a>
					<a class="nav-link <?php if($p == 'zone_data_sheet'){?>active<?php } ?>" href="?p=zone_data_sheet"> Zone Data Sheet</a>
						
					</nav>
				</div>	
				
				
			</div>
		</div>
	</nav>
</div>