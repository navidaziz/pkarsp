<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deficiency extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function bank_challan($deficiency_id)
	{
		$this->data['deficiency_id'] = $deficiency_id = (int) $deficiency_id;
		$query = "SELECT * FROM deficiencies WHERE deficiency_id = '" . $deficiency_id . "'";
		$this->data['deficiency_detail'] = $this->db->query($query)->result()[0];
		$this->data['session_id'] = $session_id = (int) $this->data['deficiency_detail']->session_id;

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;


		$this->data['title'] = "Deficiency";
		$this->data['description'] = '';
		$this->load->view('deficiency/deficiency_bank_challan_print', $this->data);
	}
}
