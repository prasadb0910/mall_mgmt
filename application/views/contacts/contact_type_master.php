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
        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
		<link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url().'css/custome_vj_css.css'; ?>"/>                               
 
<style>
 
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
 
.btn-delete{font-size:20px;     color: #333; margin:0 5px; display: inline-block; font-weight: 600;}
.btn-delete:hover {color: #e90404;}

.btn-editt{font-size:17px;     color: #333; margin:0 5px; display: inline-block; font-weight: 600;}
.btn-editt:hover {color: #95b75d;}


</style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
               <div class="heading-h2"> 
                 	 <a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; Related Party Type Master 
                 </div>  
                
       
                  
                <!-- PAGE CONTENT WRAPPER -->
                 <div class="page-content-wrap">
                     <div class="row  main-wrapper">
						 <div class="main-container"> 

                <form id="form_contact_type" method="post" action="<?php if(isset($edit_contact_type)) { echo base_url().'index.php/contact_type/updateRecord/'.$contact_type_id;} else {echo base_url().'index.php/contact_type/saveRecord';} ?>">
                  
					
					 
						
                        <div class="col-md-12 ">
						<div class="panel panel-default inside-width">
							
						 
							<div class="panel-body custom-padding">                                                                        
								
								<div class="row">
									<div class="form-group" style="  border:1px dotted #ddd; margin-bottom:10px; padding:10px 15px;">
										 
										<div class="col-md-7 col-sm-7 col-xs-12">
											<div class="">
												<label class="col-md-4 col-sm-5  col-xs-12 control-label"  style="line-height:28px; ">Related Party Type *</label>
												<div class="col-md-8 col-sm-7  col-xs-12">
													<input type="hidden" class="form-control" name="contact_type_id" id="contact_type_id" value="<?php if(isset($contact_type_id)){ echo $contact_type_id; } ?>"/>
													<input type="text" class="form-control" name="contact_type" id="contact_type" placeholder="Contact Type" value="<?php if(isset($edit_contact_type)){ echo $edit_contact_type[0]->contact_type; } ?>"/>
												</div>
											</div>
										</div>
										<div class="col-md-1 col-sm-2 col-xs-12"><button class="btn btn-success pull-right" style=" ">Save</button></div>
									 
										<br clear="all"/>
									</div>
									
									
								</div>
								
								<!-- <div class="row">&nbsp;</div>

								<button class="btn btn-primary pull-right" style="margin-right:5px;">Save</button> -->
								
							</div>

							<!-- START DATATABLE EXPORT -->
							<div class=" ">
								<h3 class="panel-title">Related Party Type</h3>
								
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
								<table id="customers2" class="table datatable table-bordered" style="border-top:none;">
									<thead>
										<tr>
											<th width="90" align="center">Sr. No.</th>
											<th >Related Party Type</th>
											<th style="text-align:center;" width="110">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php for($i=0;$i<count($contact_type); $i++) {?>
										<tr id="trow_1">
											<td align="center"><?php echo ($i + 1); ?></td>
											<td><?php echo $contact_type[$i]->contact_type; ?></td>
								 
											<td style="text-align:center;">
														<a class="btn-editt" href="<?php echo base_url().'index.php/contact_type/editRecord/'.$contact_type[$i]->id; ?>"><span class="fa fa-edit"></span></a>
														<a onclick="return confirm('Are you sure you want to delete this item?');" class="btn-delete" href="<?php echo base_url().'index.php/contact_type/deleteRecord/'.$contact_type[$i]->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
						
                   
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
            </form>
             </div>
             </div>
         </div>
        <!-- END PAGE CONTAINER -->

        <?php $this->load->view('templates/footer');?>
		<script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    <!-- END SCRIPTS -->      
    
    </body>
</html>