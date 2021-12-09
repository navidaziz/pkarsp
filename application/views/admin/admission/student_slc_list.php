<h5>Search Results: <?php echo count($students_list) ?> School Leaving Certificate
  <?php
  if (count($students_list) <= 1) {
    echo "Record";
  } else {
    echo "Records";
  }
  ?>
  found.</h5>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>Student ID</th>
      <th>SLC ID</th>
      <th>Student Name</th>
      <th>Father Name</th>
      <th>Date Of Birth</th>
      <th>School leaving date</th>
      <th>SLC Issued Date</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($students_list as $student) : ?>
      <tr>
        <td><?php echo $student->psra_student_id; ?></td>
        <td><?php echo $student->slc_id; ?></td>
        <td><?php echo $student->student_name; ?></td>
        <td><?php echo $student->student_father_name; ?></td>
        <td><?php echo date('d M, Y', strtotime($student->student_data_of_birth)); ?></td>
        <td><?php echo date('d M, Y', strtotime($student->school_leaving_date)); ?></td>
        <td><?php echo date('d M, Y', strtotime($student->slc_issue_date)); ?></td>
        <td><?php //echo $student->status;
            if ($student->status == 1) {
              echo "Admit";
            }
            if ($student->status == 2) {
              echo "Struck Off";
            }

            if ($student->status == 3) {
              echo "SLC";
            }

            ?></td>

      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php if ($students_list) { ?>

  <div class="modal-header">
    <h5 class="modal-title pull-left" id="">Admit Student In Your School</h5>
    <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <br /> -->
  </div>
  <div class="modal-body">
    <form action="<?php echo site_url(ADMIN_DIR . "admission/add_new_student/") ?>" method="post" style="text-align: center;">

      <input type="hidden" value="<?php echo $student->student_id; ?>" name="student_previous_id" />
      <input type="hidden" value="<?php echo $student->slc_id; ?>" name="admission_slc_id" />
      <input type="hidden" value="1" name="section_id" />
      <input type="hidden" value="1" name="student_class_no" />


      <table class="table">

        <tr>
          <th>Admission No: </th>
          <td><input type="text" name="student_admission_no" value="" required /></td>
        </tr>
        <tr>
          <th>Student Name: </th>
          <td><input type="text" name="student_name" value="<?php echo $student->student_name; ?>" required /></td>
        </tr>
        <tr>
          <th>Father Name: </th>
          <td><input type="text" name="student_father_name" value="<?php echo $student->student_father_name; ?>" required /></td>
        </tr>


        <tr>
          <th>Father CNIC No:</th>
          <td><input type="text" id="fathernic" name="father_nic" value="<?php echo $student->father_nic; ?>" required /></td>
        </tr>

        <tr>
          <th>Form B No:</th>
          <td><input type="text" id="formb" name="form_b" value="<?php echo $student->form_b; ?>" /></td>
        </tr>
        <tr>
          <th>Admission Date:</th>
          <td><input type="date" name="admission_date" value="" required /></td>
        </tr>
        <tr>
          <th>Date Of Birth: </th>
          <td>
            <input required min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="student_data_of_birth" value="<?php echo $student->student_data_of_birth; ?>" required />

          </td>
        </tr>


        <!-- <tr>
                            <th>CNIC Issue Date:</th>
                            <td><input type="date" name="nic_issue_date" value="<?php echo $student->nic_issue_date; ?>" /></td>
                        </tr> -->
        <tr>
          <th>Contact No:</th>
          <td><input required type="text" id="fathermobilenumber" name="father_mobile_number" value="<?php echo $student->father_mobile_number; ?>" /></td>
        </tr>

        <!-- <tr>
                            <th>Father Occupation:</th>
                            <td><input type="text" name="guardian_occupation" value="<?php echo $student->guardian_occupation; ?>" /></td>
                        </tr> -->
        <tr>
          <th>Address:</th>
          <td><input required type="text" name="student_address" value="<?php echo $student->student_address; ?>" required /></td>
        </tr>

        <tr>
          <th>Gender:</th>
          <td>
            <input required type="radio" name="gender" value="Male" <?php if ($student->gender == 'Male') { ?>checked<?php } ?> />
            Male
            <span style="margin-left: 20px;"></span>

            <input required type="radio" name="gender" value="Female" <?php if ($student->orphan == 'Female') { ?>checked<?php } ?> />
            Female

          </td>
        </tr>
        <tr>
          <th>Is Disable: </th>
          <td>
            <input required type="radio" name="is_disable" value="Yes" <?php if ($student->is_disable == 'Yes') { ?>checked<?php } ?> />
            Yes
            <span style="margin-left: 20px;"></span>

            <input required type="radio" name="is_disable" value="No" <?php if ($student->is_disable == 'No') { ?>checked<?php } ?> />
            No
          </td>
        </tr>

        <tr>
          <th>Orphan: </th>
          <td>

            <input required type="radio" name="orphan" value="Yes" <?php if ($student->orphan == 'Yes') { ?>checked<?php } ?> />
            Yes
            <span style="margin-left: 20px;"></span>

            <input required type="radio" name="orphan" value="No" <?php if ($student->orphan == 'No') { ?>checked<?php } ?> />
            No
          </td>
        </tr>

        <tr>


          <th>Religion:</th>
          <td>
            <input required type="radio" name="religion" value="Muslim" <?php if ($student->religion == 'Muslim') { ?>checked<?php } ?> />
            Muslim
            <span style="margin-left: 20px;"></span>

            <input required type="radio" name="religion" value="Non Muslim" <?php if ($student->religion == 'Non Muslim') { ?>checked<?php } ?> />
            Non Muslim

          </td>
        </tr>
        <tr>
          <th>Nationality:</th>
          <td>
            <input <?php if ($student->nationality == 'Pakistani') { ?>checked<?php } ?> type="radio" id="pak" name="nationality" onclick="$('#othernationality').hide(); $( '#foreign' ).prop( 'checked' , false );" value="Pakistani" required />
            Pakistani
            <span style="margin-left: 10px;"></span>

            <input <?php if ($student->nationality != 'Pakistani') { ?>checked<?php } ?> id="foreign" type="radio" required onclick="$('#othernationality').show(); $( '#pak' ).prop( 'checked' , false ); " /> Foreigner

            <div <?php if ($student->nationality == 'Pakistani') { ?>style="display: none;" <?php } ?> id="othernationality">
              <input <?php if ($student->nationality != 'Afghani') { ?>checked<?php } ?> type="radio" name="nationality" value="Afghani" required /> Afghani
              <span style="margin-left: 10px;"></span>
              <input <?php if ($student->nationality != 'Non Afghani') { ?>checked<?php } ?> type="radio" name="nationality" value="Non Afghani" required /> Non Afghani

            </div>
          </td>
        </tr>



        <tr>


          <th>Domicile:</th>
          <td>
            <select name="domicile_id" required>
              <option value="">Select Domicile</option>
              <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
              $districts = $this->db->query($query)->result();
              foreach ($districts as $district) { ?>
                <option <?php if ($student->domicile_id == $district->districtId) { ?>selected<?php } ?> value="<?php echo $district->districtId ?>"><?php echo $district->districtTitle ?></option>
              <?php } ?>
            </select>

          </td>

        </tr>
        <tr>
          <td colspan="2">
            <div style="border:1px solid #9FC8E8;  border-radius: 10px;   padding: 10px; background-color: white;">
              <?php $query = "SELECT class_title FROM classes WHERE class_id = '" . $student->class_id . "'";
              $class_name = $this->db->query($query)->result()[0]->class_title;
              ?>
              <h4>Student Last Time In Class - <strong><?php echo $class_name; ?></strong></h4>
              <?php $query = "SELECT class_id, class_title FROM classes";
              $classes = $this->db->query($query)->result();
              ?>

              <h4>
                Admit In Class:
                <select name="class_id" required>
                  <?php foreach ($classes as $class) { ?>
                    <option <?php if ($class->class_id == $student->class_id) { ?> selected <?php } ?> value="<?php echo $class->class_id; ?>"><?php echo $class->class_title; ?></option>
                  <?php } ?>
                </select>

              </h4>
            </div>
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="submit" class="btn btn-success btn-sm" value="Admit Student" />
        </tr>
      </table>




    </form>
  </div>
  <script>
    $(document).ready(function() {
      $('#fathermobilenumber').inputmask('(9999)-9999999');
      $('#fathernic').inputmask('99999-9999999-9');
      $('#formb').inputmask('99999-9999999-9');

    });
  </script>
<?php } ?>