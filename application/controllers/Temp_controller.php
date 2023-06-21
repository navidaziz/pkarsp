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


  public function add_mr_vaccinated_report()
  {
    $post = $this->input->post();
    $this->db->insert('mr_vaccinated', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }

  public function temp_covid()
  {
    $post = $this->input->post();
    $this->db->insert('covid_data', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }

  public function save_minority_students()
  {
    $school_id = (int) $this->input->post("schoolId");
    $query = "SELECT COUNT(*) as total FROM `minority_students` WHERE school_id='" . $school_id . "'";
    $minority_entry = $this->db->query($query)->result()[0]->total;
    if ($minority_entry == 0) {
      $post = $this->input->post();
      $this->db->insert('minority_students', $post);
      $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    } else {
      $this->session->set_flashdata('msg', 'Data Already Added!');
    }

    redirect("school/create_form");
  }
  public function temp_student_covid()
  {
    $post = $this->input->post();
    $this->db->insert('covid_student_data', $post);
    $this->session->set_flashdata('msg', 'Data uploaded successfully!');
    redirect("school/create_form");
  }

  public function temp_vehicle()
  {
    $input['vehicle_number'] = $this->input->post('vehicle_number');
    $input['vehicle_model_year'] = $this->input->post('vehicle_model_year');
    $input['total_seats'] = $this->input->post('total_seats');

    $input['type_of_vehicle'] = $this->input->post('type_of_vehicle');
    $input['expiry_of_fit_certificate'] = $this->input->post('expiry_of_fit_certificate');

    $input['school_id'] = $school_id = $this->input->post('school_id');
    $this->db->insert('school_vehicles', $input);
    echo '<table class="table">
    <tr>
      <th>S/No</td>
      <th>Vehicle No.</th>
      <th>Model Year</th>
      <th>Type of Vehicle</th>
      <th>Date of expiry of last fitness Certificate</th>
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
          <td>' . $school_vehicle->type_of_vehicle . '</td><td>';
        if ($school_vehicle->expiry_of_fit_certificate != '0000-00-00') {
          echo date('d M, Y', strtotime($school_vehicle->expiry_of_fit_certificate));
        }

        echo '</td>
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
          <td>' . $school_vehicle->type_of_vehicle . '</td><td>';
        if ($school_vehicle->expiry_of_fit_certificate != '0000-00-00') {
          echo date('d M, Y', strtotime($school_vehicle->expiry_of_fit_certificate));
        }

        echo '</td>
          <td>' . $school_vehicle->total_seats . '</td>
          <td><a href="#" onclick="delete_vehicle_date(' . $school_vehicle->vehicle_id . ')">delete</a></td>
        </tr>';
      }
    }
  }

  public function check_student_slc()
  {
    $student_slc_code = $this->input->post("student_slc_code");
    if ($student_slc_code == '') {
      echo '<p style="color:red; text-align:center;">Please Enter Student SLC Code.<p>';
      exit();
    }
    $student_slc_code = $this->db->escape($student_slc_code);
    $query = "SELECT slc.*, schools.schoolId as school_id,
    `schools`.`registrationNumber`,
    `schools`.`schoolName`
    FROM student_leaving_certificates as slc 
     INNER JOIN schools ON (schools.schoolId = slc.school_id )
     WHERE `slc`.`slc_code` = $student_slc_code";
    $student_slc = $this->db->query($query)->row();
    if ($student_slc) {
      echo '<h4>School Leaving Certificate Detail</h4>
      
      <table class="table table-bordered">
      <tr>
      <th>SLC Info</th>
      <th>Student Info</th>
      <th>SLC Issued By</th>
      
      
      </tr>
      <tr>
      <td> SLC Code: <strong>' . $student_slc->slc_code . '</strong>
      <br />
      School Leaving Date: <strong>' . date('d M, Y', strtotime($student_slc->school_leaving_date)) . '</strong> <br />
      Issue Date: <strong>' . date('d M, Y', strtotime($student_slc->slc_issue_date)) . '</strong>
      </td>
      <td>
      Name: <strong>' . $student_slc->student_name . '</strong>
      <br />
      Father Name: <strong>' . $student_slc->father_name . '</strong>
      <br />
      Gender: <strong>' . $student_slc->gender . '</strong>
      <br />
      DOB: <strong>' . date('d M, Y', strtotime($student_slc->student_data_of_birth)) . '</strong>
      </td>
      <td>School Name: <strong>' . $student_slc->schoolName . '</strong>
      <br />
      Registration No: <strong>' . $student_slc->registrationNumber . '</strong>
      </td>
      
      <tr>
      </table>
<table class="table table-bordered">
<tr>
<th>Admission Info</th>
<th>Student Class info </th>
<th>Others</th>
</tr>
<tr>
<td>
      Addmission No: <strong>' . $student_slc->admission_no . ' </strong><br />
      Addmission Date: <strong>' . date('d M, Y', strtotime($student_slc->admission_date)) . ' </strong><br />
      </td>
      <td>
      Read in class: <strong>' . $student_slc->current_class . '</strong> <br />
      Promote to class: <strong>' . $student_slc->promoted_to_class . '</strong> <br />
      </td>

      <td>
      Acadmic Record: <strong>' . $student_slc->academic_record . '</strong> <br />
      Character & Conduct: <strong>' . $student_slc->character_and_conduct . '</strong> <br />
      </td>
      </tr>
      </table>';
    } else {
      echo '<p style="color:red; text-align:center;">The Student\'s School Leaving Certificate could not be found. Please retry with a valid SLC code.</p>';
    }
  }


  public function check_school_registration()
  {

    $registration_no = $this->input->post("registration_no");
    if ($registration_no == '') {
      echo '<p style="color:red; text-align:center;">Please Enter School Registration Number.<p>';
      exit();
    }
    $registration_no = $this->db->escape($registration_no);
    $query = "SELECT  `schools`.`schoolId` AS `schools_id`
					, `schools`.`registrationNumber`
					, `schools`.`schoolName`
					, `schools`.`yearOfEstiblishment`
					, `schools`.`school_type_id`
					, `schools`.`level_of_school_id`
					, `schools`.`gender_type_id`
					, (IF(district.region=1,'Central', IF(district.region=2, 'South', IF(district.region=3, 'Malakand', IF(district.region=4, 'Hazara', 'Other'))))) as division
					, `district`.`districtTitle` 
					, `tehsils`.`tehsilTitle`
					, (SELECT `uc`.`ucTitle` FROM `uc` WHERE `uc`.`ucId` = `schools`.`uc_id`) as `ucTitle`,
					`schools`.`telePhoneNumber` as phone_no,
					`schools`.`schoolMobileNumber` as mobile_no,
					(SELECT `users`.`contactNumber` FROM users WHERE users.userId = schools.owner_id) as owner_no,
					schools.address
				FROM
					`schools`
					INNER JOIN `district` ON(`district`.`districtId` = `schools`.`district_id`)
					INNER JOIN `tehsils` ON( `tehsils`.`tehsilId` = `schools`.`tehsil_id`) ";
    $query .= " WHERE (`schools`.`registrationNumber` = " . $registration_no . " 
    OR `schools`.`schoolId` = " . $registration_no . " )";
    $school = $this->db->query($query)->row();
    if ($school) {
      echo '<table class="table table-bordered">
        <tr>
        <th>Registration No</th>
        <th>School ID</th>
        <th>School Name</th>
        <th>Address</th>
        </tr>
    <tr>
    <td>';

      if ($school->registrationNumber) {
        echo $school->registrationNumber;
      } else {
        echo 'Not Registered';
      }

      echo '</td>
     <td>' . $school->schools_id . '</td>
      <td>' . $school->schoolName . '</td>
      <td> <small>';

      if ($school->districtTitle) {
        echo "District: <strong>" . $school->districtTitle . "</strong>";
      }
      if ($school->tehsilTitle) {
        echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
      }
      if ($school->ucTitle) {
        echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
      }
      if ($school->ucTitle) {
        echo " / <strong>" . $school->address . "</strong>";
      }
      echo '</small>
      </td>
        </tr>
        </table>
            ';
?>
      <h5>Last registration / renewal certificate issued</h5>
      <table class="table table-bordered " style="font-size: 12px;">
        <tr>
          <th>#</h>
          <th>Session</th>
          <th>Registration / Renewals</th>
          <th>School Level</th>
          <!--<th>Max Tuition Fee</th>-->
          <!--<th>Total Students</th>-->
          <!--<th>Teaching Staffs</th>-->
          <!--<th>Non Teaching Staffs</th>-->
          <th>Certificate Issued</th>

        </tr>
        <?php

        $query = "SELECT
                          `reg_type`.`regTypeTitle`,
                          `levelofinstitute`.`levelofInstituteTitle`,
                          `session_year`.`sessionYearTitle`,
                          `session_year`.`sessionYearId`,
                          `school`.`renewal_code`,
                          `school`.`status`,
                          `school`.`created_date`,
                          `school`.`updatedBy`,
                          `school`.`updatedDate`,
                          `school`.`schoolId`,
                          `school`.`visit_list`,
                          `school`.`visit_type`,
                          `school`.`visit_entry_date`,
                          `school`.`cer_issue_date`,
                          school.pending_type,
                          school.pending_date,
                          school.pending_reason,
                          school.dairy_type,
                          school.dairy_no,
                          school.dairy_date
                          FROM
                          `school`,
                          `reg_type`,
                          `gender`,

                          `levelofinstitute`,
                          `session_year`
                          WHERE `reg_type`.`regTypeId` = `school`.`reg_type_id`
                          AND `gender`.`genderId` = `school`.`gender_type_id`

                          AND `levelofinstitute`.`levelofInstituteId` = `school`.`level_of_school_id`
                          AND `session_year`.`sessionYearId` = `school`.`session_year_id`
                          AND schools_id = " . $school->schools_id . "
                          AND school.status = 1
                          ORDER BY `session_year`.`sessionYearId` DESC LIMIT 1";
        $school_sessions = $last_session = $this->db->query($query)->result();

        $query = "select max(sessionYearId) as sessionYearId from session_year";
        $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;


        if ($school_sessions) {
          $count = 1;
          foreach ($school_sessions as $school_session) { ?>

            <tr>
              <td><?php echo $count++; ?></td>
              <td>
                <strong> <?php echo $school_session->sessionYearTitle; ?> </strong>
              </td>
              <td>
                <?php echo $school_session->regTypeTitle; ?>
              <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>



              <td>
                <?php
                if ($school_session->cer_issue_date) {
                  echo date('d M, Y', strtotime($school_session->cer_issue_date));
                } else {
                  echo '<small></small>';
                }
                ?></td>

            </tr>
            <?php //if ($school_session->sessionYearId == $current_session_id) {
            ?>

            <?php  //}
            ?>
          <?php
            $previous_max = $max_tuition_fee;
          }
        } else { ?>
          <tr>
            <td colspan="12">
              Not applied for registartion.
            </td>
          </tr>
        <?php } ?>

      </table>
    <?php

    } else {
      echo '<p style="color:red; text-align:center;">School Registration Number Not Found.<p>';
      exit();
    }
  }

  public function get_notifications()
  {
    $query =
      "SELECT * FROM message_for_all where`message_for_all`.`select_all`='yes' and status=1 
      order by `message_for_all`.`message_id` DESC LIMIT 30";
    $query_result = $this->db->query($query);
    $notifications = $query_result->result();
    foreach ($notifications as $message) { ?>
      <div class="bs-callout bs-callout-danger">
        <!--<a  style="" href="#">-->
        <?php echo ucwords(strtolower($message->subject)); ?>
        <small><i class="fa fa-clock-o" aria-hidden="true" style="color:black !important;"></i>
          <?php echo date("d M, Y", strtotime($message->created_date)); ?>
          <?php
          $query = "SELECT * FROM `message_for_all_attachment` WHERE `message_for_all_attachment`.`message_id` ='" . $message->message_id . "'";
          $message_attachments = $this->db->query($query)->result();
          if ($message_attachments) {
            foreach ($message_attachments as $message_attachment) {
              if ($message_attachment->folder) {
                $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
                $attachment_url = $root . "uploads/" . $message_attachment->folder . "/";
              } else {
                $attachment_url = 'http://psra.gkp.pk/schoolReg/assets/images/';
              }
          ?>
              <a style="margin-left:5px;" target="new" href="<?php echo $attachment_url . $message_attachment->attachment_name; ?>">Download</a>
            <?php
            }
          } else { ?>
            <?php //echo $message->discription; 
            ?>
          <?php }  ?>
        </small>
        <!--</a>-->
      </div>
      <hr />
    <?php  } ?>
<?php
  }


  public function get_registered_schools()
  {
    $query = "SELECT COUNT(*) as total_reg,
            SUM(IF(r.school_level=1,1,0)) as total_primary,
            SUM(IF(r.school_level=2,1,0)) as total_middle,
            SUM(IF(r.school_level=3,1,0)) as total_high,
            SUM(IF(r.school_level=4,1,0)) as total_high_sec
            FROM `registered_schools_with_emis_code` as r";
    $registered_schools = $this->db->query($query)->row();
    echo json_encode($registered_schools);
  }

  public function add_enrollement()
  {
    $schools_id = (int) $this->input->post('schools_id');
    $session_id = (int) $this->input->post('session_id');
    $school_enrollment = (int) $this->input->post('school_enrollment');
    $query = "SELECT COUNT(*) as total FROM `enrollments` 
    WHERE schools_id = '" . $schools_id . "'
    AND session_id = '" . $session_id . "'";
    $enrollment_count = $this->db->query($query)->row()->total;
    if ($enrollment_count) {
      //update
      $query = "UPDATE `enrollments` set enrollment =  '" . $school_enrollment . "', `updated_date` = '" . date('Y-m-d') . "'
             WHERE schools_id = '" . $schools_id . "'
             AND session_id = '" . $session_id . "'";
      $this->db->query($query);
    } else {
      //insert
      $query = "INSERT INTO `enrollments`
      (`schools_id`, `session_id`, `enrollment`, `updated_date`) VALUES (
        '" . $schools_id . "', '" . $session_id . "', '" . $school_enrollment . "', '" . date('Y-m-d') . "')";
      $this->db->query($query);
    }
    redirect("school_dashboard");
  }
}


?>