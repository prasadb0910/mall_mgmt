<style>
 .btn-container{ padding:10px 0;}
  .pending-group {    padding-right: 15px!important;}
</style>
<div class="panel panel-primary" id="panel-pending-activity">
    <a href="#accOneColSeven">   
        <div class="panel-heading">
            <h4 class="panel-title"> <span class="fa fa-check-square-o"> </span>   Pending Activity   </h4>
        </div>  
    </a>      

    <div class="panel-body" id="accOneColSeven">
        <div id="pending_activity">
        <?php 
            if(isset($pending_activity)) {
                for($j=0;$j<count($pending_activity); $j++) {
        ?>
            <div class="form-group" id="pending_activity_<?php echo ($j+1); ?>" <?php if($j==0) echo 'style="border-top:1px dotted #ddd;"';?>>
                <div class="col-md-1 col-sm-1 col-xs-1" >
                    <label class="col-md-12 control-label"><?php echo ($j+1); ?></label>
                </div>
                <div class="col-md-11 col-sm-11 col-xs-11">
                    <input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="<?php echo $pending_activity[$j]->pending_activity; ?>" />
                </div>
            </div>
        <?php } } else { ?>
            <div class="form-group" id="pending_activity_1" style="border-top: 1px dotted #ddd;">
                <div class="col-md-1 col-sm-1 col-xs-1  pending-no" style="">
                    <label class="col-md-12 control-label">1</label>
                </div>
                <div class="col-md-11 col-sm-11 col-xs-11 pending-group"  >
                    <input type="text" class="form-control"  name="pending_activity[]" placeholder="Pending Activity" value="" />
                </div>
            </div>
        <?php } ?>
        </div>
       
        <div class="btn-margin">
            <button type="button" class="btn btn-success repeat-pending_activity">+</button>
            <button type="button" class="btn btn-success reverse-pending_activity" style="margin-left: 10px;">-</button>
        </div>
    </div>
</div>