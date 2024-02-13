<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fine_management extends CI_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
	}

	public function index()
	{
		$this->data["title"] = "Fine Management System";
		$this->data["view"] = "fms/fine_management/fine_management_home";
		$this->load->view("layout", $this->data);
	}


	// public function fine_amount_detail()
	// {

	// 	$this->data["title"] = "Fine Amount Detail";
	// 	$this->data['school_id'] = $this->input->post('school_id');
	// 	$this->data['fine_id'] = $this->input->post('fine_id');
	// 	$this->load->view("fms/fine_management/fine_amount_detail", $this->data);
	// }

	public function fine_amount_detail()
	{
		$this->data['school_id'] = $school_id =  $this->input->post('school_id');
		$this->data['fine_id'] = $fine_id = $this->input->post('fine_id');

		$query = "SELECT f.*,  fc.fine_channel_title,
		SUM(fine_amount) as fine_amount,
		(SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id and w.fine_id = f.fine_id ) as total_waived_off,
		(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id and fp.fine_id = f.fine_id ) as total_fine_paid
		 FROM `fines` as f
		INNER JOIN fine_channels fc ON (fc.fine_channel_id = f.fine_channel_id) 
		          WHERE f.school_id = '" . $school_id . "'
				  AND f.fine_id = '" . $fine_id . "'";
		$this->data['fine'] = $this->db->query($query)->row();
		$this->load->view("fms/fine_management/fine_amount_detail", $this->data);
	}

	public function get_fine_add_form()
	{


		$this->data["title"] = "School Fined History";
		$this->data['school_id'] = $this->input->post('school_id');
		$this->load->view("fms/fine_management/add_fine", $this->data);
	}

	public function get_activity_logs()
	{
		$this->data["title"] = "Fine Activity Logs";
		$this->data['school_id'] = (int) $this->input->post('school_id');
		$this->data['fine_id'] = (int) $this->input->post('fine_id');
		$this->load->view("fms/fine_management/fine_activity_logs", $this->data);
	}



	public function get_fine_payment_details()
	{




		$this->data['school_id'] = $school_id =  $this->input->post('school_id');
		$this->data['fine_id'] = $fine_id = $this->input->post('fine_id');

		$query = "SELECT f.*, fc.fine_channel_title,
		SUM(fine_amount) as fine_amount,
		(SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id and w.fine_id = f.fine_id ) as total_waived_off,
		(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id and fp.fine_id = f.fine_id ) as total_fine_paid
		 FROM `fines` as f
		INNER JOIN fine_channels fc ON (fc.fine_channel_id = f.fine_channel_id) 
		          WHERE f.school_id = '" . $school_id . "'
				  AND f.fine_id = '" . $fine_id . "'";
		$this->data['fine'] = $this->db->query($query)->row();
		$this->load->view("fms/fine_management/get_fine_payment_details", $this->data);
	}
	public function get_fine_waive_off_details()
	{
		$this->data['school_id'] = $school_id =  $this->input->post('school_id');
		$this->data['fine_id'] = $fine_id = $this->input->post('fine_id');

		$query = "SELECT f.*,  fc.fine_channel_title,
		SUM(fine_amount) as fine_amount,
		(SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id and w.fine_id = f.fine_id ) as total_waived_off,
		(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id and fp.fine_id = f.fine_id ) as total_fine_paid
		 FROM `fines` as f
		INNER JOIN fine_channels fc ON (fc.fine_channel_id = f.fine_channel_id) 
		          WHERE f.school_id = '" . $school_id . "'
				  AND f.fine_id = '" . $fine_id . "'";
		$this->data['fine'] = $this->db->query($query)->row();
		$this->load->view("fms/fine_management/get_fine_waive_off_details", $this->data);
	}

	public function search_detail()
	{
		$district_id = (int) $this->input->post('district_id');
		$search = $this->db->escape("%" . $this->input->post('search') . "%");
		if (trim($this->input->post('search')) == '') {
			$this->data['search_list'] = array();
		} else {
			$reg_un_reg = (int) $this->input->post('reg_un_reg');
			$level = (int) $this->input->post('level');


			$query = "SELECT
					`schools`.schoolId as schools_id,
					`schools`.schoolName,
					`schools`.registrationNumber,
					`schools`.`yearOfEstiblishment`,
					`schools`.`tehsil_id`,
					`schools`.`address`,
					`schools`.`uc_id`,
					`schools`.`uc_text`,
					`district`.`districtTitle`,
					`schools`.`telePhoneNumber`,
					`schools`.`schoolMobileNumber`


					FROM `schools` INNER JOIN `district` 
					ON (`schools`.`district_id` = `district`.`districtId`) ";


			$searchBy = "Search filter by: ";
			if ($search) {
				if (is_numeric($this->input->post('search'))) {
					$leng = (int) strlen($this->input->post('search'));
					$search = $search = $this->db->escape($this->input->post('search'));
					if ($leng >= 6) {
						$query .= 'WHERE (`schools`.registrationNumber = ' . $search . ') ';
						$searchBy .= " Registration No: " . $this->input->post('search') . " / ";
					} else {
						$query .= 'WHERE (`schools`.`schoolId` = ' . $search . ') ';
						$searchBy .= " Institute ID: " . $this->input->post('search') . " / ";
					}
				} else {
					$query .= 'WHERE (`schools`.`schoolName` LIKE ' . $search . '
								OR REPLACE(schoolName, "_", " ") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "_", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "-", " ") LIKE ' . $search . ' 
								OR REPLACE(schoolName, "-", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, ".", "") LIKE ' . $search . ' 
								OR REPLACE(schoolName, ".", " ") LIKE ' . $search . ') ';
					$searchBy .= " Name: " . $this->input->post('search') . " / ";
				}
			}

			if ($district_id) {
				$query .= " AND schools.district_id = '" . $district_id . "' ";
				$q = "SELECT districtTitle FROM district WHERE districtId = '" . $district_id . "'";
				$district_name = $this->db->query($q)->row()->districtTitle;
				$searchBy .= " District: " . $district_name . " / ";
			} else {
				$searchBy .= " District: All / ";
			}
			if ($reg_un_reg == 1) {
				$query .= " AND schools.registrationNumber >0  ";
				$searchBy .= " Registered institutes / ";
			}
			if ($reg_un_reg == 2) {
				$query .= " AND schools.registrationNumber <=0 ";
				$searchBy .= " Un-Registered institutes / ";
			}
			if ($reg_un_reg == 0) {
				$searchBy .= "Registered and Un-Registered / ";
			}

			if ($level > 0) {

				$query .= " HAVING (SELECT level_of_school_id FROM school WHERE schools_id = `schools`.schoolId ORDER BY schoolId DESC LIMIT 1) = '" . $level . "' ";
				$q = "SELECT levelofInstituteTitle FROM levelofinstitute WHERE levelofInstituteId = '" . $level . "'";
				$levelofInstituteTitle = $this->db->query($q)->row()->levelofInstituteTitle;
				$searchBy .= " Level: " . $levelofInstituteTitle . "";
			} else {
				$searchBy .= "Levels: All";
			}


			$query .= " ORDER BY district.districtTitle, schools.schoolName ASC LIMIT 100 ";
			$this->data['search_list'] = $this->db->query($query)->result();
		}
		$title = "<small>" . count($this->data['search_list']) . " Records found  <span class=\"pull-right\"> <i class=\"fa fa-filter\" aria-hidden=\"true\"></i> " . $searchBy . " <i class=\"fa fa-close\" style='margin-left:10px; cursor: pointer;' onclick=\"$('#search_result').html('');\"></i></span> </small>";
		$this->data['title'] = $title;

		$this->load->view('fms/fine_management/search_list', $this->data);
	}

	public function get_school_add_fine_form()
	{


		$this->load->view("fms/fine_management/school_add_fine_form", $this->data);
	}




	public function file_upload_check()
	{
		$allowed = array('pdf');
		$filename = $_FILES['fine_file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if (!in_array($ext, $allowed)) {
			$this->form_validation->set_message('file_upload_check', 'FMS only accept .pdf format. Please select a valid file format.');

			return FALSE;
		}
	}

	public function add_fine()
	{
		$fine_type_ids = explode(",", $this->input->post('fine_type_ids'));
		$slected_fines = array();
		$seleted_fine_amount = 0;
		foreach ($fine_type_ids as $fine_type_id) {
			$fine_types = $this->input->post('fine_types');
			foreach ($fine_types as $fine_index => $fine_amount) {
				if ($fine_type_id == $fine_index) {
					$slected_fines[$fine_type_id] = $fine_amount;
					$seleted_fine_amount += $fine_amount;
				}
			}
		}

		if ($seleted_fine_amount != $this->input->post("fine_amount")) {
			$response['error'] = true;
			$response['msg'] = 'Fine amount not matched. Try again.';
			echo json_encode($response);
			exit();
		}

		$validations = array(
			//array('field' => 'file_number', 'label' => 'File Number', 'rules' => 'required'),
			array('field' => 'letter_no', 'label' => 'Letter Number', 'rules' => 'required'),
			array('field' => 'fine_type_ids', 'label' => 'Fine Type', 'rules' => 'required'),
			array('field' => 'fine_nature', 'label' => 'Fine Nature', 'rules' => 'required'),
			array('field' => 'session_id', 'label' => 'Session', 'rules' => 'required'),
			array('field' => 'fine_channel_id', 'label' => 'Fine Channel', 'rules' => 'required'),
			array('field' => 'fine_amount', 'label' => 'Amount', 'rules' => 'required'),
			array('field' => 'file_date', 'label' => 'File Date', 'rules' => 'required'),
			array('field' => 'remarks', 'label' => 'Remarks', 'rules' => 'required'),
			array('field' => 'fine_file', 'label' => 'File Attachment', 'rules' => 'callback_file_upload_check'),
		);
		$this->form_validation->set_rules($validations);
		$input = array();

		if ($this->form_validation->run() === TRUE) {
			if ($this->uploadfile($school_id, "fine_file")) {
				$input['fine_file']  = $this->data["upload_data"]["dir"] . $this->data["upload_data"]["file_name"];
			} else {
				$response['error'] = true;
				$response['msg'] = 'Error While Uploading File.';
				echo  json_encode($response);
				exit();
			}

			//$input["file_number"] = $this->input->post("file_number");
			//$input["fine_type_id"] = $this->input->post("fine_type_id");
			$input['school_id'] = $school_id =  (int) $this->input->post('school_id');
			$input["fine_channel_id"] = $this->input->post("fine_channel_id");
			$input["fine_amount"] = $this->input->post("fine_amount");
			$input["fine_nature"] = $this->input->post("fine_nature");
			$input["session_id"] = $this->input->post("session_id");
			$input["file_date"] = $this->input->post("file_date");
			$input["remarks"] = $this->input->post("remarks");
			$input["letter_no"] = $this->input->post("letter_no");
			$input['created_by'] = $this->session->userdata('userId');
			$this->db->insert('fines', $input);
			$fine_id = $this->db->insert_id();
			if ($fine_id) {
				$this->db->where('fine_id', $fine_id);
				$this->db->delete('fine_amount_details');
				$fine_amount = array();
				foreach ($slected_fines as $fine_type_id => $amount) {
					$fine_amount['fine_id'] = $fine_id;
					$fine_amount['school_id'] = $school_id;
					$fine_amount['fine_type_id'] = $fine_type_id;
					$fine_amount['amount'] = $amount;
					$this->db->insert('fine_amount_details', $fine_amount);
				}
				$response['error'] = false;
				$response['msg'] = 'Fine Add Successfully';
			}
		} else {

			$response['error'] = true;
			$response['msg'] = validation_errors();
		}
		echo  json_encode($response);
	}

	private function uploadfile($school_id, $field_name, $config = NULL)
	{
		$upload_path = '/uploads/school/' . $school_id . '/fine/';
		if (is_null($config)) {
			$config = array(
				"upload_path" => $_SERVER['DOCUMENT_ROOT'] . $upload_path,
				"allowed_types" => "pdf",
				"max_size" => 10000,
				"max_width" => 0,
				"max_height" => 0,
				"remove_spaces" => true,
				//"encrypt_name" => true
			);
			$config['file_name'] = 'PSRA-OPS-F-' . date('Y-M-d') . '-' . $school_id . '-' . time();
		}

		$dir = $config["upload_path"];
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
		}
		$this->load->library("upload", $config);
		if (!$this->upload->do_upload($field_name)) {
			$this->data['upload_error'] = $this->upload->display_errors();
			return $this->data['upload_error'];
		} else {
			$this->data['upload_data'] = $this->upload->data();
			$this->data['upload_data']['dir'] = $upload_path;
			return True;
		}
	}

	public function get_school_detail()
	{

		$school_id = (int) $this->input->post('school_id');
		// check $school is is already in school fined table or not 
		$query = "SELECT * FROM fined_schools WHERE school_id = '" . $school_id . "' LIMIT 1";
		$school = $this->db->query($query)->result();
		if ($school) {
			$response['response'] = true;
			$response['message'] = "School already in school fined table.";
			$school_detail[0]['registrationNumber'] = $school[0]->school_registration_no;
			$school_detail[0]['schoolName'] = $school[0]->school_name;
			$school_detail[0]['districtTitle'] = $school[0]->district_name;
			$school_detail[0]['tehsilTitle'] = $school[0]->tehsil_name;
			$school_detail[0]['address'] = $school[0]->address;
			$school_detail[0]['level_id'] = $school[0]->level_id;
			$school_detail[0]['contact_number'] = $school[0]->contact_number;

			$response['school'] = $school_detail;
			echo json_encode($response);
			exit();
		}

		if ($this->input->post("school_id")) {
			$school_id = (int) $this->input->post("school_id");
			$query = "SELECT `s`.`schoolId`, 
						   `s`.`registrationNumber`,
						   `s`.`schoolName`,
						   d.districtTitle,
						   t.tehsilTitle,
						   s.address,
						   `s`.`telePhoneNumber` as contact_number,
						  ( select s_s.level_of_school_id  from school as s_s 
						  where s_s.schools_id=s.schoolId and s_s.status=1 
						  order by s_s.session_year_id DESC LIMIT 1) as level_id
					 FROM schools as s
					 INNER JOIN district as d ON (d.districtId = s.district_id)
					 INNER JOIN tehsils as t ON (t.tehsilId = s.tehsil_id)
					 WHERE schoolId  = '" . $school_id . "'
					 AND `s`.`registrationNumber` > 0
					 ";
			$registration_db = $this->load->database('registration_db', TRUE);
			$school = $registration_db->query($query)->result();
			if ($school) {
				$response['response'] = true;
				$response['school'] = $school;
				$response['message'] = '';
				echo json_encode($response);
			} else {
				$response['response'] = true;
				$response['school'] = false;
				$response['message'] = 'School ID not found';
				echo json_encode($response);
			}
		} else {
			$response['response'] = true;
			$response['school'] = false;
			$response['message'] = 'School ID Required';
			echo json_encode($response);
		}


		//$school_id = 1;
		// $curl = curl_init();

		// curl_setopt_array($curl, array(
		// 	CURLOPT_URL => 'http://psra.gkp.pk/schoolReg/api/psra/get_school_detail',
		// 	CURLOPT_RETURNTRANSFER => true,
		// 	CURLOPT_ENCODING => '',
		// 	CURLOPT_MAXREDIRS => 10,
		// 	CURLOPT_TIMEOUT => 0,
		// 	CURLOPT_FOLLOWLOCATION => true,
		// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		// 	CURLOPT_CUSTOMREQUEST => 'POST',
		// 	CURLOPT_POSTFIELDS => array("school_id" => $school_id),
		// 	CURLOPT_HTTPHEADER => array(
		// 		'x-api-key: n2r5u8x/A?D(G+KbPdSgVkYp3s6v9y$B'
		// 	),
		// 	CURLOPT_FAILONERROR => TRUE
		// ));
		// //var_dump($curl);
		// if (curl_errno($curl)) {
		// 	$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		// 	curl_close($curl);
		// 	$response['response'] = false;
		// 	$response['message'] = 'Request Error:' . curl_error($curl);
		// 	curl_close($curl);
		// 	echo json_encode($response);
		// } else {
		// 	$response = array();
		// 	$response = curl_exec($curl);
		// 	curl_close($curl);
		// 	echo $response;
		// }
	}

	public function fined_summary()
	{
		$this->load->view("fms/fine_management/fined_summary", $this->data);
	}

	public function get_add_fine_payment_form()
	{
		$this->data['school_id'] = $school_id = (int) $this->input->post("school_id");

		$query = "SELECT fs.school_id, fs.school_id, fs.school_name, fs.district_name, fs.tehsil_name, fs.address ,
		SUM(IF(f.status=1,1,0)) as density,
		SUM(IF(f.status=1,f.fine_amount,0)) as total_fine,
		SUM(IF(f.status=3,1,0)) as w_offed,
		(SELECT SUM(fy.deposit_amount) FROM fine_payments as fy WHERE fy.is_deleted=0 AND fy.school_id = fs.school_id ) as paid_amount
        FROM fines as f
		INNER JOIN fined_schools fs ON (fs.school_id = f.school_id)
								WHERE fs.school_id = '" . $school_id . "'
								GROUP BY f.school_id
								";
		$this->data['fine_summary'] = $this->db->query($query)->result()[0];
		$query = "SELECT f.*, ft.fine_title , fc.fine_channel_title,
		(SELECT SUM(deposit_amount) FROM fine_payments WHERE fine_id = f.fine_id and is_deleted = 0)  as total_payment 
		 FROM `fines` as f
		INNER JOIN fine_types ft ON (ft.fine_type_id = f.fine_type_id)
		INNER JOIN fine_channels fc ON (fc.fine_channel_id = f.fine_channel_id) 
		          WHERE f.school_id = '" . $school_id . "'";
		$this->data['fines'] = $this->db->query($query)->result();

		$this->load->view("fms/fine_management/get_add_fine_payment_form", $this->data);
	}
	public function view_fine_detail($school_id)
	{
		$this->data['school_id'] =  $school_id = (int) $school_id;
		// $query = "SELECT s.schoolId as school_id, 
		//   s.registrationNumber as reg_number, 
		//   s.schoolName as school_name, 
		//   s.districtTitle as district_name,
		//   s.tehsil_name, 
		//   s.uc,
		//   s.address,
		//   s.level
		//   FROM 
		//   registered_schools s 
		//   WHERE s.schoolId = $school_id";

		$query = "select `s`.`schoolId` AS `school_id`,
		`s`.`registrationNumber` AS `reg_number`,
		(select `school_file_numbers`.`file_number` from `school_file_numbers` where (`school_file_numbers`.`school_id` = `s`.`schoolId`) limit 1) AS `file_no`,
		`s`.`yearOfEstiblishment` AS `year_of_est`,
		`s`.`schoolName` AS `school_name`,
		`d`.`districtTitle` AS `district_name`,
		`d`.`new_region` AS `new_region`,if((`d`.`new_region` = 1),'Central',if((`d`.`new_region` = 2),'South',if((`d`.`new_region` = 3),'Malakand',if((`d`.`new_region` = 4),'Hazara',if((`d`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
		(select `t`.`tehsilTitle` from `tehsils` `t` where (`t`.`tehsilId` = `s`.`tehsil_id`)) AS `tehsil_name`,
		(select `uc`.`ucTitle` from `uc` where (`uc`.`ucId` = `s`.`uc_id`)) AS `us`,
		`s`.`address` AS `address`,
		(select `l`.`levelofInstituteTitle` from `levelofinstitute` `l` where (`l`.`levelofInstituteId` = (select max(`school`.`level_of_school_id`) from `school` where (`school`.`schools_id` = `s`.`schoolId`)))) AS `level`, 
		`s`.`telePhoneNumber`,
		`s`.`schoolMobileNumber`,
		(SELECT `u`.`contactNumber` FROM `users` as u WHERE u.userId = s.owner_id) as owner_number
		from (`schools` `s` 
		INNER JOIN `district` `d` on((`d`.`districtId` = `s`.`district_id`))) 
		WHERE `s`.`registrationNumber` > 0
		AND `s`.schoolId = $school_id";

		$this->data['school'] = $this->db->query($query)->row();

		$query = "SELECT 
		SUM(fine_amount) as fine_amount,
		COALESCE((SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id ),0) as total_waived_off,
		COALESCE((SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id ),0) as total_fine_paid
		FROM fines as f
		WHERE f.is_deleted=0
		AND f.school_id = $school_id;
		";
		$this->data['fine_summary'] = $this->db->query($query)->row();

		$query = "SELECT f.*,  fc.fine_channel_title,
		SUM(fine_amount) as fine_amount,
		COALESCE((SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id and w.fine_id = f.fine_id ),0) as total_waived_off,
		COALESCE((SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id and fp.fine_id = f.fine_id ),0) as total_fine_paid,
		sy.sessionYearTitle as `session_year`
		 FROM `fines` as f
		INNER JOIN fine_channels fc ON (fc.fine_channel_id = f.fine_channel_id) 

		INNER JOIN session_year sy ON (sy.sessionYearId = f.session_id) 
		          WHERE f.school_id = '" . $school_id . "'
				  GROUP BY f.fine_id";
		$this->data['fines'] = $this->db->query($query)->result();

		$this->data["title"] = "School Fined History";
		$this->data["view"] = "fms/fine_management/school_fine_detail";
		$this->load->view("layout", $this->data);
	}

	public function wo_attachment_check()
	{
		$allowed = array('pdf');
		if (!isset($_FILES['waived_off_file']) || $_FILES['waived_off_file']['error'] == 4) {
			$this->form_validation->set_message('wo_attachment_check', 'Notification File is required for waive off');

			return FALSE;
		}
		$filename = $_FILES['waived_off_file']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if (!in_array($ext, $allowed)) {
			$this->form_validation->set_message('wo_attachment_check', 'FMS only accept .pdf format. Please select a valid file format.');

			return FALSE;
		}
	}

	public function valid_amount()
	{


		$fine_id = (int) $this->input->post('fine_id');

		$waived_off_amount = (float) $this->input->post('waived_off_amount');
		if ($waived_off_amount <= 0) {
			$this->form_validation->set_message('valid_amount', 'Please enter valid amount.');
			return FALSE;
		}

		$query = "select fine_amount from fines where fine_id = '" . $fine_id . "'";
		if ($this->db->query($query)->result()) {
			$fine_amount = $this->db->query($query)->result()[0]->fine_amount;
			if ($waived_off_amount > $fine_amount) {
				$this->form_validation->set_message('valid_amount', 'Waived off amount should be less than fine amount.');
				return FALSE;
			}
		} else {

			$this->form_validation->set_message('valid_amount', 'Invalid fine id.');
			return FALSE;
		}
	}


	public function waive_off_fine()
	{

		$validations = array(
			array('field' => 'fine_id', 'label' => 'Fine Id', 'rules' => 'required'),
			array('field' => 'waived_off_file_no', 'label' => 'Notification No', 'rules' => 'required'),
			array('field' => 'waived_off_date', 'label' => 'Notification Date', 'rules' => 'required'),
			array('field' => 'waived_off_amount', 'label' => 'Waive Off Amount', 'rules' => 'callback_valid_amount'),
			array('field' => 'wo_detail', 'label' => 'Waive off Detail', 'rules' => 'required'),
			array('field' => 'waived_off_file', 'label' => 'Notification Attachment', 'rules' => 'callback_wo_attachment_check'),
		);
		$this->form_validation->set_rules($validations);

		$input['fine_id'] = $fine_id = (int) $this->input->post('fine_id');
		$query = "select fine_amount,school_id from fines where fine_id = '" . $fine_id . "'";
		$fine_amount = $this->db->query($query)->result()[0]->fine_amount;
		$school_id = $this->db->query($query)->result()[0]->school_id;
		$input['school_id'] = $school_id;
		if ($this->form_validation->run() === TRUE) {


			if ($this->uploadfile($school_id, "waived_off_file")) {

				$input['waived_off_file']  = $this->data["upload_data"]["dir"] . $this->data["upload_data"]["file_name"];
			} else {
				$response['error'] = true;
				$response['msg'] = 'Error While Uploading File.';
				echo  json_encode($response);
				exit();
			}

			$input['fine_amount'] = $fine_amount;
			$input['waived_off_amount'] = $waived_off_amount = (float) $this->input->post('waived_off_amount');
			$input['fine_remained'] = $fine_remained = $fine_amount - $waived_off_amount;

			$input['waived_off_file_no'] = $this->input->post('waived_off_file_no');
			$input['waived_off_date'] = $this->input->post('waived_off_date');
			$input['wo_detail'] = $this->input->post('wo_detail');
			$input['waived_off_file']  = $this->data["upload_data"]["dir"] . $this->data["upload_data"]["file_name"];
			$input['created_by'] = $this->session->userdata('userId');

			if ($this->db->insert('fine_waived_off', $input)) {


				$response['update'] = $this->update_fine_status($fine_id);
				$response['error'] = false;
				$response['msg'] = "Fine waived off successfully";
			} else {
				$response['error'] = true;
				$response['msg'] = "Error while inserting waiving off";
			}
		} else {
			$response['error'] = true;
			$response['msg'] = validation_errors();
		}
		echo  json_encode($response);
	}


	public function delete_fine()
	{

		$where['fine_id'] = $fine_id  = (int) $this->input->post('fine_id');

		$this->db->where($where);
		$status['is_deleted'] = 1;
		if ($this->db->update('fines', $status)) {
			$this->activity_logs('fine', $fine_id, 'delete_fine', '0');
			echo 1;
		} else {
			echo 0;
		}
	}

	public function retore_fine()
	{

		$where['fine_id'] = $fine_id =  (int) $this->input->post('fine_id');
		$this->db->where($where);
		$status['is_deleted'] = 0;
		if ($this->db->update('fines', $status)) {
			$this->activity_logs('fine', $fine_id, 'restore_fine', '1');
			echo 1;
		} else {
			echo 0;
		}
	}

	public function delete_fine_payment()
	{

		$where['fine_id'] = $fine_id = (int) $this->input->post('fine_id');
		$where['fine_payment_id'] = (int) $this->input->post('fine_payment_id');
		$this->db->where($where);
		$status['is_deleted'] = 1;
		if ($this->db->update('fine_payments', $status)) {
			$this->update_fine_status($fine_id);
			$this->activity_logs('fine_payment', $fine_id, 'delete_payment', '1', $payment_id);
			echo 1;
		} else {
			echo 0;
		}
	}

	public function delete_waived_off()
	{

		$where_fwo['fine_id'] = $fine_id =  (int) $this->input->post('fine_id');
		$where_fwo['fine_waived_off_id'] = $fine_waived_off_id =  (int) $this->input->post('fine_waived_off_id');
		$where_fwo['is_deleted'] = 0;
		$this->db->where($where_fwo);
		$status['is_deleted'] = 1;
		if ($this->db->update('fine_waived_off', $status)) {
			$this->update_fine_status($fine_id);
			$this->activity_logs('fine_waived_off', $fine_id, 'delete_waived_off', '1', $fine_waived_off_id);
			echo 1;
		} else {
			echo 0;
		}
	}

	public function check_stan_number()
	{


		$stan_no = (float) $this->input->post('stan_no');
		if ($stan_no == "") {
			$this->form_validation->set_message('check_stan_number', 'Bank STAN No. Required');
			return FALSE;
		}

		$query = "select COUNT(*) as total from fine_payments where stan_no = '" . $stan_no . "' and is_deleted =0";
		if ($this->db->query($query)->result()) {
			$stan_count = $this->db->query($query)->result()[0]->total;
			if ($stan_count > 0) {
				$this->form_validation->set_message('check_stan_number', 'STAN No. ' . $stan_no . ' already used. please check and try again with valid STAN.');
				return FALSE;
			}
		}
	}


	public function add_fine_payment()
	{

		$validations = array(
			array('field' => 'fine_id', 'label' => 'Fine Id', 'rules' => 'required'),
			array('field' => 'stan_no', 'label' => 'Bank STAN No.', 'rules' => 'callback_check_stan_number'),
			array('field' => 'challan_date', 'label' => 'Bank Challan Date', 'rules' => 'required'),
			array('field' => 'deposit_amount', 'label' => 'Deposit Amount', 'rules' => 'required')
		);
		$this->form_validation->set_rules($validations);

		if ($this->form_validation->run() === TRUE) {

			$input['fine_id'] = $fine_id = (int) $this->input->post('fine_id');
			$input['stan_no'] = (int) $this->input->post('stan_no');
			$input['challan_date'] = $this->input->post('challan_date');
			$input['deposit_amount'] = (int) $this->input->post('deposit_amount');
			$input['created_by'] = $this->session->userdata('userId');
			$query = "SELECT school_id FROM fines WHERE fines.fine_id = '" . $fine_id . "'";
			$input['school_id'] = $this->db->query($query)->result()[0]->school_id;
			if ($this->db->insert('fine_payments', $input)) {
				$this->update_fine_status($fine_id);
				$response['error'] = false;
				$response['msg'] = "Payment Add successfully.";
			} else {
				$response['error'] = true;
				$response['msg'] = "Error while adding payment detail.";
			}
		} else {

			$response['error'] = true;
			$response['msg'] = validation_errors();
		}
		echo  json_encode($response);
	}
	public function fined_school_list()
	{
		$this->load->view("fms/fine_management/fined_school_list", $this->data);
	}

	private function activity_logs($table, $fine_id, $activity, $status, $other_id = NULL)
	{
		$activity_input['fine_id'] = $fine_id;
		$activity_input['table'] = $table;
		$activity_input['other_id'] = $other_id;
		$activity_input['activity'] = $activity;
		$activity_input['activity_status'] = $status;
		$activity_input['created_by'] = $this->session->userdata('userId');
		$this->db->insert('activity_logs', $activity_input);
	}




	private function update_fine_status($fine_id)
	{
		$fine_id = (int) $fine_id;
		$query = "SELECT SUM(fine_amount) as fine_amount,
		COALESCE((SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id and w.fine_id = f.fine_id  ),0) as total_waived_off,
		COALESCE((SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id and fp.fine_id = f.fine_id  ),0) as total_fine_paid
		 FROM `fines` as f
		 WHERE f.fine_id = '" . $fine_id . "'";
		$fine = $this->db->query($query)->row();
		$where = array();
		$update = array();
		if ($fine->fine_amount == ($fine->total_waived_off + $fine->total_fine_paid)) {
			$where['fine_id'] = $fine_id;
			$this->db->where($where);
			$update['status'] = 2;
			if ($this->db->update('fines', $update)) {
				return 'updated';
			} else {
				return 'error while update';
			}
		} else {
			$where['fine_id'] = $fine_id;
			$this->db->where($where);
			$update['status'] = 1;
			$this->db->update('fines', $update);
			$r = $fine->total_waived_off + $fine->total_fine_paid;
			return "$fine->fine_amount == $r";
		}
	}


	// public function ajax_fined_school_list()
	// {


	// 	$draw = $this->input->post('draw');
	// 	$row = $this->input->post('start');
	// 	$rowperpage = $this->input->post('length'); // Rows display per page

	// 	$columnIndex = $_POST['order'][0]['column']; // Column index
	// 	$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
	// 	//$columnName = $_POST['columns'][3]['data']; // Column name
	// 	$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
	// 	//$columnSortOrder = "asc";

	// 	$searchValue = $this->db->escape($_POST['search']['value']);
	// 	$searchValue = str_replace("'", "", $searchValue);

	// 	## Search 
	// 	$searchQuery = " ";
	// 	if ($searchValue != '') {
	// 		$searchQuery = " and (school_id like '%" . $searchValue . "%' or 
	//     school_name like '%" . $searchValue . "%' or 
	//     district_name like'%" . $searchValue . "%' ) ";
	// 	}

	// 	## Total number of record with out filtering
	// 	$query = "select COUNT(*) as total from fine_school_list where status =1";
	// 	$totalRecords = $this->db->query($query)->result()[0]->total;

	// 	## Total number of record with filtering
	// 	$query = "select COUNT(*) as total from fine_school_list where status =1 " . $searchQuery;
	// 	$totalRecordwithFilter = $this->db->query($query)->result()[0]->total;

	// 	//
	// 	## Fetch records
	// 	$empQuery = "select * from fine_school_list WHERE status =1 
	// 	            " . $searchQuery . " order by " . $columnName . " 
	// 				" . $columnSortOrder . "  limit " . $row . "," . $rowperpage;
	// 	$fined_schools = $this->db->query($empQuery)->result();
	// 	$data = array();
	// 	$count = 1;
	// 	foreach ($fined_schools as $fined_school) {
	// 		$data[] = array(
	// 			//"s_no" => $count++,
	// 			"school_id" => $fined_school->school_id,
	// 			"school_registration_no" => $fined_school->school_registration_no,
	// 			"school_name" => $fined_school->school_name,
	// 			"district_name" => $fined_school->district_name,
	// 			"tehsil_name" => $fined_school->tehsil_name,
	// 			"address" => $fined_school->address,
	// 			"frequency" => $fined_school->frequency,
	// 			"total_fine" => $fined_school->total_fine,
	// 			"total_waived_off" => $fined_school->total_waived_off,
	// 			"total_fine_paid" => $fined_school->total_fine_paid,
	// 			"total_fine_remaining" => $fined_school->total_fine_remaining,
	// 			"action" => '<a class="btn-sm btn-primary" style="margin:0px; padding:5px" href="' . site_url("fms/fine_management/view_fine_detail/" . $fined_school->school_id) . '">
	//             View
	//         </a>',

	// 		);
	// 	}

	// 	## Response
	// 	$response = array(
	// 		"draw" => intval($draw),
	// 		"iTotalRecords" => $totalRecords,
	// 		"iTotalDisplayRecords" => $totalRecordwithFilter,
	// 		"aaData" => $data
	// 	);

	// 	echo json_encode($response);
	// }
	// public function check_school_id()
	// {
	// 	if ($this->input->post('school_id')) {
	// 		$school_id = $this->input->post('school_id');
	// 		$query = "SELECT COUNT(*) as total FROM fined_schools WHERE school_id = '" . $school_id . "'";
	// 		$result = $this->db->query($query)->row()->total;
	// 		if ($result > 0) {
	// 			$this->form_validation->set_message('check_school_id', 'School Already In School List');
	// 			return FALSE;
	// 		}
	// 	}
	// }


	// public function add_school_in_fine_list()
	// {
	// 	$validations = array(
	// 		array('field' => 'school_id', 'label' => 'School Id', 'rules' => 'callback_check_school_id'),
	// 		array('field' => 'school_name', 'label' => 'School Name', 'rules' => 'required'),
	// 		array('field' => 'district_name', 'label' => 'District Name', 'rules' => 'required'),
	// 		array('field' => 'tehsil_name', 'label' => 'Tehsil Name', 'rules' => 'required'),
	// 		array('field' => 'address', 'label' => 'Address', 'rules' => 'required'),
	// 		array('field' => 'level_id', 'label' => 'School Level', 'rules' => 'required')

	// 	);
	// 	$this->form_validation->set_rules($validations);

	// 	if ($this->form_validation->run() === TRUE) {

	// 		$input['school_id'] = (int) $this->input->post('school_id');
	// 		$input['school_registration_no'] = $this->input->post('school_registration_no');
	// 		$input['school_name'] = $this->input->post('school_name');
	// 		$input['district_name'] = $this->input->post('district_name');
	// 		$input['tehsil_name'] = $this->input->post('tehsil_name');
	// 		$input['address'] = $this->input->post('address');
	// 		$input['level_id'] = $this->input->post('level_id');
	// 		$input['created_by'] = $this->session->userdata('userId');
	// 		$input['school_registration_no'] = $this->input->post('school_registration_no');
	// 		if ($this->db->insert('fined_schools', $input)) {

	// 			$response['error'] = false;
	// 			$response['msg'] = "School Add successfully.";
	// 		} else {
	// 			$response['error'] = true;
	// 			$response['msg'] = "Error while adding school detail.";
	// 		}
	// 	} else {

	// 		$response['error'] = true;
	// 		$response['msg'] = validation_errors();
	// 	}
	// 	echo  json_encode($response);
	// }
}
