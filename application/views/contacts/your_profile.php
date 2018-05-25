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
    </style>
</head>


   <body class="fixed-header ">
<?php $this->load->view('templates/sidebar1');?>
<div class="page-container ">
	<?php $this->load->view('templates/main_header');?>
                         <div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">
      <form id="form_profile" role="form"  method ="post" action="<?php if(isset($editcontact)) { echo base_url().'index.php/profile/updateRecord/'.$c_id; } else { echo base_url().'index.php/profile/saveRecord'; } ?>" enctype="multipart/form-data" autocomplete="off">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >Dashboard</a></li>

<li class="breadcrumb-item active"><a href="#">User Profile</a></li>

</ol> 
                      
                             

                                <!--  <div class="panel-heading">
                                    <h3 class="panel-title" style="text-align:center;float:initial;"><strong>Contact Master</strong></h3>
                                </div> -->
                                                
                                <div id="form_errors" style="display:none; color:#E04B4A;" class="error"></div>

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
                            <input type="file" name="c_image_file" id="image-upload" />
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
                                             
                                          
                                             <div class="row">
                                                <div class="col-md-6">
											  <div class="form-group form-group-default">
                                                    <label>Date Of Birth </label>
                                                  
                                                        <input type="text" class="form-control datepicker" id="c_dob" name="c_dob" placeholder="Enter Here" value="<?php if (isset($editcontact)) { if($editcontact[0]->c_dob!='' && $editcontact[0]->c_dob!=null) echo date('d/m/Y',strtotime($editcontact[0]->c_dob)); } ?>"/>
                                                    </div>
                                                </div>
                                             
                                               <!-- <div class="col-md-6" >
                                                    <label class="col-md-4 control-label">Upload Image </label>
                                                    <div class="col-md-6">
                                                        <div class="col-md-9" >
                                                            <input type="hidden" class="form-control" name="c_image" value="<?php echo $editcontact[0]->c_image; ?>" />
                                                            <input type="hidden" class="form-control" name="c_image_name" value="<?php echo $editcontact[0]->c_image_name; ?>" />
                                                            <input type="file" class="fileinput btn btn-success doc_file padding-height" name="c_image_file" id="c_image_file" data-error="#c_image_file_error"/>
                                                            <div id="c_image_file_error"></div>
                                                        </div>
                                                        <div class="col-md-3 download-btn" >
                                                            <?php if($editcontact[0]->c_image!= '') { ?><a target="_blank" title="Download" id="doc_file_download" href="<?php echo base_url().$editcontact[0]->c_image; ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                      
                                                <div class="col-md-6">
														  <div class="form-group form-group-default required">
                                                    <label class="col-md-4 control-label">Mobile No </label>
                                                    
                                                        <input type="text" class="form-control" id="mobile_no1" name="mobile_no1" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile1; } ?>"/>
                                                  
                                                </div>
                                                </div>
                                                </div>
										 <div class="row">
                                                <div class="col-md-6">
												 <div class="form-group form-group-default">
                                                    <label class="col-md-4 control-label">Landline </label>
                                                  
                                                      <input type="text" class="form-control" id="mobile_no2" name="mobile_no2" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile2; } ?>"/>
                                                  
                                                </div>
												</div>
                                          
                                                <div class="col-md-6">
												<div class="form-group form-group-default required">
                                                    <label>Email ID</label>
                                                  
                                                       <input type="text" class="form-control" id="email_id1" name="email_id1" style="background-color: white; color: #245478;" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_emailid1; } ?>" readonly />
                                                 
                                                </div>
                                                </div>
                                                </div>
									<div class="row clearfix">
                                                <div class="col-md-6">
														  <div class="form-group form-group-default">
                                                    <label>Office </label>
                                                  
                                                       <input type="text" class="form-control" id="c_company" name="c_company" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_company; } ?>"/>
                                                    
                                                </div>
                                            </div>
                                           
                                 
                              
                                                <div class="col-md-6">
											 <div class="form-group form-group-default">
                                                    <label>PAN No. </label>
                                                  
                                                       <input type="text" class="form-control" id="c_pan_card" name="c_pan_card" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_pan_card; } ?>"/>
                                                  
                                                </div>
                                                </div>
                                                </div>
										<div class="row clearfix">
                                                <div class="col-md-6">
											<div class="form-group form-group-default">
                                                    <label>Aadhar </label>
                                                  
                                                       <input type="text" class="form-control" id="c_aadhar_card" name="c_aadhar_card" placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_aadhar_card; } ?>"/>
                                                  
                                                </div>
                                            </div>
                                     
                                          
                                                <div class="col-md-6">
												  <div class="form-group form-group-default">
                                                    <label>GST No. </label>
                                                    
                                                       <input type="text" class="form-control" id="c_gst_no" name="c_gst_no"placeholder="Enter Here" value="<?php if (isset($editcontact)) { echo $editcontact[0]->c_gst_no; } ?>"/>
                                                    </div>
                                                </div>
											</div>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
													<div class="form-group form-group-default">
                                                        <label>Group Name </label>
                                                        <input type="hidden" id="group_id" name="group_id" value="<?php if(isset($group_details)){ echo $group_details[0]->g_id; } ?>" />
                                                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter Here" value="<?php if(isset($group_name)){ echo $group_name; } ?>" />
                                                    </div>
                                                </div>
												<!-- <div class="col-md-6">
													<div class="form-group">
    												    <div class="form-group form-group-default">
															<label>Do You want maker checker? *</label>
                                                            <input type="radio" class="" name="maker_checker" value="yes" required <?php //if(isset($group_details)){ if($group_details[0]->maker_checker=='yes') echo 'checked'; } ?> /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input type="radio" class="" name="maker_checker" value="no" required <?php //if(isset($group_details)){ if($group_details[0]->maker_checker=='no') echo 'checked'; } ?> /> No
                                                        </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                          		    <div class="form-group form-group-default">
                                                <div class="col-md-12">
                                                    <label>Address </label>
                                                  
                                                        <textarea class="form-control" id="c_address" name="c_address"><?php if (isset($editcontact)) { echo $editcontact[0]->c_address; } ?></textarea>
                                                    </div>
                                                </div>
                                                </div>
                                           
                                            <!-- <div class="form-group">
                                                <div class="col-md-6">
                                                    <label class="col-md-4 control-label">KYC Required? <span class="asterisk_sign others-validation">*</span></label>
                                                    <div class="col-md-6" style="line-height:33px;">
                                                        <input type="radio" name="kyc" class="icheckbox" value="1" id="kyc_yes" data-error="#err_kyc" <?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='1') echo 'checked'; } ?>/>&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="kyc" class="icheckbox" value="0" id="kyc_no" data-error="#err_kyc" <?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required=='0') echo 'checked'; } ?>/>&nbsp;&nbsp;No
                                                        <div id="err_kyc"></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                
                                    <!-- <div class="panel panel-primary" id="kyc-section" style="<?php //if (isset($editcontact)) { if($editcontact[0]->c_kyc_required!='1') echo 'display:none;'; } else echo 'display:none;'; ?>">
                                        <a href="#accOneColTwo">  
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                <span class="fa fa-check-square-o"> </span>     KYC Details 
                                                </h4>
                                            </div>  
                                        </a>                              
                                        <div class="panel-body" id="accOneColTwo">
                                            <?php //$this->load->view('templates/document');?>
                                            

                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success" id="repeat-documents"  >+</button>
                                                <a href="#accOneColThree" >
                                                    <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
                                                </a>
                                            </div>
                                        </div>                                
                                    </div> -->
                                    
                                    <!-- <div class="panel panel-primary" id="nominee-section" style="display:block;">
                                        <a href="#accOneColThree"> 
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><span class="fa fa-check-square-o"> </span> Nominee Details </h4>
                                            </div>
                                        </a>                                 
                                        <div class="panel-body" id="accOneColThree">
                                            <div class="table-responsive">
                                            <table id="contacts" class="table group nominee table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="55" align="center">Sr. No.</th>
                                                        <th>Name </th>
                                                        <th>Relation </th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php 
                                                    // $j=0;
                                                    // if(isset($editcontnom)) {
                                                    // for($j=0;$j<count($editcontnom); $j++) { ?>
                                                    <tr id="repeat_nominee_<?php //echo $j+1; ?>">
                                                        <td  align="center"><?php //echo ($j+1); ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php //echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" value="<?php //if (set_value('nm_name')!=null) { echo set_value('nm_name'); } else if(isset($editcontnom[$j]->nm_name)){ echo $editcontnom[$j]->nm_name; } else { echo ''; }?>" />
                                                            <input type="text" id="txtname_<?php //echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" value="<?php //if(isset($editcontnom[$j]->c_name)){ echo $editcontnom[$j]->c_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation" value="<?php //if(isset($editcontnom[$j]->nm_relation)){ echo $editcontnom[$j]->nm_relation; } else { echo ''; }?>"/>
                                                        </td>
                                                    </tr>
                                                    <?php //} } else { ?>
                                                    <tr id="repeat_nominee_<?php //echo $j+1; ?>">
                                                        <td><?php //echo $j+1; ?></td>
                                                        <td class="Contact_name">
                                                            <input type="hidden" id="txtname_<?php //echo '' . $j+1 . '_id"'; ?> name="nm_name[]" class="form-control" />
                                                            <input type="text" id="txtname_<?php //echo '' . $j+1 . '"'; ?> name="nm_contact_name[]" class="form-control auto_client nm_contact_name" placeholder="Type to choose contact from database..." />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="nm_relation[]" class="form-control" placeholder="Relation"/>
                                                        </td>
                                                    </tr>
                                                    <?php //} ?>
                                                </tbody>
                                            </table>
                                            </div>
                                            <div class="col-md-12 btn-margin">
                                                <button type="button" class="btn btn-success repeat-nominee"> + </button>
                                                <button type="button" class="btn btn-success reverse-nominee" > - </button>
                                            </div>
                                        </div>
                                    </div> -->
                           
			
                               <div class="form-footer" style="padding-bottom: 60px;">
                                    <input type="hidden" id="submitVal" value="1" />
                                    <!-- <a href="<?php //echo base_url(); ?>index.php/contacts" class="btn btn-danger btn-danger" >Cancel</a> -->
                                    <div style="display: flow-root;">
                                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-success pull-right save-form" name="submit" value="Save" />
                                    </div>
                                </div>
                            </form>
				      
                    </div>
                    </div>
                </div>
            
						
		<?php $this->load->view('templates/footer');?>
	</div>
</div>
    
    <script type="text/javascript">
        var BASE_URL="<?php echo base_url()?>";
    </script>

    <?php $this->load->view('templates/script');?>

    <!--<script type="text/javascript" src="<?php //echo base_url(); ?>js/load_autocomplete.js"></script>
    <script type="text/javascript" src="<?php //echo base_url(); ?>js/document.js"></script>-->

    <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    
    </body>
</html>
