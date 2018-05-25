<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class upload_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //get the username & password from tbl_usrs
//    public function upload_image($filename)
//    {
//        if(count($filename)>0)
//        {
//            $filename1 = explode(',',$filename);
//            foreach($filename1 as $file)
//            {
//                $file_data = array(
//                'name' => $file,
//                'date_time' => date('Y-m-d h:i:s')
//                );
//                $this->db->insert('uploaded_files', $file_data);
//            }
//        }
//    }
    
    public function upload_image($file_data)
    {
        $this->db->insert('uploaded_files', $file_data);
    }
    
    function get_upload_id()
    {
        $sql= 'select max(id) as max_id from uploaded_files';
        $query = $this->db->query($sql);
        return $query;
    }
    
    function delete_upload_id($upload_id)
    {
        $sql= "delete from uploaded_files where id = '" . $upload_id . "'";
        $this->db->query($sql);
    }
}?>