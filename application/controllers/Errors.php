<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Admin_Controller
// MY_Controller
class Errors extends MY_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('user_m');
		// $this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['description'] = 'info about All Modules';
		//$this->data['view'] = 'errors/html/module_not_allowed';
		//$this->load->view('layout', $this->data);
		$this->load->view('errors/html/module_not_allowed', $this->data);
	}
}
