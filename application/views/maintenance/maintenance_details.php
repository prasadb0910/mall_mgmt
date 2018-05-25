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
		 
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
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
 .table-stripped { min-width:750px;}
 .stripped-1 { padding:0; overflow-x:scroll!important;}
  }		
  
  .bootstrap-select.btn-group .dropdown-menu {
	  overflow:auto !important;
  }
        </style>	
    </head>
    <body>								
         <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/maintenance'; ?>" > Maintenance List</a>  &nbsp; &#10095; &nbsp;  Maintenance Details </div>

                <!-- PAGE CONTENT WRAPPER -->
                   <div class="page-content-wrap">
					 <div class="row main-wrapper">
						<div class="main-container">           
						   <div class="box-shadow custom-padding"> 
                             <form id="maintenance_details" role="form" class="form-horizontal" method="post" action="<?php if(isset($maintenance_txn)) { echo base_url().'index.php/maintenance/update/'.$m_id; } else {echo base_url().'index.php/maintenance/save'; }?>">
                                  <div class="box-shadow-inside">
									  <div class="col-md-12" style="padding:0;" >
										<div class="panel panel-default">
								
											<div class="panel-body faq">
                                <div class="panel-body panel-group accordion"  >
                                    <div class="panel  panel-primary">
                                          
                                            <div class="panel-heading">
                                                <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span> Maintenance </h4>
                                            </div>   
                                        
                                        <div class="panel-body panel-body-open text1" style="width:100%; ">
                                        <div class="form-group" style="border-top: 1px dotted #ddd;">
                                            <div class="col-md-6">
                                                <div class="">
                                                    <label class="col-md-4 control-label"> Select Property</label>
                                                    <div class="col-md-8">
                                                        <select  class="form-control" name="property" id="property">
                                                            <option value="">Select Property</option>
                                                            <?php for ($i=0; $i < count($property) ; $i++) { ?>
                                                                <option value="<?php echo $property[$i]->txn_id; ?>" <?php if(isset($maintenance_txn)) { if($property[$i]->txn_id==$maintenance_txn[0]->property_id) { echo "selected"; } } ?>><?php echo $property[$i]->p_property_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="sub_property_div" style="<?php if(isset($subproperty)) {if(count($subproperty)>0) echo ''; else echo 'display:none;';} else echo 'display:none;'; ?>">
                                                <div class="">
                                                    <label class="col-md-4 control-label"> Select Sub Property</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="sub_property" id="sub_property">
                                                            <option value="">Select Sub Property</option>
                                                            <?php for ($i=0; $i < count($subproperty) ; $i++) { ?>
                                                                <option value="<?php echo $subproperty[$i]->txn_id; ?>" <?php if(isset($maintenance_txn)) { if($subproperty[$i]->txn_id==$maintenance_txn[0]->sub_property_id) { echo "selected"; } } ?>><?php echo $subproperty[$i]->sp_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                      
                                        </div>
                                         <br clear="all"/>           
                                        <div class="form-group" id="cost_table" style="<?php if(isset($maintenance_cost_details)) {if(count($maintenance_cost_details)>0) echo ''; else echo 'border:none; display:none;';} else echo 'border:none; display:none;'; ?>">
										
                                        	<div class="remark-container stripped-1">
                                            	<div class="table-stripped">
            										<table class="table group table-bordered addschedule"  >
            											<thead>
            												<tr>
            													<th width="55" style="text-align: center;">Sr. No.</th>
            													<th  >Particulars</th>
            													<th width="110"  >Due Date</th>
                                                                <th  width="130"  >Frequency</th>
                                                                <th width="130"  >Cost (In &#x20B9;)</th>
                                                                <th width="150"  >Service Tax</th>
                                                                <th width="130"  >Amount (In &#x20B9;)</th>
            												</tr>
            											</thead>
            											<tbody>
            												<tr>
            													<td style="vertical-align: middle;" align="middle">1</td>
            													<td>
                                                                    <input type="hidden" name="particular[]" id="particular_1" value="<?php if(isset($maintenance_cost_details[0]->particular)) {echo $maintenance_cost_details[0]->particular;} ?>"/>
                                                                    <label class="control-label" id="particular_1_label"> <?php if(isset($maintenance_cost_details[0]->particular)) {echo $maintenance_cost_details[0]->particular;} ?> </label>
                                                                </td>
                                                                <td><input type="text" class="form-control datepicker" id="due_date_1" name="due_date[]" value="<?php if(isset($maintenance_cost_details[0]->due_date)) {if($maintenance_cost_details[0]->due_date!='' && $maintenance_cost_details[0]->due_date!=null) echo date('d/m/Y',strtotime($maintenance_cost_details[0]->due_date));} ?>" placeholder="Select Due Date" style="border:none;background:none;text-align:left;"/></td>
            													<td>
                                                                    <select name="frequency[]" id="frequency_1" class="form-control" style="border:none;">
                                                                        <option value="">Select</option>
                                                                        <option value="monthly" <?php if(isset($maintenance_cost_details[0]->frequency)) {if($maintenance_cost_details[0]->frequency=='monthly') echo 'selected';} ?> >Monthly</option>
                                                                        <option value="quarterly" <?php if(isset($maintenance_cost_details[0]->frequency)) {if($maintenance_cost_details[0]->frequency=='quarterly') echo 'selected';} ?> >Quarterly</option>
                                                                        <option value="yearly" <?php if(isset($maintenance_cost_details[0]->frequency)) {if($maintenance_cost_details[0]->frequency=='yearly') echo 'selected';} ?> >Yearly</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="cost[]" value="<?php if(isset($maintenance_cost_details[0]->cost)) {echo format_money($maintenance_cost_details[0]->cost,2);} ?>" id="cost_1" class="form-control m_cost format_number" placeholder="Enter Cost" style="border:none;background:none;text-align:left;"/></td>
                                                                <td>
                                                                    <select name="sch_tax_1[]" multiple id="sch_tax_1" class=" select">
                                                                    <?php 
                                                                    if(isset($tax_details)) {
                                                                        if(isset($maintenance_cost_details[0]->service_tax)){
                                                                            $tax_master=explode(',', $maintenance_cost_details[0]->service_tax);
                                                                        } else {
                                                                            $tax_master=array();
                                                                        }
                                                                        
                                                                        foreach($tax_details as $row) {
                                                                            if(in_array($row->tax_id, $tax_master)) {
                                                                                $selected="selected='selected'";
                                                                            } else {
                                                                                $selected='';
                                                                            }
                                                                            echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                        }
                                                                    };?>
                                                                    </select>
                                                                </td>
                                                                <td><input type="hidden" name="amount[]" value="" id="amount_1" class="form-control format_number" placeholder="Enter Amount" style="border:none;background:none;text-align:left;"/><span id="amount_1_text"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align: middle;" align="middle">2</td>
                                                                <td><input type="hidden" name="particular[]" id="particular_2" value="Property Tax"/><label class=" control-label" id="particular_2_label"> Property Tax </label></td>
                                                                <td><input type="text" class="form-control datepicker" id="due_date_2" name="due_date[]" value="<?php if(isset($maintenance_cost_details[1]->due_date)) {if($maintenance_cost_details[1]->due_date!='' && $maintenance_cost_details[1]->due_date!=null) echo date('d/m/Y',strtotime($maintenance_cost_details[1]->due_date));} ?>" placeholder="Select Due Date" style="border:none;background:none;text-align:left;"/></td>
                                                                <td>
                                                                    <select name="frequency[]" id="frequency_2" class="form-control" style="border:none;">
                                                                        <option value="">Select</option>
                                                                        <option value="monthly" <?php if(isset($maintenance_cost_details[1]->frequency)) {if($maintenance_cost_details[1]->frequency=='monthly') echo 'selected';} ?> >Monthly</option>
                                                                        <option value="quarterly" <?php if(isset($maintenance_cost_details[1]->frequency)) {if($maintenance_cost_details[1]->frequency=='quarterly') echo 'selected';} ?> >Quarterly</option>
                                                                        <option value="yearly" <?php if(isset($maintenance_cost_details[1]->frequency)) {if($maintenance_cost_details[1]->frequency=='yearly') echo 'selected';} ?> >Yearly</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="cost[]" value="<?php if(isset($maintenance_cost_details[1]->cost)) {echo format_money($maintenance_cost_details[1]->cost,2);} ?>" id="cost_2" class="form-control m_cost format_number" placeholder="Enter Cost" style="border:none;background:none;text-align:left;"/></td>
                                                                <td>
                                                                    <!-- <select name="sch_tax_2[]" multiple id="sch_tax_2" class="form-control select" style="display: none;">
                                                                    <?php /*
                                                                    if(isset($tax_details)) {
                                                                        foreach($tax_details as $row) {
                                                                            if(in_array($row->tax_id, $tax_master)) {
                                                                                $selected="selected='selected'";
                                                                            } else {
                                                                                $selected='';
                                                                            }
                                                                            echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                        }
                                                                    };*/?>
                                                                    </select> -->
                                                                </td>
                                                                <td><input type="hidden" name="amount[]" value="" id="amount_2" class="form-control format_number" placeholder="Enter Amount" style="border:none;background:none;text-align:left;"/><span id="amount_2_text"></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" align="right" style="vertical-align: middle;"><label class=" control-label">Total Cost </label></td>
                                                                <td><label class="control-label"><span id="total_cost"><?php if (isset($total_cost)) { echo format_money($total_cost,2); } ?></span> </label></td>
                                                                <td></td>
                                                                <td><label class="control-label"><span id="total_amount"><?php if (isset($total_amount)) { echo format_money($total_amount,2); } ?></span> </label></td>
                                                            </tr>		
            											</tbody>
            										</table>
                                              
                                                </div>
                                            </div>

                                            <div class="remark-container">
                                                <label class="col-md-2 control-label"  > Remark </label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" rows="4" name="maker_remark" ><?php if(isset($maintenance_txn)) { echo $maintenance_txn[0]->maker_remark; } ?></textarea>
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
                                    <a href="<?php echo base_url();?>index.php/maintenance" class="btn btn-danger" >Cancel</a>
                                    <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="" />
                                    <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                                </div>
                            </form>
						   </div>
						</div>
					</div>						
                    </div>
              
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

		<script>
            jQuery(function(){
    			var counter = <?php if(isset($maintenance_cost_details)) { echo count($maintenance_cost_details); } else { echo '5';} ?>;
    			$('.repeat-schedule').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" name="particular[]" class="form-control" style="border:;background:none;text-align: left; "/></td> <td><input type="text" name="cost[]" class="form-control m_cost format_number" style="border:;background:none;text-align: left;"/></td> </tr>');
					$('.addschedule').append(newRow);
					
					$(".m_cost").keyup(function() {
						var total_cost = 0;
						$('.m_cost').each(function(index, value) {
							//alert($(this).val());
							total_cost = total_cost + get_number($(this).val(),2);
							// alert(total_cost);
							$("#total_cost").html(total_cost);
						});
					});

                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });

				});
				
			});
		</script>
        <script>
            $( "#property" ).change(function() {
                var property=$("#property").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'index.php/maintenance/get_property_type' ?>",
                    data: 'property_id=' + property,
                    cache: false,
                    success: function(html){
                        var asset_type = $.trim(html);
                        if (asset_type=='Residential') {
                            $('#particular_1').val('Maintenance');
                            $('#particular_1_label').html('Maintenance');
                        } else {
                            $('#particular_1').val('CAM');
                            $('#particular_1_label').html('CAM');
                        }
                    } 
                });

                var dataString = 'property_id=' + property + '&m_id=' + <?php if(isset($m_id)) echo $m_id; else echo '0';?>;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . 'index.php/maintenance/get_sub_property' ?>",
                    data: dataString,
                    cache: false,
                    success: function(html){
                       $("#sub_property").html(html);

                        getCost();
                        if(html==""){
                            $("#sub_property_div").hide();
                        } else {
                            $("#sub_property_div").show();
                            $('#cost_table').show();

                            // $("#payment_summary").html('');
                            // $("#schedule_tax_detail").html('');
                            // $("#tot_budget").html('0');
                            // $("#tot_paid").html('0');
                            // $("#tot_outstanding").html('0');
                        }
                    } 
                });
            });

            $( "#sub_property" ).change(function() {
                getCost();
            });

            function getCost(){
                var property=$("#property").val();
                var sub_property=$("#sub_property").val();
                var dataString = 'property_id=' + property + '&sub_property_id=' + sub_property;

                $("#due_date_1").val("");
                $("#due_date_2").val("");
                $("#frequency_1").val("");
                $("#frequency_2").val("");
                $("#cost_1").val("");
                $("#cost_2").val("");
                $('#sch_tax_1').selectpicker('deselectAll');
                $('#sch_tax_1').selectpicker('refresh');
                $("#amount_1").val("");
                $("#amount_2").val("");
                $("#amount_1_text").html("");
                $("#amount_2_text").html("");
                $("#total_cost").html("");
                $("#total_amount").html("");

                if(property!=0 && property!=null) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'index.php/maintenance/get_cost' ?>",
                        data: dataString,
                        dataType:"json",
                        async: false,
                        cache: false,
                        success: function(data){
                            var txn_id = data.txn_id;

                            if (txn_id!=null && txn_id!="") {
                                window.open("<?php echo base_url();?>index.php/maintenance/edit/" + txn_id,"_parent","true");
                            }
                        }
                    });
                }

                $('#cost_table').show();
            }

            $(document).ready(function(){
                $('.m_cost').keyup(function() {
                    var total_cost = 0;
                    var total_cost_view = "";

                    $('.m_cost').each(function(index, value) {
                        total_cost = total_cost + get_number($(this).val(),2);
                        // alert(format_number(total_cost,2));
                        total_cost_view = format_money(total_cost,2);
                        $("#total_cost").html(total_cost_view);
                    });
                });

                getAmount();
            });

            $('#cost_1').blur(function(){
                getAmount();
            });

            $('#cost_2').blur(function(){
                getAmount();
            });

            function getAmount(){
                var cost = get_number($('#cost_1').val());
                var selectedTaxes=$('#sch_tax_1').map(function(){return $(this).val();}).get();
                var amount = cost;
                for(var j=0;j<selectedTaxes.length;j++){                    
                    var  percenttax=selectedTaxes[j];
                    var dataString = 'tax_id=' + percenttax;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . 'index.php/maintenance/get_tax_details' ?>",
                        data: dataString,
                        dataType:"json",
                        async: false,
                        cache: false,
                        success: function(data){
                            var tax_percent = data.tax_percent;

                            if (tax_percent!=null && tax_percent!="") {
                                exact_percent=tax_percent;
                            } else {
                                exact_percent=0;
                            }
                        }
                    });

                    // var percent1=percenttax.split("_");
                    // var exact_percent=0;
                    // exact_percent=percent1[1];
                    // console.log(exact_percent);
                    var percentAmount=0;
                    percentAmount=parseInt(exact_percent)*parseInt(cost)/parseInt(100);
                    // console.log(percentAmount);
                    amount=parseInt(amount) + parseInt(percentAmount);
                }
                $('#amount_1').val(amount);
                $('#amount_1_text').html(format_money(amount));

                $('#amount_2').val(get_number($('#cost_2').val()));
                $('#amount_2_text').html($('#cost_2').val());

                var tot_amount=parseInt($('#amount_1').val()) + parseInt($('#amount_2').val());
                $('#total_amount').html(format_money(tot_amount));
            }
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>