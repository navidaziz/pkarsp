<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forwarded_requests extends MY_Controller
{

	public function index()
	{
		$this->data['title'] = 'Forwarded Requests';
		$this->data['description'] = 'List of All Forwarded Requests';
		$this->data['view'] = 'forwarded_requests/forwarded_requests';
		$this->load->view('layout', $this->data);
	}

	public function get_request_detail()
	{
		$this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
		$this->data['session_id'] = $session_id = (int) $this->input->post('session_id');
		$this->data['comment_id'] = $comment_id = (int) $this->input->post('comment_id');

		$query = "SELECT `school`.*,
		`reg_type`.`regTypeTitle`,
		`school_type`.`typeTitle`,
		`levelofinstitute`.`levelofInstituteTitle`,
		`session_year`.`sessionYearTitle`
	  FROM
		`reg_type`
		INNER JOIN `school`
		  ON (
			`reg_type`.`regTypeId` = `school`.`reg_type_id`
		  )
		INNER JOIN `school_type`
		  ON (
			`school_type`.`typeId` = `school`.`school_type_id`
		  )
		INNER JOIN `levelofinstitute`
		  ON (
			`levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
		  )
		INNER JOIN `session_year`
		  ON (
			`session_year`.`sessionYearId` = `school`.`session_year_id`
		  )
		  WHERE  `school`.`schoolId` = '" . $school_id . "'
		  AND `school`.`session_year_id` = '" . $session_id . "'";
		$session_request_detail = $this->db->query($query)->result()[0];
		$this->data['schools_id'] = $session_request_detail->schools_id;
		$this->data['school'] = $this->school_detail($session_request_detail->schools_id);
		$this->data['session_request_detail'] = $session_request_detail;

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



		$query = "SELECT * FROM `bank_challans` 
		          WHERE school_id = '" . $session_request_detail->schoolId . "'
				  AND session_id ='" . $session_id . "'
				  AND verified ='1' ";
		$this->data['bank_challans'] = $this->db->query($query)->result();

		$query = "SELECT `schoolStaffName`as `name`, MIN(DATE(`schoolStaffAppointmentDate`)) as appoinment_date 
		FROM `school_staff` WHERE school_id= '" . $school_id . "'";
		$this->data['first_appointment_staff'] = $this->db->query($query)->result()[0];




		$this->load->view('forwarded_requests/request_detail', $this->data);
	}


	private function get_forwarded_list($status, $title = NULL)
	{
		$userId = $this->session->userdata('userId');
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`reg_type`.`regTypeTitle`,
		`school`.`schoolId` as school_id,
		`comments`.`comment_id`
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`,
		`comments`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`schoolId` = `comments`.`school_id`
		AND `comments`.`mark_to` = '" . $userId . "'
		AND `comments`.`status` = '" . $status . "'
		AND `comments`.`deleted` = '0'
		";
		//AND `school`.`status`!= 1

		if ($title) {
			$this->data['title'] = $title;
		}

		$this->data['requests'] = $this->db->query($query)->result();

		$this->load->view('forwarded_requests/requests', $this->data);
	}

	public function get_new_requests()
	{

		$this->get_forwarded_list(0, 'New Forwared For Remarks');
	}
	public function after_remarks()
	{

		$this->get_forwarded_list(1, 'After Remarks');
	}




	public function add_comment()
	{
		$input['comment'] = trim($this->db->escape($this->input->post('comment')), "'");
		$input['session_id'] = (int) $this->input->post('session_id');
		$input['school_id'] = (int) $this->input->post('school_id');
		$input['schools_id'] = (int) $this->input->post('schools_id');
		$input['created_by'] = $this->session->userdata('userId');
		if ($this->input->post('comment_id')) {
			$input['reply_id'] = (int) $this->input->post('comment_id');
			$update['status'] = 1;
			$this->db->where('comment_id', $input['reply_id']);
			$this->db->update('comments', $update);
		}
		if ($this->input->post('mark_to')) {
			$input['mark_to'] = (int) $this->input->post('mark_to');
		}
		if ($this->db->insert('comments', $input)) {
			echo 1;
		} else {
			echo 0;
		}
	}



	public function get_comments()
	{

		$where['session_id'] = (int) $this->input->post('session_id');
		$where['school_id'] = (int) $this->input->post('school_id');
		$where['schools_id'] = (int) $this->input->post('schools_id');
		$where['deleted'] = 0;
		$this->db->where($where);
		$this->db->select('`comments`.*, `users`.`userTitle`, `roles`.`role_title`');
		$this->db->from('comments');
		$this->db->join('users', 'users.userId = comments.created_by');
		$this->db->join('roles', 'roles.role_id  = users.role_id');
		$query = $this->db->get();

		$this->data['school_id'] = (int) $this->input->post('school_id');
		$this->data['comments'] =  $query->result();
		$this->load->helper('my_functions_helper');
		$this->load->view('registration_section/comments', $this->data);
	}

	public function delete_comment()
	{
		$where['comment_id'] = (int) $this->input->post('comment_id');
		$where['created_by'] = $this->session->userdata('userId');
		$this->db->where($where);
		$input['deleted'] = 1;
		if ($this->db->update('comments', $input)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function tag_users()
	{

		$selected_users = $this->input->post('selected_users');
		$input['session_id'] = (int) $this->input->post('session_id');
		$input['school_id'] = (int) $this->input->post('school_id');
		$input['schools_id'] = (int) $this->input->post('schools_id');
		$input['created_by'] = $this->session->userdata('userId');
		//var_dump($input);
		$this->db->where($input);
		//$this->db->where_not_in('user_id', $selected_users);
		$this->db->delete('tagged_users');
		foreach ($selected_users as $selected_user) {
			$input['user_id'] = (int) $selected_user;
			$this->db->insert('tagged_users', $input);
		}
		echo 1;
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
