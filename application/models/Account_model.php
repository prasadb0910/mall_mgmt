<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Account_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');

}

public function Income()
{
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Income.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $property_id  = html_escape($this->input->post('property'));
    $contact_id = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $gid=$this->session->userdata('groupid');
    
    $groupidby='';
    $and1='';
    $and2='';
    $and3='';
    $and4='';

    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

        /* ,(SELECT  case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end from contact_master  WHERE a.payer_id=c_id) as payer_name, */
        /*$query = $this->db->query("Select p.p_property_name,p.txn_id ,a.*,sp_name,
            case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as c_name,b.b_name,b.b_accountnumber
            from  actual_other_schedule a  
            join  purchase_txn p  on a.property_id=p.txn_id
            join sub_property_allocation s on s.property_id=p.txn_id
            join purchase_ownership_details po on p.txn_id=po.purchase_id
            join contact_master cm on  po.pr_client_id=cm.c_id 
            join bank_master b on b.b_id=a.account_number
            where a.txn_status = 'Approved' and a.type='receipt'
            and a.gp_id = '$gid' $and1 $and2 $and3 $and4  GROUP BY  p.txn_id");*/

        $query = "Select E.* ,b_name ,em.expense_category,
                (Select case when c_owner_type='individual' 
                then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
                else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
                from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
                from 
                (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
                (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
                (select A.*, B.sp_name from 
                (select  D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                    case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                    case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                    case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                    case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,D.tds_amount from 
                (select * from 
                (select A.* from 
                (select *
                from actual_other_schedule A where A.gp_id = '$gid' and 
                    A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
                ) C 
                where C.paid_amount>0) D where D.paid_amount>0) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id=B.txn_id) C 
                left join 
                (select * from purchase_txn where txn_status = 'Approved') D 
                on (C.property_id = D.txn_id)) E 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') F 
                on (E.payer_id=F.c_id)) E 
                left join bank_master b on b.b_id=E.account_number
                        left join expense_category_master em on em.id = E.event_name where type='receipt' and tds_amount>0 and tax_amount>0".$where_condition;
        $queryresult = $this->db->query($query);  
        $result = $queryresult->result_array();

        if(count($result)>0)
        {
            $row=5;
            $start  = 5;
            $sr_no = 1;
            for($i=0;$i<count($result);$i++)
            {
                /*
                $p_property_name = $result[$i]['p_property_name'];
                $txn_id = $result[$i]['txn_id'];
                $g_id = $result[$i]['gp_id'];
                $basic_cost = $result[$i]['basic_cost'];
                $gst_rate = $result[$i]['gst_rate'];
                $event_date = $result[$i]['event_date'];
                $category = $result[$i]['category'];
                $actual_cost = ($basic_cost*$gst_rate)/100;*/

                $event_date = $result[$i]['event_date'];
                $category =  $result[$i]['type'];;
                $event_name = $result[$i]['expense_category'];
                $p_property_name = $result[$i]['p_property_name'];
                $owner_name = $result[$i]['owner_name'];
                $payer_name =  $result[$i]['payername'];
                $payment_mode = $result[$i]['payment_mode'];
                $cheque_no = $result[$i]['cheque_no'];
                $b_name = $result[$i]['b_name'];
                $event_type = $result[$i]['expense_category'];
                $paid_amount = $result[$i]['paid_amount'];
                $tax_amount = $result[$i]['tax_amount'];
                $tds_amount = $result[$i]['tds_amount'];
                /*if( $ownerid = "")
                {
                    $query = $this->db->query("Select * from purchase_ownership_details p join contact_master cm on  p.ow_id=cm.c_id and p.purchase_id=$txn_id")->result_array();
                    for($j=0;$j<count($query);$j++)
                    {
                        if($j>0)
                            $owner_name .= ','.$query[$j]['c_name'];
                        else
                            $owner_name .= $query[$j]['c_name'];    
                        
                    }
                }
                else
                {
                    $owner_name = $result[$i]['c_name'];
                }*/

                /*$expense_category_master  = $this->db->query("Select expense_category from expense_category_master where g_id=$gid and id=$category")->result_array();
                 $categoryname = $expense_category_master[0]['expense_category'];*/
                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
                 $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $event_date);
                 $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $paid_amount);
                 $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $tax_amount);
                 $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '=G'.$row.'+'.'H'.$row);
                 $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $tds_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '=I'.$row.'-'.'J'.$row);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));

                $sr_no=$sr_no+1;
                $row=$row+1;
                
            }

            $count = count($result); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,"Total");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, '=SUM(G'.$start.':'."G".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=SUM(H'.$start.':'."H".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '=SUM(I'.$start.':'."I".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=SUM(J'.$start.':'."J".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, '=SUM(K'.$start.':'."K".($row-1).')');
        
           /* $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':K'.$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'startcolor' => array(
                        'rgb' => '9bc2e6'
                )
            ));
            */
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':K'.$row)->applyFromArray(array(
                    'borders' => array(
                        'outline' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                ));
                  

            

            $filename='Income.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        else
        {
             echo '<script>alert("No data found");</script>';
        }   
        
}

public function Expense()
{
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Expense.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $property_id  = html_escape($this->input->post('property'));
    $contact_id = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $gid=$this->session->userdata('groupid');
    
    $groupidby='';
    $and1='';
    $and2='';
    $and3='';
    $and4='';

    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $query = "Select E.* ,b_name ,em.expense_category,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
            from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
            from 
            (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
            (select A.*, B.sp_name from 
            (select  D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,D.tds_amount from 
            (select * from 
            (select A.* from 
            (select *
            from actual_other_schedule A where A.gp_id = '$gid' and 
                A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
            ) C 
            where C.paid_amount>0) D where D.paid_amount>0) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id=B.txn_id) C 
            left join 
            (select * from purchase_txn where txn_status = 'Approved') D 
            on (C.property_id = D.txn_id)) E 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') F 
            on (E.payer_id=F.c_id)) E 
            left join bank_master b on b.b_id=E.account_number
                    left join expense_category_master em on em.id = E.event_name where type='payment' and tax_amount>0 and tds_amount>0".$where_condition;
    $queryresult = $this->db->query($query);  
    $result = $queryresult->result_array();

    if(count($result)>0)
    {
        $row=5;
        $start  = 5;
        $sr_no = 1;
        for($i=0;$i<count($result);$i++)
        {
            /*
            $p_property_name = $result[$i]['p_property_name'];
            $txn_id = $result[$i]['txn_id'];
            $g_id = $result[$i]['gp_id'];
            $basic_cost = $result[$i]['basic_cost'];
            $gst_rate = $result[$i]['gst_rate'];
            $event_date = $result[$i]['event_date'];
            $category = $result[$i]['category'];
            $actual_cost = ($basic_cost*$gst_rate)/100;*/

            $event_date = $result[$i]['event_date'];
            $category =  $result[$i]['type'];;
            $event_name = $result[$i]['expense_category'];
            $p_property_name = $result[$i]['p_property_name'];
            $owner_name = $result[$i]['owner_name'];
            $payer_name =  $result[$i]['payername'];
            $payment_mode = $result[$i]['payment_mode'];
            $cheque_no = $result[$i]['cheque_no'];
            $b_name = $result[$i]['b_name'];
            $event_type = $result[$i]['expense_category'];
            $paid_amount = $result[$i]['paid_amount'];
            $tax_amount = $result[$i]['tax_amount'];
            $tds_amount = $result[$i]['tds_amount'];
            /*if( $ownerid = "")
            {
                $query = $this->db->query("Select * from purchase_ownership_details p join contact_master cm on  p.ow_id=cm.c_id and p.purchase_id=$txn_id")->result_array();
                for($j=0;$j<count($query);$j++)
                {
                    if($j>0)
                        $owner_name .= ','.$query[$j]['c_name'];
                    else
                        $owner_name .= $query[$j]['c_name'];    
                    
                }
            }
            else
            {
                $owner_name = $result[$i]['c_name'];
            }*/

            /*$expense_category_master  = $this->db->query("Select expense_category from expense_category_master where g_id=$gid and id=$category")->result_array();
             $categoryname = $expense_category_master[0]['expense_category'];*/
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $category);
                 $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $event_date);
                 $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $paid_amount);
                 $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tax_amount);
                 $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=F'.$row.'+'.'G'.$row);
                 $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $tds_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=H'.$row.'-'.'I'.$row);
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
              $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));

            $sr_no=$sr_no+1;
            $row=$row+1;
            
        }

        $count = count($result); 
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, '=SUM(G'.$start.':'."G".($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=SUM(H'.$start.':'."H".($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '=SUM(I'.$start.':'."I".($row-1).')');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=SUM(J'.$start.':'."J".($row-1).')');
    
        /*$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '9bc2e6'
            )
        ));*/

        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
        ));

        $filename='Expense.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    else
    {
         echo '<script>alert("No data found");</script>';
    }   
        
}




public function expense_copy()
{
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Expense.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $property_id  = html_escape($this->input->post('property'));
    $ownerid = html_escape($this->input->post('owner'));
    $sub_property = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $gid=$this->session->userdata('groupid');
    
    $groupidby='';
    $and1='';
    $and2='';
    $and3='';
    $and4='';

    if($property_id!="")
        $and1 = "and p.txn_id = ".$property_id;

    if($sub_property!="")
        $and2 = "and a.sub_property_id = ".$sub_property;

    if($ownerid!="")
        $and3 = "and po.ow_id=".$ownerid;

    if($from_date!="" && $to_date!="")
        $and4= " and a.event_date>='$from_date' and a.event_date<='$to_date'";
        /* ,(SELECT  case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end from contact_master  WHERE a.payer_id=c_id) as payer_name, */
        $query = $this->db->query("Select p.p_property_name,p.txn_id ,a.*,sp_name,
            case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as c_name,b.b_name,b.b_accountnumber
            from  actual_other_schedule a  
            join  purchase_txn p  on a.property_id=p.txn_id
            join sub_property_allocation s on s.property_id=p.txn_id
            join purchase_ownership_details po on p.txn_id=po.purchase_id
            join contact_master cm on  po.pr_client_id=cm.c_id 
            join bank_master b on b.b_id=a.account_number
            where a.txn_status = 'Approved'  and a.type='payment'
            and a.gp_id = '$gid' $and1 $and2 $and3 $and4  GROUP BY  p.txn_id");
        $result = $query->result_array();

        if(count($result)>0)
        {
            $row=5;
            $start  = 5;
            $sr_no = 1;
            for($i=0;$i<count($result);$i++)
            {
                
                $p_property_name = $result[$i]['p_property_name'];
                $txn_id = $result[$i]['txn_id'];
                $g_id = $result[$i]['gp_id'];
                $basic_cost = $result[$i]['basic_cost'];
                $gst_rate = $result[$i]['gst_rate'];
                $event_date = $result[$i]['event_date'];
                $category = $result[$i]['category'];
                $actual_cost = ($basic_cost*$gst_rate)/100;

                if( $ownerid = "")
                {
                    $query = $this->db->query("Select * from purchase_ownership_details p join contact_master cm on  p.ow_id=cm.c_id and p.purchase_id=$txn_id")->result_array();
                    for($j=0;$j<count($query);$j++)
                    {
                        if($j>0)
                            $owner_name .= ','.$query[$j]['c_name'];
                        else
                            $owner_name .= $query[$j]['c_name'];    
                        
                    }
                }
                else
                {
                    $owner_name = $result[$i]['c_name'];
                }
                


                $expense_category_master  = $this->db->query("Select expense_category from expense_category_master where g_id=$gid and id=$category")->result_array();
                 $categoryname = $expense_category_master[0]['expense_category'];
                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
                 $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $categoryname);
                 $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $event_date);
                 $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $basic_cost);
                 $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, '=F'.$row.'*18'.'%');
                 $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=F'.$row.'+G'.$row);
                 $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '=F'.$row.'*2%');
                 $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=H'.$row.'-'.'I'.$row);
                 $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
                 $sr_no=$sr_no+1;
                 $row=$row+1;
                
            }
            /*$sheetCount = $objPHPExcel->getSheetCount();
            $expense =  $objPHPExcel->setActiveSheetIndex(0);*/
            $count = count($result); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, '=SUM(G'.$start.':'."G".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, '=SUM(H'.$start.':'."H".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, '=SUM(I'.$start.':'."I".($row-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, '=SUM(J'.$start.':'."J".($row-1).')');

            /*  $objPHPExcel->getActiveSheet()->getStyle('A7')->getFill()->applyFromArray(
                array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => 'FF0000')
                        )
                    )
                );*/

                /*$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFill()->applyFromArray(array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFF00')
                ));*/

            $filename='Expense.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
        else
        {
             echo '<script>alert("No data found");</script>';
        }   
        
}

public function get_lease()
{
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Lease_Report.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $property_id  = html_escape($this->input->post('property'));
    $ownerid = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $gid=$this->session->userdata('groupid');
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $and4 = '';

    if($from_date!="" && $to_date!="")
        $and4= " and event_date>='$from_date' and event_date<='$to_date'";

    /*Select leasedeatil.*,p_property_name,p_address,p_propertydescription,
            p_city from (
            select E.*,sum(E.net_amount-E.paid_amount) as balamount,sum(E.net_amount) as net,sum(E.paid_amount) as paid,
            (Select possession_date from rent_txn where gp_id='$gid'  and  property_id=E.property_id  Limit 0,1) as Leasestartdate ,
            (Select termination_date from rent_txn where gp_id='$gid'  and  property_id=E.property_id Limit 0,1) as Leaseenddate 
            from 
            (select C.txn_id, C.event_type, C.event_name, C.event_date, ifnull(C.net_amount,0) as net_amount, 
            sum(ifnull(D.paid_amount,0)+ifnull(D.tds_amount,0)) as paid_amount,sum(C.net_amount-paid_amount) as Bal_Amount,C.property_id,C.sub_property_id from 
            (select A.txn_id, B.event_type, B.event_name, B.event_date, B.net_amount,A.property_id,A.sub_property_id from 
            (select * from rent_txn where gp_id='$gid'  and txn_status = 'Approved') A 
            left join 
            (select * from rent_schedule where status = '1' and (invoice_no is not null or invoice_no<>'')) B 
            on (A.txn_id = B.rent_id)) C 
            left join 
            (select * from actual_schedule where gp_id='$gid' and txn_status = 'Approved' and event_type='Rent') D 
            on (C.txn_id = D.fk_txn_id and C.event_type = D.event_type and C.event_name = D.event_name and C.event_date = D.event_date) 
            group by C.txn_id, C.event_type, C.event_name, C.event_date, C.net_amount,C.property_id) E Group BY property_id) as leasedeatil
            join purchase_txn t on t.txn_id=leasedeatil.property_id */
    
        if($ownerid!="")
        {
            if($sub_property_id!='')
            $and2 = ' and sub_property_id='.$sub_property_id;
            else
            $and2 ='';

            $row=4;
            $start  = 5;
            $sr_no = 1;
            $prev = 0;
            $ownersql = "Select purchase_id from purchase_txn p   
                        join purchase_ownership_details po  on p.txn_id=po.purchase_id
                        join contact_master cm on  po.pr_client_id=cm.c_id 
                        where txn_status='Approved' and p.gp_id = '$gid' and  pr_client_id=$ownerid";
             $query = $this->db->query($ownersql);
             $resultowner = $query->result_array();

             if(count($resultowner)>0)
             {

                for($j=0;$j<count($resultowner);$j++)
                 {
                  
                      $sql =  "Select leasedeatil.*,p_property_name,p_address,p_propertydescription,p_city,case when c_owner_type='individual' 
                        then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
                        else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as c_name  from (
                        select E.*,sum(E.net_amount-E.paid_amount) as balamount,sum(E.net_amount) as net,sum(E.paid_amount) as paid,
                        (Select possession_date from rent_txn where gp_id='$gid'  and  txn_id=E.txn_id  Limit 0,1) as Leasestartdate ,
                        (Select termination_date from rent_txn where gp_id='$gid'  and  txn_id=E.txn_id Limit 0,1) as Leaseenddate
                        from 
                        (select C.txn_id, C.event_type, C.event_name, C.event_date, ifnull(C.net_amount,0) as net_amount, 
                        sum(ifnull(D.paid_amount,0)+ifnull(D.tds_amount,0)) as paid_amount,sum(C.net_amount-paid_amount) as Bal_Amount,C.property_id,C.sub_property_id from 
                        (select A.txn_id, B.event_type, B.event_name, B.event_date, B.net_amount,A.property_id,A.sub_property_id from 
                        (select * from rent_txn where gp_id='$gid'  and txn_status = 'Approved') A 
                        left join 
                        (select * from rent_schedule where status = '1' ) B 
                        on (A.txn_id = B.rent_id)) C 
                        left join 
                        (select * from actual_schedule where gp_id='$gid' and txn_status = 'Approved' and event_type='Rent' and event_type!='') D 
                        on (C.txn_id = D.fk_txn_id and C.event_type = D.event_type and C.event_name = D.event_name and C.event_date = D.event_date) 
                        group by C.txn_id, C.event_type, C.event_name, C.event_date, C.net_amount,C.property_id) E Group BY txn_id) as leasedeatil
                        join purchase_txn t on t.txn_id=leasedeatil.property_id
                        join rent_tenant_details rtd on rtd.rent_id=leasedeatil.txn_id
                        join  contact_master cm on cm.c_id=rtd.contact_id Where property_id=".$resultowner[$j]['purchase_id'].$and2.$and4;
                     $query = $this->db->query($sql);
                     $result = $query->result_array();
                     if(count($result)>0)
                        { 
                            
                            for($i=0;$i<count($result);$i++)
                            {
                                if($result[$i]['event_type']!="")
                                {
                                   
                                  if($prev!=trim($result[$i]['property_id']))
                                    {

                                        $row = $row+2;
                                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'PROPERTY - '.$result[$i]['p_property_name']);
                                        $row = $row+1;
                                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result[$i]['p_address']);
                                        $row = $row+1;
                                         $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result[$i]['p_propertydescription'].','.$result[$i]['p_city']);
                                        $row = $row+1;
                                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Tenant Name");
                                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Lease start");
                                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,"Lease end");
                                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Rent Amount");
                                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,"Deposit");
                                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,"Balance owed");
                                        
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'startcolor' => array(
                                                    'rgb' => 'ffff00'
                                            )
                                        ));
                                        $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
                                        $row = $row+1;
                                        $prev = trim($result[$i]['property_id']); 
                                    }

                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result[$i]['c_name']);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result[$i]['Leasestartdate']);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result[$i]['Leaseenddate']);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result[$i]['net']);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result[$i]['paid']);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result[$i]['balamount']);
                                     $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));

                                     $row = $row+1;

                                }
                            }

                        }                
                 }

                   $filename='Lease_Report.xls';
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="'.$filename.'"');
                    header('Cache-Control: max-age=0');
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save('php://output');
             }
             else
             {
                 echo '<script>alert("No data found ");</script>';
             }


            
        }else
        {

            if($property_id!='')
                $and1 = ' and property_id='.$property_id;
            else
                $and1='';


            if($sub_property_id!='')
                $and2 = ' and sub_property_id='.$sub_property_id;
            else
                $and2 ='';

            if($property_id=="" && $sub_property_id=='')
                $orderby = ' ORDER BY property_id';
            else
                $orderby ='';


             $sql =  "Select leasedeatil.*,p_property_name,p_address,p_propertydescription,p_city,case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as c_name  from (
            select E.*,sum(E.net_amount-E.paid_amount) as balamount,sum(E.net_amount) as net,sum(E.paid_amount) as paid,
            (Select possession_date from rent_txn where gp_id='$gid'  and  txn_id=E.txn_id  Limit 0,1) as Leasestartdate ,
            (Select termination_date from rent_txn where gp_id='$gid'  and  txn_id=E.txn_id Limit 0,1) as Leaseenddate
            from 
            (select C.txn_id, C.event_type, C.event_name, C.event_date, ifnull(C.net_amount,0) as net_amount, 
            sum(ifnull(D.paid_amount,0)+ifnull(D.tds_amount,0)) as paid_amount,sum(C.net_amount-paid_amount) as Bal_Amount,C.property_id,C.sub_property_id from 
            (select A.txn_id, B.event_type, B.event_name, B.event_date, B.net_amount,A.property_id,A.sub_property_id from 
            (select * from rent_txn where gp_id='$gid'  and txn_status = 'Approved') A 
            left join 
            (select * from rent_schedule where status = '1' ) B 
            on (A.txn_id = B.rent_id)) C 
            left join 
            (select * from actual_schedule where gp_id='$gid' and txn_status = 'Approved' and event_type='Rent' and event_type!='') D 
            on (C.txn_id = D.fk_txn_id and C.event_type = D.event_type and C.event_name = D.event_name and C.event_date = D.event_date) 
            group by C.txn_id, C.event_type, C.event_name, C.event_date, C.net_amount,C.property_id) E Group BY txn_id) as leasedeatil
            join purchase_txn t on t.txn_id=leasedeatil.property_id
            join rent_tenant_details rtd on rtd.rent_id=leasedeatil.txn_id
            join  contact_master cm on cm.c_id=rtd.contact_id Where net>0 ".$and1.$and2.$and4.$orderby;

            $query = $this->db->query($sql);
            $result = $query->result_array();
           
             if(count($result)>0)
            { 
                $row=3;
                $start  = 5;
                $sr_no = 1;
                $prev = 0;
                $eventtype = '';
                for($i=0;$i<count($result);$i++)
                {
                    if($result[$i]['event_type']!="")
                    {
                       
                      if($prev!=trim($result[$i]['property_id']))
                        {
                            $row = $row+2;
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'PROPERTY - '.$result[$i]['p_property_name']);
                            $row = $row+1;
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result[$i]['p_address']);
                            $row = $row+1;
                             $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result[$i]['p_propertydescription'].','.$result[$i]['p_city']);
                            $row = $row+1;
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,"Tenant Name");
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,"Lease start");
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,"Lease end");
                            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Rent Amount");
                            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,"Deposit");
                            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,"Balance owed");
                            
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'startcolor' => array(
                                        'rgb' => 'ffff00'
                                )
                            ));
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
                            $row = $row+1;
                            $prev = trim($result[$i]['property_id']); 
                        }

                        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $result[$i]['c_name']);
                        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $result[$i]['Leasestartdate']);
                        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $result[$i]['Leaseenddate']);
                        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $result[$i]['net']);
                        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $result[$i]['paid']);
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $result[$i]['balamount']);
                         $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':G'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
                         $row = $row+1;
                    }
                }


                $filename='Lease_Report.xls';
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');

                

            }
            else
            {
                echo '<script>alert("No data found ");</script>';
            }
        }


}

public function bank_statement()
{
    $property_id  = html_escape($this->input->post('property'));
    $contact_id = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    $template_path=$this->config->item('template_path');
    $file = $template_path.'Bank_Statement.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $gid=$this->session->userdata('groupid');
    $row=6;
    $row_start=6;
    $start  = 6;
    $sr_no = 1;
    $where_condition = "";
    if($contact_id!="")
    {
       if($where_condition=="")
         $where_condition = " Where E.contact_id='$contact_id'";
            else
         $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         if($where_condition=="")
             $where_condition = " Where E.purchase_id ='$property_id'";
          else
             $where_condition .= " And E.purchase_id ='$property_id'";
    }    


    if($sub_property_id!="")
    {
         if($where_condition=="")
            $where_condition = " Where and E.sub_property_id ='$sub_property_id'";
         else
            $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }

    if($from_date!="" && $to_date!="")
    {
        if($where_condition=="")
            $where_condition = " Where   E.event_date>='$from_date' and E.event_date<='$to_date'";
        else
            $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }
                 
   $sqlpurchase = "select E.*,b_name from 
        (select E.*, E.p_builder_name as contact_id, F.c_full_name, F.owner_name from 
        (select C.*, '' as sub_property_id, '' as sp_name, C.net_amount-C.paid_amount as bal_amount, 
            D.pr_client_id as payer_id, D.c_full_name as payer_full_name, D.owner_name as payer_owner_name from 
        (select * from 
        (select A.*, B.purchase_id, B.event_type, B.event_name, B.event_date, B.accounting_id, B.txn_status, B.entry_type, 
            case when B.basic_cost is null then 0 else B.basic_cost end as basic_cost, 
            case when B.net_amount is null then 0 else B.net_amount end as net_amount, 
            case when B.tax_amount is null then 0 else B.tax_amount end as tax_amount, 
            case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount , B.payment_mode,B.cheque_no,B.account_number from 
        (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, p_builder_name 
        from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
        left join 
        (select * from 
        (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
            B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type,B.payment_mode,B.cheque_no,B.account_number from 
        (select A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
            sum(B.tax_amount) as tax_amount, 'schedule' as entry_type
            from purchase_schedule A left join purchase_schedule_taxation B on (A.purchase_id=B.pur_id and A.sch_id=B.sch_id) 
            where A.status = '1' and (B.status = '1' or B.status is null) 
            group by A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
        union all 
        select id as sch_id, fk_txn_id as purchase_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
            tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
            from actual_schedule_taxes where table_type = 'purchase') A 
        left join 
        (select id, fk_txn_id, event_type, event_name, event_date, txn_status, paid_amount+tds_amount as paid_amount ,payment_mode,cheque_no,account_number
            from actual_schedule where table_type = 'purchase'
        union all 
        select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
            amount_paid as paid_amount ,payment_mode,cheque_no,account_number from actual_schedule_taxes where table_type = 'purchase') B 
        on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
        where C.paid_amount>0) B 
        on A.txn_id = B.purchase_id)C where C.event_name is not null) C 
        left join 
        (select A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name from 
        (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
        where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id
        )) A 
        left join 
        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
            case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
            case when A.c_owner_type='individual' 
            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
        where A.c_status='Approved' and A.c_gid='$gid') B 
        on (A.pr_client_id=B.c_id)) D 
        on C.txn_id=D.purchase_id) E 
        left join 
        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
            case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
            case when A.c_owner_type='individual' 
            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
        where A.c_status='Approved' and A.c_gid='$gid') F 
        on (E.p_builder_name=F.c_id)) E 
        left join bank_master b on b.b_id=E.account_number".$where_condition; 
   
        $result1=$this->db->query($sqlpurchase)->result_array();
        for($i=0;$i<count($result1);$i++)
        {
            $event_date = $result1[$i]['event_date'];
            $category =  'Purchase';
            $event_name = $result1[$i]['event_name'];
            $p_property_name = $result1[$i]['p_property_name'];
            $owner_name = $result1[$i]['owner_name'];
            $payer_name = $result1[$i]['payer_full_name'];
            $payment_mode = $result1[$i]['payment_mode'];
            $cheque_no = $result1[$i]['cheque_no'];
            $b_name = $result1[$i]['b_name'];
            $event_type = $result1[$i]['event_type'];
            $paid_amount = $result1[$i]['paid_amount'];

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $event_date);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $p_property_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $owner_name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $payer_name);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $category);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $event_type);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $b_name);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $cheque_no);
             $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $paid_amount);
             $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
             $sr_no=$sr_no+1;
             $row=$row+1;

        }
   



    

    $where_condition = "";
    if($contact_id!="")
    {
       if($where_condition=="")
         $where_condition = " Where E.owner_id='$contact_id'";
            else
         $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         if($where_condition=="")
             $where_condition = " Where E.property_id ='$property_id'";
          else
             $where_condition .= " And E.property_id ='$property_id'";
    }    


    if($sub_property_id!="")
    {
         if($where_condition=="")
            $where_condition = " Where and E.sub_property_id ='$sub_property_id'";
         else
            $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }


    if($from_date!="" && $to_date!="")
    {
        if($where_condition=="")
            $where_condition = " Where   E.event_date>='$from_date' and E.event_date<='$to_date'";
        else
            $where_condition .= " And   E.event_date>='$from_date' and E.event_date<='$to_date'";
    }    
    $sqlsale = "select E.*,b_name ,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as owner_name 
            from contact_master cm join purchase_ownership_details p where p.purchase_id=E.property_id and cm.c_id=p.pr_client_id) as  owner_name
             from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.buyer_id as contact_id, D.c_full_name, D.owner_name as payername from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from 
            (select C.*, D.sale_id, D.event_type, D.event_name, D.event_date, D.accounting_id, D.txn_status, D.entry_type, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale ,(Select c_id from contact_master cm join purchase_ownership_details p where p.purchase_id=A.property_id and cm.c_id=p.pr_client_id Limit 0,1) as  owner_id from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                txn_id in (select distinct sale_id from sales_buyer_details 
                )) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number from 
            (select A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
                from sales_schedule A left join sales_schedule_taxation B on (A.sale_id=B.sale_id and A.sch_id=B.sch_id) 
                where A.status = '1' and (B.status = '1' or B.status is null) 
                group by A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
            union all 
            select id as sch_id, fk_txn_id as sale_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
                from actual_schedule_taxes where table_type = 'sales') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status ,payment_mode,cheque_no,account_number  
                from actual_schedule where table_type = 'sales' 
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number from actual_schedule_taxes where table_type = 'sales' ) B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.sale_id) E where E.event_name is not null) A 
            left join 
            (
                select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id)) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E
            left join bank_master b on b.b_id=E.account_number".$where_condition;

        $result1=$this->db->query($sqlsale)->result_array();
        for($i=0;$i<count($result1);$i++)
        {
            $event_date = $result1[$i]['event_date'];
            $category =  'Sale';
            $event_name = $result1[$i]['event_name'];
            $p_property_name = $result1[$i]['p_property_name'];
            $owner_name = $result1[$i]['owner_name'];
            $payer_name = $result1[$i]['payername'];
            $payment_mode = $result1[$i]['payment_mode'];
            $cheque_no = $result1[$i]['cheque_no'];
            $b_name = $result1[$i]['b_name'];
            $event_type = $result1[$i]['event_type'];
            $paid_amount = $result1[$i]['net_amount'];

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $event_date);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $p_property_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $owner_name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $payer_name);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $category);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $event_type);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $b_name);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $cheque_no);
             $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $paid_amount);
             $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
             $sr_no=$sr_no+1;
             $row=$row+1;

        }

        
        $where_condition = "";
        if($contact_id!="")
        {
           if($where_condition=="")
             $where_condition = " Where E.contact_id='$contact_id'";
                else
             $where_condition .= " And E.contact_id='$contact_id' ";
        }

        if($property_id!="")
        {
             if($where_condition=="")
                 $where_condition = " Where E.property_id ='$property_id'";
              else
                 $where_condition .= " And E.property_id ='$property_id'";
        }    


        if($sub_property_id!="")
        {
             if($where_condition=="")
                $where_condition = " Where and E.sub_property_id ='$sub_property_id'";
             else
                $where_condition .= " And E.sub_property_id ='$sub_property_id'";
        }


        if($from_date!="" && $to_date!="")
        {
            if($where_condition=="")
                $where_condition = " Where   E.event_date>='$from_date' and E.event_date<='$to_date'";
            else
                $where_condition .= " And   E.event_date>='$from_date' and E.event_date<='$to_date'";
        }

        $sqlrent = "select E.*,b_name,
        (Select case when c_owner_type='individual' 
        then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
        else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
        from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payername,
        (Select cm.c_id from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payer_id
        from 
        (select C.*, C.net_amount-C.paid_amount as bal_amount, D.contact_id, D.c_full_name, D.owner_name from 
        (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
        (select * from 
        (select C.*, D.rent_id, D.event_type, D.event_name, D.event_date, 
            case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
            case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
            case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
            case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, 
            D.accounting_id, D.txn_status, D.entry_type
            ,D.payment_mode,D.cheque_no,D.account_number from 
        (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.rent_amount, 
            A.possession_date, A.termination_date from 
        (select * from rent_txn where gp_id = '$gid' and txn_status='Approved' and 
            property_id in (select distinct purchase_id from purchase_ownership_details )) A 
        left join 
        (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
        on A.sub_property_id = B.txn_id) C 
        left join 
        (select * from 
        (select A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
            case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, 
            B.id as accounting_id, B.txn_status, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number  from 
        (select A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
            sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
        from rent_schedule A left join rent_schedule_taxation B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) 
        where A.status = '1' and (B.status = '1' or B.status is null) 
        group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount 
            union all 
        select id as sch_id, fk_txn_id as rent_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
            tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
        from actual_schedule_taxes where table_type = 'rent') A 
        left join 
        (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status,payment_mode,cheque_no,account_number 
            from actual_schedule where table_type = 'rent' 
        union all 
        select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
            amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number from actual_schedule_taxes where table_type = 'rent' ) B 
        on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
        where C.paid_amount>0) D 
        on C.txn_id=D.rent_id) E where E.event_name is not null) A 
        left join 
        (select * from purchase_txn where gp_id = '$gid') B 
        on A.property_id=B.txn_id) C 
        left join 
        (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
        (SELECT * FROM rent_tenant_details A WHERE A.contact_id in (select min(contact_id) from rent_tenant_details 
        where rent_id = A.rent_id group by rent_id)) A 
        LEFT JOIN 
        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
            case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
            case when A.c_owner_type='individual' 
            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
        where A.c_status='Approved' and A.c_gid='$gid') B 
        ON (A.contact_id=B.c_id)) D 
        on C.txn_id=D.rent_id) E
        left join bank_master b on b.b_id=E.account_number".$where_condition;;


        $result1=$this->db->query($sqlrent)->result_array();
        for($i=0;$i<count($result1);$i++)
        {
            $event_date = $result1[$i]['event_date'];
            $category =  'Rent';
            $event_name = $result1[$i]['event_name'];
            $p_property_name = $result1[$i]['p_property_name'];
            $owner_name = $result1[$i]['owner_name'];
            $payer_name =  $result1[$i]['payername'];//$result1[$i]['p_builder_name'];
            $payment_mode = $result1[$i]['payment_mode'];
            $cheque_no = $result1[$i]['cheque_no'];
            $b_name = $result1[$i]['b_name'];
            $event_type = $result1[$i]['event_type'];
            $paid_amount = $result1[$i]['paid_amount'];

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $event_date);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $p_property_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $owner_name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $payer_name);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $category);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $event_type);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $b_name);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $cheque_no);
             $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $paid_amount);
             $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
             $sr_no=$sr_no+1;
             $row=$row+1;

        }
        
        $where_condition = "";
        if($contact_id!="")
        {
           if($where_condition=="")
             $where_condition = " Where E.contact_id='$contact_id'";
                else
             $where_condition .= " And E.contact_id='$contact_id' ";
        }

        if($property_id!="")
        {
             if($where_condition=="")
                 $where_condition = " Where E.property_id ='$property_id'";
              else
                 $where_condition .= " And E.property_id ='$property_id'";
        }    


        if($sub_property_id!="")
        {
             if($where_condition=="")
                $where_condition = " Where and E.sub_property_id ='$sub_property_id'";
             else
                $where_condition .= " And E.sub_property_id ='$sub_property_id'";
        }


        if($from_date!="" && $to_date!="")
        {
            if($where_condition=="")
                $where_condition = " Where   E.event_date>='$from_date' and E.event_date<='$to_date'";
            else
                $where_condition .= " And   E.event_date>='$from_date' and E.event_date<='$to_date'";
        }


        $sqlother = "select E.* ,b_name ,em.expense_category,
        (Select case when c_owner_type='individual' 
        then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
        else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
        from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
        from 
        (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
        (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
        (select A.*, B.sp_name from 
        (select D.accounting_id, D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
            case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
            case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
            case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
            case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number from 
        (select * from 
        (select A.*, B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount ,B.payment_mode,B.cheque_no,B.account_number from 
        (select A.fk_txn_id, A.type, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
            A.payer_id, A.property_id, A.sub_property_id 
        from actual_other_schedule A where A.gp_id = '$gid' and 
            A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
        left join 
        (select id, fk_txn_id, event_type, event_name, event_date, paid_amount+tds_amount as paid_amount, txn_status , payment_mode,cheque_no,account_number
        from actual_schedule where table_type = 'other') B 
        on (A.fk_txn_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
        where C.paid_amount>0) D where D.paid_amount>0) A 
        left join 
        (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
        on A.sub_property_id=B.txn_id) C 
        left join 
        (select * from purchase_txn where txn_status = 'Approved') D 
        on (C.property_id = D.txn_id)) E 
        left join 
        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
            case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
            case when A.c_owner_type='individual' 
            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
        where A.c_status='Approved' and A.c_gid='$gid') F 
        on (E.payer_id=F.c_id)) E 
        left join bank_master b on b.b_id=E.account_number
                left join expense_category_master em on em.id = E.event_name".$where_condition;

        $result1=$this->db->query($sqlother)->result_array();
        for($i=0;$i<count($result1);$i++)
        {
            $event_date = $result1[$i]['event_date'];
            $category =  $result1[$i]['type'];;
            $event_name = $result1[$i]['expense_category'];
            $p_property_name = $result1[$i]['p_property_name'];
            $owner_name = $result1[$i]['owner_name'];
            $payer_name =  $result1[$i]['payername'];
            $payment_mode = $result1[$i]['payment_mode'];
            $cheque_no = $result1[$i]['cheque_no'];
            $b_name = $result1[$i]['b_name'];
            $event_type = $result1[$i]['expense_category'];
            $paid_amount = $result1[$i]['paid_amount'];

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $event_date);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $p_property_name);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $owner_name);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $payer_name);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $category);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $event_type);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $b_name);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $payment_mode);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $cheque_no);
            if($category=='receipt')
             $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $paid_amount);
            else 
             $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $paid_amount);

             $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray(array(
                                                'borders' => array(
                                                    'outline' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN
                                                    )
                                                )
                                        ));
             $sr_no=$sr_no+1;
             $row=$row+1;

        }
        
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,"Total");
        $stylerow = $row-1;
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row_start.':L'.$row)->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));

       /* $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':L'.$row)->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));*/
        $objPHPExcel->getActiveSheet()->setCellValue('k'.$row, '=SUM(L'.$start.':'."L".($row-1).')'.'-'.'SUM(K'.$start.':'."K".($row-1).')');

        $objPHPExcel->getActiveSheet()->mergeCells('K'.$row.':'.'L'.$row);
        $objPHPExcel->getActiveSheet()->getStyle('K'.$row)->getAlignment()->applyFromArray(
            array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
        );

        if(count($result1)>0)
        {
            $filename='Bank.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');   
        }
        else
        {
             echo '<script>alert("No data found");</script>';
        }
        
    
}
public function heade_fun1($row,$objPHPExcel,$start)
{
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Payment');
    $row = $row+2;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
    $row = $row+1;    
    $start = $row;
}


public function tds_statement()
{
    $property_id  = html_escape($this->input->post('property'));
    $contact_id = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $template_path=$this->config->item('template_path');
    $file = $template_path.'TDS_report.xls';
    static $objPHPExcel;
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $gid=$this->session->userdata('groupid');
    $row=4;
    $start  = 5;
    $sr_no = 1;
    $prev = 0;
    $eventtype = '';
    $bool=false;

    $where_condition = "";

    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.purchase_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $puchasesql = "select E.*,b_name from 
            (select E.*, E.p_builder_name as contact_id, F.c_full_name, F.owner_name from 
            (select C.*, '' as sub_property_id, '' as sp_name, C.net_amount-C.paid_amount as bal_amount, 
                D.pr_client_id as payer_id, D.c_full_name as payer_full_name, D.owner_name as payer_owner_name from 
            (select * from 
            (select A.*, B.purchase_id, B.event_type, B.event_name, B.event_date, B.accounting_id, B.txn_status, B.entry_type, 
                case when B.basic_cost is null then 0 else B.basic_cost end as basic_cost, 
                case when B.net_amount is null then 0 else B.net_amount end as net_amount, 
                case when B.tax_amount is null then 0 else B.tax_amount end as tax_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount , B.payment_mode,B.cheque_no,B.account_number ,if(B.tds_amount_received=1,'received','pending') as tds_status ,B.tds_amount from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, p_builder_name 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received , B.tds_amount from 
            (select A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
                from purchase_schedule A left join purchase_schedule_taxation B on (A.purchase_id=B.pur_id and A.sch_id=B.sch_id) 
                where A.status = '1' and (B.status = '1' or B.status is null) 
                group by A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
            union all 
            select id as sch_id, fk_txn_id as purchase_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
                from actual_schedule_taxes where table_type = 'purchase') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, paid_amount+tds_amount as paid_amount ,payment_mode,cheque_no,account_number,tds_amount_received,tds_amount
                from actual_schedule where table_type = 'purchase'
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
                amount_paid as paid_amount ,payment_mode,cheque_no,account_number,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'purchase') B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) B 
            on A.txn_id = B.purchase_id)C where C.event_name is not null) C 
            left join 
            (select A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
            where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id
            )) A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            on (A.pr_client_id=B.c_id)) D 
            on C.txn_id=D.purchase_id) E 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') F 
            on (E.p_builder_name=F.c_id)) E 
            left join bank_master b on b.b_id=E.account_number where tds_amount>0 ".$where_condition;

    $result1=$this->db->query($puchasesql)->result_array();
    if(count($result1)>0 && $bool===false)
    {
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Payment')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
        $bool = true;
            
    }
    for($i=0;$i<count($result1);$i++)
    {
        $category =  'Purchase';
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payer_full_name'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tds_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tds_status);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    }   
    
    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlother = "select E.* ,b_name ,em.expense_category,
                (Select case when c_owner_type='individual' 
                then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
                else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
                from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
                from 
                (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
                (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
                (select A.*, B.sp_name from 
                (select D.accounting_id, D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                    case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                    case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                    case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                    case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,if( D.tds_amount_received=1,'received','pending') as tds_status ,D.tds_amount from 
                (select * from 
                (select A.*, B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount from 
                (select A.fk_txn_id, A.type, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                    A.payer_id, A.property_id, A.sub_property_id 
                from actual_other_schedule A where A.gp_id = '$gid' and 
                    A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
                left join 
                (select id, fk_txn_id, event_type, event_name, event_date, paid_amount+tds_amount as paid_amount, txn_status , payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'other') B 
                on (A.fk_txn_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
                where C.paid_amount>0) D where D.paid_amount>0) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id=B.txn_id) C 
                left join 
                (select * from purchase_txn where txn_status = 'Approved') D 
                on (C.property_id = D.txn_id)) E 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') F 
                on (E.payer_id=F.c_id)) E 
                left join bank_master b on b.b_id=E.account_number
                        left join expense_category_master em on em.id = E.event_name where type='payment' and tds_amount>0".$where_condition; ;  


  $result1=$this->db->query($sqlother)->result_array();
  if(count($result1)>0 && $bool===false)
    {
       $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Payment')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
        $bool = true;
    }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['expense_category'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tds_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tds_status);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

         $sr_no=$sr_no+1;
         $row=$row+1;
    } 

    if($bool==true)
    {
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
         $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')');
    }
    
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

    $where_condition = "";
    $bool1 = false;
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlrent  = "select E.*,b_name,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
            from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payername,
            (Select cm.c_id from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payer_id
             from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.contact_id, D.c_full_name, D.owner_name from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from 
            (select C.*, if(D.tds_amount_received=1,'received','pending') as tds_status,D.tds_amount,D.rent_id, D.event_type, D.event_name, D.event_date, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, 
                D.accounting_id, D.txn_status, D.entry_type
                ,D.payment_mode,D.cheque_no,D.account_number from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details )) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, 
                B.id as accounting_id, B.txn_status, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount  from 
            (select A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
            from rent_schedule A left join rent_schedule_taxation B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) 
            where A.status = '1' and (B.status = '1' or B.status is null) 
            group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount 
                union all 
            select id as sch_id, fk_txn_id as rent_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
            from actual_schedule_taxes where table_type = 'rent') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status,payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'rent' 
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number ,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'rent' ) B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.rent_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
            (SELECT * FROM rent_tenant_details A WHERE A.contact_id in (select min(contact_id) from rent_tenant_details 
            where rent_id = A.rent_id group by rent_id)) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.contact_id=B.c_id)) D 
            on C.txn_id=D.rent_id) E
            left join bank_master b on b.b_id=E.account_number where tds_amount>0 ".$where_condition;;
  $result1=$this->db->query($sqlrent)->result_array();
  if(count($result1)>0 && $bool1===false)
      {

        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

        $row = $row+1;    
        $start = $row;
        $bool1=true;

      }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['event_type'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tds_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tds_status);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    } 

    $where_condition = "";
    if($contact_id!="")
    {
       $where_condition .= " And E.owner_id='$contact_id' ";
    }

    if($property_id!="")
    {
        $where_condition .= " And E.property_id ='$property_id'";
    }    


    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }


    if($from_date!="" && $to_date!="")
    {
            $where_condition .= " And   E.event_date>='$from_date' and E.event_date<='$to_date'";
    } 

    $salesql = "select E.*,b_name ,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as owner_name 
            from contact_master cm join purchase_ownership_details p where p.purchase_id=E.property_id and cm.c_id=p.pr_client_id) as  owner_name
             from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.buyer_id as contact_id, D.c_full_name, D.owner_name as payername from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from 
            (select C.*, D.sale_id, D.event_type, D.event_name, D.event_date, D.accounting_id, D.txn_status, D.entry_type, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number,if(D.tds_amount_received,'received','pending') as tds_status,D.tds_amount from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale ,(Select c_id from contact_master cm join purchase_ownership_details p where p.purchase_id=A.property_id and cm.c_id=p.pr_client_id Limit 0,1) as  owner_id from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                txn_id in (select distinct sale_id from sales_buyer_details 
                )) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received,B.tds_amount from 
            (select A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
                from sales_schedule A left join sales_schedule_taxation B on (A.sale_id=B.sale_id and A.sch_id=B.sch_id) 
                where A.status = '1' and (B.status = '1' or B.status is null) 
                group by A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
            union all 
            select id as sch_id, fk_txn_id as sale_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
                from actual_schedule_taxes where table_type = 'sales') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status ,payment_mode,cheque_no,account_number ,tds_amount_received,tds_amount 
                from actual_schedule where table_type = 'sales' 
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'sales' ) B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.sale_id) E where E.event_name is not null) A 
            left join 
            (
                select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id)) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E
            left join bank_master b on b.b_id=E.account_number where tds_amount>0 ".$where_condition;

    $result1=$this->db->query($salesql)->result_array();
     if(count($result1)>0 && $bool1===false)
      {

        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

        $row = $row+1;    
        $start = $row;
        $bool1=true;

      }
    for($i=0;$i<count($result1);$i++)
    {
        $category =  'Sales';
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tds_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tds_status);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    }       

    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlother = "select E.* ,b_name ,em.expense_category,
                (Select case when c_owner_type='individual' 
                then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
                else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
                from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
                from 
                (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
                (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
                (select A.*, B.sp_name from 
                (select D.accounting_id, D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                    case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                    case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                    case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                    case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,if( D.tds_amount_received=1,'received','pending') as tds_status ,D.tds_amount from 
                (select * from 
                (select A.*, B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount from 
                (select A.fk_txn_id, A.type, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                    A.payer_id, A.property_id, A.sub_property_id 
                from actual_other_schedule A where A.gp_id = '$gid' and 
                    A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
                left join 
                (select id, fk_txn_id, event_type, event_name, event_date, paid_amount+tds_amount as paid_amount, txn_status , payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'other') B 
                on (A.fk_txn_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
                where C.paid_amount>0) D where D.paid_amount>0) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id=B.txn_id) C 
                left join 
                (select * from purchase_txn where txn_status = 'Approved') D 
                on (C.property_id = D.txn_id)) E 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') F 
                on (E.payer_id=F.c_id)) E 
                left join bank_master b on b.b_id=E.account_number
                        left join expense_category_master em on em.id = E.event_name where type='receipt' and  tds_amount>0 ".$where_condition ;  


  $result1=$this->db->query($sqlother)->result_array();
   if(count($result1)>0 && $bool1===false)
      {

        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TDS Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'TDS');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,'Status');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );

        $row = $row+1;    
        $start = $row;
        $bool1=true;

      }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['expense_category'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tds_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $tds_status);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    } 


    if($bool1==true)
    {
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')'); 
    }
    $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
    if($bool==true || $bool1==true)
    {
        $filename='TDS.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   
    }
    else
    {
        echo"<script>alert('Result Not Found');</script>";
    }
                     
}


public function gst_statement()
{
    $property_id  = html_escape($this->input->post('property'));
    $contact_id = html_escape($this->input->post('owner'));
    $sub_property_id = html_escape($this->input->post('sub_property'));
    $from_date = formatdate($this->input->post('from_date'));
    $to_date = formatdate($this->input->post('to_date'));
    
    $template_path=$this->config->item('template_path');
    $file = $template_path.'GST_report.xls';
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $gid=$this->session->userdata('groupid');
    $row=4;
    $start  = 5;
    $sr_no = 1;
    $prev = 0;
    $eventtype = '';
    $bool=false;

    $where_condition = "";

    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.purchase_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $puchasesql = "select E.*,b_name from 
            (select E.*, E.p_builder_name as contact_id, F.c_full_name, F.owner_name from 
            (select C.*, '' as sub_property_id, '' as sp_name, C.net_amount-C.paid_amount as bal_amount, 
                D.pr_client_id as payer_id, D.c_full_name as payer_full_name, D.owner_name as payer_owner_name from 
            (select * from 
            (select A.*, B.purchase_id, B.event_type, B.event_name, B.event_date, B.accounting_id, B.txn_status, B.entry_type, 
                case when B.basic_cost is null then 0 else B.basic_cost end as basic_cost, 
                case when B.net_amount is null then 0 else B.net_amount end as net_amount, 
                case when B.tax_amount is null then 0 else B.tax_amount end as tax_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount , B.payment_mode,B.cheque_no,B.account_number ,if(B.tds_amount_received=1,'received','pending') as tds_status ,B.tds_amount from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, p_builder_name 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received , B.tds_amount from 
            (select A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
                from purchase_schedule A left join purchase_schedule_taxation B on (A.purchase_id=B.pur_id and A.sch_id=B.sch_id) 
                where A.status = '1' and (B.status = '1' or B.status is null) 
                group by A.sch_id, A.purchase_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
            union all 
            select id as sch_id, fk_txn_id as purchase_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
                from actual_schedule_taxes where table_type = 'purchase') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, paid_amount+tds_amount as paid_amount ,payment_mode,cheque_no,account_number,tds_amount_received,tds_amount
                from actual_schedule where table_type = 'purchase'
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
                amount_paid as paid_amount ,payment_mode,cheque_no,account_number,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'purchase') B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) B 
            on A.txn_id = B.purchase_id)C where C.event_name is not null) C 
            left join 
            (select A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
            where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id
            )) A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            on (A.pr_client_id=B.c_id)) D 
            on C.txn_id=D.purchase_id) E 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') F 
            on (E.p_builder_name=F.c_id)) E 
            left join bank_master b on b.b_id=E.account_number where tax_amount >0 ".$where_condition;

    $result1=$this->db->query($puchasesql)->result_array();
   if(count($result1)>0 && $bool===false)
    {
          $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Payment')->getStyle('A'.$row)->getFont()->setBold(true);
            $row = $row+2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
              $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
            $row = $row+1;    
            $start = $row;
            $bool = true;
            
    }
    for($i=0;$i<count($result1);$i++)
    {
        $category =  'Purchase';
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payer_full_name'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tax_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    }   
    
    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlother = "select E.* ,b_name ,em.expense_category,
                select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')
                    end as Tenant_name 
                from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
                from 
                (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
                (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
                (select A.*, B.sp_name from 
                (select D.accounting_id, D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                    case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                    case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                    case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                    case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,if( D.tds_amount_received=1,'received','pending') as tds_status ,D.tds_amount from 
                (select * from 
                (select A.*, B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount from 
                (select A.fk_txn_id, A.type, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                    A.payer_id, A.property_id, A.sub_property_id 
                from actual_other_schedule A where A.gp_id = '$gid' and 
                    A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
                left join 
                (select id, fk_txn_id, event_type, event_name, event_date, paid_amount+tds_amount as paid_amount, txn_status , payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'other') B 
                on (A.fk_txn_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
                where C.paid_amount>0) D where D.paid_amount>0) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id=B.txn_id) C 
                left join 
                (select * from purchase_txn where txn_status = 'Approved') D 
                on (C.property_id = D.txn_id)) E 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') F 
                on (E.payer_id=F.c_id)) E 
                left join bank_master b on b.b_id=E.account_number
                        left join expense_category_master em on em.id = E.event_name where type='payment' and tax_amount >0 ".$where_condition; ;  


  $result1=$this->db->query($sqlother)->result_array();
  if(count($result1)>0 && $bool===false)
    {
          $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Payment')->getStyle('A'.$row)->getFont()->setBold(true);
            $row = $row+2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
            $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
             $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
            $row = $row+1;    
            $start = $row;
            $bool = true;
            
    }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['expense_category'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tax_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    } 

     if($bool==true)
     {
         $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
         $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')');
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
     }
    

    $bool1 = false;
    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlrent  = "select E.*,b_name,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
            from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payername,
            (Select cm.c_id from contact_master cm join rent_tenant_details r where r.rent_id=rent_id and cm.c_id=r.contact_id Limit 0,1) as payer_id
             from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.contact_id, D.c_full_name, D.owner_name from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from 
            (select C.*, if(D.tds_amount_received=1,'received','pending') as tds_status,D.tds_amount,D.rent_id, D.event_type, D.event_name, D.event_date, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, 
                D.accounting_id, D.txn_status, D.entry_type
                ,D.payment_mode,D.cheque_no,D.account_number from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details )) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, 
                B.id as accounting_id, B.txn_status, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount  from 
            (select A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
            from rent_schedule A left join rent_schedule_taxation B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) 
            where A.status = '1' and (B.status = '1' or B.status is null) 
            group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount 
                union all 
            select id as sch_id, fk_txn_id as rent_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
            from actual_schedule_taxes where table_type = 'rent') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status,payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'rent' 
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number ,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'rent' ) B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.rent_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
            (SELECT * FROM rent_tenant_details A WHERE A.contact_id in (select min(contact_id) from rent_tenant_details 
            where rent_id = A.rent_id group by rent_id)) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.contact_id=B.c_id)) D 
            on C.txn_id=D.rent_id) E
            left join bank_master b on b.b_id=E.account_number where tax_amount >0 ".$where_condition;;
  $result1=$this->db->query($sqlrent)->result_array();
  if(count($result1)>0 && $bool1==false)
      {
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':G'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
      $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
        $bool1=true;
      }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['event_type'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tax_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;

    } 

    $where_condition = "";
    if($contact_id!="")
    {
       $where_condition .= " And E.owner_id='$contact_id' ";
    }

    if($property_id!="")
    {
        $where_condition .= " And E.property_id ='$property_id'";
    }    


    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }


    if($from_date!="" && $to_date!="")
    {
            $where_condition .= " And   E.event_date>='$from_date' and E.event_date<='$to_date'";
    } 

    $salesql = "select E.*,b_name ,
            (Select case when c_owner_type='individual' 
            then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
            else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as owner_name 
            from contact_master cm join purchase_ownership_details p where p.purchase_id=E.property_id and cm.c_id=p.pr_client_id) as  owner_name
             from 
            (select C.*, C.net_amount-C.paid_amount as bal_amount, D.buyer_id as contact_id, D.c_full_name, D.owner_name as payername from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from 
            (select C.*, D.sale_id, D.event_type, D.event_name, D.event_date, D.accounting_id, D.txn_status, D.entry_type, 
                case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number,if(D.tds_amount_received,'received','pending') as tds_status,D.tds_amount from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale ,(Select c_id from contact_master cm join purchase_ownership_details p where p.purchase_id=A.property_id and cm.c_id=p.pr_client_id Limit 0,1) as  owner_id from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                txn_id in (select distinct sale_id from sales_buyer_details 
                )) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received,B.tds_amount from 
            (select A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, 
                sum(B.tax_amount) as tax_amount, 'schedule' as entry_type 
                from sales_schedule A left join sales_schedule_taxation B on (A.sale_id=B.sale_id and A.sch_id=B.sch_id) 
                where A.status = '1' and (B.status = '1' or B.status is null) 
                group by A.sch_id, A.sale_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount
            union all 
            select id as sch_id, fk_txn_id as sale_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                tax_amount as basic_cost, tax_amount as net_amount, 0 as tax_amount, 'tax' as entry_type 
                from actual_schedule_taxes where table_type = 'sales') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status ,payment_mode,cheque_no,account_number ,tds_amount_received,tds_amount 
                from actual_schedule where table_type = 'sales' 
            union all 
            select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
                amount_paid as paid_amount, txn_status ,payment_mode,cheque_no,account_number,'' as tds_amount_received ,'' as tds_amount from actual_schedule_taxes where table_type = 'sales' ) B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.sale_id) E where E.event_name is not null) A 
            left join 
            (
                select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id)) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E
            left join bank_master b on b.b_id=E.account_number where tax_amount >0 ".$where_condition;

    $result1=$this->db->query($salesql)->result_array();
    if(count($result1)>0 && $bool1==false)
      {
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
        $bool1=true;
      }
    for($i=0;$i<count($result1);$i++)
    {
        $category =  'Sales';
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tax_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    }       
    if(count($result1)>0 && $bool1===false)
      {
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Received')->getStyle('A'.$row)->getFont()->setBold(true);
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
      $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
        $bool1=false;
      }
    $where_condition = "";
    
    if($contact_id!="")
    {
       $where_condition .= " And E.contact_id='$contact_id' ";
    }

    if($property_id!="")
    {
         $where_condition .= " And E.property_id ='$property_id'";
    }    

    if($sub_property_id!="")
    {
        $where_condition .= " And E.sub_property_id ='$sub_property_id'";
    }
    
    if($from_date!="" && $to_date!="")
    {
       $where_condition .= "  and  E.event_date>='$from_date' and E.event_date<='$to_date'";
    }

    $sqlother = "select E.* ,b_name ,em.expense_category,
                (Select case when c_owner_type='individual' 
                then concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) 
                else concat(ifnull(c_company_name,''),' - ',ifnull(cm.c_name,''),' ',ifnull(c_last_name,'')) end as Tenant_name 
                from contact_master cm join purchase_ownership_details p where p.purchase_id=property_id and cm.c_id=p.pr_client_id Limit 0,1) as payername
                from 
                (select E.*, E.payer_id as contact_id, F.c_full_name, F.owner_name from 
                (select C.*, C.net_amount-C.paid_amount as bal_amount, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
                (select A.*, B.sp_name from 
                (select D.accounting_id, D.fk_txn_id, D.type, D.event_type, D.event_name, D.event_date, D.payer_id, D.property_id, D.sub_property_id, D.txn_status, 
                    case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, 
                    case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                    case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, 
                    case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount , D.payment_mode,D.cheque_no,D.account_number ,if( D.tds_amount_received=1,'received','pending') as tds_status ,D.tds_amount from 
                (select * from 
                (select A.*, B.id as accounting_id, B.txn_status, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount ,B.payment_mode,B.cheque_no,B.account_number ,B.tds_amount_received ,B.tds_amount from 
                (select A.fk_txn_id, A.type, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount, A.tax_amount, 
                    A.payer_id, A.property_id, A.sub_property_id 
                from actual_other_schedule A where A.gp_id = '$gid' and 
                    A.property_id in (select distinct purchase_id from purchase_ownership_details )) A 
                left join 
                (select id, fk_txn_id, event_type, event_name, event_date, paid_amount+tds_amount as paid_amount, txn_status , payment_mode,cheque_no,account_number,tds_amount_received ,tds_amount
                from actual_schedule where table_type = 'other') B 
                on (A.fk_txn_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
                where C.paid_amount>0) D where D.paid_amount>0) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id=B.txn_id) C 
                left join 
                (select * from purchase_txn where txn_status = 'Approved') D 
                on (C.property_id = D.txn_id)) E 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') F 
                on (E.payer_id=F.c_id)) E 
                left join bank_master b on b.b_id=E.account_number
                        left join expense_category_master em on em.id = E.event_name where type='receipt' and tax_amount >0 ".$where_condition ;  


  $result1=$this->db->query($sqlother)->result_array();
  if(count($result1)>0 && $bool1===false)
      {
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'GST Received');
        $row = $row+2;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Sr no');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,'Property name');
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,'Owner name');
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,'Payer name');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,'Category');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,'GST');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFill()->applyFromArray(array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'startcolor' => array(
                                                'rgb' => 'ffff00'
                                        )
                                    ));
        $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
        $row = $row+1;    
        $start = $row;
      }
  for($i=0;$i<count($result1);$i++)
    {
        $category =  $result1[$i]['expense_category'];
        $p_property_name = $result1[$i]['p_property_name'];
        $owner_name = $result1[$i]['owner_name'];
        $payer_name = $result1[$i]['payername'];
        $payment_mode = $result1[$i]['payment_mode'];
        $tds_status = $result1[$i]['tds_status'];
        $tds_amount = $result1[$i]['tax_amount'];

        $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $owner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $payer_name);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $category);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $tds_amount);
         $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $sr_no);
         $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );
         $sr_no=$sr_no+1;
         $row=$row+1;
    } 

    if($bool1==true)
    {
      $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,"Total");
     $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, '=SUM(F'.$start.':'."F".($row-1).')'); 
     $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            )
        );  
    }

    if($bool1==true || $bool==true)
    {
       $filename='GST.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');    
    }else{
        echo "<script>alert('Result Not Found');</script>";
    }

                     
}
      


public function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function getProperty(){
    $gid=$this->session->userdata('groupid');
    $this->db->select('txn_id,p_property_name');
    $this->db->from('purchase_txn');
    $this->db->where('gp_id = '.$gid.' and txn_status = "Approved" ');
    $result=$this->db->get();
    $this->db->last_query();
    return $result->result();
}


function get_owners(){
    $property_id = html_escape($this->input->post('property_id'));
    if($property_id!="")
            $propertyid = " where purchase_id=".$property_id;
        else
            $propertyid="";
    $gid=$this->session->userdata('groupid');

    $sql = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
    (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A 
        where A.purchase_id in (select distinct txn_id from purchase_txn where gp_id = '$gid')) A 
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
    on (A.pr_client_id=B.c_id) $propertyid Group By pr_client_id";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getSubPropertyDetails($txn_id='0', $property_id='0') {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    if ($txn_id!='0') {
        $cond = " and txn_id<>'$txn_id'";
    } else {
        $cond = "";
    }

    if ($property_id!='0') {
        $cond2 = " and property_id='$property_id'";
    } else {
        $cond2 = "";
    }

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();
    if (count($result)>0) {
        $sql="select distinct sp_id, sp_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
            on A.txn_id = B.property_id) C 
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
            on (A.pr_client_id=B.c_id)) D 
            on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    } else {
        $sql="select distinct sp_id, sp_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
            on A.txn_id = B.property_id) C 
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
            on (A.pr_client_id=B.c_id)) D 
            on C.txn_id = D.purchase_id) E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status = 'Approved'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    }

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}


function get_sale_properties(){
    $this->db->select('txn_id,p_property_name');
    $this->db->from('purchase_txn');
    $this->db->where('gp_id = '.$this->session->userdata('groupid').' and txn_status = "Approved" ');
    $this->db->where('txn_id in (select distinct property_id from sales_txn where txn_status = "Approved") ');
    $result=$this->db->get();
    return $result->result();
}

function get_rent_properties(){
    $this->db->select('txn_id,p_property_name');
    $this->db->from('purchase_txn');
    $this->db->where('gp_id = '.$this->session->userdata('groupid').' and txn_status = "Approved" ');
    $this->db->where('txn_id in (select distinct property_id from rent_txn where txn_status = "Approved") ');
    $result=$this->db->get();
    return $result->result();
}

function get_loan_properties(){
    $this->db->select('txn_id,p_property_name');
    $this->db->from('purchase_txn');
    $this->db->where('gp_id = '.$this->session->userdata('groupid').' and txn_status = "Approved" ');
    $this->db->where('txn_id in (select distinct property_id from loan_property_details where loan_id in 
                    (select distinct txn_id from loan_txn where txn_status = "Approved")) ');
    $result=$this->db->get();
    return $result->result();
}

function get_property_details($p_id){
    $gid=$this->session->userdata('groupid');

    $sql = "select * from purchase_txn where txn_id = '$p_id'";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function get_property_owners($p_id){
    $gid=$this->session->userdata('groupid');

    // $sql = "select * from 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id and A.purchase_id = '$p_id') C 
    //         order by pr_client_id";

    $sql = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A where A.purchase_id = '$p_id') A 
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
            on (A.pr_client_id=B.c_id) order by pr_client_id";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

// function getScheduleDetails($property_id){
//     $sql="select sch_id,event_name,a.event_date,basic_cost,net_amount,event_type,sch_status,status
//      from purchase_schedule a inner join
//      (select max(b.create_date) as f_date, min(b.create_date) l_date from purchase_schedule b 
//         where purchase_id = '".$property_id."' ) as maxmindate
//      ON  (a.create_date=maxmindate.f_date or a.create_date=maxmindate.l_date) where a.event_type !='' and a.status =2  ";
//     $result=$this->db->query($sql);
//     return $result->result();
// }

// function getRevisedScheduleDetails($property_id){
//     $sql="select sch_id,event_name,a.event_date,basic_cost,net_amount,event_type,sch_status,status
//      from purchase_schedule a inner join
//      (select max(b.create_date) as f_date, min(b.create_date) l_date from purchase_schedule b 
//         where purchase_id = '".$property_id."' ) as maxmindate
//      ON  (a.create_date=maxmindate.f_date or a.create_date=maxmindate.l_date) where a.event_type !='' and a.status =1  ";
//     $result=$this->db->query($sql);
//     // echo $this->db->last_query();
//     return $result->result();
// }

function getTaxDetail($property_id){
   // $sql="select  "
}

// function getTdsDetails(){
//     $this->db->select('tax_percent');
//     $this->db->from('tax_master');
//     $this->db->where('tax_name = "tds" and status = 1');
//     $result=$this->db->get();
//     if($result->num_rows() > 0){
//     return $result->row()->tax_percent;
//   }else{
//       return ' ';
//   }
// }

function get_property_buyers($s_id){
    // $sql = "select * from 
    //         (select A.sale_id, A.buyer_id, A.share_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as buyer_name 
    //         from sales_buyer_details A, owner_master B 
    //         where A.buyer_id=B.ow_id and A.sale_id = '$s_id') C 
    //         order by buyer_id";

    // $sql = "select A.*, B.owner_name as buyer_name FROM 
    //         (select * FROM sales_buyer_details A where A.sale_id = '$s_id') A 
    //         left join 
    //         (select concat('c_',c_id) as c_id, contact_name as owner_name from 
    //         (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
    //             ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
    //         (select * from contact_master) A 
    //         left join 
    //         (select * from contact_type_master) B 
    //         on (A.c_contact_type = B.id)) C 
    //         union all 
    //         select concat('o_',ow_id) as c_id, owner_name from 
    //         (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
    //             when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
    //             when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
    //             when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
    //             when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
    //             from (select ow_gid, ow_id, ow_type, 
    //                 (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                     where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
    //                 ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
    //                 ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
    //         where ow_status='Approved') A) B) B 
    //         ON (A.buyer_id=B.c_id)";

    $sql = "select A.*, B.owner_name as buyer_name FROM 
            (select * FROM sales_buyer_details A where A.sale_id = '$s_id') A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved') B 
            ON (A.buyer_id=B.c_id)";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}


function get_max_property_owner_cnt($p_id){
    $gid=$this->session->userdata('groupid');

    // $sql = "select max(cnt_pr_client_id) as max_cnt_pr_client_id from 
    //         (select purchase_id, count(pr_client_id) as cnt_pr_client_id from 
    //         (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent, 
    //                 case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
    //                         where c_id = B.ow_ind_id) 
    //                     when B.ow_type = '1' then B.ow_huf_name 
    //                     when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                     when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                     when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                     when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                     when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                     when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                     else B.ow_proprietorship_comapny_name end as owner_name 
    //         from purchase_ownership_details A, owner_master B 
    //         where A.pr_client_id=B.ow_id and A.purchase_id='$p_id') C 
    //         group by purchase_id) D";

    $sql = "select max(cnt_pr_client_id) as max_cnt_pr_client_id from 
            (select purchase_id, count(pr_client_id) as cnt_pr_client_id from 
            (select A.purchase_id, A.pr_client_id, A.pr_ownership_percent from purchase_ownership_details A 
                where A.purchase_id in (select distinct txn_id from purchase_txn where gp_id = '$gid')) C 
            group by purchase_id) D";

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

// function get_property_details_for_related_party($p_id){
//     $gid=$this->session->userdata('groupid');

//     $sql = "select * from 
//             (select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
//                     B.txn_id as sp_id, B.sp_name from 
//             (select * from purchase_txn where gp_id='$gid' and txn_id='$p_id' and txn_status = 'Approved') A 
//             left join 
//             (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
//             on A.txn_id=B.property_id) C 
//             order by txn_id, sp_id";

//     $query=$this->db->query($sql);
//     $result=$query->result();
//     return $result;
// }

function get_property_details_for_related_party($p_id){
    $gid=$this->session->userdata('groupid');

    $sql = "select AA.*, BB.contact_id, BB.c_name, BB.c_last_name, BB.c_address, BB.c_landmark, BB.c_city, BB.c_pincode, BB.c_state, BB.c_country, BB.c_mobile1, BB.c_emailid1, BB.kyc_doc_ref, BB.contact_type from 
            (select * from 
            (select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    null as sp_id, null as sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_id='$p_id' and txn_status = 'Approved') A 
            union all
            select A.*, case when A.p_type='Building' or A.p_type='Apartment' or A.p_type='Bunglow' then 'Residential' else 'Commercial' end as asset_type, 
                    B.txn_id as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id='$gid' and txn_id='$p_id' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id='$gid' and txn_status = 'Approved') B 
            on (A.txn_id=B.property_id) where B.txn_id is not null) C 
            order by asset_type, p_usage, txn_id, sp_id) AA 
            left join 
            (select E.*, F.contact_type from 
            (select C.*, D.c_name, D.c_last_name, D.c_address, D.c_landmark, D.c_city, D.c_pincode, D.c_state, D.c_country, D.c_mobile1, D.c_emailid1, D.c_contact_type, 
            D.kyc_doc_ref from 
            (select ref_id, ref_id as property_id, null as sub_property_id, contact_id from related_party_details where type = 'purchase' 
            union all 
            select A.ref_id, B.property_id, B.sub_property_id, A.contact_id from 
            (select ref_id, contact_id from related_party_details where type = 'sale') A 
            left join 
            (select * from sales_txn where gp_id='$gid' and txn_status='Approved') B 
            on (A.ref_id = B.txn_id) 
            union all 
            select A.ref_id, B.property_id, B.sub_property_id, A.contact_id from 
            (select ref_id, contact_id from related_party_details where type = 'rent') A 
            left join 
            (select * from rent_txn where gp_id='$gid' and txn_status='Approved') B 
            on (A.ref_id = B.txn_id)) C 
            left join 
            (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
            (select * from contact_master where c_gid='$gid' and c_status='Approved') A 
            left join 
            (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
            on (A.c_id = B.kyc_cid)) D 
            on (C.contact_id=D.c_id)) E 
            left join 
            (select * from contact_type_master) F 
            on (E.c_contact_type = F.id) where F.contact_type is not null) BB 
            on (ifnull(AA.txn_id,0) = ifnull(BB.property_id,0) and ifnull(AA.sp_id,0) = ifnull(BB.sub_property_id,0))
            order by AA.asset_type, AA.p_usage, AA.txn_id, AA.sp_id";

    $query=$this->db->query($sql);
    // echo $this->db->last_query();
    $result=$query->result();
    return $result;
}

// function generate_asset_level_purchase_varience(){
//     $property_id=$this->input->post('property');
//     $data=$this->getScheduleDetails($property_id);
//     $data1=$this->getRevisedScheduleDetails($property_id);
//     $tds_per=$this->getTdsDetails();
//     $gid=$this->session->userdata('groupid');
   

//     if(count($data)>0 || count($data1)>0) {
//         $tax_detail=$this->getTaxDetail($property_id);

//         // $file = base_url().'assets/templates/Owner_Level_Asset_Allocation_Usage_Wise.xlsx';
//         $template_path=$this->config->item('template_path');
//         $file = $template_path.'asset_level_varience_excel.xlsx';
//         $this->load->library('excel');
//         $objPHPExcel = PHPExcel_IOFactory::load($file);
//         $rowno=9;
//         $srno=1;
//         $prev_event='';
//         $i=0;
//         $sch_id=0;

//         foreach($data as $row){
//                 $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowno, $srno);
//                 $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowno, $row->event_type);
//                 $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowno, $row->event_name);
//                 $rowno++;
//                 $srno++; 
//                $checkeventname=$i++;
//                $sch_id = $sch_id.','.$row->sch_id;               
//         }

//         $txncol=7;               

//         $sql="select distinct(tax_type) tax_type from purchase_schedule_taxation  where sch_id in ($sch_id) group by tax_type order by tax_master_id asc ";

//         $result_tax=$this->db->query($sql);
//         $key=0;

//         if($result_tax->num_rows() > 0){
//           $objPHPExcel->getActiveSheet()->insertNewColumnBefore('G', (count($result_tax->result()) *2));
//           foreach($result_tax->result() as $txn){           
//               $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(%)');
//               $txncol++;
//               $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(Amount)');
//               $txncol++;
//               $tax_array[$key]=$txn->tax_type;

//               $key++;
//           }
//         }

//         //get detail array for projected Schedule
//         $newrowcount=9;
//         $detail_data=$this->dispalyDetailValue($sch_id);
//         for($k=0;$k<count($detail_data['p_schedule']);$k++){
//             $objPHPExcel->getActiveSheet()->setCellValue('F'.$newrowcount,date('d-M-y',strtotime($detail_data['p_schedule'][$k]['event_date'])));
//             $objPHPExcel->getActiveSheet()->setCellValue('G'.$newrowcount,$detail_data['p_schedule'][$k]['basic_cost']);
//             $newtxncol=6; 
//             $total_tax=0;
//             $net_gross_amt=0;   
//             $total_gross=$detail_data['p_schedule'][$k]['basic_cost'];

//             for($tcnt=0;$tcnt<$key;$tcnt++){
//                 for($nc=0;$nc<count($detail_data['p_schedule'][$k]['tax_type']);$nc++) {
//                     $tax_amount='';
//                     $tax_percent='';
//                     if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt]) {
//                       $tax_amount=format_number($detail_data['p_schedule'][$k]['tax_amount'][$nc],2);
//                       $tax_percent=$detail_data['p_schedule'][$k]['tax_percent'][$nc];
//                       $nc=count($detail_data['p_schedule'][$k]['tax_type']);
//                     }
//                 }

//                 // $newtxncol++;
//                 if($tax_amount !=''){
//                     $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$tax_amount);
//                      $total_tax= $total_tax+$tax_amount;
//                 } else {
//                     $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$tax_amount);
//                 }
                    
//                 $newtxncol++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$tax_percent.'%');
//             }

//             $newtxncol++;                  
//             $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$total_tax);
//             $total_gross=$total_gross+$total_tax;

//             $newtxncol++;                  
//             $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$total_gross);
//             //tds details
//             $newtxncol++;
//             $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$tds_per.'%');
//             $tds_cal=round(($detail_data['p_schedule'][$k]['basic_cost'])*$tds_per/100);
//             $newtxncol++;
//             $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$tds_cal);
//             $net_gross_amt=$total_gross-$tds_cal;

//             $newtxncol++;
//             $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount,$net_gross_amt);
//             $newtxncol++;
                     
//             $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($newtxncol).$newrowcount)->getFill()->applyFromArray(array(
//                 'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                 'startcolor' => array(
//                     'rgb' => '#000000'
//                 )
//             ));

//            $newrowcount++; 
//         }

//         $nexttaxindex=8+$txncol;
//         $oldcolmindex=6+$txncol;

//         $sch_id1=0;
//         foreach($data1 as $row1){               
//            //  $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowno, $srno);
//            //  $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowno, $row->event_type);
//            //  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowno, $row->event_name);
//            //  $rowno++;
//            //  $srno++; 
//            // $checkeventname=$i++;
//            $sch_id1 = $sch_id1.','.$row1->sch_id;               
//         }

//         $sql1="select distinct(tax_type) tax_type from purchase_schedule_taxation  where sch_id in ($sch_id1) group by tax_type order by tax_master_id asc ";
//         $result_tax1=$this->db->query($sql1);
//         $key=0;
//         if($result_tax1->num_rows() > 0){
//             $objPHPExcel->getActiveSheet()->insertNewColumnBefore(PHPExcel_Cell::stringFromColumnIndex($nexttaxindex), (count($result_tax1->result()) *2));
//             $txncol=$nexttaxindex;               
//             foreach($result_tax1->result() as $txn){           
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(%)');
//                 $txncol++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(Amount)');
//                 $txncol++;
//                 $tax_array[$key]=$txn->tax_type;

//                 $key++;
//             }
//         }


//         //get detail array for revised tax Schedule
//         $detail_data=$this->dispalyDetailValue($sch_id1);
//         $newrowcount=9;

//             for($k=0;$k<count($detail_data['p_schedule']);$k++){
//                 $newcolmindex=$oldcolmindex;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,date('d-M-y',strtotime($detail_data['p_schedule'][$k]['event_date'] )));
//                 $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$detail_data['p_schedule'][$k]['basic_cost']);
//          $newtxncol=7; 
//             $total_tax=0;  
//             $total_gross=$detail_data['p_schedule'][$k]['basic_cost'];
//             $net_gross_amt=0;       
//          for($tcnt=0;$tcnt<$key;$tcnt++){
//                     if(isset($detail_data['p_schedule'][$k]['tax_type'])){
//                         for($nc=0;$nc<count($detail_data['p_schedule'][$k]['tax_type']);$nc++){
//                           $tax_amount='';
//                           $tax_percent='';
//                           if($detail_data['p_schedule'][$k]['tax_type'][$nc]==$tax_array[$tcnt]) {
//                             $tax_amount=format_number($detail_data['p_schedule'][$k]['tax_amount'][$nc],2);
//                           $tax_percent=$detail_data['p_schedule'][$k]['tax_percent'][$nc];

//                             $nc=count($detail_data['p_schedule'][$k]['tax_type']);
//                           }
//                         }
//                     }
                    
//                     $newcolmindex++;
//                     if($tax_amount !=''){
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_amount);
//                      $total_tax=$total_tax+$tax_amount;
//                     } else {
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_amount);

                     
//                     }
//                     $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_percent);

//                   }
//                     $newcolmindex++;                  
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$total_tax);
//                     $total_gross=$total_gross+$total_tax;
//                      $newcolmindex++;                  
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$total_gross);
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tds_per);
//                 $tds_cal=round(($detail_data['p_schedule'][$k]['basic_cost'])*$tds_per/100);
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tds_cal);
//                     $net_gross_amt=$total_gross-$tds_cal;
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$net_gross_amt);
//                      $newcolmindex++;
                
//                 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount)->getFill()->applyFromArray(array(
//                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                     'startcolor' => array(
//                         'rgb' => '#000000'
//                     )
//                 ));

//                 $newrowcount++;  
//                 //$newcolmindex++;  

//             }
//          // dispaly value in coloumn

// ///////////////////////****************************actual schedule************************////////////////
//              $nexttaxindex=8+$txncol;
//          $oldcolmindex=6+$txncol;
         
//          $key=0;
//          if($result_tax1->num_rows() > 0){
//             $objPHPExcel->getActiveSheet()->insertNewColumnBefore(PHPExcel_Cell::stringFromColumnIndex($nexttaxindex), (count($result_tax1->result()) *2));
//             $txncol=$nexttaxindex;               
//             foreach($result_tax1->result() as $txn){           
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(%)');
//                 $txncol++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($txncol).'7',$txn->tax_type.'(Amount)');
//                 $txncol++;
//                 $tax_array[$key]=$txn->tax_type;

//                 $key++;
//             }
//          }
//             $newrowcount=9;
//             for($k=0;$k<count($detail_data['p_schedule']);$k++){
//                 $sql_new="select sum(paid_amount) paid_actual,group_concat(',',tax_applied) as tax_applied from actual_schedule 
//                 where table_type='purchase' and event_type='".$detail_data['p_schedule'][$k]['event_type']."'
//                 and event_name='".$detail_data['p_schedule'][$k]['event_name']."' and event_date='".$detail_data['p_schedule'][$k]['event_date']."'
//                 and fk_txn_id='".$property_id."' and txn_status = 'Approved'";

//                 $result=$this->db->query($sql_new);
//                 $row=$result->row();

//                 $newcolmindex=$oldcolmindex;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,date('d-M-y',strtotime($detail_data['p_schedule'][$k]['event_date'])) );
//                 $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$row->paid_actual);
//          $newtxncol=7; 
//             $total_tax=0;  
//             $total_gross=$row->paid_actual;
//             $net_gross_amt=0;       
//          for($tcnt=0;$tcnt<$key;$tcnt++){
//                   if(isset($detail_data['p_schedule'][$k]['tax_type'])) {
//                     for($nc=0;$nc<count($detail_data['p_schedule'][$k]['tax_type']);$nc++) {
//                       $tax_amount='';
//                       $tax_percent='';
//                       if($detail_data['p_schedule'][$k]['tax_type'][$nc]==$tax_array[$tcnt]) {                        
//                       $tax_percent=$detail_data['p_schedule'][$k]['tax_percent'][$nc];
//                       $tax_amount=round($total_gross * $tax_percent /100);
//                         $nc=count($detail_data['p_schedule'][$k]['tax_type']);
//                       }
//                     }
//                   }
                    
//                     $newcolmindex++;
//                     if($tax_amount !=''){
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_amount);
//                      $total_tax=$total_tax+$tax_amount;
//                     } else {
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_amount);

                     
//                     }
//                     $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tax_percent);

//                   }
//                     $newcolmindex++;                  
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$total_tax);
//                    // $total_gross=$total_gross+$total_tax;
//                      $newcolmindex++;                  
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$total_gross);
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tds_per);
//                 //tds calculation
//                     $tax_count='';
//                     $pre_tax_id='';
//                     $tds_per=0;
//                     $total_tax_app=explode(',',$row->tax_applied);
//                     //print_r($total_tax_app);
//                     $tax=0;
//                     foreach($total_tax_app as $row){
//                         if($total_tax_app[$tax] !=''){
//                         $tax_app=explode('_',$total_tax_app[$tax]);
//                         if($pre_tax_id != $tax_app[0]){
//                             $tax_count = $tax_count + $tax_app[1];
//                         }
//                         $pre_tax_id=$tax_app[0];
//                     }
//                         $tax++;
                    
//                 }

//                 if($tax==0){
//                     $tds_per= 0;
//                 } else {
//                     $tds_per= round($tax_count/($tax*100));
//                 }

//                 $tds_cal=round($total_gross*$tds_per/100);
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$tds_cal);
//                     $net_gross_amt=$total_gross-$tds_cal;
//                      $newcolmindex++;
//                 $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,$net_gross_amt);
//                      $newcolmindex++;
                
//                 $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount)->getFill()->applyFromArray(array(
//                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                     'startcolor' => array(
//                         'rgb' => '#000000'
//                     )
//                 ));
//                 $newcolmindex++;

//  $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($newcolmindex).$newrowcount,($detail_data['p_schedule'][$k]['net_amount']-$net_gross_amt));
//                      $newcolmindex++;
                
//                 $newrowcount++;  




//             }

//              $objPHPExcel->getActiveSheet()->setCellValue('C'.($newrowcount+1),'Total');
//             $objPHPExcel->getActiveSheet()->getStyle('C'.($newrowcount+1).':C'.($newrowcount+1))->getFont()->setBold(true);

//             for($m=6;$m<$newcolmindex;$m++){
//              $objPHPExcel->getActiveSheet()->setCellValue(PHPExcel_Cell::stringFromColumnIndex($m).($newrowcount+1), '=sum('.PHPExcel_Cell::stringFromColumnIndex($m).'9:'.PHPExcel_Cell::stringFromColumnIndex($m).$newrowcount.')');
//             $objPHPExcel->getActiveSheet()->getStyle(PHPExcel_Cell::stringFromColumnIndex($m).($newrowcount+1).':'.PHPExcel_Cell::stringFromColumnIndex($m).($newrowcount+1))->getFont()->setBold(true);
//           }

//         $filename='asset_level_purchase_varience.xls';
//         header('Content-Type: application/vnd.ms-excel');
//         header('Content-Disposition: attachment;filename="'.$filename.'"');
//         header('Cache-Control: max-age=0');
//         $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//         $objWriter->save('php://output');

//         $logarray['table_id']=$this->session->userdata('session_id');
//         $logarray['module_name']='Reports';
//         $logarray['cnt_name']='Reports';
//         $logarray['action']='Asset Level Purchase Varience report generated.';
//         $logarray['gp_id']=$gid;
//         $this->user_access_log_model->insertAccessLog($logarray);
//     } else {
//         echo '<script>alert("No data found");</script>';
//     }

// }


function generate_asset_level_purchase_variance_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $new_row_cnt = 0;
    $sr_no = 1;
    $purchase_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    $sql = "select * from purchase_txn where txn_id='$p_id' and txn_status='Approved'";
    $query = $this->db->query($sql);
    $data = $query->result();

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Sale_Variance.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Purchase_Variance.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $p_id = $data[0]->txn_id;

        $result=$this->get_property_details($p_id);
        if(count($result)>0) {
            $objPHPExcel->getActiveSheet()->setCellValue('C3', $result[0]->p_property_name);
        }

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
            $owner_cnt=count($result);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore('4', $owner_cnt);
            $new_row_cnt=$new_row_cnt+$owner_cnt;

            $row=4;
            $cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->owner_name);
                $row=$row+1;
                $cnt=$cnt+1;
            }
        }

        $sql = "select distinct tax_id from 
                (select distinct tax_master_id as tax_id from purchase_schedule_taxation where pur_id = '$p_id' 
                union all 
                select distinct tax_applied as tax_id from actual_schedule_taxes 
                where fk_txn_id = '$p_id' and table_type = 'purchase') A";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $tax_cnt = count($result);
        } else {
            $tax_cnt = 0;
        }
        $tot_col = 29 + $tax_cnt + 50;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }


        $sql = "select min(create_date) as initial_date from purchase_schedule where purchase_id = '$p_id' and status in('1', '2')";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $initial_date = $result[0]->initial_date;
        } else {
            $initial_date = date('Y-m-d');
        }

        $sql = "select A.tax_master_id, B.tax_name from 
                (select distinct tax_master_id from purchase_schedule_taxation where pur_id = '$p_id' and status in('1', '2') and 
                sch_id in (select distinct sch_id from purchase_schedule where purchase_id = '$p_id' and create_date = '$initial_date') and status in('1', '2')) A 
                left join 
                (select * from tax_master) B 
                on A.tax_master_id = B.tax_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $initial_tax_cnt = count($result)*2;
            $col = 7;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $initial_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }
        } else {
            $initial_tax_cnt = 0;
        }

        $sql = "select A.tax_master_id, B.tax_name from 
                (select distinct tax_master_id from purchase_schedule_taxation where pur_id = '$p_id' and status = '1' and 
                sch_id in (select distinct sch_id from purchase_schedule where purchase_id = '$p_id' and status = '1')) A 
                left join 
                (select * from tax_master) B 
                on A.tax_master_id = B.tax_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $latest_tax_cnt = count($result)*2;
            $col = 15+$initial_tax_cnt;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $latest_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }

            $actual_tax_cnt = count($result)*2;
            $col = 23+$initial_tax_cnt+$latest_tax_cnt;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $actual_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }
        } else {
            $latest_tax_cnt = 0;
            $actual_tax_cnt = 0;
        }

        $initial_col = $initial_tax_cnt;
        $latest_col = $initial_tax_cnt + $latest_tax_cnt;
        $actual_col = $initial_tax_cnt + $latest_tax_cnt + $actual_tax_cnt;
        $row = 7;

        $sql = "select E.event_type, E.event_name, E.initial_sch_id, E.initial_event_date, E.initial_net_amount, E.latest_sch_id, E.latest_event_date, E.latest_net_amount, F.actual_event_date, F.actual_paid_amount from 
                (select C.event_type, C.event_name, C.initial_sch_id, C.initial_event_date, C.initial_net_amount, D.sch_id as latest_sch_id, D.event_date as latest_event_date, D.net_amount as latest_net_amount from 
                (select A.event_type, A.event_name, B.sch_id as initial_sch_id, B.event_date as initial_event_date, B.net_amount as initial_net_amount from 
                (select distinct event_type, event_name from 
                (select event_type, event_name, event_date from purchase_schedule where purchase_id = '$p_id' and create_date = '$initial_date' and status in('1', '2') 
                union all 
                select event_type, event_name, event_date from purchase_schedule where purchase_id = '$p_id' and status = '1'
                union all 
                select event_type, event_name, event_date from actual_schedule where fk_txn_id = '$p_id' and txn_status = 'Approved' and table_type = 'purchase') A 
                order by event_type) A 
                left join 
                (select sch_id, event_type, event_name, event_date, net_amount from purchase_schedule 
                    where purchase_id = '$p_id'and create_date = '$initial_date' and status in('1', '2')) B 
                on (A.event_type=B.event_type and A.event_name=B.event_name)) C 
                left join 
                (select sch_id, event_type, event_name, event_date, net_amount from purchase_schedule where purchase_id = '$p_id'and status = '1') D 
                on (C.event_type=D.event_type and C.event_name=D.event_name)) E 
                left join 
                (select event_type, event_name, max(event_date) as actual_event_date, sum(paid_amount) as actual_paid_amount from actual_schedule 
                    where fk_txn_id = '$p_id' and txn_status = 'Approved' and table_type = 'purchase' 
                    group by event_type, event_name) F 
                on (E.event_type=F.event_type and E.event_name=F.event_name)";
        $query = $this->db->query($sql);
        $data = $query->result();
        if(count($data)>0){
            $sql = "select * from tax_master where tax_name = 'tds'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $tds_percent = is_numeric($result[0]->tax_percent)?$result[0]->tax_percent:0;
            } else {
                $tds_percent = 0;
            }

            for($i=0; $i<count($data); $i++){
                $event_type = $data[$i]->event_type;
                $event_name = $data[$i]->event_name;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[0].strval($row+$new_row_cnt), $sr_no);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].strval($row+$new_row_cnt), $data[$i]->event_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[2].strval($row+$new_row_cnt), $data[$i]->event_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3].strval($row+$new_row_cnt), '');

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->initial_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6].strval($row+$new_row_cnt), $data[$i]->initial_net_amount);

                $sch_id = $data[$i]->initial_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from purchase_schedule_taxation where pur_id='$p_id' and sch_id='$sch_id' and status in('1', '2')";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=7;
                        for($k=0;$k<($initial_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$initial_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$initial_col].strval($row+$new_row_cnt), '='.$col_name[6].strval($row+$new_row_cnt).'+'.$col_name[7+$initial_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$initial_col].strval($row+$new_row_cnt), $tds_percent);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$initial_col].strval($row+$new_row_cnt), '='.$col_name[8+$initial_col].strval($row+$new_row_cnt).'*'.$col_name[9+$initial_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$initial_col].strval($row+$new_row_cnt), '='.$col_name[8+$initial_col].strval($row+$new_row_cnt).'-'.$col_name[10+$initial_col].strval($row+$new_row_cnt));



                $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$initial_col].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->latest_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$initial_col].strval($row+$new_row_cnt), $data[$i]->latest_net_amount);

                $sch_id = $data[$i]->latest_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from purchase_schedule_taxation where pur_id='$p_id' and sch_id='$sch_id' and status = '1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=15+$initial_col;
                        for($k=0;$k<($latest_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$latest_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$latest_col].strval($row+$new_row_cnt), '='.$col_name[14+$initial_col].strval($row+$new_row_cnt).'+'.$col_name[15+$latest_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$latest_col].strval($row+$new_row_cnt), $tds_percent);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$latest_col].strval($row+$new_row_cnt), '='.$col_name[16+$latest_col].strval($row+$new_row_cnt).'*'.$col_name[17+$latest_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$latest_col].strval($row+$new_row_cnt), '='.$col_name[16+$latest_col].strval($row+$new_row_cnt).'-'.$col_name[18+$latest_col].strval($row+$new_row_cnt));



                $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$latest_col].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->actual_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$latest_col].strval($row+$new_row_cnt), $data[$i]->actual_paid_amount);

                $sch_id = $data[$i]->latest_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from purchase_schedule_taxation where pur_id='$p_id' and sch_id='$sch_id' and status = '1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=23+$latest_col;
                        for($k=0;$k<($latest_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$actual_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$actual_col].strval($row+$new_row_cnt), '='.$col_name[22+$latest_col].strval($row+$new_row_cnt).'+'.$col_name[23+$actual_col].strval($row+$new_row_cnt));

                $total_tds = 0;
                $total_tds_per = 0;
                $sql = "select * from actual_schedule where table_type='purchase' and fk_txn_id='$p_id' and event_type='$event_type' and event_name='$event_name' and txn_status = 'Approved'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $net_amount = is_numeric($result[$j]->net_amount)?$result[$j]->net_amount:0;
                        $tax_applied = $result[$j]->tax_applied;

                        $tax_id = explode(',', $tax_applied);
                        for($k=0; $k<count($tax_id); $k++){
                            // $tds_code = $tax_id[$k];
                            $tds_code = explode('_', $tax_id[$k]);
                            if(count($tds_code)>0){
                                if (isset($tds_code[1])) {
                                    $tds_per = is_numeric($tds_code[1])?$tds_code[1]:0;
                                    $total_tds_per = $total_tds_per + $tds_per;
                                    $total_tds = $total_tds + (($net_amount * $tds_per)/100);
                                }
                            }
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$actual_col].strval($row+$new_row_cnt), $total_tds_per);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$actual_col].strval($row+$new_row_cnt), $total_tds);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$actual_col].strval($row+$new_row_cnt), '='.$col_name[24+$actual_col].strval($row+$new_row_cnt).'-'.$col_name[26+$actual_col].strval($row+$new_row_cnt));


                $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$actual_col].strval($row+$new_row_cnt), '=IF('.$col_name[27+$actual_col].strval($row+$new_row_cnt).'>0,IF('.$col_name[19+$latest_col].strval($row+$new_row_cnt).'>0,'.$col_name[19+$latest_col].strval($row+$new_row_cnt).'-'.$col_name[27+$actual_col].strval($row+$new_row_cnt).','.$col_name[11+$initial_col].strval($row+$new_row_cnt).'-'.$col_name[27+$actual_col].strval($row+$new_row_cnt).'),0)');

                $row = $row + 1;
                $sr_no = $sr_no + 1;
            }

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row+$new_row_cnt, 1);
            $row = $row + 1;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row+$new_row_cnt), $sr_no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row+$new_row_cnt), 'Net Receivables');
            $objPHPExcel->getActiveSheet()->setCellValue('G'.strval($row+$new_row_cnt), '=sum(G'.strval(7+$new_row_cnt).':G'.strval($row+$new_row_cnt-1).')');
            $col=7;
            for($k=0;$k<($initial_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[7+$initial_col].strval(7+$new_row_cnt).':'.$col_name[7+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[8+$initial_col].strval(7+$new_row_cnt).':'.$col_name[8+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[10+$initial_col].strval(7+$new_row_cnt).':'.$col_name[10+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[11+$initial_col].strval(7+$new_row_cnt).':'.$col_name[11+$initial_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[14+$initial_col].strval(7+$new_row_cnt).':'.$col_name[14+$initial_col].strval($row+$new_row_cnt-1).')');
            $col=15+$initial_col;
            for($k=0;$k<($latest_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[15+$latest_col].strval(7+$new_row_cnt).':'.$col_name[15+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[16+$latest_col].strval(7+$new_row_cnt).':'.$col_name[16+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[18+$latest_col].strval(7+$new_row_cnt).':'.$col_name[18+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[19+$latest_col].strval(7+$new_row_cnt).':'.$col_name[19+$latest_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[22+$initial_col].strval(7+$new_row_cnt).':'.$col_name[22+$initial_col].strval($row+$new_row_cnt-1).')');
            $col=23+$latest_col;
            for($k=0;$k<($actual_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[23+$actual_col].strval(7+$new_row_cnt).':'.$col_name[23+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[24+$actual_col].strval(7+$new_row_cnt).':'.$col_name[24+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[26+$actual_col].strval(7+$new_row_cnt).':'.$col_name[26+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[27+$actual_col].strval(7+$new_row_cnt).':'.$col_name[27+$actual_col].strval($row+$new_row_cnt-1).')');


            $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[29+$actual_col].strval(7+$new_row_cnt).':'.$col_name[29+$actual_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->getStyle($col_name[4].strval(6+$new_row_cnt).':'.$col_name[4].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[12+$initial_col].strval(6+$new_row_cnt).':'.$col_name[12+$initial_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[20+$latest_col].strval(6+$new_row_cnt).':'.$col_name[20+$latest_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[28+$actual_col].strval(6+$new_row_cnt).':'.$col_name[28+$actual_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle('A'.strval(6+$new_row_cnt).':'.$col_name[29+$actual_col].strval($row+$new_row_cnt))->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            ));

            for($k=0;$k<=29+$actual_col;$k++) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$k].strval(5+$new_row_cnt), '');
            }
        }

        

        $filename='Asset_Level_Purchase_Variance_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Purchase Variance report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}


function dispalyDetailValue($sch_id){

    $event_type='';
    $event_name='';
    $basic_amount=0;
    $net_amount=0;
    //$sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM temp_schedule  WHERE txn_type = '".$pid."' and status = '1' GROUP BY event_type";
    $sql="SELECT sch_id,event_type,event_date,event_name,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM purchase_schedule  WHERE sch_id in (".$sch_id.")  GROUP BY event_type";
    //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$pid."' and status = '1' ");
    $query=$this->db->query($sql);
    $result=$query->result();
    $data['p_schedule']=array();
    //echo $pid;
           
    $k=0;
    $total_net_amount=0;
    if(count($result)>0) {
        foreach($result as $row){
            $data['p_schedule'][$k]['event_date']=$row->event_date;
            $data['p_schedule'][$k]['event_name']=$row->event_name;
            $data['p_schedule'][$k]['event_type']=$row->event_type;
            $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
            $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                //distint tax name
            // $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM temp_schedule_taxation WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '1' group by tax_type order by tax_master_id asc ");
            $query=$this->db->query("SELECT tax_type,tax_percent,sum(tax_amount) as tax_amount FROM purchase_schedule_taxation WHERE sch_id ='".$row->sch_id."' group by tax_type order by tax_master_id asc ");
            $result_tax=$query->result();
            $j=0;
            if(count($result_tax) > 0){
                foreach($result_tax as $taxrow){
                    $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                    $data['p_schedule'][$k]['tax_amount'][$j]=format_money($taxrow->tax_amount,2);
                    $data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;

                    //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
            $j++;
                }
            }


            $total_net_amount=$total_net_amount+$row->net_amount;

            //$data['p_schtxn']=$result;
            $k++;
        }
    }
        
   
    return $data;
}


function generate_asset_level_related_party_report(){
    $p_id = $this->input->post('property');
    $data = $this->get_max_property_owner_cnt($p_id);
    if(count($data)>0) {
        $owner_cnt = $data[0]->max_cnt_pr_client_id;
    } else {
        $owner_cnt = 0;
    }
    $owner_cnt=$owner_cnt*2;
    $data = $this->get_property_details_for_related_party($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Related_Party.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Related_Party.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');
        // $objPHPExcel->getActiveSheet()->setCellValue('B1', $this->session->userdata('groupname'));
        $col_name[]=array();
        $tot_col = 63+$owner_cnt;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }

        if($owner_cnt>0){
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore('D', $owner_cnt);
            $col=3;
            for($j=1; $j<=($owner_cnt/2); $j++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].'5', 'Owner '.$j);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].'5', '% Holding');
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col_name[$col].'5:'.$col_name[$col+1].'5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('969696');
                $col=$col+2;
            }
        }

        $gid=$this->session->userdata('groupid');
        $s_row=6;
        $row=6;
        $col=0;
        $prev_asset_type="";
        $asset_type="";
        $prev_p_usage="";
        $p_usage="";
        $prev_property_id="";
        $property_id="";
        $sr_no=1;
        $agreement_area = 0;
        $pending_activity = "";

        $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].'1', $data[0]->p_property_name);

        for($i=0; $i<count($data); $i++) {
            $asset_type=$data[$i]->asset_type;
            $p_usage=$data[$i]->p_usage;
            $property_id=$data[$i]->txn_id;

            if($prev_property_id!=$property_id) {
                $prev_property_id=$property_id;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $sr_no=$sr_no+1;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $data[$i]->p_property_name);

                $result=$this->get_property_owners($property_id);
                if(count($result)>0) {
                    $col=3;
                    for($j=0; $j<count($result); $j++) {
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row), $result[$j]->owner_name);
                        $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row), $result[$j]->pr_ownership_percent);
                        $col=$col+2;
                    }
                }

                $address = get_address($data[$i]->p_address, $data[$i]->p_landmark, $data[$i]->p_city, $data[$i]->p_pincode, $data[$i]->p_state, $data[$i]->p_country);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3+$owner_cnt].strval($row), $address);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[4+$owner_cnt].strval($row), $asset_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5+$owner_cnt].strval($row), $p_usage);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6+$owner_cnt].strval($row), $data[$i]->p_status);
                $agreement_area = 0;
                $pending_activity = "";

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$owner_cnt].strval($row), $data[$i]->remarks);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $data[$i]->sp_name);
            $sub_property_id = isset($data[$i]->sp_id)?$data[$i]->sp_id:0;

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$owner_cnt].strval($row), $data[$i]->contact_type);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$owner_cnt].strval($row), $data[$i]->c_name . ' ' . $data[$i]->c_last_name);
            $address = get_address($data[$i]->c_address, $data[$i]->c_landmark, $data[$i]->c_city, $data[$i]->c_pincode, $data[$i]->c_state, $data[$i]->c_country);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$owner_cnt].strval($row), $address);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$owner_cnt].strval($row), $data[$i]->c_mobile1);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[12+$owner_cnt].strval($row), $data[$i]->c_emailid1);
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$owner_cnt].strval($row), $data[$i]->kyc_doc_ref);

            $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[15+$owner_cnt].strval($row))->applyFromArray(array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);

            $row=$row+1;
        }

        $objPHPExcel->getActiveSheet()->getStyle('A'.strval($row).':'.$col_name[15+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $row=$row+1;

        $objPHPExcel->getActiveSheet()->getStyle('A6:'.$col_name[15+$owner_cnt].strval($row))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle($col_name[7+$owner_cnt].'6:'.$col_name[7+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle($col_name[14+$owner_cnt].'6:'.$col_name[14+$owner_cnt].strval($row))->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => '000000'
            )
        ));

        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[15+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
        $objPHPExcel->getActiveSheet()->getStyle('A5:'.$col_name[15+$owner_cnt].strval(5))->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));

        $filename='Asset_Level_Related_Party_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Related Party report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}



function generate_asset_level_sale_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sr_no = 4;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $data=$this->get_property_details($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Sale.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Sale.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', $data[0]->p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', $data[0]->p_property_name);
        $address = get_address($data[0]->p_address, $data[0]->p_landmark, $data[0]->p_city, $data[0]->p_pincode, $data[0]->p_state, $data[0]->p_country);
        $objPHPExcel->getActiveSheet()->setCellValue('C7', $address);

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
        	$owner_cnt=count($result);
        	$objPHPExcel->getActiveSheet()->insertNewRowBefore('8', $owner_cnt);
        	$new_row_cnt=$new_row_cnt+$owner_cnt;

        	$row=8;
        	$sr_no=4;
        	$cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->owner_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), $result[$j]->pr_ownership_percent);
                $row=$row+1;
                $sr_no=$sr_no+1;
                $cnt=$cnt+1;
            }
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(8+$new_row_cnt), $sr_no);
        $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$p_id' and status='1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
        	$purchase_cost = $result[0]->tot_net_amount;
        	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(8+$new_row_cnt), $result[0]->tot_net_amount);
        }

        $sql = "select * from purchase_property_description where purchase_id='$p_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
        	$agreement_area = $result[0]->pr_agreement_area;
        } else {
        	$agreement_area = 1;
        }

        if($sp_id!=0 and $sp_id!=''){
        	$sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
        	$query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$objPHPExcel->getActiveSheet()->setCellValue('C6', $result[0]->sp_name);
	        	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(8+$new_row_cnt), $result[0]->allocated_cost);
	        	$agreement_area = $result[0]->sp_sellable_area;
	        	$purchase_cost = $result[0]->allocated_cost;
	        }
        }

        if(!is_numeric($agreement_area)){
        	$agreement_area = 1;
        }
        if(!is_numeric($purchase_cost)){
        	$purchase_cost = 0;
        }


        $sql = "select * from sales_txn where property_id='$p_id' and txn_status='Approved'" . $cond;
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
        	$s_id = $result[0]->txn_id;
        	$cost_of_acqisition = $result[0]->cost_of_acquisition;
        	if(!is_numeric($cost_of_acqisition)){
        		$cost_of_acqisition = 0;
        	}

        	$result=$this->get_property_buyers($s_id);
	        if(count($result)>0) {
	        	$buyer_cnt=count($result)*2;
	        	$objPHPExcel->getActiveSheet()->insertNewRowBefore(strval(10+$new_row_cnt), $buyer_cnt);

	        	$row=10+$new_row_cnt;
	        	$sr_no=1;
	        	$cnt=1;
	            for($j=0; $j<count($result); $j++) {
	                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
	                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), 'Buyer Name '.strval($cnt));
	                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->buyer_name);
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFont()->setBold(false);
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFill()->applyFromArray(array(
	                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                    'startcolor' => array(
	                        'rgb' => 'FFFFFF'
	                    )
	                ));
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray(array(
	                    'borders' => array(
	                        'allborders' => array(
	                            'style' => PHPExcel_Style_Border::BORDER_THIN
	                        )
	                    )
	                ));
	                $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                
	                $row=$row+1;
	                $sr_no=$sr_no+1;

	                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
	                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), '% Holding');
	                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->buyer_name);
	                $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), $result[$j]->share_percent);
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFont()->setBold(false);
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getFill()->applyFromArray(array(
	                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                    'startcolor' => array(
	                        'rgb' => 'FFFFFF'
	                    )
	                ));
	                $objPHPExcel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray(array(
	                    'borders' => array(
	                        'allborders' => array(
	                            'style' => PHPExcel_Style_Border::BORDER_THIN
	                        )
	                    )
	                ));
	                $objPHPExcel->getActiveSheet()->getStyle('B'.$row.':C'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	                $objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                
	                $row=$row+1;
	                $sr_no=$sr_no+1;
	                $cnt=$cnt+1;
	            }

	            $new_row_cnt=$new_row_cnt+$buyer_cnt;
	        }

	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1'";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$sale_consideration = $result[0]->tot_net_amount;
	        } else {
	        	$sale_consideration = 0;
	        }

	        if(!is_numeric($sale_consideration)){
	        	$sale_consideration = 0;
	        }

	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(10+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(10+$new_row_cnt), '='.$sale_consideration.'/'.$agreement_area);
	        $sr_no=$sr_no+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.strval(11+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(11+$new_row_cnt), '='.$sale_consideration);
	        $sr_no=$sr_no+1;

	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1' and event_name='Brokerage'";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$brokerage = $result[0]->tot_net_amount;
	        } else {
	        	$brokerage = 0;
	        }
	        if(!is_numeric($brokerage)){
	        	$brokerage = 0;
	        }
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(12+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(12+$new_row_cnt), '='.$brokerage);
	        $sr_no=$sr_no+1;

	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1' and event_name!='Brokerage' and net_amount<0";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$other_expenses = $result[0]->tot_net_amount;
	        } else {
	        	$other_expenses = 0;
	        }
	        if(!is_numeric($other_expenses)){
	        	$other_expenses = 0;
	        }
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(13+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(13+$new_row_cnt), '='.$other_expenses);


	        // $sql = "select A.bro_contactid, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_state, B.c_city, 
        	//         		B.c_country, B.c_pincode, B.c_mobile1, B.c_emailid1 from 
        	// 				(select * from sales_broker_details where sale_id='1') A 
        	// 				left join 
        	// 				(select * from contact_master) B 
        	// 				on (A.bro_contactid = B.c_id)";
          $sql = "select C.*, D.contact_type from 
                  (select A.*, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, 
                      B.c_country, B.c_mobile1, B.c_emailid1, B.c_contact_type from 
                  (select * from related_party_details where type='sale' and ref_id='$s_id') A 
                  left join 
                  (select * from contact_master where c_gid = '$gid') B 
                  on (A.contact_id=B.c_id)) C 
                  left join 
                  (select * from contact_type_master) D 
                  on (C.c_contact_type = D.id) 
                  where D.contact_type = 'Broker'";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(32+$new_row_cnt), $result[0]->c_name . ' ' . $result[0]->c_last_name);
	        	$address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
        		$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(33+$new_row_cnt), $address);
        		$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(34+$new_row_cnt), $result[0]->c_mobile1);
        		$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(35+$new_row_cnt), $result[0]->c_emailid1);
	        }
        }


        $sql = "select A.loan_id, B.* from 
                (select * from loan_property_details where property_id = '$p_id' and 
                  loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                left join 
                (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                on A.loan_id = B.txn_id";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $loan_id=$result[0]->loan_id;
            $bank_name=$result[0]->financial_institution;
            $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
            $loan_emi=0;
            $total_loan=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;
            $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

            $objPHPExcel->getActiveSheet()->setCellValue('C'.strval(15+$new_row_cnt), $bank_name);

            $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
            }

            $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                    where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
            }

            $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $total_loan = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
            } else {
                $loan_outstanding = 0;
            }

            $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

            $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
            } else {
                $tot_paid_amount = 0;
            }

            $loan_outstanding = $loan_outstanding - $tot_paid_amount;

            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(16+$new_row_cnt), '='.$total_loan);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(18+$new_row_cnt), '='.$loan_outstanding);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(19+$new_row_cnt), '='.$loan_interest_rate);
        }


        $capital_gain = $sale_consideration-$cost_of_acqisition;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(21+$new_row_cnt), '='.$sale_consideration);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(22+$new_row_cnt), '='.$cost_of_acqisition);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(23+$new_row_cnt), '='.$capital_gain);

        $sql = "select * from property_projection_details where purchase_id = '$p_id'".$cond." and 
                id = (select max(id) from property_projection_details where purchase_id = '$p_id'".$cond.")";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
        	$capital_gain_tax = $result[0]->tax_applicable;
        } else {
        	$capital_gain_tax = 0;
        }
        if(!is_numeric($capital_gain_tax)){
        	$capital_gain_tax = 0;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(24+$new_row_cnt), '='.$capital_gain_tax);

        $net_profit = $purchase_cost-$capital_gain-$capital_gain_tax;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(25+$new_row_cnt), '='.$net_profit);


        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(27+$new_row_cnt), '='.$sale_consideration);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(28+$new_row_cnt), '='.$loan_outstanding);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(29+$new_row_cnt), '='.$capital_gain_tax);


        $free_cashflow = $sale_consideration-$loan_outstanding-$capital_gain_tax;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(30+$new_row_cnt), '='.$free_cashflow);


        $filename='Asset_Level_Sale_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Sale report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}



function generate_asset_level_profitability_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sr_no = 4;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $data=$this->get_property_details($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Profitability.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Profitability.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', $data[0]->p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('C5', $data[0]->p_property_name);
        $address = get_address($data[0]->p_address, $data[0]->p_landmark, $data[0]->p_city, $data[0]->p_pincode, $data[0]->p_state, $data[0]->p_country);
        $objPHPExcel->getActiveSheet()->setCellValue('C7', $address);

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
        	$owner_cnt=count($result);
        	$objPHPExcel->getActiveSheet()->insertNewRowBefore('8', $owner_cnt);
        	$new_row_cnt=$new_row_cnt+$owner_cnt;

        	$row=8;
        	$sr_no=4;
        	$cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), $sr_no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->owner_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.strval($row), $result[$j]->pr_ownership_percent);
                $row=$row+1;
                $sr_no=$sr_no+1;
                $cnt=$cnt+1;
            }
        }

        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(8+$new_row_cnt), $sr_no);
        $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$p_id' and status='1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
        	$purchase_cost = $result[0]->tot_net_amount;
        	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(8+$new_row_cnt), $result[0]->tot_net_amount);
        }

        $sql = "select * from purchase_property_description where purchase_id='$p_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
        	$agreement_area = $result[0]->pr_agreement_area;
        } else {
        	$agreement_area = 1;
        }

        if($sp_id!=0 and $sp_id!=''){
        	$sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
        	$query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$objPHPExcel->getActiveSheet()->setCellValue('C6', $result[0]->sp_name);
	        	$objPHPExcel->getActiveSheet()->setCellValue('D'.strval(8+$new_row_cnt), $result[0]->allocated_cost);
	        	$agreement_area = $result[0]->sp_sellable_area;
	        	$purchase_cost = $result[0]->allocated_cost;
	        }
        }

        if(!is_numeric($agreement_area)){
        	$agreement_area = 1;
        }
        if(!is_numeric($purchase_cost)){
        	$purchase_cost = 0;
        }


        $sql = "select * from sales_txn where property_id='$p_id' and txn_status='Approved'" . $cond;
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0) {
        	$s_id = $result[0]->txn_id;
        	$cost_of_acqisition = $result[0]->cost_of_acquisition;
        	if(!is_numeric($cost_of_acqisition)){
        		$cost_of_acqisition = 0;
        	}

        	$sr_no=1;
	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1'";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$sale_consideration = $result[0]->tot_net_amount;
	        } else {
	        	$sale_consideration = 0;
	        }

	        if(!is_numeric($sale_consideration)){
	        	$sale_consideration = 0;
	        }

	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(10+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(10+$new_row_cnt), '='.$sale_consideration.'/'.$agreement_area);
	        $sr_no=$sr_no+1;
			$objPHPExcel->getActiveSheet()->setCellValue('A'.strval(11+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(11+$new_row_cnt), '='.$sale_consideration);
	        $sr_no=$sr_no+1;

	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1' and event_name='Brokerage'";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$brokerage = $result[0]->tot_net_amount;
	        } else {
	        	$brokerage = 0;
	        }
	        if(!is_numeric($brokerage)){
	        	$brokerage = 0;
	        }
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(12+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(12+$new_row_cnt), '='.$brokerage);
	        $sr_no=$sr_no+1;

	        $sql = "select sum(net_amount) as tot_net_amount from sales_schedule where sale_id='$s_id' and status='1' and event_name!='Brokerage' and net_amount<0";
	        $query = $this->db->query($sql);
	        $result = $query->result();
	        if(count($result)>0){
	        	$other_expenses = $result[0]->tot_net_amount;
	        } else {
	        	$other_expenses = 0;
	        }
	        if(!is_numeric($other_expenses)){
	        	$other_expenses = 0;
	        }
	        $objPHPExcel->getActiveSheet()->setCellValue('A'.strval(13+$new_row_cnt), $sr_no);
	        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(13+$new_row_cnt), '='.$other_expenses);
        }


        $sql = "select A.loan_id, B.* from 
                (select * from loan_property_details where property_id = '$p_id' and 
                  loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                left join 
                (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                on A.loan_id = B.txn_id";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $loan_id=$result[0]->loan_id;
            $bank_name=$result[0]->financial_institution;
            $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
            $loan_emi=0;
            $total_loan=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;
            $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

            $objPHPExcel->getActiveSheet()->setCellValue('C'.strval(15+$new_row_cnt), $bank_name);

            $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
            }

            $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                    where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
            }

            $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $total_loan = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
                $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
            } else {
                $loan_outstanding = 0;
            }

            $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

            $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
            } else {
                $tot_paid_amount = 0;
            }

            $loan_outstanding = $loan_outstanding - $tot_paid_amount;

            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(16+$new_row_cnt), '='.$total_loan);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(18+$new_row_cnt), '='.$loan_outstanding);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(19+$new_row_cnt), '='.$loan_interest_rate);
        }


        $capital_gain = $sale_consideration-$cost_of_acqisition;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(21+$new_row_cnt), '='.$sale_consideration);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(22+$new_row_cnt), '='.$cost_of_acqisition);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(23+$new_row_cnt), '='.$capital_gain);

        $sql = "select * from property_projection_details where purchase_id = '$p_id'".$cond." and 
                id = (select max(id) from property_projection_details where purchase_id = '$p_id'".$cond.")";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
        	$capital_gain_tax = $result[0]->tax_applicable;
        } else {
        	$capital_gain_tax = 0;
        }
        if(!is_numeric($capital_gain_tax)){
        	$capital_gain_tax = 0;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(24+$new_row_cnt), '='.$capital_gain_tax);

        $net_profit = $purchase_cost-$capital_gain-$capital_gain_tax;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(25+$new_row_cnt), '='.$net_profit);


        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(27+$new_row_cnt), '='.$sale_consideration);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(28+$new_row_cnt), '='.$loan_outstanding);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(29+$new_row_cnt), '='.$capital_gain_tax);


        $free_cashflow = $sale_consideration-$loan_outstanding-$capital_gain_tax;
        $objPHPExcel->getActiveSheet()->setCellValue('D'.strval(30+$new_row_cnt), '='.$free_cashflow);


        $filename='Asset_Level_Profitability_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Profitability report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}



function generate_asset_level_rent_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 1;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $data=$this->get_property_details($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Rent.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Rent.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Asset Name: ' . $data[0]->p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('B6', $data[0]->p_property_name);
        $address = get_address($data[0]->p_address, $data[0]->p_landmark, $data[0]->p_city, $data[0]->p_pincode, $data[0]->p_state, $data[0]->p_country);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', $address);

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
            $owner_cnt=count($result);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore('9', $owner_cnt);
            $new_row_cnt=$new_row_cnt+$owner_cnt;

            $row=9;
            $cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $result[$j]->owner_name);
                $row=$row+1;
                $cnt=$cnt+1;
            }
        }

        if($data[0]->p_type=='Building' || $data[0]->p_type=='Apartment' || $data[0]->p_type=='Bunglow') {
            $p_asset_type = 'Residential';
        } else {
            $p_asset_type = 'Commercial';
        }
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(9+$new_row_cnt), $p_asset_type);

        $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$p_id' and status='1'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $purchase_cost = $result[0]->tot_net_amount;
        }

        $sql = "select * from purchase_property_description where purchase_id='$p_id'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $agreement_area = $result[0]->pr_agreement_area;
            $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
            $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
            $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
            $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
            $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);

            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(11+$new_row_cnt), $carpet_area);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(12+$new_row_cnt), $no_of_parking);
        }

        $pending_activity="";
        $sql = "select * from pending_activity where ref_id = '$p_id' and type='purchase'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            for($j=0; $j<count($result); $j++) {
                $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(77+$new_row_cnt), $pending_activity);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(79+$new_row_cnt), $data[0]->remarks);

        if($sp_id!=0 and $sp_id!=''){
            $sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $objPHPExcel->getActiveSheet()->setCellValue('B7', $result[0]->sp_name);
                $agreement_area = $result[0]->sp_sellable_area;
                $purchase_cost = $result[0]->allocated_cost;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(79+$new_row_cnt), $result[0]->txn_remarks);
            }

            $sql = "select * from pending_activity where ref_id = '$sp_id' and type='allocation'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                for($j=0; $j<count($result); $j++) {
                    $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(77+$new_row_cnt), $pending_activity);
            }
        }

        if(!is_numeric($agreement_area)){
            $agreement_area = 1;
        }
        if(!is_numeric($purchase_cost)){
            $purchase_cost = 0;
        }
        if($agreement_area == 0){
            $agreement_area = 1;
        }
        $agreement_rate=$purchase_cost/$agreement_area;

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(10+$new_row_cnt), $agreement_area);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(14+$new_row_cnt), $agreement_rate);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(15+$new_row_cnt), '='.$purchase_cost);

        $sql = "select event_name, sum(net_amount) as tot_net_amount from 
                (select case when event_name='Registration' then 'Brokerage' else event_name end as event_name, net_amount 
                from purchase_schedule 
                where purchase_id = '$p_id' and status = '1' and 
                event_type = 'Non agreement value') A 
                group by event_name";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $other_charges=0;
            for($j=0; $j<count($result); $j++) {
                $tot_net_amount=is_numeric($result[$j]->tot_net_amount)?$result[$j]->tot_net_amount:0;
                if(strtoupper(trim($result[$j]->event_name))=='VAT ON BASIC') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(16+$new_row_cnt), '='.$tot_net_amount);
                } else if(strtoupper(trim($result[$j]->event_name))=='STAMP DUTY') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(17+$new_row_cnt), '='.$tot_net_amount);
                } else if(strtoupper(trim($result[$j]->event_name))=='BROKERAGE') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(19+$new_row_cnt), '='.$tot_net_amount);
                } else {
                    $other_charges = $other_charges + $tot_net_amount;
                }
            }

            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(20+$new_row_cnt), '='.$other_charges);
        }

        $sql = "select sum(tax_amount) as tot_service_tax from purchase_schedule_taxation where pur_id = '$p_id' and status = '1'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $tot_service_tax=is_numeric($result[0]->tot_service_tax)?$result[0]->tot_service_tax:0;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(18+$new_row_cnt), '='.$tot_service_tax);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(21+$new_row_cnt), '=SUM(B'.strval(15+$new_row_cnt).':B'.strval(20+$new_row_cnt).')');


        $sql = "select * from rent_txn where property_id = '$p_id' and txn_status = 'Approved' " . $cond;
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $deposit_amount=is_numeric($result[0]->deposit_amount)?$result[0]->deposit_amount:0;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(22+$new_row_cnt), '='.$deposit_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(23+$new_row_cnt), '=C'.strval(21+$new_row_cnt).'-C'.strval(22+$new_row_cnt));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(25+$new_row_cnt), $result[0]->lease_period);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(26+$new_row_cnt), date('d-m-Y', strtotime($result[0]->possession_date)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(27+$new_row_cnt), date('d-m-Y', strtotime($result[0]->termination_date)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(28+$new_row_cnt), $result[0]->rent_due_day);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(29+$new_row_cnt), '');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(30+$new_row_cnt), '=IF(((YEAR(B'.strval(27+$new_row_cnt).')-YEAR($B$1))*12)+(MONTH(B'.strval(27+$new_row_cnt).')-MONTH($B$1))<0,"0",((YEAR(B'.strval(27+$new_row_cnt).')-YEAR($B$1))*12)+(MONTH(B'.strval(27+$new_row_cnt).')-MONTH($B$1)))');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(31+$new_row_cnt), '=IF(((YEAR(B'.strval(29+$new_row_cnt).')-YEAR($B$1))*12)+(MONTH(B'.strval(29+$new_row_cnt).')-MONTH($B$1))<0,"0",((YEAR(B'.strval(29+$new_row_cnt).')-YEAR($B$1))*12)+(MONTH(B'.strval(29+$new_row_cnt).')-MONTH($B$1)))');

            $rent_id = $result[0]->txn_id;
            $tenant_id = $result[0]->tenant_id;
            $bl_esc = false;
            $rent_amount=0;

            $maintenance_by = isset($result[0]->maintenance_by)?$result[0]->maintenance_by:'Owner';
            $property_tax_by = isset($result[0]->property_tax_by)?$result[0]->property_tax_by:'Owner';

            $sql = "select max(net_amount) as max_net_amount from rent_schedule where sch_status='2' and 
                    rent_id='$rent_id' and create_date = (select max(create_date) as max_create_date 
                        from rent_schedule where sch_status='2' and rent_id='$rent_id') ";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $bl_esc = true;
                $rent_amount=isset($result[0]->max_net_amount)?$result[0]->max_net_amount:0;
                if(is_numeric($rent_amount)) {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(33+$new_row_cnt), '='.$rent_amount.'/'.$agreement_area);
                }
            }

            $sql = "select create_date, max(net_amount) as max_net_amount from rent_schedule 
                    where sch_status='1' and rent_id='$rent_id' and create_date = 
                    (select max(create_date) as max_create_date from rent_schedule 
                        where sch_status='1' and rent_id='$rent_id') group by create_date";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $esc_rent_amount=isset($result[0]->max_net_amount)?$result[0]->max_net_amount:0;
                if(is_numeric($esc_rent_amount)) {
                    if($bl_esc == true) {
                        if($esc_rent_amount==$rent_amount) {
                            $bl_esc = false;
                        }
                    }

                    if($bl_esc == false){
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(33+$new_row_cnt), '='.$rent_amount.'/'.$agreement_area);
                    } else {
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(47+$new_row_cnt), date('d-m-Y', strtotime($result[0]->create_date)));
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(48+$new_row_cnt), '=if(B'.strval(33+$new_row_cnt).'=0,0,(B'.strval(49+$new_row_cnt).'-B'.strval(33+$new_row_cnt).')/B'.strval(33+$new_row_cnt).')');
                        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(49+$new_row_cnt), '='.$esc_rent_amount.'/'.$agreement_area);
                    }
                }
            }

            $sql = "select * from maintenance_txn where property_id = '$p_id' and txn_status = 'Approved' " . $cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $m_id=isset($result[0]->txn_id)?$result[0]->txn_id:0;

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and (particular = 'CAMP (Rs. PSF)' or particular = 'Maintenance')";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=is_numeric($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(41+$new_row_cnt), '=('.$cost.'*12)');
                }

                $sql = "select case when frequency='yearly' then cost/12 when frequency='quarterly' then cost/3 else cost end as cost 
                        from maintenance_cost_details where m_id = '$m_id' and particular = 'Property Tax'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $cost=is_numeric($result[0]->cost)?$result[0]->cost:0;
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(43+$new_row_cnt), '=('.$cost.'*12)');
                }

                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(34+$new_row_cnt), '=(B'.strval(41+$new_row_cnt).')/('.$agreement_area.'*12)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(35+$new_row_cnt), $maintenance_by);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(36+$new_row_cnt), '=(B'.strval(43+$new_row_cnt).')/('.$agreement_area.'*12)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(37+$new_row_cnt), $property_tax_by);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(38+$new_row_cnt), '=B'.strval(33+$new_row_cnt).'-IF(B'.strval(35+$new_row_cnt).'="Owner",B'.strval(36+$new_row_cnt).',0)-IF(B'.strval(37+$new_row_cnt).'="Owner",B'.strval(34+$new_row_cnt).',0)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(39+$new_row_cnt), '=(B'.strval(38+$new_row_cnt).'*'.$agreement_area.')');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(40+$new_row_cnt), '=((B'.strval(33+$new_row_cnt).'*'.$agreement_area.')*12)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(45+$new_row_cnt), '=B'.strval(40+$new_row_cnt).'-IF(B'.strval(42+$new_row_cnt).'="Owner",B'.strval(43+$new_row_cnt).',0)-IF(B'.strval(44+$new_row_cnt).'="Owner",B'.strval(41+$new_row_cnt).',0)');
            }

            if($bl_esc == true){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(50+$new_row_cnt), '=(B'.strval(58+$new_row_cnt).')/('.$agreement_area.'*12)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(51+$new_row_cnt), $maintenance_by);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(52+$new_row_cnt), '=(B'.strval(59+$new_row_cnt).')/('.$agreement_area.'*12)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(53+$new_row_cnt), $property_tax_by);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(54+$new_row_cnt), '=(B'.strval(33+$new_row_cnt).'*(1+B'.strval(48+$new_row_cnt).'))-IF(B'.strval(51+$new_row_cnt).'="Owner",B'.strval(50+$new_row_cnt).',0)-IF(B'.strval(53+$new_row_cnt).'="Owner",B'.strval(52+$new_row_cnt).',0)');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(55+$new_row_cnt), '=(B'.strval(54+$new_row_cnt).'*'.$agreement_area.')');
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(57+$new_row_cnt), '=((B'.strval(49+$new_row_cnt).'*'.$agreement_area.')*12)');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(58+$new_row_cnt), '=B'.strval(41+$new_row_cnt));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(59+$new_row_cnt), '=B'.strval(43+$new_row_cnt));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(60+$new_row_cnt), '=((B'.strval(54+$new_row_cnt).'*'.$agreement_area.')*12)');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(62+$new_row_cnt), '=if(B'.strval(21+$new_row_cnt).'=0,0,B'.strval(45+$new_row_cnt).'/B'.strval(21+$new_row_cnt).')');
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(63+$new_row_cnt), '=if(B'.strval(23+$new_row_cnt).'=0,0,B'.strval(45+$new_row_cnt).'/B'.strval(23+$new_row_cnt).')');

            $sql = "select * from rent_schedule where sch_status='1' and rent_id='$rent_id' and date_format(event_date,'%Y%m') = date_format(curdate(),'%Y%m')";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $event_type = $result[0]->event_type;
                $event_name = $result[0]->event_name;
                $event_date = $result[0]->event_date;
                $net_amount = is_numeric($result[0]->net_amount)?$result[0]->net_amount:0;

                $sql = "select sum(paid_amount) as tot_paid_amount from actual_schedule where table_type = 'rent' and 
                        fk_txn_id = '$rent_id' and event_type = '$event_type' and event_name = '$event_name' and 
                        event_date = '$event_date' and txn_status = 'Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0) {
                    $tot_paid_amount = is_numeric($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                } else {
                    $tot_paid_amount = 0;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(65+$new_row_cnt), '='.strval($net_amount-$tot_paid_amount));
            }

            $sql = "select count(*) as tot_months from 
                    (select sch_id, net_amount-tot_paid_amount as bal_amount from 
                    (select sch_id, case when A.net_amount is null then 0 else A.net_amount end as net_amount, 
                        case when B.tot_paid_amount is null then 0 else B.tot_paid_amount end as tot_paid_amount from 
                    (select * from rent_schedule where sch_status='1' and rent_id='$rent_id') A 
                    left join 
                    (select event_type, event_name, event_date, sum(paid_amount) as tot_paid_amount 
                        from actual_schedule where table_type = 'rent' and fk_txn_id = '$rent_id' and 
                        txn_status = 'Approved' group by event_type, event_name, event_date) B 
                    on (A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                    where bal_amount!=0";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(66+$new_row_cnt), $result[0]->tot_months);
            }

            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(67+$new_row_cnt), '=B'.strval(66+$new_row_cnt).'*B'.strval(65+$new_row_cnt));

            $sql = "select sum(tax_amount) as tot_tds from actual_schedule_taxes 
                    where id in (select id from (select tax_applied, max(id) as id from actual_schedule_taxes 
                    where table_type = 'rent' and fk_txn_id = '$rent_id' and status = '1' group by tax_applied) A)";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $tot_tds=isset($result[0]->tot_tds)?$result[0]->tot_tds:0;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(69+$new_row_cnt), '='.$tot_tds);
            }

            $c_id=$tenant_id;

            // $c_id=explode("_", $tenant_id);
            // if(count($c_id)==2){
            //     $tenant_id = $c_id[1];
            //     if ($c_id[0]=="o"){
            //         $sql = "select * from 
            //                 (select A.ow_id, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country, B.c_mobile1, B.c_emailid1, B.kyc_doc_ref from 
            //                 (select * from owner_master where ow_type = '0' and ow_status='Approved' and ow_gid='$gid') A 
            //                 left join 
            //                 (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
            //                 (select * from contact_master where c_status='Approved') A 
            //                 left join 
            //                 (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
            //                 on (A.c_id = B.kyc_cid)) B 
            //                 on (A.ow_ind_id=B.c_id) 
            //                 union all 
            //                 select ow_id, ow_huf_name as c_name, '' as c_last_name, ow_huf_address as c_address, ow_huf_landmark as c_landmark, ow_huf_city as c_city, ow_huf_pincode as c_pincode, ow_huf_state as c_state, ow_huf_country as c_country, '' as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '1' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_pvtltd_comapny_name as c_name, '' as c_last_name, ow_pvtltd_address as c_address, ow_pvtltd_landmark as c_landmark, ow_pvtltd_city as c_city, ow_pvtltd_pincode as c_pincode, ow_pvtltd_state as c_state, ow_pvtltd_country as c_country, ow_pvtltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '2' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_ltd_comapny_name as c_name, '' as c_last_name, ow_ltd_address as c_address, ow_ltd_landmark as c_landmark, ow_ltd_city as c_city, ow_ltd_pincode as c_pincode, ow_ltd_state as c_state, ow_ltd_country as c_country, ow_ltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '3' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_llp_comapny_name as c_name, '' as c_last_name, ow_llp_address as c_address, ow_llp_landmark as c_landmark, ow_llp_city as c_city, ow_llp_pincode as c_pincode, ow_llp_state as c_state, ow_llp_country as c_country, ow_llp_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '4' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_prt_comapny_name as c_name, '' as c_last_name, ow_prt_address as c_address, ow_prt_landmark as c_landmark, ow_prt_city as c_city, ow_prt_pincode as c_pincode, ow_prt_state as c_state, ow_prt_country as c_country, ow_prt_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '5' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_aop_comapny_name as c_name, '' as c_last_name, ow_aop_address as c_address, ow_aop_landmark as c_landmark, ow_aop_city as c_city, ow_aop_pincode as c_pincode, ow_aop_state as c_state, ow_aop_country as c_country, ow_aop_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '6' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_trs_comapny_name as c_name, '' as c_last_name, ow_trs_address as c_address, ow_trs_landmark as c_landmark, ow_trs_city as c_city, ow_trs_pincode as c_pincode, ow_trs_state as c_state, ow_trs_country as c_country, ow_trs_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '7' and ow_status='Approved' and ow_gid='$gid' 
            //                 union all 
            //                 select ow_id, ow_proprietorship_comapny_name as c_name, '' as c_last_name, ow_proprietorship_address as c_address, ow_proprietorship_landmark as c_landmark, ow_proprietorship_city as c_city, ow_proprietorship_pincode as c_pincode, ow_proprietorship_state as c_state, ow_proprietorship_country as c_country, ow_proprietorship_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '8' and ow_status='Approved' and ow_gid='$gid') C 
            //                 where ow_id = '$tenant_id'";
            //     } else {
            //         $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
            //                 (select * from contact_master where c_id='$tenant_id') A 
            //                 left join 
            //                 (select * from contact_kyc_details where kyc_cid='$tenant_id' and kyc_doc_name='PAN Card') B 
            //                 on (A.c_id = B.kyc_cid)";
            //     }
            // } else {
            //     $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
            //             (select * from contact_master where c_id='$tenant_id') A 
            //             left join 
            //             (select * from contact_kyc_details where kyc_cid='$tenant_id' and kyc_doc_name='PAN Card') B 
            //             on (A.c_id = B.kyc_cid)";
            // }


            $sql = "select A.*, B.doc_ref_no as kyc_doc_ref from 
                    (select A.c_id, A.c_address, A.c_landmark, A.c_city, A.c_pincode, A.c_state, A.c_country,
                        case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                        case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$tenant_id') A 
                    left join 
                    (select * from document_details where doc_ref_id = '$tenant_id' and doc_ref_type = 'Contacts' and doc_doc_id = '1') B 
                    on (A.c_id = B.doc_ref_id)";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(71+$new_row_cnt), $result[0]->c_name . ' ' . $result[0]->c_last_name);
                $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(72+$new_row_cnt), $address);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(73+$new_row_cnt), $result[0]->c_mobile1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(74+$new_row_cnt), $result[0]->c_emailid1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(75+$new_row_cnt), $result[0]->kyc_doc_ref);
            }
        }

        $filename='Asset_Level_Rent_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Rent report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
}


function generate_asset_level_sale_variance_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sr_no = 1;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $sql = "select * from sales_txn where property_id='$p_id' and txn_status='Approved'" . $cond;
    $query = $this->db->query($sql);
    $data = $query->result();

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Sale_Variance.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Sale_Variance.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $s_id = $data[0]->txn_id;

        $result=$this->get_property_details($p_id);
        if(count($result)>0) {
            $objPHPExcel->getActiveSheet()->setCellValue('C3', $result[0]->p_property_name);
        }

        if($sp_id!=0 and $sp_id!=''){
            $sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $objPHPExcel->getActiveSheet()->setCellValue('C4', $result[0]->sp_name);
            }
        }

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
            $owner_cnt=count($result);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore('5', $owner_cnt);
            $new_row_cnt=$new_row_cnt+$owner_cnt;

            $row=5;
            $cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('C'.strval($row), $result[$j]->owner_name);
                $row=$row+1;
                $cnt=$cnt+1;
            }
        }

        $sql = "select distinct tax_id from 
                (select distinct tax_master_id as tax_id from sales_schedule_taxation where sale_id = '$s_id' 
                union all 
                select distinct tax_applied as tax_id from actual_schedule_taxes where fk_txn_id = '$s_id' and table_type = 'sale') A";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $tax_cnt = count($result);
        } else {
            $tax_cnt = 0;
        }
        $tot_col = 29 + $tax_cnt + 50;
        for($i=0; $i<=$tot_col; $i++) {
            $col_name[$i]=PHPExcel_Cell::stringFromColumnIndex($i);
        }


        $sql = "select min(create_date) as initial_date from sales_schedule where sale_id = '$s_id' and status in('1', '2')";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $initial_date = $result[0]->initial_date;
        } else {
            $initial_date = date('Y-m-d');
        }

        $sql = "select A.tax_master_id, B.tax_name from 
                (select distinct tax_master_id from sales_schedule_taxation where sale_id = '$s_id' and status in('1', '2') and 
                sch_id in (select distinct sch_id from sales_schedule where sale_id = '$s_id' and create_date = '$initial_date') and status in('1', '2')) A 
                left join 
                (select * from tax_master) B 
                on A.tax_master_id = B.tax_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $initial_tax_cnt = count($result)*2;
            $col = 7;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $initial_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }
        } else {
            $initial_tax_cnt = 0;
        }

        $sql = "select A.tax_master_id, B.tax_name from 
                (select distinct tax_master_id from sales_schedule_taxation where sale_id = '$s_id' and status = '1' and 
                sch_id in (select distinct sch_id from sales_schedule where sale_id = '$s_id' and status = '1')) A 
                left join 
                (select * from tax_master) B 
                on A.tax_master_id = B.tax_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $latest_tax_cnt = count($result)*2;
            $col = 15+$initial_tax_cnt;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $latest_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }

            $actual_tax_cnt = count($result)*2;
            $col = 23+$initial_tax_cnt+$latest_tax_cnt;
            $objPHPExcel->getActiveSheet()->insertNewColumnBefore($col_name[$col], $actual_tax_cnt);
            for($i=0; $i<count($result); $i++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(5+$new_row_cnt), $result[$i]->tax_master_id);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (%)');
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval(6+$new_row_cnt), $result[$i]->tax_name . ' (Amount)');
                $col = $col+2;
            }
        } else {
            $latest_tax_cnt = 0;
            $actual_tax_cnt = 0;
        }

        $initial_col = $initial_tax_cnt;
        $latest_col = $initial_tax_cnt + $latest_tax_cnt;
        $actual_col = $initial_tax_cnt + $latest_tax_cnt + $actual_tax_cnt;
        $row = 7;

        $sql = "select E.event_type, E.event_name, E.initial_sch_id, E.initial_event_date, E.initial_net_amount, E.latest_sch_id, E.latest_event_date, E.latest_net_amount, F.actual_event_date, F.actual_paid_amount from 
                (select C.event_type, C.event_name, C.initial_sch_id, C.initial_event_date, C.initial_net_amount, D.sch_id as latest_sch_id, D.event_date as latest_event_date, D.net_amount as latest_net_amount from 
                (select A.event_type, A.event_name, B.sch_id as initial_sch_id, B.event_date as initial_event_date, B.net_amount as initial_net_amount from 
                (select distinct event_type, event_name from 
                (select event_type, event_name, event_date from sales_schedule where sale_id = '$s_id' and create_date = '$initial_date' and status in('1', '2') 
                union all 
                select event_type, event_name, event_date from sales_schedule where sale_id = '$s_id' and status = '1'
                union all 
                select event_type, event_name, event_date from actual_schedule where fk_txn_id = '$s_id' and txn_status = 'Approved' and table_type = 'sales') A 
                order by event_type) A 
                left join 
                (select sch_id, event_type, event_name, event_date, net_amount from sales_schedule 
                    where sale_id = '$s_id'and create_date = '$initial_date' and status in('1', '2')) B 
                on (A.event_type=B.event_type and A.event_name=B.event_name)) C 
                left join 
                (select sch_id, event_type, event_name, event_date, net_amount from sales_schedule where sale_id = '$s_id'and status = '1') D 
                on (C.event_type=D.event_type and C.event_name=D.event_name)) E 
                left join 
                (select event_type, event_name, max(event_date) as actual_event_date, sum(paid_amount) as actual_paid_amount from actual_schedule 
                    where fk_txn_id = '$s_id' and txn_status = 'Approved' and table_type = 'sales' 
                    group by event_type, event_name) F 
                on (E.event_type=F.event_type and E.event_name=F.event_name)";
        $query = $this->db->query($sql);
        $data = $query->result();
        if(count($data)>0){
            $sql = "select * from tax_master where tax_name = 'tds'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $tds_percent = is_numeric($result[0]->tax_percent)?$result[0]->tax_percent:0;
            } else {
                $tds_percent = 0;
            }

            for($i=0; $i<count($data); $i++){
                $event_type = $data[$i]->event_type;
                $event_name = $data[$i]->event_name;
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[0].strval($row+$new_row_cnt), $sr_no);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[1].strval($row+$new_row_cnt), $data[$i]->event_type);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[2].strval($row+$new_row_cnt), $data[$i]->event_name);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[3].strval($row+$new_row_cnt), '');

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[5].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->initial_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[6].strval($row+$new_row_cnt), $data[$i]->initial_net_amount);

                $sch_id = $data[$i]->initial_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from sales_schedule_taxation where sale_id='$s_id' and sch_id='$sch_id' and status in('1', '2')";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=7;
                        for($k=0;$k<($initial_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$initial_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$initial_col].strval($row+$new_row_cnt), '='.$col_name[6].strval($row+$new_row_cnt).'+'.$col_name[7+$initial_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[9+$initial_col].strval($row+$new_row_cnt), $tds_percent);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$initial_col].strval($row+$new_row_cnt), '='.$col_name[8+$initial_col].strval($row+$new_row_cnt).'*'.$col_name[9+$initial_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$initial_col].strval($row+$new_row_cnt), '='.$col_name[8+$initial_col].strval($row+$new_row_cnt).'-'.$col_name[10+$initial_col].strval($row+$new_row_cnt));



                $objPHPExcel->getActiveSheet()->setCellValue($col_name[13+$initial_col].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->latest_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$initial_col].strval($row+$new_row_cnt), $data[$i]->latest_net_amount);

                $sch_id = $data[$i]->latest_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from sales_schedule_taxation where sale_id='$s_id' and sch_id='$sch_id' and status = '1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=15+$initial_col;
                        for($k=0;$k<($latest_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$latest_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$latest_col].strval($row+$new_row_cnt), '='.$col_name[14+$initial_col].strval($row+$new_row_cnt).'+'.$col_name[15+$latest_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[17+$latest_col].strval($row+$new_row_cnt), $tds_percent);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$latest_col].strval($row+$new_row_cnt), '='.$col_name[16+$latest_col].strval($row+$new_row_cnt).'*'.$col_name[17+$latest_col].strval($row+$new_row_cnt));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$latest_col].strval($row+$new_row_cnt), '='.$col_name[16+$latest_col].strval($row+$new_row_cnt).'-'.$col_name[18+$latest_col].strval($row+$new_row_cnt));



                $objPHPExcel->getActiveSheet()->setCellValue($col_name[21+$latest_col].strval($row+$new_row_cnt), date('d-m-Y', strtotime($data[$i]->actual_event_date)));
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$latest_col].strval($row+$new_row_cnt), $data[$i]->actual_paid_amount);

                $sch_id = $data[$i]->latest_sch_id;
                $total_tax_amount = 0;
                $sql = "select * from sales_schedule_taxation where sale_id='$s_id' and sch_id='$sch_id' and status = '1'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $col=23+$latest_col;
                        for($k=0;$k<($latest_tax_cnt/2);$k++){
                            $tax_id = $objPHPExcel->getActiveSheet()->getCell($col_name[$col].strval(5+$new_row_cnt))->getValue();
                            if($tax_id==$result[$j]->tax_master_id){
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col].strval($row+$new_row_cnt), $result[$j]->tax_percent);
                                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), $result[$j]->tax_amount);
                                $tax_amount = is_numeric($result[$j]->tax_amount)?$result[$j]->tax_amount:0;
                                $total_tax_amount = $total_tax_amount + $tax_amount;
                            }
                            $col=$col+2;
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$actual_col].strval($row+$new_row_cnt), $total_tax_amount);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$actual_col].strval($row+$new_row_cnt), '='.$col_name[22+$latest_col].strval($row+$new_row_cnt).'+'.$col_name[23+$actual_col].strval($row+$new_row_cnt));

                $total_tds = 0;
                $total_tds_per = 0;
                $sql = "select * from actual_schedule where table_type='sales' and fk_txn_id='$s_id' and event_type='$event_type' and event_name='$event_name' and txn_status = 'Approved'";
                $query = $this->db->query($sql);
                $result = $query->result();
                if(count($result)>0){
                    for($j=0;$j<count($result);$j++){
                        $net_amount = is_numeric($result[$j]->net_amount)?$result[$j]->net_amount:0;
                        $tax_applied = $result[$j]->tax_applied;

                        $tax_id = explode(',', $tax_applied);
                        for($k=0; $k<count($tax_id); $k++){
                            // $tds_code = $tax_id[$k];
                            $tds_code = explode('_', $tax_id[$k]);
                            if(count($tds_code)>0){
                                if (isset($tds_code[1])) {
                                    $tds_per = is_numeric($tds_code[1])?$tds_code[1]:0;
                                    $total_tds_per = $total_tds_per + $tds_per;
                                    $total_tds = $total_tds + (($net_amount * $tds_per)/100);
                                }
                            }
                        }
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue($col_name[25+$actual_col].strval($row+$new_row_cnt), $total_tds_per);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$actual_col].strval($row+$new_row_cnt), $total_tds);
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$actual_col].strval($row+$new_row_cnt), '='.$col_name[24+$actual_col].strval($row+$new_row_cnt).'-'.$col_name[26+$actual_col].strval($row+$new_row_cnt));


                $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$actual_col].strval($row+$new_row_cnt), '=IF('.$col_name[27+$actual_col].strval($row+$new_row_cnt).'>0,IF('.$col_name[19+$latest_col].strval($row+$new_row_cnt).'>0,'.$col_name[19+$latest_col].strval($row+$new_row_cnt).'-'.$col_name[27+$actual_col].strval($row+$new_row_cnt).','.$col_name[11+$initial_col].strval($row+$new_row_cnt).'-'.$col_name[27+$actual_col].strval($row+$new_row_cnt).'),0)');

                $row = $row + 1;
                $sr_no = $sr_no + 1;
            }

            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row+$new_row_cnt, 1);
            $row = $row + 1;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row+$new_row_cnt), $sr_no);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row+$new_row_cnt), 'Net Receivables');
            $objPHPExcel->getActiveSheet()->setCellValue('G'.strval($row+$new_row_cnt), '=sum(G'.strval(7+$new_row_cnt).':G'.strval($row+$new_row_cnt-1).')');
            $col=7;
            for($k=0;$k<($initial_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[7+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[7+$initial_col].strval(7+$new_row_cnt).':'.$col_name[7+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[8+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[8+$initial_col].strval(7+$new_row_cnt).':'.$col_name[8+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[10+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[10+$initial_col].strval(7+$new_row_cnt).':'.$col_name[10+$initial_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[11+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[11+$initial_col].strval(7+$new_row_cnt).':'.$col_name[11+$initial_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[14+$initial_col].strval($row+$new_row_cnt), '=sum('.$col_name[14+$initial_col].strval(7+$new_row_cnt).':'.$col_name[14+$initial_col].strval($row+$new_row_cnt-1).')');
            $col=15+$initial_col;
            for($k=0;$k<($latest_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[15+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[15+$latest_col].strval(7+$new_row_cnt).':'.$col_name[15+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[16+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[16+$latest_col].strval(7+$new_row_cnt).':'.$col_name[16+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[18+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[18+$latest_col].strval(7+$new_row_cnt).':'.$col_name[18+$latest_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[19+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[19+$latest_col].strval(7+$new_row_cnt).':'.$col_name[19+$latest_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->setCellValue($col_name[22+$latest_col].strval($row+$new_row_cnt), '=sum('.$col_name[22+$initial_col].strval(7+$new_row_cnt).':'.$col_name[22+$initial_col].strval($row+$new_row_cnt-1).')');
            $col=23+$latest_col;
            for($k=0;$k<($actual_tax_cnt/2);$k++){
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$col+1].strval($row+$new_row_cnt), '=sum('.$col_name[$col+1].strval(7+$new_row_cnt).':'.$col_name[$col+1].strval($row+$new_row_cnt-1).')');
                $col=$col+2;
            }
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[23+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[23+$actual_col].strval(7+$new_row_cnt).':'.$col_name[23+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[24+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[24+$actual_col].strval(7+$new_row_cnt).':'.$col_name[24+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[26+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[26+$actual_col].strval(7+$new_row_cnt).':'.$col_name[26+$actual_col].strval($row+$new_row_cnt-1).')');
            $objPHPExcel->getActiveSheet()->setCellValue($col_name[27+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[27+$actual_col].strval(7+$new_row_cnt).':'.$col_name[27+$actual_col].strval($row+$new_row_cnt-1).')');


            $objPHPExcel->getActiveSheet()->setCellValue($col_name[29+$actual_col].strval($row+$new_row_cnt), '=sum('.$col_name[29+$actual_col].strval(7+$new_row_cnt).':'.$col_name[29+$actual_col].strval($row+$new_row_cnt-1).')');

            $objPHPExcel->getActiveSheet()->getStyle($col_name[4].strval(6+$new_row_cnt).':'.$col_name[4].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[12+$initial_col].strval(6+$new_row_cnt).':'.$col_name[12+$initial_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[20+$latest_col].strval(6+$new_row_cnt).':'.$col_name[20+$latest_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle($col_name[28+$actual_col].strval(6+$new_row_cnt).':'.$col_name[28+$actual_col].strval($row+$new_row_cnt))->getFill()->applyFromArray(array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => '000000'
                )
            ));
            $objPHPExcel->getActiveSheet()->getStyle('A'.strval(6+$new_row_cnt).':'.$col_name[29+$actual_col].strval($row+$new_row_cnt))->applyFromArray(array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                    )
                )
            ));

            for($k=0;$k<=29+$actual_col;$k++) {
                $objPHPExcel->getActiveSheet()->setCellValue($col_name[$k].strval(5+$new_row_cnt), '');
            }
        }

        

        $filename='Asset_Level_Sale_Variance_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Sale Variance report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}



function generate_asset_level_purchase_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $data=$this->get_property_details($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Purchase.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Purchase.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', $data[0]->p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', $data[0]->p_property_name);
        $address = get_address($data[0]->p_address, $data[0]->p_landmark, $data[0]->p_city, $data[0]->p_pincode, $data[0]->p_state, $data[0]->p_country);
        $objPHPExcel->getActiveSheet()->setCellValue('B7', $address);

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
            $owner_cnt=count($result);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore('8', $owner_cnt*2);
            $new_row_cnt=$new_row_cnt+($owner_cnt*2);

            $row=8;
            $cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $result[$j]->owner_name);
                $row=$row+1;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), '% Holding');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $result[$j]->pr_ownership_percent);
                $row=$row+1;
                $cnt=$cnt+1;
            }
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(8+$new_row_cnt), $data[0]->p_status);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(9+$new_row_cnt), $data[0]->p_type);

        $sql = "select * from purchase_property_description where purchase_id='$p_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
            $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
            $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
            $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
            $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);

            
        } else {
            $no_of_parking = 0;
            $agreement_area = 1;
            $carpet_area = 0;
            $builtup_area = 0;
            $sellable_area = 0;
        }

        $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$p_id' and status='1' and event_type = 'Agreement Value'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $agreement_value = floatval($result[0]->tot_net_amount);
        }

        if($sp_id!=0 and $sp_id!=''){
            $sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $objPHPExcel->getActiveSheet()->setCellValue('B6', $result[0]->sp_name);

                $agreement_area = convert_to_feet($result[0]->sp_sellable_area, $result[0]->sp_sellable_area_unit);
                $carpet_area = convert_to_feet($result[0]->sp_carpet_area, $result[0]->sp_carpet_area_unit);
                $builtup_area = convert_to_feet($result[0]->sp_builtup_area, $result[0]->sp_builtup_area_unit);
                $sellable_area = convert_to_feet($result[0]->sp_sellable_area, $result[0]->sp_sellable_area_unit);

                $agreement_value = floatval($result[0]->allocated_cost);
            }
        }

        if(!is_numeric($agreement_area)){
            $agreement_area = 1;
        }
        if(!is_numeric($agreement_value)){
            $agreement_value = 0;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(10+$new_row_cnt), $no_of_parking);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(23+$new_row_cnt), $agreement_area);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(24+$new_row_cnt), $carpet_area);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(25+$new_row_cnt), $builtup_area);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(26+$new_row_cnt), $sellable_area);

        $p_builder_name = $data[0]->p_builder_name;
        $c_id = $p_builder_name;

        // $c_id=explode("_", $p_builder_name);
        // if(count($c_id)==2){
        //     $p_builder_name = $c_id[1];
        //     if ($c_id[0]=="o"){
        //         $sql = "select * from 
        //                 (select A.ow_id, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, B.c_country, B.c_mobile1, B.c_emailid1, B.kyc_doc_ref from 
        //                 (select * from owner_master where ow_type = '0' and ow_status='Approved' and ow_gid='$gid') A 
        //                 left join 
        //                 (select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
        //                 (select * from contact_master where c_status='Approved') A 
        //                 left join 
        //                 (select * from contact_kyc_details where kyc_doc_name='PAN Card') B 
        //                 on (A.c_id = B.kyc_cid)) B 
        //                 on (A.ow_ind_id=B.c_id) 
        //                 union all 
        //                 select ow_id, ow_huf_name as c_name, '' as c_last_name, ow_huf_address as c_address, ow_huf_landmark as c_landmark, ow_huf_city as c_city, ow_huf_pincode as c_pincode, ow_huf_state as c_state, ow_huf_country as c_country, '' as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '1' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_pvtltd_comapny_name as c_name, '' as c_last_name, ow_pvtltd_address as c_address, ow_pvtltd_landmark as c_landmark, ow_pvtltd_city as c_city, ow_pvtltd_pincode as c_pincode, ow_pvtltd_state as c_state, ow_pvtltd_country as c_country, ow_pvtltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '2' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_ltd_comapny_name as c_name, '' as c_last_name, ow_ltd_address as c_address, ow_ltd_landmark as c_landmark, ow_ltd_city as c_city, ow_ltd_pincode as c_pincode, ow_ltd_state as c_state, ow_ltd_country as c_country, ow_ltd_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '3' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_llp_comapny_name as c_name, '' as c_last_name, ow_llp_address as c_address, ow_llp_landmark as c_landmark, ow_llp_city as c_city, ow_llp_pincode as c_pincode, ow_llp_state as c_state, ow_llp_country as c_country, ow_llp_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '4' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_prt_comapny_name as c_name, '' as c_last_name, ow_prt_address as c_address, ow_prt_landmark as c_landmark, ow_prt_city as c_city, ow_prt_pincode as c_pincode, ow_prt_state as c_state, ow_prt_country as c_country, ow_prt_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '5' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_aop_comapny_name as c_name, '' as c_last_name, ow_aop_address as c_address, ow_aop_landmark as c_landmark, ow_aop_city as c_city, ow_aop_pincode as c_pincode, ow_aop_state as c_state, ow_aop_country as c_country, ow_aop_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '6' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_trs_comapny_name as c_name, '' as c_last_name, ow_trs_address as c_address, ow_trs_landmark as c_landmark, ow_trs_city as c_city, ow_trs_pincode as c_pincode, ow_trs_state as c_state, ow_trs_country as c_country, ow_trs_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '7' and ow_status='Approved' and ow_gid='$gid' 
        //                 union all 
        //                 select ow_id, ow_proprietorship_comapny_name as c_name, '' as c_last_name, ow_proprietorship_address as c_address, ow_proprietorship_landmark as c_landmark, ow_proprietorship_city as c_city, ow_proprietorship_pincode as c_pincode, ow_proprietorship_state as c_state, ow_proprietorship_country as c_country, ow_proprietorship_mob as c_mobile1, '' as c_emailid1, '' as kyc_doc_ref from owner_master where ow_type = '8' and ow_status='Approved' and ow_gid='$gid') C 
        //                 where ow_id = '$p_builder_name'";
        //     } else {
        //         $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
        //                 (select * from contact_master where c_id='$p_builder_name') A 
        //                 left join 
        //                 (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
        //                 on (A.c_id = B.kyc_cid)";
        //     }
        // } else {
        //     $sql = "select A.*, case when A.c_type='Others' then A.c_pan_card else B.kyc_doc_ref end as kyc_doc_ref from 
        //             (select * from contact_master where c_id='$p_builder_name') A 
        //             left join 
        //             (select * from contact_kyc_details where kyc_cid='$p_builder_name' and kyc_doc_name='PAN Card') B 
        //             on (A.c_id = B.kyc_cid)";
        // }

        $sql = "select A.*, B.doc_ref_no as kyc_doc_ref from 
                (select A.c_id, A.c_address, A.c_landmark, A.c_city, A.c_pincode, A.c_state, A.c_country,
                    case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$p_builder_name') A 
                left join 
                (select * from document_details where doc_ref_id = '$p_builder_name' and doc_ref_type = 'Contacts' and doc_doc_id = '1') B 
                on (A.c_id = B.doc_ref_id)";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(12+$new_row_cnt), $result[0]->c_name . ' ' . $result[0]->c_last_name);
            $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(13+$new_row_cnt), $address);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(14+$new_row_cnt), $result[0]->c_mobile1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(15+$new_row_cnt), $result[0]->c_emailid1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(16+$new_row_cnt), $result[0]->kyc_doc_ref);
        }

        // $sql = "select A.*, B.* from 
        //         (select bro_contactid from purchase_brokerage_details where purchase_id = '$p_id') A 
        //         left join 
        //         (select * from contact_master where c_gid = '$gid') B 
        //         on (A.bro_contactid = B.c_id)";
        $sql = "select C.*, D.contact_type from 
                (select A.*, B.c_name, B.c_last_name, B.c_address, B.c_landmark, B.c_city, B.c_pincode, B.c_state, 
                    B.c_country, B.c_mobile1, B.c_emailid1, B.c_contact_type from 
                (select * from related_party_details where type='purchase' and ref_id='$p_id') A 
                left join 
                (select * from contact_master where c_gid = '$gid') B 
                on (A.contact_id=B.c_id)) C 
                left join 
                (select * from contact_type_master) D 
                on (C.c_contact_type = D.id) 
                where D.contact_type = 'Broker'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(18+$new_row_cnt), $result[0]->c_name . ' ' . $result[0]->c_last_name);
            $address = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, $result[0]->c_state, $result[0]->c_country);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(19+$new_row_cnt), $address);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(20+$new_row_cnt), $result[0]->c_mobile1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(21+$new_row_cnt), $result[0]->c_emailid1);
        }

        $agreement_rate = $agreement_value/$agreement_area;
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(28+$new_row_cnt), $agreement_rate);

        $sql = "select * from property_projection_details where purchase_id = '$p_id'".$cond." and 
                id = (select max(id) from property_projection_details where purchase_id = '$p_id'".$cond.")";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(29+$new_row_cnt), $result[0]->market_rate);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(30+$new_row_cnt), $result[0]->req_rate_return);

            $current_index = $this->getindex(date('Y-m-d'));
            $purchase_index = $this->getindex($data[$i]->p_purchase_date);

            if($purchase_index!=0) {
                $indexed_rate = $agreement_rate*$current_index/$purchase_index;
            } else {
                $indexed_rate = 0;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(31+$new_row_cnt), $indexed_rate);
        }

        $sql = "select event_name, sum(net_amount) as tot_net_amount from 
                (select case when event_name='Registration' then 'Brokerage' else event_name end as event_name, net_amount 
                from purchase_schedule 
                where purchase_id = '$p_id' and status = '1' and 
                event_type = 'Non agreement value') A 
                group by event_name";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $other_charges=0;
            for($j=0; $j<count($result); $j++) {
                $tot_net_amount=is_numeric($result[$j]->tot_net_amount)?$result[$j]->tot_net_amount:0;
                if(strtoupper(trim($result[$j]->event_name))=='VAT ON BASIC') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(34+$new_row_cnt), '='.$tot_net_amount);
                } else if(strtoupper(trim($result[$j]->event_name))=='STAMP DUTY') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(35+$new_row_cnt), '='.$tot_net_amount);
                } else if(strtoupper(trim($result[$j]->event_name))=='BROKERAGE') {
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(37+$new_row_cnt), '='.$tot_net_amount);
                } else {
                    $other_charges = $other_charges + $tot_net_amount;
                }
            }

            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(38+$new_row_cnt), '='.$other_charges);
        }

        $sql = "select sum(tax_amount) as tot_service_tax from purchase_schedule_taxation 
                where pur_id = '$p_id' and status = '1'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $tot_service_tax=is_numeric($result[0]->tot_service_tax)?$result[0]->tot_service_tax:0;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(36+$new_row_cnt), '='.$tot_service_tax);
        }

        $sql = "select sum(tax_amount) as tot_tds from actual_schedule_taxes 
                where id in (select id from (select tax_applied, max(id) as id from actual_schedule_taxes 
                where table_type = 'purchase' and fk_txn_id = '$p_id' and status = '1' group by tax_applied) A)";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $tot_tds=isset($result[0]->tot_tds)?$result[0]->tot_tds:0;
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(45+$new_row_cnt), '='.$tot_tds);
        }

        $pending_activity = "";

        $sql = "select * from pending_activity where ref_id = '$p_id' and type='purchase'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            for($j=0; $j<count($result); $j++) {
                $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(47+$new_row_cnt), $pending_activity);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(49+$new_row_cnt), $data[0]->remarks);

        $pending_activity = "";

        if($sp_id!=0){
            $sql = "select * from pending_activity where ref_id = '$sp_id' and type='allocation'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                for($j=0; $j<count($result); $j++) {
                    $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(47+$new_row_cnt), $pending_activity);
            }
        }

        $filename='Asset_Level_Purchase_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Purchase report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}



function generate_asset_level_loan_report(){
    $gid=$this->session->userdata('groupid');
    $p_id = $this->input->post('property');
    $sp_id = $this->input->post('sub_property');
    $new_row_cnt = 0;
    $sale_consideration = 0;
    $cost_of_acqisition = 0;
    $agreement_area = 0;
    $purchase_cost = 0;
    $loan_outstanding = 0;

    if($sp_id==0 or $sp_id==''){
        $cond = " and (sub_property_id is null or sub_property_id = '0')";
    } else {
        $cond = " and sub_property_id = '$sp_id'";
    }

    $data=$this->get_property_details($p_id);

    if(count($data)>0) {
        // $file = base_url().'assets/templates/Asset_Level_Purchase.xlsx';
        $template_path=$this->config->item('template_path');
        $file = $template_path.'Asset_Level_Loan.xls';
        $this->load->library('excel');
        $objPHPExcel = PHPExcel_IOFactory::load($file);

        // $objPHPExcel->getActiveSheet()->setTitle('test worksheet');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', $data[0]->p_property_name);
        $objPHPExcel->getActiveSheet()->setCellValue('B5', $data[0]->p_property_name);

        $result=$this->get_property_owners($p_id);
        if(count($result)>0) {
            $owner_cnt=count($result);
            $objPHPExcel->getActiveSheet()->insertNewRowBefore('7', $owner_cnt*2);
            $new_row_cnt=$new_row_cnt+($owner_cnt*2);

            $row=7;
            $cnt=1;
            for($j=0; $j<count($result); $j++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), 'Owner Name '.strval($cnt));
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $result[$j]->owner_name);
                $row=$row+1;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.strval($row), '% Holding');
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval($row), $result[$j]->pr_ownership_percent);
                $row=$row+1;
                $cnt=$cnt+1;
            }
        }

        $address = get_address($data[0]->p_address, $data[0]->p_landmark, $data[0]->p_city, $data[0]->p_pincode, $data[0]->p_state, $data[0]->p_country);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(7+$new_row_cnt), $address);

        $sql = "select * from purchase_property_description where purchase_id='$p_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $no_of_parking = intval($result[0]->pr_open_parking)+intval($result[0]->pr_covered_parking);
            $agreement_area = convert_to_feet($result[0]->pr_agreement_area, $result[0]->pr_agreement_unit);
            $carpet_area = convert_to_feet($result[0]->pr_carpet_area, $result[0]->pr_carpet_unit);
            $builtup_area = convert_to_feet($result[0]->pr_builtup_area, $result[0]->pr_builtup_unit);
            $sellable_area = convert_to_feet($result[0]->pr_sellable_area, $result[0]->pr_sellable_unit);
        } else {
            $no_of_parking = 0;
            $agreement_area = 1;
            $carpet_area = 0;
            $builtup_area = 0;
            $sellable_area = 0;
        }

        $sql = "select sum(net_amount) as tot_net_amount from purchase_schedule where purchase_id='$p_id' and status='1' and event_type = 'Agreement Value'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $agreement_value = floatval($result[0]->tot_net_amount);
        }

        if($sp_id!=0 and $sp_id!=''){
            $sql = "select * from sub_property_allocation where txn_id = '$sp_id'";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $objPHPExcel->getActiveSheet()->setCellValue('B6', $result[0]->sp_name);

                $agreement_area = convert_to_feet($result[0]->sp_sellable_area, $result[0]->sp_sellable_area_unit);
                $carpet_area = convert_to_feet($result[0]->sp_carpet_area, $result[0]->sp_carpet_area_unit);
                $builtup_area = convert_to_feet($result[0]->sp_builtup_area, $result[0]->sp_builtup_area_unit);
                $sellable_area = convert_to_feet($result[0]->sp_sellable_area, $result[0]->sp_sellable_area_unit);

                $agreement_value = floatval($result[0]->allocated_cost);
            }
        }

        if(!is_numeric($agreement_area)){
            $agreement_area = 1;
        }
        if(!is_numeric($agreement_value)){
            $agreement_value = 0;
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(9+$new_row_cnt), $agreement_area);
        $agreement_rate = $agreement_value/$agreement_area;
        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(10+$new_row_cnt), $agreement_rate);

        $sql = "select A.loan_id, B.* from 
                (select * from loan_property_details where property_id = '$p_id' and loan_id in(select distinct txn_id from loan_txn where txn_status = 'Approved') ".$cond." limit 1) A 
                left join 
                (select * from loan_txn where txn_status = 'Approved' and gp_id = '$gid') B 
                on A.loan_id = B.txn_id";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            $loan_id=$result[0]->loan_id;
            $loan_ref_id=$result[0]->ref_id;
            $loan_ref_name=$result[0]->ref_name;
            $loan_type=$result[0]->loan_type;
            $bank_name=$result[0]->financial_institution;
            $loan_term=$result[0]->loan_term;
            $loan_startdate=$result[0]->loan_startdate;
            $loan_due_day=$result[0]->loan_due_day;
            if(is_numeric($loan_term)){
                $loan_enddate = date('Y-m-d', strtotime("+" . $loan_term . " months", strtotime($loan_startdate)));
            } else {
                $loan_enddate = $loan_startdate;
            }
            $curdate = date('Y-m-d');
            if($loan_startdate!=""){
                $d1 = new DateTime($loan_startdate);
                $d2 = new DateTime($curdate);
                $remaining_tenor = intval($loan_term)-intval($d1->diff($d2)->m + ($d1->diff($d2)->y*12));
            } else {
                $remaining_tenor = "";
            }

            $loan_interest_rate=isset($result[0]->loan_interest_rate)?$result[0]->loan_interest_rate:0;
            $loan_interest_type=$result[0]->interest_type;
            $loan_emi=0;
            $loan_amount=isset($result[0]->loan_amount)?$result[0]->loan_amount:0;

            $sql = "select * from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_emi=isset($result[0]->emi)?$result[0]->emi:0;
            }

            $sql = "select * from actual_schedule where id = (select max(id) from actual_schedule 
                    where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved')";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_interest_rate=isset($result[0]->int_rate)?$result[0]->int_rate:0;
                $loan_emi=isset($result[0]->net_amount)?$result[0]->net_amount:0;
            }

            $sql = "select sum(net_amount) as tot_net_amount from loan_schedule where loan_id = '$loan_id' and status = '1'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $loan_outstanding = isset($result[0]->tot_net_amount)?$result[0]->tot_net_amount:0;
            } else {
                $loan_outstanding = 0;
            }

            $outstanding_agreement_amount = $loan_amount - $loan_outstanding;

            $sql = "select sum(paid_amount + tds_amount) as tot_paid_amount, sum(tds_amount) as tot_tds_amount from actual_schedule where table_type = 'loan' and fk_txn_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $tot_paid_amount = isset($result[0]->tot_paid_amount)?$result[0]->tot_paid_amount:0;
                $tot_tds_amount = isset($result[0]->tot_tds_amount)?$result[0]->tot_tds_amount:0;
            } else {
                $tot_paid_amount = 0;
                $tot_tds_amount = 0;
            }

            $loan_outstanding = $loan_outstanding - $tot_paid_amount;

            $sql = "select sum(disbursement_amount) as tot_disbursement_amount from loan_disbursement where loan_id = '$loan_id' and txn_status = 'Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                $tot_disbursement_amount = isset($result[0]->tot_disbursement_amount)?$result[0]->tot_disbursement_amount:0;
            } else {
                $tot_disbursement_amount = 0;
            }

            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(14+$new_row_cnt), $bank_name);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(20+$new_row_cnt), $loan_ref_id);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(21+$new_row_cnt), $loan_ref_name);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(22+$new_row_cnt), $loan_type);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(24+$new_row_cnt), date('d-m-Y', strtotime($loan_startdate)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(25+$new_row_cnt), date('d-m-Y', strtotime($loan_enddate)));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(26+$new_row_cnt), $loan_term);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(27+$new_row_cnt), $remaining_tenor);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(33+$new_row_cnt), $loan_interest_rate/100);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(37+$new_row_cnt), '='.$loan_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(38+$new_row_cnt), '='.$tot_disbursement_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(39+$new_row_cnt), '='.$loan_outstanding);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(40+$new_row_cnt), '='.$outstanding_agreement_amount);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(42+$new_row_cnt), '='.$loan_emi);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(43+$new_row_cnt), $loan_due_day);
        }

        $pending_activity = "";

        $sql = "select * from pending_activity where ref_id = '$p_id' and type='purchase'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0) {
            for($j=0; $j<count($result); $j++) {
                $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(47+$new_row_cnt), $pending_activity);
        }

        $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(49+$new_row_cnt), $data[0]->remarks);

        $pending_activity = "";

        if($sp_id!=0){
            $sql = "select * from pending_activity where ref_id = '$sp_id' and type='allocation'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)>0) {
                for($j=0; $j<count($result); $j++) {
                    $pending_activity=$pending_activity . isset($result[$j]->pending_activity)?$result[$j]->pending_activity . "\n":0;
                }
                $objPHPExcel->getActiveSheet()->setCellValue('B'.strval(47+$new_row_cnt), $pending_activity);
            }
        }

        $filename='Asset_Level_Loan_Report.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        $logarray['table_id']=$this->session->userdata('session_id');
        $logarray['module_name']='Reports';
        $logarray['cnt_name']='Reports';
        $logarray['action']='Asset Level Loan report generated.';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    } else {
        echo '<script>alert("No data found");</script>';
    }
    
}
}
?>