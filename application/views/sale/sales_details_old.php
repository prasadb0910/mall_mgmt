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
		body {   -ms-overflow-style: scrollbar;}
			
			
			
			.message-box .mb-container {
			    position: absolute;
			    left: 15px;
			    top: 1%;
				border-radius:10px;
			    background: rgba(0, 0, 0, 0.9);
			    padding: 20px;
			    width: 98%;
			}
			.message-box .mb-container .mb-middle {
			    width: 100%;
			    left: 0%;
			    position: relative;
			    color: #FFF;
			}
			.addschedule td{
				border:1px solid;
				padding:0px !important;
			}
			.addschedule th{
				border:1px solid;
			}
						.dropdown-toggle { margin:0px!important;  }  
.bootstrap-select.form-control:not([class*="span"]) { 
 padding:0 !important;
}

.bootstrap-select.btn-group .dropdown-menu{overflow:auto !important;}

		</style>
	     <style type="text/css">
		  .Property-label .form-group .control-label{ padding:7px 0!important;}
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
.padding-height {padding:6px 10px; overflow:hidden;}
.panel.panel-primary {   border-top:2px solid #33414e!important; }
textarea.form-control { overflow:hidden; min-height:80px;}
.Documents-section .col-md-3, .col-md-4, .col-md-6, col-md-9{ padding:0 3px!important;}
.pending-group {    padding-right: 15px!important;}
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
                        <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Sale'; ?>" > Sales List</a>  &nbsp; &#10095; &nbsp; Sales Details </div>
                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
                       <div class="row main-wrapper">
				    	 <div class="main-container">           
                           <div class="box-shadow custom-padding"> 
						      <div class="panel panel-default">
                                <form id="form_sale" role="form" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php if(isset($s_txn)) { echo base_url().'index.php/Sale/updaterecord/'.$s_id;} else { echo base_url().'index.php/Sale/saverecord';} ?>">
                                <div class="box-shadow-inside">
                                <div class="col-md-12" style="padding:0;" >
                                 <div class="panel panel-default">
							
							   <div id="form_errors" style="display:none; color:#E04B4A;  " class="error"></div>

							     <div class="panel-body faq">
								<div class="panel-body panel-group accordion"  >
									<div class="panel  panel-primary" id="panel-property-details">
										<a href="#accOneColOne">   
		                                    <div class="panel-heading">
		                                        <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>  Property Details </h4>
		                                    </div>   
										</a>  
									    <div class="panel-body panel-body-open  Property-label text1" id="accOneColOne" style="width:100%; ">
										<div class="form-group" style="border-top: 1px dotted #ddd;">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label">Property <span class="asterisk_sign">*</span></label>

													<div class="col-md-8">                                                        
														<select  class="form-control" id="property" name="property" onchange="loadclientdetail();getdocuments();">
															<option value="">Select</option>
																<?php if(isset($s_txn)) { 
																	for($i=0; $i<count($property); $i++) { ?>
																		<option value="<?php echo $property[$i]->txn_id; ?>" <?php if($s_txn[0]->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
																<?php } } else { ?>
																		<?php for($i=0; $i<count($property); $i++) { ?>
																		<option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
																<?php } } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label" style="padding-left:0px;padding-right: 0px;">Sub Property</label>
													<div class="col-md-8">                                                        
														<select id="sub_property" class="form-control" name="sub_property">
															<option value="">Select</option>
															<?php if(isset($s_txn)) { 
																for($i=0; $i<count($sub_property); $i++) { ?>
																	<option value="<?php echo $sub_property[$i]->sp_id; ?>" <?php if($s_txn[0]->sub_property_id == $sub_property[$i]->sp_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
															<?php } } else { ?>
																	<?php for($i=0; $i<count($sub_property); $i++) { ?>
																	<option value="<?php echo $sub_property[$i]->sp_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
															<?php } } ?>
														</select>   
													</div>
												</div>
											</div>
									  	</div>

										<div class="form-group">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-4 control-label">Date of Sale <span class="asterisk_sign">*</span></label>
													<div class="col-md-8">
														<input type="text" class="form-control datepicker" id="sale_date" name="sale_date" placeholder="Date of Sale" value="<?php if(isset($s_txn)) { if(count($s_txn)>0) {echo date('d/m/Y',strtotime($s_txn[0]->date_of_sale));}} ?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="">
											<div class="addbuyer">
											<?php if(isset($s_buyer)) { 
												for ($j=0; $j < count($s_buyer); $j++) { ?>
												<div class="form-group" id="repeat_buyer_<?php echo ($j+1); ?>">
													<div class="col-md-6">
														<div class="">                                        
															<label class="col-md-4 control-label">Buyer Name <?php echo ($j+1); ?> <span class="asterisk_sign">*</span></label>
															<div class="col-md-8">
																<input type="hidden" id="owner_name_<?php echo $j+1;?>_id" name="buyername[]" class="form-control" value="<?php if(isset($s_buyer[$j]->buyer_id)){ echo $s_buyer[$j]->buyer_id; } else { echo ''; }?>" />
	                                                            <input type="text" id="owner_name_<?php echo $j+1;?>" name="owner_contact_name[]" class="form-control auto_contact_owner ownership" value="<?php if(isset($s_buyer[$j]->owner_name)){ echo $s_buyer[$j]->owner_name; } else { echo ''; }?>" placeholder="Type to choose contact or owner from database..." />
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-4 control-label">% share <span class="asterisk_sign">*</span></label>
															<div class="col-md-8">
																<input type="text" class="form-control format_number" id="sharepercent_<?php echo $j+1;?>" name="sharepercent[]" placeholder="%" value="<?php echo format_money($s_buyer[$j]->share_percent,2); ?>" />
															</div>
														</div>
													</div>
												</div>
											<?php }} else { ?>
												<div class="form-group" id="repeat_buyer_1">
													<div class="col-md-6">
														<div class="">                                        
															<label class="col-md-4 control-label">Buyer Name 1 <span class="asterisk_sign">*</span></label>
															<div class="col-md-8">
																<input type="hidden" id="owner_name_1_id" name="buyername[]" class="form-control" />
	                                                            <input type="text" id="owner_name_1" name="owner_contact_name[]" class="form-control auto_contact_owner ownership" placeholder="Type to choose contact or owner from database..." />

															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="">
															<label class="col-md-4 control-label">% share <span class="asterisk_sign">*</span></label>
															<div class="col-md-8">
																<input type="text" class="form-control" id="sharepercent_1" name="sharepercent[]" placeholder="%" value="" />
															</div>
														</div>
													</div>
												</div>
											<?php } ?>
											</div>
										</div>
										
										<div class="">
											<div class="btn-margin">
												<a href="#accOneColTwo" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
												<button class="btn btn-success repeat-buyer" style="" name="addkycbtn">+</button>
            									<button type="button" class="btn btn-success reverse-buyer" style="margin-left: 10px;">-</button>
											 </div>

										</div>
									</div>
									</div>
									<div class="panel  panel-primary" id="panel-sales-consideration">
									 	<a href="#accOneColTwo">   
				                            <div class="panel-heading">
				                            	<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Sales Consideration   </h4>
				                            </div>  
				                        </a>  
										<div class="panel-body" id="accOneColTwo">
										

									 	<div id="temp_schedule_div"></div>												
									 	<div class="show" id="actual_schedule_div" style="padding:10px;">
									 	<div class="table-stripped">
											<table id="contacts" class="table table-bordered group addsummary" style="border-top: 1px solid #ddd; font-size: 12px;">
												<thead>
													<tr>
														<th  width="55px">Sr. No.</th>
														<th  >Type</th>
														<th width="120">Total Cost  (In &#x20B9;)</th>
														<?php //print_r($tax_name);
		                                                    if(isset($tax_name)){
		                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
		                                                        $key=0;
		                                                        foreach($tax_name as $row){
			                                                        echo '<th  >'.$row->tax_type.'</th>';
				                                                    $tax_array[$key]=$row->tax_type;
				                                                    $key++;
			                                                   	} 
			                                                   	//echo '</tr></table></th>';
			                                                  	// print_r($tax_array);
		                                               		}
		                                               	?>
														<th width="120">Net Cost (In &#x20B9;)</th>
													</tr>
												</thead>
												<tbody>
													<?php //print_r($p_schedule);?>
                                                    <?php 
                                                    $j=0;
                                                    $total_basic_cost=0;
                                                    $total_net_amount=0;
                                                    $total_tax_array=array();
                                                    if(isset($p_schedule1)){
                                                    foreach($p_schedule1 as $row_tax) {
                                                        echo '<tr>
                                                        <td>'.($j+1).'</td>
                                                        <td>'.$p_schedule1[$j]["event_type"].'</td>
                                                        
                                                        <td >'.format_money($p_schedule1[$j]["basic_cost"],2).'</td>';
                                                        //echo count($p_schedule[$j]['tax_type']);
                                                       /* if(isset($p_schedule[$j]['tax_type'])){
                                                        for($tcnt=0;$tcnt<$key;$tcnt++){
                                                           // print_r($p_schedule[$j]['tax_type']);
                                                            $tax_amount='';
                                                            if(count($p_schedule[$j]['tax_type'])>=($tcnt+1)){

                                                            if($p_schedule[$j]['tax_type'][$tcnt]==$tax_array[$tcnt]){
                                                                $tax_amount=$p_schedule[$j]['tax_amount'][$tcnt];
                                                            }
                                                        }
                                                            echo '<td>'.$tax_amount.'</td>';
                                                        }
                                                        }*/
														//echo $key;
                                                        $total_basic_cost=$total_basic_cost+$p_schedule1[$j]["basic_cost"];

                                                     	$next_count=0;
                                                        $td_count=0;
														if(isset($p_schedule1[$j]['tax_type'])) {
                                                       		// for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                        	//echo "<br>hi";
                                                          	// echo $key;
                                                            for($tcnt=0;$tcnt<$key;$tcnt++){
                                                                //echo "step1--";
                                                             	for($nc=0;$nc<count($p_schedule1[$j]['tax_type']);$nc++){
	                                                                $tax_amount='';
	                                                                if($p_schedule1[$j]['tax_type'][$nc]==$tax_array[$tcnt])
	                                                                {
	                                                                    $tax_amount=$p_schedule1[$j]['tax_amount'][$nc];
	                                                                   $nc=count($p_schedule1[$j]['tax_type']);
	                                                                   //$tcnt=$key;
	                                                               //}
	                                                                }
	                                                            }
	                                                            if($tax_amount !=''){
	                                                                echo '<td >'.format_money($tax_amount,2).'</td>';
	                                                                $td_count++;
	                                                            } else {
                                                                    //if($next_count )
                                                                    echo '<td >'.format_money($tax_amount,2).'</td>';
                                                                    $td_count++;
                                                                }
                                                               	// $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
                                                          		//  $total_tax_array[$tcnt]= $tax_amount;
                                                           		// print_r($total_tax_array);
                                                    		}
                                                   			// }
														}
                                                    	$inserttd=$key-$td_count;
                                                        if($inserttd !=0){
                                                            for($tdint=0;$tdint<$inserttd;$tdint++){
                                                                echo "<td></td>";
                                                            }
                                                        }

                                                        echo '<td >'.format_money($p_schedule1[$j]["net_amount"],2).'</td></tr>';
                                                        	$total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
														//print_r($p_schedule[$j]['event_type']);
														$j++;
                                                    }?>

													<tr>
	                                                    <td colspan="2"><b>Grand Total</b></td>
	                                                    <td ><?php echo format_money($total_basic_cost,2);?></td>
	                                                    <?php  $k=0;if(isset($total_tax_amount)) {
	                                                    foreach($total_tax_amount as $row){
	                                                        echo '<td >'.format_money($total_tax_amount[$k],2).'</td>';
	                                                    	$k++;
	                                                   	} } ?>
	                                                   <td ><?php echo format_money($total_net_amount,2);?></td>
	                                                </tr>
													<?php } ?>

												</tbody>
											</table>	
															
											<!--<div class="row">
												<button class="btn btn-success repeat-summary" style="margin-left: 10px;">+</button>
											</div>-->
										</div>
										</div>
									 	 
									 
											<div class="btn-margin">
												<a href="#accOneColFive" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
												<button type="button" class="btn btn-info mb-control" data-box="#message-box-info" onclick="opentable(); return false;">Schedule</button>
											</div>
									 

									 	<!-- info -->
										<div class="message-box message-box-info animated fadeIn" id="message-box-info"  >
											<div class="mb-container" style="background:#fff; overflow: auto;max-height: 600px;">
												<div class="mb-middle">
													<div class="mb-title" style="color:#000;text-align:center;">Schedule</div>
													<div class="mb-content">
													<div class="form-group" style="border-top: 1px dotted #ddd;">
														<label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
														<input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload"  onchange="saveTempBulkUpload()" title="Browse file"/>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a>
														<!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
													</div>
														<div class="table-stripped">

															<table id="contacts" class="table group addschedule">
																<thead>
																	<tr>
																		<th style="text-align: center;" width="60">Sr. No.</th>
																		<th  >Type</th>																
																		<th  >Event</th>
																		<!-- <th style="text-align: center;vertical-align: middle;">Payment Type</th>
																		<th style="text-align: center;vertical-align: middle;">Agreement Value</th> -->
																		<th   width="120">Date</th>
																		<th   width="130">Basic Cost  (In &#x20B9;)</th>
																 	<?php //for ($i=0; $i < count($tax) ; $i++) { 
																		 	//echo '<th style="text-align: center;vertical-align: middle;">'.$tax[$i]->tax_name.'</th>';
																		// }
																	?>
																		<th   width="70">Tax(%)</th>
																	</tr>
																</thead>
																<tbody id="schedule_table">
																	<?php
																	//print_r($p_schedule);
																 	$i=0; $schedule_id=1;
																 	if(isset($p_schedule)){
																	foreach($p_schedule as $row){
																	 	$sch_id=$p_schedule[$i]['schedule_id'];
																		$event_type=$p_schedule[$i]['event_type'];
																		$event_name=$p_schedule[$i]['event_name'];
																		$basic_cost=$p_schedule[$i]['basic_cost'];
																		$event_date=date('d/m/Y',strtotime($p_schedule[$i]['event_date']));
																		$tax_master=array();
																		$j=0;
																		if(isset($p_schedule[$i]['tax_type'])){
																			for($j=0;$j<count($p_schedule[$i]['tax_type']);$j++ ){
																				$p_schedule[$i]['tax_id'][$j];
																				$tax_master[]=$p_schedule[$i]['tax_master_id'][$j];
																			}
																		}	?>
																		<tr id="repeat_schedule_<?php echo $i+1; ?>"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle"><?php echo $i+1; ?></td>
																		<input type="hidden"  name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>
																		<td><input type="text"  name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
																		<td><input type="text"  name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
																		<!-- <td><input type="text" name="sch_pay_type[]" class="form-control" value="<?php //echo $event_name;?>" style="border:none; text-align:left;"/></td>
																		<td><input type="radio" name="sch_agree_value[0]" id="sch_agree_yes_1" value="yes" ><span  style="color:#000;">Yes</span> &nbsp;&nbsp;
																		<input type="radio" name="sch_agree_value[0]" id="sch_agree_no_1" value="no" ><span  style="color:#000;">No</span></td> -->																		
																		<td><input type="text"  name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none;"/></td>
																		<td><input type="text"   name="sch_basiccost[]" value="<?php echo format_money($basic_cost,2);?>" class="form-control format_number" style="border:none; text-align:right;"/></td>
																		<td><select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="form-control select" style="display: none;">
																		<?php $schedule_id++;
																		if(isset($tax_details)){
																			//print_r($tax_id);
																			foreach($tax_details as $row){
																				if(in_array($row->tax_id, $tax_master)){
																					//echo "hi";
																					$selected="selected='selected'";
																				}
																				else{
																					$selected='';
																				}
																				echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
																			}
																		};?></select></td>
																		</tr>
																	<?php $i++; } } ?>
																</tbody>
															</table>
														</div>
													</div>
																					
													<div class="mb-footer">
														<button  type="button" class="btn btn-success repeat-schedule" style=" ">+</button>
            											<button  type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
														<button class="btn btn-danger   pull-right mb-control-close" onclick="closetemp(); return false;">Close</button>
														<button  type="button" class="btn btn-success   pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
													</div>
												</div>
											</div>
										</div>			
										</div>

										<input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id-1;?>" />
									</div>

									

									<?php $this->load->view('templates/related_party');?>



									<div class="panel  panel-primary" id="panel-documents" style="margin-bottom:5px;">
									 	<a href="#accOneColFour">   
			                                <div class="panel-heading">
			                                	<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Documents  </h4>
			                                </div>  
			                            </a> 
									 	<div class="panel-body" id="accOneColFour">
											<div id="adddoc">
												<!-- <?php //if(isset($editdocs)) { 
													//for($i=0; $i<count($editdocs); $i++) { ?>
														<div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
															<div class="col-md-2">
						                                    	<input type="hidden" class="form-control" name="doc_id[]" value="<?php //echo $editdocs[$i]->fk_d_id; ?>" />
						                                        <input type="hidden" class="form-control" id="d_m_status_<?php //echo $i; ?>" value="<?php //echo $editdocs[$i]->d_m_status; ?>" />
																<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="Document Name" value="<?php //echo $editdocs[$i]->sl_doc_name; ?>" />
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php //echo $editdocs[$i]->sl_doc_description; ?>" />
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value="<?php //echo $editdocs[$i]->sl_doc_ref_no; ?>"/>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value="<?php //echo date('d/m/Y',strtotime($editdocs[$i]->sl_doc_doi)); ?>"/>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php //echo date('d/m/Y',strtotime($editdocs[$i]->sl_doc_doe)); ?>"/>
															</div>
				                                    		<div class="col-md-2">
																<div class="col-md-8">
																	<input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
																	<div id="doc_<?php //echo $i; ?>_error"></div>
																	<?php //if($editdocs[$i]->sl_document!= '') { ?><a target="_blank" id="doc_file_download_<?php //echo $i; ?>" href="<?php //echo base_url().$editdocs[$i]->sl_document; ?>">Download</a><?php //} ?>
																</div>
					                                            <div class="col-md-4">
					                                            	<a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
					                                            </div>
				                                            </div>
														</div>
												<?php //}} else { 
													//for ($i=0; $i < count($docs) ; $i++) { ?>
														<div id="repeat_doc_<?php //echo $i; ?>" class="form-group">
															<div class="col-md-2">
				                                            	<input type="hidden" class="form-control" name="doc_id[]" value="<?php //echo $docs[$i]->d_id; ?>" />
				                                            	<input type="hidden" class="form-control" id="d_m_status_<?php //echo $i; ?>" value="<?php //echo $docs[$i]->d_m_status; ?>" />
																<input type="text" class="form-control doc_name" name="doc_name[]" id="doc_name_<?php //echo $i; ?>" placeholder="Document Name" value="<?php //echo $docs[$i]->d_documentname; ?>" />
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php //echo $docs[$i]->d_description; ?>" />
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/>
															</div>
															<div class="col-md-2">
																<input  type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/>
															</div>
		                                    				<div class="col-md-2">
																<div class="col-md-8">
																	<input type="file" class="fileinput btn-primary doc_file" name="doc_<?php //echo $i; ?>" id="doc_file_<?php //echo $i; ?>" data-error="#doc_<?php //echo $i; ?>_error"/>
																	<div id="doc_<?php //echo $i; ?>_error"></div>
																</div>
					                                            <div class="col-md-4">
					                                            	<a id="repeat_doc_<?php //echo $i; ?>_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a>
					                                            </div>
                                            				</div>
														</div>
												<?php //} } ?> -->

												<?php $this->load->view('templates/document');?>
											</div>
													
										 
										 
												<div class=" btn-margin">
												
													<!-- <button class="btn btn-success repeat-doc" style="margin-left: 10px;" name="addkycbtn">+</button> -->
													<button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                    				<!-- <button type="button" class="btn btn-success" id="reverse-documents" style="margin-left: 10px;">-</button> -->
													
														<a href="#accOneColFive" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
												 </div>
										 
										</div>
									</div>


									<div class="panel  panel-primary" id="panel-profit-or-loss" style="display:none;">
									   	<a href="#accOneColFive">   
			                                <div class="panel-heading">
			                                	<h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Profit or Loss  </h4>
			                                </div>  
                            			</a>  
										<div class="panel-body" id="accOneColFive">
											<div class="form-group" style="border-top: 1px dotted #ddd;">
												<div class="col-md-6">
													<div class="">
														<label class="col-md-4 control-label">Cost of Purchase</label>
														<div class="col-md-8">
															<input onkeyup="calculateprofit();"  type="text" class="form-control format_number" name="cost_purchase" id="costpurchase" placeholder="Amount" value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_purchase,2); } else { echo '0'; } } else { echo '0'; } ?>" />
															<input type="hidden" name="sales_consideration" id="sales_consideration" value="0" />
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="">
														<label class="col-md-4 control-label">Cost of Acquisition</label>
														<div class="col-md-8">
															<input type="text" class="form-control format_number" name="cost_of_acquisition" id="cost_of_acquisition" placeholder="Cost of Acquisition"  value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_acquisition,2); } else { echo '0'; } } else { echo '0'; } ?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6">
													<div class="">
														<label class="col-md-4 control-label">Capital Gain</label>
														<div class="col-md-8">
															<input type="text" class="form-control format_number" name="profit_loss" id="profit_loss" placeholder="Amount"  value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->profit_loss,2); } else { echo '0'; } } else { echo '0'; } ?>" />
														</div>
													</div>
												</div>
											</div>
													
											<br/>
											<div class="">
												<div class="">
													<a href="#accOneColSeven" ><button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button></a>
												 </div>
											</div>
										</div>
									</div>

									<?php $this->load->view('templates/pending_activity');?>

									
                                    <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                        <a href="#accOneColfour"> 
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Remark </h4>
                                            </div>
                                        </a>                                 
                                        <div class="panel-body" id="accOneColfour">
										   <div class="remark-container">
                                                <div class="form-group" style="background: none;border:none">
                                                <div class=" ">
                                                    <div class="col-md-12">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($s_txn)){ echo $s_txn[0]->maker_remark;}?></textarea>
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
							   
							   <br clear="all"/> 
							   </div>
								<div class="panel-footer">
									<input type="hidden" id="submitVal" value="1" />
									<a href="<?php echo base_url(); ?>index.php/sale" class="btn btn-danger" >Cancel</a>
									<input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" />
									<input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($s_txn)) echo 'display:none'; ?>" />
								</div>
                               </form>
                           	
                           	<!-- start contact popup -->
                               
                            <!-- end contact popup -->
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
	        var BASE_URL="<?php echo base_url()?>";
	    </script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
        
		<script type="text/javascript">
			var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
			var tax = new Array();
			var taxname=new Array();
			var taxpurpose=new Array();
			window.cntrinst=0;
			
			<?php for ($i=0; $i < count($tax) ; $i++) { ?>
				tax.push('<?php echo $tax[$i]->tax_percent; ?>');
				taxname.push('<?php echo $tax[$i]->tax_name; ?>');
				taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
			<?php }	?>
			function opentable(){
				if(flag==false) {
					document.getElementById('message-box-info').style.display = "block";
					// var installments=document.getElementById('installments').value;
					// var purchase=document.getElementById('purchase').value;
					// var downpymnt=document.getElementById('downpymnt').value;
					// var amt1=purchase - downpymnt;
					
					// var amt2=Math.round(amt1/installments);
					// rows='';
					// if(installments!=''){
					// 	window.cntrinst=(parseInt(installments)-1);
					// }
					// for (var i = 0; i < installments; i++) {
					// 	var ntamt=amt2;
						
					// 	rows=rows+ "<tr> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ (i+1) +"</td> <td><input type='text' id='txttype' name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text' id='txtevent' name='sch_date[]' value=''  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' id='bs_"+i+"' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='" + format_money(amt2,2) + "' class='form-control format_number' style='border:none; text-align:right;'/></td>";
					// 		for (var j = 0; j < taxname.length; j++) {
					// 			if(taxpurpose[j]=='Add') {
					// 				var staxamt=Math.round(amt2*tax[j]/100);
					// 				ntamt=ntamt+staxamt;
					// 				rows=rows+"<td><input type='text' id='tx_"+j+"_"+i+"' name='sch_tax"+ i + "[]'  value='" + format_money(staxamt,2) + "' class='form-control format_number' style='border:none;'/></td>";
					// 			} else {
					// 				var staxamt=Math.round(amt2*tax[j]/100);
					// 				ntamt=ntamt-staxamt;
					// 				rows=rows+"<td><input type='text' id='tx_"+j+"_"+i+"' name='sch_tax"+ i + "[]'  value='" + format_money(staxamt,2) + "' class='form-control format_number' style='border:none;'/></td>";
					// 			}
					// 		};
					// 	 rows=rows+ "<td><input type='text' id='ntat_"+i+"' name='sch_netamount[]'  value='" + format_money(ntamt,2) + "' class='form-control format_number' style='border:none;'/></td> </tr>";
					// 	 ntamt=0;
					// }
					// document.getElementById('schedule_table').innerHTML=rows;
					// $('.datepicker').datepicker({changeMonth: true,changeYear: true});
					// $('.format_number').keyup(function(){
				 //        format_number(this);
				 //    });
			  //       $("form :input").change(function() {
		   //              $(".save-form").prop("disabled",false);
		   //          });
					// document.getElementById('sch_bal').value=0;
					flag=true;
				} else {
					document.getElementById('message-box-info').style.display = "block";
				}
			}

			function calculatetaxes(arg){
				var bsid = arg.getAttribute('id');
				var bsicamt=document.getElementById(bsid).value;
				
				var tyu='';
				for (var i = 3
					; i < bsid.length; i++) {
					tyu=tyu+bsid.charAt(i);
				};
				
				var nwamt=0;
				var netamt=0;
				for (var i = 0; i < tax.length; i++) {
					var tx=tax[i];
					var oper=taxpurpose[i];
					if(oper=="Add") {
						nwamt=Math.round(bsicamt*tx/100);
						netamt=netamt + nwamt;
					} else if (oper=="Subtract") {
						nwamt=Math.round(bsicamt*tx/100);
						netamt = netamt - nwamt;
					}
					var tempid = 'tx_'+i+'_'+tyu;
					document.getElementById(tempid).value=nwamt;
				};
				//document.getElementById('bs_'+tyu).value=bsicamt;
				document.getElementById('ntat_'+tyu).value=netamt;
				if(document.getElementById('purchase').value!=''){
					var cstprc=parseInt(document.getElementById('purchase').value);	
				} else {
					var cstprc=0;
				}
				
				var newcst=0;
				if(document.getElementById('downpymnt').value!=''){
					var dwnpymt=parseInt(document.getElementById('downpymnt').value);	
				} else {
					var dwnpymt=0;	
				}
				
				var inst=document.getElementById('installments').value;


				for (var i = 0; i <= window.cntrinst; i++) {
					var bsc = parseInt(document.getElementById('bs_'+i).value);
					newcst=newcst + bsc;
				};
				var bal = newcst + dwnpymt;
				bal = cstprc - bal;
				document.getElementById('sch_bal').value=bal;
			}

			function savetemp() {
				removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
			    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
			    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
			    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');

			    addMultiInputNamingRules('#form_sale', 'input[name="sch_type[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_event[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_date[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_basiccost[]"]', { required: true }, "");

			    var valid = true;

			    if (!$("#form_sale").valid()) {
			    	$("#schedule_table").find('.error').each(function(index) {
			    		if($(this).is(":visible")){
			    			valid = false;
			    		}
			    	});
			    }

			    if (valid==true) {
					removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
				    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
				    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
				    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');
					
					var formdata = {};
					var formdata={
						sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
						sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
						sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
						sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get(),
						// sch_pay_type:$('input[name="sch_pay_type[]"]').map(function(){return $(this).val();}).get(),
						// sch_agree_value:$('input[name="sch_agree_value[]"]').map(function(){return $(this).val();}).get()
					}

					var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
					console.log(sch_type.length);
					var j=1;
					for(var i=0;i<sch_type.length;++i){
						//console.log("step1");
						formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
						j++;
					}
					console.log(formdata);
					$.ajax({
						url:"<?php echo base_url().'index.php/sale/insertTempSchedule';?>",
						data:formdata,
						dataType:"json",
						type:"POST",
						async:false,
						success:function(responsemydata){
							if(responsemydata.status==1){
								$("#temp_schedule_div").html(responsemydata.data);
								// alert(responsemydata.total_net_amount);
								$("#sales_consideration").val(responsemydata.total_net_amount);
							}
						//	alert("step 1 clear");
						},
					});
				
					//var bl=parseInt(document.getElementById('sch_bal').value);
					/*if(bl!=0) {
						alert("Balance should be 0. Kindly check the same.")
					} else {*/
						document.getElementById('message-box-info').style.display = "none";
						$("#actual_schedule_div").removeClass('show').addClass('hide');
					//}

					calculateprofit();
				}
			}


			function closetemp() {
				document.getElementById('message-box-info').style.display = "none";
				flag=false;
			}

			function instchange(){
				flag=false;
			}
		</script>
		
		<script>
			jQuery(function(){
				$("#sale_date").change(function() {
					//alert("hii");
					calculateprofit();
				});
			});

			jQuery(function(){
				var counter = 1;
				var tst=1;
				$('.repeat-schedule').click(function(event){
					event.preventDefault();

					scheduleRepeat(counter,tst);
				});
			    $('.reverse-schedule').click(function(event){
			        scheduleReverse(counter,tst);
			    });
			});
				
			function scheduleRepeat(counter,tst){
				var ctr=window.cntrinst;
				var counter = tst;
				if(ctr == 0){
				var tst=parseInt($("#schedule_id").val())+1;						
				}
				else{
					//alert(ctr);
					tst=parseInt(ctr)+parseInt(1);
				}
				var newRow= jQuery('<tr id="repeat_schedule_'+tst+'"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control" value="" style="border:none;"/></td>	<td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td> <td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align: right;"/></td><td><select name="sch_tax_'+tst+'[]" multiple class=" select" style="display: none;"><?php if(isset($tax_details)){foreach($tax_details as $row){echo "<option value=".$row->tax_id.">".$row->tax_name."-".$row->tax_percent."</option>";}}?><select></td></tr>');
				$('.addschedule').append(newRow);
				$('.select').selectpicker();
				$('.select').selectpicker();
				//counter++;
				//tst++;
				window.cntrinst=tst;

				$('.datepicker').datepicker({changeMonth: true,changeYear: true,yearRange:'-100:+100'});
				$('.format_number').keyup(function(){
			        format_number(this);
			    });
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
			}

			function scheduleReverse(counter,tst){
		    	var ctr=window.cntrinst;
				var counter = tst;
				if(ctr == 0){
				var tst=$("#schedule_id").val();						
				}
				else{
					//alert(ctr);
					tst=parseInt(ctr);
				}
		        var id="#repeat_schedule_"+(tst).toString();
		        if($(id).length>0){
		            $(id).remove();
		            tst--;
		            window.cntrinst=tst;
		            $("#schedule_id").val(tst);
		        }
			}
			
			jQuery(function(){
				var counter = <?php if(isset($s_buyer)) { echo count($s_buyer); } else { echo '1'; } ?>;
				$('.repeat-buyer').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_buyer_' + counter + '"><div class="col-md-6"><div class=""><label class="col-md-4 control-label" >Buyer Name ' + counter + ' <span class="asterisk_sign">*</span></label><div class="col-md-8"><input type="hidden" id="owner_name_' + counter + '_id" name="buyername[]" class="form-control" /><input type="text" id="owner_name_' + counter + '" name="owner_contact_name[]" class="form-control auto_contact_owner ownership" placeholder="Type to choose contact or owner from database..." /></div></div></div><div class="col-md-6"><div class=""><label class="col-md-4 control-label">% share <span class="asterisk_sign">*</span></label><div class="col-md-8"><input type="text" class="form-control format_number" id="sharepercent_'+counter+'" name="sharepercent[]" placeholder="%" value="" /></div></div></div></div>');
					$('.auto_contact_owner', newRow).autocomplete(autocomp_opt_contact_owner);
        			$('.addbuyer').append(newRow);
					$('.format_number').keyup(function(){
				        format_number(this);
				    });
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
				});
			    $('.reverse-buyer').click(function(event){
			    	if(counter!=1){
				        var id="#repeat_buyer_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});
		</script>

		<script type="text/javascript">
        	function loadclientdetail(){
        		var propid = document.getElementById("property").value;
        		var xmlhttp=new XMLHttpRequest();
        		xmlhttp.onreadystatechange = function() {
        			if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
        				document.getElementById("costpurchase").value = xmlhttp.responseText;
        			} 
        		};

        		xmlhttp.open("POST", "<?php echo base_url().'index.php/Sale/loadpropertydet/'; ?>" + propid, true);
        		xmlhttp.send();

        		calculateprofit();
        	}

        	$("#sale_date","#property").change(function(){
        		 getcostofacquisition();
        	})

			function getcostofacquisition(){
        		var propid = document.getElementById("property").value;
        		var saledate = document.getElementById("sale_date").value;
        		// var parameters="property="+propid;

        		// alert(propid + ' ' + saledate);

        		$.ajax({
		            url: "<?php echo base_url() . 'index.php/Sale/getcostofacquisition' ?>",
		            data: 'property=' + propid + '&sale_date=' + saledate,
		            cache: false,
		            type: "POST",
		            dataType: 'html',
		            global: false,
		            async: false,
		            success: function (data) {
		            	if (isNaN(data)){
		            		data=0;
		            	}
						document.getElementById('cost_of_acquisition').value = data;
		            },
		            error: function (xhr, status, error) {
		                    //alert(xhr.responseText);
		            }
		        });

				var cost_of_acquisition = parseFloat(get_number(document.getElementById("cost_of_acquisition").value,2));
				var sales_consideration = parseFloat(get_number(document.getElementById("sales_consideration").value,2));

				var profit_or_loss = sales_consideration - cost_of_acquisition;
				document.getElementById('profit_loss').value = profit_or_loss;
        	}

        	function calculateprofit(){
    //     		var sell_price=0;
    //     		var cost_price=0;
    //     		var registeration=0;
    //     		var stampduty=0;
    //     		var brokeramt=0;

    //     		if(document.getElementById("saleamount").value!='') {
    //     			sell_price=parseFloat(document.getElementById("saleamount").value);
    //     		}
    //     		if(document.getElementById("costpurchase").value!='') {
				// 	cost_price=parseFloat(document.getElementById("costpurchase").value);
    //     		}
    //     		if(document.getElementById("registeration").value!='') {
    //     			registeration=parseFloat(document.getElementById("registeration").value);
    //     		}
    //     		if(document.getElementById("stampduty").value!=''){
    //     			stampduty=parseFloat(document.getElementById("stampduty").value);
    //     		}
				// if(document.getElementById("brokerage_amount").value!=''){
    //     			broker=parseFloat(document.getElementById("brokerage_amount").value);
    //     		}

    //     		// alert(sell_price + ' ' + cost_price + ' ' + registeration + ' ' + stampduty + ' ' + broker);


    // 			//var profitloss=sell_price-cost_price-registeration-stampduty-broker;
				// //document.getElementById("profit_loss").value=parseFloat(profitloss);

				// var sales_consideration=sell_price-registeration-stampduty-broker;
				// document.getElementById("sales_consideration").value=parseFloat(sales_consideration);

				// alert("calculateprofit");
				getcostofacquisition();

        	}

        	function getdocuments() {
        		var propid = document.getElementById("property").value;
        		<?php if(isset($s_txn)) {  } else {  ?>
					var counter = 0;
					$('#adddoc').empty();

			        $.ajax({
			            url: "<?php echo base_url() . 'index.php/Sale/loadsaledocuments/' ?>" + propid,
			            data: $("#form_sale").serialize(),
			            cache: false,
			            type: "POST",
			            dataType: 'json',
			            global: false,
			            async: false,
			            success: function (data) {
							// if(data!=null) {
							// 	 //alert(data);
	      //                       $.each(data, function(key,value) {
	      //                           // alert(value.d_documentname + ' ' + value.d_description);
	      //                           var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group"><div class="col-md-2"><input type="hidden" class="form-control" name="doc_id[]" value="'+ value.d_id +'" /><input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="'+ value.d_m_status +'" /><input type="text" class="form-control doc_name" id="doc_name_'+ counter + '" name="doc_name[]" placeholder="Document Name" value="'+ value.d_documentname +'" /></div><div class="col-md-2"><input type="text" class="form-control" name="doc_desc[]" placeholder="Document Description"  value="'+ value.d_description +'" /></div><div class="col-md-2"><input type="text" class="form-control" name="ref_no[]" placeholder="Reference No" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_issue[]" placeholder="Date of Issue" value=""/></div><div class="col-md-2"><input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value=""/></div><div class="col-md-2"><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary doc_file" name="doc_'+ counter + '" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" /></a><div id="doc_'+counter+'_error"></div></div><div class="col-md-4"><a id="repeat_doc_'+counter+'_delete" class="btn btn-success delete_row" style="margin-left: 5px;" href="#">-</a></div></div></div>');
							// 		$('.adddoc').append(newRow);
							// 		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
					  //               $('.delete_row').click(function(event){
					  //                   delete_row($(this));
					  //               });
							//         $("form :input").change(function() {
						 //                $(".save-form").prop("disabled",false);
						 //            });
							// 		counter = counter+1;
	      //                       });
	      //                   }

	                        if(data.status==1){
								$('#adddoc').html("");
								$('#adddoc').html(data.data);
								$(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
								$('.datepicker').datepicker({changeMonth: true,changeYear: true});
				                $('.delete_row').click(function(event){
				                    delete_row($(this));
				                });
						        $("form :input").change(function() {
					                $(".save-form").prop("disabled",false);
					            });
							}
			            },
			            error: function (xhr, status, error) {
			                    //alert(xhr.responseText);
			            }
			        });
				<?php } ?>
        	}


        	$(document).ready(function(){
        		addMultiInputNamingRules('#form_sale', 'input[name="owner_contact_name[]"]', { required: function(element) {
			                                                                                                if($("#submitVal").val()=="0"){
			                                                                                                    return true;
			                                                                                                } else {
			                                                                                                    return false;
			                                                                                                }
			                                                                                            }
			                                                                                }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sharepercent[]"]', { required: function(element) {
			                                                                                            if($("#submitVal").val()=="0"){
			                                                                                                return true;
			                                                                                            } else {
			                                                                                                return false;
			                                                                                            }
			                                                                                        }
			                                                                                }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_type[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_event[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_date[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', 'input[name="sch_basiccost[]"]', { required: true }, "");
			    addMultiInputNamingRules('#form_sale', '.doc_name', { required:function(element) {
			                                                                        if($("#submitVal").val()=="0"){
			                                                                            return true;
			                                                                        } else {
			                                                                            return false;
			                                                                        }
			                                                                    }
			                                                                }, "Document");
        	});


			function saveTempBulkUpload(){
				var input = ($("#schedule_upload"))[0];
				var upload_txn_type = 'sale';
		        file = input.files[0];
		        if(file != undefined){
		            formData= new FormData();            
		                    formData.append("data_file", file);
		                    formData.append("upload_txn_type",upload_txn_type);
		                    $.ajax({
		                        url: "<?php echo base_url() . 'index.php/purchase/saveTempBulkUpload' ?>",
		                        type: "POST",
		                        data: formData,
		                        processData: false,
		                        contentType: false,
		                        dataType: "json",
		                        success: function(data){
		                        	if(data.status==0){
		                        		alert(data.errormsg);
		                        	}
		                        	else{
		                        		var counter=data.rowcounter;
		                        		var tst=data.rowcounter;
                        				window.cntrinst=tst-1;
                        				$("#schedule_id").val(tst-1);
		                        		$("#message-box-info").html(data.data);
		                        		$('.select').selectpicker();
		                        		$('.datepicker').datepicker({changeMonth: true,changeYear: true});
		                        		$('#schedule_upload').bootstrapFileInput();
		                        		//$('.repeat-schedule').trigger('click');
										$('.repeat-schedule').click(function(event){
											event.preventDefault();
											//alert(window.cntrinst);
											scheduleRepeat(counter,tst);
										});
										$('.reverse-schedule').click(function(event){
											event.preventDefault();
											//alert(window.cntrinst);
											scheduleReverse(counter,tst);
											
										});
									    $('.sch_basiccost').each(function(){
									    	format_number(this);
									    });
										$('.format_number').keyup(function(){
									        format_number(this);
									    });
								        $("form :input").change(function() {
							                $(".save-form").prop("disabled",false);
							            });
		                        	}
		                     	}
		                    });
		//                
		        }else{
		            $("#file_photo_error").html('Input something!');
		//                alert('Input something!');
		        }


			}

        </script>
    <!-- END SCRIPTS -->      
    
    <script>
        $( "#property" ).change(function() {
            var property=$("#property").val();
            var dataString = 'property_id=' + property + '&txn_id=' + <?php if(isset($s_id)) echo $s_id; else echo '0';?>;

            $.ajax({
               type: "POST",
               url: "<?php echo base_url() . 'index.php/sale/get_sub_property' ?>",
               data: dataString,
               cache: false,
               success: function(html){
                   $("#sub_property").html(html);
               } 
            });
        });
    </script>

	<script>
		jQuery(function(){
		    var counter = <?php if(isset($related_party)) { echo count($related_party); } else { echo '1'; } ?>;
		    $('.repeat-related_party').click(function(event){
		        event.preventDefault();
		        counter++;
		        var newRow = jQuery('<div class="form-group" id="related_party_'+counter+'" '+((counter==1)?'style="border-top: 1px dotted #ddd;"':'')+'>'+
			                            '<div class="col-md-4">'+
			                                '<label class="col-md-3 control-label">Type</label>'+
			                                '<div class="col-md-9">'+
			                                    '<select name="related_party_type[]" class="form-control rp_type" id="rp_type_'+counter+'">'+
			                                        '<option value="">Select</option>'+
			                                        '<?php for ($k=0; $k < count($contact_type) ; $k++) { ?>'+
			                                            '<option value="<?php echo $contact_type[$k]->id; ?>"><?php echo $contact_type[$k]->contact_type; ?></option>'+
			                                        '<?php } ?>'+
			                                    '</select>'+
			                                '</div>'+
			                            '</div>'+
			                            '<div class="col-md-4">'+
			                                '<label class="col-md-3 control-label">Name</label>'+
			                                '<div class="col-md-9">'+
			                                    '<input type="hidden" id="rp_'+counter+'_id" name="related_party[]" class="form-control" value="" />'+
			                                    '<input type="text" id="rp_'+counter+'" name="related_party_name[]" data-error="#rp_error_'+counter+'" class="form-control auto_client_by_type" value="" placeholder="Type to choose contact from database..." />'+
			                                    '<div id="rp_error_'+counter+'"></div>'+
			                                '</div>'+
			                            '</div>'+
			                            '<div class="col-md-4">'+
			                                '<label class="col-md-3 control-label" style="padding-left: 0px;">Remarks</label>'+
			                                '<div class="col-md-9">'+
			                                    '<input type="text" class="form-control" name="related_party_remarks[]" placeholder="Remarks" value="" />'+
			                                '</div>'+
			                            '</div>'+
			                        '</div>');
		    	$('.auto_client_by_type', newRow).autocomplete(auto_client_by_type_opt);
		        $('#related_party').append(newRow);
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
		    });
		    $('.reverse-related_party').click(function(event){
		    	if(counter!=1){
			        var id="#related_party_"+(counter).toString();
			        if($(id).length>0){
			            $(id).remove();
			            counter--;
			        }
			    }
		    });
		});

		$('.rp_type').change(function(){
			var id = this.id;
			var cnt = id.substr(id.lastIndexOf("_")+1);
			$("#rp_" + cnt.toString() + "_id").val("");
			$("#rp_" + cnt.toString()).val("");
		});

		jQuery(function(){
		    var counter = <?php if(isset($pending_activity)) { echo count($pending_activity); } else { echo '1'; } ?>;
		    $('.repeat-pending_activity').click(function(event){
		        event.preventDefault();
		        counter++;
		        var newRow = jQuery('<div class="form-group" id="pending_activity_'+counter+'" '+((counter==1)?'style="border-top: 1px dotted #ddd;"':'')+'><div class="col-md-1 col-sm-1 col-xs-1" style=""><label class="col-md-12 control-label">'+counter+'</label></div> <div class="col-md-11 col-sm-11 col-xs-11" style="    padding-right: 14px;}"> <input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" /></div></div>');
		        $('#pending_activity').append(newRow);
		        $("form :input").change(function() {
	                $(".save-form").prop("disabled",false);
	            });
		    });
		    $('.reverse-pending_activity').click(function(event){
		    	if(counter!=1){
			        var id="#pending_activity_"+(counter).toString();
			        if($(id).length>0){
			            $(id).remove();
			            counter--;
			        }
			    }
		    });
		});
	</script>
    </body>
</html>