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
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-view.css"/>
        <!-- EOF CSS INCLUDE -->                                      
			<style>
        	/*.lable-box { padding:8px ; font-weight:500; background:#f9f9f9; width:100%;  } */
			.control-label { padding:8px 0;  }
			.form-group:hover { background:#fdfdfd; }
			.box-border { background:; }
        </style>
	<style type="text/css">
   
.task-heading { font-size:14px; background:#fff; width:100%; padding:10px; margin-bottom:10px; margin-top-10px; border-bottom:1px dotted #ddd;  }
        </style>
		
	<style type="text/css">
     .address-remark{width: 17.5%;}
.address-container1{width:82.5%; display:flex;}       
 
.purpose-view { width:20.3%;}
.purpose-details { width:79.7%;}
.custom-padding .rspns{ padding:0;}
  
 @media screen and (max-width: 780px) 
	{
.custom-padding .col-md-6 {
    padding:0px!important;
} 
.form-horizontal .control-label { padding:0 3px!important; }
 
.sr{ text-align:left; margin:0!important;}
 .address-remark { width:100%; text-align:left!important; margin:0 10px!important;}
 .address-container1 { width:100%; text-align:left;}
.custom-padding .col-md-10 { padding:0!important;}
.custom-padding .comment-section {display:block!important;} 
.btn-container{ padding-bottom:10px!important; display:flex!important;}
 .custom-padding #delete_btn { margin-right:5px;}
}
@media screen and (min-width: 768px) and (max-width:991px){ 
.custom-padding .col-md-11 { padding:0!important;}
.custom-padding .comment-section {display:block!important;} 
.btn-container{ padding-bottom:10px!important; display:flex!important;}
 .custom-padding #delete_btn { margin-right:5px;}
}


 </style>		 
    </head>
    <body>								
   <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <?php $this->load->view('templates/menus');?>
                  <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/task'; ?>" > Task List</a>  &nbsp; &#10095; &nbsp;    Task View</div>
                  <div class="pull-right btn-top-margin responsive-margin">
					 <!--<a class="printdiv btn-margin"> <span class="btn btn-warning pull-right btn-font"> Print </span>  </a> -->
			        <a class="btn-margin"  href="<?php echo base_url(); ?>index.php/task/task_edit/<?php echo $taskdetail->id;?>"  ><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
					 <a class="btn-margin" href="<?php echo base_url()?>index.php/task" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a> 
                  </div>
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
				    <div class="row main-wrapper">
					  <div class="main-container">           
					    <div class="box-shadow">   
					       <div class="box-shadow-inside">	
					           <div class="col-md-12" style="padding:0;">	
					            <div class="full-width custom-padding" >
										<div class="panel panel-default">
                            <form id="jvalidate" role="form" class="form-horizontal" action="javascript:alert('Form #validate2 submited');">
                              
                                <div class="panel-body">
                                	<?php if(count($taskdetail) > 0 ){?>
                                    <div class="form-group" style="border-top:0px dotted #ddd;">
										<div class="col-md-12" >
											<label class="col-md-1 control-label"><strong>Subject: </strong></label>
											<div class="col-md-11">
											    <label class=" control-label box-border" style="text-align:left;"> <?php echo $taskdetail->subject_detail;?></label>
											</div>
										</div>
									</div>
                                	<div class="form-group">
                                    	<div class="col-md-12">
											<label class="col-md-1 control-label"><strong>Description: </strong></label>
											<div class="col-md-11">
											    <label class="col-md-12 control-label box-border" style="text-align:left;"><?php echo $taskdetail->message_detail;?></label>
											</div>
										</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 col-sm-4 col-xs-12 control-label"><strong>Status: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->task_status;?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Priority: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->priority;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Property: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <?php if(isset($taskdetail)) { 
                                                    for($i=0; $i<count($property); $i++) { if($taskdetail->property_id == $property[$i]->txn_id) {?>
                                                        <label class=" control-label box-border" style="text-align:left;"><?php  echo $property[$i]->p_property_name; ?></label>
                                                <?php break; } } } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Sub Property: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <?php if(isset($taskdetail)) { 
                                                    for($i=0; $i<count($sub_property); $i++) { if($taskdetail->sub_property_id == $sub_property[$i]->txn_id) {?>
                                                        <label class=" control-label box-border" style="text-align:left;"><?php  echo $sub_property[$i]->sp_name; ?></label>
                                                <?php break; } } } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>From Date: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"> <?php echo date('d/m/Y',strtotime($taskdetail->from_date)).'  '.$taskdetail->from_time;?></label>
                                            </div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>To Date: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"> <?php echo date('d/m/Y',strtotime($taskdetail->to_date)).'  '.$taskdetail->to_time;?></label>
                                            </div>
                                        </div>   
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
											<label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Frequency: </strong></label>
											<div class="col-md-10 col-sm-8 col-xs-12">
											    <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->repeat_status;?></label>
											</div>
										</div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Owner Name: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class="control-label box-border" style="text-align:left;"><?php echo $taskdetail->owner_name;?></label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php if($taskdetail->repeat_status=='Periodically'){?>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Interval: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class="control-label box-border" style="text-align:left;"><?php echo $taskdetail->period_interval;?> <span>Days after completion</span></label>
                                            </div>
										</div>
                                    </div>
                                    <?php } if($taskdetail->repeat_status=='Weekly'){?>
                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Interval: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"> <?php echo $taskdetail->period_interval;?> </label>
                                            </div>
										</div>
                                    </div>
                                    <?php } if($taskdetail->repeat_status=='Monthly'){?>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-1 control-label"><strong>Interval: </strong></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->period_interval;?><span> every month ON </span> <?php echo $taskdetail->monthly_repeat;?> <span> day of the month</span> </label>                         
                                            </div>
                                        </div>
                                    </div>
    								<?php } ?>

                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?php if($taskdetail->follower == 'No'){ ?>
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Assigned to: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"><?php if($taskdetail->name=='') { echo 'Self'; } else { echo $taskdetail->name; }?></label>
                                            </div>
                                            <?php } 
                                            else{ ?>
                                                 <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Followed By : </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12">
                                                <label class=" control-label box-border" style="text-align:left;"><?php echo $taskdetail->name;?></label>
                                            </div>
                                           <?php  } ?>
                                        </div>
                                         <div class="col-md-6 col-sm-6 col-xs-12">
                                            <label class="col-md-2 col-sm-4 col-xs-12 control-label"><strong>Maker Remark: </strong></label>
                                            <div class="col-md-10 col-sm-8 col-xs-12"> 
                                                <label class="  control-label box-border" style="text-align:left;"><?php echo $taskdetail->maker_remark;?></label>
                                                
                                            </div>
                                        </div> 
                                    </div>

                                    <?php if(isset($comment)) { 
                                         echo '<div class="form-group" style="padding:0; ">
                                              <div class="task-heading" > <label class="control-label "><strong>Task Comment : </strong></label></div>';

                            foreach($comment as $row){           ?>
                                   
                                        <div class="col-md-12" style="padding-bottom:10px;">
                                            <label class="col-md-1 control-label"><?php echo ucfirst($row->name);?>: </label>
                                            <div class="col-md-11">
                                                <label class=" control-label box-border" style="text-align:left;"><?php echo $row->comment;?></label>
                                            </div>
                                        </div>
                                    <?php } 
                               echo '</div>'; } ?>

									<div class="form-group" style="border-top:0px dotted #ddd; padding:0;  ">
							 
                                        <div class="task-heading" > <label class="control-label " style="padding:0;"><strong>Comments: </strong></label></div>  
                                         <!---   <label class="col-md-1 control-label"><strong> Comments </strong></label>-->
										 
										      <div class="comment-section"  style="padding-bottom:10px; display:flex">
                                            <div class="col-md-12">
                                                         <textarea id="follower_comment_id" name="follower_comment" class="form-control" ></textarea>
                                                     </div>
 

                                        </div>
                                    </div>
								 
                                           
                                
                                          
											 
							      
                                    <div class="" >
											<div class="col-md-12 btn-container"  style=" background: #fcfdfd;" >	
        <button id="cooment" class="btn btn-success pull-left" type="button"   onclick="addComment('<?php echo $taskdetail->id;?>')">Comment</button>											
									    <button id="delete_btn" class="btn btn-danger pull-right btn-margin" type="button" onclick="deleteRecord('<?php echo $taskdetail->id;?>')">Delete</button>
                                        <?php if($taskdetail->follower !='Yes'){?>	
                                        <button id="complete_btn" class="btn pull-right  btn-success" type="button"   onclick="completeTask('<?php echo $taskdetail->id;?>')">Complete</button>
                                        <?php } ?>  
                                    </div>
									</div>
                                  
                                    <?php } else {?>
                                    <div class="form-group" style="border-top:1px dotted #ddd;">
                                        <div class="col-md-12" style="text-align:center;" >
                                            <label class=" control-label"><strong>No Record Found </strong></label>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
							</form>
                  

                          
									
                            </div>
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
        <script>
        var BASE_URL = "<?php echo base_url();?>";
        //alert(BASE_URL);</script>     
        <script type="text/javascript" src="<?php echo base_url(); ?>js/task.js"></script>
        <!-- END SCRIPTS -->      
    </body>
</html>