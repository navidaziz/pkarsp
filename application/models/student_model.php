<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Student_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "students";
        $this->pk = "student_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(

            array(
                "field"  =>  "student_class_no",
                "label"  =>  "Student Class No",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "student_name",
                "label"  =>  "Student Name",
                "rules"  =>  "required"
            ),


            array(
                "field"  =>  "class_id",
                "label"  =>  "Class Id",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "section_id",
                "label"  =>  "Section Id",
                "rules"  =>  "required"
            ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();

        $inputs["student_class_no"]  =  $this->input->post("student_class_no");

        $inputs["student_name"]  =  $this->input->post("student_name");

        $inputs["student_father_name"]  =  $this->input->post("student_father_name");

        $inputs["student_data_of_birth"]  =  $this->input->post("student_data_of_birth");

        $inputs["student_address"]  =  $this->input->post("student_address");

        $inputs["student_admission_no"]  =  $this->input->post("student_admission_no");

        if ($_FILES["student_image"]["size"] > 0) {
            $inputs["student_image"]  =  $this->router->fetch_class() . "/" . $this->input->post("student_image");
        }

        $inputs["class_id"]  =  $this->input->post("class_id");

        $inputs["section_id"]  =  $this->input->post("section_id");

        return $this->student_model->save($inputs);
    }

    public function update_data($student_id, $image_field = NULL)
    {
        $inputs = array();

        $inputs["student_class_no"]  =  $this->input->post("student_class_no");

        $inputs["student_name"]  =  $this->input->post("student_name");

        $inputs["student_father_name"]  =  $this->input->post("student_father_name");

        $inputs["student_data_of_birth"]  =  $this->input->post("student_data_of_birth");

        $inputs["student_address"]  =  $this->input->post("student_address");

        $inputs["student_admission_no"]  =  $this->input->post("student_admission_no");

        if ($_FILES["student_image"]["size"] > 0) {
            //remove previous file....
            $students = $this->get_student($student_id);
            $file_path = $students[0]->student_image;
            $this->delete_file($file_path);
            $inputs["student_image"]  =  $this->router->fetch_class() . "/" . $this->input->post("student_image");
        }

        $inputs["class_id"]  =  $this->input->post("class_id");

        $inputs["section_id"]  =  $this->input->post("section_id");

        return $this->student_model->save($inputs, $student_id);
    }

    //----------------------------------------------------------------
    public function get_student_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array(
            "students.*", "classes.Class_title", "sections.section_title"
        );
        $join_table = array(
            "classes" => "classes.class_id = students.class_id",

            "sections" => "sections.section_id = students.section_id",
        );
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->student_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->student_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->student_model->joinGet($fields, "students", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->students = $this->student_model->joinGet($fields, "students", $join_table, $where);
            return $data;
        } else {
            return $this->student_model->joinGet($fields, "students", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_student($student_id)
    {

        $fields = array(
            "students.*", "classes.Class_title", "sections.section_title"
        );
        $join_table = array(
            "classes" => "classes.class_id = students.class_id",

            "sections" => "sections.section_id = students.section_id",
        );
        $where = "students.student_id = $student_id";

        return $this->student_model->joinGet($fields, "students", $join_table, $where, FALSE, TRUE);
    }
}
