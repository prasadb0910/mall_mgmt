<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .a {
            border-bottom: 2px solid #edf0f5;
         
            padding-bottom: 25px;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("assets/img/demo/preview.jpg") ;
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
            padding: 5px 20px;
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
            z-index:9999!important;
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
    <form id="form_real_estate_property" role="form" method ="post" action="<?php if(isset($p_txn)) { echo base_url().'index.php/real_estate_property/updaterecord/'.$p_id; } else { echo base_url().'index.php/real_estate_property/saverecord'; } ?>"  enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index/Dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('index.php/Real_estate_property')?>">Real Estate</a></li>
            <li class="breadcrumb-item"><a href="<?=base_url('index.php/Real_estate_property')?>">Property List</a></li>
                 <?php if(isset($p_txn)){ ?><li class="breadcrumb-item"><a href="<?=base_url('index.php/Real_estate_property/view/'.$p_txn[0]->property_txn_id)?>">Property View</a></li>
				  <?php } ?>
            <li class="breadcrumb-item active">Property Details </li>
            <input type="hidden" id="p_id" name="p_id" value="<?php if(isset($p_txn)) echo $p_id; ?>" />
            <input type="hidden" name="type_id" value="1">
        </ol>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-12">
                    <div class="card card-default" style="background:#e6ebf1">
                        <div class="card-header " style="background:#f6f9fc">
                            <div class="card-title">
                                Drag n' drop uploader
                            </div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span>
                        </div>
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($p_txn[0]->p_image)) echo base_url().$p_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        <div id="image-label_field">
                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class=" container-fluid container-fixed-lg bg-white">
                    <div class="card card-transparent">
                        <div class="a" id="ownership-section">
                            <p class="m-t-20"><b>Ownership<b></p>
                            <div id="repeatowner">

                                <?php $j=0; if(isset($p_ownership)) { 
                                    for ($j=0; $j < count($p_ownership) ; $j++) { ?>

                                <div id="repeat_owner_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Select Owner</label>
                                            <select id="owner_name_<?php echo $j+1; ?>" name="clientname[]" class="form-control ownership full-width" data-error="#err_owner_name_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                    <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$p_ownership[$j]->pr_client_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_owner_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_owner_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_owner_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Select Owner</label>
                                            <select id="owner_name_<?php echo $j+1; ?>" name="clientname[]" class="form-control ownership full-width" data-error="#err_owner_name_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($owner) ; $k++) { ?>
                                                    <option value="<?php echo $owner[$k]->c_id; ?>"><?php echo $owner[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_owner_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_owner_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="optionBox">
                                <div class="block" id="block">
                                    <span class="add" id="repeat-owner">+ Add Ownership</span>
                                </div>
                            </div>
                        </div>

                     <p class="m-t-20"><b>General Information</b></p>
                        <div class="a m-b-20 allocated_maintenance" id="general_info">
                         
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Unit Name</label>
                                        <input type="text" class="form-control" id="unit" name="unit"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->unit_name; } ?>" />                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Type </label>
                                        <select class="form-control full-width" name="unit_type" id="unit_type" data-error="#error_unit_type" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                            <option value="">Select</option>
                                            <option value="Shop" <?=(isset($p_txn[0]->unit_type) && $p_txn[0]->unit_type=='Shop'?'selected':'')?>>Shop</option>
                                            <option value="Basement"  <?=(isset($p_txn[0]->unit_type) && $p_txn[0]->unit_type=='Basement'?'selected':'')?>>Basement</option>   
                                        </select>
                                        <div id="error_unit_type"></div>
                                    </div>
                                </div>
                            </div>
							
							
							<div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Unit No.</label>
                                        <input type="text" class="form-control" id="unit_no" name="unit_no"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->unit_no; } ?>" />
                                    </div>
                                </div>
                            
							
							
							    <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Floor</label>
                                        <input type="text" class="form-control" id="floor" name="floor"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->floor; } ?>" />
                                    </div>
                                </div>
                            
							
                            </div>
							
							
							
							
                            <div class="row clearfix">
							    <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Area</label>
                                        <input type="text" class="form-control" id="area" name="area"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->area; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Area Unit </label>
                                        <select class="form-control full-width" id="area_unit" name="area_unit" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity"  data-error="#error_area_unit" >
                                            <option value="">Select</option>
                                            <option value="Sqft" <?=(isset($p_txn[0]->area_unit) && $p_txn[0]->area_unit=='Sqft'?'selected':'')?>>Sqft</option>
                                            <option value="Sqm" <?=(isset($p_txn[0]->area_unit) && $p_txn[0]->area_unit=='Sqm'?'selected':'')?>>Sqm</option>
                                           
                                        </select>
                                        <div id="error_area_unit"></div>
                                    </div>
                                </div>
                            
                            </div>
                          
                             <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Allocated Cost(&#x20B9;)</label>
                                        <input type="text" class="form-control" id="allocated_cost" name="allocated_cost"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->allocated_cost; } ?>" />
                                    </div>
                                </div>
                            
							
							
							    <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Allocated Maintenance(&#x20B9;)</label>
                                        <input type="text" class="form-control" id="allocated_maintenance" name="allocated_maintenance"  placeholder="Enter Here" value="<?php if(isset($p_txn)) { echo $p_txn[0]->allocated_maintenance; } ?>" />
                                    </div>
                                </div>
                            
							
                            </div>
							
                        </div>
                      
                    <div class="form-footer" style="padding-bottom: 60px;">
                        <input type="hidden" id="submitVal" value="1" />
                        <a href="<?php echo base_url(); ?>index.php/real_estate_property" class="btn btn-default-danger pull-left" >Cancel</a>
                                                  <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                            <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

</div>
</div>


<?php $this->load->view('templates/script');?>

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $owner_details = '<option value="">Select</option>';
        if(isset($owner)) 
		{
            for($i=0; $i<count($owner); $i++) 
			{
                $owner_details = $owner_details . '<option value="'.$owner[$i]->c_id.'">'.$owner[$i]->contact_name.'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $owner_details; ?>';

    
</script>
<!--script type="text/javascript" src="js/load_autocomplete.js"></script-->
<script type="text/javascript" src="<?=base_url()?>js/validations.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/document.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/purchase.js"></script>



</body>
</html>