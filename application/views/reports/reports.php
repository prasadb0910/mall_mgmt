<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
 
		
        <!-- EOF CSS INCLUDE -->                                      
        
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
        </style>

        <style type="text/css">
            
            .page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;   }
            .dataTables_filter { border-bottom:0!important; }
            .heading-h2 { background:#eee; line-height: 25px; padding:7px 15px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px;      font-size: 14px; border-bottom:1px solid #d7d7d7;}
            .heading-h2 a{  color: #444;     }
            /*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
            font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
              border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
            .nav-contacts {/* float: right; width: 55%;*/ }
            .main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
            .main-container {margin:0 12px; margin-bottom: 20px; } 
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
            .box-shadow {margin: 20px 0; width:100%;  
            background: #fff;

            box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; display: inline-block;}
            .full-width  { padding: 10px; }
            .page-overflow { overflow:auto; }
            #approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
            .table thead tr th { padding:8px 5px!important; font-weight:600; }
            b, strong { font-weight:500;}
            .panel-body {padding: 0!important;}
            .btn-container {  }
            .btn-top { margin-top: 10px!important; }
            .box-shadow-inside { padding:0px;     display: flex; }
            .panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
             .panel-margin { margin: 0; border-radius: 0!important; box-shadow: none; border: 1px dotted #ddd!important } 
            .panel-heading {border-radius: 0; }
            .panel { margin-bottom:10px;   }

             

            .btn-primary { padding:6px 10px; }
            .table-responsive {  min-height: .01%; overflow-x: auto;  margin: 15px;}
            .remark-container {padding: 10px;}
            .form-group:nth-child(even) { }
            .form-group { padding: 10px 0; }
            .panel-heading-bnt { margin: 10px!important; display: flex; }
            .panel  span { margin:0!important; }
            .btn-margin { margin-left: 5px!important; display: inline-block; }
            .btn-top-margin { margin-top:-36px!important; margin-right: 15px; }
        </style>
    </head>
    <body>

    <!-- <form method ="post" action="<?php //echo base_url() . 'index.php/reports/update_report_groups/1'?>"> -->
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>       
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp;  Reports   </a>  </div>              
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                    <div class="main-container">  
                       <div class="box-shadow" style="padding-top:10px;">   
                        <div class="col-md-12">
                        <div class="panel panel-margin panel-default" style="pointer-events:unset !important;">                            
                            <div class="panel-body">   
                                <div class="row push-up-10" style="padding:5px;">
                                    <div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <a href="#" class="mb-control sch text-decoration popuptest" > <h3 class="">Group Level</h3>     </a>     
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_1" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Owner wise </a>
                                                <a href="#" id="report_2" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="#" id="report_3" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="#" id="report_4" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Maintenance Property Tax </a>
                                                <a href="#" id="report_5" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_6" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="#" id="report_19" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Details </a>
                                               <!-- <button class="btn btn-default" data-toggle="modal" data-target="#modal_large">Large</button> -->
                                            </div>
                                        </div>
                                        <!-- END CONTACTS WITH CONTROLS -->
                                    </div>
                                    <div class="col-md-4">
                                        <!-- CONTACTS WITH CONTROLS -->
                                        <div class="">
                                            <h3 class="">Owner Level</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_7" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Asset Allocation-Usage wise </a>
                                                <a href="#" id="report_8" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan Details </a>
                                                <a href="#" id="report_9" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_10" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent Summary </a>
                                                <a href="#" id="report_20" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Details </a>
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
                                                <a href="#" id="report_11" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Profitability </a>
                                                <a href="#" id="report_12" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Purchase Variance </a>
                                                <a href="#" id="report_13" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Related Party </a>
                                                <a href="#" id="report_14" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Rent </a>
                                                <a href="#" id="report_15" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale </a>
                                                <a href="#" id="report_16" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Sale Variance </a>
                                                <a href="#" id="report_17" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Purchase </a>
                                                <a href="#" id="report_18" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Loan </a>
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
                                                <a href="#" id="report_16" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Accounting Policies</a>
                                                <a href="#" id="report_17" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Depreciation Accounting </a>
                                                <a href="#" id="report_18" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Accounting for Leases </a>
                                                <a href="#" id="report_19" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Earnings per Share</a>  
                                                <a href="#" id="report_20" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Financial Instruments</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                                <h3 class="">Property Reports</h3>         
                                            </div>
                                        <div class="panel panel-success">
                                            
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_21" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span>  Policies</a>
                                                <a href="#" id="report_22" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span>  Accounting</a>
                                                <a href="#" id="report_23" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span>  Leases</a>
                                                <a href="#" id="report_24" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Revenue</a>
                                                <a href="#" id="report_25" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Earnings</a>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="">
                                            <h3 class="">Expense Reports</h3>         
                                        </div>
                                        <div class="panel panel-success">
                                            <div class="panel-body list-group">
                                                <a href="#" id="report_26" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Accounting for Leases </a>
                                                <a href="#" id="report_27" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Revenue Recognition</a>
                                                <a href="#" id="report_28" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span>  Share </a>
                                                <a href="#" id="report_29" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Leases </a>
                                                <a href="#" id="report_30" class="list-group-item-reports mb-control sch popuptest" data-box="#message-box-info"><span class="fa fa-external-link"></span> Financial Instruments</a>
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
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- start group popup -->
        <div class="message-box message-box-info animated fadeIn" id="message-box-info" style="overflow:auto;">
            <div class="mb-container" style="background:#fff;  ">
                <div class="mb-middle" >
                    <form id="form_report_groups" method ="post" action="#">
                    <div class="mb-content">
                        <div class="" >
                            <h3 style=" margin-bottom: 10px;     font-weight: 500;">Select group to assign report</h3>
                            <div id="divCheckAll">
                            <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" /> <label> Select All </label> </div>
                            <div id="divCheckboxList">
                            <?php if(isset($groups)) {for($i=0;$i<count($groups);$i++) { ?>
                                <div class="divCheckboxItem" ><input type="checkbox" name="group[]" class="chk-group" id="group_<?php echo $groups[$i]->g_id; ?>" value="<?php echo $groups[$i]->g_id; ?>" /> <label> <?php echo $groups[$i]->group_name; ?>  </label></div>
                            <?php }} ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-footer">
                        <div class="form-group" style="border:1px dotted #ddd; margin-bottom:10px;">
                            <div class="col-md-12">
                                <label class="option">Do you want to assign this report to All User Roles</label>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-3" style="padding-left:0;"> <input type="radio" id="all_roles_yes" name="roles" value="1" > Yes  </div>
                                <div class="col-md-4"> <input type="radio" id="all_roles_no" name="roles" value="0" > No </div>
                            </div>
                            <br clear="all">
                        </div>
                        <button class="btn btn-danger  mb-control-close"> Cancel </button>
                        <button id="save_report_groups" type="button" class="btn btn-success pull-right" >Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end group popup -->

        <?php $this->load->view('templates/footer');?>
        
        <script type="text/javascript">
            var report_id = 0;

            function check_uncheck_checkbox(isChecked) {
                if(isChecked) {
                    $('.chk-group').each(function() { 
                        this.checked = true;
                    });
                } else {
                    $('.chk-group').each(function() {
                        this.checked = false;
                    });
                }
            }

            $('.popuptest').click(function(){
            // alert("Hiiiiii");
                report_id=this.id;
                report_id=report_id.substring(7);
             //alert(report_id);

                //$("#form_report_groups-form").attr("action", "<?php echo base_url() . 'index.php/reports/update_report_groups/'?>" + report_id);
                
                $('#message-box-info').find('input[type=checkbox]').prop('checked', false);
                $('#message-box-info').find('input[type=radio]').prop('checked', false);

                $.ajax({
                    url: "<?php echo base_url() . 'index.php/reports/get_report_groups/' ?>" + report_id,
                    data: $("#form_report_groups").serialize(),
                    cache: false,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(data!=null) {
                            $.each(data, function(key,value) {
                                // alert(value.rep_grp_id + ' ' + value.rep_view);

                                if(value.rep_view==1) {
                                    // alert('#group_' + value.rep_grp_id);
                                    // $('#group_' + value.rep_grp_id).checked = true;
                                    $('#group_' + value.rep_grp_id).prop('checked', true);

                                } else {
                                    // $('#group_' + value.rep_grp_id).checked = false;
                                    $('#group_' + value.rep_grp_id).prop('checked', false);
                                }
                            });
                        }
                    },
                    error: function (data) {
    //                    alert(data);
                        $result = 0;
                    }
                });

                $.ajax({
                    url: "<?php echo base_url() . 'index.php/reports/get_report_roles/' ?>" + report_id,
                    data: $("#form_report_groups").serialize(),
                    cache: false,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        if(data!='') {
                            if(data==1) {
                                $('#all_roles_yes').prop('checked', true);
                            } else {
                                $('#all_roles_no').prop('checked', true);
                            }
                        }
                    },
                    error: function (data) {
    //                    alert(data);
                        $result = 0;
                    }
                });
            });

            $("#save_report_groups").click(function(){
                var $result = 0;
               // alert(report_id);
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/reports/update_report_groups/'?>" + report_id,
                    data: $("#form_report_groups").serialize(),
                    cache: false,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
    //                    alert(data);
                        if ($.isNumeric($.trim(data))) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }

                    },
                    error: function (data) {
    //                    alert(data);
                        $result = 0;
                    }
                });

                if ($result) {
                    // $(this).parents(".message-box").removeClass("open");
                    // $('#con_first_name').val('');
                    // $('#con_middle_name').val('');
                    // $('#con_last_name').val('');
                    // $('#con_email_id1').val('');
                    // $('#con_mobile_no1').val('');
                    $(this).parents(".message-box").removeClass("open");
                    return false;
                }
                else {
                    return false;
                }
                
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>