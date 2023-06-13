<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Students_slcs extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		//error_reporting(0);
		//$this->load->model("student_model");
		//$this->lang->load("students", 'english');
		$this->lang->load("system", 'english');

		$this->load->library('form_validation');
	}




	public function index()
	{

		$userId = $this->session->userdata('userId');
		$query = "SELECT 
					`schools`.`schoolId` AS `schools_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`biseRegister`
				FROM
					`schools` WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->row();
		$slc_id = (int) $this->input->post("search_slc");
		$slc_id = $this->db->escape($slc_id);
		$query = "SELECT * FROM `student_leaving_certificates`
		          WHERE school_id = '" . $school->schools_id . "'";
		$slc_list = $this->db->query($query)->result();
		$this->data['slc_list'] = $slc_list;


		$this->data['title'] = 'School Leaving Certificates';
		$this->data['description'] = 'SLC List';
		$this->data['view'] = 'students_slcs/students_slcs_list';
		$this->load->view('layout', $this->data);
	}




	public function add_slc()
	{
		// echo '$input = array( ';
		// foreach ($_POST as $index => $value) {
		// 	echo "'" . $index . "' => " . '$this->input->post(\'' . $index . '\'), <br />';
		// }

		$input = array(
			'school_id' => $this->input->post('school_id'),
			'session_id' => $this->input->post('session_id'),
			'student_name' => $this->input->post('student_name'),
			'father_name' => $this->input->post('father_name'),
			'gender' => $this->input->post('gender'),
			'student_data_of_birth' => $this->input->post('student_data_of_birth'),
			'admission_no' => $this->input->post('admission_no'),
			'admission_date' => $this->input->post('admission_date'),
			'school_leaving_date' => $this->input->post('school_leaving_date'),
			'slc_issue_date' => $this->input->post('slc_issue_date'),
			'slc_file_no' => $this->input->post('slc_file_no'),
			'slc_certificate_no' => $this->input->post('slc_certificate_no'),
			'character_and_conduct' => $this->input->post('character_and_conduct'),
			'academic_record' => $this->input->post('academic_record'),
			'current_class' => $this->input->post('current_class'),
			'leaving_reason' => $this->input->post('leaving_reason')
		);
		if ($this->input->post('promotion_suggestion') == 'Yes') {
			$input['promoted_to_class'] = $this->input->post('promoted_to_class');
		} else {
			$input['promoted_to_class'] = NULL;
		}

		if ($this->db->insert('student_leaving_certificates', $input)) {
			$slc_id = $this->db->insert_id();
			$this->db->where('slc_id', $slc_id);
			$input = array();
			$input['slc_code'] =  ($slc_id + 10000000);
			$this->db->update('student_leaving_certificates', $input);
			$this->session->set_flashdata("msg_success", "Student SLC Update Successfully.");
			redirect('students_slcs/index');
		} else {
			$this->session->set_flashdata("msg_error", "Student SLC Not Update Successfully.");
			redirect('students_slcs/index');
		}
	}




	public function slc_certificate($slc_id)
	{
		$slc_id = (int) $slc_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
					`schools`.`schoolId` AS `schools_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`biseRegister`
				FROM
					`schools` WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->row();
		$slc_id = $this->db->escape($slc_id);
		$query = "SELECT * FROM `student_leaving_certificates`
		          WHERE school_id = '" . $school->schools_id . "'
				  AND student_leaving_certificates.slc_id = '" . $slc_id . "'";

		$this->data['student_slc'] = $this->db->query($query)->row();
		$this->load->view("students_slcs/slc_certificate", $this->data);
	}

	public function edit_student_slc($slc_id)
	{
		$slc_id = (int) $slc_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
					`schools`.`schoolId` AS `schools_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`biseRegister`
				FROM
					`schools` WHERE `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->row();
		$slc_id = $this->db->escape($slc_id);
		$query = "SELECT * FROM `student_leaving_certificates`
		          WHERE school_id = '" . $school->schools_id . "'
				  AND student_leaving_certificates.slc_id = '" . $slc_id . "'";

		$this->data['student_slc'] = $this->db->query($query)->row();
		$this->data['title'] = 'Edit Student School Leaving Certificate';
		$this->data['description'] = 'Update SLC';
		$this->data['view'] = 'students_slcs/edit_student_slc';
		$this->load->view('layout', $this->data);
	}

	public function update_slc()
	{
		// echo '$input = array( ';
		// foreach ($_POST as $index => $value) {
		// 	echo "'" . $index . "' => " . '$this->input->post(\'' . $index . '\'), <br />';
		// }

		$input = array(
			'school_id' => $this->input->post('school_id'),
			'session_id' => $this->input->post('session_id'),
			'student_name' => $this->input->post('student_name'),
			'father_name' => $this->input->post('father_name'),
			'gender' => $this->input->post('gender'),
			'student_data_of_birth' => $this->input->post('student_data_of_birth'),
			'admission_no' => $this->input->post('admission_no'),
			'admission_date' => $this->input->post('admission_date'),
			'school_leaving_date' => $this->input->post('school_leaving_date'),
			'slc_issue_date' => $this->input->post('slc_issue_date'),
			'slc_file_no' => $this->input->post('slc_file_no'),
			'slc_certificate_no' => $this->input->post('slc_certificate_no'),
			'character_and_conduct' => $this->input->post('character_and_conduct'),
			'academic_record' => $this->input->post('academic_record'),
			'current_class' => $this->input->post('current_class'),
			'leaving_reason' => $this->input->post('leaving_reason')
		);
		if ($this->input->post('promotion_suggestion') == 'Yes') {
			$input['promoted_to_class'] = $this->input->post('promoted_to_class');
		} else {
			$input['promoted_to_class'] = NULL;
		}


		$slc_id  = (int) $this->input->post('slc_id');
		$this->db->where('slc_id', $slc_id);
		if ($this->db->update('student_leaving_certificates', $input)) {
			$this->session->set_flashdata("msg_success", "Student SLC Update Successfully.");
			redirect('students_slcs/index');
		} else {
			$this->session->set_flashdata("msg_error", "Student SLC Not Update Successfully.");
			redirect('students_slcs/index');
		}
	}
}
