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
  public function temp_vehicle()
  {
    $input['vehicle_number'] = $this->input->post('vehicle_number');
    $input['vehicle_model_year'] = $this->input->post('vehicle_model_year');
    $input['total_seats'] = $this->input->post('total_seats');
    $input['school_id'] = $school_id = $this->input->post('school_id');
    $this->db->insert('school_vehicles', $input);
    echo '<table class="table">
    <tr>
      <th>S/No</td>
      <th>Vehicle No.</th>
      <th>Model Year</th>
      <th>Total Seats</th>
      <th>Action</th>
    </tr>';
    $query = "SELECT * FROM school_vehicles WHERE school_id = '" . $school_id . "'";
    $school_vehicles = $this->db->query($query)->result();
    if ($school_vehicles) {
      $count = 1;
      foreach ($school_vehicles as $school_vehicle) {
        echo '<tr>
          <td>' . $count++ . '</td>
          <td>' . $school_vehicle->vehical_number . '</td>
          <td>' . $school_vehicle->vehicle_model_year . '</td>
          <td>' . $school_vehicle->total_seats . '</td>
          <td><a href="#" onclick="delete_vehicle_date(' . $school_vehicle->vehicle_id . ')">delete</a></td>
        </tr>';
      }
    }
    echo '</table>';
  }

  function delete_vehicle_data()
  {
    $vehicle_id = (int) $this->input->post('vehicle_id');
    $school_id  = (int) $this->input->post('school_id');
    $this->db->where('vehicle_id', $vehicle_id);
    $this->db->where('school_id', $school_id);
    $this->db->delete('school_vehicles');

    echo '<table class="table">
    <tr>
      <th>S/No</td>
      <th>Vehicle No.</th>
      <th>Model Year</th>
      <th>Total Seats</th>
      <th>Action</th>
    </tr>';
    $query = "SELECT * FROM school_vehicles WHERE school_id = '" . $school_id . "'";
    $school_vehicles = $this->db->query($query)->result();
    if ($school_vehicles) {
      $count = 1;
      foreach ($school_vehicles as $school_vehicle) {
        echo '<tr>
          <td>' . $count++ . '</td>
          <td>' . $school_vehicle->vehical_number . '</td>
          <td>' . $school_vehicle->vehicle_model_year . '</td>
          <td>' . $school_vehicle->total_seats . '</td>
          <td><a href="#" onclick="delete_vehicle_date(' . $school_vehicle->vehicle_id . ')">delete</a></td>
        </tr>';
      }
    }
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
