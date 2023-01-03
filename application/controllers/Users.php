<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("admin/user_model");
        $this->lang->load("users", 'english');
        $this->lang->load("system", 'english');
        $this->load->helper('my_functions_helper');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {
        //redirect( $this->session->userdata('role_homepage_uri'));
        $main_page = base_url() .  $this->router->fetch_class() . "/view";
        redirect($main_page);
    }

    public function view()
    {
        $query = "SELECT * FROM roles WHERE role_id !=15";
        $roles = $this->db->query($query)->result();
        foreach ($roles as $role) {
            $where = "`users`.`userStatus` IN (0, 1) and users.role_id ='" . $role->role_id . "'";
            $role->users = $this->user_model->get_user_list($where, false);
        }

        $this->data["roles"] = $roles;
        // $this->data["users"] = $data->users;
        // $this->data["pagination"] = $data->pagination;
        $this->data["title"] = "User Management";
        $this->data["view"] =  "users/users";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get single record by id
     */
    public function view_user($user_id)
    {

        $user_id = (int) $user_id;

        $this->data["users"] = $this->user_model->get_user($user_id);
        $this->data["title"] = $this->lang->line('User Details');
        $this->data["view"] =  "users/view_user";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`users`.`userStatus` IN (2) ";
        $data = $this->user_model->get_user_list($where);
        $this->data["users"] = $data->users;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Users');
        $this->data["view"] =  "users/trashed_users";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * function to send a user to trash
     */
    public function trash($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;


        $this->user_model->changeStatus($user_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect("users/view/" . $page_id);
    }


    public function draft($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;


        $query = "UPDATE users SET userStatus=0 WHERE userId = '" . $user_id . "'";
        $this->db->query($query);
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect("users/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to publish user from trash
     * @param $user_id integer
     */
    public function publish($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;

        $query = "UPDATE users SET userStatus=1 WHERE userId = '" . $user_id . "'";
        $this->db->query($query);

        // $this->user_model->changeStatus($user_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect("users/view/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to permanently delete a User
     * @param $user_id integer
     */
    public function delete($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;
        $this->user_model->changeStatus($user_id, "3");
        //Remove file....
        //$users = $this->user_model->get_user($user_id);
        //$file_path = $users[0]->user_image;
        //$this->user_model->delete_file($file_path);
        // $this->user_model->delete(array('userId' => $user_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect("users/view/" . $page_id);
    }
}
