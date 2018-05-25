<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

<style>
.panel-reports--list {
;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-flex: 1;
  
    flex: 1 0 auto;
    border-right: 1px solid #edf0f5;
    border-left: 1px solid #edf0f5;
 
    box-shadow: 0 6px 32px -4px #edf0f5;
}
.m-panel {
    position: relative;
    border-radius: 1px;
    min-height: 1px;
  
    background-color: #ffffff;
    -webkit-box-shadow: none;
    box-shadow: none;
}
.panel-reports--list .m-panel__body .body-rentals {
    width: 100%;
}
.panel-reports--list .m-panel__body .body-rentals .rentals-items:not(:last-child) {
    border-bottom: 1px solid #edf0f5;
}
.panel-reports--list .m-panel__body .body-rentals .rentals-items {
    padding: 25px;
}
.panel-reports--list .m-panel__body .body-rentals .rentals-items>div {

    display: flex;
    -webkit-box-align: center;
  
    align-items: center;
}
.info-panel {
    padding-left: 10px;
    border-left: 2px solid #41a541;
}

.panel-reports--list .m-panel__body .body-rentals .rentals-items>div .info-panel>div .panel-heading {
   
}
.panel-heading:before
{
	content: "\f080 ";
    font-family: "FontAwesome";
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    display: inline-block;
    text-decoration: inherit;
    width: 1em;
    text-align: center;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    margin: 0;
    -webkit-font-smoothing: antialiased;
}
.u-textUpper {
    text-transform: uppercase !important;
}
.info-panel h3.panel-label {
    margin-bottom: 5px;
    font-size: 14px;
}
.info-panel .panel-description {
    margin: 0 0 10px;
    color: #8c919e;
    font-size: 0.85714rem;
}
.panel-reports--list .m-panel__body .body-rentals .rentals-items .rentals-view {
    text-align: right;
    width: 100px;
}
.m-btn-link--view {
    display: inline-block;
    padding: 0;
    border-width: 0;
    background-color: transparent;
    color: #41a541;
    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    font-size: 13px;
    line-height: 20px;
    font-weight: 500;
    -webkit-box-shadow: none;
    box-shadow: none;
    text-shadow: none;
    text-decoration: none;
    text-transform: lowercase;
    -webkit-transition: color 0.2s ease 0s;
    transition: color 0.2s ease 0s;
}

.panel-reports--list .m-panel__body .body-rentals .rentals-items>div .info-panel .panel-label {
    margin-bottom: 0;
}
small {
    font-size: 12px!important;
    font-weight: 400;
    display: block;
    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    color: #8c919e;
}
.info-panel h3.panel-label {
  font-weight: 600;
    color: #2b6e2b;
    font-size: 14px;
	    text-transform: capitalize;
		margin: 0;
    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    -webkit-font-smoothing: antialiased;
}

</style>

</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>

<div class="page-content-wrapper ">

<div class="content ">



<div class=" container-fluid   container-fixed-lg ">



<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
<li class="breadcrumb-item "><a href="#">Reports</a></li>

</ol>
<div class="row">






<div class="col-md-12">

<div class="m-panel panel-reports--list">
		<div class="m-panel__body">
			<div class="body-rentals">
				<!----><!---->
				<div class="group_level  <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>">
				<div class="rentals-items" <?php if(isset($rep_1_view)) {if($rep_1_view==1) {if(isset($rep_1)) {if($rep_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
							

								<div class="panel-heading">
									<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Asset Allocation-Owner wise</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/1'?>" id="report_1" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				<div class="rentals-items" <?php if(isset($rep_2_view)) {if($rep_2_view==1) {if(isset($rep_2)) {if($rep_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								
								<div class="panel-heading">
									<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Asset Allocation-Usage wise</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/2'?>" id="report_2" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				<div class="rentals-items" <?php if(isset($rep_3_view)) {if($rep_3_view==1) {if(isset($rep_3)) {if($rep_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> 
					<div>
						<div class="info-panel">
							<div>
								
								<div class="panel-heading">
									<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Loan Details</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/3'?>" id="report_3" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				<div class="rentals-items" <?php if(isset($rep_4_view)) {if($rep_4_view==1) {if(isset($rep_4)) {if($rep_4==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Maintenance Property Tax</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/4'?>" id="report_4" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
					<div class="rentals-items" <?php if(isset($rep_5_view)) {if($rep_5_view==1) {if(isset($rep_5)) {if($rep_5==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
								<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Related Party</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/5'?>" id="report_5" class="list-group-item-reports" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
				
					<div class="rentals-items" <?php if(isset($rep_6_view)) {if($rep_6_view==1) {if(isset($rep_6)) {if($rep_6==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Group Level</small>

									<h3 class="panel-label">
										<a>Rent Summary</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view" href="<?php echo base_url() . 'index.php/export/set_report_criteria/6'?>" id="report_6" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
				
				
					<div class="rentals-items"  <?php if(isset($rep_19_view)) {if($rep_19_view==1) {if(isset($rep_19)) {if($rep_19==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Group Level </small>

									<h3 class="panel-label">
										<a>Sale Details</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/19'?>" id="report_19" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				</div><!----><!----><!---->
				
				
				
					<div <?php if(isset($rep_grp_2)) {if($rep_grp_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?> >
					<div class="rentals-items" <?php if(isset($rep_7)) {if($rep_7==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Owner Level</small>

									<h3 class="panel-label">
										<a>Asset Allocation-Usage wise</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/7'?>" id="report_7" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
					<div class="rentals-items" <?php if(isset($rep_8)) {if($rep_8==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Owner Level</small>

									<h3 class="panel-label">
										<a>Loan Details</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/8'?>" id="report_8" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_9)) {if($rep_9==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Owner Level</small>

									<h3 class="panel-label">
										<a>Related Party</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view" href="<?php echo base_url() . 'index.php/export/set_report_criteria/9'?>" id="report_9" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
				
					<div class="rentals-items" <?php if(isset($rep_10)) {if($rep_10==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Owner Level</small>

									<h3 class="panel-label">
										<a>Rent Summary</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/10'?>" id="report_10" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
	
				
				
				
					<div class="rentals-items" <?php if(isset($rep_20)) {if($rep_20==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Owner Level</small>

									<h3 class="panel-label">
										<a>Sale Details</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  "<?php echo base_url() . 'index.php/export/set_report_criteria/20'?>" id="report_20" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_11)) {if($rep_11==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Profitability</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/11'?>" id="report_11" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_12)) {if($rep_12==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Purchase Variance</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/12'?>" id="report_12" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
					<div class="rentals-items" <?php if(isset($rep_13)) {if($rep_13==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Related Party</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/13'?>" id="report_13" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
					<div class="rentals-items" <?php if(isset($rep_14)) {if($rep_14==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Rent</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/14'?>" id="report_14" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_15)) {if($rep_15==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Sale</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/15'?>" id="report_15" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_16)) {if($rep_16==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Sale Variance</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view" href="<?php echo base_url() . 'index.php/export/set_report_criteria/16'?>" id="report_16" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
					<div class="rentals-items" <?php if(isset($rep_17)) {if($rep_17==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Purchase</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view"  href="<?php echo base_url() . 'index.php/export/set_report_criteria/17'?>" id="report_17" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
					<div class="rentals-items" <?php if(isset($rep_18)) {if($rep_18==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					<div>
						<div class="info-panel">
							<div>
								

								<div class="panel-heading">
									<small class="u-textUpper" >Asset Level</small>

									<h3 class="panel-label">
										<a>Loan</a>
									</h3>
								</div>
							</div>

							<p class="panel-description">This report gives you the ability to find and review screening reports during a specific date range. Within this date range, you can select to include reports for a specific property, unit, report provider and type of report package.</p>
						</div>

						<div class="rentals-view">
							<a class="m-btn-link--view" href="<?php echo base_url() . 'index.php/export/set_report_criteria/18'?>" id="report_18" class="list-group-item-reports">
								<span>view</span>
								<span><i class="fa fa-angle-right"></i></span>
							</a>
						</div>
					</div>
				</div><!----><!----><!---->
				
				
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



<?php $this->load->view('templates/script');?>
 <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>