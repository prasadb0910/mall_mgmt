<?php include('header.php');?>
 <style>
            .tile {padding: 0px;
                   min-height: 77px;}
            .list-group-item-reports {
                position: relative; text-decoration:none; color:#555;
                display: block; font-size:13px; font-weight:500;
                padding: 8px 15px; border-top:1px solid #eee;
                margin-bottom: -1px;
                background-color: #fff;
                
            }
            h3 { font-weight: 500; }
            .list-group-item-reports:hover { text-decoration:none;  background-color: #245478; color:#fff;}
            .message-box .mb-container .mb-middle {
                width: 100%; 
                left: 0%;
                position: relative;
                color: #000;
            }
            .message-box .mb-container {
                position: absolute;
                left:31%;
                top: 19%;
                border-radius:2px;
                background: rgba(0, 0, 0, 0.9);
                padding: 20px;
                width: 36%;
            }
            #divCheckAll label { padding-left:5px; font-size:15px;}
            #divCheckAll {
                background-color: #F2F2F2; height:40px;
                border: #e1e1e1 1px solid; 
                padding:8px 10px;
            }
            #divCheckboxList .divCheckboxItem label { padding-left:5px; position:relative; font-weight:500; font-size:13px; } 
            #divCheckboxList { height:185px; z-index:9; overflow-y:scroll; margin-bottom:15px; }
            #divCheckboxList .divCheckboxItem { background:#f9f9f9; padding:6px 0 5px 10px; z-index:0; border-bottom:1px solid #eee;  border-top:1px solid #fff; border-left:1px solid #eee; border-right:1px solid #eee;  }
            #divCheckboxList .divCheckboxItem:nth-child(odd) { background:#fff;}
            .option { font-size:13px; }
            .text-decoration:hover { text-decoration:none; color:#000;}
            a { text-decoration:none;}
            .text-decoration a { text-decoration:none;}
            .selected { background:#f00;}

            @media only screen and (max-width:850px) {
                .message-box .mb-container { position:absolute; left:10%; top:12%; border-radius:2px; background:rgba(0, 0, 0, 0.9); marging:20px; width:80%; }
            }
			.panel.panel-success {

    border: solid 1px #eee!important;
	    border-top: solid 2px #95b75d!important;
	    border-bottom: solid 2px #eee!important;
	    
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
<li class="breadcrumb-item "><a href="#">Reports</a></li>

</ol>
<div class="row">






<div class="col-md-12">

<div class=" container-fluid  p-t-20 p-b-20 container-fixed-lg bg-white" >


 <div class="card card-transparent">
 <div class="row">
 <div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <a href="#" class="mb-control sch text-decoration popuptest" > <h3 class="">Group Level</h3>     </a>     
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="view_reports.php" id="report_1" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Owner wise </a>
                                                <a href="#" id="report_2" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="#" id="report_3" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="#" id="report_4" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Maintenance Property Tax </a>
                                                <a href="#" id="report_5" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_6" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="#" id="report_19" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Details </a>
                                               <!-- <button class="btn btn-default" data-toggle="modal" data-target="#modal_large">Large</button> -->
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
  </div>

    <div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Owner Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_7" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="#" id="report_8" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="#" id="report_9" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_10" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="#" id="report_20" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Details </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
                                    <div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Asset Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_11" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Profitability </a>
                                                <a href="#" id="report_12" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Purchase Variance </a>
                                                <a href="#" id="report_13" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_14" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent </a>
                                                <a href="#" id="report_15" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale </a>
                                                <a href="#" id="report_16" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Variance </a>
                                                <a href="#" id="report_17" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Purchase </a>
                                                <a href="#" id="report_18" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
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

<script type="text/javascript" src="assets/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.uploadPreview.min.js"></script>

<script src="pages/js/pages.min.js"></script>
<script src="assets/js/form_layouts.js" type="text/javascript"></script>
<script src="assets/js/scripts.js" type="text/javascript"></script>

<script src="assets/js/append.js" type="text/javascript"></script>

<script src="assets/js/demo.js" type="text/javascript"></script>

<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>