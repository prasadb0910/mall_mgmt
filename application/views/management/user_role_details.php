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

<style>
.a
{
border-bottom: 2px solid #edf0f5;
margin-bottom: 25px;
padding-bottom: 25px;
}
</style>
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			th{text-align:center;}
			.center{text-align:center;}
			.form-group { border:1px dotted #ddd;  }
			.report-expand { display:none ; border:1px dotted #ddd;/* margin-top:-10px;*/ background:#fff; border-top:1px solid #fff; }
			.list-group-item-reports {
			    position: relative; text-decoration:none; color:#555;
			    display: block; font-size:12px; font-weight:600;
			    padding: 8px 15px; border-top:1px solid #eee;
			    margin-bottom: -1px;
			    background-color: #fff;
			}
			.list-group-item-reports { font-size:13px;}
			.list-group-item-reports:hover { text-decoration:none; /* background-color: #2f3c48; color:#fff;*/}
			.btn-clr { background:#fff; color:#000; margin-top:-10px; }
			.push { margin-top:3px; margin-left:5px;}
			.selectAllLabel { font-size: larger; font-weight: bold; margin-bottom:-10px; }
		 	#checkboxes, #log { min-width: 250px;  vertical-align: middle; padding: 10px;  }
			#selectall-1, #selectall-2, #selectall-3, #selectall-4, #selectall-5, #selectall-6 { margin-top:20px; margin-left:10px;}
			.panel.panel-success {
    border-top-color: #95b75d!important;
	   border-top: 2px solid;
}
 
.panel-success {
    box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2)!important;
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
<li class="breadcrumb-item active"><a href="<?php echo base_url().'index.php/manage'; ?>" > User Role List </a></li>
<li class="breadcrumb-item active"><a href="#">User Role Details</a></li>

</ol> 


                  
                <!-- PAGE CONTENT WRAPPER -->
          
					
<div class=" container-fluid  p-t-20 container-fixed-lg bg-white" >


 <div class="card card-transparent">
						
                     
							
                            <form id="form_user_role_details" role="form" method="post" action="<?php if(isset($edituser)) { if($r_id==0) echo base_url().'index.php/Manage/saverecord'; else echo base_url().'index.php/Manage/updaterecord/'.$r_id;} else {echo base_url().'index.php/Manage/saverecord';} ?>">
                                 
								
<div class="a">

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Role </label>
	<input type="hidden" class="form-control" name="rl_id" id="rl_id" value="<?php if(isset($edituser)) { if($r_id==0) echo ''; else echo $r_id; } ?>"/>
	<input type="text" class="form-control" name="role" id="role_name" value="<?php if(isset($edituser)) { if($r_id==0) echo ($edituser[0]->role_name).' 1'; else echo $edituser[0]->role_name; } ?>" placeholder="Role"/>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default required">
<label>Role Description</label>
<input type="text" class="form-control" name="role_description" placeholder="Role Description" value="<?php if(isset($edituser)) { echo $edituser[0]->r_description; } ?>"/>
</div>
</div>


</div>
</div>
							
						
											<table id="" class="table table-bordered"   >
												<thead>
													<tr>
														<th width="50">Module</th>
														<th width="50"><input type="checkbox" id="view"  onchange="selectall(1);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View</th>
														<th width="50"><input type="checkbox" id="insert"  onchange="selectall(2);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Insert</th>
														<th width="50"><input type="checkbox" id="update"  onchange="selectall(3);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update</th>
														<th width="75"><input type="checkbox" id="delete"  onchange="selectall(4);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete</th>
														<th width="75"><input type="checkbox" id="approval"  onchange="selectall(5);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Approval</th>
														<th width="75"><input type="checkbox" id="export"  onchange="selectall(6);" value="1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Download</th>

													</tr>
												</thead>
												<tbody>
													<!-- <tr id="trow_1">
														<td>Group Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_vw"  onchange="checkgroup(this);" name="view[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_ins" onchange="checkgroup(this);" name="insert[]" value="0"   <?php //if(isset($editoptions)) { if($editoptions[0]->r_insert == 1) { echo 'checked';} } ?>/></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_upd" onchange="checkgroup(this);" name="update[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_del" onchange="checkgroup(this);" name="delete[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_app" onchange="checkgroup(this);" name="approval[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="grp_exp" onchange="checkgroup(this);" name="export[]" value="0"  <?php //if(isset($editoptions)) { if($editoptions[0]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr> -->
													<tr id="trow_2">
														<td>Contact Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_vw"  onchange="checkcontact(this);"  name="view[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_ins"  onchange="checkcontact(this);"  name="insert[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_upd"  onchange="checkcontact(this);"  name="update[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_del"  onchange="checkcontact(this);"  name="delete[]" value="0" <?php if(isset($editoptions[0])) { if($editoptions[0]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_app"  onchange="checkcontact(this);"  name="approval[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="con_exp"  onchange="checkcontact(this);"  name="export[]" value="0"  <?php if(isset($editoptions[0])) { if($editoptions[0]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_3">
														<td>Bank Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_vw"  onchange="checkbank(this);"  name="view[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_ins"  onchange="checkbank(this);"  name="insert[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_upd"  onchange="checkbank(this);"  name="update[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_del"  onchange="checkbank(this);"  name="delete[]" value="1" <?php if(isset($editoptions[1])) { if($editoptions[1]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_app"  onchange="checkbank(this);"  name="approval[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bnk_exp"  onchange="checkcontact(this);"  name="export[]" value="1"  <?php if(isset($editoptions[1])) { if($editoptions[1]->r_export == 1) { echo 'checked';} } ?> /></td>
														</td>
													</tr>
													<tr id="trow_4">
														<td>Owner Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_vw"  onchange="checkowner(this);"  name="view[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_ins"  onchange="checkowner(this);"  name="insert[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_upd"  onchange="checkowner(this);"  name="update[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_del"  onchange="checkowner(this);"  name="delete[]" value="2" <?php if(isset($editoptions[2])) { if($editoptions[2]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_app"  onchange="checkowner(this);"  name="approval[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="own_exp"  onchange="checkcontact(this);"  name="export[]" value="2"  <?php if(isset($editoptions[2])) { if($editoptions[2]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_5">
														<td>Purchase Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_vw"  onchange="checkpurchase(this);"  name="view[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_ins"  onchange="checkpurchase(this);"  name="insert[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_upd"  onchange="checkpurchase(this);"  name="update[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_del"  onchange="checkpurchase(this);"  name="delete[]" value="3" <?php if(isset($editoptions[3])) { if($editoptions[3]->r_delete == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_app"  onchange="checkpurchase(this);"  name="approval[]" value="3"  <?php if(isset($editoptions[3])) { if($editoptions[3]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="pur_exp"  onchange="checkcontact(this);"  name="export[]" value="3"  <?php if(isset($editoptions[3])) { if($editoptions[3]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_6">
														<td>Allocation Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_vw"  onchange="checkallocation(this);"  name="view[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_ins"  onchange="checkallocation(this);"  name="insert[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_upd"  onchange="checkallocation(this);"  name="update[]" value="4" <?php if(isset($editoptions[4])) { if($editoptions[4]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_del"  onchange="checkallocation(this);"  name="delete[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_app"  onchange="checkallocation(this);"  name="approval[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="alc_exp"  onchange="checkcontact(this);"  name="export[]" value="4"  <?php if(isset($editoptions[4])) { if($editoptions[4]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_7">
														<td>Sale Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_vw"  onchange="checksale(this);"  name="view[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_view == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_ins"  onchange="checksale(this);"  name="insert[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_upd"  onchange="checksale(this);"  name="update[]" value="5" <?php if(isset($editoptions[5])) { if($editoptions[5]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_del"  onchange="checksale(this);"  name="delete[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_app"  onchange="checksale(this);"  name="approval[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="sle_exp"  onchange="checkcontact(this);"  name="export[]" value="5"  <?php if(isset($editoptions[5])) { if($editoptions[5]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_8">
														<td>Rent Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_vw"  onchange="checkrent(this);"  name="view[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_ins"  onchange="checkrent(this);"  name="insert[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_insert == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_upd"  onchange="checkrent(this);"  name="update[]" value="6" <?php if(isset($editoptions[6])) { if($editoptions[6]->r_edit == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_del"  onchange="checkrent(this);"  name="delete[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_app"  onchange="checkrent(this);"  name="approval[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rnt_exp"  onchange="checkcontact(this);"  name="export[]" value="6"  <?php if(isset($editoptions[6])) { if($editoptions[6]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_9">
														<td>Bank Entry Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_vw"  onchange="checkbankentry(this);"  name="view[]" value="7" <?php if(isset($editoptions[7])) { if($editoptions[7]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_ins"  onchange="checkbankentry(this);"  name="insert[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_upd"  onchange="checkbankentry(this);"  name="update[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_del"  onchange="checkbankentry(this);"  name="delete[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_app"  onchange="checkbankentry(this);"  name="approval[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="bank_entry_exp"  onchange="checkcontact(this);"  name="export[]" value="7"  <?php if(isset($editoptions[7])) { if($editoptions[7]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_10">
														<td>Loan Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_vw"  onchange="checkloan(this);"  name="view[]" value="8" <?php if(isset($editoptions[8])) { if($editoptions[8]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_ins"  onchange="checkloan(this);"  name="insert[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_upd"  onchange="checkloan(this);"  name="update[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_del"  onchange="checkloan(this);"  name="delete[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_app"  onchange="checkloan(this);"  name="approval[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="lon_exp"  onchange="checkcontact(this);"  name="export[]" value="8"  <?php if(isset($editoptions[8])) { if($editoptions[8]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_11">
														<td>Expense Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_vw"  onchange="checkloan(this);"  name="view[]" value="9" <?php if(isset($editoptions[9])) { if($editoptions[9]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_ins"  onchange="checkloan(this);"  name="insert[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_upd"  onchange="checkloan(this);"  name="update[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_del"  onchange="checkloan(this);"  name="delete[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_app"  onchange="checkloan(this);"  name="approval[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="exp_exp"  onchange="checkcontact(this);"  name="export[]" value="9"  <?php if(isset($editoptions[9])) { if($editoptions[9]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_12">
														<td>Maintenance Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_vw"  onchange="checkloan(this);"  name="view[]" value="10" <?php if(isset($editoptions[10])) { if($editoptions[10]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_ins"  onchange="checkloan(this);"  name="insert[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_upd"  onchange="checkloan(this);"  name="update[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_del"  onchange="checkloan(this);"  name="delete[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_app"  onchange="checkloan(this);"  name="approval[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="main_exp"  onchange="checkcontact(this);"  name="export[]" value="10"  <?php if(isset($editoptions[10])) { if($editoptions[10]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_13">
														<td>Valuation</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_vw"  onchange="checkloan(this);"  name="view[]" value="11" <?php if(isset($editoptions[11])) { if($editoptions[11]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_ins"  onchange="checkloan(this);"  name="insert[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_insert == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_upd"  onchange="checkloan(this);"  name="update[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_edit == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_del"  onchange="checkloan(this);"  name="delete[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_delete == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_app"  onchange="checkloan(this);"  name="approval[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_approvals == 1) { echo 'checked';} } ?> /></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="val_exp"  onchange="checkcontact(this);"  name="export[]" value="11"  <?php if(isset($editoptions[11])) { if($editoptions[11]->r_export == 1) { echo 'checked';} } ?> /></td>
													</tr>
													<tr id="trow_14" style="  border-top: 1px solid rgba(230,230,230,0.7);  border-bottom: 1px solid rgba(230,230,230,0.7);">
														<td>Tax Details</td>
														<td class="center"><input type="checkbox" class="cls_chk" id="tax_vw"  onchange="checkloan(this);"  name="view[]" value="12" <?php if(isset($editoptions[12])) { if($editoptions[12]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td colspan="5" class="center">&nbsp;</td>
													</tr>
													<tr id="trow_15">
														<td> <span class="">   Reports </span> <a class="reports" href="javascript:void(0);"><span class="badge badge-info pull-right"> View Reports</span></a></td>
														<td class="center"><input type="checkbox" class="cls_chk" id="rep_vw"  onchange="checkloan(this);"  name="view[]" value="13" <?php if(isset($editoptions[13])) { if($editoptions[13]->r_view == 1) { echo 'checked';} } ?>  /></td>
														<td colspan="5" class="center">&nbsp;</td>
													</tr>

												</tbody>
											</table>
									
								
								<div class="panel report-expand selectreport">  
						            <div class="panel-heading ui-draggable-handle" style="padding:15px;">
							           	<span class="btn btn-default btn-clr bt-xs pull-left"> <label class="" style="padding:0; margin:0;"> Select All &nbsp; <input type="checkbox" id="checkAll" class="check-box" /> </label> </span>
							           	<a class="reports" href="javascript:void(0);" ><span class="badge  pull-right" style="margin-top:-5px;"> X </span></a>
						            </div> 
					               	<br clear="all">
					
					                 	<div id="checkboxes" class="row">
											<div class="col-md-4" <?php if(isset($rep_grp_1)) {if($rep_grp_1==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        	<!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                          		<label class="selectAllLabel">
					                              	<h3 class=" pull-left">Group Level</h3> 
					                                <input type="checkbox" id="selectall-1"/>
					                                </label>
					                            </div> 
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-1">
								                 		<label class="list-group-item-reports" <?php if(isset($rep_1_view)) {if($rep_1_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_a" name="report[]" value="1" <?php if(isset($rep_1)) {if($rep_1==1) echo 'checked';} ?> /> Asset Allocation-Owner wise </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_2_view)) {if($rep_2_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group1_b" name="report[]" value="2" <?php if(isset($rep_2)) {if($rep_2==1) echo 'checked';} ?> /> Asset Allocation-Usage wise </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_3_view)) {if($rep_3_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_c" name="report[]" value="3" <?php if(isset($rep_3)) {if($rep_3==1) echo 'checked';} ?> /> Loan Details </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_4_view)) {if($rep_4_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_d" name="report[]" value="4" <?php if(isset($rep_4)) {if($rep_4==1) echo 'checked';} ?> /> Maintenance Property Tax </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_5_view)) {if($rep_5_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_e" name="report[]" value="5" <?php if(isset($rep_5)) {if($rep_5==1) echo 'checked';} ?> /> Related Party </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_6_view)) {if($rep_6_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_f" name="report[]" value="6" <?php if(isset($rep_6)) {if($rep_6==1) echo 'checked';} ?> /> Rent Summary </label>
									                 	<label class="list-group-item-reports" <?php if(isset($rep_19_view)) {if($rep_19_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group1_g" name="report[]" value="19" <?php if(isset($rep_19)) {if($rep_19==1) echo 'checked';} ?> /> Sale Details </label>
					                                </div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
											<div class="col-md-4" <?php if(isset($rep_grp_2)) {if($rep_grp_2==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        	<!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                              	<label class="selectAllLabel">
					                                    <h3 class="pull-left">Owner Level</h3> 
					                                   	<input type="checkbox" id="selectall-2"/>
					                               	</label>         
					                        	</div>
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-2">
					                                	<label class="list-group-item-reports" <?php if(isset($rep_7_view)) {if($rep_7_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_a" name="report[]" value="7" <?php if(isset($rep_7)) {if($rep_7==1) echo 'checked';} ?> /> Asset Allocation-Usage wise </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_8_view)) {if($rep_8_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_b" name="report[]" value="8" <?php if(isset($rep_8)) {if($rep_8==1) echo 'checked';} ?> /> Loan Details </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_9_view)) {if($rep_9_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_c" name="report[]" value="9" <?php if(isset($rep_9)) {if($rep_9==1) echo 'checked';} ?> /> Related Party </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_10_view)) {if($rep_10_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_d" name="report[]" value="10" <?php if(isset($rep_10)) {if($rep_10==1) echo 'checked';} ?> /> Rent Summary </label>
					                                	<label class="list-group-item-reports" <?php if(isset($rep_20_view)) {if($rep_20_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>> <input type="checkbox" id="group2_e" name="report[]" value="20" <?php if(isset($rep_20)) {if($rep_20==1) echo 'checked';} ?> /> Sale Details </label>
					                              	</div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
											<div class="col-md-4" <?php if(isset($rep_grp_3)) {if($rep_grp_3==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                            <!-- CONTACTS WITH CONTROLS -->
					                          	<div class="">
					                            	<label class="selectAllLabel">
					                                    <h3 class="pull-left">Asset Level</h3>
					                                 	<input type="checkbox" id="selectall-3"/>
					                              	</label>          
					                            </div> 
					                            <div class="panel panel-success">
					                                <div class="panel-body list-group" id="friendslist-3">
						                                <label class="list-group-item-reports" <?php if(isset($rep_11_view)) {if($rep_11_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_a" name="report[]" value="11" <?php if(isset($rep_11)) {if($rep_11==1) echo 'checked';} ?> /> Profitability </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_12_view)) {if($rep_12_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_b" name="report[]" value="12" <?php if(isset($rep_12)) {if($rep_12==1) echo 'checked';} ?> /> Purchase Variance </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_13_view)) {if($rep_13_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_c" name="report[]" value="13" <?php if(isset($rep_13)) {if($rep_13==1) echo 'checked';} ?> /> Related Party </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_14_view)) {if($rep_14_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_d" name="report[]" value="14" <?php if(isset($rep_14)) {if($rep_14==1) echo 'checked';} ?> /> Rent </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_15_view)) {if($rep_15_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_e" name="report[]" value="15" <?php if(isset($rep_15)) {if($rep_15==1) echo 'checked';} ?> /> Sale </label>
						                                <label class="list-group-item-reports" <?php if(isset($rep_16_view)) {if($rep_16_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group3_f" name="report[]" value="16" <?php if(isset($rep_16)) {if($rep_16==1) echo 'checked';} ?> /> Sale Variance </label>
					                                </div>
					                            </div>
					                            <!-- END CONTACTS WITH CONTROLS -->
					                        </div>
									
					                
					                                
					                
										<div class="col-md-4" <?php if(isset($rep_grp_4)) {if($rep_grp_4==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                       	<div class="">
					                           	<label class="selectAllLabel">
					                                <h3 class="pull-left">Account Level</h3>
													<input type="checkbox" id="selectall-4"/>
					                          	</label>        
					                        </div> 
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-4">
					                            <label class="list-group-item-reports" <?php if(isset($rep_21_view)) {if($rep_21_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_a"  name="report[]" value="21" <?php if(isset($rep_21)) {if($rep_21==1) echo 'checked';} ?> />  Income  </label>
					                            <label class="list-group-item-reports" <?php if(isset($rep_22_view)) {if($rep_22_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_b"  name="report[]" value="22" <?php if(isset($rep_22)) {if($rep_22==1) echo 'checked';} ?> />  Expense  </label>
					                            <label class="list-group-item-reports" <?php if(isset($rep_23_view)) {if($rep_23_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_c"  name="report[]" value="23" <?php if(isset($rep_23)) {if($rep_23==1) echo 'checked';} ?> />  Lease   </label>
					                            <label class="list-group-item-reports" <?php if(isset($rep_24_view)) {if($rep_24_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_d"  name="report[]" value="24" <?php if(isset($rep_24)) {if($rep_24==1) echo 'checked';} ?> />  Bank Statement  </label>
					                            <label class="list-group-item-reports" <?php if(isset($rep_25_view)) {if($rep_25_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_e"  name="report[]" value="25" <?php if(isset($rep_25)) {if($rep_25==1) echo 'checked';} ?> />  TDS  </label>
					                            <label class="list-group-item-reports" <?php if(isset($rep_26_view)) {if($rep_26_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group4_f"  name="report[]" value="26" <?php if(isset($rep_26)) {if($rep_26==1) echo 'checked';} ?> />  GST  </label>
					                            
					                            </div>
					                        </div>
					                    </div>
					         
					                    <!--
										<div class="col-md-4" <?php //if(isset($rep_grp_5)) {if($rep_grp_5==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                        <div class="">
					                           	<label class="selectAllLabel">
					                                <h3 class="pull-left">Property Reports</h3>
					                             	<input type="checkbox" id="selectall-5"/>
					                          	</label>            
					                        </div>
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-5">
					                                <label class="list-group-item-reports" <?php //if(isset($rep_21_view)) {if($rep_21_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_a" name="report[]" value="21" <?php //if(isset($rep_21)) {if($rep_21==1) echo 'checked';} ?> />   Policies  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_22_view)) {if($rep_22_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_b" name="report[]" value="22" <?php //if(isset($rep_22)) {if($rep_22==1) echo 'checked';} ?> />   Accounting  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_23_view)) {if($rep_23_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_c" name="report[]" value="23" <?php //if(isset($rep_23)) {if($rep_23==1) echo 'checked';} ?> />   Leases  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_24_view)) {if($rep_24_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_d" name="report[]" value="24" <?php //if(isset($rep_24)) {if($rep_24==1) echo 'checked';} ?> />  Revenue  </label>
					                                <label class="list-group-item-reports" <?php //if(isset($rep_25_view)) {if($rep_25_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group5_e" name="report[]" value="25" <?php //if(isset($rep_25)) {if($rep_25==1) echo 'checked';} ?> />  Earnings  </label>
					                          	</div>
					                        </div>
					                    </div>
										<div class="col-md-4" <?php //if(isset($rep_grp_6)) {if($rep_grp_6==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>>
					                       	<div class="">
					                            <label class="selectAllLabel">
					                                <h3 class="pull-left">Expense Reports</h3>
					                             	<input type="checkbox" id="selectall-6"/>
					                          	</label>             
					                        </div>
					                        <div class="panel panel-success">
					                            <div class="panel-body list-group" id="friendslist-6">
					                            <label class="list-group-item-reports" <?php //if(isset($rep_26_view)) {if($rep_26_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_a" name="report[]" value="26" <?php //if(isset($rep_26)) {if($rep_26==1) echo 'checked';} ?> />  Accounting for Leases   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_27_view)) {if($rep_27_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_b" name="report[]" value="27" <?php //if(isset($rep_27)) {if($rep_27==1) echo 'checked';} ?> />  Revenue Recognition  </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_28_view)) {if($rep_28_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_c" name="report[]" value="28" <?php //if(isset($rep_28)) {if($rep_28==1) echo 'checked';} ?> />  Share   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_29_view)) {if($rep_29_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_d" name="report[]" value="29" <?php //if(isset($rep_29)) {if($rep_29==1) echo 'checked';} ?> />  Leases   </label>
					                            <label class="list-group-item-reports" <?php //if(isset($rep_30_view)) {if($rep_30_view==0) echo 'style="display: none;"';} else echo 'style="display: none;"'; ?>><input type="checkbox" id="group6_e" name="report[]" value="30" <?php //if(isset($rep_30)) {if($rep_30==1) echo 'checked';} ?> />  Financial Instruments  </label>
					                            </div>
					                        </div>
					                    </div>
									</div> -->
									
								</div>
									</div>
					
                          						    <div class="form-footer" style="padding-bottom: 60px;">
									<a href="<?php echo base_url(); ?>index.php/manage" class="btn btn-danger" id="reset" >Cancel</a>
                                    <button class="btn btn-success pull-right">Save</button>
                                </div>
							</form>
							
						
					 </div>
					 </div>
						
                    </div>
                    

						
        <?php $this->load->view('templates/footer');?>
			 </div>
						
              </div>
			  <?php $this->load->view('templates/script');?>
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
        
		<script type="text/javascript">

			function selectall(num) {
				if(num == 1 ) {
					var view_check = document.getElementById('view').checked;
					document.getElementById('con_vw').checked = view_check;
					document.getElementById('bnk_vw').checked = view_check;
					document.getElementById('own_vw').checked = view_check;
					document.getElementById('pur_vw').checked = view_check;
					document.getElementById('alc_vw').checked = view_check;
					document.getElementById('sle_vw').checked = view_check;
					document.getElementById('rnt_vw').checked = view_check;
					document.getElementById('bank_entry_vw').checked = view_check;
					document.getElementById('lon_vw').checked = view_check;
					document.getElementById('exp_vw').checked = view_check;
					document.getElementById('main_vw').checked = view_check;
					document.getElementById('val_vw').checked = view_check;
					document.getElementById('tax_vw').checked = view_check;
					document.getElementById('rep_vw').checked = view_check;
				} else if(num == 2 ) {
					var insert_check = document.getElementById('insert').checked;
					document.getElementById('con_ins').checked = insert_check;
					document.getElementById('bnk_ins').checked = insert_check;
					document.getElementById('own_ins').checked = insert_check;
					document.getElementById('pur_ins').checked = insert_check;
					document.getElementById('alc_ins').checked = insert_check;
					document.getElementById('sle_ins').checked = insert_check;
					document.getElementById('rnt_ins').checked = insert_check;
					document.getElementById('bank_entry_ins').checked = insert_check;
					document.getElementById('lon_ins').checked = insert_check;
					document.getElementById('exp_ins').checked = insert_check;
					document.getElementById('main_ins').checked = insert_check;
					document.getElementById('val_ins').checked = insert_check;
				} else if(num == 3 ) {
					var update_check = document.getElementById('update').checked;
					document.getElementById('con_upd').checked = update_check;
					document.getElementById('bnk_upd').checked = update_check;
					document.getElementById('own_upd').checked = update_check;
					document.getElementById('pur_upd').checked = update_check;
					document.getElementById('alc_upd').checked = update_check;
					document.getElementById('sle_upd').checked = update_check;
					document.getElementById('rnt_upd').checked = update_check;
					document.getElementById('bank_entry_upd').checked = update_check;
					document.getElementById('lon_upd').checked = update_check;
					document.getElementById('exp_upd').checked = update_check;
					document.getElementById('main_upd').checked = update_check;
					document.getElementById('val_upd').checked = update_check;
				} else if(num == 4 ) {
					var delete_check = document.getElementById('delete').checked;
					document.getElementById('con_del').checked = delete_check;
					document.getElementById('bnk_del').checked = delete_check;
					document.getElementById('own_del').checked = delete_check;
					document.getElementById('pur_del').checked = delete_check;
					document.getElementById('alc_del').checked = delete_check;
					document.getElementById('sle_del').checked = delete_check;
					document.getElementById('rnt_del').checked = delete_check;
					document.getElementById('bank_entry_del').checked = delete_check;
					document.getElementById('lon_del').checked = delete_check;
					document.getElementById('exp_del').checked = delete_check;
					document.getElementById('main_del').checked = delete_check;
					document.getElementById('val_del').checked = delete_check;
				} else if(num == 5 ) {
					var approve_check = document.getElementById('approval').checked;
					document.getElementById('con_app').checked = approve_check;
					document.getElementById('bnk_app').checked = approve_check;
					document.getElementById('own_app').checked = approve_check;
					document.getElementById('pur_app').checked = approve_check;
					document.getElementById('alc_app').checked = approve_check;
					document.getElementById('sle_app').checked = approve_check;
					document.getElementById('rnt_app').checked = approve_check;
					document.getElementById('bank_entry_app').checked = approve_check;
					document.getElementById('lon_app').checked = approve_check;
					document.getElementById('exp_app').checked = approve_check;
					document.getElementById('main_app').checked = approve_check;
					document.getElementById('val_app').checked = approve_check;
				} else if(num == 6 ) {
					var export_check = document.getElementById('export').checked;
					document.getElementById('con_exp').checked = export_check;
					document.getElementById('bnk_exp').checked = export_check;
					document.getElementById('own_exp').checked = export_check;
					document.getElementById('pur_exp').checked = export_check;
					document.getElementById('alc_exp').checked = export_check;
					document.getElementById('sle_exp').checked = export_check;
					document.getElementById('rnt_exp').checked = export_check;
					document.getElementById('bank_entry_exp').checked = export_check;
					document.getElementById('lon_exp').checked = export_check;
					document.getElementById('exp_exp').checked = export_check;
					document.getElementById('main_exp').checked = export_check;
					document.getElementById('val_exp').checked = export_check;
				}
			}
			function checkgroup(arg){
				var cid=arg.getAttribute('id');
				/*f(arg.checked == true) {
					if(cid=='grp_ins' || cid == 'grp_upd' || cid == 'grp_del') {
						document.getElementById('grp_vw').checked = true;
						document.getElementById('grp_app').checked = false;
					} else if(cid=='grp_app') {
						document.getElementById('grp_vw').checked = true;
						document.getElementById('grp_ins').checked = false;
						document.getElementById('grp_upd').checked = false;
						document.getElementById('grp_del').checked = false;

					}
				}*/
			}

			function checkcontact(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='con_ins' || cid == 'con_upd' || cid == 'con_del') {
						document.getElementById('con_vw').checked = true;
						document.getElementById('con_app').checked = false;
					} else if(cid=='con_app') {
						document.getElementById('con_vw').checked = true;
						document.getElementById('con_ins').checked = false;
						document.getElementById('con_upd').checked = false;
						document.getElementById('con_del').checked = false;

					}
				}*/
			}

			function checkbank(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='bnk_ins' || cid == 'bnk_upd' || cid == 'bnk_del') {
						document.getElementById('bnk_vw').checked = true;
						document.getElementById('bnk_app').checked = false;
					} else if(cid=='bnk_app') {
						document.getElementById('bnk_vw').checked = true;
						document.getElementById('bnk_ins').checked = false;
						document.getElementById('bnk_upd').checked = false;
						document.getElementById('bnk_del').checked = false;

					}
				}*/
			}

			function checkowner(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='own_ins' || cid == 'own_upd' || cid == 'own_del') {
						document.getElementById('own_vw').checked = true;
						document.getElementById('own_app').checked = false;
					} else if(cid=='own_app') {
						document.getElementById('own_vw').checked = true;
						document.getElementById('own_ins').checked = false;
						document.getElementById('own_upd').checked = false;
						document.getElementById('own_del').checked = false;

					}
				}*/
			}

			function checkpurchase(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='pur_ins' || cid == 'pur_upd' || cid == 'pur_del') {
						document.getElementById('pur_vw').checked = true;
						document.getElementById('pur_app').checked = false;
					} else if(cid=='pur_app') {
						document.getElementById('pur_vw').checked = true;
						document.getElementById('pur_ins').checked = false;
						document.getElementById('pur_upd').checked = false;
						document.getElementById('pur_del').checked = false;

					}
				}*/
			}

			function checkallocation(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='alc_ins' || cid == 'alc_upd' || cid == 'alc_del') {
						document.getElementById('alc_vw').checked = true;
						document.getElementById('alc_app').checked = false;
					} else if(cid=='alc_app') {
						document.getElementById('alc_vw').checked = true;
						document.getElementById('alc_ins').checked = false;
						document.getElementById('alc_upd').checked = false;
						document.getElementById('alc_del').checked = false;

					}
				}*/
			}

			function checksale(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='sle_ins' || cid == 'sle_upd' || cid == 'sle_del') {
						document.getElementById('sle_vw').checked = true;
						document.getElementById('sle_app').checked = false;
					} else if(cid=='sle_app') {
						document.getElementById('sle_vw').checked = true;
						document.getElementById('sle_ins').checked = false;
						document.getElementById('sle_upd').checked = false;
						document.getElementById('sle_del').checked = false;

					}
				}*/
			}

			function checkrent(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='rnt_ins' || cid == 'rnt_upd' || cid == 'rnt_del') {
						document.getElementById('rnt_vw').checked = true;
						document.getElementById('rnt_app').checked = false;
					} else if(cid=='rnt_app') {
						document.getElementById('rnt_vw').checked = true;
						document.getElementById('rnt_ins').checked = false;
						document.getElementById('rnt_upd').checked = false;
						document.getElementById('rnt_del').checked = false;

					}
				}*/
			}
			
			function checkbankentry(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='bank_entry_ins' || cid == 'bank_entry_upd' || cid == 'bank_entry_del') {
						document.getElementById('bank_entry_vw').checked = true;
						document.getElementById('bank_entry_app').checked = false;
					} else if(cid=='bank_entry_app') {
						document.getElementById('bank_entry_vw').checked = true;
						document.getElementById('bank_entry_ins').checked = false;
						document.getElementById('bank_entry_upd').checked = false;
						document.getElementById('bank_entry_del').checked = false;

					}
				}*/
			}
			
			function checkloan(arg){
				var cid=arg.getAttribute('id');
				/*if(arg.checked == true) {
					if(cid=='lon_ins' || cid == 'lon_upd' || cid == 'lon_del') {
						document.getElementById('lon_vw').checked = true;
						document.getElementById('lon_app').checked = false;
					} else if(cid=='lon_app') {
						document.getElementById('lon_vw').checked = true;
						document.getElementById('lon_ins').checked = false;
						document.getElementById('lon_upd').checked = false;
						document.getElementById('lon_del').checked = false;

					}
				}*/
			}
		</script>
        <script>
			$(document).ready(function(){
			    $(".reports").click(function(){
			        $(".report-expand").slideToggle();
			    });
			});
		</script>   
		<script type="text/javascript" >
				$("#checkAll").change(function () {
				$('.selectreport').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));
			});
        </script>


        <script type="text/javascript" >
	       	$('#selectall-1').change(function() {      
	            $('#friendslist-1').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			 $('#selectall-2').change(function() {      
	            $('#friendslist-2').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			 $('#selectall-3').change(function() {      
	            $('#friendslist-3').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			 $('#selectall-4').change(function() {      
	            $('#friendslist-4').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			 $('#selectall-5').change(function() {      
	            $('#friendslist-5').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
			
			 $('#selectall-6').change(function() {      
	            $('#friendslist-6').find('input[type=checkbox]').prop('checked', $(this).prop("checked"));      
			});
      	</script>
    <!-- END SCRIPTS -->      
    </body>
</html>