<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visits extends CI_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load("system", 'english');
        $this->load->model("school_m");
        //$this->output->enable_profiler(TRUE);

    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {

        $this->data["title"] = 'Visit Reports';
        $this->data["description"] = 'Visit Report List';
        //$this->data['view'] = 'visits/index';
        // $this->load->view('layout', $this->data);
        $this->load->view('visits/index', $this->data);
    }

    public function visit_list()
    {

        $this->data["title"] = 'Visit Reports';
        $this->data["description"] = 'Visit Report List';
        $this->data['view'] = 'visits/visit_list';
        $this->load->view('layout', $this->data);
    }

    public function get_school_by_school_id()
    {
        $institute_id = (int) $this->input->post('institute_id');
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
        $query .= " WHERE `schools`.`schoolId` = '" . $institute_id . " '";
        $this->data['school'] = $this->db->query($query)->row();

        $this->load->view('visits/school_info', $this->data);
    }

    public function institute_visit_report($visit_id, $schools_id, $school_id, $form)
    {

        $this->data['visit_id'] = $visit_id = (int) $visit_id;
        $this->data['schools_id'] = $schools_id = (int) $schools_id;
        $this->data['school_id'] = $school_id = (int) $school_id;
        $this->data['form'] = $form = $form;

        if ($visit_id == 0) {
            $input = $this->get_inputs();
            $input->high_level_lab = 'No';
        } else {
            $query = "SELECT * FROM 
            visits 
            WHERE visit_id = $visit_id";
            $input = $this->db->query($query)->row();
            // if ($input->high_level_lab == NULL) {
            //     $input->high_level_lab = 'No';
            // }
            // if ($input->physics_lab == NULL) {
            //     $input->physics_lab = 'No';
            // }
            // if ($input->chemistry_lab == NULL) {
            //     $input->chemistry_lab = 'No';
            // }
            // if ($input->biology_lab == NULL) {
            //     $input->biology_lab = 'No';
            // }

            // if ($input->computer_lab == NULL) {
            //     $input->computer_lab = 'No';
            // }
            // if ($input->library == NULL) {
            //     $input->library = 'No';
            // }
        }



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
        $query .= " WHERE `schools`.`schoolId` = '" . $input->schools_id . " '";
        $this->data['school'] = $this->db->query($query)->row();

        $query = "SELECT session_year.sessionYearTitle, reg_type.regTypeTitle,
        school_type.typeTitle
        FROM school 
        INNER JOIN session_year ON(session_year.sessionYearId = school.session_year_id)
        INNER JOIN reg_type ON(reg_type.regTypeId = school.reg_type_id)
        INNER JOIN school_type ON(school_type.typeId = school.school_type_id)
        WHERE schools_id = '" . $input->schools_id . "' 
        AND schoolId = '" . $input->school_id . "'";
        $this->data['session'] = $this->db->query($query)->row();

        $this->data["input"] = $input;
        if ($input->visited == 'Yes') {
            $this->data['view'] = 'visits/visit_form/visit_report';
        } else {
            $this->data['view'] = 'visits/visit_form/' . $form;
        }
        $this->load->view('visits/visit_form/layout', $this->data);
        //$this->load->view('visits/institute_visit_report', $this->data);
        //$this->load->view('visits/visit_form/' . $form, $this->data);
    }
    private function add_form_a_data()
    {
        // foreach ($_POST as $var => $value) {
        //     echo ' $this->form_validation->set_rules("' . $var . '", "' . ucwords(strtolower(str_replace('_', ' ', $var))) . '", "required");<br />';
        // }
        // foreach ($_POST as $var => $value) {
        //     echo '$input["' . $var . '"] = $this->input->post("' . $var . '");<br />';
        // }
        $this->form_validation->set_rules("gender_of_edu", "Gender Of Edu", "required");
        $this->form_validation->set_rules("timing", "Timing", "required");
        $this->form_validation->set_rules("o_a_levels", "O A Levels", "required");
        $this->form_validation->set_rules("land_type", "Land Type", "required");
        $this->form_validation->set_rules("property_posession", "Property Posession", "required");
        if ($this->input->post("property_posession") == 'Rented') {
            $this->form_validation->set_rules("rent_amount", "Rent Amount", "required");
        }
        $this->form_validation->set_rules("latitude", "Latitude", "required");
        $this->form_validation->set_rules("longitude", "Longitude", "required");
        $this->form_validation->set_rules("altitude", "Altitude", "required");
        $this->form_validation->set_rules("precision", "Precision", "required");
        $this->form_validation->set_rules("total_area", "Total Area", "required");
        $this->form_validation->set_rules("covered_area", "Covered Area", "required");
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $input["a"] = 1;
            $input["d"] = 0;
            $input['visit_status'] = 'Inprogress';
            $input["primary_l"] = $this->input->post("primary_l");
            $input["middle_l"] = $this->input->post("middle_l");
            $input["high_l"] = $this->input->post("high_l");
            $input["high_sec_l"] = $this->input->post("high_sec_l");
            if ($this->input->post("high_l") == 1 or $this->input->post("high_sec_l") == 1) {
                $input["g"] = 0;
                $input["c"] = 0;
            }
            $input["gender_of_edu"] = $this->input->post("gender_of_edu");
            $input["timing"] = $this->input->post("timing");
            $input["o_a_levels"] = $this->input->post("o_a_levels");

            $input["land_type"] = $this->input->post("land_type");
            $input["property_posession"] = $this->input->post("property_posession");
            if ($this->input->post("property_posession") == 'Rented') {
                $input["rent_amount"] = $this->input->post("rent_amount");
            } else {
                $input["rent_amount"] = NULL;
            }
            $input["latitude"] = $this->input->post("latitude");
            $input["longitude"] = $this->input->post("longitude");
            $input["altitude"] = $this->input->post("altitude");
            $input["precision"] = $this->input->post("precision");
            $input["total_area"] = $this->input->post("total_area");
            $input["covered_area"] = $this->input->post("covered_area");
            if ($this->input->post("covered_area") > $this->input->post("total_area")) {
                echo '<div class="alert alert-danger">Please correct the area data. The covered area cannot exceed the total area.</div>';
                exit();
            }
            $visit_id = (int) $this->input->post("visit_id");
            $this->db->where("visit_id", $visit_id);
            $input['last_updated'] = date('Y-m-d H:i:s');
            $input['last_updated_by'] = $this->session->userdata("userId");
            if ($this->db->update("visits", $input)) {
                echo "success";
            }
        }
    }
    private function add_form_b_data()
    {
        $this->form_validation->set_rules("visit_id", "Visit Id", "required");
        $this->form_validation->set_rules("form", "Form", "required");
        if ($this->input->post("registered") == 0) {
            $this->form_validation->set_rules("rent_aggrement_date", "Rent Aggrement Date", "required");
            $this->form_validation->set_rules("first_enrollement_date", "First Enrollement Date", "required");
            $this->form_validation->set_rules("first_teacher_appointment_date", "First Teacher Appointment Date", "required");
            $this->form_validation->set_rules("year_of_establisment", "Year Of Establisment", "required");
        }
        $this->form_validation->set_rules("portrait_quaid", "Portrait Quaid", "required");
        $this->form_validation->set_rules("portrait_iqbal", "Portrait Iqbal", "required");
        $this->form_validation->set_rules("student_furnitures", "Student Furnitures", "required");
        $this->form_validation->set_rules("staff_furnitures", "Staff Furnitures", "required");
        $this->form_validation->set_rules("cross_ventilation", "Cross Ventilation", "required");
        $this->form_validation->set_rules("notice_board", "Notice Board", "required");
        $this->form_validation->set_rules("class_bell", "Class Bell", "required");
        $this->form_validation->set_rules("national_flag", "National Flag", "required");
        $this->form_validation->set_rules("fee_displayed", "Fee Displayed", "required");
        $this->form_validation->set_rules("annual_displayed", "Annual Displayed", "required");
        $this->form_validation->set_rules("water", "Water", "required");
        $this->form_validation->set_rules("electricity", "Electricity", "required");
        $this->form_validation->set_rules("boundary_wall", "Boundary Wall", "required");
        $this->form_validation->set_rules("exam_hall", "Exam Hall", "required");
        $this->form_validation->set_rules("play_ground", "Play Ground", "required");
        $this->form_validation->set_rules("play_area", "Play Area", "required");
        $this->form_validation->set_rules("canteen", "Canteen", "required");
        $this->form_validation->set_rules("stud_hostel", "Stud Hostel", "required");
        $this->form_validation->set_rules("staff_hostel", "Staff Hostel", "required");
        $this->form_validation->set_rules("transport", "Transport", "required");
        $this->form_validation->set_rules("first_aid", "First Aid", "required");
        $this->form_validation->set_rules("admi_withdreal_reg", "Admi Withdreal Reg", "required");
        $this->form_validation->set_rules("stu_attend_reg", "Stu Attend Reg", "required");
        $this->form_validation->set_rules("stu_fee_reg", "Stu Fee Reg", "required");
        $this->form_validation->set_rules("tecah_attend_reg", "Tecah Attend Reg", "required");
        $this->form_validation->set_rules("tecah_salary_reg", "Tecah Salary Reg", "required");
        $this->form_validation->set_rules("computer_available", "Computer Available", "required");
        $this->form_validation->set_rules("internet_connection", "Internet Connection", "required");
        $this->form_validation->set_rules("mobile_connectivity", "Mobile Connectivity", "required");
        $this->form_validation->set_rules("mardrasa", "Mardrasa", "required");
        $this->form_validation->set_rules("academy", "Academy", "required");
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $input["b"] = 1;
            if ($this->input->post("registered") == 0) {
                $input["rent_aggrement_date"] = $this->input->post("rent_aggrement_date");
                $input["first_enrollement_date"] = $this->input->post("first_enrollement_date");
                $input["first_teacher_appointment_date"] = $this->input->post("first_teacher_appointment_date");
                $input["year_of_establisment"] = $this->input->post("year_of_establisment");
            }
            $input["portrait_quaid"] = $this->input->post("portrait_quaid");
            $input["portrait_iqbal"] = $this->input->post("portrait_iqbal");
            $input["student_furnitures"] = $this->input->post("student_furnitures");
            $input["staff_furnitures"] = $this->input->post("staff_furnitures");
            $input["cross_ventilation"] = $this->input->post("cross_ventilation");
            $input["notice_board"] = $this->input->post("notice_board");
            $input["class_bell"] = $this->input->post("class_bell");
            $input["national_flag"] = $this->input->post("national_flag");
            $input["fee_displayed"] = $this->input->post("fee_displayed");
            $input["annual_displayed"] = $this->input->post("annual_displayed");
            $input["water"] = $this->input->post("water");
            $input["electricity"] = $this->input->post("electricity");
            $input["boundary_wall"] = $this->input->post("boundary_wall");
            $input["exam_hall"] = $this->input->post("exam_hall");
            $input["play_ground"] = $this->input->post("play_ground");
            $input["play_area"] = $this->input->post("play_area");
            $input["canteen"] = $this->input->post("canteen");
            $input["stud_hostel"] = $this->input->post("stud_hostel");
            $input["staff_hostel"] = $this->input->post("staff_hostel");
            $input["transport"] = $this->input->post("transport");
            $input["first_aid"] = $this->input->post("first_aid");
            $input["admi_withdreal_reg"] = $this->input->post("admi_withdreal_reg");
            $input["stu_attend_reg"] = $this->input->post("stu_attend_reg");
            $input["stu_fee_reg"] = $this->input->post("stu_fee_reg");
            $input["tecah_attend_reg"] = $this->input->post("tecah_attend_reg");
            $input["tecah_salary_reg"] = $this->input->post("tecah_salary_reg");
            $input["computer_available"] = $this->input->post("computer_available");
            $input["internet_connection"] = $this->input->post("internet_connection");
            $input["mobile_connectivity"] = $this->input->post("mobile_connectivity");
            $input["mardrasa"] = $this->input->post("mardrasa");
            $input["academy"] = $this->input->post("academy");
            $visit_id = $this->input->post("visit_id");
            $this->db->where("visit_id", $visit_id);
            $input['last_updated'] = date('Y-m-d H:i:s');
            $input['last_updated_by'] = $this->session->userdata("userId");
            if ($this->db->update("visits", $input)) {
                echo "success";
            }
        }
    }
    private function add_form_c_data()
    {
        // foreach ($_POST as $var => $value) {
        //     echo ' $this->form_validation->set_rules("' . $var . '", "' . ucwords(strtolower(str_replace('_', ' ', $var))) . '", "required");<br />';
        // }
        // foreach ($_POST as $var => $value) {
        //     echo '$input["' . $var . '"] = $this->input->post("' . $var . '");<br />';
        // }

        // exit();
        $this->form_validation->set_rules("visit_id", "Visit Id", "required");
        $this->form_validation->set_rules("form", "Form", "required");
        $this->form_validation->set_rules("male_staff_rooms", "Male Staff Rooms", "required");
        $this->form_validation->set_rules("female_staff_rooms", "Female Staff Rooms", "required");
        $this->form_validation->set_rules("principal_office", "Principal Office", "required");
        $this->form_validation->set_rules("account_office", "Account Office", "required");
        $this->form_validation->set_rules("reception", "Reception", "required");
        $this->form_validation->set_rules("waiting_area", "Waiting Area", "required");
        $this->form_validation->set_rules("male_washrooms", "Male Washrooms", "required");
        $this->form_validation->set_rules("female_washrooms", "Female Washrooms", "required");
        $this->form_validation->set_rules("non_teaching_male_staff", "Non Teaching Male Staff", "required");
        $this->form_validation->set_rules("non_teaching_female_staff", "Non Teaching Female Staff", "required");
        $this->form_validation->set_rules("teaching_male_staff", "Teaching Male Staff", "required");
        $this->form_validation->set_rules("teaching_female_staff", "Teaching Female Staff", "required");

        if ($this->input->post("high_level_lab")) {
            $this->form_validation->set_rules("high_level_lab", "High Level Lab", "required");
            if ($this->input->post("high_level_lab") == 'Yes') {
                $this->form_validation->set_rules("high_level_lab_equipment", "High Level Lab Equipment", "required");
            }
        }
        if ($this->input->post("physics_lab")) {
            $this->form_validation->set_rules("physics_lab", "Physics Lab", "required");
            if ($this->input->post("physics_lab") == 'Yes') {
                $this->form_validation->set_rules("physics_lab_equipment", "Physics Lab Equipment", "required");
            }
        }
        if ($this->input->post("biology_lab")) {
            $this->form_validation->set_rules("biology_lab", "Biology Lab", "required");
            if ($this->input->post("biology_lab") == 'Yes') {
                $this->form_validation->set_rules("biology_lab_equipment", "Biology Lab Equipment", "required");
            }
        }
        if ($this->input->post("chemistry_lab")) {
            $this->form_validation->set_rules("chemistry_lab", "Chemistry Lab", "required");
            if ($this->input->post("chemistry_lab") == 'Yes') {
                $this->form_validation->set_rules("chemistry_lab_equipment", "Chemistry Lab Equipment", "required");
            }
        }
        $this->form_validation->set_rules("computer_lab", "Computer Lab", "required");
        if ($this->input->post("computer_lab") == 'Yes') {
            $this->form_validation->set_rules("total_working_computers", "Total Working Computers", "required");
            $this->form_validation->set_rules("total_not_working_computers", "Total Not Working Computers", "required");
        }
        $this->form_validation->set_rules("library", "Library", "required");
        if ($this->input->post("library") == 'Yes') {
            $this->form_validation->set_rules("library_books", "Library Books", "required");
        }



        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $input["c"] = 1;
            $input["visit_id"] = $this->input->post("visit_id");
            $input["male_staff_rooms"] = $this->input->post("male_staff_rooms");
            $input["female_staff_rooms"] = $this->input->post("female_staff_rooms");
            $input["principal_office"] = $this->input->post("principal_office");
            $input["account_office"] = $this->input->post("account_office");
            $input["reception"] = $this->input->post("reception");
            $input["waiting_area"] = $this->input->post("waiting_area");
            $input["male_washrooms"] = $this->input->post("male_washrooms");
            $input["female_washrooms"] = $this->input->post("female_washrooms");
            $input["non_teaching_male_staff"] = $this->input->post("non_teaching_male_staff");
            $input["non_teaching_female_staff"] = $this->input->post("non_teaching_female_staff");
            $input["teaching_male_staff"] = $this->input->post("teaching_male_staff");
            $input["teaching_female_staff"] = $this->input->post("teaching_female_staff");
            $input["high_level_lab"] = $this->input->post("high_level_lab");
            if ($this->input->post("high_level_lab") == 'Yes') {
                $input["high_level_lab_equipment"] = $this->input->post("high_level_lab_equipment");
            } else {
                $input["high_level_lab_equipment"] = NULL;
            }
            $input["physics_lab"] = $this->input->post("physics_lab");
            if ($this->input->post("physics_lab") == 'Yes') {
                $input["physics_lab_equipment"] = $this->input->post("physics_lab_equipment");
            } else {
                $input["physics_lab_equipment"] = NULL;
            }
            $input["biology_lab"] = $this->input->post("biology_lab");
            if ($this->input->post("biology_lab") == 'Yes') {
                $input["biology_lab_equipment"] = $this->input->post("biology_lab_equipment");
            } else {
                $input["biology_lab_equipment"] = NULL;
            }

            $input["chemistry_lab"] = $this->input->post("chemistry_lab");
            if ($this->input->post("chemistry_lab") == 'Yes') {
                $input["chemistry_lab_equipment"] = $this->input->post("chemistry_lab_equipment");
            } else {
                $input["chemistry_lab_equipment"] = NULL;
            }
            $input["computer_lab"] = $this->input->post("computer_lab");
            if ($this->input->post("computer_lab") == 'Yes') {
                $input["total_working_computers"] = $this->input->post("total_working_computers");
                $input["total_not_working_computers"] = $this->input->post("total_not_working_computers");
            } else {
                $input["total_working_computers"] = NULL;
                $input["total_not_working_computers"] = NULL;
            }


            $input["library"] = $this->input->post("library");
            if ($this->input->post("library") == 'Yes') {
                $input["library_books"] = $this->input->post("library_books");
            } else {
                $input["library_books"] = NULL;
            }

            $visit_id = $this->input->post("visit_id");
            $this->db->where("visit_id", $visit_id);
            $input['last_updated'] = date('Y-m-d H:i:s');
            $input['last_updated_by'] = $this->session->userdata("userId");
            if ($this->db->update("visits", $input)) {
                echo "success";
            }
        }
    }

    private function add_form_d_data()
    {

        $visit_id = (int) $this->input->post('visit_id');
        $schools_id = (int) $this->input->post('schools_id');
        $school_id = (int) $this->input->post('school_id');

        $this->form_validation->set_rules("avg_class_rooms_size", "Avg Class Rooms Size", "required");
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {

            $this->db->where("visit_id", $visit_id);
            $_rooms_size['avg_class_rooms_size'] = $this->input->post('avg_class_rooms_size');
            $_rooms_size['d'] = 1;
            $this->db->update("visits", $_rooms_size);
        }


        $query = "DELETE FROM visit_details 
        WHERE visit_id ='" . $visit_id . "'
        AND school_id ='" . $school_id . "' 
        AND schools_id ='" . $schools_id . "'";
        $this->db->query($query);

        $classes = $this->input->post('classes');
        foreach ($classes as $class_id => $value) {
            $input['visit_id'] = (int) $visit_id;
            $input['class_id'] = (int) $class_id;
            $input['schools_id'] = $schools_id;
            $input['school_id'] = $school_id;
            $input['rooms'] = $value['rooms'];
            $input['boys'] = $value['boys'];
            $input['girls'] = $value['girls'];
            $input['max_fee'] = $value['max_fee'];
            $this->db->insert('visit_details', $input);
        }

        echo "success";
    }

    private function add_form_e_data()
    {
        // foreach ($_POST as $var => $value) {
        //     echo '$input["' . $var . '"] = $this->input->post("' . $var . '");<br />';
        // }

        // exit();

        $input["securityStatus"] = $this->input->post("securityStatus");
        $input["securityProvided"] = $this->input->post("securityProvided");
        $input["security_personnel_status_id"] = $this->input->post("security_personnel_status_id");
        $input["securityPersonnel"] = $this->input->post("securityPersonnel");
        $input["security_according_to_police_dept"] = $this->input->post("security_according_to_police_dept");
        $input["cameraInstallation"] = $this->input->post("cameraInstallation");
        $input["camraNumber"] = $this->input->post("camraNumber");
        $input["dvrMaintained"] = $this->input->post("dvrMaintained");
        $input["cameraOnline"] = $this->input->post("cameraOnline");
        $input["emergencyDoorsNumber"] = $this->input->post("emergencyDoorsNumber");
        $input["exitDoorsNumber"] = $this->input->post("exitDoorsNumber");
        $input["boundryWallHeight"] = $this->input->post("boundryWallHeight");
        $input["wiresProvided"] = $this->input->post("wiresProvided");
        $input["watchTower"] = $this->input->post("watchTower");
        $input["licensedWeapon"] = $this->input->post("licensedWeapon");
        $input["license_issued_by_id"] = $this->input->post("license_issued_by_id");
        $input["licenseNumber"] = $this->input->post("licenseNumber");
        $input["ammunitionStatus"] = $this->input->post("ammunitionStatus");
        $input["metalDetector"] = $this->input->post("metalDetector");
        $input["walkThroughGate"] = $this->input->post("walkThroughGate");
        $input["gateBarrier"] = $this->input->post("gateBarrier");

        $visit_id = (int) $this->input->post('visit_id');
        $this->db->where("visit_id", $visit_id);
        $form['e'] = 1;
        $this->db->update("visits", $form);
        $schools_id = (int) $this->input->post('schools_id');
        $school_id = (int) $this->input->post('school_id');
        $this->db->where('school_id', $school_id);
        //$this->db->delete('security_measures');
        $this->db->update('security_measures', $input);
        $affected_row = $this->db->affected_rows();
        echo 'success';
    }
    private function add_form_f_data()
    {
        // foreach ($_POST as $var => $value) {
        //     echo '$input["' . $var . '"] = $this->input->post("' . $var . '");<br />';
        // }

        // exit();

        $input["exposedToFlood"] = $this->input->post("exposedToFlood");
        $input["drowning"] = $this->input->post("drowning");
        $input["buildingCondition"] = $this->input->post("buildingCondition");
        $input["accessRoute"] = $this->input->post("accessRoute");
        $input["adjacentBuilding"] = $this->input->post("adjacentBuilding");
        $input["safeAssemblyPointsAvailable"] = $this->input->post("safeAssemblyPointsAvailable");
        $input["disasterTraining"] = $this->input->post("disasterTraining");
        $input["schoolImprovementPlan"] = $this->input->post("schoolImprovementPlan");
        $input["schoolDisasterManagementPlan"] = $this->input->post("schoolDisasterManagementPlan");
        $input["electrification_condition_id"] = $this->input->post("electrification_condition_id");
        $input["ventilationSystemAvailable"] = $this->input->post("ventilationSystemAvailable");
        $input["chemicalsSchoolLaboratory"] = $this->input->post("chemicalsSchoolLaboratory");
        $input["chemicalsSchoolSurrounding"] = $this->input->post("chemicalsSchoolSurrounding");
        $input["roadAccident"] = $this->input->post("roadAccident");
        $input["safeDrinkingWaterAvailable"] = $this->input->post("safeDrinkingWaterAvailable");
        $input["sanitationFacilities"] = $this->input->post("sanitationFacilities");
        $input["building_structure_id"] = $this->input->post("building_structure_id");
        $input["school_surrounded_by_id"] = $this->input->post("school_surrounded_by_id");

        $visit_id = (int) $this->input->post('visit_id');
        $visit_id = (int) $this->input->post('visit_id');
        $this->db->where("visit_id", $visit_id);
        $form['f'] = 1;
        $this->db->update("visits", $form);
        $schools_id = (int) $this->input->post('schools_id');
        $school_id = (int) $this->input->post('school_id');
        $this->db->where('school_id', $school_id);
        $this->db->update('hazards_with_associated_risks', $input);
        $affected_row = $this->db->affected_rows();

        $this->db->where('school_id', $school_id);
        $this->db->delete('hazards_with_associated_risks_unsafe_list');

        if ($this->input->post("accessRoute") == 'Unsafe') {
            $unSafeLists = $this->input->post('unSafeList');
            foreach ($unSafeLists as $index => $unsafe_list_id) {
                $unsafe_list['school_id'] = $school_id;
                $unsafe_list['unsafe_list_id'] = $unsafe_list_id;
                $this->db->insert('hazards_with_associated_risks_unsafe_list', $unsafe_list);
            }
        }

        echo 'success';
    }
    private function add_form_g_data()
    {

        $visit_id = (int) $this->input->post('visit_id');
        $this->db->where("visit_id", $visit_id);
        $form['g'] = 1;
        $this->db->update("visits", $form);

        echo 'success';
    }
    private function add_form_h_data()
    {

        $this->form_validation->set_rules("agree", "Agree Check Box", "required");
        $this->form_validation->set_rules("visited_by_officers", "Visited By Officers", "required");
        $this->form_validation->set_rules("visited_by_officials", "Visited By Officials", "required");
        $this->form_validation->set_rules("visit_date", "Visit Date", "required");
        $this->form_validation->set_rules("recommendation", "Recommendation", "required");
        if ($this->input->post("recommendation") == 'Recommended') {
            //$this->form_validation->set_rules("r_primary_l", "R Primary L", "required");
            if (!$this->input->post("r_primary_l") and !$this->input->post("r_middle_l") and !$this->input->post("r_high_l") and !$this->input->post("r_high_sec_l")) {
                $this->form_validation->set_rules("r_primary_l", "level is required", "required");
            }
        }
        if ($this->input->post("recommendation") == 'Not Recommended') {
            $this->form_validation->set_rules("not_recommendation_remarks", "Not Recommendation Remarks", "required");
        }
        // $this->form_validation->set_rules("other_remarks", "Other Remarks", "required");
        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $input["visit_id"] = $this->input->post("visit_id");
            $input["h"] = 1;
            $input["visited"] = 'Yes';
            $input['visit_status'] = 'Visited';
            $input['visit_end'] = date('Y-m-d H:i:s');
            $input["schools_id"] = $this->input->post("schools_id");
            $input["school_id"] = $this->input->post("school_id");
            $input["visited_by_officers"] = $this->input->post("visited_by_officers");
            $input["visited_by_officials"] = $this->input->post("visited_by_officials");
            $input["visit_date"] = $this->input->post("visit_date");
            $input["recommendation"] = $this->input->post("recommendation");

            $input["report_location_latitude"] = $this->input->post("report_location_latitude");
            $input["report_location_longitude"] = $this->input->post("report_location_longitude");
            $input["report_location_altitude"] = $this->input->post("report_location_altitude");
            $input["device"] = $_SERVER['HTTP_USER_AGENT'];

            $input['report_submitted_by'] = $this->session->userdata("userId");
            $input['report_submitted_date'] = date('Y-m-d H:i:s');

            if ($this->input->post("r_primary_l")) {
                $input["r_primary_l"] = $this->input->post("r_primary_l");
            } else {
                $input["r_primary_l"] = 0;
            }
            if ($this->input->post("r_middle_l")) {
                $input["r_middle_l"] = $this->input->post("r_middle_l");
            } else {
                $input["r_middle_l"] = 0;
            }
            if ($this->input->post("r_high_l")) {
                $input["r_high_l"] = $this->input->post("r_high_l");
            } else {
                $input["r_high_l"] = 0;
            }
            if ($this->input->post("r_high_sec_l")) {
                $input["r_high_sec_l"] = $this->input->post("r_high_sec_l");
            } else {
                $input["r_high_sec_l"] = 0;
            }
            if ($this->input->post("r_academy_l")) {
                $input["r_academy_l"] = $this->input->post("r_academy_l");
            } else {
                $input["r_academy_l"] = 0;
            }

            $input["not_recommendation_remarks"] = $this->input->post("not_recommendation_remarks");
            $input["other_remarks"] = $this->input->post("other_remarks");
            $visit_id = $this->input->post("visit_id");
            $this->db->where("visit_id", $visit_id);
            $input['last_updated'] = date('Y-m-d H:i:s');
            $input['last_updated_by'] = $this->session->userdata("userId");
            if ($this->db->update("visits", $input)) {
                echo "success";
            }
        }

        // foreach ($_POST as $var => $value) {
        //     echo ' $this->form_validation->set_rules("' . $var . '", "' . ucwords(strtolower(str_replace('_', ' ', $var))) . '", "required");<br />';
        // }
        // foreach ($_POST as $var => $value) {
        //     echo '$input["' . $var . '"] = $this->input->post("' . $var . '");<br />';
        // }

        // exit();
        // $visit_id = (int) $this->input->post('visit_id');
        // $this->db->where("visit_id", $visit_id);
        // $form['g'] = 1;
        // $this->db->update("visits", $form);

        // echo 'success';
    }


    public function upload_picture_file($picture_file)
    {
        if (isset($_FILES[$picture_file]) && !empty($_FILES[$picture_file]['name'])) {
            $config = [];
            $school_id = (int) $this->input->post('school_id');
            $visit_id = (int) $this->input->post('visit_id');
            $dir = '/uploads/visits/' . $school_id . "/" . $visit_id;
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . $dir;
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);  //create directory if not exist
            }

            $this->load->library('upload', $config);

            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'gif|jpeg|jpg|png';
            $config['max_size'] = 0;
            $file_name = 'PSRA-' . date('Y-m-d') . "-" . time() . "-" . $visit_id . "-" . $school_id;
            $config['file_name'] = $file_name;
            $this->upload->initialize($config);

            if ($this->upload->do_upload($picture_file)) {
                $image_data = $this->upload->data();
                $uploaded_file = $dir . '/' . $image_data['file_name'];

                $this->db->where("visit_id", $visit_id);
                $input[$picture_file] = $uploaded_file;
                if ($this->db->update("visits", $input)) {
                    echo "success";
                } else {
                    echo 'Error While insert into database.';
                }
            } else {
                echo $this->upload->display_errors();
            }
        } else {
            echo 'File not found.';
        }
    }



    public function add_visit_report()
    {
        $form = $this->input->post('form');
        switch ($form) {
            case 'a':
                $this->add_form_a_data();
                break;
            case 'b':
                $this->add_form_b_data();
                break;
            case 'c':
                $this->add_form_c_data();
                break;
            case 'd':
                $this->add_form_d_data();
                break;
            case 'e':
                $this->add_form_e_data();
                break;
            case 'f':
                $this->add_form_f_data();
                break;
            case 'g':
                $this->add_form_g_data();
                break;
            case 'h':
                $this->add_form_h_data();
                break;
            case 'picture_file':
                $field_name = '0';
                if (in_array('picture_1', array_keys($_FILES))) {
                    $input['visit_start'] = date('Y-m-d H:i:s');
                    $field_name = 'picture_1';
                    $input["latitude"] = $this->input->post("latitude");
                    $input["longitude"] = $this->input->post("longitude");
                    $input["altitude"] = $this->input->post("altitude");
                    $input["precision"] = $this->input->post("precision");
                    $visit_id = (int) $this->input->post("visit_id");
                    $this->db->where("visit_id", $visit_id);
                    $input['last_updated'] = date('Y-m-d H:i:s');
                    $input['last_updated_by'] = $this->session->userdata("userId");
                    $this->db->update("visits", $input);
                }
                if (in_array('high_lab_image', array_keys($_FILES))) {
                    $field_name = 'high_lab_image';
                }
                if (in_array('physics_lab_image', array_keys($_FILES))) {
                    $field_name = 'physics_lab_image';
                }
                if (in_array('biology_lab_image', array_keys($_FILES))) {
                    $field_name = 'biology_lab_image';
                }
                if (in_array('chemistry_lab_image', array_keys($_FILES))) {
                    $field_name = 'chemistry_lab_image';
                }

                if ($field_name == '0') {
                    echo 'File Name Required';
                    exit();
                }
                $this->upload_picture_file($field_name);
                break;
            default:
                echo 'Form Not Set.';
        }
        exit();

        $this->form_validation->set_rules("visited_by_officers", "Visited By Officers", "required");
        $this->form_validation->set_rules("visited_by_officials", "Visited By Officials", "required");
        $this->form_validation->set_rules("visit_date", "Visit Date", "required");
        $this->form_validation->set_rules("recommendation", "Recommendation", "required");
        $this->form_validation->set_rules("remarks", "Remarks", "required");
        $this->form_validation->set_rules("latitude", "Latitude", "required");
        $this->form_validation->set_rules("longitude", "Longitude", "required");
        $this->form_validation->set_rules("altitude", "Altitude", "required");
        $this->form_validation->set_rules("precision", "Precision", "required");
        $this->form_validation->set_rules("non_teaching_male_staff", "Non Teaching Male Staffs", "required");
        $this->form_validation->set_rules("non_teaching_female_staff", "Non Teaching Female Staffs", "required");
        $this->form_validation->set_rules("teaching_male_staff", "Teaching Male Staffs", "required");
        $this->form_validation->set_rules("teaching_female_staff", "Teaching Female Staffs", "required");
        $this->form_validation->set_rules("total_class_rooms", "Total Class Rooms", "required");
        $this->form_validation->set_rules("male_staff_rooms", "Male Staff Rooms", "required");
        $this->form_validation->set_rules("female_staff_rooms", "Female Staff Rooms", "required");
        $this->form_validation->set_rules("principal_office", "Principal Office", "required");
        $this->form_validation->set_rules("account_office", "Account Office", "required");
        $this->form_validation->set_rules("reception_waiting_area", "Reception Waiting Area", "required");
        $this->form_validation->set_rules("male_washrooms", "Male Washrooms", "required");
        $this->form_validation->set_rules("female_washrooms", "Female Washrooms", "required");
        $this->form_validation->set_rules("high_level_lab", "High Level Lab", "required");
        if ($this->input->post("high_level_lab") == 'Yes') {
            $this->form_validation->set_rules("high_level_lab_equipment", "High Level Lab Equipment", "required");
        }
        $this->form_validation->set_rules("physics_lab", "Physics Lab", "required");
        if ($this->input->post("physics_lab") == 'Yes') {
            $this->form_validation->set_rules("physics_lab_equipment", "Physics Lab Equipment", "required");
        }
        $this->form_validation->set_rules("biology_lab", "Biology Lab", "required");
        if ($this->input->post("biology_lab") == 'Yes') {
            $this->form_validation->set_rules("biology_lab_equipment", "Biology Lab Equipment", "required");
        }
        $this->form_validation->set_rules("chemistry_lab", "Chemistry Lab", "required");
        if ($this->input->post("chemistry_lab") == 'Yes') {
            $this->form_validation->set_rules("chemistry_lab_equipment", "Chemistry Lab Equipment", "required");
        }
        $this->form_validation->set_rules("computer_lab", "Computer Lab", "required");
        if ($this->input->post("computer_lab") == 'Yes') {
            $this->form_validation->set_rules("total_working_computers", "Total Working Computers", "required");
            $this->form_validation->set_rules("total_non_working_computers", "Total Non Working Computers", "required");
        }
        $this->form_validation->set_rules("library", "Library", "required");
        if ($this->input->post("library") == 'Yes') {
            $this->form_validation->set_rules("library_books", "Library Books", "required");
        }
        $this->form_validation->set_rules("avg_class_rooms_size", "Avg Class Rooms Size", "required");
        $this->form_validation->set_rules("total_male_students", "Total Male Students", "required");
        $this->form_validation->set_rules("total_female_students", "Total Female Students", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_inputs();
            $inputs->created_by = $this->session->userdata("userId");
            $visit_id = (int) $this->input->post("visit_id");
            if ($visit_id == 0) {
                $this->db->insert("visits", $inputs);
            } else {
                $this->db->where("visit_id", $visit_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $inputs->last_updated_by = $this->session->userdata("userId");
                $this->db->update("visits", $inputs);
            }
            echo "success";
        }
    }

    public function school_detail($institute_id)
    {
        $institute_id = (int) $institute_id;
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
        $query .= " WHERE `schools`.`schoolId` = '" . $institute_id . " '";
        $this->data['school'] = $this->db->query($query)->row();

        $this->load->view('visits/school_detail', $this->data);
    }
    public function get_visit_form()
    {
        $visit_id = (int) $this->input->post("visit_id");
        if ($visit_id == 0) {

            $input = $this->get_inputs();
            $input->high_level_lab = 'No';
        } else {
            $query = "SELECT * FROM 
            visits 
            WHERE visit_id = $visit_id";
            $input = $this->db->query($query)->row();
            if ($input->high_level_lab == NULL) {
                $input->high_level_lab = 'No';
            }
            if ($input->physics_lab == NULL) {
                $input->physics_lab = 'No';
            }
            if ($input->chemistry_lab == NULL) {
                $input->chemistry_lab = 'No';
            }
            if ($input->biology_lab == NULL) {
                $input->biology_lab = 'No';
            }

            if ($input->computer_lab == NULL) {
                $input->computer_lab = 'No';
            }
            if ($input->library == NULL) {
                $input->library = 'No';
            }
        }

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
        $query .= " WHERE `schools`.`schoolId` = '" . $input->schools_id . " '";
        $this->data['school'] = $this->db->query($query)->row();

        $query = "SELECT session_year.sessionYearTitle, reg_type.regTypeTitle,
        school_type.typeTitle
        FROM school 
        INNER JOIN session_year ON(session_year.sessionYearId = school.session_year_id)
        INNER JOIN reg_type ON(reg_type.regTypeId = school.reg_type_id)
        INNER JOIN school_type ON(school_type.typeId = school.school_type_id)
        WHERE schools_id = '" . $input->schools_id . "' 
        AND schoolId = '" . $input->school_id . "'";
        $this->data['session'] = $this->db->query($query)->row();

        $this->data["input"] = $input;
        $this->load->view("visits/get_visit_form", $this->data);
    }
    public function get_add_to_visit_list_form()
    {

        $visit_id = (int) $this->input->post("visit_id");
        if ($visit_id == 0) {
            $input["visit_id"] =  $visit_id;
            $input["schools_id"] = NULL;
            $input["school_id"] = NULL;
            $input["visit_reason"] = NULL;
            $input["primary_l"] = 0;
            $input["middle_l"] = 0;
            $input["high_l"] = 0;
            $input["high_sec_l"] = 0;
            $input["academy_l"] = 0;

            $input =  (object) $input;
        } else {
            $query = "SELECT * FROM 
            visits 
            WHERE visit_id = $visit_id";
            $input = $this->db->query($query)->row();
        }

        $this->data["input"] = $input;
        $this->load->view("visits/get_add_to_visit_list_form", $this->data);
    }

    public function add_to_visit_list()
    {
        $this->form_validation->set_rules("schools_id", "Schools Id", "required");
        $this->form_validation->set_rules("school_id", "School Id", "required");
        $this->form_validation->set_rules("visit_reason", "Visit Reason", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {


            $input["visit_id"] = $this->input->post("visit_id");
            $input["schools_id"] = $this->input->post("schools_id");
            $input["school_id"] = $this->input->post("school_id");
            $input["visit_reason"] = $this->input->post("visit_reason");
            $input["primary_l"] = $this->input->post("primary_l");
            $input["middle_l"] = $this->input->post("middle_l");
            $input["high_l"] = $this->input->post("high_l");
            $input["high_sec_l"] = $this->input->post("high_sec_l");
            $input["academy_l"] = $this->input->post("academy_l");
            $input["visited"] = 'No';
            $inputs =  (object) $input;

            $inputs->created_by = $this->session->userdata("userId");
            $visit_id = (int) $this->input->post("visit_id");
            if ($visit_id == 0) {
                $this->db->insert("visits", $inputs);
            } else {
                $this->db->where("visit_id", $visit_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $inputs->last_updated_by = $this->session->userdata("userId");
                $this->db->update("visits", $inputs);
            }
            echo "success";
        }
    }

    private function get_inputs()
    {
        $input["visit_id"] = $this->input->post("visit_id");
        $input["visited"] = 'Yes';
        $input["visited_by_officers"] = $this->input->post("visited_by_officers");
        $input["visited_by_officials"] = $this->input->post("visited_by_officials");
        $input["visit_date"] = $this->input->post("visit_date");
        $input["recommendation"] = $this->input->post("recommendation");
        $input["remarks"] = $this->input->post("remarks");
        $input["latitude"] = $this->input->post("latitude");
        $input["longitude"] = $this->input->post("longitude");
        $input["altitude"] = $this->input->post("altitude");
        $input["precision"] = $this->input->post("precision");
        $input["non_teaching_male_staff"] = $this->input->post("non_teaching_male_staff");
        $input["non_teaching_female_staff"] = $this->input->post("non_teaching_female_staff");
        $input["teaching_male_staff"] = $this->input->post("teaching_male_staff");
        $input["teaching_female_staff"] = $this->input->post("teaching_female_staff");
        $input["total_class_rooms"] = $this->input->post("total_class_rooms");
        $input["male_staff_rooms"] = $this->input->post("male_staff_rooms");
        $input["female_staff_rooms"] = $this->input->post("female_staff_rooms");
        $input["principal_office"] = $this->input->post("principal_office");
        $input["account_office"] = $this->input->post("account_office");
        $input["reception_waiting_area"] = $this->input->post("reception_waiting_area");
        $input["male_washrooms"] = $this->input->post("male_washrooms");
        $input["female_washrooms"] = $this->input->post("female_washrooms");
        $input["high_level_lab"] = $this->input->post("high_level_lab");
        if ($this->input->post("high_level_lab") == 'Yes') {
            $input["high_level_lab_equipment"] = $this->input->post("high_level_lab_equipment");
        } else {
            $input["high_level_lab_equipment"] = NULL;
        }
        $input["physics_lab"] = $this->input->post("physics_lab");
        if ($this->input->post("physics_lab") == 'Yes') {
            $input["physics_lab_equipment"] = $this->input->post("physics_lab_equipment");
        } else {
            $input["physics_lab_equipment"] = NULL;
        }
        $input["biology_lab"] = $this->input->post("biology_lab");
        if ($this->input->post("biology_lab") == 'Yes') {
            $input["biology_lab_equipment"] = $this->input->post("biology_lab_equipment");
        } else {
            $input["biology_lab_equipment"] = NULL;
        }

        $input["chemistry_lab"] = $this->input->post("chemistry_lab");
        if ($this->input->post("chemistry_lab") == 'Yes') {
            $input["chemistry_lab_equipment"] = $this->input->post("chemistry_lab_equipment");
        } else {
            $input["chemistry_lab_equipment"] = NULL;
        }
        $input["computer_lab"] = $this->input->post("computer_lab");
        if ($this->input->post("computer_lab") == 'Yes') {
            $input["total_working_computers"] = $this->input->post("total_working_computers");
            $input["total_non_working_computers"] = $this->input->post("total_non_working_computers");
        } else {
            $input["total_working_computers"] = NULL;
            $input["total_non_working_computers"] = NULL;
        }


        $input["library"] = $this->input->post("library");
        if ($this->input->post("library") == 'Yes') {
            $input["library_books"] = $this->input->post("library_books");
        } else {
            $input["library_books"] = NULL;
        }
        $input["avg_class_rooms_size"] = $this->input->post("avg_class_rooms_size");
        $input["total_male_students"] = $this->input->post("total_male_students");
        $input["total_female_students"] = $this->input->post("total_female_students");
        $inputs =  (object) $input;
        return $inputs;
    }

    public function delete_visit($visit_id)
    {
        $visit_id = (int) $visit_id;
        $this->db->where("visit_id", $visit_id);
        $update['is_deleted'] = 1;
        $this->db->update('visits', $update);
        //$this->db->delete("visits");
        $requested_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url();
        redirect($requested_url);
    }


    public function add_visit()
    {

        $this->form_validation->set_rules("visited_by_officers", "Visited By Officers", "required");
        $this->form_validation->set_rules("visited_by_officials", "Visited By Officials", "required");
        $this->form_validation->set_rules("visit_date", "Visit Date", "required");
        $this->form_validation->set_rules("recommendation", "Recommendation", "required");
        $this->form_validation->set_rules("remarks", "Remarks", "required");
        $this->form_validation->set_rules("latitude", "Latitude", "required");
        $this->form_validation->set_rules("longitude", "Longitude", "required");
        $this->form_validation->set_rules("altitude", "Altitude", "required");
        $this->form_validation->set_rules("precision", "Precision", "required");
        $this->form_validation->set_rules("non_teaching_male_staff", "Non Teaching Male Staffs", "required");
        $this->form_validation->set_rules("non_teaching_female_staff", "Non Teaching Female Staffs", "required");
        $this->form_validation->set_rules("teaching_male_staff", "Teaching Male Staffs", "required");
        $this->form_validation->set_rules("teaching_female_staff", "Teaching Female Staffs", "required");
        $this->form_validation->set_rules("total_class_rooms", "Total Class Rooms", "required");
        $this->form_validation->set_rules("male_staff_rooms", "Male Staff Rooms", "required");
        $this->form_validation->set_rules("female_staff_rooms", "Female Staff Rooms", "required");
        $this->form_validation->set_rules("principal_office", "Principal Office", "required");
        $this->form_validation->set_rules("account_office", "Account Office", "required");
        $this->form_validation->set_rules("reception_waiting_area", "Reception Waiting Area", "required");
        $this->form_validation->set_rules("male_washrooms", "Male Washrooms", "required");
        $this->form_validation->set_rules("female_washrooms", "Female Washrooms", "required");
        $this->form_validation->set_rules("high_level_lab", "High Level Lab", "required");
        if ($this->input->post("high_level_lab") == 'Yes') {
            $this->form_validation->set_rules("high_level_lab_equipment", "High Level Lab Equipment", "required");
        }
        $this->form_validation->set_rules("physics_lab", "Physics Lab", "required");
        if ($this->input->post("physics_lab") == 'Yes') {
            $this->form_validation->set_rules("physics_lab_equipment", "Physics Lab Equipment", "required");
        }
        $this->form_validation->set_rules("biology_lab", "Biology Lab", "required");
        if ($this->input->post("biology_lab") == 'Yes') {
            $this->form_validation->set_rules("biology_lab_equipment", "Biology Lab Equipment", "required");
        }
        $this->form_validation->set_rules("chemistry_lab", "Chemistry Lab", "required");
        if ($this->input->post("chemistry_lab") == 'Yes') {
            $this->form_validation->set_rules("chemistry_lab_equipment", "Chemistry Lab Equipment", "required");
        }
        $this->form_validation->set_rules("computer_lab", "Computer Lab", "required");
        if ($this->input->post("computer_lab") == 'Yes') {
            $this->form_validation->set_rules("total_working_computers", "Total Working Computers", "required");
            $this->form_validation->set_rules("total_non_working_computers", "Total Non Working Computers", "required");
        }
        $this->form_validation->set_rules("library", "Library", "required");
        if ($this->input->post("library") == 'Yes') {
            $this->form_validation->set_rules("library_books", "Library Books", "required");
        }
        $this->form_validation->set_rules("avg_class_rooms_size", "Avg Class Rooms Size", "required");
        $this->form_validation->set_rules("total_male_students", "Total Male Students", "required");
        $this->form_validation->set_rules("total_female_students", "Total Female Students", "required");

        if ($this->form_validation->run() == FALSE) {
            echo '<div class="alert alert-danger">' . validation_errors() . "</div>";
            exit();
        } else {
            $inputs = $this->get_inputs();
            $inputs->created_by = $this->session->userdata("userId");
            $visit_id = (int) $this->input->post("visit_id");
            if ($visit_id == 0) {
                $this->db->insert("visits", $inputs);
            } else {
                $this->db->where("visit_id", $visit_id);
                $inputs->last_updated = date('Y-m-d H:i:s');
                $inputs->last_updated_by = $this->session->userdata("userId");
                $this->db->update("visits", $inputs);
            }
            echo "success";
        }
    }

    public function print_visit_report($visit_id, $schools_id, $school_id)
    {

        $this->data['visit_id'] = $visit_id = (int) $visit_id;
        $this->data['schools_id'] = $schools_id = (int) $schools_id;
        $this->data['school_id'] = $school_id = (int) $school_id;
        $this->data['form'] = $form = $form;

        if ($visit_id == 0) {
            $input = $this->get_inputs();
            $input->high_level_lab = 'No';
        } else {
            $query = "SELECT * FROM 
            visits 
            WHERE visit_id = $visit_id";
            $input = $this->db->query($query)->row();
            // if ($input->high_level_lab == NULL) {
            //     $input->high_level_lab = 'No';
            // }
            // if ($input->physics_lab == NULL) {
            //     $input->physics_lab = 'No';
            // }
            // if ($input->chemistry_lab == NULL) {
            //     $input->chemistry_lab = 'No';
            // }
            // if ($input->biology_lab == NULL) {
            //     $input->biology_lab = 'No';
            // }

            // if ($input->computer_lab == NULL) {
            //     $input->computer_lab = 'No';
            // }
            // if ($input->library == NULL) {
            //     $input->library = 'No';
            // }
        }



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
        $query .= " WHERE `schools`.`schoolId` = '" . $input->schools_id . " '";
        $this->data['school'] = $this->db->query($query)->row();

        $query = "SELECT session_year.sessionYearTitle, reg_type.regTypeTitle,
        school_type.typeTitle
        FROM school 
        INNER JOIN session_year ON(session_year.sessionYearId = school.session_year_id)
        INNER JOIN reg_type ON(reg_type.regTypeId = school.reg_type_id)
        INNER JOIN school_type ON(school_type.typeId = school.school_type_id)
        WHERE schools_id = '" . $input->schools_id . "' 
        AND schoolId = '" . $input->school_id . "'";
        $this->data['session'] = $this->db->query($query)->row();


        $this->data['school_security_measures'] = $this->school_m->security_measures_by_school_id($school_id);

        $this->data['school_hazards_with_associated_risks'] = $this->school_m->hazards_with_associated_risks_by_school_id($school_id);
        $this->data['hazards_with_associated_risks_unsafe_list'] = $this->school_m->hazards_with_associated_risks_unsafe_list_by_school_id($school_id);



        $this->data["input"] = $input;
        if ($input->visited == 'Yes') {
            $this->load->view('visits/print_visit_report', $this->data);
        } else {
            'Not Visited Yet';
        }

        //$this->load->view('visits/institute_visit_report', $this->data);
        //$this->load->view('visits/visit_form/' . $form, $this->data);
    }
}
