<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class Bise extends REST_Controller
{


    function __construct()
    {
        // Construct the parent class
        parent::__construct();



        $api_key = $this->input->get("api_key");
        if (isset($api_key)) {

            if ($api_key !== '@D%6YAfMPBISET50@XdSsZ@p') {
                $response['error'] = "Error in api key.";
                $response['api_key'] = $api_key;
                $response['data'] = false;
                echo json_encode($response);
                exit();
            }
        } else {
            $response['error'] = "api_key is mission";
            $response['data'] = false;
            echo json_encode($response);
            exit();
        }
        $bise_password = $this->input->get("bise_password");
        if (isset($bise_password)) {
            $bise = array("bise_peshawar", "bise_mardan");
            if (!in_array($bise_password, $bise)) {
                $response['error'] = "Error in bise password. try again with valid password.";
                $response['bise_password'] = $bise_password;
                $response['data'] = false;
                echo json_encode($response);
                exit();
            }
        } else {
            $response['error'] = "bise_password is mission";
            $response['data'] = false;
            echo json_encode($response);
            exit();
        }
    }

    function index_get()
    {
    }
    function institute_info_get()
    {
        $response = array();
        $registration_no =  $this->input->get("registration_no");
        if (!$this->input->get("registration_no")) {
            $response['message'] = "Please provide registration number";
            $response['data'] = false;
            echo json_encode($response);
            exit();
        }


        $registration_no = $this->db->escape($registration_no);


        $query = "
        SELECT institute_info.school_id,institute_info.reg_code, institute_info.school_name, institute_info.district, institute_info.bise,
        IF(institute_info.gender_of_edu_id=1, 'Boys', IF(institute_info.gender_of_edu_id=2,'Girls', 'CoEdu')) as gender_of_education,
        IF(institute_info.school_level_id = 1, 'Primary', IF(institute_info.school_level_id=2, 'Middle', IF(institute_info.school_level_id=3, 'High', IF(institute_info.school_level_id=4, 'High Secondary', IF(institute_info.school_level_id=5, 'Academy','Undefine'))))) as institute_level,
        (SELECT session_year.sessionYearTitle FROM session_year WHERE session_year.sessionYearId = institute_info.registration_session_id) as registration_session,
        (SELECT session_year.sessionYearTitle FROM session_year WHERE session_year.sessionYearId = institute_info.last_renewal_session_id) as last_renewal_session
        FROM `institute_info` WHERE institute_info.reg_code = " . $registration_no . ";
        ";
        $school_info = $this->db->query($query)->result_array();
        if ($school_info) {
            $response['message'] = "Registration Found.";
            $response['data'] = $school_info;
            echo json_encode($response);
        } else {
            $response['message'] = "Registration not found. try again with different registration number.";
            $response['data'] = false;
            echo json_encode($response);
            exit();
        }
    }

    function institute_info_post()
    {
    }

    function institute_info_put()
    {
        // $data = array('returned: '. $this->put('school_id'));
        // $this->response($data);
    }

    function institute_info_delete()
    {
        // $data = array('returned: '. $this->delete('school_id'));
        // $this->response($data);
    }
}
