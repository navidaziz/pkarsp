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
		$session = $this->db->query($query)->result()[0];

		$query = "SELECT schools.`schoolId`, schools.`schoolName`, schools.`registrationNumber`, 
		district.`districtTitle`, district.`bise`,
		levelofinstitute.`levelofInstituteTitle`
		FROM schools
		INNER JOIN school ON schools.schoolId=school.schools_id
		INNER JOIN district ON district.`districtId` = schools.`district_id`
		INNER JOIN levelofinstitute ON levelofinstitute.`levelofInstituteId` = school.`level_of_school_id`
		WHERE school.`status`=1
		AND school.`session_year_id`= '" . $session->sessionYearId . "'
		AND district.`bise` = '" . $this->session->userdata('userTitle') . "'
		AND school.`level_of_school_id` IN(3,4)
		GROUP BY  schools.`schoolId`";
		$this->data['school_list'] = $this->db->query($query)->result();
		$this->data['title'] = 'High/ High Sec. schools list for session ' . $session->sessionYearTitle;
		$this->data['description'] = 'For the Session ' . $session->sessionYearTitle . ', here is the list of High/High Sec. Schools that have been registered and renewed.';
		$this->data['view'] = 'bise/school_list';
		$this->load->view('layout', $this->data);
	}
}
