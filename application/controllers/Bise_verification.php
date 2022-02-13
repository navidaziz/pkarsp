<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bise_verification extends Admin_Controller
//class Bise_verification extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'BISE Verificaion List';
		$this->data['description'] = 'List of All BISE Verificaion List';
		$this->data['view'] = 'bise_verification/bise_verification_list';
		$this->load->view('layout', $this->data);
	}

	public function get_bise_verification_detail()
	{
		$this->data['id'] = (int) $this->input->post('id');
		$this->load->view('bise_verification/get_bise_verification_detail', $this->data);
	}

	public function verify_bise_reg()
	{


		$id = (int) $this->input->post('id');
		$school_id =  (int) $this->input->post('school_id');
		if ($this->input->post("bise_verified") == 'Yes') {

			$where['id'] = $id;
			$this->db->where($where);
			$input['status'] = 1;
			$input['verified_by'] = $this->session->userdata('userId');
			$input['verified_date'] = date("Y-m-d h:i:sa");
			$input['tdr_amount'] = (float) $this->input->post('bise_tdr');
			$input['remarks'] = $this->input->post('remarks');

			$this->db->update('bise_verification_requests', $input);

			$where = array();
			$where['schoolId'] = $school_id;
			$this->db->where($where);
			$update['bise_verified'] = 1;
			$this->db->update('schools', $update);

			$this->session->set_flashdata('msg_success', 'BISE Registration Verified Successfully.');
		} else {
			$where['id'] = $id;
			$this->db->where($where);
			$input['status'] = 2;
			$input['verified_by'] = $this->session->userdata('userId');
			$input['verified_date'] = date("Y-m-d h:i:sa");
			$input['tdr_amount'] = 0.0;
			$input['remarks'] = $this->input->post('remarks');
			$this->db->update('bise_verification_requests', $input);


			$where = array();
			$where['schoolId'] = $school_id;
			$this->db->where($where);
			$update['bise_verified'] = 0;
			$this->db->update('schools', $update);
			$this->session->set_flashdata('msg_success', 'BISE Registration Not Verified.');
		}


		redirect("bise_verification");
	}
}
