<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank_challans extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Bank Challan List';
		$this->data['description'] = 'List of All Bank Challan list';
		$this->data['view'] = 'bank_challans/challan_list';
		$this->load->view('layout', $this->data);
	}

	public function get_bank_challan_detail()
	{
		$this->data['bank_challan_id'] = (int) $this->input->post('bank_challan_id');
		$this->load->view('bank_challans/verify_bank_challan_detail', $this->data);
	}

	public function verified_bank_challan()
	{



		$bank_challan_id = (int) $this->input->post('bank_challan_id');


		if ($this->input->post('verified') == 'Not Verified') {
			$input['remarks'] = $this->input->post('remarks');
			$input['total_deposit_fee'] = (float) 0.0;
			$input['verified'] = 2;
			$input['verified_by'] = $this->session->userdata('userId');
			$input['verified_date'] = date("Y-m-d h:i:sa");
			$this->db->where('bank_challan_id', $bank_challan_id);
			$query_result = $this->db->update('bank_challans', $input);
			if ($query_result) {
				$query = "SELECT challan_for,session_id, school_id, schools_id 
		          FROM bank_challans 
				  WHERE bank_challan_id = '" . $bank_challan_id . "'";
				$bank_challan = $this->db->query($query)->result()[0];


				$where['schoolId'] = $bank_challan->school_id;
				$where['session_year_id'] = $bank_challan->session_id;
				$this->db->where($where);
				$update = array();
				if ($bank_challan->challan_for == 'Deficiency') {
					$update['status'] = '7';
				} else {
					$update['status'] = '8';
				}

				$this->db->update('school', $update);
				$this->session->set_flashdata('msg_error', 'Bank Challan Not Verified.');
				redirect("bank_challans");
			}
		}

		if ($this->input->post('verified') == 'Verified') {


			$input['verified'] = 1;
			$input['verified_by'] = $this->session->userdata('userId');
			$input['verified_date'] = date("Y-m-d h:i:sa");
			$input["application_processing_fee"] = (float) $this->input->post("application_processing_fee");
			$input["renewal_fee"] = (float) $this->input->post("renewal_fee");
			$input["upgradation_fee"] = (float) $this->input->post("upgradation_fee");
			$input["inspection_fee"] = (float) $this->input->post("inspection_fee");
			$input["fine"] = (float) $this->input->post("fine");
			$input["security_fee"] = (float) $this->input->post("security_fee");
			$input["late_fee"] = (float) $this->input->post("late_fee");
			$input["renewal_and_upgradation_fee"] = (float) $this->input->post("renewal_and_upgradation_fee");
			$input["change_of_name_fee"] = (float) $this->input->post("change_of_name_fee");
			$input["change_of_ownership_fee"] = (float) $this->input->post("change_of_ownership_fee");
			$input["change_of_building_fee"] = (float) $this->input->post("change_of_building_fee");
			$input["total_deposit_fee"] = (float) $this->input->post("total_deposit_fee");
			$input['verified_by'] = $this->session->userdata('userId');
			$input['verified_date'] = date("Y-m-d h:i:sa");
			//if ($this->input->post("bise_verified")) {
			//	$input['bise_tdr'] = (float) $this->input->post("bise_tdr");
			//}
			$input['bise_tdr'] = (float) $this->input->post("bise_tdr");
			$this->db->where('bank_challan_id', $bank_challan_id);
			$query_result = $this->db->update('bank_challans', $input);
			if ($query_result) {
				$query = "SELECT bank_challans.*,
				 `session_year`.sessionYearTitle
						FROM bank_challans,
						`session_year` 
						WHERE 
						bank_challans.session_id = `session_year`.sessionYearId
						AND bank_challan_id = '" . $bank_challan_id . "'";
				$bank_challan_detail = $this->db->query($query)->result()[0];
				//here we need to change the status of renew/ registration/ and upgradation and renewal upgradation.
				if (
					$bank_challan_detail->challan_for == 'Registration'
					or $bank_challan_detail->challan_for == 'Renewal'
					or $bank_challan_detail->challan_for == 'Renewal Upgradation'
					or $bank_challan_detail->challan_for == 'Upgradation'
					or $bank_challan_detail->challan_for == 'Deficiency'
				) {

					$where = array();
					$update = array();
					if ($bank_challan_detail->challan_for == 'Registration') {


						// if ($this->input->post("bise_verified") == 'Yes') {
						// 	$where['schoolId'] = $bank_challan_detail->schools_id;
						// 	$this->db->where($where);
						// 	$update['bise_verified'] = $this->input->post("bise_verified");
						// 	$this->db->update('schools', $update);
						// }

						$update = array();
						$where['schoolId'] = $bank_challan_detail->school_id;
						$where['session_year_id'] = $bank_challan_detail->session_id;
						$update['inspection'] = '0';
						$this->db->where($where);
						$query = "SELECT bise_verified FROM schools WHERE schoolId = '" . $bank_challan_detail->schools_id . "'";
						$bise_verified = $this->db->query($query)->result();
						if ($bise_verified) {
							if ($bise_verified[0]->bise_verified == 1) {
								$update['inspection'] = '1';
							}
						}



						$update['status'] = '3';
						$this->db->update('school', $update);
					}
					if ($bank_challan_detail->challan_for == 'Renewal Upgradation') {
						$where['schoolId'] = $bank_challan_detail->school_id;
						$where['session_year_id'] = $bank_challan_detail->session_id;
						$this->db->where($where);
						$update['inspection'] = '0';
						$update['status'] = '3';
						$this->db->update('school', $update);
					}

					if ($bank_challan_detail->challan_for == 'Upgradation') {
						$where['schoolId'] = $bank_challan_detail->school_id;
						$where['session_year_id'] = $bank_challan_detail->session_id;
						$this->db->where($where);
						$update['inspection'] = '0';
						$update['status'] = '3';
						$this->db->update('school', $update);
					}

					if ($bank_challan_detail->challan_for == 'Renewal') {
						$where['schoolId'] = $bank_challan_detail->school_id;
						$where['session_year_id'] = $bank_challan_detail->session_id;
						$this->db->where($where);
						$update['inspection'] = '1';
						$update['status'] = '3';
						$this->db->update('school', $update);
					}

					if ($bank_challan_detail->challan_for == 'Deficiency') {
						$where['schoolId'] = $bank_challan_detail->school_id;
						$where['session_year_id'] = $bank_challan_detail->session_id;
						$this->db->where($where);
						$last_session = $bank_challan_detail->last_status;
						$update['status'] = $last_session;
						$this->db->update('school', $update);
					}

					$auto_comment = 'It is verified that STAN# ' . $bank_challan_detail->challan_no . ' on Dated: ' . date('d M, Y', strtotime($bank_challan_detail->challan_date)) . ' Total ' . $bank_challan_detail->total_deposit_fee . ' Rs. for ' . $bank_challan_detail->challan_for . ' Session ' . $bank_challan_detail->sessionYearTitle . ', reflected in Cash Mangement System Bank Statement. ';
					$input = array();
					$input['comment'] = $auto_comment;
					$input['session_id'] = $bank_challan_detail->session_id;
					$input['school_id'] = $bank_challan_detail->school_id;
					$input['schools_id'] = $bank_challan_detail->schools_id;
					$input['created_by'] = $this->session->userdata('userId');
					$this->db->insert('comments', $input);
				}



				$this->session->set_flashdata('msg_success', 'Bank Challan Verified Successfully.');
				redirect("bank_challans");
			}
		}
	}
}