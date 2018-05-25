<div class="panel panel-primary">
    <a href="#panel-related_party">   
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Related Party   </h4>
        </div>  
    </a>      

    <div class="panel-body" id="panel-related_party">
        <div id="related_party">
        <?php 
            if(isset($related_party)) {
                for($j=0;$j<count($related_party); $j++) {
        ?>
            <div class="form-group" id="related_party_<?php echo $j+1;?>" <?php if($j==0) echo 'style="border-top:1px dotted #ddd;"';?>>
                <div class="col-md-4">
                    <label class="col-md-3 control-label">Type</label>
                    <div class="col-md-9">
                        <select name="related_party_type[]" class="form-control rp_type" id="rp_type_<?php echo $j+1;?>">
                            <option value="">Select</option>
                            <?php for ($k=0; $k < count($contact_type) ; $k++) { ?>
                                    <option value="<?php echo $contact_type[$k]->id; ?>" <?php if($contact_type[$k]->id==$related_party[$j]->c_contact_type) { echo 'selected'; } ?>><?php echo $contact_type[$k]->contact_type; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-9">
                        <input type="hidden" id="rp_<?php echo $j+1;?>_id" name="related_party[]" class="form-control" value="<?php if(isset($related_party[$j]->contact_id)){ echo $related_party[$j]->contact_id; } else { echo ''; }?>" />
                        <input type="text" id="rp_<?php echo $j+1;?>" name="related_party_name[]" data-error="#rp_error_<?php echo $j+1;?>" class="form-control auto_client_by_type" value="<?php if(isset($related_party[$j]->contact_name)) { echo $related_party[$j]->contact_name; } else { echo ''; }?>" placeholder="Type to choose contact from database..." />
                        <div id="rp_error_<?php echo $j+1;?>"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="col-md-3 control-label" style="padding-left: 0px;">Remarks</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="related_party_remarks[]" placeholder="Remarks" value="<?php if(isset($related_party[$j]->remarks)) { echo $related_party[$j]->remarks; } ?>" />
                    </div>
                </div>
            </div>
        <?php } } else { ?>
            <div class="form-group" id="related_party_1" style="border-top: 1px dotted #ddd;">
                <div class="col-md-4">
                    <label class="col-md-3 control-label">Type</label>
                    <div class="col-md-9">
                        <select name="related_party_type[]" class="form-control rp_type" id="rp_type_1">
                            <option value="">Select</option>
                            <?php for ($k=0; $k < count($contact_type) ; $k++) { ?>
                                <option value="<?php echo $contact_type[$k]->id; ?>"><?php echo $contact_type[$k]->contact_type; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-9">
                        <input type="hidden" id="rp_1_id" name="related_party[]" class="form-control" value="" />
                        <input type="text" id="rp_1" name="related_party_name[]" data-error="#rp_error_1" class="form-control auto_client_by_type" value="" placeholder="Type to choose contact from database..." />
                        <div id="rp_error_1"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="col-md-3 control-label" style="padding-left: 0px;">Remarks</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="related_party_remarks[]" placeholder="Remarks" value="" />
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
 
        <div class="col-md-12  btn-container">
            <button type="button" class="btn btn-success repeat-related_party">+</button>
            <button type="button" class="btn btn-success reverse-related_party" style="margin-left: 10px;">-</button>
            <!--<a href="#panel-documents" >
                <button type="button" class="btn btn-info pull-right">  Next  <span class="fa fa-angle-double-right"></span> </button>
            </a>-->
        </div>
    </div>
</div>