<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	
	<style>
	.view_table
	{
		margin-left:12px;
		margin-right:12px;
	}
        #image-preview {
            min-width: auto;
            min-height: 250px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
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
			color:#fff!important;
			border-right:2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-color: rgba(255,255,255,0.1) !important;	
		}
		.rent:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.leases {
			color:#fff!important;
			border-top: 2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-right:2px solid #edf0f5;
			border-color: rgba(255,255,255,0.1) !important;
		}
		.leases:hover {
			background-color: rgba(255,255,255,0.1) !important;
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
		.user-roommates:after {
			content: '';
			position: absolute;
			left: 50%;
			top: 161px;
			width: 22px;
			height: 1px;
			margin-left: -11px;
			background-color: #e6ebf1;
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
		#pricing_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		#invoice_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		.block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left:12px;
			margin-right:12px;
		}
		p {
			font-weight: 200px!important;
			margin-left:12px;
			
		}
		.created_date {
			text-align:center;
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
			<form id="form_sale_view" role="form" method ="post" action="<?php echo base_url().'index.php/Sale/update/'.$s_id; ?>" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Sale/checkstatus/All">Sale List</a></li>
					<li class="breadcrumb-item active">Sale View</li>
				</ol>
				<div class="container">
					<div class="row">
					<div class="col-md-12">
						<div class="card card-transparent  bg-white" style="background:#fff;">
							<div class=" " style="padding:10px;">
								<a href="<?php echo base_url().'index.php/Sale'; ?>">
									<div class="fileUpload blue-btn btn width100 pull-left">
										<span><i class="fa fa-arrow-left"></i></span> 
									</div>
								</a>
								<div class="dropdown pull-right hidden-md-down">
									<button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="fileUpload blue-btn btn width100">
											<span><i class="fa fa-ellipsis-h"></i></span> 
										</div>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
										<?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
											<a href="<?php echo base_url().'index.php/Sale/edit/'.$s_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>

										<!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

										
										
										
										
										
										
											<?php if(isset($s_txn)) { ?>
										<?php if($s_txn[0]->txn_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i>  <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> </a>
										<?php } } } else if($s_txn[0]->modified_by != '' && $s_txn[0]->modified_by != null) { if($s_txn[0]->modified_by!=$saleby) { if($s_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
			                              	<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
											<a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
										<?php } } } } else { ?>
											<!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
											<a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
										<?php } } else if($s_txn[0]->created_by != '' && $s_txn[0]->created_by != null) { if($s_txn[0]->created_by!=$saleby && $s_txn[0]->txn_status != 'In Process') { if($s_txn[0]->txn_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
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
						</div>
								<div class="col-md-3" style="background: linear-gradient(45deg, #39414d 0%, #39414d 25%, #444c59 51%, #4c5561 78%, #4e5663 100%); padding-right: 15px;padding-left: 15px;">
							  <div class="p-t-20">
			                     
			                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($s_txn->p_image)) echo base_url().$s_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
			                            <!-- <input type="file" name="image" id="image-upload" /> -->
			                            <!-- <img src="<?php //echo base_url().$sub_property[0]->c_image; ?>"> -->
			                        </div>
			                        <!-- <div id="image-label_field">
			                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
			                        </div> -->
			                    </div>
					
							<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2);">
								<div class="row" style="">
									<div class="col-md-6 rent">
										<b style="font-size:22px;"><?php//$tenant_count?></b><br>
										Tenant
									</div>
									<div class="col-md-6 rent" style="border-right:none;">
										<b style="font-size:22px;" ><?php//$maintenance_count?></b><br>
										Maintenance 
									</div>
								
								</div>
							</div>
						
						</div>
						<div class="col-md-9">
							<div class="container-fluid container-fixed-lg bg-white">
								<div class="card card-transparent">
									<p class="m-t-20"></p>
									<div class="a">
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default form-group-default-select2">
													<label>Property</label>
													<select  class="form-control full-width" id="property" name="property" onchange="loadclientdetail(); getdocuments();" data-init-plugin="select2" disabled>
			                                          
			                                            <?php if(isset($s_txn)) { 
                                                for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->property_txn_id; ?>" <?php if($s_txn[0]->property_id == $property[$i]->property_txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->unit_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->property_txn_id; ?>"><?php echo $property[$i]->unit_name; ?></option>
                                            <?php } } ?>
											
			                                        </select>
												</div>
											</div>
											<div class="col-md-6" style="display:none">
												<div class="form-group form-group-default form-group-default-select2">
													<label>Sub Property</label>
													<select class="form-control full-width" id="sub_property" name="sub_property"   disabled>
			                                          
			                                            <?php if(isset($s_txn)) { 
			                                                for($i=0; $i<count($sub_property); $i++) { ?>
			                                                    <option value="<?php echo $sub_property[$i]->sp_id; ?>" <?php if($s_txn[0]->sub_property_id == $sub_property[$i]->sp_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
			                                            <?php } } else { ?>
			                                                    <?php for($i=0; $i<count($sub_property); $i++) { ?>
			                                                    <option value="<?php echo $sub_property[$i]->sp_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
			                                            <?php } } ?>
			                                        </select> 
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default ">
													<label>Date of Sale</label>
													<input type="text" class="form-control" id="sale_date" name="sale_date"  value="<?php if(isset($s_txn)) { if(count($s_txn)>0) {echo date('d/m/Y',strtotime($s_txn[0]->date_of_sale));}} ?>" readonly />
												</div>
											</div>
										</div>
										<p class="m-t-20"><b>Owner Details</b></p>
										<div class="row clearfix">
											<table class="view_table">
												<thead>
													<tr>
														<th>Sr No.</th>
														<th>Owner Name</th>
														<!--<th>% Share</th>-->
													</tr>
												</thead>
												<tbody>
													<?php $j=0; if(isset($s_owner)) { 
                                    					for ($j=0; $j < count($s_owner) ; $j++) { ?>
													<tr class="odd gradeX">
														<td><?php echo $j+1; ?></td>
														<td><?php echo $s_owner[$j]->c_name . ' ' . $s_owner[$j]->c_last_name; ?></td>
														<!--<td><?php// if(isset($s_owner[$j]->pr_ownership_percent)){ echo format_money($s_owner[$j]->pr_ownership_percent,2); } else { echo ''; }?></td>-->
													</tr>
													<?php }} ?>
												</tbody>
											</table>
										</div>

										<p class="m-t-20"><b>Buyer Details</b></p>
										<div class="row clearfix">
											<table class="view_table">
												<thead>
													<tr>
														<th>Sr No.</th>
														<th>Buyer Name</th>
														<th>% Share</th>
													</tr>
												</thead>
												<tbody>
													<?php $j=0; if(isset($s_buyer)) { 
                                    					for ($j=0; $j < count($s_buyer) ; $j++) { ?>
													<tr class="odd gradeX">
														<td><?php echo $j+1; ?></td>
														<td><?php echo $s_buyer[$j]->c_name . ' ' . $s_buyer[$j]->c_last_name; ?></td>
														<td><?php if(isset($s_buyer[$j]->share_percent)){ echo format_money($s_buyer[$j]->share_percent,2); } else { echo ''; }?></td>
													</tr>
													<?php }} ?>
												</tbody>
											</table>
										</div>
									</div>

									<div class="a">
										<p class=""><b>Sales Consideration</b></p>
										<div class="row clearfix">
											<table class="view_table" style="border-top:;">
												<thead>
													<tr>

														<th width="5%"> Sr. No. </th>
														<th width="65%"> Type  </th>                                                   
														<th width="15%" style="text-align:right;">Cost Buyer  (in &#x20B9;)</th>
														<?php //print_r($tax_name);
														if(isset($tax_name)){
														// echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
															$key=0;
															foreach($tax_name as $row){
																echo '<th width="15%" style="text-align:right;  text-transform: capitalize;">'.$row->tax_type.'</th>';
																$tax_array[$key]=$row->tax_type;
																$key++;
															} 
														//echo '</tr></table></th>';
														}
														?>
														<th width="15%" style="text-align:right;"> Net Cost (in &#x20B9;)</th>
													</tr>
												</thead>
											<tbody>
												<?php //print_r($p_schedule);?>
												<?php 
												$j=0;
												$total_basic_cost=0;
												$total_net_amount=0;
												$total_tax_array=array();
												foreach($p_schedule as $row_tax){
													echo '<tr>
													<td>'.($j+1).'</td>
													<td>'.$p_schedule[$j]["event_type"].'</td>

													<td style="text-align:right;">'.format_money($p_schedule[$j]["basic_cost"],2).'</td>';
													//echo count($p_schedule[$j]['tax_type']);
													/* if(isset($p_schedule[$j]['tax_type'])){
													for($tcnt=0;$tcnt<$key;$tcnt++){
													// print_r($p_schedule[$j]['tax_type']);
													$tax_amount='';
													if(count($p_schedule[$j]['tax_type'])>=($tcnt+1)){

													if($p_schedule[$j]['tax_type'][$tcnt]==$tax_array[$tcnt]){
													$tax_amount=$p_schedule[$j]['tax_amount'][$tcnt];
													}
													}
													echo '<td>'.$tax_amount.'</td>';
													}
													}*/
													//echo $key;
													$total_basic_cost=$total_basic_cost+$p_schedule[$j]["basic_cost"];

													$next_count=0;
													$td_count=0;
													if(isset($p_schedule[$j]['tax_type'])) {
													// for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
													//echo "<br>hi";
													// echo $key;
														for($tcnt=0;$tcnt<$key;$tcnt++){

													//echo "step1--";
															for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++){
																$tax_amount='';
																if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt])
																{
																	$tax_amount=$p_schedule[$j]['tax_amount'][$nc];
																	$nc=count($p_schedule[$j]['tax_type']);
													//$tcnt=$key;
													//}
																}
															}
															if($tax_amount !=''){
																echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
																$td_count++;

															}
															else{
													//if($next_count )
																echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
																$td_count++;
															}
													// $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
													//  $total_tax_array[$tcnt]= $tax_amount;
													// print_r($total_tax_array);




														}

													// }
													}
													$inserttd=$key-$td_count;
													if($inserttd !=0){
														for($tdint=0;$tdint<$inserttd;$tdint++){
															echo "<td></td>";
														}
													}


													echo'<td style="text-align:right;">'.format_money($p_schedule[$j]["net_amount"],2).'</td>
													</tr>';
													$total_net_amount=$total_net_amount+$p_schedule[$j]["net_amount"];
													//print_r($p_schedule[$j]['event_type']);
													$j++;


													}?>

												<tr>
													<td colspan="2"><b>Grand Total (in &#x20B9;)</b></td>
													<td style="text-align:right;"><?php echo format_money($total_basic_cost,2);?></td>
													<?php  $k=0;if(isset($total_tax_amount)) {
													foreach($total_tax_amount as $row){
														echo '<td style="text-align:right;">'.format_money($row,2).'</td>';
														$k++;
													} } ?>
													<td style="text-align:right;"><?php echo format_money($total_net_amount,2);?></td>
												</tr>
											</tbody>
											</table>
										</div>
									</div>

									<div class="a">
										<p class=""><b>Profit or Loss</b></p>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default ">
													<label>Cost of Purchase (In ₹)</label>
													<input type="text" class="form-control " value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_purchase,2); } else { echo '0'; } } else { echo '0'; } ?>" readonly>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default ">
													<label>Cost of Acquisition (In ₹)</label>
													<input type="text" class="form-control " value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_acquisition,2); } else { echo '0'; } } else { echo '0'; } ?>" readonly>
												</div>
											</div>
										</div>
										<div class="row clearfix">
											<div class="col-md-6">
												<div class="form-group form-group-default ">
													<label>Capital Gain (In ₹)</label>
													<input type="text" class="form-control " value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->profit_loss,2); } else { echo '0'; } } else { echo '0'; } ?>" readonly>
												</div>
											</div>
										</div>
									</div>

									<?php $this->load->view('templates/document_view');?>

									<p class=""><b>Remark<b></p>
									<div class="row clearfix" style="padding-bottom: 25px;">
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Maker Remarks </label>
												<input type="text" class="form-control "  value="<?php if (isset($s_txn)) { echo $s_txn[0]->maker_remark; } ?>" readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default ">
												<label> Checker Remarks </label>
												<input type="text" class="form-control "  value="<?php if (isset($s_txn)) { echo $s_txn[0]->remarks; } ?>" readonly>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-group-default " style="border:1px solid rgba(0,0,0,0.07)!important; ">
												<label>Remark</label>
												<input type="text" class="form-control " id="txtstatus" name="status_remarks" value="<?php if(isset($s_txn[0])){ echo $s_txn[0]->remarks; } else { echo ''; }?>">
											</div>
										</div>
									</div>
								</div>
							</div>
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