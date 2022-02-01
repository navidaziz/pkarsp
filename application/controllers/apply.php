<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apply extends MY_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model("school_m");
	}

	public function index()
	{
		echo "We are working on it";
	}

	public function registration($session_id)
	{
		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, level_of_school_id, gender_type_id, school_type_id,owner_id, reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school = $this->db->query($query)->result()[0];
		$this->data['school_id'] = $school_id = $school->schoolId;

		$query = "SELECT COUNT(*) AS total FROM school WHERE schools_id = '" . $school_id . "' AND session_year_id='" . $session_id . "'";

		if ($this->db->query($query)->result()[0]->total == 0) {
			$school_session = array(
				'reg_type_id' => 1,
				'schools_id' => $school_id,
				'session_year_id' => $session_id,
				'level_of_school_id' => $school->level_of_school_id,
				'gender_type_id' => $school->gender_type_id,
				'school_type_id' => $school->school_type_id,
				'updatedDate' => 123456,
				'school_will_be_update_by_school_user' => 1,
				'updatedBy' => $this->session->userdata('userId')
			);
			$this->db->insert('school', $school_session);
			$school_new_session_id = $this->db->insert_id();

			$this->db->insert('forms_process', array(
				'user_id' => $school->owner_id,
				'reg_type_id' => $school->reg_type_id,
				'form_a_status' => 1,
				'school_id' => $school_new_session_id
			));

			redirect("form/section_b/$session_id");
		} else {
			redirect("form/section_b/$session_id");
		}
	}
	public function renewal($session_id, $session_school_id = NULL)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, level_of_school_id, gender_type_id, school_type_id,owner_id, reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->result()[0];
		$schools_id = $school_detail->schoolId;

		$query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' 
		 AND status=1 ORDER BY `session_year_id` DESC";
		$last_session_detail = $this->db->query($query)->result()[0];
		$school_id = $last_session_detail->schoolId;

		if (is_null($school_id)) {
			//insert new session...
			$new_session['schools_id'] = $schools_id;
			$new_session['reg_type_id'] = 2;
			$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
			$new_session['school_type_id'] = $last_session_detail->school_type_id;
			$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
			$new_session['session_year_id'] = $session_id;
			date_default_timezone_set("Asia/Karachi");
			$dated = date("d-m-Y h:i:sa");
			$new_session['created_date'] = $dated;
			$this->db->insert('school', $new_session);


			$school_inserted_id = $this->db->insert_id();
			$this->db->insert('forms_process', array(
				'user_id' => $userId,
				'reg_type_id' => 2,
				'form_a_status' => 1,
				'school_id' => $school_inserted_id
			));

			$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));
		} else {
			$school_inserted_id = $session_school_id;
		}

		$this->db->trans_begin();
		$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();

		if (!empty($physical_facilities)) {
			$physical_facilities = $physical_facilities;
			$physical_facilities_array = array(
				'building_id' => $physical_facilities->building_id,
				'numberOfClassRoom' => $physical_facilities->numberOfClassRoom,
				'numberOfOtherRoom' => $physical_facilities->numberOfOtherRoom,
				'totalArea' => $physical_facilities->totalArea,
				'coveredArea' => $physical_facilities->coveredArea,
				'numberOfComputer' => $physical_facilities->numberOfComputer,
				'numberOfLatrines' => $physical_facilities->numberOfLatrines,
				'school_id' => $school_inserted_id
			);
			$this->db->insert('physical_facilities', $physical_facilities_array);
		}


		// get and insert as a batch insertion
		$school_physical_facilities_physical = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$school_physical_facilities_physical_array = array();
		foreach ($school_physical_facilities_physical as $spfp) {
			array_push(
				$school_physical_facilities_physical_array,
				array(
					'school_id' => $school_inserted_id,
					'pf_physical_id' => $spfp->pf_physical_id
				)
			);
		}
		if (!empty($school_physical_facilities_physical_array)) {
			$this->db->insert_batch('physical_facilities_physical', $school_physical_facilities_physical_array);
		}



		// get "physical_facilities_academic" table data and insert as batch
		$school_physical_facilities_academic = $this->school_m->physical_facilities_academic_by_school_id($school_id);
		$school_physical_facilities_academic_array = array();
		foreach ($school_physical_facilities_academic as $spfa) {
			array_push(
				$school_physical_facilities_academic_array,
				array(
					'school_id' => $school_inserted_id,
					'academic_id' => $spfa->academic_id
				)
			);
		}
		if (!empty($school_physical_facilities_academic_array)) {
			$this->db->insert_batch('physical_facilities_academic', $school_physical_facilities_academic_array);
		}

		//  get "physical_facilities_co_curricular" and insert wiht school_id
		$physical_facilities_co_curricular = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$physical_facilities_co_curricular_array = array();
		foreach ($physical_facilities_co_curricular as $pfcc) {
			array_push(
				$physical_facilities_co_curricular_array,
				array(
					'school_id' => $school_inserted_id,
					'co_curricular_id' => $pfcc->co_curricular_id
				)
			);
		}
		if (!empty($physical_facilities_co_curricular_array)) {
			$this->db->insert_batch('physical_facilities_co_curricular', $physical_facilities_co_curricular_array);
		}

		//  get "school_physical_facilities_other" and insert wiht school_id
		$physical_facilities_others =  $this->school_m->physical_facilities_other_by_school_id($school_id);
		$physical_facilities_others_array = array();
		foreach ($physical_facilities_others as $pfo) {
			array_push(
				$physical_facilities_others_array,
				array(
					'school_id' => $school_inserted_id,
					'other_id' => $pfo->other_id
				)
			);
		}
		if (!empty($physical_facilities_others_array)) {
			$this->db->insert_batch('physical_facilities_others', $physical_facilities_others_array);
		}

		//  get "school_physical_facilities_other"  and insert wiht school_id
		$school_library = $this->school_m->get_library_books_by_school_id($school_id);
		$school_library_array = array();
		foreach ($school_library as $sl) {
			array_push(
				$school_library_array,
				array(
					'school_id' => $school_inserted_id,
					'book_type_id' => $sl->book_type_id,
					'numberOfBooks' => $sl->numberOfBooks
				)
			);
		}
		if (!empty($school_library_array)) {
			$this->db->insert_batch('school_library', $school_library_array);
		}

		$school_staff = $this->school_m->staff_by_school_id($school_id);
		$school_staff_array = array();
		foreach ($school_staff as $ss) {
			array_push(
				$school_staff_array,
				array(
					'school_id' => $school_inserted_id,
					'schoolStaffName' => $ss->schoolStaffName,
					'schoolStaffFatherOrHusband' => $ss->schoolStaffFatherOrHusband,
					'schoolStaffCnic' => $ss->schoolStaffCnic,
					'schoolStaffQaulificationProfessional' => $ss->schoolStaffQaulificationProfessional,
					'schoolStaffQaulificationAcademic' => $ss->schoolStaffQaulificationAcademic,
					'schoolStaffAppointmentDate' => $ss->schoolStaffAppointmentDate,
					'schoolStaffDesignition' => $ss->schoolStaffDesignition,
					'schoolStaffNetPay' => $ss->schoolStaffNetPay,
					'schoolStaffAnnualIncreament' => $ss->schoolStaffAnnualIncreament,
					'schoolStaffType' => $ss->schoolStaffType,
					'schoolStaffGender' => $ss->schoolStaffGender,
					'TeacherTraining' => $ss->TeacherTraining,
					'TeacherExperience' => $ss->TeacherExperience
				)

			);
		}

		if (!empty($school_staff_array)) {
			$this->db->insert_batch('school_staff', $school_staff_array);
		}



		//get "fee"  and insert wiht school_id
		// $school_fee = $this->school_m->fee_by_school_id($school_id);
		// $school_fee_array = array();
		// foreach ($school_fee as $sf) {
		// 	array_push(
		// 		$school_fee_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'class_id' => $sf->class_id,
		// 			'addmissionFee' => $sf->addmissionFee,
		// 			'tuitionFee' => $sf->tuitionFee,
		// 			'otherFund' => $sf->otherFund,
		// 			'securityFund' => $sf->securityFund
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_array)) {
		// 	$this->db->insert_batch('fee', $school_fee_array);
		// }
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_d_status' => 1));

		//  get "fee_mentioned_in_form_or_prospectus"  and insert wiht school_id
		$school_fee_mentioned_in_form = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		if (!empty($school_fee_mentioned_in_form)) {
			$this->db->insert(
				'fee_mentioned_in_form_or_prospectus',
				array(
					'school_id' => $school_inserted_id,
					'feeMentionedInForm' => $school_fee_mentioned_in_form->feeMentionedInForm
				)
			);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_e_status' => 1));



		//  get "security_measures"  and insert wiht school_id
		$school_security_measures = $this->school_m->security_measures_by_school_id($school_id);
		if (!empty($school_security_measures)) {
			$school_security_measures_array = array(
				'school_id' => $school_inserted_id,
				'securityStatus' => $school_security_measures->securityStatus,
				'securityProvided' => $school_security_measures->securityProvided,
				'securityPersonnel' => $school_security_measures->securityPersonnel,
				'security_personnel_status_id' => $school_security_measures->security_personnel_status_id,
				'security_according_to_police_dept' => $school_security_measures->security_according_to_police_dept,
				'cameraInstallation' => $school_security_measures->cameraInstallation,
				'camraNumber' => $school_security_measures->camraNumber,
				'dvrMaintained' => $school_security_measures->dvrMaintained,
				'cameraOnline' => $school_security_measures->cameraOnline,
				'exitDoorsNumber' => $school_security_measures->exitDoorsNumber,
				'emergencyDoorsNumber' => $school_security_measures->emergencyDoorsNumber,
				'boundryWallHeight' => $school_security_measures->boundryWallHeight,
				'wiresProvided' => $school_security_measures->wiresProvided,
				'watchTower' => $school_security_measures->watchTower,
				'licensedWeapon' => $school_security_measures->licensedWeapon,
				'licenseNumber' => $school_security_measures->licenseNumber,
				'ammunitionStatus' => $school_security_measures->ammunitionStatus,
				'metalDetector' => $school_security_measures->metalDetector,
				'walkThroughGate' => $school_security_measures->walkThroughGate,
				'gateBarrier' => $school_security_measures->gateBarrier,
				'license_issued_by_id' => $school_security_measures->license_issued_by_id
			);
			$this->db->insert('security_measures', $school_security_measures_array);
			$this->db->insert_id();
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_f_status' => 1));


		//  get "security_measures"  and insert wiht school_id
		$school_hazards_with_associated_risks = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		if (!empty($school_hazards_with_associated_risks)) {
			$school_hazards_with_associated_risks_array = array(
				'school_id' => $school_inserted_id,
				'exposedToFlood' => $school_hazards_with_associated_risks->exposedToFlood,
				'drowning' => $school_hazards_with_associated_risks->drowning,
				'buildingCondition' => $school_hazards_with_associated_risks->buildingCondition,
				'accessRoute' => $school_hazards_with_associated_risks->accessRoute,
				'adjacentBuilding' => $school_hazards_with_associated_risks->adjacentBuilding,
				'safeAssemblyPointsAvailable' => $school_hazards_with_associated_risks->safeAssemblyPointsAvailable,
				'disasterTraining' => $school_hazards_with_associated_risks->disasterTraining,
				'schoolImprovementPlan' => $school_hazards_with_associated_risks->schoolImprovementPlan,
				'schoolDisasterManagementPlan' => $school_hazards_with_associated_risks->schoolDisasterManagementPlan,
				'electrification_condition_id' => $school_hazards_with_associated_risks->electrification_condition_id,
				'ventilationSystemAvailable' => $school_hazards_with_associated_risks->ventilationSystemAvailable,
				'chemicalsSchoolLaboratory' => $school_hazards_with_associated_risks->chemicalsSchoolLaboratory,
				'chemicalsSchoolSurrounding' => $school_hazards_with_associated_risks->chemicalsSchoolSurrounding,
				'roadAccident' => $school_hazards_with_associated_risks->roadAccident,
				'safeDrinkingWaterAvailable' => $school_hazards_with_associated_risks->safeDrinkingWaterAvailable,
				'sanitationFacilities' => $school_hazards_with_associated_risks->sanitationFacilities,
				'building_structure_id' => $school_hazards_with_associated_risks->building_structure_id,
				'school_surrounded_by_id' => $school_hazards_with_associated_risks->school_surrounded_by_id
			);
			$this->db->insert('hazards_with_associated_risks', $school_hazards_with_associated_risks_array);
			$this->db->insert_id();
		}
		//  get "hazards_with_associated_risks_unsafe_list"  and insert wiht school_id
		$hazards_with_associated_risks_unsafe_list = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);
		$hazards_with_associated_risks_unsafe_list_array = array();
		foreach ($hazards_with_associated_risks_unsafe_list as $hwaru) {
			array_push(
				$hazards_with_associated_risks_unsafe_list_array,
				array(
					'school_id' => $school_inserted_id,
					'unsafe_list_id' => $hwaru->unsafe_list_id
				)
			);
		}
		if (!empty($hazards_with_associated_risks_unsafe_list_array)) {
			$this->db->insert_batch('hazards_with_associated_risks_unsafe_list', $hazards_with_associated_risks_unsafe_list_array);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_g_status' => 1));

		//  get "school_fee_concession"  and insert wiht school_id
		// $school_fee_concession = $this->school_m->fee_concession_by_school_id($school_id);
		// $school_fee_concession_array = array();
		// foreach ($school_fee_concession as $sfc) {
		// 	array_push(
		// 		$school_fee_concession_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'concession_id' => $sfc->concession_id,
		// 			'percentage' => $sfc->percentage,
		// 			'numberOfStudent' => $sfc->numberOfStudent
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_concession_array)) {
		// 	$this->db->insert_batch('fee_concession', $school_fee_concession_array);
		// }
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("form/section_b/$session_id");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 2,
				'updatedDate' => date('Y-m-d H:i:s', time()),
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$session_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$session_id");
			}
		}
	}

	public function renewal_upgradation($session_id)
	{

		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, level_of_school_id, gender_type_id, school_type_id,owner_id, reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->result()[0];
		$schools_id = $school_detail->schoolId;

		$query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' AND status=1 ORDER BY `session_year_id` DESC";
		$last_session_detail = $this->db->query($query)->result()[0];

		//insert new session...
		$new_session['schools_id'] = $schools_id;
		$new_session['reg_type_id'] = 4;
		$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
		$new_session['school_type_id'] = $last_session_detail->school_type_id;
		$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
		$new_session['session_year_id'] = $session_id;
		date_default_timezone_set("Asia/Karachi");
		$dated = date("d-m-Y h:i:sa");
		$new_session['created_date'] = $dated;
		$this->db->insert('school', $new_session);


		$school_inserted_id = $this->db->insert_id();
		$school_id = $last_session_detail->schoolId;


		$this->db->insert('forms_process', array(
			'user_id' => $userId,
			'reg_type_id' => 4,
			'form_a_status' => 1,
			'school_id' => $school_inserted_id
		));

		$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));


		$this->db->trans_begin();
		$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();

		if (!empty($physical_facilities)) {
			$physical_facilities = $physical_facilities;
			$physical_facilities_array = array(
				'building_id' => $physical_facilities->building_id,
				'numberOfClassRoom' => $physical_facilities->numberOfClassRoom,
				'numberOfOtherRoom' => $physical_facilities->numberOfOtherRoom,
				'totalArea' => $physical_facilities->totalArea,
				'coveredArea' => $physical_facilities->coveredArea,
				'numberOfComputer' => $physical_facilities->numberOfComputer,
				'numberOfLatrines' => $physical_facilities->numberOfLatrines,
				'school_id' => $school_inserted_id
			);
			$this->db->insert('physical_facilities', $physical_facilities_array);
		}


		// get and insert as a batch insertion
		$school_physical_facilities_physical = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$school_physical_facilities_physical_array = array();
		foreach ($school_physical_facilities_physical as $spfp) {
			array_push(
				$school_physical_facilities_physical_array,
				array(
					'school_id' => $school_inserted_id,
					'pf_physical_id' => $spfp->pf_physical_id
				)
			);
		}
		if (!empty($school_physical_facilities_physical_array)) {
			$this->db->insert_batch('physical_facilities_physical', $school_physical_facilities_physical_array);
		}



		// get "physical_facilities_academic" table data and insert as batch
		$school_physical_facilities_academic = $this->school_m->physical_facilities_academic_by_school_id($school_id);
		$school_physical_facilities_academic_array = array();
		foreach ($school_physical_facilities_academic as $spfa) {
			array_push(
				$school_physical_facilities_academic_array,
				array(
					'school_id' => $school_inserted_id,
					'academic_id' => $spfa->academic_id
				)
			);
		}
		if (!empty($school_physical_facilities_academic_array)) {
			$this->db->insert_batch('physical_facilities_academic', $school_physical_facilities_academic_array);
		}

		//  get "physical_facilities_co_curricular" and insert wiht school_id
		$physical_facilities_co_curricular = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$physical_facilities_co_curricular_array = array();
		foreach ($physical_facilities_co_curricular as $pfcc) {
			array_push(
				$physical_facilities_co_curricular_array,
				array(
					'school_id' => $school_inserted_id,
					'co_curricular_id' => $pfcc->co_curricular_id
				)
			);
		}
		if (!empty($physical_facilities_co_curricular_array)) {
			$this->db->insert_batch('physical_facilities_co_curricular', $physical_facilities_co_curricular_array);
		}

		//  get "school_physical_facilities_other" and insert wiht school_id
		$physical_facilities_others =  $this->school_m->physical_facilities_other_by_school_id($school_id);
		$physical_facilities_others_array = array();
		foreach ($physical_facilities_others as $pfo) {
			array_push(
				$physical_facilities_others_array,
				array(
					'school_id' => $school_inserted_id,
					'other_id' => $pfo->other_id
				)
			);
		}
		if (!empty($physical_facilities_others_array)) {
			$this->db->insert_batch('physical_facilities_others', $physical_facilities_others_array);
		}

		//  get "school_physical_facilities_other"  and insert wiht school_id
		$school_library = $this->school_m->get_library_books_by_school_id($school_id);
		$school_library_array = array();
		foreach ($school_library as $sl) {
			array_push(
				$school_library_array,
				array(
					'school_id' => $school_inserted_id,
					'book_type_id' => $sl->book_type_id,
					'numberOfBooks' => $sl->numberOfBooks
				)
			);
		}
		if (!empty($school_library_array)) {
			$this->db->insert_batch('school_library', $school_library_array);
		}

		$school_staff = $this->school_m->staff_by_school_id($school_id);
		$school_staff_array = array();
		foreach ($school_staff as $ss) {
			array_push(
				$school_staff_array,
				array(
					'school_id' => $school_inserted_id,
					'schoolStaffName' => $ss->schoolStaffName,
					'schoolStaffFatherOrHusband' => $ss->schoolStaffFatherOrHusband,
					'schoolStaffCnic' => $ss->schoolStaffCnic,
					'schoolStaffQaulificationProfessional' => $ss->schoolStaffQaulificationProfessional,
					'schoolStaffQaulificationAcademic' => $ss->schoolStaffQaulificationAcademic,
					'schoolStaffAppointmentDate' => $ss->schoolStaffAppointmentDate,
					'schoolStaffDesignition' => $ss->schoolStaffDesignition,
					'schoolStaffNetPay' => $ss->schoolStaffNetPay,
					'schoolStaffAnnualIncreament' => $ss->schoolStaffAnnualIncreament,
					'schoolStaffType' => $ss->schoolStaffType,
					'schoolStaffGender' => $ss->schoolStaffGender,
					'TeacherTraining' => $ss->TeacherTraining,
					'TeacherExperience' => $ss->TeacherExperience
				)

			);
		}

		if (!empty($school_staff_array)) {
			$this->db->insert_batch('school_staff', $school_staff_array);
		}



		//get "fee"  and insert wiht school_id
		// $school_fee = $this->school_m->fee_by_school_id($school_id);
		// $school_fee_array = array();
		// foreach ($school_fee as $sf) {
		// 	array_push(
		// 		$school_fee_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'class_id' => $sf->class_id,
		// 			'addmissionFee' => $sf->addmissionFee,
		// 			'tuitionFee' => $sf->tuitionFee,
		// 			'otherFund' => $sf->otherFund,
		// 			'securityFund' => $sf->securityFund
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_array)) {
		// 	$this->db->insert_batch('fee', $school_fee_array);
		// }
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_d_status' => 1));

		//  get "fee_mentioned_in_form_or_prospectus"  and insert wiht school_id
		$school_fee_mentioned_in_form = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		if (!empty($school_fee_mentioned_in_form)) {
			$this->db->insert(
				'fee_mentioned_in_form_or_prospectus',
				array(
					'school_id' => $school_inserted_id,
					'feeMentionedInForm' => $school_fee_mentioned_in_form->feeMentionedInForm
				)
			);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_e_status' => 1));



		//  get "security_measures"  and insert wiht school_id
		$school_security_measures = $this->school_m->security_measures_by_school_id($school_id);
		if (!empty($school_security_measures)) {
			$school_security_measures_array = array(
				'school_id' => $school_inserted_id,
				'securityStatus' => $school_security_measures->securityStatus,
				'securityProvided' => $school_security_measures->securityProvided,
				'securityPersonnel' => $school_security_measures->securityPersonnel,
				'security_personnel_status_id' => $school_security_measures->security_personnel_status_id,
				'security_according_to_police_dept' => $school_security_measures->security_according_to_police_dept,
				'cameraInstallation' => $school_security_measures->cameraInstallation,
				'camraNumber' => $school_security_measures->camraNumber,
				'dvrMaintained' => $school_security_measures->dvrMaintained,
				'cameraOnline' => $school_security_measures->cameraOnline,
				'exitDoorsNumber' => $school_security_measures->exitDoorsNumber,
				'emergencyDoorsNumber' => $school_security_measures->emergencyDoorsNumber,
				'boundryWallHeight' => $school_security_measures->boundryWallHeight,
				'wiresProvided' => $school_security_measures->wiresProvided,
				'watchTower' => $school_security_measures->watchTower,
				'licensedWeapon' => $school_security_measures->licensedWeapon,
				'licenseNumber' => $school_security_measures->licenseNumber,
				'ammunitionStatus' => $school_security_measures->ammunitionStatus,
				'metalDetector' => $school_security_measures->metalDetector,
				'walkThroughGate' => $school_security_measures->walkThroughGate,
				'gateBarrier' => $school_security_measures->gateBarrier,
				'license_issued_by_id' => $school_security_measures->license_issued_by_id
			);
			$this->db->insert('security_measures', $school_security_measures_array);
			$this->db->insert_id();
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_f_status' => 1));


		//  get "security_measures"  and insert wiht school_id
		$school_hazards_with_associated_risks = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		if (!empty($school_hazards_with_associated_risks)) {
			$school_hazards_with_associated_risks_array = array(
				'school_id' => $school_inserted_id,
				'exposedToFlood' => $school_hazards_with_associated_risks->exposedToFlood,
				'drowning' => $school_hazards_with_associated_risks->drowning,
				'buildingCondition' => $school_hazards_with_associated_risks->buildingCondition,
				'accessRoute' => $school_hazards_with_associated_risks->accessRoute,
				'adjacentBuilding' => $school_hazards_with_associated_risks->adjacentBuilding,
				'safeAssemblyPointsAvailable' => $school_hazards_with_associated_risks->safeAssemblyPointsAvailable,
				'disasterTraining' => $school_hazards_with_associated_risks->disasterTraining,
				'schoolImprovementPlan' => $school_hazards_with_associated_risks->schoolImprovementPlan,
				'schoolDisasterManagementPlan' => $school_hazards_with_associated_risks->schoolDisasterManagementPlan,
				'electrification_condition_id' => $school_hazards_with_associated_risks->electrification_condition_id,
				'ventilationSystemAvailable' => $school_hazards_with_associated_risks->ventilationSystemAvailable,
				'chemicalsSchoolLaboratory' => $school_hazards_with_associated_risks->chemicalsSchoolLaboratory,
				'chemicalsSchoolSurrounding' => $school_hazards_with_associated_risks->chemicalsSchoolSurrounding,
				'roadAccident' => $school_hazards_with_associated_risks->roadAccident,
				'safeDrinkingWaterAvailable' => $school_hazards_with_associated_risks->safeDrinkingWaterAvailable,
				'sanitationFacilities' => $school_hazards_with_associated_risks->sanitationFacilities,
				'building_structure_id' => $school_hazards_with_associated_risks->building_structure_id,
				'school_surrounded_by_id' => $school_hazards_with_associated_risks->school_surrounded_by_id
			);
			$this->db->insert('hazards_with_associated_risks', $school_hazards_with_associated_risks_array);
			$this->db->insert_id();
		}
		//  get "hazards_with_associated_risks_unsafe_list"  and insert wiht school_id
		$hazards_with_associated_risks_unsafe_list = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);
		$hazards_with_associated_risks_unsafe_list_array = array();
		foreach ($hazards_with_associated_risks_unsafe_list as $hwaru) {
			array_push(
				$hazards_with_associated_risks_unsafe_list_array,
				array(
					'school_id' => $school_inserted_id,
					'unsafe_list_id' => $hwaru->unsafe_list_id
				)
			);
		}
		if (!empty($hazards_with_associated_risks_unsafe_list_array)) {
			$this->db->insert_batch('hazards_with_associated_risks_unsafe_list', $hazards_with_associated_risks_unsafe_list_array);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_g_status' => 1));

		//  get "school_fee_concession"  and insert wiht school_id
		// $school_fee_concession = $this->school_m->fee_concession_by_school_id($school_id);
		// $school_fee_concession_array = array();
		// foreach ($school_fee_concession as $sfc) {
		// 	array_push(
		// 		$school_fee_concession_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'concession_id' => $sfc->concession_id,
		// 			'percentage' => $sfc->percentage,
		// 			'numberOfStudent' => $sfc->numberOfStudent
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_concession_array)) {
		// 	$this->db->insert_batch('fee_concession', $school_fee_concession_array);
		// }
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("form/section_b/$session_id");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 4,
				'updatedDate' => date('Y-m-d H:i:s', time()),
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$session_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$session_id");
			}
		}
	}

	public function upgradation($session_id)
	{


		$this->data['session_id'] = $session_id = (int) $session_id;
		$userId = $this->session->userdata('userId');
		$query = "SELECT schoolId, level_of_school_id, gender_type_id, school_type_id,owner_id, reg_type_id 
		         FROM schools WHERE `owner_id`='" . $userId . "'";
		$school_detail = $this->db->query($query)->result()[0];
		$schools_id = $school_detail->schoolId;

		$query = "SELECT *  FROM `school` WHERE `schools_id` = '" . $schools_id . "' AND status=1 ORDER BY `session_year_id` DESC";
		$last_session_detail = $this->db->query($query)->result()[0];

		//insert new session...
		$new_session['schools_id'] = $schools_id;
		$new_session['reg_type_id'] = 3;
		$new_session['gender_type_id'] = $last_session_detail->gender_type_id;
		$new_session['school_type_id'] = $last_session_detail->school_type_id;
		$new_session['level_of_school_id'] = $last_session_detail->level_of_school_id;
		$new_session['session_year_id'] = $session_id;
		date_default_timezone_set("Asia/Karachi");
		$dated = date("d-m-Y h:i:sa");
		$new_session['created_date'] = $dated;
		$this->db->insert('school', $new_session);


		$school_inserted_id = $this->db->insert_id();
		$school_id = $last_session_detail->schoolId;


		$this->db->insert('forms_process', array(
			'user_id' => $userId,
			'reg_type_id' => 3,
			'form_a_status' => 1,
			'school_id' => $school_inserted_id
		));

		$this->db->where('userId', $userId)->update('users', array('school_renewed' => 1));


		$this->db->trans_begin();
		$physical_facilities =  $this->db->where('school_id', $school_id)->get('physical_facilities')->row();

		if (!empty($physical_facilities)) {
			$physical_facilities = $physical_facilities;
			$physical_facilities_array = array(
				'building_id' => $physical_facilities->building_id,
				'numberOfClassRoom' => $physical_facilities->numberOfClassRoom,
				'numberOfOtherRoom' => $physical_facilities->numberOfOtherRoom,
				'totalArea' => $physical_facilities->totalArea,
				'coveredArea' => $physical_facilities->coveredArea,
				'numberOfComputer' => $physical_facilities->numberOfComputer,
				'numberOfLatrines' => $physical_facilities->numberOfLatrines,
				'school_id' => $school_inserted_id
			);
			$this->db->insert('physical_facilities', $physical_facilities_array);
		}


		// get and insert as a batch insertion
		$school_physical_facilities_physical = $this->school_m->physical_facilities_physical_by_school_id($school_id);
		$school_physical_facilities_physical_array = array();
		foreach ($school_physical_facilities_physical as $spfp) {
			array_push(
				$school_physical_facilities_physical_array,
				array(
					'school_id' => $school_inserted_id,
					'pf_physical_id' => $spfp->pf_physical_id
				)
			);
		}
		if (!empty($school_physical_facilities_physical_array)) {
			$this->db->insert_batch('physical_facilities_physical', $school_physical_facilities_physical_array);
		}



		// get "physical_facilities_academic" table data and insert as batch
		$school_physical_facilities_academic = $this->school_m->physical_facilities_academic_by_school_id($school_id);
		$school_physical_facilities_academic_array = array();
		foreach ($school_physical_facilities_academic as $spfa) {
			array_push(
				$school_physical_facilities_academic_array,
				array(
					'school_id' => $school_inserted_id,
					'academic_id' => $spfa->academic_id
				)
			);
		}
		if (!empty($school_physical_facilities_academic_array)) {
			$this->db->insert_batch('physical_facilities_academic', $school_physical_facilities_academic_array);
		}

		//  get "physical_facilities_co_curricular" and insert wiht school_id
		$physical_facilities_co_curricular = $this->school_m->physical_facilities_co_curricular_by_school_id($school_id);
		$physical_facilities_co_curricular_array = array();
		foreach ($physical_facilities_co_curricular as $pfcc) {
			array_push(
				$physical_facilities_co_curricular_array,
				array(
					'school_id' => $school_inserted_id,
					'co_curricular_id' => $pfcc->co_curricular_id
				)
			);
		}
		if (!empty($physical_facilities_co_curricular_array)) {
			$this->db->insert_batch('physical_facilities_co_curricular', $physical_facilities_co_curricular_array);
		}

		//  get "school_physical_facilities_other" and insert wiht school_id
		$physical_facilities_others =  $this->school_m->physical_facilities_other_by_school_id($school_id);
		$physical_facilities_others_array = array();
		foreach ($physical_facilities_others as $pfo) {
			array_push(
				$physical_facilities_others_array,
				array(
					'school_id' => $school_inserted_id,
					'other_id' => $pfo->other_id
				)
			);
		}
		if (!empty($physical_facilities_others_array)) {
			$this->db->insert_batch('physical_facilities_others', $physical_facilities_others_array);
		}

		//  get "school_physical_facilities_other"  and insert wiht school_id
		$school_library = $this->school_m->get_library_books_by_school_id($school_id);
		$school_library_array = array();
		foreach ($school_library as $sl) {
			array_push(
				$school_library_array,
				array(
					'school_id' => $school_inserted_id,
					'book_type_id' => $sl->book_type_id,
					'numberOfBooks' => $sl->numberOfBooks
				)
			);
		}
		if (!empty($school_library_array)) {
			$this->db->insert_batch('school_library', $school_library_array);
		}

		$school_staff = $this->school_m->staff_by_school_id($school_id);
		$school_staff_array = array();
		foreach ($school_staff as $ss) {
			array_push(
				$school_staff_array,
				array(
					'school_id' => $school_inserted_id,
					'schoolStaffName' => $ss->schoolStaffName,
					'schoolStaffFatherOrHusband' => $ss->schoolStaffFatherOrHusband,
					'schoolStaffCnic' => $ss->schoolStaffCnic,
					'schoolStaffQaulificationProfessional' => $ss->schoolStaffQaulificationProfessional,
					'schoolStaffQaulificationAcademic' => $ss->schoolStaffQaulificationAcademic,
					'schoolStaffAppointmentDate' => $ss->schoolStaffAppointmentDate,
					'schoolStaffDesignition' => $ss->schoolStaffDesignition,
					'schoolStaffNetPay' => $ss->schoolStaffNetPay,
					'schoolStaffAnnualIncreament' => $ss->schoolStaffAnnualIncreament,
					'schoolStaffType' => $ss->schoolStaffType,
					'schoolStaffGender' => $ss->schoolStaffGender,
					'TeacherTraining' => $ss->TeacherTraining,
					'TeacherExperience' => $ss->TeacherExperience
				)

			);
		}

		if (!empty($school_staff_array)) {
			$this->db->insert_batch('school_staff', $school_staff_array);
		}



		//get "fee"  and insert wiht school_id
		// $school_fee = $this->school_m->fee_by_school_id($school_id);
		// $school_fee_array = array();
		// foreach ($school_fee as $sf) {
		// 	array_push(
		// 		$school_fee_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'class_id' => $sf->class_id,
		// 			'addmissionFee' => $sf->addmissionFee,
		// 			'tuitionFee' => $sf->tuitionFee,
		// 			'otherFund' => $sf->otherFund,
		// 			'securityFund' => $sf->securityFund
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_array)) {
		// 	$this->db->insert_batch('fee', $school_fee_array);
		// }
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_d_status' => 1));

		//  get "fee_mentioned_in_form_or_prospectus"  and insert wiht school_id
		$school_fee_mentioned_in_form = $this->school_m->fee_mentioned_in_form_by_school_id($school_id);
		if (!empty($school_fee_mentioned_in_form)) {
			$this->db->insert(
				'fee_mentioned_in_form_or_prospectus',
				array(
					'school_id' => $school_inserted_id,
					'feeMentionedInForm' => $school_fee_mentioned_in_form->feeMentionedInForm
				)
			);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_e_status' => 1));



		//  get "security_measures"  and insert wiht school_id
		$school_security_measures = $this->school_m->security_measures_by_school_id($school_id);
		if (!empty($school_security_measures)) {
			$school_security_measures_array = array(
				'school_id' => $school_inserted_id,
				'securityStatus' => $school_security_measures->securityStatus,
				'securityProvided' => $school_security_measures->securityProvided,
				'securityPersonnel' => $school_security_measures->securityPersonnel,
				'security_personnel_status_id' => $school_security_measures->security_personnel_status_id,
				'security_according_to_police_dept' => $school_security_measures->security_according_to_police_dept,
				'cameraInstallation' => $school_security_measures->cameraInstallation,
				'camraNumber' => $school_security_measures->camraNumber,
				'dvrMaintained' => $school_security_measures->dvrMaintained,
				'cameraOnline' => $school_security_measures->cameraOnline,
				'exitDoorsNumber' => $school_security_measures->exitDoorsNumber,
				'emergencyDoorsNumber' => $school_security_measures->emergencyDoorsNumber,
				'boundryWallHeight' => $school_security_measures->boundryWallHeight,
				'wiresProvided' => $school_security_measures->wiresProvided,
				'watchTower' => $school_security_measures->watchTower,
				'licensedWeapon' => $school_security_measures->licensedWeapon,
				'licenseNumber' => $school_security_measures->licenseNumber,
				'ammunitionStatus' => $school_security_measures->ammunitionStatus,
				'metalDetector' => $school_security_measures->metalDetector,
				'walkThroughGate' => $school_security_measures->walkThroughGate,
				'gateBarrier' => $school_security_measures->gateBarrier,
				'license_issued_by_id' => $school_security_measures->license_issued_by_id
			);
			$this->db->insert('security_measures', $school_security_measures_array);
			$this->db->insert_id();
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_f_status' => 1));


		//  get "security_measures"  and insert wiht school_id
		$school_hazards_with_associated_risks = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
		if (!empty($school_hazards_with_associated_risks)) {
			$school_hazards_with_associated_risks_array = array(
				'school_id' => $school_inserted_id,
				'exposedToFlood' => $school_hazards_with_associated_risks->exposedToFlood,
				'drowning' => $school_hazards_with_associated_risks->drowning,
				'buildingCondition' => $school_hazards_with_associated_risks->buildingCondition,
				'accessRoute' => $school_hazards_with_associated_risks->accessRoute,
				'adjacentBuilding' => $school_hazards_with_associated_risks->adjacentBuilding,
				'safeAssemblyPointsAvailable' => $school_hazards_with_associated_risks->safeAssemblyPointsAvailable,
				'disasterTraining' => $school_hazards_with_associated_risks->disasterTraining,
				'schoolImprovementPlan' => $school_hazards_with_associated_risks->schoolImprovementPlan,
				'schoolDisasterManagementPlan' => $school_hazards_with_associated_risks->schoolDisasterManagementPlan,
				'electrification_condition_id' => $school_hazards_with_associated_risks->electrification_condition_id,
				'ventilationSystemAvailable' => $school_hazards_with_associated_risks->ventilationSystemAvailable,
				'chemicalsSchoolLaboratory' => $school_hazards_with_associated_risks->chemicalsSchoolLaboratory,
				'chemicalsSchoolSurrounding' => $school_hazards_with_associated_risks->chemicalsSchoolSurrounding,
				'roadAccident' => $school_hazards_with_associated_risks->roadAccident,
				'safeDrinkingWaterAvailable' => $school_hazards_with_associated_risks->safeDrinkingWaterAvailable,
				'sanitationFacilities' => $school_hazards_with_associated_risks->sanitationFacilities,
				'building_structure_id' => $school_hazards_with_associated_risks->building_structure_id,
				'school_surrounded_by_id' => $school_hazards_with_associated_risks->school_surrounded_by_id
			);
			$this->db->insert('hazards_with_associated_risks', $school_hazards_with_associated_risks_array);
			$this->db->insert_id();
		}
		//  get "hazards_with_associated_risks_unsafe_list"  and insert wiht school_id
		$hazards_with_associated_risks_unsafe_list = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);
		$hazards_with_associated_risks_unsafe_list_array = array();
		foreach ($hazards_with_associated_risks_unsafe_list as $hwaru) {
			array_push(
				$hazards_with_associated_risks_unsafe_list_array,
				array(
					'school_id' => $school_inserted_id,
					'unsafe_list_id' => $hwaru->unsafe_list_id
				)
			);
		}
		if (!empty($hazards_with_associated_risks_unsafe_list_array)) {
			$this->db->insert_batch('hazards_with_associated_risks_unsafe_list', $hazards_with_associated_risks_unsafe_list_array);
		}
		// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_g_status' => 1));

		//  get "school_fee_concession"  and insert wiht school_id
		// $school_fee_concession = $this->school_m->fee_concession_by_school_id($school_id);
		// $school_fee_concession_array = array();
		// foreach ($school_fee_concession as $sfc) {
		// 	array_push(
		// 		$school_fee_concession_array,
		// 		array(
		// 			'school_id' => $school_inserted_id,
		// 			'concession_id' => $sfc->concession_id,
		// 			'percentage' => $sfc->percentage,
		// 			'numberOfStudent' => $sfc->numberOfStudent
		// 		)
		// 	);
		// }
		// if (!empty($school_fee_concession_array)) {
		// 	$this->db->insert_batch('fee_concession', $school_fee_concession_array);
		// }
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata(
				'msg_error',
				"Sorry Something went wrong!."
			);
			redirect("form/section_b/$session_id");
		} else {
			$this->db->trans_commit();
			$school_data_to_update = array(
				'reg_type_id' => 3,
				'updatedDate' => date('Y-m-d H:i:s', time()),
				'updatedBy' => $this->session->userdata('userId'),
				'created_date' => date('Y-m-d H:i:s', time()),
				'status' => 0
			);
			// echo "<pre>"; print_r($school_data_to_update);exit();
			$this->db->where('schoolId', $school_inserted_id);
			$this->db->update('school', $school_data_to_update);
			$affected_rows = $this->db->affected_rows();
			if ($affected_rows > 0) {
				$this->session->set_flashdata(
					'msg_success',
					"You have successfully applied for renewal, kindly update your current school data."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$session_id");
			} else {
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("form/section_b/$school_id");
			}
		}
	}
}
