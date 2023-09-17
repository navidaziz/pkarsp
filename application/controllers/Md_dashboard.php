<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_dashboard extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('project_helper');
   }

   public function index()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/index', $this->data);
   }
}
