<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operation extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("school_m");
	}

	public function index()
	{
		$this->data['title'] = 'Operation Wing';
		$this->data['description'] = 'Dashboard';
		$this->data['view'] = 'operation/index';
		$this->load->view('layout', $this->data);
	}

	public function section_e_open_list()
	{
		$query = "SELECT  `schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.`yearOfEstiblishment`,
		`schools`.`tehsil_id`,
		`schools`.`address`,
		`schools`.`uc_id`,
		`schools`.`uc_text`,
		`district`.`districtTitle`,
		school.schoolId as school_id,
		school.session_year_id as session_id,
		session_year.sessionYearTitle 
		FROM school
		INNER JOIN schools ON (schools.schoolId = school.schools_id) 
		INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`)
		INNER JOIN session_year ON(session_year.sessionYearId = school.session_year_id)
		 WHERE school.section_e=0";
		$this->data['search_list'] = $this->db->query($query)->result();
		$title = "<h4>Section E Opened Cases List <small class=\"pull-right\">" . count($this->data['search_list']) . " Records found  </small></h4>";
		$this->data['title'] = $title;

		$this->load->view('operation/section_e_opened_list', $this->data);
	}

	public function section_e($schools_id, $school_id, $session_id)
	{
		$this->data['school_id'] = (int) $school_id;
		$this->data['schools_id'] = $schools_id = (int) $schools_id;
		$query = "SELECT
   	`schools`.schoolId 
   	, `schools`.`registrationNumber`
      , `schools`.`schoolName`
      , `schools`.`yearOfEstiblishment`
      , `schools`.`school_type_id`
      , `schools`.`level_of_school_id`
      , `schools`.`gender_type_id`
      , (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
      , `district`.`districtTitle` 
      , `tehsils`.`tehsilTitle`
      , (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
      `schools`.`address`,
      `schools`.`telePhoneNumber`,
      `schools`.`schoolMobileNumber`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`principal_email`
   	FROM `schools` INNER JOIN `district` 
        ON (`schools`.`district_id` = `district`.`districtId`) 
        INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)";
		$query .= " WHERE `schools`.`schoolId` = " . $schools_id . " ";
		$this->data['school'] = $this->db->query($query)->row();

		$this->data['session_id'] = (int) $session_id;
		$this->data['title'] = "Update Section E";
		$this->data['description'] = "Update Section E";
		$this->data['view'] = 'operation/section_e_update_form';
		$this->load->view('layout', $this->data);
	}

	public function update_section_e()
	{

		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');
		$session_id = (int) $this->input->post('session_id');
		$query = "SELECT COUNT(*) as total, school.section_e
				FROM
					`schools` , `school` 
				WHERE `schools`.`schoolId` = `school`.`schools_id`
				AND  `school`.`schoolId`='" . $school_id . "'
				AND `schools`.`schoolId`='" . $schools_id . "'";
		$school =  $this->db->query($query)->row();
		if ($school->total == 0) {
			echo "You are not allow to update.";
			exit();
		}

		if ($school->section_e == 1) {
			echo "Section E not open yet!";
			exit();
		}



		$fees = $this->input->post('fee');
		foreach ($fees as $fee_id => $fee) {

			$query = "UPDATE fee SET tuitionFee = '" . $fee . "' 
			WHERE school_id = '" . $school_id . "' AND feeId = '" . $fee_id . "'";
			$this->db->query($query);
		}

		if ($this->input->post('update_section_e') == 'Submit Section E') {
			$query = "UPDATE `school` SET section_e = 1  WHERE status='2' AND schoolId = '" . $school_id . "' LIMIT 1";
			$this->db->query($query);
		}

		redirect("operation/section_e/" . $schools_id . "/" . $school_id . "/" . $session_id);
	}


	public function update_section_e_form()
	{
		$this->data['school_id'] = (int) $this->input->post('school_id');
		$this->data['schools_id'] = (int) $this->input->post('schools_id');
		$this->data['session_id'] = (int) $this->input->post('session_id');
		$this->load->view('operation/section_e', $this->data);
	}

	public function add_class_fee()
	{
		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');
		$session_id = (int) $this->input->post('session_id');
		$class_id = (int) $this->input->post('class_id');
		$tuitionFee = (int) $this->input->post('tuitionFee');
		//remove all data of on schools is for class 
		$query = "DELETE FROM fee 
		          WHERE school_id ='" . $school_id . "' 
				AND class_id ='" . $class_id . "'";
		$this->db->query($query);


		$input['school_id'] = $school_id;
		$input['class_id'] = $class_id;
		$input['addmissionFee'] = 0;
		$input['tuitionFee'] = (int) $tuitionFee;
		$input['securityFund'] = 0;
		$input['otherFund'] = 0;
		$this->db->insert('fee', $input);
		redirect("operation/section_e/" . $schools_id . "/" . $school_id . "/" . $session_id);
	}
}
