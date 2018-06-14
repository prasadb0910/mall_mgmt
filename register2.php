<!DOCTYPE html>
<?php include('db.php') ?>
<?php
    $ip_address =  $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d H:i:s");
    if(isset($_POST["submit"])) {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $owner_name=$_POST["owner_name"];
        $mall_name=$_POST["mall_name"];
        $no_of_units=$_POST["no_of_units"];
      //  $name=$first_name.' '.$last_name;
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
            $sms = $date . "Dear%20".$owner_name."%2C%20your%20login%20OTP%20is%20".$otp."%2E%20Please%20treat%20this%20as%20confidential%2E%20Sharing%20it%20with%20anyone%20gives%20them%20full%20access%20to%20your%20Pecan%20Reams%20account%2E%20Pecan%20Reams%20never%20calls%20to%20verify%20your%20OTP%2E";
            $sms = str_replace(' ', '%20', $sms);
            $sms = str_replace(':', '%3A', $sms);
            $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $surl);
            curl_exec($ch);
            curl_close($ch);

            if(!isset($_SESSION["owner_name"])){
                session_start();
            }
            
            $_SESSION["owner_name"] = $owner_name;
            $_SESSION["mall_name"] = $mall_name;
            $_SESSION["no_of_units"] = $no_of_units;
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
		$_SESSION["otp"];
        if($_SESSION["otp"]==$_POST["otp"]) {
            $owner_name=$_SESSION["owner_name"];
			$mall_name=$_SESSION["mall_name"];
			$no_of_units=$_SESSION["no_of_units"];
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

            echo 'Sql'.$sql = "insert into contact_master (c_name,mall_name,no_of_units,c_gid, c_emailid1, c_mobile1, c_status, c_createdate, c_createdby, c_modifieddate, c_modifiedby) 
                    values ('".$owner_name."','".$mall_name."','".$no_of_units."','".$group_id."', '".$email."', '".$mobile."', 'Approved', '".$now."', '0', '".$now."', '0')";
            mysqli_query($conn, $sql);
            $contact_id = mysqli_insert_id($conn);

            $sql = "update group_master set created_by = '".$contact_id."' where g_id = '".$group_id."'";
            mysqli_query($conn, $sql);

            echo 'Sql'.$sql = "insert into group_users (gu_gid,name,gu_email,gu_mobile,gu_password,gu_role,add_date,gu_cid,assigned_status,assigned_role,created_at,created_by,updated_at,updated_by,user_type,isVerified,assure) 
                    values ('".$group_id."','".$owner_name."','".$email."','".$mobile."','".$password."','Admin','".$now."','".$contact_id."','Approved','1','".$now."','0','".$now."','0','owner','0','1') ";
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);

                $sql = "insert into users (name,email,mobile,password,isVerified) 
                        values ('".$owner_name."','".$email."','".$mobile."','".$password."','0') ";
                mysqli_query($conn, $sql);

                $sql2 = "INSERT INTO 
                user_access_log (user_id,ip_address,module_name,controller_name,action,table_id,`date`,created_on,gp_id)
                VALUES ('$contact_id','$ip_address','Registeration','Registeration','User Registered','$contact_id', '$date','$date','$group_id')";
                $conn->query($sql2);

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
                    $mail->Password = 'ASSURE789';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 465;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('info@pecanreams.com', 'Pecan Reams');
                    $mail->addAddress($email, $owner_name);     // Add a recipient
                    // $mail->addAddress('ellen@example.com');               // Name is optional
                    $mail->addReplyTo('info@pecanreams.com', 'Pecan Reams');
                    // $mail->addCC('ashwini.patil@pecanreams.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Welcome to Pecan Reams';
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
                                            <p>Hi '.$owner_name.',</p>
                                            <p>
                                                Thank you for registering with Pecan Reams.
                                            </p>
                                            <br>
                                            For any specific information, general feedback about the site or content, please feel free to write on info@pecanreams.com
                                            <br><br><br>
                                            Thanks,<br><br>
                                            Team Pecan Reams
                                        </div>
                                    </body>
                                    </html>';
                    $mail->AltBody = 'Thank you for registering with Pecan Reams.';

                    $mail->send();
                    // echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo 'Message could not be sent.';
                //     echo 'Mailer Error: ' . $mail->ErrorInfo;
                // }

                    $sms = "Hi%20".$owner_name."%2C%20Thank%20you%20for%20registering%20with%20Pecan%20Reams%2E%20For%20feedback%20please%20feel%20free%20to%20write%20on%20info%40pecanreams%2Ecom%20or%20visit%20http%3A%2F%2Fwww%2Epecanreams%2Ecom";
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

                $sql = "Insert into user_login_emails (user_id, email, token, isVerified) values ('$user_id','$email', '$token', '0')";
                mysqli_query($conn, $sql);

                $url =  $base_url.'/index.php/login/get_dashboard/'.$token;

                // echo $url;
                // echo '<br/>';

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

        if(!isset($_SESSION["owner_name"])){
            // session_start();
            header("Location: ".$base_url."/register.php");
        }

        $owner_name=$_SESSION["owner_name"];
        $mall_name=$_SESSION["mall_name"];
        $no_of_units=$_SESSION["no_of_units"];
        $email=$_SESSION["email"];
        $mobile=$_SESSION["mobile"];
        $password=$_SESSION["password"];
        $main_group_name=$_SESSION["main_group_name"];
        $display_group_name=$_SESSION["display_group_name"];
        $package=$_SESSION["package"];
        $module=$_SESSION["module"];

        $otp = rand(100000,999999);
		
		
        $date = date("d M H:i");
        $sms = $date . "Dear%20".$owner_name."%2C%20your%20login%20OTP%20is%20".$otp."%2E%20Please%20treat%20this%20as%20confidential%2E%20Sharing%20it%20with%20anyone%20gives%20them%20full%20access%20to%20your%20Pecan%20Reams%20account%2E%20Pecan%20Reams%20never%20calls%20to%20verify%20your%20OTP%2E";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $mobile . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch); 

        $_SESSION["otp"] = $otp;
        $_SESSION["resent"] = 'true';

        $msg="<h5 id='msg1'>OTP Sent!! </h5>";
    }
?>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams – Property Management Tool Log In </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="Description" content="Get access to your real estate property management dashboard.">
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                     
    </head>
    <body>
        <div class="login-container lightmode">
            <div class="login-box animated fadeInDown">
                <div class="login-logo"></div>
                <div class="login-body">
                    <div class="login-title"><strong>Register</strong>  a new membership</div>
                    <!-- <form id="form_login" action="<?php //echo base_url().'index.php/login/checkcredentials'; ?>" class="form-horizontal" method="post"> -->
                  <form id="form_registration" class="form-horizontal"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="<?php if(isset($_SESSION["otp"])) echo 'display: none;'; ?>" autocomplete="off" >
				  
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
										<input type="password" class="form-control" placeholder="Password" name="password" id="password" />
									</div>
								</div>
						<div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control" placeholder="Confirm Password"  name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php if(isset($_POST["confirm_password"])) echo $_POST["confirm_password"]; ?>" pattern=".{8,}" title="Password does not match" required />
                            </div>
						</div>
						   <div class="input-group"  style="margin-bottom:5px; display:none;" >
            <span class="input-group-addon" style="padding: 6px 15px;"><i class="fa fa-users"></i></span>
            <input type="text" class="form-control" name="main_group_name" placeholder="Group Name" value="<?php if(isset($_POST["main_group_name"])) echo $_POST["main_group_name"]; ?>" />
        </div>
						
						        <?php if(isset($_POST["pricing"])) { ?>
            <div class="form-group"  style="margin-bottom:20px; display:none;" >
          
                <select class="form-group" id="" name="package">
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
            <div class="form-group"  style=" display:none;" >
                <input type="hidden" name="module" value="<?php echo $_POST['module']; ?>">
            </div>
        <?php } ?>
						
							
						
						<div class="form-group">
                            <div class="col-md-6">
                                <!-- <span class="btn btn-link btn-block" id="forgot_password">Forgot your password?</span> -->
                                <label class="check"><input type="checkbox" name="remember" class="icheckbox" /> Remember Me</label>
                            </div>


                            <div class="col-md-6">
                                <button id="log_in" type="submit" name="submit" class="btn btn-info btn-block" >Register</button>
                            </div>
                        </div>

                  
                        
                        <!-- <div class="login-subtitle">
                            Don't have an account yet? <a href="#">Create an account</a>
                        </div> -->
                    </form>
					
					    <form id="form_otp" class="form-horizontal" style="margin-bottom: 0px; padding-bottom: 0px; <?php if(!isset($_SESSION["otp"])) echo 'display: none;'; ?>" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
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

    <form id="form_resend_otp" class="form-horizontal" style="margin-top: 0px; <?php if(!isset($_SESSION["otp"])) echo 'display: none;'; ?>" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form-group" style="margin-bottom:0px; <?php if(isset($_SESSION["resent"])) echo 'display: none;'; ?>">
            <input style="padding: 10px 20px; margin-top:10px; color: -webkit-link; cursor: pointer; text-decoration: underline; font-size: 15px;" type="submit" id="resend" name="resend" class="btn-link" value="Resend Otp" />
        </div>
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
            //var BASE_URL="<?php //echo base_url()?>";
        </script>
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
 
        <!-- END PLUGINS-->
        
        
    </body>
</html>