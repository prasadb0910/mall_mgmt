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
            background: url("<?php echo base_url();?>assets/img/demo/preview.jpg") ;
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
    </style>
</head>
<body class="fixed-header ">
<?php  $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_rent_3rdparty" role="form" method ="post" action="<?=base_url().'index.php/Rent_3rd_party/saverecord'?>"  enctype="multipart/form-data">

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
                                        <input type="text" class="form-control format_number" name="locking_period" id="locking_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->locking_period; }} ?>" />
                                    </div>
                                </div>
								
                                <div class="col-md-3">
                                    <div class="form-group form-group-default ">
                                        <label>Lease Period In Months</label>
                                        <input type="text" class="form-control format_number" name="lease_period" id="lease_period" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>0) { echo $rent[0]->lease_period; }} ?>" />
                                    </div>
                                </div>
                            
                            </div>
					
							
                        </div>
                    
                        <div class="a  recurring" id="recurring">
                           <p class="m-t-20"> 
						 <div class="div_heading ">
                          <h5>Recurring & Transactions</h5>
                         </div>
						 </p>
                            <div class="row clearfix">
							
							
							  <div class="col-md-3">
                                        <div class="form-group form-group-default ">
                                            <label>Amount </label>
                                            <input type="text" class="form-control format_number rent_amount" name="rent_amount" id="rent_amount" onchange="instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($rent)) { if(count($rent)>=0) { echo format_money($rent[0]->rent_amount,2); }} ?>" />
                                        </div>
                               </div>
                
                           </div>
                           </div>
						   
					  
					             <div class="a m-b-20 tenant" id="tenant">
					     <p class="m-t-20"> 	 <div class="div_heading ">
                          <h5>Tenant </h5></div></p>
             
                         
                            <div class="row clearfix">
                            
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                     <label class="">Tenant</label>
                                      <select class="form-control full-width" name="tenant[]" id="client" data-error="#err_client" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                        <option value="">Select</option>
                                         <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$tenants[0]->contact_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div id="err_client"></div>
                                    </div>
                                </div>
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





   
  


<?php $this->load->view('templates/script');?>
<!--script type="text/javascript" src="js/load_autocomplete.js"></script-->
<script type="text/javascript" src="<?php echo base_url();?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/rent.js"></script>


</body>
</html>