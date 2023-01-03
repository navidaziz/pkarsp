<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank_challan_entry extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {

      $this->data['title'] = 'Bank Challan Entry';
      $this->data['description'] = 'Bank Challan Entry';
      $this->data['view'] = 'bank_challan_entry/index';
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


         $this->load->view('bank_challan_entry/school_session_list', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }

   public function edit_bank_challan()
   {
      $this->data['bank_challan_id'] = $this->input->post('bank_challan_id');
      $this->load->view('bank_challan_entry/edit_bank_challan', $this->data);
   }

   public function get_bank_challan_list()
   {
      $query = "SELECT `schools`.`schoolName`, 
      `schools`.`schoolId`, `session_year`.`sessionYearTitle`,
      bank_challans.* FROM bank_challans
      INNER JOIN schools ON(schools.schoolId = bank_challans.schools_id)
      INNER JOIN session_year ON(session_year.sessionYearId = `bank_challans`.`session_id`)
      ";
      $this->data['school_session_challans'] = $this->db->query($query)->result();
      $this->load->view('bank_challan_entry/bank_challan_list', $this->data);
   }


   public function update_bank_challan()
   {


      $bank_challan_id = $this->input->post("bank_challan_id");
      $statn_number = $this->input->post("statn_number");
      $date_of_deposit = $this->input->post("date_of_deposit");
      $application_fee = $this->input->post("application_fee");
      $renewal_fee = $this->input->post("renewal_fee");
      $inspection_fee = $this->input->post("inspection_fee");
      $upgradation_fee = $this->input->post("upgradation_fee");
      $security = $this->input->post("security");
      $late_fee = $this->input->post("late_fee");
      $change_of_name = $this->input->post("change_of_name");
      $change_of_building = $this->input->post("change_of_building");
      $change_of_ownership = $this->input->post("change_of_ownership");
      $penalty = $this->input->post("penalty");
      $miscellaneous = $this->input->post("miscellaneous");
      $fine = $this->input->post("fine");
      $challan_for = $this->input->post("challan_for");
      $userId = $this->session->userdata('userId');

      $query = "SELECT count(*) as total FROM bank_challans WHERE challan_no = '" . $statn_number . "' and bank_challan_id !='" . $bank_challan_id . "'";
      $count = $this->db->query($query)->result()[0]->total;
      if ($count == 0) {

         $query = "UPDATE `bank_challans`
         SET
         `challan_for` = '" . $challan_for . "',
         `challan_no` = '" . $statn_number . "', 
         `challan_date` = '" . $date_of_deposit . "',  
         `application_processing_fee` = '" . $application_fee . "',  
         `renewal_fee` = '" . $renewal_fee . "',
         `upgradation_fee`= '" . $upgradation_fee . "',
         `inspection_fee` = '" . $inspection_fee . "',
         `fine` = '" . $fine . "',
         `security_fee` =  '" . $security . "', 
         `late_fee` = '" . $late_fee . "',
         `change_of_name_fee` = '" . $change_of_name . "',
         `change_of_ownership_fee` = '" . $change_of_ownership . "',
         `change_of_building_fee` = '" . $change_of_building . "', 
         `penalty` = '" . $penalty . "', 
         `miscellaneous` = '" . $miscellaneous . "',
         `created_by` = '" . $userId . "' 
        WHERE bank_challan_id ='" . $bank_challan_id . "'";
         if ($this->db->query($query)) {
            $query = "SELECT (`application_processing_fee`+`renewal_fee`+`upgradation_fee`+`inspection_fee`+`fine`+`security_fee`+`late_fee`+`renewal_and_upgradation_fee`+`change_of_name_fee`+`change_of_ownership_fee`+`change_of_building_fee`+`miscellaneous`+`penalty`) as total FROM `bank_challans` WHERE challan_no = '" . $statn_number . "'";
            $challan_total = $this->db->query($query)->result()[0]->total;
            $query = "UPDATE bank_challans SET total_deposit_fee='" . $challan_total . "' WHERE bank_challan_id ='" . $bank_challan_id . "'";
            $this->db->query($query);
            echo "success";
         } else {
            echo 'error while entering data into the database.';
         }
      } else {
         echo "STAN Number already used. try again with different STAN No.";
      }
      //$variables = $_POST;
      // foreach ($variables as $key => $value) {
      //    echo '\'".$' . $key . '."\', ';
      // }
   }
   public function add_stan_number()
   {


      $school_session_id = (int) $this->input->post("school_session_id");
      if ($school_session_id == 0) {
         $query = "SELECT `sessionYearId` FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;";
         $session_id = $this->db->query($query)->result()[0]->sessionYearId;
      } else {
         $query = "SELECT session_year_id FROM school WHERE schoolId='" . $school_session_id . "';";
         $session_id = $this->db->query($query)->result()[0]->session_year_id;
      }


      $school_id = $this->input->post("school_id");
      $statn_number = $this->input->post("statn_number");
      $date_of_deposit = $this->input->post("date_of_deposit");

      $application_fee = $this->input->post("application_fee");

      $renewal_fee = $this->input->post("renewal_fee");
      $inspection_fee = $this->input->post("inspection_fee");
      $upgradation_fee = $this->input->post("upgradation_fee");
      $security = $this->input->post("security");
      $late_fee = $this->input->post("late_fee");
      $change_of_name = $this->input->post("change_of_name");
      $change_of_building = $this->input->post("change_of_building");
      $change_of_ownership = $this->input->post("change_of_ownership");
      $penalty = $this->input->post("penalty");
      $miscellaneous = $this->input->post("miscellaneous");
      $fine = $this->input->post("fine");

      $challan_for = $this->input->post("challan_for");
      if ($challan_for == 'Change of Name') {
         $change_of_name = $this->input->post("application_fee");
         $application_fee = 0.00;
      }
      if ($challan_for == 'Change of Location') {
         $change_of_building = $this->input->post("application_fee");
         $application_fee = 0.00;
      }
      if ($challan_for == 'Change of Ownership') {
         $change_of_ownership = $this->input->post("application_fee");
         $application_fee = 0.00;
      }
      if ($challan_for == 'Penalty') {
         $penalty = $this->input->post("application_fee");
         $application_fee = 0.00;
      }
      if ($challan_for == 'Miscellaneous' or $challan_for == 'Applicant Certificate') {
         $miscellaneous = $this->input->post("application_fee");
         $application_fee = 0.00;
      }




      $userId = $this->session->userdata('userId');

      $query = "SELECT count(*) as total FROM bank_challans WHERE challan_no = '" . $statn_number . "'";
      $count = $this->db->query($query)->result()[0]->total;
      if ($count == 0) {

         $query = "INSERT INTO `bank_challans`(
         `session_id`, 
         `school_id`, 
         `schools_id`, 
         `challan_for`, 
         `challan_no`, 
         `challan_date`, 
         `application_processing_fee`, 
         `renewal_fee`, 
         `upgradation_fee`, 
         `inspection_fee`, 
         `fine`, 
         `security_fee`, 
         `late_fee`, 
         `change_of_name_fee`, 
         `change_of_ownership_fee`, 
         `change_of_building_fee`, 
         `penalty`,
         `miscellaneous`,
         `status`,
         `created_by`) 
        VALUES (
         '" . $session_id . "',
         '" . $school_session_id . "', 
         '" . $school_id . "', 
         '" . $challan_for . "', 
         '" . $statn_number . "', 
         '" . $date_of_deposit . "', 
         '" . $application_fee . "', 
         '" . $renewal_fee . "', 
         '" . $upgradation_fee . "', 
         '" . $inspection_fee . "',
         '" . $fine . "',
         '" . $security . "', 
         '" . $late_fee . "',
         '" . $change_of_name . "',
         '" . $change_of_ownership . "',
         '" . $change_of_building . "',  
         '" . $penalty . "', 
         '" . $miscellaneous . "',
         '1',
         '" . $userId . "'
         )";
         if ($this->db->query($query)) {
            $query = "SELECT (`application_processing_fee`+`renewal_fee`+`upgradation_fee`+`inspection_fee`+`fine`+`security_fee`+`late_fee`+`renewal_and_upgradation_fee`+`change_of_name_fee`+`change_of_ownership_fee`+`change_of_building_fee`+`miscellaneous`+`penalty`) as total FROM `bank_challans` WHERE challan_no = '" . $statn_number . "'";
            $challan_total = $this->db->query($query)->result()[0]->total;
            $query = "UPDATE bank_challans SET total_deposit_fee='" . $challan_total . "' WHERE challan_no = '" . $statn_number . "'";
            $this->db->query($query);
            echo "success";
         } else {
            echo 'error while entering data into the database.';
         }
      } else {
         echo "STAN Number already used. try again with different STAN No.";
      }
      //$variables = $_POST;
      // foreach ($variables as $key => $value) {
      //    echo '\'".$' . $key . '."\', ';
      // }
   }
}
