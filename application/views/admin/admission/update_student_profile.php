<div class="modal-header">
    <h5 class="modal-title pull-left" id="">Update Student Profile</h5>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <br />
</div>
<div class="modal-body">
    <form action="<?php echo site_url(ADMIN_DIR . "admission/update_profile/" . $students[0]->student_id) ?>" method="post" style="text-align: center;">

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
                <td><input type="text" name="student_admission_no" value="<?php echo $students[0]->student_admission_no; ?>" /></td>
            </tr>
            <tr>
                <th>Student Name: </th>
                <td><input type="text" name="student_name" value="<?php echo $students[0]->student_name; ?>" /></td>
            </tr>
            <tr>
                <th>Father Name: </th>
                <td><input type="text" name="student_father_name" value="<?php echo $students[0]->student_father_name; ?>" /></td>
            </tr>


            <tr>
                <th>Father CNIC No:</th>
                <td><input type="text" id="father_nic" name="father_nic" value="<?php echo $students[0]->father_nic; ?>" /></td>
            </tr>

            <tr>
                <th>Form B No:</th>
                <td><input type="text" id="form_b" name="form_b" value="<?php echo $students[0]->form_b; ?>" /></td>
            </tr>
            <tr>
                <th>Admission Date:</th>
                <td><input type="date" name="admission_date" value="<?php echo $students[0]->admission_date; ?>" /></td>
            </tr>
            <tr>
                <th>Date Of Birth: </th>
                <td>
                    <input min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" style="width: 125px;" type="date" name="student_data_of_birth" value="<?php echo $students[0]->student_data_of_birth; ?>" required />

                </td>
            </tr>


            <!-- <tr>
                            <th>CNIC Issue Date:</th>
                            <td><input type="date" name="nic_issue_date" value="<?php echo $students[0]->nic_issue_date; ?>" /></td>
                        </tr> -->
            <tr>
                <th>Contact No:</th>
                <td><input type="text" id="father_mobile_number" name="father_mobile_number" value="<?php echo $students[0]->father_mobile_number; ?>" /></td>
            </tr>

            <!-- <tr>
                            <th>Father Occupation:</th>
                            <td><input type="text" name="guardian_occupation" value="<?php echo $students[0]->guardian_occupation; ?>" /></td>
                        </tr> -->
            <tr>
                <th>Address:</th>
                <td><input type="text" name="student_address" value="<?php echo $students[0]->student_address; ?>" required /></td>
            </tr>

            <tr>
                <th>Gender:</th>
                <td>
                    <input type="radio" name="gender" value="Male" <?php if ($students[0]->gender == 'Male') { ?>checked<?php } ?> />
                    Male
                    <span style="margin-left: 20px;"></span>

                    <input type="radio" name="gender" value="Female" <?php if ($students[0]->orphan == 'Female') { ?>checked<?php } ?> />
                    Female

                </td>
            </tr>
            <tr>
                <th>Is Disable: </th>
                <td>
                    <input type="radio" name="is_disable" value="Yes" <?php if ($students[0]->is_disable == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input type="radio" name="is_disable" value="No" <?php if ($students[0]->is_disable == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>

            <tr>
                <th>Orphan: </th>
                <td>

                    <input type="radio" name="orphan" value="Yes" <?php if ($students[0]->orphan == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input type="radio" name="orphan" value="No" <?php if ($students[0]->orphan == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>

            <tr>


                <th>Religion:</th>
                <td>
                    <input type="radio" name="religion" value="Muslim" <?php if ($students[0]->religion == 'Muslim') { ?>checked<?php } ?> />
                    Muslim
                    <span style="margin-left: 20px;"></span>

                    <input type="radio" name="religion" value="Non Muslim" <?php if ($students[0]->religion == 'Non Muslim') { ?>checked<?php } ?> />
                    Non Muslim

                </td>
            </tr>
            <tr>
                <th>Nationality:</th>
                <td>
                    <input <?php if ($students[0]->nationality == 'Pakistani') { ?>checked<?php } ?> type="radio" id="pakistani" name="nationality" onclick="$('#other_nationality').hide(); $( '#foreigner' ).prop( 'checked' , false );" value="Pakistani" required />
                    Pakistani
                    <span style="margin-left: 10px;"></span>

                    <input <?php if ($students[0]->nationality != 'Pakistani') { ?>checked<?php } ?> id="foreigner" type="radio" required onclick="$('#other_nationality').show(); $( '#pakistani' ).prop( 'checked' , false ); " /> Foreigner

                    <div <?php if ($students[0]->nationality == 'Pakistani') { ?>style="display: none;" <?php } ?> id="other_nationality">
                        <input <?php if ($students[0]->nationality != 'Afghani') { ?>checked<?php } ?> type="radio" name="nationality" value="Afghani" required /> Afghani
                        <span style="margin-left: 10px;"></span>
                        <input <?php if ($students[0]->nationality != 'Non Afghani') { ?>checked<?php } ?> type="radio" name="nationality" value="Non Afghani" required /> Non Afghani

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
                            <option <?php if ($students[0]->domicile_id == $district->districtId) { ?>selected<?php } ?> value="<?php echo $district->districtId ?>"><?php echo $district->districtTitle ?></option>
                        <?php } ?>
                    </select>

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
        $('#father_mobile_number').inputmask('(9999)-9999999');
        $('#father_nic').inputmask('99999-9999999-9');
        $('#form_b').inputmask('99999-9999999-9');

    });
</script>