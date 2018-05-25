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
	<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
	<!-- EOF CSS INCLUDE -->                                      
	<style>   
 @media screen and (max-width: 780px) 
	{
.custom-padding .col-md-6 {
    padding:0px!important;
}

.form-horizontal .control-label { padding:0 3px!important; }
 .custom-padding .address-remark { padding:0 10px!important; }
 
.sr{ text-align:left; margin:0!important;}

 .address-container1 { width:96%; text-align:left; margin:10px!important;}
.custom-padding .rspns { padding:0!important;}
.custom-padding .remark  { }
.custom-padding .col-md-10{ padding:0!important;}
}

@media screen and (min-width: 781px) and (max-width:991px){ 
.custom-padding .control-label { padding:0 2px!important; }

.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:98%; text-align:left;margin:0 7px!important;}
 .custom-padding .col-md-10  { padding:0 2px!important; }
 
}
</style>
</head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
              <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Expense'; ?>" > Expense List</a>  &nbsp; &#10095; &nbsp;    Expense View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				    <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> <a class="btn-margin"  href="<?php echo base_url().'index.php/Expense/edit/'.$e_id; ?>"> 
					<span class="btn btn-success pull-right btn-font"> Edit </span> </a> <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/Expense" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                  </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				    <div class="row main-wrapper">
					  <div class="main-container">           
					    <div class="box-shadow">   
					       <div class="box-shadow-inside">	
					          <div class="col-md-12" style="padding:0;">	
					            <div class="full-width custom-padding" >
					            	<div class="panel panel-default">
										<form id="form_expense" role="form" class="form-horizontal" action="">                           
										 <div id="pdiv" >    
											<div class="panel-body">
												<div class="form-group" style="border-top:0px dotted #ddd;">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Select Property:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->p_property_name; } ?></label>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12" id="sub_property_div">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Select Sub Property:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->sp_name; } ?></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Vendor Name:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->contact_name; } ?></label>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Category:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->expense_category; } ?></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 Expenses control-label"><strong>Expenses Description:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12  ">
															<label class="col-md-12 remark control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->expense_description; } ?></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Y o Y Escalations:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->escalation; } ?></label>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Expense Date:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { if ($expense[0]->expense_date!=null && $expense[0]->expense_date!="") echo date('d/m/Y',strtotime($expense[0]->expense_date)); } ?></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Expense Amount:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo format_money($expense[0]->expense_amount,2); } ?></label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-md-6 col-sm-6 col-xs-12">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Payment Time:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->payment_time; } ?></label>
														</div>
													</div>
													<div class="col-md-6 col-sm-6 col-xs-12" style="<?php if (isset($expense)) { if($expense[0]->payment_time!='now') echo 'display: none;'; } else echo 'display: none;'; ?>">
														<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Payment Mode:</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12">
															<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->payment_mode; } ?></label>
														</div>
													</div>
												</div>


                                <div id="show-payment" style="<?php if (isset($expense)) { if($expense[0]->payment_time=='later' || $expense[0]->payment_mode!='Cheque') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Cheque No.:</strong></label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->cheque_number; } ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Cheque Date:</strong></label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { if ($expense[0]->cheque_date!=null && $expense[0]->cheque_date!="") echo date('d/m/Y',strtotime($expense[0]->cheque_date)); } ?></label>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Bank Name:</strong></label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->bank_name_name; } ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Cheque Amount:</strong></label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->cheque_amount; } ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>MICR Code:</strong></label>
                                            <div class="col-md-8 col-sm-7 col-xs-12">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->micr_code; } ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


												<div id="show-task" style="<?php if (isset($expense)) { if($expense[0]->payment_time!='later') echo 'display: none;'; } else echo 'display: none;'; ?>">
													<div class="form-group">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>From Date:</strong></label>
															<div class="col-md-2 rspns col-sm-6 col-xs-12">
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->from_date)) echo date('d/m/Y',strtotime($expense[0]->from_date));?></label>
															</div>
															<div class="col-md-3  col-sm-6 col-xs-12">
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->from_time)) echo $expense[0]->from_time;?></label>
															</div>
														</div>
														<div class="col-md-6 col-sm-6 col-xs-12">
															<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>To Date:</strong></label>
															<div class="col-md-2 rspns col-sm-6 col-xs-12">
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->to_date)) echo date('d/m/Y',strtotime($expense[0]->to_date));?></label>
															</div>
															<div class="col-md-3 col-sm-6 col-xs-12">
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->to_time)) echo $expense[0]->to_time;?></label>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="col-md-6 col-sm-6 col-xs-12">                                                  
															<label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Frequency:</strong></label>
															<div class="col-md-8 col-sm-7 col-xs-12"> 
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->repeat_status)){ echo $expense[0]->repeat_status;} ?></label>                                                               
															</div>
														</div>
													</div>
														
													<div class="form-group" style="<?php if (isset($expense)) { if($expense[0]->repeat_status!='Periodically') echo 'display: none;'; } else echo 'display: none;'; ?>">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<label class="col-md-4  col-sm-5 col-xs-12  control-label"><strong>Interval after:</strong></label>
															<div class="col-md-8 col-sm-7 col-xs-12">
																<label class="control-label" style="text-align:left;"><?php if(isset($expense[0]->period_interval)) { echo $expense[0]->period_interval; } ?></label>
																<label class="control-label">  Days </label>
															</div>
														</div>
													</div>

													<div class="form-group" style="<?php if (isset($expense)) { if($expense[0]->repeat_status!='Weekly') echo 'display: none;'; } else echo 'display: none;'; ?>">
														<div class="col-md-6 col-sm-6 col-xs-12">
															<label class="col-md-4  col-sm-5 col-xs-12 Interval control-label"><strong>Interval:</strong></label>
															<div class="col-md-8 col-sm-7 col-xs-12 Interval-1 ">  
																<label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->period_interval)) { echo $expense[0]->period_interval; } ?></label>
															</div>
														</div>
													</div>


                                    <div class="form-group" style="<?php if (isset($expense)) { if($expense[0]->repeat_status!='Monthly') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label"><strong>Interval:</strong></label>
                                            <div class="col-md-2" style="margin-right:0;">
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->period_interval)) { echo $expense[0]->period_interval; } ?></label>
                                            </div>
                                            <label class=" control-label col-md-2 " style="padding-left:0px; margin-left:-30px;" ><strong>every month ON</strong></label>
                                            <div class="col-md-2"> 
                                                <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->monthly_repeat)) { echo $expense[0]->monthly_repeat; } ?></label>
                                            </div>
                                            <label class=" control-label">  day of the month</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="show-neft" style="<?php if (isset($expense)) { if($expense[0]->payment_time=='later' || $expense[0]->payment_mode!='NEFT') echo 'display: none;'; } else echo 'display: none;'; ?>">
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="">                                        
                                                <label class="col-md-4  col-sm-5 col-xs-12 control-label"><strong>Ref No.</strong></label>
                                                <div class="col-md-8 col-sm-7 col-xs-12">
                                                    <label class="col-md-12 control-label" style="text-align:left;"><?php if(isset($expense[0]->ref_no)) { echo $expense[0]->ref_no; } ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group print-form-group">
                                    <div class="col-md-12">
                                        <label class="col-md-2 control-label"><strong>Maker Remark:</strong></label>
                                        <div class="col-md-10 ">
                                            <label class="col-md-12 remark control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->maker_remark; } ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group print-form-group  print-border">
                                    <div class="col-md-12">
                                        <label class="col-md-2 control-label"><strong>Checker Remark:</strong></label>
                                        <div class="col-md-10 ">
                                            <label class="col-md-12 remark control-label" style="text-align:left;"><?php if(isset($expense)) { echo $expense[0]->txn_remarks; } ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>



										<?php if(isset($expense)) { ?>
										<?php if($expense[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
										  
											<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Expense/updaterecord/'.$e_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														<label class="col-md-2 address-remark control-label"><strong>Remarks:</strong></label>
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($expense[0])){ echo $expense[0]->txn_remarks; } else { echo ''; }?></textarea>
														</div>
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger">Cancel</a>
													<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
												</div> 
											</form>

										<?php } } } else if($expense[0]->modified_by != '' && $expense[0]->modified_by != null) { if($expense[0]->modified_by!=$expenseby) { if($expense[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
										  
											<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Expense/approve/'.$e_id; ?>">
												<div class="panel-body" style="margin-top:10px;">
													<div class="row">
													<label class="col-md-2 address-remark control-label"><strong>Remarks:</strong></label>
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($expense[0])){ echo $expense[0]->txn_remarks; } else { echo ''; }?></textarea>
														</div>
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger">Cancel</a>
													<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
													<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
												</div> 
											</form>

										<?php } } } } else { ?>

											<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Expense/updaterecord/'.$e_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														<label class="col-md-2 address-remark control-label"><strong>Remarks:</strong></label>
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($expense[0])){ echo $expense[0]->txn_remarks; } else { echo ''; }?></textarea>
														</div>
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger">Cancel</a>
													<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
												</div> 
											</form>

										<?php } } else if($expense[0]->created_by != '' && $expense[0]->created_by != null) { if($expense[0]->created_by!=$expenseby && $expense[0]->txn_status != 'In Process') { if($expense[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
										  
											<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Expense/approve/'.$e_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														<label class="col-md-2 address-remark control-label"><strong>Remarks:</strong></label>
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($expense[0])){ echo $expense[0]->txn_remarks; } else { echo ''; }?></textarea>
														</div>
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger">Cancel</a>
													<input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
													<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
												</div> 
											</form>

										<?php } } } } else { ?>
											
											<form id="" method="post" class="form-horizontal" action="<?php echo base_url().'index.php/Expense/updaterecord/'.$e_id; ?>">
													<div class="panel-body" style="margin-top:10px;">
													<div class="row">
														<label class="col-md-2 address-remark control-label"><strong>Remarks:</strong></label>
														<div class="col-md-10 address-container1">
															<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($expense[0])){ echo $expense[0]->txn_remarks; } else { echo ''; }?></textarea>
														</div>
													</div>
												</div>
													 
												<div class="panel-footer">
													<a href="<?php echo base_url(); ?>index.php/Expense" class="btn btn-danger">Cancel</a>
													<input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
												</div> 
											</form>

										<?php } } } ?>


								 </div>
						        </div>
							  </div>
						   </div>
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
            
$(document).ready(function(){
        $('.table').addClass('table-active table table-bordered');    
  });

      </script>

 <script>


       $('.printdiv').click(function(){

            $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")


            


            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();

              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 { }.col-md-6 {width:50%;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');



              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>