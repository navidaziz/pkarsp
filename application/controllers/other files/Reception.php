<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reception extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {

      $this->data['title'] = 'Record Room';
      $this->data['description'] = 'info about module';
      $this->data['view'] = 'reception/dashboard';
      $this->load->view('layout', $this->data);
   }




   public function school_detail()
   {


      $visit_type = $this->input->post('type');
      $region = $this->input->post('region');
      $this->data['schoolid'] = $schoolid = $this->db->escape($this->input->post('search'));
      $query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`district`.`districtTitle`,
      `district`.`region`,
      `schools`.`address`,
      `schools`.`telePhoneNumber`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`schoolMobileNumber`
		FROM `schools` INNER JOIN `district` 
        ON (`schools`.`district_id` = `district`.`districtId`) ";
      $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
      $school = $this->db->query($query)->row();
      if ($school) {

         if ($school->registrationNumber) {
            $this->data['visit_type'] = 'Upgradation';
         } else {
            $this->data['visit_type'] = 'Registration';
         }


         $this->data['school'] = $school;


         $this->load->view('reception/school_detail', $this->data);
      } else {
         echo "Institute ID not found try again with different Institute ID.";
         exit();
      }
   }

   public function add_dairy_number()
   {

      $school_session_ids = $this->input->post('school_session_ids');
      $error = false;
      foreach ($school_session_ids as $school_id) {

         $dairy_type = $this->db->escape($this->input->post('dairy_type'));
         $dairy_number = $this->db->escape($this->input->post('dairy_number'));

         $query = "update school set 
      dairy_type=" . $dairy_type . ", 
      dairy_no=" . $dairy_number . ", 
      dairy_date = '" . date('Y-m-d') . "' 
      where schoolId = $school_id";
         $query = $this->db->query($query);
         if ($query) {
         } else {
            $error = true;
         }
      }

      if ($error) {

         echo 'error';
      } else {
         echo 'success';
      }
   }
}
