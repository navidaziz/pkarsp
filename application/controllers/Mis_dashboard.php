<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mis_dashboard extends admin_Controller
//class Mis_dashbaord extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      $this->data['title'] = 'MIS Dashboard';
      $this->data['description'] = 'Registration / Renewal and Upgradation Interface';
      $this->data['view'] = 'mis_dashboard/dashboard';
      $this->load->view('layout', $this->data);
   }

   public function school_summary()
   {


      $visit_type = $this->input->post('type');
      $region = $this->input->post('region');
      $this->data['schoolid'] = $schoolid = $this->db->escape($this->input->post('search'));
      $query = "SELECT
   	`schools`.schoolId as schools_id
   	, `schools`.`registrationNumber`
      , `schools`.`schoolName`
      , `schools`.`yearOfEstiblishment`
      , `schools`.`school_type_id`
      , `schools`.`level_of_school_id`
      , `schools`.`gender_type_id`
      , (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
      , `district`.`districtTitle` 
      , `tehsils`.`tehsilTitle`
      , (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
      `schools`.`address`,
      `schools`.`telePhoneNumber` as `phone_no`,
      `schools`.`schoolMobileNumber` as `mobile_no`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`principal_email`,
      users.userTitle,
      users.userName,
      users.userPassword,
      users.cnic,
      users.contactNumber as owner_no
   	FROM `schools` INNER JOIN `district` 
        ON (`schools`.`district_id` = `district`.`districtId`) 
        INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`) 
        INNER JOIN users ON(users.userId = schools.owner_id)";
      $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
      $school = $this->db->query($query)->row();
      if ($school) {

         if ($school->registrationNumber) {
            $this->data['visit_type'] = 'Upgradation';
         } else {
            $this->data['visit_type'] = 'Registration';
         }

         $this->data['school'] = $school;


         $this->load->view('mis_dashboard/school_detail', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }

   public function get_renewal_issue_interface()
   {


      $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');

      $query = "SELECT isfined FROM schools WHERE schoolId = '" . $schools_id . "'";
      $isfined = $this->db->query($query)->row()->isfined;
      if ($isfined == 1) {
         echo '
         <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

         <div class="row">
         <div class="col-md-12">
         <div style="text-align:center">
         <div class="alert alert-warning">';
         echo 'We cannot issue renewal or registration until the fine imposed on the school is paid to the operation wing.';
         echo '</div>
         </div>
         </div>
         <div>
         </div>';
         exit();
      }

      $query = "SELECT section_e FROM school WHERE schoolId = '" . $school_id . "'";
      $section_e = $this->db->query($query)->row()->section_e;
      if ($section_e == 0) {
         echo '
         <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

         <div class="row">
         <div class="col-md-12">
         <div style="text-align:center">
         <div class="alert alert-warning">';
         echo 'Section E open for update. We cannot issue renewal or registration until School submit updated section E.';
         echo '</div>
         </div>
         </div>
         <div>
         </div>';
         exit();
      }




      $query = "SELECT `level_of_school_id` FROM school 
                WHERE schools_id = '" . $schools_id . "'
                AND status = 1
                AND schoolId <'" . $school_id . "' LIMIT 1";
      $previous_session = $this->db->query($query)->row();
      $previous_session_level = 0;
      if ($previous_session) {
         $previous_session_level =  $previous_session->level_of_school_id;
      }

      $this->data['previous_session_level'] = $previous_session_level;

      $query = "SELECT `school`.*, 
      `schools`.`registrationNumber`, 
      `schools`.`yearOfEstiblishment`,
      `session_year`.`sessionYearTitle`,
      reg_type.regTypeTitle
      FROM school
      INNER JOIN session_year ON(session_year.sessionYearId = school.session_year_id) 
      INNER JOIN reg_type ON(reg_type.regTypeId = school.reg_type_id) 
      INNER JOIN schools ON(school.schools_id = schools.schoolId)
      WHERE school.schools_id = '" . $schools_id . "'
      AND school.schoolId = '" . $school_id . "'";
      $this->data['school'] = $school =  $this->db->query($query)->row();
      if ($school->registrationNumber) {
         $this->data['title'] = $school->regTypeTitle;
         $this->data['description'] = 'For Session ' . $school->sessionYearTitle;
         $this->load->view('mis_dashboard/get_renewal_issue_interface', $this->data);
      } else {
         $this->data['title'] = "New Registration";
         $this->data['description'] = 'For Session ' . $school->sessionYearTitle;
         $this->load->view('mis_dashboard/get_registration_issue_interface', $this->data);
      }
   }

   public function isssue_renewal()
   {

      $signatory = (int) $this->input->post('signatory');
      date_default_timezone_set("Asia/Karachi");
      $dated =  date("Y-m-d h:i:s");
      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');

      $upgradation = $this->input->post('upgradation');
      if ($upgradation === 'yes') {
         $levels = $this->input->post('levels');
         $selected_levels = array();
         foreach ($levels as $level_id => $level) {
            if ($level_id == 1) {
               $selected_levels[] = $level_id;
            }
            if ($level_id == 2) {
               $selected_levels[] = $level_id;
            }
            if ($level_id == 3) {
               $selected_levels[] = $level_id;
            }
            if ($level_id == 4) {
               $selected_levels[] = $level_id;
            }

            $query = "UPDATE school SET level_of_school_id = '" . max($selected_levels) . "',
         upgrade=1
                 WHERE schools_id = '" . $schools_id . "'
                 AND schoolId = '" . $school_id . "'";
            $this->db->query($query);

            $query = "UPDATE school SET level_of_school_id = '" . max($selected_levels) . "'
         WHERE schools_id = '" . $schools_id . "'
                 AND schoolId > '" . $school_id . "'";
            $this->db->query($query);
         }



         // $this->db->where('schoolId', $school_id);
         // $upgrade['level_of_school_id'] = ;
         // $this->db->update('school', $upgrade);
         $registration_type = "Renewal-Upgradation";
      } else {
         $registration_type = "Renewal";
      }


      $row = $this->db->where('schoolId', $school_id)->get('school')->row();
      $renewal_code = '';
      $schoolId = $row->schoolId;
      $schools_id = $row->schools_id;
      $reg_type_id = $row->reg_type_id;
      $session_id = $row->session_year_id;
      $renewal_code = $reg_type_id . "-" . $schoolId . "-" . $session_id;
      //echo $renewal_code;exit;
      $arr = array();
      if ($renewal_code != "") {
         $update_data = array(
            'renewal_code' => $renewal_code,
            'status' => 1,
            'updatedDate' => $dated,
            'signatory_id' => $signatory,
            'cer_issue_date' => date("Y-m-d h:i:s"),
            'updatedBy' => $this->session->userdata('userId')
         );



         $update_data['primary'] = 0;
         $update_data['middle'] = 0;
         $update_data['high'] = 0;
         $update_data['high_sec'] = 0;
         $levels = $this->input->post('levels');
         foreach ($levels as $level_id => $level) {
            if ($level_id == 1) {
               $update_data['primary'] = 1;
            }
            if ($level_id == 2) {
               $update_data['middle'] = 1;
            }
            if ($level_id == 3) {
               $update_data['high'] = 1;
            }
            if ($level_id == 4) {
               $update_data['high_sec'] = 1;
            }
         }

         $this->db->where('schoolId', $school_id);
         $affected_rows = $this->db->update('school', $update_data);
         if ($affected_rows > 0) {
            $this->send_certificate($schools_id, $school_id, $registration_type);
            $arr['schools_id'] = $schools_id;
            $arr['msg'] = "Issued Successfully";
            $arr['success'] = true;
         } else {
            $arr['msg'] = "Error Try Again";
            $arr['success'] = false;
         }
      } else {

         $arr['msg'] = "Error Try Again";
         $arr['success'] = false;
      }

      echo json_encode($arr);
      exit;
   }

   public function isssue_registration()
   {
      date_default_timezone_set("Asia/Karachi");
      $dated =  date("Y-m-d h:i:s");
      $school_id = $this->input->post('school_id');
      $schools_id = $this->input->post('schools_id');



      $row = $this->db->where('schoolId', $schools_id)->get('schools')->row();

      $yearOfEstiblishment = $row->yearOfEstiblishment;
      $tehsil_id = $row->tehsil_id;
      if (!$tehsil_id) {
         $arr['msg'] = "Tehsil ID missing.";
         $arr['success'] = false;
         echo json_encode($arr);
         exit;
      }
      $district_id = $row->district_id;
      if (!$district_id) {
         $arr['msg'] = "Tehsil ID missing.";
         $arr['success'] = false;
         echo json_encode($arr);
         exit;
      }


      // update year of establishment 


      if (!$this->input->post('year_of_establishment')) {
         $arr['msg'] = " Year of Establishment Required";
         $arr['success'] = false;
         echo json_encode($arr);
         exit;
      } else {
         $this->db->where('schoolId', $schools_id);
         $year_of_establishment['yearOfEstiblishment'] = $this->input->post('year_of_establishment');
         $this->db->update('schools', $year_of_establishment);
      }


      if (!$this->input->post('session_id')) {
         $arr['msg'] = " Session Required";
         $arr['success'] = false;
         echo json_encode($arr);
         exit;
      } else {
         //update registration session 
         $this->db->where('schoolId', $school_id);
         $session_year_id['session_year_id'] = $this->input->post('session_id');
         $this->db->update('school', $session_year_id);
      }






      $levels = $this->input->post('levels');
      if (is_null($levels)) {
         $arr['msg'] = " A certain level is required. For registration, you must select at least one level.";
         $arr['success'] = false;
         echo json_encode($arr);
         exit;
      }
      $selected_levels = array();
      foreach ($levels as $level_id => $level) {
         if ($level_id == 1) {
            $selected_levels[] = $level_id;
         }
         if ($level_id == 2) {
            $selected_levels[] = $level_id;
         }
         if ($level_id == 3) {
            $selected_levels[] = $level_id;
         }
         if ($level_id == 4) {
            $selected_levels[] = $level_id;
         }
      }


      $query = "UPDATE school SET level_of_school_id = '" . max($selected_levels) . "'
      WHERE schools_id = '" . $schools_id . "'
              AND schoolId >= $school_id";
      $this->db->query($query);


      $where = array('tehsilId' => $tehsil_id, 'district_id' => $district_id);
      $this->db->where($where);
      $autoIncreamentNumberRow = $this->db->get('registration_code')->result()[0];
      $registrationNumberIncreamentId = $autoIncreamentNumberRow->registrationNumberIncreamentId;
      $registrationNumberIncreament = $autoIncreamentNumberRow->registrationNumberIncreament;

      $district_id_with_prefix_zero = sprintf("%02d", $district_id);
      $tehsil_id_with_prefix_zero = sprintf("%03d", $tehsil_id);
      $yearOfEstiblishment = substr($yearOfEstiblishment, 2);
      $codeCombined = $district_id_with_prefix_zero . $tehsil_id_with_prefix_zero . $registrationNumberIncreament . $yearOfEstiblishment;

      $data["district_id"] = $district_id;
      $data["tehsil_id"] = $tehsil_id;
      $data["school_id"] = $school_id;
      $data["codeCombined"] = $codeCombined;

      $update_data = array(
         'registrationNumber' => $codeCombined,
         'updatedDate' => $dated,
         'updatedBy' => $this->session->userdata('userId')
      );


      $this->db->where('schoolId', $schools_id);
      $this->db->update('schools', $update_data);
      $affected_rows = $this->db->affected_rows();
      if ($affected_rows) {

         $signatory = (int) $this->input->post('signatory');
         $update_data = array(
            'renewal_code' => 0,
            'status' => 1,
            'updatedDate' => $dated,
            'signatory_id' => $signatory,
            'cer_issue_date' => date("Y-m-d h:i:s"),
            'updatedBy' => $this->session->userdata('userId')
         );

         $update_data['primary'] = 0;
         $update_data['middle'] = 0;
         $update_data['high'] = 0;
         $update_data['high_sec'] = 0;
         $levels = $this->input->post('levels');
         if (is_null($levels)) {
         }
         foreach ($levels as $level_id => $level) {
            if ($level_id == 1) {
               $update_data['primary'] = 1;
            }
            if ($level_id == 2) {
               $update_data['middle'] = 1;
            }
            if ($level_id == 3) {
               $update_data['high'] = 1;
            }
            if ($level_id == 4) {
               $update_data['high_sec'] = 1;
            }
         }

         $this->db->where('schoolId', $school_id);
         $this->db->update('school', $update_data);




         $update_increament = array(
            'registrationNumberIncreament' => $registrationNumberIncreament + 1
         );
         $where1 = array('tehsilId' => $tehsil_id, 'district_id' => $district_id);
         $this->db->where($where1);
         $this->db->update('registration_code', $update_increament);
         $affected_rows = $this->db->affected_rows();

         if ($this->send_certificate($schools_id, $school_id, 'Registration')) {
            $arr['schools_id'] = $schools_id;
            $arr['msg'] = "Issued Successfully";
            $arr['success'] = true;
         } else {
            $arr['msg'] = "Error try again.";
            $arr['success'] = false;
         }
      } else {
         $arr['msg'] = "Error try again.";
         $arr['success'] = false;
      }
      echo json_encode($arr);
      exit;
   }

   private function send_certificate($schools_id, $school_id, $registration_type)
   {
      $school_id = (int) $school_id;
      $schools_id = (int) $schools_id;
      date_default_timezone_set("Asia/Karachi");
      $insert['subject'] = "Institute " . $registration_type . " Certificate";
      $insert['discription'] = '
         I am writing to inform you that your Institute ' . $registration_type . ' Certificate has been sent to you. 
         Once you have received it, please download or print the certificate.
         <br />
         <br />
         <form target="_blank" method="post" action="' . base_url('school/certificate') . '">
         <input type="hidden" name="school_id" value="' . $school_id . '">
         <input type="submit" class="btn btn-primary" value="Download Certificate">
         </form>
         <br />
         <br />
         If you have any questions or concerns regarding your registration, 
         please do not hesitate to contact KP-PSRA Registration Office.
         <br />
         Thank you.
             ';

      $insert['created_by'] = $this->session->userdata('userId');
      $insert['created_date'] = date("d-m-Y h:i:s");
      $insert['select_all'] = "no";
      $insert['district_id'] = 0;
      $insert['level_id'] = 0;
      $insert['like_text'] = "";

      $this->db->set($insert);
      $this->db->insert("message_for_all");
      $message_id = $this->db->insert_id();
      if ($message_id) {
         $input = array();
         $input['school_id'] = $schools_id;
         $input['message_id'] = $message_id;
         $this->db->set($input);
         $this->db->insert("message_school");
         return true;
      } else {
         return true;
      }
   }
   //section E unlock
   public function unlock_editing()
   {
      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');
      $query = "UPDATE `school` SET section_e = 0  WHERE status='2' AND schoolId = '" . $school_id . "' 
      AND schools_id ='" . $schools_id . "' LIMIT 1";
      if ($this->db->query($query)) {
         $userId = $this->session->userdata('userId');
         $query = "INSERT INTO `section_open_log`(`school_id`, `status`, `user_id`) 
                 VALUES ('" . $school_id . "','Open for editing','" . $userId . "')";
         $this->db->query($query);
         echo 'success';
      } else {
         echo 'error';
      }
   }
   //section E lock
   public function lock_editing()
   {
      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');
      $query = "UPDATE `school` SET section_e = 1  WHERE status='2' AND schoolId = '" . $school_id . "' 
      AND schools_id ='" . $schools_id . "' LIMIT 1";
      if ($this->db->query($query)) {
         $userId = $this->session->userdata('userId');
         $query = "INSERT INTO `section_open_log`(`school_id`, `status`, `user_id`) 
                 VALUES ('" . $school_id . "','Close editing','" . $userId . "')";
         $this->db->query($query);
         echo 'success';
      } else {
         echo 'error';
      }
   }




   // public function inspections()
   // {
   //    $this->data['title'] = 'Inspections';
   //    $this->data['description'] = 'List of All Inspections';
   //    $this->data['view'] = 'registration_section/inspections';
   //    $this->load->view('layout', $this->data);
   // }

   // private function get_request_list($status, $file_status, $request_type = NULL, $title = NULL)
   // {
   //    $userId = $this->session->userdata('userId');
   //    $query = "SELECT region_ids FROM users WHERE userId = '" . $userId . "'";
   //    $region_ids = $this->db->query($query)->row()->region_ids;

   //    $query = "SELECT
   // 	`schools`.schoolId as schools_id,
   // 	`schools`.schoolName,
   // 	`schools`.registrationNumber,
   // 	`schools`.biseRegister,
   // 	`session_year`.`sessionYearTitle`,
   // 	`session_year`.`sessionYearId`,
   // 	`school`.`status`,
   // 	`reg_type`.`regTypeTitle`,
   // 	`school`.`schoolId` as school_id,
   // 	`district`.`districtTitle`,
   //    `school`.`file_status`,
   //       `school`.`apply_date`,
   //             (SELECT s.status
   //             FROM school as s WHERE 
   //             s.schools_id = `schools`.`schoolId`
   //             AND  s.session_year_id = (`school`.`session_year_id`-1) and s.schools_id = schools.schoolId LIMIT 1) as previous_session_status,
   //       (SELECT COUNT(*)
   //             FROM school as s WHERE 
   //             s.schools_id = `schools`.`schoolId`
   //             AND  s.status != 1 and `s`.`file_status`=5) as deficient
   //             FROM
   //             `school`,
   //             `schools`,
   //             `session_year`,
   //             `reg_type`,
   //             `district`

   //             WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
   //             AND `school`.`schools_id` = `schools`.`schoolId`
   //             AND `school`.`reg_type_id` = `reg_type`.`regTypeId` 
   //             AND schools.district_id = district.districtId 
   //             AND district.new_region IN(" . $region_ids . ") ";

   //    if ($status) {
   //       $query .= " AND `school`.`status`='" . $status . "'";
   //    }

   //    if ($file_status) {
   //       $query .= " AND `school`.`file_status`= '" . $file_status . "'";
   //    }


   //    if ($request_type) {
   //       $query .= "AND `school`.`reg_type_id`= $request_type";
   //    }


   //    if ($title) {
   //       $this->data['title'] = $title;
   //    }

   //    $query .= " ORDER BY `school`.`schools_id` ASC, `school`.`session_year_id` ASC ";


   //    $this->data['list_type'] = $file_status;
   //    $this->data['requests'] = $this->db->query($query)->result();

   //    $this->load->view('mis_dashboard/requests', $this->data);
   // }

   // // private function school_detail($schools_id)
   // // {
   // //    $query = "SELECT
   // // 	            `schools`.`schoolId` as schools_id,
   // // 				`schools`.`schoolName`,
   // // 				`schools`.`registrationNumber`,
   // // 				`schools`.`yearOfEstiblishment`,
   // // 				`tehsils`.`tehsilTitle`,
   // // 				`district`.`division`,
   // // 				`schools`.`telePhoneNumber`,
   // // 				`schools`.`schoolMobileNumber`,
   // // 				`schools`.`principal_email`,
   // // 				`levelofinstitute`.`levelofInstituteTitle`,
   // // 				`genderofschool`.`genderOfSchoolTitle`,
   // // 				`users`.`userTitle`,
   // // 				`users`.`userEmail`,
   // // 				`users`.`cnic`,
   // // 				`users`.`contactNumber`,
   // // 				`schools`.`mediumOfInstruction`,
   // // 				`schools`.`biseRegister`,
   // // 				`schools`.`biseregistrationNumber`,
   // // 				`schools`.`primaryRegDate`,
   // // 				`schools`.`highRegDate`,
   // // 				`schools`.`interRegDate`,
   // // 				`schools`.`biseAffiliated`,
   // // 				`schools`.`bise_verified`,
   // // 				`schools`.`level_of_school_id`,
   // // 				`school_type`.`typeTitle`,
   // // 				`bise`.`biseName`,
   // // 				`district`.`districtTitle`,
   // // 				`uc`.`ucTitle`,
   // // 				`schools`.`primary_level`,
   // // 				`schools`.`middle_level`,
   // // 				`schools`.`high_level`,
   // // 				`schools`.`h_sec_college_level`
   // // 				FROM
   // // 				`district`
   // // 				INNER JOIN `schools`
   // // 					ON (
   // // 					`district`.`districtId` = `schools`.`district_id`
   // // 					)
   // // 				INNER JOIN `tehsils`
   // // 					ON (
   // // 					`tehsils`.`tehsilId` = `schools`.`tehsil_id`
   // // 					)
   // // 				INNER JOIN `levelofinstitute`
   // // 					ON (
   // // 					`levelofinstitute`.`levelofInstituteId` = `schools`.`level_of_school_id`
   // // 					)
   // // 				INNER JOIN `genderofschool`
   // // 					ON (
   // // 					`genderofschool`.`genderOfSchoolId` = `schools`.`gender_type_id`
   // // 					)
   // // 				LEFT JOIN `school_type`
   // // 					ON (
   // // 					`schools`.`school_type_id` = `school_type`.`typeId`
   // // 					)
   // // 				INNER JOIN `users`
   // // 					ON (
   // // 					`users`.`userId` = `schools`.`owner_id`
   // // 					)
   // // 				LEFT JOIN `bise`
   // // 					ON (
   // // 					`schools`.`bise_id` = `bise`.`biseId`
   // // 					)
   // // 				LEFT JOIN `uc`
   // // 					ON (
   // // 					`uc`.`ucId` = `schools`.`uc_id`
   // // 					)	
   // // 				WHERE schools.schoolId = '" . $schools_id . "'
   // // 						";

   // //    return $this->db->query($query)->result()[0];
   // // }

   // // public function get_new_requests()
   // // {
   // //    $this->get_request_list(2, 1, 2, 'New Renewal');
   // //    $this->get_request_list(2, 1, 4, 'New Renewal-Upgradation');
   // //    $this->get_request_list(2, 1, 1, 'New Registration');
   // //    $this->get_request_list(2, 1, 3, 'Upgradation');
   // // }


   // // public function deficient_cases()
   // // {

   // //    $this->get_request_list(2, 5, 2, 'Financially Deficient Cases');
   // //    $this->get_request_list(2, 4, 2, 'Forwarded To Operation Wing');
   // //    $this->get_request_list(2, 10, 2, 'Marked Completed (Issue Pending)');
   // // }


   // // public function new_inspection_requests()
   // // {
   // //    $this->get_request_list(4, NULL, 'New Inspection');
   // // }
   // // public function awating_inspection_requests()
   // // {
   // //    $this->get_request_list(5, NULL, 'Inspection Inprogress');
   // // }
   // // public function notesheet()
   // // {
   // //    $this->get_request_list(2, 2, 'Renewal Note Sheet');
   // //    $this->get_request_list(2, 1, 'Registration Note Sheet');
   // // }
   // // public function completed_requests()
   // // {
   // //    //$this->get_request_list(1, NULL, 'Completed Requests');
   // // }
   // // public function inspection_requests()
   // // {
   // //    $query = "SELECT
   // // 	`schools`.schoolId as schools_id,
   // // 	`schools`.schoolName,
   // // 	`schools`.registrationNumber,
   // // 	`schools`.biseRegister,
   // // 	`session_year`.`sessionYearTitle`,
   // // 	`session_year`.`sessionYearId`,
   // // 	`school`.`status`,
   // // 	`school`.`schoolId` as school_id,
   // // 	`reg_type`.`regTypeTitle`
   // // 	FROM
   // // 	`school`,
   // // 	`schools`,
   // // 	`session_year`,
   // // 	`reg_type`
   // // 	WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
   // // 	AND `school`.`schools_id` = `schools`.`schoolId`
   // // 	AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
   // // 	AND `school`.`reg_type_id`=6";
   // //    $this->data['completed_requests'] = $this->db->query($query)->result();

   // //    $this->load->view('registration_section/inspection_requests', $this->data);
   // // }

   // // public function get_request_detail()
   // // {

   // //    $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
   // //    $this->data['session_id'] = $session_id = (int) $this->input->post('session_id');

   // //    $query = "SELECT `school`.*,
   // // 	`reg_type`.`regTypeTitle`,
   // // 	`school_type`.`typeTitle`,
   // // 	`levelofinstitute`.`levelofInstituteTitle`,
   // // 	`session_year`.`sessionYearTitle`
   // //   FROM
   // // 	`reg_type`
   // // 	INNER JOIN `school`
   // // 	  ON (
   // // 		`reg_type`.`regTypeId` = `school`.`reg_type_id`
   // // 	  )
   // // 	INNER JOIN `school_type`
   // // 	  ON (
   // // 		`school_type`.`typeId` = `school`.`school_type_id`
   // // 	  )
   // // 	INNER JOIN `levelofinstitute`
   // // 	  ON (
   // // 		`levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
   // // 	  )
   // // 	INNER JOIN `session_year`
   // // 	  ON (
   // // 		`session_year`.`sessionYearId` = `school`.`session_year_id`
   // // 	  )
   // // 	  WHERE  `school`.`schoolId` = '" . $school_id . "'
   // // 	  AND `school`.`session_year_id` = '" . $session_id . "'";
   // //    $session_request_detail = $this->db->query($query)->result()[0];
   // //    $this->data['schools_id'] = $session_request_detail->schools_id;
   // //    $this->data['school'] = $this->school_detail($session_request_detail->schools_id);
   // //    $this->data['session_request_detail'] = $session_request_detail;

   // //    // $query = "SELECT MAX(tuitionFee) as max_tution_fee 
   // //    //  FROM `fee` WHERE school_id= '" . $school_id . "'";
   // //    // $this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
   // //    // 	'/[^0-9.]/',
   // //    // 	'',
   // //    // 	$this->db->query($query)->result()[0]->max_tution_fee
   // //    // );
   // //    // $query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee 
   // //    // FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
   // //    // $this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



   // //    $query = "SELECT * FROM `bank_challans` 
   // // 	          WHERE school_id = '" . $session_request_detail->schoolId . "'
   // // 			  AND session_id ='" . $session_id . "'
   // // 			  AND verified ='1' ";
   // //    $this->data['bank_challans'] = $this->db->query($query)->result();

   // //    $query = "SELECT `schoolStaffName`as `name`, MIN(DATE(`schoolStaffAppointmentDate`)) as appoinment_date 
   // // 	FROM `school_staff` WHERE school_id= '" . $school_id . "'";
   // //    $this->data['first_appointment_staff'] = $this->db->query($query)->result()[0];




   // //    $this->load->view('mis_dashboard/request_detail', $this->data);
   // // }


   // public function school_session_list()
   // {



   //    $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
   //    $query = "SELECT  `schools`.`schoolId` AS `schools_id`
   //    , `schools`.`registrationNumber`
   //    , `schools`.`schoolName`
   //    , `schools`.`yearOfEstiblishment`
   //    , `schools`.`school_type_id`
   //    , `schools`.`level_of_school_id`
   //    , `schools`.`gender_type_id`
   //    , (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
   //    , `district`.`districtTitle` 
   //    , `tehsils`.`tehsilTitle`
   //    , (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
   //    `schools`.`address`,
   //    `schools`.`telePhoneNumber`,
   //    `schools`.`isfined`,
   //    `schools`.`file_no`,
   //    `schools`.`schoolMobileNumber`
   // 	FROM `schools` 
   //    INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
   //    INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
   //    ";
   //    $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
   //    $school = $this->db->query($query)->row();
   //    if ($school) {

   //       if ($school->registrationNumber) {
   //          $this->data['visit_type'] = 'Upgradation';
   //       } else {
   //          $this->data['visit_type'] = 'Registration';
   //       }

   //       $this->data['school'] = $school;
   //       var_dump($school);


   //       $this->load->view('mis_dashboard/add_bank_challan', $this->data);
   //       //$this->load->view('mis_dashboard/school_session_list', $this->data);
   //    } else {
   //       echo "School ID not found try again with different School ID.";
   //       exit();
   //    }
   // }

   // public function add_stan_number()
   // {


   //    $school_session_id = (int) $this->input->post("school_session_id");
   //    if ($school_session_id == 0) {
   //       $query = "SELECT `sessionYearId` FROM `session_year` ORDER BY sessionYearId DESC LIMIT 1;";
   //       $session_id = $this->db->query($query)->result()[0]->sessionYearId;
   //    } else {
   //       $query = "SELECT session_year_id FROM school WHERE schoolId='" . $school_session_id . "';";
   //       $session_id = $this->db->query($query)->result()[0]->session_year_id;
   //    }


   //    $school_id = $this->input->post("school_id");
   //    $statn_number = $this->input->post("statn_number");
   //    $date_of_deposit = $this->input->post("date_of_deposit");

   //    $application_fee = $this->input->post("application_fee");

   //    $renewal_fee = $this->input->post("renewal_fee");
   //    $inspection_fee = $this->input->post("inspection_fee");
   //    $upgradation_fee = $this->input->post("upgradation_fee");
   //    $security = $this->input->post("security");
   //    $late_fee = $this->input->post("late_fee");
   //    $change_of_name = $this->input->post("change_of_name");
   //    $change_of_building = $this->input->post("change_of_building");
   //    $change_of_ownership = $this->input->post("change_of_ownership");
   //    $penalty = $this->input->post("penalty");
   //    $miscellaneous = $this->input->post("miscellaneous");
   //    $fine = $this->input->post("fine");

   //    $challan_for = $this->input->post("challan_for");
   //    if ($challan_for == 'Change of Name') {
   //       $change_of_name = $this->input->post("application_fee");
   //       $application_fee = 0.00;
   //    }
   //    if ($challan_for == 'Change of Location') {
   //       $change_of_building = $this->input->post("application_fee");
   //       $application_fee = 0.00;
   //    }
   //    if ($challan_for == 'Change of Ownership') {
   //       $change_of_ownership = $this->input->post("application_fee");
   //       $application_fee = 0.00;
   //    }
   //    if ($challan_for == 'Penalty') {
   //       $penalty = $this->input->post("application_fee");
   //       $application_fee = 0.00;
   //    }
   //    if ($challan_for == 'Miscellaneous' or $challan_for == 'Applicant Certificate') {
   //       $miscellaneous = $this->input->post("application_fee");
   //       $application_fee = 0.00;
   //    }




   //    $userId = $this->session->userdata('userId');

   //    $query = "SELECT count(*) as total FROM bank_challans WHERE challan_no = '" . $statn_number . "'";
   //    $count = $this->db->query($query)->result()[0]->total;
   //    if ($count == 0) {

   //       $query = "INSERT INTO `bank_challans`(
   //       `session_id`, 
   //       `school_id`, 
   //       `schools_id`, 
   //       `challan_for`, 
   //       `challan_no`, 
   //       `challan_date`, 
   //       `application_processing_fee`, 
   //       `renewal_fee`, 
   //       `upgradation_fee`, 
   //       `inspection_fee`, 
   //       `fine`, 
   //       `security_fee`, 
   //       `late_fee`, 
   //       `change_of_name_fee`, 
   //       `change_of_ownership_fee`, 
   //       `change_of_building_fee`, 
   //       `penalty`,
   //       `miscellaneous`,
   //       `created_by`,
   //       `verified_by`,
   //       `verified`
   //       ) 
   //      VALUES (
   //       '" . $session_id . "',
   //       '" . $school_session_id . "', 
   //       '" . $school_id . "', 
   //       '" . $challan_for . "', 
   //       '" . $statn_number . "', 
   //       '" . $date_of_deposit . "', 
   //       '" . $application_fee . "', 
   //       '" . $renewal_fee . "', 
   //       '" . $upgradation_fee . "', 
   //       '" . $inspection_fee . "',
   //       '" . $fine . "',
   //       '" . $security . "', 
   //       '" . $late_fee . "',
   //       '" . $change_of_name . "',
   //       '" . $change_of_ownership . "',
   //       '" . $change_of_building . "',  
   //       '" . $penalty . "', 
   //       '" . $miscellaneous . "',
   //       '" . $userId . "',
   //       '" . $userId . "',
   //       '1'
   //       )";
   //       if ($this->db->query($query)) {
   //          $query = "SELECT (`application_processing_fee`+`renewal_fee`+`upgradation_fee`+`inspection_fee`+`fine`+`security_fee`+`late_fee`+`renewal_and_upgradation_fee`+`change_of_name_fee`+`change_of_ownership_fee`+`change_of_building_fee`+`miscellaneous`+`penalty`) as total FROM `bank_challans` WHERE challan_no = '" . $statn_number . "'";
   //          $challan_total = $this->db->query($query)->result()[0]->total;
   //          $query = "UPDATE bank_challans SET total_deposit_fee='" . $challan_total . "' WHERE challan_no = '" . $statn_number . "'";
   //          $this->db->query($query);
   //          echo "success";
   //       } else {
   //          echo 'error while entering data into the database.';
   //       }
   //    } else {
   //       echo "<div class='alert alert-danger'>";
   //       $query = "SELECT * FROM bank_challans WHERE challan_no = '" . $statn_number . "'";
   //       $stan_detail = $this->db->query($query)->row();
   //       if ($stan_detail->old_challan_id) {
   //          echo "<strong style='color:red'>
   //            STAN Number already used in Old Challan Data. Try again with different STAN No.</strong><br />";
   //          // var_dump($stan_detail);
   //          $query = "SELECT * FROM `old_challans` WHERE stan_no='" . $statn_number . "'";
   //          $old_challans = $this->db->query($query)->result();
   //          foreach ($old_challans as $old_challan_detail) {
   //             echo "STAN: <strong>" . $old_challan_detail->stan_no . "</strong> - Date: <strong>" . $old_challan_detail->date . "</strong> - Challan For: <strong>" . $challan->remarks . "</strong> -  School ID: <strong>" . $old_challan_detail->school_id . "</strong> - School Name: <strong>" . $old_challan_detail->school_name . "</strong> - Session: <strong>" . $old_challan_detail->session . "</strong> - Excel S.No: <strong>" . $old_challan_detail->excel_s_no . "</strong>";
   //             echo "<br />";
   //          }
   //       } else {
   //          echo "<strong style='color:red'>STAN Number already used. try again with different STAN No.</strong><br />";
   //          $query = "SELECT bank_challans.challan_no, bank_challans.challan_date, 
   //                 bank_challans.challan_for,
   //                 schools.schoolId, schools.schoolName, session_year.sessionYearTitle
   //                          FROM `bank_challans`
   //                          INNER JOIN schools ON(schools.schoolId = bank_challans.schools_id)
   //                          INNER JOIN school ON(school.schoolId = bank_challans.school_id)
   //                          INNER JOIN session_year ON(session_year.sessionYearId=school.session_year_id)
   //                          WHERE bank_challans.challan_no = '" . $statn_number . "'";
   //          $challans = $this->db->query($query)->result();
   //          foreach ($challans as $challan) {
   //             echo "STAN: <strong>" . $challan->challan_no . "</strong> - Date: <strong>" . $challan->challan_date . "</strong> - Challan For: <strong>" . $challan->challan_for . "</strong> -  School ID: <strong>" . $challan->schoolId . "</strong> - 
   //                      School Name: <strong>" . $challan->schoolName . "</strong> - Session: <strong>" . $challan->sessionYearTitle . "</strong> ";
   //             echo "<br />";
   //          }
   //       }
   //       echo "</div>";
   //       //echo "STAN Number already used. try again with different STAN No.";
   //    }
   // }

   // public function edit_bank_challan()
   // {
   //    $this->data['bank_challan_id'] = $this->input->post('bank_challan_id');
   //    $this->load->view('mis_dashboard/edit_bank_challan', $this->data);
   // }

   // public function update_bank_challan()
   // {


   //    $bank_challan_id = $this->input->post("bank_challan_id");
   //    $statn_number = $this->input->post("statn_number");
   //    $date_of_deposit = $this->input->post("date_of_deposit");
   //    $application_fee = $this->input->post("application_fee");
   //    $renewal_fee = $this->input->post("renewal_fee");
   //    $inspection_fee = $this->input->post("inspection_fee");
   //    $upgradation_fee = $this->input->post("upgradation_fee");
   //    $security = $this->input->post("security");
   //    $late_fee = $this->input->post("late_fee");
   //    $change_of_name = $this->input->post("change_of_name");
   //    $change_of_building = $this->input->post("change_of_building");
   //    $change_of_ownership = $this->input->post("change_of_ownership");
   //    $penalty = $this->input->post("penalty");
   //    $miscellaneous = $this->input->post("miscellaneous");
   //    $fine = $this->input->post("fine");
   //    $challan_for = $this->input->post("challan_for");
   //    $userId = $this->session->userdata('userId');

   //    $query = "SELECT count(*) as total FROM bank_challans WHERE challan_no = '" . $statn_number . "' and bank_challan_id !='" . $bank_challan_id . "'";
   //    $count = $this->db->query($query)->result()[0]->total;
   //    if ($count == 0) {

   //       $query = "UPDATE `bank_challans`
   //       SET
   //       `challan_for` = '" . $challan_for . "',
   //       `challan_no` = '" . $statn_number . "', 
   //       `challan_date` = '" . $date_of_deposit . "',  
   //       `application_processing_fee` = '" . $application_fee . "',  
   //       `renewal_fee` = '" . $renewal_fee . "',
   //       `upgradation_fee`= '" . $upgradation_fee . "',
   //       `inspection_fee` = '" . $inspection_fee . "',
   //       `fine` = '" . $fine . "',
   //       `security_fee` =  '" . $security . "', 
   //       `late_fee` = '" . $late_fee . "',
   //       `change_of_name_fee` = '" . $change_of_name . "',
   //       `change_of_ownership_fee` = '" . $change_of_ownership . "',
   //       `change_of_building_fee` = '" . $change_of_building . "', 
   //       `penalty` = '" . $penalty . "', 
   //       `miscellaneous` = '" . $miscellaneous . "',
   //       `created_by` = '" . $userId . "' 
   //      WHERE bank_challan_id ='" . $bank_challan_id . "'";
   //       if ($this->db->query($query)) {
   //          $query = "SELECT (`application_processing_fee`+`renewal_fee`+`upgradation_fee`+`inspection_fee`+`fine`+`security_fee`+`late_fee`+`renewal_and_upgradation_fee`+`change_of_name_fee`+`change_of_ownership_fee`+`change_of_building_fee`+`miscellaneous`+`penalty`) as total FROM `bank_challans` WHERE challan_no = '" . $statn_number . "'";
   //          $challan_total = $this->db->query($query)->result()[0]->total;
   //          $query = "UPDATE bank_challans SET total_deposit_fee='" . $challan_total . "' WHERE bank_challan_id ='" . $bank_challan_id . "'";
   //          $this->db->query($query);
   //          echo "success";
   //       } else {
   //          echo 'error while entering data into the database.';
   //       }
   //    } else {
   //       echo "STAN Number already used. try again with different STAN No.";
   //    }
   //    //$variables = $_POST;
   //    // foreach ($variables as $key => $value) {
   //    //    echo '\'".$' . $key . '."\', ';
   //    // }
   // }

   // public function complete_challan_entry()
   // {
   //    $school_ids = "";
   //    $schoolids = explode(',', $this->input->post('school_session_id'));
   //    foreach ($schoolids as $schoolid) {
   //       $school_ids .= $schoolid . ",";
   //    }
   //    $school_ids = trim($school_ids, ',');
   //    $schools_id = (int) $this->input->post('school_id');
   //    $query = "UPDATE school SET file_status = '2' WHERE schoolId IN(" . $school_ids . ") and schools_id = '" . $schools_id . "'";

   //    if ($this->db->query($query)) {
   //       redirect('online_cases');
   //    }
   // }


   // public function add_comment()
   // {


   //    $input['comment'] = trim($this->db->escape($this->input->post('comment')), "'");
   //    $input['session_id'] = (int) $this->input->post('session_id');
   //    $input['school_id'] = (int) $this->input->post('school_id');
   //    $input['schools_id'] = $schools_id =  (int) $this->input->post('schools_id');
   //    $input['created_by'] = $this->session->userdata('userId');
   //    if ($input['comment']) {
   //       if ($this->db->insert('comments', $input)) {
   //          //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //          redirect($_SERVER['HTTP_REFERER']);
   //       } else {
   //          //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //          redirect($_SERVER['HTTP_REFERER']);
   //       }
   //    } else {
   //       //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //       redirect($_SERVER['HTTP_REFERER']);
   //    }
   // }

   // public function delete_comment($comment_id, $schools_id)
   // {

   //    $where['comment_id'] = (int) $comment_id;
   //    $where['schools_id'] = (int) $schools_id;
   //    $where['created_by'] = $this->session->userdata('userId');
   //    $this->db->where($where);
   //    $input['deleted'] = 1;
   //    if ($this->db->update('comments', $input)) {
   //       //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //       redirect($_SERVER['HTTP_REFERER']);
   //    } else {
   //       //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //       redirect($_SERVER['HTTP_REFERER']);
   //    }
   // }
   // public function update_online_apply()
   // {

   //    $school_id = (int) $this->input->post('school_id');
   //    $schools_id = (int) $this->input->post('schools_id');
   //    $reg_type_id = (int) $this->input->post('reg_type_id');
   //    $query = "UPDATE school set reg_type_id = '" . $reg_type_id . "' WHERE schoolId = '" . $school_id . "' AND schools_id ='" . $schools_id . "' LIMIT 1";

   //    if ($this->db->query($query)) {
   //       redirect("online_cases/combine_note_sheet/" . $schools_id);
   //    } else {
   //       redirect("online_cases/combine_note_sheet/" . $schools_id);
   //    }
   // }


   // public function get_session_challan_form()
   // {



   //    $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
   //    $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
   //    $query = "SELECT  `schools`.`schoolId` AS `schools_id`
   //    , `schools`.`registrationNumber`
   //    , `schools`.`schoolName`
   //    , `schools`.`yearOfEstiblishment`
   //    , `schools`.`school_type_id`
   //    , `schools`.`level_of_school_id`
   //    , `schools`.`gender_type_id`
   //    , (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
   //    , `district`.`districtTitle` 
   //    , `tehsils`.`tehsilTitle`
   //    , (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
   //    `schools`.`address`,
   //    `schools`.`telePhoneNumber`,
   //    `schools`.`isfined`,
   //    `schools`.`file_no`,
   //    `schools`.`schoolMobileNumber`
   // 	FROM `schools` 
   //    INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
   //    INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
   //    ";
   //    $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
   //    $school = $this->db->query($query)->row();
   //    if ($school) {

   //       if ($school->registrationNumber) {
   //          $this->data['visit_type'] = 'Upgradation';
   //       } else {
   //          $this->data['visit_type'] = 'Registration';
   //       }

   //       $this->data['school'] = $school;


   //       $this->load->view('mis_dashboard/add_session_challan_form', $this->data);
   //    } else {
   //       echo "School ID not found try again with different School ID.";
   //       exit();
   //    }
   // }
   // public function get_apply_edit_form()
   // {



   //    $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
   //    $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
   //    $query = "SELECT  `schools`.`schoolId` AS `schools_id`
   //    , `schools`.`registrationNumber`
   //    , `schools`.`schoolName`
   //    , `schools`.`yearOfEstiblishment`
   //    , `schools`.`school_type_id`
   //    , `schools`.`level_of_school_id`
   //    , `schools`.`gender_type_id`
   //    , (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
   //    , `district`.`districtTitle` 
   //    , `tehsils`.`tehsilTitle`
   //    , (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
   //    `schools`.`address`,
   //    `schools`.`telePhoneNumber`,
   //    `schools`.`isfined`,
   //    `schools`.`file_no`,
   //    `schools`.`schoolMobileNumber`
   // 	FROM `schools` 
   //    INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
   //    INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
   //    ";
   //    $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
   //    $school = $this->db->query($query)->row();
   //    if ($school) {


   //       $this->data['school'] = $school;


   //       $this->load->view('mis_dashboard/get_apply_edit_form', $this->data);
   //    } else {
   //       echo "School ID not found try again with different School ID.";
   //       exit();
   //    }
   // }


   // public function sent_message()
   // {


   //    $dated = date("Y-m-d h:i:s");
   //    $insert['discription'] = $this->input->post('discription');
   //    $insert['subject'] = $this->input->post('subject');
   //    $school_id_for_message = (int) $this->input->post('school_id_for_message');
   //    $insert['created_by'] = $this->session->userdata('userId');
   //    $insert['created_date'] = $dated;
   //    //var_dump($insert);exit;

   //    $is_deficiency_message = $this->input->post('is_deficiency_message');
   //    if ($is_deficiency_message) {
   //       $school_session_id = $this->input->post('school_session_id');
   //       if ($school_session_id) {
   //          $deficiency = array();
   //          $deficiency['pending_type'] = 'Deficiency';
   //          $deficiency['pending_date'] = date("Y-m-d");
   //          $deficiency['pending_reason'] = $this->input->post('deficiency_reason');
   //          $deficiency['file_status'] = 5;
   //          $this->db->where('schoolId', $school_session_id);
   //          $this->db->update('school', $deficiency);
   //          $insert['school_session_id'] = $school_session_id;
   //       }
   //       $insert['message_type'] = 'Deficiency';
   //       $insert['message_reason'] = $this->input->post('deficiency_reason');
   //    } else {
   //       $insert['message_type'] = 'General';
   //       $insert['message_reason'] = $this->input->post('deficiency_reason');
   //    }

   //    $insert['district_id'] = 0;
   //    $insert['level_id'] = 0;
   //    $insert['like_text'] = "";

   //    $insert['select_all'] = "no";

   //    $this->db->set($insert);
   //    $this->db->insert("message_for_all");
   //    $message_id = $this->db->insert_id();
   //    if ($message_id) {
   //       $input = array();
   //       $input['school_id'] = $school_id_for_message;
   //       $input['message_id'] = $message_id;
   //       $this->db->set($input);
   //       $this->db->insert("message_school");
   //       echo 1;
   //    } else {
   //       echo 0;
   //    }
   // }

   // public function  combine_note_sheet($schools_id)
   // {
   //    $this->data['schools_id'] = $schools_id = (int) $schools_id;
   //    $this->data['school'] = $this->schooldetail($schools_id);
   //    $this->load->view('mis_dashboard/combine_note_sheet', $this->data);
   // }

   // public function  single_note_sheet($schools_id, $school_id)
   // {
   //    $this->data['schools_id'] = $schools_id = (int) $schools_id;
   //    $this->data['school_id'] = $school_id = (int) $school_id;

   //    $query = "SELECT COUNT(*) as total FROM school WHERE school.schoolId = '" . $school_id . "' and school.schools_id = '" . $schools_id . "'";
   //    $school_count = $this->db->query($query)->row()->total;

   //    if ($school_count == 0) {
   //       echo "School Case Not Matched.";
   //       exit();
   //    } else {
   //       $this->data['school'] = $this->schooldetail($schools_id);
   //       $this->load->view('mis_dashboard/single_note_sheet', $this->data);
   //    }
   // }



   // private function schooldetail($schools_id)
   // {
   //    $query = "SELECT  `schools`.`schoolId` AS `schools_id`
   // 				, `schools`.`registrationNumber`
   // 				, `schools`.`schoolName`
   // 				, `schools`.`yearOfEstiblishment`
   // 				, `schools`.`school_type_id`
   // 				, `schools`.`level_of_school_id`
   // 				, `schools`.`gender_type_id`
   // 				, (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
   // 				, `district`.`districtTitle` 
   // 				, `tehsils`.`tehsilTitle`
   // 				, (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
   // 				`schools`.`telePhoneNumber` as phone_no,
   // 				`schools`.`schoolMobileNumber` as mobile_no,
   // 				(SELECT `users`.`contactNumber` FROM users WHERE users.userId = schools.owner_id) as owner_no,
   // 				schools.address
   // 			FROM
   // 				`schools`
   // 				INNER JOIN `district` ON(`district`.`districtId` = `schools`.`district_id`)
   // 				INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
   // 			WHERE `schools`.`schoolId`='" . $schools_id . "'";
   //    return $this->db->query($query)->result()[0];
   // }


   // public function  mark_as_complete_form()
   // {
   //    $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
   //    $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
   //    $this->load->view('mis_dashboard/mark_as_complete_form', $this->data);
   // }

   // public function  change_file_status($schools_id)
   // {
   //    $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
   //    $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
   //    $file_status = (int) $this->input->post('file_status');
   //    $userId = $this->session->userdata('userId');
   //    $query = "UPDATE `school` SET file_status ='" . $file_status . "', note_sheet_completed='" . $userId . "' WHERE status=2 and schoolId= '" . $school_id . "' and schools_id = '" . $schools_id . "'";
   //    if ($this->db->query($query)) {
   //       //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //       redirect($_SERVER['HTTP_REFERER']);
   //    } else {
   //       //redirect("online_cases/combine_note_sheet/" . $schools_id);
   //       redirect($_SERVER['HTTP_REFERER']);
   //    }
   // }


}
