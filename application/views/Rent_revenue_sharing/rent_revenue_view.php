<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
		#kyc-section b
		{
		margin-bottom: 15px;
	    color: #4a65da;
	    font-size: 14px!important;
	    font-weight: 600!important;
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		.block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
		}
		.created_date {
			text-align:center;
		}
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
			margin-left:0px!important;
		}
		.print {
			color:#fe970a!important;
			display:none!important;
		}
		.a {
			border-bottom: 2px solid #edf0f5;
			margin-bottom: 25px!important;
			padding-bottom: 25px!important;
		}
		.btn-group-justified {
			margin-left:2px;
		}
		.leases_status {
			border: 1px solid #41a541;
			color: #41a541;
			background-color: transparent;
			border-color: #41a541;
			display: inline-block;
			padding: 2px 8px;
			border-radius: 4px;
			font-size: 11px;
			font-weight: 400;
			font-style: normal;
			letter-spacing: 0.0625em;
			text-transform: lowercase;
			font-family: "Montserrat";
		}
		.view-block-btn .btn {
			width:100%;
			margin-bottom:15px;
		}
		.m-panel__view article {
			min-width: 100%;
			margin-bottom: 25px;
			padding-bottom: 10px;
			border-bottom: 2px solid #edf0f5;
			font-family: "Montserrat";
		}
		.view-block {
			display:inline-flex;
		}
		#contact1 {
			width: 60px;
			height: 60px;
			text-align: left;
			float: none;
			margin: 15px auto;
			display: block;
		}
		.info {
			text-align:center;
		}
		.email {
			font-size:13px!important;
			color:#4a65da!important;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif!important;
		}
		.title_1 {
			margin-bottom:5px!important;
			font-size: 1.14286rem!important;
			font-family: inherit!important;
			font-weight: 500!important;
			letter-spacing: 0.02em!important;
			text-transform: capitalize!important;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif!important;
		}
		.mob_no {
			text-align:center;
			font-size: 14px;
			color: #8b92a2;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif!important;
		}
		.view-title {
			margin-bottom: 15px;
			color: #4a65da;
			font-size: 14px!important;
			font-weight: 600!important;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif!important;
		}
		article {
			min-width: 100%;
			padding-bottom: 10px;
			border-bottom: 2px solid #edf0f5;
		}
		.info-name-property {
			font-weight: 600;
			text-transform: capitalize;
			font-size: 14px;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		a {
			color: #41a541;
			text-decoration: none;
			cursor: pointer;
			outline: medium none;
			-webkit-transition: color 0.2s ease 0s;
			transition: color 0.2s ease 0s;
		}
		.m-property-info {
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
			font-weight:500;
		}
		.info-location .icon-svg {
			margin-right: 5px;
		}
		.info-location {
			display: inline-flex;
		}
		.unit-options {
			display: inline-flex;
			-webkit-box-flex: 1;
			-webkit-flex: 1 0 auto;
			-webkit-box-align: center;
			align-items: center;
			height: 44px;
		}
		small {
			font-size: 12px;
			font-weight: 400;
		font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
			color: #8c919e;
		}
		.unit-options>div>span {
			font-size: 1.07143rem;
			font-weight: 600;
			padding:10px;
		}
		.title-block>span {
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
			font-size: 16px;
			font-weight: 400;
		}
		.title-block>h4 {
			margin-top: 4px!important;
			font-size: 14px;
			font-weight: 600;
		}
		.title-block {
			min-width: 120px;
		}
		.title-block .period {
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
			font-size: 16px;
			font-weight: 400;
		}
		.view_block_type_lease h5 {
			font-size:14px!important;
			font-weight:600!important;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
			
		}
		.view-block-date h5
		{
	
			font-size:14px!important;
			font-weight:600!important;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		.m-status--leases-type {
			padding: 1px 15px;
			color: #40434b;
			border: 1px solid #e6ebf1;
			background-color: #f6f9fc;
			border-radius: 4px;
			font-size: 11px;
			font-weight: 400;
			font-style: normal;
			letter-spacing: 0.0625em;
			text-transform: lowercase;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		.files-item {
			padding: 15px;
			position: relative;
			width: 65px;
			height: 70px;
			border: 2px solid #e6ebf1;
			display: inline-flex;
			-webkit-box-align: center;
			-webkit-align-items: center;
			-ms-flex-align: center;
			align-items: center;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			-webkit-flex-direction: column;
			-ms-flex-direction: column;
			flex-direction: column;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-ms-flex-pack: center;
			justify-content: center;
			margin-bottom: 20px;
			margin-right: 26px;
		}
		.file-icon-lg {
			font-size: 40px;
			color:#f77171!important;
		}
		.item-title {
			position: absolute;
			font-size: 0.71429rem;
			left: 0;
			bottom: -20px;
			white-space: nowrap;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		.view_table
		{
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif!important;
		}
		// .utilities-block {
			// border: 2px solid #f6f9fc;
			// padding: 20px;
			// margin-bottom: 20px;
			// -webkit-box-flex: 1;
			// -webkit-flex-grow: 1;
			// -ms-flex-positive: 1;
			// flex-grow: 1;
		// }
		.utilities-tag .tag {
			padding: 4px 10px;
			
			border: 1px solid #41a541;
			border-radius: 100px;
			color: #41a541;
			font-size: 9px;
			font-weight: 700;
			text-transform: uppercase;
			white-space: nowrap;
			display: inline-block;
			font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
		}
		.dropdown-item input {
			display: inline; 
			padding-left: 0px;
			cursor: pointer;
			font-size: 13px;
		}
		.select2-selection, .select2-selection__rendered{
			background: white!important;
			color: rgba(0, 0, 0, 0.36)!important;
			font-weight: normal;
		}
		.select2-selection__arrow {
			display: none;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
	<?php $this->load->view('templates/main_header');?>
	<div class="page-content-wrapper ">
		<div class="content ">
			<form id="form_rent_view" role="form" method ="post" action="<?php //echo base_url().'index.php/Rent/update/'.$r_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Rent_revenue_sharing">REVENUE LIST</a></li>
					<li class="breadcrumb-item active">Revenue View</li>
				</ol>
				<div class="container">
					<div class="row">
						<div class="card card-transparent  bg-white" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="javascript:void(0)">
									<div class="pull-left" style="padding-top: 6px;padding-left:15px;">
										<span style="font-size:16px;"><i class="fa fa-file-text-o" style="font-size:24px"></i> Lease</span>
									</div>
								</a>
								<div class="dropdown pull-right hidden-md-down" style="padding-right:7px;">
									<button class="profile-dropdown-toggle pull-right"  type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="fileUpload blue-btn btn width100">
											<span><i class="fa fa-ellipsis-h"></i></span> 
										</div>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
										<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
											<a href="<?php echo base_url().'index.php/Rent_revenue_sharing/add'?>" class="dropdown-item edit" ><i class="pg-settings_small"></i>Add</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										<?php if(isset($editrent)) { ?>
										<?php if($editrent[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i>  <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } else if($editrent[0]->modified_by != '' && $editrent[0]->modified_by != null) { if($editrent[0]->modified_by!=$rentby) { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($editrent[0]->created_by != '' && $editrent[0]->created_by != null) { if($editrent[0]->created_by!=$rentby && $editrent[0]->txn_status != 'In Process') { if($editrent[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
										<?php } } } ?>

										<a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
									</div>
								</div>
							</div>
						</div>
						<?php if(isset($rent)){?>
						<div class="card card-transparent  bg-white" style="background:#fff;">
							<div class="row">
								<div class="col-md-9">
									<div class=" container-fluid  container-fixed-lg bg-white p-b-10">
										
										<div class="card card-transparent">
											<article>
												<h5 class="view-title">Property information &amp; terms</h5>
												<div class="m-property-info ">
													<div class="info-name-property">
														<span>
															<a class="info-link" href="">
																<a class="info-link" href="">
																<?=$rent[0]->unit_name?> 
															</a>
															</a>
															<span>, </span>
														</span><!-- 
														<a  class="info-link" title="" href="">
															Building
														</a> -->
													</div>
													<!-- <div class="info-location">
														<div class="icon-svg">
															<i class="fa fa-map-marker" aria-hidden="true"></i>
														</div>
														<div class="location-address">
															<address><?php //echo $editrent[0]->p_address; ?></address>
															<address><?php //echo $editrent[0]->p_googlemaplink; ?></address>
														</div>
													</div> -->
												</div>
												<div class="unit-options">
													<!-- <div>
														<span>1</span>
														<small>bed</small>
													</div> &nbsp /
													<div>
														<span>1</span>
														<small>bath</small>
													</div> &nbsp / -->
													<div>
														<span>Area - <?=$rent[0]->area?></span>
														<small><?=$rent[0]->area_unit?></small>
													</div>
												</div>
											</article>
											<article class="period-transaction">
												<section>
													<div class="row">
														<div class="col-md-12 col-sm-4">
															<div class="transaction-item">
																<div class="view-block m-b-0">
																	
																	<div class="title-block">
																		<h4>Locking Period</h4>
																		<span class="period"><?=$rent[0]->locking_period?></span>
																	</div>
																
																	
																</div>
															</div>
														</div>
													</div>
												</section>
											</article>
											<?php 
											if(isset($revenue_sharing))
											{ ?>
												<article class="lease-transaction">
														<h5 class="view-title">Entered Revenue Amount</h5>
														
										<div class="row clearfix">
											<table class="view_table">
												<thead>
													<tr>
														<th>Month</th>
														<th>Revenue Amount (In ₹)</th>
														<th>Rent Amount (In ₹)</th>
														<th>Revenue (In ₹)</th>
														<th>Total Rent Amount (In ₹)</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
														<?php 
															if(isset($revenue_sharing))
															{
																foreach ($revenue_sharing as $key => $value) {
																
																$total_rent_amt=$value['revenue_sharing_amount'] + $value['rent_amount']
															?>
														
													<tr class="odd gradeX">
														
														<td><?=$value['event_date']?></td>
														<td><?=format_money($value['revenue_amount'],2)?></td>
														<td><?=format_money($value['rent_amount'],2)?></td>
														<td><?=$value['revenue_sharing_amount']?></td>
														<td><?=$total_rent_amt?></td>
														<td><a href="<?php echo base_url().'index.php/Rent_revenue_sharing/edit/'.$r_id.'/'.$value['revenue_schedule_id'] ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a></td>
												
													</tr>
													<?php }} ?>
												</tbody>
											</table>
										</div>
														
														
														
														
														
														
														
														
														
											
														</section>
												</article>
												
											<?php }?>
										</div>
										
									</div>
								</div>
								<div class="col-md-3" style="background-color: #f6f9fc;border-left: 2px solid #edf0f5;padding:20px;">
									<div class="status" style="float:right">
										<!-- <span class="leases_status">Active</span>
										<span class="leases_status status_name">#1</span> -->
									</div>
									<div class="view_block_type_lease  p-b-20" style=" border-bottom:2px solid #edf0f5;">
										<div class="m-b-10">
											<h5  style="font-size:16px;font-weight:600">Revenue is pending For</h5>
											<div class="date-type">
											<div>
												<?php 
													if(isset($revenue_sharing_pending))
													{
														foreach ($revenue_sharing_pending as $key => $value1) {
														
													?>
												<div>
													<span><?=$value1['event_date']?></span>
												</div>
												<?php   } } ?>
											</div>
										</div>
										</div>
									</div>
									
								</div>
						</div>
						<?php } ?>
					</div>
					</div>
				</div>
			</div>
    		</form>
		</div>
		<?php $this->load->view('templates/footer');?>
	</div>
</div>

<?php $this->load->view('templates/script');?>
</body>
</html>