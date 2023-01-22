<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Admin_Controller
// MY_Controller
class Registration extends MY_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('user_m');
		// $this->output->enable_profiler(TRUE);

	}


	public function get_ucs_by_tehsils_id()
	{
		$tehsil_id = $this->input->post('id');
		if (!empty($tehsil_id)) {
			$this->load->model("general_modal");
			$response = $this->general_modal->ucs($tehsil_id, FALSE);
			echo $response;
			return;
		} else {
			return "<option></option>";
		}
	}


	public function get_tehsils_by_district_id()
	{
		$district_id = $this->input->post('id');
		if (!empty($district_id)) {
			$this->load->model("general_modal");
			$response = $this->general_modal->tehsils($district_id, FALSE);
			echo $response;
			return;
		} else {
			return "<option></option>";
		}
	}
}
