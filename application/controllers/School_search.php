<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_search extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("school_m");
	}

	public function index()
	{
		$this->data['title'] = 'Search';
		$this->data['description'] = 'Search registere and unregisteres institute by name, id or registration no.';
		$this->data['view'] = 'school_search/index';
		$this->load->view('layout', $this->data);
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
					`district`.`districtTitle`
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

		$this->load->view('school_search/search_list', $this->data);
	}


	public function school_summary()
	{


		$this->data['schoolid'] = $schoolid = $this->db->escape($this->input->post('schools_id'));
		$query = "SELECT
			`schools`.schoolId as schools_id
			, `schools`.`registrationNumber`
			, `schools`.`schoolName`
			, `schools`.`yearOfEstiblishment`
			, `schools`.`school_type_id`
			, `schools`.`level_of_school_id`
			, `schools`.`gender_type_id`
			, (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
			, `district`.`districtTitle` 
			, `tehsils`.`tehsilTitle`
			, (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
			`schools`.`address`,
			`schools`.`telePhoneNumber` as `phone_no`,
			`schools`.`schoolMobileNumber` as `mobile_no`,
			`schools`.`isfined`,
			`schools`.`file_no`,
			`schools`.`principal_email`,
			users.userTitle,
			users.userName,
			users.userPassword,
			users.cnic,
			users.contactNumber as owner_no
			FROM `schools` INNER JOIN `district` 
				ON (`schools`.`district_id` = `district`.`districtId`) 
				INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`) 
				INNER JOIN users ON(users.userId = schools.owner_id)";
		$query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
		$school = $this->db->query($query)->row();
		if ($school) {

			if ($school->registrationNumber) {
				$this->data['visit_type'] = 'Upgradation';
			} else {
				$this->data['visit_type'] = 'Registration';
			}

			$this->data['school'] = $school;


			$this->load->view('school_search/school_detail', $this->data);
		} else {
			echo "School ID not found try again with different School ID.";
			exit();
		}
	}


	public function create_message()
	{


		$this->data['schoolid'] = $schoolid = $this->db->escape($this->input->post('schools_id'));
		$query = "SELECT
			`schools`.schoolId as schools_id
			, `schools`.`registrationNumber`
			, `schools`.`schoolName`
			, `schools`.`yearOfEstiblishment`
			, `schools`.`school_type_id`
			, `schools`.`level_of_school_id`
			, `schools`.`gender_type_id`
			, (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
			, `district`.`districtTitle` 
			, `tehsils`.`tehsilTitle`
			, (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
			`schools`.`address`,
			`schools`.`telePhoneNumber` as `phone_no`,
			`schools`.`schoolMobileNumber` as `mobile_no`,
			`schools`.`isfined`,
			`schools`.`file_no`,
			`schools`.`principal_email`,
			users.userTitle,
			users.userName,
			users.userPassword,
			users.cnic,
			users.contactNumber as owner_no
			FROM `schools` INNER JOIN `district` 
				ON (`schools`.`district_id` = `district`.`districtId`) 
				INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`) 
				INNER JOIN users ON(users.userId = schools.owner_id)";
		$query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
		$school = $this->db->query($query)->row();
		if ($school) {

			if ($school->registrationNumber) {
				$this->data['visit_type'] = 'Upgradation';
			} else {
				$this->data['visit_type'] = 'Registration';
			}

			$this->data['school'] = $school;


			$this->load->view('school_search/create_message', $this->data);
		} else {
			echo "School ID not found try again with different School ID.";
			exit();
		}
	}

	public function sent_message()
	{

		$allowed_extensions = array('pdf', 'jpeg', 'png', 'jpg', 'docx', 'docx');

		if (!empty($_FILES['otherimages'])) {
			$file_array = $this->reArrayFiles($_FILES['otherimages']);
			foreach ($file_array as $file) {
				$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
				if (!in_array(strtolower($file_extension), $allowed_extensions)) {
					$arr['msg'] = "Error in file extension.";
					$arr['success'] = false;
					echo json_encode($arr);
					exit();
				}
				// continue with uploading the file
			}
		}





		$insert['discription'] = $this->input->post('discription');
		$insert['subject'] = $this->input->post('subject');
		$school_id_for_message = (int) $this->input->post('school_id_for_message');
		$insert['created_by'] = $this->session->userdata('userId');
		$insert['created_date'] = date("Y-m-d h:i:s");
		//var_dump($insert);exit;

		$is_deficiency_message = $this->input->post('is_deficiency_message');
		if ($is_deficiency_message) {
			$school_session_id = $this->input->post('school_session_id');
			if ($school_session_id) {
				$deficiency = array();
				$deficiency['pending_type'] = 'Deficiency';
				$deficiency['pending_date'] = date("Y-m-d");
				$deficiency['pending_reason'] = $this->input->post('deficiency_reason');
				$insert['school_session_id'] = $school_session_id;
			}
			$insert['message_type'] = 'Deficiency';
			$insert['message_reason'] = $this->input->post('deficiency_reason');
		} else {
			$insert['message_type'] = 'General';
			$insert['message_reason'] = $this->input->post('deficiency_reason');
		}

		$insert['district_id'] = 0;
		$insert['level_id'] = 0;
		$insert['like_text'] = "";
		$insert['select_all'] = "no";

		$this->db->set($insert);
		$this->db->insert("message_for_all");
		$message_id = $this->db->insert_id();
		if ($message_id) {
			$input = array();
			$input['school_id'] = $school_id_for_message;
			$input['message_id'] = $message_id;
			$this->db->set($input);
			$this->db->insert("message_school");


			$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/school/' . $school_id_for_message . "/";
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);  //create directory if not exist
			}

			$files = $_FILES;

			if (isset($_FILES['otherimages']) && !empty($_FILES['otherimages']['name'])) {
				$cpt = count($_FILES['otherimages']['name']);

				//echo "hellow";exit;
				//var_dump($_FILES['otherimages']['name']);exit;
				$config = [];

				$this->load->library('upload', $config);
				for ($i = 0; $i < $cpt; $i++) {
					$_FILES['otherimages[]']['name'] = $files['otherimages']['name'][$i];
					$_FILES['otherimages[]']['type'] = $files['otherimages']['type'][$i];
					$_FILES['otherimages[]']['tmp_name'] = $files['otherimages']['tmp_name'][$i];
					$_FILES['otherimages[]']['error'] = $files['otherimages']['error'][$i];
					$_FILES['otherimages[]']['size'] = $files['otherimages']['size'][$i];
					$config['upload_path'] = $upload_dir;


					$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|pdf';
					$config['max_size'] = 0;
					$file_name = 'PSRA-' . date('Y-m-d') . "-" . time() . "-" . $message_id;
					$config['file_name'] = $file_name;

					$this->upload->initialize($config);
					if ($this->upload->do_upload("otherimages[]")) {
						$images_data[] = $this->upload->data();
					}
				}

				$num_images = count($images_data);
				//echo $num_images;exit;
				//var_dump($images_data);exit;
				if ($num_images > 0) {
					for ($i = 0; $i < $num_images; $i++) {
						$data = [
							'message_id' => $message_id,
							'attachment_name' => $images_data[$i]['file_name'],
							'folder' => 'school/' . $school_id_for_message,
						];
						$this->db->set($data);
						$this->db->insert("message_for_all_attachment");
						// $id = $this->db->insert_id();
						// $file_extension = pathinfo($images_data[$i]['file_name'], PATHINFO_EXTENSION);
						// if ($file_extension == 'jpg' || $file_extension == 'png') {
						// 	$imgString .= $images_data[$i]['file_name'] . ",";
						// } elseif ($file_extension == 'pdf' || $file_extension == 'docx' || $file_extension == 'doc') {
						// 	$pdfString .= $images_data[$i]['file_name'] . ",";
						// }
					}
				}
			}
			$arr['msg'] = "Message send";
			$arr['success'] = true;
		} else {
			$arr['msg'] = "Error Try Again";
			$arr['success'] = false;
		}
		echo json_encode($arr);
		exit;
	}
	private function reArrayFiles($file_post)
	{
		$file_array = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);

		for ($i = 0; $i < $file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_array[$i][$key] = $file_post[$key][$i];
			}
		}

		return $file_array;
	}
}
