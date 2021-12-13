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
					, `schools`.`gender_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;





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

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Section B (Physical Facilities)';
		$this->data['view'] = 'forms/section_b/section_b';
		$this->load->view('layout', $this->data);
	}


	public function update_form_b_data()
	{
		$posts = $this->input->post();
		if (!isset($posts['numberOfComputer'])) {
			$numberOfComputer = "";
		} else {
			$numberOfComputer = $posts['numberOfComputer'];
		}
		// // var_dump($posts);
		// exit();
		$validation_config = array(
			array(
				'field' =>  'building_id',
				'label' =>  'School Building',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'numberOfClassRoom',
				'label' =>  'Number Of Class Rooms',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'numberOfOtherRoom',
				'label' =>  'Number Of Other Rooms',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'totalArea',
				'label' =>  'Total Area',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'coveredArea',
				'label' =>  'Covered Area',
				'rules' =>  'trim|required'
			)
		);

		$this->form_validation->set_rules($validation_config);
		if ($this->form_validation->run() === TRUE) {
			$posts = $this->input->post();
			$school_id = $posts['school_id'];
			$mainData = array(
				'building_id' => $posts['building_id'],
				'numberOfClassRoom' => $posts['numberOfClassRoom'],
				'numberOfOtherRoom' => $posts['numberOfOtherRoom'],
				'rent_amount' => $posts['rent_amount'],
				'totalArea' => $posts['totalArea'],
				'coveredArea' => $posts['coveredArea'],
				'numberOfComputer' => $numberOfComputer,
				'numberOfLatrines' => $posts['numberOfLatrines'],
				'school_id' => $posts['school_id']
			);


			$this->db->where('physicalFacilityId', $posts['physicalFacilityId'])->update('physical_facilities', $mainData);
			$affected_row = $this->db->affected_rows();

			$this->db->where('school_id', $school_id);
			$this->db->delete(array('physical_facilities_physical', 'physical_facilities_academic', 'physical_facilities_co_curricular', 'physical_facilities_others'));


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
		} else {

			$this->session->set_flashdata('msg', 'Error Try Again With Valid Data');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_b/$session_id");
		}
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
					, `schools`.`gender_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$query = "SELECT * FROM school_staff WHERE school_id ='" . $school_id . "'";
		$this->data['school_staff'] = $this->db->query($query)->result();

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Section D (School Employees Detail)';
		$this->data['view'] = 'forms/section_d/section_d';
		$this->load->view('layout', $this->data);
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
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id`
					, `schools`.`level_of_school_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$query = "SELECT classes_ids FROM `levelofinstitute`  WHERE levelofInstituteId='" . $this->data['school']->level_of_school_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";
		$query = "SELECT * FROM class ";
		$this->data['classes'] = $this->db->query($query)->result();

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Section E (School Fee Detail)';
		$this->data['view'] = 'forms/section_e/section_e';
		$this->load->view('layout', $this->data);
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

		$input['school_id'] = $this->input->post('school_id');
		$input['class_id'] = $this->input->post('class_id');
		$input['addmissionFee'] = $this->input->post('addmissionFee');
		$input['tuitionFee'] = $this->input->post('tuitionFee');
		$input['securityFund'] = $this->input->post('securityFund');
		$input['otherFund'] = $this->input->post('otherFund');
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
					, `schools`.`school_type_id`
					, `schools`.`gender_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;

		$school_type_id = $this->data['school']->school_type_id;
		$gender_type_id = $this->data['school']->gender_type_id;
		$query = "SELECT classes_ids FROM `levelofinstitute` 
		          WHERE levelofInstituteId='" . $school_type_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

		$this->data['classes'] = $this->db->query($query)->result();
		$this->data['ages'] = $this->db->query("SELECT * FROM age")->result();

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Apply For Renewal';
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

		$class_ages = array_filter($this->input->post("class_age"));

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
					, `schools`.`gender_type_id`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$this->load->model("school_m");
		$this->data['security_status'] = $this->school_m->get_security_status();
		$this->data['security_provided'] = $this->school_m->get_security_provided();
		$this->data['security_personnel'] = $this->school_m->get_security_personnel();
		$this->data['security_license_issued'] = $this->school_m->get_security_license_issued();

		$this->data['school_security_measures'] = $this->db->where('school_id', $school_id)->get('security_measures')->result()[0];

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Apply For Renewal';
		$this->data['view'] = 'forms/section_f/section_f';
		$this->load->view('layout', $this->data);
	}

	public function update_from_f_data()
	{
		$session_id = (int) $this->input->post('session_id');
		$securityMeasureId = $this->input->post('securityMeasureId');
		$posts = $this->input->post();
		unset($posts['securityMeasureId']);
		unset($posts['school_id']);
		// var_dump($posts);
		unset($posts['session_id']);
		// var_dump($posts);
		// exit();
		$validation_config = array(
			array(
				'field' =>  'securityStatus',
				'label' =>  'Security Status',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'securityProvided',
				'label' =>  'Security Provided',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'exitDoorsNumber',
				'label' =>  'Exit Doors Number',
				'rules' =>  'trim|required'
			),
			array(
				'field' =>  'watchTower',
				'label' =>  'watch Tower',
				'rules' =>  'trim|required'
			)
		);

		$this->form_validation->set_rules($validation_config);
		if ($this->form_validation->run() === TRUE) {
			// $staff_info = $this->input->post();
			$this->db->where('securityMeasureId', $securityMeasureId)->update('security_measures', $posts);
			$affected_row = $this->db->affected_rows();
			$arr = array();

			if ($affected_row) {

				$this->session->set_flashdata('msg', 'Security Measures Successfully Changed.');
				$session_id = (int) $this->input->post('session_id');
				redirect("form/section_f/$session_id");
			} else {
				$this->session->set_flashdata('msg', 'Error Try Again');
				$session_id = (int) $this->input->post('session_id');
				redirect("form/section_f/$session_id");
			}
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			$session_id = (int) $this->input->post('session_id');
			redirect("form/section_f/$session_id");
		}
	}
}
