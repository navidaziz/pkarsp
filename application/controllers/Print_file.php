<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_file extends Admin_Controller
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
				  , `schools`.`schoolId` as schools_id
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
				, `school`.`new_certificate`
				, DATE(`school`.`cer_issue_date`) as cer_issue_date
				, `reg_type`.`regTypeTitle`
				, `schools`.`address`
				, school.school_type_id
				, `school`.`level_of_school_id`
				, `school`.`primary`
				, `school`.`middle`
				, `school`.`high`
				, `school`.`high_sec`
				, `school`.`status`
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
				INNER JOIN `reg_type` ON(`reg_type`.`regTypeId` = school.reg_type_id)	  
                  WHERE  school.schoolId = '" . $school_id . "'";

		$school_info = $this->db->query($query)->row();
		if ($school_info) {
			if ($school_info->status == 1) {
				if ($school_info->cer_issue_date >= '2019-10-08') {
					$this->data['schools_info'] = $school_info;
					if ($school_info->new_certificate == 0) {
						$query1 = "SELECT MIN(`age_and_class`.`class_id`),
					(select classTitle from class where classId= MIN(`age_and_class`.`class_id`)) as classTitle
					FROM
					`age_and_class`
					INNER JOIN `class` 
					ON (`age_and_class`.`class_id` = `class`.`classId`)
					WHERE `age_and_class`.`school_id` =" . $school_info->schoolId . ";";

						$this->data['lower_class'] = $this->db->query($query1)->row();
						$this->load->view('print/certificate_of_school', $this->data);
					}
					if ($school_info->new_certificate == 1) {
						$this->load->view('print/new_certificate_of_school', $this->data);
					}
				} else {
					$this->data['message_title'] = 'Certificate Not Found';
					$this->data['message'] = 'It appears that the certificate is not available online, and there is a possibility that it needs to be manually addressed as a certificate issue.';
					$this->load->view('errors/html/certificate_not_found', $this->data);
				}
			} else {
				$this->data['message_title'] = 'Certificate Not Found';
				$this->data['message'] = 'Certificate not found, it could mean that the institute has not applied for it yet or the case is still in process and has not been completed. Once the process is complete, you will receive your certificate.';
				$this->load->view('errors/html/certificate_not_found', $this->data);
			}
		} else {
			$this->data['message_title'] = 'Certificate Not Found';
			$this->data['message'] = 'Error in Institute ID try again with valid institute ID.';
			$this->load->view('errors/html/certificate_not_found', $this->data);
		}
	}

	public function security_slip($level_type, $school_id = NULL)
	{
		$this->data['level_type'] = (int) $level_type;
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Security';
		$this->load->view('print/security_slip', $this->data);
	}
	public function upgradation_security_slip($school_id = NULL)
	{
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Security';
		$this->load->view('print/upgradation_security_slip', $this->data);
	}


	public function print_change_of_name_bank_challan($level_type, $school_id = NULL)
	{
		$this->data['level_type'] = (int) $level_type;
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Change of Name';
		$this->load->view('print/change_of_name_bank_challan_print', $this->data);
	}

	// public function penalty_change_of_name_bank_challan($school_id = NULL)
	// {
	// 	$this->data['school'] = $this->get_school_info($school_id);
	// 	$this->load->view('print/penalty_bank_challan_print', $this->data);
	// }

	public function print_change_of_building_bank_challan($level_type, $school_id = NUll)
	{
		$this->data['level_type'] = (int) $level_type;
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Change of Building or Location';
		$this->load->view('print/change_of_building_bank_challan_print', $this->data);
	}


	public function print_change_of_ownership_bank_challan($level_type, $school_id = NUll)
	{
		$this->data['level_type'] = (int) $level_type;
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Change of Ownership';
		$this->load->view('print/change_of_ownership_bank_challan_print', $this->data);
	}

	public function applicant_certificate_slip($school_id = NULL)
	{
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Applicant Certificate';
		$this->load->view('print/applicant_slip', $this->data);
	}
	public function fine_slip($school_id = NULL)
	{
		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'Fine';
		$this->load->view('print/fine_slip', $this->data);
	}
	public function general_blank_challan($school_id = NULL)
	{

		$this->data['school'] = $this->get_school_info($school_id);
		$this->data['title'] = 'PSRA Bank';
		$this->load->view('print/general_blank_challan', $this->data);
	}


	public function  section_e($school_id)
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

		$this->load->view('print/section_e', $this->data);
	}

	public function all_section_e($schools_id)
	{
		$schools_id = (int) $schools_id;
		$this->data['schools_id'] = $schools_id;
		$this->load->view('print/all_section_e', $this->data);
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

	private function get_school_info($school_id)
	{
		$query = "SELECT
		`schools`.`schoolId` as schools_id
		, `schools`.`registrationNumber`
		, `schools`.`schoolName`
		, `schools`.`district_id`
		, (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.`schoolId` AND status=1 ORDER BY school.schoolId DESC LIMIT 1) as level_of_school_id
		FROM
			`schools` ";
		if ($school_id) {
			$school_id = (int) $school_id;
			$query .= " WHERE `schools`.`schoolId`='" . $school_id . "'";
		} else {
			$userId = $this->session->userdata('userId');
			$query .= "  WHERE `schools`.`owner_id`='" . $userId . "'";
		}

		$school = $this->db->query($query)->row();
		if ($school) {
			return  $school;
		} else {
			return NULL;
		}
	}
}
