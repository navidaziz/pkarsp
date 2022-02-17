<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_dashboard extends Admin_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
		$this->load->model("general_modal");
		$this->load->model("session_m");
		$this->load->helper('project_helper');
	}



	public function index()
	{


		$userId = $this->session->userdata('userId');
		//$this->data['schooldata'] = $this->school_m->get_school_data_for_school_insertion($userId);
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school_id'] = $school_id = $this->db->query($query)->result()[0]->schoolId;
		$query = "SELECT 
		`schools`.`schoolId`,
		`schools`.`reg_type_id`,
		`schools`.`schoolName`,
		`schools`.`yearOfEstiblishment`,
		`schools`.`telePhoneNumber`,
		`schools`.`district_id`,
		`district`.`districtTitle`,
		`schools`.`tehsil_id`,
		`tehsils`.`tehsilTitle`,
		`uc`.`ucTitle`,
		`schools`.`uc_id`,
		`schools`.`address`,
		`schools`.`location`,
		`schools`.`late`,
		`schools`.`longitude`,
		`genderofschool`.`genderOfSchoolTitle`,
		`schools`.`gender_type_id`,
		`school_type`.`typeTitle`,
		`schools`.`schoolTypeOther`,
		`schools`.`ppcName`,
		`schools`.`ppcCode`,
		`schools`.`mediumOfInstruction`,
		`schools`.`biseRegister`,
		`schools`.`registrationNumber`,
		`schools`.`biseregistrationNumber`,
		`schools`.`primaryRegDate`,
		`schools`.`middleRegDate`,
		`schools`.`highRegDate`,
		`schools`.`interRegDate`,
		`schools`.`biseAffiliated`,
		`schools`.`bise_id`,
		`bise`.`biseName`,
		`schools`.`otherBiseName`,
		`schools`.`management_id`,
		`management`.`managementTitle`,
		`schools`.`level_of_school_id`,
		`levelofinstitute`.`levelofInstituteTitle`,
		`schools`.`schoolMobileNumber`
	  FROM
		`schools` 
		
		LEFT JOIN `bank_account` 
		  ON (
			`schools`.`schoolId` = `bank_account`.`school_id`
		  ) 
		  LEFT JOIN `levelofinstitute` 
		  ON (
			`schools`.`level_of_school_id` = `levelofinstitute`.`levelofInstituteId`
		  ) 
		LEFT JOIN `district` 
		  ON (
			`schools`.`district_id` = `district`.`districtId`
		  ) 
		LEFT JOIN `tehsils` 
		  ON (
			`schools`.`tehsil_id` = `tehsils`.`tehsilId`
		  ) 
		LEFT JOIN `uc` 
		  ON (`schools`.`uc_id` = `uc`.`ucId`) 
		LEFT JOIN `genderofschool` 
		  ON (
			`schools`.`gender_type_id` = `genderofschool`.`genderOfSchoolId`
		  ) 
		LEFT JOIN `school_type` 
		  ON (
			`schools`.`school_type_id` = `school_type`.`typeId`
		  ) 
		LEFT JOIN `bise` 
		  ON (
			`schools`.`bise_id` = `bise`.`biseId`
		  ) 
		LEFT JOIN `management` 
		  ON (
			`schools`.`management_id` = `management`.`managementId`
		  ) 
	   
	  WHERE schools.`schoolId` ='" . $school_id . "'";
		$this->data['school']  = $this->db->query($query)->result()[0];
		//$this->data['school']  = $this->school_m->get_school_data_for_school_insertion($userId);
		//var_dump($this->data['school']);
		$tehsil_id = $this->data['schooldata']->tehsil_id;
		$this->data['ucs_list'] = $this->db->where('tehsil_id', $tehsil_id)->get('uc')->result();
		$next = $this->session_m->get_next_session();
		$this->data['next_session_id'] = $next->session_id;
		$this->data['school_types'] = $this->general_modal->school_types();
		$this->data['districts'] = $this->general_modal->districts();
		$this->data['gender_of_school'] = $this->general_modal->gender_of_school();
		$this->data['level_of_institute'] = $this->general_modal->level_of_institute();
		$this->data['reg_type'] = $this->general_modal->registration_type();
		$this->data['tehsils'] = $this->general_modal->tehsils();
		$this->data['ucs'] = $this->general_modal->ucs();
		$this->data['locations'] = $this->general_modal->location();
		$this->data['bise_list'] = $this->general_modal->bise_list();
		// var_dump($this->data['locations']);
		// exit();
		$this->data['title'] = 'school';
		$this->data['description'] = 'info about school';
		$this->data['view'] = 'school_dashboard/school_dashboard';
		$this->load->view('layout', $this->data);
	}

	public function certificate($schools_id, $school_id, $session_id)
	{
		$schools_id = (int) $schools_id;
		$school_id = (int) $school_id;
		$session_id = (int) $session_id;

		$query = "SELECT
                  `school`.`schoolId`
                  ,`school`.`updatedDate`
                  , `schools`.`registrationNumber`
                  , `schools`.`schoolName`
                  , `schools`.`district_id`
                  , `district`.`districtTitle`
                  , `district`.`bise`
                  , `schools`.`gender_type_id`
                  , `genderofschool`.`genderOfSchoolTitle`
                  , `levelofinstitute`.`levelofInstituteTitle`
                  , `levelofinstitute`.`upper_class`
                  , `schools`.`biseregistrationNumber`
                  ,`session_year`.`sessionYearTitle`
                ,`tehsils`.`tehsilTitle`
              FROM
                  `schools`
				  INNER JOIN `district` 
                      ON (`schools`.`district_id` = `district`.`districtId`)
				 INNER JOIN `tehsils` 
                      ON (`schools`.`tehsil_id` = `tehsils`.`tehsilId`)
				 INNER JOIN `school` 
                      ON (`schools`.`schoolId` = `school`.`schools_id`)
                  INNER JOIN `genderofschool` 
                      ON (`school`.`gender_type_id` = `genderofschool`.`genderOfSchoolId`)
                  INNER JOIN `levelofinstitute` 
                      ON (`school`.`level_of_school_id` = `levelofinstitute`.`levelofInstituteId`)
                  INNER JOIN `session_year` 
                      ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
                  WHERE `schools`.`schoolId` = '" . $schools_id . "' 
				        AND `school`.`status`=1 
						AND school.schoolId = '" . $school_id . "'
						AND `school`.`session_year_id` = '" . $session_id . "'";

		$school_info = $this->db->query($query)->row();

		$query1 = "SELECT
                 
                  MIN(`age_and_class`.`class_id`)
                  
                  ,(select classTitle from class where classId= MIN(`age_and_class`.`class_id`)) as classTitle
                  
                  
              FROM
                  `age_and_class`
                  
                 
                  
                      
                      INNER JOIN `class` 
                      ON (`age_and_class`.`class_id` = `class`.`classId`)
                    WHERE `age_and_class`.`school_id` =" . $school_info->schoolId . ";";
		$this->data['schools_info'] = $school_info;
		$this->data['lower_class'] = $this->db->query($query1)->row();

		$this->load->view('school_dashboard/certificate_of_schools', $this->data);
	}
}
