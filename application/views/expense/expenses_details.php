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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/plugins/wickedpicker/stylesheets/wickedpicker.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>

        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->                                      
		
   <style>		
 #cost_table { padding:0px; margin:0;   width:100%;}
 
.btn-default.dropdown-toggle { margin-top:-7px; }
.maintenance-sectionn {     padding: 10px;  display: -webkit-box; background:#fff;  }
textarea.form-control { overflow:hidden;}
.Remark { padding-left:6px!important;}
.Expenses-Description { padding-left:6px!important;}
 .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-']
            {
                padding-left:8px;
                padding-right:8px;
            } 
@media only screen and  (min-width:280px)  and (max-width:1020px) { 
 .addkyc .row [class^='col-xs-'], .row [class^='col-sm-'], .row [class^='col-md-'], .row [class^='col-lg-'] 
 { padding:0;  }
 #ptype { margin:0!important;}
 .datepicker{ margin:0!important;}
 .custom-padding .col-md-7 { padding:0!important;}
 .custom-padding .col-md-3 { padding:4px!important;}
 .custom-padding .abs { margin:0!important;}
 .custom-padding .repeatimg .abs { margin:0!important;}
  .custom-padding .btn-container { margin:10px!important;}
  #actual_schedule_div { overflow-x:scroll;}
  #temp_schedule_div { overflow-x:scroll;}
  }				
        </style>	
    </head>
    <body>								
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Expense'; ?>" > Expenses List</a>  &nbsp; &#10095; &nbsp; Expenses Details</div>
                
                <div class="page-content-wrap">
                     <div class="row main-wrapper">
				    	<div class="main-container">           
                          <div class="box-shadow custom-padding">  
                            <form id="form_expense" role="form" class="form-horizontal" method="post" action="<?php if(isset($expense)) { echo base_url().'index.php/Expense/updaterecord/'.$e_id; } else { echo base_url().'index.php/Expense/saverecord'; } ?>">
						      <div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0; width:100%;" >
                                   <div class="panel panel-default">								
                                     <div class="panel-body box-padding faq">
                                       <div class="panel-body panel-group accordion"  >
                                          <div class="panel  panel-primary">
                                        <a href="#accOneColOne">   
                                            <div class="panel-heading">
                                                <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span> Expense </h4>
                                            </div>   
                                        </a>
                                      <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                      
										<div class="form-group" style="border-top: 1px dotted #ddd;">
										
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label"> Select Property</label>
													<div class="col-md-8">
													  <select  class="form-control" name="property" id="property" onchange="loadsubproperty();">
														<option value="">Select Property</option>  
														<?php for ($i=0; $i < count($property); $i++) { ?>
															<option value="<?php echo $property[$i]->txn_id; ?>" <?php if(isset($expense)) { if($expense[0]->property_id == $property[$i]->txn_id) { echo "selected";}} ?>><?php echo $property[$i]->p_property_name; ?></option>
														<?php } ?>
													  </select>
													</div>
												</div>
											</div>
											<div class="col-md-6" id="sub_property_div">
												<div class="">
													<label class="col-md-4 control-label"> Select Sub Property</label>
													<div class="col-md-8">
													  <select  class="form-control" name="sub_property" id="sub_property" onload="loadsubproperty();">
														<option value="">Select Sub Property</option>                                          
													  </select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label"> Vendor Name <span  class="asterisk_sign prop_other_name"> * </span></label>
													<div class="col-md-8">
														<input type="hidden" id="vendor_id" name="vendor" class="form-control" value="<?php if(isset($expense[0]->vendor_id)) { echo $expense[0]->vendor_id; } ?>" />
														<input type="text" id="vendor" name="vendor_name" class="form-control auto_client" value="<?php if(isset($expense[0])) { echo $expense[0]->contact_name; } ?>" placeholder="Type to choose contact from database..." />
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-12">
												<label class="col-md-2 control-label" style="padding-left: 0px;"> Expenses Description </label>
												<div class="col-md-10 Expenses-Description" >
													<textarea class="form-control" rows="4" placeholder=" Expenses Description" name="description" ><?php if(isset($expense)) { echo $expense[0]->expense_description; } ?></textarea>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												<div class="">                                        
													<label class="col-md-4 control-label"> Y o Y Escalations </label>
													<div class="col-md-8">
														<input type="text" class="form-control format_number" name="escalations" placeholder="Y o Y Escalations" value="<?php if(isset($expense)) { echo $expense[0]->escalation; } ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-6" >
												<div class="">
													<label class="col-md-4 control-label" > Expense Date <span  class="asterisk_sign prop_other_name"> * </span></label>
													<div class="col-md-8">
														<input type="text" class="form-control datepicker" name="expense_date" placeholder="Select  Expense Date" value="<?php if(isset($expense)) { if ($expense[0]->expense_date!=null && $expense[0]->expense_date!="") echo date('d/m/Y',strtotime($expense[0]->expense_date)); } ?>" />
													</div>
												</div>
											</div>
										</div>
											
										<div class="form-group">
											<div class="col-md-6">
												<div class="">                                        
													<label class="col-md-4 control-label"> Expense Amount <span  class="asterisk_sign prop_other_name"> * </span></label>
													<div class="col-md-8">
														<input type="text" class="form-control format_number" name="expense_amount" placeholder="Expense Amount" value="<?php if(isset($expense)) { echo format_money($expense[0]->expense_amount,2); } ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label"> Category <span  class="asterisk_sign prop_other_name"> * </span></label>
													<div class="col-md-8">
														<select  class="form-control" name="category">
															<option value="">Select Category</option>    
															<?php for ($i=0; $i < count($expense_category); $i++) { ?>
																<option value="<?php echo $expense_category[$i]->id; ?>" <?php if(isset($expense)) { if($expense_category[$i]->id == $expense[0]->category) { echo "selected";}} ?>><?php echo $expense_category[$i]->expense_category; ?></option>
															<?php } ?> 
														</select>
													</div>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-12">
												<label class="col-md-2 control-label" > Remark </label>
												<div class="col-md-10 Remark">
													<textarea class="form-control" rows="4" name="maker_remark" ><?php if(isset($expense)) { echo $expense[0]->maker_remark; } ?></textarea>
												</div>
											</div>
										</div>


                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="">
                                                <label class="col-md-4 control-label"> Payment Time <span  class="asterisk_sign prop_other_name"> * </span></label>
                                                <div class="col-md-8">
                                                    <input type="radio" name="payment_time" class="icheckbox" value="now" id="payment_time_now" data-error="#err_payment_time" <?php if (isset($expense)) { if($expense[0]->payment_time=='now') echo 'checked'; } ?>/>&nbsp;&nbsp;Now&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="payment_time" class="icheckbox" value="later" id="payment_time_later" data-error="#err_payment_time" <?php if (isset($expense)) { if($expense[0]->payment_time=='later') echo 'checked'; } ?>/>&nbsp;&nbsp;Later
                                                    <div id="err_payment_time"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="show-payment-mode" style="<?php if (isset($expense)) { if($expense[0]->payment_time!='now') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                            <div class="">
                                                <label class="col-md-4 control-label"> Payment Mode </label>
                                                <div class="col-md-8">                                                                  
                                                    <select   class="form-control" name="payment_mode" id="payment_mode">
                                                        <option value="">Select Payment Mode </option>
                                                        <option value="Cash" <?php if(isset($expense)) { if($expense[0]->payment_mode=='Cash') { echo "selected";} } ?>> Cash </option>
                                                        <option value="Cheque" <?php if(isset($expense)) { if($expense[0]->payment_mode=='Cheque') { echo "selected";} } ?>> Cheque </option>
                                                        <option value="NEFT" <?php if(isset($expense)) { if($expense[0]->payment_mode=='NEFT') { echo "selected";} } ?>> DD & NEFT/RTGS </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="show-payment" style="<?php if (isset($expense)) { if($expense[0]->payment_time=='later' || $expense[0]->payment_mode!='Cheque') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="">                                        
                                                    <label class="col-md-4 control-label"> Cheque No. </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="cheque_no" name="cheque_no" placeholder="Cheque No." value="<?php if(isset($expense)) { echo $expense[0]->cheque_number; } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" >
                                                <div class="">
                                                    <label class="col-md-4 control-label" > Cheque Date </label>
                                                    <div class="col-md-8">
                                                    	<input type="text" class="form-control datepicker" id="cheque_date" name="cheque_date" placeholder="Select Cheque Date"  value="<?php if(isset($expense)) { if ($expense[0]->cheque_date!=null && $expense[0]->cheque_date!="") echo date('d/m/Y',strtotime($expense[0]->cheque_date)); } ?>" />
                                                    </div>
                                                </div>
                                            </div>                    
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="">                                        
                                                    <label class="col-md-4 control-label"> Bank Name  </label>
                                                    <div class="col-md-8">
                                                        <input type="hidden" class="form-control" id="bank_name_id" name="bank_name" value="<?php if(isset($expense)) { echo $expense[0]->bank_name; } ?>"/>
                                                        <input type="text" class="form-control auto_bank" id="bank_name" name="bank_name_name" placeholder="Type to choose bank...." value="<?php if(isset($expense)) { echo $expense[0]->bank_name_name; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="">                                        
                                                    <label class="col-md-4 control-label"> Cheque Amount(In &#x20B9;) </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control format_number" id="cheque_amount" name="cheque_amount" placeholder="Cheque Amount" value="<?php if(isset($expense)) { echo $expense[0]->cheque_amount; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="">                                        
                                                    <label class="col-md-4 control-label"> MICR Code </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="micr_code" name="micr_code" placeholder="MICR Code" value="<?php if(isset($expense)) { echo $expense[0]->micr_code; } ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>

                                    <div id="show-neft" style="<?php if (isset($expense)) { if($expense[0]->payment_time=='later' || $expense[0]->payment_mode!='NEFT') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <div class="">                                        
                                                    <label class="col-md-4 control-label"> Ref No. </label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="ref_no" name="ref_no" placeholder="Ref No." value="<?php if(isset($expense)) { echo $expense[0]->ref_no; } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br clear="all">
                                    </div>

										<!-- <br clear="all"> -->


                                    <div id="show-task" style="<?php if (isset($expense)) { if($expense[0]->payment_time!='later') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label class="col-md-4 control-label">From Date</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control datepicker" id="from_date" name="from_date" value="<?php if(isset($expense[0]->from_date)) echo date('d/m/Y',strtotime($expense[0]->from_date));?>" placeholder="From Date"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control timepickermask" id="from_time" name="from_time" value="<?php if(isset($expense[0]->from_time)) echo $expense[0]->from_time;?>" placeholder="From Time"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 to-date">
                                                <label class="col-md-4 control-label">To Date</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control datepicker" id="to_date" name="to_date" value="<?php if(isset($expense[0]->to_date)) echo date('d/m/Y',strtotime($expense[0]->to_date));?>" placeholder="To Date"/>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control timepickermask" id="to_time"  name="to_time" value="<?php if(isset($expense[0]->to_time)) echo $expense[0]->to_time;?>" placeholder="To Time"/>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <div class="col-md-6">                                                  
                                                <label class="col-md-4 control-label">Frequency</label>
                                                <div class="col-md-6"> 
                                                        <select class="form-control" name="repeat" id="repeat">
                                                          <option value="Never" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Never') echo "selected";}?> >Never</option>
                                                          <option value="Daily" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Daily') echo "selected";}?> >Daily</option>
                                                          <option value="Periodically" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Periodically') echo "selected";}?> >Periodically</option>
                                                          <option value="Weekly" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Weekly') echo "selected";}?> >Weekly</option>
                                                          <option value="Monthly" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Monthly') echo "selected";}?> >Monthly</option>
                                                          <option value="Yearly" <?php if(isset($expense[0]->repeat_status)){ if($expense[0]->repeat_status=='Yearly') echo "selected";}?> >Yearly</option>                                                               
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group" id="repeat-periodically">
                                            <div class="col-md-12">
                                                <label class="col-md-2 control-label"> Interval after </label>
                                                <div class="col-md-2">
                                                    <select class="form-control" id="periodic_interval" name="periodic_interval">
                                                        <option value="">Select</option>
                                                        <?php for($i=1;$i<=30;$i++){
                                                            $selected='';
                                                            if(isset($expense[0]->period_interval)){
                                                                if($expense[0]->repeat_status=='Periodically' && $i==$expense[0]->period_interval){
                                                                    $selected='selected';
                                                                }
                                                            } else {
                                                                $selected='';
                                                            }
                                                            echo '<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
                                                        } ?>
                                                    </select>
                                                </div> 
                                                <label class="control-label">  Days </label>
                                            </div>
                                        </div>


											<div class="form-group" id="repeat-weekly">
												<div class="col-md-12">
													<label class="col-md-2 control-label"> Interval</label>
													<div class="col-md-8" style="line-height:31px;">  
														<?php $week_days=array();
															if(isset($expense[0]->repeat_status)){
																if($expense[0]->repeat_status=='Weekly'){
																	if(isset($expense[0]->period_interval)){
																		$week_days=explode(',',$expense[0]->period_interval);
																	}
																}
															}
														?>

														<input type="hidden" name="weekday" value="" data-error="#weekday_error" />
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Mon" <?php if(in_array('Mon',$week_days)) echo "checked='checked'";?>/>&nbsp;Mon&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Tue" <?php if(in_array('Tue',$week_days)) echo "checked='checked'";?>/>&nbsp;Tue&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Wed" <?php if(in_array('Wed',$week_days)) echo "checked='checked'";?>/>&nbsp;Wed&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Thu" <?php if(in_array('Thu',$week_days)) echo "checked='checked'";?>/>&nbsp;Thu&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Fri" <?php if(in_array('Fri',$week_days)) echo "checked='checked'";?>/>&nbsp;Fri&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sat" <?php if(in_array('Sat',$week_days)) echo "checked='checked'";?>/>&nbsp;Sat&nbsp;&nbsp;
														<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sun" <?php if(in_array('Sun',$week_days)) echo "checked='checked'";?>/>&nbsp;Sun&nbsp;&nbsp;
														<div id="weekday_error"></div>
													</div>
												</div>
											</div>

											<div class="form-group" id="repeat-monthly">
												<div class="col-md-12">
													<label class="col-md-2 control-label"> Interval</label>
													<div class="col-md-2" style="margin-right:0;">
														<select class="form-control " name="monthly_interval">
															<option value="">Select</option>
															<?php for($i=1;$i<=12;$i++){
																$selected='';
																if(isset($expense[0]->period_interval)){
																	if($expense[0]->repeat_status=='Monthly' && $i==$expense[0]->period_interval){
																		$selected='selected';
																	}
																} else {
																	$selected='';
																}
																echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
															} ?>
														</select>
													</div>
													<label class=" control-label col-md-2 " style="padding-left:0px; margin-left:-30px;" >  every month ON</label>
													<div class="col-md-2"> 
														<select class="form-control" name="monthly_interval2">
															<option value="">Select</option>
															<?php for($i=1;$i<=30;$i++){
																$selected='';
																if(isset($expense[0]->monthly_repeat)){
																	if($expense[0]->repeat_status=='Monthly' && $i==$expense[0]->monthly_repeat){
																		$selected='selected';
																	}
																} else {
																	$selected='';
																}
																echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
															} ?>
														</select>
													</div>
													<label class=" control-label">  day of the month</label>
												</div>
											</div>
										</div>
									</div>
								   </div>
									   </div>
								     </div>
									</div>
								</div>
								 <br clear="all"/>
							 </div>	
							<div class="panel-footer" style="clear:both;">
										<input type="hidden" id="submitVal" value="1" />
										<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger" >Cancel</a>
										<input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
										<input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
									</div>								 
                            </form>
						 </div>	
                      </div>
                     </div>
                  </div>
				</div>   
                <!-- END PAGE CONTENT WRAPPER -->
                     
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
		 </div>				
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/wickedpicker/src/wickedpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>

        <script type="text/javascript">
            function loadsubproperty(){
                var clientid = document.getElementById("property").value;
                var expid=<?php if(isset($expense)) { echo $e_id; } else { echo '0'; }?>;

                var xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                        var data = xmlhttp.responseText;
                        document.getElementById('sub_property').innerHTML = data;
                        if(data==''){
                            $("#sub_property_div").hide();
                        } else {
                            $("#sub_property_div").show();
                        }
                    }
                };
                xmlhttp.open("POST", "<?php echo base_url().'index.php/Expense/loadsubproperty/'; ?>" + clientid  + "/" + expid , true);
                xmlhttp.send();
            }
        </script>
        <script>
            $(function() {
                if($('#mySelectList').children('option').length>0){
                    $("#sub_property_div").show();
                } else {
                    $("#sub_property_div").hide();
                }
                
                $('#repeat-periodically').hide(); 
                $('#repeat-monthly').hide();
                $('#repeat-weekly').hide();
				
				if($('#repeat').val() == 'Never') {
					$('.to-date').hide();
				}

                $('#repeat').change(function(){
                    if($('#repeat').val() == 'Never') {
						$('.to-date').hide();
					}
					else{
						$('.to-date').show();
					}
					if($('#repeat').val() == 'Periodically') {
                        $('#repeat-monthly').hide(); 
                        $('#repeat-periodically').show(); 
                        $('#repeat-weekly').hide();
                    } 
                    else if($('#repeat').val() == 'Monthly') {              
                        $('#repeat-periodically').hide(); 
                        $('#repeat-monthly').show(); 
                        $('#repeat-weekly').hide();
                    }
                    else if($('#repeat').val() == 'Never' || $('#repeat').val() == 'Daily' || $('#repeat').val() == 'Yearly') {$('#repeat-periodically').hide(); 
                        $('#repeat-weekly').hide(); 
                        $('#repeat-monthly').hide();            
                    }
                    else if($('#repeat').val() == 'Weekly') {               
                        $('#repeat-periodically').hide(); 
                        $('#repeat-monthly').hide();
                        $('#repeat-weekly').show(); 
                    }
                    else{
                        //alert($('#repeat').val());
                    }
					

                });
            });

            $(function() {
    			// $('#show-payment').hide();
    			$('#payment_mode').change(function(){
    				if($('#payment_mode').val() == 'Cheque') {
    					$('#show-payment').show();
    				} else {
    					$('#show-payment').hide();

    				}
                    if($('#payment_mode').val() == 'NEFT') {
                        $('#show-neft').show();
                    } else {
                        $('#show-neft').hide();
                    }
    			});
    		});
            $(function(){
                $('.timepickermask').wickedpicker();                        
            });
            $(document).ready(function() {
                if($('#repeat').val() != 'Never' || $('#repeat').val() != 'Daily' || $('#repeat').val() != 'Yearly'){
                    var divId=$('#repeat').val();
                    $('#repeat-'+divId.toLowerCase()).show(); 
                }
                if($('#payment_time_later').is(":checked")){
                    $('#show-task').show();
                }
                loadsubproperty();
                $('input[type=radio][name=payment_time]').on('ifClicked', function () {
                    if (this.value == 'now') {
                        $('#show-payment-mode').show();
                        $('#show-task').hide();
                    }
                    else if (this.value == 'later') {
                        $('#show-payment-mode').hide();
                        $('#show-payment').hide();
                        $('#show-neft').hide();
                        $('#show-task').show();
                    }
                });
            });
        </script>
    </body>
</html>