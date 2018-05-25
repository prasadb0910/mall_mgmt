<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="<?php echo base_url(); ?>image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>mobile-menu/vendor-1437d0659c.css"/>
		<!--[if lt IE 9]>
        <script src="dist/html5shiv.js"></script>
        <![endif]-->
        <!-- EOF CSS INCLUDE -->

        <style>
            .page-content page-overflow { height:auto!important;}
            .page-container .page-content .page-content-wrap { background:#fff;  margin:0px; width: auto!important; float: none;   }
            .dataTables_filter { border-bottom:0!important; }
            .heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: block;  margin-top: 61px; border-bottom:1px solid #d7d7d7; font-size:14px;  }
            .heading-h2 a{  color: #444;      }
            /*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
            font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
            border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
            .nav-contacts {/* float: right; width: 55%;*/ }
            .main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
            .main-container {margin:0 12px; } 
            h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
            .col-md-12 {}
            .full-width {
                margin-top: 20px; display:inline-block;
                background: #fff;
                padding: 15px 25px;
                box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px;	

            }
            .dropdown-toggle{
                background: none !important;
                color: #53ad53 !important;
                border-color: #53ad53 !important;
            }
            .dropdown-toggle:hover {
                background: #53ad53 !important;
                color: #fff !important;
            }
            .table thead tr th { padding:8px 5px!important; font-weight:600; }
            b, strong {
                font-weight:500;
            }
            .page-overflow { overflow:auto; }
            .panel { margin-bottom:0;}
            .nav-contacts { /*margin-top:-40px;*/ float:right;}
            /*------------------------------------------*/

            .m-nav>li a,.m-nav--linetriangle>li a{display:inline-block;border-radius:0; padding:0px 20px 6px;margin-right:0;font-family:"Montserrat", "TenantCloud Sans", Avenir, sans-serif;font-weight:400;color:rgba(98,98,98,0.7);font-size:0.875rem;min-width:70px;text-transform:uppercase;border-color:transparent}
            .dataTables_scrollHeadInner {width:auto!important: padding:0!important;}

            /*-----------------------------*/
            .dataTables_scrollHead {  border-right:1px  solid #ddd!important;}
            .dataTables_scrollBody {   border-bottom:1px  solid #ddd!important;  }
            .responsive-table-bordered tr th:first-child{ width:45px!important;  text-align:center;} 
            .responsive-table-bordered tr th:nth-child(2){ width:222px!important; } 
            .responsive-table-bordered tr th:nth-child(3){ width:72px!important; } 
            .responsive-table-bordered tr th:nth-child(4){ width:72px!important; } 
            .responsive-table-bordered tr th:nth-child(5){ width:75px!important; } 
            .responsive-table-bordered tr th:nth-child(6){ width:75px!important; } 
            .responsive-table-bordered tr th:nth-child(7){ width:70px!important; } 
            .responsive-table-bordered tr th:nth-child(8){ width:90px!important; } 
            .responsive-table-bordered tr th:nth-child(9){ width:65px!important; } 
            .responsive-table-bordered tr th:nth-child(10){ width:95px!important; } 
            .responsive-table-bordered tr th:last-child { width:60px!important;   text-align:center;} 



            .responsive-table-bordered tr td:first-child{ width:34.8px!important;} 
            .responsive-table-bordered tr td:nth-child(2){ width:211px!important;} 
            .responsive-table-bordered tr td:nth-child(3){ width:62px!important;} 
            .responsive-table-bordered tr td:nth-child(4){ width:63px!important;} 
            .responsive-table-bordered tr td:nth-child(5){ width:65px!important;} 
            .responsive-table-bordered tr td:nth-child(6){ width:64px!important;} 
            .responsive-table-bordered tr td:nth-child(7){ width:60px!important;} 
            .responsive-table-bordered tr td:nth-child(8){ width:80px!important;} 
            .responsive-table-bordered tr td:nth-child(9){ width:53px!important;} 
            .responsive-table-bordered tr td:nth-child(10){ width:86px!important;} 
            .responsive-table-bordered tr td:last-child { width:59px!important;  text-align:center;} 

            *--------------*/


            /*-----------------------------*/

            .responsive-cashflow-table thead tr th:first-child{   text-align:center;     width: 53px!important;} 
            .responsive-cashflow-table thead tr th:first-child { width:52px!important;}
            .responsive-cashflow-table thead tr th:nth-child(2){ width:215px;} 
            .responsive-cashflow-table thead tr th:nth-child(3){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(4){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(5){ width:155px;} 
            .responsive-cashflow-table thead tr th:nth-child(6){ width:76px;} 
            .responsive-cashflow-table thead tr th:nth-child(7){ width:85px;} 
            .responsive-cashflow-table thead tr th:nth-child(8){ width:70px;} 
            .responsive-cashflow-table thead tr th:nth-child(9){ width:90px;} 

            .responsive-cashflow-table tr th:last-child { width:60px;  text-align:center;} 



            .responsive-cashflow-table tr td:nth-child(1){ width:33px;} 
            .responsive-cashflow-table tr td:nth-child(2){ width:170px; } 
            .responsive-cashflow-table tr td:nth-child(3){ width:52.8px;} 
            .responsive-cashflow-table tr td:nth-child(4){ width:53px;} 
            .responsive-cashflow-table tr td:nth-child(5){ width:122px;} 
            .responsive-cashflow-table tr td:nth-child(6){ width:58.8px;} 
            .responsive-cashflow-table tr td:nth-child(7){ width:66px;} 
            .responsive-cashflow-table tr td:nth-child(8){ width:54px;} 
            .responsive-cashflow-table tr td:nth-child(9){ width:69px;} 

            .responsive-cashflow-table tr td:last-child { width:49px;  text-align:center;} 

            *--------------*/


            .dataTables_scroll {/* overflow-x:scroll!important;*/ width:100%; }
            .fa-search { font-size:22px; text-align:center;      padding:5px 2px; color:#072c48; font-weight:100; }
            @media only screen and (max-width: 800px){
                .nav-contacts { display:none!important}

                ul.topnav li a {  padding:15px 32px!important;}
                ul.topnav {
                    display: block!important; width:100%!important;
                }
            } 

            .items
            {
                height:120px; width:120px;
                margin:0 auto;
                padding:10px;
            }
            .items img
            {
                width:100%

            }
            .widget-c3 
            {
                background: rgba(0, 0, 0, 0.15);
                text-align: center;
                margin-top:-10px;

            }

            .widget-c3 a
            {
                color:#000!important;
                font-size:14px!important;
            }

            .widget.widget-padding-sm, .widget.widget-item-icon {
                padding: 10px 0px 0px;
            }
          
            
			panel.panel-info {
    border-top-color: #3c8dbc!important;;
}

.panel {
   
    border-radius: 3px!important;

    border-top: 3px solid #3c8dbc!important;;

}


            @font-face {
                font-family: 'seguibl';
                src: url('fonts/seguibl.eot');
                src: local('seguibl'), url('fonts/seguibl.woff') format('woff'), url('fonts/seguibl.ttf') format('truetype');
            }

            @font-face {
                font-family: 'seguibl';
                src: url('<?php echo base_url(); ?>fonts/seguibl.eot');
                src: local('seguibl'), url('<?php echo base_url(); ?>fonts/seguibl.woff') format('woff'), url('<?php echo base_url(); ?>fonts/seguibl.ttf') format('truetype');
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
			<div class="page-content-wrap">
                    <div class="row  main-wrapper">
                <div class="row" style="margin-top:80px;">
                    
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/dashboard'; ?>">
                                <div class="img" style="text-align:center;margin-bottom:15px;margin-top:25px;"> <img src="<?php echo base_url(); ?>img/main-logo.png"></div>
                            </a>
                            <div class="widget-buttons widget-c3"  style="background: rgba(0, 0, 0, 0.15);">
                                <a href="<?php echo base_url().'index.php/dashboard'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
                            </div>                            
                        </div>    
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/login/idata'; ?>">
                                <div class="img" style="text-align:center;margin-bottom:21px;margin-top:21px;"> <b style="font-family:'seguibl' !important;font-size:34px;text-align:center; color: rgb(40, 55, 122)!important;">iDATA</b></div>
                            </a>
                            <div class="widget-buttons widget-c3">
                                <a href="<?php echo base_url().'index.php/login/idata'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/login/assure'; ?>">
                                <div class="img" style="text-align:center;margin-bottom:25px;margin-top:25px;" > <img src="<?php echo base_url(); ?>img/assure.png"></div>
                            </a>
                            <div class="widget-buttons widget-c3" >
                                <a href="<?php echo base_url().'index.php/login/assure'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
                            </div>
                        </div>
                    </div>
              
                </div>
     

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><span class="fa fa-comments"></span>Blogs</h3>
                        </div>
                        <div class="panel-body list-group list-group-contacts">                                
                            <a href="#" class="list-group-item">
                                <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" class="pull-left" alt="Brad Pitt"/>
                                <span class="contacts-title">Brad Pitt</span>
                                <p>Actor and Film Producer</p>
                            </a>
                            <a href="#" class="list-group-item">
                                <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" class="pull-left" alt="Dmitry Ivaniuk"/>
                                <span class="contacts-title">Dmitry Ivaniuk</span>
                                <p>Web Developer/Designer</p>
                            </a>                                
                            <a href="#" class="list-group-item">
                                <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" class="pull-left" alt="Nadia Ali"/>
                                <span class="contacts-title">Nadia Ali</span>
                                <p>Singer-Songwriter</p>
                            </a>                                                                
                            <a href="#" class="list-group-item">
                                <img src="http://www.gravatar.com/avatar/88b87698be0bc461f3cacf1f080929d5.jpg?s=80&d=mm&r=g" class="pull-left" alt="John Doe"/>
                                <span class="contacts-title">John Doe</span>
                                <p>UI/UX Designer</p>
                            </a>
                        </div>
                      
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"></span> Newsletters</h3>
                        </div>
                        <div class="panel-body">
                            <div class="messages messages-img">
                                <div class="items" >
                                    <img src="<?php echo base_url(); ?>img/Newsletter.png">
                                </div>         
                                <h2 style="padding:10px;text-align:center;">Sign Up</h2>
                                <p style="margin-left:10px;margin-right:10px;">
                                    Sign up to our newsletter and get exclusive deals you wont find anywhere else straight to your inbox!
                                </p>
                            </div>
                            <br>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>

        <?php $this->load->view('templates/footer');?>
    </body>
</html>