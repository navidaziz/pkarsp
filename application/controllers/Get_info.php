<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Get_info extends CI_Controller
{
   public function __construct()
   {
      parent::__construct();
      
   }
   
   
   public function g_emis_code(){
       exit();
      ini_set("memory_limit","512M");
      $emis_code = 1;
      $query = "SELECT * FROM schools WHERE schools.registrationNumber >0";
      $schools = $this->db->query($query)->result();
      
      foreach($schools as $school){
        echo $school->schoolId." - ".$school->schoolName." - P".str_pad($emis_code, 6, '0', STR_PAD_LEFT);
        echo "<br />";
        $school_emis_code = "P".str_pad($emis_code, 6, '0', STR_PAD_LEFT);
        $emis_code++;
        $query="UPDATE `schools` SET `emis_code`='".$school_emis_code."' WHERE schoolId='".$school->schoolId."'";
        $this->db->query($query);
      }
   }

   public function get_school_active_session()
   {
      $schools_id = (int) $this->input->post('id');

      $query = "SELECT `schools`.`registrationNumber` FROM schools
              WHERE `schools`.`schoolId`='" . $schools_id . "'";
      $school_registration_number = $this->db->query($query)->row()->registrationNumber;

      if ($school_registration_number) {
         $query = "SELECT schoolId, sy.sessionYearTitle FROM `school` as s 
         INNER JOIN session_year as sy ON (sy.sessionYearId = s.session_year_id) 
         WHERE schools_id='" . $schools_id . "' and s.status=2;";
      } else {
         $query = "SELECT schoolId, sy.sessionYearTitle FROM `school` as s 
         INNER JOIN session_year as sy ON (sy.sessionYearId = s.session_year_id) 
         WHERE schools_id='" . $schools_id . "'";
      }
     
      
      $school_session = $this->db->query($query)->result();
      if($school_session){
        echo '<br />
        <strong> Deficiency on session: <strong> <select required="required" name="school_session_id">
         <option  value=""> Select Session</option>';
         
         foreach($school_session as $session){
         echo '<option value="'.$session->schoolId.'">'.$session->sessionYearTitle.'</option>';
      }
        echo '</select>';

        echo '<br />
         <strong> Deficiency Reason: <strong>
         <input  type="radio" name="deficiency_reason" value="Fee Deficiency" /> Fee Deficiency
         <input required="required" type="radio" name="deficiency_reason" value="Data Deficiency" /> Data Deficiency
         <input required="required" type="radio" name="deficiency_reason" value="Fine" /> Fine 
         <input required="required" type="radio" name="deficiency_reason" value="Challan Verification" /> Challan Verification
        ';
         
      }else{


      echo '<br />
         <strong> Deficiency Reason: <strong>
         <input required="required" type="radio" name="deficiency_reason" value="Fine" /> Fine 
         <input required="required" type="radio" name="deficiency_reason" value="Others" /> Others
        ';
      }

      }
   
}