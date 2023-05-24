<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Psra_dashboard extends CI_Controller
{

  public function __construct()
  {

    parent::__construct();
    $this->load->model("age_m");
  }
  public function index()
  {
    $this->data['title'] = 'Dashboard';
    $this->data['description'] = 'info about All Modules';
    $this->data['view'] = 'psra_dashboard/dashboard';
    $this->load->view('psra_dashboard/para_dashboard', $this->data);
  }
}
