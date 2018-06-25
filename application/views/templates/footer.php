<style>.message-box {
    display: none;
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}
</style>
<div id="confirm_content1" style="display:none">
	<div class="logout-containerr">
		<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
		<div class="confirmModal_header"> <span class="fa fa-sign-out"></span> Log <strong>Out</strong> ? </div>
		<div class="confirmModal_content">
			<p>Are you sure you want to log out?</p>                    
			<p>Press No if you want to continue work. Press Yes to logout current user.</p>
		</div>
		<div class="confirmModal_footer">
			<a href="<?php echo base_url();?>index.php/login/logout" class="btn btn-success ">Yes</a>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">No</button>
		</div>
	</div>
</div>



	<!--<div class="message-box message-box-success animated fadeIn" id="message-box-success">
	<form id="form_change_password" role="form" class="form-horizontal" method="post" action="" novalidate="novalidate" autocomplete="Off">
    <div class="mb-container" style="background: rgb(255, 255, 255); /*left: 350px; top: 25%;*/ width: 50%;">
        <div class="mb-middle">
            <div class="mb-title" style="color: #4d4d4d;"><span class="fa fa-check"></span> Change password </div>
            <div class="mb-content">
            	 
                <div class="col-md-12" style="box-shadow: none;">
					<div class="col-md-12" style="box-shadow: none;">
						<label class="control-label">Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" value="">
						</div>
					</div>
					<div class="col-md-12" style="box-shadow: none;">
						<label class="control-label">New Password *</label>
						<div>
							<input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" value="">
						</div>
					</div>
					<div class="col-md-12" style="box-shadow: none;">
						<label class=" control-label">Confirm Password *</label>
						<div class="  ">
							<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" value="">
						</div>
					</div>
				</div>
				 
            </div>
            <div class="mb-footer">
            	<a class="btn btn-success pull-left" id="btn_change_password" href="javascript:void(0);">Submit</a>
                <button class="btn btn-danger pull-right mb-control-close">Close</button>
            </div>
        </div>
    </div>
    </form>
</div>-->

<div id="confirm_content" style="display:none">
	<button type="button" class="close" data-confirmmodal-but="cancel">×</button>
	<form id="form_change_password" role="form" class="form-horizontal" action="" method="post" novalidate="novalidate" autocomplete="Off">
		<div class="confirmModal_header">  <span>  Change password </span>  </div>
		<div class="confirmModal_content">
				<div class=" ">
					<div class="col-md-12">
						<label class="control-label">Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="password" id="password" placeholder=" " value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class="control-label">New Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="new_password" id="new_password" placeholder=" " value=""/>
						</div>
					</div>
					<div class="col-md-12 ">
						<label class=" control-label">Confirm Password *</label>
						<div class=" ">
							<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder=" " value=""/>
						</div>
					</div>
					<br clear="all"/>
				</div>
		</div>
		<div class="confirmModal_footer">
		  <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
			<button type="submit" class="btn btn-success " id="submit_form_change_password" >Submit</button>
			<button type="button" class="btn btn-danger " data-confirmmodal-but="cancel">Cancel</button>
		</div>
	</form>
</div> 

