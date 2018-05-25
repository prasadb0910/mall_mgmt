<!DOCTYPE html>

<html class="no-js  " lang="en-US">
<?php
// See the password_hash() example to see where this came from.
// $hash = '$2y$10$LrtONCG2UEBu/dQ9Lzh/FuHdwRDFmWtQt8kWi1/43GPuvY0mC5rgS';

// if (password_verify('1234567890', $hash)) {
//     $result = 'Password is valid!';
// } else {
//     $result = 'Invalid password.';
// }
?>
<?php include('db.php') ?>
<?php
    if(isset($_POST["submit"])) {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $first_name=$_POST["first_name"];
        $last_name=$_POST["last_name"];
        $name=$first_name.' '.$last_name;
        $email=$_POST["email"];
        $mobile=$_POST["mobile"];
        // $password="pass@123";
        $password=$_POST["password"];
        // $main_group_name=$_POST["main_group_name"];
        // $display_group_name=$_POST["display_group_name"];
        $main_group_name=$email;
        $display_group_name=$main_group_name;
        $package=$_POST["package"];
        $module=$_POST["module"];
        $now = date("Y-m-d H:i:s");

        // $password=md5($password);
        $password=password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

        // $check=mysqli_query($conn,"select * from group_users where gu_email='$email' or gu_mobile='$mobile'");
        $check=mysqli_query($conn,"select * from group_users where gu_email='$email'");
        if($check){
            $checkrows=mysqli_num_rows($check);
        } else {
            $checkrows=0;
        }

        // $check=mysqli_query($conn,"select * from group_master where group_name='$main_group_name'");
        // if($check){
        //     $checkrows2=mysqli_num_rows($check);
        // } else {
        //     $checkrows2=0;
        // }

        if($checkrows>0) {
            $msg="<h5 id='msg1'>Email id Already Exists!! </h5>";
        // } else if($checkrows2>0) {
        //     $msg="<h5 id='msg1'>Group Name Already Exists!! </h5>";
        } else { 
            $otp = rand(100000,999999);

            $date = date("d M H:i");
            $sms = $date . "Dear%20".$first_name."%2C%20your%20login%20OTP%20is%20".$otp."%2E%20Please%20treat%20this%20as%20confidential%2E%20Sharing%20it%20with%20anyone%20gives%20them%20full%20access%20to%20your%20Pecan%20Reams%20account%2E%20Pecan%20Reams%20never%20calls%20to%20verify%20your%20OTP%2E";
            $sms = str_replace(' ', '%20', $sms);
            $sms = str_replace(':', '%3A', $sms);
            $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $surl);
            curl_exec($ch);
            curl_close($ch);

            if(!isset($_SESSION["name"])){
                session_start();
            }
            
            $_SESSION["first_name"] = $first_name;
            $_SESSION["last_name"] = $last_name;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["mobile"] = $mobile;
            $_SESSION["password"] = $password;
            $_SESSION["otp"] = $otp;
            $_SESSION["main_group_name"] = $main_group_name;
            $_SESSION["display_group_name"] = $display_group_name;
            $_SESSION["package"] = $package;
            $_SESSION["module"] = $module;
        }
    }
?>
<?php
    if(isset($_POST["verify"])) {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        session_start();
        // if(!isset($_SESSION["name"])){
        //     session_start();
        // }

        if($_SESSION["otp"]==$_POST["otp"]) {
            $first_name=$_SESSION["first_name"];
            $last_name=$_SESSION["last_name"];
            $name=$_SESSION["name"];
            $email=$_SESSION["email"];
            $mobile=$_SESSION["mobile"];
            $password=$_SESSION["password"];
            $main_group_name=$_SESSION["main_group_name"];
            $display_group_name=$_SESSION["display_group_name"];
            $package=$_SESSION["package"];
            $module=$_SESSION["module"];
            $now = date("Y-m-d H:i:s");

            $sql = "insert into group_master (group_name, group_status, create_date, created_by, modified_date, modified_by, display_group_name, verified, maker_checker) 
                    values ('".$main_group_name."', 'Active', '".$now."', '0', '".$now."', '0', '".$display_group_name."', 'yes', 'no')";
            mysqli_query($conn, $sql);
            $group_id = mysqli_insert_id($conn);

            $sql = "insert into contact_master (c_name, c_last_name, c_gid, c_emailid1, c_mobile1, c_status, c_createdate, c_createdby, c_modifieddate, c_modifiedby, c_type, c_owner_type) 
                    values ('".$first_name."', '".$last_name."', '".$group_id."', '".$email."', '".$mobile."', 'Approved', '".$now."', '0', '".$now."', '0', 'Owners', 'individual')";
            mysqli_query($conn, $sql);
            $contact_id = mysqli_insert_id($conn);

            $sql = "update group_master set created_by = '".$contact_id."' where g_id = '".$group_id."'";
            mysqli_query($conn, $sql);

            $sql = "insert into group_users (gu_gid,name,gu_email,gu_mobile,gu_password,gu_role,add_date,gu_cid,assigned_status,assigned_role,created_at,created_by,updated_at,updated_by,user_type,isVerified,assure) 
                    values ('".$group_id."','".$name."','".$email."','".$mobile."','".$password."','Admin','".$now."','".$contact_id."','Approved','1','".$now."','0','".$now."','0','owner','0','1') ";
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);

                $sql = "insert into users (name,email,mobile,password,isVerified) 
                        values ('".$name."','".$email."','".$mobile."','".$password."','0') ";
                mysqli_query($conn, $sql);

                // $check=mysqli_query($conn,"select * from group_users where gu_email='$email'");
                // $checkrows=mysqli_num_rows($check);
                // if($checkrows==0){
                //     $sql = "insert into group_users(name,gu_email,gu_mobile,gu_password,assigned_role,isVerified) 
                //             values ('".$name."','".$email."','".$mobile."','".$password."','2','0') ";
                //     mysqli_query($conn, $sql);
                //     $user_id = mysqli_insert_id($conn);

                //     $sql = "insert into users(name,email,mobile,password,isVerified) values ('".$name."','".$email."','".$mobile."','".$password."','0') ";
                //     mysqli_query($conn, $sql);
                // }

                session_unset();
                session_destroy();

                // header('Location: https://www.pecanreams.com/d3m/');
                // header("Location: dataform.php?package");
                // header("Location: http://localhost/prop_details/");
                // header('Location: http://localhost/prop_details/public/index.php/login');
                // header("Location: http://localhost/pecanreams/app/");
                // header("Location: ".$base_url."app/");

                //------------------- Mail After Registration ------------------------------------
                require 'PHPMailer/PHPMailerAutoload.php';
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                // try {
                    //Server settings
                    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'ssl://smtp.googlemail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = 'info@pecanreams.com';                 // SMTP username
                    $mail->Password = 'Info@003#';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('info@pecanreams.com', 'Pecan REAMS');
                    $mail->addAddress($email, $name);     // Add a recipient
                    // $mail->addAddress('ellen@example.com');               // Name is optional
                    $mail->addReplyTo('info@pecanreams.com', 'Pecan REAMS');
                    // $mail->addCC('ashwini.patil@pecanreams.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Welcome to Pecan REAMS';
                    $mail->Body = '<!DOCTYPE html>
                                    <html lang="en">
                                    <head>
                                        <meta charset="utf-8">
                                        <meta name="viewport" content="width=device-width, initial-scale=1">
                                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                                    </head>
                                    <body>
                                        <div class="container">
                                            <p>Hi '.$first_name.',</p>
                                            <p>
                                                Thank you for registering with Pecan REAMS.
                                            </p>
                                            <br><br>
                                            For any specific information, general feedback about the site or content, please feel free to write on info@pecanreams.com
                                            <br><br>
                                            Thanks,<br>
                                            Team Pecan REAMS
                                        </div>
                                    </body>
                                    </html>';
                    $mail->AltBody = 'Thank you for registering with Pecan REAMS.';

                    $mail->send();
                    // echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo 'Message could not be sent.';
                //     echo 'Mailer Error: ' . $mail->ErrorInfo;
                // }

                    $sms = "Hi%20".$first_name."%2C%20Thank%20you%20for%20registering%20with%20Pecan%20Reams%2E%20For%20feedback%20please%20feel%20free%20to%20write%20on%20info%40pecanreams%2Ecom%20or%20visit%20http%3A%2F%2Fwww%2Epecanreams%2Ecom";
                    $sms = str_replace(' ', '%20', $sms);
                    $sms = str_replace(':', '%3A', $sms);
                    $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, $surl);
                    curl_exec($ch);
                    curl_close($ch);
                //------------------- Mail After Registration ------------------------------------

                // header("Location: ".$base_url."/app/");

                $token = rand(100000,999999);
                $token = md5($token);

                $sql = "Insert into user_login_emails (user_id, email, token, isVerified) values ('$user_id', '$email', '$token', '0')";
                mysqli_query($conn, $sql);

                $url =  $base_url.'/app/index.php/login/get_dashboard/'.$token;
                header("Location: ".$url);

                // if($package==''){
                //     header("Location: ".$base_url."app/");
                // } else {
                //     // header("Location: dataFrom.htm?user_id=".$user_id."&sub_id=".$package."&trans_id=0&module=".$module);
                //     header("https://www.pecanreams.com/demo/dataFrom1.php?user_id=".$user_id."&sub_id=".$package."&trans_id=0&module=".$module);
                // }

                $msg= "<h5 id='msg'>Done Registration successfully!!</h5>";
            } else {
                $msg= mysqli_error($conn);
            }
        } else { 
            $msg="<h5 id='msg1'>OTP does not match!! </h5>";
        }
    }
?>
<?php
    if(isset($_POST["resend"])) {
        session_start();

        if(!isset($_SESSION["first_name"])){
            // session_start();
            header("Location: ".$base_url."/register.php");
        }

        $first_name=$_SESSION["first_name"];
        $last_name=$_SESSION["last_name"];
        $name=$_SESSION["name"];
        $email=$_SESSION["email"];
        $mobile=$_SESSION["mobile"];
        $password=$_SESSION["password"];
        $main_group_name=$_SESSION["main_group_name"];
        $display_group_name=$_SESSION["display_group_name"];
        $package=$_SESSION["package"];
        $module=$_SESSION["module"];

        $otp = rand(100000,999999);

        $date = date("d M H:i");
        $sms = $date . "Dear%20".$first_name."%2C%20your%20login%20OTP%20is%20".$otp."%2E%20Please%20treat%20this%20as%20confidential%2E%20Sharing%20it%20with%20anyone%20gives%20them%20full%20access%20to%20your%20Pecan%20Reams%20account%2E%20Pecan%20Reams%20never%20calls%20to%20verify%20your%20OTP%2E";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);

        $_SESSION["otp"] = $otp;

        $msg="<h5 id='msg1'>OTP Sent!! </h5>";
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link href="assets/images/favicon.png" rel="icon">
    <!--[if lt IE 9]>
    <script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/html5shiv.min.js"></script>
    <script src="http://prodo.create.rocks/wp-content/themes/prodo/assets/js/respond.min.js"></script>
    <![endif]-->
    <title>Pecan Reams – Register Your Real Estate Property Management Account</title>
    <meta name="Description" content="Get register on India’s best real estate property management service. Grow your business with enhance real estate market analysis and expertise.">
    <link rel='dns-prefetch' href='https://maps.google.com' />
    <link rel='dns-prefetch' href='https://fonts.googleapis.com' />
    <link rel='dns-prefetch' href='https://s.w.org' />

    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
        .xdebug-error {display: none;}
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel='stylesheet' id='roboto-css'  href='https://fonts.googleapis.com/css?family=Roboto%3A300%2C400%2C400italic%2C500%2C500italic&#038;ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='open-sans-css'  href='https://fonts.googleapis.com/css?family=Open+Sans%3A300%2C300italic%2C400%2C400italic%2C600%2C600italic%2C700%2C700italic&#038;ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='bootstrap-css'  href='assets/bootstrap/css/bootstrap.min.css?ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='font-awesome-css'  href='assets/css/plugins/font-awesome.min.css?ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='isotope-css'  href='assets/css/plugins/isotope.min.css?ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='style-css'  href='assets/css/style.min.css?ver=2.1' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-style-css'  href='style.css?ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet' id='responsive-css'  href='assets/css/responsive.min.css?ver=4.6.1' type='text/css' media='all' />
    <link rel='stylesheet'   href='assets/css/login-min.css' type='text/css' media='all' />
    <link rel='stylesheet'   href='assets/css/login.css' type='text/css' media='all' />
    <!--[if lt IE 9]>
    <link rel='stylesheet' id='oldie-css'  href='assets/css/oldie.min.css?ver=4.6.1' type='text/css' media='all' />
    <![endif]-->

    <style type="text/css">
        .recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}
        .services { display:flex;}
        #benefits{  }
        #benefits.container{ display:flex;}
        #flip-key { padding:10px   20px;     min-height: 234px; border-right:1px dashed #ddd;  border-bottom:1px dashed #ddd;
          position:relative!important;       transform-style: flat!important;  background:#fff;    text-align: left!important; 
          z-index: 0!important;   flex:1; box-sizing:border-box;   
          font-size:14px;
        }
        #flip-key:nth-child(1) {  padding-left:0;}
        #flip-key:nth-child(3) { border-right:0px dotted #ddd;}
        #flip-key:nth-child(4) {   border-bottom:0px dotted #ddd; padding-left:0; padding-top:20px;}
        #flip-key:nth-child(5) {   border-bottom:0px dotted #ddd;  padding-top:20px;}
        #flip-key:nth-child(6) { border-right:0px dotted #ddd; border-bottom:0px dotted #ddd;  padding-top:20px;}
        #flip-this {
          position:relative!important;       transform-style: flat!important;  background:none;    text-align: center!important; 
          padding-left:0!important;  padding-right:0!important;    z-index: 0!important;   flex:1; box-sizing:border-box;  
          border-right:1px dashed #ddd;  border-bottom:1px dashed #ddd;
        }
        #flip-this:nth-child(3) { border-right:0;}
        .four-hover, .five-hover , .six-hover{ border-bottom:0!important;}
        #features h2 {    text-align: center;     position: relative; color:#fff;  }
        #flip-this p {  padding:15px 30px;  font-size:17px; color:#fff; }
        #flip-this h4 {  color:#fff; font-weight:100!important; text-transform:capitalize; letter-spacing:.5px!important; text-shadow:3px 2px 3px rgba(0,0,0,.3); }
        /*#flip-this:hover { background:#2185c5; color:#fff;}*/
        #flip-this img {

        }
        .front {  }
        #flip-this .back {
            text-align: center;
            position:relative!important;
        }

        /*.service-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}*/
        .offsetTopSs { padding-top:45px;}

        .offsetBottomSs { padding-bottom:55px;}
        .frame-container-video{width:85%; margin:auto;}
        .frame-container{width:85%; margin:auto;}
        .embed-container {     position: absolute;     top: 109px;    /* width: 300px; */    left: 113px;    /* padding: 0; */ margin: 0;}

        .image-slider p {
            position: absolute;
            bottom: -10px;
            background: rgba(0,0,0,.5);
            width: 100%;
            padding: 10px;
            color: #fff;
            font-size: 18px;
            text-align: center;}
        .image-slider img{/* width:520px;  height:325px;*/ }	
        @media only screen and (max-width:767px){ 
            .width-large{display:none!important;}
            #solution h4 { visibility:hidden; margin:0;}
            .width-small { text-align:center;   display:block!important; clear:both;     padding: 30px 0 0;}
            .width-small a { margin:5px;}
        }
    </style>

    <style>
        .footer-bottom {
            background-color: #191818; font-size:12px;
            width: 100%; padding:5px 0;
        }
        .copyright {
            color: #ccc;    text-align: right;
        }
        .design {
            color: #fff;


            text-align: left;
        }
        .design a {
            color: #fff;
        }

        /*------------------*/
        footer .housing-line {
         padding: 13px 0 0 0;
         display: inline-block;
         

         -webkit-box-sizing: border-box;
         -moz-box-sizing: border-box;
         box-sizing: border-box;
        }
        footer .housing-line img { height:88px;}
        .footer .footer-logo-coloured {
          /*  height: 87px;
            background-image: url(assets/images/main-logo.png); 
            width: 167px;*/
            display: inline-block;
            background-size: contain;
            background-position: left;
            background-repeat: no-repeat;
            margin-bottom: 4px;
        }

        .footer .desc {
            color: #7f7f7f;
            font-size: 11px;
            line-height: 22px;
        }
        .footer .footer-header {
            color: #000;
            height: 35px;  
            font-weight: 500;
            font-size: 16px;
        }



        .footer .footer-header .footer-text {
            display: inline-block; text-transform:uppercase;
            font-weight:900; color:#fff; 
            letter-spacing:1px;
            font-size: 12px;
        }
        #portfolio-details h4 { font-weight:400; font-size:25px; margin:5px 0;}
        #portfolio-details h5 { font-weight:400; font-size:20px; margin:5px 0; }
        .spacing-top1 { padding-top:80px;}
        .spacing-top { padding-top:50px;}
        .spacing-bottom { padding-bottom:50px;}
        @media only screen and (max-width:380px){
            .image-slider p { padding:5px; font-size:14px;}
        }
        .login-overlay { position:fixed; top:0; left:0; bottom:0; right:0; background:rgba(0,0,0,.6);display:none;  z-index:9999;}
        .login-box { background:#fff; width:100%; max-width:480px; min-height:250px; margin:auto; display:none;}
        .width-small { display:none;}
        .width-large {     padding: 69px 0 0; text-align:center;} 
        .width-large a {  font-size:17px; }
        /*--------------form style------------->

         </style>
        <style>
        #embed-video {
        position: fixed; overflow:hidden;	
            top: 0;
            left: 0;
            right: 0;
           bottom:0;
            z-index: 999999;
        	}
        	
        	.close-video {
        	position: fixed;
            z-index: 999999;
            color: #000;
            right: 60px;
        	}
        	/*----------------*/


            .single-about-detail {
                position: relative;
                margin-bottom: 50px;
            }	
            .about-img img {
             /* height: 206px;*/
         }
         .about-img img {
            width: 100%;
        }
        .about-img img {
            width: 100% !important;
            height:250px!important

        }

        .about-details {
            background: #eee;
            border-top:0px solid #fff;
            transition: all .7s ease 0s;
            -webkit-transition: all .7s ease 0s;
            -moz-transition: all .7s ease 0s;
            -o-transition: all .7s ease 0s;
            -ms-transition: all .7s ease 0s;
        }
        .about-details {
            /*min-height:260px;*/
        }
        body#home-page #main .container #where-to-buy-callout h3 {
            font-size: 20px;
        }
        body#home-page #main .container #where-to-buy-callout h3 {
            font-size: 15px;
            padding: 30px 0 10px 0;
            color: #7d4225;
        }
        .single-about-detail h3 {
            color: #000 !important;
            font-size:20px !important; padding:0 20px;
            line-height: 30px;
            text-transform: capitalize;
            font-weight: 400;
        }




        .single-about-detail p {
            color: #000 !important;  line-height:26px;

        }
        .about-details p {

            padding: 0 28px;
            padding-bottom: 30px;
        }


        .btn-read {
           /* position: absolute;
            bottom: 10px;  
            left:30%;  */

            display: block;
            margin: auto;
          /*  width: 132px;
          margin-top: -18px;*/
        }
        .btn-width {   margin: auto;  width: 132px; display:block;   padding-bottom: 16px;}

        .text-center #share-title {
            text-align:center!important;
            color: #333!important;
            padding:0;
        }

        body {
            background-color:  #d4d4d4;
        }

        .para{
           margin-top: 80px;
           margin-bottom: 80px;
           margin-left: 130px;
           color:#fff;
        }

        .form-signin {
          max-width: 411px;
          padding: 15px 35px 18px;
          -webkit-box-shadow: 0 0 3px #fff;
          box-shadow: 0 0 3px #fff;
          margin:0 auto;
          margin-top:120px;
          margin-bottom:50px;
          align:center;
          background-color:#fff;

        }
        .form-signin .input-group
        {
            top:10px;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
          margin-bottom: 20px;

        }
        .form-signin .checkbox {
          font-weight: normal;
        }
        .form-signin .form-control {
          position: relative;
          font-size: 16px;
          height: auto;
          padding: 10px;
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;
        }
        #password  { -webkit-text-security: disc; }
        #msg{
        	color:green;
        }
        #msg1{
        	color:red;
        }

    </style>

    <link rel='stylesheet'   href='assets/css/custom.css' type='text/css' media='all' />
    <link rel="stylesheet" href="assets/css/flexslider.css" type="text/css" media="screen" />
	
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109726639-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109726639-1');
</script> -->
</head>

<body class="single single-post postid-3434 single-format-image nav-sticky" style="background:#d4d4d4">
    <div class="navbar navbar-fixed-top floating positive two" role="navigation">
        <div class="container">
		
		
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="assets/images/main-logo.png" data-alt="assets/images/main-logo.png" alt="">
                </a>
            </div>

            <span class="contacts">
                <a href="tel:022 6143 1777 " class="p-d-10"><i class="fa fa-phone" aria-hidden="true"></i>
                <small class="hidden-xs hidden-sm">022 6143 1712 </small> </a> &nbsp
                <a href="mailto:info@dentalhome.in" class="p-d-10"><i class="fa fa-envelope" aria-hidden="true"></i>
                    <small class="hidden-xs hidden-sm">info@pecanreams.com</small></a>
            
            </span>
            <br/>
            
            <div class="collapse navbar-collapse" id="navbar-collapse"> 
                <ul id="menu-primary" class="nav navbar-nav navbar-right">
                <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="index.php" >Home
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu" >
                          <li><a href="about.html#company">About Us</a></li>    <li class="divider"></li>
                          <li><a href="about.html#team">Team</a></li>
                       <li class="divider"></li>
                          <li><a href="about.html#about">Pecan Group</a></li>
                    
            
                        </ul>
                        
                    </li>
      
       
      
                <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" >Solutions
                        <span class="caret"></span></a>
                       <ul class="dropdown-menu" >
						  <li><a href="property-management-service.html">REAMS</a></li>    <li class="divider"></li>
						  <li><a href="online-real-estate-analytics-tool.php">iDATA</a></li>
					   <li class="divider"></li>
						  <li><a href="public-notice-online.php">Assure</a></li>
					
						<li class="divider"></li>
						   <li><a href="real-estate-private-equity-advisor.html">Advisory</a></li>
						</ul>
                        
                    </li>
      
                    <li  ><a class="jumper"  href="blog" target="_blank"> Blogs</a></li>
                    <!-- <li  ><a href="pricing.php">Pricing</a></li> -->
                    <li ><a class="jumper" href="contact.php">Contact Us</a></li>
                    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >Login
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="https://www.pecanreams.com/app/" target="_blank">REAMS</a></li><li class="divider"></li>
                        <li><a href="https://www.pecanreams.com/d3m/" target="_blank">iDATA / Assure</a></li>
                    </ul>
                    </li>

                    <li><a href="register.php">REGISTER</a></li>
                </ul>
            </div>
        </div>
    </div>

    <form id="form_registration" class="form-signin" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="<?php if(isset($_SESSION["otp"])) echo 'display: none;'; ?>" autocomplete="off">       
        <div style="font-size:24px; text-align:center" ><b>Register Now</b></div>
        <?php if (isset($_POST["submit"])) {echo $msg;}?>
        <!-- <br> -->
        <?php //if (isset($result)) {print $result;}?>
        <!-- <br> -->
        <div class="input-group"  style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-user"></i></span>
            <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php if(isset($_POST["first_name"])) echo $_POST["first_name"]; ?>" required autofocus />
        </div>
        <div class="input-group"  style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-user"></i></span>
            <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php if(isset($_POST["last_name"])) echo $_POST["last_name"]; ?>" required/>
        </div>
        <div class="input-group"  style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 14px 6px 13px;"><i class="fa fa-envelope"></i></span>
            <input id="email" type="text" class="form-control"  name="email" placeholder="Email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required/>
        </div>
        <div class="input-group" style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 16px;"><i class="fa fa-lock" ></i></span>
            <input id="password" type="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>" pattern=".{8,}" title="Six or more characters" required onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : ''); if(this.checkValidity()) form.confirm_password.pattern = RegExp.escape(this.value);"/>
        </div>
        <div class="input-group" style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 16px;"><i class="fa fa-lock" ></i></span>
            <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php if(isset($_POST["confirm_password"])) echo $_POST["confirm_password"]; ?>" pattern=".{8,}" title="Password does not match" required onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');"/>
        </div>
        <span id="message"></span>
        <div class="input-group"  style="margin-bottom:5px" >
            <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-phone"></i></span>
            <input type="text" class="form-control" name="mobile" placeholder="Mobile No." value="<?php if(isset($_POST["mobile"])) echo $_POST["mobile"]; ?>" pattern="[789][0-9]{9}" required/>
        </div>
        <div class="input-group"  style="margin-bottom:5px; display:none;" >
            <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-users"></i></span>
            <input type="text" class="form-control" name="main_group_name" placeholder="Group Name" value="<?php if(isset($_POST["main_group_name"])) echo $_POST["main_group_name"]; ?>" />
        </div>
        <!-- <div class="input-group"  style="margin-bottom:5px" >
            <span class="input-group-addon"><i class="fa fa-users"></i></span>
            <input type="text" class="form-control" name="display_group_name" placeholder="Display Group Name" value="<?php //if(isset($_POST["display_group_name"])) echo $_POST["display_group_name"]; ?>" required/>
        </div> -->
       
        <?php if(isset($_POST["pricing"])) { ?>
            <div class="input-group"  style="margin-bottom:20px; display:none;" >
                <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-rupee"></i></span>
                <select class="form-control" id="" name="package">
                    <option value="">Select Package</option>
                    <?php 
                        $query = "select * from subscription where module='".$_POST["module"]."'";
                        $result = mysqli_query($conn, $query); 
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="'.$row["id"].'"'.(isset($_POST[$row["package_name"]])?"selected":"").'>'.$row["package_name"].' Yearly Package</option>';
                        }
                    ?>
                    <!-- <option value="1" <?php //if(isset($_POST["Basic"])) echo 'selected'; ?>>Basic Yearly Package</option>
                    <option value="2" <?php //if(isset($_POST["Business"])) echo 'selected'; ?>>Business Yearly Package</option>
                    <option value="3" <?php //if(isset($_POST["Enterprise"])) echo 'selected'; ?>>Enterprise Yearly Package</option> -->
               </select>
            </div>
        <?php } ?>
        <?php if(isset($_POST["module"])) { ?>
            <div class="input-group"  style="margin-bottom:20px; display:none;" >
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
            </div>
        <?php } ?>
        
        <p style="font-size:14px;">By Signing Up, you agree to our <a href="<?php echo $base_url; ?>/assure/index.php/terms" target="_blank">Terms & Conditions.</a></p>     
        <input style="margin-top:0px" type="submit" id="register" name="submit" class="btn btn-lg btn-primary btn-block" value="Register" />
    </form>

    <form id="form_otp" class="form-signin" style="margin-bottom: 0px; padding-bottom: 0px; <?php if(!isset($_SESSION["otp"])) echo 'display: none;'; ?>" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div style="font-size:24px; text-align:center" ><b>Enter OTP </b><?php //echo $_SESSION["otp"]; ?><?php //echo $_SESSION["name"]; ?></div>
        <?php if (isset($_POST["verify"]) ){echo $msg;}?>
        <?php if (isset($_POST["resend"]) ){echo $msg;}?>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="text" class="form-control" name="otp" placeholder="OTP" pattern="[0-9]{6}" required autofocus />
            </div>
        </div>
        <div class="form-group" style="margin-top: 20px;">
            <input style="padding: 10px 20px;" type="submit" id="verify" name="verify" class="btn btn-primary pull-left" value="Verify" />
            <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-primary pull-right" style="padding: 10px 20px;">Cancel</a>
        </div>
        <br>
    </form>

    <form id="form_resend_otp" class="form-signin" style="margin-top: 0px; <?php if(!isset($_SESSION["otp"])) echo 'display: none;'; ?>" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form-group" style="margin-bottom:0px;">
            <input style="padding: 10px 20px; margin-top:10px; color: -webkit-link; cursor: pointer; text-decoration: underline; font-size: 15px;" type="submit" id="resend" name="resend" class="btn-link" value="Resend Otp" />
        </div>
    </form>

<footer class="footer  no-border">
	<div class="container offsetBottomS offsetTopS">
		<div class="row">
<div class="col-lg-4  col-md-4 col-sm-3 col-xs-12">
		<div class="housing-line">
<div class="footer-logo-coloured"> <a href="index.php"><img src="assets/images/main-logo.png" style="background:#fff; padding:5px 10px;" /> </a></div>
<!---<div class="desc">
Copyright 2016. All rights reserved.
</div>-->
</div>
	</div>	
<div class="col-lg-4  col-md-4 col-sm-5 col-xs-4 footer-clmn1">
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="footer-header">
<span class="footer-text">Company</span>
</div> 
<ul class="list-unstyled clear-margins ">
			<li><a  href="about.html"> About Us</a></li>

			<li><a  href="contact.php"> Contact Us</a></li> 
</ul>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<div class="footer-header">
<span class="footer-text">Help</span>
</div> 
<ul class="list-unstyled clear-margins  " >
			<li><a  href="privacy-policy.html">  Privacy Policy</a></li>
			<li><a  href="terms-and-conditions.html">  Terms & Condition</a></li>    
</ul>
</div> 
</div>
<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4	footer-clmn2">
<div class="footer-header">
<span class="footer-text">Solutions</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="property-management-service.html"> REAMS</a></li>
			<li><a  href="online-real-estate-analytics-tool.php"> iDATA</a></li>
			<li><a  href="public-notice-online.php"> Assure</a></li>
						<li><a href="real-estate-private-equity-advisor.html">Advisory</a></li>
			                         
		
</ul>
</div>

<div class="col-lg-2  col-md-2 col-sm-2 col-xs-4 footer-clmn3">
<div class="footer-header">
<span class="footer-text">Classroom</span>
</div>
 
<ul class="list-unstyled clear-margins">
			<li><a  href="blog" target="_blank"> Blogs</a></li>
</ul>
</div>

 
                
	   </div>
	</div>

<div class="footer-bottom"> 
	<div class="container  ">
		<div class="row">
				
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="design">

					<a class="to-top"><i class="fa fa-angle-up"></i></a> 
				<!--	<a href="#">Privacy policy </a> |  
					<a target="_blank" href="#">Terms & Condition</a>-->

				</div>

			</div>
			
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

				<div class="copyright">	Copyright 2017.  All rights reserved.</div>

			</div>

				
		</div>
	</div>

 </div>
 
</footer>
<!--footer-->




<script>
var Prodo = {
	'loader': true,
	'animations': true,
	'navigation': 'sticky'
};
</script>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="assets/bootstrap.min.js"></script>

<script>
$(document).ready(function(){

	// $('#register').click(function(e) {
	// 	//form.submit();
	// 	document.getElementById('rf').submit();
	// 	alert('h');
	// });

    $('a[href^="#"]').click(function(e) {

        jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top-80}, 1000);



        e.preventDefault();

    });

});

</script>


<script src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-One-Page-Navigation-Plugin-Page-Scroll-To-ID/jquery.malihu.PageScroll2id.js"></script> 
<script>
(function($){
 $(window).load(function(){

    /* Page Scroll to id fn call */
    $("#menu-primary a,a[href='#top'],a[rel='m_PageScroll2id']").mPageScroll2id({
       highlightSelector:"#menu-primary a"

   });

    /* demo functions */
    $("a[rel='next']").click(function(e){
       e.preventDefault();
       var to=$(this).parent().parent(" ").next().attr("id");
       $.mPageScroll2id("scrollTo",to);



   });


});
})(jQuery);
</script>

<script defer src="assets/js/jquery.flexslider.js"></script> 
<script type="text/javascript">



$(window).load(function(){
  $('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 215,
    slideshow: false,
    controlNav: false,
    itemMargin: 0,
    minItems:1,
    maxItems: 5  
});
});



</script>
<script src="js/jquery.flip.min.js"></script>
<script>
$(function(){
   $(".flip-horizontal").flip({
       trigger: 'hover'
   });
   $(".flip-vertical").flip({
     axis: 'x',
     trigger: 'hover'
 });

   $(".one-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.one-hover').css("z-index","9999");

    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.one-hover').css("z-index","999999");
        $('.two-hover').css("z-index","9");
        $('.three-hover').css("z-index","9");
        $('.four-hover').css("z-index","9");
        $('.five-hover').css("z-index","9");
        $('.six-hover').css("z-index","9");
				//$('.one-hover').css("background","#fff");
				
			}
		});

   $(".two-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.two-hover').css("z-index","9999");		 
    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.two-hover').css("z-index","999999");
        $('.one-hover').css("z-index","9");
        $('.three-hover').css("z-index","9");
        $('.four-hover').css("z-index","9");
        $('.five-hover').css("z-index","9");
        $('.six-hover').css("z-index","9");

    }
});

   $(".three-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.three-hover').css("z-index","9999");

    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.three-hover').css("z-index","999999");
        $('.one-hover').css("z-index","9");
        $('.two-hover').css("z-index","9");
        $('.four-hover').css("z-index","9");
        $('.five-hover').css("z-index","9");
        $('.six-hover').css("z-index","9");				 
    }
});

   $(".four-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.four-hover').css("z-index","9999");

    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.four-hover').css("z-index","999999");	
        $('.one-hover').css("z-index","9");
        $('.three-hover').css("z-index","9");
        $('.two-hover').css("z-index","9");
        $('.five-hover').css("z-index","9");
        $('.six-hover').css("z-index","9");
    }
});


   $(".five-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.five-hover').css("z-index","9999");

    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.five-hover').css("z-index","999999");	
        $('.one-hover').css("z-index","9");
        $('.three-hover').css("z-index","9");
        $('.four-hover').css("z-index","9");
        $('.two-hover').css("z-index","9");
        $('.six-hover').css("z-index","9");
    }
});
   $(".six-hover").hover(function(){
     if($('.service-overlay').is(":visible")){
        $('.service-overlay').hide();
        $('.six-hover').css("z-index","9999");

    }
    else {
        $('.service-overlay').slideDown("fast");
        $('.six-hover').css("z-index","999999");	
        $('.one-hover').css("z-index","9");
        $('.three-hover').css("z-index","9");
        $('.four-hover').css("z-index","9");
        $('.five-hover').css("z-index","9");
        $('.two-hover').css("z-index","9");
    }
});

   $("#loginclick").click(function(){

    $('.login-overlay').show();
    $('.login-box').show();
			//	$('.one-hover').css("z-index","9999");


		});

   $(".btn-cls").click(function(){
			// $('#login-modal').attr("aria-hidden","true");
			// $('#login-modal').removeClass("in");
			//	$('#login-modal').hide();
            $('#login-modal').modal('toggle');

			//	$('.one-hover').css("z-index","9999");


		});


});
</script>



<script>
$(document).ready(function(){

  $('.video-control').click(function() {
     $('#embed-video').removeClass("hidden");
     $('.autocreate').removeClass("hidden");
     $('.video-section').attr("autoplay");
			var video = $(".video-section")[0]; // id or class of your <video> tag
            if (video.paused) {
                video.play();
            }    


        });

  $('.close-video').click(function() {
     $('#embed-video').addClass("hidden");
     $('.autocreate').addClass("hidden");
			var video = $(".video-section")[0]; // id or class of your <video> tag
            if (video.play) {
                video.pause();
                video.currentTime = 0;
            }    

        });
});


</script>
<script>
    $('.dropdown-toggle').click(function() {
        var location = $(this).attr('href');
        window.location.href = location;
        return false;
    });
    RegExp.escape= function(s) {
        return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    };
</script>

<script type='text/javascript' src='assets/bootstrap/js/bootstrap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='https://maps.google.com/maps/api/js?key=AIzaSyBQ9dVY1A4D4HbKBhh7HuXY3QRwLMWhg88'></script>
<script type='text/javascript' src='assets/js/jquery.gmap.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/retina.min.js?ver=1.3.0'></script>

<!-- <script type='text/javascript' src='assets/js/smoothscroll.min.js?ver=4.6.1'></script> -->
<script type='text/javascript' src='assets/js/jquery.mb.ytplayer.min.js?ver=25062016'></script>
<script type='text/javascript' src='assets/js/jquery.parallax.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/jquery.isotope.min.js?ver=4.6.1'></script>


<script type='text/javascript' src='assets/js/jquery.scrollto.min.js?ver=2.1.3'></script>
<script type='text/javascript' src='assets/js/jquery.knob.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='assets/js/prodo.min.js?ver=2.1'></script>
<script type='text/javascript' src='js/comment-reply.min.js?ver=4.6.1'></script>
<script type='text/javascript' src='js/wp-embed.min.js?ver=4.6.1'></script>



</body>
</html>
