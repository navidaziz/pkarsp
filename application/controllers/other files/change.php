<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Change extends MY_Controller
{

	public function of_name()
	{
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;")->result()[0];
		$this->data['session_id'] = $session_id = $this->data['session_detail']->sessionYearId;
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
					, `school`.`reg_type_id`
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
		$this->data['title'] = 'Change of Name';
		$this->data['description'] = 'Request for change of institute name';
		$this->data['view'] = 'change/of_name';
		$this->load->view('layout', $this->data);
	}

	public function add_change_bank_challan()
	{
		$session_id = (int) $this->input->post('session_id');
		$userId = $this->session->userdata('userId');
		$query = "SELECT 
		`school`.`schoolId` AS `school_id` FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$school_id = $this->data['school']->school_id;
		$challan_detail['challan_for'] = $this->input->post('challan_for');
		$challan_detail['challan_no'] = $this->input->post('challan_no');
		$challan_detail['challan_date'] = $this->input->post('challan_date');
		$challan_detail['session_id'] = $session_id;
		$challan_detail['school_id'] = $school_id;
		$challan_detail['created_by'] = $userId;



		$bank_challan_id = $this->db->insert('bank_challans', $challan_detail);
		if ($bank_challan_id) {
			$application_detail['application_subject'] = $this->input->post('application_subject');
			$application_detail['application_detail'] = $this->input->post('application_detail');
			if ($this->input->post('challan_for') == 'Change Of Building') {
				$institute_new_detail = "";
				$institute_new_detail .= "District: " . $this->input->post('district') . ",";
				$institute_new_detail .= "Tehsil: " . $this->input->post('tehsil') . ",";
				$institute_new_detail .= "Union Council: " . $this->input->post('uc') . ",";
				$institute_new_detail .= "Address: " . $this->input->post('address') . ",";
				$institute_new_detail .= "Locality: " . $this->input->post('locality') . ",";
				$institute_new_detail .= "Latitude: " . $this->input->post('latitude') . ",";
				$institute_new_detail .= "Longitude: " . $this->input->post('longitude') . "";
				$application_detail['institute_new_detail'] = $institute_new_detail;
			}
			if ($this->input->post('challan_for') == 'Change Of Ownership') {
				$institute_new_detail = "";
				$institute_new_detail .= "Owner Name: " . $this->input->post('owner_name') . ",";
				$institute_new_detail .= "Owner CNIC: " . $this->input->post('owner_cnic') . "";
				$application_detail['institute_new_detail'] = $institute_new_detail;
			}
			if ($this->input->post('challan_for') == 'Change Of Name') {

				$application_detail['institute_new_detail'] = $this->input->post('institute_new_detail');
			}



			$application_detail['institute_old_detail'] = $this->input->post('institute_old_detail');
			$application_detail['session_id'] = $session_id;
			$application_detail['school_id'] = $school_id;
			$application_detail['bank_challan_id'] = $bank_challan_id;
			$application_detail['created_by'] = $userId;

			$this->db->insert('changes_requests', $application_detail);

			$this->session->set_flashdata('msg_success', $this->input->post('challan_for') . ' Application Request Submit Successfully.');
			redirect("school_dashboard");
		}
	}

	public function of_building()
	{
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;")->result()[0];
		$this->data['session_id'] = $session_id = $this->data['session_detail']->sessionYearId;
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
					, `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`district_id`
					, `schools`.`tehsil_id`
					, `schools`.`uc_id`
					, `schools`.`uc_text`
					, `schools`.`uc_text`
					, `schools`.`address`
					, `schools`.`location`
					, `schools`.`late`
					, `schools`.`longitude`
					, `district`.`districtTitle`
					, `tehsils`.`tehsilTitle`
					, `uc`.`ucTitle`

				FROM
					`schools`
					INNER JOIN `school`
					ON (`schools`.`schoolId` = `school`.`schools_id`)
					INNER JOIN `district`
					ON(`schools`.`district_id` = `district`.`districtid`)
					INNER JOIN `tehsils`
					ON(`schools`.`tehsil_id` = `tehsils`.`tehsilid`)
					LEFT JOIN `uc`
					ON(`schools`.`uc_id` = `uc`.`ucId`)	
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$this->data['title'] = 'Change of Name';
		$this->data['description'] = 'Request for change of institute name';
		$this->data['view'] = 'change/of_building';
		$this->load->view('layout', $this->data);
	}

	public function of_ownership()
	{
		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;")->result()[0];
		$this->data['session_id'] = $session_id = $this->data['session_detail']->sessionYearId;
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
					, `school`.`reg_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`yearOfEstiblishment`
					, `users`.`userTitle`
					, `users`.`cnic`
				FROM
					`schools`
					INNER JOIN `school` 
						ON (`schools`.`schoolId` = `school`.`schools_id`)
					INNER JOIN `users`
					ON (schools.owner_id = users.userId)	
						WHERE `school`.`session_year_id`='" . $session_id . "'
						AND `schools`.`owner_id`='" . $userId . "'";


		$this->data['school'] =  $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $this->data['school']->school_id;
		$this->data['title'] = 'Change of Name';
		$this->data['description'] = 'Request for change of institute name';
		$this->data['view'] = 'change/of_ownership';
		$this->load->view('layout', $this->data);
	}
}
