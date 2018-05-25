<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Portfolio Management</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url();?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url();?>css/theme-blue.css"/>
        <!-- EOF CSS INCLUDE -->                                      
		<style>
		.addschedule td{
	border:1px solid;
	padding:0px !important;
	    vertical-align: middle !important;
}
.addschedule th{
	border:1px solid;
}
.addsummary td{
	border:1px solid;
	    vertical-align: middle;
	padding:0px !important;
}
.addsummary th{
	border:1px solid;
}
.addtax td{
	border:1px solid;
	
	padding:0px !important;
}
.addtax th{
	border:1px solid;
}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <?php $this->load->view('templates/menus');?>
                <!-- END X-NAVIGATION VERTICAL -->                     
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row">
					
						<div class="col-md-1">&nbsp;</div>
						
                        <div class="col-md-10">
						<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="<?php echo base_url()?>index.php/dashboard/saveActualBankEntry" method="post">
                            	<input type="hidden" name="prop_id" id="prop_id" value="<?php echo $property_details['prop_id'];?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Group Details</strong></h3>
                                    
                                </div>
                                <div class="panel-body">
									<div class="form-group" style="border-top:1px dotted #ddd">
										<div class="col-md-6">
											<div class="">
												<label class="col-md-3 control-label">Type</label>
												<div class="col-md-9">

													<select class="form-control select">
														<option <?php echo $property_details['payment'];?> value="payment" >Payment</option>
														<option <?php echo $property_details['receipt'];?> value="reciept" >Reciept</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="">
												<label class="col-md-3 control-label">Status</label>
												<div class="col-md-9">
												<select class="form-control select">
													<option>Select</option>
													<option value="purchase" <?php if (isset($property_details['purchase'])) echo $property_details['purchase'];?> >Property Purchase</option>
													<option value="loan_emi" >Loan EMI</option>
													<option value="rent" <?php if (isset($property_details['rent'])) echo $property_details['rent'];?> >Rent</option>
													<option value="sale" <?php if (isset($property_details['sale'])) echo $property_details['sale'];?> >Property Sale</option>
												</select>
													
												</div>
											</div>
										</div>
									</div>
								
									
                                </div>
								
								
								<!-- START DATATABLE -->
								<div class="panel-heading">
									<h3 class="panel-title">Bank Entry</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<!-- <div class="form-group" style="border-top:1px dotted #ddd">
											<div class="col-md-12">
												<div class="">
													<label class="col-md-2 control-label" style="margin-left: -38px;">Owner Name</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="owner_name" placeholder=""/>
													</div>
												</div>
											</div>
											
										</div> -->
										<div class="form-group" style="border-top:1px dotted #ddd">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Property Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="prop_name" value="<?php if(isset($property_details['property_name'])) echo $property_details['property_name'];?>" placeholder=""/>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Sub Property Name</label>
													<div class="col-md-9">
														<input type="text" class="form-control" name="sub_prop_name" placeholder=""/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group" style="border-top:1px dotted #ddd">
											<!-- <div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Event</label>
													<div class="col-md-9">
														<select class="form-control select" name="event_name">
															<option>Select</option>
															<?php if(isset($property_details['schedule_detail'])){
																		$i=0;
																	foreach ($property_details['schedule_detail'] as $row) {
																		# code...
																		echo "<option value='".$property_details['schedule_detail'][$i]['event_name']."'>".$property_details['schedule_detail'][$i]['event_name']."</option>";


																	}
															}?>
														</select>
													</div>
												</div>
											</div> -->
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Date</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="event_date" value="<?php echo date('d/m/Y');?>" placeholder=""/>
													</div>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>
								<!-- END DEFAULT DATATABLE -->
								
								
								<div class="panel-heading">
									<h3 class="panel-title">Payment Summary</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table group1 addschedule">
											<thead>
												<tr>
													<th >Particular</th>
													<th>Event Name</th>
													<th>Event Date</th>
													<th >Budget</th>												
													<th>Paid Till Date</th>
													<th >Actual</th>
													<th>Tax Applicable</th>													
													<th >Difference</th>													
												</tr>
											</thead>
											<tbody>

												<?php if(isset($property_details['schedule_detail'])){
																		$i=0;
																	foreach ($property_details['schedule_detail'] as $row) {
																		if($property_details['schedule_detail'][$i]['amount_paid'] == $property_details['schedule_detail'][$i]['net_amount'] ){
																			$disabled='disabled';
																		}
																		else{
																			$disabled='';
																		}



																		echo '<input type="hidden" name="schedule_id[]" id ="schedule_id_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['schedule_id'].'">';
																	echo '<tr><td>'.$property_details['schedule_detail'][$i]['event_type'].'</td>
																	<td>'.$property_details['schedule_detail'][$i]['event_name'].'</td>
																	<td>'.date("d/m/Y",strtotime($property_details['schedule_detail'][$i]['event_date'])).'</td>
																	<td> <input type="hidden" name="net_amount[]" id="net_amount_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['net_amount'].'">'.$property_details['schedule_detail'][$i]['net_amount'].'</td>
																	<td><input type="hidden" id="paid_till_date_'.($i+1).'" value="'.$property_details['schedule_detail'][$i]['amount_paid'].'"><a href="#" onclick="getAllpaidDetails('.$property_details['schedule_detail'][$i]['schedule_id'].')">'.$property_details['schedule_detail'][$i]['amount_paid'].' </a></td>
																	<td><input type="text" id="actual_amount_'.($i+1).'" name="actual_amount[]" class="form-control" style="border: none;" onchange="getServiceTax(this.id)" '.$disabled.'/></td>
																	<td> <select id="extra_taxes_'.($i+1).'" name="extra_taxes_'.($i+1).'[]"  class="select" multiple >';
																	if(isset($property_details['allTaxes']))
																	{
																		//print_r($tax_id);
																		foreach($property_details['allTaxes'] as $row)
																		{
																			echo '<option value="'.$row->tax_id.'_'.$row->tax_percent.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';	
																		} 	
																	}
																		echo '</select></td>
																		</td><td id="diifence_'.($i+1).'">'.$property_details['schedule_detail'][$i]['balance_amount'].'</td></tr>';
																	$i++;
																	
																	}
																} ?>

											</tbody>
										</table>
										<div class="row " >
											<div class="col-md-6"><button type="button"  class="btn btn-primary"id="<?php echo ($i+1);?>" onclick="getActualAmount(this.id)">Get Amount To Be Paid</button></div>
											<div class="col-md-3">Amount Paid Today</div><div class="col-md-3" id="actual_amount_to_pay"></div></div>
											<div class="row">
										&nbsp;
										</div>
										<table id="contacts" class="table group1 addschedule">
											<thead>
												<tr>
													<th>Taxes Applicable</th>
													<th>Tax Amount</th>
													<th>Paid Till Date</th>													
													<th>Tax Amount Paid</th>
													<th>Difference</th>													
												</tr>
											</thead>
											<tbody>
												<tr><td>Taxes</td><td><input type="text" id="taxAmount" name="taxAmount" style="border:none" value="<?php echo $property_details['tax_amount']?>" ></td>
													<td ><input type="text" id="paid_till_date" name="paid_till_date" style="border:none" value="<?php echo $property_details['tax_paid_amount']?>" ></td>
													<td><input type="text" style="border : none" id="total_paid_tax" name="total_paid_tax" onchange="getDiffence(this.value)" /></td>
													<td id="differnce_tax"><?php echo $property_details['tax_differnece'];?></td>
												</tr>
											</tbody>
										</table>
										<div class="row">
										&nbsp;
										</div>
										</div>
										<!-- <div class="row">
										<button class="btn btn-success repeat1" style="margin-left: 10px;">+</button>
										</div> -->
										</div>
										
									</div>
									</div>


									<div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;" >
													<div class="mb-container" style="background:#fff;">
														<div class="mb-middle">
															<div class="mb-title" style="color:#000;text-align:center;">Payment Details</div>
															<div class="mb-content" id="paid_detail_view">
															</div>
															
														</div>
														 <div class="mb-footer">
                                                    <button class="btn btn-danger btn-lg pull-right mb-control-close">Close</button>
                                                    
                                                </div>
													</div>
												</div>
										
										<!-- START DATATABLE -->
								<div class="panel-heading">
									<h3 class="panel-title">Payment Details</h3>
								</div>
								<div class="panel-body">
									<div class="row">
									<div class="panel-body">
										<div class="form-group" style="border-top:1px dotted #ddd">
											<div class="col-md-12">
												<div class="">
													<label class="col-md-2 control-label" style="margin-left: -38px;">Bank A/C</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="account_number" placeholder=""/>
													</div>
												</div>
											</div>
											
										</div>
										<div class="form-group" style="border-top:1px dotted #ddd">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Mode</label>
													<div class="col-md-9">
														<select class="form-control select" name="payment_mode">
															<option>Select</option>
															<option>Cheque</option>
															<option>Cash</option>
															<option>NEFT</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Payment Date</label>
													<div class="col-md-9">
														<input type="text" class="form-control datepicker" name="payment_date"  value="<?php echo date('d/m/Y');?>" placeholder=""/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group" style="border-top:1px dotted #ddd">
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Cheque No</label>
													<div class="col-md-9">
														<input type="text" class="form-control " name="cheq_no" placeholder=""/>
														
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">Cheque Amount</label>
													<div class="col-md-9">
														<input type="text" class="form-control " name="cheq_amount" placeholder=""/>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group" style="border-top:1px dotted #ddd">
											
											<div class="col-md-6">
												<div class="">
													<label class="col-md-3 control-label">MICR No</label>
													<div class="col-md-9">
														<input type="text" class="form-control " name="micr_no" placeholder=""/>
													</div>
												</div>
											</div>
										</div>
									</div>
									</div>
								
									<div class="mb-footer">
										<button class="btn btn-default mb-control-close">Cancel</button>
										<button id="save_contact" type="submit" class="btn btn-primary pull-right" style="margin-right: 10px;">Save</button>
									</div>
								</div>
									
									
								
							</form>
						</div>
						</div>
						
						<div class="col-md-1">&nbsp;</div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <!-- MESSAGE BOX-->
        <?php $this->load->view('templates/footer');?>
        <!-- END TEMPLATE -->
		
		<script>

		jQuery(function(){
    var counter = 1;
    $('.repeat').click(function(event){
        event.preventDefault();
        counter++;
        var newRow = jQuery('<tr><td>'+counter+'</td>'+
											'<td class="Contact_name"><input type="text" id="txtname" class="form-control"/></td>'+
											'<td><input type="text" id="txtdesign" class="form-control"/></td>'+
													'<td><input type="text" id="txtmob" class="form-control"/></td>'+
												'	<td><input type="text" id="txtemail" class="form-control"/></td>'+
												'	<td align="middle"><input type="checkbox" id="chkadmin" class="icheckbox"/></td></tr>');
        $('table.group').append(newRow);
    });
});


jQuery(function(){
    var counter1 = 2;
    $('.repeat1').click(function(event){
        event.preventDefault();
        counter1++;
        var newRow = jQuery('<tr><td>'+counter1+'</td>'+
												'	<td class="Contact_name"><input type="text" id="txtname" class="form-control"/></td>'+
												'	<td><input type="text" id="txtemail" class="form-control"/></td>'+
												'	<td><input type="text" id="txtphone" class="form-control"/></td>'+
													
												'	<td align="middle"><input type="radio" id="chkadmin" group="type" class=""/>Admin'+
												'	<input type="radio" id="chkadmin" group="type" class=""/>User</tr>');
        $('table.group1').append(newRow);
    });
});


</script>
		
		<script type="text/javascript">
            var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        group_name: {
                                required: true
                        },
						status: {
                                required: true
                        },
						group_members: {
                                required: true
                        }
                    }                                        
                });
				
			$('#reset').click(function(){
				$('#jvalidate')[0].reset();
				$('.tagsinput').attr('value') = '';
			 });
			 
			$('.contact_id').click(function(){
				var members = "";
				
				$('#contacts tr').each(function() {
					var row = $(this);
					
					if (row.find('input[type="checkbox"]').is(':checked')) {
						members = members + $(this).find("td.Contact_name").html() + ',';
					}
					});
					
				alert(members);
				
				$('#group_members').attr('value', members);
				//$('input[name=group_members]').val(members);
				//$('#group_members').val(members);
			 });

			function getPayTodayAmount(ids){
				

			}

			function getActualAmount(ids){
				//alert(ids);
				//var allTaxes=["test1","test2"];
				var totalPayAmount=0;

				for(var i=1;i<ids;i++){
					var actual_amount=$("#actual_amount_"+i).val();
					//console.log(actual_amount);	
					if(actual_amount != ''){
					var total_actual_amount=actual_amount;
					var selectedTaxes=$('select[name="extra_taxes_'+i+'[]"]').map(function(){return $(this).val();}).get();
					//console.log(total_actual_amount);
					for(var j=0;j<selectedTaxes.length;j++){					
					var  percenttax=selectedTaxes[j];
					var percent1=percenttax.split("_");
					var exact_percent=0;
					exact_percent=percent1[1];
					var percentAmount=0;
					 percentAmount=parseInt(exact_percent)*parseInt(actual_amount)/parseInt(100);
					 total_actual_amount=parseInt(total_actual_amount) - parseInt(percentAmount);

					}
					totalPayAmount=parseInt(totalPayAmount)+parseInt(total_actual_amount);
					total_actual_amount=0;
				}
				}
				$("#actual_amount_to_pay").html(totalPayAmount);
			//	console.log(total_actual_amount);

			}

			function getServiceTax(ids){
				//alert(ids);
					var sch_ids='schedule_id_'+ids.split("_").pop();
					var schedule_id=$("#"+sch_ids).val();
					var actual_amount=$("#"+ids).val();
					var prop_id=$("#prop_id").val();
					$.ajax({
						url:"<?php echo base_url()?>index.php/dashboard/getServiceTax",
						type:"post",
						dataType:"JSON",
						data:{"schedule_id" : schedule_id,"actual_amount":actual_amount,"prop_id" : prop_id},
						success:function(responsedata){
							if(responsedata.status==1){
								var tax_amount=$("#taxAmount").val();
								var return_tax_amount=parseInt(tax_amount)+parseInt(responsedata.tax_amount);
								$("#taxAmount").val(return_tax_amount);
							}
						}

					});
					getDifferneceAmt(ids);

			}

			function getDifferneceAmt(ids){
					var netamt_ids='net_amount_'+ids.split("_").pop();
					var netAmount=$("#"+netamt_ids).val();
					//console.log(netAmount);

					var paid_ids='paid_till_date_'+ids.split("_").pop();
					var paid_amount=$("#"+paid_ids).val();
					//console.log(paid_amount);

					var actual_amount=$("#"+ids).val();
					//console.log(actual_amount);

					var difference=0;
					difference=parseInt(netAmount)-parseInt(paid_amount)-parseInt(actual_amount);
					console.log(difference);
					$("#diifence_"+ids.split("_").pop()).html(difference);

			}
			function getDiffence(val1){
				var val2 =$("#taxAmount").val();
				var val_paid=$("#paid_till_date").val();
				var val3=parseInt(val2)-parseInt(val1)-parseInt(val_paid);
				$("#differnce_tax").val(val3);
			}
			function getAllpaidDetails(schedule_id){
				var prop_id=$("#prop_id").val();
				var formdata={schedule_id:schedule_id,
					prop_id:prop_id};
					 $.ajax({
					 	url:"<?php echo base_url()?>/index.php/dashboard/getPaidDetails",
					 	data:formdata,
					 	type:"post",
					 	dataType:"json",
					 	success:function(data){
					 		$("#paid_detail_view").html(data.htmldata);
					document.getElementById('message-box-info').style.display = "block";

					 	}
					 })


			}

        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>