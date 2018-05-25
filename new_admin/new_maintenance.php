<?php include('header.php');?>


<link href="assets/css/maintenance.css" rel="stylesheet" type="text/css" />


</head>
<body class="fixed-header ">


<?php include('sidebar.php')?>

<div class="page-container ">

<div class="header ">

<a href="#" class="btn-link toggle-sidebar hidden-lg-up pg pg-menu" data-toggle="sidebar">
</a>

<div class="">
<div class="brand inline   ">

</div>




 </div>
<div class="d-flex align-items-center">

<div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
<span class="semi-bold">David</span> <span class="text-master">Nest</span>
</div>
<div class="dropdown pull-right hidden-md-down">
<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="thumbnail-wrapper d32 circular inline">
<img src="assets/img/profiles/avatar.jpg" alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
</span>
</button>
<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
<a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
<a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
<a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
<a href="#" class="clearfix bg-master-lighter dropdown-item">
<span class="pull-left">Logout</span>
<span class="pull-right"><i class="pg-power"></i></span>
</a>
</div>
</div>


</div>
</div>


<div class="page-content-wrapper ">

<div class="content ">



<div class=" container-fluid   container-fixed-lg ">



<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
<li class="breadcrumb-item "><a href="bank_list.php"> BANK DETAILS LIST</a></li>
<li class="breadcrumb-item active"> BANK DETAILS</li>
</ol>


<div class="row">
<div class="col-md-12">

<div class="card card-default">
<div class="card-header ">
<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
<h2>Add maintenance requests</h2>


</div>


<div class="card-block">

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
<input type="text" class="form-control" name="title" placeholder="" >
</div>

<div class="form-group form-group-default required">
<label>DETAILS</label>
<textarea class="form-control" id="name"></textarea>
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
<FORM METHOD="post" ACTION="xxx@gmail.com" ENCTYPE="multipart/form-data">
<input type="hidden" id="uploadFile" placeholder="Add files from My Computer"/>
<div class="fileUpload">

<input id="uploadBtn" type="file" class="upload" multiple="multiple" name="browsefile"/>
<label class="files">
				<i class="fa fa-cloud-upload"></i>

				<span class="label-description">
					<span>Upload</span>
					<small>Take photo of the problem</small>
				</span>
</label>
</div>

<div id="upload_prev">
</div>  

  
       
</FORM>	
</div> 

<div class="col-md-6">
<FORM METHOD="post" ACTION="xxx@gmail.com" ENCTYPE="multipart/form-data">
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

  
       
</FORM>	
</div> 
</div>  
</div>  

<div class="a">
<fieldset class="assignee" id="assigneePro">
	<div class="info-panel">
		<h3 class="panel-label">
			Assignee Information

			<!---->
		</h3>
		<p class="panel-description">Assign yourself or select the Service Professional from the list. Connect and post the order to ServicePro Portal. Communicate, add materials, and create transactions within the order.</p>
	</div>

	<div class="radio radio-success">
<input type="radio" value="1" name="kyc" id="male">
<label for="male">Do it Myself</label>
<input type="radio" checked="checked"  value="0" name="kyc" id="female">
<label for="female">Assign to service provider</label>
</div>
<div class="col-md-6">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">ASSIGN TO</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="assign_to">
<option value="AK">select</option>

</select>
</div>
</div>
</div>

	<!-- Dates & labor -->
	<div class="a">
	<div>
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
<input type="email" class="form-control date" placeholder="Pick a date" id="datepicker-component2">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>
		
			</div>
			
			<div class="col-md-6">

		<div class="form-group form-group-default input-group">
<div class="form-input-group">
<label>REQUEST DUE DATE
</label>
<input type="email" class="form-control date" placeholder="Pick a date" id="datepicker-component2">
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
<label>STARTED TO WORK DATE
</label>
<input type="email" class="form-control date" placeholder="Pick a date" id="datepicker-component2">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>
		
			</div>
			
			<div class="col-md-6">
<div class="form-group form-group-default input-group">
<div class="form-input-group">
<label>COMPLETED WORK DATE
</label>
<input type="email" class="form-control date" placeholder="Pick a date" id="datepicker-component2">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>
		
			</div>
		</div>
				
	</div>
	</div>
</fieldset>
<div class="form-footer" style="padding-bottom: 60px;">

<button class="btn btn-default-primary pull-left"  type="submit">Cancel</button>
<button class="btn btn-success pull-right"  type="submit">Save</button>



</div>
</div>
</div>

<div class="col-md-4">
<div class="body-aside is-landlord">
	<div class="aside-inner">
	<!-- Priority information -->
	<div class="aside-group priority">
		<h3>Priority</h3>
		<div class="btn-group-status">
			<!----><button class="m-btn" type="button" >
				Low
			</button><!----><button class="m-btn btn-primary--danger active disabled" type="button" >
				Normal
			</button><!----><button class="m-btn" type="button" >
				High
			</button><!----><button class="m-btn" type="button" >
				Critical
			</button><!---->
		</div>
	</div>

	<!-- Location information -->
	<div class="aside-group">
		<h3>Location Information</h3>

	<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Select Property</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="Property">
<option value="AK">select</option>

</select>
</div>

<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Select Unit</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="unit">
<option value="AK">select</option>

</select>
</div>

		<!---->
	</div>

	<!-- Residents information -->
	<div class="aside-group residents">
		<h3>Residents Information</h3>

		
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Select Tenants</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenants">
<option value="AK">select</option>

</select>
</div>

<div class="form-group form-group-default input-group">
<div class="form-input-group">
<label>Check In</label>
<input type="email" class="form-control date" placeholder="Pick a date" id="datepicker-component2">
</div>
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
</div>

	<div class="group-time">
			<div class="checkbox-box">
	<!---->	<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12" >
			<div class="checkbox-inner">
			<input name="time1" id="time1" type="checkbox" value="1">
			<label for="time1" title="any time" >any time</label>
		</div><!---->
	</div><!---->
		<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12" >
		<div class="checkbox-inner">
			<input name="time2" id="time2" type="checkbox" value="2">
			<label for="time2" title="8am - 12pm" >8am - 12pm</label>
		</div><!---->
	</div>
	<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12" >
		<div class="checkbox-inner">
			<input name="time3" id="time3" type="checkbox" value="3">
			<label for="time3" title="12pm - 4pm" >12pm - 4pm</label>
		</div><!---->
	</div><!---->
	<div class="form-checkbox checkbox check-success col-xs-24 col-sm-12" >
		<div class="checkbox-inner">
			<input name="time4" id="time4" type="checkbox" value="4">
			<label for="time4" title="4pm - 8pm" >4pm - 8pm</label>
			</div><!---->
	</div><!---->

	<!---->
</div>
		</div>


	</div>

	<!-- Authorization information -->
	

	<!-- Pets information -->
	
</div>

						</div>
						</div>






</div>
</div>
</div>




</div>
</div>
</div>




</div>




<div class=" container-fluid  container-fixed-lg footer">
<div class="copyright sm-text-center">
<p class="small no-margin pull-left sm-pull-reset">
<span class="hint-text">Copyright &copy; 2017 </span>
<span class="font-montserrat">REVOX</span>.
<span class="hint-text">All rights reserved. </span>
<span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span>
</p>
<p class="small no-margin pull-right sm-pull-reset">
Hand-crafted <span class="hint-text">&amp; made with Love</span>
</p>
<div class="clearfix"></div>
</div>
</div>

</div>

</div>



<script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="assets/plugins/modernizr.custom.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/plugins/tether/js/tether.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery/jquery-easy.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-actual/jquery.actual.min.js"></script>
<script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/classie/classie.js"></script>
<script src="assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>




<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>
<script>
$(document).on('click','.close',function(){
	$(this).parents('span').remove();

})

document.getElementById('uploadBtn').onchange = uploadOnChange;
document.getElementById('uploadBtn1').onchange = uploadOnChange1;
    
function uploadOnChange() {
    document.getElementById("uploadFile").value = this.value;
    var filename = this.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    var files = $('#uploadBtn')[0].files;
    for (var i = 0; i < files.length; i++) {
     $("#upload_prev").append('<span>'+'<div class="filenameupload">'+files[i].name+'</div>'+'<p class="close" ><i class="fa fa-trash "></i></p></span>');
    }
    document.getElementById('filename').value = filename;
}

function uploadOnChange1() {
    document.getElementById("uploadFile1").value = this.value;
    var filename = this.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    var files = $('#uploadBtn1')[0].files;
    for (var i = 0; i < files.length; i++) {
     $("#upload_prev1").append('<span>'+'<div class="filenameupload">'+files[i].name+'</div>'+'<p class="close" ><i class="fa fa-trash "></i></p></span>');
    }
    document.getElementById('filename').value = filename;
}

	</script>
	
<script src="assets/js/append.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>

<script>
 $(".date").datepicker();

</script>
<script type="text/javascript">
   $(document).ready(function() {
 $('#dob').change(function(){ 
	checkdob();});
 });
 </script>



		
	

</html>