<?php include('header.php');?>


<link href="assets/css/maintenance.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#image-preview {
  min-width: auto;
  min-height: 300px;
  width:100%;
  height:auto;
  position: relative;
  overflow: hidden;
background: url(assets/img/demo/crop.jpg);
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
</style>
<style>
.custom-radio .radio {
    border: 2px solid #edf0f5;
    background: #f6f9fc;
    padding: 10px 15px;
    margin-bottom: 0;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
}
.custom-radio .radio small {
    padding-top: 15px;
	font-size: 12px;
    font-weight: 400;
    display: block;
    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    color: #8c919e;
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
</style>

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

<li class="breadcrumb-item active"> Landlord Website</li>
</ol>


<div class="row">
<div class="col-md-12">






<div class="row">
<div class="col-md-12">
<div class=" container-fluid  p-t-20 p-b-20  container-fixed-lg bg-white " >
<div class="a">
<div class="info-panel">
		<h3 class="panel-label">
			Free Website Subdomain Name

		</h3>
	
	</div>
<br>
<form role="form">
<div class="form-group form-group-default input-group">
<div class="input-group-addon">
https://
</div>
<div class="form-input-group">
<label>Subdomain</label>
<input type="email" class="form-control" value="dhavalmaru">
</div>
<div class="input-group-addon">
.pecanreams.com	
</div>
</div>
</form>
</div>



<div class="a">
<fieldset class="assignee" id="assigneePro">
	<div class="info-panel">
		<h3 class="panel-label">
			Website Structure


			<!---->
		</h3>
		<p class="panel-description">Assign yourself or select the Service Professional from the list. Connect and post the order to ServicePro Portal. Communicate, add materials, and create transactions within the order.</p>
	</div>

	<div class="custom-radio">
					<div class="row">
						<!----><div class="col-md-6" ng-repeat="option in $ctrl.websiteShowPagesOptions">
							<div class="element form-radio radio radio-success">
								<!----><div class="u-posRelative" ng-repeat="item in option">
									<div>
										<input id="show_pages-1" name="show_pages" type="radio" checked="checked" value="1">
										<label for="show_pages-1" >Advanced</label>
									</div>

									<small>- Home Page<br>- Rentals Page<br>- Contact Page</small>
								</div><!---->
							</div>
						</div><!----><div class="col-md-6"  ng-repeat="option in $ctrl.websiteShowPagesOptions">
							<div class="element form-radio radio radio-success">
								<!----><div class="u-posRelative">
									<div>
										<input id="show_pages-2" name="show_pages" type="radio"  class="ng-pristine ng-untouched ng-valid ng-not-empty" value="2">
										<label for="show_pages-2">Simple</label>
									</div>

									<small>- Rentals Page<br>- Contact Page</small>
								</div><!---->
							</div>
						</div><!---->
					</div>
				</div>
				
				<br>
				<div class="form-group form-group-default required">
<label> HOME PAGE COVER PHOTO TEXT</label>
<input type="text" class="form-control" name="title" placeholder="" >
</div>

</div>
<div class="a">
<div class="col-md-12">





<form enctype="multipart/form-data">
<div class="card " style="background:#e6ebf1">
<div class="card-header " style="background:#f6f9fc!important;height:100%;color:">
<div class="card-title">
Drag n' drop uploader

</div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span></div>

<div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20"  >
 
  <input type="file" name="image" id="image-upload" />
</div>
<div id="image-label_field">
 <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
</div>

</div>

</div>

</div>
<div class="a">
	<div>
		<div class="info-panel">
			<h3 class="panel-label">
				Home Page Text
			</h3>
		
		</div>
		<div class="row p-t-20">
			<div class="col-md-12">
		<div class="form-group form-group-default required">
<label>DETAILS</label>
<textarea class="form-control" id="name"></textarea>
</div>
		</div>
		</div>
		</div>
		
<div class="col-md-12">





<div class="card">
<div class="card-header ">
<div class="card-title">
Drag n' drop uploader
</div>
<div class="tools">
<a class="collapse" href="javascript:;"></a>
<a class="config" data-toggle="modal" href="#grid-config"></a>
<a class="reload" href="javascript:;"></a>
<a class="remove" href="javascript:;"></a>
</div>
</div>
<div class="card-block no-scroll no-padding">
<form action="/new_admin/assets/plugins/dropzone/file-upload" class="dropzone no-margin">
<div class="fallback">
<input name="file" type="file" multiple />
</div>
</form>
</div>
</div>

</div>
		</div>
<div class="a">
<div>
		<div class="info-panel">
			<h3 class="panel-label">
				Home Page Text
			</h3>
		
		</div><br>

<div class="optionBox" id="other_doc_box">
<div class="block1"><div class="row clearfix"><div class="col-md-12"><div class="form-group form-group-default required"><label>Office Name</label><input type="text" class="form-control " name="office_name"></div></div></div><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default required"><label>Street Address</label><input type="text" class="form-control" name="address" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>City</label><input type="text" class="form-control" name="city"></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Country</label><input id="Country" type="text" class="form-control " name="Country" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>State</label><input id="State" type="text" class="form-control " name="dob" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Zipcode</label><input id="Zipcode" type="text" class="form-control " name="Zipcode" ></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT PHONE</label><input type="text" class="form-control" name="phone1" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT PHONE 2</label><input type="text" class="form-control" name="phone2"></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT EMAIL</label><input type="text" class="form-control" name="email1" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT EMAIL 2</label><input type="text" class="form-control" name="email2"></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>FAX</label><input type="text" class="form-control" name="fax" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>
SKYPE</label><input type="text" class="form-control" name="skype"></div></div></div></div></div>
<div class="row clearfix">

</div>

<div class="optionBox" id="landlord_contact_box">
  
 
    <div class="block" id="landlord_contact_block">
        <span class="add" id="add_landlord_contact">+ Add Location</span>
    </div>
</div>
</div>
</div>


	<!-- Dates & labor -->
	<div class="a">
	<div>
		<div class="info-panel">
			<h3 class="panel-label">
				Company Social Media Links
			</h3>
		
		</div>

<br>
		<div class="row">
			<div class="col-md-6">

			<form role="form">
<div class="form-group form-group-default input-group">

<div class="form-input-group">
<label>FACEBOOK URL</label>
<input type="email" class="form-control" >
</div>
<div class="input-group-addon">
<i class="fa fa-facebook" style="font-size:45px"></i>
</div>
</div>
</form>
		
			</div>
			
			<div class="col-md-6">

			<form role="form">
<div class="form-group form-group-default input-group">

<div class="form-input-group">
<label>TWITTER URL</label>
<input type="email" class="form-control">
</div>
<div class="input-group-addon">
<i class="fa fa-twitter" style="font-size:28px"></i>
</div>
</div>
</form>
		
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-6">
<form role="form">
<div class="form-group form-group-default input-group">

<div class="form-input-group">
<label>GOOGLE PLUS URL</label>
<input type="email" class="form-control">
</div>
<div class="input-group-addon">
<i class="	fa fa-google-plus" style="font-size:28px"></i>
</div>
</div>
</form>
		
			</div>
			
			<div class="col-md-6">

			<form role="form">
<div class="form-group form-group-default input-group">

<div class="form-input-group">
<label>LINKEDIN URL</label>
<input type="email" class="form-control" >
</div>
<div class="input-group-addon">
<i class="	fa fa-linkedin" style="font-size:28px"></i>
</div>
</div>
</form>
			
			</div>
		</div>
				
	</div>
	</div>
</fieldset>
<div class="form-footer" style="padding-bottom: 60px;">

<button class="btn btn-default-primary pull-left"  type="submit">Cancel</button>
<button class="btn btn-success pull-right"  type="submit">Save</button>
<button class="btn btn-warning pull-right"  style="margin-right:20px;" type="submit">Preview</button>



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
<script type="text/javascript" src="assets/js/jquery.uploadPreview.min.js"></script>
<script src="assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>



<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>

<script src="assets/js/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  });
});
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