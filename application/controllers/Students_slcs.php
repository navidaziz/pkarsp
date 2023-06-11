<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Students_slcs extends CI_Controller
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


	public function create_student_slc()
	{


		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');
		$userId = $this->session->userdata('userId');
		$student_name = $this->db->escape($this->input->post('student_name'));
		$father_name = $this->db->escape($this->input->post('father_name'));
		$gender = $this->db->escape($this->input->post('gender'));

		$student_data_of_birth = $this->db->escape($this->input->post('student_data_of_birth'));
		$admission_no = $this->db->escape($this->input->post('admission_no'));
		$admission_date = $this->db->escape($this->input->post('admission_date'));
		$school_leaving_date = $this->db->escape($this->input->post("school_leaving_date"));
		$slc_issue_date = $this->db->escape($this->input->post("slc_issue_date"));
		$slc_file_no = $this->db->escape($this->input->post("slc_file_no"));
		$slc_certificate_no = $this->db->escape($this->input->post("slc_certificate_no"));
		$withdraw_reason = $this->db->escape($this->input->post("withdraw_reason"));
		$character_and_conduct = $this->db->escape($this->input->post("character_and_conduct"));
		$academic_record = $this->db->escape($this->input->post("academic_record"));
		$current_class = $this->db->escape($this->input->post("current_class"));
		$promoted_to_class = $this->db->escape($this->input->post('promoted_to_class'));
		//$promoted_to_class = $this->db->escape($this->$this->input->post("promoted_to_class"));
		// if ($this->input->post("promotion_suggestion") == 'Yes') {
		// 	$promoted_to_class = $this->db->escape($this->$this->input->post("promoted_to_class"));
		// } else {
		// 	$promoted_to_class = NULL;
		// }

		$query = "INSERT INTO `student_leaving_certificates`(
			`admission_no`, 
			`session_id`, 
			`admission_date`, 
			`student_data_of_birth`,
			`school_leaving_date`, 
			`slc_issue_date`, 
			`slc_file_no`, 
			`slc_certificate_no`, 
			`leaving_reason`,
			`character_and_conduct`,
			`academic_record`,
			`school_id`,
			`student_name`,
			`father_name`,
			`gender`,
			`current_class`,
			`promoted_to_class`,
			`created_by`) 
			VALUES (" . $admission_no . ",
					'" . $session_id . "',
					" . $admission_date . ",
					" . $student_data_of_birth . ",
					" . $school_leaving_date . ",
					" . $slc_issue_date . ",
					" . $slc_file_no . ",
					" . $slc_certificate_no . ",
					" . $withdraw_reason . ", 
					" . $character_and_conduct . ", 
					" . $academic_record . ",  
					'" . $school_id . "',
					" . $student_name . ",
					" . $father_name . ",
					" . $gender . ",
					" . $current_class . ",
					" . $promoted_to_class . ",
					'" . $userId . "')";
		$this->db->query($query);
		$slc_id = $this->db->insert_id();
		$slc_code = ($slc_id + 10000000);
		$query = "UPDATE `student_leaving_certificates` SET slc_code = '" . $slc_code . "' WHERE slc_id = '" . $slc_id . "'";
		$this->db->query($query);
		$this->session->set_flashdata("msg_error", "Student SLC Create Successfully.");
		redirect('students_slcs/index');
	}



	public function search_slc()
	{
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_id =  $this->db->query($query)->result()[0]->schoolId;
		$slc_id = (int) $this->input->post("search_slc");
		$slc_id = $this->db->escape($slc_id);
		$query = "SELECT
			`student_leaving_certificates`.`slc_id`
			, `students`.*
			, `student_leaving_certificates`.`school_leaving_date`
			, `student_leaving_certificates`.`slc_issue_date`
			FROM
			`students`
			INNER JOIN `student_leaving_certificates` 
			ON (`students`.`student_id` = `student_leaving_certificates`.`student_id`)
			WHERE `student_leaving_certificates`.`slc_id`= $slc_id";


		$students_list = $this->db->query($query)->result();

		$this->data['students_list'] = $students_list;
		$this->load->view(ADMIN_DIR . "admission/student_slc_list", $this->data);
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
}
