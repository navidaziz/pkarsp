<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_dashboard extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
		$this->load->model("general_modal");
		$this->load->model("session_m");
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
		`levelofinstitute`.`levelofInstituteTitle`
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
}
