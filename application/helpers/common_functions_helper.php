<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * File Name: group_list.php
 */

    function load_view($view, $data) {
    	$CI =& get_instance();
        
        $user_data['Properties'] = 0;
        $user_data['Association'] = 0;
        $user_data['Task'] = 1;
        $user_data['Dashboard'] = 1;
        $user_data['Reports'] = 1;
        $user_data['Documents'] = 0;
        $user_data['Settings'] = 0;

        $user_data['Owner'] = 0;
        $user_data['Purchase'] = 0;
        $user_data['Allocation'] = 0;
        $user_data['Sale'] = 0;
        $user_data['Rent'] = 0;
        $user_data['BankEntry'] = 0;
		$user_data['Indexation'] = 0;
        $user_data['Tax'] = 0;
        $user_data['Loan'] = 0;
        $user_data['Expense'] = 0;
        $user_data['Maintenance'] = 0;
        $user_data['Groups'] = 0;
        $user_data['Contacts'] = 0;
        $user_data['Bank'] = 0;
        $user_data['AllTask'] = 1;
        $user_data['MyTask'] = 1;
        $user_data['CreateTask'] = 1;
        $user_data['User'] = 0;
        $user_data['UserRoles'] = 0;
        $user_data['Payments'] = 0;
        
        $user_data['DocumentMaster'] = 0;
        $user_data['DocumentTypeMaster'] = 0;
        $user_data['Valuation'] = 0;
        
        $user_data['Log'] = 0;

        $roleid = $CI->session->userdata('role_id');
        $query=$CI->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            for ($i=0; $i<count($result); $i++) {
                $user_data[$result[$i]->section] = $result[$i]->r_view;
            }
        }

        if ($user_data['Owner']==0 && $user_data['Purchase']==0 && $user_data['Allocation']==0 && $user_data['Sale']==0 && 
            $user_data['Rent']==0 && $user_data['BankEntry']==0 && $user_data['Loan']==0 && $user_data['Expense']==0 && 
            $user_data['Maintenance']==0 && $user_data['Payments']==0) {
            $user_data['Properties'] = 0;
        } else {
            $user_data['Properties'] = 1;
        }

        if ($user_data['Groups']==0 && $user_data['Contacts']==0 && $user_data['Bank']==0) {
            $user_data['Association'] = 0;
        } else {
            $user_data['Association'] = 1;
        }

        if ($user_data['AllTask']==0 && $user_data['MyTask']==0 && $user_data['CreateTask']==0) {
            $user_data['Task'] = 0;
        } else {
            $user_data['Task'] = 1;
        }

        if ($user_data['DocumentMaster']==0 && $user_data['DocumentTypeMaster']==0) {
            $user_data['Documents'] = 0;
        } else {
            $user_data['Documents'] = 1;
        }

        if ($user_data['User']==0 && $user_data['UserRoles']==0) {
            $user_data['Settings'] = 0;
        } else {
            $user_data['Settings'] = 1;
        }

        if ($user_data['Log']==0) {
            $user_data['Log'] = 0;
        } else {
            $user_data['Log'] = 1;
        }

        $user_data['userdata'] = $CI->session->all_userdata();

    	$data = $data + $user_data;

    	$CI->load->view($view, $data);
    }

    function load_view_without_data($view) {
        $CI =& get_instance();
        
        $user_data['Properties'] = 0;
        $user_data['Association'] = 0;
        $user_data['Task'] = 1;
        $user_data['Dashboard'] = 1;
        $user_data['Reports'] = 1;
        $user_data['Documents'] = 0;
        $user_data['Settings'] = 0;
		
		$user_data['Indexation'] = 0;
        $user_data['Tax'] = 0;
        $user_data['Owner'] = 0;
        $user_data['Purchase'] = 0;
        $user_data['Allocation'] = 0;
        $user_data['Sale'] = 0;
        $user_data['Rent'] = 0;
        $user_data['BankEntry'] = 0;
        $user_data['Loan'] = 0;
        $user_data['Expense'] = 0;
        $user_data['Maintenance'] = 0;
        $user_data['Groups'] = 0;
        $user_data['Contacts'] = 0;
        $user_data['Bank'] = 0;
        $user_data['AllTask'] = 1;
        $user_data['MyTask'] = 1;
        $user_data['CreateTask'] = 1;
        $user_data['User'] = 0;
        $user_data['UserRoles'] = 0;
        $user_data['Payments'] = 0;
        
        $user_data['DocumentMaster'] = 0;
        $user_data['DocumentTypeMaster'] = 0;
        $user_data['Valuation'] = 0;
        
        $user_data['Log'] = 0;

        $roleid = $CI->session->userdata('role_id');
        $query=$CI->db->query("SELECT * FROM user_role_options WHERE role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            for ($i=0; $i<count($result); $i++) {
                $user_data[$result[$i]->section] = $result[$i]->r_view;
            }
        }

        if ($user_data['Owner']==0 && $user_data['Purchase']==0 && $user_data['Allocation']==0 && $user_data['Sale']==0 && 
            $user_data['Rent']==0 && $user_data['BankEntry']==0 && $user_data['Loan']==0 && $user_data['Expense']==0 && 
            $user_data['Maintenance']==0 && $user_data['Payments']==0) {
            $user_data['Properties'] = 0;
        } else {
            $user_data['Properties'] = 1;
        }

        if ($user_data['Groups']==0 && $user_data['Contacts']==0 && $user_data['Bank']==0) {
            $user_data['Association'] = 0;
        } else {
            $user_data['Association'] = 1;
        }

        if ($user_data['AllTask']==0 && $user_data['MyTask']==0 && $user_data['CreateTask']==0) {
            $user_data['Task'] = 0;
        } else {
            $user_data['Task'] = 1;
        }

        if ($user_data['DocumentMaster']==0 && $user_data['DocumentTypeMaster']==0) {
            $user_data['Documents'] = 0;
        } else {
            $user_data['Documents'] = 1;
        }

        if ($user_data['User']==0 && $user_data['UserRoles']==0) {
            $user_data['Settings'] = 0;
        } else {
            $user_data['Settings'] = 1;
        }

        if ($user_data['Log']==0) {
            $user_data['Log'] = 0;
        } else {
            $user_data['Log'] = 1;
        }

        $user_data['userdata'] = $CI->session->all_userdata();
        $data = $user_data;

        $CI->load->view($view, $data);
    }

    function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    function send_email($from_email, $from_email_sender, $to_email, $subject, $message) {
        try {
            $CI =& get_instance();

            $from_email = 'info@pecanreams.com';

            //configure email settings
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.googlemail.com'; //smtp host name
            $config['smtp_port'] = '465'; //smtp port number
            $config['smtp_user'] = $from_email;
            $config['smtp_pass'] = 'Info@003#'; //$from_email password
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $CI->email->initialize($config);

            //send mail
            $CI->email->from($from_email, $from_email_sender);
            $CI->email->to($to_email);
            // $CI->email->to('prasad.bhisale@otbconsulting.co.in');
            $CI->email->subject($subject);
            $CI->email->message($message);
            $CI->email->set_mailtype("html");
            // return $CI->email->send();

        } catch (Exception $ex) {
            
        }
    }

    function send_email_old($from_email, $from_email_sender, $to_email, $subject, $message) {
        try {
            $CI =& get_instance();

            //configure email settings
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.rediffmailpro.com'; //smtp host name
            $config['smtp_port'] = '587'; //smtp port number
            $config['smtp_user'] = $from_email;
            $config['smtp_pass'] = 'prasad3323'; //$from_email password
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            $CI->email->initialize($config);

            //send mail
            $CI->email->from($from_email, $from_email_sender);
            // $CI->email->to($to_email);
            $CI->email->to('prasad.bhisale@otbconsulting.co.in');
            $CI->email->subject($subject);
            $CI->email->message($message);
            $CI->email->set_mailtype("html");
            return $CI->email->send();

        } catch (Exception $ex) {
            
        }
    }

    function format_money($number, $decimal=2){
        if(!isset($number)) $number=0;

        if($number!=0){
            $negative=false;
            if(strpos($number, '-')!==false){
                $negative=true;
                $number = str_replace('-', '', $number);
            }

            $number = floatval(str_replace(',', '', $number));
            $number = round($number, $decimal);

            $decimal="";
            
            if(strpos($number, '.')!==false){
                $decimal = substr($number, strpos($number, '.'));
                $number = substr($number, 0, strpos($number, '.'));
            }
            
            // echo $decimal . '<br/>';
            // echo $number . '<br/>';

            $len = strlen($number);
            $m = '';
            $number = strrev($number);
            for($i=0;$i<$len;$i++){
                if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                    $m .=',';
                }
                $m .=$number[$i];
            }

            $number = strrev($m);
            $number = $number . $decimal;

            if($negative==true){
                $number = '-' . $number;
            }
        } else {
            $number = '0';
        }
        
        return $number;
    }

    function format_number($number, $decimal=2){
        if(!isset($number)) $number=0;
        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);
        return $number;
    }

    function convert_to_feet($num, $unit){
        $num = format_number($num, 2);
        if($unit=='Sq m'){
            $num = $num * 10.7639;
        } else if($unit=='Sq yard'){
            $num = $num * 9;
        }

        return $num;
    }

    function get_address($address, $landmark, $city, $pincode, $state, $country) {
        if(isset($address)) {
            $address = $address . ',';
        }
        if(isset($landmark)) {
            if($landmark!=''){
                $address = $address . $landmark . ' ';
            }
        }
        if(isset($city)) {
            if($city!=''){
                $address = $address . $city . ' ';
            }
        }
        if(isset($pincode)) {
            if($pincode!=''){
                $address = $address . $pincode . ' ';
            }
        }
        if(isset($state)) {
            if($state!=''){
                $address = $address . $state . ' ';
            }
        }
        if(isset($country)) {
            if($country!=''){
                $address = $address . $country . ' ';
            }
        }

        $address = str_replace(',,,,,', ',', $address);
        $address = str_replace(',,,,', ',', $address);
        $address = str_replace(',,,', ',', $address);
        $address = str_replace(',,', ',', $address);

        if(strpos($address, ',')!==false){
            $address = substr($address, 0, strlen($address)-1);
        }

        return $address;
    }

    function dump($array)
    {
       echo "<pre>";
       print_r($array);
       echo "</pre>";
    }
?>