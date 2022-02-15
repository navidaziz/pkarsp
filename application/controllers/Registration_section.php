<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration_section extends Admin_Controller
{

	public function index()
	{
		$this->data['title'] = 'Registration Section';
		$this->data['description'] = 'List of All Requests';
		$this->data['view'] = 'registration_section/request_list';
		$this->load->view('layout', $this->data);
	}

	public function inspections()
	{
		$this->data['title'] = 'Inspections';
		$this->data['description'] = 'List of All Inspections';
		$this->data['view'] = 'registration_section/inspections';
		$this->load->view('layout', $this->data);
	}

	private function get_request_list($status, $request_type = NULL, $title = NULL)
	{
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

		(SELECT s.status
		FROM school as s WHERE 
		 s.schools_id = `schools`.`schoolId`
		AND  s.session_year_id = (`school`.`session_year_id`-1)) as previous_session_status

		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`
		
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`status`= '" . $status . "'";
		if ($request_type) {
			$query .= "AND `school`.`reg_type_id`= $request_type";
		}


		if ($title) {
			$this->data['title'] = $status . " - " . $title;
		}

		$query .= " ORDER BY `school`.`created_date` ASC,  `school`.`schools_id`, `school`.`session_year_id` ASC ";

		$this->data['requests'] = $this->db->query($query)->result();

		$this->load->view('registration_section/requests', $this->data);
	}

	public function get_new_requests()
	{

		$this->get_request_list(3, 1, 'New Registration');
		$this->get_request_list(3, 2, 'New Renewal');
		$this->get_request_list(3, 4, 'New Renewal-Upgradation');
		$this->get_request_list(3, 3, 'Upgradation');
	}

	public function new_inspection_requests()
	{
		$this->get_request_list(4, NULL, 'New Inspection');
	}
	public function awating_inspection_requests()
	{
		$this->get_request_list(5, NULL, 'Inspection Inprogress');
	}
	public function completed_inspection_requests()
	{
		$this->get_request_list(6, NULL, 'Inspection Completed');
	}
	public function completed_requests()
	{
		//$this->get_request_list(1, NULL, 'Completed Requests');
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

		$selected_levels = $this->input->post('reg_levels');
		$school_level = array();
		$school_level['primary_level'] = NULL;
		$school_level['middle_level'] = NULL;
		$school_level['high_level'] = NULL;
		$school_level['h_sec_college_level'] = NULL;
		foreach ($selected_levels as $levels_id) {
			if ($levels_id == 1) {
				$school_level['primary_level'] = 1;
			}
			if ($levels_id == 2) {
				$school_level['middle_level'] = 1;
			}
			if ($levels_id == 3) {
				$school_level['high_level'] = 1;
			}
			if ($levels_id == 4) {
				$school_level['h_sec_college_level'] = 1;
			}
		}

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
					'updatedBy' => $this->session->userdata('userId'),
					'level_of_school_id' => max($selected_levels)
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

				if ($school_level) {
					// Upgrade school date....
					$this->db->where('schoolId', $schools_id);
					$this->db->update('schools', $school_level);
				}

				$reponse['status'] = 1;
				$message = "<h2 class='text-center'><strong class='text text-success'>Successfully Alloted Registration Number \" $codeCombined \" .</strong></h2>";

				$reponse['message'] = $message;
			}
		} else {
			$reponse['status'] = 0;
			$reponse['message'] = "Sorry! Account password incorrect.";
		}
		echo json_encode($reponse);
	}

	public function grant_renewal()
	{


		$account_password = $this->input->post('account_password');
		$schools_id = (int) $this->input->post('schools_id');
		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');

		$query = "SELECT school.session_year_id, 
		school.status, 
		session_year.sessionYearTitle 
		FROM school, session_year 
		WHERE 
		school.session_year_id = session_year.sessionYearId
		AND schools_id = '" . $schools_id . "' 
		AND  session_year_id = '" . ($session_id - 1) . "'";
		$previous_session = $this->db->query($query)->result()[0];

		if ($previous_session->status != 1) {
			$reponse['status'] = 0;
			$reponse['message'] = "<span style=\"color:red\">Renewal can not granted because previous session " . $previous_session->sessionYearTitle . " Renewal Pending.</span>";
			echo json_encode($reponse);
			exit();
		}

		$query = "SELECT school.session_year_id, 
		school.status, 
		session_year.sessionYearTitle 
		FROM school, session_year 
		WHERE 
		school.session_year_id = session_year.sessionYearId
		AND schools_id = '" . $schools_id . "' 
		AND  session_year_id = '" . ($session_id) . "'";
		$previous_session = $this->db->query($query)->result()[0];

		if ($previous_session->status != 3) {
			$reponse['status'] = 0;
			$reponse['message'] = "<span style=\"color:red\">Renewal can not granted beacause the request status is " . $previous_session->status . "</span>";
			echo json_encode($reponse);
			exit();
		}


		$selected_levels = $this->input->post('renewal_levels');

		$school_level = array();
		$school_level['primary_level'] = NULL;
		$school_level['middle_level'] = NULL;
		$school_level['high_level'] = NULL;
		$school_level['h_sec_college_level'] = NULL;
		foreach ($selected_levels as $levels_id) {
			if ($levels_id == 1) {
				$school_level['primary_level'] = 1;
			}
			if ($levels_id == 2) {
				$school_level['middle_level'] = 1;
			}
			if ($levels_id == 3) {
				$school_level['high_level'] = 1;
			}
			if ($levels_id == 4) {
				$school_level['h_sec_college_level'] = 1;
			}
		}

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
					if ($school_level) {
						// update levels....
						$this->db->where('schoolId', $schools_id);
						$this->db->update('schools', $school_level);
					}
					$reponse['status'] = 1;
					$message = "<h2 class='text-center'><strong class='text text-success'>
					            Successfully Alloted Renewal Number \" $renewal_code \"</strong></h2>";
					$auto_comment = "Renewal granted with renewal No#  " . $renewal_code;
					$input = array();
					$input['comment'] = $auto_comment;
					$input['session_id'] = $session_id;
					$input['school_id'] = $school_id;
					$input['schools_id'] = $schools_id;
					$input['created_by'] = $this->session->userdata('userId');
					$this->db->insert('comments', $input);
					$reponse['message'] = $message;
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

	public function grant_renewal_and_upgrade()
	{

		//var_dump($_POST);
		//echo max($_POST['upgrade_levels']);


		$account_password = $this->input->post('account_password');
		$schools_id = (int) $this->input->post('schools_id');
		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');
		$upgrade = $this->input->post('upgrade');

		$selected_levels = array_merge((array) $_POST['renewal_levels'], (array) $_POST['upgrade_levels']);
		$school_level = array();
		$school_level['primary_level'] = NULL;
		$school_level['middle_level'] = NULL;
		$school_level['high_level'] = NULL;
		$school_level['h_sec_college_level'] = NULL;
		foreach ($selected_levels as $levels_id) {
			if ($levels_id == 1) {
				$school_level['primary_level'] = 1;
			}
			if ($levels_id == 2) {
				$school_level['middle_level'] = 1;
			}
			if ($levels_id == 3) {
				$school_level['high_level'] = 1;
			}
			if ($levels_id == 4) {
				$school_level['h_sec_college_level'] = 1;
			}
		}



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

				if ($upgrade == 'Yes') {
					$update_data['level_of_school_id'] = max($selected_levels);
					$update_data['upgrade'] = 1;
				}
				$this->db->where('schoolId', $school_id);
				if ($this->db->update('school', $update_data)) {

					if ($school_level) {
						// Upgrade school date....
						$this->db->where('schoolId', $schools_id);
						$this->db->update('schools', $school_level);
					}

					$reponse['status'] = 1;
					$message = "<h2 class='text-center'><strong class='text text-success'>Successfully Alloted Renewal Number \" $renewal_code \"</strong></h2>
					";
					$reponse['message'] = $message;
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

	public function grant_upgradation()
	{

		//var_dump($_POST);
		//echo max($_POST['upgrade_levels']);


		$account_password = $this->input->post('account_password');
		$schools_id = (int) $this->input->post('schools_id');
		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');
		$upgrade = $this->input->post('upgrade');

		$selected_levels = array_merge((array) $_POST['renewal_levels'], (array) $_POST['upgrade_levels']);
		$school_level = array();
		$school_level['primary_level'] = NULL;
		$school_level['middle_level'] = NULL;
		$school_level['high_level'] = NULL;
		$school_level['h_sec_college_level'] = NULL;
		foreach ($selected_levels as $levels_id) {
			if ($levels_id == 1) {
				$school_level['primary_level'] = 1;
			}
			if ($levels_id == 2) {
				$school_level['middle_level'] = 1;
			}
			if ($levels_id == 3) {
				$school_level['high_level'] = 1;
			}
			if ($levels_id == 4) {
				$school_level['h_sec_college_level'] = 1;
			}
		}



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

				if ($upgrade == 'Yes') {
					$update_data['level_of_school_id'] = max($selected_levels);
					$update_data['upgrade'] = 1;
				} else {
					$update_data['upgrade'] = 0;
					$update_data['isRejected'] = 1;
				}
				$this->db->where('schoolId', $school_id);
				if ($this->db->update('school', $update_data)) {

					if ($school_level) {
						// Upgrade school date....
						$this->db->where('schoolId', $schools_id);
						$this->db->update('schools', $school_level);
					}

					$reponse['status'] = 1;
					$message = "<h2 class='text-center'><strong class='text text-success'>Successfully Alloted Upgradaiton Number \" $renewal_code \"</strong></h2>
					";
					$auto_comment = "Upgradaiton granted with Upgradaiton No#  " . $renewal_code;
					$input = array();
					$input['comment'] = $auto_comment;
					$input['session_id'] = $session_id;
					$input['school_id'] = $school_id;
					$input['schools_id'] = $schools_id;
					$input['created_by'] = $this->session->userdata('userId');
					$this->db->insert('comments', $input);
					$reponse['message'] = $message;
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
		// $query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee 
		// FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		// $this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



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

	public function forward_for_inspection()
	{
		$session_id = (int) $this->input->post('session_id');
		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');
		$this->db->where('schoolId', $school_id);
		$input['status'] = 4;
		$this->db->update('school', $input);
		$auto_comment = "Forwarded for inpection Assignment.";
		$input = array();
		$input['comment'] = $auto_comment;
		$input['session_id'] = $session_id;
		$input['school_id'] = $school_id;
		$input['schools_id'] = $schools_id;
		$input['created_by'] = $this->session->userdata('userId');
		$this->db->insert('comments', $input);
		redirect("registration_section/");
	}

	public function inspection_assignment()
	{
		$session_id = (int) $this->input->post('session_id');
		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');
		$inspection_by = (int) $this->input->post('inspection_by');
		$this->db->where('schoolId', $school_id);
		$input['status'] = 5;
		$input['inspection_by'] = $inspection_by;


		$this->db->update('school', $input);

		$query = "SELECT  `users`.`userId`, `users`.`userTitle`, `roles`.`role_title` 
		FROM
		`roles`
		INNER JOIN `users`
		ON ( `roles`.`role_id` = `users`.`role_id` )
		AND  `users`.`userId` !=$inspection_by;";
		$user = $this->db->query($query)->result()[0];
		$innspector_name = $user->userTitle . " - " . $user->role_title;
		$auto_comment = "Inspection Assign to " . $innspector_name;
		$input = array();
		$input['comment'] = $auto_comment;
		$input['session_id'] = $session_id;
		$input['school_id'] = $school_id;
		$input['schools_id'] = $schools_id;
		$input['created_by'] = $this->session->userdata('userId');
		$this->db->insert('comments', $input);
		redirect("registration_section/inspections");
	}

	public function submit_inspection_report()
	{
		$session_id = (int) $this->input->post('session_id');
		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');
		$inspection_report = $this->input->post('inspection_report');
		$this->db->where('schoolId', $school_id);
		$input['status'] = 6;
		$input['inspection'] = 1;
		$input['inspection_report'] = $inspection_report;
		$this->db->update('school', $input);

		$auto_comment = "Inspection Report: " . $inspection_report;
		$input = array();
		$input['comment'] = $auto_comment;
		$input['session_id'] = $session_id;
		$input['school_id'] = $school_id;
		$input['schools_id'] = $schools_id;
		$input['created_by'] = $this->session->userdata('userId');
		$this->db->insert('comments', $input);
		redirect("registration_section/inspections");
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
					LEFT JOIN `school_type`
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

	public function renewal_fee_sturucture()
	{


		$query = "SELECT * FROM `fee_structure`";
		$this->data['fee_structures'] = $this->db->query($query)->result();
		$this->load->view('forms/fee_structures/renewal_fee_sturucture', $this->data);
	}

	public function send_deficiency()
	{
		$session_id = (int) $this->input->post('session_id');
		$school_id = (int) $this->input->post('school_id');
		$schools_id = (int) $this->input->post('schools_id');

		$input["session_id"] = $session_id;
		$input["school_id"] = $school_id;
		$input["schools_id"] = $schools_id;

		$input["deficiency_title"] = $this->input->post("deficiency_title");
		$input["deficiency_detail"] = $this->input->post("deficiency_detail");

		$input["application_processing_fee"] = (float) $this->input->post("application_processing_fee");
		$input["renewal_fee"] = (float) $this->input->post("renewal_fee");
		$input["upgradation_fee"] = (float) $this->input->post("upgradation_fee");
		$input["inspection_fee"] = (float) $this->input->post("inspection_fee");
		$input["fine"] = (float) $this->input->post("fine");
		$input["security_fee"] = (float) $this->input->post("security_fee");
		$input["renewal_and_upgradation_fee"] = (float) $this->input->post("renewal_and_upgradation_fee");

		$input["late_fee"] = (float) $this->input->post("late_fee");
		$query = "SELECT `status` FROM `school` WHERE schoolId = '" . $school_id . "'";
		$last_status = $this->db->query($query)->result()[0]->status;
		$input['last_status'] = $last_status;

		$input["total_deposit_fee"] = (float) $this->input->post("total_deposit_fee");

		$query_result = $this->db->insert('deficiencies', $input);
		if ($query_result) {
			$where['schoolId'] = $school_id;
			$this->db->where($where);
			$update['status'] = '7';

			$update['deficiency'] = 1;
			$this->db->update('school', $update);
			redirect("registration_section/");
		}
	}
}
