<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //get the username & password from tbl_usrs
    function get_user($usr, $pwd)
    {  
        //This is in the PHP file and sends a Javascript alert to the client
        //$message = "wrong answer";
        //echo "<script type='text/javascript'>alert('$message . md5($pwd) ');</script>";

        $sql = "select * from mst_user where user_id = '" . $usr . "' and password = '" . $pwd . "' and is_approved = 1 LIMIT 1";
        $query = $this->db->query($sql);
        //return $query->num_rows();
        return $query;
    }

    function insert_otp_data($data) {
        $this->db->insert('otp_details', $data);
        return $this->db->insert_id();
    }
    
    function check_otp($mobile, $otp) {
        $sql = "select * from otp_details where mobile = '" . $mobile . "' and " . 
               "created_date > DATE_SUB(now(),INTERVAL '5' MINUTE) and otp = '" . $otp . "' and " . 
               "id = (select max(id) from otp_details where mobile = '" . $mobile . "')";
        $query = $this->db->query($sql);
        if( $query->num_rows() > 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function get_user_details($usr, $pwd) {
        // $pwd = md5($pwd);
        // $query=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$usr' AND gu_password = '$pwd' order by gu_gid desc");
        // return $query;

        $result = 0;
        $query=$this->db->query("SELECT * FROM group_users WHERE gu_email = '$usr' order by gu_id")->result();
        if(count($query)>0){
            for($i=0; $i<count($query); $i++){
                $hashedPassword = $query[$i]->gu_password;
                if (password_verify($pwd, $hashedPassword)) {
                    $result = $query[$i]->gu_id;
                }
            }
        }
        return $result;
    }
}?>