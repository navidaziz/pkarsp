<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Online_cases extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
   }

   public function index()
   {
      $this->data['title'] = 'Online Cases Dashboard';
      $this->data['description'] = 'Cases Dashboard';
      $this->data['view'] = 'online_cases/cases_dashboard';
      $this->load->view('layout', $this->data);
   }

   public function inspections()
   {
      $this->data['title'] = 'Inspections';
      $this->data['description'] = 'List of All Inspections';
      $this->data['view'] = 'registration_section/inspections';
      $this->load->view('layout', $this->data);
   }

   private function get_request_list($status, $file_status, $request_type = NULL, $title = NULL)
   {
      $userId = $this->session->userdata('userId');
      $query = "SELECT region_ids FROM users WHERE userId = '" . $userId . "'";
      $region_ids = $this->db->query($query)->row()->region_ids;

      $query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`reg_type`.`regTypeTitle`,
		`school`.`schoolId` as school_id,
		`district`.`districtTitle`,
      `school`.`file_status`,
      `school`.`apply_date`,
      schools.isfined,
      school.status_remark,
		(SELECT s.status
		FROM school as s WHERE 
		 s.schools_id = `schools`.`schoolId`
		AND  s.session_year_id = (`school`.`session_year_id`-1) and s.schools_id = schools.schoolId LIMIT 1) as previous_session_status,
      (SELECT COUNT(*)
		FROM school as s WHERE 
		 s.schools_id = `schools`.`schoolId`
		AND  s.status != 1 and `s`.`file_status`=5) as deficient
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`,
      `district`
		
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId` 
      AND schools.district_id = district.districtId 
      AND district.new_region IN(" . $region_ids . ") ";

      if ($status) {
         $query .= " AND `school`.`status`='" . $status . "'";
      }

      if ($file_status) {
         $query .= " AND `school`.`file_status`= '" . $file_status . "'";
      }


      if ($request_type) {
         $query .= "AND `school`.`reg_type_id`= $request_type";
      }


      if ($title) {
         $this->data['title'] = $title;
      }

      $query .= " ORDER BY `school`.`apply_date` ASC, `school`.`schools_id` ASC, `school`.`session_year_id` ASC ";


      $this->data['list_type'] = $file_status;
      $this->data['requests'] = $this->db->query($query)->result();

      $this->load->view('online_cases/requests', $this->data);
   }

   public function get_new_requests()
   {
      $this->get_request_list(2, 1, 2, 'New Renewal');
      $this->get_request_list(2, 1, 4, 'New Renewal-Upgradation');
      $this->get_request_list(2, 1, 1, 'New Registration');
      $this->get_request_list(2, 1, 3, 'Upgradation');
   }


   public function deficient_cases()
   {

      $this->get_request_list(2, 5, NULL, 'Financially Deficient Cases');
      $this->get_request_list(2, 4, NULL, 'Forwarded To Operation Wing');
      $this->get_request_list(2, 10, NULL, 'Issue Pending');
      $this->get_request_list(2, 3, NULL, 'Pending Due To Previous');
   }


   public function new_inspection_requests()
   {
      $this->get_request_list(4, NULL, 'New Inspection');
   }
   public function awating_inspection_requests()
   {
      $this->get_request_list(5, NULL, 'Inspection Inprogress');
   }
   public function notesheet()
   {
      $this->get_request_list(2, 2, 'Renewal Note Sheet');
      $this->get_request_list(2, 1, 'Registration Note Sheet');
   }
   public function completed_requests()
   {
      //$this->get_request_list(1, NULL, 'Completed Requests');
   }
   public function inspection_requests()
   {
      $query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`school`.`schoolId` as school_id,
		`reg_type`.`regTypeTitle`
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`reg_type_id`=6";
      $this->data['completed_requests'] = $this->db->query($query)->result();

      $this->load->view('registration_section/inspection_requests', $this->data);
   }

   public function get_request_detail()
   {

      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $this->data['session_id'] = $session_id = (int) $this->input->post('session_id');

      $query = "SELECT `school`.*,
		`reg_type`.`regTypeTitle`,
		`school_type`.`typeTitle`,
		`levelofinstitute`.`levelofInstituteTitle`,
		`session_year`.`sessionYearTitle`
	  FROM
		`reg_type`
		INNER JOIN `school`
		  ON (
			`reg_type`.`regTypeId` = `school`.`reg_type_id`
		  )
		INNER JOIN `school_type`
		  ON (
			`school_type`.`typeId` = `school`.`school_type_id`
		  )
		INNER JOIN `levelofinstitute`
		  ON (
			`levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
		  )
		INNER JOIN `session_year`
		  ON (
			`session_year`.`sessionYearId` = `school`.`session_year_id`
		  )
		  WHERE  `school`.`schoolId` = '" . $school_id . "'
		  AND `school`.`session_year_id` = '" . $session_id . "'";
      $session_request_detail = $this->db->query($query)->result()[0];
      $this->data['schools_id'] = $session_request_detail->schools_id;
      $this->data['school'] = $this->school_detail($session_request_detail->schools_id);
      $this->data['session_request_detail'] = $session_request_detail;

      // $query = "SELECT MAX(tuitionFee) as max_tution_fee 
      //  FROM `fee` WHERE school_id= '" . $school_id . "'";
      // $this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace(
      // 	'/[^0-9.]/',
      // 	'',
      // 	$this->db->query($query)->result()[0]->max_tution_fee
      // );
      // $query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee 
      // FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
      // $this->data['fee_sturucture'] = $this->db->query($query)->result()[0];



      $query = "SELECT * FROM `bank_challans` 
		          WHERE school_id = '" . $session_request_detail->schoolId . "'
				  AND session_id ='" . $session_id . "'
				  AND verified ='1' ";
      $this->data['bank_challans'] = $this->db->query($query)->result();

      $query = "SELECT `schoolStaffName`as `name`, MIN(DATE(`schoolStaffAppointmentDate`)) as appoinment_date 
		FROM `school_staff` WHERE school_id= '" . $school_id . "'";
      $this->data['first_appointment_staff'] = $this->db->query($query)->result()[0];




      $this->load->view('online_cases/request_detail', $this->data);
   }
   private function school_detail($schools_id)
   {
      $query = "SELECT
		            `schools`.`schoolId` as schools_id,
					`schools`.`schoolName`,
					`schools`.`registrationNumber`,
					`schools`.`yearOfEstiblishment`,
					`tehsils`.`tehsilTitle`,
					`district`.`division`,
					`schools`.`telePhoneNumber`,
					`schools`.`schoolMobileNumber`,
					`schools`.`principal_email`,
					`levelofinstitute`.`levelofInstituteTitle`,
					`genderofschool`.`genderOfSchoolTitle`,
					`users`.`userTitle`,
					`users`.`userEmail`,
					`users`.`cnic`,
					`users`.`contactNumber`,
					`schools`.`mediumOfInstruction`,
					`schools`.`biseRegister`,
					`schools`.`biseregistrationNumber`,
					`schools`.`primaryRegDate`,
					`schools`.`highRegDate`,
					`schools`.`interRegDate`,
					`schools`.`biseAffiliated`,
					`schools`.`bise_verified`,
					`schools`.`level_of_school_id`,
					`school_type`.`typeTitle`,
					`bise`.`biseName`,
					`district`.`districtTitle`,
					`uc`.`ucTitle`,
					`schools`.`primary_level`,
					`schools`.`middle_level`,
					`schools`.`high_level`,
					`schools`.`h_sec_college_level`
					FROM
					`district`
					INNER JOIN `schools`
						ON (
						`district`.`districtId` = `schools`.`district_id`
						)
					INNER JOIN `tehsils`
						ON (
						`tehsils`.`tehsilId` = `schools`.`tehsil_id`
						)
					INNER JOIN `levelofinstitute`
						ON (
						`levelofinstitute`.`levelofInstituteId` = `schools`.`level_of_school_id`
						)
					INNER JOIN `genderofschool`
						ON (
						`genderofschool`.`genderOfSchoolId` = `schools`.`gender_type_id`
						)
					LEFT JOIN `school_type`
						ON (
						`schools`.`school_type_id` = `school_type`.`typeId`
						)
					INNER JOIN `users`
						ON (
						`users`.`userId` = `schools`.`owner_id`
						)
					LEFT JOIN `bise`
						ON (
						`schools`.`bise_id` = `bise`.`biseId`
						)
					LEFT JOIN `uc`
						ON (
						`uc`.`ucId` = `schools`.`uc_id`
						)	
					WHERE schools.schoolId = '" . $schools_id . "'
							";

      return $this->db->query($query)->result()[0];
   }

   public function school_session_list()
   {



      $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
      $query = "SELECT  `schools`.`schoolId` AS `schools_id`
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
      `schools`.`telePhoneNumber`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`schoolMobileNumber`
   	FROM `schools` 
      INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
      INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
      ";
      $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
      $school = $this->db->query($query)->row();
      if ($school) {

         if ($school->registrationNumber) {
            $this->data['visit_type'] = 'Upgradation';
         } else {
            $this->data['visit_type'] = 'Registration';
         }

         $this->data['school'] = $school;


         $this->load->view('online_cases/add_bank_challan', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
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
         `created_by`,
         `verified_by`,
         `verified`
         ) 
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
         '" . $userId . "',
         '" . $userId . "',
         '1'
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
         echo "<div class='alert alert-danger'>";
         $query = "SELECT * FROM bank_challans WHERE challan_no = '" . $statn_number . "'";
         $stan_detail = $this->db->query($query)->row();
         if ($stan_detail->old_challan_id) {
            echo "<strong style='color:red'>
              STAN Number already used in Old Challan Data. Try again with different STAN No.</strong><br />";
            // var_dump($stan_detail);
            $query = "SELECT * FROM `old_challans` WHERE stan_no='" . $statn_number . "'";
            $old_challans = $this->db->query($query)->result();
            foreach ($old_challans as $old_challan_detail) {
               echo "STAN: <strong>" . $old_challan_detail->stan_no . "</strong> - Date: <strong>" . $old_challan_detail->date . "</strong> - Challan For: <strong>" . $challan->remarks . "</strong> -  School ID: <strong>" . $old_challan_detail->school_id . "</strong> - School Name: <strong>" . $old_challan_detail->school_name . "</strong> - Session: <strong>" . $old_challan_detail->session . "</strong> - Excel S.No: <strong>" . $old_challan_detail->excel_s_no . "</strong>";
               echo "<br />";
            }
         } else {
            echo "<strong style='color:red'>STAN Number already used. try again with different STAN No.</strong><br />";
            $query = "SELECT bank_challans.challan_no, bank_challans.challan_date, 
                   bank_challans.challan_for,
                   schools.schoolId, schools.schoolName, session_year.sessionYearTitle
                            FROM `bank_challans`
                            INNER JOIN schools ON(schools.schoolId = bank_challans.schools_id)
                            INNER JOIN school ON(school.schoolId = bank_challans.school_id)
                            INNER JOIN session_year ON(session_year.sessionYearId=school.session_year_id)
                            WHERE bank_challans.challan_no = '" . $statn_number . "'";
            $challans = $this->db->query($query)->result();
            foreach ($challans as $challan) {
               echo "STAN: <strong>" . $challan->challan_no . "</strong> - Date: <strong>" . $challan->challan_date . "</strong> - Challan For: <strong>" . $challan->challan_for . "</strong> -  School ID: <strong>" . $challan->schoolId . "</strong> - 
                        School Name: <strong>" . $challan->schoolName . "</strong> - Session: <strong>" . $challan->sessionYearTitle . "</strong> ";
               echo "<br />";
            }
         }
         echo "</div>";
         //echo "STAN Number already used. try again with different STAN No.";
      }
   }

   public function edit_bank_challan()
   {
      $this->data['bank_challan_id'] = $this->input->post('bank_challan_id');
      $this->load->view('online_cases/edit_bank_challan', $this->data);
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

   public function complete_challan_entry()
   {
      $school_ids = "";
      $schoolids = explode(',', $this->input->post('school_session_id'));
      foreach ($schoolids as $schoolid) {
         $school_ids .= $schoolid . ",";
      }
      $school_ids = trim($school_ids, ',');
      $schools_id = (int) $this->input->post('school_id');
      $query = "UPDATE school SET file_status = '2' WHERE schoolId IN(" . $school_ids . ") and schools_id = '" . $schools_id . "'";

      if ($this->db->query($query)) {
         redirect('online_cases');
      }
   }


   public function add_comment()
   {


      $input['comment'] = trim($this->db->escape($this->input->post('comment')), "'");
      $input['session_id'] = (int) $this->input->post('session_id');
      $input['school_id'] = (int) $this->input->post('school_id');
      $input['schools_id'] = $schools_id =  (int) $this->input->post('schools_id');
      $input['created_by'] = $this->session->userdata('userId');
      if ($input['comment']) {
         if ($this->db->insert('comments', $input)) {
            //redirect("online_cases/combine_note_sheet/" . $schools_id);
            redirect($_SERVER['HTTP_REFERER']);
         } else {
            //redirect("online_cases/combine_note_sheet/" . $schools_id);
            redirect($_SERVER['HTTP_REFERER']);
         }
      } else {
         //redirect("online_cases/combine_note_sheet/" . $schools_id);
         redirect($_SERVER['HTTP_REFERER']);
      }
   }

   public function delete_comment($comment_id, $schools_id)
   {

      $where['comment_id'] = (int) $comment_id;
      $where['schools_id'] = (int) $schools_id;
      $where['created_by'] = $this->session->userdata('userId');
      $this->db->where($where);
      $input['deleted'] = 1;
      if ($this->db->update('comments', $input)) {
         //redirect("online_cases/combine_note_sheet/" . $schools_id);
         redirect($_SERVER['HTTP_REFERER']);
      } else {
         //redirect("online_cases/combine_note_sheet/" . $schools_id);
         redirect($_SERVER['HTTP_REFERER']);
      }
   }
   public function update_online_apply()
   {

      $school_id = (int) $this->input->post('school_id');
      $schools_id = (int) $this->input->post('schools_id');
      $reg_type_id = (int) $this->input->post('reg_type_id');
      $query = "UPDATE school set reg_type_id = '" . $reg_type_id . "' WHERE schoolId = '" . $school_id . "' AND schools_id ='" . $schools_id . "' LIMIT 1";

      if ($this->db->query($query)) {
         redirect("online_cases/combine_note_sheet/" . $schools_id);
      } else {
         redirect("online_cases/combine_note_sheet/" . $schools_id);
      }
   }


   public function get_session_challan_form()
   {



      $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $query = "SELECT  `schools`.`schoolId` AS `schools_id`
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
      `schools`.`telePhoneNumber`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`schoolMobileNumber`
   	FROM `schools` 
      INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
      INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
      ";
      $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
      $school = $this->db->query($query)->row();
      if ($school) {

         if ($school->registrationNumber) {
            $this->data['visit_type'] = 'Upgradation';
         } else {
            $this->data['visit_type'] = 'Registration';
         }

         $this->data['school'] = $school;


         $this->load->view('online_cases/add_session_challan_form', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }
   public function get_apply_edit_form()
   {



      $this->data['schoolid'] = $schoolid = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $query = "SELECT  `schools`.`schoolId` AS `schools_id`
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
      `schools`.`telePhoneNumber`,
      `schools`.`isfined`,
      `schools`.`file_no`,
      `schools`.`schoolMobileNumber`
   	FROM `schools` 
      INNER JOIN `district` ON (`schools`.`district_id` = `district`.`districtId`) 
      INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
      ";
      $query .= " WHERE `schools`.`schoolId` = " . $schoolid . " ";
      $school = $this->db->query($query)->row();
      if ($school) {


         $this->data['school'] = $school;


         $this->load->view('online_cases/get_apply_edit_form', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }


   public function sent_message()
   {


      $dated = date("Y-m-d h:i:s");
      $insert['discription'] = $this->input->post('discription');
      $insert['subject'] = $this->input->post('subject');
      $school_id_for_message = (int) $this->input->post('school_id_for_message');
      $insert['created_by'] = $this->session->userdata('userId');
      $insert['created_date'] = $dated;
      //var_dump($insert);exit;

      $is_deficiency_message = $this->input->post('is_deficiency_message');
      if ($is_deficiency_message) {
         $school_session_id = $this->input->post('school_session_id');
         if ($school_session_id) {
            $deficiency = array();
            $deficiency['pending_type'] = 'Deficiency';
            $deficiency['pending_date'] = date("Y-m-d");
            $deficiency['pending_reason'] = $this->input->post('deficiency_reason');
            $deficiency['file_status'] = 5;
            $this->db->where('schoolId', $school_session_id);
            $this->db->update('school', $deficiency);
            $insert['school_session_id'] = $school_session_id;
         }
         $insert['message_type'] = 'Deficiency';
         $insert['message_reason'] = $this->input->post('deficiency_reason');
      } else {
         $insert['message_type'] = 'General';
         $insert['message_reason'] = $this->input->post('deficiency_reason');
      }

      $insert['district_id'] = 0;
      $insert['level_id'] = 0;
      $insert['like_text'] = "";

      $insert['select_all'] = "no";

      $this->db->set($insert);
      $this->db->insert("message_for_all");
      $message_id = $this->db->insert_id();
      if ($message_id) {
         $input = array();
         $input['school_id'] = $school_id_for_message;
         $input['message_id'] = $message_id;
         $this->db->set($input);
         $this->db->insert("message_school");
         echo 1;
      } else {
         echo 0;
      }
   }

   public function  combine_note_sheet($schools_id)
   {
      $this->data['schools_id'] = $schools_id = (int) $schools_id;
      $this->data['school'] = $this->schooldetail($schools_id);
      $this->load->view('online_cases/combine_note_sheet', $this->data);
   }

   public function  single_note_sheet($schools_id, $school_id)
   {
      $this->data['schools_id'] = $schools_id = (int) $schools_id;
      $this->data['school_id'] = $school_id = (int) $school_id;

      $query = "SELECT COUNT(*) as total FROM school WHERE school.schoolId = '" . $school_id . "' and school.schools_id = '" . $schools_id . "'";
      $school_count = $this->db->query($query)->row()->total;

      if ($school_count == 0) {
         echo "School Case Not Matched.";
         exit();
      } else {
         $this->data['school'] = $this->schooldetail($schools_id);
         $this->load->view('online_cases/single_note_sheet', $this->data);
      }
   }



   private function schooldetail($schools_id)
   {
      $query = "SELECT  `schools`.`schoolId` AS `schools_id`
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
					`schools`.`telePhoneNumber` as phone_no,
					`schools`.`schoolMobileNumber` as mobile_no,
					(SELECT `users`.`contactNumber` FROM users WHERE users.userId = schools.owner_id) as owner_no,
					schools.address
				FROM
					`schools`
					INNER JOIN `district` ON(`district`.`districtId` = `schools`.`district_id`)
					INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`)
				WHERE `schools`.`schoolId`='" . $schools_id . "'";
      return $this->db->query($query)->result()[0];
   }


   public function  mark_as_complete_form()
   {
      $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $this->load->view('online_cases/mark_as_complete_form', $this->data);
   }

   public function  change_file_status($schools_id)
   {
      $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $status_remark = $this->db->escape($this->input->post('status_remark'));
      $file_status = (int) $this->input->post('file_status');
      $completed_date = date("Y-m-d H:i:s");
      $userId = $this->session->userdata('userId');
      $query = "UPDATE `school` SET file_status ='" . $file_status . "', 
      `note_sheet_completed_date` = '" . $completed_date . "',
              note_sheet_completed='" . $userId . "' ,
              `status_remark`=" . $status_remark . "
              WHERE status=2 and schoolId= '" . $school_id . "' 
              and schools_id = '" . $schools_id . "'";
      if ($this->db->query($query)) {
         //redirect("online_cases/combine_note_sheet/" . $schools_id);
         redirect($_SERVER['HTTP_REFERER']);
      } else {
         //redirect("online_cases/combine_note_sheet/" . $schools_id);
         redirect($_SERVER['HTTP_REFERER']);
      }
   }

   public function school_summary()
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


         $this->load->view('online_cases/school_detail', $this->data);
      } else {
         echo "School ID not found try again with different School ID.";
         exit();
      }
   }

   public function  change_session_status()
   {
      $this->data['schools_id'] = $schools_id = (int) $this->input->post('schools_id');
      $this->data['school_id'] = $school_id = (int) $this->input->post('school_id');
      $this->load->view('online_cases/change_session_status', $this->data);
   }
}
