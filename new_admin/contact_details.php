<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Pages - Admin Dashboard UI Kit - Form Layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
<link rel="apple-touch-icon" href="pages/ico/60.png">
<link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
<link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
<link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta content="" name="description" />
<meta content="" name="author" />
<link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
<link href="assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
<link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
<style>
#filelist {
    margin-top: 15px;
}

#uploadFilesButtonContainer, #selectFilesButtonContainer, #overallProgress {
    display: inline-block;
}

#overallProgress {
    float: right;
}

.yellowBackground {
  background: #F2E699;
}
</style>
<style>
.a
{
border-bottom: 2px solid #edf0f5;
margin-bottom: 25px;
padding-bottom: 25px;
}
</style>
<style type="text/css">
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
cursor: pointer;
	    margin-bottom: 10px;
		font-size:14px;
		font-weight:500;
}
.block1
{
	padding: 5px 20px;
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

<?php include("sidebar.php");?>



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
<li class="breadcrumb-item "><a href="contact.php">Contact List</a></li>
<li class="breadcrumb-item active">Contact Details</li>
</ol>
<div class="row">
<div class="col-md-4">


<div class="col-lg-12">


<form enctype="multipart/form-data">
<div class="card card-default" style="background:#e6ebf1">
<div class="card-header " style="background:#f6f9fc">
<div class="card-title">
Drag n' drop uploader

</div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span></div>

<div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20">
 
  <input type="file" name="image" id="image-upload" />
</div>
<div id="image-label_field">
 <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
</div>

</div>
</div>
</div>





<div class="col-md-8">

<div class=" container-fluid   container-fixed-lg bg-white">


 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">
<p class="m-t-20"><b>Personal Details</b></p>
<div class="a">

<div class="row clearfix">
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>First Name</label>
<input type="text" class="form-control " name="c_name" id="c_name" required>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Middle Name</label>
<input type="text" class="form-control " name="c_middle_name" id="c_middle_name">
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Last Name</label>
<input type="text" class="form-control " name="c_last_name" id="c_last_name" >
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Select Type</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="type" id="type">

<option value="AK">Select</option>
<option value="AK">Others</option>
<option value="HI">Legal Entity</option>


</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Concerned Person Name</label>
<input type="text" class="form-control " name="Concerned Person Name">
</div>
</div>

</div>

<div class="row clearfix">


<div class="col-md-6">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Related Party Type</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2">
<option value="AK">Select</option>


</select>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>PAN Card No</label>
<input type="text" class="form-control" name="PAN Card No" required>
</div>
</div>




</div>


<div class="row clearfix">


<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Date Of Birth</label>
<input id="dob" type="text" class="form-control date" name="dob" required>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Anniversary Date</label>
<input id="anniversary_date" type="text" class="form-control date" name="anniversary_date" required>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">Gender</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2">
<option value="AK">Select</option>
<option value="AK">Male</option>
<option value="AK">Female</option>


</select>
</div>
</div>


</div>
<div class="guardian" style="display:none;">
<div class="row clearfix">

<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Guardian</label>
<input type="text" class="form-control " name="guardian" id="guardian" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Relation</label>
<input type="text" class="form-control " name="guardian_relation" id="guardian_relation">
</div>
</div>
</div>

</div>

<div class="row clearfix">
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Designation</label>
<input type="text" class="form-control " name="designation" required>
</div>
</div>
<div class="col-md-8">
<div class="form-group form-group-default required">
<label>Address</label>
<input type="text" class="form-control " name="address">
</div>
</div>


</div>


<div class="row clearfix">

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Landmark </label>
<input type="text" class="form-control " name="landmark">
</div>
</div>


<div class="col-md-4">
<div class="form-group form-group-default required">
<label>City </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Pincode </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

</div>


<div class="row clearfix">

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>State</label>
<input type="text" class="form-control " name="startDate" required>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Country </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Email ID - 1 </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

</div>

<div class="row clearfix">

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Email ID - 2</label>
<input type="text" class="form-control " name="startDate" required>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Mobile No - 1 </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default required">
<label>Mobile No - 2 </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

</div>
<div class="col-md-12">
<div class="form-group row required">
<label class="col-md-12 control-label">KYC Required?</label>
<div class="col-md-12">
<div class="radio radio-success">
<input type="radio" value="1" name="kyc" id="male">
<label for="male">Yes</label>
<input type="radio" checked="checked"  value="0" name="kyc" id="female">
<label for="female">No</label>
</div>
</div>


</div>
</div>

</div>



<div class="a" id="kyc-section">
<p class="m-t-20"><b>KYC Details<b></p>


<div class="block1"><h5>ID Proof</h4><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div></div></div></div>



<div class="block1"><h5>Address Proof</h4><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div></div></div>
</div>

<div class="optionBox" id="loan_doc_box">
<div class="block1"><h5>Loan Documents</h4><div class="remove" id="loan_doc">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> 
 <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div>
  </div></div></div></div>

<div class="optionBox" id="property_doc_box">
<div class="block1"><h5>Property Documents</h4><div class="remove" id="property_doc">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="select">select</option><option value="select">select</option><option value="select">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div></div></div></div></div>

<div class="optionBox" id="other_doc_box">
<div class="block1"><h5>Other Documents</h4><div class="remove" id="other_doc">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div></div></div></div></div>

<div class="row clearfix">

</div>

<div class="optionBox" id="optionBox1">
  
 
    <div class="block" id="block2">
        <span class="add" id="add1">+ Add KYC Details.</span>
    </div>
</div>
</div>

<div class="a" id="nominee-section">
<p class="m-t-20"><b>Nominee Details<b></p>


<div class="row clearfix">

</div>

<div class="optionBox" id="optionBox">
  
    <div class="block" id="block">
        <span class="add" id="add">+ Add Nominee Details.</span>
    </div>
</div>
</div>


<p><b>Remark</b></p>

<div class="a">

<div class="row clearfix">

<div class="col-md-12">
<div class="form-group form-group-default required">
<label>Remark</label>
<input type="text" class="form-control " name="Remark">
</div>
</div>
</div>

</div>




<div class="form-footer" style="padding-bottom: 60px;">

<button class="btn btn-default-danger pull-left"  type="submit">Cancel</button>
<button class="btn btn-default pull-right"  type="submit">Submit</button>
<button class="btn btn-default pull-right m-r-10" type="submit">Save</button>


</div>
</form>
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

<script type="text/javascript" src="assets/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.uploadPreview.min.js"></script>

<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="assets/js/append.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	
  $.uploadPreview({
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  });
});
</script>
<script>
 $('#img_delete').click(function(){
        $("#image-upload").remove();
    });
</script>
<script>
 $(".date").datepicker();

</script>
<script type="text/javascript">
   $(document).ready(function() {
	   
 $('#dob').change(function(){ 
	checkdob();});
 });
 </script>
 <script type="text/javascript">
            function checkdob(){
            var age = getAge();
            if(age<18 && age !=null){
                $('.guardian').show();
            }
            else{
                $('.guardian').hide();
                $('#guardian').val('');
                $('#guardian_relation').val('');
            }
			return age;
        }
    
        function getAge(){
            var age = null;

            if ($('#dob').val()!=""){
                var day = moment($('#dob').val(), "dd/mm/yyyy");
                var dob = new Date(day);
                var today = new Date();
                age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
            }
            
            return age;
        }
         
    </script>
    <script>
	
        $(document).ready(function() {
			 
            $('input[type=radio][name=kyc]').on('change', function () {
				
                if (this.value == '1') {
                    $('#nominee-section').show();
                    $('#kyc-section').show();
                }
                else if (this.value == '0') {
                    $('#kyc-section').hide();
                    //$('#nominee-section').hide();
                }
            });});
    </script>


<script type="text/javascript">
  $(window).load(function(){
$('#loan_doc_box').on('click','#loan_doc',function() {
 	$(this).parent().remove();
});
$('#property_doc_box').on('click','#property_doc',function() {
 	$(this).parent().remove();
});

$('#other_doc_box').on('click','#other_doc',function() {
 	$(this).parent().remove();
});
});
</script>
<script>

	$('#type').change(function(){
				if($('#type').val() == 'Others') {
					$('.others-validation').hide();
					$('.others-hide').hide();
					$('.company-hide').show();
                    $('#contact_type_div').show();

                    $('#dob').val('');
                    $('#date_of_anniversary').val('');
                    checkdob();

                    $('#full_name_label').html('Name');
                    $('#c_middle_name').hide();
                    $('#c_last_name').hide();
                    $('#owner_type').show();
                    $('#c_name').attr("placeholder", "Name");

				} else {
					$('.others-validation').show();
					$('.others-hide').show();
                    $('.company-hide').hide();
                    $('#contact_type_div').hide();

                    $('#company').val('');
                    $('#contact_type').val('');
                    $('#pan_card').val('');
                    checkdob();

                    $('#full_name_label').html('Full Name');
                    $('#c_middle_name').show();
                    $('#c_last_name').show();
                    $('#owner_type').hide();
                    $('#c_name').attr("placeholder", "First Name");
				}
			});



</script>
<script>

		 window.intercomSettings = {
		   app_id: "xt5z6ibr"
		 };
		</script>
		<script>
		$(document).ready(function($) {

  // Upload btn on change call function
  $(".uploadlogo").change(function() {
    var filename = readURL(this);
    $(this).parent().children('span').html(filename);
  });

  // Read File and return value  
  function readURL(input) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (
      ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "gif" || ext == "pdf"
      )) {
      var path = $(input).val();
      var filename = path.replace(/^.*\\/, "");
      // $('.fileUpload span').html('Uploaded Proof : ' + filename);
      return ""+filename;
    } else {
      $(input).val("");
      return "Only image/pdf formats are allowed!";
    }
  }
  // Upload btn end

});
		
	</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>