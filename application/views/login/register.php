<!DOCTYPE html>
<?php $base_url=""?>
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
                    <div class="login-title"><strong>Register</strong>  a new membership</div>
                    <!-- <form id="form_login" action="<?php //echo base_url().'index.php/login/checkcredentials'; ?>" class="form-horizontal" method="post"> -->
                  <form id="form_registration" class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="<?php if(isset($_SESSION["otp"])) echo 'display: none;'; ?>" autocomplete="off">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Owner Name" name="owner_name" id="owner_name"  value="<?php if(isset($_POST["owner_name"])) echo $_POST["owner_name"]; ?>" required autofocus/>
                            </div>
                        </div>
						
						    <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Mall Name" name="mall_name" id="mall_name" value="<?php if(isset($_POST["mall_name"])) echo $_POST["mall_name"]; ?>" required />
                            </div>
							</div>
							
						<div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="No.Of Units" name="no_of_units" id="no_of_units" value="<?php if(isset($_POST["no_of_units"])) echo $_POST["no_of_units"]; ?>" required />
                            </div>
						</div>
						
                     
						
							<div class="form-group">
                            <div class="col-md-12">
                                <input type="email" class="form-control" placeholder="Email ID" name="email" id="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
                            </div>
							</div>
							
							<div class="form-group">
                            <div class="col-md-12">
                               <input type="text" class="form-control" name="mobile" placeholder="Mobile No." value="<?php if(isset($_POST["mobile"])) echo $_POST["mobile"]; ?>" pattern="[789][0-9]{9}" required/>
                            </div>
							</div>
						<div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>" pattern=".{8,}" title="Six or more characters" required onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.confirm_password.pattern = RegExp.escape(this.value);"//>
                            </div>
                        </div>
						<div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Confirm Password"  name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php if(isset($_POST["confirm_password"])) echo $_POST["confirm_password"]; ?>" pattern=".{8,}" title="Password does not match" required onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/>
                            </div>
						</div>
						
							
						
						<div class="form-group">
                            <div class="col-md-6">
                                <!-- <span class="btn btn-link btn-block" id="forgot_password">Forgot your password?</span> -->
                                <label class="check"><input type="checkbox" name="remember" class="icheckbox" /> Remember Me</label>
                            </div>


                            <div class="col-md-6">
                                <button id="log_in" type="button" class="btn btn-info btn-block" data-modal-id="modal-otp">Register</button>
                            </div>
                        </div>

                      <!--   <div class="form-group">
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