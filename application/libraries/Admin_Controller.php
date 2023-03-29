<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Admin_Controller extends MY_Controller
{

    public $controller_name = "";
    public $method_name = "";


    public function __construct()
    {

        parent::__construct();

        $this->load->helper("my_functions");
        $this->load->model("mr_m");
        $this->load->model("module_m");
        $this->data['controller_name'] = $this->controller_name = $this->router->fetch_class();
        $this->data['method_name'] = $this->method_name = $this->router->fetch_method();
        $this->data['menu_arr'] = $this->mr_m->roleMenu($this->session->userdata("role_id"));

        // $this->load->model("system_global_setting_model");
        // $system_global_setting_id = 1;
        // $fields = $fields = array("sytem_admin_logo", "system_title", "system_sub_title", "sytem_public_logo");
        // $join_table = $join_table = array();
        // $where = "system_global_setting_id = $system_global_setting_id";
        // $this->data["system_global_settings"] = $this->system_global_setting_model->joinGet($fields, "system_global_settings", $join_table, $where, false, true);



        if ($this->session->userdata('role_id') == 15) {
            $user_id = $this->session->userdata('userId');
            $query = "  SELECT * FROM `schools` where owner_id=$user_id";

            $query = $this->db->query($query);
            if ($query->row()) {
                $school_info = $query->row();
                $school_name = str_replace("'", "", $school_info->schoolName);

                $query1 = "SELECT message_for_all.*,`message_school`.`school_id` FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where (`message_school`.`school_id`=$school_info->schoolId AND 
                     `message_for_all`.`select_all`='no')
                     OR  (`message_for_all`.`district_id` in($school_info->district_id,0) AND  `message_for_all`.`level_id` in($school_info->level_of_school_id,0) 
                      AND 
                     `message_for_all`.`select_all`='yes' AND  LOCATE(`message_for_all`.`like_text`,'" . $school_name . "')> 0)
                     order by `message_for_all`.`message_id` DESC";
                $query1 = $this->db->query($query1);
                // print_r($this->db->last_query()) ;exit;
                // var_dump($query1->result());exit;


                $this->data['inbox_messages'] = count($query1->result());
            } else {
                $this->data['inbox_messages'] = 0;
            }
        } else {
            $this->data['inbox_messages'] = 0;
        }

        // var_dump($this->session);
        // exit();
        //login check
        $exception_uri = array(
            "user/login",
            "user/logout",
            "login",
            "login/logout",
            "login/validate_user",
            "register/signup",
            "register/index",
            "register/password_reset",
            "register/password_reset_submit"
        );
        if (!in_array(uri_string(), $exception_uri)) {
            //check if the user is logged in or not
            if (!$this->session->userdata('userId') && empty($this->session->userdata('userId'))) {
                // echo "problem is here too many redirections here...";
                // exit(); 
                $is_ajax = 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
                if ($is_ajax) {
                    echo '<div class="alert alert-danger">';
                    echo 'Please log in again as your session has expired.';
                    echo '<span style="margin-left:20px;"></span><a href="' . site_url('login') . '"> Login again</a>';
                    echo '</div>';
                    exit();
                } else {
                    redirect("login");
                }
            }

            //now we will check if the current module is assigned to the user or not
            $this->data['current_action_id'] = $current_action_id = $this->module_m->actionIdFromName($this->controller_name, $this->method_name);

            $allowed_modules = $this->mr_m->rightsByRole($this->session->userdata("role_id"));

            //add role homepage to allowed modules
            $allowed_modules[] = $this->session->userdata("role_homepage_id");

            if (!in_array($current_action_id, $allowed_modules)) {
                $is_ajax = 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
                if ($is_ajax) {
                    echo '<div class="alert alert-danger">
                    <strong>Error!</strong> You are not allowed to access this module.
                    ' . $this->controller_name . ' - ' . $this->method_name . '
                </div>
                ';
                    exit();
                } else {
                    $this->session->set_flashdata('msg_error', 'You are not allowed to access this module');
                    // redirect($_SERVER['HTTP_REFERER']);
                    // session_destroy();
                    //redirect($this->session->userdata("role_homepage_uri"));
                    $module = $this->controller_name . '-' . $this->method_name;
                    redirect(site_url("errors/index?module=$module"));
                }
            }
        }
    }
}
