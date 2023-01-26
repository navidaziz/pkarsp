<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_account extends Admin_Controller
{

	public function change_password()
	{
		$this->data['title'] = 'Change Account Password';
		$this->data['description'] = 'Change Account Password';
		$this->data['view'] = 'user_account/change_password';
		$this->load->view('layout', $this->data);
	}

	public function submit_changed_password()
	{
		$validation_config = array(

			array(
				"field"  =>  "old_password",
				"label"  =>  "Old Password",
				"rules"  =>  "trim|required"
			),
			array(
				"field"  =>  "new_password",
				"label"  =>  "New Password",
				"rules"  =>  "trim|required|min_length[6]|matches[re_new_password]"
			),
			array(
				"field"  =>  "re_new_password",
				"label"  =>  "Repeat New Password",
				"rules"  =>  "trim|required|min_length[6]"
			)

		);

		//set and run the validation
		$this->form_validation->set_rules($validation_config);

		if ($this->form_validation->run() === TRUE) {
			$old_password = $this->db->escape($this->input->post('old_password'));
			$user_id = $userId = $this->session->userdata('userId');
			$query = "SELECT COUNT(*) as total FROM users 
			        WHERE `users`.`userPassword` = " . $old_password . " 
			        AND `users`.`userId` = '" . $user_id . "'";
			if ($this->db->query($query)->result()[0]->total) {
				$input['userPassword'] = $this->input->post('new_password');
				$this->db->where('userId', $user_id);
				if ($this->db->update('users', $input)) {
					$this->session->set_flashdata("msg_success", "Account Password Changed Successfully.");
					redirect("user_account/change_password");
				} else {
					$this->session->set_flashdata("msg_error", "Error While Updating Account Password");
					redirect("user_account/change_password");
				}
			} else {
				$this->session->set_flashdata("msg_error", "Your Current Password is not correct.");
				redirect("user_account/change_password");
			}
		} else {
			$this->change_password();
		}
	}

	public function change_user_name()
	{
		$this->data['title'] = 'Change Account User Name';
		$this->data['description'] = 'Change User Name';
		$this->data['view'] = 'user_account/change_user_name';
		$this->load->view('layout', $this->data);
	}

	public function submit_changed_user_name()
	{
		$this->form_validation->set_message('is_unique_user_name', 'User Name is already registered.');

		$validation_config = array(
			array(
				"field"  =>  "user_name",
				"label"  =>  "User Name",
				"rules"  =>  "trim|required"
			),
			array(
				"field"  =>  "password",
				"label"  =>  "Password",
				"rules"  =>  "trim|required"
			)

		);

		//set and run the validation
		$this->form_validation->set_rules($validation_config);

		if ($this->form_validation->run() === TRUE) {

			//check unique 
			$password = $this->db->escape($this->input->post('password'));
			$user_id = $userId = $this->session->userdata('userId');
			$user_name = $this->db->escape($this->input->post('user_name'));
			$query = "SELECT count(*) as total FROM users 
			          WHERE users.userName =" . $user_name . "
					  AND `users`.`userId` != '" . $user_id . "'";
			if ($this->db->query($query)->result()[0]->total) {
				$this->session->set_flashdata("msg_error", "User Name you entered already in used. try with different User Name.");
				redirect("user_account/change_user_name");
				exit();
			}



			$query = "SELECT COUNT(*) as total FROM users 
			        WHERE `users`.`userPassword` = " . $password . " 
			        AND `users`.`userId` = '" . $user_id . "'";
			if ($this->db->query($query)->result()[0]->total) {
				$input['userName'] = $this->input->post('user_name');
				$this->db->where('userId', $user_id);
				if ($this->db->update('users', $input)) {
					$this->session->set_flashdata("msg_success", "Account User Name Changed Successfully.");
					redirect("user_account/change_user_name");
				} else {
					$this->session->set_flashdata("msg_error", "Error While Updating Account Password");
					redirect("user_account/change_user_name");
				}
			} else {
				$this->session->set_flashdata("msg_error", "Your Password is not correct.");
				redirect("user_account/change_user_name");
			}
		} else {
			$this->change_user_name();
		}
	}
}
