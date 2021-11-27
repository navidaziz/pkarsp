<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends MY_Controller
{

	public function index()
	{
		// 	$query = $this->db->query("SELECT * FROM schools 
		// left join users on schools.owner_id = users.userId 
		// left join district on schools.district_id = district.districtId 
		// where owner_id = '" . $_SESSION['userId'] . "'");
		// 	$data['data'] = $query->result_array();
		// 	// echo "<pre>"; print_r($data);exit();
		// 	$this->load->view('school/bankReceipt', $data);
		echo "We are working on it";
	}

	public function section_c()
	{
		$this->data['school_id'] = $school_id = 4;
		$this->data['school_detail'] = $this->db->query("SELECT * FROM schools WHERE schoolId = '" . $school_id . "'")->result()[0];
		$this->data['session_id'] = $session_id =  4;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` WHERE sessionYearId = $session_id")->result()[0];

		$last_seesion_record = $this->db->query("SELECT * FROM `school` WHERE schools_id='" . $school_id . "' ORDER BY schoolId DESC LIMIT 1")->result()[0];
		$school_type_id = $last_seesion_record->school_type_id;
		echo $gender_type_id = $last_seesion_record->gender_type_id;
		$query = "SELECT classes_ids FROM `levelofinstitute` WHERE levelofInstituteId='" . $school_type_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

		$this->data['classes'] = $this->db->query($query)->result();

		$school_gender_id = $last_seesion_record->gender_type_id;


		$this->data['schools_id'] = $this->db->query("SELECT schoolId FROM `school` 
													  WHERE `schools_id` = '" . $school_id . "' 
													  AND `session_year_id` = '" . $session_id . "'")->result()[0]->schoolId;

		$this->data['ages'] = $this->db->query("SELECT * FROM age")->result();

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Apply For Renewal';
		$this->data['view'] = 'forms/section_c';
		$this->load->view('layout', $this->data);
	}

	public function add_classes_ages()
	{

		$class_id = $this->input->post("classId");
		$gender_id = $this->input->post("gender_id");
		$schools_id = (int) $this->db->query("SELECT schoolId FROM `school` WHERE `schools_id` = 4 AND `session_year_id` = 4")->result()[0]->schoolId;

		$class_ages = array_filter($this->input->post("class_age"));

		foreach ($class_ages as $age_id => $enrolled) {
			$inputs['age_id'] = $age_id;
			$inputs['class_id'] = $class_id;
			$inputs['age_id'] = $age_id;
			$inputs['gender_id'] = $gender_id;
			$inputs['school_id'] = $schools_id;
			$inputs['enrolled'] = $enrolled;
			var_dump($inputs);
			$this->db->insert('age_and_class', $inputs);
		}
		$this->session->set_flashdata('msg', 'Class Age Wise Data For Boys Add Successfully');
		redirect("form/section_c");
	}

	public function update_class_ages_from()
	{
		$this->data['schools_id'] = (int) trim($this->input->post("schools_id"));
		$this->data['gender_id'] = (int) $this->input->post("gender_id");
		$this->data['class_id'] = $class_id = (int) $this->input->post("class_id");
		$this->data['school_id'] = $school_id = (int) $this->input->post("school_id");
		$this->data['session_id'] = $session_id = (int) $this->input->post("session_id");
		$this->data['class'] = $this->db->query("SELECT classId, age_range_ids, classTitle FROM class WHERE classId = '" . $class_id . "' ")->result()[0];
		$age_range_ids = $this->data['class']->age_range_ids;
		$query = "SELECT * FROM age WHERE ageId IN (" . $age_range_ids . ")";
		$this->data['ages'] = $this->db->query($query)->result();

		$this->load->view('forms/update_class_ages_form', $this->data);
	}


	public function update_class_ages_data()
	{

		$class_id = $this->input->post("class_id");
		$gender_id = $this->input->post("gender_id");
		$schools_id = $this->input->post("schools_id");


		//remove all data of on schools is for class and gender
		$query = "DELETE FROM age_and_class WHERE school_id ='" . $schools_id . "' AND class_id ='" . $class_id . "' AND gender_id ='" . $gender_id . "' ";
		$this->db->query($query);

		$class_ages = array_filter($this->input->post("class_age"));

		foreach ($class_ages as $age_id => $enrolled) {
			$inputs['age_id'] = $age_id;
			$inputs['class_id'] = $class_id;
			$inputs['age_id'] = $age_id;
			$inputs['gender_id'] = $gender_id;
			$inputs['school_id'] = $schools_id;
			$inputs['enrolled'] = $enrolled;
			var_dump($inputs);
			$this->db->insert('age_and_class', $inputs);
		}


		//remove all data of enrolment of students by school id, class_id, and gender_id
		$school_id = $this->input->post("school_id");
		$session_id = $this->input->post("session_id");
		$query = "DELETE FROM school_enrolments WHERE 
		          school_id ='" . $school_id . "'
				  AND session_id =  '" . $session_id . "'
				  AND class_id ='" . $class_id . "' 
				  AND gender_id ='" . $gender_id . "' ";
		$this->db->query($query);
		//$query = "INSERT INTO `school_enrolments`(`id`, `sesson_id`, `school_id`, `class_id`, `gender_id`,  `non_muslim`, `disabled`)VALUES (])";
		$enrolment['session_id'] = $session_id;
		$enrolment['school_id'] = $school_id;
		$enrolment['class_id'] = $class_id;
		$enrolment['gender_id'] = $gender_id;
		$enrolment['non_muslim'] = (int)  $this->input->post('non_muslim');
		$enrolment['disabled']  = (int)  $this->input->post('disabled');
		$this->db->insert('school_enrolments', $enrolment);

		$this->session->set_flashdata('msg', 'Class Age Wise Data For Boys Add Successfully');
		redirect("form/section_c");
	}
}
