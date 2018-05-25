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
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>    
        <!-- EOF CSS INCLUDE -->                                       
		<style>
		.control-label{ padding:7px 3px;}
		@media only screen  and (min-width: 280px) and (max-width: 1020px) {
.heading-h2 {
      display: flex!important;  
		}}
		</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
           <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                           <div class="heading-h2"> 
                 	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Indexation Master 
                 </div>  
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                     <div class="row  main-wrapper">
						 <div class="main-container"> 
                <form id="form_indexation" method="post" action="<?php if(isset($editindexation)) { echo base_url().'index.php/indexation/updateRecord/'.$i_id;} else {echo base_url().'index.php/indexation/saveRecord';} ?>">
                        <div class="col-md-12">
								<div class="panel panel-default inside-width">
									<div class="panel-body">    
										<div class="row">
										<div class="form-group" style="  border:1px dotted #ddd; margin-bottom:10px;" >
												<div class="col-md-5 col-sm-6 col-xs-12">
													<div class="">
														<label class="col-md-4 control-label" style="">Financial Year *</label>
														<div class="col-md-8">
															<input type="hidden" class="form-control" name="i_id" id="i_id" value="<?php if(isset($i_id)){ echo $i_id; } ?>"/>
															<!-- <input type="text" class="form-control" name="financial_year" id="financial_year" placeholder="Year" value="<?php //if(isset($editindexation)){ echo $editindexation[0]->i_financial_year; } ?>"/> -->
															<select class="form-control" name="financial_year" id="financial_year">
																<option value="">Select</option>
															</select>
														</div>
													</div>
												</div>
												<div class="col-md-5 col-sm-6 col-xs-12">	
													<div class="">
														<label class="col-md-4 control-label" style="">Cost Inflation Index*</label>
														<div class="col-md-8">
															<input type="text" class="form-control format_number" name="cost_inflation_index" placeholder="Index" value="<?php if(isset($editindexation)){ echo $editindexation[0]->i_cost_inflation_index; } ?>"/>
														</div>
													</div>
												</div>

												 <div class="col-md-1 col-sm-12 col-xs-12">
										<button class="btn btn-success	 pull-right">Save</button>
										
							</div>
							<br clear="all"/>
											</div>
											
											
											
											
											
											
											
											
											
											
											
										</div>
									 
	                           

									<!-- START DATATABLE EXPORT -->
								<div class="" >
										<h3 class="panel-title"  >Indexation List</h3>
										
										<div class="btn-group pull-right btn-cntnr">
											<button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download </button>
											<ul class="dropdown-menu">
												<li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
												
												<li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
												
											</ul>
										</div>
										
									</div>
									<div class="panel-body">
										<div class="table-responsive">
										<table id="customers2" class="table datatable table-bordered" style="border: none; ">
											<thead>
												<tr>
													<th align="center" width="78" style="text-align:center;">Sr. No.</th>
													<th>Financial Year</th>
													<th>Cost Inflation Index</th>
													<th width="100" style="text-align:center;">Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php for($i=0;$i<count($indexation); $i++) {?>
												<tr id="trow_1">
													<td align="center"><?php echo ($i + 1); ?></td>
													<td><?php echo $indexation[$i]->i_financial_year; ?></td>
													<td><?php echo $indexation[$i]->i_cost_inflation_index ?></td>
													<td style="text-align:center;">
														<a class="btn-editt" href="<?php echo base_url().'index.php/indexation/editRecord/'.$indexation[$i]->i_id; ?>"><span class="fa fa-edit"></span></a>
														<a onclick="return confirm('Are you sure you want to delete this item?');" class="btn-delete" href="<?php echo base_url().'index.php/indexation/deleteRecord/'.$indexation[$i]->i_id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													</td>
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
            </form>

       
          </div>
              </div>
          </div>
        <!-- END PAGE CONTAINER -->
   </div>
          </div>
        <?php $this->load->view('templates/footer');?>
		<script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        <script>
        	$(document).ready(function(){
        		var minOffset = 1981, maxOffset = 50;
				var thisYear = (new Date()).getFullYear();
				var editYear = '<?php if(isset($editindexation)) echo $editindexation[0]->i_financial_year; else echo ''; ?>';

				for (var i = minOffset; i <= thisYear+maxOffset; i++) { 
					var year = i.toString() + '-' + (i+1).toString().substring(2, 4);
					$('<option>', {value: year, text: year}).appendTo("#financial_year");
				}
				if(editYear=="") {
					var year = thisYear.toString() + '-' + (thisYear+1).toString().substring(2, 4);
					$("#financial_year").val(year);
				} else {
					$("#financial_year").val(editYear);
				}
        	});
        </script>
    <!-- END SCRIPTS -->      
    
    </body>
</html>