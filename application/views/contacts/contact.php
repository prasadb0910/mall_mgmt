<?php include('header.php')?>
<link href="assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">


<style>

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
<style>
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
    width: 70px;
    height: 70px;
    text-align: left;
	float: none;
    margin: 15px auto;
    display: block;
	
}
.info
{
	text-align:center;
   
}
.invoice
{
	margin:10px;
}
.btn-group-justified
{
	margin-left:2px;
}
.email
{
	font-size:13px!important;
	
	color:#4a65da!important;
}
.title_1
{
	margin-bottom:5px!important;
	font-size: 1.14286rem!important;
    font-family: inherit!important;
    font-weight: 500!important;
    letter-spacing: 0.02em!important;
    text-transform: capitalize!important;
}
.contact_card
{
	border-radius:5px!important;
}
.rent
{
	border-bottom:2px solid #edf0f5;
	border-top:2px solid #edf0f5;
	border-right:2px solid #edf0f5;
	    padding: 6px 10px;
		text-align:center;
		color:#40434b;
		
}
.rent:hover
{
	background-color: #f6f9fc;
}
.leases
{
	border-bottom:2px solid #edf0f5;
	border-top:2px solid #edf0f5;
	    padding: 6px 10px;
		text-align:center;
				color:#40434b;
}

.leases:hover
{
	background-color: #f6f9fc;
}

.badge-notify {
    background: #899be7;
    position: relative;
    top: -88px;

    left: 159px;
    width: 28px;
    height: 28px;
    color: #fff;

    border: 2px solid #ffffff;
    position: absolute;
    top: 8px;

    width: 28px;
    height: 28px;
    border-radius: 50%;
    background-color: #899be7;
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


.user-roommates.empty>p {
   text-align:center;
    font-size: 14px;
    color: #8b92a2;
}
.select2-selection--single 
{
	text-align:left;
}


	
		
		.btn1 {
    border: none;
    outline: none;

    background-color: #f1f5f9;
    cursor: pointer;
    font-size: 18px;
	
	cursor: pointer;
    color: #40434b;
    font-size: 20px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: -webkit-inline-box;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    border-radius: 6px;
    width: 34px;
    height: 34px;
    margin-right: 3px;
    -webkit-transition: background-color 0.235s ease-in;
    transition: background-color 0.235s ease-in;
}

/* Style the active class, and buttons on mouse-over */
.active1, .btn1:hover {
    background-color: #e6ebf1;
 
}
#myDIV
{
	display: -webkit-inline-box;
}

</style>
</head>
<body class="fixed-header ">

<?php include('sidebar.php');?>


<div class="page-container ">

<?php include('main_header.php');?>

<div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
<li class="breadcrumb-item active"><a href="#">Contact List</a></li>

</ol>

<div id="rootwizard">

<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
<li class="nav-item">
<a class="active" data-toggle="tab" href="#tab1" role="tab"><i class="fa fa-shopping-cart tab-icon"></i> <span>TENANTS</span></a>
</li>
<li class="nav-item">
<a class="" data-toggle="tab" href="#tab2" role="tab"><i class="fa fa-truck tab-icon"></i> <span>OWNERS</span></a>
</li>
<li class="nav-item">
<a class="" data-toggle="tab" href="#tab3" role="tab"><i class="fa fa-credit-card tab-icon"></i> <span>Others</span></a>
</li>

<li class="nav-item">
<a class="" data-toggle="tab" href="#tab4" role="tab"><i class="fa fa-credit-card tab-icon"></i> <span>Contact Type</span></a>
</li>

</ul>
<br>



<div class="tab-content"style="background:none;">
<div class="tab-pane sm-no-padding active slide-left" id="tab1">

<div class="row" ><div class="col-md-12"> 

<ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
<li class="nav-item">
<a class="active" data-toggle="tab" role="tab" data-target="#all" href="#">All()</a>
</li>


<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#approved">Approved()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#pending">Pending()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#rejected">Rejected()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#inprocess">IN Process()</a>
</li>

</ul>

<div class="tab-content">
<div class="tab-pane active" id="all">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>


</div>
</div>
</div>
</div>
</div>




<div class="tab-pane" id="approved">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="pending">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="rejected">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="inprocess">
<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


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




<div class="tab-pane  sm-no-padding  slide-left" id="tab2">

<div class="row" ><div class="col-md-12"> 

<ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
<li class="nav-item">
<a class="active" data-toggle="tab" role="tab" data-target="#all" href="#">All()</a>
</li>


<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#approved">Approved()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#pending">Pending()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#rejected">Rejected()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#inprocess">IN Process()</a>
</li>

</ul>

<div class="tab-content">
<div class="tab-pane active" id="all">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>


</div>
</div>
</div>
</div>
</div>




<div class="tab-pane" id="approved">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="pending">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="rejected">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="inprocess">
<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


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
<div class="tab-pane sm-no-padding  slide-left" id="tab3">

<div class="row" ><div class="col-md-12"> 

<ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
<li class="nav-item">
<a class="active" data-toggle="tab" role="tab" data-target="#all" href="#">All()</a>
</li>


<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#approved">Approved()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#pending">Pending()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#rejected">Rejected()</a>
</li>

<li class="nav-item">
<a href="#" data-toggle="tab" role="tab" data-target="#inprocess">IN Process()</a>
</li>

</ul>

<div class="tab-content">
<div class="tab-pane active" id="all">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>


</div>
</div>
</div>
</div>
</div>




<div class="tab-pane" id="approved">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="pending">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="rejected">

<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>



	

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


</div>

</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="inprocess">
<div id="myDIV">
  <button class="btn1 active1" id="grid_btn"><i class="fa fa-th" aria-hidden="true"></i></button>
  <button class="btn1 " id="list_btn"><i class="fa fa-list" aria-hidden="true"></i></button>

</div>




<div class="form-group form-group-default form-group-default-select2 required " style="max-width:33.33%;float:right	">
<label class="">Add Owner</label>
<select class="full-width" data-placeholder="Select Country" onchange="location = this.value;" data-init-plugin="select2" name="type" id="type" style="text:align:left;">

<option value="AK"><a href="">Select</a></option>

<option value="contact_details.php">Individual</option>
<option value="add_new_huf.php">Huf</option>
<option value="add_new_pvtltd.php">Private Limited</option>
<option value="add_new_ltd.php">Limited</option>
<option value="add_new_llp.php">LLP</option>
<option value="add_new_partnership.php">Partnership</option>
<option value="add_new_aop.php">AOP</option>
<option value="add_new_trust.php">Trust</option>
<option value="add_new_proprietorship.php">Proprietorship</option>



</select>
</div>

<br>

<div class="row">


<div class=" col-md-3" >
<div class="grid">
<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12">


<div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>

<div class="info">
<H5 class="title_1">Dhawal Maru</H5>
<p class="email">dhaval.maru@pecanreams.com</p>

</div>
<div class="user-roommates empty">
<p>9632587410</p>
</div>



</div>
</div>



<div class="row" style="padding-left:15px;padding-right:15px;">
<div class="col-md-6 rent">
<i style="font-size:22px;" class="fa fa-money"></i><br>
Rent
</div>

<div class=" col-md-6 leases">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases
</div>

</div> 





<div class=" col-md-12">
<span class="invoice"><a href="input_form.html"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;">View <i class="	fa fa-angle-right tab-icon"></i> </a>
</div>
</div>


</div>
</div>

</div>
<div class="row list">


<div class=" col-md-12" >

<div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
<div class="row">
<div class=" col-md-12" >
<div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
<div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span>DM</span>
</div>  
</div><span class="badge badge-notify" style="left: 74px;"><i class=" fa fa-comments" style="font-size:16px!important;"></i></span>



<div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
<span class="title_1">Dhawal Maru</span><br>
<span class="email">dhaval.maru@pecanreams.com</span>

</div>
<div class="user-roommates empty pull-left" style="margin-top: 25px;padding-left: 200px;">
<p class=" m-t-10">9632587410</p>
</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><i style="font-size:22px;" class="fa fa-money"></i><br>
Rent</div>
<div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
<i style="font-size:22px;" class="fa fa-file-text-o "></i><br>
Leases</div>
<a href="contact_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="	fa fa-angle-right tab-icon"></i> </a>
<span class="invoice"  ><a href="input_form.html"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:200px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>


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


<div class="tab-pane slide-left  sm-no-padding" id="tab4">

<div class=" container-fluid   container-fixed-lg bg-white ">


<div class="card card-transparent">
<form class="form" method="" action="">
<div class="container" style="background:#f6f9fc;margin:10px;">
<div class="row m-t-20 p-t-10">
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Related Party Type</label>
<input type="text" class="form-control " name="Contact Type ">
</div>
</div>
<div class="col-md-2">
<button class="btn btn-default m-t-10" style="float:right;" type="submit"> Save</button>
</div>
</div>
</div>
</form>


<div class="row">
<div class="col-md-12">

<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>Sr No.</th>
<th>Related Party Type</th>
<th>Actions</th>

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
<tr class="odd gradeA">
<td>Trident</td>
<td>Internet Explorer 5.5</td>
<td>Win 95+</td>

 </tr>
 <tr class="odd gradeA">
<td>Trident</td>
<td>Internet Explorer 5.5</td>
<td>Win 95+</td>

 </tr>
 <tr class="odd gradeA">
<td>Trident</td>
<td>Internet Explorer 5.5</td>
<td>Win 95+</td>

 </tr><tr class="odd gradeA">
<td>Trident</td>
<td>Internet Explorer 5.5</td>
<td>Win 95+</td>

 </tr><tr class="odd gradeA">
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

<?php include('footer.php')?>

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

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jszip.min.js"></script>

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
	
        $(document).ready(function() {
			  $('.list').hide();
            $('#grid_btn').on('click', function () {
              
                    $('.grid').show();
                    $('.list').hide();});
					
			$('#list_btn').on('click', function () {
              
                   $('.grid').hide();
                    $('.list').show();
					});
              
               });
    </script>
	<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btn1");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active1");
    current[0].className = current[0].className.replace(" active1", "");
    this.className += " active1";
  });
}
</script>

	
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>