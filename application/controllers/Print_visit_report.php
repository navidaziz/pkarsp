<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Print_visit_report extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
	}



	public function  visit_report($school_id)
	{
		$school_id = (int) $school_id;
		$this->data['school_id'] = $school_id;
		$this->data['school'] = $this->school_m->explore_schools_by_school_id_m($school_id);
		$this->data['school_bank'] = $this->school_m->get_bank_by_school_id($school_id);
		$this->load->model("general_modal");
		$this->data['buildings'] = $this->general_modal->building();
		$this->data['physical'] = $this->general_modal->physical();
		$this->data['academics'] = $this->general_modal->academic();
		$this->data['book_types'] = $this->general_modal->book_type();
		$this->data['co_curriculars'] = $this->general_modal->co_curricular();
		$this->data['other'] = $this->general_modal->other();
		$this->data['school_physical_facilities'] = $this->school_m->physical_facilities_by_school_id($school_id);

		$this->data['school_physical_facilities_physical'] = $school_physical_facilities_physical = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$physical_ids = array();
		foreach ($school_physical_facilities_physical as $ph_obj) {
			$physical_ids[] = $ph_obj->pf_physical_id;
		}
		$this->data['facilities_physical_ids'] = $physical_ids;

		$this->data['school_physical_facilities_academic'] = $school_physical_facilities_academic  = $this->school_m->physical_facilities_academic_by_school_id($school_id);

		$academic_ids = array();
		foreach ($school_physical_facilities_academic as $acad_obj) {
			$academic_ids[] = $acad_obj->academic_id;
		}
		$this->data['academic_ids'] = $academic_ids;

		$this->data['school_physical_facilities_co_curricular'] = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$this->data['school_physical_facilities_other'] = $this->school_m->physical_facilities_other_by_school_id($school_id);
		$this->data['school_library'] = $this->school_m->get_library_books_by_school_id($school_id);


		$this->data['age_and_class'] = $this->school_m->get_age_and_class_by_school_id($school_id);
		// $school_bank = $this->school_m->get_bank_by_school_id($school_id);


		$staff_query = "SELECT
                            `school_staff`.`schoolStaffId`
                            , `school_staff`.`schoolStaffName`
                            , `school_staff`.`schoolStaffFatherOrHusband`
                            , `school_staff`.`schoolStaffCnic`
                            , `school_staff`.`schoolStaffQaulificationProfessional`
                            , `school_staff`.`schoolStaffQaulificationAcademic`
                            , `school_staff`.`schoolStaffAppointmentDate`
                            , `school_staff`.`schoolStaffDesignition`
                            , `school_staff`.`schoolStaffNetPay`
                            , `school_staff`.`schoolStaffAnnualIncreament`
                            , `school_staff`.`schoolStaffType`
                            , `school_staff`.`schoolStaffType`
                            , `school_staff`.`schoolStaffType`
                            , `staff_type`.`staffTtitle`
                            , `school_staff`.`schoolStaffGender`
                            , `gender`.`genderTitle`
                            , `school_staff`.`TeacherTraining`
                            , `school_staff`.`TeacherExperience`
                            , `school_staff`.`school_id`
                        FROM
                            `school_staff`
                            INNER JOIN `staff_type` 
                                ON (`school_staff`.`schoolStaffType` = `staff_type`.`staffTypeId`)
                            INNER JOIN `gender` 
                                ON (`school_staff`.`schoolStaffGender` = `gender`.`genderId`)
                            WHERE school_id = '" . $school_id . "'
							AND `school_staff`.`schoolStaffType` = 2
							ORDER BY `school_staff`.`schoolStaffName` ASC;";
		$this->data['non_teaching_staffs'] =  $this->db->query($staff_query)->result();

		$staff_query = "SELECT
                            `school_staff`.`schoolStaffId`
                            , `school_staff`.`schoolStaffName`
                            , `school_staff`.`schoolStaffFatherOrHusband`
                            , `school_staff`.`schoolStaffCnic`
                            , `school_staff`.`schoolStaffQaulificationProfessional`
                            , `school_staff`.`schoolStaffQaulificationAcademic`
                            , `school_staff`.`schoolStaffAppointmentDate`
                            , `school_staff`.`schoolStaffDesignition`
                            , `school_staff`.`schoolStaffNetPay`
                            , `school_staff`.`schoolStaffAnnualIncreament`
                            , `school_staff`.`schoolStaffType`
                            , `school_staff`.`schoolStaffType`
                            , `school_staff`.`schoolStaffType`
                            , `staff_type`.`staffTtitle`
                            , `school_staff`.`schoolStaffGender`
                            , `gender`.`genderTitle`
                            , `school_staff`.`TeacherTraining`
                            , `school_staff`.`TeacherExperience`
                            , `school_staff`.`school_id`
                        FROM
                            `school_staff`
                            INNER JOIN `staff_type` 
                                ON (`school_staff`.`schoolStaffType` = `staff_type`.`staffTypeId`)
                            INNER JOIN `gender` 
                                ON (`school_staff`.`schoolStaffGender` = `gender`.`genderId`)
                            WHERE school_id = '" . $school_id . "'
							AND `school_staff`.`schoolStaffType` = 1
							ORDER BY `school_staff`.`schoolStaffName` ASC;";
		$this->data['teaching_staffs'] =  $this->db->query($staff_query)->result();


		//$this->data['school_staff'] = $this->school_m->staff_by_school_id($school_id); 

		$this->data['school_fee'] = $this->school_m->fee_by_school_id($school_id);
		$this->data['school_fee_mentioned_in_form'] = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		//var_dump($this->data['school_fee_mentioned_in_form']);exit;

		$this->data['school_security_measures'] = $this->school_m->security_measures_by_school_id($school_id);

		$this->data['school_hazards_with_associated_risks'] = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		$this->data['hazards_with_associated_risks_unsafe_list'] = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);

		$this->data['school_fee_concession'] = $this->school_m->fee_concession_by_school_id($school_id);
		$this->data['schoolId'] = $school_id;
		$this->data['title'] = 'school details';
		$query = $this->db->query("SELECT * FROM bank_transaction where school_id = '" . $school_id . "'");
		$this->data['bank_transaction'] = $query->result_array();

		$this->data['title'] = 'Apply For ' . $this->registaion_type($this->data['school']->reg_type_id);
		$this->data['description'] = 'Section B (Physical Facilities)';

		$this->load->view('print/visit_report', $this->data);
	}

	public function  visit_proforma()
	{
		$this->data['school_security_measures'] = $this->school_m->security_measures_by_school_id(0);

		$this->data['school_hazards_with_associated_risks'] = $this->school_m->hazards_with_associated_risks_by_school_id(0);
		$this->data['hazards_with_associated_risks_unsafe_list'] = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id(0);

		$this->load->view('print/visit_proforma', $this->data);
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

	function google_map()
	{
		$this->load->view('print/google_map', $this->data);
	}

	public function calculate()
	{

		// Replace 'YOUR_API_KEY' with your actual Google Maps API key
		$api_key = 'AIzaSyCTbYZF_kDxKNopcvej6oh-eVs1z9Xq2J0';

		// Example coordinates
		$origins = '35.9126911,71.8051538';

		$query = "SELECT coordinate_latitude,coordinate_longitude FROM schools 
          WHERE coordinate_longitude IS NOT NULL and coordinate_latitude IS NOT NULL
          and district_id =13 
          ";
		$coordinates = $this->db->query($query)->result();
		$destinations = "";
		foreach ($coordinates as $coordinate) {
			$destinations .= $coordinate->coordinate_latitude . "," . $coordinate->coordinate_longitude . "|";
		}

		echo $destinations;


		// Build the API request URL
		$request_url = "https://maps.googleapis.com/maps/api/distancematrix/json";
		$request_url .= "?origins=" . urlencode($origins);
		$request_url .= "&destinations=" . urlencode($destinations);
		$request_url .= "&key=" . $api_key;

		// Initialize cURL session
		$ch = curl_init();

		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Execute cURL session and get the response
		$response = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			echo 'Curl error: ' . curl_error($ch);
		}

		// Close cURL session
		curl_close($ch);

		// Decode the JSON response
		$data = json_decode($response, true);

		// Check if the request was successful
		if ($data['status'] === 'OK') {
			// Extract distance information or any other relevant data from $data
			$distance = $data['rows'][0]['elements'][0]['distance']['text'];
			echo "Total Distance: $distance\n";
		} else {
			// Handle the error
			echo "Error: " . $data['status'] . "\n";
		}
	}
}
