<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
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
            left: 170px;
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
		@media screen and (min-device-width: 1440px) and (max-device-width:2556px) 
		{ 
			  .badge-notify 
			  {
				    left: 312px!important;
			  }
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
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper">
    <div class="content">
        <div class="container-fluid container-fixed-lg">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Bank List</a></li>
            </ol>
            <?php if(isset($groups)) { for ($i=0; $i < count($groups) ; $i++) { ?>
            <option value="<?php echo $groups[$i]->gu_gid; ?>" <?php if($groups[$i]->gu_gid==$this->session->userdata('groupid')) echo 'selected'; ?>><?php echo $groups[$i]->group_name; ?></option>
            <?php }} ?>
            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class="" href="<?php echo base_url(); ?>index.php/bank/checkstatus/All">All(<?php echo count ($all); ?>)</a>
                    </li>
                    <li class="nav-item approved">
                        <a class="" href="<?php echo base_url(); ?>index.php/bank/checkstatus/Approved">Approved(<?php echo count ($approved); ?>)</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="" href="<?php echo base_url(); ?>index.php/bank/checkstatus/Pending">Pending(<?php echo count ($pending); ?>)</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="" href="<?php echo base_url(); ?>index.php/bank/checkstatus/Rejected">Rejected(<?php echo count ($rejected); ?>)</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class="" href="<?php echo base_url(); ?>index.php/bank/checkstatus/InProcess">IN Process(<?php echo count ($inprocess); ?>)</a>
                    </li>
                </ul>
                <div class="tab-content"style="background:none;">
                    <div class="tab-pane padding-20 sm-no-padding active slide-left" id="tab1">
                        <div class="row">
                            <div class=" col-md-12" >
                                <div class="tab-content">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="all">
                                            <div id="myDIV">
                                                <button class="btn1 active1 grid_btn" id="grid_btn_1"><i class="fa fa-th" aria-hidden="true"></i></button>
                                                <button class="btn1 list_btn" id="list_btn_1"><i class="fa fa-list" aria-hidden="true"></i></button>
                                                <a href="<?php echo base_url(); ?>index.php/bank/addnew"><button class="btn btn-default pull-right" type="submit"><i class="fa fa-plus tab-icon"></i> <span> Add Bank Details</span></button></a>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <?php for($i=0; $i < count($banks); $i++) { ?>
                                                <div class=" col-md-3" >
                                                    <div class="grid">
                                                        <div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
                                                            <div class="row">
                                                                <div class=" col-md-12">
                                                                    <div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
                                                                        <div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;">
                                                                            <span><?php echo (strlen($bankowner[$i]['name'])>0?substr($bankowner[$i]['name'], 0, 1):'') . (strlen($bankowner[$i]['name'])>0?substr($bankowner[$i]['name'], 0, 1):''); ?></span>
                                                                        </div>  
                                                                    </div>
                                                              
                                                                    <div class="info">
                                                                        <H5 class="title_1"><?php  echo $banks[$i]->b_name; ?></H5>
                                                                        <p class="email"><?php if($bankowner[$i]['name']!='') echo $bankowner[$i]['name']; else echo '&nbsp;'; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="padding-left:15px;padding-right:15px;">
                                                                <div class="col-md-6 rent">
                                                                    Branch<br>
                                                                    <?php echo $banks[$i]->b_branch;?>
                                                                </div>
                                                                <div class=" col-md-6 leases">
                                                                    Account Type<br>
                                                                    <?php echo $banks[$i]->b_accounttype;?>
                                                                </div>
                                                            </div>
                                                            <div class=" col-md-12">
                                                                <span class="invoice"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><span> <?php echo $banks[$i]->b_status;?> </span></button></span>
                                                                <a href="<?php echo base_url().'index.php/Bank/viewbank/'.$banks[$i]->b_id; ?>" class=" pull-right invoice" style="color:#5cb85c;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="row list">
                                                <?php for($i=0; $i<count($banks); $i++) { ?>
                                                <div class=" col-md-12" >
                                                    <div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-12" >
                                                                <div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
                                                                    <div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;">
                                                                        <span><?php echo (strlen($bankowner[$i]['name'])>0?substr($bankowner[$i]['name'], 0, 1):'') . (strlen($bankowner[$i]['name'])>0?substr($bankowner[$i]['name'], 0, 1):''); ?></span>
                                                                    </div>  
                                                                </div>
                                                             
                                                                <div class="info pull-left p-l-10" style="margin-top: 25px;text-align:left;">
                                                                    <span class="title_1"><?php  echo $banks[$i]->b_name; ?></span><br>
                                                                    <span class="email"><?php if($bankowner[$i]['name']!='') echo $bankowner[$i]['name']; else echo '&nbsp;'; ?></span>
                                                                </div>

                                                                <div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">Branch<br>
                                                                    <?php echo $banks[$i]->b_branch;?>
                                                                </div>
                                                                <div class="pull-left"  style="margin-top: 25px;padding-left: 50px;">
                                                                    Account Type<br>
                                                                    <?php echo $banks[$i]->b_accounttype;?>
                                                                </div>
                                                                <a href="<?php echo base_url().'index.php/Bank/viewbank/'.$banks[$i]->b_id; ?>" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-right:50px">View <i class="    fa fa-angle-right tab-icon"></i> </a>
                                                                <span class="invoice"  ><button class="btn btn-success pull-right btn-xs invoice" type="submit" style="margin-top: 37px;margin-right:200px"><span> <?php echo $banks[$i]->b_status;?> </span></button></span>
                                                            </div>
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
    </div>

    <?php $this->load->view('templates/footer');?>
</div>
</div>

<?php $this->load->view('templates/script');?>
	
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