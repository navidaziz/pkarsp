<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends MY_Controller
{

	public function index()
	{
		$this->data['title'] = 'Download Bank Challan';
		$this->data['description'] = 'Bank Challan for security, fine , change of name, location and ownership.';
		$this->data['view'] = 'bank_challan/index';
		$this->load->view('layout', $this->data);
	}
}
