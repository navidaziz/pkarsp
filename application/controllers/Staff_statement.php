<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff_statement extends Admin_Controller
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

	public function staff_list()
	{

		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId as schools_id FROM schools WHERE owner_id = $userId";
		$school = $this->db->query($query)->row();
		$this->data['schools_id'] = $school->schools_id;
		$query = "SELECT count(*) as total FROM school as s
		INNER JOIN session_year as sy ON(sy.sessionYearId = s.session_year_id) 
		          WHERE  s.schools_id = ? AND sy.status=1";
		$session_count = $this->db->query($query, array($school->schools_id))->row()->total;
		if ($session_count > 0) {

			$query = "SELECT s.schoolId as school_id, s.session_year_id FROM school as s
			INNER JOIN session_year as sy ON(sy.sessionYearId = s.session_year_id) 
		          WHERE  s.schools_id = ? AND sy.status=1";
			$school_session = $this->db->query($query, array($school->schools_id))->row();
			$school_id = $school_session->school_id;
			$this->data['school_id'] = $school_id;
			$this->data['session_id'] = $school_session->session_year_id;
			$query = "SELECT *, gender.genderTitle, staff_type.staffTtitle  
			          FROM school_staff, gender, staff_type 
				      WHERE school_staff.schoolStaffType = staff_type.staffTypeId
				      AND  school_staff.schoolStaffGender = gender.genderId
				      AND school_id ='" . $school_id . "' 
				      ORDER BY `school_staff`.`schoolStaffName` ASC";
			$this->data['school_staff'] = $this->db->query($query)->result();
			$this->data['school'] = $this->school_detail($school_id);
			$this->load->model("school_m");
			$this->data['gender'] = $this->school_m->get_gender();
			$this->data['staff_type'] = $this->school_m->get_staff_type();
			$this->data['title'] = 'Staff Statement';
			$this->data['description'] = 'list of current session staff detail';
			$this->data['view'] = 'section_d/section_d';
			$this->load->view('layout', $this->data);
		} else {
			echo "School Session Not Found.";
		}
		//exit();



		// $this->data['school_id'] =  $school_id = $school->school_id;
		// $this->data['schools_id'] =  $school->schools_id;
		// $this->data['session_id']  = $session_id = $school->session_id;

		// $this->data['session_detail'] = $this->get_session_detail($session_id);
		// $this->data['form_status'] = $this->get_form_status($school_id);
	}

	public function add_employee_data()
	{
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
			redirect("staff_statement/staff_list");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("staff_statement/staff_list");
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
		$this->load->view('section_d/get_employee_edit_form', $this->data);
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
			redirect("staff_statement/staff_list");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("staff_statement/staff_list");
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
			redirect("staff_statement/staff_list");
		} else {
			$this->session->set_flashdata('msg', 'Error Try Again');
			redirect("staff_statement/staff_list");
		}
	}
}
