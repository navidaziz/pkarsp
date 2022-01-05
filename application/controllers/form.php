<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Form extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
	}


	public function index()
	{
		echo "Welcome to PSRA...";
	}



	public function section_b($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
					, `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];


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

	public function section_d($session_id)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

		$query = "SELECT *, gender.genderTitle, staff_type.staffTtitle  FROM school_staff, gender, staff_type 
				  WHERE school_staff.schoolStaffType = staff_type.staffTypeId
				  AND  school_staff.schoolStaffGender = gender.genderId
				  AND school_id ='" . $school_id . "'";
		$this->data['school_staff'] = $this->db->query($query)->result();
		$this->load->model("school_m");
		$this->data['gender'] = $this->school_m->get_gender();
		$this->data['staff_type'] = $this->school_m->get_staff_type();
		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section D (School Employees Detail)';
		$this->data['view'] = 'forms/section_d/section_d';
		$this->load->view('layout', $this->data);
	}

	public function section_e($session_id)
	{

		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`level_of_school_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

		$query = "SELECT classes_ids FROM `levelofinstitute`  WHERE levelofInstituteId='" . $this->data['school']->level_of_school_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";
		$this->data['classes'] = $this->db->query($query)->result();

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section E (School Fee Detail)';
		$this->data['view'] = 'forms/section_e/section_e';
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
			'school_id' => $posts['school_id']
		);




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

		//update form ......

		$form_input['form_b_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);


		$this->session->set_flashdata('msg', 'Facility Detail Added Successfully.');
		$session_id = (int) $this->input->post('session_id');
		redirect("form/section_b/$session_id");
	}



	public function add_employee_date()
	{

		// $posts = $this->input->post();
		// foreach ($posts as $variable => $post) {
		// 	echo '$input["' . $variable . '"] = $this->input->post("' . $variable . '");' . "<br />";
		// }
		//$input["schools_id"] = $this->input->post("schools_id");
		$session_id = (int) $this->input->post("session_id");
		$input["school_id"] = (int) $this->input->post("school_id");

		$input["schoolStaffName"] = $this->input->post("schoolStaffName");
		$input["schoolStaffFatherOrHusband"] = $this->input->post("schoolStaffFatherOrHusband");
		$input["schoolStaffCnic"] = $this->input->post("schoolStaffCnic");
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

		$this->db->insert('school_staff', $input);
		$insert_id = $this->db->insert_id();
		if ($insert_id) {
			$this->session->set_flashdata('msg', 'Employee Detail Added Successfully.');
			redirect("form/section_d/$session_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$session_id");
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
		//$school_id = (int) $this->input->post("school_id");
		//$input["schools_id"] = (int) $this->input->post("schools_id");
		$schoolStaffId = (int) $this->input->post("schoolStaffId");

		$input["schoolStaffName"] = $this->input->post("schoolStaffName");
		$input["schoolStaffFatherOrHusband"] = $this->input->post("schoolStaffFatherOrHusband");
		$input["schoolStaffCnic"] = $this->input->post("schoolStaffCnic");
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

		$this->db->where('schoolStaffId', $schoolStaffId);;
		if ($this->db->update('school_staff', $input)) {
			$this->session->set_flashdata('msg', 'Employee Detail Update Successfully.');
			redirect("form/section_d/$session_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$session_id");
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
			redirect("form/section_d/$session_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("form/section_d/$session_id");
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

		$this->session->set_flashdata('msg', 'Class Fee Detail Add Successfully.');
		redirect("form/section_e/$session_id");
	}

	public function section_c($session_id)
	{

		//new here 


		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`level_of_school_id`
					, `schools`.`gender_type_id` , 
					`school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];
		$level_of_school_id = $this->data['school']->level_of_school_id;
		$query = "SELECT classes_ids FROM `levelofinstitute` 
		          WHERE levelofInstituteId='" . $level_of_school_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

		$this->data['classes'] = $this->db->query($query)->result();
		$this->data['ages'] = $this->db->query("SELECT * FROM age")->result();

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		$this->data['view'] = 'forms/section_c/section_c';
		$this->load->view('layout', $this->data);
	}

	public function add_classes_ages()
	{

		$session_id = $this->input->post("session_id");
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
		redirect("form/section_c/$session_id");
	}



	public function section_f($session_id)
	{

		//new here 


		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

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
			redirect("form/section_f/$session_id");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_f/$session_id");
		}
	}


	public function section_g($session_id)
	{

		//new here 


		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

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
			redirect("form/section_g/$session_id");
		} else {
			$this->session->set_flashdata('msg', 'Hazards with Associated Risks.');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_g/$session_id");
		}
	}

	public function section_h($session_id)
	{

		//new here 


		$this->data['session_id'] = $session_id = (int) $session_id;
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

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

		$form_input['form_h_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);

		$this->session->set_flashdata('msg', 'Hazards with Associated Risks.');
		$session_id = (int) $this->input->post('session_id');
		redirect("form/section_h/$session_id");
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

	public function submit_bank_challan($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , 
					`school`.`reg_type_id`
					, `school`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT MAX(tuitionFee) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee 
		FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = '';
		if ($this->data['school']->reg_type_id == 1) {
			$this->data['view'] = 'forms/submit_bank_challan/registration';
		}
		if ($this->data['school']->reg_type_id == 2) {
			$this->data['view'] = 'forms/submit_bank_challan/renewal';
		}
		$this->load->view('layout', $this->data);
	}

	private  function check_school_session_entry($session_id, $school_id)
	{
		$query = "SELECT * FROM school 
		          WHERE schools_id = '" . $school_id . "' 
				  AND session_year_id= '" . $session_id . "'";
		$school_session_entry = $this->db->query($query)->result();


		if (!$school_session_entry) {
			$this->session->set_flashdata('msg_error', 'You are not applied for this session.');
			redirect('school_dashboard');
		} else {
			$school_session_detail = $school_session_entry[0];
			if ($school_session_detail->status != 0) {
				redirect("online_application/status/$session_id");
			}
		}
	}

	public function complete_section_d($session_id)
	{
		$session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`,
		`school`.`schools_id` FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$form_input['form_d_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);
		$this->session->set_flashdata('msg_success', 'Section D Data Submit Successfully.');
		redirect("form/section_d/$session_id");
	}
	public function complete_section_e($session_id)
	{
		$session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`,
		`school`.`schools_id` FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";
		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$form_input['form_e_status'] = 1;
		$this->db->where('school_id', $school_id);
		$this->db->update('forms_process', $form_input);
		$this->session->set_flashdata('msg_success', 'Section D Data Submit Successfully.');
		redirect("form/section_e/$session_id");
	}


	public function add_bank_challan()
	{
		$session_id = (int) $this->input->post('session_id');
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`,
		`school`.`schools_id` FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";

		$this->data['school'] =  $this->db->query($query)->result()[0];

		$schools_id = $this->data['school']->schools_id;
		$school_id = $this->data['school']->school_id;

		$challan_detail['challan_for'] = $this->input->post('challan_for');
		$challan_detail['challan_no'] = $this->input->post('challan_no');
		$challan_detail['challan_date'] = $this->input->post('challan_date');
		$challan_detail['session_id'] = $session_id;
		$challan_detail['schools_id'] = $schools_id;
		$challan_detail['school_id'] = $school_id;
		$challan_detail['created_by'] = $userId;

		$this->db->insert('bank_challans', $challan_detail);
		$this->db->where('schoolId', $school_id);
		$input['status'] = 2;
		$this->db->update('school', $input);
		$this->session->set_flashdata('msg_success', 'Bank Challan Submit Successfully.');
		redirect("form/submit_bank_challan/$session_id");
	}

	public function print_registration_bank_challan($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT MAX(tuitionFee) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = "Registration";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/registration_bank_challan_print', $this->data);
	}

	public function update_test_date()
	{

		$school_id = (int) $this->input->post("school_id");
		$schools_id = (int) $this->input->post("schools_id");


		if ($this->input->post('level')) {
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
		redirect("form/submit_bank_challan/$session_id");
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


		redirect("form/submit_bank_challan/$session_id");
	}


	public function print_renewal_bank_challan($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` 
		                                                  WHERE sessionYearId = $session_id")->result()[0];
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id`
					, `schools`.`schoolId` AS `schools_id`
					, `school`.`session_year_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`district_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id` , `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$this->check_school_session_entry($session_id, $this->data['school']->schools_id);

		$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
		$this->data['form_status'] = $this->db->query($query)->result()[0];

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT MAX(tuitionFee) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
			'/[^0-9.]/',
			'',
			$this->db->query($query)->result()[0]->max_tution_fee
		);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];


		$this->data['title'] = "Renewal";
		$this->data['description'] = '';
		$this->load->view('forms/submit_bank_challan/renewal_bank_challan_print', $this->data);
	}
}
