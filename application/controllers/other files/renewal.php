<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Renewal extends MY_Controller
{

	public function apply($session_id)
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
				'reg_type_id' => 2,
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

			$this->db->where('userId', $school->owner_id)->update('users', array('school_renewed' => 1));
		} else {
			echo "You are already applied";
		}
	}
}
