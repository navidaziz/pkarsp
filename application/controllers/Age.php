<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Age extends Admin_Controller {
  
  public function __construct(){

parent::__construct();
$this->load->model("age_m");
  }
  public function index(){

$this->data['Age_list'] = $this->age_m->get();
$this->data['title'] = 'age';
    $this->data['description'] = 'info about age';
    $this->data['view'] = 'age/age';
    $this->load->view('layout', $this->data);
  }
  public function create_form(){
    $this->data['title'] = 'age';
    $this->data['description'] = 'info about age';
    $this->data['view'] = 'age/create';
    $this->load->view('layout', $this->data);
  }
  public function create_process($id = null){

//validation configuration
$validation_config = array(
array(
'field' =>  'ageTitle',
'label' =>  'Age Title',
'rules' =>  'trim|required'
)
);
$post_data = $this->input->post();
//var_dump($post_data);exit;
// unset($posts['text_password']);
$this->form_validation->set_rules($validation_config);
if($this->form_validation->run() === TRUE){
if($id == null){
$msg = "New Age has been created successfully";
$type = "msg_success";
$insert_id = $this->age_m->save($post_data);
}else{
$type = "msg";
$msg =  "Age has been updated successfully";
$insert_id = $this->age_m->save($post_data, $id);
}

if($insert_id){
$this->session->set_flashdata($type, $msg);
redirect('age');
}else{
$this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
redirect('age/create_form');
}
}else{
if($id == null){
$this->create_form();
}else{
$this->session->set_flashdata('msg_error', "Something's wrong, Please try again.");
$path = "age/edit/".$id;
redirect($path);
}

}
  }
/**
* edit a district
* @param $district id integer
*/
public function edit($id){
$id = (int) $id;
$this->data['age'] = $this->age_m->get($id);
$this->data['title'] = 'Age';
$this->data['description'] = 'here you can edit and save the changes on fly.';
$this->data['view'] = 'age/edit';
$this->load->view('layout', $this->data);
}
public function delete($id){
$id = (int) $id;
$where = array('complainTypeId' => $id );
$result = $this->age_m->delete($where);
if($result){
$this->session->set_flashdata('msg_success', "complain Type successfully deleted.");
redirect('complain_type');
}else{
$this->session->set_flashdata('msg_error', "Something's wrong, Please try later");
redirect('complain_type');
}
}
  
}