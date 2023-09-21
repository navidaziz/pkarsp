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

   public function summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/summary', $this->data);
   }
   public function level_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/level_wise_summary', $this->data);
   }
   public function region_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/regsion_wise_summary', $this->data);
   }
   public function district_wise_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/district_wise_summary', $this->data);
   }
   public function yearly_monthly_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/yearly_monthly_summary', $this->data);
   }
   public function yearly_monthly_session_summary()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/yearly_monthly_session_summary', $this->data);
   }
   public function daily_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/daily_progress_report', $this->data);
   }
   public function region_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/region_progress_report', $this->data);
   }

   public function session_progress_report()
   {
      $this->data['title'] = 'PSRA Dashboard';
      $this->data['description'] = 'Monitoring and evaluation dashboard';
      $this->load->view('md_dashboard/session_progress_report', $this->data);
   }
}
