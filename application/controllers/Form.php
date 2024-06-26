<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends Admin_Controller
{
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


	public function section_b($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);


		$this->load->model("general_modal");
		$this->data['buildings'] = $this->general_modal->building();
		$this->data['physical'] = $this->general_modal->physical();
		$this->data['academics'] = $this->general_modal->academic();
		$this->data['book_types'] = $this->general_modal->book_type();
		$this->data['co_curriculars'] = $this->general_modal->co_curricular();
		$this->data['other'] = $this->general_modal->other();

		$this->load->model("school_m");
		$this->data['school_physical_facilities'] = $this->school_m->physical_facilities_by_school_id($school_id);

		$school_physical_facilities_physical  = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$physical_ids = array();
		foreach ($school_physical_facilities_physical as $ph_obj) {
			$physical_ids[] = $ph_obj->pf_physical_id;
		}
		$this->data['facilities_physical_ids'] = $physical_ids;

		$school_physical_facilities_academic = $this->school_m->physical_facilities_academic_by_school_id($school_id);

		$academic_ids = array();
		foreach ($school_physical_facilities_academic as $acad_obj) {
			$academic_ids[] = $acad_obj->academic_id;
		}
		$this->data['academic_ids'] = $academic_ids;

		$school_physical_facilities_co_curricular = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$curricular_ids = array();
		foreach ($school_physical_facilities_co_curricular as $curricular_obj) {
			$curricular_ids[] = $curricular_obj->co_curricular_id;
		}
		$this->data['curricular_ids'] = $curricular_ids;


		$school_physical_facilities_other = $this->school_m->physical_facilities_other_by_school_id($school_id);
		$other_ids = array();
		foreach ($school_physical_facilities_other as $other_obj) {
			$other_ids[] = $other_obj->other_id;
		}
		$this->data['other_ids'] = $other_ids;

		$this->data['school_library'] = $this->school_m->get_library_books_by_school_id($school_id);

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section B (Physical Facilities)';
		$this->data['view'] = 'forms/section_b/section_b';
		$this->load->view('layout', $this->data);
	}

	public function update_levels()
	{
		$upgradation_levels = '';
		if ($this->input->post('levels')) {
			foreach ($this->input->post('levels') as $level_id => $level) {
				if ($level === 'on') {
					$upgradation_levels .= $level_id . ',';
				}
			}
			$upgradation_levels = trim($upgradation_levels, ",");
		}
		$form_input['upgradation_levels'] = $upgradation_levels;
		$school_id = (int) $this->input->post('school_id');
		$this->db->where('schoolId', $school_id);
		$this->db->update('school', $form_input);
		$this->session->set_flashdata('msg', 'Update Successfully');
		if ($this->input->post('update') == 'save_next') {
			redirect("form/section_c/$school_id");
		} else {
			redirect("form/section_b/$school_id");
		}
	}

	public function section_d($school_session_id)
	{

		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);


		$query = "SELECT *, gender.genderTitle, staff_type.staffTtitle  FROM school_staff, gender, staff_type 
				  WHERE school_staff.schoolStaffType = staff_type.staffTypeId
				  AND  school_staff.schoolStaffGender = gender.genderId
				  AND school_id ='" . $school_id . "' ORDER BY `school_staff`.`schoolStaffName` ASC";
		$this->data['school_staff'] = $this->db->query($query)->result();
		$this->load->model("school_m");
		$this->data['gender'] = $this->school_m->get_gender();
		$this->data['staff_type'] = $this->school_m->get_staff_type();
		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section D (Institute Employees Detail)';
		$this->data['view'] = 'forms/section_d/section_d';
		$this->load->view('layout', $this->data);
	}

	public function section_e($school_session_id)
	{

		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$query = "SELECT MAX(schoolId) as pre_school_id FROM school 
		WHERE schools_id = $school->schools_id and status=1";
		$previous_session = $this->db->query($query)->row();

		if ($previous_session->pre_school_id) {
			$min_level = array();

			//check level mentioned on last issued certificate or not

			$query = "SELECT `primary`, `middle`, `high`, `high_sec` FROM school 
				WHERE new_certificate=1
				AND school.schoolId = $previous_session->pre_school_id";
			$school_levels = $this->db->query($query)->row();
			if ($school_levels) {
				if ($school_levels->primary == 1) {
					$min_level[] = 1;
				}
				if ($school_levels->middle == 1) {
					$min_level[] = 2;
				}
				if ($school_levels->high == 1) {
					$min_level[] = 3;
				}
				if ($school_levels->high_sec == 1) {
					$min_level[] = 4;
				}
			} else {
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
			}
		}

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
		if ($this->data['school']->reg_type_id == 4 or $this->data['school']->reg_type_id == 1) {
			$class_levels_id = $this->data['school']->upgradation_levels;
			if ($class_levels_id) {
				$classIds = array();
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
		$this->data['description'] = 'Section E (School Fee Detail)';
		if ($school->school_type_id == 7) {
			$this->data['view'] = 'forms/section_e/academy_section_e';
		} else {
			$this->data['view'] = 'forms/section_e/section_e';
		}



		$this->load->view('layout', $this->data);
	}

	public function update_form_b_data()
	{




		$posts = $this->input->post();
		$school_id = $posts['school_id'];
		$this->db->where('school_id', $school_id);
		$this->db->delete(array(
			'physical_facilities',
			'physical_facilities_physical',
			'physical_facilities_academic',
			'physical_facilities_co_curricular',
			'physical_facilities_others'
		));



		$physical_facilities = array(
			'building_id' => $posts['building_id'],
			'numberOfClassRoom' => $posts['numberOfClassRoom'],
			'numberOfOtherRoom' => $posts['numberOfOtherRoom'],
			'rent_amount' => $posts['rent_amount'],
			'totalArea' => $posts['totalArea'],
			'coveredArea' => $posts['coveredArea'],
			'numberOfComputer' => $posts['numberOfComputer'],
			'numberOfLatrines' => $posts['numberOfLatrines'],
			'school_id' => $posts['school_id'],
			'land_type' => $posts['land_type'],
			'avg_class_room_size' => $posts['avg_class_room_size'],
			'timing' => $posts['timing'],
			'female_washrooms' => $posts['female_washrooms'],
			'male_washrooms' => $posts['male_washrooms']
		);

		$physical_facilities['high_science_lab'] = NULL;
		$physical_facilities['physics_lab'] = NULL;
		$physical_facilities['chemistry_lab'] = NULL;
		$physical_facilities['biology_lab'] = NULL;

		if ($posts['high_science_lab']) {
			$physical_facilities['high_science_lab'] = $posts['high_science_lab'];
		}

		if ($posts['physics_lab']) {
			$physical_facilities['physics_lab'] = $posts['physics_lab'];
		}

		if ($posts['chemistry_lab']) {
			$physical_facilities['chemistry_lab'] = $posts['chemistry_lab'];
		}

		if ($posts['biology_lab']) {
			$physical_facilities['biology_lab'] = $posts['biology_lab'];
		}


		$this->db->insert('physical_facilities', $physical_facilities);



		if (isset($posts['pf_physical_id'])) {
			$pf_physical_ids = $posts['pf_physical_id'];
			foreach ($pf_physical_ids as $pf_physical_id) {
				$this->db->insert('physical_facilities_physical', array('pf_physical_id' => $pf_physical_id, 'school_id' => $posts['school_id']));
			}
		}

		if (isset($posts['academic_id'])) {
			$academic_ids    = $posts['academic_id'];
			foreach ($academic_ids as $academic_id) {
				$this->db->insert('physical_facilities_academic', array('academic_id' => $academic_id, 'school_id' => $posts['school_id']));
				if ($academic_id == 2) {
					$this->db->where('school_id', $posts['school_id']);
					if ($this->db->delete('school_library')) {
						$libary_books    = $posts['libary_books'];
						foreach ($libary_books as $book_type_id => $numberOfBooks) {
							$libary_book_inputs['book_type_id'] = $book_type_id;
							$libary_book_inputs['numberOfBooks'] = $numberOfBooks;
							$libary_book_inputs['school_id'] = $posts['school_id'];
							$this->db->insert('school_library', $libary_book_inputs);
						}
					}
				}
			}
		}


		if (isset($posts['co_curricular_id'])) {
			$co_curricular_ids    = $posts['co_curricular_id'];
			foreach ($co_curricular_ids as $co_curricular_id) {
				$this->db->insert('physical_facilities_co_curricular', array('co_curricular_id' => $co_curricular_id, 'school_id' => $posts['school_id']));
			}
		}

		if (isset($posts['other_id'])) {
			$other_ids    = $posts['other_id'];
			foreach ($other_ids as $other_id) {
				$this->db->insert('physical_facilities_others', array('other_id' => $other_id, 'school_id' => $posts['school_id']));
			}
		}

		//update a and o level
		$input_school['a_o_level'] = (int) $this->input->post('a_o_level');
		$schools_id = (int) $this->input->post('schools_id');

		$input_school['telePhoneNumber'] = $this->input->post('telePhoneNumber');
		$input_school['schoolMobileNumber'] = $this->input->post('schoolMobileNumber');
		$input_school['principal_email'] = $this->input->post('principal_email');

		$this->db->where('schoolId', $schools_id);
		$this->db->update('schools', $input_school);

		//update form ......

		$form_input['form_b_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);

		$form_input = array();
		$form_input['gender_type_id'] = (int) $this->input->post('gender_type_id');
		$this->db->where('schoolId', $school_id);
		$this->db->update('school', $form_input);

		$form_input = array();
		$form_input['principal'] = $this->input->post('principal');
		$form_input['principal_cnic'] = $this->input->post('principal_cnic');
		$form_input['principal_contact_no'] = $this->input->post('principal_contact_no');

		$form_input['upgradation_levels'] = $this->input->post('upgradation_levels');

		$this->db->where('schoolId', $school_id);
		$this->db->update('school', $form_input);


		$this->session->set_flashdata('msg', 'Facility Detail Added Successfully.');
		$session_id = (int) $this->input->post('session_id');
		if ($this->input->post('update') == 'save_next') {
			redirect("form/section_c/$school_id");
		} else {
			redirect("form/section_b/$school_id");
		}
	}



	public function add_employee_data()
	{

		// $posts = $this->input->post();
		// foreach ($posts as $variable => $post) {
		// 	echo '$input["' . $variable . '"] = $this->input->post("' . $variable . '");' . "<br />";
		// }
		//$input["schools_id"] = $this->input->post("schools_id");
		$session_id = (int) $this->input->post("session_id");
		$input["school_id"] = $school_id =  (int) $this->input->post("school_id");

		$input["schoolStaffName"] = $this->input->post("schoolStaffName");
		$input["schoolStaffFatherOrHusband"] = $this->input->post("schoolStaffFatherOrHusband");
		$input["schoolStaffCnic"] = $this->input->post("schoolStaffCnic");
		$input["contact"] = $this->input->post("contact");
		$input["schoolStaffGender"] = $this->input->post("schoolStaffGender");
		$input["schoolStaffType"] = $this->input->post("schoolStaffType");
		$input["schoolStaffQaulificationAcademic"] = $this->input->post("schoolStaffQaulificationAcademic");
		$input["schoolStaffQaulificationProfessional"] = $this->input->post("schoolStaffQaulificationProfessional");
		$input["TeacherTraining"] = $this->input->post("TeacherTraining");
		$input["TeacherExperience"] = $this->input->post("TeacherExperience");
		$input["schoolStaffDesignition"] = $this->input->post("schoolStaffDesignition");
		$input["schoolStaffAppointmentDate"] = $this->input->post("schoolStaffAppointmentDate");
		$input["schoolStaffNetPay"] = $this->input->post("schoolStaffNetPay");
		$input["schoolStaffAnnualIncreament"] = $this->input->post("schoolStaffAnnualIncreament");

		$input["job_nature"] = $this->input->post("job_nature");
		$input["gov_sector"] = $this->input->post("gov_sector");
		$input["gov_noc"] = $this->input->post("gov_noc");

		$this->db->insert('school_staff', $input);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$this->session->set_flashdata('msg', 'Employee Detail Added Successfully.');
			redirect("form/section_d/$school_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$school_id");
		}
	}

	public function get_employee_edit_form()
	{
		$employee_id = (int) $this->input->post("employee_id");

		$this->data["schools_id"] = (int) $this->input->post("schools_id");
		$this->data["school_id"] = (int) $this->input->post("school_id");
		$this->data["session_id"] = (int) $this->input->post("session_id");

		$this->data['gender'] = $this->db->get('gender')->result();
		$this->data['staff_type'] = $this->db->get('staff_type')->result();
		$query = "SELECT * FROM school_staff WHERE schoolStaffId ='" . $employee_id . "'";
		$this->data['school_staff'] = $this->db->query($query)->result()[0];
		$this->data['title'] = 'Update Employee Detail';
		$this->data['description'] = 'Update Employee Detail';
		$this->load->view('forms/section_d/get_employee_edit_form', $this->data);
	}

	public function update_employee_detail()
	{
		$session_id = (int) $this->input->post("session_id");
		$school_id = (int) $this->input->post("school_id");
		//$input["schools_id"] = (int) $this->input->post("schools_id");
		$schoolStaffId = (int) $this->input->post("schoolStaffId");

		$input["schoolStaffName"] = $this->input->post("schoolStaffName");
		$input["schoolStaffFatherOrHusband"] = $this->input->post("schoolStaffFatherOrHusband");
		$input["schoolStaffCnic"] = $this->input->post("schoolStaffCnic");
		$input["contact"] = $this->input->post("contact");
		$input["schoolStaffGender"] = $this->input->post("schoolStaffGender");
		$input["schoolStaffType"] = $this->input->post("schoolStaffType");
		$input["schoolStaffQaulificationAcademic"] = $this->input->post("schoolStaffQaulificationAcademic");
		$input["schoolStaffQaulificationProfessional"] = $this->input->post("schoolStaffQaulificationProfessional");
		$input["TeacherTraining"] = $this->input->post("TeacherTraining");
		$input["TeacherExperience"] = $this->input->post("TeacherExperience");
		$input["schoolStaffDesignition"] = $this->input->post("schoolStaffDesignition");
		$input["schoolStaffAppointmentDate"] = $this->input->post("schoolStaffAppointmentDate");
		$input["schoolStaffNetPay"] = $this->input->post("schoolStaffNetPay");
		$input["schoolStaffAnnualIncreament"] = $this->input->post("schoolStaffAnnualIncreament");

		$input["job_nature"] = $this->input->post("job_nature");
		$input["gov_sector"] = $this->input->post("gov_sector");
		$input["gov_noc"] = $this->input->post("gov_noc");

		$this->db->where('schoolStaffId', $schoolStaffId);;
		if ($this->db->update('school_staff', $input)) {
			$this->session->set_flashdata('msg', 'Employee Detail Update Successfully.');
			redirect("form/section_d/$school_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$school_id");
		}
	}

	public function delete_employee($employee_id, $school_id, $session_id)
	{

		$employee_id = (int) $employee_id;
		$school_id = (int) $school_id;
		$session_id = (int) $session_id;

		$this->db->where('schoolStaffId', $employee_id);
		$this->db->where('school_id', $school_id);
		if ($this->db->delete('school_staff')) {
			$this->session->set_flashdata('msg', 'Employee Detail Delete Successfully.');
			redirect("form/section_d/$school_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$school_id");
		}
	}

	public function update_class_fee_from()
	{
		$this->data['schools_id'] = (int) trim($this->input->post("schools_id"));
		$this->data['class_id'] = $class_id = (int) $this->input->post("class_id");
		$this->data['school_id'] =  (int) $this->input->post("school_id");
		$this->data['session_id'] = (int) $this->input->post("session_id");
		$this->data['class'] = $this->db->query("SELECT classId, age_range_ids, classTitle 
		                                         FROM class WHERE classId = '" . $class_id . "' ")->result()[0];


		$this->load->view('forms/section_e/update_class_fee_from', $this->data);
	}

	public function update_class_fee()
	{




		$class_id = (int) $this->input->post("class_id");
		$schools_id = (int) $this->input->post("schools_id");
		$school_id = (int) $this->input->post("school_id");
		$session_id = (int) $this->input->post("session_id");

		if ($this->input->post('courses')) {
			$input_courses_array = array();
			$select_courses = $this->input->post('courses');
			$courses_columns = array("fcta", "ccpa", "frca", "css_pms", "etea", "language", "others");
			foreach ($courses_columns as $courses_column) {

				if (in_array($courses_column, $select_courses)) {
					$input_courses_array[$courses_column] = 1;
				} else {
					$input_courses_array[$courses_column] = 0;
				}
			}
			$input_courses_array['schools_id'] = $schools_id;
			$input_courses_array['school_id'] = $school_id;
			$input_courses_array['session_id'] = $session_id;


			$query = "DELETE FROM academy_courses 
		          WHERE school_id ='" . $school_id . "'";
			$this->db->query($query);
			if ($input_courses_array['others'] == '1') {
				$input_courses_array['others_courses'] = $this->input->post('others_courses');
			}
			//var_dump($input_courses_array);
			$this->db->insert('academy_courses', $input_courses_array);
		}



		//remove all data of on schools is for class 
		$query = "DELETE FROM fee 
		          WHERE school_id ='" . $school_id . "' 
				AND class_id ='" . $class_id . "'";
		$this->db->query($query);

		$input['school_id'] = (int) $this->input->post('school_id');
		$input['class_id'] = (int) $this->input->post('class_id');
		$input['addmissionFee'] = (int) $this->input->post('addmissionFee');
		$input['tuitionFee'] = (int) $this->input->post('tuitionFee');
		$input['securityFund'] = (int) $this->input->post('securityFund');
		$input['otherFund'] = (int) $this->input->post('otherFund');
		$this->db->insert('fee', $input);




		if ($this->input->post('pro')) {
			//remove all data of on schools is for class 
			$query = "DELETE FROM fee_mentioned_in_form_or_prospectus 
			WHERE school_id ='" . $school_id . "'";
			$this->db->query($query);
			$fee_mention = array();

			$fee_mention['feeMentionedInForm'] = $this->input->post('pro');
			$fee_mention['FeeMentionOutside'] = $this->input->post('outside');
			$fee_mention['school_id'] = $school_id;
			$this->db->insert('fee_mentioned_in_form_or_prospectus', $fee_mention);
		}
		$this->session->set_flashdata('msg', 'Class Fee Detail Add Successfully.');
		redirect("form/section_e/$school_id");
	}

	public function section_c($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);

		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);


		//we use this code for only session 2023-24 howover next year we get levels from school session 

		$query = "SELECT MAX(schoolId) as pre_school_id FROM school 
		WHERE schools_id = $school->schools_id and status=1";
		$previous_session = $this->db->query($query)->row();

		if ($previous_session->pre_school_id) {
			$min_level = array();

			//check level mentioned on last issued certificate or not

			$query = "SELECT `primary`, `middle`, `high`, `high_sec` FROM school 
				WHERE new_certificate=1
				AND school.schoolId = $previous_session->pre_school_id";
			$school_levels = $this->db->query($query)->row();
			if ($school_levels) {
				if ($school_levels->primary == 1) {
					$min_level[] = 1;
				}
				if ($school_levels->middle == 1) {
					$min_level[] = 2;
				}
				if ($school_levels->high == 1) {
					$min_level[] = 3;
				}
				if ($school_levels->high_sec == 1) {
					$min_level[] = 4;
				}
			} else {
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
			}
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
		if ($this->data['school']->reg_type_id == 4 or $this->data['school']->reg_type_id == 1) {
			//$classIds = array();
			$class_levels_id = $this->data['school']->upgradation_levels;
			if ($class_levels_id) {
				$classIds = array();
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
			$this->data['view'] = 'forms/section_c/academy_section_c';
		} else {
			$query = "SELECT * FROM age WHERE ageId < 20";
			$this->data['ages'] = $this->db->query($query)->result();
			$this->data['view'] = 'forms/section_c/section_c';
		}
		$this->load->view('layout', $this->data);
	}

	// public function add_classes_ages()
	// {

	// 	$session_id = $this->input->post("session_id");
	// 	$class_id = $this->input->post("classId");
	// 	$gender_id = $this->input->post("gender_id");
	// 	$schools_id = (int) $this->db->query("SELECT schoolId FROM `school` WHERE `schools_id` = 4 AND `session_year_id` = 4")->result()[0]->schoolId;

	// 	$class_ages = array_filter($this->input->post("class_age"));

	// 	foreach ($class_ages as $age_id => $enrolled) {
	// 		$inputs['age_id'] = $age_id;
	// 		$inputs['class_id'] = $class_id;
	// 		$inputs['age_id'] = $age_id;
	// 		$inputs['gender_id'] = $gender_id;
	// 		$inputs['school_id'] = $schools_id;
	// 		$inputs['enrolled'] = $enrolled;
	// 		var_dump($inputs);
	// 		$this->db->insert('age_and_class', $inputs);
	// 	}

	// 	$this->session->set_flashdata('msg', "Class Age Wise Data For $gender Add Successfully");
	// 	redirect("form/section_c");
	// }

	public function update_class_ages_from()
	{

		$this->data['gender_id'] = (int) $this->input->post("gender_id");
		$this->data['class_id'] = $class_id = (int) $this->input->post("class_id");
		$this->data['school_id'] = $school_id = (int) $this->input->post("school_id");
		$this->data['session_id'] = $session_id = (int) $this->input->post("session_id");
		$this->data['class'] = $this->db->query("SELECT classId, age_range_ids, classTitle FROM class WHERE classId = '" . $class_id . "' ")->result()[0];
		$age_range_ids = $this->data['class']->age_range_ids;
		$query = "SELECT * FROM age WHERE ageId IN (" . $age_range_ids . ")";
		$this->data['ages'] = $this->db->query($query)->result();

		$this->load->view('forms/section_c/update_class_ages_form', $this->data);
	}


	public function update_class_ages_data()
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
		$enrolment['afghani']  = (int)  $this->input->post('afghani');
		$enrolment['non_afghani']  = (int)  $this->input->post('non_afghani');
		$this->db->insert('school_enrolments', $enrolment);

		$gender = '';
		if ($gender_id == 1) {
			$gender = 'Boys';
		}
		if ($gender_id == 2) {
			$gender = 'Girls';
		}

		$this->session->set_flashdata('msg', "Class Age Wise Data For $gender Add Successfully");
		redirect("form/section_c/$school_id");
	}

	public function add_academy_section_c_data()
	{

		$class_id = 21;
		$age_id = 19;
		$school_id = (int) $this->input->post("school_id");
		$query = "DELETE FROM age_and_class 
		          WHERE school_id ='" . $school_id . "' 
				  AND class_id ='" . $class_id . "' AND gender_id IN (1,2)";
		$this->db->query($query);

		$inputs['age_id'] = $age_id;
		$inputs['class_id'] = $class_id;
		$inputs['gender_id'] = 1;
		$inputs['school_id'] = $school_id;
		$inputs['enrolled'] = $this->input->post('boys');
		$this->db->insert('age_and_class', $inputs);

		$inputs['age_id'] = $age_id;
		$inputs['class_id'] = $class_id;
		$inputs['gender_id'] = 2;
		$inputs['school_id'] = $school_id;
		$inputs['enrolled'] = $this->input->post('girls');
		$this->db->insert('age_and_class', $inputs);

		$this->session->set_flashdata('msg', "Add Successfully");
		redirect("form/section_c/$school_id");
	}


	public function section_f($school_session_id)
	{

		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$this->load->model("school_m");
		$this->data['security_status'] = $this->school_m->get_security_status();
		$this->data['security_provided'] = $this->school_m->get_security_provided();
		$this->data['security_personnel'] = $this->school_m->get_security_personnel();
		$this->data['security_license_issued'] = $this->school_m->get_security_license_issued();

		$this->data['school_security_measures'] = $this->db->where('school_id', $school_id)->get('security_measures')->result()[0];

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		$this->data['view'] = 'forms/section_f/section_f';
		$this->load->view('layout', $this->data);
	}

	public function update_from_f_data()
	{
		$session_id = (int) $this->input->post('session_id');
		//$securityMeasureId = $this->input->post('securityMeasureId');
		$posts = $this->input->post();
		$school_id = $posts['school_id'];
		unset($posts['securityMeasureId']);
		// var_dump($posts);
		unset($posts['session_id']);



		// $staff_info = $this->input->post();
		$this->db->where('school_id', $school_id);
		$this->db->delete('security_measures');
		$this->db->insert('security_measures', $posts);
		$affected_row = $this->db->affected_rows();

		if ($affected_row) {
			$form_input['form_f_status'] = 1;
			$this->db->where('school_id', $school_id);
			$this->db->update('forms_process', $form_input);

			$this->session->set_flashdata('msg', 'Security Measures Successfully Changed.');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_f/$school_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_f/$school_id");
		}
	}


	public function section_g($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);


		$this->load->model("school_m");
		$this->data['building_structure'] = $this->school_m->get_building_structure();
		$this->data['hazards_surrounded'] = $this->school_m->get_hazards_surrounded();
		$this->data['hazards_electrification'] = $this->school_m->get_hazards_electrification();
		$this->data['unsafe_list'] = $this->school_m->get_unsafe_list();
		$this->data['hazards_hazard_with_associated_risks'] = $this->school_m->hazards_hazard_with_associated_risks($school_id)[0];
		// unsafe_ids 
		$unsafe_list = $this->school_m->get_unsafe_by_school_id($school_id);
		// var_dump($this->data['hazards_hazard_with_associated_risks']);
		// exit;
		$unsafe_ids = array();
		foreach ($unsafe_list as $unsafe) {
			$unsafe_ids[] = $unsafe->unsafe_list_id;
		}
		$this->data['unsafe_ids'] = $unsafe_ids;

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		$this->data['view'] = 'forms/section_g/section_g';
		$this->load->view('layout', $this->data);
	}

	public function update_form_g_data()
	{


		$posts = $this->input->post();
		unset($posts['session_id']);
		$unSafeList1 = $posts['unSafeList'];
		unset($posts['unSafeList']);


		$hazardsWithAssociatedRisksId = $posts['hazardsWithAssociatedRisksId'];
		$school_id = $posts['school_id'];
		$this->db->where('school_id', $school_id);
		$this->db->delete('hazards_with_associated_risks_unsafe_list');

		$this->db->where('school_id', $school_id);
		$this->db->delete('hazards_with_associated_risks');


		unset($posts['hazardsWithAssociatedRisksId']);

		$this->db->insert('hazards_with_associated_risks', $posts);
		$query_result = $this->db->affected_rows();

		// unsafe list deletion old list and insert new one 
		if ($posts['accessRoute'] != 'Safe') {
			$count = count($unSafeList1);
			$batch_data = [];
			for ($i = 0; $i < $count; $i++) {
				array_push($batch_data,  array(
					'`unsafe_list_id`' => $unSafeList1[$i],
					'`school_id`' => $school_id
				));
			}

			// supply id column and then table name in argument list

			$this->db->insert_batch('`hazards_with_associated_risks_unsafe_list`', $batch_data);
			$insert_id = $this->db->insert_id();
		}
		if ($query_result > 0) {
			$form_input['form_g_status'] = 1;
			$this->db->where('school_id', $school_id);
			$this->db->update('forms_process', $form_input);

			$this->session->set_flashdata('msg', 'Hazards with Associated Risks.');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_g/$school_id");
		} else {
			$this->session->set_flashdata('msg', 'Hazards with Associated Risks.');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_g/$school_id");
		}
	}

	public function section_h($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$this->load->model("school_m");
		$this->data['school_fee_concession'] = $this->school_m->fee_concession_by_school_id($school_id);

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		$this->data['view'] = 'forms/section_h/section_h';
		$this->load->view('layout', $this->data);
	}

	public function update_form_h_data()
	{




		$school_id = (int) $this->input->post('school_id');
		$session_id = (int) $this->input->post('session_id');


		$this->db->where('school_id', $school_id);
		$this->db->delete('fee_concession');

		$concession_types = $_POST['concession_types'];

		foreach ($concession_types as $concession_type_id => $concession_type) {

			$input['concession_id'] = (int) $concession_type_id;
			$input['percentage'] = (int) $concession_type["percentage"];
			$input['numberOfStudent'] = (int) $concession_type["numberOfStudent"];
			$input['school_id'] = (int) $school_id;
			$this->db->insert('fee_concession', $input);
		}



		//var_dump($_POST);
		$input = array();
		$input['school_id']  = $schools_id  = (int) $this->input->post("schools_id");
		$input['school_session_id']  = $school_id  = (int) $this->input->post("school_id");
		$input['session_id'] = $session_id =  (int) $this->input->post("session_id");
		$input['regional_language'] = $this->input->post("regional_language");
		$input['rl_primary'] =  NULL;
		$input['rl_middle'] = NULL;
		$input['rl_high'] = NULL;
		$input['rl_high_sec'] = NULL;
		$input['comment'] = $this->input->post("comment");
		if ($input['regional_language'] == 'Yes') {
			$languages = $this->input->post("language");
			foreach ($languages as $level_id => $language) {
				if ($level_id == 1) {
					$input['rl_primary'] =  $language;
				}
				if ($level_id == 2) {
					$input['rl_middle'] =  $language;
				}
				if ($level_id == 3) {
					$input['rl_high'] =  $language;
				}
				if ($level_id == 4) {
					$input['rl_high_sec'] = $language;
				}
			}
			$input['comment'] = NULL;
		}

		$levels = $this->input->post("levels");
		foreach ($levels as $level_id => $publisher_id) {
			if ($level_id == 1) {
				$input['primary'] = (int) $publisher_id;
				if ($publisher_id == 'other') {
					$input['primary'] = $this->add_new_publisher($level_id);
				}
			}
			if ($level_id == 2) {
				$input['middle'] = (int) $publisher_id;
				if ($publisher_id == 'other') {
					$input['middle'] = $this->add_new_publisher($level_id);
				}
			}
			if ($level_id == 3) {
				$input['high'] = (int) $publisher_id;
				if ($publisher_id == 'other') {
					$input['middle'] = $this->add_new_publisher($level_id);
				}
			}
			if ($level_id == 4) {
				$input['high_sec'] = (int) $publisher_id;
				if ($publisher_id == 'other') {
					$input['middle'] = $this->add_new_publisher($level_id);
				}
			}
		}
		//check data already inserted or not
		$query = "SELECT COUNT(*) as total FROM textbooks WHERE school_id = '" . $schools_id . "' and session_id = '" . $session_id . "'";
		$count = $this->db->query($query)->row()->total;
		if ($count == 0) {
			//insert data
			$this->db->insert('textbooks', $input);
			$this->session->set_flashdata('msg_success', 'Data insert successfully!');
		} else {
			//update data 
			$where['school_id'] = $schools_id;
			$where['session_id'] = $session_id;
			$this->db->where($where);
			$this->db->update('textbooks', $input);

			$this->session->set_flashdata('msg_success', 'Data updated successfully!');
		}


		$form_input['form_h_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);

		$this->session->set_flashdata('msg', 'Hazards with Associated Risks.');
		$session_id = (int) $this->input->post('session_id');
		redirect("form/section_h/$school_id");
	}

	private function add_new_publisher($level_id)
	{
		//if publisher ID 77 means Other please check and add as new publisher
		$new_publisher_name = $this->input->post($level_id . "_other");

		$query = "SELECT id, COUNT(*) as total 
              FROM publishers 
              WHERE publisher_name = " . $this->db->escape($new_publisher_name);
		$publisher = $this->db->query($query)->row();
		if ($publisher->total == 0) {
			$new_publisher_input['publisher_name'] = $new_publisher_name;
			$this->db->insert('publishers', $new_publisher_input);
			return $this->db->insert_id();
		} else {
			return $publisher->id;
		}
	}

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

	public function submit_bank_challan($school_session_id)
	{



		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);



		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "'
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "' 
	ORDER BY (last_date) ASC
		";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT * FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' 
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';







		if ($school->school_type_id == 1) {

			if ($this->data['school']->reg_type_id == 1) {
				$this->data['view'] = 'forms/submit_bank_challan/registration';
			}
			if ($this->data['school']->reg_type_id == 2) {
				$this->data['view'] = 'forms/submit_bank_challan/renewal';
			}
			if ($this->data['school']->reg_type_id == 4) {
				$this->data['view'] = 'forms/submit_bank_challan/renewal_upgradation';
			}
			if ($this->data['school']->reg_type_id == 3) {
				$this->data['view'] = 'forms/submit_bank_challan/upgradation';
			}
		}
		if ($school->school_type_id == 7) {
			if ($this->data['school']->reg_type_id == 1) {
				$this->data['view'] = 'forms/submit_bank_challan/academy_registration';
			}
			if ($this->data['school']->reg_type_id == 2) {
				$this->data['view'] = 'forms/submit_bank_challan/academy_renewal';
			}
		}



		$this->load->view('layout', $this->data);
	}

	private  function check_school_session_entry($school_id)
	{
		$query = "SELECT * FROM school  WHERE schoolId = '" . $school_id . "'  ";
		$school_session_entry = $this->db->query($query)->result();

		if (!$school_session_entry) {
			//$this->session->set_flashdata('msg_error', 'You are not applied for this session.');
			redirect('school_dashboard');
		} else {
			$school_session_detail = $school_session_entry[0];



			if ($school_session_detail->status != 0) {
				//$this->session->set_flashdata('msg_error', 'You are already applied for this session.');
				redirect("online_application/status/$school_id");
			}
			if ($school_session_detail->status == 0) {
				$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();
				if (is_null($physical_facilities) and $school_session_detail->reg_type_id != 1) {
					$session_id = $school_session_detail->session_year_id;
					redirect("apply/renewal/$session_id/$school_id");
					exit();
				}
			}
		}
	}

	public function complete_section_d($school_id)
	{


		$form_input['form_d_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);
		$this->session->set_flashdata('msg_success', 'Section D Data Submit Successfully.');
		redirect("form/section_d/$school_id");
	}
	public function complete_section_e()
	{
		$school_id = (int) $this->input->post('school_id');
		$feeMentionedInFormId = (int) $this->input->post('feeMentionedInFormId');
		$pro = $this->input->post('pro');
		$outside = $this->input->post('outside');

		if (!$feeMentionedInFormId) {

			$this->db->insert(
				'fee_mentioned_in_form_or_prospectus',
				array(
					'school_id' => $school_id,
					'feeMentionedInForm' => $pro,
					'FeeMentionOutside' => $outside
				)
			);
		} else {
			$this->db->where('feeMentionedInFormId', $feeMentionedInFormId);
			$update_data['feeMentionedInForm'] = $pro;
			$update_data['FeeMentionOutside'] = $outside;
			$this->db->update('fee_mentioned_in_form_or_prospectus', $update_data);
		}



		$form_input['form_e_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);
		$this->session->set_flashdata('msg_success', 'Section E Data Submit Successfully.');
		redirect("form/section_e/$school_id");
	}

	public function submit_application_online($school_id, $schools_id)
	{
		$school_id = (int) $school_id;
		$schools_id = (int) $schools_id;
		$query = "SELECT owner_id FROM schools WHERE schoolId = '" . $schools_id . "'";
		$owner_id = $this->db->query($query)->result()[0]->owner_id;
		$userId = $this->session->userdata('userId');
		if ($owner_id == $userId) {
			$date = date('Y-m-d H:i:s');
			$query = "UPDATE school set status = '2', file_status='1', `visit` = 'No',  apply_date ='" . $date . "', updatedDate ='" . $date . "' WHERE schoolId = '" . $school_id . "' and schools_id = '" . $schools_id . "'";
			if ($this->db->query($query)) {
				$query = "SELECT reg_type_id, upgradation_levels, level_of_school_id 
				FROM school 
				WHERE schools_id ='" . $schools_id . "' 
				AND schoolId = '" . $school_id . "'";
				$apply_detail = $this->db->query($query)->row();
				if ($apply_detail->reg_type_id == 1 or $apply_detail->reg_type_id == 4) {
					$input["schools_id"] = $schools_id;
					$input["school_id"] = $school_id;

					if ($apply_detail->reg_type_id == 1) {
						$input["visit_reason"] = 'New Registration';
					} elseif ($apply_detail->reg_type_id == 4) {
						$input["visit_reason"] = 'Upgradation';
					}

					$upgradation_levels = $apply_detail->upgradation_levels;
					$levels_array = explode(",", $upgradation_levels);
					$input["primary_l"] = 0;
					$input["middle_l"] = 0;
					$input["high_l"] = 0;
					$input["high_sec_l"] = 0;
					$input["academy_l"] = 0;
					if ($apply_detail->level_of_school_id == 1) {
						$input["primary_l"] = 1;
					}
					if ($apply_detail->level_of_school_id == 2) {
						$input["middle_l"] = 1;
					}
					if ($apply_detail->level_of_school_id == 3) {
						$input["high_l"] = 1;
					}
					if ($apply_detail->level_of_school_id == 4) {
						$input["high_sec_l"] = 1;
					}
					if ($apply_detail->level_of_school_id == 5) {
						$input["academy_l"] = 1;
					}

					if ($apply_detail->upgradation_levels) {
						if (in_array("1", $levels_array)) {
							$input["primary_l"] = 1;
						}
						if (in_array("2", $levels_array)) {
							$input["middle_l"] = 1;
						}
						if (in_array("3", $levels_array)) {
							$input["high_l"] = 1;
						}
						if (in_array("4", $levels_array)) {
							$input["high_sec_l"] = 1;
						}
						if (in_array("5", $levels_array)) {
							$input["academy_l"] = 1;
						}
					}
					$input["visited"] = 'No';

					$inputs =  (object) $input;
					$inputs->created_by = $this->session->userdata("userId");
					$this->db->insert("visits", $inputs);
				}
				$this->session->set_flashdata('msg_success', 'online application request submitted.');
			} else {
				$this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
			}
		} else {
			$this->session->set_flashdata('msg_error', "You are not allowed to submit the application.");
		}
		redirect("form/submit_bank_challan/$school_id");
	}

	public function remove_bank_challan($school_id, $challan_id)
	{
		$school_id = (int) $school_id;
		$challan_id = (int) $challan_id;
		$query = "DELETE FROM bank_transaction WHERE bt_id = '" . $challan_id . "' and school_id = '" . $school_id . "'";
		if ($this->db->query($query)) {
			$this->session->set_flashdata('msg_success', 'Bank Challan Delete Successfully.');
		} else {
			$this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
		}
		redirect("form/submit_bank_challan/$school_id");
	}



	public function add_bank_challan()
	{
		if ($this->input->post('submit') == 'Add Challan') {
			$challan_data = array();
			$challan_data['school_id'] = $school_id = (int) $this->input->post('school_id');
			$challan_data['schools_id'] = (int) $this->input->post('schools_id');
			$challan_data['session_id'] = (int) $this->input->post('session_id');
			$challan_data['bt_no'] = $this->input->post('challan_no');
			$challan_data['bt_date'] = $this->input->post('challan_date');
			$challan_data['reg_type_id'] = (int) $this->input->post('reg_type_id');
			// if ($this->input->post('challan_for') == 'Registration') {
			// 	$challan_data['reg_type_id'] = 1;
			// }
			$this->db->insert('bank_transaction', $challan_data);
			redirect("form/submit_bank_challan/$school_id");
		}


		// $session_id = (int) $this->input->post('session_id');
		// $userId = $this->session->userdata('userId');

		// $schools_id = (int) $this->input->post('schools_id');
		// $school_id = (int) $this->input->post('school_id');

		// $challan_detail['challan_for'] = $this->input->post('challan_for');
		// $challan_detail['challan_no'] = $this->input->post('challan_no');
		// $challan_detail['challan_date'] = $this->input->post('challan_date');
		// $challan_detail['session_id'] = $session_id;
		// $challan_detail['schools_id'] = $schools_id;
		// $challan_detail['school_id'] = $school_id;
		// $challan_detail['created_by'] = $userId;
		// if ($this->input->post('challan_for') == 'Deficiency') {
		// 	$challan_detail['deficiency_id'] = $this->input->post('deficiency_id');
		// 	$challan_detail['last_status'] = $this->input->post('last_status');
		// }

		// $this->db->insert('bank_challans', $challan_detail);
		// $this->db->where('schoolId', $school_id);
		// $input['status'] = 2;
		// $this->db->update('school', $input);


		// $schools_id = (int) $this->input->post('schools_id');
		// $school_id = (int) $this->input->post('school_id');

		// $query = "SELECT owner_id FROM schools WHERE schoolId = '" . $schools_id . "'";
		// $owner_id = $this->db->query($query)->result()[0]->owner_id;
		// $userId = $this->session->userdata('userId');
		// if ($owner_id == $userId) {
		// 	$date = date('Y-m-d H:i:s');
		// 	$query = "UPDATE school set status = '2', file_status='1', apply_date ='" . $date . "', updatedDate ='" . $date . "' WHERE schoolId = '" . $school_id . "' and schools_id = '" . $schools_id . "'";
		// 	if ($this->db->query($query)) {
		// 		$this->session->set_flashdata('msg_success', 'online application request submitted.');
		// 	} else {
		// 		$this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
		// 	}
		// } else {
		// 	$this->session->set_flashdata('msg_error', "You are not allowed to submit the application.");
		// }

	}

	public function print_registration_bank_challan($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "'
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` 
		          WHERE session_id = '" . $session_id . "'
				 AND school_type_id = '" . $school->school_type_id . "' 
				  ";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, 
		renewal_app_inspection_fee, renewal_fee FROM `fee_structure` 
		WHERE fee_min <= $max_tuition_fee  
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



		$this->data['title'] = "Registration";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/registration_bank_challan_print', $this->data);
	}

	public function academy_bank_challan_print($school_session_id)
	{


		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);



		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "'
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "' 
		ORDER BY (last_date) ASC
		";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT * FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' 
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



		$this->data['title'] = "Registration";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/academy_bank_challan_print', $this->data);
	}

	public function academy_renewal_challan_print($school_session_id)
	{


		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);



		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "'
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "' 
		ORDER BY (last_date) ASC
		";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT * FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' 
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



		$this->data['title'] = "Registration";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/academy_renewal_challan_print', $this->data);
	}

	public function update_test_date()
	{

		$school_id = (int) $this->input->post("school_id");
		$schools_id = (int) $this->input->post("schools_id");


		if ($this->input->post('level')) {
			$this->db->where('schoolId', $schools_id);
			$school_update['level_of_school_id'] = $this->input->post('level');
			$this->db->update('schools', $school_update);

			$this->db->where('schoolId', $school_id);
			$school_update['level_of_school_id'] = $this->input->post('level');
			$this->db->update('school', $school_update);
		}



		if ($this->input->post('max_fee') >= 0) {
			$this->db->where('school_id', $school_id);
			$fee['tuitionFee'] = $this->input->post('max_fee');
			$this->db->update('fee', $fee);
		}

		if ($this->input->post('year_of_es')) {
			$est_date = $this->input->post('year_of_es');
			$est_year = date('Y', strtotime($est_date));
			$est_month = date('m', strtotime($est_date));
			if ($est_month >= 4) {
				$session_year = $est_year;
			} else {
				$session_year = $est_year - 1;
			}



			$query = "SELECT `sessionYearId` FROM `session_year` WHERE YEAR(`session_start`) >= '" . $session_year . "'";
			$session_id = $this->db->query($query)->result()[0]->sessionYearId;

			$this->db->where('schoolId', $school_id);
			$school_update['session_year_id'] = $session_id;
			$this->db->update('school', $school_update);


			$this->db->where('schoolId', $schools_id);
			$schools_update['yearOfEstiblishment'] = $this->input->post('year_of_es');
			$this->db->update('schools', $schools_update);
		}
		redirect("form/submit_bank_challan/$school_id");
	}

	public function update_test_renewal($session_id)
	{

		$school_id = (int) $this->input->post("school_id");
		$schools_id = (int) $this->input->post("schools_id");




		if ($this->input->post('max_fee') >= 0) {
			$this->db->where('school_id', $school_id);
			$fee['tuitionFee'] = $this->input->post('max_fee');
			$this->db->update('fee', $fee);
		}


		redirect("form/submit_bank_challan/$school_id");
	}



	public function print_renewal_bank_challan($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` 
		WHERE session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "' ";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT * FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' 
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];

		$this->data['title'] = "Renewal";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/renewal_bank_challan_print', $this->data);
	}

	public function print_renewal_upgradation_bank_challan($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id 
					   AND school_type_id = '" . $school->school_type_id . "' 
					   AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE 
		session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "' ";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee , up_grad_fee
		FROM `fee_structure` WHERE fee_min <= $max_tuition_fee 
		AND school_type_id = '" . $school->school_type_id . "'
		ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = "Upgradataion + Renewal";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/renewal_upgradation_bank_challan_print', $this->data);
	}

	public function print_upgradation_bank_challan($school_session_id)
	{
		$this->check_school_session_entry($school_session_id);

		$userId = $this->session->userdata('userId');
		$this->data['school'] = $school = $this->school_detail($school_session_id);
		$this->data['school_id'] =  $school_id = $school->school_id;
		$this->data['schools_id'] =  $school->schools_id;
		$this->data['session_id']  = $session_id = $school->session_id;

		$this->data['session_detail'] = $this->get_session_detail($session_id);
		$this->data['form_status'] = $this->get_form_status($school_id);

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id 
					   AND last_date >='" . date('Y-m-d') . "' 
					   AND school_type_id = '" . $school->school_type_id . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` 
		WHERE session_id = '" . $session_id . "'
		AND school_type_id = '" . $school->school_type_id . "'";

		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee, up_grad_fee 
		FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = "Upgradataion";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/upgradation_bank_challan_print', $this->data);
	}

	public function renewal_fee_sturucture()
	{


		$school_type_id = (int) $this->input->post('school_type_id');
		$this->data['school_type_id'] = (int) $school_type_id;
		$query = "SELECT * FROM `fee_structure` 
		          WHERE school_type_id = '" . $school_type_id . "' 
				  ORDER BY fee_max ASC";
		$this->data['fee_structures'] = $this->db->query($query)->result();
		if ($school_type_id == 1) {
			$this->load->view('forms/fee_structures/renewal_fee_sturucture', $this->data);
		}
		if ($school_type_id == 7) {
			$this->load->view('forms/fee_structures/academey_fee_sturucture', $this->data);
		}
	}

	public function upload_affidavit($school_id)
	{

		$config = array(
			"upload_path" => $_SERVER['DOCUMENT_ROOT'] . '/uploads/affidavits/',
			"allowed_types" => "jpg|jpeg|pdf",
			"max_size" => 30000,
			"max_width" => 0,
			"max_height" => 0,
			"remove_spaces" => true,
			"encrypt_name" => true
		);
		$upload = $this->upload_file("affidavit", $config);
		if ($upload === True) {
			$attchment_file = $this->data["upload_data"]["file_name"];
			$userId = $this->session->userdata('userId');
			$query = "SELECT schoolId FROM schools WHERE owner_id = '" . $userId . "'";
			$schools_id = $this->db->query($query)->row()->schoolId;

			$query = "INSERT INTO `affidavit_attachments`(`folder`, `attachment`, `schools_id`, `school_id`) 
		          VALUES ('affidavits','" . $attchment_file . "', '" . $schools_id . "', '" . $school_id . "')";
			if ($this->db->query($query)) {
				redirect("form/submit_bank_challan/$school_id");
			} else {
				redirect("form/submit_bank_challan/$school_id");
			}
		} else {
			//var_dump($upload);
			//$attchment_file = "";
			redirect("form/submit_bank_challan/$school_id");
		}

		exit();
	}
}
