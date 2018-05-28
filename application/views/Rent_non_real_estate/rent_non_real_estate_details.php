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
            content: "on off";
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
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("<?php echo base_url()?>assets/img/demo/preview.jpg") ;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
        #image-label {
            color:white;
            padding-left:6px;
        }
        #image-label_field{
            background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
        }
        #image-label_field:hover{
            background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add{
            color:#41a541;
            cursor:pointer;
            font-size:14px;
            font-weight:500;
        }
        .remove{
            color:#d63b3b;
            text-align:right;
            cursor:pointer;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1{
            padding: 20px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .delete{
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:pointer;
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
            height: 43px;
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
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
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
        .select2-container {
            /* z-index:9999!important;*/
        }
        /*.modal.fade {
            z-index:9999!important;
        }*/
		#ownership-section .select2-container,#general_info .select2-container,#address_info .select2-container,#property_desc .select2-container,#documents .select2-container
		{
			   z-index:0!important;
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
	.recurring .select2-container {
            height: 26px!important;
		}
        .recurring .select2-container .select2-selection.select2-selection--single {
            height: 26px!important;
        	padding-top: 0px!important;
        }
    </style>
</head>
<body class="fixed-header ">
<?php  $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_rent_non_real_estate" role="form" method ="post" action="<?=base_url().'index.php/Rent_real_estate/saverecord'?>"  enctype="multipart/form-data">
    <input type="hidden" name="rent_module_type" value="2">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index/Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index/Purchase/checkstatus/All">Tenant List</a></li>
                 <?php if(isset($p_txn)){ ?><li class="breadcrumb-item"><a href="">Tenant View</a></li>
				  <?php } ?>
            <li class="breadcrumb-item active">Tenant Details </li>
            <input type="hidden" id="p_id" name="p_id" value="<?php if(isset($p_txn)) echo $p_id; ?>" />
        </ol>
        <div class="row">
           <!-- <div class="col-md-4">
                <div class="col-lg-12">
                    <div class="card card-default" style="background:#e6ebf1">
                        <div class="card-header " style="background:#f6f9fc">
                            <div class="card-title">
                                Drag n' drop uploader
                            </div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span>
                        </div>
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        <div id="image-label_field">
                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
                        </div>
                    </div>
                </div>
            </div>-->
			<div class="col-md-1"></div>
            <div class="col-md-10">
                <div class=" container-fluid container-fixed-lg bg-white">
                    <div class="card card-transparent">
                      
    <div class="a allocated_maintenance" id="general_info">
       <p class="m-t-20">	 <div class="div_heading ">
                          <h5>Property Information & Terms</h5></div></p>
                                   
                                    <p class="panel-description">Select the property, unit for the lease. Add the start and/or end date of the lease, Lockin Period and Notice Period for the lease. </p>
    					
                    
                         
                            <div class="row clearfix">
                                 <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Unit Name</label>
                                        <select class="full-width" name="unit" id="unit" data-error="#err_unit" data-placeholder="Select" data-init-plugin="select2" onchange="get_property_details();" data-minimum-results-for-search="Infinity">
                                            <option value="">Select</option>
                                            <?php if(isset($editrent)) { 
                                                for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->property_txn_id; ?>" <?php if($editrent[0]->property_id == $property[$i]->property_txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->unit_name; ?></option>
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
							      
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Start Date</label>
                                        <input type="text" class="form-control datepicker" name="possession_date" id="possession_date" onchange="calculatedate(); instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->possession_date!=null && $editrent[0]->possession_date!='') echo date('d/m/Y',strtotime($editrent[0]->possession_date)); }} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>End Date</label>
                                        <input type="text" class="form-control datepicker" name="termination_date" id="termination_date" onchange="calculatedate(); instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>0) { if($editrent[0]->termination_date!=null && $editrent[0]->termination_date!='') echo date('d/m/Y',strtotime($editrent[0]->termination_date)); }} ?>"/>
                                    </div>
                                </div>
								
								  <div class="col-md-4">
                                    <div class="form-group form-group-default ">
                                        <label>Period In Months</label>
                                        <input type="text" class="form-control format_number" name="locking_period" id="locking_period" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>0) { echo $editrent[0]->period; }} ?>" />
                                      
                                    </div>
                                </div>
                            
                            </div>
					
							
                        </div>
                      
					  
					  
					     <p class="m-t-20">	 <div class="div_heading ">
                          <h5>Client <div class="div_heading ">
                          </h5><div></p>
                        <div class="a m-b-20 client" id="client">
                         
                            <div class="row clearfix">
                            
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Client</label>
                                        <select class="form-control full-width" name="client" id="client" data-error="#err_client" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                            <option value="">Select</option>
                                             <option value="">Select</option>
                                                 <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                        </select>
                                        <div id="err_client"></div>
                                    </div>
                                </div>
                            </div>
                            </div>
					  
                       
					     <p class="m-t-20"> 
						 <div class="div_heading ">
                          <h5>Recurring & Transactions</h5>
                         </div>
						 </p>
                        <div class="a m-b-20 recurring" id="recurring">
                         
                            <div class="row clearfix">
							
							
							  <div class="col-md-3">
                                        <div class="form-group form-group-default ">
                                            <label>amount</label>
                                            <input type="text" class="form-control format_number rent_amount" name="rent_amount" id="rent_amount" onchange="instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>=0) { echo format_money($editrent[0]->rent_amount,2); }} ?>" />
                                        </div>
                                    </div>
                            <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 input-group gst">
                                            <div class="form-input-group">
                                                <label class="inline" style="float:left!important;">GST Rate</label>
                                                            <select class="full-width select2" id="gst_rate" data-placeholder="Select" data-init-plugin="select2" <?php if(isset($other_amt_details)) { if($other_amt_details[$j]->gst==1) echo ''; else echo 'disabled'; } else echo 'disabled'; ?> onChange="set_gst_rate_val(this);"  data-error="#err_gst_rate">
                                                            <option value="">Select</option>
                                                            <?php 
                                                                if(isset($tax)){
                                                                    foreach($tax as $row){
                                                                        echo '<option value="'.$row->tax_id.'" >'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                    }
                                                                };?>
                                                            </select>
                                                             <div id="err_gst_rate"></div> 
												 <div id="err_gst_rate"></div>
                                            </div>
                                            <div class="input-group-addon bg-transparent h-c-50">
                                                <input type="checkbox" class ="toggle" name="gst" id="gst" value="yes" onchange="set_gst();"<?php if(isset($editrent)) { if($editrent[0]->gst==1) echo 'checked'; } ?> />
                                            </div>
                                        </div>
                                    </div>
									    <div class="col-md-3" >
                                        <div class="form-group form-group-default input-group">
                                             <div class="form-input-group" style="width:90px;">
                                                <label style="float:left!important;padding-left:3px!important;">TDS Rate In %</label>
                                                <input type="text" class="form-control format_number" name="tds_rate[]" id="tds_rate" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>=0) { echo format_money($editrent[0]->tds_rate,2); }} ?>" <?php if(isset($editrent)) { if($editrent[0]->tds==1) echo '';   } else { echo "disabled" ;} ?>    style="width: 90px;padding-left:3px!important" /></label>
                                            </div>
                                            <div class="input-group-addon bg-transparent h-c-50">
                                                <input type="checkbox" name="tds" id="tds" value="yes" onchange="set_tds();" class="toggle"  <?php if(isset($editrent)) { if($editrent[0]->tds==1) echo 'checked'; } ?> />
                                            </div>
                                        </div>
                                        </div>
                                    </div>
									<!-- 
                                    <div class="col-md-2">
                                         <div class="form-group form-group-default required">
                                        <label>Tds Rate % </label>
                                        <input type="text" class="form-control" id="tds_rate" name="tds_rate"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->tds_rate; } ?>" />
                                    </div> -->
                                    </div>
                                
                                    
                                </div>
                           </div>
						   
						   
						    <div class="a">
                    
                              <p class="m-t-20"> 
                                    <div class="div_heading ">
                                        <h5>Deposits</h5>
                                
                                    <p class="panel-description">Record deposits and amount that is received by tenant in this section.</p>
        						</div></p>
						
                            <div class="row clearfix">
							
							
							  <div class="col-md-6" style="">
                                    <div class="form-group form-group-default required">
                                        <label class="">Category </label>
                                        <input type="text" class="form-control" name="deposit_category" id="deposit_category" placeholder="Enter Here" value="<?php if(isset($editrent)) echo $editrent[0]->deposit_category; else echo 'Deposit'; ?>" readonly />
                                    </div>
                                </div>
							
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Amount In &#x20B9;</label>
                                        <input type="text" class="form-control format_number" name="deposit_amount" id="deposit_amount" placeholder="Enter Here" value="<?php if(isset($editrent)) { if(count($editrent)>0) { echo format_money($editrent[0]->deposit_amount,2); }} ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6" style="<?php if(isset($deposit_paid_details)) { if(count($deposit_paid_details)>0) { echo ''; } else echo 'display: none;'; } else echo 'display: none;'; ?>">
                                    <div class="form-group form-group-default required">
                                        <label>Paid Amount In &#x20B9;</label>
                                        <input type="text" class="form-control format_number" name="deposit_paid_amount" id="deposit_paid_amount" placeholder="Enter Here" value="<?php if(isset($deposit_paid_details)) { if(count($deposit_paid_details)>0) { echo format_money($deposit_paid_details[0]->paid_amount,2); }} ?>" readonly />
                                    </div>
                                </div>
                              
                            </div>
                        </div>
						
						
						 <div class="a m-b-20" >
                           
					  <p class="m-t-20"> 
                            <div class="div_heading ">
                            <h5>Document Details</h5>		
                           <p class="panel-description">By default requirements of rent documents are displayed. Just need to add details. Also can add aditional documents if required by using plus button	.</p></p>
						
							</div>
                            <?php $this->load->view('templates/document');?>
                            <div class="optionBox" id="optionBox1">
                                <div class="block" id="block2">
                                    <span class="add" id="repeat-documents">+ Add doc Details.</span>
                                </div>
                            </div>
                        </div>

                    <div class="form-footer" style="padding-bottom: 60px;">
                        <input type="hidden" id="submitVal" value="1" />
                        <a href="index/Purchase" class="btn btn-default-danger pull-left" >Cancel</a>
                        <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="Submit" style="margin-right: 10px;" />
                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php// if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                    </div>
                </div>
            </div>
        </div>
			<div class="col-md-1"></div>
		
    </div>
    </form>
</div>

</div>
</div>


   
  


<?php $this->load->view('templates/script');?>
<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";
</script>
<!--script type="text/javascript" src="js/load_autocomplete.js"></script-->
<script type="text/javascript" src="<?php echo base_url()?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/rent.js"></script>


</body>
</html>