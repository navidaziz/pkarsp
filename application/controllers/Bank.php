<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends Admin_Controller
{

	public function index()
	{
		$userId = $this->session->userdata('userId');
		$this->data['level_type'] = (int) $level_type;
		$query = "SELECT
		`schools`.`schoolId` as schools_id
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools` ";
		if ($school_id) {
			$query .= " WHERE `schools`.`schoolId`='" . $school_id . "'";
		} else {
			$query .= " WHERE `schools`.`owner_id`='" . $userId . "'";
		}
		$school = $this->db->query($query)->row();

		if ($school->schools_id) {
			$this->data['school'] = $school;
		} else {
			if ($this->input->get('school_id')) {
				$school_id = (int) $this->input->get('school_id');
				$this->data['school_id'] = "/" . $school_id;
				$this->data['schoolId'] = (int) $school_id;
			}
			$this->data['school'] = NULL;
		}
		$this->data['title'] = 'Download Bank Challan';
		$this->data['description'] = 'Bank Challan for security, fine , change of name, location and ownership.';
		$this->data['view'] = 'print/bank_challan_list';
		$this->load->view('layout', $this->data);
	}
}
