<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apply extends Admin_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
	}


	public function registration($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT * FROM schools WHERE `owner_id`='" . $userId . "'";
		$school = $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $school->schoolId;

		$query = "SELECT COUNT(*) AS total FROM school WHERE schools_id = '" . $school_id . "' AND session_year_id='" . $session_id . "'";

		if ($this->db->query($query)->result()[0]->total == 0) {
			$school_session = array(
				'school_name' => $school->schoolName,
				'district_id' => $school->district_id,
				'tehsil_id' => $school->tehsil_id,
				'uc_id' => $school->uc_id,
				'uc_text' => $school->uc_text,
				'address' => $school->address,
				'latitude' => $school->late,
				'longitude' => $school->longitude,
				'reg_type_id' => 1,
				'schools_id' => $school_id,
				'session_year_id' => $session_id,
				'level_of_school_id' => $school->level_of_school_id,
				'gender_type_id' => $school->gender_type_id,
				'school_type_id' => $school->school_type_id,
				'school_will_be_update_by_school_user' => 1,
				'updatedBy' => $this->session->userdata('userId')
			);
			// $new_session['school_name'] = $school->school_name;
			// $new_session['district_id'] = $school->district_id;
			// $new_session['tehsil_id'] = $school->tehsil_id;
			// $new_session['uc_id'] = $school->uc_id;
			// $new_session['uc_text'] = $school->uc_text;
			// $new_session['address'] = $school->address;
			// $new_session['latitude'] = $school->latitude;
			// $new_session['longitude'] = $school->longitude;
			// $new_session['primary'] = $school->primary;
			// $new_session['middle'] = $school->middle;
			// $new_session['high'] = $school->high;
			// $new_session['high_sec'] = $school->high_sec;
			$this->db->insert('school', $school_session);
			$school_new_session_id = $this->db->insert_id();

			$this->db->insert('forms_process', array(
				'user_id' => $school->owner_id,
				'reg_type_id' => $school->reg_type_id,
				'form_a_status' => 1,
				'school_id' => $school_new_session_id
			));

			redirect("form/section_b/$school_new_session_id");
		} else {
			$query = "SELECT schoolId FROM school 
			WHERE schools_id = '" . $school_id . "' 
			AND session_year_id='" . $session_id . "'";
			$school_new_session_id = $this->db->query($query)->row()->schoolId;

			redirect("form/section_b/$school_new_session_id");
		}
	}
	public function renewal($session_id, $session_school_id = NULL)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, 
		                 level_of_school_id, 
						 gender_type_id, 
						 school_type_id,
						 owner_id, 
						 reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->row();
		$schools_id = $school_detail->schoolId;

		// $query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' 
		//  AND status=1 ORDER BY `session_year_id` DESC";

		$query = "SELECT COUNT(*) as total, schoolId FROM school 
		        WHERE `schools_id` = '" . $schools_id . "'
				AND session_year_id = '" . $session_id . "'";
		$already_applied  = $this->db->query($query)->row();
		if ($already_applied->total) {
			$session_school_id = $already_applied->schoolId;
		}

		$query = "SELECT * FROM `school` 
		          WHERE `schools_id` = '" . $schools_id . "'
				  AND `session_year_id` = '" . ($session_id - 1) . "'
				  ORDER BY `session_year_id` DESC LIMIT 1";
		$last_session_detail = $this->db->query($query)->row();
		$school_id = $last_session_detail->schoolId;


		if (is_null($session_school_id)) {
			//insert new session...
			$new_session['schools_id'] = $schools_id;
			$new_session['reg_type_id'] = 2;
			$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
			//$new_session['gender_type_id'] = 0;
			$new_session['school_type_id'] = $last_session_detail->school_type_id;
			$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
			$new_session['session_year_id'] = $session_id;
			date_default_timezone_set("Asia/Karachi");
			$new_session['created_date'] = date('Y-m-d H:i:s', time());

			$new_session['school_name'] = $last_session_detail->school_name;
			$new_session['district_id'] = $last_session_detail->district_id;
			$new_session['tehsil_id'] = $last_session_detail->tehsil_id;
			$new_session['uc_id'] = $last_session_detail->uc_id;
			$new_session['uc_text'] = $last_session_detail->uc_text;
			$new_session['address'] = $last_session_detail->address;
			$new_session['latitude'] = $last_session_detail->latitude;
			$new_session['longitude'] = $last_session_detail->longitude;
			$new_session['primary'] = $last_session_detail->primary;
			$new_session['middle'] = $last_session_detail->middle;
			$new_session['high'] = $last_session_detail->high;
			$new_session['high_sec'] = $last_session_detail->high_sec;

			$this->db->insert('school', $new_session);
			$school_inserted_id = $this->db->insert_id();
			$this->db->insert('forms_process', array(
				'user_id' => $userId,
				'reg_type_id' => 2,
				'form_a_status' => 1,
				'school_id' => $school_inserted_id
			));

			$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));
		} else {
			$school_inserted_id = $session_school_id;
		}


		$process_previous_data = $this->process_previous_data($school_id, $school_inserted_id);

		if ($process_previous_data == FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("school_dashboard/index");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 2,
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_inserted_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("school_dashboard/index");
			}
		}
	}

	public function renewal_upgradation($session_id, $session_school_id = NULL)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, 
		                 level_of_school_id, 
						 gender_type_id, 
						 school_type_id,
						 owner_id, 
						 reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->row();
		$schools_id = $school_detail->schoolId;

		// $query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' 
		//  AND status=1 ORDER BY `session_year_id` DESC";

		$query = "SELECT COUNT(*) as total, schoolId FROM school 
		        WHERE `schools_id` = '" . $schools_id . "'
				AND session_year_id = '" . $session_id . "'";
		$already_applied  = $this->db->query($query)->row();
		if ($already_applied->total) {
			$session_school_id = $already_applied->schoolId;
		}

		$query = "SELECT * FROM `school` 
		          WHERE `schools_id` = '" . $schools_id . "'
				  AND `session_year_id` = '" . ($session_id - 1) . "'
				  ORDER BY `session_year_id` DESC LIMIT 1";
		$last_session_detail = $this->db->query($query)->row();
		$school_id = $last_session_detail->schoolId;


		if (is_null($session_school_id)) {
			//insert new session...
			$new_session['schools_id'] = $schools_id;
			$new_session['reg_type_id'] = 4;
			$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
			//$new_session['gender_type_id'] = 0;
			$new_session['school_type_id'] = $last_session_detail->school_type_id;
			$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
			$new_session['session_year_id'] = $session_id;
			date_default_timezone_set("Asia/Karachi");
			$new_session['created_date'] = date('Y-m-d H:i:s', time());

			$new_session['school_name'] = $last_session_detail->school_name;
			$new_session['district_id'] = $last_session_detail->district_id;
			$new_session['tehsil_id'] = $last_session_detail->tehsil_id;
			$new_session['uc_id'] = $last_session_detail->uc_id;
			$new_session['uc_text'] = $last_session_detail->uc_text;
			$new_session['address'] = $last_session_detail->address;
			$new_session['latitude'] = $last_session_detail->latitude;
			$new_session['longitude'] = $last_session_detail->longitude;
			$new_session['primary'] = $last_session_detail->primary;
			$new_session['middle'] = $last_session_detail->middle;
			$new_session['high'] = $last_session_detail->high;
			$new_session['high_sec'] = $last_session_detail->high_sec;


			$this->db->insert('school', $new_session);
			$school_inserted_id = $this->db->insert_id();
			$this->db->insert('forms_process', array(
				'user_id' => $userId,
				'reg_type_id' => 2,
				'form_a_status' => 1,
				'school_id' => $school_inserted_id
			));

			$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));
		} else {
			$school_inserted_id = $session_school_id;
		}


		$process_previous_data = $this->process_previous_data($school_id, $school_inserted_id);

		if ($process_previous_data == FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("school_dashboard/index");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 4,
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal +  upgradation, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_inserted_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("school_dashboard/index");
			}
		}
	}

	public function upgradation($session_id, $session_school_id = NULL)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, 
		                 level_of_school_id, 
						 gender_type_id, 
						 school_type_id,
						 owner_id, 
						 reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->row();
		$schools_id = $school_detail->schoolId;

		// $query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' 
		//  AND status=1 ORDER BY `session_year_id` DESC";

		$query = "SELECT COUNT(*) as total, schoolId FROM school 
		        WHERE `schools_id` = '" . $schools_id . "'
				AND session_year_id = '" . $session_id . "'
				AND reg_type_id = 3";
		$already_applied  = $this->db->query($query)->row();
		if ($already_applied->total) {
			$session_school_id = $already_applied->schoolId;
		}

		$query = "SELECT * FROM `school` 
		          WHERE `schools_id` = '" . $schools_id . "'
				  AND `session_year_id` = '" . ($session_id - 1) . "'
				  ORDER BY `session_year_id` DESC LIMIT 1";
		$last_session_detail = $this->db->query($query)->row();
		$school_id = $last_session_detail->schoolId;


		if (is_null($session_school_id)) {
			//insert new session...
			$new_session['schools_id'] = $schools_id;
			$new_session['reg_type_id'] = 4;
			//$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
			$new_session['gender_type_id'] = 0;
			$new_session['school_type_id'] = $last_session_detail->school_type_id;
			$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
			$new_session['session_year_id'] = $session_id;
			date_default_timezone_set("Asia/Karachi");
			$new_session['school_name'] = $last_session_detail->school_name;
			$new_session['district_id'] = $last_session_detail->district_id;
			$new_session['tehsil_id'] = $last_session_detail->tehsil_id;
			$new_session['uc_id'] = $last_session_detail->uc_id;
			$new_session['uc_text'] = $last_session_detail->uc_text;
			$new_session['address'] = $last_session_detail->address;
			$new_session['latitude'] = $last_session_detail->latitude;
			$new_session['longitude'] = $last_session_detail->longitude;
			$new_session['primary'] = $last_session_detail->primary;
			$new_session['middle'] = $last_session_detail->middle;
			$new_session['high'] = $last_session_detail->high;
			$new_session['high_sec'] = $last_session_detail->hig_sec;

			$new_session['created_date'] = date('Y-m-d H:i:s', time());
			$this->db->insert('school', $new_session);
			$school_inserted_id = $this->db->insert_id();
			$this->db->insert('forms_process', array(
				'user_id' => $userId,
				'reg_type_id' => 2,
				'form_a_status' => 1,
				'school_id' => $school_inserted_id
			));

			$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));
		} else {
			$school_inserted_id = $session_school_id;
		}


		$process_previous_data = $this->process_previous_data($school_id, $school_inserted_id);

		if ($process_previous_data == FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("school_dashboard/index");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 3,
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for Upgradation, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_inserted_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("school_dashboard/index");
			}
		}
	}

	/*
	public function upgradation($session_id)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, level_of_school_id, gender_type_id, school_type_id,owner_id, reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->result()[0];
		$schools_id = $school_detail->schoolId;

		$query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' AND status=1 ORDER BY `session_year_id` DESC";
		$last_session_detail = $this->db->query($query)->result()[0];

		//insert new session...
		$new_session['schools_id'] = $schools_id;
		$new_session['reg_type_id'] = 3;
		$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
		$new_session['school_type_id'] = $last_session_detail->school_type_id;
		$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
		$new_session['session_year_id'] = $session_id;
		date_default_timezone_set("Asia/Karachi");
		$dated = date("d-m-Y h:i:sa");
		$new_session['created_date'] = $dated;
		$this->db->insert('school', $new_session);


		$school_inserted_id = $this->db->insert_id();
		$school_id = $last_session_detail->schoolId;


		$this->db->insert('forms_process', array(
			'user_id' => $userId,
			'reg_type_id' => 3,
			'form_a_status' => 1,
			'school_id' => $school_inserted_id
		));

		$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));


		$this->db->trans_begin();
		$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();

		if (!empty($physical_facilities)) {
			$physical_facilities = $physical_facilities;
			$physical_facilities_array = array(
				'building_id' => $physical_facilities->building_id,
				'numberOfClassRoom' => $physical_facilities->numberOfClassRoom,
				'numberOfOtherRoom' => $physical_facilities->numberOfOtherRoom,
				'totalArea' => $physical_facilities->totalArea,
				'coveredArea' => $physical_facilities->coveredArea,
				'numberOfComputer' => $physical_facilities->numberOfComputer,
				'numberOfLatrines' => $physical_facilities->numberOfLatrines,
				'school_id' => $school_inserted_id
			);
			$this->db->insert('physical_facilities', $physical_facilities_array);
		}


		// get and insert as a batch insertion
		$school_physical_facilities_physical = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$school_physical_facilities_physical_array = array();
		foreach ($school_physical_facilities_physical as $spfp) {
			array_push(
				$school_physical_facilities_physical_array,
				array(
					'school_id' => $school_inserted_id,
					'pf_physical_id' => $spfp->pf_physical_id
				)
			);
		}
		if (!empty($school_physical_facilities_physical_array)) {
			$this->db->insert_batch('physical_facilities_physical', $school_physical_facilities_physical_array);
		}



		// get "physical_facilities_academic" table data and insert as batch
		$school_physical_facilities_academic = $this->school_m->physical_facilities_academic_by_school_id($school_id);
		$school_physical_facilities_academic_array = array();
		foreach ($school_physical_facilities_academic as $spfa) {
			array_push(
				$school_physical_facilities_academic_array,
				array(
					'school_id' => $school_inserted_id,
					'academic_id' => $spfa->academic_id
				)
			);
		}
		if (!empty($school_physical_facilities_academic_array)) {
			$this->db->insert_batch('physical_facilities_academic', $school_physical_facilities_academic_array);
		}

		//  get "physical_facilities_co_curricular" and insert wiht school_id
		$physical_facilities_co_curricular = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$physical_facilities_co_curricular_array = array();
		foreach ($physical_facilities_co_curricular as $pfcc) {
			array_push(
				$physical_facilities_co_curricular_array,
				array(
					'school_id' => $school_inserted_id,
					'co_curricular_id' => $pfcc->co_curricular_id
				)
			);
		}
		if (!empty($physical_facilities_co_curricular_array)) {
			$this->db->insert_batch('physical_facilities_co_curricular', $physical_facilities_co_curricular_array);
		}

		//  get "school_physical_facilities_other" and insert wiht school_id
		$physical_facilities_others =  $this->school_m->physical_facilities_other_by_school_id($school_id);
		$physical_facilities_others_array = array();
		foreach ($physical_facilities_others as $pfo) {
			array_push(
				$physical_facilities_others_array,
				array(
					'school_id' => $school_inserted_id,
					'other_id' => $pfo->other_id
				)
			);
		}
		if (!empty($physical_facilities_others_array)) {
			$this->db->insert_batch('physical_facilities_others', $physical_facilities_others_array);
		}

		//  get "school_physical_facilities_other"  and insert wiht school_id
		$school_library = $this->school_m->get_library_books_by_school_id($school_id);
		$school_library_array = array();
		foreach ($school_library as $sl) {
			array_push(
				$school_library_array,
				array(
					'school_id' => $school_inserted_id,
					'book_type_id' => $sl->book_type_id,
					'numberOfBooks' => $sl->numberOfBooks
				)
			);
		}
		if (!empty($school_library_array)) {
			$this->db->insert_batch('school_library', $school_library_array);
		}

		$school_staff = $this->school_m->staff_by_school_id($school_id);
		$school_staff_array = array();
		foreach ($school_staff as $ss) {
			array_push(
				$school_staff_array,
				array(
					'school_id' => $school_inserted_id,
					'schoolStaffName' => $ss->schoolStaffName,
					'schoolStaffFatherOrHusband' => $ss->schoolStaffFatherOrHusband,
					'schoolStaffCnic' => $ss->schoolStaffCnic,
					'schoolStaffQaulificationProfessional' => $ss->schoolStaffQaulificationProfessional,
					'schoolStaffQaulificationAcademic' => $ss->schoolStaffQaulificationAcademic,
					'schoolStaffAppointmentDate' => $ss->schoolStaffAppointmentDate,
					'schoolStaffDesignition' => $ss->schoolStaffDesignition,
					'schoolStaffNetPay' => $ss->schoolStaffNetPay,
					'schoolStaffAnnualIncreament' => $ss->schoolStaffAnnualIncreament,
					'schoolStaffType' => $ss->schoolStaffType,
					'schoolStaffGender' => $ss->schoolStaffGender,
					'TeacherTraining' => $ss->TeacherTraining,
					'TeacherExperience' => $ss->TeacherExperience
				)

			);
		}

		if (!empty($school_staff_array)) {
			$this->db->insert_batch('school_staff', $school_staff_array);
		}



		//get "fee"  and insert wiht school_id
		// $school_fee = $this->school_m->fee_by_school_id($school_id);
		// $school_fee_array = array();
		// foreach ($school_fee as $sf) {
		// 	array_push(
		// 		$school_fee_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'class_id' => $sf->class_id,
		// 			'addmissionFee' => $sf->addmissionFee,
		// 			'tuitionFee' => $sf->tuitionFee,
		// 			'otherFund' => $sf->otherFund,
		// 			'securityFund' => $sf->securityFund
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_array)) {
		// 	$this->db->insert_batch('fee', $school_fee_array);
		// }
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_d_status' => 1));

		//  get "fee_mentioned_in_form_or_prospectus"  and insert wiht school_id
		$school_fee_mentioned_in_form = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		if (!empty($school_fee_mentioned_in_form)) {
			$this->db->insert(
				'fee_mentioned_in_form_or_prospectus',
				array(
					'school_id' => $school_inserted_id,
					'feeMentionedInForm' => $school_fee_mentioned_in_form->feeMentionedInForm
				)
			);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_e_status' => 1));



		//  get "security_measures"  and insert wiht school_id
		$school_security_measures = $this->school_m->security_measures_by_school_id($school_id);
		if (!empty($school_security_measures)) {
			$school_security_measures_array = array(
				'school_id' => $school_inserted_id,
				'securityStatus' => $school_security_measures->securityStatus,
				'securityProvided' => $school_security_measures->securityProvided,
				'securityPersonnel' => $school_security_measures->securityPersonnel,
				'security_personnel_status_id' => $school_security_measures->security_personnel_status_id,
				'security_according_to_police_dept' => $school_security_measures->security_according_to_police_dept,
				'cameraInstallation' => $school_security_measures->cameraInstallation,
				'camraNumber' => $school_security_measures->camraNumber,
				'dvrMaintained' => $school_security_measures->dvrMaintained,
				'cameraOnline' => $school_security_measures->cameraOnline,
				'exitDoorsNumber' => $school_security_measures->exitDoorsNumber,
				'emergencyDoorsNumber' => $school_security_measures->emergencyDoorsNumber,
				'boundryWallHeight' => $school_security_measures->boundryWallHeight,
				'wiresProvided' => $school_security_measures->wiresProvided,
				'watchTower' => $school_security_measures->watchTower,
				'licensedWeapon' => $school_security_measures->licensedWeapon,
				'licenseNumber' => $school_security_measures->licenseNumber,
				'ammunitionStatus' => $school_security_measures->ammunitionStatus,
				'metalDetector' => $school_security_measures->metalDetector,
				'walkThroughGate' => $school_security_measures->walkThroughGate,
				'gateBarrier' => $school_security_measures->gateBarrier,
				'license_issued_by_id' => $school_security_measures->license_issued_by_id
			);
			$this->db->insert('security_measures', $school_security_measures_array);
			$this->db->insert_id();
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_f_status' => 1));


		//  get "security_measures"  and insert wiht school_id
		$school_hazards_with_associated_risks = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		if (!empty($school_hazards_with_associated_risks)) {
			$school_hazards_with_associated_risks_array = array(
				'school_id' => $school_inserted_id,
				'exposedToFlood' => $school_hazards_with_associated_risks->exposedToFlood,
				'drowning' => $school_hazards_with_associated_risks->drowning,
				'buildingCondition' => $school_hazards_with_associated_risks->buildingCondition,
				'accessRoute' => $school_hazards_with_associated_risks->accessRoute,
				'adjacentBuilding' => $school_hazards_with_associated_risks->adjacentBuilding,
				'safeAssemblyPointsAvailable' => $school_hazards_with_associated_risks->safeAssemblyPointsAvailable,
				'disasterTraining' => $school_hazards_with_associated_risks->disasterTraining,
				'schoolImprovementPlan' => $school_hazards_with_associated_risks->schoolImprovementPlan,
				'schoolDisasterManagementPlan' => $school_hazards_with_associated_risks->schoolDisasterManagementPlan,
				'electrification_condition_id' => $school_hazards_with_associated_risks->electrification_condition_id,
				'ventilationSystemAvailable' => $school_hazards_with_associated_risks->ventilationSystemAvailable,
				'chemicalsSchoolLaboratory' => $school_hazards_with_associated_risks->chemicalsSchoolLaboratory,
				'chemicalsSchoolSurrounding' => $school_hazards_with_associated_risks->chemicalsSchoolSurrounding,
				'roadAccident' => $school_hazards_with_associated_risks->roadAccident,
				'safeDrinkingWaterAvailable' => $school_hazards_with_associated_risks->safeDrinkingWaterAvailable,
				'sanitationFacilities' => $school_hazards_with_associated_risks->sanitationFacilities,
				'building_structure_id' => $school_hazards_with_associated_risks->building_structure_id,
				'school_surrounded_by_id' => $school_hazards_with_associated_risks->school_surrounded_by_id
			);
			$this->db->insert('hazards_with_associated_risks', $school_hazards_with_associated_risks_array);
			$this->db->insert_id();
		}
		//  get "hazards_with_associated_risks_unsafe_list"  and insert wiht school_id
		$hazards_with_associated_risks_unsafe_list = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);
		$hazards_with_associated_risks_unsafe_list_array = array();
		foreach ($hazards_with_associated_risks_unsafe_list as $hwaru) {
			array_push(
				$hazards_with_associated_risks_unsafe_list_array,
				array(
					'school_id' => $school_inserted_id,
					'unsafe_list_id' => $hwaru->unsafe_list_id
				)
			);
		}
		if (!empty($hazards_with_associated_risks_unsafe_list_array)) {
			$this->db->insert_batch('hazards_with_associated_risks_unsafe_list', $hazards_with_associated_risks_unsafe_list_array);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_g_status' => 1));

		//  get "school_fee_concession"  and insert wiht school_id
		// $school_fee_concession = $this->school_m->fee_concession_by_school_id($school_id);
		// $school_fee_concession_array = array();
		// foreach ($school_fee_concession as $sfc) {
		// 	array_push(
		// 		$school_fee_concession_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'concession_id' => $sfc->concession_id,
		// 			'percentage' => $sfc->percentage,
		// 			'numberOfStudent' => $sfc->numberOfStudent
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_concession_array)) {
		// 	$this->db->insert_batch('fee_concession', $school_fee_concession_array);
		// }
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("form/section_b/$school_inserted_id");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 3,
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_inserted_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_inserted_id");
			}
		}
	}
	*/

	private function process_previous_data($school_id, $school_inserted_id)
	{
		$this->db->trans_begin();

		// previous session physical facilities data ......
		$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();
		if ($physical_facilities) {
			$this->db->delete('physical_facilities', array('school_id' => $school_inserted_id));
			$physical_facilities->school_id = $school_inserted_id;
			$physical_facilities->physicalFacilityId = NULL;
			$this->db->insert('physical_facilities', $physical_facilities);
		}



		// previous session physical facilities academic others data ......
		$physical_facilities_physical = $this->db->where('school_id', $school_id)->get('physical_facilities_physical')->result();
		if ($physical_facilities_physical) {
			$this->db->delete('physical_facilities_physical', array('school_id' => $school_inserted_id));
			foreach ($physical_facilities_physical as $pfp) {
				$pfp->pfPhysicalId = NULL;
				$pfp->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('physical_facilities_physical', $physical_facilities_physical);
		}

		// previous session physical facilities academic others data ......
		$physical_facilities_academic = $this->db->where('school_id', $school_id)->get('physical_facilities_academic')->result();
		if ($physical_facilities_academic) {
			$this->db->delete('physical_facilities_academic', array('school_id' => $school_inserted_id));
			foreach ($physical_facilities_academic as $pfa) {
				$pfa->pfAcademicId = NULL;
				$pfa->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('physical_facilities_academic', $physical_facilities_academic);
		}

		// previous session physical facilities co curriclar others data ......
		$physical_facilities_co_curricular = $this->db->where('school_id', $school_id)->get('physical_facilities_co_curricular')->result();
		if ($physical_facilities_co_curricular) {
			$this->db->delete('physical_facilities_co_curricular', array('school_id' => $school_inserted_id));
			foreach ($physical_facilities_co_curricular as $pfcc) {
				$pfcc->pfCoCurricularId = NULL;
				$pfcc->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('physical_facilities_co_curricular', $physical_facilities_co_curricular);
		}


		// previous session physical facilities others data ......
		$physical_facilities_others = $this->db->where('school_id', $school_id)->get('physical_facilities_others')->result();
		if ($physical_facilities_others) {
			$this->db->delete('physical_facilities_others', array('school_id' => $school_inserted_id));
			foreach ($physical_facilities_others as $pfo) {
				$pfo->pfOtherId = NULL;
				$pfo->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('physical_facilities_others', $physical_facilities_others);
		}

		// previous session library data ......
		$school_library = $this->db->where('school_id', $school_id)->get('school_library')->result();
		if ($school_library) {
			$this->db->delete('school_library', array('school_id' => $school_inserted_id));
			foreach ($school_library as $books) {
				$books->schoolLibraryId = NULL;
				$books->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('school_library', $school_library);
		}

		// previous session staff data ......
		$school_staff = $this->db->where('school_id', $school_id)->get('school_staff')->result();
		if ($school_staff) {
			$this->db->delete('school_staff', array('school_id' => $school_inserted_id));
			foreach ($school_staff as $ss) {
				$ss->schoolStaffId = NULL;
				$ss->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('school_staff', $school_staff);
		}

		// previous session academy session ....
		$previous_session_academy_courses =  $this->db->where('school_id', $school_id)->get('academy_courses')->row();
		if ($previous_session_academy_courses) {
			$this->db->delete('academy_courses', array('school_id' => $school_inserted_id));
			$previous_session_academy_courses->school_id = $school_inserted_id;
			$previous_session_academy_courses->id = NULL;
			$this->db->insert('academy_courses', $previous_session_academy_courses);
		}

		// previous fee mention data  .....
		$fee_mention =  $this->db->where('school_id', $school_id)->get('fee_mentioned_in_form_or_prospectus')->row();
		if ($fee_mention) {
			$this->db->delete('fee_mentioned_in_form_or_prospectus', array('school_id' => $school_inserted_id));
			$fee_mention->school_id = $school_inserted_id;
			$fee_mention->feeMentionedInFormId = NULL;
			$this->db->insert('fee_mentioned_in_form_or_prospectus', $fee_mention);
		}


		$security_measures =  $this->db->where('school_id', $school_id)->get('security_measures')->row();
		if ($security_measures) {
			$this->db->delete('security_measures', array('school_id' => $school_inserted_id));
			$security_measures->school_id = $school_inserted_id;
			$security_measures->securityMeasureId = NULL;
			$this->db->insert('security_measures', $security_measures);
		}

		$hazards_with_associated_risks =  $this->db->where('school_id', $school_id)->get('hazards_with_associated_risks')->row();
		if ($hazards_with_associated_risks) {
			$this->db->delete('hazards_with_associated_risks', array('school_id' => $school_inserted_id));
			$hazards_with_associated_risks->school_id = $school_inserted_id;
			$hazards_with_associated_risks->hazardsWithAssociatedRisksId = NULL;
			$this->db->insert('hazards_with_associated_risks', $hazards_with_associated_risks);
		}

		//unsafe list.. need to remove wrong programing here ...
		$hazards_with_associated_risks_unsafe_list = $this->db->where('school_id', $school_id)->get('hazards_with_associated_risks_unsafe_list')->result();
		if ($hazards_with_associated_risks_unsafe_list) {
			$this->db->delete('hazards_with_associated_risks_unsafe_list', array('school_id' => $school_inserted_id));
			foreach ($hazards_with_associated_risks_unsafe_list as $unsafe_list) {
				$unsafe_list->unSafeId = NULL;
				$unsafe_list->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('hazards_with_associated_risks_unsafe_list', $hazards_with_associated_risks_unsafe_list);
		}

		// fes concession list
		$fee_concessions = $this->db->where('school_id', $school_id)->get('fee_concession')->result();
		if ($fee_concessions) {
			$this->db->delete('fee_concession', array('school_id' => $school_inserted_id));
			foreach ($fee_concessions as $fee_concession) {
				$fee_concession->feeConcessionId = NULL;
				$fee_concession->school_id = $school_inserted_id;
			}
			$this->db->insert_batch('fee_concession', $fee_concessions);
		}


		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}
