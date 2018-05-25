<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>    
        <!-- META SECTION -->
       
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar1');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>



<div class="page-content-wrapper ">

<div class="content ">



<div class=" container-fluid   container-fixed-lg ">



<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
<li class="breadcrumb-item active "><a href="#">User Details</a></li>

</ol>
<div class="row">






<div class="col-md-12">

<div class=" container-fluid  p-t-20 p-b-5 container-fixed-lg bg-white" >


 <div class="card card-transparent">
      <form id="form_admin_user_assign_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($user)) echo base_url(). 'index.php/Assign/updateadminuser/' . $user[0]->c_id; else echo base_url().'index.php/Assign/saveadminuser'; ?>">
                                   <div class="box-shadow-inside">
                                 <div class="col-md-12" >
                               <div class="panel panel-default">
								
								<div class="panel-body">
									<div class="form-group" style="    ">
										<div class="col-md-12">
											
												<label class="col-md-1 control-label">Full Name <span class="asterisk_sign">*</span></label>
                                                <div class="col-md-3">
                                                    <input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if(isset($user)) echo $user[0]->c_id;?>"/>
                                                    <input type="text" class="form-control" name="con_first_name" placeholder="First Name" value="<?php if(isset($user)) echo $user[0]->c_name;?>"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="con_middle_name" placeholder="Middle Name" value="<?php if(isset($user)) echo $user[0]->c_middle_name;?>"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="con_last_name" placeholder="Last Name" value="<?php if(isset($user)) echo $user[0]->c_last_name;?>"/>
                                                </div>
											
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
                                            <label class="col-md-1 control-label">Email ID <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="con_email_id1" id="con_email_id1" placeholder="Email ID" value="<?php if(isset($user)) echo $user[0]->c_emailid1;?>"/>
                                            </div>
                                            <label class="col-md-4 control-label" style="text-align:right;">Mobile No <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="con_mobile_no1" placeholder="Mobile No" value="<?php if(isset($user)) echo $user[0]->c_mobile1;?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="<?php if(isset($user)) echo ''; else echo 'display: none;';?>">
                                        <div class="col-md-12">
                                            <label class="col-md-1 control-label">Status <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-3">
                                                <select class="form-control" name="con_status">
                                                    <option value="Approved" <?php if(isset($user)) {if ($user[0]->c_status=='Approved') echo 'selected';}?>>Active</option>
                                                    <option value="Rejected" <?php if(isset($user)) {if ($user[0]->c_status=='Rejected') echo 'selected';}?>>InActive</option>
                                                </select>
                                            </div>
                                            <label class="col-md-4 control-label">Remarks <span class="asterisk_sign">*</span></label>
                                            <div class="col-md-4">
                                                <textarea style="overflow: hidden; text-align:justify;" class="form-control" name="con_txn_remarks"><?php if(isset($user)) echo $user[0]->txn_remarks;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 </div>
                                  </div>
                        </div>   
                                <div class="panel-footer">
									<a href="<?php echo base_url(); ?>index.php/assign/adminuser" class="btn btn-danger" type="reset" id="reset">Cancel</a>
                                    <button class="btn btn-success pull-right">Save</button>
                                </div>
							</form>
             
                </div>
                <!-- END PAGE CONTENT WRAPPER -->

        <?php $this->load->view('templates/footer');?>
		            </div>            

        </div>

						
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<?php $this->load->view('templates/script');?>
    
        <script>
		$(document).ready(function() {
		$('.select2').select2();
		});
        </script>

    <!-- END SCRIPTS -->      
    </body>
</html>