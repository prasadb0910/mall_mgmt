<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <link href="<?=base_url()?>/css/c3.css" rel="stylesheet" type="text/css" />
        <script src="<?=base_url()?>/js/d3-4.13.0.min-1190977b.js"></script>
    <script src="<?=base_url()?>/js/c3.min-c960f68f.js"></script>

    <style>
	.m-btn-link--remove {
    color: #40434b;
    text-transform: lowercase;
	    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    font-size: 13px;
    line-height: 20px;
    font-weight: 500;
	cursor:pointer;
}
.m-btn-link--remove:before {
    content: '\f00d';
     font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    font-size: 15px;
    display: inline-block;
    text-decoration: inherit;
    width: 1em;
    text-align: center;
    font-variant: normal;
    text-transform: none;
    line-height: 1;
    margin: 0;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
	.m-btn-link--remove:hover {
    opacity: 1;
    color: #d63b3b!important;
    text-decoration: none;
}
        a{color: #41a541 ;}a:hover, a:active {
            color: #2b6e2b;
        }
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
        }
        .next {
          right: 0;
          border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
          background-color: rgba(0, 0, 0, 0.8);
        }
        .numbertext {
          color: #f2f2f2;
          font-size: 12px;
          padding: 8px 12px;
          position: absolute;
          top: 0;
        }

        img {
          margin-bottom: -4px;
        }

        .caption-container {
          text-align: center;
          background-color: black;
          padding: 2px 16px;
          color: white;
        }

        .demo {
          opacity: 0.6;
        }

        .active,
        .demo:hover {
          opacity: 1;
        }

        img.hover-shadow {
          transition: 0.3s
        }

        .hover-shadow:hover {
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
        }
        .column
        {
        	width:25%;
        }
        .list_units p
        {
        	font-size:14px!important;
        }
    </style>
    <style>
        .edit
        {
        	
        	color:#41a541!important;
        }
        .delete
        {
        	color:#da5050!important;
        }
        .print
        {
        	color:#fe970a!important;
        }

        .a
        {
        border-bottom: 2px solid #edf0f5;
        margin-bottom: 25px;
        padding-bottom: 25px;
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
            width: 150px;
            height: 150px;
            text-align: center;
        	float: none;
            margin: 15px auto;
            display: block;
        	color:#fff!important;
        }
        .info
        {
        	text-align:center;
           
        }
        .invoice
        {
            margin: 10px;
            padding: 0 27px;
            border-radius: 30px;
            font-size: 13px;
        }
        .btn-group-justified
        {
        	margin-left:2px;
        }
        .email
        {
        	font-size:13px!important;
        		display: block;
        		text-align:center;
        	
        }
        .title_1
        {
        	
        	font-size: 15px!important;
            font-family: inherit!important;
            font-weight: 500!important;
            letter-spacing: 0.02em!important;
            text-transform: capitalize!important;
        	text-align:center;
        	display: block;
        }

        .rent
        {
            border-right:2px solid #f6f9fc;
            padding:12px;
            text-align:center;
            color:#40434b;
            border-color: #f6f9fc !important;	
            font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
            font-size: 12px;
            
        }
        .rent i
        {
        	color:#41a541 !important;	
        	
        }
        .rent:hover
        {
        	background-color: #f6f9fc !important;
        }
        .leases
        {
            color:#40434b;
            border-top: 2px solid #f6f9fc;
            padding:12px;
            text-align:center;
            color:#40434b;
            border-right:2px solid #f6f9fc;
            border-color: #f6f9fc) !important;
            font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
            font-size: 12px;
            
			word-wrap: break-word;
        }
        .leases i
        {
        	color:#41a541 !important;	
        }
        .leases:hover
        {
        	background-color: #f6f9fc !important;
        }


        #money.fa 
        {
        	font-size:22px!important;
        }
        .user-roommates:after {
            content: '';
            position: absolute;
            left: 50%;
           top: 161px;
            width: 22px;
            height: 1px;
            margin-left: -11px;
            background-color: #e6ebf1;
        }

        .user-roommates.empty>p {
           text-align:center;
            font-size: 12px;
            color: #d1d3d8;
        }
        .form-group-default
        {
        	border:none!important;
        }

        .form-group-default label
        {
        	font-weight:1000!important;
        }
        .thumbnail-wrapper.d32>* {
            line-height: 110px!important;
        }
        .block1
        {
        	padding: 20px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
        	    margin-top: 10px;
            margin-bottom: 10px;
        }
        p{
            font-weight: 200px!important;
        }

        .month 
        {
        	background:#f6f9fc;
        }

        .prop_sq li
        {
        	list-style-type:none!important;
        }
    </style>
    <style>
        .dot {
    		height: 115px;
    		width: 115px;
    		border: 1px solid #0facf352;
    		border-radius: 50%;
    		display: block;
    		font-size: 15px;
    		text-align: center;
            line-height: 115px;
            margin:0 auto;
        }
        .unit {
        	font-weight:400!important;
        	font-size:18px!important;
        	    padding-left: 40px;
        }	
        .sq {
        	font-weight:300;
        	font-size:14px;
        	padding-left: 40px;
        }
        .view_prop {
        	
            width: 100%!important;
            max-width: 100%!important;
        	border:1px solid rgba(0,0,0,0.07)!important;
        }
        .m-panel__footer {
            background: transparent;
            border-radius: 0;
            border-bottom: 0;
            padding: 7px 15px;
            position: relative;
            z-index: 3;
            height: 44px;
          -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .card{
        	font-variant-numeric: proportional-nums!important;
            font-family: "tenantcloud", Avenir, sans-serif!important;
            line-height: 1.42857!important;
            letter-spacing: 0.02em!important;
            text-rendering: optimizelegibility!important;
        	font-size:15px!important;
        }
        .m-panel__body {
            position: relative;
            padding: 15px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-flex: 1;
            -webkit-flex: 1 0 auto;
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }
        .middle-xs {
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        }
        .outstanding-price {
            text-align: center!important;
        }
        .outstanding-price p {
            color: #da5050;
            margin: 0;
            font-size: 1.71429em;
        }
        .payments-price.received {
           // text-align: right;
         //   padding-right: 25px;
        	    position: relative;
            max-width: 50%;
            word-break: break-all;
        }
        .body-price {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        .payments-price.received p {
           // font-size: 1.71429em;
            font-size: 20px;
            line-height: 23px;
        }
		   .payments-price.received span {
          padding-right: 20px;
        }
        .body-price .payments-price.received:after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 1px;
            height: 100%;
            background: #6dc56d;
            -webkit-transform: rotate(25deg);
            transform: rotate(25deg);
        }
        .payments-price.pending {
            text-align: left;
            padding-left: 20px;
        }
        .payments-price.pending p {
           
                font-size: 1.14286em;
        }
        .u-textTruncate {
            max-width: 100%;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            word-wrap: normal !important;
        }
        .list-inner ul li
        {
        	border-bottom: 1px dashed #edf0f5;
        }
        .list-footer {
            height: 35px;
            padding: 6px 20px 6px 25px;
            border-top: 1px solid #edf0f5;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: end;
            -webkit-justify-content: flex-end;
            -ms-flex-pack: end;
            justify-content: flex-end;
        }
        .m-panel__heading {
            border-radius: 0;
            padding: 7px 15px;
            position: relative;
            height: 48px;
            min-height: 48px;
            border-bottom: 2px solid #edf0f5;
            background-color: #f6f9fc;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
        	font-weight:700;
        }
        .between-xs {
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }
        .rent a,.leases a {
        	color:#626262!important;
        }
    </style>
    <style>
        .u-flex--flex {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-flex: 1;
            -webkit-flex: 1 0 auto;
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
        }
        .m-widget--started>.row>[class*='col-sm']:first-child {
            border-right: 1px solid #edf0f5;
        }
        .m-panel__heading {
            border-radius: 0;
            padding: 7px 15px;
            position: relative;
            height: 48px;
            min-height: 48px;
            border-bottom: 2px solid #edf0f5;
            background-color: #f6f9fc;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
        }
        .m-panel__body {
            padding: 15px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-flex: 1;
            -webkit-flex: 1 0 auto;
            -ms-flex: 1 0 auto;
            flex: 1 0 auto;
        }
        .order-sm-2 {
            -webkit-box-ordinal-group: 3;
            -webkit-order: 2;
            -ms-flex-order: 2;
            order: 2;
        }
        small {
            font-size: 12px;
            font-weight: 400;
            display: block;
            font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
            color: #8c919e;
        }
        .started {
        	display: flex;
        	padding:5px;
        }
        .started:before {
            font-family: FontAwesome;
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-size: 32px;
            /*color:#41a541;*/
        }
        .body {
        	padding-left: 10px;
        }

		 .start-move-in .body {
        	padding-left: 13px;
        }
		 .start-free-website .body {
        	padding-left: 12px;
        }
		
        .body a {
            line-height: 1;
            font-size: 16px;
        }

        .start-property:before {
            content: "\f015 ";
            font-family: FontAwesome;
            display: inline-block;
            padding-right: 3px;
            vertical-align: middle;
            font-size: 32px;
            color:<?php if(isset($property)) {if(count($property)==0) echo "#da5050;"; else echo "#41a541;";} else echo "#da5050;";?>;
        }
        .start-property a {
            color:<?php if(isset($property)) {if(count($property)==0) echo '#da5050;'; else echo '#41a541;';} else echo '#da5050;';?>;
        }
        .start-tenants:before {
        	content:"\f007 ";
            color:<?php if(isset($tenant)) {if(count($tenant)==0) echo '#da5050;'; else echo '#41a541;';} else echo '#da5050;';?>;
        }
        .start-tenants a {
            color:<?php if(isset($tenant)) {if(count($tenant)==0) echo '#da5050;'; else echo '#41a541;';} else echo '#da5050;';?>;
        }
        .start-move-in:before {
        	content:"\f10a ";
            color:<?php if(isset($rent)) {if(count($rent)==0) echo '#da5050;'; else echo '#41a541;';} else echo '#da5050;';?>;
        }
        .start-move-in a {
            color:<?php if(isset($rent)) {if(count($rent)==0) echo '#da5050;'; else echo '#41a541;';} else echo '#da5050;';?>;
        }
        .start-free-website:before {
        	content:"\f1c5";
            color:<?php if(isset($website)) {if(count($website)==0) echo '#da5050 !important;'; else echo '#41a541 !important;';} else echo '#da5050 !important;';?>;
        }
        .start-free-website a {
            color:<?php if(isset($website)) {if(count($website)==0) echo '#da5050 !important;'; else echo '#41a541 !important;';} else echo '#da5050 !important;';?>;
        }
        .start-invoice_settings:before {
        	content:"\f013";
        	color:#da5050;
        }
        .cloud-smile {
            text-align: center;
            margin-bottom: 10px;
        }
        .smile {
        	font-size: 90px;
            color:#41a541;
            text-align:center
        }
        .progress {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            overflow: hidden;
            font-size: 12px;
            line-height: 1rem;
            text-align: center;
            background-color: #eceeef;
            border-radius: 7px;
        	height: 14px;
        }
        .c3-event-rect {
            width: 0 !important;
        }
    </style>
</head>
<body class="fixed-header">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper">
<div class="content">
    <div class=" container-fluid   container-fixed-lg">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ol>
        <div class=" container-fluid   container-fixed-lg">
          
                <div class="row">
                    <div class="col-md-12">
                        <div class="row close_panel">
                            <div class=" col-md-12">
                                <div class="card card-default  ">
                                    <div class="m-panel__heading    between-xs">
                                        <div class="heading-title">
                                            Let's Get Started
                                        </div>
										<a class="m-btn-link--remove" >Close</a>
                                    </div>
									
                                    <div class="card-block">
                                        <div class="m-panel__body">
                                            <div class="row">
                                                <div class=" col-md-9">
												  <div class="row">
                                                    <div class=" col-md-6">
                                                        <div class="started start-tenants">
                                                            <div class="body tenants">
                                                                <a  title="add tenants" href="<?php echo base_url(); ?>index.php/contacts/addnew" style="<?php if(isset($tenant)) {if(count($tenant)==0) echo 'color: #da5050;';} else echo 'color: #da5050;';?>">
                                                                    <span>add tenants</span>
                                                                </a>
                                                                <small>add active and new tenants</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-6">
                                                        <div class="started start-property">
                                                            <div class="body">
                                                                <a title="add property &amp; units" href="<?php echo base_url(); ?>index.php/real_estate_property/add" style="<?php if(isset($property)) {if(count($property)==0) echo 'color: #da5050;';} else echo 'color: #da5050;';?>">
                                                                    <span>add property &amp; units</span>
                                                                </a>
                                                                <small>add apartments, homes, offices</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-6">
                                                        <div class="started start-move-in">
                                                            <div class="body move_tenant">
                                                                <a  title="move in a tenant" href="<?php echo base_url(); ?>index.php/Rent_real_estate/add" style="<?php if(isset($rent)) {if(count($rent)==0) echo 'color: #da5050;';} else echo 'color: #da5050;';?>">
                                                                    <span>move in a tenant</span>
                                                                </a>
                                                                <small>create a lease and manage accounting</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-6">
                                                        <div class="started start-free-website">
                                                            <div class="body website">
                                                                <a  title="set up free website" href="#">
                                                                    <span>set up free website</span>
                                                                </a>
                                                                <small>select color scheme, subdomain and list vacancies</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class=" col-md-3">
                                                    <div class ="smile">
                                                        <?php if(isset($progress)) 
                                                                { if($progress>0) echo '<i class="fa fa-smile-o"></i>'; else echo '<i class="fa fa-frown-o" style="color:#da5050;"></i>'; } 
                                                                else echo '<i class="fa fa-frown-o" style="color:red;"></i>'; 
                                                        ?>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar">
                                                            <span class="current-value"><?php if(isset($progress)) { echo $progress; } else echo 0; ?>%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-default " style="height:270px">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            Quick buttons
                                        </div>
                                    </div>
                                    <div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box">
                                        <div class="row" style="padding-left:30px;padding-right:30px;">
                                            <div class=" col-md-4 rent" style="border-right: 2px solid #f6f9fc;">
                                                <a href="<?php echo base_url(); ?>index.php/contacts/addnew"><i style="font-size:24px;" class="fa fa-group "></i><br>
                                                    New Tenant
                                                </a>
                                            </div>
                                            <div class="col-md-4 rent" style="border-right: 2px solid #f6f9fc;">
                                                <a href="<?php echo base_url(); ?>index.php/real_estate_property/add"><i style="font-size:24px;" class="fa fa-home"></i><br>
                                                    New Property
                                                </a>
                                            </div>
                                            <div class=" col-md-4 rent" style="border-right:none;padding:18px">
                                                <a href="<?php echo base_url(); ?>index.php/Rent_real_estate/add"><i style="font-size:24px;" class="fa fa-file-text-o "></i><br>
                                                    New Rent
                                                </a>
                                            </div>
                                            <div class="col-md-4 leases" style="border-right: 2px solid #f6f9fc;">
                                                <a href="<?php echo base_url(); ?>index.php/task/task_edit"><i style="font-size:24px;" class="fa fa-wrench"></i><br>
                                                  New Request
                                                </a>
                                            </div>
                                            <div class=" col-md-4 leases">
                                                <a href="<?php echo base_url(); ?>index.php/accounting/addnew/expense"><i style="font-size:24px;" class="fa fa-rupee "></i><br>
                                                    New Expense
                                                </a>
                                            </div>
                                            <div class=" col-md-4 leases" style="border-right:none;">
                                                <a href="<?php echo base_url(); ?>index.php/accounting/addnew/income"><i style="font-size:24px;" class="fa fa-money"></i><br>
                                                    New Income
                                                </a>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                               <div class="col-md-4">
                                <div class="card card-default ">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            Units
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="m-panel__body">
                                            <div id="chartMessages"></div>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-4">
                                <div class="card card-default ">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            Last 30 days
                                        </div>
                                    </div>
                                    <div class="card-block">
                                       <div class="m-panel__body" style="height:136px">
                                            <div class="body-price">
                                                <div class="payments-price received">
                                                    <a href="#">
                                                        <p>₹<?php if(isset($invoice_cnt[0]->paid_invoices)) echo format_money($invoice_cnt[0]->paid_invoices,2); ?></p>
                                                        <span>paid invoices</span>
                                                    </a>
                                                </div>
                                                <div class="payments-price pending">
                                                    <p class="u-textTruncate">₹<?php if(isset($invoice_cnt[0]->open_invoices)) echo format_money($invoice_cnt[0]->open_invoices,2); ?></p>
                                                    <span>open invoices</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-panel__footer">
                                            <a  href="<?php echo base_url(); ?>index.php/accounting/">view all</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-4">
                                <div class="card card-default ">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            Outstanding Receipts
                                        </div>
                                    </div>
                                    <div class="card-block">
                                          <div class="m-panel__body" style="height:136px">
                                            <div class="outstanding-price">
                                                <p>₹<?php if(isset($total_outstanding[0]->total_outstanding)) echo format_money($total_outstanding[0]->total_outstanding,2); else echo 0; ?></p>
                                            </div>
                                        </div>
                                        <div class="m-panel__footer">
                                           <a  href="<?php echo base_url(); ?>index.php/accounting/">view all</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                          
                               <div class="col-md-4">
                                <div class="card card-default">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            To do List
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="m-panel__body" style="height:136px">
                                            <div class="list-inner">
                                                <ul>
                                                </ul>
                                            </div>
                                        </div>
                                         <div class="m-panel__footer">
                                            <a class="ng-binding" href="">view all</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <div class="col-md-4">
                                <div class="card card-default">
                                    <div class="m-panel__heading between-xs">
                                        <div class="heading-title">
                                            Maintenance
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="m-panel__body">
                                            <div id="chartMessages1"></div>
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

    var chart = c3.generate({
        type: 'donut',
        bindto: '#chartMessages',
        data: {
            columns: [
            ['vacant', <?php if(isset($property_cnt[0]->vacant_cnt)) echo $property_cnt[0]->vacant_cnt; ?>],
            ['occupied', <?php if(isset($property_cnt[0]->rent_cnt)) echo $property_cnt[0]->rent_cnt; ?>],
            ['sold', <?php if(isset($property_cnt[0]->sale_cnt)) echo $property_cnt[0]->sale_cnt; ?>],

            ],
            type: 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
       
        donut: {
            label: {
                format: function(value) {
                    return value;
                },
                threshold: 0.01,
             //   show: true, // to turn off the min/max labels.
            },
            /*title: total+' Total',*/
            min: 0,
            max: 100, // 100 is default
            // units: 2,
            width: 10, // for adjusting arc thickness
            opacity: 1,

        },
        legend: {
            position: 'right'
        },
        size: {
            height: 150
        },
        tooltip: {
            format: {
                value: function (value, ratio, id) {
                    return value;
                }
            }
        }
    });

</script>

<script>
    var chart = c3.generate({
        bindto: '#chartMessages1',
        data: {
            columns:<?php  echo json_encode($mentainanace_cnt)?>,
            type: 'donut',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: {
            label: {
                format: function(value) {
                    return value;
                },
                threshold: 0.01,
                // show: true, // to turn off the min/max labels.
            },
           /* title: total+' Total',*/
            min: 0,
            max: 100, // 100 is default
            // units: 'Remaining',
            width: 10, // for adjusting arc thickness
        },
        legend: {
            position: 'right'
        },
        size: {
            height: 150
        },
        tooltip: {
            format: {
                value: function (value, ratio, id) {
                    return value;
                }
            }
        }
    });
</script>
<script>

$(document).ready(function() {
    $('.m-btn-link--remove').on('click', function () {
          $('.close_panel').hide();
    });
});


</script>


 <script>
 
 
 
 </script>


<script>
    // var currentCount = 150;
    // var progress = (currentCount / 300) * 100;

    var progress = '<?php if(isset($progress)) { echo $progress; } else echo 0; ?>';
    $(".progress-bar").width(progress + '%');
    if (progress % 1 !== 0) {
        $(".progress-bar").text(progress.toFixed(1) + '%');
    } else {
        $(".progress-bar").text(progress + '%');
    }
</script>
</body>
</html>
