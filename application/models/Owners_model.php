<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Owners_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}

function getCityList($term){
	// $this->db->select('id,city_name,state_id');
	// $this->db->from('city_master');
	// $this->db->where('status = "1" and city_name like "%'.$term.'%" ');
	// $result=$this->db->get();

	$result=$this->db->query("select id,city_name,state_id from city_master where status = '1' and city_name like '%" . $term . "%' 
                            order by case when city_name = '" . $term . "' then 1 
                            when city_name like '%" . $term . "%' then 2 end;");
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->city_name,"state_id"=>$row->state_id);

	}
	return $datatarray;
}

function getStateCountryByCity($state_id){
	$this->db->select('sm.state_name , cm.country_name,cm.id as country_id ');
	$this->db->from('state_master sm,country_master cm');
	$this->db->where('cm.id = sm.country_id and sm.id = '.$state_id.' ');
	$result=$this->db->get();
	//echo $this->db->last_query();
foreach($result->result() as $row){
	$response=array("status"=>true,"state_name"=>$row->state_name,"country_id"=>$row->country_id,"country_name"=>$row->country_name);
}
return $response;
}

function loadcountry($text){
	// $this->db->select('id,country_name');
	// $this->db->from('country_master');
	// $this->db->where('status = "1" and country_name like "%'.$text.'%" ');
	// $result=$this->db->get();

	$result=$this->db->query("select id,country_name from country_master where status = '1' and country_name like '%" . $text . "%' 
                            order by case when country_name = '" . $text . "' then 1 
                            when country_name like '%" . $text . "%' then 2 end;");
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->country_name);

	}
	return $datatarray;
}

function loadState($text){
	// $this->db->select('id,state_name');
	// $this->db->from('state_master');
	// $this->db->where('status = "1" and state_name like "%'.$text.'%" ');
	// $result=$this->db->get();
	
	$result=$this->db->query("select id,state_name from state_master where status = '1' and state_name like '%" . $text . "%' 
                            order by case when state_name = '" . $text . "' then 1 
                            when state_name like '%" . $text . "%' then 2 end;");
	foreach($result->result() as $row){
		$datatarray[]=array("id"=>$row->id,"label"=>$row->state_name);

	}
	return $datatarray;
}



}
?>