<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="<?php echo base_url(); ?>image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<!--[if lt IE 9]>
        <script src="dist/html5shiv.js"></script>
        <![endif]-->
        <!-- EOF CSS INCLUDE -->                                      
		<style>
	       .page-content page-overflow { height:auto!important;}
            .page-container .page-content .page-content-wrap { background:#fff;  margin:0px; width: auto!important; float: none;   }
            .dataTables_filter { border-bottom:0!important; }
            .heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: block;  margin-top: 61px; border-bottom:1px solid #d7d7d7; font-size:14px;  }
            .heading-h2 a{  color: #444;      }
            /*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
            font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
              border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
            .nav-contacts {/* float: right; width: 55%;*/ }
            .main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
            .main-container {margin:0 12px; } 
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
            .col-md-12 {}
            .full-width {
            margin-top: 20px; display:inline-block;
            background: #fff;
            padding: 15px 25px;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px;	
            	
            }
            .dropdown-toggle{
            background: none !important;
            color: #53ad53 !important;
            border-color: #53ad53 !important;
            }
            .dropdown-toggle:hover {
            background: #53ad53 !important;
            color: #fff !important;
            }
            .table thead tr th { padding:8px 5px!important; font-weight:600; }
            b, strong {
            font-weight:500;
            }
            .page-overflow { overflow:auto; }
            .panel { margin-bottom:0;}
            .nav-contacts { /*margin-top:-40px;*/ float:right;}
            /*------------------------------------------*/

            .m-nav>li a,.m-nav--linetriangle>li a{display:inline-block;border-radius:0; padding:0px 20px 6px;margin-right:0;font-family:"Montserrat", "TenantCloud Sans", Avenir, sans-serif;font-weight:400;color:rgba(98,98,98,0.7);font-size:0.875rem;min-width:70px;text-transform:uppercase;border-color:transparent}
            .dataTables_scrollHeadInner {width:auto!important: padding:0!important;}

            /*-----------------------------*/
             .dataTables_scrollHead {  border-right:1px  solid #ddd!important;}
             .dataTables_scrollBody {   border-bottom:1px  solid #ddd!important;  }
            .responsive-table-bordered tr th:first-child{ width:45px!important;  text-align:center;} 
            .responsive-table-bordered tr th:nth-child(2){ width:222px!important; } 
            .responsive-table-bordered tr th:nth-child(3){ width:72px!important; } 
            .responsive-table-bordered tr th:nth-child(4){ width:72px!important; } 
            .responsive-table-bordered tr th:nth-child(5){ width:75px!important; } 
            .responsive-table-bordered tr th:nth-child(6){ width:75px!important; } 
            .responsive-table-bordered tr th:nth-child(7){ width:70px!important; } 
            .responsive-table-bordered tr th:nth-child(8){ width:90px!important; } 
            .responsive-table-bordered tr th:nth-child(9){ width:65px!important; } 
            .responsive-table-bordered tr th:nth-child(10){ width:95px!important; } 
            .responsive-table-bordered tr th:last-child { width:60px!important;   text-align:center;} 



            .responsive-table-bordered tr td:first-child{ width:34.8px!important;} 
            .responsive-table-bordered tr td:nth-child(2){ width:211px!important;} 
            .responsive-table-bordered tr td:nth-child(3){ width:62px!important;} 
            .responsive-table-bordered tr td:nth-child(4){ width:63px!important;} 
            .responsive-table-bordered tr td:nth-child(5){ width:65px!important;} 
            .responsive-table-bordered tr td:nth-child(6){ width:64px!important;} 
            .responsive-table-bordered tr td:nth-child(7){ width:60px!important;} 
            .responsive-table-bordered tr td:nth-child(8){ width:80px!important;} 
            .responsive-table-bordered tr td:nth-child(9){ width:53px!important;} 
            .responsive-table-bordered tr td:nth-child(10){ width:86px!important;} 
            .responsive-table-bordered tr td:last-child { width:59px!important;  text-align:center;} 

            *--------------*/


            /*-----------------------------*/

            .responsive-cashflow-table thead tr th:first-child{   text-align:center;     width: 53px!important;} 
            .responsive-cashflow-table thead tr th:first-child { width:52px!important;}
            .responsive-cashflow-table thead tr th:nth-child(2){ width:215px;} 
            .responsive-cashflow-table thead tr th:nth-child(3){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(4){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(5){ width:155px;} 
            .responsive-cashflow-table thead tr th:nth-child(6){ width:76px;} 
            .responsive-cashflow-table thead tr th:nth-child(7){ width:85px;} 
            .responsive-cashflow-table thead tr th:nth-child(8){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(9){ width:90px;} 
             
            .responsive-cashflow-table tr th:last-child { width:60px;  text-align:center;} 



            .responsive-cashflow-table tr td:nth-child(1){ width:33px;} 
            .responsive-cashflow-table tr td:nth-child(2){ width:170px; } 
            .responsive-cashflow-table tr td:nth-child(3){ width:52.8px;} 
            .responsive-cashflow-table tr td:nth-child(4){ width:53px;} 
            .responsive-cashflow-table tr td:nth-child(5){ width:122px;} 
            .responsive-cashflow-table tr td:nth-child(6){ width:58.8px;} 
            .responsive-cashflow-table tr td:nth-child(7){ width:66px;} 
            .responsive-cashflow-table tr td:nth-child(8){ width:54px;} 
            .responsive-cashflow-table tr td:nth-child(9){ width:69px;} 
              
            .responsive-cashflow-table tr td:last-child { width:49px;  text-align:center;} 

            *--------------*/


            .dataTables_scroll {/* overflow-x:scroll!important;*/ width:100%; }
            .fa-search { font-size:22px; text-align:center;      padding:5px 2px; color:#072c48; font-weight:100; }
            @media only screen and (max-width: 800px){
            	.nav-contacts { display:none!important}
             
            	ul.topnav li a {  padding:15px 32px!important;}
            ul.topnav {
                display: block!important; width:100%!important;
            }
            } 
        </style>
    
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">

 
    

    <div class="scrollbar" id="style-1">
      <div class="force-overflow"></div>
    </div>

    



		
            <!-- PAGE CONTENT -->
    <?php $this->load->view('templates/menus');?>
           <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
             
                  <div class="heading-h2">   Dashboard   
				         <div class="nav-contacts ng-scope" ui-view="@nav">
                <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
                    <div class="u-posRelative u-textRight">
                        <i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

                        <ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
                            <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/all">
                                    <span class="ng-binding">All</span>
                                </a>
                            </li>

                            <li class="self" >
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/mytask">
                                    <span class="ng-binding">Self</span>
                                </a>
                            </li>

                            <li class="assigned">
                                <a href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/assigned">
                                    <span class="ng-binding">Assigned</span>
                                </a>
                            </li>

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/pending">
                                    <span class="ng-binding">Pending</span>
                                </a>
                            </li>

                            <li class="completed">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/completed">
                                    <span class="ng-binding">Completed</span>
                                </a>
                            </li>           
                        </ul>

                        <i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
                    </div>
                </div>
            </div>
				  
				  </div>
              
			<ul class="topnav" id="myTopnav">
		  <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/all">
                                    <span class="ng-binding">All</span>
                                </a>
                            </li>

                            <li class="self" >
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/mytask">
                                    <span class="ng-binding">Self</span>
                                </a>
                            </li>

                            <li class="assigned">
                                <a href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/assigned">
                                    <span class="ng-binding">Assigned</span>
                                </a>
                            </li>

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/pending">
                                    <span class="ng-binding">Pending</span>
                                </a>
                            </li>

                            <li class="completed">
                                <a  href="<?php echo base_url(); ?>index.php/dashboard/checkstatus/completed">
                                    <span class="ng-binding">Completed</span>
                                </a>
                            </li>           
  <li class="icon">
    <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
  </li>
</ul>

                <div class="pagontent-wrapper ">
                 
                    <div class="row main-wrapper"> 
                      <div class="main-container"> 
					
                            <?php if(isset($task_detail)){?>
							  <div class="full-width" style="">
                            <div class="col-md-12" style="">
                                
                                <!-- START WIDGET MESSAGES -->
                                <h2 style="float:left;    margin-bottom: 0;">Scheduled Task</h2>  <!-- <span style="fmargin-left:20px;margin-top:10px;margin-top: 5px; float: right; text-decoration: underline; font-size: 14px;"><a href="#">View all</a></span> -->      
                                <!-- END WIDGET MESSAGES -->
								<div class="btn-group pull-right" style="display:none;" >
											<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download </button>
											<ul class="dropdown-menu">
												<li><a href="#" onClick ="$('#schedule_table').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
												
												<li><a href="#" onClick ="$('#schedule_table').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
												</ul>
										</div>
                                <div class="panel panel-default" style="border:none;box-shadow:none;">
                                    
                                    <div class="panel-body panel-body-table" style="margin-top: 0;">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered   responsive-table-bordered" id="schedule_table" style="border:1px solid #ddd;">
                                                <thead>
                                                    <tr>
                                                        <th style=""  >Sr. No.</th>
                                                        <th style=""   >Task</th>
                                                        <th style=""   >Property</th>
                                                        <th style=""   >Owner</th>
                                                        <th style=""  >Assigned By</th>
                                                        <th style=""  >Assigned To</th>
                                                        <th style="" >Due Date</th>
                                                        <th style=""  >Completed On</th>
                                                        <th style=""  >Status</th>
                                                        <th style=""  >Remarks</th>
                                                        <th style=" "  >View Task</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(isset($task_detail)){
                                                    $i=0;
                                                    foreach($task_detail as $row){
                                                        if ($task_detail[$i]['status']=='Completed'){
                                                            $style = ' background-color: yellowgreen;';
                                                        } else if ($task_detail[$i]['no_of_days']>7){
                                                            $style = ' background-color: yellow;';
                                                        } else if ($task_detail[$i]['no_of_days']<=7 && $task_detail[$i]['no_of_days']>=0){
                                                            $style = ' background-color: orange;';
                                                        } else if ($task_detail[$i]['no_of_days']<0){
                                                            $style = ' background-color: red;';
                                                        } else {
                                                            $style = '';
                                                        }

                                                        echo ' <tr style="word-break: break-word;">
                                                        <td style=" text-align:center; "    ><strong>'.($i+1).'</strong></td>
                                                        <td style="  "  ><strong>'.$task_detail[$i]['subject_detail'].'</strong></td>
                                                        <td style="   " strong>'.$task_detail[$i]['property'].'</strong></td>
                                                        <td style="  "  ><strong>'.$task_detail[$i]['owner_name'].'</strong></td>                                                        
                                                        <td style=" " ><strong>'.$task_detail[$i]['assigned_by'].'</strong></td>
                                                        <td style="  "  ><strong>'.$task_detail[$i]['assigned_to'].'</strong></td>
                                                        <td style="  " ><strong>'.(($task_detail[$i]['due_date']==null || $task_detail[$i]['due_date']=='')?'':date('d/m/Y',strtotime($task_detail[$i]['due_date']))).'</strong></td>
                                                        <td style="  "  ><strong>'.(($task_detail[$i]['status']!='Completed')?'':(($task_detail[$i]['completed_on']==null || $task_detail[$i]['completed_on']=='')?'':date('d/m/Y',strtotime($task_detail[$i]['completed_on'])))).'</strong></td>
                                                        <td style="color: black;  '.$style.'"  ><strong>'.$task_detail[$i]['status'].'</strong></td>
                                                        <td style=" "  ><strong>'.$task_detail[$i]['remarks'].'</strong></td>
                                                        <td style="padding:5px; " ><strong><a href="'.base_url().'index.php/Task/task_view/'.urlencode($task_detail[$i]['id']).'" target="_blank"><i class="fa fa-search" ></i></a></strong></td>
                                                        </tr> ';
                                                        $i++;
                                                    }
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							</div>
							<?php }?>
							
						
                            <?php if(isset($task_detail)){?>
								<div class="full-width" style="">
    						<div class="col-md-12">
                                <!-- START WIDGET MESSAGES -->
                                <h2 style="float:left;">Cashflow Task</h2>   <!-- <span style="fmargin-left:20px;margin-top:10px;margin-top: 5px; float: right;  text-decoration: underline; font-size: 14px;"><a href="#">View all</a></span> -->
                                <!-- END WIDGET MESSAGES -->
								<div class="btn-group pull-right" style="display:none;">
											<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download</button>
											<ul class="dropdown-menu">
												<li><a href="#" onClick ="$('#cashflow_table').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
												
												<li><a href="#" onClick ="$('#cashflow_table').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
												</ul>
										</div>
                                <div class="panel panel-default"  style="border:none;box-shadow:none;">
                                    
                                    <div class="panel-body panel-body-table"  style="border:none;box-shadow:none;">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-bordered  responsive-cashflow-table  " id="cashflow_table" style="border:1px solid #ddd;" >
                                                <thead>
                                                    <tr>
                                                        <th style=""  >Sr. No.</th>
                                                        <th style="" >Task</th>
                                                        <th style="" >Property </th>
                                                        <th style=""   >Owner</th>
                                                        <th style=""   >Type</th>
                                                        <!-- <th style="padding:5px;" width="15%">Event Name</th> -->
                                                        <th style=""  >Due Date</th>
                                                        <th style=""    >Completed On</th>
                                                        <th style=""  >Status</th>
                                                        <th style=""   >Remark</th>
                                                        <th style=""  >View Task</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <!- purchase sale and rent schedule as per date -->
                                                <?php if(isset($schedule_detail)){
                                                    $i=0;
                                                    foreach($schedule_detail as $row){
                                                        if ($schedule_detail[$i]['status']=='Completed'){
                                                            $style = ' background-color: yellowgreen;';
                                                        } else if ($schedule_detail[$i]['no_of_days']>7){
                                                            $style = ' background-color: yellow;';
                                                        } else if ($schedule_detail[$i]['no_of_days']<=7 && $schedule_detail[$i]['no_of_days']>=0){
                                                            $style = ' background-color: orange;';
                                                        } else if ($schedule_detail[$i]['no_of_days']<0){
                                                            $style = ' background-color: red;';
                                                        } else {
                                                            $style = '';
                                                        }

                                                        echo ' <tr style="word-break: break-word;">
                                                        <td style="padding:5px;text-align:center;" ><strong>'.($i+1).'</strong></td>
                                                        <td style="padding:5px;  "><strong>'.$schedule_detail[$i]['task'].'</strong></td>
                                                        <td style="padding:5px;  "><strong>'.$schedule_detail[$i]['property'].'</strong></td>
                                                        <td style="padding:5px; "><strong>'.$schedule_detail[$i]['owner_name'].'</strong></td>
                                                        <td style="padding:5px; "><strong>'.$schedule_detail[$i]['task'].'</strong></td>
                                                       <!--<td style="padding:5px;" ><strong>'.$schedule_detail[$i]['event_name'].'</strong></td>-->
                                                        <td style="padding:5px; "  ><strong>'.(($schedule_detail[$i]['due_date']==null || $schedule_detail[$i]['due_date']=='')?'':date('d/m/Y',strtotime($schedule_detail[$i]['due_date']))).'</strong></td>
                                                        <td style="padding:5px;"  ><strong>'.(($schedule_detail[$i]['status']!='Completed')?'':(($schedule_detail[$i]['completed_on']==null || $schedule_detail[$i]['completed_on']=='')?'':date('d/m/Y',strtotime($schedule_detail[$i]['completed_on'])))).'</strong></td>
                                                        <td style="color: black;padding:5px;"'.$style.'"><strong>'.$schedule_detail[$i]['status'].'</strong></td>
                                                        <td  style="color: black;padding:5px;"'.$style.'"><strong></strong></td>

                                                        <td style="padding:5px; "  ><strong><a href="'.base_url().'index.php/bank_entry/bankEntry/'.$schedule_detail[$i]['prop_id'].'" target="_blank"><i class="fa fa-search" ></i></a></strong></td>
                                                        </tr> ';
                                                        $i++;
                                                    }
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							</div>
                            <?php }?>
    						
    						
    						
    						
    						
    				 
    						
    					
    						
    				</div>		 
                        </div>
                      
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
                
                 <br clear="all">
            </div>            
            <!-- END PAGE CONTENT -->
          
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>

        <script>
            jQuery(function(){
                $('.grp_change').change(function(){
                    var g_id=$('.grp_change option:selected').val();
                    //alert(g_id);
                    $.ajax({
                        url: "<?php echo base_url() . 'index.php/dashboard/changegroup' ?>",
                        data: 'g_id='+g_id,
                        cache: false,
                        type: "POST",
                        dataType: 'html',
                        global: false,
                        async: false,
                        success: function (data) {
        //                    alert(data);
                            if ($.isNumeric($.trim(data))) {
                                $result = 1;
                                //alert(data);
                            } else {
                                $result = 0;
                                //alert(data);
                            }

                        },
                        error: function (data) {
        //                    alert(data);
                            $result = 0;
                        }
                    });

                    if ($result) {
                        //alert('hi');
                        window.location.href='<?php echo base_url(); ?>index.php/dashboard';
                    }
                    else {
                        return false;
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                var table = $('#cashflow_table').DataTable({
                    // "scrollY":        "200px",
                    // "scrollCollapse": true,
                    // "paging":         false
						scrollY:200,
						bSort:true,
						bPaginate:false,
						sScrollX: "100%",
                });

                $('#cashflow_table thead').css('display','none');

                $('.dataTables_scrollHeadInner table').on('click', 'th', function() {
                    $('#cashflow_table thead').css('display','none');
                });

                $("#cashflow_table_filter input").keyup( function () {
                    $('#cashflow_table thead').css('display','none');
                });


			 $('#schedule_table').DataTable( {
			scrollY:200,
			bSort:true,
			bPaginate:false,
			 sScrollX: "100%",
			 //scrollX: false,
		} );

                

                $('#schedule_table thead').css('display','none');

                $('.dataTables_scrollHeadInner table').on('click', 'th', function() {
                    $('#schedule_table thead').css('display','none');
                });

                $("#schedule_table_filter input").keyup( function () {
                    $('#schedule_table thead').css('display','none');
                });

                var url = window.location.href;
                if(url.includes('all')){
                    $('.all').attr('class','active');
                }
                else  if(url.includes('mytask')){
                    $('.self').attr('class','active');
                }
                 else  if(url.includes('assigned')){
                    $('.assigned').attr('class','active');
                }
                 else  if(url.includes('pending')){
                    $('.pending').attr('class','active');
                }
                  else  if(url.includes('completed')){
                    $('.completed').attr('class','active');
                }


                $('.ahrefall').click(function(){
                    alert(window.location.href );
                    //$('.a').attr('class','active');
                });
            });
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>