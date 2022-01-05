<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_section extends MY_Controller
{

	public function index()
	{


		$this->data['title'] = 'Registration Section';
		$this->data['description'] = 'List of All Requests';
		$this->data['view'] = 'registration_section/request_list';
		$this->load->view('layout', $this->data);
	}

	public function get_new_requests()
	{
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`school`.`schoolId` as school_id
		FROM
		`school`,
		`schools`,
		`session_year`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`status`=3
		AND `school`.`reg_type_id`=1";
		$this->data['new_registrations'] = $this->db->query($query)->result();

		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`school`.`schoolId` as school_id
		FROM
		`school`,
		`schools`,
		`session_year`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`status`=3
		AND `school`.`reg_type_id`=2";
		$this->data['new_renewals'] = $this->db->query($query)->result();
		$this->load->view('registration_section/new_requests', $this->data);
	}

	public function completed_requests()
	{
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`school`.`schoolId` as school_id,
		`reg_type`.`regTypeTitle`
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`status`=1";
		$this->data['completed_requests'] = $this->db->query($query)->result();

		$this->load->view('registration_section/completed_requests', $this->data);
	}
	public function inspection_requests()
	{
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`school`.`schoolId` as school_id,
		`reg_type`.`regTypeTitle`
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`reg_type_id`=6";
		$this->data['completed_requests'] = $this->db->query($query)->result();

		$this->load->view('registration_section/inspection_requests', $this->data);
	}

	public function allot_registration_number()
	{
		$account_password = $this->input->post('account_password');
		$schools_id = (int) $this->input->post('schools_id');
		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');

		$this->db->where('userPassword', $account_password);
		$this->db->where('userId', $this->session->userdata('userId'));
		$user_detail = $this->db->get('users')->row();
		if ($user_detail) {

			date_default_timezone_set("Asia/Karachi");
			$dated = date("d-m-Y h:i:sa");

			$row = $this->db->where('schoolId', $schools_id)->get('schools')->row();

			$yearOfEstiblishment = $row->yearOfEstiblishment;
			$tehsil_id = $row->tehsil_id;
			$district_id = $row->district_id;

			$where = array('tehsilId' => $tehsil_id, 'district_id' => $district_id);


			$this->db->where($where);
			$autoIncreamentNumberRow = $this->db->get('registration_code')->result()[0];
			$registrationNumberIncreament = $autoIncreamentNumberRow->registrationNumberIncreament;

			$district_id_with_prefix_zero = sprintf("%02d", $district_id);
			$tehsil_id_with_prefix_zero = sprintf("%03d", $tehsil_id);
			$yearOfEstiblishment = substr($yearOfEstiblishment, 2);
			$codeCombined = $district_id_with_prefix_zero . $tehsil_id_with_prefix_zero . $registrationNumberIncreament . $yearOfEstiblishment;

			$data["district_id"] = $district_id;
			$data["tehsil_id"] = $tehsil_id;
			$data["school_id"] = $school_id;
			$data["codeCombined"] = $codeCombined;

			$update_data = array(
				'registrationNumber' => $codeCombined,
				'updatedDate' => $dated,
				'updatedBy' => $this->session->userdata('userId')
			);

			$this->db->where('schoolId', $schools_id);
			$this->db->update('schools', $update_data);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows) {


				$update_session_data = array(
					'status' => 1,
					'updatedDate' => $dated,
					'updatedBy' => $this->session->userdata('userId')
				);
				$this->db->where('schoolId', $school_id);
				$this->db->where('session_year_id', $session_id);
				$this->db->update('school', $update_session_data);
				$update_increament = array(
					'registrationNumberIncreament' => $registrationNumberIncreament + 1
				);
				$where1 = array('tehsilId' => $tehsil_id, 'district_id' => $district_id);
				$this->db->where($where1);
				$this->db->update('registration_code', $update_increament);
				$affected_rows = $this->db->affected_rows();

				echo "<h2 style='margin-top:150px; margin-bottom:70px;' class='text-center'><strong class='text text-success'>Successfully Alloted Registration Number \" $codeCombined \" .</strong></h2>";
				echo "<div class='row'><div class='col-md-offset-2 col-md-8' style='margin-bottom:35px;'>";
				echo "
					<input type='hidden' name='schools_id_for_message' id='schools_id_for_message' value='" . $school_session_id . "'></input>
	
	
					<button id='send_message' class='btn btn-primary'><i class='fa fa-envelope-o'></i> Send Registration Certificate</button><a class='btn btn-success btn-flat pull-right' onclick='(function(){ location.reload(); })
			  ();'>Close</a>";
				echo "</div></div>";
			}
		} else {
			echo "Sorry! Account password incorrect.";
		}
	}

	public function grant_renewal()
	{


		$account_password = $this->input->post('account_password');
		$schools_id = (int) $this->input->post('schools_id');
		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');

		$this->db->where('userPassword', $account_password);
		$this->db->where('userId', $this->session->userdata('userId'));
		$user_detail = $this->db->get('users')->row();
		if ($user_detail) {
			date_default_timezone_set("Asia/Karachi");
			$dated = date("Y-m-d h:i:sa");

			$renewal_code = "2-" . $school_id . "-" . $session_id;
			//echo $renewal_code;exit;
			$arr = array();
			if ($renewal_code != "") {
				$update_data = array(
					'renewal_code' => $renewal_code,
					'status' => 1,
					'updatedDate' => $dated,
					'updatedBy' => $this->session->userdata('userId')
				);

				$this->db->where('schoolId', $school_id);
				if ($this->db->update('school', $update_data)) {
					$reponse['status'] = 1;
					$reponse['message'] = "Renewal Successfully";
				} else {
					$reponse['status'] = 0;
					$reponse['message'] = "Sorry! Some thing went wrong try again.";
				}
			} else {
				$reponse['status'] = 0;
				$reponse['message'] = "Erro in renewal code creation, try again.";
			}
		} else {
			$reponse['status'] = 0;
			$reponse['message'] = "Sorry! Account password incorrect.";
		}

		echo json_encode($reponse);
	}
	public function get_request_detail()
	{
		$this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
		$this->data['session_id'] = $session_id = (int) $this->input->post('session_id');

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




		$this->load->view('registration_section/request_detail', $this->data);
	}

	public function add_comment()
	{
		$input['comment'] = trim($this->db->escape($this->input->post('comment')), "'");
		$input['session_id'] = (int) $this->input->post('session_id');
		$input['school_id'] = (int) $this->input->post('school_id');
		$input['schools_id'] = (int) $this->input->post('schools_id');
		$input['created_by'] = $this->session->userdata('userId');
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
		$where['status'] = 1;
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
		$input['status'] = 0;
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
					`uc`.`ucTitle`
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
