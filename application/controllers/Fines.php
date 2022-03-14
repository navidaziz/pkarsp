<?php
defined('BASEPATH') or exit('No direct script access allowed');

//class Fines extends Admin_Controller
class Fines extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Fine Mangement System';
		$this->data['description'] = 'Fine Management System';
		$this->data['view'] = 'fines/fined_school_list';
		$this->load->view('layout', $this->data);
	}

	public function add_fine()
	{
		$school_fine_history = array(
			'school_id' => (int) $this->input->post('schools_id'),
			'fine_category' => $this->input->post('fine_category'),
			'fine_amount' => $this->input->post('amount'),
			'remarks' => $this->input->post('remarks'),
			'created_by' => $this->session->userdata('userId'),
			'file_number' => $this->input->post('file_number'),
			'file_date' => $this->input->post('file_date')
		);
		if ($this->db->insert('school_fine_history', $school_fine_history)) {
			$where['schoolId'] = (int) $this->input->post('schools_id');
			$this->db->where($where);
			$is_fine['isfined'] = 1;
			$this->db->update('schools', $is_fine);
			echo 1;
		} else {
			echo 0;
		}
	}

	public function delete_fine()
	{
		$where['school_id'] = (int) $this->input->post('schools_id');
		$where['history_id'] = (int) $this->input->post('history_id');
		$this->db->where($where);
		$status['is_deleted'] = 1;
		if ($this->db->update('school_fine_history', $status)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function delete_fine_payment()
	{
		$where['school_id'] = (int) $this->input->post('schools_id');
		$where['fine_id'] = (int) $this->input->post('history_id');
		$where['fine_payment_id'] = (int) $this->input->post('fine_payment_id');
		$this->db->where($where);
		$status['is_deleted'] = 1;
		if ($this->db->update('fine_payments', $status)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function add_fine_payment()
	{

		$input['school_id'] = (int) $this->input->post('schools_id');
		$input['fine_id'] = (int) $this->input->post('history_id');
		$input['stan_no'] = (int) $this->input->post('stan_no');
		$input['deposit_date'] = $this->input->post('deposit_date');
		$input['deposit_amount'] = (int) $this->input->post('deposit_amount');
		$input['created_by'] = $this->session->userdata('userId');
		if ($this->db->insert('fine_payments', $input)) {

			echo 1;
		} else {
			echo 0;
		}
	}


	public function view_school_detail()
	{


		$this->data['schools_id'] = $school_id = (int) $this->input->post('schools_id');


		$this->data['school'] = $this->school_detail($school_id);


		$this->load->view('fines/school_detail', $this->data);
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
        ON (`schools`.`district_id` = `district`.`districtId`) 
		WHERE `schools`.registrationNumber > 0
		";

		if ($search_by == 'school_id') {
			$searchBy = 'School ID';
			$query .= " AND `schools`.`schoolId` = " . $schoolid . " ";
		}

		if ($search_by == 'reg_no') {
			$searchBy = 'Reg. ID';
			$query .= " AND `schools`.`registrationNumber` = " . $reg_no . " ";
		}

		if ($search_by == 'school_name') {
			$searchBy = 'School Name';
			$query .= " AND `schools`.`schoolName` LIKE " . $school_name . " ";
		}

		if ($district_id) {
			$query .= " AND schools.district_id = '" . $district_id . "' ";
		}
		$query .= " ORDER BY schools.schoolName ASC LIMIT 30 ";
		$this->data['search_list'] = $this->db->query($query)->result();
		$title = "<small>" . count($this->data['search_list']) . " Records found <i class=\"fa fa-close\" onclick=\"$('#search_result').html('');\"></i> <span class=\"pull-right\"> <i class=\"fa fa-filter\" aria-hidden=\"true\"></i> " . $district_name . " - " . $searchBy . "</span></small>";
		$this->data['title'] = $title;

		$this->load->view('fines/search_list', $this->data);
	}
}
