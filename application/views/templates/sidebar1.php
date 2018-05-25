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
		  <?php if ($Groups==1) { ?>
   
    <li  <?php if ($Groups==0) echo 'style="display: none;"'; ?>>
      <a href="<?php echo base_url().'index.php/groups'; ?>" class="menu--link" title="">
       <span class="title">Groups</span>
       	
      </a>
	  <span class="bg-success icon-thumbnail"><i class="fa fa-group"></i></span>
    </li> <?php } else { ?>
   
  
    <li>
        <a   href="<?php echo base_url().'index.php/dashboard/'; ?>">  
    
		 <span class="title">REAMS</span>
       </a>
	     <span class="bg-success icon-thumbnail"><i class="fa fa-tachometer"></i></span>
    </li>

    <li>
        <a  href="<?php echo base_url().'index.php/login/idata'; ?>">  
		 <span class="title">iDATA</span>
       </a>
	     <span class="bg-success icon-thumbnail"><i class="fa fa-tachometer"></i></span>
    </li>
	   
 
   
    <li>
        <a  href="<?php echo base_url().'index.php/login/assure'; ?>">  
        <span class="title">Assure</span>
        
       </a>
	   	<span class="bg-success icon-thumbnail"><i class="fa fa-tachometer"></i></span>
    </li>
 
    <?php } ?>

		
	
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>

 
