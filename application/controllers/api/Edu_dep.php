<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Edu_dep extends REST_Controller {


function __construct()
    {
        // Construct the parent class
        parent::__construct();
        

        
        $api_key = $this->input->get("api_key");
        if(isset($api_key)){
            
            if($api_key !== '@D%6YAfMPT50@XdSsZ@p'){
                    $response['error'] ="Error in api key.";
                    $response['api_key'] = $api_key;
                     $response['data'] = false;
                    echo json_encode($response);
                    exit();
                }
            
        }else{
            $response['error'] ="api_key is mission";
             $response['data'] = false;
            echo json_encode($response);
            exit();
        }
        
       
        
        // if($_SERVER['REQUEST_METHOD']==='POST'){
            
        // }
        
        }


   // function __construct()
   // {
        // Construct the parent class
       // parent::__construct();
        // $api_key = apache_request_headers();
        // if($api_key["X-Api-Key"] !== 'n2r5u8x/A?D(G+KbPdSgVkYp3s6v9y$B'){
        //     $response['error'] ="Error in api key.";
        //     echo json_encode($response);
        //     exit();
        // }
        
        // if($_SERVER['REQUEST_METHOD']==='POST'){
            
        // }
        
      //  }
        
//         public function index_get($id = 0)
// 	{
//       $data = ['Item created successfully.'];
     
//         $this->response($data, REST_Controller::HTTP_OK);
// 	}
	
// 	 public function index_post($id = 0)
// 	{
//       $data = array();
     
//         $this->response($data, REST_Controller::HTTP_OK);
// 	}


function get_school_info_get()
    {   
       
       
        $response =array();
        
        
        $schoolId = (int) $this->input->get("schoolId");
           if($schoolId==0){
               
               $response['message'] = "Please provide schoolId";
               $response['data'] = false;
               echo json_encode($response);
               exit();
           }
           
           
           
           $emisCode = $this->input->get("emisCode");
           if($emisCode==""){
               $response['message'] = "Please provide emisCode";
                $response['data'] = false;
               echo json_encode($response);
               exit();
           }
           $emisCode = $this->db->escape($this->input->get("emisCode"));
           $schoolId = $this->db->escape($schoolId);
           
           
           $query="SELECT * FROM `registered_schools_with_emis_code` WHERE school_id = $schoolId AND emis_code = $emisCode";
           $school_info = $this->db->query($query)->result_array();
           if($school_info){
               $response['message'] = "School Found";
                $response['data'] = $school_info;
               echo json_encode($response);
           }else{
               $response['message'] = "School not found.";
                $response['data'] = false;
               echo json_encode($response);
               exit();
           }
           
           
           
           
           
           
           
    }
     
    function get_school_info_post()
    {
        
    }
 
    function get_school_info_put()
    {       
        // $data = array('returned: '. $this->put('school_id'));
        // $this->response($data);
    }
 
    function get_school_info_delete()
    {
        // $data = array('returned: '. $this->delete('school_id'));
        // $this->response($data);
    }
        
       public function RegSchool_post(){
           
           $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
exit();
           
           $schoolId = (int) $this->input->post("schoolId");
           if(!empty($schoolId)){
               $data['message'] = "Please provide school id";
               echo $this->response($data, REST_Controller::HTTP_OK);
               exit();
           }
           
           $emis_code = $this->db->escape($this->input->post("emis_code"));
           if(!empty($emis_code)){
               $data['message'] = "Please provide EMIS Code";
               echo $this->response($data, REST_Controller::HTTP_OK);
               exit();
           }
           
          
     
        
	     
        }

public function get_school_detail()
    {
        
        if($this->input->post("school_id")){
        $school_id = (int) $this->input->post("school_id");
        $query="SELECT `s`.`schoolId`, 
                       `s`.`registrationNumber`,
                       `s`.`schoolName`,
                       d.districtTitle,
                       t.tehsilTitle,
                       s.address,
                      ( select s_s.level_of_school_id  from school as s_s where s_s.schools_id=s.schoolId and s_s.status=1 order by s_s.session_year_id DESC LIMIT 1) as level_id
                 FROM schools as s
                 INNER JOIN district as d ON (d.districtId = s.district_id)
                 INNER JOIN tehsils as t ON (t.tehsilId = s.tehsil_id)
                 WHERE schoolId  = '".$school_id."'
                 AND `s`.`registrationNumber` > 0
                 ";
        $school = $this->db->query($query)->result();
        if($school){
            $response['response'] = true;
            $response['school'] = $school;
            $response['message'] = '';
            echo json_encode($response);
        }else{
            $response['response'] = true;
            $response['school'] = false;
            $response['message'] = 'School ID not found';
            echo json_encode($response);
        }
        }else{
            $response['response'] = true;
            $response['school'] = false;
            $response['message'] = 'School ID Required';
            echo json_encode($response);
        }
        
        
    }
    
 
   

}