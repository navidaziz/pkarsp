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
        $this->data['view'] = 'visits/index';
        $this->load->view('layout', $this->data);
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
}
