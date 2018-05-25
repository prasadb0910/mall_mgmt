<?php 
    if(isset($related_party)) {
?>
<div class="panel-heading" style="border-top:1px solid #E5E5E5; ">
    <h3 class="panel-title"  ><strong>Related Party</strong></h3>
</div>
<div class="panel-body">
    <?php
        for($j=0;$j<count($related_party); $j++) {
    ?>
    <div class="form-group print-border" <?php if($j==0) echo 'style="border-top:0px dotted #ddd;"';?>>
        <div class="col-md-3 col-sm-3 print-related">
            <label class="col-md-4 col-sm-4  control-label"><strong>Type:</strong></label>
            <div class="col-md-8 col-sm-8">
                <label class="col-md-12 control-label" style="text-align:left;"> <?php echo $related_party[$j]->contact_type; ?> </label>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 print-related">
            <label class="col-md-3 col-sm-3 control-label"><strong>Name:</strong></label>
            <div class="col-md-9 col-sm-9">
                <label class="col-md-12 control-label" style="text-align:left;"> <?php echo $related_party[$j]->contact_name; ?> </label>
            </div>
        </div>
        <div class="col-md-5 col-sm-5 print-related">
            <label class="col-md-3 col-sm-3 control-label"><strong>Remarks:</strong></label>
            <div class="col-md-9 col-sm-9">
                <label class="col-md-12 control-label" style="text-align:left;"> <?php echo $related_party[$j]->remarks; ?> </label>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>