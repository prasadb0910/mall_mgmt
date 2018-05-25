<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams – Property Management Tool Log In </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="Description" content="Get access to your real estate property management dashboard.">
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        <div class="login-container lightmode">
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Log In</strong> to your account</div>
                    <!-- <form id="form_login" action="<?php //echo base_url().'index.php/login/checkcredentials'; ?>" class="form-horizontal" method="post"> -->
                    <form id="form_login" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="E-mail" name="email" id="email" autofocus/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <!-- <span class="btn btn-link btn-block" id="forgot_password">Forgot your password?</span> -->
                                <label class="check"><input type="checkbox" name="remember" class="icheckbox" /> Remember Me</label>
                            </div>


                            <div class="col-md-6">
                                <button id="log_in" type="button" class="btn btn-info btn-block" data-modal-id="modal-otp">Log In</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="<?php echo base_url().'index.php/login/email'; ?>" class="btn-link btn-block pull-left">I forgot my password</a>
                            <a href="<?php echo base_url().'../register.php'; ?>" class="btn-link btn-block pull-left">Register a new membership</a>
                        </div>
                        
                        <!-- <div class="login-subtitle">
                            Don't have an account yet? <a href="#">Create an account</a>
                        </div> -->
                    </form>
                </div>
                <div class="login-footer">
                    <div class="pull-left">
                        &copy; 2016 Pecan
                    </div>
                    <div class="pull-right">
                        <a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-otp" tabindex="-1" role="dialog" aria-labelledby="modal-otp-label" aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h2 class="modal-title" id="modal-otp-label">OTP</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <form id="otp_form" role="form" action="#" method="post" autocomplete="off">
                                        <div class="form-group">
                                            <label for="otp" class="sr-only">OTP</label>

                                            <input type="text" name="otp" id="otp" class="form-control" style="border-color: initial;" placeholder="OTP..." data-error="#otp_error" autofocus>

                                            <div id="otp_error" class="text-danger"></div>
                                            <div id="otp_resend"></div>
                                        </div>
                                        <div class="">      
                                            <button type="button" id="btn_save" class="btn-link-1">Submit </button>
                                            <a id="resend_otp" style="float:right; cursor:pointer;">Resend OTP</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- START PLUGINS -->
        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/jquery-validation/jquery.validate.js'></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>js/login.js'></script>
        <!-- END PLUGINS-->
        
        
    </body>
</html>