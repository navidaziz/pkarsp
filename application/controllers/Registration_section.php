<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_section extends MY_Controller
{

	public function index()
	{
		$query = "SELECT
		`schools`.schoolId,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`session_year`.`sessionYearTitle`,
		`school`.`schools_id`,
		`school`.`status`
		FROM
		`school`,
		`schools`,
		`bank_challans`,
		`session_year`
		WHERE `school`.`schoolId` = `bank_challans`.`school_id`
		AND `session_year`.`sessionYearId` = `bank_challans`.`session_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND  `bank_challans`.`verified` = '1'
		AND `school`.`status`=3
		AND `school`.`reg_type_id`=1";
		$this->data['new_registrations'] = $this->db->query($query)->result();

		$this->data['title'] = 'Registration Section';
		$this->data['description'] = 'List of All Requests';
		$this->data['view'] = 'registration_section/request_list';
		$this->load->view('layout', $this->data);
	}
}
