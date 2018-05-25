<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Details</title>
    <!--link the bootstrap css file-->
    <link href="<?php echo base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <!--link jquery ui css-->
    <link href="<?php echo base_url('assets/jquery-ui-1.11.2/jquery-ui.min.css'); ?>" rel="stylesheet" type="text/css" />
    <!--include jquery library-->
    <script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
    <!--load jquery ui js file-->
    <script src="<?php echo base_url('assets/jquery-ui-1.11.2/jquery-ui.min.js'); ?>"></script>
        
    <style type="text/css">
    .colbox {
        margin-left: 0px;
        margin-right: 0px;
    }
    </style>
    
    <script type="text/javascript">
    //load datepicker control onfocus
    $(function() {
        $("#hireddate").datepicker();
    });
    </script>
    
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-lg-6 col-sm-6 well">
        <legend>Add User Details</legend>
        <?php 
        $attributes = array("class" => "form-horizontal", "id" => "mst_userform", "name" => "mst_userform");
        echo form_open("mst_user/index", $attributes);?>
        <fieldset>
            
            <!-- <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="id" class="control-label"><?php //echo date('Y-m-d H:i:s'); ?></label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="user_id" name="id" placeholder="id" type="text" class="form-control"  value="<?php //echo set_value('id'); ?>" />
                <span class="text-danger"><?php //echo form_error('id'); ?></span>
            </div>
            </div>
            </div> -->
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="user_id" class="control-label">User Id</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="user_id" name="user_id" placeholder="user_id" type="text" class="form-control"  value="<?php echo set_value('user_id'); ?>" />
                <span class="text-danger"><?php echo form_error('user_id'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="user_role" class="control-label">User Role</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <select id="user_role" name="user_role" placeholder="user_role" type="text" class="form-control"  value="<?php echo set_value('user_role'); ?>">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <span class="text-danger"><?php echo form_error('user_role'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="user_type" class="control-label">User Type</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <select id="user_type" name="user_type" placeholder="user_type" type="text" class="form-control"  value="<?php echo set_value('user_type'); ?>">
                    <option value="internal">Internal</option>
                    <option value="external">External</option>
                </select>
                <span class="text-danger"><?php echo form_error('user_type'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="first_name" class="control-label">First Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="first_name" name="first_name" placeholder="first_name" type="text" class="form-control"  value="<?php echo set_value('first_name'); ?>" />
                <span class="text-danger"><?php echo form_error('first_name'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="last_name" class="control-label">Last Name</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="last_name" name="last_name" placeholder="last_name" type="text" class="form-control"  value="<?php echo set_value('last_name'); ?>" />
                <span class="text-danger"><?php echo form_error('last_name'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="gender" class="control-label">Gender</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="gender" name="gender" placeholder="gender" type="radio" value="Male" /> Male
                <input id="gender" name="gender" placeholder="gender" type="radio" value="Female" /> Female
                <span class="text-danger"><?php echo form_error('gender'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="mobile_no" class="control-label">Mobile No</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="mobile_no" name="mobile_no" placeholder="mobile_no" type="text" class="form-control"  value="<?php echo set_value('mobile_no'); ?>" />
                <span class="text-danger"><?php echo form_error('mobile_no'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="email_id" class="control-label">Email Id</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="email_id" name="email_id" placeholder="email_id" type="text" class="form-control"  value="<?php echo set_value('email_id'); ?>" />
                <span class="text-danger"><?php echo form_error('email_id'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="personal_mobile_no" class="control-label">Personal Mobile No</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="personal_mobile_no" name="personal_mobile_no" placeholder="personal_mobile_no" type="text" class="form-control"  value="<?php echo set_value('personal_mobile_no'); ?>" />
                <span class="text-danger"><?php echo form_error('personal_mobile_no'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="personal_email_id" class="control-label">Personal Email Id</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="personal_email_id" name="personal_email_id" placeholder="personal_email_id" type="text" class="form-control"  value="<?php echo set_value('personal_email_id'); ?>" />
                <span class="text-danger"><?php echo form_error('personal_email_id'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="skype_id" class="control-label">Skype Id</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="skype_id" name="skype_id" placeholder="skype_id" type="text" class="form-control"  value="<?php echo set_value('skype_id'); ?>" />
                <span class="text-danger"><?php echo form_error('skype_id'); ?></span>
            </div>
            </div>
            </div>
            
            <div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="f_time_id" class="control-label">F_Time Id</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="f_time_id" name="f_time_id" placeholder="f_time_id" type="text" class="form-control"  value="<?php echo set_value('f_time_id'); ?>" />
                <span class="text-danger"><?php echo form_error('f_time_id'); ?></span>
            </div>
            </div>
            </div>
            
            <!--<div class="form-group">
            <div class="row colbox">
            <div class="col-lg-4 col-sm-4">
                <label for="is_disable" class="control-label">is_disable</label>
            </div>
            <div class="col-lg-8 col-sm-8">
                <input id="is_currently_login" name="is_disable" placeholder="is_disable" type="radio" value="yes" /> Yes
                <input id="is_currently_login" name="is_disable" placeholder="is_disable" type="radio" value="no" /> No
                <span class="text-danger"><?php //echo form_error('is_disable'); ?></span>
            </div>
            </div>
            </div>-->
            
            <div class="form-group">
            <div class="col-sm-offset-4 col-lg-8 col-sm-8 text-left">
                <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save" />
                <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Cancel" />
            </div>
            </div>
        </fieldset>
        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>
</body>
</html>