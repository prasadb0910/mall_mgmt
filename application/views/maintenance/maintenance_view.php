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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{padding:3px 5px;}

@media only screen and (max-width: 660px) { 
	.heading-h2 {
    display: block;   width: 100%;
}
.padding-0 { overflow-x:scroll;}
 .responsive-margin {
    width: 100%;
    background: #fff;
    padding: 6px 15px 3px; margin-top:0px!important;
    text-align: right; margin:0;
}
}
 </style>		
		<style type="text/css">
     .address-remark{width: 17.5%;}
.address-container1{width:82.5%; display:flex;}       
 
.purpose-view { width:20.3%;}
.purpose-details { width:79.7%;}
.custom-padding .rspns{ padding:0;}
  
 @media screen and (max-width: 780px) 
	{
.custom-padding .col-md-6 {
    padding:0px!important;
} 
.form-horizontal .control-label { padding:0 3px!important; }
 
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}

} </style>		 
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/maintenance'; ?>" > Maintenance List</a>  &nbsp; &#10095; &nbsp;    Maintenance View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				     <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> <a class="btn-margin"  href="<?php echo base_url().'index.php/Maintenance/edit/'.$m_id; ?>" > <span class="btn btn-success pull-right btn-font"> Edit </span>  </a> <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/maintenance" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
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
                             <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                          
                               <div id="pdiv" >
                                <div class="panel-body">
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
											<label class="col-md-4 col-sm-5 col-xs-12 position-name control-label"><strong>Property Name: </strong></label>
											<div class="col-md-8 col-sm-7 col-xs-12 position-view">
                                                <?php for ($i=0; $i < count($property) ; $i++) { ?>
                                                    <?php if(isset($maintenance_txn)) { if($property[$i]->txn_id==$maintenance_txn[0]->property_id) { ?>
                                                        <label class="col-md-12 control-label box-border" style="text-align:left;">
                                                            <?php echo $property[$i]->p_property_name; }?>
                                                        </label> 
                                                    <?php } ?>
                                                <?php } ?>
											</div>
										</div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-3 col-sm-5 col-xs-12 position-name control-label"><strong>Sub Property Name: </strong></label>
                                            <div class="col-md-9 col-sm-7 col-xs-12 position-view">
                                            
                                            <?php for ($i=0; $i < count($subproperty) ; $i++) { ?>
                                                <?php if(isset($maintenance_txn)) { if($subproperty[$i]->txn_id==$maintenance_txn[0]->sub_property_id) { ?>
                                                    <label class="col-md-12 control-label box-border" style="text-align:left;">
                                                        <?php echo $subproperty[$i]->sp_name; ?>
                                                    </label>
                                                <?php  } } ?>
                                            <?php } ?>
                                            </div>
                                        </div>
									</div>

                                    <div class="form-group print-form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12 rspns">
                                            <label class="col-md-2 col-sm-12 col-xs-12 address-remark position-name-1   control-label" style="padding-right: 7px;"><strong>Maker Remarks: </strong></label>
                                            <div class="col-md-10 col-sm-12 col-xs-12 address-container1 remark position-view-1 ">
                                                <label class="col-md-12 remark control-label box-border" style="text-align:left;">
                                                    <?php if(isset($maintenance_txn)) { echo $maintenance_txn[0]->maker_remark; } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group print-form-group print-border  ">
                                        <div class="col-md-12 col-sm-12 col-xs-12 rspns">
                                            <label class="col-md-2 col-sm-12 col-xs-12 address-remark position-name-1   control-label" style="padding-right: 7px;"><strong>Checker Remarks: </strong></label>
                                            <div class="col-md-10 col-sm-12 col-xs-12 address-container1 remark position-view-1 ">
                                                <label class="col-md-12 remark control-label box-border" style="text-align:left;">
                                                    <?php if(isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- <div class="form-group">
                                        <div class="col-md-6">
                                            <label class="col-md-4 control-label"><strong>Owner: </strong></label>
                                            <div class="col-md-8">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;">
                                                    <?php /*
                                                             if(isset($owner)){
                                                                $owner_name='';
                                                                foreach($owner as $row){
                                                                    $owner_name=$owner_name.' ,'.$row->owner_name;
                                                                }
                                                                echo substr($owner_name,2);
                                                             }
                                                           */ ?> 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="col-md-4 control-label"><strong>Due Date: </strong></label>
                                            <div class="col-md-8">
                                                <label class="col-md-12 control-label box-border" style="text-align:left;">
                                                    <?php /*if (isset($maintenance_txn)) { if($maintenance_txn[0]->due_date!='' && $maintenance_txn[0]->due_date!=null) echo date('d/m/Y',strtotime($maintenance_txn[0]->due_date)); } */?>
                                                </label>
                                            </div>
										</div>
                                    </div> -->
					            </div>
                    	        <div class="full-width"  style="padding:10px" >
                                	<div class="col-md-12 padding-0">
                                    	<div class="table-stripped">
											<table class="table group table-bordered addschedule table-active">
												<thead  >
													<tr>
														<th style="text-align: center;vertical-align: middle;" width="60">Sr. No.</th>
														<th style="text-align: left;vertical-align: middle;" width="350">Particulars</th>
                                                        <th style="text-align: left;vertical-align: middle;"  width="70">Due Date</th>
                                                        <th style="text-align: left;vertical-align: middle;"  width="100">Frequency</th>
														<th style="text-align: left;vertical-align: middle;"  width="70">Cost  (In &#x20B9;)</th>
                                                        <?php if(isset($tax_details)) { 
                                                                for($j=0;$j<count($tax_details);$j++) {
                                                                    echo '<th>'.$tax_details[$j]->tax_name.'</th>';
                                                        }} ?>
                                                        <th style="text-align: left;vertical-align: middle;"  width="130">Net Amount  (In &#x20B9;)</th>
													</tr>
												</thead>
												<tbody>
                                                    <?php if(isset($maintenance_cost_details)) { for($i=0; $i<count($maintenance_cost_details); $i++) { ?>
                                                        <tr>
                                                            <td style="vertical-align: middle;" align="middle"><?php echo $i+1; ?></td>
                                                            <td><label class=" control-label"><?php if (isset($maintenance_cost_details)) { echo $maintenance_cost_details[$i]->particular; } ?></label></td>
                                                            <td><label class=" control-label"><?php if (isset($maintenance_cost_details)) { if($maintenance_cost_details[$i]->due_date!='' && $maintenance_cost_details[$i]->due_date!=null) echo date('d/m/Y',strtotime($maintenance_cost_details[$i]->due_date)); } ?></label></td>
                                                            <td><label class=" control-label"><?php if (isset($maintenance_cost_details)) { echo $maintenance_cost_details[$i]->frequency; } ?></label></td>
                                                            <td><label class=" control-label"><?php if (isset($maintenance_cost_details)) { echo format_money($maintenance_cost_details[$i]->cost,2); } ?></label></td>
                                                            <?php if(isset($tax_details)) { 
                                                                    for($j=0;$j<count($tax_details);$j++) {
                                                                        echo '<td><label class=" control-label">'.((isset($service_tax_amt[$i][$j]))?format_money($service_tax_amt[$i][$j],2):0).'</label></td>';
                                                            }} ?>
                                                            <td><label class=" control-label"><?php if (isset($net_amount[$i])) { echo format_money($net_amount[$i],2); } ?></label></td>
                                                        </tr>
                                                    <?php }} ?>
                                                    <tr>
                                                        <td colspan="4" align="right" style="vertical-align: middle;"><label class=" control-label">Total Cost  (In &#x20B9;)</label></td>
                                                        <td><label class=" control-label"> <?php if (isset($total_cost)) { echo format_money($total_cost,2); } ?></label></td>
                                                        <?php if(isset($tax_details)) { 
                                                                for($j=0;$j<count($tax_details);$j++) {
                                                                    echo '<td><label class=" control-label">'.((isset($total_service_tax_amt[$j]))?format_money($total_service_tax_amt[$j],2):0).'</label></td>';
                                                        }} ?>
                                                        <td><label class=" control-label"><?php if (isset($total_net_amount)) { echo format_money($total_net_amount,2); } ?></label></td>
                                                    </tr>
												</tbody>
											</table>
                                            <!-- <table class="table group table-bordered" style="margin-top:-21px; padding:0;">
                                                <tr>
                                                    <td colspan="2" align="right" style="vertical-align: middle;"><label class=" control-label">Total Cost </label></td>
                                                    <td width="310" ><label class=" control-label"> <?php //if (isset($total_cost)) { echo format_money($total_cost,2); } ?> Rs</label></td>
                                                </tr>
											</table> -->
										</div>
                                	</div>
								</div>
                             </div> 
							</form>

                            <?php if(isset($maintenance_txn)) { ?>
                            <?php if($maintenance_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Maintenance/update/'.$m_id; ?>">
                                     <div class="panel-body" style="margin-top:0px;">
                                    <div class="row">
									  <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?></textarea>
                                        </div>                                      
                                    </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/maintenance" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } } else if($maintenance_txn[0]->modified_by != '' && $maintenance_txn[0]->modified_by != null) { if($maintenance_txn[0]->modified_by!=$maintenance_by) { if($maintenance_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Maintenance/approve/'.$m_id; ?>">
                                     <div class="panel-body" style="margin-top:0px;">
                                    <div class="row">
                                          <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?></textarea>
                                        </div>                                        
                                    </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/maintenance" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    </div> 
                                </form>

                            <?php } } } } else { ?>

                                <form id="" method="post" action="<?php echo base_url().'index.php/Maintenance/update/'.$m_id; ?>">
                                     <div class="panel-body" style="margin-top:0px;">
                                    <div class="row">
                                        <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?></textarea>
                                        </div>                                       
                                    </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/maintenance" class="btn btn-danger">Cancel</a>
                                        <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                    </div> 
                                </form>

                            <?php } } else if($maintenance_txn[0]->created_by != '' && $maintenance_txn[0]->created_by != null) { if($maintenance_txn[0]->created_by!=$maintenance_by && $maintenance_txn[0]->txn_status != 'In Process') { if($maintenance_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                              
                                <form id="" method="post" action="<?php echo base_url().'index.php/Maintenance/approve/'.$m_id; ?>">
                                     <div class="panel-body" style="margin-top:0px;">
                                    <div class="row">
                                         <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?></textarea>
                                        </div>
                                       
                                    </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/maintenance" class="btn btn-danger">Cancel</a>
                                        <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                        <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                    </div> 
                                </form>

                            <?php } } } } else { ?>
                                
                                <form id="" method="post" action="<?php echo base_url().'index.php/Maintenance/update/'.$m_id; ?>">
                                     <div class="panel-body" style="margin-top:0px;">
                                    <div class="row">
                                          <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                        <div class="col-md-10 address-container1 ">
                                            <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if (isset($maintenance_txn)) { echo $maintenance_txn[0]->txn_remarks; } ?></textarea>
                                        </div>
                                      
                                    </div>
                                    </div>
                                    
                                    <div class="panel-footer">
                                        <a href="<?php echo base_url(); ?>index.php/maintenance" class="btn btn-danger">Cancel</a>
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

            var divToPrint=document.getElementById('pdiv');

              var newWin=window.open('','Print-Window');

              newWin.document.open();
            
              newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} table tr th:first-child{width:10%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:5px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 { }.col-md-6 {width:50%;}.full-width {padding:0!important;}.table-stripped { border:none!important;}.mb-container{margin:0!important;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');

              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>