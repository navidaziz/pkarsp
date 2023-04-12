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
		$search = $this->db->escape("%" . $this->input->post('search') . "%");
		if (trim($this->input->post('search')) == '') {
			$this->data['search_list'] = array();
		} else {
			$reg_un_reg = (int) $this->input->post('reg_un_reg');
			$level = (int) $this->input->post('level');


			$query = "SELECT
					`schools`.schoolId as schools_id,
					`schools`.schoolName,
					`schools`.registrationNumber,
					`schools`.`yearOfEstiblishment`,
					`schools`.`tehsil_id`,
					`schools`.`address`,
					`schools`.`uc_id`,
					`schools`.`uc_text`,
					`district`.`districtTitle`
					FROM `schools` INNER JOIN `district` 
					ON (`schools`.`district_id` = `district`.`districtId`) ";


			$searchBy = "Search filter by: ";
			if ($search) {
				if (is_numeric($this->input->post('search'))) {
					$leng = (int) strlen($this->input->post('search'));
					$search = $search = $this->db->escape($this->input->post('search'));
					if ($leng >= 6) {
						$query .= 'WHERE (`schools`.registrationNumber = ' . $search . ') ';
						$searchBy .= " Registration No: " . $this->input->post('search') . " / ";
					} else {
						$query .= 'WHERE (`schools`.`schoolId` = ' . $search . ') ';
						$searchBy .= " Institute ID: " . $this->input->post('search') . " / ";
					}
				} else {
					$query .= 'WHERE (`schools`.`schoolName` LIKE ' . $search . '
								OR REPLACE(schoolName, "_", " ") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "_", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "-", " ") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "-", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, ".", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, ".", " ") LIKE ' . $search . ') ';
					$searchBy .= " Name: " . $this->input->post('search') . " / ";
				}
			}

			if ($district_id) {
				$query .= " AND schools.district_id = '" . $district_id . "' ";
				$q = "SELECT districtTitle FROM district WHERE districtId = '" . $district_id . "'";
				$district_name = $this->db->query($q)->row()->districtTitle;
				$searchBy .= " District: " . $district_name . " / ";
			} else {
				$searchBy .= " District: All / ";
			}
			if ($reg_un_reg == 1) {
				$query .= " AND schools.registrationNumber >0  ";
				$searchBy .= " Registered institutes / ";
			}
			if ($reg_un_reg == 2) {
				$query .= " AND schools.registrationNumber <=0 ";
				$searchBy .= " Un-Registered institutes / ";
			}
			if ($reg_un_reg == 0) {
				$searchBy .= "Registered and Un-Registered / ";
			}

			if ($level > 0) {

				$query .= " HAVING (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.schoolId ORDER BY schoolId DESC LIMIT 1) = '" . $level . "' ";
				$q = "SELECT levelofInstituteTitle FROM levelofinstitute WHERE levelofInstituteId = '" . $level . "'";
				$levelofInstituteTitle = $this->db->query($q)->row()->levelofInstituteTitle;
				$searchBy .= " Level: " . $levelofInstituteTitle . "";
			} else {
				$searchBy .= "Levels: All";
			}


			$query .= " ORDER BY district.districtTitle, schools.schoolName ASC LIMIT 100 ";
			$this->data['search_list'] = $this->db->query($query)->result();
		}
		$title = "<small>" . count($this->data['search_list']) . " Records found  <span class=\"pull-right\"> <i class=\"fa fa-filter\" aria-hidden=\"true\"></i> " . $searchBy . " <i class=\"fa fa-close\" style='margin-left:10px; cursor: pointer;' onclick=\"$('#search_result').html('');\"></i></span> </small>";
		$this->data['title'] = $title;

		$this->load->view('search/search_list', $this->data);
	}

	public function view_school_detail()
	{


		$this->data['schools_id'] = $school_id = (int) $this->input->post('schools_id');

		$this->data['school'] = $this->school_detail($school_id);

		$query = "SELECT schoolId From school WHERE schools_id = '" . $school_id . "' ORDER BY schoolId DESC LIMIT 1";
		$school_id = $this->db->query($query)->result()[0]->schoolId;

		$query = "SELECT MAX(tuitionFee) as max_tution_fee 
		 FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);


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
					`schools`
					INNER JOIN `district`
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
					LEFT JOIN `school_type`
						ON (
						`schools`.`school_type_id` = `school_type`.`typeId`
						)
					LEFT JOIN `users`
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
