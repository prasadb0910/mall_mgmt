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
     <form id="form_user_assign_details"  class="" method="post" action="<?php if(isset($assignusr[0])) echo base_url().'index.php/Assign/editrecord/'.$assignusr[0]->gu_id; else echo base_url().'index.php/Assign/saverecord'; ?>">
          

						<div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Contact </label>
                                      <input type="hidden" id="contact_person_id" name="contact" class="form-control" value="<?php if(isset($assignusr[0]->gu_cid)){ echo $assignusr[0]->gu_cid; } else { echo ''; }?>" />
                                     <input type="text" id="contact_person" name="contact_name" class="form-control auto_client" value="<?php if(isset($assignusr[0]->gu_name)){ echo $assignusr[0]->gu_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." style="color: #0b385f;" <?php if(isset($assignusr[0]->gu_name)) echo 'disabled';?> />
                                    </div>
                                </div>
                                <div class="col-md-6" style="display:none">
                                    <div class="form-group form-group-default required">
                                        <label id="email">Email</label>
                                       <?php if(isset($assignusr[0]->gu_email)){ echo $assignusr[0]->gu_email; } else { echo ''; }?>
                                    </div>
                                </div>
                               
                            </div>

							
							
						<div class="row clearfix">
                                <div class="col-md-6" style="<?php if(isset($group_details)) if($group_details[0]->maker_checker=='no') echo 'display: none;'; ?>">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Role </label>
													<select class="full-width select2" name="role" id="role"  data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
														<option value="">Select</option>
                                                        <?php for ($i=0; $i < count($roles) ; $i++) { ?>
                                                            <option value="<?php echo $roles[$i]->rl_id; ?>" <?php if (set_value('role')!=null) { if (set_value('role')==$roles[$i]->rl_id) echo 'selected'; } else if(isset($assignusr[0]->assigned_role)){ if ($assignusr[0]->assigned_role==$roles[$i]->rl_id) echo 'selected'; } else { echo ''; }?>><?php echo $roles[$i]->role_name; ?></option>
                                                        <?php } ?>
													</select>
                                    </div>
                                </div>
                              <div class="col-md-6" style="<?php if(isset($group_details)) if($group_details[0]->maker_checker=='no') echo 'display: none;'; ?>">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Owner </label>
													<select multiple="" name="owners[]" class="form-control select" style="display: none; "  data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity" multiple>
                                                        <?php for ($i=0; $i < count($owner) ; $i++) { ?>
                                                            <option value="<?php echo $owner[$i]['id']; ?>" <?php if (isset($user_role_owners)) {echo in_array($owner[$i]['id'],$user_role_owners) ? "selected" : null;} ?>><?php echo $owner[$i]['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                    </div>
                                </div>
                               
                            </div>

							
							


						<div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                        <label>For Assure </label>
                                    <input type="radio" name="assure" id="assure_yes" value="1" data-error="#assure_error" <?php if (isset($assignusr)) { if($assignusr[0]->assure=='1') echo 'checked'; } ?> /> Yes &nbsp; &nbsp; &nbsp; 
                                                    <input type="radio" name="assure" id="assure_no" value="0" data-error="#assure_error" <?php if (isset($assignusr)) { if($assignusr[0]->assure=='0') echo 'checked'; } ?> /> No
                                                    <div id="assure_error"></div>
                                    </div>
                                </div>
                            
                               
                            </div>
		  	<div class="row clearfix">
                          	<div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                        <label >Maker Remark</label>
                                     <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($assignusr)){ echo $assignusr[0]->maker_remark;}?></textarea> 
                                    </div>
                                </div>

                            
                               
                            </div>
							
							  	<div class="row clearfix" style="<?php if(isset($assignusr)) echo ''; else echo 'display: none;';?>">
                          	<div class="col-md-6">
                                     <div class="form-group form-group-default form-group-default-select2 required">
                                        <label >Status</label>
                                     <select class="form-control" name="assigned_status" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                    <option value="Active" <?php if(isset($assignusr)) {if ($assignusr[0]->assigned_status=='Active') echo 'selected';}?>>Active</option>
                                                    <option value="Inactive" <?php if(isset($assignusr)) {if ($assignusr[0]->assigned_status=='Inactive') echo 'selected';}?>>InActive</option>
                                                </select>
                                    </div>
                                </div>
								<div class="col-md-6">
                                 <div class="form-group form-group-default required" style="<?php if(isset($assignusr)) echo ''; else echo 'display: none;';?>">
                                        <label >Remarks</label>
                                       <textarea class="form-control" name="txn_remarks"><?php if(isset($assignusr)) echo $assignusr[0]->txn_remarks;?></textarea>
                                    </div>
                                </div>
                            
                               
                            </div>
							
							
							
       
                                   
                                <div class="panel-footer">
                                    <a class="btn btn-danger" id="reset" href="<?php echo base_url(); ?>index.php/Assign" style="margin-right: 10px;">Cancel</a>
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
        <script>
            $(function() {
                //autocomplete
                $(".auto_client").autocomplete({

                        source: "<?php echo base_url() . 'index.php/Assign/loadcontacts/';?>",
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.value);
                                var email=ui.item.email1;
                                $("#email").html(email);
                                //alert(email);
                                //console.log(email);
                        },
                        minLength: 1
                });
            });

            
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>