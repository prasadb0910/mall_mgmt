<nav class="page-sidebar" data-pages="sidebar">
	<div class="sidebar-overlay-slide from-top" id="appMenu">
		<div class="row">
			<div class="col-xs-6 no-padding">
				<a href="#" class="p-l-40"><img src="<?php echo base_url(); ?>assets/img/demo/social_app.svg" alt="socail">
				</a>
			</div>
			<div class="col-xs-6 no-padding">
				<a href="#" class="p-l-10"><img src="<?php echo base_url(); ?>assets/img/demo/email_app.svg" alt="socail">
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 m-t-20 no-padding">
				<a href="#" class="p-l-40"><img src="<?php echo base_url(); ?>assets/img/demo/calendar_app.svg" alt="socail">
				</a>
			</div>
			<div class="col-xs-6 m-t-20 no-padding">
				<a href="#" class="p-l-10"><img src="<?php echo base_url(); ?>assets/img/demo/add_more.svg" alt="socail">
				</a>
			</div>
		</div>
	</div>
	<div class="sidebar-header">
		<img src="<?php echo base_url(); ?>assets/img/logo_white.png" alt="logo" class="brand" data-src="<?php echo base_url(); ?>assets/img/logo_white.png" data-src-retina="<?php echo base_url(); ?>assets/img/logo_white_2x.png" style="min-height: 25px;height: 100%;">
		<div class="sidebar-header-controls">
			<button type="button" class="btn btn-xs sidebar-slide-toggle btn-link hidden-md-down" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
			</button>
			<button type="button" class="btn btn-link hidden-md-down" data-toggle-pin="sidebar"><i class="fa fs-12" style="color:#000;"></i>
			</button>
		</div>
	</div>
	<div class="sidebar-menu">
		<ul class="menu-items">
			<li style="<?php if ($userdata['groupid']=='0') echo 'display: none;';?>">
				<a href="<?php echo base_url().'index.php/dashboard/home'; ?>" class="detailed">
					<span class="title">Dashboard</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard"></i></span>
			</li>
			<li class="open" <?php if ($Properties==0 && $Sale==0) echo 'style="display: none;"'; ?>>
				<a href="javascript:;">
					<span class="title">Properties</span>
					<span class=" open  arrow"></span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-building-o" aria-hidden="true"></i></span>
				<ul class="sub-menu">
					<li <?php if ($Purchase==0) echo 'style="display: none;"'; ?>>
						<a href="<?php echo base_url().'index.php/purchase'; ?>">List</a>
						<span class="icon-thumbnail">Co</span>
					</li>
					<li <?php if ($Sale==0) echo 'style="display: none;"'; ?>>
						<a href="<?php echo base_url().'index.php/sale'; ?>">Sold</a>
						<span class="icon-thumbnail">OW</span>
					</li>
				</ul>
			</li>
			<li <?php if ($Rent==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/rent'; ?>" class="detailed">
					<span class="title">Leases</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-file-text-o "></i></span>
			</li>
			<li <?php if ($Loan==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/loan'; ?>" class="detailed">
					<span class="title">Loan</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-building-o"></i></span>
			</li>
			<!-- <li class="open" <?php //if ($Loan==0) echo 'style="display: none;"'; ?>>
				<a href="javascript:;">
					<span class="title">Loan</span>
					<span class=" open  arrow"></span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-building-o" aria-hidden="true"></i></span>
				<ul class="sub-menu">
					<li  <?php //if ($Loan==0) echo 'style="display: none;"'; ?>>
						<a href="<?php //echo base_url().'index.php/loan'; ?>">Loan</a>
						<span class="icon-thumbnail">Co</span>
					</li>
					<li  <?php //if ($Loan==0) echo 'style="display: none;"'; ?>>
						<a href="<?php //echo base_url().'index.php/loan_disbursement'; ?>">Loan Disbursement</a>
						<span class="icon-thumbnail">OW</span>
					</li>
				</ul>
			</li> -->
			<li <?php if ($BankEntry==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/Accounting'; ?>" class="detailed">
					<span class="title">Accounting</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-list-alt  "></i></span>
			</li>
			<li <?php if ($Association==0) echo 'style="display: none;"'; ?>>
				<a href="javascript:;">
					<span class="title">Contacts</span>
					<span class=" open  arrow"></span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-group"></i></span>
				<ul class="sub-menu">
					<li class="">
						<a href="<?php echo base_url().'index.php/contacts'; ?>">List Page</a>
						<span class="icon-thumbnail">Co</span>
					</li>
					<li class="">
						<a href="<?php echo base_url().'index.php/contacts/checkstatus/All/Tenants'; ?>">Tenants</a>
						<span class="icon-thumbnail">OW</span>
					</li>
					<li class="">
						<a href="<?php echo base_url().'index.php/contacts/checkstatus/Owners/All'; ?>">Owners</a>
						<span class="icon-thumbnail">OW</span>
					</li>
					<li class="">
						<a href="<?php echo base_url().'index.php/contacts/checkstatus/Others/All'; ?>">Others</a>
						<span class="icon-thumbnail">OW</span>
					</li>
				</ul>
			</li>
			<li <?php if ($Task==0) echo 'style="display: none;"'; ?>>
				<a href="<?php echo base_url().'index.php/task'; ?>" class="detailed">
					<span class="title">Tasks</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-edit "></i></span>
			</li>
			<li <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
				<a href="<?php if ($userdata['groupid']=='0') echo  base_url().'index.php/reports'; else echo  base_url().'index.php/reports/view_reports'; ?>" class="detailed">
					<span class="title">Reports</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-bar-chart-o "></i></span>
			</li>
			<li class="#">
				<a href="reports.php" class="detailed">
					<span class="title">My Website</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-globe "></i></span>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>