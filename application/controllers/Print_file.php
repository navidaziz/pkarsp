<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_file extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
	}
	public function  school_session_detail($school_id)
	{
		$school_id = (int) $school_id;
		$this->data['school_id'] = $school_id;
		$this->data['school'] = $this->school_m->explore_schools_by_school_id_m($school_id);
		$this->data['school_bank'] = $this->school_m->get_bank_by_school_id($school_id);

		$this->data['school_physical_facilities'] = $this->school_m->physical_facilities_by_school_id($school_id);

		$this->data['school_physical_facilities_physical'] = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$this->data['school_physical_facilities_academic'] = $this->school_m->physical_facilities_academic_by_school_id($school_id);
		$this->data['school_physical_facilities_co_curricular'] = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$this->data['school_physical_facilities_other'] = $this->school_m->physical_facilities_other_by_school_id($school_id);
		$this->data['school_library'] = $this->school_m->get_library_books_by_school_id($school_id);


		$this->data['age_and_class'] = $this->school_m->get_age_and_class_by_school_id($school_id);
		// $school_bank = $this->school_m->get_bank_by_school_id($school_id);

		$this->data['school_staff'] = $this->school_m->staff_by_school_id($school_id);

		$this->data['school_fee'] = $this->school_m->fee_by_school_id($school_id);
		$this->data['school_fee_mentioned_in_form'] = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		//var_dump($this->data['school_fee_mentioned_in_form']);exit;

		$this->data['school_security_measures'] = $this->school_m->security_measures_by_school_id($school_id);

		$this->data['school_hazards_with_associated_risks'] = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		$this->data['hazards_with_associated_risks_unsafe_list'] = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);

		$this->data['school_fee_concession'] = $this->school_m->fee_concession_by_school_id($school_id);
		$this->data['schoolId'] = $school_id;
		$this->data['title'] = 'school details';
		$query = $this->db->query("SELECT * FROM bank_transaction where school_id = '" . $school_id . "'");
		$this->data['bank_transaction'] = $query->result_array();

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section B (Physical Facilities)';

		$this->load->view('print/school_session_detail', $this->data);
	}

	public function certificate()
	{

		$school_id = (int) $this->input->post('school_id');


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
                  WHERE  `school`.`status`=1 
						AND school.schoolId = '" . $school_id . "'";

		$school_info = $this->db->query($query)->row();

		$query1 = "SELECT MIN(`age_and_class`.`class_id`),
		(select classTitle from class where classId= MIN(`age_and_class`.`class_id`)) as classTitle
		FROM
		`age_and_class`
		INNER JOIN `class` 
		ON (`age_and_class`.`class_id` = `class`.`classId`)
		WHERE `age_and_class`.`school_id` =" . $school_info->schoolId . ";";
		$this->data['schools_info'] = $school_info;
		$this->data['lower_class'] = $this->db->query($query1)->row();

		$this->load->view('print/certificate_of_school', $this->data);
	}

	// public function certificate($schools_id, $school_id, $session_id)
	// {
	// 	$schools_id = (int) $schools_id;
	// 	$school_id = (int) $school_id;
	// 	$session_id = (int) $session_id;

	// 	$query = "SELECT
	//               `school`.`schoolId`
	//               ,`school`.`updatedDate`
	//               , `schools`.`registrationNumber`
	//               , `schools`.`schoolName`
	//               , `schools`.`district_id`
	//               , `district`.`districtTitle`
	//               , `district`.`bise`
	//               , `schools`.`gender_type_id`
	//               , `genderofschool`.`genderOfSchoolTitle`
	//               , `levelofinstitute`.`levelofInstituteTitle`
	//               , `levelofinstitute`.`upper_class`
	//               , `schools`.`biseregistrationNumber`
	//               ,`session_year`.`sessionYearTitle`
	//             ,`tehsils`.`tehsilTitle`
	//           FROM
	//               `schools`
	// 			  INNER JOIN `district` 
	//                   ON (`schools`.`district_id` = `district`.`districtId`)
	// 			 INNER JOIN `tehsils` 
	//                   ON (`schools`.`tehsil_id` = `tehsils`.`tehsilId`)
	// 			 INNER JOIN `school` 
	//                   ON (`schools`.`schoolId` = `school`.`schools_id`)
	//               INNER JOIN `genderofschool` 
	//                   ON (`school`.`gender_type_id` = `genderofschool`.`genderOfSchoolId`)
	//               INNER JOIN `levelofinstitute` 
	//                   ON (`school`.`level_of_school_id` = `levelofinstitute`.`levelofInstituteId`)
	//               INNER JOIN `session_year` 
	//                   ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
	//               WHERE `schools`.`schoolId` = '" . $schools_id . "' 
	// 			        AND `school`.`status`=1 
	// 					AND school.schoolId = '" . $school_id . "'
	// 					AND `school`.`session_year_id` = '" . $session_id . "'";

	// 	$school_info = $this->db->query($query)->row();

	// 	$query1 = "SELECT

	//               MIN(`age_and_class`.`class_id`)

	//               ,(select classTitle from class where classId= MIN(`age_and_class`.`class_id`)) as classTitle


	//           FROM
	//               `age_and_class`




	//                   INNER JOIN `class` 
	//                   ON (`age_and_class`.`class_id` = `class`.`classId`)
	//                 WHERE `age_and_class`.`school_id` =" . $school_info->schoolId . ";";
	// 	$this->data['schools_info'] = $school_info;
	// 	$this->data['lower_class'] = $this->db->query($query1)->row();

	// 	$this->load->view('print/certificate_of_schools', $this->data);
	// }

	public function print_change_of_name_bank_challan()
	{

		$userId = $this->session->userdata('userId');

		$query = "SELECT
		`schools`.`schoolId`
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools`
			WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $this->db->query($query)->result()[0];
		$this->load->view('print/change_of_name_bank_challan_print', $this->data);
	}

	public function penalty_change_of_name_bank_challan()
	{

		$userId = $this->session->userdata('userId');

		$query = "SELECT
		`schools`.`schoolId`
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools`
			WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $this->db->query($query)->result()[0];
		$this->load->view('print/penalty_bank_challan_print', $this->data);
	}

	public function print_change_of_building_bank_challan()
	{

		$userId = $this->session->userdata('userId');

		$query = "SELECT
		`schools`.`schoolId`
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools`
			WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $this->db->query($query)->result()[0];
		$this->load->view('print/change_of_building_bank_challan_print', $this->data);
	}


	public function print_change_of_ownership_bank_challan()
	{

		$userId = $this->session->userdata('userId');

		$query = "SELECT
		`schools`.`schoolId`
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools`
			WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $this->db->query($query)->result()[0];
		$this->load->view('print/change_of_ownership_bank_challan_print', $this->data);
	}

	public function print_change_of_applicant_certificate_bank_challan()
	{

		$userId = $this->session->userdata('userId');

		$query = "SELECT
		`schools`.`schoolId`
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools`
			WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $this->db->query($query)->result()[0];
		$this->load->view('print/applicant_certificate_bank_challan_print', $this->data);
	}


	// private function school_detail($school_session_id)
	// {
	// 	$userId = $this->session->userdata('userId');
	// 	$query = "SELECT 
	// 				`school`.`schoolId` AS `school_id`
	// 				, `schools`.`schoolId` AS `schools_id`
	// 				, `school`.`session_year_id` as `session_id`
	// 				, `schools`.`registrationNumber`
	// 				, `schools`.`schoolName`
	// 				, `schools`.`yearOfEstiblishment`
	// 				, `schools`.`school_type_id`
	// 				, `schools`.`level_of_school_id`
	// 				, `schools`.`gender_type_id` 
	// 				, `school`.`reg_type_id`
	// 			FROM
	// 				`schools`
	// 				INNER JOIN `school` 
	// 					ON (`schools`.`schoolId` = `school`.`schools_id`)
	// 					WHERE `school`.`schoolId`='" . $school_session_id . "'
	// 					AND `schools`.`owner_id`='" . $userId . "'";
	// 	return $this->db->query($query)->result()[0];
	// }
	// private function schooldetail($schools_id)
	// {
	// 	$query = "SELECT 
	// 				`school`.`schoolId` AS `school_id`
	// 				, `schools`.`schoolId` AS `schools_id`
	// 				, `school`.`session_year_id` as `session_id`
	// 				, `schools`.`registrationNumber`
	// 				, `schools`.`schoolName`
	// 				, `schools`.`yearOfEstiblishment`
	// 				, `schools`.`school_type_id`
	// 				, `schools`.`level_of_school_id`
	// 				, `schools`.`gender_type_id` 
	// 				, `school`.`reg_type_id`
	// 			FROM
	// 				`schools`
	// 				INNER JOIN `school` 
	// 					ON (`schools`.`schoolId` = `school`.`schools_id`)
	// 					WHERE `schools`.`schoolId`='" . $schools_id . "'";
	// 	return $this->db->query($query)->result()[0];
	// }

	private function registaion_type($type_id)
	{
		if ($type_id == 1) {
			return 'Registration';
		}
		if ($type_id == 2) {
			return 'Renewal';
		}
		if ($type_id == 3) {
			return 'Up-Gradation';
		}
		if ($type_id == 4) {
			return 'Up-Gradation And Renewal';
		}
	}
}
