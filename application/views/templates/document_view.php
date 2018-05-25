<div class="a" id="kyc-section">
	<p class=""><b>Document Details</b></p>
	<?php
	 if(isset($documents)) { for ($i=0; $i < count($documents); $i++) { ?>
	<?php
	//$documents[$i]['doc_ref_id']==$editloan[0]->txn_id
		if(isset($documents[$i]->doc_ref_id))
		{ ?>
			<div class="block1">
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Document Type</label>
					<input type="text" class="form-control" value="<?php if(($documents[$i]->d_type)=='') { echo 'others'; } else { echo $documents[$i]->d_type; } ?>" readonly>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Document Name</label>
					<input type="text" class="form-control" value="<?php echo $documents[$i]->doc_documentname; ?>" readonly>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Description</label>
					<input type="text" class="form-control" value="<?php echo $documents[$i]->doc_description; ?>" readonly>
				</div>
			</div>
		</div>
		<div class="row clearfix">
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Refernce No.</label>
					<input type="text" class="form-control" value="<?php echo $documents[$i]->doc_ref_no; ?>" readonly>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Date Of Issue</label>
					<input type="text" class="form-control" value="<?php if ($documents[$i]->doc_doi!='') { if($documents[$i]->doc_doi != '') echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); }?>" readonly>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group form-group-default ">
					<label>Date Of Expiry</label>
					<input type="text" class="form-control" value="<?php if ($documents[$i]->doc_doe!='') { if($documents[$i]->doc_doe != '') echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>" readonly>
				</div>
			</div>
		</div>
		<?php if($documents[$i]->doc_document!='' && $documents[$i]->doc_document!=null) { ?>
		<div class="row clearfix"> 
			
				<a class="btn btn-default-danger " target="_blank" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><span><i class="fa fa-download"></i>  Download</span></a>
			&nbsp &nbsp 
			<!-- <div class="btn btn-default-warning">
				<span><i class="fa fa-search"></i>  Preview</span>
			</div> -->
		</div>
		<?php } ?>
	</div>
		<?php }
	 ?>
	
	<?php } } ?>
</div>