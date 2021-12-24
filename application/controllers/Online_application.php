<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Online_application extends MY_Controller
{

	public function index()
	{
		echo "We are working on it";
	}

	public function status($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;



		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];



		$this->data['title'] = 'Apply For';
		$this->data['description'] = '';
		$this->data['view'] = 'forms/section_h/section_h';
		$this->load->view('layout', $this->data);
	}
}
