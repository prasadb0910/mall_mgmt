<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('templates/header');?>

<link href="<?php echo base_url(); ?>assets/css/maintenance.css" rel="stylesheet" />

<style>
	.a
	{
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
	#image-label 
	{

		color:white;
		padding-left:6px;

	}
	#image-label_field
	{
		background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;


	}
	#image-label_field:hover
	{
		background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
	}
	.add
	{
		color:#41a541;
		cursor:default;
		font-size:14px;
		font-weight:500;
	}
	.remove
	{
		color:#d63b3b;
		text-align:right;
		cursor:default;
		margin-bottom: 10px;
		font-size:14px;
		font-weight:500;
	}
	.block1
	{
		padding: 20px 20px;
		border: 2px solid #edf0f5;
		border-radius: 7px;
		background: #f6f9fc;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.delete
	{
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

	/*Chrome fix*/
	input::-webkit-file-upload-button {
		cursor: pointer !important;
		height: 42px;
		width: 100%;
	}
	.attachments
	{
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
<div class="content ">
	<div class=" container-fluid   container-fixed-lg ">
		<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
			<li class="breadcrumb-item active">Maintenance</li>
		</ol>
		<div class="row">
			<div class="col-md-12">
				<div id="myDIV m-b-20">
	                <a class="btn btn-default pull-right m-b-20" href="<?php echo base_url(); ?>index.php/task/task_edit"><span class="fa fa-plus"></span> Add Maintenance Details</a>
	            </div>
	        </div>
			<div class="col-md-12">
				<div class="swiper-wrapper "  style="">
					<div class="swiper-slide swiper-slide-active col-md-4" >
						<div class="workorders-place-wrap workorders-wrap-clear">
							<div class="workorders-place-head" style="">
								<h3>
									<span class="head-title">New</span>
									<span class="head-count count-1">(<span id="count_1"><?php echo $new; ?></span>)</span>
								</h3>
							</div>

							<div class="workorders-place-body" style="" ondrop="drop(event)" ondragover="allowDrop(event)">
								<div class="workorders-place-inner" style="" id="border_1">
									<div  class="placeholder-workorders" id="text1" style="<?php if($new>0) echo 'display: none;'; ?>">
										<div>
											<div class="m-b-10" >
												<i class="fa fa fa-arrows"></i>
												<h4>Drag</h4>
											</div>
											<h4>No new requests</h4>
										</div>
									</div>


									<?php if(count($task) > 0){
										foreach($task as $row){ 
										if($row->task_status=='New'){ ?>

										<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;" draggable="true" ondragstart="drag(event)" id="drag_<?php echo $row->id; ?>">
											<div class="row p-l-20">
												<div class=" col-md-12">
													<div class="info">
														<H5 class="title_1 pull-left"><?php echo $row->subject_detail; ?></H5>
														<p class="pull-right p-t-15 p-r-10"><span style="color: #5cb85c;font-size:16px"><!-- #23920 --></span></p><br>
													<div class="info-name-property pull-left"><?php echo $row->p_display_name; ?></div><br>
														<div class="info-name-property pull-left" style="font-size:14px!important"><?php echo $row->priority; ?></div><br>
														
														<div class="location-address">
														
															<address><?php echo get_address($row->p_address, $row->p_landmark, $row->p_city, $row->p_pincode, $row->p_state, $row->p_country); ?></address>
														</div>
													</div>
												</div>
											</div>
											<div class=" col-md-12 p-b-10 p-t-5">
												<span class="badge badge-notify pull-left "><?php echo (strlen($row->c_name)>0?substr($row->c_name, 0, 1):'') . (strlen($row->c_last_name)>0?substr($row->c_last_name, 0, 1):''); ?></span>
												<span class="pull-left " style="padding-left:50px"><small class="user-roommates empty">Assign to</small><br><?php echo $row->c_full_name; ?></span>
												<a href="<?php echo base_url(); ?>index.php/task/task_edit/<?php echo $row->id;?>" class=" pull-right invoice" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
											</div>
										</div>

									<?php }}} ?>

								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide swiper-slide-next col-md-4" >
						<div class="workorders-place-wrap workorders-wrap-clear" >
							<div class="workorders-place-head">
								<h3>
									<span class="head-title">In Progress</span>
									<span class="head-count count-2">(<span id="count_2"><?php echo $in_progress; ?></span>)</span>
								</h3>
							</div>

							<div class="workorders-place-body"  ondrop="drop(event)" ondragover="allowDrop(event)">
								<div class="workorders-place-inner" id="border_2">
									<div  class="placeholder-workorders" id="text2" style="<?php if($in_progress>0) echo 'display: none;'; ?>">
										<div>
											<div class="m-b-10">
												<i class="fa fa fa-arrows"></i>
												<h4>Drag</h4>
											</div>
											<h4>No in progress requests</h4>
										</div>
									</div>


									<?php if(count($task) > 0){
										foreach($task as $row){ 
										if($row->task_status=='In Progress'){ ?>

										<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;" draggable="true" ondragstart="drag(event)" id="drag_<?php echo $row->id; ?>">
											<div class="row p-l-20">
												<div class=" col-md-12">
													<div class="info">
														<H5 class="title_1 pull-left"><?php echo $row->subject_detail; ?></H5>
														<p class="pull-right p-t-15 p-r-10"><span style="color: #5cb85c;font-size:16px"><!-- #23920 --></span></p><br>
														<div class="info-name-property pull-left"><?php echo $row->p_display_name; ?></div><br>
														<div class="info-name-property pull-left" style="font-size:14px!important"><?php echo $row->priority; ?></div><br>
														
														<div class="location-address">
														
															<address><?php echo get_address($row->p_address, $row->p_landmark, $row->p_city, $row->p_pincode, $row->p_state, $row->p_country); ?></address>
														</div>
													</div>
												</div>
											</div>
											<div class=" col-md-12 p-b-10 p-t-5">
												<span class="badge badge-notify pull-left "><?php echo (strlen($row->c_name)>0?substr($row->c_name, 0, 1):'') . (strlen($row->c_last_name)>0?substr($row->c_last_name, 0, 1):''); ?></span>
												<span class="pull-left " style="padding-left:50px"><small class="user-roommates empty">Assign to</small><br><?php echo $row->c_full_name; ?></span>
												<a href="<?php echo base_url(); ?>index.php/task/task_edit/<?php echo $row->id;?>" class=" pull-right invoice" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
											</div>
										</div>

									<?php }}} ?>

								</div>
							</div>
						</div>
					</div>
					<div class="swiper-slide col-md-4">
						<div class="workorders-place-wrap">
							<div class="workorders-place-head">
								<h3>
									<span class="head-title">Resolved</span>
									<span class="head-count count-3">(<span id="count_3"><?php echo $resolved; ?></span>)</span>
								</h3>
							</div>

							<div class="workorders-place-body"  ondrop="drop(event)" ondragover="allowDrop(event)">
								<div class="workorders-place-inner" id="border_3">
									<div  class="placeholder-workorders" id="text3" style="<?php if($resolved>0) echo 'display: none;'; ?>">
										<div>
											<div class="m-b-10">
												<i class="fa fa fa-arrows"></i>
												<h4>Drag</h4>
											</div>
											<h4>No in progress requests</h4>
										</div>
									</div>

									<?php if(count($task) > 0){
										foreach($task as $row){ 
										if($row->task_status=='Resolved'){ ?>

										<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;" draggable="true" ondragstart="drag(event)" id="drag_<?php echo $row->id; ?>">
											<div class="row p-l-20">
												<div class=" col-md-12">
													<div class="info">
														<H5 class="title_1 pull-left"><?php echo $row->subject_detail; ?></H5>
														<p class="pull-right p-t-15 p-r-10"><span style="color: #5cb85c;font-size:16px"><!-- #23920 --></span></p><br>
														<div class="info-name-property pull-left"><?php echo $row->p_display_name; ?></div><br>
														<div class="info-name-property pull-left" style="font-size:14px!important"><?php echo $row->priority; ?></div><br>
														
															
														<div class="location-address">
														
															<address><?php echo get_address($row->p_address, $row->p_landmark, $row->p_city, $row->p_pincode, $row->p_state, $row->p_country); ?></address>
														</div>
													</div>
												</div>
											</div>
											<div class=" col-md-12 p-b-10 p-t-5">
												<span class="badge badge-notify pull-left "><?php echo (strlen($row->c_name)>0?substr($row->c_name, 0, 1):'') . (strlen($row->c_last_name)>0?substr($row->c_last_name, 0, 1):''); ?></span>
												<span class="pull-left " style="padding-left:50px"><small class="user-roommates empty">Assign to</small><br><?php echo $row->c_full_name; ?></span>
												<a href="<?php echo base_url(); ?>index.php/task/task_edit/<?php echo $row->id;?>" class=" pull-right invoice" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
											</div>
										</div>

									<?php }}} ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('templates/footer');?>
</div>
</div>
<?php $this->load->view('templates/script');?>
<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/task_list.js"></script>

</body>
</html>