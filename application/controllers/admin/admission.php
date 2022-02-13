<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admission extends Admin_Controller
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
	//---------------------------------------------------------------

	public function asc_report()
	{
		$this->data["view"] = ADMIN_DIR . "admission/asc_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function birth_certificate($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName,registrationNumber FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school->schoolId;

		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->load->view(ADMIN_DIR . "admission/birth_certificate", $this->data);
	}

	public function update_student_profile()
	{
		$student_id = (int) $this->input->post('student_id');
		//just for redirection the update page
		if ($this->input->post('class_list')) {
			$this->data['class_list'] = true;
		} else {
			$this->data['class_list'] = false;
		}

		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school->schoolId;

		$this->data["students"]  = $this->student_model->get_student($student_id);



		$this->load->view(ADMIN_DIR . "admission/update_student_profile", $this->data);
	}

	public function change_class_form()
	{
		$student_id = (int) $this->input->post('student_id');

		$this->data["students"]  = $this->student_model->get_student($student_id);



		$this->load->view(ADMIN_DIR . "admission/change_class_form", $this->data);
	}

	public function change_student_class()
	{
		$student_id = (int) $this->input->post('student_id');
		$class_id = (int) $this->input->post('class_id');
		$query = "UPDATE students SET class_id = '" . $class_id . "' WHERE student_id = '" . $student_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}
	public function delete_student_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;

		$query = "UPDATE students SET status = '0' WHERE student_id = '" . $student_id . "' AND school_id = '" . $school_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}

	public function restore_student_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;

		$query = "UPDATE students SET status = '1' WHERE student_id = '" . $student_id . "' AND school_id = '" . $school_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}

	public function set_barcode($code)
	{
		// Load library
		//$this->load->library('zend');
		// Load in folder Zend
		//$this->zend->load('Zend/Barcode');
		// Generate barcode
		//$rendererOptions = array(
		//	'imageType'          => 'png',
		//	'horizontalPosition' => 'center',
		//	'verticalPosition'   => 'middle',
		//);
		//Zend_Barcode::render('code39', 'image', array('text' => (int) $code), $rendererOptions);
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
		, `student_leaving_certificates`.school_leaving_date
		, `student_leaving_certificates`.slc_issue_date
	FROM
		`students`
		INNER JOIN `student_leaving_certificates` 
			ON (`students`.`student_id` = `student_leaving_certificates`.`student_id`) 
			WHERE student_leaving_certificates.slc_id = '" . $slc_id . "' 
			ORDER BY student_leaving_certificates.slc_id LIMIT 1";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->load->view(ADMIN_DIR . "admission/slc_certificate", $this->data);
	}

	public function rsr()
	{
		$query = "SELECT * FROM teachers";
		$this->data['student'] = $this->db->query($query)->result()[0];
		$this->data["view"] = ADMIN_DIR . "admission/result_submission_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function update_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;

		$input["student_class_no"] = $this->input->post("student_class_no");
		$input["student_admission_no"] = $this->input->post("student_admission_no");
		$input["student_name"] = ucwords(strtolower($this->input->post("student_name")));
		$input["student_father_name"] = ucwords(strtolower($this->input->post("student_father_name")));
		$input["student_data_of_birth"] = $this->input->post("student_data_of_birth");
		$input["form_b"] = $this->input->post("form_b");
		$input["admission_date"] = $this->input->post("admission_date");
		$input["student_address"] = ucwords(strtolower($this->input->post("student_address")));
		$input["father_mobile_number"] = $this->input->post("father_mobile_number");
		$input["father_nic"] = $this->input->post("father_nic");
		$input["guardian_occupation"] = $this->input->post("guardian_occupation");
		$input["religion"] = ucwords(strtolower($this->input->post("religion")));
		$input["nationality"] = ucwords(strtolower($this->input->post("nationality")));
		$input["private_public_school"] = ucwords(strtolower($this->input->post("private_public_school")));
		$input["school_name"] = ucwords(strtolower($this->input->post("school_name")));
		$input["orphan"] = ucwords(strtolower($this->input->post("orphan")));
		$input["vaccinated"] = ucwords(strtolower($this->input->post("vaccinated")));
		$input["is_disable"] = ucwords(strtolower($this->input->post("is_disable")));
		$input["ehsaas"] = ucwords(strtolower($this->input->post("ehsaas")));
		$input["nic_issue_date"] = $this->input->post("nic_issue_date");
		$input["gender"] = $this->input->post("gender");
		$input["domicile_id"] = $this->input->post("domicile_id");


		$where_condition = array('student_id' => $student_id, 'school_id' => $school_id);
		$this->db->where($where_condition);
		if ($this->db->update("students", $input)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			if ($this->input->post('class_id')) {
				$class_id = $this->input->post('class_id');
				redirect(ADMIN_DIR . "admission/view_students/$class_id");
			} else {

				redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
			}
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
	}


	public function search_student()
	{
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_id =  $this->db->query($query)->result()[0]->schoolId;

		$search = $this->db->escape("%" . $this->input->post("search_student") . "%");
		$search2 = $this->db->escape($this->input->post("search_student"));
		$query = "SELECT s.*, c.class_title
		        FROM students as s,
				classes as c WHERE s.class_id = c.class_id
				AND (s.student_name LIKE $search
				OR s.student_father_name LIKE $search
				OR s.student_admission_no = $search2 )
				AND school_id = $school_id
				AND s.status != 0 
				LIMIT 20";

		$students_list = $this->db->query($query)->result();

		$this->data['students_list'] = $students_list;
		$this->load->view(ADMIN_DIR . "admission/student_search_list", $this->data);
	}
	public function add_new_student()
	{
		$class_id = $this->input->post("class_id");
		$section_id = $this->input->post("section_id");
		$query = "SELECT sessionYearId as session_id FROM `session_year` WHERE status=1 ORDER BY sessionYearId DESC";
		$session_id  = $this->db->query($query)->result()[0]->session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,district_id,tehsil_id, uc_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school = $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;
		$district_id = $school->district_id;
		$tehsil_id = $school->tehsil_id;
		$uc_id = $school->uc_id;


		$data = array(
			'class_id' => $this->input->post("class_id"),
			'section_id' => $this->input->post("section_id"),
			'session_id' => $session_id,
			'student_class_no' => $this->input->post("student_class_no"),
			'student_name' => $this->input->post("student_name"),
			'student_father_name' => $this->input->post("student_father_name"),
			'student_data_of_birth' => $this->input->post("student_data_of_birth"),
			'student_address' => $this->input->post("student_address"),
			'student_admission_no' => $this->input->post("student_admission_no"),
			'religion' => $this->input->post("religion"),
			'father_nic' => $this->input->post("father_nic"),
			'nationality' => $this->input->post("nationality"),
			'guardian_occupation' => $this->input->post("guardian_occupation"),
			'admission_date' => $this->input->post("admission_date"),
			'private_public_school' => $this->input->post("private_public_school"),
			'school_name' => $this->input->post("school_name"),
			'father_mobile_number' => $this->input->post("father_mobile_number"),
			'orphan' => $this->input->post("orphan"),
			'district_id' => $district_id,
			'tehsil_id' => $tehsil_id,
			'uc_id' => $uc_id,
			'gender' => $this->input->post("gender"),
			'form_b' => $this->input->post("form_b"),
			'school_id' => $school_id,
			'domicile_id' => $this->input->post("domicile_id"),
			'student_previous_id' =>  $this->input->post("student_previous_id"),
			'admission_slc_id' =>  $this->input->post("admission_slc_id")


		);
		if ($this->db->insert('students', $data)) {
			$student_id = $this->db->insert_id();
			$psra_stat_id = 10000;
			$query = "UPDATE students SET psra_student_id = '" . ($psra_stat_id + $student_id) . "' WHERE student_id = '" . $student_id . "'";
			$this->db->query($query);

			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect(ADMIN_DIR . "admission/view_students/$class_id/$section_id");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_students/$class_id/$section_id");
		}
	}

	/**
	 * Default action to be called
	 */

	public function index()
	{

		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school->schoolId;
		$query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id ASC";

		$result = $this->db->query($query);
		$classes = $result->result();

		$this->data['classes'] = $classes;
		$this->data['title'] = "Admission Dashboard";
		$this->data["view"] = ADMIN_DIR . "admission/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	// public function students_list($class_id, $section_id)
	// {


	// 	$class_id = (int) $class_id;
	// 	$section_id = (int) $section_id;
	// 	$where = "`students`.`status` IN (1) and `students`.`class_id`='" . $class_id . "' and `students`.`section_id` ='" . $section_id . "'
	// 	ORDER BY `student_class_no` ASC";
	// 	$this->data["students"] = $this->student_model->get_student_list($where, FALSE);

	// 	$this->data["pagination"] = "";
	// 	$this->data["title"] = "Update Students";

	// 	$this->data["view"] = PUBLIC_DIR . "student/students";
	// 	$this->load->view(PUBLIC_DIR . "layout", $this->data);
	// }

	public function promote_students($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,0,2) and `students`.`class_id`='" . $class_id . "' AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Promote Students";

		$this->data["view"] = ADMIN_DIR . "admission/promote_students";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function struck_off_students($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Struck Off Students";

		$this->data["view"] = ADMIN_DIR . "admission/struck_off_students";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function students_list($class_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' 
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function award_list($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/award_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function results($class_id = NULL, $section_id = NULL)
	{
		if ($class_id) {
			$this->data['class_id']  = $class_id = (int) $class_id;
		} else {
			$this->data['class_id'] = NULL;
		}
		if ($section_id) {
			$this->data['section_id']  = $section_id = (int) $section_id;
		} else {
			$this->data['section_id'] = NULL;
		}
		$where = "`students`.`status` IN (1,2)";

		if ($class_id) {
			$where .= " AND `students`.`class_id` = '" . $class_id . "' ";
		} else {
			$where .= " AND `students`.`class_id` IN (2,3,4,5,6)";
		}

		if ($section_id) {
			$where .= " AND `students`.`section_id` = '" . $section_id . "' ";
		}
		$where .= " ORDER BY `class_id`, `section_id`, `student_class_no` ASC ";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "Students Results";

		$this->data["view"] = ADMIN_DIR . "admission/results";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function all_students_data()
	{
		$where = "`students`.`status` IN (1,2) and `students`.`class_id` IN (2,3,4,5,6) 
		ORDER BY `class_id`, `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	public function age_wise_report($class_id, $section_id)
	{
		$this->data['class_id']  = $class_id = (int) $class_id;
		$this->data['section_id']  = $section_id = (int) $section_id;
		$where = "`students`.`status` IN (1,2) and `students`.`class_id`='" . $class_id . "' 
		AND `students`.`section_id` ='" . $section_id . "'
		ORDER BY `section_id`, `student_class_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();

		//$this->data["sections"] = $this->student_model->getList("sections", "section_id", "section_title", $where ="");
		//var_dump($this->data["classes"]);


		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";

		$this->data["pagination"] = "";
		$this->data["title"] = "All Students list";

		$this->data["view"] = ADMIN_DIR . "admission/age_wise_report";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function re_admit_again()
	{
		$student_id = (int) $this->input->post("student_id");


		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id  = $school->schoolId;
		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "' AND school_id = '" . $school_id . "'";
		$student_record = $this->db->query($query)->result();
		if ($student_record) {
			$class_id = (int) $this->input->post("class_id");
			$section_id = (int) $this->input->post("section_id");
			$admission_no = (int) $this->input->post("admission_no");
			$re_admit_again_reason = $this->db->escape($this->input->post("re_admit_again_reason"));
			$query = "UPDATE students set `status` = '1',  `student_admission_no` = '" . $admission_no . "' WHERE student_id = '" . $student_id . "'";
			if ($this->db->query($query)) {
				$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "'";
				$student = $this->db->query($query)->result()[0];
				$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
					  VALUES ('" . $student->student_id . "','" . $admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $student->section_id . "','Re Admit'," . $re_admit_again_reason . ", '" . $this->session->userdata('user_id') . "')";
				$this->db->query($query);
			}
			if ($this->input->post("redirect_page") == 'view_student_profile') {
				$this->session->set_flashdata("msg_success", "Student Re-Admit Successfully");
				redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
			} else {
				$this->session->set_flashdata("msg_success", "Student Re-Admit Successfully");
				redirect(ADMIN_DIR . "admission/struck_off_students/" . $class_id . "/" . $section_id);
			}
		} else {
			$this->session->set_flashdata("msg_error", "You are not allowed to readmint");
			redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
		}
	}

	public function withdraw_student()
	{


		$student_id = (int) $this->input->post("student_id");

		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id  = $school->schoolId;
		$query = "SELECT * FROM students WHERE student_id = '" . $student_id . "' AND school_id = '" . $school_id . "'";
		$student_record = $this->db->query($query)->result();


		$school_leaving_date = $this->db->escape($this->input->post("school_leaving_date"));
		$slc_issue_date = $this->db->escape($this->input->post("slc_issue_date"));
		$slc_file_no = $this->db->escape($this->input->post("slc_file_no"));
		$slc_certificate_no = $this->db->escape($this->input->post("slc_certificate_no"));
		$withdraw_reason = $this->db->escape($this->input->post("withdraw_reason"));
		$character_and_conduct = $this->db->escape($this->input->post("character_and_conduct"));
		$academic_record = $this->db->escape($this->input->post("academic_record"));


		$promoted_to_class = $this->db->escape($this->input->post("promoted_to_class"));
		$current_class = $this->db->escape($this->input->post("current_class"));


		if ($student_record) {
			$student = $student_record[0];
			$query = "UPDATE students set `status` = '3',  
		          `school_id` = '" . $school_id . "' 
				  WHERE student_id = '" . $student_id . "'";
			if ($this->db->query($query)) {


				$query = "INSERT INTO `student_leaving_certificates`(
				      `student_id`, 
			          `admission_no`, 
					  `session_id`, 
					  `class_id`, 
					  `section_id`, 
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
					  `psra_student_id`,
					  `student_name`,
					  `father_name`,
					  `current_class`,
					  `promoted_to_class`,
					  `created_by`) 
				      VALUES ('" . $student->student_id . "',
					          '" . $student->student_admission_no . "',
							  '" . $student->session_id . "',
							  '" . $student->class_id . "',
							  '" . $student->section_id . "',
							  " . $student->admission_date . ",
							  " . $student->student_data_of_birth . ",
							  " . $school_leaving_date . ",
							  " . $slc_issue_date . ",
							  " . $slc_file_no . ",
							  " . $slc_certificate_no . ",
							  " . $withdraw_reason . ", 
							  " . $character_and_conduct . ", 
							  " . $academic_record . ",  
							  '" . $school_id . "',
							  '" . $student->psra_student_id . "',
							  '" . $student->student_name . "',
							  '" . $student->student_father_name . "',
							  " . $current_class . ",
							  " . $promoted_to_class . ",
							  '" . $userId . "')";
				$this->db->query($query);



				$query = "INSERT INTO `student_history`(`student_id`, 
			          `student_admission_no`, 
					  `session_id`, 
					  `class_id`, 
					  `section_id`, 
					  `history_type`, 
					  `remarks`, 
					  `school_id`,
					  `created_by`) 
				      VALUES ('" . $student->student_id . "',
					          '" . $student->student_admission_no . "',
							  '" . $student->session_id . "',
							  '" . $student->class_id . "',
							  '" . $student->section_id . "',
							  'Withdraw'," . $withdraw_reason . ", 
							  '" . $school_id . "',
							  '" . $userId . "')";
				$this->db->query($query);
			}
			if ($this->input->post("redirect_page") == 'view_student_profile') {
				$this->session->set_flashdata("msg_success", "Student Withdraw Successfully");
				redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
			} else {
				$this->session->set_flashdata("msg_success", "Student Withdraw Successfully");
				redirect(ADMIN_DIR . "admission/struck_off_students/" . $class_id . "/" . $section_id);
			}
		} else {
			$this->session->set_flashdata("msg_error", "You are not allowed to withdraw the student.");
			redirect(ADMIN_DIR . "admission/view_student_profile/" . $student_id);
		}
	}


	public function promote_to_next_section()
	{


		$class_id = (int) $this->input->post("class_id");
		$section_id = (int) $this->input->post("section_id");
		$current_session = (int) $this->input->post("current_session");
		$to_class = (int) $this->input->post("to_class");
		$to_section = (int) $this->input->post("to_section");
		$new_session = (int) $this->input->post("new_session");
		$query = "SELECT * FROM students WHERE students.status = 1
		          AND students.class_id = '" . $class_id . "'
				  AND students.section_id = '" . $section_id . "'
				  AND students.session_id = '" . $current_session . "'
				";
		$students = $this->db->query($query)->result();
		foreach ($students as $student) {
			$query = "UPDATE students set class_id = '" . $to_class . "', section_id = '" . $to_section . "', session_id = '" . $new_session . "'
			          WHERE student_id = '" . $student->student_id . "'";
			if ($this->db->query($query)) {
				$query = "INSERT INTO `student_history`(`student_id`, `student_admission_no`, `session_id`, `class_id`, `section_id`, `history_type`, `remarks`, `created_by`) 
				          VALUES ('" . $student->student_id . "','" . $student->student_admission_no . "','" . $student->session_id . "','" . $student->class_id . "','" . $student->section_id . "','Promoted','Promoted to next class.', '" . $this->session->userdata('user_id') . "')";
				$this->db->query($query);
			}
		}

		$this->session->set_flashdata("msg_success", $this->lang->line("success"));
		redirect(ADMIN_DIR . "admission/promote_students/$class_id/$section_id");
	}




	public function login($student_id)
	{

		/*$this->session->sess_destroy();
		$this->session->keep_flashdata('message');*/
		$student_id = (int) $student_id;
		$query = "SELECT
						`student_id`
						, `class_id`
						, `section_id`
						, `student_name`
						, `student_class_no`
						, `student_admission_no`
					FROM
					`students` WHERE `student_id` = " . $student_id . ";";
		$query_result = $this->db->query($query);
		$student_information = $query_result->result()[0];



		$query = $this->db->select('user_data, ip_address')->get('ci_sessions');
		$online_users = array(); /* array to store the user data we fetch */

		$uip[$student_id] = $this->input->ip_address();

		foreach ($query->result() as $row) {
			$udata = unserialize($row->user_data);
			$uip[$udata['student_id']] = $row->ip_address;
			/* put data in array using username as key */
			//$online_users[$udata['student_id']] = $udata['student_name']; 
			$online_users[] = $udata['student_id'];
		}
		$this->data['online_users'] = $online_users;


		if (in_array($student_id, $online_users) and $uip[$student_id] != $this->input->ip_address()) {
			echo "student already log in...";
			$main_page = base_url() . $this->router->fetch_class() . "/students_list/" . $student_information->class_id . "/" . $student_information->section_id;
			redirect($main_page);

			exit();
		}








		//create session here ......
		$user_data = array(
			"student_id"  => $student_information->student_id,
			"class_id" => $student_information->class_id,
			"section_id" => $student_information->section_id,
			"student_name" => $student_information->student_name,
			"student_class_no" =>  $student_information->student_class_no,
			"student_admission_no" => $student_information->student_admission_no,
			"logged_in" => TRUE
		);

		//add to session
		$this->session->set_userdata($user_data);

		$main_page = base_url() . $this->router->fetch_class() . "/view_student/" . $student_id;
		redirect($main_page);
	}

	public function logout()
	{
		$class_id = $this->session->userdata('class_id');
		$section_id = $this->session->userdata('section_id');

		$this->session->sess_destroy();
		redirect(base_url() . $this->router->fetch_class() . "/students_list/" . $class_id . "/" . $section_id);
	}

	/**
	 * get a list of all items that are not trashed
	 */
	public function view()
	{

		$where = "`students`.`status` IN (1) ";
		$data = $this->student_model->get_student_list($where, TRUE, TRUE);
		$this->data["students"] = $data->students;
		$this->data["pagination"] = $data->pagination;
		$this->data["title"] = "Students";
		$this->data["view"] = PUBLIC_DIR . "students/students";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	/**
	 * get single record by id
	 */
	public function view_student_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school->schoolId;

		$this->data["students"]  = $this->student_model->get_student($student_id);


		$this->data["title"] = "Student Detail";
		$this->data["view"] = ADMIN_DIR . "admission/view_student_profile";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	//-----------------------------------------------------

	public function test($test_id)
	{
		$test_id = (int) $test_id;
		$student_id = $this->session->userdata('student_id');
		$check = false;
		$tests_detail = $this->test_model->get_test($test_id);

		//get test total question 
		$query = "SELECT 
				COUNT( `test_questions`.`test_question_id`) AS total_test_questions 
				FROM
				`test_questions` 
				WHERE `test_questions`.`test_id` = $test_id;";
		$query_result = $this->db->query($query);
		$this->data['total_test_questions'] = $query_result->result()[0]->total_test_questions;

		//get test total question attempted
		$query = "SELECT
			COUNT(`question_answer_id`) AS total_attempted_quetions
		FROM
		`questions_answers`
		WHERE  `test_id` = $test_id
		AND `student_id` =$student_id;";
		$query_result = $this->db->query($query);
		$this->data['total_attempted_quetions'] = $query_result->result()[0]->total_attempted_quetions;

		$query = "SELECT `question_id` FROM `questions_answers` WHERE `test_id` = $test_id and `student_id` = $student_id ";
		$query_result = $this->db->query($query);
		$question_ids = $query_result->result();

		foreach ($question_ids as $index => $question_id) {
			$question_ids[$index] = $question_id->question_id;
			$check = true;
		}
		$question_ids = implode(",", $question_ids);


		$query = "SELECT 
	`tests`.`test_id`,	
  `tests`.`test_title`,
  `subjects`.`subject_title`,
  `classes`.`Class_title`,
  `questions`.`question_id`,
  `questions`.`question_type`,
  `questions`.`chapter_name`,
  `questions`.`question_title`,
  `questions`.`question_image`,
  `questions`.`option_one`,
  `questions`.`option_two`,
  `questions`.`option_three`,
  `questions`.`option_four`,
  `questions`.`qustion_correct_answer` 
FROM
  `tests`,
  `test_questions`,
  `subjects`,
  `classes`,
  `questions` 
WHERE `tests`.`test_id` = `test_questions`.`test_id` 
  AND `subjects`.`subject_id` = `tests`.`subject_id` 
  AND `classes`.`class_id` = `tests`.`class_id` 
  AND `questions`.`question_id` = `test_questions`.`question_id` 
  AND  `test_questions`.`test_id` ='" . $test_id . "'";

		if ($check) {
			$query .= " AND `test_questions`.`question_id` NOT IN (" . $question_ids . ")";
		}
		$query .= " ORDER BY  RAND() ";

		$query_result = $this->db->query($query);
		$test_question = $query_result->result();
		$this->data['test_question'] = $test_question;

		if (!$test_question) {
			//get test result
			$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = $test_id
						AND `student_id` =$student_id;";
			$query_result = $this->db->query($query);
			$this->data['test_result'] = $query_result->result()[0];
		}

		//get test questions 
		$this->data["title"] = $tests_detail[0]->test_title . " ( " . $tests_detail[0]->test_type . " )";
		$this->data["view"] = PUBLIC_DIR . "student/question_view";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}


	public function qustion_answer()
	{




		$test_id = (int) $this->input->post('test_id');
		$question_id = (int) $this->input->post('question_id');
		$answer = $this->input->post('answer');

		//check user already attempt this question or not 

		$query = "SELECT * FROM `questions_answers` 
			  WHERE `test_id` = $test_id 
			  AND `question_id` = $question_id
			  AND student_id = " . $this->session->userdata('student_id');
		$query_result = $this->db->query($query);
		var_dump($query_result->result());
		if (!$query_result->result()) {
			$query = "SELECT `questions`.`qustion_correct_answer` FROM `questions` WHERE `question_id` = $question_id";
			$query_result = $this->db->query($query);
			$qustion_info = $query_result->result()[0];
			if (trim($qustion_info->qustion_correct_answer) == trim($answer)) {
				$_POST['answer'] = 1;
			} else {
				$_POST['answer'] = 0;
			}

			$_POST['student_id'] = $this->session->userdata('student_id');
			$this->question_answer_model->save_data();
		} else {
		}

		$main_page = base_url() . $this->router->fetch_class() . "/test/" . $test_id;
		redirect($main_page);
	}


	public function edit_student($student_id)
	{
		$student_id = (int) $student_id;
		$this->data["student"] = $this->student_model->get($student_id);

		$this->data["classes"] = $this->student_model->getList("CLASSES", "class_id", "Class_title", $where = "");

		$this->data["sections"] = $this->student_model->getList("SECTIONS", "section_id", "section_title", $where = "");

		$this->data["title"] = $this->lang->line('Edit Student');

		$this->data["view"] = PUBLIC_DIR . "student/edit_student";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}


	public function update_data($student_id)
	{

		$student_id = (int) $student_id;

		if ($this->student_model->validate_form_data() === TRUE) {

			if ($this->upload_file("student_image")) {
				$_POST["student_image"] = $this->data["upload_data"]["file_name"];
			}

			$student_id = $this->student_model->update_data($student_id);
			if ($student_id) {

				$this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
				redirect("student/view_student/$student_id");
			} else {

				$this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
				redirect("student/view_student/$student_id");
			}
		} else {
			$this->edit($student_id);
		}
	}


	public function students_result($class_id, $section_id)
	{
		/*$class_and_section = $this->input->post('class_and_section');
		$temp_var = explode("_", $class_and_section);
		$class_id = $temp_var[0];
		$section_id = $temp_var[1];*/
		$class_id = (int) $class_id;
		$section_id = (int) $section_id;

		$query = "SELECT DISTINCT 
				  `students`.*,
				  `sections`.`section_title`,
				  `classes`.`Class_title`,
				  SUM(`questions_answers`.`answer`) AS total_points 
				FROM
				  `questions_answers`,
				  `students`,
				  `classes`,
				  `sections` 
				WHERE `questions_answers`.`student_id` = `students`.`student_id` 
				  AND `classes`.`class_id` = `students`.`class_id` 
				  AND `sections`.`section_id` = `students`.`section_id` 
				  AND `students`.`status` IN (1,2) 
				  AND  `students`.`class_id`='" . $class_id . "' 
				  AND  `students`.`section_id` ='" . $section_id . "'
				GROUP BY `students`.`student_id` 
				ORDER BY total_points DESC ";
		$query_result = $this->db->query($query);
		$students = $query_result->result();



		/*$where = "`students`.`status` IN (1) 
				   and `students`.`class_id`='".$class_id."' 
				   and `students`.`section_id` ='".$section_id."'";
		$students = $this->student_model->get_student_list($where,FALSE);*/

		foreach ($students as $student_index => $student) {

			//get test by class id
			$where = "`tests`.`status` IN (1) and `tests`.`class_id` = " . $student->class_id;
			$tests  = $this->test_model->get_test_list($where, FALSE);

			foreach ($tests as $index => $test) {
				$query = "SELECT
							COUNT(`question_id`) AS total_questions,
							SUM(`answer`) as got_marks
						FROM `questions_answers`
						WHERE `test_id` = " . $test->test_id . "
						AND `student_id` = " . $student->student_id . ";";
				$query_result = $this->db->query($query);
				$tests[$index]->result = $query_result->result()[0];

				$tests[$index]->total_question = 	$query_result->result()[0]->total_questions;

				//get the total questions 


				$query = "SELECT
							COUNT(`test_question_id`) AS total_test_questions
						FROM
						`test_questions`
						WHERE `test_id` = " . $test->test_id . ";";
				$query_result = $this->db->query($query);
				$tests[$index]->result->total_test_questions = $query_result->result()[0]->total_test_questions;

				$tests[$index]->total_question = 	$query_result->result()[0]->total_test_questions;
			}



			$students[$student_index]->tests = $tests;
		}
		$this->data["students"] = $students;

		$this->data["pagination"] = "";
		$this->data["title"] = "Students";

		$this->data["view"] = PUBLIC_DIR . "student/students_result";
		$this->load->view(PUBLIC_DIR . "layout", $this->data);
	}



	function update_student_section()
	{
		//var_dump($_REQUEST);
		$section_id = $this->input->post("section_id");
		$class_id = $this->input->post("class_id");
		$student_id = $this->input->post("student_id");
		$student_section_id = $this->input->post("student_section_id");

		//update student section

		$this->db->query("UPDATE `students` SET `section_id`='" . $student_section_id . "' WHERE `student_id`='" . $student_id . "'");

		$main_page = site_url(ADMIN_DIR . "admission/view_students/" . $class_id . "/" . $section_id);
		redirect($main_page);
	}

	function view_students($class_id)
	{

		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school_id = $school->schoolId;
		$query = "SELECT * FROM `classes` WHERE status=1 ORDER BY class_id DESC";

		$this->data['class_id']  = $class_id = (int) $class_id;
		$where = "`students`.`status` IN (1,2) 
		AND  `students`.`class_id`='" . $class_id . "' 
		AND `students`.`school_id`='" . $school_id . "'
		ORDER BY `student_admission_no` ASC";
		$this->data["students"] = $students =  $this->student_model->get_student_list($where, FALSE);
		$sections = array();



		foreach ($students as $student) {
			$sections[$student->section_title][] = $student;
		}
		$this->data["sections"] = $sections;
		$this->data["pagination"] = "";
		$this->data["title"] = "Students";
		//var_dump($sections);
		$this->data["view"] = ADMIN_DIR . "admission/view_student";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}
	function update_student_info($student_id)
	{

		$student_id = (int) $student_id;
		$student_class_no = $this->input->post('student_class_no');
		$student_name = $this->input->post('student_name');
		if ($student_name != "" and $student_class_no != "") {
			$query = "UPDATE `students` SET `student_class_no`='" . $student_class_no . "',`student_name`='" . $student_name . "' WHERE `student_id` =$student_id;";
			$result = $this->db->query($query);
			echo "Student info update successfuly";
		} else {


			echo "Student name or class number missing try again...";
		}
	}



	function update_student_record()
	{

		$student_id = (int) $this->input->post('student_id');;
		$field = $this->input->post('field');
		$value = $this->db->escape(ucwords($this->input->post('value')));

		$query = "UPDATE `students` SET `" . $field . "`=" . $value . "
			     WHERE `student_id` =$student_id;";
		if ($this->db->query($query)) {
			echo $this->input->post('value');
		} else {
			echo "Error";
		}
	}


	function update_student_admission_no($student_id)
	{

		$student_id = (int) $student_id;
		$student_admission_no = $this->input->post('student_admission_no');

		$query = "UPDATE `students` SET `student_admission_no`='" . $student_admission_no . "'
			     WHERE `student_id` =$student_id;";
		$result = $this->db->query($query);
		echo "Student info update successfuly";
	}

	function save_student_data()
	{
		$section_id = $this->input->post("section_id");
		$class_id = $this->input->post("class_id");
		$student_id = $this->student_model->save_data();
		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}
	public function dormant_student($class_id, $section_id, $student_id)
	{

		$student_id = (int) $student_id;


		$this->student_model->changeStatus($student_id, "0");
		$this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));

		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}
	public function active_student($class_id, $section_id, $student_id)
	{

		$student_id = (int) $student_id;


		$this->student_model->changeStatus($student_id, "1");
		$this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));

		$main_page = base_url() . $this->router->fetch_class() . "/edit_students/" . $class_id . "/" . $section_id;
		redirect($main_page);
	}
}
