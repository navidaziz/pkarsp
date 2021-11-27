<?php

class Temp_controller extends CI_Controller
{


  public function temp_form()
  {
    $post = $this->input->post();
    $id = $post['school_id'];
    $data = array(
      'late' => $post['late'], 'longitude' => $post['long'], 'address' => $post['address'], 'principal_email' => $post['email'], 'telePhoneNumber' => $post['contact'], 'schoolMobileNumber' => $post['mobile']
    );
    $this->db->where('schoolId', $id);
    $this->db->update('schools', $data);
    $this->session->set_flashdata('msg', 'Data updated successfully!');
    redirect("school/create_form");
  }

  public function temp_covid()
  {
    $post = $this->input->post();
    $this->db->insert('covid_data', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }

  public function temp_student_covid()
  {
    $post = $this->input->post();
    $this->db->insert('covid_student_data', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }

  public function add_mr_vaccinated_report()
  {
    $post = $this->input->post();
    $this->db->insert('mr_vaccinated', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }
}
