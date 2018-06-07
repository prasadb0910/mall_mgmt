<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header.php');?>

    <link href="<?php echo base_url();?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

     <link href="<?php echo base_url();?>assets/css/prop_list.css" rel="stylesheet" />

    <style>
        <?php// if($maker_checker!='yes') { ?>
            // .approved {
                // display: none !important;
            // }
            // .pending {
                // display: none !important;
            // }
            // .rejected {
                // display: none !important;
            // }
        <?php //} ?>
    </style>
</head>
<body class="fixed-header">
<?php $this->load->view('templates/sidebar.php');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header.php');?>
<div class="page-content-wrapper">
    <div class="content ">
        <div class=" container-fluid container-fixed-lg">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=base_url().'index.php/Dashboard/'?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Rent 3rd party List</li>
            </ol>

            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class="<?php if($checkstatus=='All') echo 'active'; ?>" href="<?=base_url('index.php/Rent_3rd_party/checkstatus/ALL')?>">ALL(<?php echo $all; ?>)</a>
                    </li>
                    <li class="nav-item approved">
                        <a class="<?php if($checkstatus=='Approved') echo 'active'; ?>"  href="<?=base_url('index.php/Rent_3rd_party/checkstatus/Approved')?>">Approved(<?php echo $approved; ?>)</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="<?php if($checkstatus=='Pending') echo 'active'; ?>" href="<?=base_url('index.php/Rent_3rd_party/checkstatus/Pending')?>">Pending(<?php echo $pending; ?>)</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="<?php if($checkstatus=='Rejected') echo 'active'; ?>" href="<?=base_url('index.php/Rent_3rd_party/checkstatus/Rejected')?>">Rejected(<?php echo $rejected; ?>)</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class="<?php if($checkstatus=='InProcess') echo 'active'; ?>"  href="<?=base_url('index.php/Rent_3rd_party/checkstatus/InProcess/1')?>">Draft(<?php echo $inprocess; ?>)</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content"style="background:none;">
                    <div class="tab-pane sm-no-padding active slide-left" id="tab1">
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all">
                                        <div id="myDIV">
                                            <button class="btn1 active1 grid_btn" id="grid_btn_1"><i class="fa fa-th" aria-hidden="true"></i></button>
                                            <button class="btn1 list_btn" id="list_btn_1"><i class="fa fa-list" aria-hidden="true"></i></button>

                                            <!--<a href="index.php/sale"><button class="btn btn-default pull-right m-r-10" type="submit"> <span>Sold List</span></button></a>
											<a href="index.php/sale/addnew"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-minus tab-icon"></i> <span>Sell</span></button></a>-->
											 <?php
                                                $baseurl = base_url("index.php/Rent_3rd_party/add");
                                           ?>


                                            <a href="<?=$baseurl?>"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Add Rent</span></button></a>
                                        </div>
                                        <br>
                                      <div class="row grid">
                                         <?php for($i=0; $i<count($rent); $i++) { ?>
                                            <div class=" col-md-6">
                                                <div class="markup">
                                                    <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-4">
                                                                <img src="<?php echo base_url().$rent[$i]->p_image; ?>" alt="Paris" class="prop_img m-t-20 m-l-20" style="width:180px" onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                            </div>
                                                            <div class=" col-md-8">
                                                                <div class="card-header ">
                                                                   <div class="building_name"><b></b></div>
                                                                    <div class="owner_name"><H4 class="m-t-0 m-b-0">
                                                                        <?php

                                                                        foreach ($rent[$i]->owner_name as $key => $value) {
                                                                            echo $value->owner_name.",";
                                                                        }

                                                                         ?>
                                                                    </H4></div>
                                                                </div>
                                                                <div class="card-block">

                                                                     <?php foreach($rent[$i]->tenant_name as $name) { ?>
                                                                       <p class=" flat_info m-t-0 m-b-0"><b><?php echo $name->contact_name; ?></b></p> 
                                                                      <?php  }?>
                                                                      <p class=" flat_info m-t-0 m-b-0"><?php echo $rent[$i]->unit_name . ', ' . $rent[$i]->floor.' ' . 'Floor - ' . $rent[$i]->area.'  '.$rent[$i]->area_unit; ?></p>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <div class="col-md-4 rent">
                                                                 <a href="<?php echo base_url() . 'index.php/contacts/checkstatus/All/Tenants/' . $rent[$i]->property_id; ?>"><i style="font-size:22px;" class="fa fa-group"></i><br>
                                                                Tenants
                                                                    </a>
                                                            </div>
                                                            <div class=" col-md-4 leases">
                                                                 <a href="">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
                                                                    </a>
                                                            </div>
                                                       
                                                            <div class=" col-md-4 leases" style="border-left: 2px solid #edf0f5;">
                                                             <a href="<?php echo base_url().'index.php/task/checkstatus/'.$rent[$i]->property_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                Maintenance
                                                                </a>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-12">
                                                            <a href="<?php echo base_url().'index.php/Rent_3rd_party/view/'.$rent[$i]->txn_id; ?>" class=" pull-right invoice p-b-5     p-t-5" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          <?php } ?>
                                        </div>
                                        <div class="row list">
                                         <?php for($i=0; $i<count($rent); $i++) { ?>
                                            <div class=" col-md-12">
                                                <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                    <div class="row">
                                                        <img src="<?php echo base_url().$rent[$i]->p_image; ?>" alt=" " class="prop_img" style="max-width:100%;max-height:100%;height:100px; width:100px;border:none;padding: 8px;" onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                        <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;width:35%">
                                                            <div class="building_name"><?php echo $rent[$i]->unit_name; ?></div>
                                                        <div class="owner_name">
                                                             <?php

                                                                foreach ($rent[$i]->owner_name as $key => $value) {
                                                                    echo $value->owner_name.",";
                                                                }

                                                                ?>  
                                                             </div>
                                                        <?php foreach($rent[$i]->tenant_name as $name) { ?>
                                                                       <p class=" flat_info m-t-0 m-b-0"><b><?php echo $name->contact_name; ?></b></p> 
                                                                      <?php  }?>
                                                        </div>
                                                        <p class=" flat_info m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 10px;width: 18%;"><?php echo $rent[$i]->unit_name . ', ' . $rent[$i]->floor.' ' . 'Floor - ' . $rent[$i]->area.'  '.$rent[$i]->area_unit; ?></p>    
                                                        <p class="avaibility m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 10px;"></p>
                                                        
                                                        <div class="prop_btns">
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url() . 'index.php/contacts/checkstatus/All/Tenants/' . $rent[$i]->property_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Tenants"><i style="font-size:22px;" class="fa fa-group"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Accounting"><i style="font-size:22px;" class="fa fa-inr"></i></a>
                                                            </div>
                                                           
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="<?php echo base_url().'index.php/task/checkstatus/'.$rent[$i]->property_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Maintenance"><i style="font-size:22px;" class="fa fa-file-text-o"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Sub Property"><i style="font-size:22px;" class="fa fa-building-o"></i></a>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo base_url().'index.php/Rent_3rd_party/view/'.$rent[$i]->txn_id; ?>" class=" pull-left invoice" style="color:#5cb85c;margin-top: 37px;padding-left: 30px;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
                                                         </div>
                                                </div>
                                            </div>
                                         <?php  } ?>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/footer.php');?>
</div>
</div>

<?php $this->load->view ('templates/script.php');?>

<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/datatables/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('.list').hide();
        $('.grid_btn').on('click', function () {
            $('.grid').show();
            $('.list').hide();
            set_active_button($(this), 'list_btn');
        });
        $('.list_btn').on('click', function () {
            $('.grid').hide();
            $('.list').show();
            set_active_button($(this), 'grid_btn');
        });
    });
    var set_active_button = function(elem, btn){
        var id = elem.attr('id');
        var index = id.substring(id.lastIndexOf('_'));
        elem.addClass(' active1');
        $('#'+btn+index).removeClass('active1')
    }
</script>
</body>
</html>