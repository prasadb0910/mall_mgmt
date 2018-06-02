<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

    <link href="<?php echo base_url(); ?>assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

    <style>
	
	
	
    	.dropdown-menu
    	{
    		background:#fff!important;


    	}
    	
        .dropdown-menu>li>a:hover {
            color: #fff;
            text-decoration: none;
            background-color: #41a541!important;
            background-image: none;
        }
	
	
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
		.leases a {
          color: #626262!important;
        }
		.rent a {
          color: #626262!important;
        }
		.list a {
          color: #626262!important;
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
            display:inherit;
        }
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
                <li class="breadcrumb-item active"><a href="#">Contact List</a></li>
            </ol>

            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
					<li class="nav-item">
                        <a class="<?php if($contact_type=='All') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/All/All"><i class="fa fa-user"></i> <span>All</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php if($contact_type=='Tenants') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/All/Tenants"><i class="fa fa-user"></i> <span>TENANTS</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php if($contact_type=='Owners') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/All/Owners"><i class="fa fa-user"></i> <span>OWNERS</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="<?php if($contact_type=='Others') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/All/Others"><i class="fa fa-user"></i> <span>Others</span></a>
                    </li>
                </ul>
                <br>
				<div class="row" >
                <div class="col-md-12"> 
				<div class="dropdown pull-right">
									<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Add Contact
									<span class="caret"></span></button>
									<ul class="dropdown-menu">
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/individual">Individual</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/huf">Huf</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/pvtltd">Private Limited</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/ltd">Limited</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/llp">LLP</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/partnership">Partnership</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/aop">AOP</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/trust">Trust</a></li>
									  <li><a href="<?php echo base_url(); ?>index.php/contacts/addnew/<?php echo $contact_type; ?>/proprietorship">Proprietorship</a></li>
									 
									</ul>
								  </div>
				
                <div class="tab-content"style="background:none;">
				
                    <div class="tab-pane sm-no-padding active slide-left" id="tab1">
					
                       
							
                                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                                    <li class="nav-item all">
                                        <a class="<?php if($checkstatus=='All') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/All/<?php echo $contact_type; ?>">All(<?php echo count($all); ?>)</a>
                                    </li>
                                    <li class="nav-item approved">
                                        <a class="<?php if($checkstatus=='Approved') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/Approved/<?php echo $contact_type; ?>">Approved(<?php echo count($approved); ?>)</a>
                                    </li>
                                    <li class="nav-item pending">
                                        <a class="<?php if($checkstatus=='Pending') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/Pending/<?php echo $contact_type; ?>">Pending(<?php echo count($pending); ?>)</a>
                                    </li>
                                    <li class="nav-item rejected">
                                        <a class="<?php if($checkstatus=='Rejected') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/Rejected/<?php echo $contact_type; ?>">Rejected(<?php echo count($rejected); ?>)</a>
                                    </li>
                                    <li class="nav-item inprocess">
                                        <a class="<?php if($checkstatus=='In Process') echo 'active'; ?>" href="<?php echo base_url(); ?>index.php/contacts/checkstatus/InProcess/<?php echo $contact_type; ?>">Draft(<?php echo count($inprocess); ?>)</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="all">
							
									
											
                                        <div id="myDIV">
										<div class="row">
										<div class="col-md-12">
								
                                            <button class="btn1 active1 grid_btn" id="grid_btn_1"><i class="fa fa-th" aria-hidden="true"></i></button>
                                            <button class="btn1 list_btn" id="list_btn_1"><i class="fa fa-list" aria-hidden="true"></i></button>
                                        
							

										</div>
										</div>
										</div>
                                        <br>
                                        <div class="row">
                                            <?php for($i=0; $i<count($contacts); $i++) { ?>
                                            <div class=" col-md-3" >
                                                <div class="grid">
                                                    <div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-12">
                                                                <div class="thumbnail-wrapper d32 circular b-white "id="contact1" >
                                                                    <div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; -size:28pxalign-items:center;text-align: center;padding-top: 17px;font-size:24px;"><span><?php echo (strlen($contacts[$i]->c_name)>0?substr($contacts[$i]->c_name, 0, 1):'') . (strlen($contacts[$i]->c_last_name)>0?substr($contacts[$i]->c_last_name, 0, 1):''); ?></span>
                                                                    </div>  
                                                                </div>
                                                             
                                                                <div class="info">
                                                                    <H5 class="title_1"><?php if($contacts[$i]->c_owner_type=='individual') echo $contacts[$i]->c_name . ' ' . $contacts[$i]->c_last_name; else echo $contacts[$i]->c_company_name; ?></H5>
                                                                    <p class=""><b><?=$contacts[$i]->c_type?></b></p>
                                                                    <p>
                                                                        <?php if($contacts[$i]->c_owner_type=='individual') echo 'Individual';
                                                                            else if($contacts[$i]->c_owner_type=='huf') echo 'Huf';
                                                                            else if($contacts[$i]->c_owner_type=='pvtltd') echo 'Private Limited';
                                                                            else if($contacts[$i]->c_owner_type=='ltd') echo 'Limited';
                                                                            else if($contacts[$i]->c_owner_type=='llp') echo 'LLP';
                                                                            else if($contacts[$i]->c_owner_type=='partnership') echo 'Partnership';
                                                                            else if($contacts[$i]->c_owner_type=='aop') echo 'AOP';
                                                                            else if($contacts[$i]->c_owner_type=='trust') echo 'Trust';
                                                                            else if($contacts[$i]->c_owner_type=='proprietorship') echo 'Proprietorship'; ?>
                                                                    </p>
                                                                    <p class="email"><?php if($contacts[$i]->c_emailid1!='') echo $contacts[$i]->c_emailid1; else echo '&nbsp;'; ?></p>
                                                                </div>
                                                                <div class="user-roommates empty">
                                                                    <p><?php if($contacts[$i]->c_mobile1!='') echo $contacts[$i]->c_mobile1; else echo '&nbsp;'; ?></p>
																	
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <?php $class = ($contacts[$i]->c_type=='Owners' || $contacts[$i]->c_type=='Others' ?"col-md-12":'col-md-6'); 
																   $stylerent = ($contacts[$i]->c_type=='Owners' || $contacts[$i]->c_type=='Others' ?"border-right:none":''); 
                                                            ?>
                                                            <?php $style = ($contacts[$i]->c_type=='Owners' || $contacts[$i]->c_type=='Others'?"display:none":''); ?>

                                                             
                                                            <div class="col-md-12 rent">
                                                                <a href="<?php echo base_url() . 'index.php/Accounting/getConAcc/All/' . $contacts[$i]->c_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
																	</a>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class=" col-md-12">
                                                            <span class="invoice"><a href="<?php echo base_url(); ?>index.php/Accounting/addnew/income"><button class="btn btn-success pull-left btn-xs invoice" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
                                                            <a href="<?php echo base_url().'index.php/Contacts/viewrecord/'.$contacts[$i]->c_id; ?>" class=" pull-right invoice" style="color:#5cb85c;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div class="row list">
                                            <?php for($i=0; $i<count($contacts); $i++) { ?>
                                            <div class=" col-md-12" >
                                                <div class="card card-transparent container-fixed-lg bg-white contact_card " style="background:#fff;">
                                                    <div class="row">
                                                        <div class=" col-md-12" >
                                                            <div class="thumbnail-wrapper d32 circular b-white pull-left" id="contact1" style="margin: 15px;">
                                                                <div class="bg-master text-center text-white" style=" background: #899be7;text-align: center; padding-top: 17px;font-size:24px;"><span><?php echo (strlen($contacts[$i]->c_name)>0?substr($contacts[$i]->c_name, 0, 1):'') . (strlen($contacts[$i]->c_last_name)>0?substr($contacts[$i]->c_last_name, 0, 1):''); ?></span>
                                                                </div>  
                                                            </div>
                                                           
                                                            <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;width:30%">
                                                                <span class="title_1"><?php if($contacts[$i]->c_owner_type=='individual') echo $contacts[$i]->c_name . ' ' . $contacts[$i]->c_last_name; else echo $contacts[$i]->c_company_name; ?></span><br>
                                                                <span class=""><b><?=$contacts[$i]->c_type?> - </b></span>
                                                                <span class="">
                                                                    <?php if($contacts[$i]->c_owner_type=='individual') echo 'Individual';
                                                                            else if($contacts[$i]->c_owner_type=='huf') echo 'Huf';
                                                                            else if($contacts[$i]->c_owner_type=='pvtltd') echo 'Private Limited';
                                                                            else if($contacts[$i]->c_owner_type=='ltd') echo 'Limited';
                                                                            else if($contacts[$i]->c_owner_type=='llp') echo 'LLP';
                                                                            else if($contacts[$i]->c_owner_type=='partnership') echo 'Partnership';
                                                                            else if($contacts[$i]->c_owner_type=='aop') echo 'AOP';
                                                                            else if($contacts[$i]->c_owner_type=='trust') echo 'Trust';
                                                                            else if($contacts[$i]->c_owner_type=='proprietorship') echo 'Proprietorship'; ?>
                                                                </span><br>
                                                                <span class="email"><?php echo $contacts[$i]->c_emailid1; ?></span>
                                                            </div>
                                                            <div class="user-roommates empty pull-left" style="margin-top: 25px;">
                                                                <p class=" m-t-10"><?php echo $contacts[$i]->c_mobile1; ?></p>
                                                            </div>
                                                            <div class="pull-left"  style="margin-top: 25px;padding-left: 50px;"><a href="<?php echo base_url() . 'index.php/Accounting/getConAcc/All/' . $contacts[$i]->c_id; ?>">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
																	</a>
                                                            </div>
                                                           
                                                            <a href="<?php echo base_url().'index.php/Contacts/viewrecord/'.$contacts[$i]->c_id; ?>" class=" pull-right invoice" style="color:#5cb85c!important;margin-top: 37px;padding-right:50px">View <i class="    fa fa-angle-right tab-icon"></i> </a>
                                                            <span class="invoice"  ><a href="<?php echo base_url(); ?>index.php/Accounting/addnew/income"><button class="btn btn-success pull-right btn-xs invoice "style="margin-top: 37px;margin-right:40px" type="submit"><i class="fa fa-plus tab-icon"></i> <span>invoice </span></button></a></span>
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