<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />                                
		
<style>
	table.dataTable thead .sorting:after {
    opacity: 0.2; 
    content: ""; 
}
table.dataTable thead .sorting_asc:after {
    content: "";
}
table.dataTable thead .sorting_desc:after {
    content: "";
}		
</style>
</head>
    <body>								
        <!-- START PAGE CONTAINER -->
<body class="fixed-header">
<?php $this->load->view('templates/sidebar1');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>


<div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >Dashboard</a></li>
<li class="breadcrumb-item active"><a href="#">Add User Role</a></li>

</ol> 


 <a class="btn btn-default pull-right" href="<?php echo base_url().'index.php/Manage/addnew'; ?>">
										<span class="fa fa-plus"></span> Add User Role
									</a>

<div class=" container-fluid   container-fixed-lg bg-white m-t-50">


<div class="card card-transparent">

<div class="card-block">



                 	
                <!-- PAGE CONTENT WRAPPER -->
							<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="20">Sr. No.</th>
											<th width="50">Role</th>
											<th width="50">Description</th>
											<th width="50">Created By</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0; $i < count($user) ; $i++) { ?>
										<tr id="trow_1">
											<td><?php echo $i+1; ?></td>
											<td><a href="<?php echo base_url().'index.php/Manage/view/'.$user[$i]->rl_id; ?>"><?php echo $user[$i]->role_name; ?></a></td>
											<td><?php echo $user[$i]->r_description; ?></td>
											<td><?php echo $user[$i]->created_by; ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
							</div>
                            <!-- END DEFAULT DATATABLE -->
                            
						</div>
						</div>
				
                    

						
        <?php $this->load->view('templates/footer');?>
			 </div>
						
              </div>
<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>
    <!-- END SCRIPTS -->      
    </body>
</html>













