<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      $this->data['title'] = 'Reports';
      $this->data['description'] = 'All Reports';
      $this->data['view'] = 'reports/cases_dashboard';
      $this->load->view('layout', $this->data);
   }
}
