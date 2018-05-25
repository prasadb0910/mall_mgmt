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
.view_table td
{
	border:none!important;
}
.table_head2
{
	background:#fafcfd!important;
}
.total_amt {
    text-align: center;
    display:inline-flex;
    padding: 0px 40px;
    margin-bottom: 20px;
    background-color: #f6f9fc;
    border: 1px solid #edf0f5;
}
.total_amt>h5
{
	    padding-right: 10px;
		    font-size: 14px;
    font-weight: 600;
}
</style>
</head>
<body class="fixed-header ">


<?php include('sidebar.php');?>

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

<li class="breadcrumb-item active">Add Income</li>
</ol>
<div class="row">






<div class="col-md-12">

<div class=" container-fluid  p-t-20 container-fixed-lg bg-white" >


 <div class="card card-transparent">

<form id="form-personal" role="form" autocomplete="off">

<div class="a">

<div class="row clearfix">
	<div class="col-md-4">
					<div class="form-group form-group-default form-group-default-select2 required">
					<label class=""> PAYER / PAYEE </label>
					<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="payee">
					<option value="AK">Select</option>

					</select>
					</div>
	</div>

	<div class="col-md-4">
					<div class="form-group form-group-default form-group-default-select2 required">
					<label class="">Property</label>
					<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="property">
					<option value="AK">Select</option>

					</select>
					</div>
	</div>
	
	<div class="col-md-4">
					<div class="form-group form-group-default form-group-default-select2 required">
					<label class="">Unit</label>
					<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="unit_name">
					<option value="AK">Select</option>

					</select>
					</div>
	</div>



</div>
</div>

<div class="a">
<p class="m-t-20"><b>Partnership Details</b></p>
<div class="row clearfix">
<table class="view_table">
<thead>
<tr>
<th>Due On</th>
<th>Paid date</th>
<th> Category </th>
<th>Amount</th>
<th>GST</th>
<th>GST Amount (if yes)</th>
<th>Total</th>
<th></th>



</tr>
</thead>
<tbody class="income_dtl">
<tr class="table_head2 ">
<td><div class="form-group form-group-default ">
<label>Due Date</label>
<input id="due_date" type="text" class="form-control date" name="Due Date " >
</div></td>
<td><div class="form-group form-group-default ">
<label>Paid  Date</label>
<input id="paid _date" type="text" class="form-control date" name="Paid Date " >
</div></td>
<td> 	
	<div class="form-group form-group-default form-group-default-select2 required">
						<label class=""> Category</label>
						<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="Category">
						<option value="AK">Select Category</option>

						</select>
	</div>
</td>
<td>18,000</td>
<td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" /></td>
<td>1,000</td>
<td>19,000</td>
<td class="delete"><i class="fa fa-trash" aria-hidden="true"></i></td>

</tr>

<tr class="odd gradeX">
	<td><div class="form-group form-group-default form-group-default-select2 required">
						<label class=""> BANK NAME</label>
						<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="Category">
						<option value="AK">Select</option>

						</select>
	</div></td>



	<td colspan="2">
	<div class="form-group form-group-default ">
	<label>Description</label>
	<input id="" type="text" class="form-control " name="description " >
	</div>
	</td>
	<td colspan="6"></td>
	</tr>

<tr class="row clearfix">

</tr>

<tbody id="income_box" >
  
 
    <tr class="block" id="income_block">

	
        <td class="add" id="add_income">+ Add</td>
	

    </tr>



</tbody>
</tbody>
</table>

</div>
</div>

<div class="row clearfix">
	<div class="col-md-10">
	</div>
	

	
	<div class="col-md-2">
	<div class="total_amt" >

	<h5>Total</h5>
	<h1>₹0</h1>
	</div>
					

</div>
</div>

<div class="form-footer" style="padding-bottom: 60px;">

<button class="btn btn-default-primary pull-left"  type="submit">Cancel</button>
<button class="btn btn-success pull-right"  type="submit">mark as received</button>
<button class="btn btn-warning pull-right m-r-10" type="submit">Create Invoice</button>


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
	
	
	<script>
$(document).ready(function(){
    $(".delete_img").click(function(){
        $("#image-preview").remove();
    });
});
</script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>