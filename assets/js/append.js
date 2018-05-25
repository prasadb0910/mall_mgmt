
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


