<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section_access extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {

      $this->data['title'] = 'Section Access';
      $this->data['description'] = 'info about module';
      $this->data['view'] = 'section_access/dashboard';
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


         $this->load->view('section_access/school_detail', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }

   public function unlock_editing()
   {
      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');
      $query = "UPDATE `school` SET status = 0  WHERE status='2' 
               AND schoolId = '" . $school_id . "' 
               AND schools_id ='" . $schools_id . "' LIMIT 1";
      if ($this->db->query($query)) {
         $userId = $this->session->userdata('userId');
         $query = "INSERT INTO `section_open_log`(`school_id`, `status`, `user_id`) 
                 VALUES ('" . $school_id . "','Form-open','" . $userId . "')";
         $this->db->query($query);
         echo 'success';
      } else {
         echo 'error';
      }
   }

   public function lock_editing()
   {
      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');
      $query = "UPDATE `school` SET status = 2  WHERE status='0' 
               AND schoolId = '" . $school_id . "' 
               AND schools_id ='" . $schools_id . "' LIMIT 1";
      if ($this->db->query($query)) {
         $userId = $this->session->userdata('userId');
         $query = "INSERT INTO `section_open_log`(`school_id`, `status`, `user_id`) 
                 VALUES ('" . $school_id . "','Form-close','" . $userId . "')";
         $this->db->query($query);
         echo 'success';
      } else {
         echo 'error';
      }
   }
}
