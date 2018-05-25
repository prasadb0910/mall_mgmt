<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Tax_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}
function getTaxDetail($tax_id=false){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type,tax_action,effective_date');
	if($tax_id !=''){
		$this->db->where('tax_id = '.$tax_id.' ');
	}
	$this->db->where('status = "1" ');
	$this->db->from('tax_master');
	$result=$this->db->get();
	return $result->result();
}
function insertUpdateRecord(){
	$tax_name=$this->input->post('tax_name');
	$tax_perecent=$this->input->post('tax_perecnt');
	$tax_id=$this->input->post('tax_id');
	$effective_date=$this->input->post('effective_date');
	$i=0;

	foreach($tax_name as $row){
		$txn_type=$this->input->post('txn_for_'.($i+1));
		$j=0;
		$d_t_type="";

		foreach($txn_type as $row){
	        if($txn_type[$j]=='purchase'){
	            $d_t_type="purchase, ";
	        }
	        if($txn_type[$j]=='sale'){
	            $d_t_type=$d_t_type . "sale, ";
	        }
	        if($txn_type[$j]=='rent'){
	            $d_t_type=$d_t_type . "rent, ";
	        }
	        if($txn_type[$j]=='loan'){
	            $d_t_type=$d_t_type . "loan, ";
	        }
	        if($txn_type[$j]=='maintenance'){
	            $d_t_type=$d_t_type . "maintenance, ";
	        }
	        if($txn_type[$j]=='valuation'){
	            $d_t_type=$d_t_type . "valuation, ";
	        }

			$j++;
		}

		$d_t_type = substr($d_t_type, 0, strrpos($d_t_type, ", "));

		if($tax_id[0] !='' && $i==0){
			$update_array=array(
				"tax_name" => $tax_name[$i],
				"tax_percent"=> $tax_perecent[$i],
				"tax_action"=>$this->input->post('txn_type_'.($i+1)),
				"txn_type"=>$d_t_type,
				"effective_date"=>FormatDate($effective_date[$i]),
				"modified_by"=>$this->session->userdata('session_id'),
				"modified_date"=>date('Y-m-d'),
				"status"=>'1'
			);
			$this->db->where('tax_id = '.$tax_id[$i].' and status="1" ');
			$this->db->update('tax_master',$update_array);
			//exit;
		} else {
			
			$insert_array=array(
				"tax_name" => $tax_name[$i],
				"tax_percent"=> $tax_perecent[$i],
				"tax_action"=>$this->input->post('txn_type_'.($i+1)),
				"txn_type"=>$d_t_type,
				"effective_date"=>FormatDate($effective_date[$i]),											
				"created_by"=>$this->session->userdata('session_id'),
				"create_date"=>date('Y-m-d'),
				"status"=>'1'
			);
			$this->db->insert('tax_master',$insert_array);
		}
		$i++;
	}
	//return true;
}

}
?>