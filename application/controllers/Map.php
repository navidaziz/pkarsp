<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Admin_Controller
// MY_Controller
class Map extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('user_m');
		// $this->output->enable_profiler(TRUE);
	}
	public function index()
	{
		$query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
      `schools`.`biseregistrationNumber`,
	  `schools`.`longitude` as `long`,
	  `schools`.`late` as `late`,

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
      school.visit,
      school.recommended,
      `school`.`level_of_school_id`,
      `schools`.`yearOfEstiblishment`,
      (SELECT `tehsils`.`tehsilTitle` FROM `tehsils` WHERE `tehsils`.`tehsilId` = schools.tehsil_id) as tehsil,
      schools.address,
      (SELECT `levelofinstitute`.`levelofInstituteTitle` FROM `levelofinstitute`  WHERE `levelofinstitute`.`levelofInstituteId`= school.level_of_school_id) as level,
		
      schools.telePhoneNumber,
schools.schoolMobileNumber,
school.principal_contact_no,
(SELECT `users`.`contactNumber` FROM users WHERE `users`.`userId`=schools.owner_id) as owner_contact_no,
      
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
	  AND schools.district_id IN (13)
	   AND `school`.`status`='2'
	   AND school.file_status=1
	   AND `school`.`reg_type_id` IN (1,4)
	    ORDER BY `school`.`apply_date` ASC, `school`.`schools_id` ASC, `school`.`session_year_id` ASC LIMIT 30";

		$this->data['schools'] = $this->db->query($query)->result();
		//var_dump($this->data['schools']);
		$this->load->view('map/index', $this->data);
	}
}
