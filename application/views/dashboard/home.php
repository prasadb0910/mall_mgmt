<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
	<style>
	.widget-c3 {
    background: rgba(0, 0, 0, 0.15);
    text-align: center;
    margin-top: 0px;
    padding: 6px;
}
 .widget {
    width: 100%;
    float: left;
    margin: 0px;
    list-style: none;
    text-decoration: none;
    -moz-box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);
 
    box-shadow: 0px 1px 1px 0px rgba(0, 0, 0, 0.2);
    color: #FFF;
    -moz-border-radius: 0px;

    border-radius: 0px;

    margin-bottom: 20px;
    min-height: 120px;
    position: relative;
}
            .widget-c3 
            {
                background: rgba(0, 0, 0, 0.15);
                text-align: center;
                margin-top:-10px;

            }
.widget .widget-buttons {
    float: left;
    width: 100%;
    text-align: center;
    padding-top: 3px;
    margin-top: 5px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}
            .widget-c3 a
            {
                color:#000!important;
                font-size:14px!important;
            }

            .widget.widget-padding-sm, .widget.widget-item-icon {
                padding: 10px 0px 0px;
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
   <body class="fixed-header">
<?php $this->load->view('templates/sidebar1');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>


<div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>


</ol>

<div class=" container-fluid   container-fixed-lg">
                    <div class="row">
              
                    
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/dashboard'; ?>">
                                <div class="img" style="text-align:center;height:80px;padding-top:12px"> <img src="<?php echo base_url(); ?>img/main-logo.png"></div>
                            </a>
                            <div class="widget-buttons widget-c3"  style="background: rgba(0, 0, 0, 0.15);">
                                <a href="<?php echo base_url().'index.php/dashboard'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
                            </div>                            
                        </div>    
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/login/idata'; ?>">
                                <div class="img" style="text-align:center;height:80px;padding-top:22px"> <b style="font-family:'seguibl' !important;font-size:34px;text-align:center; color: rgb(40, 55, 122)!important;">iDATA</b></div>
                            </a>
                            <div class="widget-buttons widget-c3">
                                <a href="<?php echo base_url().'index.php/login/idata'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-info widget-padding-sm" style="background:#fff!important;" >
                            <a href="<?php echo base_url().'index.php/login/assure'; ?>">
                                <div class="img" style="text-align:center;height:80px;padding-top:22px" > <img src="<?php echo base_url(); ?>img/assure.png"></div>
                            </a>
                            <div class="widget-buttons widget-c3" >
                                <a href="<?php echo base_url().'index.php/login/assure'; ?>">Get Started <span class="fa fa-arrow-circle-right"></span></a>
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
 <script type="text/javascript">
 $(document).ready(function(){
   $('#edit').click(function() {
    $('.text-info').hide();
	$('#edit').hide();
	$('.useremail-login').hide();
    $('.grp_change').show();
 
 });
   $('#mbl-grp_change').click(function() {
  
    $('.grp_change').show();
 
 });
 $('.grp_change').mouseleave(function() {
setTimeout(function(){
    $('.text-info').show();
	$('#edit').show();
	$('.useremail-login').show();
    $('.grp_change').hide();
 }, 3000);
 
 });
 });
 
 
 


 </script>


    </body>
</html>