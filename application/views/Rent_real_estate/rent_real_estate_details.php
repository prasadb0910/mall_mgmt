<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .toggle {
            -webkit-appearance: none;
            appearance: none;
            width: 45px;
            height: 24px;
            display: inline-block;
            position: relative;
            border-radius: 50px;
            overflow: hidden;
            outline: none;
            border: none;
            cursor: pointer;
            background-color: #da5050;
            transition: background-color ease 0.3s;
        }
        .toggle:before {
            content: "Yes No";
            display: block;
            position: absolute;
            z-index: 2;
            width: 16px;
            height: 16px;
            background: #fff;
            left: 1px;
            top: 4px;
            border-radius: 50%;
            font: 9px/19px Helvetica;
            text-transform: uppercase;
            font-weight: bold;
            text-indent: -22px;
            word-spacing: 27px;
            color: #fff;
            text-shadow: -1px -1px rgba(0,0,0,0.15);
            white-space: nowrap;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s;
        }
        .toggle:checked {
            background-color: #4CD964;
        }
        .toggle:checked:before {
            left: 29px;
        }
        .a {
            border-bottom: 2px solid #edf0f5;
            margin-bottom: 25px;
            padding-bottom: 25px;
        }
       .div_heading h5 {
           font-size: 14px;
            font-weight: 600;
            color: #40434b;
            margin-top: 0px;
            margin-bottom: 0px;
        	text-align:left;
        }
		.view_table tr:nth-child(even) {
			background-color:transparent!important;
		}
		.view_table td, .view_table th
		{
			border:none!important; 
			padding: 8px;
			text-align:center;
		}
        .add {
            color:#41a541;
            cursor:default;
            font-size:14px;
            font-weight:500;
        }
        .remove {
            color:#d63b3b;
            text-align:right;
            cursor:default;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1 {
            padding: 20px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
			text-align: left;
        }
        .block {
            text-align: left;
        }
        .delete {
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:default;
            margin-top: 15px;
            font-size:20px;
            font-weight:500;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            font-weight:400;
        }
        .blue-btn:hover,
        .blue-btn:active,
        .blue-btn:focus,
        .blue-btn {
            background: transparent;
            border: dotted 1px #27a9e0;
            border-radius: 3px;
            color: #27a9e0;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none !important;
            padding: 10px 20px;
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
            height: 50px;
            margin-top: 0;
        }
        .fileUpload input.uploadlogo {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 42px;
        }
        input::-webkit-file-upload-button {
            cursor: pointer !important;
            height: 42px;
            width: 100%;
        }
        .attachments {
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
          
        }
        #form_rent {
            text-align: center;
            position: relative;
				
        }
        #form_rent fieldset {
            background: white;
            border: 0 none;
            border-radius: 0px;

            padding: 20px 30px;
            box-sizing: border-box;
            width: 85%;
            margin: 0 8%;

            position: relative;
        }
        #form_rent fieldset:not(:first-of-type) {
            display: none;
        }
        #form_rent .action-button {
            width: 100px;
            background: #ee0979;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }
        #form_rent .action-button:hover, #form_rent .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #ee0979;
        }
        #form_rent .action-button-previous {
            width: 100px;
            background: #C5C5F1;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }
        #form_rent .action-button-previous:hover, #form_rent .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
        }
        .fs-title {
            font-size: 18px;
            text-transform: uppercase;
            color: #2C3E50;
            margin-bottom: 10px;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .fs-subtitle {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }
        #progressbar li {
            list-style-type: none;
            /*color: white;*/
            text-transform: uppercase;
            font-size: 9px;
            width: 33.33%;
            float: left;
            position: relative;
            letter-spacing: 1px;
        }
        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 24px;
            height: 24px;
            line-height: 26px;
            display: block;
            font-size: 12px;
            color: #333;
            background: white;
            border-radius: 25px;
            margin: 0 auto 10px auto;
        }
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: white;
            position: absolute;
            left: -50%;
            top: 9px;
            z-index: -1; /*put it behind the numbers*/
        }
        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }
        #progressbar li.active:before, #progressbar li.active:after {
            background: #a5b1de;
            color: white;
        }
        .dme_link {
            margin-top: 30px;
            text-align: center;
        }
        .dme_link a {
            background: #FFF;
            font-weight: bold;
            color: #ee0979;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 5px 25px;
            font-size: 12px;
        }
        .dme_link a:hover, .dme_link a:focus {
            background: #C5C5F1;
            text-decoration: none;
        }
        /*.view_table td, .view_table th {
            border:0px!important;
            text-align:center!important;
        }
        .view_table tr:nth-child(even) {
            background-color: #fff!important;
        }*/
        .checkbox label::after {
            left:0.5px!important;
        }
        .select2-container .select2-selection .select2-selection__rendered {
            float: left!important;
        }
        .addschedule td{
            border:1px solid;
            padding:0px !important;
        }
        .addschedule th{
            border:1px solid;
        }
        .addtax td{
            border:1px solid;
            /*padding:0px !important;*/
        }
        .addtax th{
            border:1px solid;
        }
        .modal-content{
            width: 1000px;
        }
        #schedule_table td{
            background:#ffffff;
        }
        .modal-footer{
            display: block;
        }
        /*.select2-container {
            z-index:9999!important;
        }*/
        .form-group label {
            text-align: left;
        }
        /*#pdc_table td {
            padding: 0px;
        }*/
		.panel-description {
            color: #8c919e;
            font-size: 0.85714rem;
        	float:left;
        	text-align:left;
        }
		.recurring .select2-container {
            height: 26px!important;
		}
        .recurring .select2-container .select2-selection.select2-selection--single {
            height: 26px!important;
        	padding-top: 0px!important;
        }
		.view_table {
		    /*max-width: 80%!important;*/
			text-align: center!important;
			margin: 0 auto!important;
		}
        .form-group-default1 {
    background-color: #fff;
    position: relative;
    border: 1px solid rgba(0,0,0,0.07);
    border-radius: 2px;
    padding-top: 7px;
    padding-left: 12px;
    padding-right: 12px;
    padding-bottom: 4px;
    overflow: hidden;
    width: 100%;
    -webkit-transition: background-color 0.2s ease;
    transition: background-color 0.2s ease;
}
.form-group-default1 .form-control {
    border: none;
    height: 25px;
    min-height: 25px;
    padding: 0;
    margin-top: -4px;
    background: none;
}
.form-group-default1.input-group .input-group-addon {
    height: 52px;
    border-radius: 0!important;
    border: none!important;
}
.form-group-default1 label {
    margin: 0;
    display: block;
    opacity: 1;
    -webkit-transition: opacity 0.2s ease;
    transition: opacity 0.2s ease;
}
.form-group-default1.input-group .form-input-group {
    width: 100%;
}
.form-group-default1.input-group {
    padding: 0;
}
.form-group-default1.input-group label {
    margin-top: 6px;
    padding-left: 12px;
}
 
.form-group-default1 label {
    margin: 0;
    display: block;
    opacity: 1;
    -webkit-transition: opacity 0.2s ease;
    transition: opacity 0.2s ease;
}



    </style>
</head>
<body class="fixed-header ">
<?php  $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
    <div class="content ">
    <form id="form_rent" role="form" method="POST" enctype="multipart/form-data" action="<?php if(isset($rent)){ echo base_url().'index.php/Rent_real_estate/updaterecord/'.$r_id; } else { echo base_url().'index.php/Rent_real_estate/saverecord';} ?>">
        <input type="hidden" name="rent_module_type" value="1">
        <div class=" container-fluid container-fixed-lg ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url().'index.php/Dashboard/'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?=base_url().'index.php/Rent_real_estate/'?>">Rent List</a></li>
                <?php if(isset($rent)){ ?>
                <li class="breadcrumb-item"><a href="<?=base_url().'index.php/Rent_real_estate/view/'.$r_id?>">Rent View</a></li>
                <?php } ?>
                <li class="breadcrumb-item active">Rent Details</li>
                <input type="hidden" id="r_id" name="r_id" value="<?php if(isset($rent)) echo $r_id; ?>" />
            </ol>
            <div class="row">
                <div class="col-md-12 ">
                    <ul id="progressbar">
                        <li class="active" style="text-align: center;">Property & Tenants</li>
                        <li style="text-align: center;">Extra Fees & Utilities</li>
                        <li style="text-align: center;">Agreement & Documents</li>
                    </ul>
                    <fieldset id="panel-rent-details" class="rent_field">
                        <div class="a">
                       	    <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="div_heading ">
                                        <h5>Property Information & Terms</h5>
                                    </div>
                                    <p class="panel-description">Select the property, unit for the lease. Add the start and/or end date of the lease, Lockin Period and Notice Period for the lease. </p>
    							</div>
							</div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Unit Name</label>
                                        <select class="full-width" name="property" id="property" data-error="#err_unit" data-placeholder="Select" data-init-plugin="select2" onchange="get_property_details();" data-minimum-results-for-search="Infinity">
                                            <option value="">Select</option>
                                             <?php if(isset($rent)) { 
                                                for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->property_txn_id; ?>" <?php if($rent[0]->property_id == $property[$i]->property_txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->unit_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->property_txn_id; ?>"><?php echo $property[$i]->unit_name; ?></option>
                                            <?php } } ?>
                                        
                                        </select>
                                        <div id="err_property"></div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="sub_property_div">
                                   
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <div class="form-group form-group-default required">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control datepicker" name="possession_date" id="possession_date" onchange="calculatedate(); instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { if($rent[0]->possession_date!=null && $rent[0]->possession_date!='') echo date('d/m/Y',strtotime($rent[0]->possession_date)); }} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-default required">
                                        <label>End Date</label>
                                        <input type="text" class="form-control datepicker" name="termination_date" id="termination_date" onchange="calculatedate(); instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { if($rent[0]->termination_date!=null && $rent[0]->termination_date!='') echo date('d/m/Y',strtotime($rent[0]->termination_date)); }} ?>"/>
                                    </div>
                                </div>
								
								  <div class="col-md-3">
                                    <div class="form-group form-group-default " id="noticep_error">
                                        <label>Lockin Period In Months</label>
                                        <input type="text" class="form-control format_number" name="locking_period" id="locking_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->locking_period; }} ?> " readonly />
                                      
                                    </div>
                                </div>
								
                                <div class="col-md-3">
                                    <div class="form-group form-group-default ">
                                        <label>Lease Period In Months</label>
                                        <input type="text" class="form-control format_number" name="lease_period" id="lease_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->lease_period; }} ?>" />
                                    </div>
                                </div>
                              
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <div class="form-group form-group-default " id="rentp_error">
                                        <label>Free Rent Period In Months</label>
                                        <input type="text" class="form-control format_number" name="free_rent_period" id="free_rent_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->free_rent_period; }} ?>"/> 
                                    </div>
                                </div>
                                   <div class="col-md-3">
                                    <div class="form-group form-group-default " id="noticep_error">
                                        <label>Notice Period In Months</label>
                                        <input type="text" class="form-control format_number" name="notice_period" id="notice_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->notice_period; }} ?>" />
                                      
                                    </div>
                                </div>
								
								<div class="col-md-6">
                            </div>
                            </div>
                        </div>
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="div_heading ">
                                        <h5>Resident</h5>	
                                    </div>
                                    <p class="panel-description">Select the tenant(s) from the dropdown below. If your tenant is connected with you, the lease will be automatically shared with them and posted on their Tenant Portal.</p>
        						</div>
							</div>
                            <div id="repeattenant">

                                <?php $j=0; if(isset($tenants)) { 
                                    for ($j=0; $j < count($tenants) ; $j++) { ?>

                                <div id="repeat_tenant_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Tenant</label>
                                            <select id="tenant_name_<?php echo $j+1; ?>" name="tenant[]" class="form-control tenant full-width select2" data-error="#err_tenant_name_<?php echo $j+1; ?>" data-placeholder="Select" data-init-plugin="select2" >
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"
                                                    <?php if($contact[$k]->c_id==$tenants[$j]->contact_id) 
                                                    { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_tenant_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_tenant_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_tenant_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Tenant</label>
                                            <select id="tenant_name_<?php echo $j+1; ?>" name="tenant[]" class="form-control tenant full-width select2" data-error="#err_tenant_name_<?php echo $j+1; ?>" data-placeholder="Select" data-init-plugin="select2" >
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_tenant_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_tenant_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="tenant_box">
                                <div class="block" id="tenant_block">
                                    <span style="float:left;" class="add" id="repeat-tenant">+ Add</span>
                                </div>
                            </div>
							 <br>
                        </div>
						
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="div_heading ">
                                        <h5>Recurring & Transactions</h5>
                                    </div>
                                    <p class="panel-description">To create a recurring invoice, input the amount of the transaction and choose an invoice schedule.The invoice date is the date the first invoice will be due. Then pick what due date the recurring transaction will be set for. Click Yes if GST applicable. IF TDS is set to yes please input % of TDS. If you receive Post Dated Cheque from Tenant then click in Add PDC button to input all entries of PDCs.</p>
    							</div>
							</div>
                         
                            <div id="transaction">
							   <div class="row clearfix">
							       <div class="col-md-3">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label class="">Category</label>
                                            <select class="full-width" name="category" id="category" data-error="#err_schedule" data-placeholder="Select" data-init-plugin="select2" onchange="instchange(); opentable();" data-minimum-results-for-search="Infinity"><option value="Rent">Rent</option>
                                            </select>
                                            <div id="err_schedule"></div>
                                        </div>
                                   </div>
									
								    <div class="col-md-3">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label class="">Type Of Rent</label>
                                            <select class="full-width" name="rent_type" id="rent_type" data-error="#err_schedule" data-placeholder="Select" data-init-plugin="select2" onchange="rentype();" data-minimum-results-for-search="Infinity">
                                                <option value="">Select</option>
                                                <option  <?php   if(isset($rent)) { $rent[0]->rent_type=='fixed';  echo ($rent[0]->rent_type=='fixed'?"selected":"");} else "";  ?>  value="fixed">Fixed</option>
                                                <option  <?php  if(isset($rent)) { echo ($rent[0]->rent_type=='revenue'?"selected":"");} else "";  ?>   value="revenue">% Revenue
                                                </option>
                                            </select>
                                            <div id="err_schedule"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default ">
                                            <label>Amount</label>
                                            <input type="text" class="form-control format_number rent_amount" name="rent_amount" id="rent_amount" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>=0) { echo format_money($rent[0]->rent_amount,2); }} ?>" />
                                        </div>
                                    </div>
                                     <div class="col-md-3"   id="revenue_percentage" >
                                        <div class="form-group form-group-default ">
                                            <label>Revenue % </label>
                                            <input type="text" class="form-control format_number rent_amount" name="revenue_percentage" id="revenue_percentage_id" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>=0) { echo format_money($rent[0]->revenue_percentage,2); }} ?>"  />
                                        </div>
                                    </div>
                               </div>
                               <div class="row clearfix">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label class="">Invoice Schedule</label>
                                            <select class="full-width" name="schedule" id="schedule" data-error="#err_schedule" data-placeholder="Select" data-init-plugin="select2" onchange="instchange(); opentable();" data-minimum-results-for-search="Infinity">
                                                <option value="">Select</option>
                                                <option value="Monthly" <?php if(isset($rent)) if($rent[0]->schedule == 'Monthly') { echo 'selected';} ?> >Monthly</option>
                                                <option value="Quarterly" <?php if(isset($rent)) if($rent[0]->schedule == 'Quarterly') { echo 'selected';} ?> >Quarterly</option>
                                                <option value="Yearly" <?php if(isset($rent)) if($rent[0]->schedule == 'Yearly') { echo 'selected';} ?> >Yearly</option>
                                            </select>
                                            <div id="err_schedule"></div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                            <div class="form-group form-group-default ">
                                                <label>First Invoice Date</label>
                                                <input type="text" class="form-control datepicker" name="invoice_date" id="invoice_date" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { if($rent[0]->invoice_date!=null && $rent[0]->invoice_date!='') echo date('d/m/Y',strtotime($rent[0]->invoice_date)); }} ?>"/>
                                            </div>
                                     </div>
                                     <div class="col-md-3"  id="revenue_due_day">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label> Revenue % input due day</label>
                                                <select class="full-width" name="revenue_due_day" id=""  data-error="#err_revenue_due_day" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                    <option value="">Select</option>
                                                    <?php if(isset($rent) && count($rent)>0) {
                                                            for($i=1; $i<=31; $i++) { 
                                                                if($rent[0]->rent_due_day==$i) echo '<option selected>'.$i.'</option>'; 
                                                                else echo '<option>'.$i.'</option>';}} 
                                                    else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
                                                </select>
                                                <div id="err_revenue_due_day"></div>
                                            </div>
                                     </div>
    								 <div class="col-md-3" >
                                            <div class="form-group form-group-default input-group">
                                                <div class="form-input-group">
                                                    <label class="inline" style="float:left!important;">Advance Rent?</label>
                                                 
                                                </div>
                                                <div class="input-group-addon bg-transparent h-c-50">
                                                    <input type="checkbox" name="advance_rent" id="advance_rent" value="yes" onchange="set_advrent()" class="toggle"  <?php if(isset($rent)) { if($rent[0]->advance_rent==1) echo 'checked'; } ?> />
                                                </div>
                                            </div>
                                     </div>
                                     </div>
								 <div class="row clearfix">
    								 <div class="col-md-3">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label>  Due Day</label>
                                                <select class="full-width" name="rent_due_day" id="rent_due_day" data-error="#err_rent_due_day" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                                    <option value="">Select</option>
                                                    <?php if(isset($rent) && count($rent)>0) {
                                                            for($i=1; $i<=31; $i++) { 
                                                                if($rent[0]->rent_due_day==$i) echo '<option selected>'.$i.'</option>'; 
                                                                else echo '<option>'.$i.'</option>';}} 
                                                    else {for($i=1; $i<=31; $i++) { echo '<option>'.$i.'</option>';}} ?>
                                                </select>
                                                <div id="err_rent_due_day"></div>
                                            </div>
                                     </div>
									 
									  <div class="col-md-9">   </div>
                                </div>
                                <div class="row clearfix recurring">
                                   
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 input-group gst">
                                            <div class="form-input-group">
                                                <label class="inline" style="float:left!important;">GST Rate</label>
                                              
                                                <select class="full-width" name="gst_rate" id="gst_rate" <?php if(isset($rent)) { if($rent[0]->gst==1) echo ''; else echo 'disabled'; } else echo 'disabled'; ?> onchange="instchange(); opentable(); set_tax();" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity"  data-error="#err_gst_rate" >
                                                    <option value="">Select</option>
                                                    <?php 
                                                        $selected='';
                                                        if(isset($tax)){
                                                            foreach($tax as $row){
                                                                if(isset($rent)) { 
                                                                    if(count($rent)>=0) { 
                                                                        if($rent[0]->gst_rate==$row->tax_id) $selected = "selected='selected'"; 
                                                                    }
                                                                }
                                                                echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
												 <div id="err_gst_rate"></div>
                                            </div>
                                            <div class="input-group-addon bg-transparent h-c-50">
                                                <input type="checkbox" class ="toggle" name="gst" id="gst" value="yes" onchange="set_gst();"<?php if(isset($rent)) { if($rent[0]->gst==1) echo 'checked'; } ?> />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default input-group">
                                            <div class="form-input-group">
                                                <label style="">TDS Rate In %</label>
                                                <input type="text" class="form-control format_number" name="tds_rate" id="tds_rate" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>=0) { echo format_money($rent[0]->tds_rate,2); }} ?>" <?php if(isset($rent)) { if($rent[0]->tds==1) echo '';   } else { echo "disabled" ;} ?>    style="" /></label>
                                            </div>
                                            <div class="input-group-addon bg-transparent h-c-50">
                                                <input type="checkbox" name="tds" id="tds" value="yes" onchange="set_tds();" class="toggle"  <?php if(isset($rent)) { if($rent[0]->tds==1) echo 'checked'; } ?> />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding-right: 7px;">
                                        <div class="form-group form-group-default input-group">
                                            <div class="form-input-group">
                                                <label class="inline" style="float:left!important;">PDC</label>
                                                <!-- <input type="text" class="form-control " name="tds_rate" id="tds_rate" value="yes" placeholder="Enter Here" style="text-align:center;"> -->
                                            </div>
                                            <div class="input-group-addon bg-transparent h-c-50">
                                                <input type="checkbox" name="pdc" id="pdc" value="yes" onchange="set_pdc();" class="toggle"  <?php if(isset($rent)) { if($rent[0]->pdc==1) echo 'checked'; } ?> />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="add_pdc" style="<?php if(isset($rent)) { if($rent[0]->pdc==1) echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
                                    <button type="button" class="btn btn-default-info pull-right" data-toggle="modal" data-target="#myModal2">Yes Add PDCs</button>
                                    <br><br>
                                </div>
                            </div>

                            
                            
                            <div class="optionBox" id="tenant_box">
                                <div class="block" id="tenant_block">
                                    <span style="float:left;" class="add" id="repeat-transaction">+ Add</span>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="a">
                       	    <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="div_heading ">
                                        <h5>Deposits</h5>
                                    </div>
                                    <p class="panel-description">Record deposits and amount that is received by tenant in this section.</p>
        						</div>
							</div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Amount In &#x20B9;</label>
                                        <input type="text" class="form-control format_number" name="deposit_amount" id="deposit_amount" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo format_money($rent[0]->deposit_amount,2); }} ?>"/>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6" style="<?php if(isset($deposit_paid_details)) { if(count($deposit_paid_details)>0) { echo ''; } else echo 'display: none;'; } else echo 'display: none;'; ?>">
                                    <div class="form-group form-group-default required">
                                        <label>Paid Amount In &#x20B9;</label>
                                        <input type="text" class="form-control format_number" name="deposit_paid_amount" id="deposit_paid_amount" placeholder="Enter Here" value="<?php if(isset($deposit_paid_details)) { if(count($deposit_paid_details)>0) { echo format_money($deposit_paid_details[0]->paid_amount,2); }} ?>" readonly />
                                    </div>
                                </div> -->
                                <div class="col-md-6" style="display: none;">
                                    <div class="form-group form-group-default required">
                                        <label class="">Category </label>
                                        <input type="text" class="form-control" name="deposit_category" id="deposit_category" placeholder="Enter Here" value="<?php if(isset($rent)) echo $rent[0]->deposit_category; else echo 'Deposit'; ?>" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="a">
    						<div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="div_heading ">
                                        <h5>Y-o-Y</h5>
                                    </div>
                                    <p class="panel-description">Input Y-o-Y Escalations for the coming years if lockin period is more than 1 year. Rent will automatically increase at the time of escalation increase year.</p>
        						</div>
    						</div>
                            <div id="repeatescalation">

                                <?php $j=0; if(isset($escalations)) { 
                                    for ($j=0; $j < count($escalations) ; $j++) { ?>

                                <div id="repeat_escalation_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Escalate Date</label>
                                            <input type="text" class="form-control escalation datepicker" name="esc_date[]" id="esc_date_<?php echo $j+1; ?>" placeholder="Enter Here" value="<?php if(isset($escalations)) { if(count($escalations)>0) { if($escalations[$j]->esc_date!=null && $escalations[$j]->esc_date!='') echo date('d/m/Y',strtotime($escalations[$j]->esc_date)); }} ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default ">
                                            <label>Escalation IN % </label>
                                            <input type="text" class="form-control format_number" name="escalation[]" id="escalation_<?php echo $j+1; ?>" placeholder="Enter Here" value="<?php if(isset($escalations)) { if(count($escalations)>0) { echo format_money($escalations[$j]->escalation,2); }} ?>"/>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_escalation_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_escalation_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Escalate Date</label>
                                            <input type="text" class="form-control escalation datepicker" name="esc_date[]" id="esc_date_<?php echo $j+1; ?>" placeholder="Enter Here" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default ">
                                            <label>Escalation IN % </label>
                                            <input type="text" class="form-control format_number" name="escalation[]" id="escalation_<?php echo $j+1; ?>" placeholder="Enter Here" value=""/>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_escalation_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="escalation_box">
                                <div class="block" id="escalation_block">
                                    <span style="float:left;" class="add" id="repeat-escalation">+ Add</span>
                                </div>
                            </div>
							 <br>
                        </div>
                        <div class="a" style="display: none;">
                            <!-- <p class="div_heading"><b> Rent Consideration<b></p>
                            <br/> -->
                            <div class="row clearfix" id="temp_schedule_div"></div>

                            <?php if(isset($p_schedule)) { ?>
                            <div class="row clearfix" id="actual_schedule_div">
                                <div class="col-md-12">
                                    <table class="view_table addsummary">
                                        <thead>
                                            <tr>
                                                <th width="55">Sr. No.</th>
                                                <th width="120">Type</th>
                                                <th width="120">Total Cost  (In &#x20B9;)</th>
                                                <?php if(isset($tax_name)){
                                                            $key=0;
                                                            foreach($tax_name as $row){
                                                                echo '<th style="text-align: center;vertical-align: middle;">'.$row->tax_type.' (In &#x20B9;)</th>';
                                                                $tax_array[$key]=$row->tax_type;
                                                                $key++;
                                                            }
                                                        }
                                                ?>
                                                <th width="120">Net Cost (In &#x20B9;)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $j=0;
                                                $total_basic_cost=0;
                                                $total_net_amount=0;
                                                $total_tax_array=array();
                                                
                                                foreach($p_schedule as $row_tax) {
                                                    echo '<tr>
                                                    <td align="center">'.($j+1).'</td>
                                                    <td>'.$row_tax["event_type"].'</td>
                                                    <td class="text-right">'.format_money($row_tax["basic_cost"],2).'</td>';
                                                    $total_basic_cost=$total_basic_cost+$row_tax["basic_cost"];
                                                    $next_count=0;
                                                    $td_count=0;
                                                    // print_r($p_schedule);
                                                    if(isset($row_tax['tax_type'])) {
                                                        // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                        //echo "<br>hi";
                                                        // echo $key;
                                                        for($tcnt=0;$tcnt<$key;$tcnt++){
                                                            //echo "step1--";
                                                            for($nc=0;$nc<count($row_tax['tax_type']);$nc++){
                                                                $tax_amount='';
                                                                if($row_tax['tax_type'][$nc]==$tax_array[$tcnt]){
                                                                    $tax_amount=$row_tax['tax_amount'][$nc];
                                                                    $nc=count($row_tax['tax_type']);
                                                                    //$tcnt=$key;
                                                                    //}
                                                                }
                                                            }
                                                            if($tax_amount !=''){
                                                                echo '<td  >'.format_money($tax_amount,2).'</td>';
                                                                $td_count++;
                                                            }
                                                            else{
                                                                //if($next_count )
                                                                echo '<td  >'.format_money($tax_amount,2).'</td>';
                                                                $td_count++;
                                                            }
                                                            // $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
                                                            //  $total_tax_array[$tcnt]= $tax_amount;
                                                            // print_r($total_tax_array);
                                                        }
                                                    }
                                                    $inserttd=$key-$td_count;
                                                    if($inserttd !=0){
                                                        for($tdint=0;$tdint<$inserttd;$tdint++){
                                                            echo "<td></td>";
                                                        }
                                                    }

                                                    echo '<td  class="text-right">'.format_money($row_tax["net_amount"],2).'</td></tr>';
                                                    $total_net_amount=$total_net_amount+$row_tax["net_amount"];
                                                    //print_r($p_schedule[$j]['event_type']);
                                                    $j++;
                                                }
                                            ?>

                                            <tr>
                                                <td colspan="2" align="right"><b>Grand Total (In &#x20B9;)</b></td>
                                                <td class="text-right"><?php echo (isset($total_basic_cost)?format_money($total_basic_cost,2):0);?></td>
                                                <?php  
                                                    $k=0;
                                                    if (isset($total_tax_amount)) {
                                                        foreach($total_tax_amount as $row){
                                                            echo '<td class="text-right">'.format_money($row[$k],2).'</td>';
                                                            $k++;
                                                        }
                                                    }
                                                ?>
                                               <td class="text-right"><?php echo (isset($total_net_amount)?format_money($total_net_amount,2):0);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php } ?>
                            <br>

                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick=" return false;">Schedule</button>

                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Schedule</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row clearfix" >
                                            <label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
                                            <div class="fileUpload blue-btn btn width100">
                                                <span><i class="fa fa-cloud-upload"></i> Upload Schedule</span>
                                                <input type="file" class="uploadlogo" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()" />
                                            </div>
                                            <label class="control-label" style="color:#000;"><a href="schedule_format_rent.xlsx" target="_blank">Download Format</a></label>
                                            <!-- <input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()"/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="<?php //echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a> -->
                                            <!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-12" id="import_schedule">
                                                <table class="view_table addschedule">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;" width="60">Sr. No.</th>
                                                            <th style="display:none;">Event Type</th>
                                                            <th width="120">Event Name</th>
                                                            <th width="120">Date</th>
                                                            <th width="130">Basic Cost  (In &#x20B9;)</th>                    
                                                            <th width="150">Tax Appilcable</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="schedule_table">
                                                        <?php $i=0; $schedule_id=1;
                                                        if(isset($p_schedule1)){
                                                        //print_r($p_schedule1);
                                                        foreach($p_schedule1 as $row){
                                                            $sch_id=$p_schedule1[$i]['schedule_id'];
                                                            $event_type=$p_schedule1[$i]['event_type'];
                                                            $event_name=$p_schedule1[$i]['event_name'];
                                                            $basic_cost=$p_schedule1[$i]['basic_cost'];
                                                            $event_date=date('d/m/Y',strtotime($p_schedule1[$i]['event_date']));
                                                            $tax_master=array();
                                                            $j=0;
                                                            if(isset($p_schedule1[$i]['tax_type'])){
                                                                for($j=0;$j<count($p_schedule1[$i]['tax_type']);$j++ ){
                                                                    //$p_schedule1[$i]['tax_master'][$j];
                                                                    $tax_master[]=$p_schedule1[$i]['tax_master_id'][$j];
                                                                }
                                                            }
                                                        ?>

                                                        <tr id="repeat_schedule_<?php echo $i+1; ?>">
                                                            <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle"><?php echo $i+1; ?></td>
                                                            <input type="hidden"  name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>

                                                            <td style="display: none;"><input type="text"  name="sch_type[]" class="form-control" value="<?php echo $event_type;?>" style="border:none;"/></td>
                                                            <td><input type="text"  name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none;"/></td>
                                                            <td><input type="text"  name="sch_date[]" value="<?php echo $event_date;?>" class="form-control datepicker" style="border:none;"/></td>
                                                            <td><input type="text"   name="sch_basiccost[]" value="<?php echo format_money($basic_cost,2);?>" class="form-control format_number" style="border:none"/></td>
                                                            <td>
                                                                <select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="  select" style="display: none;">
                                                                <?php $schedule_id++;
                                                                    if(isset($tax)){
                                                                        //print_r($tax_id);
                                                                        foreach($tax as $row){
                                                                            if(in_array($row->tax_id, $tax_master)){
                                                                                //echo "hi";
                                                                                $selected="selected='selected'";
                                                                            }
                                                                            else{
                                                                                $selected='';
                                                                            }
                                                                            echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                        }
                                                                    };?>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <?php $i++; }} ?>
                                                    </tbody>
                                                    <!-- <tbody id="schedule_box" >
                                                        <tr class="block" id="schedule_block">
                                                            <td class="add" id="add_schedule">+ Add</td>
                                                        </tr>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                                        <button type="button" class="btn btn-default-danger" data-dismiss="modal">Close</button> -->

                                        <button class="btn btn-success repeat-schedule" id="schedule_btn" style=" ">+</button>
                                        <button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
                                        <button class="btn btn-default-danger pull-right mb-control-close" data-dismiss="modal" onclick="closetemp(); return false;">Close</button>
                                        <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="rowdisplaycount" value="<?php echo $i;?>">
                            <input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id-1;?>">
                        </div>
                        <div id="rent_error" style="color: rgb(224, 75, 74); padding-left: 20px;" class="error"></div>
                        <input type="button" name="next" class="btn btn-success next" value="Next"/>
                    </fieldset>
                    <fieldset class="rent_field">
                        <div class="a" id="rent_utility_div">
                           <div class="row clearfix">
							<div class="col-md-12">
								<div class="div_heading ">
									<h5>Utilities</h5>		
								</div>
							   <p class="panel-description">Please check the radiobutton appropriately if utilities cost is borne by either landlord or tenant or neither of two.</p>
						
							</div>
						</div>
						
                        
                            <table class="view_table">
                                <thead>
                                    <tr>
                                        <th>Perticulars</th>
                                        <th>Landlord</th>
                                        <th>Tenant</th>
                                        <th>N/A</th>
                                    </tr>
                                </thead>
                                <tbody id="rent_utilities">
                                    <?php //for ($k=0; $k < count($utility) ; $k++) { ?>
                                                <tr class="">
                                                <td>
                                                    <input type="hidden" id="utility" name="utility" value="2">
													Property Tax

                                                    <?php //if(isset($utility[$k]->utility)) echo $utility[$k]->utility; ?>
                                                </td>
												      
                                                <td>
                                              
                                                        <!-- <input type="checkbox" id="landlord<?php //echo $k+1; ?>" name="landlord" value="1" <?php //if(isset($utility[0]->landlord)) { if($utility[0]->landlord=='1') echo 'checked'; } ?> >
                                                        <label for="landlord"></label>-->
														<div class="radio radio-success">
														<input type="radio" value="Owner" name="utility_owner" id="landlord" <?php if(isset($utility[0]->utility_owner)) { if($utility[0]->utility_owner=='landlord') echo 'checked'; } ?>>
														<label for="landlord"></label>
														</div>
                                                </td>
                                                <td>
                                                
                                                        <!--<input type="checkbox" id="tenant<?php //echo $k+1; ?>" name="u_tenant" value="1" <?php// if(isset($utility[0]->tenant)) { if($utility[0]->tenant=='1') echo 'checked'; } ?> >
                                                        <label for="tenant"></label>-->
													<div class="radio radio-success">
														<input type="radio" value="Tenant" name="utility_owner" id="u_tenant" <?php if(isset($utility[0]->utility_owner)) { if($utility[0]->utility_owner=='u_tenant') echo 'checked'; } ?>>
														<label for="u_tenant"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                   
                                                        <!--<input type="checkbox" id="na" name="na" value="1" <?php// if(isset($utility[0]->na)) { if($utility[0]->na=='1') echo 'checked'; } ?> >
                                                        <label for="na"></label>-->
													<div class="radio radio-success">
                                                    <input type="radio"  value="na" name="utility_owner" id="na" <?php if(isset($utility[0]->utility_owner)) { if($utility[0]->utility_owner=='na') echo 'checked'; } ?>>
														<label for="na"></label>
													</div>
                                                </td>
                                            </tr>

										
                                    <?php //} ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="a" >
                           <div class="row clearfix">
						 <div class="col-md-12">
                            <div class="div_heading ">
                            <h5>Email Notifications</h5>		</div>
                           <p class="panel-description">Notification settings if want notify owners and tenants.</p>
						
							</div>
							</div>
                         
                            <table class="view_table">
                                <thead>
                                    <tr>
                                        <th>Particulars</th>
                                        <th>Owners</th>
                                        <th>Tenant</th>
                                    </tr>
                                </thead>
                                     <tbody id="email_notification">
                                    <?php //for ($k=0; $k < count($utility) ; $k++) { ?>
                                                <tr class="">
                                                <td>
                                                    <input type="hidden" id="email_notification" name="email_notification" value="6">
													Invoice is Posted			


                                                    <?php //if(isset($utility[$k]->utility)) echo $utility[$k]->utility; ?>
                                                </td>
                                                <td>
                                                    <div class="checkbox check-success">
                                                        <input type="checkbox" id="e_owners" name="e_owners" value="1" <?php if(isset($notification[0]->owner)) { if($notification[0]->owner=='1') echo 'checked'; } ?> >
                                                        <label for="e_owners"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkbox check-success">
                                                        <input type="checkbox" id="e_tenant" name="e_tenant" value="1" <?php if(isset($notification[0]->tenant)) { if($notification[0]->tenant=='1') echo 'checked'; } ?> >
                                                        <label for="e_tenant"></label>
                                                    </div>
                                                </td>
                                            
                                            </tr> 
                                    <?php //} ?>
                                </tbody>
                            </table>
                        </div>

                        <input type="button" class="btn btn-danger" value="Remove Lease" style="display: none;" />   
                        <input type="button" name="previous" class="btn btn-warning previous" value="Previous" />
                        <input type="button" name="next" class="btn btn-success next" value="Next" />
                    </fieldset>
                    <fieldset id="panel-documents" class="rent_field">
                        <div class="a">
                             <div class="row clearfix">
						 <div class="col-md-12">
                            <div class="div_heading ">
                            <h5>Document Details</h5>		</div>
                           <p class="panel-description">By default requirements of rent documents are displayed. Just need to add details. Also can add aditional documents if required by using plus button	.</p>
						
							</div>
							</div>
                            <?php $this->load->view('templates/document');?>
                            <div class="optionBox" id="optionBox1">
                                <div class="block" id="block2">
                                    <span class="add" id="repeat-documents">+ Add doc Details.</span>
                                </div>
                            </div>
                        </div>
                          <div class="row clearfix">
						 <div class="col-md-12">
                            <div class="div_heading ">
                            <h5>Remark</h5>		
							</div>
                          
						
							</div>
						</div>
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                        <label>Remark</label>
                                        <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($rent)){ echo $rent[0]->maker_remark;}?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="form_errors" style="display:none; color:#E04B4A; padding-left:20px;" class="error"></div>


                        <input type="button" name="remove" class="btn btn-danger" value="Remove Lease" style="display: none;" />   
                        <input type="button" name="previous" class="btn btn-warning previous pull-left" value="Previous" />

                        <input type="hidden" id="submitVal" value="1" />
                        <a href="<?php echo base_url(); ?>index.php/Rent_real_estate" class="btn btn-danger pull-left" style="margin-left: 10px;" >Cancel</a>
                        <input type="submit" class="btn btn-success pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                        <input type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" style="margin-right: 10px; <?php if($maker_checker!='yes' && isset($rent)) echo 'display:none'; ?>" />
                    </fieldset>

                    <div class="modal fade" id="myModal2" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">PDCS</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <table class="view_table" id="pdc_table">
                                                <thead>
                                                    <tr>
                                                        <th>Sr No.</th>
                                                        <th>Date</th>
                                                        <th>Particulars</th>
                                                        <th>Amount</th>
                                                        <th>Gst</th>
                                                        <th>TDS</th>
                                                        <th>Net Amount</th>
                                                        <th>Cheque no</th>
                                                        <th>Bank Name & Branch</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="repeatpdc">
                                                    <?php $j=0; if(isset($pdcs)) { 
                                                        for ($j=0; $j < count($pdcs) ; $j++) { ?>

                                                    <tr id="repeat_pdc_<?php echo $j+1; ?>" style="background-color: #ffffff;">
                                                        <td><?php echo $j+1; ?></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control datepicker pdc" name="pdc_date[]" value="<?php if(isset($pdcs)) { if(count($pdcs)>0) { if($pdcs[0]->pdc_date!=null && $pdcs[0]->pdc_date!='') echo date('d/m/Y',strtotime($pdcs[0]->pdc_date)); }} ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_particular[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_particular; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_amt[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_amt; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_gst[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_gst; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_tds[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_tds; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_net_amt[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_net_amt; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_chq_no[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_chq_no; } ?>"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_bank[]" value="<?php if(isset($pdcs)) { echo $pdcs[$j]->pdc_bank; } ?>"></div></td>
                                                        <td><div class="delete delete_row" id="repeat_pdc_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div></td>
                                                    </tr>

                                                    <?php } } else { ?>
                                                    
                                                    <tr id="repeat_pdc_<?php echo $j+1; ?>" style="background-color: #ffffff;">
                                                        <td><?php echo $j+1; ?></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control datepicker pdc" name="pdc_date[]" ></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_particular[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_amt[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_gst[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_tds[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_net_amt[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_chq_no[]"></div></td>
                                                        <td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_bank[]"></div></td>
                                                        <td><div class="delete delete_row" id="repeat_pdc_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div></td>
                                                    </tr>

                                                    <?php } ?>
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="add pull-left" id="repeat-pdc" colspan="10">+ Add</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                                    <button type="button" class="btn btn-default-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
<?php $this->load->view('templates/footer');?>
</div>
</div>
<?php $this->load->view('templates/script');?>
<script type="text/javascript">
     var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';

    <?php 
        $due_day = '<option value="">Select</option>';
        if(isset($rent) && count($rent)>0) {
            for($i=1; $i<=31; $i++) { 
                $due_day = $due_day . '<option>'.$i.'</option>';
            }
        } 
    ?>
    var due_day = '<?php echo $due_day; ?>';

    var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
    var tax = new Array();
    var taxname=new Array();
    var taxpurpose=new Array();
    window.cntrinst=0;

    <?php 
	if (isset($tax))
	{
			for ($i=0; $i < count($tax) ; $i++) { ?>
        tax.push('<?php echo $tax[$i]->tax_percent; ?>');
        taxname.push('<?php echo $tax[$i]->tax_name; ?>');
        taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
    <?php }} ?>
	


    <?php 
        $tax_list_details = '<option value="">Select</option>';
        if(isset($tax_details)){
            foreach($tax_details as $row){
                $tax_list_details = $tax_list_details . '<option value="'.$row->tax_id.'">'.str_replace("'","",$row->tax_name).'-'.$row->tax_percent.'</option>';
            }
        }
    ?>
    var tax_list_details = '<?php echo $tax_list_details; ?>';


    <?php 
        $invoice_issuer = '<option value="">Select</option>';
        if(isset($prop_owners)){
            for ($k=0; $k < count($prop_owners) ; $k++) {
                $invoice_issuer = $invoice_issuer . '<option value="'.$prop_owners[$k]->c_id.'">'.str_replace("'","",$prop_owners[$k]->owner_name).'</option>';
            }
        }
    ?>
    var invoice_issuer = '<?php echo $invoice_issuer; ?>';
</script>

<script type="text/javascript">
  $(document).ready(function() {
	
     rentype();
  });

  var rentype = function() {
	  
	
        if($('#rent_type').val()=="fixed")
        {
            $('#revenue_percentage_id').val('');
            $('#revenue_percentage').hide();
            $('#revenue_due_day').hide();
        }
        else if($('#rent_type').val()=="revenue")
        {
            console.log('revenue_percentage'+$('#revenue_percentage').val());
            $('#revenue_percentage').show();
            $('#revenue_due_day').show();
        }
		else
		{
			$('#revenue_percentage').hide();
            $('#revenue_due_day').hide();
		}
			
    }


</script>

<script type="text/javascript">
    function opentable(){
        if(flag==false) {
            // document.getElementById('myModal').style.display = "block";

            var lease=get_number(document.getElementById('lease_period').value,2);
            var rent=get_number(document.getElementById('rent_amount').value,2);
            //alert(rent);
            var stdt=document.getElementById('possession_date').value;
            var endt=document.getElementById('termination_date').value;
            var duedy=get_number(document.getElementById('rent_due_day').value,2);
            if (isNaN(duedy) || duedy==0) duedy=1;
            //duedy++;
            var amt2=Math.round(rent);
            rows='';
            var tax='';
            var tmpdt=new Date(stdt);
            //console.log(stdt);
            //alert(tmpdt);
            var yy=null;
            var mm=null;
            if($("#possession_date").val()!="" && $("#possession_date").val()!=null){
                mm=$("#possession_date").datepicker('getDate').getMonth();
                //console.log(mm);
                yy=$("#possession_date").datepicker('getDate').getFullYear();;
            }

            if(!isNaN(mm)){
                mm = mm + 1;
            }

            var increment = 1;
            if($('#schedule').val()=='Monthly'){
                increment = 1;
            } else if($('#schedule').val()=='Quarterly'){
                increment = 3;
                lease = Math.ceil(lease / 3);
                amt2 = amt2 * 3;
            } else if($('#schedule').val()=='Yearly'){
                increment = 12;
                lease = Math.ceil(lease / 12);
                amt2 = amt2 * 12;
            }

            // var cntSch = <?php //isset($p_schedule1)? echo count($p_schedule1): 0;?>
            // var counter = (cntSch>lease)?lease:cntSch;
            // for (var i=0; i<counter; i++) {
            <?php 
            $i=0; $schedule_id=1;
            if(isset($p_schedule1)){
                foreach($p_schedule1 as $row){
                    $sch_id=$p_schedule1[$i]['schedule_id'];
                    $event_type=$p_schedule1[$i]['event_type'];
                    $event_name=$p_schedule1[$i]['event_name'];
                    $basic_cost=format_number($p_schedule1[$i]['basic_cost'],2);
                    $event_date=date('d/m/Y',strtotime($p_schedule1[$i]['event_date']));
                    $tax_master=array();
                    $j=0;
                    if(isset($p_schedule1[$i]['tax_type'])){
                        for($j=0;$j<count($p_schedule1[$i]['tax_type']);$j++ ){
                            //$p_schedule1[$i]['tax_master'][$j];
                            $tax_master[]=$p_schedule1[$i]['tax_master_id'][$j];
                        }
                    }
            ?>

            // if(mm>11){
            //     mm=1;
            //     yy++;
            // } else {
            //     mm++;
            // }

            if(mm==13){
                mm=1;
                yy++;
            } else if(mm==14){
                mm=2;
                yy++;
            } else if(mm==15){
                mm=3;
                yy++;
            } else if(mm==16){
                mm=4;
                yy++;
            } else if(mm==17){
                mm=5;
                yy++;
            } else if(mm==18){
                mm=6;
                yy++;
            } else if(mm==19){
                mm=7;
                yy++;
            } else if(mm==20){
                mm=8;
                yy++;
            } else if(mm==21){
                mm=9;
                yy++;
            } else if(mm==22){
                mm=10;
                yy++;
            } else if(mm==23){
                mm=11;
                yy++;
            } else if(mm==24){
                mm=12;
                yy++;
            }

            var taxidcount=parseInt(i)+parseInt(1);
            var abc=yy+'/'+mm+'/'+duedy;

            mm = mm + increment;

            //alert(abc);
            abc=moment(abc).format('DD/MM/YYYY');

            rows=rows+ "<tr id='repeat_schedule_<?php echo $i+1; ?>'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'><?php echo $i+1; ?></td> \
            <td style='display: none;'> \
            <input type='hidden' name='sch_id[]' class='form-control' value='<?php echo $sch_id;?>' style='border:none;'/> \
            <input type='text' id='txttype_<?php echo $schedule_id;?>' name='sch_type[]' class='form-control' value='<?php echo $event_type;?>' style='border:none;'/> \
            </td> \
            <td><input type='text' id='txtevent_<?php echo $schedule_id;?>' name='sch_event[]' class='form-control' value='<?php echo $event_name;?>' style='border:none;'/></td> \
            <td><input type='text' id='txtdate_<?php echo $schedule_id;?>' name='sch_date[]' value='"+ abc +"' class='form-control datepicker' style='border:none;'/></td> \
            <td><input type='text' id='bs<?php echo $i; ?>' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='<?php echo format_money($basic_cost,2);?>' class='form-control format_number' style='border:none;'/></td> \
            <td><select class='form-control select' multiple name='sch_tax_<?php echo $schedule_id;?>[]'>";

            <?php $schedule_id++;
                if(isset($tax)){
                    foreach($tax as $row){
                        if(in_array($row->tax_id, $tax_master)){
                            //echo "hi";
                            $selected="selected='selected'";
                        } else {
                            $selected='';
                        } 
            ?>

            rows=rows+"<option value='<?php echo $row->tax_id;?>' <?php echo $selected;?>><?php echo $row->tax_name.'-'.$row->tax_percent ; ?></option>";
            
            <?php }} ?>

            rows=rows+ "</select></td></tr>";
            <?php $i++; }} ?>

            for (var i = <?php echo isset($p_schedule1)? count($p_schedule1): 0;?>; i < lease; i++) {
                // if(mm>11){
                //     mm=1;
                //     yy++;
                // } else {
                //     mm++;
                // }

                if(mm==13){
                    mm=1;
                    yy++;
                } else if(mm==14){
                    mm=2;
                    yy++;
                } else if(mm==15){
                    mm=3;
                    yy++;
                } else if(mm==16){
                    mm=4;
                    yy++;
                } else if(mm==17){
                    mm=5;
                    yy++;
                } else if(mm==18){
                    mm=6;
                    yy++;
                } else if(mm==19){
                    mm=7;
                    yy++;
                } else if(mm==20){
                    mm=8;
                    yy++;
                } else if(mm==21){
                    mm=9;
                    yy++;
                } else if(mm==22){
                    mm=10;
                    yy++;
                } else if(mm==23){
                    mm=11;
                    yy++;
                } else if(mm==24){
                    mm=12;
                    yy++;
                }

                var taxidcount=parseInt(i)+parseInt(1);
                var abc=yy+'/'+mm+'/'+duedy;

                mm = mm + increment;

                //alert(abc);
                abc=moment(abc).format('DD/MM/YYYY');
                var ntamt=amt2;

                rows=rows+ "<tr id='repeat_schedule_"+ (i+1) +"'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ (i+1) +"</td> <td style='display: none;'><input type='hidden' name='sch_id[]' class='form-control' value='' style='border:none;'/> <input type='text' id='txttype_"+ (i+1) +"' name='sch_type[]' class='form-control' value='Rent' style='border:none;'/></td><td><input type='text' id='txtevent_"+ (i+1) +"' name='sch_event[]' class='form-control' value='Rent' style='border:none;'/></td> <td><input type='text' id='txtdate_"+ (i+1) +"' name='sch_date[]' value='"+ abc +"'  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' id='bs"+i+"' onkeyup='calculatetaxes(this);' name='sch_basiccost[]' value='" + format_money(amt2,2) + "' class='form-control format_number' style='border:none;text-align:right;'/></td><td><select class='form-control select' multiple name='sch_tax_"+taxidcount+"[]'>";

                <?php if(isset($tax)){
                    foreach($tax as $row){ ?>
                        //alert("step"+i);
                        rows=rows+"<option value='<?php echo $row->tax_id;?>'><?php echo $row->tax_name."-".$row->tax_percent ; ?></option>";
                <?php } } ?>                    
                rows=rows+ "</select></td></tr>";
                ntamt=0;
            }

            document.getElementById('schedule_table').innerHTML=rows;

            set_tax();
            
            $(".select", rows).select2();
            // $('.datepicker', rows).datepicker({changeMonth: true,changeYear: true});
            $("#rowdisplaycount").val(i);
            $('.format_number').keyup(function(){
                format_number(this);
            });
            $("form :input").change(function() {
                $(".save-form").prop("disabled",false);
            });

            if($('#possession_date').val()!='' && $('#termination_date').val()!='' && $('#rent_amount').val()!=''){
                savetemp();
            }

            flag=true;
        } else {
            document.getElementById('myModal').style.display = "block";
        }
    }
</script>
<script>
 $("#sidebar_cntrl").on("click",function(){
        
         if($('body').hasClass("menu-pin"))
         {
            $( "#form_rent fieldset" ).css({'width':'85%','margin':'0 8%'});
         }
		 else
		 {  
			$( "#form_rent fieldset" ).css({'width':'100%','margin':'0 auto'});
		 }
 });

 var set_advrent = function() {
    if($('#advance_rent').is(":checked")){
        $('#advance_rent_amount').attr('disabled', false);
        // alert("g");
        $('#advance_rent_amount').focus();
    } else {
        $('#advance_rent_amount').val('');
        $('#advance_rent_amount').attr('disabled', true);
    }
}

</script>




<!--script type="text/javascript" src="js/load_autocomplete.js"></script-->
<script type="text/javascript" src="<?php echo base_url()?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/rent.js"></script>

</body>
</html>