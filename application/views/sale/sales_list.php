<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

       <link href="<?php echo base_url(); ?>assets/css/prop_list.css" rel="stylesheet" />

    <style>
        <?php if($maker_checker!='yes') { ?>
            .approved {
                display: none !important;
            }
            .pending {
                display: none !important;
            }
            .rejected {
                display: none !important;
            }
        <?php } ?>
    </style>
</head>
<body class="fixed-header">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper">
    <div class="content ">
        <div class=" container-fluid container-fixed-lg">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Sale List</a></li>
            </ol>

            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class="<?php if($checkstatus=='All') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/All">All(<?php echo $all; ?>)</a>
                    </li>
                    <li class="nav-item approved">
                        <a class="<?php if($checkstatus=='Approved') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/Approved">Approved(<?php echo $approved; ?>)</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="<?php if($checkstatus=='Pending') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/Pending">Pending(<?php echo $pending; ?>)</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="<?php if($checkstatus=='Rejected') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/Rejected">Rejected(<?php echo $rejected; ?>)</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class="<?php if($checkstatus=='InProcess') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/InProcess">Draft(<?php echo $inprocess; ?>)</a>
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
                                       
                                            <a href="<?php echo base_url(); ?>index.php/Sale/addnew"><button class="btn btn-default pull-right" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Add Sale</span></button></a>
                                        </div>
                                 <br>
                                        <div class="row grid">
                                            <?php for($i=0; $i<count($sales); $i++) { ?>
                                            <div class=" col-md-6">
                                                <div class="markup">
                                                    <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-4">
                                                                <img src="<?php echo base_url().$sales[$i]->p_image; ?>" alt="Paris" class="prop_img m-t-20 m-l-20" style="width:180px" onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                            </div>
                                                            <div class=" col-md-8">
                                                                <div class="card-header ">
																 <div class="building_name"><b><?php echo $sales[$i]->unit_name; ?></b></div>
                                                                    
                                                                 <div class="owner_name"><H4 class="m-t-0 m-b-0">
                                                                        <div class="building_name"><b></b></div> 
                                                                    </H4></div>
                                                                </div>
                                                                <div class="card-block">
                                                                 
                                                                    <p class=" flat_info m-t-0 m-b-0"><?php echo $sales[$i]->unit_name . ', ' . $sales[$i]->floor.' ' . 'Floor - ' . $sales[$i]->area.'  '.$sales[$i]->area_unit; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <div class=" col-md-12 leases">
																 <a href="<?php echo base_url().'index.php/accounting/checkstatus/All/' . $sales[$i]->property_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
																	</a>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-12">
                                                            <a href="<?php echo base_url().'index.php/Sale/view/'.$sales[$i]->txn_id; ?>" class=" pull-right invoice p-b-5     p-t-5" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row list">
                                            <?php for($i=0; $i<count($sales); $i++) { ?>
                                            <div class=" col-md-12">
                                                <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                    <div class="row">
                                                      <img src="<?php echo base_url().$sales[$i]->p_image; ?>" alt="Paris" class="prop_img" style="max-width:100%;width:100px;max-height:100%;height:100px; border:none;padding: 8px;" onerror=" this.src='<?php echo base_url(); ?>assets/img/demo/preview.jpg'">
                                                        <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;width:35%">
														 <div class="building_name"><?php echo $sales[$i]->unit_name; ?></div>
                                                         
                                                           
                                                          
                                                        </div>
                                                        <p class=" flat_info m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 20px;"><?php echo $sales[$i]->unit_name . ', ' . $sales[$i]->floor.' ' . 'Floor - ' . $sales[$i]->area.'  '.$sales[$i]->area_unit; ?></p>
                                                        <div class="prop_btns">
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 20px;">
                                                                <a href="<?php echo base_url().'index.php/accounting/checkstatus/All/' . $sales[$i]->property_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Accounting"><i style="font-size:22px;" class="fa fa-inr"></i></a>
                                                            </div>
                                                        </div>
                                                        <a href="<?php echo base_url().'index.php/Sale/view/'.$sales[$i]->txn_id; ?>" class=" pull-left invoice" style="color:#5cb85c;margin-top: 37px;padding-left: 30px;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
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

    <?php $this->load->view('templates/footer');?>
</div>
</div>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>

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