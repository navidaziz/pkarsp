<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Request_m extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public function get_request_list($status, $request_type = NULL, $title = NULL)
    {
        $query = "SELECT
		`schools`.schoolId as schools_id,
		`schools`.schoolName,
		`schools`.registrationNumber,
		`schools`.biseRegister,
		`session_year`.`sessionYearTitle`,
		`session_year`.`sessionYearId`,
		`school`.`status`,
		`reg_type`.`regTypeTitle`,
		`school`.`schoolId` as school_id
		FROM
		`school`,
		`schools`,
		`session_year`,
		`reg_type`
		
		WHERE  `session_year`.`sessionYearId` = `school`.`session_year_id`
		AND `school`.`schools_id` = `schools`.`schoolId`
		AND `school`.`reg_type_id` = `reg_type`.`regTypeId`
		AND `school`.`status`= '" . $status . "'";
        if ($request_type) {
            $query .= "AND `school`.`reg_type_id`= $request_type";
        }
        if ($title) {
            $this->data['title'] = $status . " - " . $title;
        }

        $this->data['requests'] = $this->db->query($query)->result();

        $this->load->view('registration_section/requests', $this->data);
    }
}
