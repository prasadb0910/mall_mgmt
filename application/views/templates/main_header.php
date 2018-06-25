<div class="header">

<a href="#" class="btn-link toggle-sidebar hidden-lg-up pg pg-menu" data-toggle="sidebar">
</a>
	<div class="">
		<div class="brand inline">
		
		</div>
	</div>
	<div class="d-flex align-items-center">
		<div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
			<span class="semi-bold"><?php if (isset($userdata['loginname'])) {echo $userdata['loginname'];} ?></span><br> <span class="text-master"><?php if (isset($userdata['username'])) {echo $userdata['username'];} ?></span>
		</div>
		<div class="dropdown pull-right hidden-md-down">
			<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<!--<span class="thumbnail-wrapper d32 circular inline">
					<img src="<?php echo base_url(); ?>assets/img/profiles/Icon-user.png" alt="" data-src="<?php echo base_url(); ?>assets/img/profiles/Icon-user.png" data-src-retina="<?php echo base_url(); ?>assets/img/profiles/Icon-user.png" width="32" height="32">
				</span>-->
				<span class="settings" style="color:#fff"><i class="fa fa-cog" style="font-size:25px"></i></span>
			</button>
			<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
			
		
				<a href="<?php echo base_url().'index.php/dashboard/home'; ?>" style="<?php //if ($userdata['groupid']=='0') echo 'display: none;';?>" class="dropdown-item"><i class="fa fa-dashboard"></i> Dashboard</a>
				
				<a href="<?php echo base_url().'index.php/profile'; ?>" style="<?php //if ($userdata['groupid']=='0') echo 'display: none;';?>" class="dropdown-item"><i class="fa fa-user"></i> User Profile</a>
				
			
				
				
		
					
					<a href="<?php echo base_url().'index.php/assign';?>" class="dropdown-item"><i class="fa fa-user-plus"></i> User </a>
					
					<a href="<?php echo base_url().'index.php/manage'; ?>" <?php //if ($UserRoles==0 || $userdata['maker_checker']=='no') echo 'style="display: none;"'; ?> class="dropdown-item"><i class="fa fa-user"></i> User Roles </a>
				
		
				<a href="<?php echo base_url().'index.php/City_master'; ?>" class="dropdown-item"><i class="fa fa-cog"></i> Settings</a>
			<!--<a class="dropdown-item  mb-control" data-box="#message-box-success" href="#"> <i class="fa fa-lock"></i> Change Password</a>-->
			<a class="dropdown-item"  data-confirmmodal-bind="#confirm_content" data-topoffset="" href="#"> <i class="fa fa-lock"></i>
              Change Password</a>
				<a href="#" class="clearfix bg-master-lighter dropdown-item"  id="confirmModal_ex2"  data-confirmmodal-bind="#confirm_content1">
					<span class="pull-left">Logout</span>
					<span class="pull-right"><i class="pg-power"></i></span>
				</a>
			</div>
		</div>
	</div>
</div>