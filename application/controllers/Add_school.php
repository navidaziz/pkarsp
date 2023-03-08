<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//class Add_school extends Admin_Controller
class Add_school extends MY_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("user_model");
		$this->load->model("user_m");
		//$this->lang->load("users", 'english');
		//$this->lang->load("system", 'english');

		//$this->output->enable_profiler(TRUE);
		$userId = $this->session->userdata('userId');

		$query = "SELECT `schools`.`schoolId` FROM `schools` WHERE owner_id = '" . $userId . "'";
		$school_result = $this->db->query($query)->result();
		if ($school_result) {
			$this->session->set_userdata('role_homepage_uri', 'school_dashboard');
			redirect('school_dashboard');
		}
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{

		$this->load->model("general_modal");
		$this->load->model("session_m");
		$next = $this->session_m->get_next_session();
		$this->data['next_session_id'] = $next->session_id;
		$this->data['school_types'] = $this->general_modal->school_types();
		$this->data['districts'] = $this->general_modal->districts();
		$this->data['gender_of_school'] = $this->general_modal->gender_of_school();
		$this->data['level_of_institute'] = $this->general_modal->level_of_institute();
		$this->data['reg_type'] = $this->general_modal->registration_type();
		$this->data['tehsils'] = $this->general_modal->tehsils();
		$this->data['ucs'] = $this->general_modal->ucs();
		$this->data['locations'] = $this->general_modal->location();
		$this->data['bise_list'] = $this->general_modal->bise_list();
		$district_query = "SELECT
			    `districtId`
			    , `districtTitle`
			FROM
			    `district` ORDER by districtTitle ASC;";
		$this->data['districts'] = $this->user_m->runQuery($district_query);



		$this->data['title'] = "Login to dashboard";
		$this->load->view("add_school/add_school_from", $this->data);
	}

	public function process_data()
	{





		//var_dump($school_data);
		//exit();

		$userId = $this->session->userdata('userId');
		$woner_data['userTitle'] = $this->input->post('userTitle');
		$woner_data['contactNumber'] = $this->input->post('contactNumber');
		$woner_data['cnic'] = $this->input->post('cnic');
		$woner_data['gender'] = $this->input->post('gender');
		$woner_data['address'] = $this->input->post('owner_address');

		$this->db->where('userId', $userId);
		$this->db->update('users', $woner_data);

		$school_data = $this->input->post();

		// $level_ids = $this->input->post("level_of_school_id");
		// $school_data['primary_level'] = 0;
		// $school_data['middle_level'] = 0;
		// $school_data['high_level'] = 0;
		// $school_data['h_sec_college_level'] = 0;
		// foreach ($level_ids as $level_id) {
		// 	if ($level_id == 1) {
		// 		$school_data['primary_level'] = 1;
		// 	}
		// 	if ($level_id == 2) {
		// 		$school_data['middle_level'] = 1;
		// 	}
		// 	if ($level_id == 3) {
		// 		$school_data['high_level'] = 1;
		// 	}
		// 	if ($level_id == 4) {
		// 		$school_data['h_sec_college_level'] = 1;
		// 	}
		// 	if ($level_id == 5) {
		// 		$school_data['academy'] = 1;
		// 	}
		// }

		//unset($school_data['level_of_school_id']);
		$school_data['owner_id'] = $userId;
		unset($school_data['userTitle']);
		unset($school_data['contactNumber']);
		unset($school_data['cnic']);
		unset($school_data['gender']);
		unset($school_data['owner_address']);

		unset($school_data['type_of_institute_id']);

		unset($school_data['banka_acount_details']);
		unset($school_data['accountTitle']);
		unset($school_data['bankAccountNumber']);
		unset($school_data['bankBranchAddress']);
		unset($school_data['bankBranchCode']);
		unset($school_data['bankAccountName']);

		if ($school_data['uc_id'] != 0) {
			unset($school_data['uc_text']);
		}
		if ($school_data['biseRegister'] == 'No') {
			unset($school_data['biseregistrationNumber']);
			unset($school_data['primaryRegDate']);
			unset($school_data['middleRegDate']);
			unset($school_data['highRegDate']);
			unset($school_data['interRegDate']);
		}

		if ($school_data['biseAffiliated'] == 'No') {
			unset($school_data['bise_id']);
			unset($school_data['otherBiseName']);
		} else {
			if ($school_data['bise_id'] != 10) {
				unset($school_data['otherBiseName']);
			}
		}
		$year = $this->input->post('e_year');
		unset($school_data['e_year']);
		$month =  $this->input->post('e_month');
		unset($school_data['e_month']);
		$school_data['yearOfEstiblishment'] = $year . "-" . $month;
		//$school_data['level_of_school_id'] = max($level_ids);
		$this->db->insert('schools', $school_data);
		$school_id = $this->db->insert_id();

		if ($school_data['biseRegister'] == 'Yes') {

			$bise_verification['school_id'] =  $school_id;
			$bise_verification['registration_number'] =  $school_data['biseregistrationNumber'];
			$bise_verification['tdr_amount'] =  0;
			$bise_verification['bise_id'] =  $school_data['bise_id'];
			$this->db->insert('bise_verification_requests', $bise_verification);
		}

		if ($school_data['banka_acount_details'] == 'Yes') {
			$bank_data['accountTitle'] = $this->input->post('accountTitle');
			$bank_data['bankAccountNumber'] = $this->input->post('bankAccountNumber');
			$bank_data['bankBranchAddress'] = $this->input->post('bankBranchAddress');
			$bank_data['bankBranchCode'] = $this->input->post('bankBranchCode');
			$bank_data['bankAccountName'] = $this->input->post('bankAccountName');
			$bank_data['school_id'] = $school_id;
			$this->db->insert('bank_account', $bank_data);
		}

		$owner['owner_name'] = $this->input->post('userTitle');
		$owner['owner_father_name'] = '';
		$owner['owner_contact_no'] = $this->input->post('contactNumber');
		$owner['owner_cnic'] = $this->input->post('cnic');
		$owner['gender'] = $this->input->post('gender');
		$owner['address'] = $this->input->post('owner_address');
		$owner['status'] = 1;
		$owner['school_id'] = $school_id;
		$this->db->insert('school_owners', $owner);

		$this->session->set_userdata('role_homepage_uri', 'school_dashboard');
		redirect('school_dashboard');

		# code...
	}
}
