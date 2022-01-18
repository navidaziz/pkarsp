<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inspection_section extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Request_m');
	}

	public function index()
	{
		$this->data['title'] = 'Inspections';
		$this->data['description'] = 'List of All Inspections';
		$this->data['view'] = 'registration_section/inspections';
		$this->load->view('layout', $this->data);
	}
	public function new_inspection_requests()
	{
		$this->Request_model->get_request_list(4, NULL, 'New Inspection');
	}
	public function awating_inspection_requests()
	{
		$this->Request_model->get_request_list(5, NULL, 'Inspection Inprogress');
	}
	public function completed_inspection_requests()
	{
		$this->Request_model->get_request_list(6, NULL, 'Inspection Completed');
	}
}
