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
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/theme-blue.css'; ?>"/> 
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		 <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/> 


    </head>
    <body>								
       	
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
                  <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Task List</div>


                          <div class="nav-contacts ng-scope" ui-view="@nav">
							  <div class="u-borderBottom u-bgColorBreadcrumb ng-scope">
								 <div class="container u-posRelative u-textRight">
									      <div class="pull-left btn-top">
													<div class="c">
										<a class="btn btn-success" href="<?php echo base_url(); ?>index.php/task/task_edit">
											<span class="fa fa-plus"></span> Add Task Details
										</a>
									</div>
									<?php $this->load->view('templates/download');?>
												</div>
								 
								
									<i class="scroll-left icon-fo icon-fo-left-open-big" ng-click="scrollLeft()"></i>
									<ul class="m-nav--linetriangle" ng-swipe-left="app.onInnerSwipe($event);" ng-swipe-right="app.onInnerSwipe($event);">
										<li class="all">
												<a href="<?php echo base_url();?>index.php/task/index/All"  >
												<span class="ng-binding">All</span>
											     <span id="approved">(<?php echo $allTask;?>)</span> </a>

										</li>

										<li class="mytask" >
												<a href="<?php echo base_url();?>index.php/task/index/Mytask"  >
												<span class="ng-binding">My Task</span>
											   <span id="approved">(<?php echo $myTask;?>)</span> </a>
										</li>									 
										<li class="pending">
											<a  href="<?php echo base_url(); ?>index.php/task/index/Pending">
											<span class="ng-binding">Pending Task</span>
											<span id="approved">(<?php echo $pendingTask;?>)</span>  
											</a>
										</li>
									</ul>
									<i class="scroll-right icon-fo icon-fo-right-open-big" ng-click="scrollRight()"></i>
							   </div>
							 </div>
                          </div>
       
<ul class="topnav" id="myTopnav">
	<li class="all">
			<a href="<?php echo base_url();?>index.php/task/index/All"  >
			<span class="ng-binding">All</span>
			 <span id="approved">(<?php echo $allTask;?>)</span> </a>

	</li>

	<li class="mytask" >
			<a href="<?php echo base_url();?>index.php/task/index/Mytask"  >
			<span class="ng-binding">My Task</span>
		   <span id="approved">(<?php echo $myTask;?>)</span> </a>
	</li>									 
	<li class="pending">
		<a  href="<?php echo base_url(); ?>index.php/task/index/Pending">
		<span class="ng-binding">Pending Task</span>
		<span id="approved">(<?php echo $pendingTask;?>)</span>  
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
                             <div class="col-md-12" style="padding:0;" >
						       <div class="panel panel-default inside-width" style="border:none;box-shadow:none; ">	
							
						
							<!-- START DATATABLE EXPORT -->
							
							<div class="panel-body">
								<div class="table-responsive">
								<table id="customers2" role="grid" class="table datatable table-bordered">
									<thead>
										<tr>
											<th  width="45"  style="text-align:center;" > Sr. No. </th>
											<th  width="210"> Task Name </th>
											<th  width="210"> Assigned to </th>
											<th  width="80"> Priority </th>
											<th  width="70"> Due Date </th>
											<th  width="80"> From Date </th>
											<th  width="80"> To Date</th>
											<th  width="70"> Status </th
												</tr>
									</thead>
									<tbody>
										<?php if(count($tasklist) > 0){
											$i=1;
											$name;
											foreach($tasklist as $row){
												if($row->name=='') { $name='Self'; } else { $name=$row->name; }
											
											echo '<tr>
												<td align="center">'.$i.'</td>
											<td><a href="'.base_url().'index.php/Task/task_view/'.urlencode($row->id).'">'.$row->subject_detail.'</a></td>
											<td>'. $name .'</td>
											<td>'.$row->priority.'</td>
											<td>'.date('d/m/Y',strtotime($row->due_date)).'</td>
											<td>'.date('d/m/Y',strtotime($row->from_date)).'</td>
											<td>'.date('d/m/Y',strtotime($row->to_date)).'</td>
											<td>'.$row->task_status.'</td>
											<!--<td><a href="'.base_url().'index.php/Task/task_view/'.urlencode($row->id).'"><button class="btn btn-info">View</button></a></td>-->
											</tr>';
											$i++;}
										}?>
						
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
                } else  if(url.includes('Mytask')){
                    $('.mytask').attr('class','active');
                } else  if(url.includes('Pending')){
                    $('.pending').attr('class','active');
                } else {
                	$('.all').attr('class','active');
                }

                $('.ahrefall').click(function(){
                    alert(window.location.href );
                    //$('.a').attr('class','active');
                });
            });	
			</script>
        <script>
        var BASE_URL = "<?php echo base_url(); ?>";
        //alert(BASE_URL);</script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/task.js"></script>
		<script>
		//loadTaskList();</script>
    <!-- END SCRIPTS -->    

 
    </body>
</html>