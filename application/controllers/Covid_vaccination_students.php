<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Covid_vaccination_students extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');
	}
	//---------------------------------------------------------------


	function index()
	{

		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId,schoolName FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$this->data['school_id']  = $school_id = $school->schoolId;
		$query = "SELECT * FROM covid_vaccination_students 
		WHERE `school_id`='" . $school_id . "'
		 ORDER BY student_id ASC";
		$this->data['students']  =  $this->db->query($query)->result();

		$this->data["title"] = "Students";
		$this->data["view"] = "covid_vaccination_students/view_student";
		$this->load->view("layout", $this->data);
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

		$query = "SELECT * FROM `covid_vaccination_students` WHERE student_id = '" . $student_id . "';";

		$this->data["students"]  = $this->db->query($query)->result();



		$this->load->view("covid_vaccination_students/update_student_profile", $this->data);
	}



	public function delete($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;

		$query = "DELETE FROm covid_vaccination_students  WHERE student_id = '" . $student_id . "' AND school_id = '" . $school_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect("covid_vaccination_students");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect("covid_vaccination_students");
		}
	}


	public function update_profile($student_id)
	{
		$student_id = (int) $student_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId FROM schools WHERE `owner_id`='" . $userId . "'";
		$this->data['school'] = $school =  $this->db->query($query)->result()[0];
		$school_id = $school->schoolId;

		$input["student_admission_no"] = $this->input->post("student_admission_no");
		$input["student_name"] = ucwords(strtolower($this->input->post("student_name")));
		$input["student_father_name"] = ucwords(strtolower($this->input->post("student_father_name")));
		$input["student_data_of_birth"] = $this->input->post("student_data_of_birth");
		$input["form_b"] = $this->input->post("form_b");
		$input["father_nic"] = $this->input->post("father_nic");
		$input["gender"] = $this->input->post("gender");
		$input["vaccinated"] = ucwords(strtolower($this->input->post("vaccinated")));
		if ($this->input->post("vaccinated") == 'Yes') {
			$input["first_dose"] = $this->input->post("first_dose");
			$input["second_dose"] = $this->input->post("second_dose");
			$input["remarks"] = NULL;
			$input["other_remarks"] = NULL;
		} else {
			$input["first_dose"] = NULL;
			$input["second_dose"] = NULL;
			$input["remarks"] = $this->input->post("remarks");
			$input["other_remarks"] = $this->input->post("other_remarks");
		}






		$where_condition = array('student_id' => $student_id, 'school_id' => $school_id);
		$this->db->where($where_condition);
		if ($this->db->update("covid_vaccination_students", $input)) {
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			if ($this->input->post('class_id')) {
				$class_id = $this->input->post('class_id');
				redirect("covid_vaccination_students");
			} else {

				redirect("covid_vaccination_students");
			}
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect(ADMIN_DIR . "admission/view_student_profile/$student_id");
		}
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

		if ($this->input->post("remarks") == 'Other') {
			$other_remarks = $this->input->post("other_remarks");
		} else {
			$other_remarks = NULL;
		}

		$data = array(
			'class_id' => $this->input->post("class_id"),
			'section_id' => $this->input->post("section_id"),
			'session_id' => $session_id,
			'student_admission_no' => $this->input->post("student_admission_no"),
			'student_name' => $this->input->post("student_name"),
			'student_father_name' => $this->input->post("student_father_name"),
			'student_data_of_birth' => $this->input->post("student_data_of_birth"),
			'father_nic' => $this->input->post("father_nic"),
			'district_id' => $district_id,
			'tehsil_id' => $tehsil_id,
			'uc_id' => $uc_id,
			'gender' => $this->input->post("gender"),
			'form_b' => $this->input->post("form_b"),
			'school_id' => $school_id,
			'vaccinated' => $this->input->post("vaccinated")
		);

		if ($this->input->post("vaccinated") == 'Yes') {
			$data["first_dose"] = $this->input->post("first_dose");
			$data["second_dose"] = $this->input->post("second_dose");
			$data["remarks"] = NULL;
			$data["other_remarks"] = NULL;
		} else {
			$data["first_dose"] = NULL;
			$data["second_dose"] = NULL;
			$data["remarks"] = $this->input->post("remarks");
			$data["other_remarks"] = $other_remarks;
		}
		if ($this->db->insert('covid_vaccination_students', $data)) {
			$student_id = $this->db->insert_id();
			$this->session->set_flashdata("msg_success", $this->lang->line("success"));
			redirect("covid_vaccination_students");
		} else {
			$this->session->set_flashdata("msg_success", $this->lang->line("msg_error"));
			redirect("covid_vaccination_students");
		}
	}
}
