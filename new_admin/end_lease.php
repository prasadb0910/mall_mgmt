<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Pages - Admin Dashboard UI Kit - Form Wizard</title>
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
<link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
<link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
<link href="assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
<link href="assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
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


.form-group-default label
{
	font-weight:1000!important;
}
.slider:after {
   content:"Off";
} 
.slider:before {
   content:"On";
}
#prop_info .form-group-default

{
	border:none!important;
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

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="contact.php">Contact List</a></li>
<li class="breadcrumb-item active"><a href="#">Contact View</a></li>

</ol>

<div class="container">
<div class="row m-t-20">
<div class="col-md-12">
<div class="card card-transparent  bg-white m-t-20" style="background:#fff;margin-right:16px;">



<div class=" " style="padding:10px;">

<a href="contact.php"><div class="fileUpload blue-btn btn width100 pull-left">
    <span><i class="fa fa-arrow-left"></i> Tenant</span> 
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
</div>






<div class="col-md-12">

<div class=" container-fluid   container-fixed-lg bg-white">


 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">
<p class="m-t-20"><b>END LEASE PROCESS</b></p>
<div class="a" id="prop_info">

<div class="row clearfix">
<div class="col-md-4">
<div class="form-group form-group-default ">
<label>Property</label>
<input type="text" class="form-control "  value="Green Acres 2" name="" id="" readonly>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default ">
<label>Lease Type</label>
<input type="text" class="form-control "  value=" Fixed" name="" id="" readonly>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default ">
<label>Start Date</label>
<input type="text" class="form-control "  value="05-01-2018" name="" id="" readonly>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-md-4">
<div class="form-group form-group-default ">
<label>Unit</label>
<input type="text" class="form-control "  value="1" name="" id="" readonly>
</div>
</div>
<div class="col-md-4">
<div class="form-group form-group-default ">
<label>Lease Invoicing</label>
<input type="text" class="form-control "  value="Seperated" name="" id="" readonly>
</div>
</div>

<div class="col-md-4">
<div class="form-group form-group-default ">
<label>End Date</label>
<input type="text" class="form-control "  value="05-01-2019" name="" id="" readonly>
</div>
</div>
</div>


</div>

<div class="a">
<p class="m-t-20"><b> UNPAID INVOICES 
</b></p>
<div class="row clearfix">
<div class="col-md-12">
<table class="view_table" border="1px;" style="width:100%;">
<thead>
<tr>
<th>Category - Category of receivable and month of booking income</th>
<th>Total - Total amount to be received</th>
<th>Received till date</th>
<th>Pending</th>
<th>Deposit - Want to deduct from deposit?</th>
<th>Source</th>
<th>Date Paid</th>
<th>Amount</th>


</tr>
</thead>
<tbody>
<tr class="odd gradeX">
<td>Rent - Jan 18			</td>
<td>Rs. 20,000</td>
<td>Rs. 0</td>
<td>Rs. 20,000</td>
<td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />  <div class="slider"></div></td>
<td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />  <div class="slider"></div></td>
<td><div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>DATE PAID</label>
<input id="date" type="text" class="form-control date" name="date" required>
</div></td>
<td><div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>Amount</label>
<input id="amount" type="text" class="form-control " name="amount" >
</div></td>

</tr>



</tbody>
</table>
<button class="btn btn-success m-t-20 pull-right" type="submit">record as paid</button>
</div>

</div>

</div>


<div class="a">
<p class="m-t-20"><b>     RETURN DEPOSIT
</b></p>
<div class="row clearfix">
<div class="col-md-12">
<table class="view_table" border="1px;" style="width:100%;">
<thead>
<tr>
<th>Category</th>
<th>Available Amount - Deposit amount if pending rent is to be deducted from deposit than this amount will be reduced				</th>
<th>Refund Date	</th>
<th>Amount To Refund</th>


</tr>
</thead>
<tbody>
<tr class="odd gradeX">
<td>Deposit</td>
<td>Rs. 1,00,000</td>
<td><div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>Refund Date</label>
<input id="date" type="text" class="form-control date" name="date" required>
</div></td>
<td><div class="form-group form-group-default" style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>Amount</label>
<input id="amount" type="text" class="form-control " name="amount" >
</div></td>


</tr>



</tbody>
</table>
<button class="btn btn-success m-t-20 pull-right" type="submit">record return</button>
</div>

</div>

</div>
<div class="row clearfix">
<div class="col-md-6"><button class="btn btn-default-danger pull-left"  type="submit">Cancel</button></div>

<div class="col-md-4">
<div class="form-group form-group-default pull-right" style="border:1px solid rgba(0,0,0,0.07)!important; ">
<label>Date Of Birth</label>
<input id="dob" type="text" class="form-control date" name="dob" required>
</div>
</div>

<div class="col-md-2"><button class="btn btn-danger pull-right"  type="submit">END THE LEASE	</button></div>
</div>
</div>
</div>
</div>

</form>

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
<script type="text/javascript" src="assets/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="assets/plugins/classie/classie.js"></script>
<script src="assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-autonumeric/autoNumeric.js"></script>
<script type="text/javascript" src="assets/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-inputmask/jquery.inputmask.min.js"></script>
<script src="assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="assets/plugins/summernote/js/summernote.min.js" type="text/javascript"></script>
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>


<script src="pages/js/pages.min.js"></script>


<script src="assets/js/form_wizard.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>
<script>
		 window.intercomSettings = {
		   app_id: "xt5z6ibr"
		 };
		</script>
		<script>
 $(".date").datepicker();

</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>