<?php include('header.php');?>


<style>
.nav-tabs.nav-tabs-left~.tab-content
{
	width:100%!important;
}
table.dataTable thead .sorting:after {
    opacity: 0.2; 
    content: ""; 
}
table.dataTable thead .sorting_asc:after {
    content: "";
}
table.dataTable thead .sorting_desc:after {
    content: "";
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
<li class="breadcrumb-item "><a href="bank_list.php"> BANK DETAILS LIST</a></li>
<li class="breadcrumb-item active"> BANK DETAILS</li>
</ol>




<div class="card card-transparent">

<div class="card-block no-padding">
<div class="row">
<div class="col-xl-12">
<div class="card card-transparent flex-row">
<ul class="nav nav-tabs nav-tabs-simple nav-tabs-left bg-white" id="tab-3">
<li class="nav-item">
<a href="#" class="active" data-toggle="tab" data-target="#tab3hellowWorld">Service Settings	
</a>
</li>
<li class="nav-item">
<a href="#" data-toggle="tab" data-target="#tab3FollowUs">City Master	
	
</a>
</li>

</ul>
<div class="tab-content bg-white">
<div class="tab-pane active" id="tab3hellowWorld">

<div class="form-group row required">
<label class="col-md-12 control-label">Services opt for:</label>
<div class="col-md-12">
<div class="radio radio-success">
<input type="radio" value="1" name="kyc" id="male">
<label for="male">Rent Management</label>
<input type="radio" checked="checked"  value="0" name="kyc" id="female">
<label for="female">Property and Rent Management
</label>
</div>
</div>


</div>

<div class="form-group row required">
<label class="col-md-12 control-label">Do you want maker and checker</label>
<div class="col-md-12">
<div class="radio radio-success">
<input type="radio" value="2" name="kyc" id="male">
<label for="male">Yes</label>
<input type="radio" checked="checked"  value="3" name="kyc" id="female">
<label for="female">No</label>
</div>
</div>


</div>
<button class="btn btn-default pull-right m-r-10" type="submit">Save</button>
</div>
<div class="tab-pane " id="tab3FollowUs">

<div class="card card-transparent " >
 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">

<div class="container" style="background:#f6f9fc;margin:10px;padding:20px">
<div class="row">
<div class="col-md-6">
<div class="form-group form-group-default form-group-default-select2 required">
<label class="">State Name</label>
<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="state">
<option value="AK">Select</option>
<option value="AK">Maharashtra</option>
<option value="AK">Rajasthan</option>


</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default required">
<label>City</label>
<input type="text" class="form-control " name="city" required>
</div>
</div>

</div>
<button class="btn btn-default pull-right" type="submit"> Save</button><br>



</div>


</div>


<div class="card-block">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>Sr No.</th>
<th>City</th>
<th>State</th>

</tr>
</thead>
<tbody>
<tr class="odd gradeX">
<td>Trident</td>
<td>Internet Explorer 4.0</td>
<td>Win 95+</td>

</tr>
<tr class="even gradeC">
<td>Trident</td>
<td>Internet Explorer 5.0</td>
<td>Win 95+</td>

</tr>
<tr class="odd gradeA">
<td>Trident</td>
<td>Internet Explorer 5.5</td>
<td>Win 95+</td>

 </tr>

</tbody>
</table>
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


<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jszip.min.js"></script>

<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>



<script src="assets/js/demo.js" type="text/javascript"></script>

<script>
 $(".date").datepicker();

</script>

</html>