<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left"> <?php echo $title ?></h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <h5 style="color: red;">Note: All fields are mandatory.</h5>
  <form action="<?php echo site_url("form/update_employee_detail") ?>" method="post">

    <?php
    $query = "select school_type_id FROM schools WHERE schoolId = '" . $schools_id . "'";
    $school_type_id = $this->db->query($query)->row()->school_type_id;

    ?>

    <input type="hidden" name="schoolStaffId" value="<?php echo $school_staff->schoolStaffId; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
    <table class="table table-bordered">

      <tr>
        <th>Name</th>
        <td><input class="form-control" type="text" name="schoolStaffName" required value="<?php echo  $school_staff->schoolStaffName; ?>" /> </td>
      </tr>
      <tr>
        <th>F / Husband Name</th>
        <td><input class="form-control" type="text" name="schoolStaffFatherOrHusband" required value="<?php echo  $school_staff->schoolStaffFatherOrHusband; ?>" /> </td>
      </tr>
      <tr>
        <th>CNIC</th>
        <td><input class="form-control" type="text" id="schoolStaffCnic2" name="schoolStaffCnic" required value="<?php echo  $school_staff->schoolStaffCnic; ?>" /> </td>
      </tr>
      <tr>
        <th>Gender</th>
        <td> <select class="form-control" required name="schoolStaffGender">
            <option value="">Gender</option>
            <?php if (!empty($gender)) : ?>
              <?php foreach ($gender as $gen) : ?>
                <option <?php if ($school_staff->schoolStaffGender == $gen->genderId) {
                          echo "selected";
                        } ?> value="<?php echo $gen->genderId ?>"><?php echo $gen->genderTitle; ?></option>
              <?php endforeach; ?>
            <?php else : ?>
              No gender found.
            <?php endif; ?>
          </select></td>
      </tr>
      <tr>
        <th>Employee Type</th>
        <td>
          <select class="form-control" required name="schoolStaffType">
            <option value="">Type</option>
            <?php if (!empty($staff_type)) : ?>
              <?php foreach ($staff_type as $s_type) : ?>
                <option <?php if ($school_staff->schoolStaffType == $s_type->staffTypeId) {
                          echo "selected";
                        } ?> value="<?php echo $s_type->staffTypeId ?>"><?php echo $s_type->staffTtitle; ?></option>
              <?php endforeach; ?>
            <?php else : ?>
              No Staff Type Found.
            <?php endif; ?>
          </select>
        </td>
      </tr>
      <tr>
        <th>Designation</th>
        <td><input class="form-control" type="text" name="schoolStaffDesignition" required value="<?php echo  $school_staff->schoolStaffDesignition; ?>" /></td>
      </tr>
      <?php if ($school_type_id == 7) { ?>
        <tr>
          <th>Job Nature</th>
          <td><input <?php if ($school_staff->job_nature == 'permanent') {
                        echo 'checked';
                      } ?> onclick="$('.gov_sector2').attr('required', false); $('.gov_sector2').prop('checked', false); $('.gov_noc2').prop('checked', false); $('#gov_sector_div2').hide(); $('#gov_noc_div2').hide();" type="radio" name="job_nature" value="permanent" required /> Permanent Staff
            <spna style="margin-left: 10px;"></spna>
            <input <?php if ($school_staff->job_nature == 'visiting') {
                      echo 'checked';
                    } ?> onclick="$('.gov_sector2').attr('required', true); $('#gov_sector_div2').show();" type="radio" name="job_nature" value="visiting" required /> Visiting Staff
            <br />
            <div id="gov_sector_div2" style="padding: 10px; border:1px solid gray; margin-top: 5px; 
          <?php if ($school_staff->job_nature == 'visiting') {
            echo 'display:block';
          } else {
            echo 'display:none';
          } ?>
          ">
              <strong>Govt: Sectot Staff </strong>
              <spna style="margin-left: 15px;"></spna>
              <input <?php if ($school_staff->gov_sector == 'yes') {
                        echo 'checked';
                      } ?> class="gov_sector2" onclick="$('.gov_noc2').attr('required', true); $('#gov_noc_div2').show();" type="radio" name="gov_sector" value="yes" /> Yes
              <spna style="margin-left: 10px;"></spna>
              <input <?php if ($school_staff->gov_sector == 'no') {
                        echo 'checked';
                      } ?> class="gov_sector2" onclick="$('.gov_noc2').attr('required', false); $('.gov_noc2').prop('checked', false); $('#gov_noc_div2').hide();" type="radio" name="gov_sector" value="no" /> No
            </div>

            <div id="gov_noc_div2" style="padding: 10px; border:1px solid gray; margin-top: 5px; 
          <?php if ($school_staff->gov_sector == 'yes') {
            echo 'display:block';
          } else {
            echo 'display:none';
          } ?>
          ">
              <strong>NOC in Case of Govt: Sector Staff: </strong>
              <spna style="margin-left: 15px;"></spna>
              <input <?php if ($school_staff->gov_noc == 'yes') {
                        echo 'checked';
                      } ?> class="gov_noc2" type="radio" name="gov_noc" value="yes" /> Yes
              <spna style="margin-left: 10px;"></spna>
              <input <?php if ($school_staff->gov_noc == 'no') {
                        echo 'checked';
                      } ?> class="gov_noc2" type="radio" name="gov_noc" value="no" /> No
            </div>
          </td>
        </tr>
      <?php } ?>
      <th>Academic</th>
      <td><input class="form-control" type="text" name="schoolStaffQaulificationAcademic" required value="<?php echo  $school_staff->schoolStaffQaulificationAcademic; ?>" /></td>
      </tr>
      <tr>
        <th>Professional</th>
        <td><input class="form-control" type="text" name="schoolStaffQaulificationProfessional" required value="<?php echo  $school_staff->schoolStaffQaulificationProfessional; ?>" /></td>
      </tr>
      <?php if ($school_type_id != 7) { ?>
        <tr>
          <th>Training In Months</th>
          <td><input class="form-control" type="number" name="TeacherTraining" required value="<?php echo  $school_staff->TeacherTraining; ?>" /></td>
        </tr>
        <tr>
          <th>Experience In Months</th>
          <td><input class="form-control" type="number" name="TeacherExperience" required value="<?php echo  $school_staff->TeacherExperience; ?>" /></td>
        </tr>
      <?php } else { ?>
        <input class="form-control" type="hidden" name="TeacherTraining" required value="0" />
        <input class="form-control" type="hidden" name="TeacherExperience" required value="0" />
      <?php } ?>
      <tr>
        <th>Appointment At</th>
        <td><input class="form-control" type="date" name="schoolStaffAppointmentDate" required value="<?php echo  $school_staff->schoolStaffAppointmentDate; ?>" /></td>
      </tr>
      <tr>
        <th>Net.Pay</th>
        <td><input class="form-control" type="number" name="schoolStaffNetPay" required value="<?php echo  $school_staff->schoolStaffNetPay; ?>" /></td>
      </tr>
      <tr>
        <th>Annual Increament</th>
        <td><input class="form-control" min="0" max="100" placeholder="10, 20 etc" type="number" name="schoolStaffAnnualIncreament" required value="<?php echo  $school_staff->schoolStaffAnnualIncreament; ?>" /> %</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">
          <input class="btn btn-success" type="submit" name="" value="Update Detail" />
        </td>
      </tr>



    </table>

  </form>


</div>
<script>
  $(document).ready(function() {
    $('#schoolStaffCnic2').inputmask('99999-9999999-9');

  });
</script>