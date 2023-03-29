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

        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

        $secret = '6Leuqa4ZAAAAACHxncAMn6I8ULX2Rf3R6hT7NhjP';

        $credential = array(
            'secret' => $secret,
            'response' => $this->input->post('g-recaptcha-response')
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);

        $status = json_decode($response, true);

        if ($status['success'] != 1) {
            $this->session->set_flashdata('msg', 'Captcha error, Please try again.');
            redirect("register/signup");
        }

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

            $inputs["role_id"]  = 35;
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
}
