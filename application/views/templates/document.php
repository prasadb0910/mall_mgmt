<div id="document_details" class="Documents-section">

<?php 
    if(isset($documents)) {
        $doc_no=0;
        for($i=0; $i<count($documents); $i++) { 
        if(isset($documents[$i]->d_type_id) && $documents[$i]->d_type_id!='') {
            if (count($docs[$documents[$i]->d_type_id])>0 && ($documents[$i]->doc_doc_name==null || $documents[$i]->doc_doc_name=='')) {
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="block1">
            <div class="row clearfix" >
                <div class="col-md-10">
                    <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_type_id; ?>" />
                    <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->d_m_status; ?>" />
                    <h4><?php echo $documents[$i]->d_type; ?></h4>
                </div>
                <div class="col-md-2">
                    <div class="remove delete_row" id="repeat_doc_<?php echo $doc_no; ?>_delete" style="<?php if($documents[$i]->d_m_status=='Yes') echo 'display: none;'; ?>">Remove <i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="form-group form-group-default form-group-default-select2">
                        <label class="">Select Document</label>
                        <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_doc_name[]" value="<?php echo $documents[$i]->doc_doc_name; ?>" />
                        <select id="doc_name_<?php echo $doc_no; ?>" name="doc_name[]" class="form-control doc_name full-width" data-placeholder="Select Document" data-init-plugin="select2" data-error="#doc_name_<?php echo $doc_no; ?>_error" onChange="getExpiryDateStatus(this);">
                            <option value="">Select</option>
                            <?php for ($j=0; $j < count($docs[$documents[$i]->d_type_id]) ; $j++) { ?>
                                <option value="<?php echo $docs[$documents[$i]->d_type_id][$j]->d_id; ?>" <?php if($docs[$documents[$i]->d_type_id][$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php echo $docs[$documents[$i]->d_type_id][$j]->d_documentname; ?></option>
                            <?php } ?>
                        </select>
                        <span id="doc_name_<?php echo $doc_no; ?>_error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Description</label>
                        <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Refernce No</label>
                        <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $documents[$i]->doc_ref_no; ?>" />
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Date Of Issue</label>
                        <input type="text" class="form-control date1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>" />
                    </div>
                </div>
                <div class="col-md-4" id="date_expiry_<?php echo $doc_no; ?>" style="<?php if($documents[$i]->d_show_expiry_date=='No') echo 'display:none;'?>padding-right:7px!important;">
                    <div class="form-group form-group-default">
                        <label>Date Of Expiry</label>
                        <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>" />
                    </div>
                </div>
            </div>
            <p class="attachments">Attachments</p>
            <div class="row clearfix">
                <div class="col-md-8">
                    <div class="fileUpload blue-btn btn width100">
                        <span><i class="fa fa-cloud-upload"></i></span>
                        <input type="hidden" class="form-control" name="doc_document[]" id="doc_document_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_document; ?>" />
                        <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                        <input type="file" class="uploadlogo fileinput btn btn-success padding-height doc_file" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                        
                        <div id="doc_<?php echo $doc_no; ?>_error"></div>
                    </div>
                    <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a><?php } ?>
                </div>
                <div class="col-md-1 download-btn">
                    <?php $doc_no=$doc_no+1; ?>
                </div>
            </div>
        </div>
    </div>

<?php 
    } else if ((isset($documents[$i]->doc_doc_id) && $documents[$i]->doc_doc_id!='') || (isset($documents[$i]->doc_doc_name) && $documents[$i]->doc_doc_name!='')) { 
?>

    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="block1" style="padding-top:20px!important;">
            <div class="row clearfix">
                <div class="col-md-10">
                    <?php if($documents[$i]->d_type_id!='') {
                        if(isset($doc_types)) {
                            echo '<div class="form-group form-group-default form-group-default-select2">
                                    <label class="">Select Document Type</label>
                                    <select name="doc_type[]" id="doc_type_'.$doc_no.'" class="form-control doc_name full-width" data-placeholder="Select Document Type" data-init-plugin="select2">';

                            for($j=0; $j<count($doc_types); $j++) {
                                if($doc_types[$j]->d_type_id==$documents[$i]->d_type_id) {
                                    echo '<option value="'.$doc_types[$j]->d_type_id.'" selected>'.$doc_types[$j]->d_type.'</option>';
                                } else {
                                    echo '<option value="'.$doc_types[$j]->d_type_id.'">'.$doc_types[$j]->d_type.'</option>';
                                }
                            }

                            echo '</select></div>';
                        }
                    } else { ?>
                        <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                        <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                        <h4 class="doc_file">Other</h4>
                    <?php } ?>
                </div>
                <div class="col-md-2">
                    <div class="remove delete_row" id="repeat_doc_<?php echo $doc_no; ?>_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            </div>
            <div class="row clearfix ">
                <div class="col-md-4">
                    <div class="form-group form-group-default form-group-default-select2 " >
                        <label class="">Select Document</label>
                        <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_doc_name[]" value="<?php echo $documents[$i]->doc_doc_name; ?>" />
                        <select id="doc_name_<?php echo $doc_no; ?>" name="doc_name[]" class="form-control doc_name full-width" data-placeholder="Select Document" data-init-plugin="select2" onChange="getExpiryDateStatus(this);">
                            <option value="">Select</option>

                            <?php if(isset($doc_details)) {
                                for($j=0; $j<count($doc_details); $j++) { ?>
                                    <option value="<?php echo $doc_details[$j]->d_id; ?>" <?php if($doc_details[$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php echo $doc_details[$j]->d_documentname; ?></option>
                            <?php } } ?>

                            <?php //for ($j=0; $j < count($docs[$documents[$i]->d_type_id]) ; $j++) { ?>
                                <!-- <option value="<?php //echo $docs[$documents[$i]->d_type_id][$j]->d_id; ?>" <?php //if($docs[$documents[$i]->d_type_id][$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php //echo $docs[$documents[$i]->d_type_id][$j]->d_documentname; ?></option> -->
                            <?php //} ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Description</label>
                        <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Refernce No</label>
                        <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Date Of Issue</label>
                        <input type="text" class="form-control date1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>" />
                    </div>
                </div>
                <div class="col-md-4" id="date_expiry_<?php echo $doc_no; ?>" style="<?php if($documents[$i]->d_show_expiry_date=='No') echo 'display:none;'?>padding-right:7px!important;">
                    <div class="form-group form-group-default">
                        <label>Date Of Expiry</label>
                        <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>" />
                    </div>
                </div>   
			
            </div>
            <p class="attachments">Attachments</p>
            <div class="row clearfix">
                <div class="col-md-8">
                    <div class="fileUpload blue-btn btn width100">
                        <span><i class="fa fa-cloud-upload"></i></span>
                        <input type="hidden" class="form-control" name="doc_document[]" id="doc_document_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_document; ?>" />
                        <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                        <input type="file" class="uploadlogo fileinput btn btn-success padding-height doc_file" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>
                        <div id="doc_<?php echo $doc_no; ?>_error"></div>
                    </div>
                    <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a><?php } ?>
                </div>
                <div class="col-md-1 download-btn">
                    <?php $doc_no=$doc_no+1; ?>
                </div>
            </div>
        </div>
    </div>

<?php 
    }} else { 
?>
    
    <div id="repeat_doc_<?php echo $doc_no; ?>" class="form-group" style="background:none; border:none;">
        <div class="block1">
            <div class="row clearfix">
                <div class="col-md-10">
                    <input type="hidden" class="form-control" name="doc_type[]" id="doc_type_<?php echo $doc_no; ?>" />
                    <input type="hidden" class="form-control" id="d_m_status_<?php echo $doc_no; ?>" value="No" />
                    <h4 class="doc_file">Other </h4>
                </div>
                <div class="col-md-2">
                    <div class="remove delete_row" id="repeat_doc_<?php echo $doc_no; ?>_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="form-group form-group-default form-group-default-select2">
                        <label class="">Select Documents</label>
                        <input type="hidden" id="doc_name_<?php echo $doc_no; ?>_id" name="doc_doc_name[]" value="<?php echo $documents[$i]->doc_doc_name; ?>" />
                        <select id="doc_name_<?php echo $doc_no; ?>" name="doc_name[]" class="form-control doc_name full-width" data-placeholder="Select Document" data-init-plugin="select2" onChange="getExpiryDateStatus(this);">
                            <option value="">Select</option>
                            <?php for ($j=0; $j < count($docs[$documents[$i]->d_type_id]) ; $j++) { ?>
                                <option value="<?php echo $docs[$documents[$i]->d_type_id][$j]->d_id; ?>" <?php if($docs[$documents[$i]->d_type_id][$j]->d_id==$documents[$i]->doc_doc_id) { echo 'selected'; } ?>><?php echo $docs[$documents[$i]->d_type_id][$j]->d_documentname; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Description</label>
                        <input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="<?php echo $documents[$i]->doc_description; ?>" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Refernce No</label>
                        <input type="text" class="form-control" name="ref_no[]" id="ref_no_<?php echo $doc_no; ?>" placeholder="Reference No" value="<?php echo $documents[$i]->doc_ref_no; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-4">
                    <div class="form-group form-group-default">
                        <label>Date Of Issue</label>
                        <input type="text" class="form-control date1" name="date_issue[]" placeholder="Date of Issue" value="<?php if (isset($documents)) { if($documents[$i]->doc_doi!='' && $documents[$i]->doc_doi!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doi)); } ?>" />
                    </div>
                </div>
                <div class="col-md-4" id="date_expiry_<?php echo $doc_no; ?>" style="padding-right:7px!important;">
                    <div class="form-group form-group-default">
                        <label>Date Of Expiry</label>
                        <input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"  value="<?php if (isset($documents)) { if($documents[$i]->doc_doe!='' && $documents[$i]->doc_doe!=null) echo date('d/m/Y',strtotime($documents[$i]->doc_doe)); } ?>"/>
                    </div>
                </div>
				  
            </div>
            <p class="attachments">Attachments</p>
            <div class="row clearfix">
                <div class="col-md-8">
                    <div class="fileUpload blue-btn btn width100">
                        <span><i class="fa fa-cloud-upload"></i></span>
                        <input type="hidden" class="form-control" name="doc_document[]" id="doc_document_<?php echo $doc_no; ?>" value="<?php echo $documents[$i]->doc_document; ?>" />
                        <input type="hidden" class="form-control" name="document_name[]" value="<?php echo $documents[$i]->document_name; ?>" />
                        <input type="file" class="uploadlogo fileinput btn btn-success padding-height doc_file" name="doc_<?php echo $doc_no; ?>" id="doc_file_<?php echo $doc_no; ?>" data-error="#doc_<?php echo $doc_no; ?>_error"/>                        
                        <div id="doc_<?php echo $doc_no; ?>_error"></div>
                    </div>
                    <?php if($documents[$i]->doc_document!= '') { ?><a target="_blank" title="Download" id="doc_file_download_<?php echo $doc_no; ?>" href="<?php echo base_url().$documents[$i]->doc_document; ?>"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a><?php } ?>
                </div>
                <div class="col-md-1 download-btn">
                    <?php $doc_no=$doc_no+1; ?>
                </div>
            </div>
        </div>
    </div>

<?php }}} ?>

</div>

<?php
    $document_type_options = '<option value="">Select</option>';

    if(isset($doc_types)) {
        for($i=0; $i<count($doc_types); $i++) {
            $document_type_options = $document_type_options . '<option value="'.$doc_types[$i]->d_type_id.'">'.$doc_types[$i]->d_type.'</option>';
        }
    }
?>

<script>
    var document_type_options = '<?php echo $document_type_options; ?>';
</script>

<?php
    $document_details = '<option value="">Select</option>';

    if(isset($doc_details)) {
        for($i=0; $i<count($doc_details); $i++) {
            $document_details = $document_details . '<option value="'.$doc_details[$i]->d_id.'">'.$doc_details[$i]->d_documentname.'</option>';
        }
    }
?>

<script>
    var document_details = '<?php echo $document_details; ?>';
</script>