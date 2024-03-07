<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Admin_Controller
// MY_Controller
class Test_code extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
	}

	public function index()
	{
		echo "ok";
	}

	public function district_registration_code()
	{

		$query = "SELECT * FROM district lIMIT 2";
		$districts = $this->db->query($query)->result();
		foreach ($districts as $district) {

			for ($i = 1; $i < 9999; $i++) {
				$mis_code = sprintf("%04d", $i);
				echo 'P' . $district->district_code . '' . $mis_code . "<br />";
			}
		}
	}

	public function update_mis_code()
	{

		error_reporting(-1);
		error_reporting(E_ERROR | E_PARSE);
		ini_set('display_errors', 1);
		ini_set('memory_limit', '128M');
		$query = "SELECT * FROM schools WHERE registrationNumber>0";
		$schools = $this->db->query($query)->result();
		foreach ($schools as $school) {

			$MIS_CODE = "";
			$query = "SELECT COUNT(*) as total FROM mis_codes WHERE school_id = '" . $school->schoolId . "'";
			$mis_code_count = $this->db->query($query)->row()->total;

			if ($mis_code_count == 0) {
				$query = "INSERT INTO `mis_codes`(`school_id`, `registration_code`) 
				          VALUES ('" . $school->schoolId . "', '" . $school->registrationNumber . "')";
				if ($this->db->query($query)) {
					$mis_code_id = $this->db->insert_id();
					$prefix = ($school->school_type_id == 1) ? "PS" : (($school->school_type_id == 7) ? "PA" : "");
					$MIS_CODE = $prefix . sprintf("%05d", $mis_code_id);
					$query = "UPDATE `mis_codes` SET `mis_code`='" . $MIS_CODE . "' 
					WHERE `code_id` = '" . $mis_code_id . "'";
					$this->db->query($query);
				}
			} else {
				$query = "SELECT * FROM mis_codes WHERE school_id = '" . $school->schoolId . "'";
				$MIS_CODE = $this->db->query($query)->row()->mis_code;
			}

			$query = "UPDATE `schools` SET `mis_code`='" . $MIS_CODE . "' WHERE `schoolId` = '" . $school->schoolId . "'";
			$this->db->query($query);
		}
	}
}
