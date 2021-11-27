<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class NoteSheet extends Admin_Controller { 
    	public function __construct(){
        
        parent::__construct();
        $this->load->model("school_m");

    	}
  public function index(){ 
    // echo $_SESSION['user_type'];exit;
    $flage='';
    if ($_SESSION['user_type'] ==1) {
      $flage='1';
    }else if ($_SESSION['user_type'] ==2) {
      $flage='2';
    }else if ($_SESSION['user_type'] ==3) {
      $flage='3';
    }else if ($_SESSION['user_type'] ==4) {
      $flage='4';
    }else if ($_SESSION['user_type'] ==5) {
      $flage='5';
    }else if ($_SESSION['user_type'] ==6) {
      $flage='6';
    }else if ($_SESSION['user_type'] ==7) {
      $flage='7';
    }else if ($_SESSION['user_type'] ==8) {
      $flage='8';
    }
      $like=array();$where=array();	     	    
      if($this->input->post('schoolName')){
     	 $like['schoolName'] = trim($this->input->post('schoolName'));
      } if($this->input->post('schoolId')){
     	 $like['schoolId'] = trim($this->input->post('schoolId'));
      } 

     
    $this->load->library("pagination");
    $config["base_url"] ="https://psra.gkp.pk/schoolReg/NoteSheet/index/" ;

    $total = $this->db->query("SELECT * FROM schools 
    LEFT JOIN levelofinstitute on levelofinstitute.levelofInstituteId = schools.level_of_school_id
    LEFT JOIN district on district.districtId = schools.district_id
    LEFT JOIN tehsils on tehsils.tehsilId = schools.tehsil_id
    WHERE schools.status_type='$flage'"); 
    $config["total_rows"] = $total->num_rows();
    $config["uri_segment"] = 3;
    // $config['use_page_numbers'] = TRUE; 

    $config['per_page'] =8;
    
    $config['reuse_query_string'] = true;
    $config['full_tag_open'] = '<ul class="pagination justify-content-end pull-right">';
    $config['full_tag_close'] = '</ul>';
    $config['attributes'] = ['class' => 'page-link'];
     
    $config['first_link'] = '&laquo; First';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
     
    $config['last_link'] = 'Last &raquo;';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
     
    $config['next_link'] = 'Next &rarr;';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
     
    $config['prev_link'] = '&larr; Prev';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
     
    $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
    $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    // echo $this->uri->segment(3);exit;
    $config['anchor_class'] = 'follow_link';
    $this->pagination->initialize($config);
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $this->data["links"] = $this->pagination->create_links(); 
    $limit = $config['per_page'];
    
    
    
    // $sql = "SELECT * FROM schools 
    // LEFT JOIN levelofinstitute on levelofinstitute.levelofInstituteId = schools.level_of_school_id
    // LEFT JOIN district on district.districtId = schools.district_id
    // LEFT JOIN tehsils on tehsils.tehsilId = schools.tehsil_id
    // WHERE schools.status_type='$flage'";
    
    // $query = $this->db->query($sql); 
    $joins = array(
            array(
                'table' => 'levelofinstitute',
                'condition' => 'levelofinstitute.levelofInstituteId = schools.level_of_school_id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'district',
                'condition' => 'district.districtId = schools.district_id',
                'type' => 'LEFT'
            ),
            array(
                'table' => 'tehsils',
                'condition' => 'tehsils.tehsilId = schools.tehsil_id',
                'type' => 'LEFT'
            ) 
        );
    $where['schools.status_type'] = $flage;
    $this->data['res'] = $this->select_fields_where_like_join('schools','*',$joins,$where,'','',$like,'','',$limit,$page);
    // echo "<pre>"; print_r($this->data['res']);exit;
    $this->data['view'] = 'Notesheet/notesheet';
    $this->load->view('layout',$this->data);
 }
 public function ChangeStatus(){
     
   if($this->input->get('print')){ 
      $id = $this->input->get('schoolId');  
      $query = $this->db->query("SELECT * FROM paranewregistration LEFT JOIN users on paranewregistration.added_by_id = users.userId  WHERE school_id = '".$id."' ");
      $result['data'] = $query->result_array();  
      $result['subject'] = $this->input->get('subject'); ; 
      $this->load->view('school/print',$result);
   } 
  if($this->input->get('comments')){

      $this->input->get('comments'); 
      $data['school_id'] = $this->input->get('schoolId');
      $data['comment_text'] = $this->input->get('comments'); 
      $data['comment_by'] = $_SESSION['userId'];  
      $insert = $this->db->insert("commentnewregistraction",$data);
      if($insert){  
        echo json_encode($res['success'] = '1'); 
      }else{
          echo $this->db->error();
      }
  }else if($this->input->post('submit')){
    //   echo "<pre>"; print_r($_POST); exit;

      $data['school_id'] = $this->input->post('schoolId');
      $data['para_text'] = $this->input->post('para_text'); 
      $statusType = $this->input->post('status_type'); 
      $data['added_by_id'] = $_SESSION['userId']; $subject = $this->input->post('subject'); 
      $insert = $this->db->insert("paranewregistration",$data);
      if($insert){  
          //echo "UPDATE `schools` SET `status_type` = '".$statusType."' WHERE schoolId ='".$data['school_id']."'";exit;
          $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$statusType."',`subjects` = '".$subject."' WHERE schoolId ='".$data['school_id']."'");
        //   $update = $this->db->query("UPDATE `schools` SET `subjects` = '".$subject."' WHERE schoolId ='".$schoolId."'");
          if($update){  
            redirect('NoteSheet');
          } 
      }
  }
  
  if($this->input->post('renewal_upgradation')){ 
    //   echo "<pre>"; print_r($_POST);exit;
      $data['school_id'] = $this->input->post('schoolId');
      $data['para_text'] = $this->input->post('para_text'); 
      $statusType = $this->input->post('status_type'); 
      $data['added_by_id'] = $_SESSION['userId']; $subject = $this->input->post('subject'); 
      $insert = $this->db->insert("para_renewal",$data);
        // echo "UPDATE `school` SET `status_type` = '".$statusType."',`subject` = '".$subject."' WHERE schoolId ='".$data['school_id']."'";exit;
          $update = $this->db->query("UPDATE `school` SET `status_type` = '".$statusType."',`subject` = '".$subject."' WHERE schoolId ='".$data['school_id']."'"); 
           
            redirect('NoteSheet/renewal_upgradation'); 
  }
  
  else if($this->input->get('closeFile')){ 

      $data['school_id'] = $this->input->get('schoolId');   
      $update = $this->db->query("UPDATE `schools` SET `status_type` = '0' WHERE schoolId ='".$data['school_id']."'"); 
      echo json_encode($res['success'] = '1'); 
  }
  
  else if($this->input->get('isRejected')){ 

      $data['school_id'] = $this->input->get('schoolId');   
      $update = $this->db->query("UPDATE `schools` SET `isRejected` = '1',`status_type` = '1' WHERE schoolId ='".$data['school_id']."'"); 
      echo json_encode($res['success'] = '1'); 
  }
  
  else if($this->input->get('ViewPara')){
      $response="";
      $id = $this->input->get('schoolId');  
      $query = $this->db->query("SELECT * FROM paranewregistration LEFT JOIN users on paranewregistration.added_by_id = users.userId  WHERE school_id = '".$id."' ");
      $result = $query->result_array();  
      if($result){   
        foreach($result as $res){
          $response .= "<p>".$res['para_text']."</p><p><strong>remarks By: </strong> <span>".$res['userTitle']."</span>   <strong>Date: </strong> ".$res['para_created_at'].""."</p><br>";
        }
        $res['success'] ='1';
        $res['datas'] =$response;
        echo json_encode($res); 
      }
  }else if($this->input->get('ViewComments')){
      $response="";
      $id = $this->input->get('schoolId');  
      $query = $this->db->query("SELECT * FROM commentnewregistraction LEFT JOIN users on commentnewregistraction.comment_by = users.userId  WHERE school_id = '".$id."' ");
      $result = $query->result_array();  
      if($result){   
        foreach($result as $res){
          $response .= "<li> <b>TEXT: </b>". $res['comment_text']."<br><b> Created at: </b>".$res['comment_created_at']."<b> initiated By:</b>".$res['userTitle']."</li>";
        }
        $res['success'] ='1';
        $res['datas'] =$response;
        echo json_encode($res); 
      }
  }else if($this->input->get('status_type')){
      // echo "string";exit();
      $schoolId = $this->input->get('schoolId');
      $status_type = $this->input->get('status_type'); 
      $where =array('schoolId'=>$schoolId);
      // echo "UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'";
      $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'");
      if($update){  
        echo json_encode($res['success'] = '1'); 
      }
  }
  
//   else if($this->input->get('fee2017')){
//       echo "string";exit();
//       $feeid = $this->input->get('feeid');
//       $Fee = $this->input->get('value'); 
//       $where =array('feeid'=>$feeid);
//       // echo "UPDATE `fee` SET `fee2017` = '".$Fee."' WHERE feeid ='".$feeid."'";
//       $update = $this->db->query("UPDATE `fee` SET `fee2017` = '".$Fee."' WHERE feeid ='".$feeid."'");
//       if($update){  
//         echo json_encode($res['success'] = '1'); 
//       }
//   }
  
  
  else if($this->input->get('addSubject')){
      // echo "string";exit();
      $schoolId = $this->input->get('schoolId');
      $subject = $this->input->get('subject'); 
      $where =array('schoolId'=>$schoolId);
    //   echo  "UPDATE `schools` SET `subjects` = '".$subject."' WHERE schoolId ='".$schoolId."'";
      $update = $this->db->query("UPDATE `schools` SET `subjects` = '".$subject."' WHERE schoolId ='".$schoolId."'");
      if($update){  
        echo json_encode($res['success'] = '1'); 
      }
  }
  
  
  else if($this->input->get('status_type')){
      // echo "string";exit();
      $schoolId = $this->input->get('schoolId');
      $status_type = $this->input->get('status_type'); 
      $where =array('schoolId'=>$schoolId);
      // echo "UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'";
      $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'");
      if($update){  
        echo json_encode($res['success'] = '1'); 
      }
  }else if($this->input->get('status_type')){
      // echo "string";exit();
      $schoolId = $this->input->get('schoolId');
      $status_type = $this->input->get('status_type'); 
      $where =array('schoolId'=>$schoolId);
      // echo "UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'";
      $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'");
      if($update){  
        echo json_encode($res['success'] = '1'); 
      }
  }else if($this->input->get('status_type')){
      // echo "string";exit();
      $schoolId = $this->input->get('schoolId');
      $status_type = $this->input->get('status_type'); 
      $where =array('schoolId'=>$schoolId);
      // echo "UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'";
      $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$status_type."' WHERE schoolId ='".$schoolId."'");
      if($update){  
        echo json_encode($res['success'] = '1'); 
      }
  }
 }
 public function ChangeStatusOfRenewal(){echo "here";exit;
     if($this->input->post('renewal_upgradation')){ 
      $data['school_id'] = $this->input->post('schoolId');
      $data['para_text'] = $this->input->post('para_text'); 
      $statusType = $this->input->post('status_type'); 
      $data['added_by_id'] = $_SESSION['userId']; $subject = $this->input->post('subject'); 
      $insert = $this->db->insert("paranewregistration",$data);
      if($insert){  
          //echo "UPDATE `schools` SET `status_type` = '".$statusType."' WHERE schoolId ='".$data['school_id']."'";exit;
          $update = $this->db->query("UPDATE `schools` SET `status_type` = '".$statusType."',`subjects` = '".$subject."' WHERE schoolId ='".$data['school_id']."'");
        //   $update = $this->db->query("UPDATE `schools` SET `subjects` = '".$subject."' WHERE schoolId ='".$schoolId."'");
          if($update){  
            redirect('NoteSheet');
          } 
      }
  }
 }
 public function num_rows($query){
       // echo $query; 
       $query = $this->db->query($query); 
       $num_rows =  $query->num_rows();
       return $num_rows;
 }
 public function select_fields_where_like_join($tbl = '', $data='', $joins = '', $where = '', $single = FALSE, $field = '', $value = '',$group_by='',$order_by = '',$limit = '',$page='',$where_in_col='',$where_in_array=''){
   
        if (is_array($data) and isset($data[1])){
            $this->db->select($data[0],$data[1]);
        }else{
            $this->db->select($data);
        }

        $this->db->from($tbl);
        if ($joins != '') {
            foreach ($joins as $k => $v) {
                $this->db->join($v['table'], $v['condition'], $v['type']);
            }
        }

        if ($value !== '') {
            // $this->db->like('LOWER(' . $field . ')', strtolower($value));
            // $this->db->or_like($value);
            $this->db->like($value);
        }

        if ($where != '') {
            $this->db->where($where);
        }

        if ($where_in_col != '' && $where_in_array !='') {
             $this->db->where_in($where_in_col,$where_in_array);
        }
           

        if($group_by != ''){
            $this->db->group_by($group_by);
        }
        if($order_by != ''){
            if(is_array($order_by)){
                $this->db->order_by($order_by[0],$order_by[1]);
            }else{
                $this->db->order_by($order_by);
            }
        }
        if($limit != ''){
            // if(is_array($limit)){
            //     $this->db->limit($limit[0],$limit[1]);
            // }else{
            //     $this->db->limit($limit);
            // }           
          $this->db->limit($limit,$page);
        }
        $query = $this->db->get(); 
        //print_r($this->db->last_query());//exit();
        if ($query) { 
          if ($single == TRUE) {
              return $query->row();
          } else {
              return $query->result_array();
          }
        } else { 
            return FALSE;
        }
    }
 public function renewal_upgradation(){  
      $this->load->model('general_modal');
      $this->data['districts'] = $this->general_modal->districts(0, FALSE);
      $this->db->where('setting_name','next');
        $query=$this->db->get("session_setting");
        
        $next_session= $query->row()->session_id;
        $query ="SELECT count(*)as total_rows FROM `schools` inner join school on `schools`.`schoolId`=`school`.`schools_id` WHERE `schools`.`registrationNumber` not in('',0) and `school`.`status`=2 and session_year_id=$next_session";

        $number_of_rows = $this->db->query($query)->row()->total_rows; 
        $this->load->library('pagination');
            $config = [
                'base_url'  =>  base_url('school/renewal_code_allotment'),
                'per_page'  =>  25,
                'total_rows' => $number_of_rows,
                'full_tag_open' =>  '<ul class="pagination pagination-sm">',
                'full_tag_close'  =>    '</ul>',
                'first_tag_open'    =>  '<li>',
                'first_tag_close'  =>   '</li>',
                'last_tag_open' =>  '<li>',
                'last_tag_close'  =>    '</li>',
                'next_tag_open' =>  '<li>',
                'next_tag_close'  =>    '</li>',
                'prev_tag_open' =>  '<li>',
                'prev_tag_close'  =>    '</li>',
                'num_tag_open'  =>  '<li>',
                'num_tag_close'  => '</li>',
                'cur_tag_open'  =>  '<li class="active"><a>',
                'cur_tag_close'  => '</a></li>'
            ];

          $this->pagination->initialize($config);
          if(empty($id)){
              $offset = $this->uri->segment(3,0);
          }else{
              $offset = $id;
          }
      $this->data['schools'] = $this->school_m->schools_has_no_renewal_number($config['per_page'], $offset);
      
      $this->data['title'] = 'school Renewal';
      $this->data['description'] = 'info about school';
      
    $this->data['view'] = 'Notesheet/renewal_upgradation';
    $this->load->view('layout',$this->data); 
 }
}