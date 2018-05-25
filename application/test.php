<?php
class test extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->helper('common_functions');
        
    }

	public function index(){

		echo "this is test";

	}

	public function abc(){

        $data['userdata'] = $this->session->all_userdata();
		$this->load->view('test1');
	}

	 public function display($a=50, $b=50){
    	$query=$this->db->query("SELECT * FROM contact_master");
    	$result=$query->result();

    	$data['contact']=$result;
        load_view('test2', $data);
    }

	public function insert(){

    $data  = array
    	(
    		'c_id'=>'49',
    		'c_name'=> 'xyz',
    		);
    $this->db->insert('contact_master', $data);
    $this->display();
	}

	public function update(){

    $data  = array
    	(
    		'c_id'=>'48',
    		'c_name'=> 'xyz',
    		);
    $this->db->insert('contact_master', $data);
   
	}

	public function delete(){

		$this->db->where('c_name','wer');
		$this->db->delete('contact_master');
		$this->display();
	}

	public function save(){

        $data['userdata'] = $this->session->all_userdata();
		$this->load->view('test2',$data);
	}
}

?>