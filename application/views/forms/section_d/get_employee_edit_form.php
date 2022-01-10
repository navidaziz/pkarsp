<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left"> <?php echo $title ?></h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <h5 style="color: red;">Note: All fields are mandatory.</h5>
  <form action="<?php echo site_url("form/update_employee_detail") ?>" method="post">


    <input type="hidden" name="schoolStaffId" value="<?php echo $school_staff->schoolStaffId; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $school->schoolId; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
    <table class="table table-bordered">

      <tr>
        <th>Name</th>
        <td><input type="text" name="schoolStaffName" required value="<?php echo  $school_staff->schoolStaffName; ?>" /> </td>
      </tr>
      <tr>
        <th>F/Husband Name</th>
        <td><input type="text" name="schoolStaffFatherOrHusband" required value="<?php echo  $school_staff->schoolStaffFatherOrHusband; ?>" /> </td>
      </tr>
      <tr>
        <th>CNIC</th>
        <td><input type="text" id="schoolStaffCnic2" name="schoolStaffCnic" required value="<?php echo  $school_staff->schoolStaffCnic; ?>" /> </td>
      </tr>
      <tr>
        <th>Gender</th>
        <td> <select required name="schoolStaffGender">
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
        <th>Type</th>
        <td>
          <select required name="schoolStaffType">
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
        <th>Academic</th>
        <td><input type="text" name="schoolStaffQaulificationAcademic" required value="<?php echo  $school_staff->schoolStaffQaulificationAcademic; ?>" /></td>
      </tr>
      <tr>
        <th>Professional</th>
        <td><input type="text" name="schoolStaffQaulificationProfessional" required value="<?php echo  $school_staff->schoolStaffQaulificationProfessional; ?>" /></td>
      </tr>
      <tr>
        <th>Training In Months</th>
        <td><input type="number" name="TeacherTraining" required value="<?php echo  $school_staff->TeacherTraining; ?>" /></td>
      </tr>
      <tr>
        <th>Experience In Months</th>
        <td><input type="number" name="TeacherExperience" required value="<?php echo  $school_staff->TeacherExperience; ?>" /></td>
      </tr>
      <tr>
        <th>Designation</th>
        <td><input type="text" name="schoolStaffDesignition" required value="<?php echo  $school_staff->schoolStaffDesignition; ?>" /></td>
      </tr>
      <tr>
        <th>Appointment At</th>
        <td><input type="date" name="schoolStaffAppointmentDate" required value="<?php echo  $school_staff->schoolStaffAppointmentDate; ?>" /></td>
      </tr>
      <tr>
        <th>Net.Pay</th>
        <td><input type="number" name="schoolStaffNetPay" required value="<?php echo  $school_staff->schoolStaffNetPay; ?>" /></td>
      </tr>
      <tr>
        <th>Annual Increament</th>
        <td><input placeholder="10%, 20% etc" type="text" name="schoolStaffAnnualIncreament" required value="<?php echo  $school_staff->schoolStaffAnnualIncreament; ?>" /></td>
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