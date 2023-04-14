<?php
defined('BASEPATH') or exit('No direct script access allowed');

//class Fines extends Admin_Controller
class Bise extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$query = "SELECT * FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;";
		$current_session = $this->db->query($query)->row();
		$query = "SELECT * FROM `session_year` WHERE sessionYearId ='" . ($current_session->sessionYearId - 1) . "'";
		$previous_session = $this->db->query($query)->row();


		$query = "SELECT schools.`schoolId`, schools.`schoolName`, schools.`registrationNumber`, 
		district.`districtTitle`, district.`bise`,
		levelofinstitute.`levelofInstituteTitle`,
		`session_year`.`sessionYearTitle`
		FROM schools
		INNER JOIN school ON schools.schoolId=school.schools_id
		INNER JOIN district ON district.`districtId` = schools.`district_id`
		INNER JOIN levelofinstitute ON levelofinstitute.`levelofInstituteId` = school.`level_of_school_id`
		INNER JOIN session_year ON (session_year.sessionYearId = school.`session_year_id`)
		WHERE school.`status`=1
		AND school.`session_year_id` IN('" . $current_session->sessionYearId . "','" . $previous_session->sessionYearId . "')
		AND district.`bise` = '" . $this->session->userdata('userTitle') . "'
		AND school.`level_of_school_id` IN(3,4)
		GROUP BY  schools.`schoolId`";
		$this->data['school_list'] = $this->db->query($query)->result();
		$this->data['title'] = 'High/ High Sec. schools list for session ' . $previous_session->sessionYearTitle . ' & ' . $current_session->sessionYearTitle;
		$this->data['description'] = 'For the Session ' .  $previous_session->sessionYearTitle . ' & ' . $current_session->sessionYearTitle . ', here is the list of High/High Sec. Schools that have been registered and renewed.<br /><br />';
		$this->data['view'] = 'bise/school_list';
		$this->load->view('layout', $this->data);
	}
}
