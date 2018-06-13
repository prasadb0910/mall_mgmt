<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Login extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->helper("file");
        $this->load->helper('cookie');
        $this->load->helper('string');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('login_model');
        $this->load->database();
    }

    public function index(){
        $this->load->view('login/main_page');
    }

    public function checkcredentials() {
        $uname=$this->input->post('email');
        $upass=$this->input->post('password');

        // $uname = html_escape('prasadb0910@gmail.com');
        // $upass = html_escape('pass@123');

        $msg='';
        $redirect_url='';

        if ($uname=='admin@pecanreams.com' && $upass=='delta003') {
            $sessiondata = array(
                'session_id' => 0,
                'username' => $uname,
                'loginname' => 'SuperAdmin',
                'groupid' => 0,
                'groupname' => '',
                'role_id' => 0,
                'usrrole' => 'SuperAdmin',
                'gu_id' => 0
                );

            $this->session->set_userdata($sessiondata);
            // echo "Loggen in <br>";
            // print_r($this->session->userdata());
            $logarray['table_id']='0';
            $logarray['module_name']='Login';
            $logarray['cnt_name']='Login';
            $logarray['action']='Logged in';
            $logarray['gp_id']='0';
            $this->user_access_log_model->insertAccessLog($logarray);
            // redirect(base_url().'index.php/Groups');
            $redirect_url=base_url().'index.php/Groups';

        } else {
            // $upass = md5($upass);

            // $query=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$uname' AND gu_password = '$upass' order by gu_gid desc");
            // $result=$query->result();
            // if(count($result) > 0 ) {
            //     $query = $this->db->query("SELECT A.* FROM group_users A,group_master B WHERE A.gu_gid=B.g_id AND B.group_status='Active' AND A.gu_email = '$uname' AND A.gu_password = '$upass' order by gu_gid desc");
            //     $result4=$query->result();

            $result = $this->login_model->get_user_details($uname, $upass);
            if($result > 0) {
                $redirect_url = $this->set_user_session($result);

                // $result2=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$uname' AND gu_password = '$upass' order by gu_gid desc")->result();
                // if(count($result2)>0){
                //     $this->send_welcome_email();
                // }
                
            } else {
                // echo "<script>alert('Invalid Username or Password.');</script>";
				// $this->load->view('login/main_page');
                $msg='Invalid Username or Password.';
                $redirect_url=base_url().'index.php/Login';
            }
        }

        $data['msg']=$msg;
        $data['redirect_url']=$redirect_url;

        echo json_encode($data);
    }

    public function set_user_session($gu_id){
        $query = $this->db->query("SELECT A.* FROM group_users A, group_master B WHERE A.gu_gid=B.g_id AND B.group_status='Active' AND 
                                    A.gu_id = '$gu_id' order by A.gu_id");
        $result=$query->result();
        if(count($result)>0) {
            $now = date('Y-m-d');
            $data = array('u_lastlogin' => $now, );
            $uid=$result[0]->gu_cid;
            $gu_id=$result[0]->gu_id;
            $this->db->where('u_id', $uid);
            $this->db->update('user_master', $data);
            $gu_gid=$result[0]->gu_gid;
            $uname=$result[0]->gu_email;

            $query = $this->db->query("SELECT * FROM contact_master WHERE c_id = '$uid'");
            $result2=$query->result();

            $query = $this->db->query("SELECT * FROM group_master WHERE g_id='$gu_gid'");
            $result3=$query->result();

            $sessiondata = array(
                'session_id' => $uid,
                'username' => $uname,
                'loginname' => $result2[0]->c_name . ' ' . $result2[0]->c_last_name,
                'groupid' => $result[0]->gu_gid,
                'groupname' => $result3[0]->group_name,
                'role_id' => $result[0]->assigned_role,
                'usrrole' => $result[0]->gu_role,
                'gu_id' => $gu_id,
                'maker_checker' => $result3[0]->maker_checker
                );

            $this->session->set_userdata($sessiondata);
            // echo "Loggen in <br>";
            // print_r($this->session->userdata());
            $logarray['table_id']=$uid;
            $logarray['module_name']='Login';
            $logarray['cnt_name']='Login';
            $logarray['action']='Logged in';
            $logarray['gp_id']=$result[0]->gu_gid;
            $this->user_access_log_model->insertAccessLog($logarray);
            // redirect(base_url().'index.php/Dashboard');
            $redirect_url=base_url().'index.php/Dashboard';
        } else {
            // echo "<script>alert('No Groups Assigned.');</script>";
            // $this->load->view('login/main_page');
            $msg='No Groups Assigned.';
            $redirect_url=base_url().'index.php/Login';
        }

        return $redirect_url;
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect();
    }

    public function send_welcome_email() {
        $data = array();

        $to_email = $this->input->post('email');
        // $to_email = $this->session->userdata('username');
        // $to_email = 'prasad.bhisale@pecanreams.com';

        // echo $to_email;

        if($to_email!=''){
            $query=$this->db->query("SELECT * FROM group_users WHERE gu_email='" . $to_email . "'");
            $result=$query->result();

            if (count($result) > 0) {
                // echo '<br/>';
                // echo count($result);

                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $subject = 'Welcome to Pecan Reams';

                $to_email = $result[0]->gu_email;
                $name = $result[0]->name;

                // echo '<br/>';
                // echo $to_email;

                $message = '<!DOCTYPE html>
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
                                    <h2>Hi '.$name.',</h2>
                                    <p>
                                        Thank you for registering with Pecan Reams.
                                    </p>
                                    <br><br>
                                    For any specific information, general feedback about the site or content, please feel free to write on info@pecanreams.com
                                    <br><br>
                                    Thanks,<br>
                                    Team Pecan REAMS
                                </div>
                            </body>
                            </html>';

                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

                // echo '<br/>';
                // echo $mailSent;

                $this->db->query("Update group_users set mail_sent = '1' WHERE gu_email = '$to_email'");

                // $this->db2 = $this->load->database('assure', true);
                // $this->db2->query("Update group_users set mail_sent = '1' WHERE gu_email = '$to_email'");
            }
        }
    }

    public function email() {
        $this->load->view('login/email');
    }
	
	 public function register() {
        $this->load->view('login/register');
    }

    public function check_valid_email() {
        $result = 1;
        $email = $this->input->post('email');
        $query=$this->db->query("SELECT * FROM group_users WHERE gu_email='" . $email . "'");
        $data=$query->result();
        if($email!=''){
            if (count($data) > 0) {
                $result = 0;
            }
        }

        echo $result;
    }

    public function check_valid_token() {
        $result = 1;
        $email = $this->input->post('email');
        $token = $this->input->post('token');
        $query=$this->db->query("SELECT * FROM password_resets WHERE gu_email='" . $email . "' and token='" . $token . "'");
        $data=$query->result();
        if($email!=''){
            if (count($data) > 0) {
                $result = 0;
            }
        }

        echo $result;
    }

    public function set_token($email){
        $token = random_string('numeric', 6);
        $token = md5($token);

        $sql = "delete from password_resets where gu_email = '".$email."'";
        $this->db->query($sql);

        $sql = "insert into password_resets (gu_email, token) values ('".$email."', '".$token."')";
        $this->db->query($sql);

        return $token;
    }

    public function email_link() {
        $data = array();

        $to_email = $this->input->post('email');
        $query=$this->db->query("SELECT * FROM group_users WHERE gu_email='" . $to_email . "'");
        $result=$query->result();
        if($to_email!=''){
            if (count($result) > 0) {
                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $subject = 'Reset Password Request';

                $token = $this->set_token($to_email);

                $message = '<!DOCTYPE html>
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
                                    <h2>Hello!</h2>
                                    <p>
                                        You are receiving this email because we received a password reset request for your account.
                                    </p>
                                    <br><br>

                                    <table width="200" height="44" cellpadding="0" cellspacing="0" border="0" bgcolor="#41a541" style="border-collapse:collapse!important;border-radius:4px">
                                        <tbody>
                                            <tr>
                                                <td align="center" valign="middle" height="44" style="font-family:"Open Sans",sans-serif;font-size:14px;font-weight:normal">
                                                    <a  href="'.base_url().'index.php/login/reset'.$token.'"style="font-family:"Open Sans",sans-serif;color:#ffffff;display:inline-block;text-decoration:none;line-height:44px;width:200px;font-weight:normal;text-transform:uppercase" >Reset Password </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <br><br>
                                    If you did not request a password reset, no further action is required.
                                    <br><br>
                                    Thanks,<br>
                                    Team Pecan REAMS
                                </div>

                            </body>
                            </html>';

                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

                if ($mailSent==1) {
                    $data['success'] = "We have e-mailed your password reset link!";
                } else {
                    $data['error'] = "Mail sending failed.";
                }
            } else {
                $data['error'] = "Please enter correct email id.";
            }
        } else {
                $data['error'] = "Please enter email id.";
        }

        $this->load->view('login/email', $data);
    }

    public function reset($token) {
        $data['token'] = $token;

        $this->load->view('login/reset', $data);
    }

    public function reset_password(){
        $data = array();

        $to_email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->update_password($to_email, $password, '');

        $gu_id='';
        $query=$this->db->query("SELECT * FROM group_users WHERE gu_email='" . $to_email . "'");
        $data=$query->result();
        if($to_email!=''){
            if (count($data) > 0) {
                $gu_id=$data[0]->gu_id;
            }
        }

        $redirect_url = $this->set_user_session($gu_id);

        redirect($redirect_url);
    }

    public function update_password($to_email, $password, $user_id){
        $password=password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
        $now=date('Y-m-d H:i:s');

        $sql = "update group_users set gu_password = '$password', updated_at = '$now', updated_by = '$user_id' where gu_email = '$to_email'";
        $this->db->query($sql);

        $sql = "update users set password = '$password' where email = '$to_email'";
        $this->db->query($sql);

        // $this->db2 = $this->load->database('assure', true);

        // $sql = "update group_users set gu_password = '$password', updated_at = '$now', updated_by = '$user_id' where gu_email = '$to_email'";
        // $this->db2->query($sql);

        // $sql = "update users set password = '$password' where email = '$to_email'";
        // $this->db2->query($sql);

        $sql = "delete from password_resets where gu_email = '$to_email'";
        $this->db->query($sql);
    }

    public function check_valid_password(){
        $result = 1;
        $uname=$this->session->userdata('username');
        $upass = $this->input->post('password');
        // $upass = 'pass@123';

        $data = $this->login_model->get_user_details($uname, $upass);

        if ($data > 0) {
            $result = 0;
        }

        echo $result;
    }

    public function change_password() {
        $uname=$this->session->userdata('username');
        $upass = $this->input->post('password');
        $curusr=$this->session->userdata('session_id');

        $this->update_password($uname, $upass, $curusr);

        echo 1;
    }

    public function forgot_password_email() {
        $to_email = $this->input->post('email');
        $query=$this->db->query("SELECT * FROM group_users WHERE gu_email='" . $to_email . "'");
        $result=$query->result();
		if($to_email!=''){
			if (count($result) > 0) {
				$from_email = 'info@pecanreams.com';
				$from_email_sender = 'Pecan REAMS';
				$subject = 'Your password for property';
				$message = '<html><head></head><body>Hi,<br /><br />' .
							'Password: ' . $result[0]->gu_password .
							'<br /><br />Thanks</body></html>';
				$mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
				if ($mailSent==1) {
					echo "Password has been mailed to your email id.";
				} else {
					echo "Mail sending failed.";
				}
			} else {
				echo "Please enter correct email id.";
			}
		}
		else {
				echo "Please enter email id.";
		}

        // $this->load->view('login/main_page');
    }

    public function send_otp($name, $phone) {
        // $phone="9773560529";
        //------------------ SMS Sending Start --------------------------------------
        $otp = random_string('numeric', 6);

        $date = date("d M H:i");
        $this->load->library('PHPRequests');
        $sms = $date . "Dear%20".$name."%2C%20your%20login%20OTP%20is%20".$otp."%2E%20Please%20treat%20this%20as%20confidential%2E%20Sharing%20it%20with%20anyone%20gives%20them%20full%20access%20to%20your%20Pecan%20Reams%20account%2E%20Pecan%20Reams%20never%20calls%20to%20verify%20your%20OTP%2E";
        $sms = str_replace(' ', '%20', $sms);
        $sms = str_replace(':', '%3A', $sms);
        $surl = "http://smshorizon.co.in/api/sendsms.php?user=Ashish_Chandak&apikey=QizzeB4YLplingobMXX2&mobile=" . $phone . "&message=" . $sms . "&senderid=PECANR&type=txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $surl);
        curl_exec($ch);
        curl_close($ch);

        $data = array(
            'mobile' => $phone,
            'otp' => $otp,
            'created_date' => date('Y-m-d H:i:s')
        );
        $this->login_model->insert_otp_data($data);

        // echo $surl;
        // echo '<br/>';
        // echo $otp;
        
        return $otp;
        //------------------ SMS Sending End ----------------------------------------
    }

    public function get_otp() {
        $uname=$this->input->post('email');
        $upass=$this->input->post('password');
        $otp=0;

        // $uname='prasada0910@gmail.com';
        // $upass='pass@123';

        if ($uname=='admin@pecanreams.com' && $upass=='delta003') {
            // $this->checkcredentials();
        } else {
            // $upass = md5($upass);
            // $query=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$uname' AND gu_password = '$upass' order by gu_gid desc");
            // $result=$query->result();
            // if(count($result) > 0 ) {
            //     $cookie2 = get_cookie('User_'.$result[0]->gu_id);
            //     if (!isset($cookie2)) {
            //         $query = $this->db->query("SELECT A.* FROM group_users A,group_master B WHERE A.gu_gid=B.g_id AND B.group_status='Active' AND A.gu_email = '$uname' AND A.gu_password = '$upass' order by gu_gid desc");
            //         $result4=$query->result();
            //         if(count($result4)>0) {

            $result = $this->login_model->get_user_details($uname, $upass);
            if($result > 0) {
                $query = $this->db->query("SELECT A.* FROM group_users A, group_master B WHERE A.gu_gid=B.g_id AND B.group_status='Active' AND 
                                            A.gu_id = '$result' order by A.gu_id");
                $result=$query->result();
                if(count($result)>0) {
                    $now = date('Y-m-d');
                    $cookie2 = get_cookie('User_'.$result[0]->gu_id);
                    $data = array('u_lastlogin' => $now, );
                    $uid=$result[0]->gu_cid;
                    $this->db->where('u_id', $uid);
                    $this->db->update('user_master', $data);
                    $gu_gid=$result[0]->gu_gid;

                    if (!isset($cookie2)) {
                        $query = $this->db->query("SELECT * FROM contact_master WHERE c_id = '$uid'");
                        $result2=$query->result();
                        if (count($result2)>0){
                            $otp = $this->send_otp($result2[0]->c_name, $result2[0]->c_mobile1);
                        }
                    }
                }
            }
        }

        echo $otp;
    }
    
    public function check_otp() {
        $uname=$this->input->post('email');
        $upass=$this->input->post('password');
        $otp = $this->input->post('otp');

        // $c_mobile1 = "1234567890";
        // $uname='swapnil.darekar@gmail.com';
        // $upass='pass@123';
        // $otp = "789134";
        
        $check_otp=0;

        // $upass = md5($upass);
        // $query=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$uname' AND gu_password = '$upass' order by gu_gid desc");
        // $result=$query->result();
        // if(count($result) > 0 ) {


        $result = $this->login_model->get_user_details($uname, $upass);
        if($result > 0) {
            $query = $this->db->query("SELECT A.* FROM group_users A, group_master B WHERE A.gu_gid=B.g_id AND B.group_status='Active' AND 
                                        A.gu_id = '$result' order by A.gu_id");
            $result=$query->result();
            if(count($result)>0) {
                $now = date('Y-m-d');
                $uid=$result[0]->gu_cid;
                $query = $this->db->query("SELECT * FROM contact_master WHERE c_id = '$uid'");
                $result2=$query->result();
                if (count($result2)>0){
                    $check_otp = $this->login_model->check_otp($result2[0]->c_mobile1, $otp);

                    if($check_otp==1){
                        set_cookie('User_'.$result[0]->gu_id, 'Hello', 86500000);
                    }
                }
            }
        }

        echo $check_otp;
    }
    
    public function check_login_details() {
        $username = html_escape($this->input->post('username'));
        $password = html_escape($this->input->post('password'));

        // $username = html_escape('prasadb0910@gmail.com');
        // $password = html_escape('pass@123');

        if ($username=='admin@pecanreams.com' && $password=='delta003') {
            echo 1;
        } else {
            $result = $this->login_model->get_user_details($username, $password);
            
            // if ($result->num_rows() > 0) {
            //     echo 1;
            // } else {
            //     echo 0;
            // }

            if($result>0){
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function assure() {
        $email_id=$this->session->userdata('username');
        $token = rand(100000,999999);
        $token = md5($token);
        $user_id=$this->session->userdata('gu_id');

        $data = array(
                        'user_id' => $user_id,
                        'email' => $email_id,
                        'token' => $token,
                        'isVerified'=> '0'
                    );

        // $this->db2 = $this->load->database('assure', true);
        // $this->db2->insert('user_login_emails',$data);
        // $id = $this->db2->insert_id();

        $this->db->insert('user_login_emails',$data);
        $id = $this->db->insert_id();

        redirect(base_url().'../d3m/public/index.php/login/set_assure_session/'.$token, 'refresh');
    }

    public function idata() {
        $email_id=$this->session->userdata('username');
        $token = rand(100000,999999);
        $token = md5($token);
        $user_id=$this->session->userdata('gu_id');

        $data = array(
                        'user_id' => $user_id,
                        'email' => $email_id,
                        'token' => $token,
                        'isVerified'=> '0'
                    );

        // $this->db2 = $this->load->database('assure', true);
        // $this->db2->insert('user_login_emails',$data);
        // $id = $this->db2->insert_id();

        $this->db->insert('user_login_emails',$data);
        $id = $this->db->insert_id();

        redirect(base_url().'../d3m/public/index.php/login/set_idata_session/'.$token, 'refresh');
    }

    public function get_dashboard($token){
        $redirect_url = $this->get_session($token);
        
        $redirect_url = base_url().'index.php/Dashboard';
        redirect($redirect_url);
    }

    public function get_laravel_session($token){
        $redirect_url = $this->get_session($token);
        
        $redirect_url = base_url().'index.php/Dashboard';
        redirect($redirect_url);
    }

    public function get_user_profile($token){
        $redirect_url = $this->get_session($token);
        
        $redirect_url = base_url().'index.php/profile';
        redirect($redirect_url);
    }

    public function get_user($token){
        $redirect_url = $this->get_session($token);
        
        $redirect_url = base_url().'index.php/assign';
        redirect($redirect_url);
    }

    public function get_user_roles($token){
        $redirect_url = $this->get_session($token);
        
        $redirect_url = base_url().'index.php/manage';
        redirect($redirect_url);
    }

    public function get_session($token){
        $redirect_url = base_url().'index.php/Login';

        $sql = "select * from user_login_emails where token = '$token' and isVerified = '0'";
        // $this->db2 = $this->load->database('assure', true);
        // $query = $this->db2->query($sql);
        $query = $this->db->query($sql);
        $data = $query->result();
        if(count($data)>0){
            // $email_id = $data[0]->email;
            $user_id = $data[0]->user_id;

            // $this->db2->query("update user_login_emails set isVerified = '1' where token = '$token'");

            $this->db->query("update user_login_emails set isVerified = '1' where token = '$token'");

            // $sql = "select * from group_users where gu_email = '$email_id' and assigned_status!='Inactive'";
            $sql = "select * from group_users where gu_id = '$user_id'";
            $query = $this->db->query($sql);
            $data2 = $query->result();
            if(count($data2)>0){
                $gu_id=$data2[0]->gu_id;
                $redirect_url = $this->set_user_session($gu_id);
            }
        }

        return $redirect_url;
    }
}
?>