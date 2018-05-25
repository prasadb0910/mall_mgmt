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

.div_heading
{
	font-size:16px;
	font-weight:700;
	float:left;
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
 float:left;
}

</style>
<style>

#msform {
    text-align: center;
    position: relative;
    margin-top: 30px;
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0px;
 
    padding: 20px 30px;
    box-sizing: border-box;
    width: 80%;
    margin: 0 10%;

    /*stacking fieldsets above each other*/
    position: relative;
}

/*Hide all except first fieldset*/
#msform fieldset:not(:first-of-type) {
    display: none;
}




/*buttons*/
#msform .action-button {
    width: 100px;
    background: #ee0979;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 25px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button:hover, #msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #ee0979;
}

#msform .action-button-previous {
    width: 100px;
    background: #C5C5F1;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 25px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px;
}

#msform .action-button-previous:hover, #msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
}

/*headings*/
.fs-title {
    font-size: 18px;
    text-transform: uppercase;
    color: #2C3E50;
    margin-bottom: 10px;
    letter-spacing: 2px;
    font-weight: bold;
}

.fs-subtitle {
    font-weight: normal;
    font-size: 13px;
    color: #666;
    margin-bottom: 20px;
}

/*progressbar*/
#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    /*CSS counters to number the steps*/
    counter-reset: step;
}

#progressbar li {
    list-style-type: none;
    /*color: white;*/
    text-transform: uppercase;
    font-size: 9px;
    width: 33.33%;
    float: left;
    position: relative;
    letter-spacing: 1px;
}

#progressbar li:before {
    content: counter(step);
    counter-increment: step;
    width: 24px;
    height: 24px;
    line-height: 26px;
    display: block;
    font-size: 12px;
    color: #333;
    background: white;
    border-radius: 25px;
    margin: 0 auto 10px auto;
}

/*progressbar connectors*/
#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: white;
    position: absolute;
    left: -50%;
    top: 9px;
    z-index: -1; /*put it behind the numbers*/
}

#progressbar li:first-child:after {
    /*connector not needed before the first step*/
    content: none;
}

/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before, #progressbar li.active:after {
    background: #a5b1de;
    color: white;
}


/* Not relevant to this form */
.dme_link {
    margin-top: 30px;
    text-align: center;
}
.dme_link a {
    background: #FFF;
    font-weight: bold;
    color: #ee0979;
    border: 0 none;
    border-radius: 25px;
    cursor: pointer;
    padding: 5px 25px;
    font-size: 12px;
}

.dme_link a:hover, .dme_link a:focus {
    background: #C5C5F1;
    text-decoration: none;
}
.view_table td, .view_table th
{
	border:0px!important;
	text-align:center!important;
}
.view_table tr:nth-child(even) 
{
	background-color: #fff!important;
}
.checkbox label::after
{
	left:0.5px!important;
}	


.select2-container .select2-selection .select2-selection__rendered {

    float: left!important;
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
<li class="breadcrumb-item "><a href="contact.php">Contact List</a></li>
<li class="breadcrumb-item active">Lease</li>
</ol>
<div class="row">
    <div class="col-md-12 ">
        <form id="msform">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active">Property & Tenants</li>
                <li>Extra Fees & Utilities</li>
                <li>Agreement & Documents</li>
            </ul>
            <!-- fieldsets -->
            <fieldset>
              <div class="a">
		<p class="div_heading ">Property Information & Terms</p>
			<br>
			 <div class="row clearfix">

					<div class="col-md-6">
					<div class="form-group form-group-default form-group-default-select2 required">
					<label class="">Property Name</label>
					<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="property_name">
					<option value="AK">Select</option>

					</select>
					</div>
					</div>

					<div class="col-md-6">
					<div class="form-group form-group-default form-group-default-select2 required">
					<label class="">Sub Property</label>
					<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="sub_property_name">
					<option value="AK">Select</option>
					</select>
					</div>
					</div>
					</div>
			 <div class="row clearfix">
					<div class="col-md-3">
					<div class="form-group form-group-default required">
					<label>Start Date</label>
					<input id="start_date" type="text" class="form-control date" name="Start Date" required>
					</div>
					</div>
					<div class="col-md-3">
					<div class="form-group form-group-default required">
					<label>End Date</label>
					<input id="End_date" type="text" class="form-control date" name="End_date" required>
					</div>
					</div>
					
					<div class="col-md-2">
						<div class="form-group form-group-default ">
						<label>Lockin Period</label>
						<input type="text" class="form-control " name="lockin_period" id="lockin_period" placeholder="years">
						</div>
						</div>
						<div class="col-md-2">
						<div class="form-group form-group-default ">
						<label>Notice Period</label>
						<input type="text" class="form-control " name="notice_period" id="notice_period" placeholder="months">
						</div>
						</div>
						<div class="col-md-2">
						<div class="form-group form-group-default ">
						<label>Rent Free Period</label>
						<input type="text" class="form-control " name="rent_free_period" id="rent_free_period" >
						</div>
						</div>				
						</div>
				
						</div>
								
								<div class="a" >
								<p class="div_heading ">Resident</p>
								<br>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2 required">
										<label class="">Select Tenant</label>
										<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenant">
										<option value="AK">Select</option>

										</select>
										</div>
									</div>
								</div>
				
						
				
							<div class="row clearfix"></div>
							<div class="optionBox" id="tenant_box">
							<div class="block" id="tenant_block">
							<span style="float:left;" class="add" id="add_tenant">+ Add</span>
							</div>
							</div>
							</div>
							
								<div class="a" id="ott">
								<p class="div_heading ">Recurring & One Time Transactions</p>
								<br>
								<div class="row clearfix">
									<div class="col-md-3">
										<div class="form-group form-group-default form-group-default-select2 required">
										<label class="">Select Category</label>
										<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenant">
										<option value="Rent">Rent	</option>

										</select>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group form-group-default ">
										<label>Amount</label>
										<input type="text" class="form-control " name="amount" id="amount" placeholder="">
									</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group form-group-default form-group-default-select2 required">
										<label class="">Invoice Schedule</label>
										<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenant">
										<option value="Monthly">Monthly</option>

										</select>
										</div>
									</div>
									
									<div class="col-md-3">
										<div class="form-group form-group-default ">
										<label>First Invoice Date<label>
										<input id="invoice_date" type="text" class="form-control date" name="invoice_date " >
										</div>
									</div>
									
								</div>
							
								
								
									<div class="row clearfix">
									
										<div class="col-md-3">
										<div class="form-group form-group-default ">
										<label>Due Day</label>
										<input type="text" class="form-control " name="due" id="due" placeholder="">
										</div>
										</div>
									
									<div class="col-md-3">
									<div class="form-group form-group-default input-group">
										<div class="form-input-group">
										<label class="inline">GST?</label>
										<input type="text" class="form-control " value="Yes  " placeholder="" style="text-align:center;">
										</div>
										<div class="input-group-addon bg-transparent h-c-50">
										<input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />
										</div>
										</div>
												
									</div>
									
									<div class="col-md-3">
									<div class="form-group form-group-default input-group">
										<div class="form-input-group">
										<label class="inline">TDS?</label>
										<input type="text" class="form-control " value="yes" placeholder="" style="text-align:center;">
										</div>
										<div class="input-group-addon bg-transparent h-c-50">
										<input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />
										</div>
										</div>
												
									</div>
									
									<div class="col-md-3">
										<div class="form-group form-group-default input-group">
										<div class="form-input-group">
										<label class="inline">PDC?</label>
										<input type="text" class="form-control " value="yes" placeholder="" style="text-align:center;">
										</div>
										<div class="input-group-addon bg-transparent h-c-50">
										<input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" />
										</div>
										</div>
									</div>
									
								</div>
								  <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Yes Add PDCs</button>
								  
								   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Schedule</h4>
        </div>
        <div class="modal-body">
       <div class="row clearfix">
<div class="col-md-12">
<table class="view_table">
<thead>
<tr>
<th>Sr No.</th>
<th>Date</th>
<th>Particulars</th>
<th>Amount</th>
<th>Gst</th>
<th>TDS</th>
<th>Net Amount</th>
<th>Cheque no</th>
<th>Bank Name & Branch</th>


</tr>
</thead>
<tbody>

<tr class="odd gradeX">

<td>1</td>

<td><div class="form-group form-group-default">
<input id="dob" type="text" class="form-control date" name="" >
</div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>

<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>
<td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td>

</tr>


<tr class="odd gradeX">

</tr>


</tbody>
<tbody id="rent_schedule_box" >
  
  <tr class="odd gradeX">

</tr>
    <tr class="block" id="rent_schedule_block">
        <span class="add" id="add_rent_schedule">+ Add</span>
    </tr>

</tbody>

</table>

</div>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
          <button type="button" class="btn btn-default-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
								  
								  <br>
								</div>
								
									<div class="a" >
								<p class="div_heading ">Deposits</p>
								<br>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2 required">
										<label class="">Select Category	</label>
										<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenant">
										<option value="AK">Select</option>

										</select>
										</div>
									</div>
									
										<div class="col-md-6">
										<div class="form-group form-group-default ">
										<label>Amount</label>
										<input type="text" class="form-control " name="amount" id="amount" placeholder="">
									</div>
									</div>
									
								</div>
				
							</div>
							
								
									<div class="a" >
								<p class="div_heading ">Y-o-Y</p>
								<br>
								<div class="row clearfix">
									<div class="col-md-6">
										<div class="form-group form-group-default form-group-default-select2 required">
										<label class="">Select Year	</label>
										<select class="full-width" data-placeholder="Select Country" data-init-plugin="select2" name="tenant">
										<option value="select">select</option>
										<option value="2017">2017</option>
										<option value="2016">2016</option>
										<option value="2018">2018</option>

										</select>
										</div>
									</div>
								
										<div class="col-md-6">
										<div class="form-group form-group-default ">
										<label>Escalation %	</label>
										<input type="text" class="form-control " name="escalation" id="escalation" placeholder="">
										</div>
										</div>
									
									
									
								</div>
				
							</div>
									  
						          <input type="button" name="next" class="btn btn-success next" value="Next"/>  
			
            </fieldset>
			<fieldset>
						   
							<div class="a" >
							<p class="div_heading">Utilities</p>
							<table class="view_table">
							<thead>
							<tr>
							<th></th>
							<th>Landlord</th>
							<th>Tenant</th>
							<th>N/A</th>

							</tr>
							</thead>
							<tbody>
							<tr class="">
							<td>CAM</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox1"><label for="checkbox1"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox2"><label for="checkbox2"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox3"><label for="checkbox3"></label></div>
							</td>

							</tr>

							<tr class="">
							<td>Property Tax</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox4"><label for="checkbox4"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox5"><label for="checkbox5"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox6"><label for="checkbox6"></label></div>
							</td>

							</tr>
							
							
							<tr class="">
							<td>Cable/Satellite
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox7"><label for="checkbox7"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox8"><label for="checkbox8"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox9"><label for="checkbox9"></label></div>
							</td>

							</tr>
							
							
							<tr class="">
							<td>Electricity
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox10"><label for="checkbox10"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox11"><label for="checkbox11"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox12"><label for="checkbox12"></label></div>
							</td>

							</tr>
							
								<tr class="">
							<td>Gas
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox13"><label for="checkbox13"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox14"><label for="checkbox14"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox15"><label for="checkbox15"></label></div>
							</td>

							</tr>
							
							
								<tr class="">
							<td>PT
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox16"><label for="checkbox16"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox17"><label for="checkbox17"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox18"><label for="checkbox18"></label></div>
							</td>

							</tr>
							
							
							
								<tr class="">
							<td>Cable & Communication Services
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox19"><label for="checkbox19"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox20"><label for="checkbox20"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox21"><label for="checkbox21"></label></div>
							</td>

							</tr>
							
							
								<tr class="">
							<td>Internet

							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox22"><label for="checkbox22"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox23"><label for="checkbox23"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox24"><label for="checkbox24"></label></div>
							</td>

							</tr>
							
							
								<tr class="">
							<td>Water and Sewer

							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox25"><label for="checkbox25"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox26"><label for="checkbox26"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox27"><label for="checkbox27"></label></div>
							</td>

							</tr>
							
							
								<tr class="">
							<td>Parking

							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox28"><label for="checkbox28"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox29"><label for="checkbox29"></label>
							</div>
							</td>
							<td>
							<div class="checkbox check-success"><input type="checkbox" checked="checked" value="1" id="checkbox30"><label for="checkbox30"></label></div>
							</td>

							</tr>


							</tbody>
							</table>
							    </div>
								<div class="a" >
								<p class="div_heading">Email Notifications</p>
								
								<table class="view_table">
							<thead>
							<tr>
							<th></th>
							<th>Owners</th>
							<th>Tenant</th>
						

							</tr>
							</thead>
							<tbody>
							<tr class="">
							<td>Invoice is Posted</td>
							<td>
							Yes/No
							</td>
							<td>
							Yes/No
							</td>
							</tr>
							
								<tr class="">
							<td>Invoice is Due</td>
							<td>
							Yes/No
							</td>
							<td>
							Yes/No
							</td>
							</tr>
							
								<tr class="">
							<td>Invoice is Expired</td>
							<td>
							Yes/No
							</td>
							<td>
							Yes/No
							</td>
							</tr>
							
								<tr class="">
							<td>Invoice is Posted</td>
							<td>
							Yes/No
							</td>
							<td>
							Yes/No
							</td>
							</tr>
							
							
									</tbody>		
									</table>
							    </div>
								 <input type="button" name="" class="btn btn-danger" value="Remove Lease"/>   
						 <input type="button" name="previous" class="btn btn-warning previous" value="Previous"/>
                <input type="button" name="next" class="btn btn-success next" value="Next"/>   
               
						   
			</fieldset>
            <fieldset>
                
				<div class="a">
<p class="div_heading">Document Details</p><br>


<div class="block1"><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">select</option><option value="AK">select</option><option value="AK">select</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="row clearfix"><div class="col-md-4"> <div class="fileUpload blue-btn btn width100">
    <span><i class="fa fa-cloud-upload"></i></span>
    <input type="file" class="uploadlogo" />
  </div></div></div>
  </div>
  
  <div class="row clearfix">

</div>

<div class="optionBox" id="optionBox1">
  
 
    <div class="block" id="block2">
        <span class="add" id="add1">+ Add doc Details.</span>
    </div>
</div>
  </div>
			

<p class="div_heading">Remark</p>
<br>
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
			
				<input type="button" name="" class="btn btn-danger" value="Remove Lease"/>   
				<input type="button" name="previous" class="btn btn-warning previous" value="Previous"/>
				<input type="submit" name="submit" class="btn btn-success submit" value="Save"/> 
	
               
            </fieldset>
        </form>
        <!-- link to designify.me code snippets -->
        
        <!-- /.link to designify.me code snippets -->
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
	
	
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})
	
	</script>
	
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>

 


</body>
</html>