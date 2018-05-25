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
												<input type="text" class="input-sm form-control daterange" name="start" value="<?=($startdate!=""?$startdate:'')?>" />
												<div class="input-group-addon">to</div>
												<input type="text" class="input-sm form-control daterange" name="end" value="<?= ($enddate!=""?$enddate:'')?>"/>
												 <input type="submit" style="margin-left:10px;border-radius:3px;"class="btn btn-default" name="">
											
											</div>
											</form>
												
										</div>
												<div class="col-md-2">
												<a href="<?=base_url('index.php/accounting');?>" target="_self"> <button class="btn btn-default-danger" >Reset</button></a>
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
													<!-- <tr class="odd-cell">
														<td colspan="11" style="background-color:#f6f9fc!important;">January, 2018</td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
													</tr> -->
													<?php $j=0; for ($i=0; $i < count($bankentry) ; $i++) { if($bankentry[$i]['particulars']=='Rent' || $bankentry[$i]['particulars']=='Sale' || $bankentry[$i]['particulars']=='Income') { ?>
													<tr class="">
														<td><span class="btn btn-success paid" >Paid</span></td>
														<td class="acc_dtl">
															<input type="hidden" id="type_<?php echo $j; ?>" value="View" />
															<input type="hidden" id="status_<?php echo $j; ?>" value="paid" />
															<input type="hidden" id="prop_id_<?php echo $j; ?>" value="<?php echo $bankentry[$i]['prop_id']; ?>" />
															<input type="hidden" id="particular_<?php echo $j; ?>" value="<?php echo $bankentry[$i]['particulars']; ?>" />
															<input type="hidden" id="bal_amount_<?php echo $j; ?>" value="<?php echo format_money($bankentry[$i]['bal_amount'],2); ?>" />
															<input type="hidden" id="net_amount_<?php echo $j; ?>" value="<?php echo format_money($bankentry[$i]['net_amount'],2); ?>" />
															<input type="hidden" id="due_date_<?php echo $j; ?>" value="<?php echo ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''; ?>" />
															<!-- <input type="hidden" id="link_<?php //echo $j; ?>" value="<?php //echo base_url().'index.php/Accounting/bankEntryView/'.$bankentry[$i]['prop_id'].'/'.$bankentry[$i]['accounting_id'].'/'.$bankentry[$i]['entry_type']; ?>" /> -->
															<input type="hidden" id="link_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/view/receipt/'.$bankentry[$i]['txn_status'].'/'.$bankentry[$i]['contact_id'].'/'.$bankentry[$i]['transaction'].'/'.($bankentry[$i]['property_id']==''?'0':$bankentry[$i]['property_id']).'/'.($bankentry[$i]['sub_property_id']==''?'0':$bankentry[$i]['sub_property_id']).'/'.($bankentry[$i]['accounting_id']==''?'0':$bankentry[$i]['accounting_id']); ?>" />
															<input type="hidden" id="property_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['property'])) echo $bankentry[$i]['property']; ?>" />
															<input type="hidden" id="sub_property_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['sub_property'])) echo $bankentry[$i]['sub_property']; ?>" />
															<input type="hidden" id="owner_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['owner_name'])) echo $bankentry[$i]['owner_name']; ?>" />
															<input type="hidden" id="payer_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['payer_name'])) echo $bankentry[$i]['payer_name']; ?>" />
															<input type="hidden" id="address_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['p_address'])) echo $bankentry[$i]['p_address']; ?>" />
															<a id="details_<?php echo $j; ?>" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details</a>
														</td>
														<td style="text-align:right"><?php echo ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''; ?></td>
														<td><?php echo $bankentry[$i]['particulars']; ?></td>
														<td><?php if(isset($bankentry[$i]['payer_name'])) echo $bankentry[$i]['payer_name']; ?></td>
														<td><?php echo $bankentry[$i]['property']; ?></td>
														<td><?php echo $bankentry[$i]['sub_property']; ?></td>
														<td style="text-align:right"><?php echo format_money($bankentry[$i]['net_amount'],2); ?></td>
														<td style="text-align:right"><?php echo format_money($bankentry[$i]['paid_amount'],2); ?></td>
														<td style="text-align:right"><?php if(isset($bankentry[$i]['bal_amount'])) echo format_money($bankentry[$i]['bal_amount'],2); ?></td>
														<!-- <td style="text-align:right"><?php //if(isset($bankentry[$i]['tax_amount'])) echo format_money($bankentry[$i]['tax_amount'],2); ?></td> -->
													</tr>
													<?php $j++; }} ?>
													<?php for($i=0;$i<count($pendingbankentry);$i++) { if($pendingbankentry[$i]['particulars']=='Rent' || $pendingbankentry[$i]['particulars']=='Sale' || $pendingbankentry[$i]['particulars']=='Income') { ?>
													<tr class="">
														<td><span class="btn btn-danger unpaid" >Unpaid</span></td>
														<td class="acc_dtl">
															<input type="hidden" id="type_<?php echo $j; ?>" value="Receive" />
															<input type="hidden" id="type_2_<?php echo $j; ?>" value="View" />
															<input type="hidden" id="status_<?php echo $j; ?>" value="unpaid" />
															<input type="hidden" id="txn_status_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['txn_status']; ?>" />
															<input type="hidden" id="prop_id_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['prop_id']; ?>" />
															<input type="hidden" id="particular_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['particulars']; ?>" />
															<input type="hidden" id="bal_amount_<?php echo $j; ?>" value="<?php echo format_money($pendingbankentry[$i]['bal_amount'],2); ?>" />
															<input type="hidden" id="net_amount_<?php echo $j; ?>" value="<?php echo format_money($pendingbankentry[$i]['net_amount'],2); ?>" />
															<input type="hidden" id="due_date_<?php echo $j; ?>" value="<?php echo ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):''; ?>" />
															<!-- <input type="hidden" id="link_<?php //echo $j; ?>" value="<?php //echo base_url().'index.php/Accounting/bankEntry/'.$pendingbankentry[$i]['prop_id']; ?>" /> -->
															<input type="hidden" id="link_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/edit/receipt/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:''); ?>" />
															<input type="hidden" id="link_2_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/viewOtherSchedule/receipt/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:''); ?>" />
															<input type="hidden" id="owner_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['owner_name'])) echo $pendingbankentry[$i]['owner_name']; ?>" />
															<input type="hidden" id="payer_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['payer_name'])) echo $pendingbankentry[$i]['payer_name']; ?>" />
															<input type="hidden" id="property_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['property'])) echo $pendingbankentry[$i]['property']; ?>" />
															<input type="hidden" id="sub_property_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['sub_property'])) echo $pendingbankentry[$i]['sub_property']; ?>" />
															<input type="hidden" id="address_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['p_address'])) echo $pendingbankentry[$i]['p_address']; ?>" />
															<a id="details_<?php echo $j; ?>" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details</a>
														</td>
														<td style="text-align:right"><?php echo ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):''; ?></td>
														<td><?php echo $pendingbankentry[$i]['particulars']; ?></td>
														<td><?php if(isset($pendingbankentry[$i]['payer_name'])) echo $pendingbankentry[$i]['payer_name']; ?></td>
														<td><?php echo $pendingbankentry[$i]['property']; ?></td>
														<td><?php echo $pendingbankentry[$i]['sub_property']; ?></td>
														<td style="text-align:right"><?php echo format_money($pendingbankentry[$i]['net_amount'],2); ?></td>
														<td style="text-align:right"><?php echo format_money($pendingbankentry[$i]['paid_amount'],2); ?></td>
														<td style="text-align:right"><?php if(isset($pendingbankentry[$i]['bal_amount'])) echo format_money($pendingbankentry[$i]['bal_amount'],2); ?></td>
														<!-- <td style="text-align:right"><?php //if(isset($pendingbankentry[$i]['tax_amount'])) echo format_money($pendingbankentry[$i]['tax_amount'],2); ?></td> -->
													</tr>
													<?php $j++; }} ?>
													<!-- <tr class="odd-cell">
														<td colspan="6" style="background-color:#f6f9fc!important;">Sub-Total</td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td>40,000</td>
														<td>0</td>
														<td>20,000</td>
														<td>100</td>
														<td></td>
													</tr> -->
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
													<!-- <tr class="odd-cell">
														<td colspan="11" style="background-color:#f6f9fc!important;">January, 2018</td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
													</tr> -->
													<?php for ($i=0; $i < count($bankentry) ; $i++) { if($bankentry[$i]['particulars']=='Purchase' || $bankentry[$i]['particulars']=='Loan' || $bankentry[$i]['particulars']=='Expense' || $bankentry[$i]['particulars']=='Maintenance') { ?>
													<tr class="">
														<td><span class="btn btn-success paid" >Paid</span></td>
														<td class="acc_dtl">
															<input type="hidden" id="type_<?php echo $j; ?>" value="View" />
															<input type="hidden" id="status_<?php echo $j; ?>" value="paid" />
															<input type="hidden" id="prop_id_<?php echo $j; ?>" value="<?php echo $bankentry[$i]['prop_id']; ?>" />
															<input type="hidden" id="particular_<?php echo $j; ?>" value="<?php echo $bankentry[$i]['particulars']; ?>" />
															<input type="hidden" id="bal_amount_<?php echo $j; ?>" value="<?php echo format_money($bankentry[$i]['bal_amount'],2); ?>" />
															<input type="hidden" id="net_amount_<?php echo $j; ?>" value="<?php echo format_money($bankentry[$i]['net_amount'],2); ?>" />
															<input type="hidden" id="due_date_<?php echo $j; ?>" value="<?php echo ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''; ?>" />
															<!-- <input type="hidden" id="link_<?php //echo $j; ?>" value="<?php //echo base_url().'index.php/Accounting/bankEntryView/'.$bankentry[$i]['prop_id'].'/'.$bankentry[$i]['accounting_id'].'/'.$bankentry[$i]['entry_type']; ?>" /> -->
															<input type="hidden" id="link_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/view/payment/'.$bankentry[$i]['txn_status'].'/'.$bankentry[$i]['contact_id'].'/'.$bankentry[$i]['transaction'].'/'.($bankentry[$i]['property_id']==''?'0':$bankentry[$i]['property_id']).'/'.($bankentry[$i]['sub_property_id']==''?'0':$bankentry[$i]['sub_property_id']).'/'.($bankentry[$i]['accounting_id']==''?'0':$bankentry[$i]['accounting_id']); ?>" />
															<input type="hidden" id="property_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['property'])) echo $bankentry[$i]['property']; ?>" />
															<input type="hidden" id="sub_property_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['sub_property'])) echo $bankentry[$i]['sub_property']; ?>" />
															<input type="hidden" id="owner_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['owner_name'])) echo $bankentry[$i]['owner_name']; ?>" />
															<input type="hidden" id="payer_name_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['payer_name'])) echo $bankentry[$i]['payer_name']; ?>" />
															<input type="hidden" id="address_<?php echo $j; ?>" value="<?php if(isset($bankentry[$i]['p_address'])) echo $bankentry[$i]['p_address']; ?>" />
															<a id="details_<?php echo $j; ?>" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details </a>
														</td>
														<td style="text-align:right"><?php echo ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''; ?></td>
														<td><?php echo $bankentry[$i]['particulars']; ?></td>
														<td><?php if(isset($bankentry[$i]['payer_name'])) echo $bankentry[$i]['payer_name']; ?></td>
														<td><?php echo $bankentry[$i]['property']; ?></td>
														<td><?php echo $bankentry[$i]['sub_property']; ?></td>
														<td style="text-align:right"><?php echo format_money($bankentry[$i]['net_amount'],2); ?></td>
														<td style="text-align:right"><?php echo format_money($bankentry[$i]['paid_amount'],2); ?></td>
														<td style="text-align:right"><?php if(isset($bankentry[$i]['bal_amount'])) echo format_money($bankentry[$i]['bal_amount'],2); ?></td>
														<!-- <td style="text-align:right"><?php //if(isset($bankentry[$i]['tax_amount'])) echo format_money($bankentry[$i]['tax_amount'],2); ?></td> -->
													</tr>
													<?php $j++; }} ?>
													<?php for($i=0;$i<count($pendingbankentry);$i++) { if($pendingbankentry[$i]['particulars']=='Purchase' || $pendingbankentry[$i]['particulars']=='Loan' || $pendingbankentry[$i]['particulars']=='Expense' || $pendingbankentry[$i]['particulars']=='Maintenance') { ?>
													<tr class="">
														<td><span class="btn btn-danger unpaid" >Unpaid</span></td>
														<td class="acc_dtl">
															<input type="hidden" id="type_<?php echo $j; ?>" value="Pay" />
                              								<input type="hidden" id="type_2_<?php echo $j; ?>" value="View" />
															<input type="hidden" id="status_<?php echo $j; ?>" value="unpaid" />
                              								<input type="hidden" id="txn_status_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['txn_status']; ?>" />
															<input type="hidden" id="prop_id_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['prop_id']; ?>" />
															<input type="hidden" id="particular_<?php echo $j; ?>" value="<?php echo $pendingbankentry[$i]['particulars']; ?>" />
															<input type="hidden" id="bal_amount_<?php echo $j; ?>" value="<?php echo format_money($pendingbankentry[$i]['bal_amount'],2); ?>" />
															<input type="hidden" id="net_amount_<?php echo $j; ?>" value="<?php echo format_money($pendingbankentry[$i]['net_amount'],2); ?>" />
															<input type="hidden" id="due_date_<?php echo $j; ?>" value="<?php echo ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):''; ?>" />
															<!-- <input type="hidden" id="link_<?php //echo $j; ?>" value="<?php //echo base_url().'index.php/Accounting/bankEntry/'.$pendingbankentry[$i]['prop_id']; ?>" /> -->
															<input type="hidden" id="link_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/edit/payment/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:''); ?>" />
															<input type="hidden" id="link_2_<?php echo $j; ?>" value="<?php echo base_url().'index.php/Accounting/viewOtherSchedule/payment/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:''); ?>" />
															<input type="hidden" id="property_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['property'])) echo $pendingbankentry[$i]['property']; ?>" />
															<input type="hidden" id="sub_property_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['sub_property'])) echo $pendingbankentry[$i]['sub_property']; ?>" />
															<input type="hidden" id="payer_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['payer_name'])) echo $pendingbankentry[$i]['payer_name']; ?>" />
															<input type="hidden" id="owner_name_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['owner_name'])) echo $pendingbankentry[$i]['owner_name']; ?>" />
															<input type="hidden" id="address_<?php echo $j; ?>" value="<?php if(isset($pendingbankentry[$i]['p_address'])) echo $pendingbankentry[$i]['p_address']; ?>" />
															<a id="details_<?php echo $j; ?>" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details</a>
														</td>
														<td style="text-align:right"><?php echo ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):''; ?></td>
														<td><?php echo $pendingbankentry[$i]['particulars']; ?></td>
														<td><?php if(isset($pendingbankentry[$i]['payer_name'])) echo $pendingbankentry[$i]['payer_name']; ?></td>
														<td><?php echo $pendingbankentry[$i]['property']; ?></td>
														<td><?php echo $pendingbankentry[$i]['sub_property']; ?></td>
														<td style="text-align:right"><?php echo format_money($pendingbankentry[$i]['net_amount'],2); ?></td>
														<td style="text-align:right"><?php echo format_money($pendingbankentry[$i]['paid_amount'],2); ?></td>
														<td style="text-align:right"><?php if(isset($pendingbankentry[$i]['bal_amount'])) echo format_money($pendingbankentry[$i]['bal_amount'],2); ?></td>
														<!-- <td style="text-align:right"><?php //if(isset($pendingbankentry[$i]['tax_amount'])) echo format_money($pendingbankentry[$i]['tax_amount'],2); ?></td> -->
													</tr>
													<?php $j++; }} ?>
													<!-- <tr class="odd-cell">
														<td colspan="6" style="background-color:#f6f9fc!important;">Sub-Total</td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td style="display: none;"></td>
														<td>40,000</td>
														<td>0</td>
														<td>20,000</td>
														<td>100</td>
														<td></td>
													</tr> -->
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
	$(".daterange").datepicker();
</script>

</body>
</html>