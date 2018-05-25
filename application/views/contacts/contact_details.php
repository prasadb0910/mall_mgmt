<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .a {
            border-bottom: 2px solid #edf0f5;
            margin-bottom: 25px;
            padding-bottom: 25px;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
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
			margin-left:10px!important;
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
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
        }
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_contact" role="form" method ="post" action="<?php if(isset($editcontact)) { echo base_url().'index.php/contacts/updaterecord/'.$c_id; } else { echo base_url().'index.php/contacts/saverecord'; } ?>" enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Contacts/checkstatus/All/<?php if (isset($contact_type)) echo $contact_type; else if (isset($editcontact[0]->c_type)) echo $editcontact[0]->c_type; ?>">Contact List</a></li>
			
			  <?php if(isset($editcontact)){ ?>        
			  <li class="breadcrumb-item"><a href="<?php if (isset($c_id)) echo base_url().'index.php/Contacts/viewrecord/'.$c_id; ?>">Contact View</a></li>
				  <?php } ?>

            <li class="breadcrumb-item active">Contact Details</li>
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
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($editcontact)) echo base_url().$editcontact[0]->c_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                            <!-- <img src="<?php //echo base_url().$editcontact[0]->c_image; ?>"> -->
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
                        <p class="m-t-20"><b>Personal Details</b></p>
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if (isset($c_id)) { echo $c_id; } ?>">
                                    <input type="hidden" class="form-control" name="owner_type" id="owner_type" value="<?php if (isset($owner_type)) echo $owner_type; else if (isset($editcontact[0]->c_owner_type)) echo $editcontact[0]->c_owner_type; ?>">
                                    <div class="form-group form-group-default required">
                                        <label>First Name</label>
                                        <input type="text" class="form-control " name="c_name" id="c_name" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_name; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control " name="c_middle_name" id="c_middle_name" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_middle_name; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control " name="c_last_name" id="c_last_name" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_last_name; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
							     <div class="col-md-4" style="<?php if (isset($contact_type)) { if($contact_type!='All') echo 'display: none;'; }else if (isset($editcontact[0]->c_type)) { if($editcontact[0]->c_type!='All') echo 'display: none;'; } ?>">
                                    <div class="form-group form-group-default form-group-default-select2 required"  aria-required="true">
                                        <label class="">Contact Type</label>
                                        <select class="full-width" name="type" id="type" onChange="get_invoice_format();"  data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity" data-error="#err_type" >
                                            <option value="">Select</option>
                                            <option value="Owners" <?php if (isset($contact_type)) { if($contact_type=='Owners') echo 'selected'; } else if (isset($editcontact[0]->c_type)) { if($editcontact[0]->c_type=='Owners') echo 'selected'; } ?>>Owner</option>
                                            <option value="Tenants" <?php if (isset($contact_type)) { if($contact_type=='Tenants') echo 'selected'; } else if (isset($editcontact[0]->c_type)) { if($editcontact[0]->c_type=='Tenants') echo 'selected'; } ?>>Tenant</option>
                                            <option value="Others" <?php if (isset($contact_type)) { if($contact_type=='Others') echo 'selected'; } else if (isset($editcontact[0]->c_type)) { if($editcontact[0]->c_type=='Others') echo 'selected'; } ?>>Other</option>
                                        </select>
                                        <div id="err_type"></div>
                                    </div>
                                </div>
							
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Date Of Birth</label>
                                        <input type="text" class="form-control date1" id="dob"  data-date-end-date="0d" name="date_of_birth" placeholder="Enter Here" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_dob!='' && $editcontact[0]->c_dob!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_dob)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Anniversary Date</label>
                                        <input type="text" class="form-control date1" id="date_of_anniversary" data-date-end-date="0d" name="date_of_anniversary" placeholder="Enter Here" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_anniversarydate!='' && $editcontact[0]->c_anniversarydate!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_anniversarydate)); } ?>">
                                    </div>
                                </div>
                            
                            </div>
                            <!-- <div class="guardian" style="<?php //if(isset($editcontact[0]->c_guardian)) {if($editcontact[0]->c_guardian=='') echo 'display:none;';} ?>">
                                <div class="row clearfix">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label>Guardian</label>
                                            <select id="guardian" name="guardian" class="form-control full-width" data-error="#err_guardian" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php //for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php //echo $contact[$k]->c_id; ?>" <?php //if (isset($editcontact)) {if($contact[$k]->c_id==$editcontact[0]->c_guardian) { echo 'selected'; }} ?>><?php //echo $contact[$k]->contact_name; ?></option>
                                                <?php //} ?>
                                            </select>
                                            <div id="err_guardian"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required">
                                            <label>Relation</label>
                                            <input type="text" class="form-control " id="guardian_relation" name="Enter Here" placeholder="Enter Here" value="<?php //if (isset($editcontact)) { echo $editcontact[0]->c_relation; } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row clearfix">
							
							    <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Gender</label>
                                        <select class="full-width" name="gender" id="gender" data-error="#err_gender" data-placeholder="Select " data-init-plugin="select2" data-minimum-results-for-search="Infinity">
                                            <option value="">Select</option>
                                            <option value="Male" <?php if (isset($editcontact)) { if($editcontact[0]->c_gender=='Male') echo 'selected'; } ?>>Male</option>
                                            <option value="Female" <?php if (isset($editcontact)) { if($editcontact[0]->c_gender=='Female') echo 'selected'; } ?>>Female</option>
                                        </select>
                                        <div id="err_gender"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Designation</label>
                                        <input type="text" class="form-control " name="designation" id="designation" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_designation; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Address</label>
                                        <input type="text" class="form-control " name="address" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?>">
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row clearfix">
                                <!-- <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>City </label>
                                        <input type="text" class="form-control " name="city" id ="con_add_city" placeholder="Enter Here" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_city; } ?>">
                                    </div>
                                </div> -->
								 <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Landmark </label>
                                        <input type="text" class="form-control " name="landmark" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_landmark; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">City</label>
                                        <select class="full-width" name="city" id="con_add_city" class="form-control nm_name full-width" data-placeholder="Select" data-init-plugin="select2" data-error="#err_city">
                                            <option value="">Select</option>
                                            <?php
                                                $opt = '';
                                                foreach($city as $cities)
                                                {   
                                                  $opt.="<option value='".$cities['city_name']."' data-id='".$cities['id']."'".($editcontact[0]->c_city==$cities['city_name']?'selected':'').">".$cities['city_name']."</option>";
                                                }
                                                echo $opt;
                                            ?>
                                           
                                        </select>
                                        <div id="err_city"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Pincode </label>
                                        <input type="text" class="form-control " name="pincode" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_pincode; } ?>">
                                    </div>
                                </div>
                              
                            </div>
                            <div class="row clearfix">
							  <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>State</label>
                                        <input type="text" class="form-control " readonly name="state" id="con_add_state" placeholder="Enter Here" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_state; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Country </label>
                                        <input type="text" class="form-control " name="country" id="con_add_country" placeholder="Enter Here" value="<?php if(isset($editcontact)) { echo  $editcontact[0]->c_country; } ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Email ID - 1 </label>
                                        <input type="text" class="form-control " id="email_id1" name="email_id1" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>">
                                    </div>
                                </div>
                             
                            </div>
                            <div class="row clearfix">
							
							   <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Email ID - 2</label>
                                        <input type="text" class="form-control " id="email_id2" name="email_id2" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid2; } ?>" >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default required">
                                        <label>Mobile No - 1 </label>
                                        <input type="text" class="form-control " id="mobile_no1" name="mobile_no1" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-default">
                                        <label>Mobile No - 2 </label>
                                        <input type="text" class="form-control " id="mobile_no2" name="mobile_no2" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?>">
                                    </div>
                                </div>
                             
                                
                                </div>
							 <div class="row clearfix">
                              <div class="col-md-4 ">
                                    <div class="form-group form-group-default">
                                        <label>GST No</label>
                                        <input type="text" class="form-control " id="gst_no" name="gst_no" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_gst_no; } ?>">
                                    </div>
                                </div>
                                 
                                <div class="col-md-4 inv_format">
                                    <div class="form-group form-group-default">
                                        <label>Invoice Format</label>
                                        <input type="text" class="form-control " id="invoice_format" name="invoice_format" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_invoice_format; } ?>" >
                                    </div>
                                </div>
                                <div class="col-md-4 inv_format">
                                    <div class="form-group form-group-default">
                                        <label>Invoice No</label>
                                        <input type="text" class="form-control " id="invoice_no" name="invoice_no" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_invoice_no; } ?>">
                                    </div>
                                </div>
                               
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row required">
                                    <label class="col-md-12 control-label">KYC Required?</label>
                                    <div class="col-md-12">
                                        <div class="radio radio-success">
                                            <input type="radio" name="kyc" value="1" id="kyc_yes" data-error="#err_kyc" <?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='1') echo 'checked'; } ?>/>
                                            <label for="kyc_yes">Yes</label>
                                            <input type="radio" name="kyc" value="0" id="kyc_no" data-error="#err_kyc" <?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='0') echo 'checked'; else if($editcontact[0]->c_kyc_required!='1') echo 'checked'; } else echo 'checked'; ?>/>
                                            <label for="kyc_no">No</label>
                                        </div>
                                        <div id="err_kyc"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="a" id="kyc-section" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_kyc_required!='1') echo 'display:none;'; } else echo 'display:none;'; ?>">
                            <p class=""><b>KYC Details</b></p>
                            <?php $this->load->view('templates/document');?>
                            <div class="optionBox" id="optionBox1">
                                <div class="block" id="block2">
                                    <span class="add" id="repeat-documents">+ Add KYC Details</span>
                                </div>
                            </div>
                        </div>

                        <div class="a" id="nominee-section">
                            <p class=""><b>Nominee Details</b></p>
                            <div id="nominee_details">

                                <?php $j=0;
                                if(isset($editcontnom)) {
                                for($j=0; $j<count($editcontnom); $j++) { ?>

                                <div id="repeat_nominee_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Contact</label>
                                            <select id="nm_name_<?php echo $j+1; ?>" name="nm_name[]" class="form-control nm_name full-width" data-placeholder="Select" data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$editcontnom[$j]->c_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Relation</label>
                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Enter Here" value="<?php if(isset($editcontnom[$j]->relation)){ echo $editcontnom[$j]->relation; } else { echo ''; }?>"/>
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_nominee_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_nominee_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label>Contact</label>
                                            <select id="nm_name_<?php echo $j+1; ?>" name="nm_name[]" class="form-control nm_name full-width" data-placeholder="Select" data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label>Relation</label>
                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Enter Here" value="" />
                                        </div>
                                    </div>
                                    <!-- <div class="delete delete_row" id="repeat_nominee_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="optionBox">
                                <div class="block" id="block">
                                    <span class="add" id="repeat-nominee">+ Add Nominee Details</span>
                                </div>
                            </div>
                        </div>

                        <!-- <p><b>Remark</b></p>
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Remark</label>
                                        <input type="text" class="form-control " name="maker_remark" placeholder="Remark" value="<?php //if (isset($editcontact)) { echo $editcontact[0]->c_maker_remark; } ?>">
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-footer" style="padding-bottom: 60px;">
                            <input type="hidden" id="submitVal" value="1" />
                            <a href="<?php echo base_url(); ?>index.php/contacts" class="btn btn-default-danger pull-left" >Cancel</a>
                            <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                            <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
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

<script type="text/javascript">
    var BASE_URL="<?php echo base_url()?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';
</script>



<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/contact.js"></script>

</body>
</html>