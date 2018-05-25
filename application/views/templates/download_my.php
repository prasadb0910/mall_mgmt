<div class="btn-group pull-right" style="margin-bottom:8px;">
    <?php if(isset($access)) { if($access[0]->r_export == 1) { ?>
        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> &nbsp;Download</button>
        <ul class="dropdown-menu">
            <li><a href="#" onClick ="$('#customers2').tableExport({type:'csv',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/csv.png' width="24"/> CSV</a></li>
            <li><a href="#" onClick ="$('#customers2').tableExport({type:'excel',escape:'false'});"><img src='<?php echo base_url(); ?>img/icons/xls.png' width="24"/> XLS</a></li>
        </ul>
    <?php } } ?>
</div>