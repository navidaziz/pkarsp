<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Online_application extends MY_Controller
{

	public function index()
	{
		echo "We are working on it";
	}

	public function status($school_session_id)
	{

		$this->load->helper('project_helper');
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` 
					, `school`.`reg_type_id`
					, `school`.`status`
					, `levelofinstitute`.`levelofInstituteTitle`
					, `gender`.`genderTitle`
					, `reg_type`.`regTypeTitle`
				FROM
					`schools`
					, `school`
					,`levelofinstitute`
					,`gender`
					,`reg_type` 
				WHERE  `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
				AND `gender`.`genderId` = `school`.`gender_type_id`
				AND `reg_type`.`regTypeId` = `school`.`reg_type_id`
				AND `schools`.`schoolId` = `school`.`schools_id`
				AND  `school`.`schoolId`='" . $school_session_id . "'
				AND `schools`.`owner_id`='" . $userId . "'";




		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->data['session_id'] = $session_id = (int) $this->data['school']->session_year_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];

		$this->data['title'] = 'Applied For';
		$this->data['description'] = '';
		$this->data['view'] = 'online_application/status';
		$this->load->view('layout', $this->data);
	}
}
