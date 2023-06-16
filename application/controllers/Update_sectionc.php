<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update_sectionc extends Admin_Controller
{

	private function registaion_type($type_id)
	{
		if ($type_id == 1) {
			return 'Registration';
		}
		if ($type_id == 2) {
			return 'Renewal';
		}
		if ($type_id == 3) {
			return 'Up-Gradation';
		}
		if ($type_id == 4) {
			return 'Up-Gradation And Renewal';
		}
	}

	public function __construct()
	{

		parent::__construct();
	}

	private function school_detail($school_session_id)
	{
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
					`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id` as `session_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `school`.`level_of_school_id`
					, `school`.`gender_type_id`  
					, `school`.`reg_type_id`
					, `school`.`upgradation_levels`
					, `schools`.`biseRegister`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`schoolId`='" . $school_session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";
		return $this->db->query($query)->result()[0];
	}
	private function get_session_detail($session_id)
	{
		return $this->db->query("SELECT * FROM `session_year` WHERE sessionYearId = $session_id")->result()[0];
	}

	private function get_form_status($school_id)
	{
		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		return $this->db->query($query)->result()[0];
	}

	public function updatesectionc($school_session_id)
	{

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);

		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);


		//we use this code for only session 2023-24 howover next year we get levels from school session 

		$query = "SELECT MAX(schoolId) as pre_school_id FROM school WHERE schools_id = $school->schools_id and status=1";
		$previous_session = $this->db->query($query)->row();
		$min_level = array();

		$query = "select SUM(`s`.`enrolled`) as total FROM
		         `age_and_class` as `s` 
				 where `s`.`class_id` in (1,2,3,4,5,6,7)
				 AND `s`.`school_id` = '" . $previous_session->pre_school_id . "'";
		$primary = $this->db->query($query)->row()->total;
		if ($primary) {
			$min_level[] = 1;
		}
		$query = "select SUM(`s`.`enrolled`) as total FROM
		         `age_and_class` as `s` 
				 where `s`.`class_id` in (9,10,11)
				 AND `s`.`school_id` = '" . $previous_session->pre_school_id . "'";
		$middle = $this->db->query($query)->row()->total;
		if ($middle) {
			$min_level[] = 2;
		}
		$query = "select SUM(`s`.`enrolled`) as total FROM
		         `age_and_class` as `s` 
				 where `s`.`class_id` in (12,13)
				 AND `s`.`school_id` = '" . $previous_session->pre_school_id . "'";
		$high = $this->db->query($query)->row()->total;
		if ($high) {
			$min_level[] = 3;
		}

		$query = "select SUM(`s`.`enrolled`) as total FROM
		         `age_and_class` as `s` 
				 where `s`.`class_id` in (14,15)
				 AND `s`.`school_id` = '" . $previous_session->pre_school_id . "'";
		$high_sec = $this->db->query($query)->row()->total;
		if ($high_sec) {
			$min_level[] = 4;
		}
		// its only for renewal and registration
		if (!$min_level) {
			$min_level = 1;
		} else {
			$min_level = min($min_level);
		}
		$max_level = $this->data['school']->level_of_school_id;

		// end here 
		$query = "SELECT classId FROM `class` 
		          WHERE level_id >= '" . $min_level . "'and level_id<='" . $max_level . "'";
		$class_Ids = $this->db->query($query)->result_array();
		foreach ($class_Ids as $class_Id) {
			$classIds[] = $class_Id['classId'];
		}
		//for upgradation 
		if ($this->data['school']->reg_type_id == 4) {
			$class_levels_id = $this->data['school']->upgradation_levels;
			if ($class_levels_id) {
				$query = "SELECT classId FROM `class` 
				WHERE level_id IN(" . $class_levels_id . ")";
				$class_Ids = $this->db->query($query)->result_array();
				//$classIds = array();
				foreach ($class_Ids as $class_Id) {
					$classIds[] = $class_Id['classId'];
				}
			}
		}



		$query = "select a_o_level FROM schools WHERE schoolId = '" . $school->schools_id . "'";
		$a_o_level = $this->db->query($query)->row()->a_o_level;
		if (!$a_o_level) {
			$key = array_search('16', $classIds);
			if (false !== $key) {
				unset($classIds[$key]);
			}
			$key = array_search('17', $classIds);
			if (false !== $key) {
				unset($classIds[$key]);
			}
			$key = array_search('18', $classIds);
			if (false !== $key) {
				unset($classIds[$key]);
			}
			$key = array_search('19', $classIds);
			if (false !== $key) {
				unset($classIds[$key]);
			}
			$key = array_search('20', $classIds);
			if (false !== $key) {
				unset($classIds[$key]);
			}
		}

		$classes_ids = implode(",", $classIds);
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

		$this->data['classes'] = $this->db->query($query)->result();

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		if ($this->data['school']->school_type_id == 7) {
			$query = "SELECT * FROM age WHERE ageId = 20";
			$this->data['ages'] = $this->db->query($query)->result();
			$this->data['view'] = 'section_c/academy_section_c';
		} else {
			$query = "SELECT * FROM age WHERE ageId < 20";
			$this->data['ages'] = $this->db->query($query)->result();
			$this->data['view'] = 'section_c/section_c';
		}
		$this->load->view('layout', $this->data);
	}


	public function updateclassagesfrom()
	{

		$this->data['gender_id'] = (int) $this->input->post("gender_id");
		$this->data['class_id'] = $class_id = (int) $this->input->post("class_id");
		$this->data['school_id'] = $school_id = (int) $this->input->post("school_id");
		$this->data['session_id'] = $session_id = (int) $this->input->post("session_id");
		$this->data['class'] = $this->db->query("SELECT classId, age_range_ids, classTitle FROM class WHERE classId = '" . $class_id . "' ")->result()[0];
		$age_range_ids = $this->data['class']->age_range_ids;
		$query = "SELECT * FROM age WHERE ageId IN (" . $age_range_ids . ")";
		$this->data['ages'] = $this->db->query($query)->result();

		$this->load->view('section_c/update_class_ages_form', $this->data);
	}


	public function updateclassagesdata()
	{

		$class_id = $this->input->post("class_id");
		$gender_id = $this->input->post("gender_id");
		$school_id = $this->input->post("school_id");


		//remove all data of on schools is for class and gender
		$query = "DELETE FROM age_and_class WHERE school_id ='" . $school_id . "' 
		           AND class_id ='" . $class_id . "' AND gender_id ='" . $gender_id . "' ";
		$this->db->query($query);

		//$class_ages = array_filter($this->input->post("class_age"));
		$class_ages = $this->input->post("class_age");
		foreach ($class_ages as $age_id => $enrolled) {
			$inputs['age_id'] = $age_id;
			$inputs['class_id'] = $class_id;
			$inputs['age_id'] = $age_id;
			$inputs['gender_id'] = $gender_id;
			$inputs['school_id'] = $school_id;
			$inputs['enrolled'] = $enrolled;

			$this->db->insert('age_and_class', $inputs);
		}


		//remove all data of enrolment of students by Institute ID, class_id, and gender_id
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

		$gender = '';
		if ($gender_id == 1) {
			$gender = 'Boys';
		}
		if ($gender_id == 2) {
			$gender = 'Girls';
		}

		$this->session->set_flashdata('msg', "Class Age Wise Data For $gender Add Successfully");
		redirect("update_sectionc/updatesectionc/$school_id");
	}
}
