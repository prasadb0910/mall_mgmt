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
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->                                      
	 
 
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>                    
                 <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/bank'; ?>" > Bank  List </a>  &nbsp; &#10095; &nbsp; Bank  View</div>
                   <div class="pull-right btn-top-margin responsive-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->                                
                                   
									<a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 

                                      <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?><a class="btn-margin" href="<?php echo base_url() . 'index.php/Bank/editbank/' . $b_id; ?>" class=""><span class="btn btn-success pull-right btn-font"> Edit </span>  </a><?php } }  ?>

										    <a class="btn-margin"  href="<?php echo base_url()?>index.php/bank" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                             
                                </div>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row main-wrapper">
                      <div class="main-container">           
                         <div class="box-shadow">   
                         	  <div class="box-shadow-inside">

				 
						
                        <div class="col-md-12" style="padding:0;">
						<div class=" full-width custom-padding">
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                               
                     		<div id="pdiv" >
                                <div class="panel-body">
									<div class="form-group" style="border-top:0px dotted #ddd;">
										<div class="col-md-6 col-sm-6 col-xs-12" >
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Owner Name:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->owner_name; } ?>	</label>
												</div>
											</div>
										</div>
										<div class="col-md-6  col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Registered Add.:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_address; } ?>	</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name control-label"><strong>Registered Phone:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12  control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_phone; } ?>	</label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name control-label"><strong>Registered Email:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_email; } ?>	</label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12  position-name control-label"><strong>Bank Name:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_name; } ?>	</label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name control-label"><strong>Bank Branch:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
												  	<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_branch; } ?> </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Bank Add.:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_address; } ?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Bank Landmark:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_landmark; } ?> </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name control-label"><strong>Bank City:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_city; } ?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Bank Pincode:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_pincode; } ?> </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12  position-name control-label"><strong>Bank State:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_state; } ?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-6  position-name col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name-1 control-label"><strong>Bank Country:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12 position-view-1">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_country; } ?> </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12  position-name control-label"><strong>Account Type:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
											   		<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_accounttype; } ?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name control-label"><strong>Account No.:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
										 			<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_accountnumber; } ?></label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12  position-name control-label"><strong>Customer ID:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_customerid; } ?> </label>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>IFSC Code:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
						 							<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_ifsc; } ?></label> 
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name-1 control-label"><strong>Relationship Manager:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12 position-manager">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->c_name; } ?></label> 
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12  position-name control-label"><strong>Phone no.:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo $bankdetail[0]->b_phone_number; } ?></label> 
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4  col-sm-5 col-xs-12 position-name-1 control-label"><strong>Opening Balance:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12 position-manager">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($bankdetail)) {echo format_money($bankdetail[0]->b_openingbalance,2); } ?></label> 
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Balance Ref Date:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if (isset($bankdetail)) {if($bankdetail[0]->b_bal_ref_date!='') echo date("d/m/Y",strtotime($bankdetail[0]->b_bal_ref_date));}?></label> 
												</div>
											</div>
										</div>
									</div>
									<div class="form-group print-border">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5 col-xs-12  position-name-1 control-label"><strong>Closing Balance:</strong></label>
												<div class="col-md-8 col-sm-7 col-xs-12 position-manager">
													<label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php if(isset($b_closingbalance)) {echo format_money($b_closingbalance,2); } ?></label> 
												</div>
											</div>
										</div>
									</div>
                                </div>


                            	<!-- START DATATABLE -->
								<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
									<h3 class="panel-title"><strong>Authorised Signatory</strong></h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
											<table id="contacts" class="table datatable group table-bordered"  >
												<thead>
													<tr>
													  <th width="21%"> Name</th>
													  <th width="24%">Purpose of AS</th>
													  <th width="24%">Type</th>
													</tr>
												</thead>
												<tbody>
													<?php $j=0;
													if(isset($bank_sign)) {
														for ($j=0; $j < count($bank_sign) ; $j++) { 
													?>
													<tr>
														<td><?php if(isset($bank_sign[$j]->c_name)){ echo $bank_sign[$j]->c_name; } else { echo ''; }?></td>
														<td><?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_purpose;  } ?></td>
														<td><?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_type;  } ?></td>
													</tr>
													<?php  }} ?>
												</tbody>
											</table>
											<div class="row">
												&nbsp;
											</div>
									  	</div>
									</div>
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->
								<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
									<h3 class="panel-title"><strong> Remarks</strong></h3>
								</div>
								<div class="panel-body">
									<div class="form-group row print-form-group" style="border-top: 1px dotted #ddd;">
										<div class="col-md-2"> <label class="col-md-12 remark control-label contact-view">Maker Remarks:</label> </div>
										<div class="col-md-10 remark">
										  	<label class="col-md-12 remark control-label contact-view" style="text-align:left;"><?php if (isset($bankdetail)) { echo $bankdetail[0]->maker_remark; } ?></label> 
										</div>
									</div>
									<div class="form-group row print-form-group print-border">
										<div class="col-md-2"> <label class="col-md-12 remark control-label contact-view">Checker Remarks:</label> </div>
										<div class="col-md-10 remark">
										  	<label class="col-md-12 remark control-label contact-view" style="text-align:left;"><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></label> 
										</div>
									</div>
								</div>
							</div>
							</form>
							
							<?php if(isset($bankdetail)) { ?>
							<?php if($bankdetail[0]->b_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                				<form id="" method="post" action="<?php echo base_url().'index.php/Bank/updatebank/'.$b_id; ?>">
	                                <div class="panel-body" style="padding-top:0px;">
	                                <div class="row">
										<div class="col-md-2  sr" id=""> <label  >Checker Remarks</label> </div> 
                					    <div class="col-md-10  " style="padding-top:10px;">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></textarea>
                						</div>
                                      
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a  class="btn btn-danger" href="<?php echo base_url(); ?>index.php/bank">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                				</form>

							<?php } } } else if($bankdetail[0]->modified_by != '' && $bankdetail[0]->modified_by != null) { if($bankdetail[0]->modified_by!=$contactby) { if($bankdetail[0]->b_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                				<form id="" method="post" action="<?php echo base_url().'index.php/Bank/approverecord/'.$b_id; ?>">
	                                <div class="panel-body" style="padding-top:0px;">
	                                <div class="row">
									   	<div class="col-md-2  sr" id=""> <label >Checker Remarks</label> </div>  
                					    <div class="col-md-10 " style="padding-top:10px;">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></textarea>
                						</div>
                                  
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/bank" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
										<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                
                                    </div> 
                				</form>

							<?php } } } } else { ?>

                				<form id="" method="post" action="<?php echo base_url().'index.php/Bank/updatebank/'.$b_id; ?>">
	                                <div class="panel-body" style="padding-top:0px;">
	                                <div class="row">
									<div class="col-md-2 sr" id=""> <label >Checker Remarks</label> </div>  
                					    <div class="col-md-10" style="padding-top:10px;">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></textarea>
                						</div>
                                     	
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a  class="btn btn-danger" href="<?php echo base_url(); ?>index.php/bank" >Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                				</form>

							<?php } } else if($bankdetail[0]->created_by != '' && $bankdetail[0]->created_by != null) { if($bankdetail[0]->created_by!=$contactby) { if($bankdetail[0]->b_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                				<form id="" method="post" action="<?php echo base_url().'index.php/Bank/approverecord/'.$b_id; ?>">

	                                <div class="panel-body" style="padding-top:0px;">
	                                <div class="row">
										<div class="col-md-2 sr " id=""> <label >Checker Remarks</label> </div>
                					    <div class="col-md-10 " style="padding-top:10px;">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></textarea>
                						</div>
									
                                        
                                        </div>
                                        </div>
                                         
                						<div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/bank" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
											<input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    
                                        </div> 
                				</form>


							<?php } } } } else { ?>
								
                				<form id="" method="post" action="<?php echo base_url().'index.php/Bank/updatebank/'.$b_id; ?>">
	                                <div class="panel-body" style="padding-top:0px;">
	                                <div class="row">
										<div class="col-md-2 sr" id=""> <label >Checker Remarks</label> </div>  
                					    <div class="col-md-10 ">
                							<textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($bankdetail)) { echo $bankdetail[0]->txn_remarks; } ?></textarea>
                						</div>
                                     
                                    </div>
                                    </div>
                                         
            						<div class="panel-footer">
                                        <a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/bank" >Cancel</a>
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

           
                newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:40%;}.col-md-6 {width:50%;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>