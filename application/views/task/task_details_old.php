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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/user-details.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/plugins/wickedpicker/stylesheets/wickedpicker.css"/>

        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->
    </head>
	<style>
 
			
			 

	
.box-padding .col-md-6 { padding-left:10px;  padding-right:10px;}
.file-input-wrapper .fileinput { overflow:hidden;}
 .padding-height {padding:6px 10px; overflow:hidden;}
        </style>	
    <body>								
        <!-- START PAGE CONTAINER -->
       <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                
                     <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/task'; ?>" > Task List</a>  &nbsp; &#10095; &nbsp;  Task Details </div>
					 
                <!-- PAGE CONTENT WRAPPER -->
             <div class="page-content-wrap">
                 <div class="row main-wrapper">
				    <div class="main-container">           
                        <div class="box-shadow custom-padding"> 
  							<form id="task_detail" role="form" class="form-horizontal" action="<?php echo base_url();?>index.php/Task/insertDetails" method="POST">
							   <div class="box-shadow-inside">
									<div class="col-md-12" style="padding:0;" >
										<div class="panel panel-default">
											<input type="hidden" name="task_id" id="task_id" value="<?php if(isset($taskdetail->task_id))echo $taskdetail->task_id;?>">
											<div class= "panel-body panel-group accordion"     >
                      		   <div class="panel-primary"  >
                                                               
                                    <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                        <div class="form-group" style="border-top:1px dotted #ddd;">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label">Subject <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-9">
													<input type="text" class="form-control " name="subject_detail"  value="<?php if(isset($taskdetail->subject_detail)) {echo $taskdetail->subject_detail;}?>"placeholder="Your Task Subject Here..." required/>
												</div>
											</div>
                                        </div>

										<div class="form-group">
											<div class="col-md-12">
												<label class="col-md-2 control-label">Description <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-9">
													<textarea class="form-control" name="description" rows="2" required><?php if(isset($taskdetail->message_detail))echo $taskdetail->message_detail;?></textarea>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="col-md-6 col-sm-6  ">													
												<label class="col-md-4 control-label">Status</label>
												<div class="col-md-6"> 
												    <select class="form-control" name="task_status" required>
													      <option value="Pending" <?php if(isset($taskdetail->task_status)){ if($taskdetail->task_status=='Pending') echo "selected";}?> >Pending</option>
													      <option value="Completed" <?php if(isset($taskdetail->task_status)){ if($taskdetail->task_status=='Completed') echo "selected";}?> >Completed</option>
											        </select>
												</div>
											</div>
                                            <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Priority <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-6"> 
												    <select class="form-control" name="priority" required>
														<option value="">Select</option>
														<option value="Low" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Low') echo "selected";}?> >Low</option>
														<option value="Medium" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Medium') echo "selected";}?> > Medium</option>
														<option value="High" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='High') echo "selected";}?> >High</option>
														<option value="Very High" <?php if(isset($taskdetail->priority)){ if($taskdetail->priority=='Very High') echo "selected";}?> >Very High</option>
											        </select>
												</div>
											</div>	
										</div>

										<div class="form-group">
											  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Property</label>
												<div class="col-md-6">
													<select  class="form-control" id="property" name="property">
														<option value="0">Select</option>
															<?php if(isset($taskdetail)) { 
																for($i=0; $i<count($property); $i++) { ?>
																	<option value="<?php echo $property[$i]->txn_id; ?>" <?php if($taskdetail->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
															<?php } } else { ?>
																	<?php for($i=0; $i<count($property); $i++) { ?>
																	<option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>
										  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Sub Property</label>
												<div class="col-md-6">
													<select  class="form-control" id="sub_property" name="sub_property">
														<option value="0">Select Sub Property</option>
															<?php if(isset($taskdetail)) { 
																for($i=0; $i<count($sub_property); $i++) { ?>
																	<option value="<?php echo $sub_property[$i]->txn_id; ?>" <?php if($taskdetail->sub_property_id == $sub_property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
															<?php } } else { ?>
																	<?php for($i=0; $i<count($sub_property); $i++) { ?>
																	<option value="<?php echo $sub_property[$i]->txn_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
															<?php } } ?>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
                                        	  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 col-sm-12 control-label" >From Date <span  class="asterisk_sign prop_other_name"> * </span></label>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control datepicker" name="from_date" value="<?php if(isset($taskdetail->from_date)) echo date('d/m/Y',strtotime($taskdetail->from_date));?>" placeholder="From Date" required/>
												</div>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control  timepickermask " name="from_time" value="<?php if(isset($taskdetail->from_time)) echo $taskdetail->from_time;?>" placeholder="From Time"/>
												</div>
											</div>
											  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 col-sm-12 control-label">To Date</label>
												<div class="col-md-3 col-sm-6" >
													<input type="text" class="form-control datepicker" name="to_date" value="<?php if(isset($taskdetail->to_date)) echo date('d/m/Y',strtotime($taskdetail->to_date));?>" placeholder="To Date"/>
												</div>
												<div class="col-md-3 col-sm-6">
													<input type="text" class="form-control timepickermask" name="to_time"  value="<?php if(isset($taskdetail->to_time)) echo $taskdetail->to_time;?>" placeholder="To Time"/>
												</div>
											</div>
										</div>

										<div class="form-group">
										  <div class="col-md-6 col-sm-6">
												<label class="col-md-4 control-label">Owner</label>
												<div class="col-md-6">
													<input type="hidden" id="owner_name_id" name="owner_name" data-error="#owner_error" class="form-control" value="<?php if(isset($taskdetail->owner_id)){ echo $taskdetail->owner_id; } else { echo ''; }?>" />
													<input type="text" id="owner_name" name="owner_contact_name" class="form-control auto_owner" value="<?php if(isset($taskdetail->owner_name)){ echo $taskdetail->owner_name; } else { echo ''; }?>" placeholder="Type to choose owner from database..." />
													<div id="owner_error"></div>
												</div>
											</div>
										  <div class="col-md-6 col-sm-6">													
												<label class="col-md-4 control-label">Frequency</label>
												<div class="col-md-6"> 
													    <select class="form-control" name="repeat" id="repeat">
													      <option value="Never" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Never') echo "selected";}?> >Never</option>
													      <option value="Daily" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Daily') echo "selected";}?> >Daily</option>
                                                          <option value="Periodically" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Periodically') echo "selected";}?> >Periodically</option>
													      <option value="Weekly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Weekly') echo "selected";}?> >Weekly</option>
													      <option value="Monthly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Monthly') echo "selected";}?> >Monthly</option>
													      <option value="Yearly" <?php if(isset($taskdetail->repeat_status)){ if($taskdetail->repeat_status=='Yearly') echo "selected";}?> >Yearly</option>															      
												        </select>
												</div>
											</div>
										</div>
											
										<div class="form-group" id="repeat-periodically">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval after </label>
												<div class="col-md-2">
												    <select class="form-control" name="periodic_interval">
												    	<option value="">Select</option>
												    	<?php for($i=1;$i<=30;$i++){
												    		$selected='';
												    		if(isset($taskdetail->period_interval)){
												    			if($taskdetail->repeat_status=='Periodically' && $i==$taskdetail->period_interval){
												    				$selected='selected';
												    			}
												    		} else {
												    			$selected='';
												    		}
												    		echo '<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
												     	} ?>
											        </select>
												</div> 
												<label class="control-label">  Days </label>
											</div>
										</div>

										<div class="form-group" id="repeat-weekly">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval</label>
												<div class="col-md-8">  
												<div style="padding-top:8px;">
													<?php $week_days=array();
														if(isset($taskdetail->repeat_status)){
															if($taskdetail->repeat_status=='Weekly'){
																if(isset($taskdetail->period_interval)){
																	$week_days=explode(',',$taskdetail->period_interval);
																}
															}
														}
													?>

													<input type="hidden" name="weekday" value="" data-error="#weekday_error" />
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Mon" <?php if(in_array('Mon',$week_days)) echo "checked='checked'";?>/>&nbsp;Mon&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Tue" <?php if(in_array('Tue',$week_days)) echo "checked='checked'";?>/>&nbsp;Tue&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Wed" <?php if(in_array('Wed',$week_days)) echo "checked='checked'";?>/>&nbsp;Wed&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Thu" <?php if(in_array('Thu',$week_days)) echo "checked='checked'";?>/>&nbsp;Thu&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Fri" <?php if(in_array('Fri',$week_days)) echo "checked='checked'";?>/>&nbsp;Fri&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sat" <?php if(in_array('Sat',$week_days)) echo "checked='checked'";?>/>&nbsp;Sat&nbsp;&nbsp;
													<input type="checkbox" name="weekly_interval[]" class="weekday" value="Sun" <?php if(in_array('Sun',$week_days)) echo "checked='checked'";?>/>&nbsp;Sun&nbsp;&nbsp;
													</div>
													<div id="weekday_error"></div>
												</div>
											</div>
										</div>

										<div class="form-group" id="repeat-monthly">
                                        	<div class="col-md-12">
												<label class="col-md-2 control-label"> Interval</label>
												<div class="col-md-2" style="margin-right:0;">
												    <select class="form-control " name="monthly_interval">
												    	<option value="">Select</option>
														<?php for($i=1;$i<=12;$i++){
															$selected='';
															if(isset($taskdetail->period_interval)){
																if($taskdetail->repeat_status=='Monthly' && $i==$taskdetail->period_interval){
																	$selected='selected';
																}
															} else {
																$selected='';
															}
															echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
														} ?>
											        </select>
												</div>
												<label class=" control-label col-md-2 " style="padding-left:0px; margin-left:-30px;" >  every month ON</label>
												<div class="col-md-2"> 
												    <select class="form-control" name="monthly_interval2">
												    	<option value="">Select</option>
														<?php for($i=1;$i<=30;$i++){
															$selected='';
															if(isset($taskdetail->monthly_repeat)){
																if($taskdetail->repeat_status=='Monthly' && $i==$taskdetail->monthly_repeat){
																	$selected='selected';
																}
															} else {
																$selected='';
															}
															echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option> ';
														} ?>
											        </select>
												</div>
												<label class=" control-label">  day of the month</label>
											</div>
										</div>

                                        <div class="">

                                        	<!-- <div class="col-md-6" style="border-top: 1px dotted #ddd;">
												<label class="col-md-4 control-label">Assigned to</label>
												<div class="col-md-5">
												 	<input type="hidden" id="txtname_id" name="assigned" class="form-control" value="<?php //if (set_value('assigned')!=null) { echo set_value('assigned'); } else if(isset($taskdetail->user_id)){ echo $taskdetail->user_id; } else { echo ''; }?>" />
                                                    <input type="text" id="txtname" name="assigned_name" class="form-control auto_client"  value="<?php //if (set_value('assigned_name')!=null) { echo set_value('assigned_name'); } else if(isset($taskdetail->name)){ echo $taskdetail->name; } else { echo ''; }?>" placeholder="Type to choose contact..."  required/>
												</div>  
												<div class="col-md-3"> 
													<label class="control-label"> OR &nbsp;&nbsp;&nbsp;</label> <input type="checkbox" name="self_assigned" id="self_assigned" value="self" onclick="getselfContactId(this.value)" /> <label> Self </label>
												</div>
											</div> -->

                                        	<div class="form-group">
												<div class="col-md-6">
													<label class="col-md-4 col-sm-2 control-label">Assigned to</label>
													<div class="col-md-8 col-sm-8"> 
													<div style="padding-top:8px;">
														<input type="checkbox" name="self_assigned" id="self_assigned" value="self" <?php if(isset($self)) {if(count($self)>0) echo 'checked';}?>/> <label> Self </label>
														</div>
													</div>
												</div>
											</div>

											<div class="repeatcontact">
	                                            <?php if(isset($editcontact)) { 
	                                            for ($j=0; $j < count($editcontact) ; $j++) { 
	                                            ?>
	                                            <div class="form-group" id="repeat_contact_<?php echo $j+1;?>">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" >Assigned to</label>
	                                                        <div class="col-md-8">
	                                                            <input type="hidden" id="contact_<?php echo $j+1;?>_id" name="contact[]" class="form-control" value="<?php if(isset($editcontact[$j]->user_id)){ echo $editcontact[$j]->user_id; } else { echo ''; }?>" />
	                                                            <input type="text" id="contact_<?php echo $j+1;?>" name="contact_name[]" class="form-control auto_client" value="<?php if(isset($editcontact[$j]->name)){ echo $editcontact[$j]->name; } else { echo ''; }?>" placeholder="Type to choose contact..." />
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <?php } } else { ?>
	                                            <div class="form-group" id="repeat_contact_1">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" style="padding-left: 0;">Assigned to</label>
	                                                        <div class="col-md-8">
	                                                            <input type="hidden" id="contact_1_id" name="contact[]" class="form-control" />
	                                                            <input type="text" id="contact_1" name="contact_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <?php } ?>

	                                            
	                                        </div>
	                                        <div class="form-group" style="background:#fff;">
	                                            <div class="col-md-6">
	                                                <button class="btn btn-success repeat-contact" style="margin-left: 10px;">+</button>
            										<button type="button" class="btn btn-success reverse-contact" style="margin-left: 10px;">-</button>
	                                            </div>
	                                        </div>
	                                        <!-- <div class="">
	                                       <div class="form-group">
												<div class="col-md-6">
													<label class="col-md-4 control-label">Follower</label>
													<div class="col-md-8"> 
														 <input type="hidden" id="follower_1_id" name="follower[]" class="form-control" />
	                                                     <input type="text" id="follower_1" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                 </div>
												</div>
											</div>
										</div> -->

											<div class="follower_div">
	                                            <?php //print_r(($editfollower)); 
	                                            if(!empty($editfollower)) { 
	                                            for ($j=0; $j < count($editfollower) ; $j++) { 
	                                            ?>
	                                            <div class="form-group" id="repeat_follower_<?php echo $j+1;?>">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" >Task Follower</label>
	                                                        <div class="col-md-8"> 
														 <input type="hidden" id="follower_<?php echo $j+1;?>_id" name="follower[]" class="form-control" value="<?php if(isset($editfollower[$j]->user_id)){ echo $editfollower[$j]->user_id; } else { echo ''; }?>"  />
	                                                     <input type="text" id="follower_<?php echo $j+1;?>" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." value="<?php if(isset($editfollower[$j]->name)){ echo $editfollower[$j]->name; } else { echo ''; }?>" />
	                                                 </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <?php } } else { ?>
	                                            <div class="form-group" id="repeat_follower_1">
	                                                <div class="col-md-6">
	                                                    <div class="">
	                                                        <label class="col-md-4 control-label" style="padding-left: 0;">Task Follower</label>
	                                                        <div class="col-md-8"> 
														 <input type="hidden" id="follower_1_id" name="follower[]" class="form-control" />
	                                                     <input type="text" id="follower_1" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." />
	                                                 </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <?php } ?>

	                                            
	                                        </div>
									   <div class="form-group" style="background:#fff;">
	                                            <div class="col-md-6">
	                                                <button class="btn btn-success repeat-follower" style="margin-left: 10px;">+</button>
            										<button type="button" class="btn btn-success reverse-follower" style="margin-left: 10px;">-</button>
	                                            </div>
	                                        </div>
										</div>
                                    </div>

                             




 
                      		  	<div class="panel-primary"   >
                                  	<a href="javascript:void(0);" style="cursor:text;">   
                                  	<div class="panel-heading">
              							<h4 class="panel-title"> <span class="fa fa-tasks"> </span>  Remark </h4>
                                    </div>  
                                 	</a>                
                                         <div class="panel-body panel-body-open text1" id="accOneColOne" style="width:100%; ">
                                                <div class="form-group" style="background: none;border:none">
                                                <div class="col-md-12 ">
													<div class="remark-container">
                                                        <textarea  class="form-control" id="maker_remark" name="maker_remark" rows="2" ><?php if(isset($taskdetail))echo $taskdetail->maker_remark;?></textarea>
                                                      <!--  <label style="margin-top: 5px;">Remark </label> -->
                                               
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br clear="all"/>
                                </div>
								</div>
										</div>
									</div>
									 <br clear="all"/>
								</div>
								<div class="panel-footer">
									<a class="btn btn-danger" href="<?php echo base_url(); ?>index.php/task">Cancel</a>
									<button class="btn  pull-right btn-success" type="submit">Save</button>
								</div>
							</form>
						</div>
						
                    </div>
                    
                 </div>
                <!-- END PAGE CONTENT WRAPPER -->
             </div>            
            <!-- END PAGE CONTENT -->
           </div>
        <!-- END PAGE CONTAINER -->
		   </div>				
        <?php $this->load->view('templates/footer');?>
        <script>
        	var BASE_URL = "<?php echo base_url(); ?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/wickedpicker/src/wickedpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/task.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>

		<script>
			$(function(){
				$('.timepickermask').wickedpicker();						
			});
			$(function(){
				if($('#repeat').val() != 'Never' || $('#repeat').val() != 'Daily' || $('#repeat').val() != 'Yearly'){
					var divId=$('#repeat').val();
					$('#repeat-'+divId.toLowerCase()).show(); 
				}
			});
			jQuery(function(){
				var counter = <?php if(isset($editcontact)) { echo count($editcontact); } else { echo 1; } ?>;
				$('.repeat-contact').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_contact_' + counter + '"> <div class="col-md-6"> <div class=""> <label class="col-md-4 control-label" style="padding-left: 0;" >Assigned To</label> <div class="col-md-8"> <input type="hidden" id="contact_' + counter + '_id" name="contact[]" class="form-control" /> <input type="text" id="contact_' + counter + '" name="contact_name[]" class="form-control auto_client" placeholder="Type to choose contact..." /> </div> </div> </div> </div>');
					$('.auto_client', newRow).autocomplete(autocomp_opt);
                    $('.repeatcontact').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
				});
			    $('.reverse-contact').click(function(event){
			    	if((counter)!=1){
				        var id="#repeat_contact_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});

			jQuery(function(){
				var counter = <?php if(isset($editcontact)) { echo count($editcontact); } else { echo 1; } ?>;
				$('.repeat-follower').click(function(event){
					event.preventDefault();
					counter++;
					var newRow = jQuery('<div class="form-group" id="repeat_follower_' + counter + '"> <div class="col-md-6"> <div class=""> <label class="col-md-4 control-label" style="padding-left: 0;" >Task Follower</label> <div class="col-md-8"> <input type="hidden" id="follower_' + counter + '_id" name="follower[]" class="form-control" /> <input type="text" id="follower_' + counter + '" name="follower_name[]" class="form-control auto_client" placeholder="Type to choose contact..." /> </div> </div> </div> </div>');
					$('.auto_client', newRow).autocomplete(autocomp_opt);
                    $('.follower_div').append(newRow);
			        $("form :input").change(function() {
		                $(".save-form").prop("disabled",false);
		            });
				});
			    $('.reverse-follower').click(function(event){
			    	if((counter)!=1){
				        var id="#repeat_follower_"+(counter).toString();
				        if($(id).length>0){
				            $(id).remove();
				            counter--;
				        }
			    	}
			    });
			});
		</script>
		<script>
	        $( "#property" ).change(function() {
	            var property=$("#property").val();
	            var dataString = 'property_id=' + property + '&task_id=' + <?php if(isset($taskdetail->task_id)) echo $taskdetail->task_id; else echo '0';?>;

	            $.ajax({
	               type: "POST",
	               url: "<?php echo base_url() . 'index.php/Task/get_sub_property' ?>",
	               data: dataString,
	               cache: false,
	               success: function(html){
	                   $("#sub_property").html(html);
	               } 
	            });
	        });
	    </script>
    	<!-- END SCRIPTS -->      
    </body>
</html>