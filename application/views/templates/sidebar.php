<nav class="page-sidebar" data-pages="sidebar">
	
	<div class="sidebar-header">
		<img src="<?php echo base_url(); ?>assets/img/logo_white.png" alt="logo" class="brand" data-src="<?php echo base_url(); ?>assets/img/logo_white.png" data-src-retina="<?php echo base_url(); ?>assets/img/logo_white.png" style="min-height: 25px;height: 100%;padding:5px 0px">

		<div class="sidebar-header-controls">
			<button type="button" class="btn btn-xs sidebar-slide-toggle btn-link hidden-md-down" data-pages-toggle="#appMenu"><i class="fa fa-angle-down fs-16"></i>
			</button>
			<button type="button" class="btn btn-link hidden-md-down" id="sidebar_cntrl" data-toggle-pin="sidebar"><i class="fa fs-12" style="color:#000;"></i>
			</button>
		</div>
	</div>
	<div class="sidebar-menu">
			<ul class="menu-items">
			<li class="" style="background:#0d3553!important;color:#fff;">
				<a class="detailed">
					<span class="title">REAMS</span>
					<span class=" open  arrow"></span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
				</li>
		
			<li style="">
				<a href="<?php echo base_url();?>index.php/dashboard" class="detailed">
					<span class="title">Dashboard</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard"></i></span>
			</li>
		
			<li>
				<a href="<?php echo base_url();?>index.php/contacts">
				<span class="title">Contacts</span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-group"></i></span>
				
			</li>
			
						
			<li class="open">
				<a href="javascript:;">
				<span class="title">Properties</span>
				<span class=" open  arrow"></span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-home" aria-hidden="true"></i></span>
				<ul class="sub-menu">
				<li class="">
				<a href="<?php echo base_url();?>index.php/Real_estate_property/">Real Estate</a>
			
				</li>
				<li class="">
				<a href="<?php echo base_url();?>index.php/Non_real_estate_property">Non Real Estate</a>
				
				</li>

				</ul>
			</li>
			
			
				<li class="open">
				<a href="javascript:;">
				<span class="title">Leases</span>
				<span class=" open  arrow"></span>
				</a>
				<span class="icon-thumbnail"><i class="fa fa-money" aria-hidden="true"></i></span>
				<ul class="sub-menu">
			
				<li class="">
				<a href="<?php echo base_url();?>index.php/Rent_real_estate">Rent Real Estate</a>
				
				</li>
				
				<li class="">
				<a href="<?php echo base_url();?>index.php/Rent_non_real_estate">Rent Non Real Estate</a>
				
				</li>
				
				<li class="">
				<a href="<?php echo base_url();?>index.php/Rent_3rd_party">Rent 3rd party</a>
				
				</li>
				
				<li class="">
				<a href="<?php echo base_url();?>index.php/Rent_revenue_sharing">Rent Revenue Sharing</a>
				
				</li>

				</ul>
			</li>
	
		
			
				
			
				
			<li>
				<a href="<?php echo base_url();?>index.php/accounting" class="detailed">
					<span class="title">Accounting</span>
				</a>
					<span class="icon-thumbnail"><i class="fa fa-rupee  "></i></span>
			</li>
			
			<li>
				<a href="<?php echo base_url();?>index.php/task" class="detailed">
					<span class="title">Maintenance</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-edit "></i></span>
			</li>
			<li  style="">
				<a href="<?php echo base_url();?>index.php/reports/view_reports" class="detailed">
					<span class="title">Reports</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-bar-chart-o "></i></span>
			</li>
			
				<li class="#" >
				<a href="<?php echo base_url();?>index.php/sale" class="detailed">
					<span class="title">Sale</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-building-o "></i></span>
			</li>
			<li class="#" style="display: none;">
				<a href="reports.php" class="detailed">
					<span class="title">My Website</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-globe "></i></span>
			</li>
			
				<!--<li class="#" style="background:#0d3553!important;border-bottom:1px solid#245478!important">
				<a href="" class="detailed">
					<span class="title">iDATA</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
				</li>
			
				<li class="#" style="background:#0d3553!important;">
				<a href="" class="detailed">
					<span class="title">Assure</span>
				</a>
				<span class="bg-success icon-thumbnail"><i class="fa fa-dashboard "></i></span>
			</li>-->
			
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>