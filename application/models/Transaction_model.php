<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Transaction_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function insertRPDetails($ref_id, $type){
    $related_party=$this->input->post('related_party[]');
    $related_party_remarks=$this->input->post('related_party_remarks[]');

    for($i=0;$i<count($related_party);$i++) {
        if($related_party[$i]!="" && $related_party[$i]!=null) {
            $data = array(
                        'ref_id' => $ref_id,
                        'type' => $type,
                        'contact_id' => $related_party[$i],
                        'remarks' => $related_party_remarks[$i]
                    );
            $this->db->insert('related_party_details', $data);
        }
    }
}

function insertPendingActivity($ref_id, $type){
    $pending_activity=$this->input->post('pending_activity[]');
    for ($i=0; $i < count($pending_activity); $i++) {
        if($pending_activity[$i]!="" && $pending_activity[$i]!=null) {
            $data = array(
                        'ref_id' => $ref_id,
                        'type' => $type,
                        'pending_activity' => $pending_activity[$i]
                    );
            $this->db->insert('pending_activity', $data);
        }
    }
}

}
?>