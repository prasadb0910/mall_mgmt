<?php 
    if(isset($pending_activity)) {
?>
<div class="panel-heading" style="border-top:1px solid #E5E5E5;   ">
    <h3 class="panel-title"><strong>Pending Activity </strong></h3>
</div>
 <div class="panel-body">
    <?php
        for($j=0;$j<count($pending_activity); $j++) {
    ?>
    <div class="form-group print-border" <?php if($j==0) echo 'style="border-top:0px dotted #ddd;"';?>>
        <div class="col-md-12 col-sm-12">
            <div class="">           
                <div class="col-md-12">
				     <label class="col-md-1 col-sm-1 col-xs-1 control-label " style="text-align:center"><strong><?php echo ($j+1); ?></strong></label>
                    <label class="col-md-11 col-sm-11 col-xs-11 control-label contact-view" style="text-align:left;"> <?php echo $pending_activity[$j]->pending_activity; ?> </label>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>