<?php include('header.php');?>

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
<li class="breadcrumb-item "><a href="owners.php">Owner List</a></li>
<li class="breadcrumb-item active">Owner Details -Private Limited</li>
</ol>
<div class="row">
<div class="col-md-4">


<div class="col-lg-12">


<form enctype="multipart/form-data">
<div class="card card-default" style="background:#e6ebf1">
<div class="card-header " style="background:#f6f9fc">
<div class="card-title">
Drag n' drop uploader

</div><span><a href="#"><i class=" fa fa-trash pull-right" style="color:#d63b3b;font-size:18px;"></i></a></span></div>

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

<div class=" container-fluid  p-t-20 container-fixed-lg bg-white" >


 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">

<div class="a">

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Organisation Name </label>
<input type="text" class="form-control " name="Organisation Name" id="Organisation Name" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Registration No</label>
<input type="text" class="form-control " name="Registration No" id="Registration No" required>
</div>
</div>


</div>


<div class="row clearfix">




<div class="col-md-6">

<div class="form-group form-group-default ">
<label>Date of Incorporation</label>
<input id="Date of Incorp" type="text" class="form-control date" name="Date of Incorp " >
</div>
</div>

<div class="col-md-6">

<div class="form-group form-group-default required">
<label>Contact Person </label>
<input type="text" class="form-control " name="Contact Person">
</div>




</div>



</div>




<div class="row clearfix">




<div class="col-md-6">

<div class="form-group form-group-default required">
<label>Address</label>
<input type="text" class="form-control " name="address">
</div>
</div>



<div class="col-md-6">

<div class="form-group form-group-default required">
<label>Landmark </label>
<input type="text" class="form-control " name="landmark">
</div>




</div>
</div>




<div class="row clearfix">


<div class="col-md-6">
<div class="form-group form-group-default required">
<label>State</label>
<input type="text" class="form-control " name="startDate" required>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Country </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

</div>


<div class="row clearfix">



<div class="col-md-6">
<div class="form-group form-group-default required">
<label>City </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Pincode </label>
<input type="text" class="form-control " name="endDate">
</div>
</div>


</div>


<div class="row clearfix">



<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Branch Address </label>
<input type="text" class="form-control " name="Branch Address">
</div>
</div>

<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Telephone No. </label>
<input type="text" class="form-control " name="Telephone No.">
</div>
</div>


</div>

<div class="row clearfix">

<div class="col-md-6">
<div class="form-group form-group-default ">
<label>Mobile No. </label>
<input type="text" class="form-control " name="Mobile No.">
</div>
</div>


</div>
</div>

<div class="a" id="Director">
<p class="m-t-20"><b>Director Details<b></p>


<div class="row clearfix">

</div>

<div class="optionBox" id="director_box">
  
    <div class="block" id="director_block">
        <span class="add" id="add_director">+ Add Director Details.</span>
    </div>
</div>
</div>





<div class="a" id="Shareholder">
<p class="m-t-20"><b>Shareholder Details<b></p>


<div class="row clearfix">

</div>

<div class="optionBox" id="shareholder_box">
  
    <div class="block" id="shareholder_block">
        <span class="add" id="add_shareholder">+ Add Shareholder Details.</span>
    </div>
</div>
</div>




<div class="a" id="kyc-section">
<p class="m-t-20"><b>Document Details<b></p>


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
<div class="block1"><h5>Property Documents</h4><div class="remove" id="property_doc">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
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
        <span class="add" id="add1">+ Add Documents Details.</span>
    </div>
</div>
</div>


<div class="a" id="signatory">
<p class="m-t-20"><b>Authorised Signatory<b></p>


<div class="row clearfix">

</div>

<div class="optionBox" id="signatory_box">
  
    <div class="block" id="signatory_block">
        <span class="add" id="add_signatory">+ Add Authorised Signatory</span>
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



<div class="form-footer" style="padding-bottom: 60px; ">

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
        }
    
        function getAge(){
            var age = null;

            if ($('#dob').val()!=""){
                var day = moment($('#dob').val(), "MM/DD/YYYY");
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


<script>
$('#loan_doc_box').on('click','#loan_doc',function() {
 	$(this).parent().remove();
});
$('#property_doc_box').on('click','#property_doc',function() {
 	$(this).parent().remove();
});

$('#other_doc_box').on('click','#other_doc',function() {
 	$(this).parent().remove();
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