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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/> 
        
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
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                          
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Bank Details List </div>
                <!-- PAheading-h2GE CONTENT WRAPPER -->
                  <!-- <div class="top-band">
                            <div class=""  >
                                <label class="col-md-2 control-label" style="width:125px; margin-top:10px; padding-left:17px; font-size:14px; color:#000; padding-right:0px;">Select Group: </label>
                                <div class="col-md-8" style="margin:0px; padding-left:0px; padding-right:0px;">
                                    <select class="form-control grp_change" name="group" style="height:40px; font-weight:bolder; font-size:14px;">
                                        <?php if(isset($groups)) { for ($i=0; $i < count($groups) ; $i++) { ?>
                                            <option value="<?php echo $groups[$i]->gu_gid; ?>" <?php if($groups[$i]->gu_gid==$this->session->userdata('groupid')) echo 'selected'; ?>><?php echo $groups[$i]->group_name; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>
                            </div>
                 </div> -->
                <div class="nav-contacts ng-scope" ui-view="@nav">
                <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
                    <div class="container u-posRelative u-textRight">
                    	   	<div class="pull-left btn-top">
										<?php if(isset($access)) { if($access[0]->r_insert == 1) { ?>
											<a class="btn btn-success" href="<?php echo base_url().'index.php/bank/addnew'; ?>">
												<span class="fa fa-plus"></span> Add Bank Details
											</a>
											<?php } } ?>
											</div>
								


                        <i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>

                           <ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
                            <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/All">
                                    <span class="ng-binding">All</span>
                                    <span id="approved">  (<?php echo  	($all); ?>)  </span>
                                </a>
                            </li>

                            <li class="approved" >
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/Approved">
                                    <span class="ng-binding">Approved</span>
                                    <span id="approved"> (<?php echo count($approved); ?>)</span>
                                </a>
                            </li>

                            

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/Pending">
                                    <span class="ng-binding">Pending</span>
                                    <span id="approved"> (<?php echo count($pending); ?>) </span>
                                </a>
                            </li>

                            <li class="rejected">
                                <a href="<?php echo base_url(); ?>index.php/bank/checkstatus/Rejected">
                                    <span class="ng-binding">Rejected</span>
                                    <span id="approved"> (<?php echo count($rejected); ?>) </span>
                                </a>
                            </li>

                            <li class="inprocess">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/InProcess">
                                    <span class="ng-binding">In Process</span>
                                    <span id="approved"> (<?php echo count($inprocess); ?>) </span>
                                </a>
                            </li>           
                        </ul>


                        <i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
                    </div>
                </div>
            </div>
			
			<ul class="topnav" id="myTopnav">
		               <li class="all">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/All">
                                    <span class="ng-binding">All</span>
                                    <span id="approved">  (<?php echo count($all); ?>)  </span>
                                </a>
                            </li>

                            <li class="approved" >
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/Approved">
                                    <span class="ng-binding">Approved</span>
                                    <span id="approved"> (<?php echo count($approved); ?>)</span>
                                </a>
                            </li>

                            

                            <li class="pending">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/Pending">
                                    <span class="ng-binding">Pending</span>
                                    <span id="approved"> (<?php echo count($pending); ?>) </span>
                                </a>
                            </li>

                            <li class="rejected">
                                <a href="<?php echo base_url(); ?>index.php/bank/checkstatus/Rejected">
                                    <span class="ng-binding">Rejected</span>
                                    <span id="approved"> (<?php echo count($rejected); ?>) </span>
                                </a>
                            </li>

                            <li class="inprocess">
                                <a  href="<?php echo base_url(); ?>index.php/bank/checkstatus/InProcess">
                                    <span class="ng-binding">In Process</span>
                                    <span id="approved"> (<?php echo count($inprocess); ?>) </span>
                                </a>
                            </li>   
  <li class="icon">
    <a href="javascript:void(0);" onclick="myFunction()">&#9776;</a>
  </li>
</ul>
      
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row  main-wrapper">					
				     <div class="main-container"> 
						
                        <div class="col-md-12">
						<div class="panel panel-default inside-width" style="border:none;box-shadow:none;">
							
						 
							<div class="panel-body">                                                                        
							
								
									<?php $this->load->view('templates/download');?> 

								</div>
								
							
								
							<!-- START DATATABLE EXPORT -->
							
							<div class="panel-body" style="padding-top: 0;">
								<div class="table-responsive">
								<table id="customers2" class="table datatable table-bordered"  >
									<thead>
										<tr>
											<th style="padding:5px;" width="70" align="center">Sr. No.</th>
											<th style="padding:5px;"  >Bank Name</th>
											<th style="padding:5px;"  >Owner</th>
											<th style="padding:5px;" >Status</th>
											<th style="padding:5px;" >Branch</th>
											<th style="padding:5px;" >Account Type</th>
											<th style="padding:5px;"  >Account Number</th>
											<th style="padding:5px;"  >IFSC Code</th>
											<th style="padding:5px;" >Relationship Manager</th>
											
											<!-- <th width="75">Actions</th> -->
										</tr>
									</thead>
									<tbody>
										<?php for($i=0; $i < count($banks); $i++) { ?>
										<tr id="trow_<?php echo $i;?>">
											<td style="padding:5px;" align="center"><?php if(isset($banks)){ echo ($i+1) ;} else {echo '1';} ?></td>
											<?php if(isset($access)) { if($access[0]->r_view == 1) { ?>
												<td style="padding:5px;">
														<a href="<?php echo base_url().'index.php/Bank/viewbank/'.$banks[$i]->b_id; ?>"><?php echo $banks[$i]->b_name; ?></a>
													
												</td>
											<?php } else { ?><td><?php echo $bankowner[$i]['name']; ?></td><?php } } else { ?>
												<td style="padding:5px;"><?php echo $bankowner[$i]['name']; ?></td>
											<?php } ?>
											<td style="padding:5px;"><?php echo $bankowner[$i]['name']; ?></td>
											<td style="padding:5px;"><?php echo $banks[$i]->b_status; ?></td>
											<td style="padding:5px;"><?php echo $banks[$i]->b_branch; ?></td>
											<td style="padding:5px;"><?php echo $banks[$i]->b_accounttype; ?></td>
											<td style="padding:5px;"><?php echo $banks[$i]->b_accountnumber; ?></td>
											<td style="padding:5px;"><?php echo $banks[$i]->b_ifsc; ?></td>
											<td style="padding:5px;"><?php echo $relationshipmanager[$i]; ?></td>
											
											<!--<td>
												<?php //if(isset($access)) { if($access[0]->r_edit == 1) { ?>
												<!--<button class="btn btn-default btn-rounded btn-sm"><span class="fa fa-pencil"></span></button></a>
												<?php //} if($access[0]->r_delete == 1) { ?>
												<!--<a href=""><button class="btn btn-danger btn-rounded btn-sm" onClick="delete_row('trow_1');"><span class="fa fa-times"></span></button></a>
												<?php //} } ?>
										<!--	</td> -->
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
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
		  <script>
            $(document).ready(function() {               

                var url = window.location.href;
                if(url.includes('All')){
                    $('.all').attr('class','active');
                }
                else  if(url.includes('Approved')){
                    $('.approved').attr('class','active');
                }
                 else  if(url.includes('Assigned')){
                    $('.assigned').attr('class','active');
                }
                 else  if(url.includes('Pending')){
                    $('.pending').attr('class','active');
                }
               else  if(url.includes('Rejected')){
                    $('.rejected').attr('class','active');
                }
                  else  if(url.includes('InProcess')){
                    $('.inprocess').attr('class','active');
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