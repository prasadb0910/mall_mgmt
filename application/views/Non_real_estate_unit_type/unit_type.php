<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
  	<link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" >
	<link href="<?php echo base_url(); ?>assets/plugins/datatables/css/export.css" rel="stylesheet" type="text/css" media="screen" />
<style>

.btn-editt {
    font-size: 17px;
    color: #333;
    margin: 0 5px;
    display: inline-block;
    font-weight: 600;
}
.btn-editt:hover {
    color: #95b75d;
}
.btn-delete {
    font-size: 20px;
    color: #333;
    margin: 0 5px;
    display: inline-block;
    font-weight: 600;
}
.btn-delete:hover {
    color: #e90404;
}
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
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>





<div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
 <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>" > Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?=base_url("index.php/Non_real_estate_property")?>">Non Real Estate</a></li>
<li class="breadcrumb-item active"><a href="#">Unit Type For Non Real Estate Property</a></li>

</ol>

<div class=" container-fluid   container-fixed-lg bg-white m-t-10">


<div class="card card-transparent">
          <form id="form_expense_category" method="post" action="<?php if(isset($edit_unit_type)) { echo base_url().'index.php/Nrp_unit_type/updateRecord/'.$unit_type_id;} else {echo base_url().'index.php/Nrp_unit_type/saveRecord';} ?>">
<div class="container" style="background:#f6f9fc;margin:10px;">
<div class="row m-t-20 p-t-10">
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Unit Type</label>
			<input type="hidden" class="form-control" name="unit_type_id" id="unit_type_id" value="<?php if(isset($unit_type_id)){ echo $unit_type_id; } ?>"/>
			<input type="text" class="form-control" name="unit_type" id="unit_type" placeholder="Unit Type" value="<?php if(isset($edit_unit_type)){ echo $edit_unit_type[0]->unit_type; } ?>"/>
</div>
</div>
<div class="col-md-2">
<button class="btn btn-default m-t-10" style="float:right;" type="submit"> Save</button>
</div>
</div>
</div>
</form>

<div class="card-header  d-flex justify-content-between">
<div class="card-title"><b>Unit Type For Non Real Estate Property</b>
</div>
<div class="export-options-container"></div>

</div>
<div class="card-block">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
<th>Sr No.</th>
<th>Unit Type</th>
<th>Actions</th>

</tr>
</thead>
<tbody>
			<?php for($i=0;$i<count($unit_type); $i++) {?>
	<tr id="trow_1">
	<td align="center"><?php echo ($i + 1); ?></td>
	<td><?php echo $unit_type[$i]->unit_type ?></td>
	<td style="text-align:center;">
	<a class="btn-editt" href="<?php echo base_url().'index.php/Nrp_unit_type/editRecord/'.$unit_type[$i]->id; ?>"><span class="fa fa-edit"></span></a>
	<a onclick="return confirm('Are you sure you want to delete this item?');" class="btn-delete" href="<?php echo base_url().'index.php/Nrp_unit_type/deleteRecord/'.$unit_type[$i]->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													</td>

	</tr>
	<?php } ?>


</tbody>
</table>
</div>
</div>

</div>

</div>
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


		<script>
	

		</script>
	
		
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>