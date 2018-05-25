<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
        .a {
            border-bottom: 2px solid #edf0f5;
            margin-bottom: 25px;
            padding-bottom: 25px;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("assets/img/demo/preview.jpg") ;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
        #image-label {
            color:white;
            padding-left:6px;
        }
        #image-label_field{
            background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
        }
        #image-label_field:hover{
            background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add{
            color:#41a541;
            cursor:pointer;
            font-size:14px;
            font-weight:500;
        }
        .remove{
            color:#d63b3b;
            text-align:right;
            cursor:pointer;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1{
            padding: 5px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .delete{
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:pointer;
            margin-top: 15px;
            font-size:20px;
            font-weight:500;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            font-weight:400;
        }
        .blue-btn:hover,
        .blue-btn:active,
        .blue-btn:focus,
        .blue-btn {
            background: transparent;
            border: dotted 1px #27a9e0;
            border-radius: 3px;
            color: #27a9e0;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none !important;
            padding: 10px 20px;
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
            height: 43px;
            margin-top: 0;
        }
        .fileUpload input.uploadlogo {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 42px;
        }
        input::-webkit-file-upload-button {
            cursor: pointer !important;
            height: 42px;
            width: 100%;
        }
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
        }
        .addschedule td{
            border:1px solid;
            padding:0px !important;
        }
        .addschedule th{
            border:1px solid;
        }
        .addtax td{
            border:1px solid;
            /*padding:0px !important;*/
        }
        .addtax th{
            border:1px solid;
        }
        .modal-content{
            width: 1000px;
        }
        #schedule_table td{
            background:#ffffff;
        }
        .modal-footer{
            display: block;
        }
        .select2-container {
            z-index:9999!important;
        }
        /*.modal.fade {
            z-index:9999!important;
        }*/
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_sale" role="form" method ="post" action="<?php if(isset($s_txn)) { echo base_url().'index.php/Sale/updaterecord/'.$s_id; } else { echo base_url().'index.php/Sale/saverecord'; } ?>" enctype="multipart/form-data">
    <div class=" container-fluid   container-fixed-lg ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Sale/checkstatus/All">Sale List</a></li>
            <li class="breadcrumb-item"><a href="<?php if (isset($s_id)) echo base_url().'index.php/Sale/view/'.$s_id; ?>">Sale View</a></li>
            <li class="breadcrumb-item active">Sale Details</li>
            <input type="hidden" id="s_id" name="s_id" value="<?php if(isset($s_txn)) echo $s_id; ?>" />
        </ol>
        <div class="row">
            <div class="col-md-4">
                <div class="col-lg-12">
                    <div class="card card-default" style="background:#e6ebf1">
                        <div class="card-header " style="background:#f6f9fc">
                            <div class="card-title">
                                Drag n' drop uploader
                            </div><span ><a href="#"><i class=" fa fa-trash pull-right" id="img_delete" style="color:#d63b3b;font-size:18px;"></i></a></span>
                        </div>
                        <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($s_txn)) echo base_url().$s_txn[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                            <input type="file" name="image" id="image-upload" />
                        </div>
                        <div id="image-label_field">
                            <label for="image-upload" id="image-label"><i class="fa fa-cloud-upload"></i><span>Upload Photo</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class=" container-fluid container-fixed-lg bg-white">
                    <div class="card card-transparent">
                        <div class="a">
                            <p class="m-t-20"><b>Property Details<b></p>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Property </label>
                                        <select  class="form-control full-width" id="property" name="property" onchange="loadclientdetail(); getdocuments();" data-placeholder="Select Property" data-init-plugin="select2">
                                            <option value="">Select Property</option>
                                            <?php if(isset($s_txn)) { 
                                                for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->txn_id; ?>" <?php if($s_txn[0]->property_id == $property[$i]->txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->p_property_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($property); $i++) { ?>
                                                    <option value="<?php echo $property[$i]->txn_id; ?>"><?php echo $property[$i]->p_property_name; ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Sub Property </label>
                                        <select class="form-control full-width" id="sub_property" name="sub_property" data-placeholder="Select Sub Property" data-init-plugin="select2">
                                            <option value="">Select</option>
                                            <?php if(isset($s_txn)) { 
                                                for($i=0; $i<count($sub_property); $i++) { ?>
                                                    <option value="<?php echo $sub_property[$i]->sp_id; ?>" <?php if($s_txn[0]->sub_property_id == $sub_property[$i]->sp_id) { echo 'selected';} ?> ><?php echo $sub_property[$i]->sp_name; ?></option>
                                            <?php } } else { ?>
                                                    <?php for($i=0; $i<count($sub_property); $i++) { ?>
                                                    <option value="<?php echo $sub_property[$i]->sp_id; ?>"><?php echo $sub_property[$i]->sp_name; ?></option>
                                            <?php } } ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Date of Sale</label>
                                        <input type="text" class="form-control datepicker" id="sale_date" name="sale_date" placeholder="Date of Sale" value="<?php if(isset($s_txn)) { if(count($s_txn)>0) {echo date('d/m/Y',strtotime($s_txn[0]->date_of_sale));}} ?>" />

                                        <input type="hidden" onkeyup="calculateprofit();" class="form-control format_number" name="cost_purchase" id="costpurchase" placeholder="Amount" value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_purchase,2); } else { echo '0'; } } else { echo '0'; } ?>" />
                                        <input type="hidden" name="sales_consideration" id="sales_consideration" value="0" />
                                        <input type="hidden" class="form-control format_number" name="cost_of_acquisition" id="cost_of_acquisition" placeholder="Cost of Acquisition"  value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->cost_of_acquisition,2); } else { echo '0'; } } else { echo '0'; } ?>" />
                                        <input type="hidden" class="form-control format_number" name="profit_loss" id="profit_loss" placeholder="Amount"  value="<?php if(isset($s_txn)) { if(count($s_txn)>0) { echo format_money($s_txn[0]->profit_loss,2); } else { echo '0'; } } else { echo '0'; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                        </div>

                        <div class="a" id="buyer-section">
                            <p class="m-t-20"><b>Buyer<b></p>
                            <div id="repeatbuyer">

                                <?php $j=0; if(isset($s_buyer)) { 
                                    for ($j=0; $j < count($s_buyer) ; $j++) { ?>

                                <div id="repeat_buyer_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Select Buyer</label>
                                            <select id="buyer_name_<?php echo $j+1; ?>" name="buyername[]" class="form-control buyer full-width" data-error="#err_buyer_name_<?php echo $j+1; ?>" data-placeholder="Select Buyer" data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$s_buyer[$j]->buyer_id) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_buyer_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>% of buyer</label>
                                            <input type="text" id="sharepercent_<?php echo $j+1; ?>" name="sharepercent[]" class="form-control" placeholder="% of buyer" value="<?php if(isset($s_buyer[$j]->share_percent)){ echo format_money($s_buyer[$j]->share_percent,2); } else { echo ''; }?>"/>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_buyer_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } } else { ?>
                                
                                <div id="repeat_buyer_<?php echo $j+1; ?>" class="row clearfix">
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Select Buyer</label>
                                            <select id="buyer_name_<?php echo $j+1; ?>" name="buyername[]" class="form-control buyer full-width" data-error="#err_buyer_name_<?php echo $j+1; ?>" data-placeholder="Select Buyer" data-init-plugin="select2">
                                                <option value="">Select</option>
                                                <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                    <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id="err_buyer_name_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default">
                                            <label>% of buyer</label>
                                            <input type="text" id="sharepercent_<?php echo $j+1; ?>" name="sharepercent[]" class="form-control" placeholder="% of buyer" value=""/>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_buyer_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } ?>

                            </div>
                            <div class="optionBox" id="optionBox">
                                <div class="block" id="block">
                                    <span class="add" id="repeat-buyer">+ Add buyer</span>
                                </div>
                            </div>
                        </div>

                        <div class="a">
                            <p class="m-t-20"><b> Sale Consideration<b></p>
                            <div id="temp_schedule_div"></div>
                            <div class="show row clearfix" id="actual_schedule_div">
                                <div class="col-md-12">
                                    <table class="view_table addsummary">
                                        <thead>
                                            <tr>
                                                <th width="55">Sr. No.</th>
                                                <th width="120">Type</th>
                                                <th width="120">Total Cost (In &#x20B9;)</th>

                                                <?php //print_r($tax_name);
                                                    if(isset($tax_name)){
                                                       // echo '<th colspan="'.count($tax_name).'"><table><tr><td clolspan="'.count($tax_name).'"><center>Taxes</center></td></tr><tr>';
                                                        $key=0;
                                                        foreach($tax_name as $row){
                                                            echo '<th style="text-align: center;vertical-align: middle;">'.$row->tax_type.' (In &#x20B9;)</th>';
                                                            $tax_array[$key]=$row->tax_type;
                                                            $key++;
                                                        } 
                                                       //echo '</tr></table></th>';
                                                      // print_r($tax_array);
                                                    }
                                                ?>

                                                <th width="120">Net Cost (In &#x20B9;)</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php //print_r($p_schedule);?>
                                            <?php 
                                            $j=0;
                                            $total_basic_cost=0;
                                            $total_net_amount=0;
                                            $total_tax_array=array();
                                            if(isset($p_schedule1)){
                                            foreach($p_schedule1 as $row_tax) {
                                                echo '<tr>
                                                <td style="text-align:left;">'.($j+1).'</td>
                                                <td style="text-align:left;">'.$p_schedule1[$j]["event_type"].'</td>
                                                

                                                
                                                <td style="text-align:right;">'.format_money($p_schedule1[$j]["basic_cost"],2).'</td>';
                                                //echo count($p_schedule[$j]['tax_type']);
                                               /* if(isset($p_schedule[$j]['tax_type'])){
                                                for($tcnt=0;$tcnt<$key;$tcnt++){
                                                   // print_r($p_schedule[$j]['tax_type']);
                                                    $tax_amount='';
                                                    if(count($p_schedule[$j]['tax_type'])>=($tcnt+1)){

                                                    if($p_schedule[$j]['tax_type'][$tcnt]==$tax_array[$tcnt]){
                                                        $tax_amount=$p_schedule[$j]['tax_amount'][$tcnt];
                                                    }
                                                }
                                                    echo '<td>'.$tax_amount.'</td>';
                                                }
                                                }*/
                                                //echo $key;
                                                $total_basic_cost=$total_basic_cost+$p_schedule1[$j]["basic_cost"];
                                                $next_count=0;
                                                $td_count=0;
                                                if(isset($p_schedule1[$j]['tax_type'])) {
                                                    // for($cnt_type=0;$cnt_type<count($p_schedule[$j]['tax_type']);$cnt_type++){
                                                    //echo "<br>hi";
                                                    // echo $key;
                                                    for($tcnt=0;$tcnt<$key;$tcnt++){
                                                        //echo "step1--";
                                                        for($nc=0;$nc<count($p_schedule1[$j]['tax_type']);$nc++){
                                                            $tax_amount='';
                                                            if($p_schedule1[$j]['tax_type'][$nc]==$tax_array[$tcnt]){
                                                                $tax_amount=$p_schedule1[$j]['tax_amount'][$nc];
                                                                $nc=count($p_schedule1[$j]['tax_type']);
                                                                //$tcnt=$key;
                                                                //}
                                                            }
                                                        }
                                                        if($tax_amount !=''){
                                                            echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
                                                            $td_count++;
                                                        } else {
                                                            //if($next_count )
                                                            echo '<td style="text-align:right;">'.format_money($tax_amount,2).'</td>';
                                                            $td_count++;
                                                        }
                                                        // $tax_amount_toatl= $tax_amount_toatl+ $tax_amount;
                                                        //  $total_tax_array[$tcnt]= $tax_amount;
                                                        // print_r($total_tax_array);
                                                    }
                                                // }
                                                }
                                                $inserttd=$key-$td_count;
                                                if($inserttd !=0){
                                                    for($tdint=0;$tdint<$inserttd;$tdint++){
                                                        echo "<td></td>";
                                                    }
                                                }
                                                echo'<td style="text-align:right;">'.format_money($p_schedule1[$j]["net_amount"],2).'</td></tr>';
                                                $total_net_amount=$total_net_amount+$p_schedule1[$j]["net_amount"];
                                                //print_r($p_schedule[$j]['event_type']);
                                                $j++;


                                            } ?>

                                            <tr>
                                                <td colspan="2" style="text-align:left;"><b>Grand Total  (In &#x20B9;) </b></td>
                                                <td style="text-align:right;"><?php echo format_money($total_basic_cost,2);?></td>
                                                <?php  $k=0;if(isset($total_tax_amount)) {
                                                foreach($total_tax_amount as $row){
                                                    echo '<td style="text-align:right;">'.format_money($total_tax_amount[$k],2).'</td>';
                                                    $k++;
                                                } } ?>
                                               <td style="text-align:right;"><?php echo format_money($total_net_amount,2); ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>

                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="opentable(); return false;">Schedule</button>

                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Schedule</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row clearfix" >
                                            <label class="control-label" style="color:#000;">Bulk Upload: </label>&nbsp;&nbsp;
                                            <div class="fileUpload blue-btn btn width100">
                                                <span><i class="fa fa-cloud-upload"></i> Upload Schedule</span>
                                                <input type="file" class="uploadlogo" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()" />
                                            </div>
                                            <label class="control-label" style="color:#000;"><a href="<?php echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a></label>
                                            <!-- <input type="file" class="fileinput btn-primary" name="schedule_upload" id="schedule_upload" onchange="saveTempBulkUpload()"/>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="<?php //echo base_url();?>schedule_format.xlsx" target="_blank">Download Format</a> -->
                                            <!-- <label class="control-label" style="color:#000;"><a href="#">Download Format</a></label> -->
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-12" id="import_schedule">
                                                <table class="view_table addschedule">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center;vertical-align: middle;" width="60">Sr. No.</th>
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Type</th>
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Event</th>
                                                            <!-- <th style="text-align: center;vertical-align: middle;">Payment Type</th>
                                                            <th style="text-align: center;vertical-align: middle;">Agreement Value</th> -->
                                                            <th style="text-align: center;vertical-align: middle;" width="120">Date</th>

                                                            <th style="text-align: center;vertical-align: middle;" width="130">Cost (In &#x20B9;)</th>
                                                            <?php for ($i=0; $i < count($tax) ; $i++) { 
                                                                //echo '<th style="text-align: center;vertical-align: middle;">'.$tax[$i]->tax_name.'</th>';
                                                            }
                                                            ?>
                                                            <th style="text-align: center;vertical-align: middle;" width="70">Tax(%)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="schedule_table">
                                                        <?php $i=0; $schedule_id=1;
                                                        if(isset($p_schedule)){
                                    
                                                        foreach($p_schedule as $row){
                                                            $sch_id=$p_schedule[$i]['schedule_id'];
                                                            $event_type=$p_schedule[$i]['event_type'];
                                                            $event_name=$p_schedule[$i]['event_name'];
                                                            $basic_cost=$p_schedule[$i]['basic_cost'];
                                                            $event_date=date('d/m/Y',strtotime($p_schedule[$i]['event_date']));
                                                            $tax_master=array();
                                                            $j=0;
                                                            if(isset($p_schedule[$i]['tax_type'])){
                                                            for($j=0;$j<count($p_schedule[$i]['tax_type']);$j++ ){
                                                                $p_schedule[$i]['tax_id'][$j];
                                                                $tax_master[]=$p_schedule[$i]['tax_master_id'][$j];
                                                            }
                                                        }   ?>

                                                        <tr id="repeat_schedule_<?php echo $i+1; ?>">
                                                        <td style="text-align:center; vertical-align:middle;" align="middle"><?php echo $i+1; ?></td>
                                                        <input type="hidden" name="sch_id[]" class="form-control" value="<?php echo $sch_id;?>" style="border:none;"/>
                                                        
                                                        <td><input type="text" name="sch_type[]" id="sch_type_<?php echo $i+1; ?>" class="form-control sch_type" value="<?php echo $event_type;?>" style="border:none; text-align:left;"/></td>
                                                        
                                                        <td><input type="text" name="sch_event[]" class="form-control" value="<?php echo $event_name;?>" style="border:none; text-align:left;"/></td>
                                                        <!-- <td><input type="text" name="sch_pay_type[]" class="form-control" value="<?php //echo $p_schedule[$i]['sch_pay_type'];?>" style="border:none; text-align:left;"/></td>
                                                        <td><input type="radio" name="sch_agree_value[0]" id="sch_agree_yes_1" value="yes" <?php //if(($p_schedule[$i]['sch_agree_value'])=='yes'){echo 'checked';} ?> >Yes &nbsp;&nbsp;<input type="radio" name="sch_agree_value[0]" id="sch_agree_no_1" value="no" <?php //if(($p_schedule[$i]['sch_agree_value'])=='no'){ echo 'checked';}?> >No</td> -->
                                                        <td><input type="text" name="sch_date[]" class="form-control date" value="<?php echo $event_date;?>" style="border:none; text-align:left; background:#ffffff; color:rgb(44, 44, 44)!important;"/></td>
                                                        <td><input type="text" name="sch_basiccost[]" class="form-control format_number" value="<?php echo format_money($basic_cost,2);?>" style="border:none; text-align:right;"/></td>
                                                        <td class="form-group-default-select2">
                                                            <select name="sch_tax_<?php echo $schedule_id;?>[]" multiple class="form-control full-width" data-placeholder="Select Tax" data-init-plugin="select2">
                                                            <?php $schedule_id++;
                                                            if(isset($tax_details)){
                                                                //print_r($tax_id);
                                                                foreach($tax_details as $row){
                                                                    if(in_array($row->tax_id, $tax_master)){
                                                                        //echo "hi";
                                                                        $selected="selected='selected'";
                                                                    }
                                                                    else{
                                                                        $selected='';
                                                                    }
                                                                    echo '<option value="'.$row->tax_id.'" '.$selected.'>'.$row->tax_name.'-'.$row->tax_percent.'</option>';
                                                                }
                                                            };?>
                                                            </select>
                                                        </td>
                                                        </tr>
                                                        <?php $i++; 
                                                        }   
                                                        } ?>
                                                        <?php //if (isset($p_schedule)) {
                                                        //  for ($i=0; $i < count($p_schedule) ; $i++) { 
                                                        //      echo "<tr> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>".($i+1)."</td> <td><input   type='text' id='eve' name='sch_event[]' class='form-control' value='".$p_schedule[$i]->event_name."' style='border:none;'/></td> <td><input   type='text' id='txtevent' name='sch_date[]' value='".date('d/m/Y',strtotime($p_schedule[$i]->event_date))."'  class='form-control date' style='border:none;'/></td> <td><input   type='text' id='bs_" . ($i +1). " name='sch_basiccost[]' value='".$p_schedule[$i]->basic_cost."' class='form-control format_number' style='border:none;'/></td>";
                                                        //      for ($j=0; $j < count($tax) ; $j++) { 
                                                        //          echo " <td>None<input   type='text' id='tx_".$j."_".$i."' name='sch_tax".$i."[]'  value='".$p_schtxn[$j]->tax_amount."' class='form-control' style='border:none;'/></td>";
                                                        //      }
                                                        //      echo "<td><input  type='text' id='net_" .($i+1)."' name='sch_netamount[]'  value='".$p_schedule[$i]->net_amount."' class='form-control' style='border:none;'/></td> </tr>";
                                                        //  }
                                                        // }
                                                        ?>
                                                    </tbody>
                                                    <!-- <tbody id="schedule_box" >
                                                        <tr class="block" id="schedule_block">
                                                            <td class="add" id="add_schedule">+ Add</td>
                                                        </tr>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                                        <button type="button" class="btn btn-default-danger" data-dismiss="modal">Close</button> -->

                                        <button class="btn btn-success repeat-schedule" id="schedule_btn" style=" ">+</button>
                                        <button type="button" class="btn btn-success reverse-schedule" style="margin-left: 10px;">-</button>
                                        <button class="btn btn-default-danger pull-right mb-control-close" data-dismiss="modal" onclick="closetemp(); return false;">Close</button>
                                        <button type="button" class="btn btn-default pull-right" style="margin-right: 10px;" onclick="savetemp();" id="savebtn" >Save</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id-1;?>">
                        </div>
                    </div>

                    <div class="a">
                        <p class="m-t-20"><b>Documents<b></p>
                        <?php $this->load->view('templates/document');?>
                        <div class="optionBox" id="optionBox1">
                            <div class="block" id="block2">
                                <span class="add" id="repeat-documents">+ Add Documents</span>
                            </div>
                        </div>
                    </div>

                    <p class="div_heading">Remark</p>
                    <br>
                    <div class="a">
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group form-group-default required">
                                    <label>Remark</label>
                                    <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($s_txn)){ echo $s_txn[0]->maker_remark;}?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer" style="padding-bottom: 60px;">
                        <input type="hidden" id="submitVal" value="1" />
                        <a href="<?php echo base_url(); ?>index.php/Sale" class="btn btn-default-danger pull-left" >Cancel</a>
                        <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                        <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($s_txn)) echo 'display:none'; ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php $this->load->view('templates/footer');?>
</div>
</div>

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.$contact[$i]->contact_name.'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';

    var flag=<?php if(isset($p_schedule)) { echo "true"; } else { echo "false"; } ?>;
    var tax = new Array();
    var taxname=new Array();
    var taxpurpose=new Array();
    window.cntrinst=0;

    <?php for ($i=0; $i < count($tax) ; $i++) { ?>
        tax.push('<?php echo $tax[$i]->tax_percent; ?>');
        taxname.push('<?php echo $tax[$i]->tax_name; ?>');
        taxpurpose.push('<?php echo $tax[$i]->purpose; ?>');
    <?php } ?>

    <?php 
        $tax_list_details = '<option value="">Select</option>';
        if(isset($tax_details)){
            foreach($tax_details as $row){
                $tax_list_details = $tax_list_details . '<option value="'.$row->tax_id.'">'.$row->tax_name.'-'.$row->tax_percent.'</option>';
            }
        }
    ?>
    var tax_list_details = '<?php echo $tax_list_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/load_autocomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/document.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sale.js"></script>

</body>
</html>