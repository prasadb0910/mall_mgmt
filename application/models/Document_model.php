<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Document_model Extends CI_Model{

	function __Construct(){
		parent :: __construct();
	}

	public function add_new_doc($type='', $d_t_type=''){
        // $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
        // 						'' as doc_documentname, '' as d_show_expiry_date, 
        //                         '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
        //                         '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
        //                         from document_type_master");
        // $result=$query->result();
        // $data['documents']=$result;

        // for($i=0; $i<count($result); $i++){
        //     $d_type_id = $result[$i]->d_type_id;

        //     if($type!=''){
        //         $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
        //                                 (select * from document_types where d_type_id='$d_type_id') A 
        //                                 left join 
        //                                 (select * from document_master where ".$type."='Yes') B 
        //                                 on (A.d_id=B.d_id)) C where C.d_documentname is not null");
        //     } else {
        //         $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
        //                                 (select * from document_types where d_type_id='$d_type_id') A 
        //                                 left join 
        //                                 (select * from document_master) B 
        //                                 on (A.d_id=B.d_id)) C where C.d_documentname is not null");
        //     }
            
        //     $data['docs'][$d_type_id]=$query->result();
        // }

        $query=$this->db->query("select * from document_type_master");
        $result=$query->result();
        $data['doc_types']=$result;

        $query=$this->db->query("select * from document_master");
        $result=$query->result();
        $data['doc_details']=$result;

        $cond1='';
        $cond2='';

        if($type!=''){
            $cond2 = " where ".$type."='Yes'";
        }


        if($d_t_type!=''){
            $cond1 = " where d_t_type like '%".$d_t_type."%'";

            if($cond2==''){
                $cond2 = " where d_t_type like '%".$d_t_type."%'";
            } else {
                $cond2 = $cond2 . " and d_t_type like '%".$d_t_type."%'";
            }
        }

        $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                '' as doc_documentname, '' as d_show_expiry_date, 
                                '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name  
                                from document_type_master");
        $result=$query->result();
        $data['documents']=$result;

        for($i=0; $i<count($result); $i++){
            $d_type_id = $result[$i]->d_type_id;

            $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                    (select * from document_types where d_type_id='$d_type_id') A 
                                    left join 
                                    (select * from document_master".$cond2.") B 
                                    on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            $data['docs'][$d_type_id]=$query->result();
        }

        return $data;
    }

    public function view_doc($type='', $doc_ref_id='', $doc_ref_type=''){
        $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                                (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                                (select * from document_details where doc_ref_id='$doc_ref_id' and doc_ref_type='$doc_ref_type') A 
                                left join 
                                (select * from document_type_master) B 
                                on (A.doc_type_id=B.d_type_id)) C 
                                left join 
                                (select * from document_master) D 
                                on (C.doc_doc_id=D.d_id)");
        $result=$query->result();
        $data['documents']=$result;

        for($i=0; $i<count($result); $i++){
            $d_type_id = $result[$i]->d_type_id;

            $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                    (select * from document_types where d_type_id='$d_type_id') A 
                                    left join 
                                    (select * from document_master where ".$type."='Yes') B 
                                    on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            $data['docs'][$d_type_id]=$query->result();
        }
        
        $query=$this->db->query("select * from document_type_master");
        $result=$query->result();
        $data['doc_types']=$result;

        $query=$this->db->query("select * from document_master");
        $result=$query->result();
        $data['doc_details']=$result;

        return $data;
    }

    public function edit_view_doc($type='', $doc_ref_id='', $doc_ref_type='', $d_t_type=''){
        $cond1='';
        $cond2='';

        if($type!=''){
            $cond2 = " where ".$type."='Yes'";
        }


        if($d_t_type!=''){
            $cond1 = " where d_t_type like '%".$d_t_type."%'";

            if($cond2==''){
                $cond2 = " where d_t_type like '%".$d_t_type."%'";
            } else {
                $cond2 = $cond2 . " and d_t_type like '%".$d_t_type."%'";
            }
        }

        $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                                (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                                (select * from document_details where doc_ref_id='$doc_ref_id' and doc_ref_type='$doc_ref_type') A 
                                left join 
                                (select * from document_type_master) B 
                                on (A.doc_type_id=B.d_type_id)) C 
                                left join 
                                (select * from document_master".$cond1.") D 
                                on (C.doc_doc_id=D.d_id)");
        $result=$query->result();
        $data['documents']=$result;

        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $d_type_id = $result[$i]->d_type_id;
                $d_id = $result[$i]->doc_doc_id;

                $query=$this->db->query("select * from document_types where d_id='$d_id' and d_type_id='$d_type_id'");
                $qur_res=$query->result();

                if(count($qur_res)>0){
                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master".$cond2.") B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");
                    $data['docs'][$d_type_id]=$query->result();
                } else {
                    $data['docs'][$d_type_id]=array();
                }
            }
        } else {
            $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                    '' as doc_documentname, '' as d_show_expiry_date, 
                                    '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                    '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name  
                                    from document_type_master");
            $result=$query->result();
            $data['documents']=$result;

            for($i=0; $i<count($result); $i++){
                $d_type_id = $result[$i]->d_type_id;

                $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                        (select * from document_types where d_type_id='$d_type_id') A 
                                        left join 
                                        (select * from document_master".$cond2.") B 
                                        on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                $data['docs'][$d_type_id]=$query->result();
            }
        }
        
        $query=$this->db->query("select * from document_type_master");
        $result=$query->result();
        $data['doc_types']=$result;

        $query=$this->db->query("select * from document_master");
        $result=$query->result();
        $data['doc_details']=$result;

        return $data;
    }

    public function insert_doc($doc_ref_id='', $doc_ref_type='') {
        // if ($ow_status!="Delete" || $rec_status=="Approved") {
            // $query=$this->db->query("SELECT * FROM document_details WHERE doc_ref_id = '$doc_ref_id' and doc_ref_type = '$doc_ref_type'");
            // $result=$query->result();
            // $file_path_db=NULL;
            // $file_path_count=0;

            // for ($i=0; $i < count($result) ; $i++) { 
            //     $file_path_db[$i]['doctype']=$result[$i]->doc_type_id;
            //     $file_path_db[$i]['docname']=$result[$i]->doc_doc_id;
            //     $file_path_db[$i]['docdesc']=$result[$i]->doc_description;
            //     $file_path_db[$i]['docrefno']=$result[$i]->doc_ref_no;
            //     $file_path_db[$i]['docdoi']=$result[$i]->doc_doi;
            //     $file_path_db[$i]['docdoe']=$result[$i]->doc_doe;
            //     $file_path_db[$i]['docpath']=$result[$i]->doc_document;
            //     $file_path_db[$i]['docfilename']=$result[$i]->document_name;
            //     $file_path_count=$i;
            // }

            // if ($rec_status!="Approved") {
                $this->db->where('doc_ref_id', $doc_ref_id);
                $this->db->where('doc_ref_type', $doc_ref_type);
                $this->db->delete('document_details');
            // }

            $doctype=$this->input->post('doc_type[]');
            $docname=$this->input->post('doc_name[]');
            $docdesc=$this->input->post('doc_desc[]');
            $docref=$this->input->post('ref_no[]');
            $docdoi=$this->input->post('date_issue[]');
            $docdoe=$this->input->post('date_expiry[]');
            $docdocument=$this->input->post('doc_document[]');
            $documentname=$this->input->post('document_name[]');
            $docdocname=$this->input->post('doc_doc_name[]');

            $doccnt=0;

            for ($k=0; $k<count($docname); $k++) {
                if((isset($docname[$k]) and $docname[$k]!="") || (isset($docdocname[$k]) and $docdocname[$k]!="")) {
                    $docname[$k]=str_replace('/', '_', $docname[$k]);

                    if($docdoe[$k]=="") {
                        $doe = NULL;
                    } else {
                        $doe = FormatDate($docdoe[$k]);
                    }
                    
                    if($docdoi[$k]=="") {
                        $doi = NULL;
                    } else {
                        $doi = FormatDate($docdoi[$k]);
                    }
                    
                    $filePath='uploads/'.$doc_ref_type.'/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $filePath='uploads/'.$doc_ref_type.'/'.$doc_ref_type.'_'.$doc_ref_id.'/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $filePath='uploads/'.$doc_ref_type.'/'.$doc_ref_type.'_'.$doc_ref_id.'/documents/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $confi['upload_path']=$upload_path;
                    $confi['allowed_types']='*';
                    $this->load->library('upload', $confi);
                    $this->upload->initialize($confi);
                    $extension="";

                    $file_nm='doc_'.$doccnt;

                    while (!isset($_FILES[$file_nm])) {
                        $doccnt = $doccnt + 1;
                        $file_nm = 'doc_'.$doccnt;
                    }

                    if(!empty($_FILES[$file_nm]['name'])) {
                        if($this->upload->do_upload($file_nm)) {
                            // echo "Uploaded <br>";
                        } else {
                            // echo "Failed<br>";
                            // echo $this->upload->data();
                        }   

                        $upload_data=$this->upload->data();
                        $fileName=$upload_data['file_name'];
                        $extension=$upload_data['file_ext'];
                            
                        $data = array(
                            'doc_ref_id' => $doc_ref_id,
                            'doc_ref_type' => $doc_ref_type,
                            'doc_type_id' => ($doctype[$k]=='')?'0':$doctype[$k],
                            'doc_doc_id' => ($docname[$k]=='')?'0':$docname[$k],
                            'doc_description' => $docdesc[$k],
                            'doc_ref_no' => $docref[$k],
                            'doc_doi' => $doi,
                            'doc_doe' => $doe,
                            'doc_document' => $filePath.$fileName,
                            'document_name' => $fileName,
                            'doc_doc_name' => $docdocname[$k]
                        );
                        $this->db->insert('document_details', $data);
                    } else {
                        // if($file_path_count>=$k) {
                        //     $path=$file_path_db[$k]['docpath'];
                        //     $flnm=$file_path_db[$k]['docfilename'];
                        // } else {
                        //     $path="";
                        //     $flnm="";
                        // }

                        $data = array(
                            'doc_ref_id' => $doc_ref_id,
                            'doc_ref_type' => $doc_ref_type,
                            'doc_type_id' => ($doctype[$k]=='')?'0':$doctype[$k],
                            'doc_doc_id' => ($docname[$k]=='')?'0':$docname[$k],
                            'doc_description' => $docdesc[$k],
                            'doc_ref_no' => $docref[$k],
                            'doc_doi' => $doi,
                            'doc_doe' => $doe,
                            'doc_document' => $docdocument[$k],
                            'document_name' => $documentname[$k],
                            'doc_doc_name' => $docdocname[$k]
                        );
                        $this->db->insert('document_details', $data);
                    }
                }

                $doccnt = $doccnt + 1;

                if($k!=count($docname)-1) {
                    $file_nm='doc_'.$doccnt;

                    while (!isset($_FILES[$file_nm])) {
                        $doccnt = $doccnt + 1;
                        $file_nm = 'doc_'.$doccnt;
                    }
                }
            }
            $file_path_db=NULL;
        // }

        return true;
    }
}
?>