<?php include("header.php")?>
<link href="assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" media="screen">
<style>
.edit
{
	
	color:#41a541!important;
}
.delete
{
	color:#da5050!important;
}
.print
{
	color:#fe970a!important;
}

.a
{
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
.info
{
	text-align:center;
   
}
.invoice
{
    margin: 10px;
    padding: 0 27px;
    border-radius: 30px;
    font-size: 13px;
}
.btn-group-justified
{
	margin-left:2px;
}
.email
{
	font-size:13px!important;
	
	
	color:#fff!important;
}
.title_1
{
	
	font-size: 1.14286rem!important;
    font-family: inherit!important;
    font-weight: 500!important;
    letter-spacing: 0.02em!important;
    text-transform: capitalize!important;
	color:#fff!important;
}
.contact_card
{
	border-radius:5px!important;
}
.rent
{

color:#fff!important;
	border-right:2px solid #edf0f5;
	    padding: 6px 10px;
		text-align:center;
		color:#40434b;
	border-color: rgba(255,255,255,0.1) !important;	
}
.rent:hover
{
	background-color: rgba(255,255,255,0.1) !important;
}
.leases
{
color:#fff!important;
border-top: 2px solid #edf0f5;
padding: 6px 10px;
text-align:center;
color:#40434b;
border-right:2px solid #edf0f5;
border-color: rgba(255,255,255,0.1) !important;
}

.leases:hover
{
	background-color: rgba(255,255,255,0.1) !important;
}

.badge-notify {
    background: #899be7;
    position: relative;
    top: -88px;

    left: 188px;
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
#money.fa 
{
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
.form-group-default
{
	border:none!important;
}

.form-group-default label
{
	font-weight:1000!important;
}

.thumbnail-wrapper.d32>* {
    line-height: 110px!important;
}
#pricing_box:before
    {
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
	#invoice_box:before
    {
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
	
	.block1
{
	padding: 20px 20px;
    border: 2px solid #edf0f5;
    border-radius: 7px;
    background: #f6f9fc;
	    margin-top: 10px;
    margin-bottom: 10px;
}
p{
    font-weight: 200px!important;
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
<div class="brand inline">

</div>




</div>
<div class="d-flex align-items-center">

<div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
<span class="semi-bold">David</span> <span class="text-master">Nest</span>
</div>
<div class="dropdown pull-right hidden-md-down">
<button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<span class="thumbnail-wrapper d32 circular inline">
<img src="../assets/img/profiles/avatar.jpg" alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg" width="32" height="32">
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

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
<li class="breadcrumb-item"><a href="#">Owner List</a></li>
<li class="breadcrumb-item active"><a href="#">AOP view</a></li>

</ol>

<div class="container">
<div class="row ">

<div class="card card-transparent  bg-white " style="background:#fff;margin-right:16px;">



<div class=" " style="padding:10px;">

<a href="owners.php"><div class="fileUpload blue-btn btn width100 pull-left">
    <span><i class="fa fa-arrow-left"></i></span> 
  </div></a>

<div class="dropdown pull-right hidden-md-down">
<button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

<div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-ellipsis-h"></i></span> 
  </div>

</button>
<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a>
<a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>

</div>
</div>


</div>
</div>


<div class=" col-md-3" style="background:#a5b1de;" >

<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-20" style="background:rgba(0,0,0,0.2);">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #41c997;text-align: center; size:28px;align-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>



</div>

</div>
</div>
</div>

<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="invoice_box" style="background:rgba(0,0,0,0.2);">
<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success  btn-xs invoice" type="submit"><span>New Invoice </span></button></a></span>

</div>
</div>

<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2);">

<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class="col-md-6 rent" style="border-right:none;">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>
<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>


<div class=" col-md-6 leases" style="border-right:none;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 
</div> 





</div>



<div class="col-md-9">

<div class=" container-fluid   container-fixed-lg bg-white">


 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">
<div class="a">

<div class="row clearfix p-t-20" >
<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Property Name:  </label>
<input type="text" class="form-control "  value="1" name="Property Name " id="Property Name" readonly>
</div>
</div>


<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Sub Property Name:</label>
<input type="text" class="form-control "  value="1" name="" id="" readonly>
</div>
</div>
</div>





<div class="row clearfix ">

<div class="col-md-6">

<div class="form-group form-group-default ">
<label>RRR</label>
<input type="text" class="form-control "  value="RRR " id="RRR" readonly>
</div>
</div>

<div class="col-md-6">

<div class="form-group form-group-default ">
<label>RRV</label>
<input type="text" class="form-control "  value="RRV " id="RRV" readonly>
</div>
</div>

</div>


<div class="row clearfix">


<div class="col-md-6">

<div class="form-group form-group-default ">
<label>Cost Of Acquisition</label>
<input type="text" class="form-control "  value="aaa " id="status" readonly>
</div>
</div>

<div class="col-md-6">

<div class="form-group form-group-default ">
<label>Date</label>
<input type="text" class="form-control "  value="9/01/2018 " id="status" readonly>
</div>
</div>

</div>



<div class="row clearfix">

<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Market Rate</label>
<input  type="text" class="form-control " value="111"  readonly >
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Market Value</label>
<input  type="text" class="form-control " value="111" readonly >
</div>
</div>



</div>




<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Tax Applicable</label>
<input type="text" class="form-control " value="Tax Applicable" name="Tax Applicable" readonly>
</div>
</div>
<div class="col-md-6">

<div class="form-group form-group-default ">
<label>Projected Profit Or Loss (In &#x20B9;)</label>
<input type="text" class="form-control " value="tax" name="" readonly>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Maker Remark</label>
<input type="text" class="form-control " value="Maker Remark" name="Maker Remark" readonly>
</div>
</div>
<div class="col-md-6">

<div class="form-group form-group-default ">
<label>Checker Remark</label>
<input type="text" class="form-control " value="Checker Remark" name="" readonly>
</div>
</div>
</div>

</div>


<p><b>Remark</b></p>

<div class="a">

<div class="row clearfix">

<div class="col-md-12">
<div class="form-group form-group-default " style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>Remark</label>
<input type="text" class="form-control " name="Remark" id="Remark" required>
</div>
</div>
</div>

</div>



<div class="form-footer" style="padding-bottom: 60px;">

<button class="btn btn-default-danger pull-left"  type="submit">Cancel</button>
<button class="btn btn-default-danger pull-right"  type="submit">Delete</button>



</div>
</form>

</form>

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

<script type="text/javascript" src="assets/plugins/dropzone/dropzone.min.js"></script>


<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="assets/js/append.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>


<script src="pages/js/pages.min.js"></script>


<script src="assets/js/form_wizard.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>
<script>
		 window.intercomSettings = {
		   app_id: "xt5z6ibr"
		 };
		</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>
