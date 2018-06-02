<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
			margin-left:0px!important;
		}
		.print {
			color:#fe970a!important;
			display:none!important;
		}
		.a {
			border-bottom: 2px solid #edf0f5;
			margin-bottom: 25px;
			padding-bottom: 25px;
		}
		.prop_img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}
		.markup {
			border-radius:20px;
		}
		#contact1 {
			width: 150px;
			height: 150px;
			text-align: center;
			float: none;
			margin: 15px auto;
			display: block;
			color:#fff!important;
		}
		.info {
			text-align:center;

		}
		.invoice {
			margin: 10px;
			padding: 0 27px;
			border-radius: 30px;
			font-size: 13px;
		}
		.btn-group-justified {
			margin-left:2px;
		}
		.email {
			font-size:13px!important;
			color:#fff!important;
		}
		.title_1 {
			font-size: 1.14286rem!important;
			font-family: inherit!important;
			font-weight: 500!important;
			letter-spacing: 0.02em!important;
			text-transform: capitalize!important;
			color:#fff!important;
		}
		.contact_card {
			border-radius:5px!important;
		}
		.rent {
			color:#fff!important;
			border-right:2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-color: rgba(255,255,255,0.1) !important;	
		}
		.rent:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.rent a {
			color:#fff!important;
		}
		.leases {
			color:#fff!important;
			border-top: 2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-right:2px solid #edf0f5;
			border-color: rgba(255,255,255,0.1) !important;
		}
		.leases:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.badge-notify {
			background: #899be7;
			position: relative;
			top: -88px;

			left: 175px;
			width: 28px;
			height: 28px;
			color: #fff;

			border: 2px solid #ffffff;
			position: absolute;
			top: 30px;

			width: 28px;
			height: 28px;
			border-radius: 50%;
			background-color: #41c997;
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;

			-webkit-box-align: center;
			-webkit-align-items: center;
			-ms-flex-align: center;
			align-items: center;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-ms-flex-pack: center;
			justify-content: center;
			border: 2px solid #ffffff;
			-webkit-transition: background-color 0.2s linear;
			transition: background-color 0.2s linear;
		}
		#money.fa {
			font-size:22px!important;
		}
		.user-roommates:after {
			content: '';
			position: absolute;
			left: 50%;
			top: 161px;
			width: 22px;
			height: 1px;
			margin-left: -11px;
			background-color: #e6ebf1;
		}
		.user-roommates.empty>p {
			text-align:center;
			font-size: 12px;
			color: #d1d3d8;
		}
		.form-group-default {
			border:none!important;
		}
		.form-group-default label {
			font-weight:1000!important;
		}
		.thumbnail-wrapper.d32>* {
			line-height: 110px!important;
		}
		#pricing_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		#invoice_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		.block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left:12px;
			margin-right:12px;
		}
		p {
			font-weight: 200px!important;
		}
		.dropdown-item input {
			display: inline; 
			padding-left: 0px;
			cursor: pointer;
			font-size: 13px;
		}
		.select2-selection, .select2-selection__rendered{
			background: white!important;
			color: rgba(0, 0, 0, 0.36)!important;
			font-weight: normal;
		}
		.select2-selection__arrow {
			display: none;
		}
		
		p
		{
			padding-left:12px!important;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
	<?php $this->load->view('templates/main_header');?>
	<div class="page-content-wrapper ">
		<div class="content ">
			<form id="form_contact_view" role="form" method ="post" action="<?php echo base_url().'index.php/Contacts/update/'.$c_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Contacts/checkstatus/All/<?php if (isset($contact_type)) echo $contact_type; else if (isset($editcontact[0]->c_type)) echo $editcontact[0]->c_type; ?>">Contact List</a></li>
					<li class="breadcrumb-item active">Contact View</li>
						<li class="breadcrumb-item active"><?php if (isset($owner_type)) echo $owner_type;?></li>
				</ol>
				<div class="container">
					<div class="row">						
					<div class="col-md-12">
						<div class="card card-transparent  bg-white" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Contacts'; ?>">
									<div class="fileUpload blue-btn btn width100 pull-left">
										<span><i class="fa fa-arrow-left"></i></span> 
									</div>
								</a>
								<div class="dropdown pull-right hidden-md-down">
									<button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="fileUpload blue-btn btn width100">
											<span><i class="fa fa-ellipsis-h"></i></span> 
										</div>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
										<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
											<a href="<?php echo base_url().'index.php/Contacts/editrecord/'.$c_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

									<?php if(isset($editcontact)) { ?>
										<?php if($editcontact[0]->c_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i>  <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } else if($editcontact[0]->c_modifiedby != '' && $editcontact[0]->c_modifiedby != null) { if($editcontact[0]->c_modifiedby!=$contactby) { if($editcontact[0]->c_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($editcontact[0]->c_createdby != '' && $editcontact[0]->c_createdby != null) { if($editcontact[0]->c_createdby!=$contactby && $editcontact[0]->c_status != 'In Process') { if($editcontact[0]->c_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i>  <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } ?>

										<a href="#" class="dropdown-item print" ><i class="fa fa-print"></i> Print</a>
									</div>
								</div>
							</div>
						</div>
						</div>
						<div class="col-md-3" style="background:#a5b1de; padding-right: 15px;padding-left: 15px;">
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-20" style="background:rgba(0,0,0,0.2);">
								<div class="row">
									<div class=" col-md-12">
										<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
											<div class="bg-master text-center text-white" style=" background: #41c997;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span><?php echo (strlen($contact_details[0]->c_name)>0?substr($contact_details[0]->c_name, 0, 1):'') . (strlen($contact_details[0]->c_last_name)>0?substr($contact_details[0]->c_last_name, 0, 1):''); ?></span>
											</div>  
										</div>
										<div class="info">
											<H5 class="title_1"><?php if($editcontact[0]->c_owner_type=='individual') echo $editcontact[0]->c_name . ' ' . $editcontact[0]->c_last_name; else echo $editcontact[0]->c_company_name; ?></H5>
											<p class="email"><?php if($contact_details[0]->c_emailid1!='') echo $contact_details[0]->c_emailid1; else echo '&nbsp;'; ?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="invoice_box" style="background:rgba(0,0,0,0.2);">
								<div class=" col-md-12">
										<span class="invoice"><a href="<?php echo base_url(); ?>index.php/Accounting/addnew/income" class="btn btn-success  btn-xs invoice" ><span>New Invoice </span></a></span>
								</div>
							</div>
							
								<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2); <?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Others')  echo 'display: none;'; } ?>">
								<div class="row">
								  <div class="col-md-6 rent">
                                    <a href="<?php echo base_url(); ?>index.php/Accounting">
                                      <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                         Accounting
										</a>
                                    </div>
                                     <div class=" col-md-6 rent" style="border-right:none;">
										<a href="<?php echo base_url(); ?>index.php/rent">
                                         <i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
                                         Rent
										 </a>
                                                           
								  </div>
								</div> 
							</div>
					
							
						</div>
						<div class="col-md-9">
							<div class=" container-fluid   container-fixed-lg bg-white">
								<div class="card card-transparent">
									<p class="m-t-20"></p>
									<div class="a">
										<div class="row clearfix">
											<div class="col-md-6">
												<input type="hidden" class="form-control" name="c_id" id="c_id" value="<?php if (isset($c_id)) { echo $c_id; } ?>">
		                                    	<input type="hidden" class="form-control" name="type" id="type" value="<?php if (isset($contact_type)) echo $contact_type; else if (isset($editcontact[0]->c_type)) echo $editcontact[0]->c_type; ?>">
												<input type="hidden" class="form-control" name="owner_type" id="owner_type" value="<?php if (isset($owner_type)) echo $owner_type; else if (isset($editcontact[0]->c_owner_type)) echo $editcontact[0]->c_owner_type; ?>">
												<div class="form-group form-group-default">
													<label>Company Name</label>
													<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_company_name; } ?></span>
												
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default ">
													<label>Registration No</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_reg_no; } ?></span>
												
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Date of Incorporation</label>
														<span class="label_addr"><?php if(isset($editcontact)) { if($editcontact[0]->c_incop_date!='' && $editcontact[0]->c_incop_date!=null) echo date('d/m/Y', strtotime($editcontact[0]->c_incop_date)); } ?></span>
													
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Contact Person</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_reg_no; } ?></span>
													
		                                          
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Address</label>
														<span class="label_addr"><?php if(isset($editcontact)) { echo  $editcontact[0]->c_address; } ?></span>
													
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Landmark </label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_landmark; } ?></span>
													
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>City </label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_city; } ?></span>
												
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Pincode </label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_company_name; } ?></span>
													
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>State</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_state; } ?></span>
													
											</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Country </label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_country; } ?></span>
													
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Branch Address</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_branch; } ?></span>
													
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_telephone; } ?></span>
													<label>Telephone No.</label>
												
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Mobile No.</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_mobile; } ?></span>
													
												</div>
											</div>
											<div class="col-md-6" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Owners') echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
			                                    <div class="form-group form-group-default">
			                                        <label>Invoice Format</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_invoice_format; } ?></span>

			                                    </div>
			                                </div>
										</div>
										<div class="row clearfix" style="<?php if (isset($editcontact)) { if($editcontact[0]->c_type=='Owners') echo ''; else echo 'display: none;'; } else echo 'display: none;'; ?>">
											<div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Invoice No</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_invoice_no; } ?></span>
			                                       
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>GST No</label>
														<span class="label_addr"><?php if (isset($editcontact)) { echo $editcontact[0]->c_gst_no; } ?></span>
			                                       
			                                    </div>
			                                </div>
										</div>
									</div>
									
			                        <div class="a" id="family-section" style="<?php if($owner_type!='huf') echo 'display: none;'; ?>">
			                            <p class="m-t-20"><b>Family Details<b></p>
										
		                                <div id="family_details">

		                                    <?php $l=0;
		                                    if(isset($editcontfam)) {
		                                    for($l=0; $l<count($editcontfam); $l++) { ?>

		                                    <div id="repeat_family_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Select Contact</label>
		                                                <select id="family_details_<?php echo $l+1; ?>" name="family[]" class="form-control family_details full-width" data-placeholder="" data-init-plugin="select2" data-error="#family_details_<?php echo $l; ?>_error" disabled>

		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontfam[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
	                        							<span id="family_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default">
		                                                <label>Relation</label>
		                                                <input type="text" class="form-control" name="relation[]" value="<?php echo $editcontfam[$l]->relation; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="director-section" style="<?php if($owner_type!='pvtltd' && $owner_type!='ltd') echo 'display: none;'; ?>">
			                            <p class=""><b>Director Details</b></p>
		                                <div id="director_details">

		                                    <?php $l=0;
		                                    if(isset($editcontdir)) {
		                                    for($l=0; $l<count($editcontdir); $l++) { ?>

		                                    <div id="repeat_director_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Director <?php echo $l+1; ?></label>
		                                                <select id="director_details_<?php echo $l+1; ?>" name="director[]" class="form-control director_details full-width" data-init-plugin="select2" data-error="#director_details_<?php echo $l; ?>_error" disabled>
		                                                
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontdir[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
	                        							<span id="director_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="shareholder-section" style="<?php if($owner_type!='pvtltd' && $owner_type!='ltd') echo 'display: none;'; ?>">
			                            <p class=""><b>Shareholder Details</b></p>
		                                <div id="shareholder_details">

		                                    <?php $l=0;
		                                    if(isset($editcontshr)) {
		                                    for($l=0; $l<count($editcontshr); $l++) { ?>

		                                    <div id="repeat_shareholder_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Share Holder <?php echo $l+1; ?></label>
		                                                <select id="shareholder_details_<?php echo $l+1; ?>" name="shareholder[]" class="form-control shareholder_details full-width" data-init-plugin="select2" data-error="#shareholder_details_<?php echo $l; ?>_error" disabled>
		                                            
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontshr[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
	                        							<span id="shareholder_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default">
		                                                <label>Shareholder %</label>
		                                                <input type="text" class="form-control" id="shareholder_percent_<?php echo $l+1; ?>" name="shareholder_percent[]"  value="<?php echo $editcontshr[$l]->percent; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-3">
		                                            <div class="form-group form-group-default">
		                                                <label>No Of Shares</label>
		                                                <input type="text" class="form-control" name="no_of_shares[]"  value="<?php echo $editcontshr[$l]->no_of_shares; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="partnership-section" style="<?php if($owner_type!='llp' && $owner_type!='partnership' && $owner_type!='aop') echo 'display: none;'; ?>">
			                            <p class=""><b>Partnership Details</b></p>
		                                <div id="partnership_details">

		                                    <?php $l=0;
		                                    if(isset($editcontprt)) {
		                                    for($l=0; $l<count($editcontprt); $l++) { ?>

		                                    <div id="repeat_partnership_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Partner <?php echo $l+1; ?></label>
		                                                <select id="partnership_details_<?php echo $l+1; ?>" name="partnership[]" class="form-control partnership_details full-width" data-init-plugin="select2" data-error="#partnership_details_<?php echo $l; ?>_error" disabled>
		                                                
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontprt[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
		                    							<span id="partnership_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default">
		                                                <label>Partnership %</label>
		                                                <input type="text" class="form-control" id="partnership_percent_<?php echo $l+1; ?>" name="partnership_percent[]"  value="<?php echo $editcontprt[$l]->percent; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="trustee-section" style="<?php if($owner_type!='trust') echo 'display: none;'; ?>">
			                           <p class=""><b>Trustee Details</b></p>
		                                <div id="trustee_details">

		                                    <?php $l=0;
		                                    if(isset($editconttrs)) {
		                                    for($l=0; $l<count($editconttrs); $l++) { ?>

		                                    <div id="repeat_trustee_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Trustee <?php echo $l+1; ?></label>
		                                                <select id="trustee_details_<?php echo $l+1; ?>" name="trustee[]" class="form-control trustee_details full-width"data-init-plugin="select2" data-error="#trustee_details_<?php echo $l; ?>_error" disabled>

		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editconttrs[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
	                        							<span id="trustee_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="beneficiary-section" style="<?php if($owner_type!='trust') echo 'display: none;'; ?>">
			                            <p class=""><b>Beneficiary Details</b></p>
		                                <div id="beneficiary_details">

		                                    <?php $l=0;
		                                    if(isset($editcontben)) {
		                                    for($l=0; $l<count($editcontben); $l++) { ?>

		                                    <div id="repeat_beneficiary_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Beneficiary <?php echo $l+1; ?></label>
		                                                <select id="beneficiary_details_<?php echo $l+1; ?>" name="beneficiary[]" class="form-control beneficiary_details full-width" data-placeholder="" data-init-plugin="select2" data-error="#beneficiary_details_<?php echo $l; ?>_error" disabled>
		                                         
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontben[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
		                    							<span id="beneficiary_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default">
		                                                <label>Shareholder %</label>
		                                                <input type="text" class="form-control" id="beneficiary_percent_<?php echo $l+1; ?>" name="beneficiary_percent[]"   value="<?php echo $editcontben[$l]->percent; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

			                        <div class="a" id="owner-section" style="<?php if($owner_type!='proprietorship') echo 'display: none;'; ?>">
			                             <p class=""><b>Owner Details</b></p>
		                                <div id="owner_details">

		                                    <?php $l=0;
		                                    if(isset($editcontown)) {
		                                    for($l=0; $l<count($editcontown); $l++) { ?>

		                                    <div id="repeat_owner_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Owner <?php echo $l+1; ?></label>
		                                                <select id="owner_details_<?php echo $l+1; ?>" name="owner[]" class="form-control owner_details full-width" data-placeholder="" data-init-plugin="select2" data-error="#owner_details_<?php echo $l; ?>_error" disabled>
		                                                 
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontown[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
	                        							<span id="owner_details_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>
									
									<?php $this->load->view('templates/document_view');?>

									<div class="a" id="authsignatory-section" style="<?php if($owner_type=='huf') echo 'display: none;'; ?>">
			                            <p class=""><b>Authorised Signatory Details</b></p>
		                                <div id="authsignatory_details">

		                                    <?php $l=0;
		                                    if(isset($editcontauth)) {
		                                    for($l=0; $l<count($editcontauth); $l++) { ?>

		                                    <div id="repeat_authsignatory_<?php echo $l+1; ?>" class="row clearfix">
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default form-group-default-select2">
		                                                <label class="">Authorised Signatory <?php echo ($l+1); ?></label>
		                                                <select id="authsignatory_<?php echo $l+1; ?>" name="authsignatory[]" class="form-control authsignatory_details full-width" data-init-plugin="select2" data-error="#authsignatory_<?php echo $l; ?>_error" disabled>
		                                                
		                                                    <?php for ($k=0; $k < count($owner) ; $k++) { ?>
		                                                        <option value="<?php echo $owner[$k]->c_id; ?>" <?php if($owner[$k]->c_id==$editcontauth[$l]->c_id) { echo 'selected'; } ?>><?php echo $owner[$k]->contact_name; ?></option>
		                                                    <?php } ?>
		                                                </select>
		                    							<span id="authsignatory_<?php echo $l; ?>_error"></span>
		                                            </div>
		                                        </div>
		                                        <div class="col-md-4">
		                                            <div class="form-group form-group-default">
		                                                <label>Purpose Of AS</label>
		                                                <input type="text" class="form-control" name="purpose[]"  value="<?php echo $editcontauth[$l]->purpose; ?>" readonly/>
		                                            </div>
		                                        </div>
		                                    </div>

		                                    <?php } } ?>

		                                </div>
			                        </div>

									<!-- <p class="m-t-20"><b>Remark<b></p>
									<div class="row clearfix" style="padding-bottom: 25px;">
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Maker Remarks </label>
												<input type="text" class="form-control "  value="1" name="" id="" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Checker Remarks </label>
												<input type="text" class="form-control "  value="1" name="" id="" readonly>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-group-default " style="border:1px solid rgba(0,0,0,0.07)!important; ">
												<label>Remark</label>
												<input type="text" class="form-control " name="Remark" id="Remark" />
											</div>
										</div>
									</div> -->
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
</body>
</html>