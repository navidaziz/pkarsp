<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Admin_Controller
{

    /**
     * constructor method
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model("user_model");
        //$this->lang->load("users", 'english');
        //$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------


    /**
     * Default action to be called
     */
    public function index()
    {

        $this->data['title']  = "Sign Up";
        $this->load->view("register/signup_form", $this->data);
    }

    public function is_unique_email()
    {
        $email_address = $this->input->post('email_address');
        $check = $this->db->get_where('users', array('userEmail' => $email_address), 1);

        if ($check->num_rows() > 0) {

            $this->form_validation->set_message('is_unique_email', 'The email address "' . $email_address . '" is already registered with PSRA. Try with differnt email address.');

            return FALSE;
        }

        return TRUE;
    }

    public function check_user_name()
    {
        $user_name = $this->input->post('userName');
        if (preg_match('/^\S.*\s.*\S$/', $user_name)) {
            $this->form_validation->set_message('check_user_name', 'User Name contain space. Spaces are not allowed.');
            return FALSE;
        }

        return TRUE;
    }
    public function check_password()
    {
        $userPassword = $this->input->post('userPassword');
        if (preg_match('/^\S.*\s.*\S$/', $userPassword)) {
            $this->form_validation->set_message('check_password', 'Password contain space. Spaces are not allowed.');
            return FALSE;
        }

        return TRUE;
    }

    public function signup()
    {

        // var_dump($_POST);
        // $this->form_validation->set_message('is_unique_email', 'The email address is already registered with PSRA. Try with differnt email address.');
        $this->form_validation->set_message('is_unique', 'User Name is already registered with PSRA.');

        $validation_config = array(

            array(
                "field"  =>  "userName",
                "label"  =>  "User Name",
                //"rules"  =>  "trim|required|min_length[6]|is_unique[users.userName]"
                "rules"  =>  "trim|required|min_length[6]|callback_check_user_name|is_unique[users.userName]"
            ),
            array(
                "field"  =>  "userPassword",
                "label"  =>  "User Password",
                "rules"  =>  "trim|required|min_length[6]|callback_check_password|matches[c_userPassword]"
            ),
            array(
                "field"  =>  "c_userPassword",
                "label"  =>  "Confirm Passowrd",
                "rules"  =>  "trim|required|min_length[6]"
            ),
            array(
                "field"  =>  "email_address",
                "label"  =>  "email_address",
                //"rules"  =>  "trim|required|email|is_unique_email|is_unique[users.userEmail]"
                "rules"  =>  "required|callback_is_unique_email"
            )

        );

        $this->load->database();

        //set and run the validation
        $this->form_validation->set_rules($validation_config);

        if ($this->form_validation->run() === TRUE) {
            $inputs = array();

            $inputs["role_id"]  = 15;
            $inputs["userName"]  = $this->input->post('userName');
            $inputs["userPassword"]  = $this->input->post('userPassword');
            $inputs["userEmail"]  = $this->input->post('email_address');
            $inputs["createdDate"]  =  date('Y-m-d H:i:s');
            $inputs["userStatus"]  =  1;

            if ($this->user_model->save($inputs)) {
                $this->session->set_flashdata("msg_success", "You account has been created successfully with the username and password you entered. please login using your username and password.<br />آپ کا اکاؤنٹ آپ کے درج کردہ یو ز نیم اور پاس ورڈ کے ساتھ کامیابی کے ساتھ بن گیا ہے۔ براہ کرم اپنا یو ز نیم اور پاس ورڈ استعمال کرکے لاگ ان کریں۔");
                redirect("login");
            } else {
                $this->session->set_flashdata("msg_error", "Error In Registration Please Try Again.");
                redirect("register/");
            }
        } else {
            $this->index();
        }
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
        $this->data["view"] = "users/view_user";
        $this->load->view("layout", $this->data);
    }
    //-----------------------------------------------------

    /**
     * get a list of all trashed items
     */
    public function trashed()
    {

        $where = "`users`.`status` IN (2) ";
        $data = $this->user_model->get_user_list($where);
        $this->data["users"] = $data->users;
        $this->data["pagination"] = $data->pagination;
        $this->data["title"] = $this->lang->line('Trashed Users');
        $this->data["view"] = "users/trashed_users";
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

    /**
     * function to restor user from trash
     * @param $user_id integer
     */
    public function restore($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;


        $this->user_model->changeStatus($user_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect("users/trashed/" . $page_id);
    }
    //---------------------------------------------------------------------------

    /**
     * function to draft user from trash
     * @param $user_id integer
     */
    public function draft($user_id, $page_id = NULL)
    {

        $user_id = (int) $user_id;


        $this->user_model->changeStatus($user_id, "0");
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


        $this->user_model->changeStatus($user_id, "1");
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
        //$this->user_model->changeStatus($user_id, "3");
        //Remove file....
        $users = $this->user_model->get_user($user_id);
        $file_path = $users[0]->user_image;
        $this->user_model->delete_file($file_path);
        $this->user_model->delete(array('user_id' => $user_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect("users/trashed/" . $page_id);
    }
    //----------------------------------------------------



    /**
     * function to add new User
     */
    public function add()
    {

        $this->data["roles"] = $this->user_model->getList("roles", "role_id", "role_title", $where = "`role_id` > 1");

        $this->data["title"] = $this->lang->line('Add New User');
        $this->data["view"] = "users/add_user";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------


    public function save_user_data()
    {
        if ($this->user_model->validate_form_data() === TRUE) {

            if ($this->upload_file("user_image")) {
                $_POST['user_image'] = $this->data["upload_data"]["file_name"];
            }

            $user_id = $this->user_model->save_data();
            if ($user_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                echo "success";
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                $this->get_user_add_form();
            }
        } else {
            $this->get_user_add_form();
        }
    }



    public function save_data()
    {
        if ($this->user_model->validate_form_data() === TRUE) {

            if ($this->upload_file("user_image")) {
                $_POST['user_image'] = $this->data["upload_data"]["file_name"];
            }

            $user_id = $this->user_model->save_data();
            if ($user_id) {
                $this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect("users/edit/$user_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("users/add");
            }
        } else {
            $this->add();
        }
    }


    /**
     * function to edit a User
     */
    public function edit($user_id)
    {
        $user_id = (int) $user_id;
        $this->data["user"] = $this->user_model->get($user_id);
        $this->data["roles"] = $this->user_model->getList("roles", "role_id", "role_title", $where = "`role_id` > 1");

        $this->data["title"] = $this->lang->line('Edit User');
        $this->data["view"] = "users/edit_user";
        $this->load->view("layout", $this->data);
    }
    //--------------------------------------------------------------------
    public function get_user_add_form()
    {

        $this->data['restaurant_id'] = $this->input->post('restaurant_id');
        $this->data['role_id'] = 23;
        $this->load->view("users/add_user_form", $this->data);
    }

    public function get_user_edit_form()
    {
        //exit();
        if ($this->input->post('user_id')) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->input->post('id');
        }

        $this->data['restaurant_id'] = $this->input->post('restaurant_id');
        $this->data['role_id'] = 23;
        $this->data["user"] = $this->user_model->get($user_id);
        $this->load->view("users/edit_user_form", $this->data);
    }

    public function update_user_data()
    {

        if ($this->input->post('user_id')) {
            $user_id = $this->input->post('user_id');
        } else {
            $user_id = $this->input->post('id');
        }
        /*	$this->data['restaurant_id'] = (int) $this->input->post('restaurant_id');
		  $this->data['role_id'] = (int) $this->input->post('role_id');*/
        if ($this->user_model->validate_form_data($user_id) === TRUE) {

            if ($this->upload_file("user_image")) {
                $_POST["user_image"] = $this->data["upload_data"]["file_name"];
            }

            $user_id = $this->user_model->update_data($user_id);
            if ($user_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                echo "success";
                exit();
            } else {
                $_POST['id'] = $user_id;
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                $this->get_user_edit_form();
            }
        } else {

            $this->get_user_edit_form();
        }
    }


    public function update_data($user_id)
    {

        $user_id = (int) $user_id;

        if ($this->user_model->validate_form_data($user_id) === TRUE) {

            if ($this->upload_file("user_image")) {
                $_POST["user_image"] = $this->data["upload_data"]["file_name"];
            }

            $user_id = $this->user_model->update_data($user_id);
            if ($user_id) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect("users/edit/$user_id");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("users/edit/$user_id");
            }
        } else {
            $this->edit($user_id);
        }
    }


    /**
     * logout a user
     */
    public function logout()
    {
        //remove the card .....
        $this->user_m->logout();
        redirect("users/login");
    }
    //-----------------------------------------------------

    /**
     * function to login a user
     */
    public function login()
    {

        //$this->data['captcha'] = $this->captcha(); 
        //check if the user is already logedin
        if ($this->user_m->loggedIn() == TRUE) {
            redirect("users/view");
        }

        //load other models
        $this->load->model("role_m");
        $this->load->model("module_m");

        $validations = array(
            /*array(
                'field' =>  'user_email',
                'label' =>  'Email Address',
                'rules' =>  'valid_email|required'
            ),
            */
            array(
                'field' =>  'user_password',
                'label' =>  'Password',
                'rules' =>  'required'
            )
        );
        $this->form_validation->set_rules($validations);
        if ($this->form_validation->run() === TRUE) {

            $input_values = array(
                'user_name' => $this->input->post("user_email"),
                'user_password' => $this->input->post("user_password")

            );

            //get the user
            $user = $this->user_m->getBy($input_values, TRUE);
            //var_dump($user);
            //exit;

            if (count($user) > 0 and $user->role_id != 2 and $user->role_id != 24 and $user->role_id != 23) {

                //
                $role_homepage_id = $this->role_m->getCol("role_homepage", $user->role_id);
                $role_homepage_parent_id = $this->module_m->getCol("parent_id", $role_homepage_id);

                //now create homepage path
                $homepage_path = "";
                if ($role_homepage_parent_id != 0) {
                    $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_parent_id) . "/";
                }
                $homepage_path .= $this->module_m->getCol("module_uri", $role_homepage_id);

                $fields = "roles.*";
                $join  = array();
                $where = "roles.role_id = $user->role_id";
                $role = $roles = $this->role_m->joinGet($fields, "roles", $join, $where);

                //get user projects  by role id



                $user_data = array(
                    "user_id"  => $user->user_id,
                    "user_email" => $user->user_email,
                    "user_title" => $user->user_title,
                    "role_id" => $user->role_id,
                    "role_level" =>  $role[0]->role_level,
                    "district_id" => '',
                    "role_homepage_id" => $role_homepage_id,
                    "role_homepage_uri" => $homepage_path,
                    "ngo_id" => '',
                    "user_image" => $user->user_image,
                    "user_unique_id" => md5(uniqid(rand(), TRUE)),
                    "logged_in" => TRUE
                );


                //add to session
                $this->session->set_userdata($user_data);
                //var_dump($this->session->userdata);
                //exit;
                $this->session->set_flashdata('msg_success', "<strong>" . $user->user_title . '</strong><br/><i>welcome to admin panel</i>');
                redirect($homepage_path);
            } else {
                $this->session->set_flashdata('msg', 'User Name or Password is incorrect or Your Are not Allowed to login');
                redirect("users/login");
            }
        } else {

            $this->data['title'] = "Login to dashboard";
            $this->load->view("users/login", $this->data);
        }
    }


    public function update_profile()
    {

        $user_id = (int) $this->session->userdata('user_id');
        $this->data["user"] = $this->user_model->get($user_id);


        $validation_config = array(
            array(
                "field"  =>  "user_email",
                "label"  =>  "User Email",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "user_password",
                "label"  =>  "User Password",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "user_mobile_number",
                "label"  =>  "Mobile Number",
                "rules"  =>  "required"
            ),


        );


        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if ($this->form_validation->run() === TRUE) {


            $config = array(
                "upload_path" => "./assets/uploads/" . $this->router->fetch_class() . "/",
                "allowed_types" => "jpg|jpeg|bmp|png|gif",
                "max_size" => 10000,
                "max_width" => 0,
                "max_height" => 0,
                "remove_spaces" => true,
                "encrypt_name" => true
            );
            if (!$this->upload_file("user_image", $config)) {
                //var_dump($this->data["upload_error"]);
            } else {
                //var_dump($this->data["upload_data"]);
                $user_image = $this->data["upload_data"]["file_name"];
            }


            $inputs = array();



            $inputs["user_email"]  =  $this->input->post("user_email");

            $inputs["user_password"]  =  $this->input->post("user_password");

            $inputs["user_mobile_number"]  =  $this->input->post("user_mobile_number");



            if ($_FILES["user_image"]["size"] > 0) {
                $inputs["user_image"]  =  $this->router->fetch_class() . "/" . $user_image;
            }


            if ($this->user_model->save($inputs, $user_id)) {

                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect("users/update_profile");
            } else {

                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect("users/update_profile");
            }
        }

        $this->data["title"] = $this->lang->line('Update Profile');
        $this->data["view"] = "users/update_profile";
        $this->load->view("layout", $this->data);
    }



    function confirmEmail($hashcode)
    {
        //  echo $hashcode;  die;
        if ($this->user_model->verifyEmail($hashcode) === true) {
            $this->session->set_flashdata('msg_success', 'Email address has been confirmed. Please login to the system');
            redirect("login");
        } else {
            $this->session->set_flashdata('msg_error', 'Email address has not been confirmed. Please try to re-register');
            redirect("login");
        }
    }

    public function password_reset()
    {

        $this->data['title']  = "Sign Up";
        $this->load->view("password_recovery/recover_password_form", $this->data);
    }
    public function password_reset_submit()
    {

        // $user_id = (int) $this->session->userdata('user_id');
        //  $this->data["user"] = $this->user_model->get($user_id);


        $validation_config = array(
            array(
                "field"  =>  "user_email",
                "label"  =>  "User Email",
                "rules"  =>  "required|valid_email|callback_email_exists"
            ),



        );
        //	print_r($_POST); die;

        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        if ($this->form_validation->run() === TRUE) {



            $inputs = array();
            $inputs["user_email"]  =  $user_email = strtolower(trim($this->input->post("user_email")));

            $user = $this->user_model->get_user_by_email($user_email);

            if ($user) {
                $verification_code = $user->verification_code;
                $user_name = $user->userName;
                $password = $user->userPassword;


                $subject = 'Reset your Password';



                $message2 = 'Your Account User Name: <strong> ' . $user_password . ' </strong>';
                $message2 = 'Your Account Password: ' . $user_name . '</strong>
                
                ';
                $send_email = $this->user_model->sendEmail($user_email, $subject, $message2);
                if ($send_email === false) {
                    $this->session->set_flashdata("msg_error", " Error sending Email make sure your email address is correct please !");
                    redirect("login");
                    exit();
                }
                $this->session->set_flashdata("msg_success", " Your password has been sent to your email address:  $user_email");
                redirect("login");
            }
        }
        $this->data['title']  = "Reset Password";
        $this->load->view("password_recovery/recover_password_form", $this->data);
    }


    public function email_exists($email)
    {
        //$this->load->model('user_model');

        if ($this->user_model->get_user_by_email($email)) {
            return true;
        } else {
            $this->form_validation->set_message('email_exists', 'We couldn\'t find that email address in our system.');
            return false;
        }
    }
    function checkSpam($email)
    {
        $this->load->library('genuinemail');
        $check = $this->genuinemail->check($email);
        if ($check === TRUE) return true;
        return false;
    }
}
