<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>

        <style>
            .tile {padding: 0px;
                   min-height: 77px;}
        </style>

        <style>
            .tile {padding: 0px; min-height: 77px;}
            .page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;  background: #E0E0E7;  }
            .dataTables_filter {/* border-bottom:0!important;*/ }
            .table tbody tr td:last-child  {border: 1px solid #eee!important;}
            .heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px; /*padding-bottom: 0; */  } 
            .heading-h2 a{  color: #444;     }
            /*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
            font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
            border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
            .nav-contacts {/* float: right; width: 55%;*/ }
            .main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
            .main-container {margin:0 12px; } 
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
            .col-md-12 { margin:20px 0; display: flex;
            background: #fff;
            padding:10px!important;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px;}
            .page-overflow { overflow:auto; }
            #approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
            .table thead tr th { padding:8px 5px!important; font-weight:600; }
            b, strong { font-weight:500;}
            .panel-body {padding: 0!important;}
            .panel { border: none; box-shadow: none; margin-top: 0;   margin-bottom: 0; padding: 0;}
            .btn-container {  }
            .btn-top-margin { margin-top:-36px!important; margin-right: 15px; }
            .dataTables_empty { color:#e90404!important; font-size: 14px!important;  }
            .btn-top {  background:#eee; line-height: 25px;  border-bottom: 1px solid #ddd;  padding:0px 22px 7px 0; }
            .btn-cntnr { margin-bottom:10px }
            .row [class^='col-md-'], .row [class^='col-lg-'] {
                min-height: 1px;
                padding-left:0px;
                padding-right:0px;
            }
        </style>

        <link href="<?php echo base_url().'mobile-menu/vertical/demo.css'; ?>" rel="stylesheet">
        <link href="<?php echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.css'; ?>" rel="stylesheet">
        <link href="<?php echo base_url().'css/responsive.css'; ?>" rel="stylesheet">
        <link href="<?php echo base_url().'css/logout/popModal.css'; ?>" rel="stylesheet">

        <!--[if IE]>
            <link rel="stylesheet" type="text/css" href="all-ie-only.css" />
        <![endif]-->
         <!--[if lt IE 9]>
        <script src="dist/html5shiv.js"></script>
        <![endif]-->

        <style type="text/css">
            body {
                scrollbar-base-color: #222;
                scrollbar-3dlight-color: #222;
                scrollbar-highlight-color: #222;
                scrollbar-track-color: #3e3e42;
                scrollbar-arrow-color: #111;
                scrollbar-shadow-color: #222;
                scrollbar-dark-shadow-color: #222; 
                -ms-overflow-style: -ms-autohiding-scrollbar;  
            }
            .form-control { padding:6px!important;  }
            body{ overflow:initial; }
            .fonts {
                font-size:35px; 
                text-align: center;
                width: 60px;
                line-height: 48px;
            }
            .x-navigation {overflow-x: hidden;}
            .x-navigation li > a .fa, .x-navigation li > a .glyphicon  {font-size: 20px;}
            .left-menu {  }
            .left-menu li .fa{ font-size: 16px!important; padding-right:15px; }
            .left-menu li .glyphicon { font-size: 16px!important; padding-right:15px;  }
            .left-menu li .glyphicon { font-size: 16px!important; }
            .left-menu li:hover{ background: #23303b!important;}
            .scroller .x-navigation ul li { display: inline-block!important; visibility: visible!important; }
            .x-navigation.x-navigation-horizontal { float:none!important; left: 0;  position: fixed; overflow:hidden; }
            .x-navigation { float: none!important }
            .menu-wrapper { top:61px;
                background-image: linear-gradient(to top, #05131f 0%, #13202c 23%, #33414e 100%);
            }
            .menu-wrapper ul { background: none!important }
            .menu { background: none!important }
            #ng-toggle {
                position: fixed;
            }
            .menu-wrapper ul li a span {opacity: 1;}
            .menu-wrapper .menu--faq {
                position: absolute;  
                left: 0;     text-shadow: 0px 1px 1px #000;
                bottom: 0;  line-height: 50px;
                z-index: 99999;
                width: 240px; 
            }
            .menu--faq  li { font-size: 1rem; }
            .gn-icon .icon-fontello:before {
                font-size: 20px;
                line-height: 50px;
                width: 50px;
            }
            .fa-sign-out {   }
            #edit{  display: inline-block; padding: 0 5px; cursor:pointer;    }
            .text-info { color:#fff!important; display: inline-block; line-height: 20px; }
            .grp_change{ display: none; }
            .menu-wrapper .scroller {
                position: absolute;
                overflow-y: scroll;
                width: 240px;
                height:80%;
            }

            .header-fixed-style {  width: 100%;  height: 61px; left:0;   position: fixed; background:#245478!important;   z-index: 999; display:block;   }
            .logo-container { width:200px;  float:left; background:#fff; text-align:center; padding:6px 0;}

            .useremail-container {width:300px; float:left;}
            .useremail-container a { font-size:18px; color:#fff; padding:15px 10px; display: block;}
            .dropdown-selector { width:35%; float:right;   display:block; tex-align:right;}
            .dropdown-selector-left    { font-size:18px; color:#fff; padding:10px 19px;  display: block; float:right;     text-align: right;}
            .useremail-login { font-size:12px; color:#fff; display: block;}
            .useremail-login:hover{color:#fff; } 
            .logout-section { float:right; display:block;  }
            .logout-section a { color:#fff; font-size:25px;  padding:13px 15px;  display: block;  float:left; border-left:1px solid #0d3553;  }
            .logout-section a:hover { background:#0d3553!important; color:#fff;}

            ::-webkit-scrollbar {
                width: 0.5em;
                height: 0.5em;
            }
            ::-webkit-scrollbar-button:start:decrement,
            ::-webkit-scrollbar-button:end:increment  {
                display: none;
            }
            ::-webkit-scrollbar-track-piece  {
                background-color: #ccc;
                -webkit-border-radius: 6px;
            }
            ::-webkit-scrollbar-thumb:vertical {
                -webkit-border-radius: 6px;
                background: #072c48 url("<?php echo base_url().'img/scrollbar_thumb_bg.png';?>") no-repeat center;
            }
            ::-webkit-scrollbar-thumb:horizontal {
                -webkit-border-radius: 6px;
                background: #072c48 url("<?php echo base_url().'img/scrollbar_thumb_bg.png';?>") no-repeat center;
            } 
            ::-webkit-scrollbar-track, 
            ::-moz-scrollbar-track, 
            ::-o-scrollbar-track{
                box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                -o-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                border-radius: 10px;
                background-color: #F5F5F5;
            } 
            .vertical_nav .bottom-menu-fixed {
                position: absolute;
                background:#245478!important;      border-top: 1px solid #0d3553;
                top: 90%!important;
                width: 100%;
                margin: 0;
                padding: 0;
                list-style-type: none;
                z-index: 0;
            }
            .toggle_menu {
                display: none;
            }
            @media only screen and (max-width: 991px){
                .toggle_menu {
                    display: block;
                    float: left;
                    padding:16px 10px; 
                    color: #fff; cursor:pointer;
                }
            }
            @media screen and (max-width:320px) {.vertical_nav .bottom-menu-fixed { top: 79.2%!important; } }
            @media only screen and (min-width:321px) and (max-width:360px) {.vertical_nav .bottom-menu-fixed {  top: 82.2%!important;}  }
            .vertical_nav__minify .menu--subitens__opened span {
                cursor:default;
            }
        </style>
    </head>
    <body>
        <div class="page-container page-navigation-top">
            <div class="scrollbar" id="style-1">
                <div class="force-overflow"></div>
            </div>

            <?php $this->load->view('templates/menus1');?>

            <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                <!-- <div class="header-fixed-style">
                    <div class="logo-container">
                        <a class="gn-icon-menu" href="#"> 
                            <img height="50" style=" " src="<?php //echo base_url().'img/logo-icon.png';?>"   /> 
                            <img src="<?php //echo base_url().'img/pecan-logo.png';?>"  height="45" style="margin-left:10px;"  />                
                        </a>
                    </div>
                    <div class="toggle_menu"  id="toggleMenu">  <i class="fa fa-arrows-alt" aria-hidden="true"></i> </div>
                    <div class="dropdown-selector">
                        <div class="logout-section">
                            <a class="fa-edit-btn " id="mbl-grp_change" href="javascript:void(0);"> <i class="fa fa-edit" aria-hidden="true"></i><span class="xn-text"> </span></a>
                            <a href="#"  id="confirmModal_ex2" class="  top-sign" data-confirmmodal-bind="#confirm_content1"><span class="fa fa-sign-out"></span></a>    
                        </div>
                        <div class="dropdown-selector-left">
                            <span class="xn-text  text-info">
                                <?php //if (isset($userdata['groupname'])) {if ($userdata['groupid']!='0') echo $userdata['groupname']; else echo 'Software Developer';} else echo 'Software Developer';?>
                            </span>
                            <span class="useremail-login" href="" style="">
                                <span class="xn-text"><?php //if (isset($userdata['username'])) {echo $userdata['username'];} ?></span>
                            </span>
                        </div>
                    </div>
                </div> -->

                <!-- <nav class="vertical_nav">
                    <ul id="js-menu" class="menu mCustomScrollbar">
                        <li class="menu--item">
                            <a class="menu--link" href="<?php //echo base_url().'index.php/dashboard'; ?>">  
                                <i class="menu--icon  fa fa-fw fa-tachometer"></i>
                                <span class="menu--label">iData</span>
                            </a>
                        </li>
                        <li class="menu--item">
                            <a class="menu--link" href="<?php //echo base_url().'index.php/dashboard'; ?>">  
                                <i class="menu--icon  fa fa-fw fa-tachometer"></i>
                                <span class="menu--label">Assure</span>
                            </a>
                        </li>
                    </ul>

                    <ul id="js-menu" class="menu bottom-menu bottom-menu-fixed" style="background: #fcfdfd!important;">
                        <li class="menu--item">
                            <a href="<?php //echo base_url().'index.php/login/assure'; ?>" class="menu--link" title="Assure" target="_blank">
                                <img style="" src="<?php //echo base_url().'img/assure.png';?>" />
                            </a>
                        </li>
                    </ul>
                </nav> -->

                <div class="heading-h2"> 
                    Home
                </div>
                <div class="page-content-wrap">
                    <div class="row main-wrapper">
                        <div class="main-container">
                            <div class="col-md-12"  >
                                <div class="panel panel-default">
                                    <form id="form_confirm_details" method="post" action="<?php echo base_url()?>index.php/Dashboard/confirm_details">
                                    <div class="panel-body">
                                        <div class="form-group" style="float: left; width: 100%;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">First Name *</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php if(isset($contact_details)){ echo $contact_details[0]->c_name; } ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">Last Name *</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control " name="last_name" placeholder="Last Name" value="<?php if(isset($contact_details)){ echo $contact_details[0]->c_last_name; } ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: left; width: 100%;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">Email Address *</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="email_id" placeholder="Email Address" style="background-color: white; color: #245478; border: none;" value="<?php if(isset($contact_details)){ echo $contact_details[0]->c_emailid1; } ?>" required readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">Contact Number *</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control " name="contact_number" placeholder="Contact Number" value="<?php if(isset($contact_details)){ echo $contact_details[0]->c_mobile1; } ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: left; width: 100%;">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">Group Name *</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="group_name" placeholder="Group Name" value="<?php if(isset($user_details)){ echo $user_details[0]->group_name; } ?>" required/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="col-md-4">
                                                <div class="">
                                                    <label class="col-md-4 control-label">Do You want maker checker? *</label>
                                                    <div class="col-md-8">
                                                        <input type="radio" class="" name="maker_checker" value="yes" required <?php if(isset($user_details)){ if($user_details[0]->maker_checker=='yes') echo 'checked'; } ?> /> Yes &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="" name="maker_checker" value="no" required <?php if(isset($user_details)){ if($user_details[0]->maker_checker=='no') echo 'checked'; } ?> /> No
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="float: left; width: 100%;">
                                            <div class="col-md-10">
                                                <input type="submit" class="btn btn-success pull-right" value="Submit" />
                                            </div>
                                        </div>
                                        <!-- <div class="">
                                            <div class="col-md-12 btn-container">
                                                <div class="pull-left"> 
                                                    <input type="submit" class="btn btn-success pull-left" value="Submit" />
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('templates/footer');?>

        <!-- <script type="text/javascript" src="<?php //echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.js';?>"></script> -->
        <script>
            function myFunction() {
                var x = document.getElementById("myTopnav");
                if (x.className === "topnav") {
                    x.className += " responsive";
                } else {
                    x.className = "topnav";
                }
            }
        </script>
    </body>
</html>