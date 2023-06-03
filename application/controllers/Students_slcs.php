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
		$this->load->model("student_model");
		$this->lang->load("students", 'english');
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
		$userId = $this->session->userdata('userId');
		$query = "SELECT * FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school->schoolId;


		$query = "SELECT
		`students`.`student_class_no`
		, `students`.`student_name`
		, `students`.`student_father_name`
		, `students`.`student_data_of_birth`
		, `students`.`student_address`
		, `students`.`student_admission_no`
		, `students`.`nationality`
		, `students`.`gender`
		, `students`.`admission_date`
		, student_leaving_certificates.slc_id
		, `student_leaving_certificates`.`slc_file_no`
		, `student_leaving_certificates`.`slc_certificate_no`
		, `student_leaving_certificates`.`leaving_reason`
		, `student_leaving_certificates`.`psra_student_id`
		, `student_leaving_certificates`.`current_class`
		, `student_leaving_certificates`.`promoted_to_class`
		, `student_leaving_certificates`.`academic_record`
		, `student_leaving_certificates`.`character_and_conduct`
		, `student_leaving_certificates`.`remarks`
		FROM
		`students`
		INNER JOIN `student_leaving_certificates` 
			ON (`students`.`student_id` = `student_leaving_certificates`.`student_id`) 
			WHERE student_leaving_certificates.slc_id = '" . $slc_id . "' 
			ORDER BY student_leaving_certificates.slc_id LIMIT 1";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->load->view(ADMIN_DIR . "admission/slc_certificate", $this->data);
	}
}
