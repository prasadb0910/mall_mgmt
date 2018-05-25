<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

                                    
		

		 <style>
            .tile {padding: 0px;
                   min-height: 77px;}
            .list-group-item-reports {
                position: relative; text-decoration:none; color:#555;
                display: block; font-size:13px; font-weight:500;
                padding: 8px 15px; border-top:1px solid #eee;
                margin-bottom: -1px;
                background-color: #fff;
                
            }
            h3 { font-weight: 500; }
            .list-group-item-reports:hover { text-decoration:none;  background-color: #245478; color:#fff;}
            .message-box .mb-container .mb-middle {
                width: 100%; 
                left: 0%;
                position: relative;
                color: #000;
            }
            .message-box .mb-container {
                position: absolute;
                left:31%;
                top: 19%;
                border-radius:2px;
                background: rgba(0, 0, 0, 0.9);
                padding: 20px;
                width: 36%;
            }
            #divCheckAll label { padding-left:5px; font-size:15px;}
            #divCheckAll {
                background-color: #F2F2F2; height:40px;
                border: #e1e1e1 1px solid; 
                padding:8px 10px;
            }
            #divCheckboxList .divCheckboxItem label { padding-left:5px; position:relative; font-weight:500; font-size:13px; } 
            #divCheckboxList { height:185px; z-index:9; overflow-y:scroll; margin-bottom:15px; }
            #divCheckboxList .divCheckboxItem { background:#f9f9f9; padding:6px 0 5px 10px; z-index:0; border-bottom:1px solid #eee;  border-top:1px solid #fff; border-left:1px solid #eee; border-right:1px solid #eee;  }
            #divCheckboxList .divCheckboxItem:nth-child(odd) { background:#fff;}
            .option { font-size:13px; }
            .text-decoration:hover { text-decoration:none; color:#000;}
            a { text-decoration:none;}
            .text-decoration a { text-decoration:none;}
            .selected { background:#f00;}

            @media only screen and (max-width:850px) {
                .message-box .mb-container { position:absolute; left:10%; top:12%; border-radius:2px; background:rgba(0, 0, 0, 0.9); marging:20px; width:80%; }
            }
			.panel.panel-success {

    border: solid 1px #eee!important;
	    border-top: solid 2px #95b75d!important;
	    border-bottom: solid 2px #eee!important;
	    
}
        </style>
    
    </head>
    <body>

    <!-- <form method ="post" action="<?php //echo base_url() . 'index.php/reports/update_report_groups/1'?>"> -->
        <!-- START PAGE CONTAINER -->
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

<div class=" container-fluid  p-t-20 p-b-20 container-fixed-lg bg-white" >


 <div class="card card-transparent">
                                                                  
								
							   <div class="row push-up-10" style="padding:5px;">
									<div class="col-md-4" <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Group Level</h3>
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/1'?>" id="report_1" class="list-group-item-reports" <?php if(isset($rep_1_view)) {if($rep_1_view==1) {if(isset($rep_1)) {if($rep_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Asset Allocation-Owner wise </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/2'?>" id="report_2" class="list-group-item-reports" <?php if(isset($rep_2_view)) {if($rep_2_view==1) {if(isset($rep_2)) {if($rep_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/3'?>" id="report_3" class="list-group-item-reports" <?php if(isset($rep_3_view)) {if($rep_3_view==1) {if(isset($rep_3)) {if($rep_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/4'?>" id="report_4" class="list-group-item-reports" <?php if(isset($rep_4_view)) {if($rep_4_view==1) {if(isset($rep_4)) {if($rep_4==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Maintenance Property Tax </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/5'?>" id="report_5" class="list-group-item-reports" <?php if(isset($rep_5_view)) {if($rep_5_view==1) {if(isset($rep_5)) {if($rep_5==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/6'?>" id="report_6" class="list-group-item-reports" <?php if(isset($rep_6_view)) {if($rep_6_view==1) {if(isset($rep_6)) {if($rep_6==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/19'?>" id="report_19" class="list-group-item-reports" <?php if(isset($rep_19_view)) {if($rep_19_view==1) {if(isset($rep_19)) {if($rep_19==0) echo 'style="display: none;"';} else echo 'style="display: none;"';}  else echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Details </a>
                                               <!-- <button class="btn btn-default" data-toggle="modal" data-target="#modal_large">Large</button> -->
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
									<div class="col-md-4" <?php if(isset($rep_grp_2)) {if($rep_grp_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Owner Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/7'?>" id="report_7" class="list-group-item-reports" <?php if(isset($rep_7)) {if($rep_7==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/8'?>" id="report_8" class="list-group-item-reports" <?php if(isset($rep_8)) {if($rep_8==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/9'?>" id="report_9" class="list-group-item-reports" <?php if(isset($rep_9)) {if($rep_9==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/10'?>" id="report_10" class="list-group-item-reports" <?php if(isset($rep_10)) {if($rep_10==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/20'?>" id="report_20" class="list-group-item-reports" <?php if(isset($rep_20)) {if($rep_20==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Details </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
									<div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Asset Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/11'?>" id="report_11" class="list-group-item-reports" <?php if(isset($rep_11)) {if($rep_11==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Profitability </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/12'?>" id="report_12" class="list-group-item-reports" <?php if(isset($rep_12)) {if($rep_12==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Purchase Variance </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/13'?>" id="report_13" class="list-group-item-reports" <?php if(isset($rep_13)) {if($rep_13==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/14'?>" id="report_14" class="list-group-item-reports" <?php if(isset($rep_14)) {if($rep_14==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Rent </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/15'?>" id="report_15" class="list-group-item-reports" <?php if(isset($rep_15)) {if($rep_15==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/16'?>" id="report_16" class="list-group-item-reports" <?php if(isset($rep_16)) {if($rep_16==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Sale Variance </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/17'?>" id="report_17" class="list-group-item-reports" <?php if(isset($rep_17)) {if($rep_17==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Purchase </a>
                                                <a href="<?php echo base_url() . 'index.php/export/set_report_criteria/18'?>" id="report_18" class="list-group-item-reports" <?php if(isset($rep_18)) {if($rep_18==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Loan </a>
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
								</div>
                                
                                <!-- <div class="row push-up-10">
									<div class="col-md-4">
                                        <div class="">
                                            <h3 class="">Task Reoprts</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_16" class="list-group-item-reports" <?php //if(isset($rep_16)) {if($rep_16==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Accounting Policies</a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_17" class="list-group-item-reports" <?php //if(isset($rep_17)) {if($rep_17==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Depreciation Accounting </a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_18" class="list-group-item-reports" <?php //if(isset($rep_18)) {if($rep_18==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Accounting for Leases </a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_19" class="list-group-item-reports" <?php //if(isset($rep_19)) {if($rep_19==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Earnings per Share</a>  
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_20" class="list-group-item-reports" <?php //if(isset($rep_20)) {if($rep_20==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Financial Instruments</a>
                                            </div>
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="">
                                            <h3 class="">Property Reports</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            
                                            <div class="panel-body list-group">
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_21" class="list-group-item-reports" <?php //if(isset($rep_21)) {if($rep_21==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span>  Policies</a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_22" class="list-group-item-reports" <?php //if(isset($rep_22)) {if($rep_22==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span>  Accounting</a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_23" class="list-group-item-reports" <?php //if(isset($rep_23)) {if($rep_23==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span>  Leases</a>
                                                 <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_24" class="list-group-item-reports" <?php //if(isset($rep_24)) {if($rep_24==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Revenue</a>
                                                  <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_25" class="list-group-item-reports" <?php //if(isset($rep_25)) {if($rep_25==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Earnings</a>
                                          </div>
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="">
                                            <h3 class="">Expense Reports</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_26" class="list-group-item-reports" <?php //if(isset($rep_26)) {if($rep_26==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Accounting for Leases </a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_27" class="list-group-item-reports" <?php //if(isset($rep_27)) {if($rep_27==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Revenue Recognition</a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_28" class="list-group-item-reports" <?php //if(isset($rep_28)) {if($rep_28==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span>  Share </a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_29" class="list-group-item-reports" <?php //if(isset($rep_29)) {if($rep_29==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Leases </a>
                                                <a href="<?php //echo base_url() . 'index.php/reports/download_report'?>" id="report_30" class="list-group-item-reports" <?php //if(isset($rep_30)) {if($rep_30==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><span class="fa fa-external-link"></span> Financial Instruments</a>
                                            </div>
                                        </div>
                                    </div>
								</div> -->
							</div>
						</div>
						</div>
						</div>
					</div>
                    </div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <?php $this->load->view('templates/footer');?>
		 </div>
						
                    </div>
		<?php $this->load->view('templates/script');?>
    </body>
</html>