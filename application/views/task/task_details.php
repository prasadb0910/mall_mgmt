<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/header');?>
	<link href="<?php echo base_url(); ?>assets/css/maintenance.css" rel="stylesheet" />
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
	<div class="container-fluid container-fixed-lg">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Task/'; ?>">Maintenance List</a></li>
			<li class="breadcrumb-item active" ><a href="#">Maintenance Details</a></li>
		</ol>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-default">
					<div class="card-header ">
					
						<h2>Add maintenance requests</h2>
					</div>

					<div class="card-block">
						<form id="task_detail" action="<?php echo base_url();?>index.php/Task/insertDetails" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" id="id" value="<?php if(isset($taskdetail->id)) echo $taskdetail->id;?>">
						<!-- <input type="hidden" name="task_id" id="task_id" value="<?php //if(isset($taskdetail->task_id))echo $taskdetail->task_id;?>"> -->
						<input type="hidden" name="task_status" id="task_status" value="<?php if(isset($taskdetail->task_status)) echo $taskdetail->task_status; else echo 'New'; ?>">
						<div class="row">
							<div class="col-md-8">
								<div class=" container-fluid  p-t-20 p-b-20 m_details container-fixed-lg bg-white " >
									<div class="a">
										<div class="info-panel">
											<h3 class="panel-label">
												Request Details
											</h3>
											<p class="panel-description">Add any additional details here.</p>
										</div>
										<div class="form-group form-group-default required">
											<label>Title</label>
											<input type="text" class="form-control" name="subject_detail" placeholder="Enter Here" value="<?php if(isset($taskdetail->subject_detail)) {echo $taskdetail->subject_detail;}?>"/>
										</div>
										<div class="form-group form-group-default required">
											<label>DETAILS</label>
											<textarea class="form-control" name="description"  placeholder="Enter Here" rows="2" ><?php if(isset($taskdetail->message_detail))echo $taskdetail->message_detail;?></textarea>
										</div>
									</div>
									<div class="a">
										<div class="info-panel">
											<h3 class="panel-label">
												Attachments
											</h3>
											<p class="panel-description">Attach the files of the issue to help narrowing down the issue.</p>
										</div>
										<div class="row">
											<div class="col-md-6">
												<input type="hidden" id="uploadFile" placeholder="Add files from My Computer"/>
												<div class="fileUpload">
													<input id="uploadBtn" type="file" class="upload" multiple="multiple" name="browsefile"/>
													<label class="files" for="uploadBtn">
														<i class="fa fa-cloud-upload"></i>
														<span class="label-description">
															<span>Upload</span>
															<small>Take photo of the problem</small>
														</span>
													</label>
												</div>
												<div id="upload_prev">
												</div>
											</div> 
											<!-- <div class="col-md-6">
												<input type="hidden" id="uploadFile1" placeholder="Add files from My Computer"/>
												<div class="fileUpload">
													<input id="uploadBtn1" type="file" class="upload" multiple="multiple" name="browsefile"/>
													<label class="files">
														<i class="fa fa-video-camera"></i>
														<span class="label-description">
															<span>Upload</span>
															<small>Take photo of the problem</small>
														</span>
													</label>
												</div>
												<div id="upload_prev1">
												</div>
											</div> --> 
										</div>  
									</div>  
									<div class="a">
										<fieldset class="assignee" id="assigneePro">
											<div class="info-panel">
												<h3 class="panel-label">
													Assignee Information
												</h3>
												<p class="panel-description">Assign yourself or select the Service Professional from the list. Connect and post the order to ServicePro Portal. Communicate, add materials, and create transactions within the order.</p>
											</div>
											<div class="radio radio-success">
												<input type="radio" value="1" name="self_assigned" id="self_assigned_yes" <?php if(isset($taskdetail->self_assigned)) {if($taskdetail->self_assigned=='1') echo 'checked';} ?> />
												<label for="self_assigned_yes">Do it Myself</label>
												<input type="radio" value="0" name="self_assigned" id="self_assigned_no" <?php if(isset($taskdetail->self_assigned)) {if($taskdetail->self_assigned=='0' || $taskdetail->self_assigned==null) echo 'checked';} else echo 'checked'; ?> />
												<label for="self_assigned_no">Assign to service provider</label>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default form-group-default-select2 required">
													<label class="">ASSIGN TO</label>
													<select id="contact_1_id" name="contact" class="form-control full-width" data-error="#err_contact_name_1" data-placeholder="Select" data-init-plugin="select2" <?php if(isset($taskdetail->self_assigned)) {if($taskdetail->self_assigned=='1') echo 'disabled';} ?>>
		                                                <option value="">Select</option>
		                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
		                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($taskdetail)) { if($taskdetail->self_assigned=='0' || $taskdetail->self_assigned==null) { if($taskdetail->user_id == $contact[$k]->c_id) { echo 'selected'; }}} ?>><?php echo $contact[$k]->contact_name; ?></option>
		                                                <?php } ?>
		                                            </select>
		                                            <div id="err_contact_name_1"></div>
												</div>
											</div>
										</fieldset>
									</div>
									<div class="a">
										<div class="info-panel">
											<h3 class="panel-label">
												Dates &amp; labor
											</h3>
											<p class="panel-description">Capture work and day hours for each request to keep track of labor time.</p>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-default input-group">
													<div class="form-input-group">
														<label>REQUEST INITIATED DATE</label>
														<input type="text" class="form-control datepicker"  placeholder="Enter Here" name="request_initiated_date" value="<?php if(isset($taskdetail->request_initiated_date)) echo date('d/m/Y',strtotime($taskdetail->request_initiated_date));?>" />
													</div>
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default input-group">
													<div class="form-input-group">
														<label>REQUEST DUE DATE</label>
														<input type="text" class="form-control datepicker"  placeholder="Enter Here" name="request_due_date" value="<?php if(isset($taskdetail->request_due_date)) echo date('d/m/Y',strtotime($taskdetail->request_due_date));?>" />
													</div>
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-default input-group">
													<div class="form-input-group">
														<label>STARTED TO WORK DATE</label>
														<input type="text" class="form-control datepicker"  placeholder="Enter Here" name="started_to_work_date" value="<?php if(isset($taskdetail->started_to_work_date)) echo date('d/m/Y',strtotime($taskdetail->started_to_work_date));?>" />
													</div>
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default input-group">
													<div class="form-input-group">
														<label>COMPLETED WORK DATE</label>
														<input type="text" class="form-control datepicker"  placeholder="Enter Here" name="completed_work_date" value="<?php if(isset($taskdetail->completed_work_date)) echo date('d/m/Y',strtotime($taskdetail->completed_work_date));?>" />
													</div>
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-footer" style="padding-bottom: 60px;">
										<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/task">Cancel</a>
										<button class="btn btn-success pull-right"  type="submit">Save</button>
									</div>
								</div>
							</div>

							<div class="col-md-4">
								<div class="body-aside is-landlord">
									<div class="aside-inner">
										<div class="aside-group priority">
											<h3>Priority</h3>
											<div class="btn-group-status">
												<input type="button" class="m-btn <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Low') echo 'active';} ?>" value="Low" />
												<input type="button" class="m-btn <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Normal') echo 'active';} else  echo 'active'; ?>" value="Normal" />
												<input type="button" class="m-btn <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='High') echo 'active';} ?>" value="High" />
												<input type="button" class="m-btn <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Critical') echo 'active';} ?>" value="Critical" />
												<input type="hidden" name="priority" id="priority" value="<?php if(isset($taskdetail->priority)) echo $taskdetail->priority; else echo 'Normal'; ?>" />
											</div>
										</div>
										<div class="aside-group">
											<h3>Location Information</h3>
											<div class="form-group form-group-default form-group-default-select2 required">
												<label class="">Select Property</label>
												<select class="form-control full-width" id="property" name="property" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
													<option value="0">Select</option>
													<?php if(isset($taskdetail)) { 
														for($i=0; $i<count($property); $i++) { ?>
															<option value="<?php echo $property[$i]->property_txn_id; ?>" <?php if($taskdetail->property_id == $property[$i]->property_txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->unit_name; ?></option>
													<?php } } else { ?>
															<?php for($i=0; $i<count($property); $i++) { ?>
															<option value="<?php echo $property[$i]->property_txn_id; ?>"><?php echo $property[$i]->unit_name; ?></option>
													<?php } } ?>
												</select>
											</div>
											<div class="form-group form-group-default form-group-default-select2 required" id="subproperty" style="display:none;">
												<label class="">Select Sub Property</label>
												<select  class="form-control full-width" id="sub_property" name="sub_property" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">
													<option value="0">Select Sub Property</option>
													<?php if(isset($taskdetail)) { 
														for($i=0; $i<count($sub_property); $i++) { ?>
															<option value="<?php echo $sub_property[$i]->txn_id; ?>" <?php if($taskdetail->sub_property_id == $sub_property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
													<?php } } else { ?>
															<?php for($i=0; $i<count($sub_property); $i++) { ?>
															<option value="<?php echo $sub_property[$i]->txn_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
													<?php } } ?>
												</select>
											</div>
										</div>
										<div class="aside-group residents">
											<h3>Residents Information</h3>
											<div class="form-group form-group-default form-group-default-select2 required">
												<label class="">Select Tenants</label>
												<select id="owner_name" name="owner_name" class="form-control full-width" data-error="#err_owner_name" data-placeholder="Select" data-init-plugin="select2">
	                                                <option value="">Select</option>
	                                                <?php if(isset($taskdetail)) { 
														for($i=0; $i<count($contact); $i++) { ?>
															<option value="<?php echo $contact[$i]->c_id; ?>" <?php if($taskdetail->owner_id == $contact[$i]->c_id) { echo 'selected';} ?> ><?php echo $contact[$i]->contact_name; ?></option>
													<?php } } else { ?>
															<?php for($i=0; $i<count($contact); $i++) { ?>
															<option value="<?php echo $contact[$i]->c_id; ?>"><?php echo $contact[$i]->contact_name; ?></option>
													<?php } } ?>
	                                            </select>
	                                            <div id="err_owner_name"></div>
											</div>
											<div class="form-group form-group-default input-group">
												<div class="form-input-group">
													<label>Check In</label>
													<input type="text" class="form-control datepicker" name="check_in_date" id="check_in_date"  placeholder="Enter Here" value="<?php if(isset($taskdetail->check_in_date)) echo date('d/m/Y',strtotime($taskdetail->check_in_date));?>" />
												</div>
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
											</div>
											<div class="group-time">
												<div class="checkbox-box">
													<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12"  style="padding-left:7px!important;">
														<div class="checkbox-inner">
															<input name="time1" id="time1" type="checkbox" value="1" <?php if(isset($taskdetail->time1)){ if($taskdetail->time1=='1') echo 'checked';} ?>>
															<label for="time1" title="any time" >any time</label>
														</div>
													</div>
													<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12">
														<div class="checkbox-inner">
															<input name="time2" id="time2" type="checkbox" value="1" <?php if(isset($taskdetail->time2)){ if($taskdetail->time2=='1') echo 'checked';} ?>>
															<label for="time2" title="8am - 12pm" >8am - 12pm</label>
														</div>
													</div>
													<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12">
														<div class="checkbox-inner">
															<input name="time3" id="time3" type="checkbox" value="1" <?php if(isset($taskdetail->time3)){ if($taskdetail->time3=='1') echo 'checked';} ?>>
															<label for="time3" title="12pm - 4pm" >12pm - 4pm</label>
														</div>
													</div>
													<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12">
														<div class="checkbox-inner">
															<input name="time4" id="time4" type="checkbox" value="1" <?php if(isset($taskdetail->time4)){ if($taskdetail->time4=='1') echo 'checked';} ?>>
															<label for="time4" title="4pm - 8pm" >4pm - 8pm</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	 var BASE_URL="<?php echo base_url(); ?>";
</script>
<?php $this->load->view('templates/footer');?>
</div>
</div>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/task.js"></script>

</html>