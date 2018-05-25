<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		
		 <style>
			  .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-']
            {
                padding-left:8px;
                padding-right:8px;
            } 
	
			.row [id^='repeat-bank-sign'] {padding-right:8px;}
		 </style>
		
    </head>
    <body>								
    	<!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>      
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/bank'; ?>" > Bank Details List </a>  &nbsp; &#10095; &nbsp; Bank Details</div>               
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    <div class="row main-wrapper">					
					<div class="main-container">           
                         <div class="box-shadow">
                            <form id="form_bank" role="form" class="form-horizontal" method="post" action="<?php if(isset($bankdetail)) { echo base_url().'index.php/bank/updatebank/'.$b_id; } else {echo base_url().'index.php/bank/savebank'; }?>">

                                <div class="box-shadow-inside">
                                <div class="col-md-12" >
                                     <div class="panel panel-default border-none">
								   <div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>
                                <div class="panel-heading">
                            		<h3 class="panel-title" style="text-align: center; float: initial;"><strong>Bank Details</strong></h3>
                                </div>
                                                
                             
								

								<div class="panel-body">
									<div class="" style="border-top:none; ">
										<div class="form-group" style="border:none; ">
											<div class="col-md-6 col-sm-4 col-xs-6">
												<div class="">
													<label class="col-md-3 control-label">Owner <span class="asterisk_sign">*</span></label>
													<div class="col-md-9">
														<input type="hidden" id="owner_name_id" name="owner_name" data-error="#owner_error" class="form-control" value="<?php if(isset($bankdetail[0]->b_ownerid)){ echo $bankdetail[0]->b_ownerid; } else { echo ''; }?>" />
														<input type="text" id="owner_name" name="owner_contact_name" class="form-control auto_non_legal_contact_owner" value="<?php if(isset($bankdetail[0]->owner_name)){ echo $bankdetail[0]->owner_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
														<div id="owner_error"></div>
													</div>
												</div>
											</div>
											<div class="col-md-6  col-sm-4 col-xs-6">
												<div class="">
													<label class="col-md-3 control-label">Reg Address</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_address" placeholder="Registered Address" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_address; } ?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="form-group" style="border:none; ">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Reg Phone</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_phone" placeholder="Registered Phone" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_phone; } ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Reg Email</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="registered_email" placeholder="Registered Email" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_email; } ?>" />
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="panel-body panel-group accordion"  >
                                    <div class="panel  panel-primary" id="panel-bank-details">
										<a href="#accOneColOne">   
											<div class="panel-heading">
		                                       	<h4 class="panel-title">
		                                           <span class="fa fa-check-square-o"> </span>  Bank Details
		                                        </h4>
		                                    </div>   
	                                    </a>  

										<div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                            <div class="form-group" style="border-top:1px solid #ddd; padding-top:10px;">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank Name <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="bank_name" placeholder="Bank Name" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_name; } ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank Branch <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="bank_branch" placeholder="Bank Branch" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_branch; } ?>" />
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank Address <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="bank_address" placeholder="Bank Address" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_address; } ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label" style="padding-left: 0px; padding-right: 5px;">Bank Landmark</label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="bank_landmark" placeholder="Bank Landmark" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_landmark; } ?>" />
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank City</label>
															<div class="col-md-9">
																<input type="hidden" name="bank_city_id" id="bank_add_city_id" />
                                                        		<input type="text" class="form-control autocompleteCity" name="bank_city" id ="bank_add_city" placeholder="Bank City" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_city; } ?>"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank Pincode</label>
															<div class="col-md-9">
                                                        		<input type="text" class="form-control" name="bank_pincode" id ="bank_add_pincode" placeholder="Bank Pincode" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_pincode; } ?>"/>
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank State</label>
															<div class="col-md-9">
																<input type="hidden" name="bank_state_id" id="bank_add_state_id" />
                                                        		<input type="text" class="form-control loadstatedropdown" name="bank_state" id ="bank_add_state" placeholder="Bank State" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_state; } ?>"/>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Bank Country</label>
															<div class="col-md-9">
                                                        		<input type="hidden" name="bank_country_id" id="bank_add_country_id" />
                                                        		<input type="text" class="form-control loadcountrydropdown" name="bank_country" id ="bank_add_country" placeholder="Bank Country" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_country; } ?>"/>
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Account Type <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<select class="form-control" name="account_type">
																	<option value="">Select</option>
																	<option value="Savings" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Savings') echo 'selected'; } ?>>Savings</option>
																	<option value="Current" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Current') echo 'selected'; } ?>>Current</option>
																	<option value="Overdraft" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Overdraft') echo 'selected'; } ?>>Overdraft</option>
																	<option value="Loan" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Loan') echo 'selected'; } ?>>Loan</option>
																</select>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Account No. <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="account_no" placeholder="Account No" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_accountnumber; } ?>" />
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">IFSC Code <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="ifsc" placeholder="IFSC Code" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_ifsc; } ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Customer ID</label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="customer_id" placeholder="Customer ID" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_customerid; } ?>" />
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label" >Bank Phone No.</label>
															<div class="col-md-9">
																<input type="text" class="form-control" name="phone_no" placeholder="Bank Phone no" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_phone_number; } ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label"  >Relationship Manager</label>
															<div class="col-md-9">
																<input type="hidden" id="relation_manager_id" name="relation_manager" class="form-control" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_relationshipmanager; } ?>" />
	                                                            <input type="text" id="relation_manager" name="relation_manager_name" class="form-control auto_client" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->c_name; } ?>" placeholder="Type to choose contact from database..." />
	                                                            <!-- <button class="btn btn-info mb-control sch" id="schedule_btn" data-box="#message-box-info" style="margin-left: 2px;">+</button> -->
																<!-- <input type="text" class="form-control" name="relation_manager" onkeyup="approvalFlag();"  placeholder="Relationship Manager" value="<?php //if(isset($bankdetail)) {echo $bankdetail[0]->b_relationshipmanager; } ?>" /> -->
															</div>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Opening Balance <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control format_number" name="opening_balance" placeholder="Opening Balance" value="<?php if(isset($bankdetail)) {echo format_money($bankdetail[0]->b_openingbalance,2); } ?>" />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-3 control-label">Balance Ref Date <span class="asterisk_sign">*</span></label>
															<div class="col-md-9">
																<input type="text" class="form-control datepicker1" name="b_bal_ref_date" id="payment_date" placeholder="Balance Ref Date" value="<?php if (isset($bankdetail)) {if($bankdetail[0]->b_bal_ref_date!='') echo date("d/m/Y",strtotime($bankdetail[0]->b_bal_ref_date));}?>" placeholder=""/>
															</div>
														</div>
													</div>
												</div>
     							 <div class="col-md-12 btn-margin">
												<a href="#accOneColTwo" >
	          									<button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a> </div>
											</div>
										</div>
										
										<div class="panel panel-primary" id="panel-authorised_signatory">
											<a href="#accOneColTwo">  
												<div class="panel-heading">
			                                        <h4 class="panel-title">
			                                        <span class="fa fa-check-square-o"> </span>    Authorised Signatory
			                                        </h4>
			                                    </div>  
			                               </a>      

                                    		<div class="panel-body" id="accOneColTwo">
												<div class="banksign">
													<?php $j=0;
													if(isset($bank_sign)) {
														for ($j=0; $j < count($bank_sign) ; $j++) { 
													?>

													<div class="form-group" id="repeat-bank-sign_<?php echo $j+1; ?>" style="<?php if($j==0) echo 'border-top: 1px dotted #ddd;'; ?>">
														<div class="col-md-1" style="padding-left:0px;">
															<label class="col-md-12 control-label"><?php echo $j+1 ?> <span class="asterisk_sign">*</span></label>
														</div>
														<div class="col-md-4">
                                                            <input type="hidden" id="auth_name_<?php echo $j+1; ?>_id" name="auth_name[]" data-error="#auth_name_<?php echo $j+1; ?>_error" class="form-control" value="<?php if(isset($bank_sign[$j]->ath_contactid)){ echo $bank_sign[$j]->ath_contactid; } else { echo ''; }?>" />
                                                            <input type="text" id="auth_name_<?php echo $j+1; ?>" name="auth_contact_name[]" class="form-control auto_client auth_name" value="<?php if(isset($bank_sign[$j]->c_name)){ echo $bank_sign[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                                                            <div id="auth_name_<?php echo $j+1; ?>_error"></div>
														</div>
														<div class="col-md-4">
															<input type="text"  class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_purpose;  } ?>" />
														</div>
				                                        <div class="col-md-3">
															<select class="form-control" name="auth_type[]" id="auth_type_<?php echo $j+1; ?>">
																<option value="">Select</option>
										                        <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Sole') echo 'selected';  } ?>>Sole</option>
										                        <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Joint') echo 'selected';  } ?>>Joint</option>
									                    	</select>
														</div>
													</div>
													<?php  }} else { ?>
													<div class="form-group" id="repeat-bank-sign_<?php echo $j+1; ?>" style="border-top: 1px dotted #ddd;">
														<div class="col-md-1" style="padding-left:0px;">
															<label class="col-md-12 control-label">1 <span class="asterisk_sign">*</span></label>
														</div>
														<div class="col-md-4">
                                                            <input type="hidden" id="auth_name_<?php echo $j+1; ?>_id" name="auth_name[]" data-error="#auth_name_<?php echo $j+1; ?>_error" class="form-control" value="" />
                                                            <input type="text" id="auth_name_<?php echo $j+1; ?>" name="auth_contact_name[]" class="form-control auto_client auth_name" value="" placeholder="Type to choose contact from database..." />
                                                            <div id="auth_name_<?php echo $j+1; ?>_error"></div>
														</div>
														<div class="col-md-4">
															<input type="text"  class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="" />
														</div>
				                                        <div class="col-md-3">
															<select class="form-control" name="auth_type[]" id="auth_type_<?php echo $j+1; ?>">
																<option value="">Select</option>
										                        <option>Sole</option>
										                        <option >Joint</option>
									                    	</select>
														</div>
													</div>
													<?php } ?>
												</div>
												
													<div class="col-md-12  btn-margin">
														<div class="">
																<div class=" ">  
																	<button class="btn btn-success repeat-bank-sign" style="margin-left: 0px;" name="addhufbtn">+</button>
                                                					<button type="button" class="btn btn-success reverse-bank-sign" style="margin-left: 10px;">-</button>
																	<!-- <button type="button" class="btn btn-info mb-control sch" style="float:right;" data-box="#message-box-info"><span class="fa fa-plus"></span> Add Contact</button> -->
																</div>
														</div>
													</div>                                                                                                                                     <!-- start contact popup -->
	                                    
											</div>
										</div>
										 <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                        <a href="#accOneColfour"> 
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                            </div>
                                        </a>                                 
                                        <div class="panel-body" id="accOneColfour">
										    <div class="remark-container1">
                                                <div class="form-group" style="background: none;border:none">
                                                   <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($bankdetail)){ echo $bankdetail[0]->maker_remark;}?></textarea>
                                                        <!-- <label style="margin-top: 5px;">Remark </label> -->
                                                    </div>
                                                   
                                                </div>
                                                </div>
											 </div>
                                        </div>
                                    </div>

									</div>
								</div>

								
                            </div>
					  </div>
					    </div>
					    <div class="panel-footer">
									<input type="hidden" id="submitVal" value="1" />
                                	<a href="<?php echo base_url();?>index.php/bank" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                                </div>
                            </form>
                            
						 
					</div>
				  </div>	
					 
						
                 </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
	    <script type="text/javascript">
	        var BASE_URL="<?php echo base_url()?>";
	    </script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
    	<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

		<script>
		 	jQuery(function(){
			 	var counter = <?php if(isset($bank_sign)) { echo count($bank_sign); } else { echo 1; } ?>;
			    $('.repeat-bank-sign').click(function(event){
			        event.preventDefault();
			        counter++;
			        var newRow = jQuery('<div class="form-group" id="repeat-bank-sign_'+counter+'" style="'+((counter==1)?'border-top: 1px dotted #ddd;':'')+'"><div class="col-md-1" style="padding-left:0px;"><label class="col-md-12 control-label">'+counter+' <span class="asterisk_sign">*</span></label></div><div class="col-md-4"><input type="hidden" id="auth_name_'+counter+'_id" name="auth_name[]" data-error="#auth_name_'+counter+'_error" class="form-control" /><input type="text" id="auth_name_'+counter+'" name="auth_contact_name[]" class="form-control auto_client auth_name" placeholder="Type to choose contact from database..." /><div id="auth_name_'+counter+'_error"></div></div><div class="col-md-4"><input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" /></div><div class="col-md-3"><select class="form-control" name="auth_type[]" id="auth_type_'+counter+'"><option value="">Select</option><option>Sole</option><option>Joint</option></select></div></div>');
			        $('.auto_client', newRow).autocomplete(autocomp_opt);
			        $('.banksign').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
			    });
				$('.reverse-bank-sign').click(function(event){
					if(counter!=1){
		                var id="#repeat-bank-sign_"+(counter).toString();
		                if($(id).length>0){
		                    $(id).remove();
		                    counter--;
		                }
					}
	            });
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				addMultiInputNamingRules('#form_bank', 'input[name="auth_name[]"]', { required: function(element) {
		                                                                                    if($("#submitVal").val()=="0"){
		                                                                                        return true;
		                                                                                    } else {
		                                                                                        return false;
		                                                                                    }
		                                                                                }, 
			                                                                        	messages: {required: "Select correct contact from list"}
		                                                                         	}, "");
    			addMultiInputNamingRules('#form_bank', 'select[name="auth_type[]"]', { required: function(element) {
	                                                                                        if($("#submitVal").val()=="0"){
	                                                                                            return true;
	                                                                                        } else {
	                                                                                            return false;
	                                                                                        }
	                                                                                    } 
                                                                                 	}, "");
			});
		</script>
		<script type="text/javascript">
            $(function() {
              $(".datepicker1").datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',
        changeYear: true });
            });
        </script>
	</body>
</html>