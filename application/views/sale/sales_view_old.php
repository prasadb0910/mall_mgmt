<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
		   <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
        <!-- EOF CSS INCLUDE -->                                      
	<style type="text/css">
		 
     .address-remark{width:12.9%;}
.address-container1{width:87.1%; display:flex;}   

    
 @media screen and (max-width: 780px) 
	{
.custom-padding .col-md-6 {
    padding:0px!important;
} 
.form-horizontal .control-label { padding:0 3px!important; }
 
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}

}

@media screen and (min-width: 781px) and (max-width:991px){ 
.custom-padding .control-label { padding:0 2px!important; }
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}
 
}
        </style>	     	
    </head>
    <body >
       <!-- START PAGE CONTAINER -->
          <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">                  
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/sale'; ?>" > Sales List</a>  &nbsp; &#10095; &nbsp;    Sales View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> 
				        <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?>  <a class="btn-margin" href="<?php echo base_url().'index.php/sale/edit/'.$s_id; ?>"> 
						<span class="btn btn-success pull-right btn-font"> Edit </span> </a> <?php } }  ?>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/sale" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
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
														<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Property:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12">            
															<label class="col-md-12 control-label contact-view" style="text-align:left;">
															<?php if(isset($s_txn)) { echo $s_txn[0]->p_property_name; } ?></label>
														</div>													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">													
														<label class="col-md-3 col-sm-5 col-xs-12 position-name control-label"><strong>Sub Property:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12 Sub-Property">
													   <label class="col-md-12 control-label contact-view" style="text-align:left;">
														<?php if(isset($s_txn)) {echo $s_txn[0]->sp_name;} ?></label>
														</div>													
												</div>
											</div>
                                           <div class="form-group print-border">
												<div class="col-md-6 col-sm-6 col-xs-12">													
														<label class="col-md-3 col-sm-5 col-xs-12 control-label"><strong>Date of Sale:</strong></label>
														<div class="col-md-9 col-sm-7 col-xs-12">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($s_txn)) { if(count($s_txn)>=0) {echo date('d/m/Y',strtotime($s_txn[0]->date_of_sale));}} ?></label>
														</div>
													
												</div>
												
											</div>                                         
                                  <div class="row">
                                    <h3 class="panel-title" style="padding:10px 10px 0 10px; margin-left:0px; font-size:16px; font-weight:600;"> Owner  Details</h3> 
									</div>
                
                        <div class="row">
                  
                    <div class="table-responsive">
                    <table id="contacts" class="table table-bordered  " style="border-top:;">
                      <thead>
                      <tr>
                          <th width="5%" align="center">Sr. No.</th>
                          <th width="65%">Owner Name </th>
                          <th width="30%">% Share</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($s_owner)) { 
                          for ($j=0; $j < count($s_owner); $j++) { ?>
                        <tr>
                          <td class="Contact_name" align="center"><?php echo $j+1; ?></td>
                          <td><?php if(isset($s_owner[$j]->owner_name)){ echo $s_owner[$j]->owner_name; } else { echo ''; }?></td>
                          <td><?php echo format_money($s_owner[$j]->pr_ownership_percent,2); ?> </td>
                        </tr>
                        <?php } } ?>
                        
                      </tbody>
                    </table>
                    
                    
                    </div>
                  
                  
                      </div>






                                       
                                      	<div class="row">
                                    <h3 class="panel-title" style="padding:5px 10px 0 10px;  font-size:16px; font-weight:600;"> Buyer Details</h3>                                    
                           				</div>
								
												<div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered " style="border-top:;">
											<thead>
											<tr>
                                                  <th width="5%" align="center">Sr. No.</th>
													<th width="65%">Buyer Name </th>
													<th width="30%">% Share</th>
												</tr>
											</thead>
											<tbody>
												<?php if(isset($s_buyer)) { 
													for ($j=0; $j < count($s_buyer); $j++) { ?>
												<tr>
												  <td class="Contact_name" align="center"><?php echo $j+1; ?></td>
													<td><?php if(isset($s_buyer[$j]->owner_name)){ echo $s_buyer[$j]->owner_name; } else { echo ''; }?></td>
													<td><?php echo format_money($s_buyer[$j]->share_percent,2); ?> </td>
												</tr>
												<?php } } ?>
												
											</tbody>
										</table>
										
										
									  </div>
									
									
											</div>
                                </div>
                                
                                
                                  <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Sales Consideration</strong></h3>                                    
                                </div>
                                <div class="panel-body">


                                	 <div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered  " style="border-top:;">
											<thead>
												<tr>
												
                                                    <th width="5%"> Sr. No. </th>
                                                    <th width="65%"> Type  </th>                                                   
                                                    <th width="15%" style="text-align:right;">Cost Buyer  (in &#x20B9;)</th>
                                                    <?php //print_r($tax_name);
                                                    if(isset($tax_name)){
                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
                                                        $key=0;
                                                        foreach($tax_name as $row){
                                                        echo '<th width="15%" style="text-align:right;  text-transform: capitalize;">'.$row->tax_type.'</th>';
                                                    $tax_array[$key]=$row->tax_type;
                                                    $key++;
                                                   } 
                                                   //echo '</tr></table></th>';
                                               }
                                               ?>
                                                    <th width="15%" style="text-align:right;"> Net Cost (in &#x20B9;)</th>
                                                </tr>
											</thead>
											<tbody>
                                                   <?php //print_r($p_schedule);?>
                                                    <?php 
                                                    $j=0;
                                                    $total_basic_cost=0;
                                                    $total_net_amount=0;
                                                    $total_tax_array=array();
                                                    foreach($p_schedule as $row_tax){
                                                            echo '<tr>
                                                            <td>'.($j+1).'</td>
                                                            <td>'.$p_schedule[$j]["event_type"].'</td>
                                                            
                                                            <td style="text-align:right;">'.format_money($p_schedule[$j]["basic_cost"],2).'</td>';
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
                                                        $total_basic_cost=$total_basic_cost+$p_schedule[$j]["basic_cost"];

                                                         $next_count=0;
                                                            $td_count=0;
															if(isset($p_schedule[$j]['tax_type'])) {
                                                           // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                                //echo "<br>hi";
                                                              // echo $key;
                                                            for($tcnt=0;$tcnt<$key;$tcnt++){
                                                                
                                                                //echo "step1--";
                                                             for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++){
                                                                $tax_amount='';
                                                                if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt])
                                                                {
                                                                    $tax_amount=$p_schedule[$j]['tax_amount'][$nc];
                                                                   $nc=count($p_schedule[$j]['tax_type']);
                                                                   //$tcnt=$key;
                                                               //}
                                                                }
                                                            }
                                                            if($tax_amount !=''){
                                                                echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
                                                                    $td_count++;

                                                            }
                                                                else{
                                                                    //if($next_count )
                                                                    echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
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

                                                        
                                                        echo'<td style="text-align:right;">'.format_money($p_schedule[$j]["net_amount"],2).'</td>
                                                            </tr>';
                                                            $total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
//print_r($p_schedule[$j]['event_type']);
$j++;


                                                    }?>

												<tr>
                                                    <td colspan="2"><b>Grand Total (in &#x20B9;)</b></td>
                                                    <td style="text-align:right;"><?php echo format_money($total_basic_cost,2);?></td>
                                                    <?php  $k=0;if(isset($total_tax_amount)) {
                                                    foreach($total_tax_amount as $row){
                                                        echo '<td style="text-align:right;">'.format_money($row,2).'</td>';
                                                    $k++;
													} } ?>
                                                   <td style="text-align:right;"><?php echo format_money($total_net_amount,2);?></td>
                                                </tr>

												
											</tbody>
										</table>
										
										
									  </div>
									
									
									   </div>
                                <!-- <div class="form-group" style="border-top:1px dotted #ddd;">
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Sales Price:</strong></label>
														<div class="col-md-8">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php //if(isset($s_txn)) { if(count($s_txn)>0) {echo $s_txn[0]->sale_price; } else { echo '0'; }} else { echo '0';} ?> </label>
														</div>
													
												</div>
												
											</div>  
                                            
                                             <br clear="all">
                                             	<div class="row">
                                    <h3 class="panel-title" style="padding:5px 0; margin-left:0px; font-size:16px; font-weight:600;">Cost of Sales
</h3>                                    
                           				</div>
                               	<div class="form-group" style="padding:0; background:#fff; background-color:#fff;" >
                                            
                                   </div>  
                                    	<div class="form-group" >
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Registration:</strong></label>
														<div class="col-md-8">                                                          <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php //if(isset($s_txn)) { if(count($s_txn)>0) {echo $s_txn[0]->registeration_amt; } else { echo '0'; }} else { echo '0';} ?></label>
														</div>
													
												</div>
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Stamp Duty:</strong></label>
														<div class="col-md-8">
													   <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php //if(isset($s_txn)) { if(count($s_txn)>0) {echo $s_txn[0]->stamp_duty; } else { echo '0'; }} else { echo '0';} ?></label>
														</div>
													
												</div>
											</div>
                                        
										<div class="form-group">
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Brokerage Amount:</strong></label>
														<div class="col-md-8">                                                          <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php //if(isset($s_broker)) { if(count($s_broker)>0) { echo $s_broker[0]->bro_amount; } else { echo '0';}} else { echo '0';} ?> </label>
														</div>
													
												</div>
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Sales Consideration:</strong></label>
														<div class="col-md-8">
													   <label class="col-md-12 control-label contact-view" style="text-align:left;"> <?php //if(isset($s_txn)) { if(count($s_txn)>0) { echo $s_txn[0]->sales_consideration; } else { echo '0';}} else { echo '0';} ?> </label>
														</div>
													
												</div>
											</div> -->
                                </div>
								
								
								<!-- START DATATABLE -->
							    <!-- <div class="panel-heading">
                                    <h3 class="panel-title"><strong> Broker Details </strong></h3>                                    
                                </div>
                                <div class="panel-body">
                                <div class="form-group" style="border-top:1px dotted #ddd;">
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong>Broker Name:</strong></label>
														<div class="col-md-8">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php //if (set_value('brokername_name')!=null) { echo set_value('brokername_name'); } else if(isset($s_broker[0]->c_name)){ echo $s_broker[0]->c_name; } else { echo ''; }?> </label>
														</div>
													
												</div>
											
                                   
												<div class="col-md-6">
													
														<label class="col-md-4 control-label"><strong> Remarks:</strong></label>
														<div class="col-md-8">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php //if(isset($s_broker)) { if(count($s_broker)>0) { echo $s_broker[0]->bro_remarks; }} ?> </label>
														</div>
													
												</div>
												
										
										
                                </div>
                            </div> -->
								
								<!-- END DEFAULT DATATABLE -->


                        <?php $this->load->view('templates/related_party_view');?>
                             
                                
                                <!-- START DATATABLE -->
								<!-- <div class="panel-heading" style="border-top:1px solid #E5E5E5;   ">
									<h3 class="panel-title" style="padding:0px; "><strong>Document </strong></h3>
							  </div>
								<div class="panel-body">
									<div class="row">
									
										<div class="table-responsive">
										<table id="contacts" class="table table-bordered">
											<thead>
												<tr>
												  <th width="19%">Document Name</th>
													<th width="16%">ID Proof</th>
													<th width="16%">Reference No.</th>
													<th width="15%">Date of Issue</th>
													<th width="20%">Date of Expiry</th>
													<th width="14%" class="th">Download</th>
												</tr>
											</thead>
											<tbody>
												<?php //if(isset($editdocs)) { 
												//for($i=0; $i<count($editdocs); $i++) { ?>
												<tr>
												  <td class="Contact_name"><?php //echo $editdocs[$i]->sl_doc_name; ?></td>
													<td class="Contact_name"><?php //echo $editdocs[$i]->sl_doc_description; ?></td>
													<td><?php //echo $editdocs[$i]->sl_doc_ref_no; ?></td>
													<td><?php //echo date('d/m/Y',strtotime($editdocs[$i]->sl_doc_doi)); ?></td>
													<td><?php //echo date('d/m/Y',strtotime($editdocs[$i]->sl_doc_doe)); ?></td>
													<?php //if($editdocs[$i]->sl_document!='' && $editdocs[$i]->sl_document!=null) { ?>
                              <td align="" class="td">
                                <?php //if($editdocs[$i]->sl_document!= '') { ?><a href="<?php //echo base_url().$editdocs[$i]->sl_document; ?>" class="btn btn-primary">
                                <i class="glyphicon glyphicon-download"> </i> Download </a><?php //} ?>
											        </td>
                          <?php //} else { ?>
                              <td align="" class="td"></td>
                          <?php //} ?>
												</tr>
												<?php //} } ?>
											</tbody>
										</table>
										
										
									  </div>
									
									</div>
								</div> -->
								<!-- END DEFAULT DATATABLE -->
                                
                                <?php $this->load->view('templates/document_view');?>
                                
                                
                                     <div class="panel-heading">
                                    <h3 class="panel-title"><strong> Profit or Loss </strong></h3>                                    
                                </div>
                                <div class="panel-body">
                                <div class="form-group" style="border-top:0px dotted #ddd;">
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-4 col-sm-5 col-xs-12 position-purchase control-label"><strong>Cost of Purchase   (In &#x20B9;):</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12 position-view ">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_purchase,2); } else { echo '0'; } } else { echo '0'; } ?> </label>
														</div>
													
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-4 col-sm-5 col-xs-12 position-purchase control-label"><strong>Cost of Acquisition   (In &#x20B9;):</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12 position-view">
														  <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_acquisition,2); } else { echo '0'; } } else { echo '0'; } ?> </label>
														</div>
													
												</div>
											</div>  
                               	  
                                    	<div class="form-group print-border" >
												<div class="col-md-6 col-sm-6 col-xs-12">
													
														<label class="col-md-4  col-sm-5 col-xs-12 position-purchase control-label"><strong>Capital Gain   (In &#x20B9;):</strong></label>
														<div class="col-md-8 col-sm-7 col-xs-12 position-view ">                                                          <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->profit_loss,2); } else { echo '0'; } } else { echo '0'; } ?></label>
														</div>
													
												</div>
												
											</div>
                                        
										
                                </div>


                                <?php $this->load->view('templates/pending_activity_view');?>


                                <div class="panel-heading" style="border-top:1px solid #E5E5E5;  ">
                                    <h3 class="panel-title"><strong> Remarks</strong></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group row Remark print-form-group" style="border-top: 1px dotted #ddd;">
                                        <label class="col-md-2 address-remark Remark control-label"><strong>Maker Remarks:</strong></label>
                                        <div class="col-md-10 address-container1">
                                          <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($s_txn)) { echo $s_txn[0]->maker_remark; } ?></label> 
                                        </div>                            
                                    </div>
                                    <div class="form-group row Remark print-border print-form-group">
                                        <label class="col-md-2 address-remark Remark control-label"><strong>Checker Remarks:</strong></label>
                                        <div class="col-md-10 address-container1">
                                          <label class="col-md-12 control-label contact-view" style="text-align:left;"><?php if (isset($s_txn)) { echo $s_txn[0]->remarks; } ?></label> 
                                        </div>                            
                                    </div>
                                </div>

 </div>
                                
                                </form>


                                <?php if(isset($s_txn)) { ?>
                                <?php if($s_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                                  
                                    <form id="" method="post" action="<?php echo base_url().'index.php/Sale/updaterecord/'.$s_id; ?>">
                                        <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
                                              <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                                <div class="col-md-10  address-container1">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>                                              
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                        </div> 
                                    </form>

                                <?php } } } else if($s_txn[0]->modified_by != '' && $s_txn[0]->modified_by != null) { if($s_txn[0]->modified_by!=$saleby) { if($s_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                  
                                    <form id="" method="post" action="<?php echo base_url().'index.php/Sale/approve/'.$s_id; ?>">
                                           <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
                                               <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                                <div class="col-md-10  address-container1">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div> 
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                        </div> 
                                    </form>

                                <?php } } } } else { ?>

                                    <form id="" method="post" action="<?php echo base_url().'index.php/Sale/updaterecord/'.$s_id; ?>">
                                             <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
                                               <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                                <div class="col-md-10  address-container1">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>                                             
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-danger">Cancel</a>
                                            <input type="submit" class="btn btn-danger pull-right" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/>
                                        </div> 
                                    </form>

                                <?php } } else if($s_txn[0]->created_by != '' && $s_txn[0]->created_by != null) { if($s_txn[0]->created_by!=$saleby && $s_txn[0]->txn_status != 'In Process') { if($s_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                  
                                    <form id="" method="post" action="<?php echo base_url().'index.php/Sale/approve/'.$s_id; ?>">
                                           <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
                                                <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                                <div class="col-md-10  address-container1">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
                                       
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-danger">Cancel</a>
                                            <input class="btn btn-success pull-right" type="submit" value="Approve" name="submit" style="margin-right:10px;"/>
                                            <input class="btn btn-danger pull-right" type="submit" value="Reject" name="submit" style="margin-right:10px;"/>
                                        </div> 
                                    </form>

                                <?php } } } } else { ?>
                                    
                                    <form id="" method="post" action="<?php echo base_url().'index.php/Sale/updaterecord/'.$s_id; ?>">
                                           <div class="panel-body" style="margin-top:10px;">
                                            <div class="row">
											    <div class="col-md-2 address-remark sr" id=""> <label >Remarks</label> </div>  
                                                <div class="col-md-10  address-container1">
                                                    <textarea type="text" id="txtstatus" name="status_remarks" class="form-control" placeholder="Remarks" ><?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?></textarea>
                                                </div>
                                                
                                            </div>
                                        </div>
                                             
                                        <div class="panel-footer">
                                            <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-danger">Cancel</a>
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
                 $('th').css("border","1px solid #ddd !important");
            $('th').css("border-right","1px solid #ddd !important")

               newWin.document.write('<html>   <style> body{padding:0; margin:0; font-family: Montserrat-Black, muli, Open Sans, sans-serif; font-weight:400;} table{border-spacing:0; border-collapse:collapse; border:1px solid #ddd; text-align:left; width:100%; margin:10px 0; clear:both; } table tr td {border:1px solid #ddd; padding:5px;} .print-authorised tr th:first-child{width:40%;} table tr th {border:1px solid #ddd; text-align:left;  padding:5px; font-weight:400;} table tr th:first-child{width:10%;}.download {display:none;} .form-group{display:flex; word-break: break-all; padding:10px; border:1px solid #ddd!important; border-bottom:0px solid #ddd!important;}.print-form-group {display:inline-block;     width: 97%;}.panel-heading { border:none!important; margin-top:20px;}.panel-heading .panel-title { margin-bottom:5px; padding:0; font-weight:400; font-size:20px;}   strong{  font-weight:400;  } .print-border{ border-bottom:1px solid #ddd!important;}.control-label{ float:left; padding-right:2px;}.print-form-group .col-md-2 { width:100%;}.col-md-4 {width:55%;}.col-md-6 {width:50%;}</style> <body onload="window.print()"> <div>'+divToPrint.innerHTML+'</body></html>');


              newWin.document.close();

              //setTimeout(function(){newWin.close();},10);
        });
        </script> 
    <!-- END SCRIPTS -->      
    </body>
</html>