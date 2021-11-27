<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Apply extends MY_Controller
{

	public function index()
	{
		echo "We are working on it";
	}

	public function renewal()
	{
		$this->data['school_id'] = (int) $school_id = 4;
		$this->data['school_detail'] = $this->db->query("SELECT * FROM schools WHERE schoolId = '" . $school_id . "'")->result()[0];
		$this->data['session_id'] = (int) $session_id =  4;

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT MAX(tuitionFee) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace('/[^0-9.]/', '', $this->db->query($query)->result()[0]->max_tution_fee);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` WHERE sessionYearId = $session_id")->result()[0];

		$last_seesion_record = $this->db->query("SELECT * FROM `school` WHERE schools_id='" . $school_id . "' ORDER BY schoolId DESC LIMIT 1")->result()[0];
		$school_type_id = $last_seesion_record->school_type_id;
		$gender_type_id = $last_seesion_record->gender_type_id;
		$query = "SELECT classes_ids FROM `levelofinstitute` WHERE levelofInstituteId='" . $school_type_id . "'";
		$classes_ids = $this->db->query($query)->result()[0]->classes_ids;
		$query = "SELECT * FROM class WHERE classId IN(" . $classes_ids . ")";

		$this->data['classes'] = $this->db->query($query)->result();

		$school_gender_id = $last_seesion_record->gender_type_id;


		$this->data['schools_id'] = $this->db->query("SELECT schoolId FROM `school` 
													  WHERE `schools_id` = '" . $school_id . "' 
													  AND `session_year_id` = '" . $session_id . "'")->result()[0]->schoolId;

		$this->data['ages'] = $this->db->query("SELECT * FROM age")->result();

		$this->data['title'] = 'Apply For Renewal';
		$this->data['description'] = 'Apply For Renewal';
		$this->data['view'] = 'apply/renewal';
		$this->load->view('layout', $this->data);
	}
	public function renewal_fee_sturucture()
	{


		$query = "SELECT * FROM `fee_structure`";
		$this->data['fee_structures'] = $this->db->query($query)->result();
		$this->load->view('apply/renewal_fee_sturucture', $this->data);
	}

	public function print_renewal_bank_challan($session_id)
	{
		$this->data['school_id'] = (int) $school_id = 4;
		$this->data['school_detail'] = $this->db->query("SELECT * FROM schools WHERE schoolId = '" . $school_id . "'")->result()[0];
		$this->data['session_id'] = (int) $session_id =  4;

		$query = "SELECT session_id, last_date, fine_percentage FROM `session_fee_submission_dates` 
		               WHERE session_id= $session_id AND last_date >='" . date('Y-m-d') . "' 
					   ORDER BY last_date ASC LIMIT 1";
		$this->data['late_fee'] = $this->db->query($query)->result()[0];

		$query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $session_id . "'";
		$this->data['session_fee_submission_dates'] = $this->db->query($query)->result();

		$query = "SELECT MAX(tuitionFee) as max_tution_fee  FROM `fee` WHERE school_id= '" . $school_id . "'";
		$this->data['max_tuition_fee'] = $max_tuition_fee = preg_replace('/[^0-9.]/', '', $this->db->query($query)->result()[0]->max_tution_fee);

		$query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee FROM `fee_structure` WHERE fee_min <= $max_tuition_fee ORDER BY fee_min DESC LIMIT 1";
		$this->data['fee_sturucture'] = $this->db->query($query)->result()[0];

		$this->data['session_detail'] = $this->db->query("SELECT * FROM `session_year` WHERE sessionYearId = $session_id")->result()[0];


		$this->load->view('apply/renewal_bank_challan_print', $this->data);
	}

	public function school_update_by_school_user_after_copying_data_process()
	{

		$post = $this->input->post();
		// echo "<pre>";print_r($post);
		// exit();
		if ($this->input->post('bt_date')) {
			$count = count($this->input->post('bt_date'));
			for ($i = 0; $i < $count; $i++) {
				$InserData = array(
					'school_id' => $this->input->post('school_id'),
					'reg_type_id' => $this->input->post('reg_type_id'),
					'bt_no' => $_POST['bt_no'][$i],
					'bt_date' => $_POST['bt_date'][$i],
				);
				//   $query = $this->db->query("SELECT * FROM bank_transaction where bt_no='".$_POST['bt_no'][$i]."'");
				//   $num_rows =  $query->num_rows(); 
				//   if($num_rows > 0){
				//     echo "THis ".$_POST['bt_no'][$i]." tracsaction no already used";exit();
				//   }else{
				//     $this->db->insert('bank_transaction', $InserData);
				//   }
				$this->db->insert('bank_transaction', $InserData);
			}
		}


		$school_id = $post['school_id'];
		$this->db->where('schoolId', $school_id);

		$current_session = $this->db->get('school')->row();
		$schools_id = $current_session->schools_id;
		$status = $current_session->status;
		//echo $school_id;exit;

		$this->db->where('schools_id', $schools_id);
		$this->db->where('status', 1);
		$this->db->order_by('schoolId', 'DESC');
		$previos_session = $this->db->get('school')->row();
		$school_inserted_id = $school_id;
		$school_id = $previos_session->schoolId;
		//var_dump($previos_session);exit;
		///////////////////////////////////
		///////////////////////////////////
		//////////////////////////////////
		// Copy School Data
		if ($status == 0) {
			$this->db->trans_begin();
			//  if($skip_post_data == false){

			//   $post = $this->input->post();
			//   $schools_data_to_update = array(
			//       'level_of_school_id' => $post['level_of_school_id'],
			//       'gender_type_id' => $post['gender_type_id'],
			//       'school_type_id' => $post['type_of_institute_id'],
			//       'reg_type_id' => $post['reg_type_id'],
			//       'schoolName' => $post['name'],
			//       'ppcName'=> $post['ppcName'],
			//       'ppcCode'=> $post['ppcCode'],
			//       'schoolTypeOther'=> $post['schoolTypeOther']
			//   );

			//   $this->db->where('schoolId', $post['schools_id']);
			//   $this->db->update('schools', $schools_data_to_update);
			//   $affected_rows = $this->db->affected_rows();

			//   // getting school Id and then get all old data by this school id and updated with renewal school id 
			//   $school_id = $this->db->where('schools_id', $post['schools_id'])->order_by('schoolId', 'desc')->get('school')->result()[0]->schoolId;

			//   $school_data_to_insert = array(
			//                           'reg_type_id' => $post['reg_type_id'],
			//                           'schools_id' => $post['schools_id'],
			//                           'session_year_id' => $post['session_year_id'],
			//                           'level_of_school_id' => $post['level_of_school_id'],
			//                           'gender_type_id' => $post['gender_type_id'],
			//                           'school_type_id' => $post['type_of_institute_id'],
			//                           'updatedDate' => $post['createdDate'],
			//                           'school_will_be_update_by_school_user' => 1,
			//                           'updatedBy' => $this->session->userdata('userId')
			//                         );
			//   $this->db->insert('school', $school_data_to_insert);
			//   $school_inserted_id = $this->db->insert_id();

			//   $this->db->insert('forms_process', array('user_id' => $post['owner_id'],
			//                                           'reg_type_id' => $post['reg_type_id'],
			//                                           'form_a_status' => 1,
			//                                           'school_id' => $school_inserted_id                                       
			//                                     ));
			// }

			// $physical_facilities = $this->school_m->physical_facilities_by_school_id($school_id);
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
			// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_b_status' => 1));

			//  get "age_and_class"  and insert wiht school_id
			// $age_and_class = $this->db->where('school_id', $school_id)->get('age_and_class')->result();
			// $age_and_class_array = array();
			// foreach ($age_and_class as $ac) {
			//   array_push($age_and_class_array, array(
			//                                     'school_id' => $school_inserted_id,
			//                                     'age_id' => $ac->age_id,
			//                                     'class_id' => $ac->class_id,
			//                                     'enrolled' => $ac->enrolled,
			//                                     'gender_id' => $ac->gender_id,
			//                                     'total' => $ac->total
			//                                   )
			//   );
			// }
			// if(!empty($age_and_class_array)){
			//   $this->db->insert_batch('age_and_class', $age_and_class_array);
			// }
			// $this->db->where('school_id', $school_inserted_id)->update('forms_process', array('form_c_status' => 1));

			//  get "age_and_class"  and insert wiht school_id
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
			$school_fee = $this->school_m->fee_by_school_id($school_id);
			$school_fee_array = array();
			foreach ($school_fee as $sf) {
				array_push(
					$school_fee_array,
					array(
						'school_id' => $school_inserted_id,
						'class_id' => $sf->class_id,
						'addmissionFee' => $sf->addmissionFee,
						'tuitionFee' => $sf->tuitionFee,
						'otherFund' => $sf->otherFund,
						'securityFund' => $sf->securityFund
					)
				);
			}
			if (!empty($school_fee_array)) {
				$this->db->insert_batch('fee', $school_fee_array);
			}
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
			$school_fee_concession = $this->school_m->fee_concession_by_school_id($school_id);
			$school_fee_concession_array = array();
			foreach ($school_fee_concession as $sfc) {
				array_push(
					$school_fee_concession_array,
					array(
						'school_id' => $school_inserted_id,
						'concession_id' => $sfc->concession_id,
						'percentage' => $sfc->percentage,
						'numberOfStudent' => $sfc->numberOfStudent
					)
				);
			}
			if (!empty($school_fee_concession_array)) {
				$this->db->insert_batch('fee_concession', $school_fee_concession_array);
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata(
					'msg_error',
					"Sorry Something went wrong!."
				);
				//echo $school_id;exit;
				redirect("school/create_form");
			} else {
				$this->db->trans_commit();
				$school_data_to_update = array(
					'reg_type_id' => $post['reg_type_id'],
					'updatedDate' => date('Y-m-d H:i:s', time()),
					'updatedBy' => $this->session->userdata('userId'),
					'status' => 2
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
					redirect("school/explore_school_by_id/$school_inserted_id");
				} else {
					$this->session->set_flashdata(
						'msg_error',
						"Sorry Something went wrong!."
					);
					//echo $school_id;exit;
					redirect("school/create_form");
				}
			}
		} else {
			redirect("school/explore_school_by_id/$school_inserted_id");
		}
	}
}
