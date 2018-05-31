<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Task_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->model('purchase_model');
}

function getPropertyDetails($txn_id='0') {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    $sql="select * from property_txn where gp_id = '$gid' and txn_status = 'Approved'";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getSubPropertyDetails($property_id='0') {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    $sql="select * from sub_property_allocation where property_id = '$property_id' and txn_status = 'Approved'";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function  getUsers($user_id){
	$this->db->select('cm.c_id,concat_ws(" ",cm.c_name,cm.c_last_name) name ,concat_ws("-",cm.c_emailid1,cm.c_mobile1) as name2 ');
	$this->db->from(' group_users gu ');
	$this->db->where('gu.gu_id = '.$user_id.' ');
	$this->db->join('contact_master cm','cm.c_id = gu.gu_cid','inner');
	$result=$this->db->get();
	//echo $this->db->last_query();
	$dataarray=array();
	$i=0;
	foreach($result->result() as $row){			
            $dataarray= array('value' => $row->c_id , 'label' => $row->name . ' - ' . $row->name2);
        }
	return $dataarray;
}

function testFormData($form_data) {
	$newArray=array();
	//print_r($form_data);

	$subject_detail=$form_data['subject_detail'];
	$description=$form_data['description'];
	$priority=$form_data['priority'];
	$from_time=$form_data['from_time'];
	$to_time=$form_data['to_time'];
	$repeat=$form_data['repeat'];
	$interval2=$form_data['monthly_interval2'];
	$property=$form_data['property'];
	$owner_name=$form_data['owner_name'];

	if($form_data['repeat']=='Weekly'){
		//print_r($form_data['weekly_interval']);
		$interval=implode(',',$form_data['weekly_interval']);
	}elseif($form_data['repeat']=='Periodically'){
		$interval=$form_data['periodic_interval'];
	}elseif($form_data['repeat']=='Monthly'){
		$interval=$form_data['monthly_interval'];
	}else{
		$interval='';
	}

	if(isset($form_data['self_assigned'])){
		if($form_data['self_assigned'] =='self'){
		$assign_to=$this->session->userdata('session_id');
		}else{
			$assign_to=$form_data['assigned'];
		}
	}else{
		$assign_to=$form_data['assigned'];
	}

	$from_date = FormatDate($form_data['from_date']);
	$to_date = FormatDate($form_data['to_date']);
	$due_date = FormatDate($form_data['from_date']);
	$cur_date = date('Y-m-d');
	$week_index=0;

	while($due_date<=$to_date) {
		// echo $due_date . ' ';

		if($due_date>=$cur_date) {
			// echo 'Insert ';
		}

		if($repeat=="Never") {
			break;
		} else if($repeat=="Daily") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 days"));
		} else if($repeat=="Periodically") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+".$interval." days"));
		} else if($repeat=="Weekly") {
			$week_day="";

			if (isset($form_data['weekly_interval'][$week_index])) {
				$week_day=$form_data['weekly_interval'][$week_index];
				$week_index=$week_index+1;
				if (! isset($form_data['weekly_interval'][$week_index])) {
					$week_index=0;
				}
			}

			if($week_day=="Mon") $week_day="monday";
			else if($week_day=="Tue") $week_day="tuesday";
			else if($week_day=="Wed") $week_day="wednesday";
			else if($week_day=="Thu") $week_day="thursday";
			else if($week_day=="Fri") $week_day="friday";
			else if($week_day=="Sat") $week_day="saturday";
			else if($week_day=="Sun") $week_day="sunday";

			// echo $week_day;

			if($week_day!=''){
				$date = new DateTime($due_date);
				$date->modify('next ' . $week_day);
				$due_date = $date->format('Y-m-d');
			}

		} else if($repeat=="Monthly") {
			$date = explode('-',$due_date);
			$due_date = $date[0] . '-' . strval(intval($date[1])+intval($interval)) . '-' . $interval2;
			$d = DateTime::createFromFormat("Y-m-d", $due_date);
			$due_date = strval($d->format('Y-m-d'));
		} else if($repeat=="Yearly") {
			$due_date = date ("Y-m-d", strtotime ($due_date ."+1 years"));
		}
	}
}

function get_contact_details($c_id){
	$sql="select * from contact_master where c_id = '$c_id'";
	$query=$this->db->query($sql);
	return $query->result();
}

function get_task_list_table($subject, $assigned_to, $priority, $status) {
    $table='';
    $table='<div>
            <table style="border-collapse: collapse; border: 1px solid black;">
                <thead>
                    <tr>
                        <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                        <th style="padding:5px; border: 1px solid black;" width="100">Task Name</th>
                        <th style="padding:5px; border: 1px solid black;" width="100">Assigned To</th>
                        <th style="padding:5px; border: 1px solid black;" width="90">Priority</th>
                        <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                    </tr>
                </thead>
                <tbody>';

    $table=$table.'<tr>
                    <td style="padding:5px; border: 1px solid black;">1</td>
                    <td style="padding:5px; border: 1px solid black;">'.$subject.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$assigned_to.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$priority.'</td>
                    <td style="padding:5px; border: 1px solid black;">'.$status.'</td>
                </tr>';

    $table=$table.'</tbody></table></div>';

    // echo $table;
    return $table;
}

function insertDetails($form_data) {
	$gid=$this->session->userdata('groupid');

	$id=$form_data['id'];
	$subject_detail=$form_data['subject_detail'];
	$description=$form_data['description'];
	$task_status=$form_data['task_status'];

	$self_assigned = '0';
	$contact[0]=$form_data['contact'];
	if(isset($form_data['self_assigned'])){
		if($form_data['self_assigned']=='1'){
			$self_assigned = '1';
			$contact[0] = $this->session->userdata('session_id');
		}
	}

	$request_initiated_date = FormatDate($form_data['request_initiated_date']);
	$request_due_date = FormatDate($form_data['request_due_date']);
	$started_to_work_date = FormatDate($form_data['started_to_work_date']);
	$completed_work_date = FormatDate($form_data['completed_work_date']);

	$priority=$form_data['priority'];
	$property=$form_data['property'];
	$sub_property=$form_data['sub_property'];
	$owner_name=$form_data['owner_name'];

	$check_in_date = FormatDate($form_data['check_in_date']);

	$time1='0';
	$time2='0';
	$time3='0';
	$time4='0';
	if(isset($form_data['time1'])){
		if($form_data['time1']=='1'){
			$time1='1';
		}
	}
	if(isset($form_data['time2'])){
		if($form_data['time2']=='1'){
			$time2='1';
		}
	}
	if(isset($form_data['time3'])){
		if($form_data['time3']=='1'){
			$time3='1';
		}
	}
	if(isset($form_data['time4'])){
		if($form_data['time4']=='1'){
			$time4='1';
		}
	}

	$newArray=array();
	$assign_to=$contact[0];
	$insertArray=array(
					'subject_detail' => $subject_detail,
					'message_detail' => $description,
					'task_status' => $task_status,
					'self_assigned' => $self_assigned,
					'user_id' =>$assign_to,
					'request_initiated_date' =>$request_initiated_date,
					'request_due_date' =>$request_due_date,
					'started_to_work_date' =>$started_to_work_date,
					'completed_work_date' =>$completed_work_date,
					'priority' => $priority,
					'property_id'=>$property,
					'sub_property_id'=>$sub_property,
					'owner_id'=>$owner_name,
					'check_in_date' => $check_in_date,
					'time1' => $time1,
					'time2' => $time2,
					'time3' => $time3,
					'time4' => $time4,
					'status'=>'1',
					'gp_id'=>$gid
				);

	$cur_date = date('Y-m-d H:i:s');
	if($id=='' || $id==null){
		$insertExtra=array(
			'created_by' => $this->session->userdata('session_id'),
			'created_on' => $cur_date
			);
		$newArray=array_merge($insertArray,$insertExtra);
		$this->db->insert('user_task_detail', $newArray);

		$logarray['table_id']=$this->db->insert_id();
	    $logarray['module_name']='Task';
	    $logarray['cnt_name']='Task';
	    $logarray['action']='Task Record Inserted';
	    $logarray['gp_id']=$gid;
	    $this->user_access_log_model->insertAccessLog($logarray);
	} else {
		$insertExtra=array(
			'updated_by' => $this->session->userdata('session_id'),
			'updated_on' => $cur_date
			);
		$newArray=array_merge($insertArray,$insertExtra);
        $this->db->where('id', $id);
		$this->db->update('user_task_detail', $newArray);

		$logarray['table_id']=$id;
	    $logarray['module_name']='Task';
	    $logarray['cnt_name']='Task';
	    $logarray['action']='Task Record Modified';
	    $logarray['gp_id']=$gid;
	    $this->user_access_log_model->insertAccessLog($logarray);
	}

	$assignee_names="";
	for($i=0; $i<count($contact); $i++) {
		$assign_to=$contact[$i];
		$result=$this->get_contact_details($assign_to);
		if(count($result)>0){
			$assignee_name="";
	        if(isset($result[0]->c_name)){
	            $assignee_name=$result[0]->c_name;
	        }
	        if(isset($result[0]->c_last_name)){
	            $assignee_name=$assignee_name.' '.$result[0]->c_last_name;
	        }
	        $assignee_names=$assignee_names.$assignee_name.', ';
			$assignee_email=$result[0]->c_emailid1;

		    $from_email = 'info@pecanreams.com';
		    $from_email_sender = 'Pecan REAMS';
		    $subject = 'Task Intimation';

		    $table=$this->get_task_list_table($subject_detail, $assignee_name, $priority, 'Pending');

		    $message = '<html><head></head><body>Dear '.$assignee_name.'<br /><br />
		                We would like to bring to your notice that a New Task Entry has been assigned to you. 
		                The Task details are as follows.<br /><br />' . $table . '<br /><br />
		                If the above Task is incorrectly assigned to you please reject the same immediately.<br /><br />Thanks</body></html>';
		    $mailSent=send_email($from_email,  $from_email_sender, $assignee_email, $subject, $message);
		    // print_r($mailSent);
		}
	}

	if(strpos($assignee_names, ', ')>0){
        $assignee_names=substr($assignee_names,0,strripos($assignee_names, ', '));
    }

	$assigner=$this->session->userdata('session_id');
	$result=$this->get_contact_details($assigner);
	if(count($result)>0){
		$assigner_name="";
        if(isset($result[0]->c_name)){
            $assigner_name=$result[0]->c_name;
        }
        if(isset($result[0]->c_last_name)){
            $assigner_name=$assigner_name.' '.$result[0]->c_last_name;
        }
		$assigner_email=$result[0]->c_emailid1;

		$group_owner_names="";
		$group_owners=$this->purchase_model->get_group_owners($gid);
		if(count($group_owners)>0){
	        for($i=0;$i<count($group_owners);$i++){
	            $owner_name="";
	            if(isset($group_owners[$i]->c_name)){
	                $owner_name=$group_owners[$i]->c_name;
	            }
	            if(isset($group_owners[$i]->c_last_name)){
	                $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
	            }
	            $group_owner_names=$group_owner_names.$owner_name.', ';
	        }
	        if(strpos($group_owner_names, ', ')>0){
	            $group_owner_names=substr($group_owner_names,0,strripos($group_owner_names, ', '));
	        }
	    }

	    $from_email = 'info@pecanreams.com';
	    $from_email_sender = 'Pecan REAMS';
	    $subject = 'Task Intimation';

	    $table=$this->get_task_list_table($subject_detail, $assignee_names, $priority, 'Pending');

	    $message = '<html><head></head><body>Dear '.$assigner_name.'<br /><br />
	                We would like to bring to your notice that a New Task Entry has been created by you for '.$group_owner_names.'. 
	                The Task details are as follows.<br /><br />' . $table . '<br /><br />
	                If the above Task is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
	    $mailSent=send_email($from_email,  $from_email_sender, $assigner_email, $subject, $message);
    	// print_r($mailSent);
	}
}

function getTaskList($user_id='',$task_type=''){
	if($task_type=='mytask' ||  $task_type==false){
		$cond=" and (user_id='$user_id')";
	} else if($task_type=='pending'){
		$cond=" and (created_by='$user_id' or user_id='$user_id') and task_status = 'pending'";
	} else if($task_type=='assigned'){
		$cond=" and (created_by='$user_id' and user_id!='$user_id')";
	} else if($task_type=='completed'){
		$cond=" and (created_by='$user_id' or user_id='$user_id') and task_status = 'completed'";
	} else {
		$cond="";
	}

	$gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    // $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$user_id'");
    $result=$query->result();

    if (count($result)>0) {
    	$sql="select G.*, datediff(G.due_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
    		G.updated_on as completed_on,H.owner_name from 
			(select E.*, F.sp_name from 
			(select C.*, D.p_property_name from 
			(select A.*, concat_ws(' ', B.c_name, B.c_last_name) as created_by_name from 
			(select A.*, concat_ws(' ', B.c_name, B.c_last_name) as name from 
			(select * from user_task_detail where gp_id = '$gid' and status='1' and 
													property_id in (select distinct purchase_id from purchase_ownership_details 
			                                        where pr_client_id in (select distinct owner_id from user_role_owners 
			                                            where user_id = '$user_id'))".$cond.") A 
			left join 
			(select * from contact_master where c_gid='$gid') B 
			on (A.user_id=B.c_id)) A 
			left join 
			(select * from contact_master where c_gid='$gid') B 
			on (A.created_by=B.c_id)) C 
			left join 
			(select * from purchase_txn where gp_id = '$gid') D 
			on (C.property_id = D.txn_id)) E 
			left join 
			(select * from sub_property_allocation where gp_id = '$gid') F 
			on (E.sub_property_id = F.txn_id)) G 
			left join 
			(select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            on (A.pr_client_id=B.c_id)) H 
			on G.property_id = H.purchase_id";
    } else {
    	$sql="select G.*, datediff(G.due_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
    		G.updated_on as completed_on,H.owner_name from 
			(select E.*, F.sp_name from 
			(select C.*, D.p_property_name from 
			(select A.*, concat_ws(' ', B.c_name, B.c_last_name) as created_by_name from 
			(select A.*, concat_ws(' ', B.c_name, B.c_last_name) as name from 
			(select * from user_task_detail where gp_id = '$gid' and status='1' ".$cond.") A 
			left join 
			(select * from contact_master where c_gid='$gid') B 
			on (A.user_id=B.c_id)) A 
			left join 
			(select * from contact_master where c_gid='$gid') B 
			on (A.created_by=B.c_id)) C 
			left join 
			(select * from purchase_txn where gp_id = '$gid') D 
			on (C.property_id = D.txn_id)) E 
			left join 
			(select * from sub_property_allocation where gp_id = '$gid') F 
			on (E.sub_property_id = F.txn_id)) G 
			left join 
			(select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
            where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            on (A.pr_client_id=B.c_id)) H 
			on G.property_id = H.purchase_id";
    }
    $query=$this->db->query($sql);
    return $query->result();




	// $where="ut.created_by = '".$user_id."' and ut.status='1' ";
	// $where2="ut.user_id = '".$user_id."' and ut.created_by != '".$user_id."' and ut.status='1' ";
	// if($task_type=='mytask' ||  $task_type==false){
	// 	$where2="ut.user_id = '".$user_id."' and ut.status='1' ";
	// }
	// if($task_type=='pending' ||  $task_type==false){
	// 	$where="ut.created_by = '".$user_id."' and ut.status='1' and ut.task_status = 'pending' ";
	// 	$where2="ut.user_id = '".$user_id."' and ut.created_by != '".$user_id."' and ut.status='1' and ut.task_status = 'pending' ";
	// }
	// if($task_type=='assigned'){
	// 	$where2="ut.created_by = '".$user_id."' and ut.user_id != '".$user_id."' and ut.status='1'";
	// }
	// if($task_type=='completed'){
	// 	$where="ut.created_by = '".$user_id."' and ut.status='1' and ut.task_status = 'completed' ";
	// 	$where2="ut.user_id = '".$user_id."' and ut.created_by != '".$user_id."' and ut.status='1' and ut.task_status = 'completed' ";
	// }

	// $result1=array();
	// if($task_type=='all' || $task_type=='pending' || $task_type=='completed' || $task_type==false){
	//     $this->db->select("p.p_property_name ,ut.id,ut.task_id,concat_ws(' ',cm.c_name,cm.c_last_name) name, 
	//     					concat_ws(' ',cm2.c_name,cm2.c_last_name) created_by_name, ut.subject_detail,ut.message_detail,
	//     					ut.priority,ut.from_date,ut.to_date,ut.task_status,ut.due_date,
	//     					datediff(ut.due_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days,
	//     					ut.updated_on as completed_on,case when B.ow_type = '0' then 
 //                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
 //                                where c_id = B.ow_ind_id) 
 //                            when B.ow_type = '1' then B.ow_huf_name 
 //                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
 //                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
 //                            when B.ow_type = '4' then B.ow_llp_comapny_name 
 //                            when B.ow_type = '5' then B.ow_prt_comapny_name 
 //                            when B.ow_type = '6' then B.ow_aop_comapny_name 
 //                            when B.ow_type = '7' then B.ow_trs_comapny_name 
 //                        	else B.ow_proprietorship_comapny_name end as owner_name");
	//     $this->db->where($where);
	//     $this->db->where("A.pr_client_id=B.ow_id and A.purchase_id = ut.property_id");
	//     if($task_type !=='all'){
	//     	$this->db->where('ut.follower = "No" ');
	//     }
	//     $this->db->from("user_task_detail ut,purchase_ownership_details A, owner_master B");
	//     $this->db->join("contact_master cm","cm.c_id = ut.user_id ","left");
	// 	$this->db->join("contact_master cm2","cm2.c_id = ut.created_by ","left");		
	// 	$this->db->join("purchase_txn p","p.txn_id = ut.property_id","inner");

	// 	$this->db->order_by("ut.due_date");
	//     $result1=$this->db->get()->result();
	//    	echo $this->db->last_query() . '<br>';
	// }

	// $result2=array();

	// $this->db->select("p.p_property_name,ut.id,ut.task_id,concat_ws(' ',cm.c_name,cm.c_last_name) name, concat_ws(' ',cm2.c_name,cm2.c_last_name) created_by_name, ut.subject_detail,ut.message_detail,ut.priority,ut.from_date,ut.to_date,ut.task_status,ut.due_date,datediff(ut.due_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days,ut.updated_on as completed_on,case when B.ow_type = '0' then 
 //                                (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
 //                                where c_id = B.ow_ind_id) 
 //                            when B.ow_type = '1' then B.ow_huf_name 
 //                            when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
 //                            when B.ow_type = '3' then B.ow_ltd_comapny_name 
 //                            when B.ow_type = '4' then B.ow_llp_comapny_name 
 //                            when B.ow_type = '5' then B.ow_prt_comapny_name 
 //                            when B.ow_type = '6' then B.ow_aop_comapny_name 
 //                            when B.ow_type = '7' then B.ow_trs_comapny_name 
 //                        	else B.ow_proprietorship_comapny_name end as owner_name");
	// $this->db->where($where2);
	// // $this->db->from("user_task_detail ut ");
	//     $this->db->where("A.pr_client_id=B.ow_id and A.purchase_id = ut.property_id");
	//      if($task_type !=='all'){
	//     	$this->db->where('ut.follower = "No" ');
	//     }
	//     $this->db->from("user_task_detail ut,purchase_ownership_details A, owner_master B");
	
	// $this->db->join("contact_master cm","cm.c_id = ut.user_id ","left");
	// $this->db->join("contact_master cm2","cm2.c_id = ut.created_by ","left");
	// $this->db->join("purchase_txn p","p.txn_id = ut.property_id","inner");
	// $this->db->order_by("ut.due_date");
	// $result2=$this->db->get()->result();
	// echo $this->db->last_query() . '<br>';

	// $result=array_merge($result1,$result2);
	// return $result;
}

function getTaskDetail($task_id){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');


			// $this->db->select("ut.id as id,concat(cm.c_name,' ',cm.c_last_name) as name, ut.*");
   //          $this->db->where("ut.id = ".$task_id." and ut.status='1' ");
   //          $this->db->from("user_task_detail ut ");
   //          $this->db->join("contact_master cm","cm.c_id = ut.user_id ","left");
   //          $result1=$this->db->get()->row();
			// return $result1;

	// $sql="select C.*, D.owner_name from 
	// 	(select A.*, concat(B.c_name,' ',B.c_last_name,' - ',c_emailid1,' - ',c_mobile1) as name from 
	// 	(select * from user_task_detail where id='$task_id') A 
	// 	left join 
	// 	(select * from contact_master where c_gid = '$gid') B 
	// 	on (A.user_id=B.c_id)) C 
	// 	left join 
	// 	(select ow_id, case when ow_type = '0' then 
	// 	                            (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
	// 	                            where c_id = ow_ind_id) 
	// 	                        when ow_type = '1' then ow_huf_name 
	// 	                        when ow_type = '2' then ow_pvtltd_comapny_name 
	// 	                        when ow_type = '3' then ow_ltd_comapny_name 
	// 	                        when ow_type = '4' then ow_llp_comapny_name 
	// 	                        when ow_type = '5' then ow_prt_comapny_name 
	// 	                        when ow_type = '6' then ow_aop_comapny_name 
	// 	                        when ow_type = '7' then ow_trs_comapny_name 
 //                        		else ow_proprietorship_comapny_name end as owner_name from owner_master where ow_gid = '$gid') D 
	// 	On (C.owner_id=D.ow_id)";

	$sql="select C.*, D.owner_name from 
		(select A.*, concat(B.c_name,' ',B.c_last_name,' - ',c_emailid1,' - ',c_mobile1) as name from 
		(select * from user_task_detail where id='$task_id') A 
		left join 
		(select * from contact_master where c_gid = '$gid') B 
		on (A.user_id=B.c_id)) C 
		left join 
		(select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') D 
		On (C.owner_id=D.c_id)";

	$query=$this->db->query($sql);
    $result=$query->row();
    return $result;
}

function getTaskUsers($task_id){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select A.user_id, concat(B.c_name,' ',B.c_last_name,' - ',c_emailid1,' - ',c_mobile1) as name from 
		(select distinct user_id from user_task_detail where task_id='$task_id' and follower = 'No'  and user_id!='$session_id') A 
		left join 
		(select * from contact_master where c_gid = '$gid') B 
		on (A.user_id=B.c_id)";

	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getTaskFollower($task_id){
 $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select A.user_id, concat(B.c_name,' ',B.c_last_name,' - ',c_emailid1,' - ',c_mobile1) as name from 
		(select distinct user_id from user_task_detail where task_id='$task_id' and follower = 'Yes'  and user_id!='$session_id') A 
		left join 
		(select * from contact_master where c_gid = '$gid') B 
		on (A.user_id=B.c_id)";

	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function checkSelfTask($task_id){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

	$sql="select * from user_task_detail where task_id='$task_id' and user_id='$session_id'";
	$query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getTaskCount($tasktype){
	// echo $tasktype . '<br>';

	$task_count=0;
	$all_task=0;
	$mytask=0;
	if($tasktype=='all' || $tasktype=='pending'){
		$this->db->select('count(id) as cnt ');
		$this->db->from('user_task_detail');
		$this->db->where('created_by = '.$this->session->userdata("session_id").' and status = "1" ');
		if($tasktype=='pending'){
			$this->db->where('task_status = "pending" ');
		}
		if($tasktype !='all'){
			$this->db->where('follower = "No" ');
		}
		$result=$this->db->get();

		// echo $this->db->last_query() . '<br>';
		$all_task=$result->row()->cnt;
	}
	if($tasktype=='all' || $tasktype=='mytask'){
		$this->db->select('count(id) as cnt ');
		$this->db->from('user_task_detail');
		if($tasktype=='all'){
			$this->db->where(' user_id = '.$this->session->userdata("session_id").' and created_by != '.$this->session->userdata("session_id").' ');
		}else{
			$this->db->where(' user_id = '.$this->session->userdata("session_id").' ');
		}
		if($tasktype !='all'){
			$this->db->where('follower = "No" ');
		}
		$result2=$this->db->get();
		// echo $this->db->last_query() . '<br>';
		$mytask=$result2->row()->cnt;
	}
	
	$task_count=$all_task + $mytask;

	return $task_count;
}

function getContactId(){
	$this->db->select('gu_cid');
	$this->db->from('group_users');
	$this->db->where('gu_id = '.$this->session->userdata("session_id").' ');
	$cid=$this->db->get()->row()->gu_cid;
	return $cid;
}

function deleteRecord($task_id){
	$gid=$this->session->userdata('groupid');
	$this->db->select('id');
	$this->db->from('user_task_detail');
	$this->db->where('id = '.$task_id.' and status = "1" ');
	$result=$this->db->get();
	if($result->num_rows() > 0){
		$update_array=array(
			"status" => "3",
			"updated_by" => $this->session->userdata('session_id'));
		$this->db->where('id = '.$task_id.' ');
		$this->db->update('user_task_detail',$update_array);
		$logarray['table_id']=$task_id;
	    $logarray['module_name']='Task';
	    $logarray['cnt_name']='Task';
	    $logarray['action']='Task Record Deleted';
	    $logarray['gp_id']=$gid;
	    $this->user_access_log_model->insertAccessLog($logarray);
		$response=array("status"=>true,"msg"=>"Record Deleted Successfully");
	}else{
		$response=array("status"=>false,"msg"=>"unable to delete record");
	}
	return $response;
}

function completeTask($task_id){
	$this->db->select('id');
	$this->db->from('user_task_detail');
	$this->db->where('id = '.$task_id.' and status = "1" ');
	$result=$this->db->get();
	if($result->num_rows() > 0){
		$update_array=array(
			"task_status" => "Completed",
			"updated_by" => $this->session->userdata('session_id'),
			"updated_on" => date('Y-m-d H:i:s'));
		$this->db->where('id = '.$task_id.' ');
		$this->db->update('user_task_detail',$update_array);
		$response=array("status"=>true,"msg"=>"Task Completed Successfully");
	}else{
		$response=array("status"=>false,"msg"=>"unable to complete task");
	}
	return $response;
}

function addCommentTask($comm_array){
	$this->db->insert('user_task_comment',$comm_array);
}


function getCommentDetail($task_id){
	$this->db->select("concat_ws(' ',cm.c_name,cm.c_last_name) name,u.comment");
	$this->db->from('contact_master cm, user_task_comment u');
	$this->db->where('cm.c_id = u.user_id  and u.task_id = '.$task_id.'  ');
	$result=$this->db->get();
	return $result->result();
}

}
?>