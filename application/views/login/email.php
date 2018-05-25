<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>
        <title>Pecan Reams</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-default.css"/>
    </head>
    <body>
        <div class="login-container lightmode">
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>

                <?php if(isset($success)) { ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <?php echo $success; ?>
                    </div>
                <?php } ?>

                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>

                <div class="login-body">
                    <div class="login-title">Reset Password</div>
                    <form id="form_login_email" class="form-horizontal" action="<?php echo base_url().'index.php/login/email_link'; ?>" method="post">
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="E-mail" name="email" id="email" autofocus/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-2">
                            </div>
                            <div class="col-xs-8">
                                <button type="submit" class="btn btn-info btn-block">Send Password Reset Link</button>
                            </div>
                            <div class="col-xs-2">
                            </div>
                        </div>

                        <div class="form-group">
                            <a href="<?php echo base_url().'index.php/login'; ?>" class="btn-link btn-block pull-left">Log in</a>
                            <a href="<?php echo base_url().'../register.php'; ?>" class="btn-link btn-block pull-left">Register a new membership</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            var BASE_URL="<?php echo base_url()?>";
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>js/plugins/jquery-validation/jquery.validate.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>
    </body>
</html>