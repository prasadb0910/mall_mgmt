<style type="text/css">
    .delete-btn a{ font-size:25px;  color: #333;  }
    .delete-btn a:hover { color: #e90404; }

    .delete_row  {font-size:25px; color: #333;   }
    .delete_row:hover { color: #e90404;  }

    .download-btn a{     font-size:25px;  color: #333;  }
    .download-btn a:hover { color: #1caf9a; }
    .btn-margin {     padding: 10px 15px!important;  border-top: 1px dotted #ddd; }
    .table {  width: 100%;   max-width: 100%;  margin-bottom:0px;}
    .padding-height {padding:6px 10px; overflow:hidden;}
    .btn-margin { margin: 10px 0; }
</style>

<div id="document_details" class="Documents-section">

<?php 
    if(isset($documents)) {
        $doc_no=0;
        for($i=0; $i<count($documents); $i++) { 
        if(isset($documents[$i]->d_type_id) && $documents[$i]->d_type_id!='') {
            if (count($docs[$documents[$i]->d_type_id])>0) {
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="col-md-3">
            <div class="col-md-6 document-align">
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_type_id; ?>" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_m_status; ?>" />
                <label class="doc_file"><?php echo $documents[$i]->d_type; ?> </label>
            </div>
            <div class="col-md-6">
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_doc_name[]" />
                <select name="doc_name[]" class="form-control doc_name" id="doc_name_<?php echo $doc_no; ?>" onChange="getExpiryDateStatus(this);">
                    <option value="">Select</option>
                    <?php for ($j=0; $j < count($docs[$documents[$i]->d_type_id]) ; $j++) { ?>
                        <option value="<?php echo $docs[$documents[$i]->d_type_id][$j]->d_id; ?>" <?php if($docs[$documents[$i]->d_type_id][$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php echo $docs[$documents[$i]->d_type_id][$j]->d_documentname; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">                                                     
            <div class="col-md-6" >
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" >
            <div class="col-md-6" >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6">
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>" style="<?php if($documents[$i]->d_show_expiry_date=='No') echo 'display:none;'?>" />
            </div>
        </div>
        <div class="col-md-2">
			<div class="col-md-6" >
                <input type="hidden" class="form-control" name="doc_document[]" value="<?php echo $documents[$i]->doc_document; ?>" />
                <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                
                <a class="file-input-wrapper btn btn-default  fileinput btn btn-success padding-height doc_file"><span>Browse</span>
                    <input type="file" class="fileinput btn btn-success doc_file padding-height" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"  />
                </a>

                <div id="doc_<?php echo $doc_no; ?>_error"></div>
            </div>

			<div class="col-md-3 download-btn">
                <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
            </div>

            <div class="col-md-1 delete-btn">
                <a title="Delete" id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" class="delete_row" href="#" style="<?php if($documents[$i]->d_m_status=='Yes') echo 'display: none;'; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

<?php 
    } else if ((isset($documents[$i]->doc_doc_id) && $documents[$i]->doc_doc_id!='') || (isset($documents[$i]->doc_doc_name) && $documents[$i]->doc_doc_name!='')) { 
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="col-md-3" >
            <div class="col-md-6 document-align" >
                <?php if($documents[$i]->d_type_id!='') {
                    if(isset($doc_types)) {
                        echo '<select class="form-control" name="doc_type[]" id="doc_type_'.$doc_no.'">';

                        for($j=0; $j<count($doc_types); $j++) {
                            if($doc_types[$j]->d_type_id==$documents[$i]->d_type_id) {
                                echo '<option value="'.$doc_types[$j]->d_type_id.'" selected>'.$doc_types[$j]->d_type.'</option>';
                            } else {
                                echo '<option value="'.$doc_types[$j]->d_type_id.'">'.$doc_types[$j]->d_type.'</option>';
                            }
                        }

                        echo '</select>';
                    }
                } else { ?>
                    <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                    <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                    <label class="doc_file">Other</label>
                <?php } ?>
            </div>
            <div class="col-md-6" >
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_name[]" class="form-control doc_name" value="<?php echo $documents[$i]->doc_doc_id; ?>" data-error="#doc_name_<?php echo $doc_no; ?>_error"/>
                <input type="text" id="doc_name_<?php echo $doc_no; ?>" name="doc_doc_name[]" class="form-control auto_document" value="<?php if(($documents[$i]->doc_documentname)=='') { echo $documents[$i]->doc_doc_name; } else { echo $documents[$i]->doc_documentname; } ?>" placeholder="Type to choose document from database..." />
                <div id="doc_name_<?php echo $doc_no; ?>_error"></div>
            </div>
        </div>
        <div class="col-md-4">                                                     
            <div class="col-md-6">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" >
            <div class="col-md-6" >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6">
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
        <div class="col-md-2" >
            <div class="col-md-6" >
                <input type="hidden" class="form-control" name="doc_document[]" value="<?php echo $documents[$i]->doc_document; ?>" />
                <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                <input type="file" class="fileinput btn btn-success doc_file padding-height"  name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>

            </div>
            <div class="col-md-3 download-btn" >
                <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
            </div>
            <div class="col-md-1 delete-btn"  >
                <a class="delete_row" href="#" title="Delete" id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

<?php 
    }} else { 
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="col-md-3" >
            <div class="col-md-6 document-align" >
                <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                <label class="doc_file">Other </label>
            </div>
            <div class="col-md-6" >
                <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_name[]" class="form-control doc_name" value="<?php echo $documents[$i]->doc_doc_id; ?>" data-error="#doc_name_<?php echo $doc_no; ?>_error"/>
                <input type="text" id="doc_name_<?php echo $doc_no; ?>" name="doc_doc_name[]" class="form-control auto_document" value="<?php echo $documents[$i]->doc_documentname; ?>" placeholder="Type to choose document from database..." />
                <div id="doc_name_<?php echo $doc_no; ?>_error"></div>
            </div>
        </div>
        <div class="col-md-4">                                                     
            <div class="col-md-6">
                <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" id="ref_no_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
            </div>
        </div>
        <div class="col-md-3" >
            <div class="col-md-6" >
                <input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>"/>
            </div>
            <div class="col-md-6">
                <input type="text" id="date_expiry_<?php echo $doc_no; ?>" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>"/>
            </div>
        </div>
		<div class="col-md-2" >
            <div class="col-md-6" >
                <input type="hidden" class="form-control" name="doc_document[]" value="<?php echo $documents[$i]->doc_document; ?>" />
                <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                <a class="file-input-wrapper btn btn-default  fileinput btn-primary">
                    <span>Browse</span>
                    <input type="file" class="fileinput btn-primary doc_file" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error" style="width: 100%;height: 28px;">
                </a>
                <div id="doc_<?php echo $doc_no; ?>_error"></div>
            </div>
            <div class="col-md-3 download-btn" >
                <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
            </div>
            <div class="col-md-1 delete-btn"  >
                <a class="delete_row" href="#" title="Delete" id="repeat_doc_<?php echo $doc_no; $doc_no=$doc_no+1; ?>_delete" ></a>
            </div>
        </div>
    </div>

<?php }}} ?>

</div>