<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

    <style>
        table.dataTable thead .sorting:after {
            opacity: 0.2; 
            content: ""; 
        }
        table.dataTable thead .sorting_asc:after {
            content: "";
        }
        table.dataTable thead .sorting_desc:after {
            content: "";
        }
        .prop_img {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            width: 150px;
        }
        .markup {
            border-radius:20px;
        }
        #contact1 {
            width: 70px;
            height: 70px;
            text-align: left;
            float: none;
            margin: 15px auto;
            display: block;
        }
        .info {
            text-align:center;
        }
        .invoice {
            margin:10px;
        }
        .btn-group-justified {
            margin-left:2px;
        }
        .email {
            font-size:13px!important;
            color:#4a65da!important;
        }
        .title_1 {
            margin-bottom:5px!important;
            font-size: 1.14286rem!important;
            font-family: inherit!important;
            font-weight: 500!important;
            letter-spacing: 0.02em!important;
            text-transform: capitalize!important;
        }
        .contact_card {
            border-radius:5px!important;
        }
        .rent {
            border-bottom:2px solid #edf0f5;
            border-top:2px solid #edf0f5;
            border-right:2px solid #edf0f5;
            padding: 6px 10px;
            text-align:center;
            color:#40434b;
        }
        .rent:hover {
            background-color: #f6f9fc;
        }
        .leases {
            border-bottom:2px solid #edf0f5;
            border-top:2px solid #edf0f5;
            padding: 6px 10px;
            text-align:center;
            color:#40434b;
        }
        .leases:hover {
            background-color: #f6f9fc;
        }
        .badge-notify {
            background: #899be7;
            position: relative;
            top: -88px;
            left: 159px;
            width: 28px;
            height: 28px;
            color: #fff;
            border: 2px solid #ffffff;
            position: absolute;
            top: 8px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #899be7;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            border: 2px solid #ffffff;
            -webkit-transition: background-color 0.2s linear;
            transition: background-color 0.2s linear;
        }
        #money.fa {
            font-size:22px!important;
        }
        .user-roommates.empty>p {
            text-align:center;
            font-size: 14px;
            color: #8b92a2;
        }
        .select2-selection--single {
            text-align:left;
        }
        .btn1 {
            border: none;
            outline: none;

            background-color: #f1f5f9;
            cursor: pointer;
            font-size: 18px;

            cursor: pointer;
            color: #40434b;
            font-size: 20px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: -webkit-inline-box;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            border-radius: 6px;
            width: 34px;
            height: 34px;
            margin-right: 3px;
            -webkit-transition: background-color 0.235s ease-in;
            transition: background-color 0.235s ease-in;
        }
        .active1, .btn1:hover {
            background-color: #e6ebf1;
        }
        #myDIV{
            display: -webkit-inline-box;
        }
    </style>

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
                        <a class="<?php if($checkstatus=='InProcess') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/Sale/checkstatus/InProcess">IN Process(<?php echo $inprocess; ?>)</a>
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
                                        </div>
                                        <div>
                                            <a href="<?php echo base_url(); ?>index.php/Sale/addnew"><button class="btn btn-default pull-right" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Add Property</span></button></a>
                                        </div>
                                        <br>
                                        <div class="row grid">
                                            <?php for($i=0; $i<count($sales); $i++) { ?>
                                            <div class=" col-md-6">
                                                <div class="markup">
                                                    <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-4">
                                                                <img src="<?php echo base_url().$sales[0]->p_image; ?>" alt="Paris" class="prop_img m-t-20 m-l-20" style="width:180px">
                                                            </div>
                                                            <div class=" col-md-8">
                                                                <div class="card-header ">
                                                                    <div class="owner_name"><H4 class="m-t-0 m-b-0"><?php echo $sales[$i]->owner_name; ?></H4></div>
                                                                </div>
                                                                <div class="card-block">
                                                                    <p class=" flat_info m-t-0 m-b-0"><?php echo $sales[$i]->p_type . ', ' . $sales[$i]->pr_agreement_area . ' ' . $sales[$i]->pr_agreement_area . ', ' . $sales[$i]->p_status; ?></p>
                                                                    <p class="avaibility m-t-0 m-b-0">Vacant</p>
                                                                    <div class="building_name"><b><?php echo $sales[$i]->p_display_name; ?></b></div>
                                                                    <div class="address"><i class="fa fa-map-marker"></i><?php if(isset($sales)) { echo $sales[0]->p_apartment . ' ' . $sales[0]->p_flatno . ' ' . $sales[0]->p_floor . ' ' . $sales[0]->p_wing . ' ' . $sales[0]->p_address . ' ' . $sales[0]->p_landmark . ' ' . $sales[0]->p_state . ' ' . $sales[0]->p_city . ' ' . $sales[0]->p_pincode . ' ' . $sales[0]->p_country; } ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <div class="col-md-3 rent">
                                                                <i style="font-size:22px;" class="fa fa-group"></i><br>
                                                                Tenants
                                                            </div>
                                                            <div class=" col-md-3 leases">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
                                                            </div>
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
                                                                <i style="font-size:22px;" class="fa fa-clock-o  "></i><br>
                                                                Reminders
                                                            </div>
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
                                                                <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                Maintenance
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
                                                        <img src="<?php echo base_url(); ?>assets/img/demo/menu_divided_con.png" alt="Paris" class="prop_img" style="max-width:100px;width:100%;border:none;padding: 8px;">
                                                        <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;">
                                                            <div class="owner_name"><H4 class="m-t-0 m-b-0"><?php echo $sales[$i]->owner_name; ?></H4></div>
                                                            <div class="building_name"><?php echo $sales[$i]->p_display_name; ?></div>
                                                            <div class="address"><i class="fa fa-map-marker"></i><?php if(isset($sales)) { echo $sales[0]->p_apartment . ' ' . $sales[0]->p_flatno . ' ' . $sales[0]->p_floor . ' ' . $sales[0]->p_wing . ' ' . $sales[0]->p_address . ' ' . $sales[0]->p_landmark . ' ' . $sales[0]->p_state . ' ' . $sales[0]->p_city . ' ' . $sales[0]->p_pincode . ' ' . $sales[0]->p_country; } ?></div>
                                                        </div>
                                                        <p class=" flat_info m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 20px;"><?php echo $sales[$i]->p_type . ', ' . $sales[$i]->pr_agreement_area . ' ' . $sales[$i]->pr_agreement_area . ', ' . $sales[$i]->p_status; ?></p>
                                                        <p class="avaibility m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 20px;" >Occupied Expires on:11/02/2018</p>
                                                        <div class="prop_btns">
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 20px;">
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Tenants"><i style="font-size:22px;" class="fa fa-group"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 20px;">
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Accounting"><i style="font-size:22px;" class="fa fa-inr"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 20px;">
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Reminders"><i style="font-size:22px;" class="fa fa-clock-o"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 20px;">
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Maintenance"><i style="font-size:22px;" class="fa fa-file-text-o"></i></a>
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