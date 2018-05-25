
$('#add').click(function() {
    $('#block:last').before('<div class="block"><div class="row clearfix"><div class="col-md-2"><div class="form-group form-group-default "><label>Sr No.</label><input type="text" class="form-control" name="id" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Name</label><input type="text" class="form-control" name="name" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Relation</label><input type="text" class="form-control" name="Relation" required></div></div><div class="delete" id="delete"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#optionBox').on('click','#delete',function() {
 	$(this).parent().remove();
});

$('#add_shareholder').click(function() {
    $('#shareholder_block').before('<div class="shareholder_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>Shareholder Name.</label><input type="text" class="form-control" name="Shareholder Name" ></div></div><div class="col-md-3"><div class="form-group form-group-default required"><label>Shareholder %</label><input type="text" class="form-control" name="Shareholder%" required></div></div><div class="col-md-3"><div class="form-group form-group-default required"><label>No. of Shares</label><input type="text" class="form-control" name="no_of_relation" required></div></div><div class="delete" id="delete_shareholder"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#shareholder_box').on('click','#delete_shareholder',function() {
 	$(this).parent().remove();
});


$('#add_director').click(function() {
  $('#director_block').before('<div class="director_block"><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default "><label>Director Name</label><input type="text" class="form-control" name="Director Name" ></div></div><div class="delete" id="delete_director"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#director_box').on('click','#delete_director',function() {
 	$(this).parent().remove();
});

$('#add_trustee').click(function() {
  $('#trustee_block').before('<div class="owner_block"><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default "><label>Trustee Name</label><input type="text" class="form-control" name="Trustee Name" ></div></div><div class="delete" id="delete_trustee"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#trustee_box').on('click','#delete_trustee',function() {
 	$(this).parent().remove();
});


$('#add_beneficiary').click(function() {
  $('#beneficiary_block').before('<div class="beneficiary_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>beneficiary</label><input type="text" class="form-control" name="Partner Name" ></div></div><div class="col-md-5"><div class="form-group form-group-default "><label>Shareholder%</label><input type="text" class="form-control" name="shareholder%" ></div></div><div class="delete" id="delete_beneficiary"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#beneficiary_box').on('click','#delete_beneficiary',function() {
 	$(this).parent().remove();
});




$('#add_partner').click(function() {
  $('#partner_block').before('<div class="partner_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>Partner Name</label><input type="text" class="form-control" name="Partner Name" ></div></div><div class="col-md-5"><div class="form-group form-group-default "><label>Partnership%</label><input type="text" class="form-control" name="partnership%" ></div></div><div class="delete" id="delete_partner"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#partner_box').on('click','#delete_partner',function() {
 	$(this).parent().remove();
});


$('#add_signatory').click(function() {
    $('#signatory_block').before('<div class="signatory_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>Authorised Signatory </label><input type="text" class="form-control" name="authorised_signatory 1" required></div></div><div class="col-md-5"><div class="form-group form-group-default required"><label>Purchase of AS</label><input type="text" class="form-control" name="Purchase of AS" required></div></div><div class="delete" id="delete_signatory"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#signatory_box').on('click','#delete_signatory',function() {
 	$(this).parent().remove();
});


$('#add_bank_signatory').click(function() {
    $('#bank_signatory_block').before('<div class="bank_signatory_block"><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default "><label>Authorised Signatory </label><input type="text" class="form-control" name="bank_signatory" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Purchase of AS</label><input type="text" class="form-control" name="bank_Purchase_of_AS" required></div></div><div class="col-md-3"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select</label><select class="full-width select2"  data-init-plugin="select2"><option value="AK">sole</option><option value="AK">joint</option></Select></div></div><div class="delete" id="delete_bank_signatory"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	$('.select2').select2();
	
});
$('#bank_signatory_box').on('click','#delete_bank_signatory',function() {
 	$(this).parent().remove();
});






$('#add1').click(function() {
    //$('.select2').select2('destroy');
	$('#block2').before
	('<div class="block1"><div class="remove" id="remove1">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">Select</option><option value="AK">Select</option><option value="AK">Select</option></Select></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Description.</label><input type="text" class="form-control" name="Description." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Refernce No..</label><input type="text" class="form-control" name="Refernce No." required></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Issue</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Date Of Expiry</label><input id="start-date" type="text" class="form-control date" name="dob" required></div></div></div><p class="attachments">Attachments</p><div class="col-md-4"> <div class="fileUpload blue-btn btn width100"><span><i class="fa fa-cloud-upload"></i></span><input type="file" class="uploadlogo" /></div></div></div>');
	
	$('.select2').select2();
  $(".date").datepicker();


	
});
$('#optionBox1').on('click','#remove1',function() {
 	$(this).parent().remove();
});


$('#add_assign').click(function() {
  $('#assign_block').before('<div class="assign_block"><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default "><label>Assign To</label><input type="text" class="form-control" name="assign_to" placeholder="Type to choose contact" ></div></div><div class="delete" id="delete_assign"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#assign_box').on('click','#delete_assign',function() {
 	$(this).parent().remove();
});


$('#add_follower').click(function() {
  $('#follower_block').before('<div class="follower_block"><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default "><label>Task Follower</label><input type="text" class="form-control" name="follower_name" placeholder="Type to choose contact" ></div></div><div class="delete" id="delete_follower"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#follower_box').on('click','#delete_follower',function() {
 	$(this).parent().remove();
});


  // Upload btn on change call function

$('#add_owner').click(function() {
  $('#owner_block').before('<div class="owner_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>Owner Name</label><input type="text" class="form-control" name="Owner Name" ></div></div><div class="col-md-5"><div class="form-group form-group-default "><label>% of Ownership *%</label><input type="text" class="form-control" name="ownership" ></div></div><div class="delete" id="delete_owner"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#owner_box').on('click','#delete_owner',function() {
 	$(this).parent().remove();
});




$('#add_prop_img').click(function() {
  $('#prop_img_block').before('<tr class="prop_img_block"><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default "><label>Captured Date</label><input id="start-date" type="text" class="form-control date" name="Captured Date" required></div></div><div class="col-md-4"><div class="form-group form-group-default "><label>Description</label><input type="text" class="form-control" name="Description" ></div></div><div class="col-md-3"> <div class="fileUpload blue-btn btn width100"><span><i class="fa fa-cloud-upload"></i></span><input type="file" class="uploadlogo" /></div></div><div class="delete" id="delete_prop_img"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
  
    $(".date").datepicker();
	
});
$('#prop_img_box').on('click','#delete_prop_img',function() {
 	$(this).parent().remove();
});


$('#add_schedule').click(function() {
	 $('#schedule_block').before('<tr class="schedule_block"><td>1</td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default"><input id="dob" type="text" class="form-control date" name="Date Of Purchase" required></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><select  name="Select"><option value="AK">Select</option><option value="AK">Select</option><option value="AK">Select</option></select></td><td class="delete" id="delete_schedule"><i class="fa fa-trash" aria-hidden="true"></i></td></tr>');
	 
	   $(".date").datepicker();
	 });

$('#schedule_box').on('click','#delete_schedule',function() {
 	$(this).parent().remove();
});



$('#add_tenant').click(function() {
  $('#tenant_block').before('<div class="tenant_block"><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Documents</label><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="AK">Select</option><option value="AK">Select</option><option value="AK">Select</option></Select></div></div><div class="delete" id="delete_tenant"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
		$('.select2').select2();
});
$('#tenant_box').on('click','#delete_tenant',function() {
 	$(this).parent().remove();
});


$('#add_rent_schedule').click(function() {
	 $('#rent_schedule_block').before('<tr class="rent_schedule_block"><td>1</td><td><div class="form-group form-group-default"><input id="date_rent" type="text" class="form-control date" name="date" ></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td><div class="form-group form-group-default "><input type="text" class="form-control " name=""></div></td><td class="delete" id="delete_rent_schedule"><i class="fa fa-trash" aria-hidden="true"></i></td></tr>');
	 
	   $(".date").datepicker();
	 });

$('#rent_schedule_box').on('click','#delete_rent_schedule',function() {
 	$(this).parent().remove();
});


$('#add_buyer').click(function() {
  $('#buyer_block').before('<div class="buyer_block"><div class="row clearfix"><div class="col-md-5"><div class="form-group form-group-default "><label>Buyer Name</label><input type="text" class="form-control" name="Buyer Name" ></div></div><div class="col-md-5"><div class="form-group form-group-default "><label>% share</label><input type="text" class="form-control" name="% share" ></div></div><div class="delete" id="delete_buyer"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#buyer_box').on('click','#delete_buyer',function() {
 	$(this).parent().remove();
});



$('#add_owner_name').click(function() {
  $('#owner_name_block').before('<div class="owner_name_block"><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default "><label>Name Of Applicant</label><input type="text" class="form-control" name="applicant_name" ></div></div><div class="delete" id="delete_owner_name"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#owner_name_box').on('click','#delete_owner_name',function() {
 	$(this).parent().remove();
});


$('#add_security').click(function() {
  $('#security_block').before('<div class="security_block"><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default "><label>Name</label><input type="text" class="form-control" name="security_name" ></div></div><div class="delete" id="delete_security"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#security_box').on('click','#delete_security',function() {
 	$(this).parent().remove();
});


$('#add_owner_name').click(function() {
  $('#owner_name_block').before('<div class="owner_name_block"><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default "><label>Name Of Applicant</label><input type="text" class="form-control" name="applicant_name" ></div></div><div class="delete" id="delete_owner_name"><i class="fa fa-trash" aria-hidden="true"></i></div></div></div></div>');
	
});
$('#owner_name_box').on('click','#delete_owner_name',function() {
 	$(this).parent().remove();
});


$('#add_sub_prop').click(function() {
  $('#sub_prop_block').before('<div class="block1"><div class="remove" id="delete_sub_prop">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Sr. No.</label><input type="text" class="form-control" name="sr_no." ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Sub Property Name.</label><input type="text" class="form-control" name="sub_property_name" ></div></div><div class="col-md-4"><div class="form-group form-group-default form-group-default-select2 required"><label class="">Select Sub Property Type</label><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="shop">shop</option><option value="Flat">Flat</option><option value="Floor">Floor</option></select></div></div><div class="col-md-4"><div class="form-group form-group-default input-group"><div class="form-input-group"><label>Carpet Area</label><input type="text" class="form-control usd" name="carpet_area"></div><div class="input-group-addon bg-transparent h-c-50"><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="select">select</option><option value="sq ft">sq ft</option><option value="sq mt">sq m</option><option value="sq yard">sq yard</option></select></div></div></div><div class="col-md-4"><div class="form-group form-group-default input-group"><div class="form-input-group"><label>Built Up Area</label><input type="text" class="form-control usd" name="build_up_area"></div><div class="input-group-addon bg-transparent h-c-50"><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="select">select</option><option value="sq ft">sq ft</option><option value="sq mt">sq m</option><option value="sq yard">sq yard</option></select></div></div></div><div class="col-md-4"><div class="form-group form-group-default input-group"><div class="form-input-group"><label>Saleable Area</label><input type="text" class="form-control usd" name="saleble_area" ></div><div class="input-group-addon bg-transparent h-c-50"><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2"><option value="select">select</option><option value="sq ft">sq ft</option><option value="sq mt">sq m</option><option value="sq yard">sq yard</option></select></div></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Allocated Cost(₹)</label><input type="text" class="form-control" name="Allocated Cost (In ₹)." ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Allocated Maintenance(₹)</label><input type="text" class="form-control" name="Allocated Maintenance (In ₹)." required></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Allocated Maintenance(₹)</label><input type="text" class="form-control" name="Allocated Maintenance (In ₹)." ></div></div></div></div>');
$('.select2').select2();	
});
$('#sub_prop_box').on('click','#delete_sub_prop',function() {
 	$(this).parent().remove();
});

$('#add_income').click(function() {
	 $('#income_block').before('<tr class="table_head2 "><td><div class="form-group form-group-default "><label>Due Date</label><input id="due_date" type="text" class="form-control date" name="Due Date " ></div></td><td><div class="form-group form-group-default "><label>Paid  Date</label><input id="paid_date" type="text" class="form-control date" name="Paid Date " ></div></td><td> <div class="form-group form-group-default form-group-default-select2 required"><label class=""> Category</label><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2" name="Category"><option value="AK">Select Category</option></select></div></td><td>18,000</td><td><input type="checkbox" value="yes" data-init-plugin="switchery" data-size="small" data-color="primary" checked="checked" /></td><td>1,000</td><td>19,000</td><td class="delete" id="delete_income"><i class="fa fa-trash" aria-hidden="true"></i></td></tr><tr class="odd gradeX"><td><div class="form-group form-group-default form-group-default-select2 required"><label class=""> BANK NAME</label><select class="full-width select2" data-placeholder="Select Country" data-init-plugin="select2" name="Category"><option value="AK">Select</option></select></div></td><td colspan="2"><div class="form-group form-group-default "><label>Description</label><input id="" type="text" class="form-control " name="description " ></div></td><td colspan="6"></td></tr>');
	 
	   $(".date").datepicker();
	   $('.select2').select2();
	   $('.switchery-small').checkbox();
	   
	 });

$('#income_box').on('click','#delete_income',function() {
 	$(this).parent().remove();
});


$('#add_landlord_contact').click(function() {
  $('#landlord_contact_block').before('<div class="block1"><div class="remove" id="delete_landlord_contact">Remove <i class="fa fa-times" aria-hidden="true"></i></div><div class="row clearfix"><div class="col-md-12"><div class="form-group form-group-default required"><label>Office Name</label><input type="text" class="form-control " name="office_name"></div></div></div><div class="row clearfix"><div class="col-md-8"><div class="form-group form-group-default required"><label>Street Address</label><input type="text" class="form-control" name="address" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>City</label><input type="text" class="form-control" name="city"></div></div></div><div class="row clearfix"><div class="col-md-4"><div class="form-group form-group-default required"><label>Country</label><input id="Country" type="text" class="form-control " name="Country" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>State</label><input id="State" type="text" class="form-control " name="dob" ></div></div><div class="col-md-4"><div class="form-group form-group-default required"><label>Zipcode</label><input id="Zipcode" type="text" class="form-control " name="Zipcode" ></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT PHONE</label><input type="text" class="form-control" name="phone1" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT PHONE 2</label><input type="text" class="form-control" name="phone2"></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT EMAIL</label><input type="text" class="form-control" name="email1" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>CONTACT EMAIL 2</label><input type="text" class="form-control" name="email2"></div></div></div><div class="row clearfix"><div class="col-md-6"><div class="form-group form-group-default required"><label>FAX</label><input type="text" class="form-control" name="fax" ></div></div><div class="col-md-6"><div class="form-group form-group-default required"><label>SKYPE</label><input type="text" class="form-control" name="skype"></div></div></div></div>');
 });
$('#landlord_contact_box').on('click','#delete_landlord_contact',function() {
 	$(this).parent().remove();
});