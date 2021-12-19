<div class="modal-header">
    <h5 class="modal-title pull-left" id="">Update Student Profile</h5>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <br />
</div>
<div class="modal-body">
    <form action="<?php echo site_url("covid_vaccination_students/update_profile/" . $students[0]->student_id) ?>" method="post" style="text-align: center;">

        <?php if ($class_list) { ?>
            <input type="hidden" name="class_id" value="<?php echo $students[0]->class_id; ?>" />
        <?php   } ?>

        <table class="table">
            <!-- <tr>
                            <th>Class No: </th>
                            <td><input type="hidden" name="student_class_no" value="<?php echo $students[0]->student_class_no; ?>" /></td>
                        </tr> -->
            <tr>
                <th>Admission No: </th>
                <td><input required type="text" name="student_admission_no" value="<?php echo $students[0]->student_admission_no; ?>" /></td>
            </tr>
            <tr>
                <th>Student Name: </th>
                <td><input required type="text" name="student_name" value="<?php echo $students[0]->student_name; ?>" /></td>
            </tr>
            <tr>
                <th>Father Name: </th>
                <td><input required type="text" name="student_father_name" value="<?php echo $students[0]->student_father_name; ?>" /></td>
            </tr>


            <tr>
                <th>Father CNIC No:</th>
                <td><input required type="text" id="fathernic" name="father_nic" value="<?php echo $students[0]->father_nic; ?>" /></td>
            </tr>

            <tr>
                <th>Form B No:</th>
                <td><input type="text" id="formb" name="form_b" value="<?php echo $students[0]->form_b; ?>" /></td>
            </tr>

            <tr>
                <th>Date Of Birth: </th>
                <td>
                    <input required min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="student_data_of_birth" value="<?php echo $students[0]->student_data_of_birth; ?>" required />

                </td>
            </tr>



            <tr>
                <th>Gender:</th>
                <td>
                    <input required type="radio" name="gender" value="Male" <?php if ($students[0]->gender == 'Male') { ?>checked<?php } ?> />
                    Male
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="gender" value="Female" <?php if ($students[0]->orphan == 'Female') { ?>checked<?php } ?> />
                    Female

                </td>
            </tr>


            <tr>
                <th>Vaccinated:</th>
                <td>
                    <input required type="radio" name="vaccinated" value="Male" <?php if ($students[0]->vaccinated == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="vaccinated" value="Female" <?php if ($students[0]->vaccinated == 'No') { ?>checked<?php } ?> />
                    No

                </td>
            </tr>





            <tr>
                <td colspan="2">
                    <input type="submit" class="btn btn-success btn-sm" value="Update Profile" />
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