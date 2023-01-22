<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Previous_requests extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Previous Requests';
		$this->data['description'] = 'Previous Requests';
		$this->data['view'] = 'previous_requests/previous_requests_list';
		$this->load->view('layout', $this->data);
	}


	public function marked_as_re_submit()
	{
		$where['schoolId'] = (int) $this->input->post('school_id');
		$where['status'] = 2;
		$this->db->where($where);
		$update['status'] = '0';
		if ($this->db->update('school', $update)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function forward_for_challan_verification()
	{

		$schoolId = (int) $this->input->post('school_id');
		$challan_no = $this->input->post('challan_no');
		$chalan_date =  $this->input->post('chalan_date');
		$userId = $this->session->userdata('userId');


		$query = "SELECT school.*,  `reg_type`.`regTypeTitle`  FROM school 
		INNER JOIN `reg_type` 
                    ON (
                      `reg_type`.`regTypeId` = `school`.`reg_type_id`
                    )
		WHERE schoolId = '" . $schoolId . "' and status = 2";
		$school = $this->db->query($query)->result()[0];


		$challan_detail['challan_for'] = $school->regTypeTitle;
		$challan_detail['challan_no'] = $challan_no;
		$challan_detail['challan_date'] = $chalan_date;
		$challan_detail['session_id'] = $school->session_year_id;
		$challan_detail['schools_id'] = $school->schools_id;
		$challan_detail['school_id'] = $schoolId;
		$challan_detail['created_by'] = $userId;
		if ($this->db->insert('bank_challans', $challan_detail)) {
			echo 1;
		} else {
			echo 0;
		}
	}
}
