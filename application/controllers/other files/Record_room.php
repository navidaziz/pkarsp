<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Record_room extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {

      $this->data['title'] = 'Record Room';
      $this->data['description'] = 'info about module';
      $this->data['view'] = 'record_room/dashboard';
      $this->load->view('layout', $this->data);
   }

   public function get_visit_list_form()
   {
      $data['type'] = $this->input->post('type');
      $data['region'] = $this->input->post('region');

      $this->load->view('record_room/visit_list_form', $data);
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


         $this->load->view('record_room/school_detail', $this->data);
      } else {
         echo "Institute ID not found try again with different Institute ID.";
         exit();
      }
   }

   public function add_school_in_visit_list()
   {
      $school_id = (int) $this->input->post('school_id');
      $visit_type = $this->db->escape($this->input->post('visit_type'));
      if ($this->input->post('visit_type') == 'Upgradation') {
         $query = "update school set reg_type_id = 4, visit_list = 1, visit_type=" . $visit_type . ", 
                visit_entry_date = '" . date('Y-m-d') . "' where schoolId = $school_id";
      } else {
         $query = "update school set reg_type_id = 1, visit_list = 1, visit_type=" . $visit_type . ", 
         visit_entry_date = '" . date('Y-m-d') . "' where schoolId = $school_id";
      }
      $query = $this->db->query($query);
      if ($query) {
         echo 'success';
      } else {
         echo 'error';
      }
   }
   public function remove_from_visit_list()
   {
      $school_id = (int) $this->input->post('school_id');

      $query = "SELECT visit_type FROM school WHERE schoolId = $school_id";
      $visit_type = $this->db->query($query)->result()[0]->visit_type;

      $query = "update school set visit_list = NULL, visit_type= NULL, visit_entry_date = NULL where schoolId = $school_id";
      if ($visit_type == 'Upgradation') {
         $query = "update school set reg_type_id = 2, visit_list = NULL, visit_type= NULL, visit_entry_date = NULL where schoolId = $school_id";
      }
      $query = $this->db->query($query);
      if ($query) {
         echo 'success';
      } else {
         echo 'error';
      }
   }


   public function add_deficiancy()
   {
      $school_id = (int) $this->input->post('school_id');

      $deficiency = array();
      $deficiency['pending_type'] = 'Deficiency';
      $deficiency['pending_date'] = date('Y-m-d');
      $deficiency['pending_reason'] = $this->input->post('deficiency_reason');
      $this->db->where('schoolId', $school_id);
      if ($this->db->update('school', $deficiency)) {
         echo 'success';
      } else {
         echo 'error';
      }
   }

   public function save_file_number()
   {
      $school_id = (int) $this->input->post('school_id');
      $file_no = $this->db->escape($this->input->post('file_no'));

      $query = "SELECT COUNT(0) as total FROM school_file_numbers WHERE school_id = $school_id";
      $total = $this->db->query($query)->row()->total;
      if ($total) {
         if ($this->input->post('file_no') == "" or $this->input->post('file_no') == 0) {
            $query = "DELETE FROM school_file_numbers WHERE school_id = $school_id";
         } else {
            $query = "UPDATE school_file_numbers SET file_number = $file_no WHERE school_id = $school_id";
         }

         if ($this->db->query($query)) {
            echo 'success';
         } else {
            echo 'error';
         }
      } else {
         $query = "INSERT INTO school_file_numbers (`school_id`, `file_number`) VALUES ($school_id, $file_no)";
         if ($this->db->query($query)) {
            echo 'success';
         } else {
            echo 'error';
         }
      }
   }
}
