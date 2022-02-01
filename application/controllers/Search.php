<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
	}

	public function search_detail()
	{
		$district_id = (int) $this->input->post('district_id');
		if ($district_id) {
			$district_name = $this->input->post('district_name');
		} else {
			$district_name = "All Districts";
		}
		$search_by = $this->input->post('search_by');
		$schoolid = $this->db->escape($this->input->post('search'));
		$reg_no = $this->db->escape($this->input->post('search'));
		$school_name = $this->db->escape("%" . $this->input->post('search') . "%");
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`district`.`districtTitle`
		FROM `schools` INNER JOIN `district` 
        ON (`schools`.`district_id` = `district`.`districtId`) ";

		if ($search_by == 'school_id') {
			$searchBy = 'School ID';
			$query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
		}

		if ($search_by == 'reg_no') {
			$searchBy = 'Reg. ID';
			$query .= " WHERE `schools`.`registrationNumber` = " . $reg_no . " ";
		}

		if ($search_by == 'school_name') {
			$searchBy = 'School Name';
			$query .= " WHERE `schools`.`schoolName` LIKE " . $school_name . " ";
		}

		if ($district_id) {
			$query .= " AND schools.district_id = '" . $district_id . "' ";
		}
		$query .= " ORDER BY schools.schoolName ASC LIMIT 30 ";
		$this->data['search_list'] = $this->db->query($query)->result();
		$title = "<small>" . count($this->data['search_list']) . " Records found <i class=\"fa fa-close\" onclick=\"$('#search_result').html('');\"></i> <span class=\"pull-right\"> <i class=\"fa fa-filter\" aria-hidden=\"true\"></i> " . $district_name . " - " . $searchBy . "</span></small>";
		$this->data['title'] = $title;

		$this->load->view('search/search_list', $this->data);
	}

	public function view_school_detail()
	{
		$this->data['schools_id'] = $school_id = (int) $this->input->post('schools_id');

		$this->data['school'] = $this->school_detail($school_id);


		$query = "SELECT MAX(tuitionFee) as max_tution_fee 
		 FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);
		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee 
		FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



		$query = "SELECT `schoolStaffName`as `name`, MIN(DATE(`schoolStaffAppointmentDate`)) as appoinment_date 
		FROM `school_staff` WHERE school_id= '" . $school_id . "'";
		$this->data['first_appointment_staff'] = $this->db->query($query)->result()[0];




		$this->load->view('search/school_detail', $this->data);
	}

	private function school_detail($schools_id)
	{
		$query = "SELECT
		            `schools`.`schoolId` as schools_id,
					`schools`.`schoolName`,
					`schools`.`registrationNumber`,
					`schools`.`yearOfEstiblishment`,
					`tehsils`.`tehsilTitle`,
					`district`.`division`,
					`schools`.`telePhoneNumber`,
					`schools`.`schoolMobileNumber`,
					`schools`.`principal_email`,
					`levelofinstitute`.`levelofInstituteTitle`,
					`genderofschool`.`genderOfSchoolTitle`,
					`users`.`userTitle`,
					`users`.`userEmail`,
					`users`.`cnic`,
					`users`.`contactNumber`,
					`schools`.`mediumOfInstruction`,
					`schools`.`biseRegister`,
					`schools`.`biseregistrationNumber`,
					`schools`.`primaryRegDate`,
					`schools`.`highRegDate`,
					`schools`.`interRegDate`,
					`schools`.`biseAffiliated`,
					`schools`.`bise_verified`,
					`schools`.`level_of_school_id`,
					`school_type`.`typeTitle`,
					`bise`.`biseName`,
					`district`.`districtTitle`,
					`uc`.`ucTitle`,
					`schools`.`primary_level`,
					`schools`.`middle_level`,
					`schools`.`high_level`,
					`schools`.`h_sec_college_level`
					FROM
					`district`
					INNER JOIN `schools`
						ON (
						`district`.`districtId` = `schools`.`district_id`
						)
					INNER JOIN `tehsils`
						ON (
						`tehsils`.`tehsilId` = `schools`.`tehsil_id`
						)
					INNER JOIN `levelofinstitute`
						ON (
						`levelofinstitute`.`levelofInstituteId` = `schools`.`level_of_school_id`
						)
					INNER JOIN `genderofschool`
						ON (
						`genderofschool`.`genderOfSchoolId` = `schools`.`gender_type_id`
						)
					INNER JOIN `school_type`
						ON (
						`schools`.`school_type_id` = `school_type`.`typeId`
						)
					INNER JOIN `users`
						ON (
						`users`.`userId` = `schools`.`owner_id`
						)
					LEFT JOIN `bise`
						ON (
						`schools`.`bise_id` = `bise`.`biseId`
						)
					LEFT JOIN `uc`
						ON (
						`uc`.`ucId` = `schools`.`uc_id`
						)	
					WHERE schools.schoolId = '" . $schools_id . "'
							";

		return $this->db->query($query)->result()[0];
	}
}
