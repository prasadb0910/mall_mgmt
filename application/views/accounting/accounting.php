<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('templates/header');?>

	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" >
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" media="screen">
	<link href="<?php echo base_url(); ?>assets/css/accounting.css" rel="stylesheet" type="text/css" media="screen">

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
		.week {
			color:#6b7c93;
		}
		.active1, .week:hover {
		   color: #7489e3;
		 
		}
		.table tbody tr td {
			padding:10px!important;	
		}
		.created_date {
			text-align:center;
		}
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
		}
		.print {
			color:#fe970a!important;
		}
		.a {
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
		.info {
			text-align:center;
		}
		.invoice {
		    margin: 10px;
		    padding: 0 27px;
		    border-radius: 30px;
		    font-size: 13px;
		}
		.btn-group-justified {
			margin-left:2px;
		}
		.email {
			font-size:13px!important;
			color:#fff!important;
		}
		.title_1 {
			font-size: 1.14286rem!important;
		    font-family: inherit!important;
		    font-weight: 500!important;
		    letter-spacing: 0.02em!important;
		    text-transform: capitalize!important;
			color:#fff!important;
		}
		.contact_card {
			border-radius:5px!important;
		}
		.rent {
			color:#a5b1de!important;
			border-right:1px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-color:#a5b1de!important
		}
		.rent:hover {
			background-color: #a5b1de!important;
			color:#fff!important;
		}
		.leases {
			color:#a5b1de!important;
			border-top: 1px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-right:1px solid #edf0f5;
			border-color: #a5b1de!important;
			
		}
		.leases:hover {
			background-color: #a5b1de!important;
			
		}
		
		.leases a:hover 
		{
				color:#fff!important;
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
		#money.fa {
			font-size:22px!important;
		}
		.user-roommates.empty>p {
			text-align:center;
			font-size: 12px;
			color: #d1d3d8;
		}
		.form-group-default {
			border:none!important;
		}
		.form-group-default label {
			font-weight:1000!important;
		}
		.thumbnail-wrapper.d32>* {
		    line-height: 110px!important;
		}
		.block1 {
			padding: 20px 20px;
		    border: 2px solid #edf0f5;
		    border-radius: 7px;
		    background: #f6f9fc;
			margin-top: 10px;
		    margin-bottom: 10px;
		}
		p {
		    font-weight: 200px!important;
		}
		.acc_buttons tr td:hover
		{
			background-color: #a5b1de;
		}
		.acc_buttons tr td:hover a
		 {
		    color: white;
		    text-decoration: none;
		}
		.acc_buttons tr td a
		{
			  color: #a5b1de;
			 
		}

		.acc_buttons tr td
		{
			padding:5px;
		}

		.dataTables_filter {
		    float: right;
		    padding-right: 10px;
		    display: none!important;
		}

		.dataTables_length{
			 display: none!important;
		}
	</style>

    <style>
        <?php if($maker_checker!='yes') { ?>
            .approved {
                display: none !important;
            }
            .pending {
                display: none !important;
            }
            .rejected {
                display: none !important;
            }
        <?php } ?>
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
	<div class="content">
		<div class=" container-fluid container-fixed-lg">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
				<li class="breadcrumb-item"><a href="#">Accounting</a></li>
			</ol>
		
			<div style="display: flow-root;">
				<a href="<?php echo base_url(); ?>index.php/Expense_category/index"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Accounting Category</span></button></a>
				<a href="<?php echo base_url(); ?>index.php/bank"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Bank Master</span></button></a></div>
				<ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class="<?php if($checkstatus=='All') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/All">All(<?php if(isset($all)) echo $all; else echo 0; ?>)</a>
                    </li>
                    <li class="nav-item all">
                        <a class="<?php if($checkstatus=='Unpaid') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/Unpaid">Unpaid(<?php if(isset($unpaid)) echo $unpaid; else echo 0; ?>)</a>
                    </li>
                    <li class="nav-item approved">
                        <a class="<?php if($checkstatus=='Approved') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/Approved">Approved(<?php if(isset($approved)) echo $approved; else echo 0; ?>)</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="<?php if($checkstatus=='Pending') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/Pending">Pending(<?php if(isset($pending)) echo $pending; else echo 0; ?>)</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="<?php if($checkstatus=='Rejected') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/Rejected">Rejected(<?php if(isset($rejected)) echo $rejected; else echo 0; ?>)</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class="<?php if($checkstatus=='InProcess') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Accounting/checkstatus/InProcess">Draft(<?php if(isset($inprocess)) echo $inprocess; else echo 0; ?>)</a>
                    </li>
                </ul>
                <br>
				<div class="row m-t-20">
			 		<div class="col-md-3" style="display:none;"> 
						<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id=""style="background:transparent;border:1px solid #a5b1de!important">
							<div class="row" style="padding-left:15px;padding-right:15px;">
								<div class="col-md-6 rent">
									<a href="<?php echo base_url(); ?>index.php/accounting/addnew/receipt">
										<i style="font-size:22px;" class="fa fa-th-list"></i><br>Receive
									</a>
								</div>
								<div class="col-md-6 rent" style="border-right:none;">
									<a href="<?php echo base_url(); ?>index.php/accounting/addnew/payment">
										<i style="font-size:22px;" class="fa fa-money"></i><br>Pay
									</a>
								</div>
								<div class=" col-md-6 leases">
									<a href="<?php echo base_url(); ?>index.php/accounting/addnew/income">
										<i style="font-size:22px;" class="fa fa-plus-square"></i><br>Add Income
									</a>
								</div>
								<div class=" col-md-6 leases" style="border-right:none;">
									<a href="<?php echo base_url(); ?>index.php/accounting/addnew/expense">
										<i style="font-size:22px;" class="fa fa-plus-square "></i><br>Add Expense
									</a>
								</div>
								<div class=" col-md-6 leases">
									<a href="#">
										<i style="font-size:22px;" class="fa fa-rupee"></i><br>Manage GST
									</a>
								</div>
								<div class=" col-md-6 leases" style="border-right:none;">
									<a href="<?php echo base_url(); ?>index.php/accounting/getTds">
										<i style="font-size:22px;" class="fa fa-rupee"></i><br>Manage TDS
									</a>
								</div>
							</div> 
						</div>
					</div>
					
					<div class="col-md-3">
						
						<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" style="background:transparent;">
					
							<table class="acc_buttons" border="1" style="border:1px solid #a5b1de!important;border-radius:3px;">
							<tr style="width:100%">
							<td style="text-align:center;"><a href="<?php echo base_url(); ?>index.php/accounting/addnew/receipt">
											<i style="font-size:22px;" class="fa fa-th-list"></i><br>Receive
										</a></td>
							<td  style="text-align:center;"><a href="<?php echo base_url(); ?>index.php/accounting/addnew/payment">
											<i style="font-size:22px;" class="fa fa-money"></i><br>Pay
										</a></td>
							</tr>
							<tr>
							<td  style="text-align:center;"><a href="<?php echo base_url(); ?>index.php/accounting/addnew/income">
											<i style="font-size:22px;" class="fa fa-plus-square"></i><br>Add Income
										</a></td>
							<td  style="text-align:center;"><a href="<?php echo base_url(); ?>index.php/accounting/addnew/expense">
											<i style="font-size:22px;" class="fa fa-plus-square "></i><br>Add Expense
										</a></td>
							</tr>
							<tr>
							<td  style="text-align:center;"><a href="<?php echo base_url('index.php/accounting/getGst'); ?>">
											<i style="font-size:22px;" class="fa fa-rupee"></i><br>Manage GST
										</a></td>
							<td  style="text-align:center;"><a href="<?php echo base_url(); ?>index.php/accounting/getTds">
											<i style="font-size:22px;" class="fa fa-rupee"></i><br>Manage TDS
										</a></td>
							</tr>
							</table>
							
					
						
						</div>
					</div>
					
					
					
					<div class="col-md-9">
						<div class="row clearfix" >
							<div class="col-md-12">
							
									<div class="row clearfix" >
										<div class="col-md-4" style="display:none;">
											<ul class="days_filter" id="days_filter">
												<li class="week active1">1W</li>
												<li class="week">2W</li>
												<li class="week">1M</li>
												<li class="week">3M</li>
												<li class="week">1Y</li>
												<li class="week">ALL</li>
											</ul>
										</div>
										<div class="col-md-8" style="padding-right:0px!important">
											<form action="<?= base_url('index.php/accounting')?>" method="POST">
											<div class="input-daterange input-group " id="datepicker-range">
												<label style="margin-top:5px;"> Date Range:- &nbsp </label>
												<input type="text" class="input-sm form-control daterange" name="startdate" id="startdate" value="<?=($startdate!=""?$startdate:'')?>" />
												<div class="input-group-addon">to</div>
												<input type="text" class="input-sm form-control daterange" name="enddate" id="enddate" value="<?= ($enddate!=""?$enddate:'')?>"/>
												 <input type="button" id="buttondate" value="Submit"  style="margin-left:10px;border-radius:3px;" class="btn btn-default" name="">
											
											</div>
											</form>
												
										</div>
												<div class="col-md-2">
												<button class="btn btn-default-danger" id="resetdate" >Reset</button>
												</div>
									</div>
									<div class="row clearfix">
										<div class="col-md-12">
											<table id="example5" class="table table-bordered table-striped">
												<thead>
													<tr class="p-receipts">
														<th colspan="10"> Receipts</th>
													</tr>
													<tr>
														<th>Status</th>
														<th>Action</th>
														<th>Due Date</th>
														<th>Category</th>
														<th>Payer</th>
														<th>Property</th>
														<th>Sub Property</th>
														<th>Due</th>
														<th>Received</th>
														<th>Pending</th>
														<!-- <th>GST</th> -->
													</tr>
												</thead>
												<tbody>

												</tbody>
											</table>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-md-12">
											<table id="example6" class="table table-bordered table-striped">
												<thead>
													<tr class="p-receipts">
														<th colspan="10"> Payments</th>
													</tr>
													<tr>
														<th>Status</th>
														<th>Action</th>
														<th>Due Date</th>
														<th>Category</th>
														<th>Payee</th>
														<th>Property</th>
														<th>Sub Property</th>
														<th>Due</th>
														<th>Received</th>
														<th>Pending</th>
														<!-- <th>GST</th> -->
													</tr>
												</thead>
												<tbody>
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

	<?php $this->load->view('templates/footer');?>

</div>
</div>

<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header col-xs-height col-middle text-center" style="background-color:#2b303b!important;padding: 10px!important;">
					<p class="head-title">TRANSACTION</p>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-18"></i>
					</button>
				</div>
				<div class="container-xs-height full-height p-t-20">
					<div class="">
						<div class="modal-body  col-middle ">
							<div class="header-nav " style="">
								<div class="m-status--payment-status status-0 pull-left" id="status"></div>
								<div class="nav-btn p-l-10 p-r-10">
									<a class="btn btn-success pull-right" id="type" style="text-transform: uppercase;" href="<?php echo base_url(); ?>index.php/Accounting/edit"></a>
								</div>
								<!-- <a class="modal-edit ">
									<i class="fa fa-cog"></i>
								</a> -->
							</div><br>
							<div class="view-block">
								<h5>Category:</h5>
								<span class="category" id="particular">Rent</span>
							</div><br>
							<div class="view-block">
								<table class="view_table" align="center">
									<tbody>
										<tr>
											<td>
												<h5>Balance</h5>
												<span class="balance" id="bal_amount">-</span>
											</td>
											<td>
												<h5>Total</h5>
												<span  class="net_total" id="net_amount">-</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div><br>
							<div class="view-block" style="display: none;">
								<div>
									<h5>Transaction type:</h5>
									<span>Income /</span>
									<span>Recurring, </span>
									<span>Monthly</span>
								</div>
							</div>
							<div class="view-block">
								<h5>Due:</h5>
								<span class="due_dtl" id="due_date">-</span>
							</div><br>
							<div class="view-block rent_date" style="display: none">
								<h5>Month Of Rent:</h5>
								<span class=""><span id="particular_name">-</span></span>
							</div><br>
							<div class="view-block">
								<h5>Property:</h5>
								<span class=""><span id="property_name">-</span></span>
							</div><br>
							<div class="view-block subprop" style="display: none">
								<h5>Sub Property:</h5>
								<span class=""><span id="sub_property_name">-</span></span>
							</div><br>
							<div class="view-block">
								<h5>Owner:</h5>
								<span class=""><span id="owner_name">-</span></span>
								<h5 style="display: none;">Lease 1</h5>
							</div><br>
							<div class="view-block">
								<h5 id="payer_label">Payer:</h5>
								<span class=""><span id="payer_name">-</span></span>
								<h5 style="display: none;">Lease 1</h5>
							</div><br>
							<div class="view-block" style="display: none;">
								<div class="m-property-info ">
									<div class="info-name-property">
										<span>
											<span >1 BHK Flat</span>
											<span>,</span>
										</span>
										<span>unit 1</span>
									</div>
									<div class="info-location p-b-10" >
										<div class="icon-svg"><i class="fa fa-map-marker"></i>
										</div>
										<div class="location-address">
											<address  id="address">Green Acres 3, Thane, MH, 400607, IN</address>
										</div>
									</div>
								</div>
							</div><!-- <br> -->
							<div class="m-panel filter-footer" style="display:none;">
								<div class="btn-group pull-left p-r-20">
									<a class="edit icon-line icon-line-print" target="_blank">
										<span><i class="fa fa-print"></i></span><br>
										<span>print</span>
									</a>
								</div> 
								<div class="footer-detail pull-left p-r-10">
									<h5>Transaction id <span>2662837</span></h5>
									<div class="info-date" >
										<div>Updated 27/01/2018</div>
									</div>
								</div> &nbsp 
								<a  href="" class="remove void icon-line icon-line-interface-remove pull-right">
									<span><i class="fa fa-trash"></i></span><br>
									<span>void</span> 
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('templates/script');?>
<?php $url_property_id = $this->uri->segment(4);?>
<?php $url_contact_id = $this->uri->segment(5);?>
<?php echo 'url_rent_id'.$url_rent_id = $this->uri->segment(6);?>


<script>
var header = document.getElementById("days_filter");
var btns = header.getElementsByClassName("week");
for (var i = 0; i < btns.length; i++) {
	btns[i].addEventListener("click", function() {
		var current = document.getElementsByClassName("active1");
		current[0].className = current[0].className.replace(" active1", "");
		this.className += " active1";
	});
}
</script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/acc_list.js"></script>

<script>
var BASE_URL="<?php echo base_url(); ?>";
	$(".daterange").datepicker();

$(document).ready(function() {
$(".daterange").datepicker();

	$('#buttondate').on( 'click', function () {
	    $('#example5').DataTable().destroy();
	    $('#example6').DataTable().destroy();

	    $('#example5').DataTable({
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
							url : BASE_URL + "index.php/accounting/checkstatus_receipt/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?'/'.$url_property_id:'/'.$url_property_id)?><?=($url_rent_id!=''?'/'.$url_rent_id:'')?>", // json datasource
							type: "post",  // type of method  ,GET/POST/DELETE
							data: function(data) {
													// data.notice_type_id = 1;
													// data.newspaper = '6';
													// data.from_date = '';
													// data.to_date = '';
													// data.keyword = '';
													// data.match_word = '';
													data.startdate = $('#startdate').val();
													data.enddate = $('#enddate').val();
													/*data.notice_type_id = $('#notice_type_id').val();
													data.newspaper = $('#newspaper').val();
													data.from_date = $('#from_date').val();
													data.to_date = $('#to_date').val();
													data.keyword = $('#keyword').val();
													data.match_word = $("input[name='match_word']:checked").val();											
													data.noticetypetext = $("#noticetypetext").val();
													data.newspapertext = $("#newspaper option:selected").text();*/
							                    },
							error: function(){
							  	$("#example_processing").css("display","none");
							}
						}
		});

		$('#example6').DataTable({
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
							url : BASE_URL + "index.php/accounting/checkstatus_payment/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?$url_property_id:'/'.$url_property_id)?>", // json datasource
							type: "post",  // type of method  ,GET/POST/DELETE
							data: function(data) {
													// data.notice_type_id = 1;
													// data.newspaper = '6';
													// data.from_date = '';
													// data.to_date = '';
													// data.keyword = '';
													// data.match_word = '';
													data.startdate = $('#startdate').val();
													data.enddate = $('#enddate').val();
													/*data.notice_type_id = $('#notice_type_id').val();
													data.newspaper = $('#newspaper').val();
													data.from_date = $('#from_date').val();
													data.to_date = $('#to_date').val();
													data.keyword = $('#keyword').val();
													data.match_word = $("input[name='match_word']:checked").val();											
													data.noticetypetext = $("#noticetypetext").val();
													data.newspapertext = $("#newspaper option:selected").text();*/
							                    },
							error: function(){
							  	$("#example_processing").css("display","none");
							}
						}
		});

	} );

	 $('#example5').DataTable().destroy();
	 $('#example6').DataTable().destroy();

	$('#resetdate').on( 'click', function () {
	    $('#example5').DataTable().destroy();
	    $('#example6').DataTable().destroy();
	    $('#startdate').val('');
	    $('#enddate').val('');
	    $('#example5').DataTable({
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
							url : BASE_URL + "index.php/accounting/checkstatus_receipt/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?'/'.$url_property_id:'')?><?=($url_contact_id!=''?'/'.$url_contact_id:'')?><?=($url_rent_id!=''?'/'.$url_rent_id:'')?>", // json datasource
							type: "post",  // type of method  ,GET/POST/DELETE
							data: function(data) {
													// data.notice_type_id = 1;
													// data.newspaper = '6';
													// data.from_date = '';
													// data.to_date = '';
													// data.keyword = '';
													// data.match_word = '';
													data.startdate = $('#startdate').val();
													data.enddate = $('#enddate').val();
													/*data.notice_type_id = $('#notice_type_id').val();
													data.newspaper = $('#newspaper').val();
													data.from_date = $('#from_date').val();
													data.to_date = $('#to_date').val();
													data.keyword = $('#keyword').val();
													data.match_word = $("input[name='match_word']:checked").val();											
													data.noticetypetext = $("#noticetypetext").val();
													data.newspapertext = $("#newspaper option:selected").text();*/
							                    },
							error: function(){
							  	$("#example_processing").css("display","none");
							}
						}
		});

		$('#example6').DataTable({
				"bProcessing": true,
				"serverSide": true,
				"ajax":{
							url : BASE_URL + "index.php/accounting/checkstatus_payment/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?'/'.$url_property_id:'')?><?=($url_contact_id!=''?'/'.$url_contact_id:'')?>", // json datasource
							type: "post",  // type of method  ,GET/POST/DELETE
							data: function(data) {
													// data.notice_type_id = 1;
													// data.newspaper = '6';
													// data.from_date = '';
													// data.to_date = '';
													// data.keyword = '';
													// data.match_word = '';
													data.startdate = $('#startdate').val();
													data.enddate = $('#enddate').val();
													/*data.notice_type_id = $('#notice_type_id').val();
													data.newspaper = $('#newspaper').val();
													data.from_date = $('#from_date').val();
													data.to_date = $('#to_date').val();
													data.keyword = $('#keyword').val();
													data.match_word = $("input[name='match_word']:checked").val();											
													data.noticetypetext = $("#noticetypetext").val();
													data.newspapertext = $("#newspaper option:selected").text();*/
							                    },
							error: function(){
							  	$("#example_processing").css("display","none");
							}
						}
		});

	} );

    $('#example5').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"ajax":{
					url : BASE_URL + "index.php/accounting/checkstatus_receipt/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?'/'.$url_property_id:'')?><?=($url_contact_id!=''?'/'.$url_contact_id:'')?><?=($url_rent_id!=''?'/'.$url_rent_id:'')?>", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					data: function(data) {
											// data.notice_type_id = 1;
											// data.newspaper = '6';
											// data.from_date = '';
											// data.to_date = '';
											// data.keyword = '';
											// data.match_word = '';
											data.startdate = $('#startdate').val();
											data.enddate = $('#enddate').val();
											/*data.notice_type_id = $('#notice_type_id').val();
											data.newspaper = $('#newspaper').val();
											data.from_date = $('#from_date').val();
											data.to_date = $('#to_date').val();
											data.keyword = $('#keyword').val();
											data.match_word = $("input[name='match_word']:checked").val();											
											data.noticetypetext = $("#noticetypetext").val();
											data.newspapertext = $("#newspaper option:selected").text();*/
					                    },
					error: function(){
					  	$("#example_processing").css("display","none");
					}
				}
	});


	$('#example6').DataTable({
		"bProcessing": true,
		"serverSide": true,
		"ajax":{
					url : BASE_URL + "index.php/accounting/checkstatus_payment/<?=($checkstatus!=''?$checkstatus:'ALL')?><?=($url_property_id!=''?'/'.$url_property_id:'')?><?=($url_contact_id!=''?'/'.$url_contact_id:'')?><?=($url_rent_id!=''?'/'.$url_rent_id:'')?>", // json datasource
					type: "post",  // type of method  ,GET/POST/DELETE
					data: function(data) {
											// data.notice_type_id = 1;
											// data.newspaper = '6';
											// data.from_date = '';
											// data.to_date = '';
											// data.keyword = '';
											// data.match_word = '';
											data.startdate = $('#startdate').val();
											data.enddate = $('#enddate').val();
											/*data.notice_type_id = $('#notice_type_id').val();
											data.newspaper = $('#newspaper').val();
											data.from_date = $('#from_date').val();
											data.to_date = $('#to_date').val();
											data.keyword = $('#keyword').val();
											data.match_word = $("input[name='match_word']:checked").val();											
											data.noticetypetext = $("#noticetypetext").val();
											data.newspapertext = $("#newspaper option:selected").text();*/
					                    },
					error: function(){
					  	$("#example_processing").css("display","none");
					}
				}
	});
});
</script>

</body>
</html>