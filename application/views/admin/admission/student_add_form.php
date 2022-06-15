<div class="modal-header">
    <h4 class="modal-title pull-left" id=""><?php echo $title;  ?> </h4>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <br />
</div>
<div class="modal-body">
    <form id="addStudentForm" method="POST" style="padding: 5px;">


        <div style="display: none;" id="student_profile_message"></div>

        <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
        <input type="hidden" name="section_id" value="1" />
        <input type="hidden" name="student_class_no" value="1" />
        <?php if ($student) { ?>
            <input type="hidden" name="student_id" value="<?php echo $student->student_id; ?>" />
        <?php } ?>
        <table class="table">
            <tr>
                <td style="width: 100px;"><label class="required" for="inputEmail4">Admission No</label>
                    <input class="form-control" placeholder="Admission No" type="text" name="student_admission_no" value="<?php if ($student) {
                                                                                                                                echo $student->student_admission_no;
                                                                                                                            } ?>" required />
                </td>
                <td><label class="required" for="inputEmail4">Student Name</label>
                    <input class="form-control" placeholder="Student Name" type="text" id="student_name" name="student_name" value="<?php if ($student) {
                                                                                                                                        echo $student->student_name;
                                                                                                                                    } ?>" required />
                </td>
                <td>
                    <label class="required" for="inputEmail4">Father Name</label>
                    <input class="form-control" placeholder="Father Name" type="text" id="student_father_name" name="student_father_name" value="<?php if ($student) {
                                                                                                                                                        echo $student->student_father_name;
                                                                                                                                                    } ?>" required />
                </td>
            </tr>
        </table>
        <label class="required" for="inputEmail4">Nationality</label>
        <br />
        <input onclick="change_masking('Pakistani')" class="form-check-input" type="radio" id="pakistani" name="nationality" value="Pakistani" <?php if ($student->nationality == 'Pakistani') { ?> checked <?php  } ?> required />
        Pakistani
        <span style="margin-left: 10px;"></span>

        <input onclick="change_masking('Afghani')" class="form-check-input" id="foreigner" <?php if ($student->nationality == 'Afghani') { ?> checked <?php  } ?> type="radio" required /> Foreigner

        <span style="display: none;" id="other_nationality"> (
            <input id="afghani" onclick="change_masking('Afghani')" id="afghani" <?php if ($student->nationality == 'Afghani') { ?> checked <?php  } ?> class="form-check-input" type="radio" name="nationality" value="Afghani" required /> Afghani
            <span style="margin-left: 2px;"></span>
            <input onclick="change_masking('Other')" id="non_afghani" class="form-check-input" type="radio" name="nationality" value="Non Afghani" <?php if ($student->nationality == 'Non Afghani') { ?> checked <?php  } ?> required /> Non Afghani
            )
        </span>

        <table class="table">
            <tr>
                <td>
                    <label class="required" for="inputEmail4">Father CNIC</label>
                    <input class="form-control" placeholder="11111-1111111-1" type="text" id="father_nic" name="father_nic" value="<?php if ($student) {
                                                                                                                                        echo $student->father_nic;
                                                                                                                                    } ?>" required />
                </td>
                <td>
                    <label for="inputEmail4">Student Form-B</label>
                    <input class="form-control" placeholder="11111-1111111-1" id="form_b" type="text" id="form_b" name="form_b" value="<?php if ($student) {
                                                                                                                                            echo $student->form_b;
                                                                                                                                        } ?>" />
                </td>
                <td>
                    <label class="required" for="inputEmail4">Contact No </label>
                    <input class="form-control" style="padding: 0 1px;" placeholder="(0311)-1111111" id="father_mobile_number" type="text" id="father_mobile_number" name="father_mobile_number" value="<?php if ($student) {
                                                                                                                                                                                                            echo $student->father_mobile_number;
                                                                                                                                                                                                        } ?>" />
                </td>
                <td>
                    <label class="required" for="inputEmail4">Date Of Birth</label>
                    <input class="form-control" min="<?php echo date("Y") - 30; ?>-12-31" max="<?php echo date("Y") - 2; ?>-12-31" type="date" name="student_data_of_birth" value="<?php if ($student) {
                                                                                                                                                                                        echo $student->student_data_of_birth;
                                                                                                                                                                                    } ?>" required />
                </td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td style="width: 130px;">

                    <label class="required" for="inputEmail4">Addmission Date</label>
                    <input class="form-control" min="<?php echo date("Y") - 5; ?>-12-31" max="<?php echo date("Y-m-d"); ?>" type="date" name="admission_date" value="<?php if ($student) {
                                                                                                                                                                            echo $student->admission_date;
                                                                                                                                                                        } ?>" required />

                </td>
                <td>
                    <label class="required" for="inputEmail4">Gender</label><br />
                    <input type="radio" name="gender" value="Male" <?php if ($student->gender == 'Male') { ?> checked <?php  } ?> required />
                    Male
                    <span style="margin-left: 1px;"></span>
                    <input type="radio" name="gender" value="Female" <?php if ($student->gender == 'Female') { ?> checked <?php  } ?> required />
                    Female
                </td>
                <td>

                    <label class="required" for="inputEmail4">Disable</label><br />
                    <input type="radio" name="is_disable" value="No" <?php if ($student->is_disable == 'No') { ?> checked <?php  } ?> required />
                    No
                    <span style="margin-left: 1px;"></span>
                    <input type="radio" name="is_disable" value="Yes" <?php if ($student->is_disable == 'Yes') { ?> checked <?php  } ?> required />
                    Yes


                </td>
                <td>
                    <label class="required" for="inputEmail4">Orphan</label><br />
                    <input type="radio" name="orphan" value="No" <?php if ($student->orphan == 'No') { ?> checked <?php  } ?> required />
                    No
                    <span style="margin-left: 1px;"></span>
                    <input type="radio" name="orphan" value="Yes" <?php if ($student->orphan == 'Yes') { ?> checked <?php  } ?> required />
                    Yes
                </td>
                <td>
                    <label class="required" for="inputEmail4">Religion</label><br />
                    <input type="radio" name="religion" value="Muslim" <?php if ($student->religion == 'Muslim') { ?> checked <?php  } ?> required />
                    Muslim
                    <span style="margin-left: 10px;"></span>
                    <input type="radio" name="religion" value="Non Muslim" <?php if ($student->religion == 'Non Muslim') { ?> checked <?php  } ?> required />
                    Non Muslim
                </td>
            </tr>
        </table>

        <table class="table" id="province_div">
            <tr>
                <td>
                    <div>
                        <label class="required" for="inputEmail4">Mention Province</label><br />
                        <select class="form-control" name="province" id="province" onchange="show_ditrict_list()" required>
                            <option value="" <?php if ($student->province == '') { ?> selected <?php  } ?>>Select Province</option>
                            <option value="Khyber Pakhtunkhwa" <?php if ($student->province == '') { ?> selected <?php  } ?> selected>Khyber Pakhtunkhwa</option>
                            <option value="Punjab" <?php if ($student->province == 'Punjab') { ?> selected <?php  } ?>>Punjab</option>
                            <option value="Sindh" <?php if ($student->province == 'Sindh') { ?> selected <?php  } ?>>Sindh</option>
                            <option value="Baloachistan" <?php if ($student->province == 'Baloachistan') { ?> checked <?php  } ?>>Baloachistan</option>
                            <option value="Islamabad" <?php if ($student->province == 'Islamabad') { ?> selected <?php  } ?>>Islamabad Capital Territory</option>
                            <option value="Gilgit baltistan" <?php if ($student->province == 'Gilgit baltistan') { ?> selected <?php  } ?>>Gilgit Baltistan</option>
                            <option value="Azad Jammu Kashmir" <?php if ($student->province == 'Azad Jammu Kashmir') { ?> selected <?php  } ?>>Azad Jammu Kashmir</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div>
                        <label class="required" for="inputEmail4">Domicile District</label><br />
                        <select class="form-control" onchange="set_district_of_domicile()" id="domicile_id" name="domicile_id" required>
                            <option value="">Select Domicile District</option>
                            <?php $query = "SELECT * FROM district ORDER BY districtTitle ASC";
                            $districts = $this->db->query($query)->result();
                            foreach ($districts as $district) { ?>
                                <option <?php if ($student->domicile == $district->districtTitle) { ?> selected <?php  } ?> value="<?php echo $district->districtTitle ?>"><?php echo $district->districtTitle ?></option>
                            <?php } ?>
                        </select>
                        <input style="display: none;" class="form-control" placeholder="Domicile District Name" id="ditrict_domicile" name="ditrict_domicile" type="text" value="<?php if ($student) {
                                                                                                                                                                                        echo $student->ditrict_domicile;
                                                                                                                                                                                    } ?>" />

                    </div>
                </td>
            </tr>
        </table>

        <table class="table" id="province_div">
            <tr>
                <td> <label class="required" for="inputEmail4">Student Address</label><br />
                    <input class="form-control" type="text" name="student_address" value="<?php if ($student) {
                                                                                                echo $student->student_address;
                                                                                            } ?>" required />

            </tr>
            <tr>
                <td style="text-align: center;">
                    <?php if ($student) { ?>
                        <input class="btn btn-danger btn-sm" style="margin-top: 10px;" type="submit" value="Update Student Profile" name="Update Student Profile" />
                    <?php } else { ?>
                        <input class="btn btn-success btn-sm" style="margin-top: 10px;" type="submit" value="Add New Student" name="Add Student" />
                    <?php } ?>
                </td>
            </tr>
        </table>

    </form>



</div>
<script>
    $(document).ready(function() {
        $('#father_mobile_number').inputmask('(0399)-9999999');
        $('#father_nic').inputmask('99999-9999999-9');
        $('#form_b').inputmask('99999-9999999-9');

    });

    $(document).ready(function() {
                $("#addStudentForm").on("submit", function(event) {
                    event.preventDefault();

                    var formValues = $(this).serialize();
                    <?php if ($student) { ?>
                        $.post("<?php echo site_url(ADMIN_DIR . "admission/UpdateStudentProfile"); ?>", formValues, function(data) {
                        <?php } else { ?>
                            $.post("<?php echo site_url(ADMIN_DIR . "admission/check_student_profile"); ?>", formValues, function(data) {
                            <?php } ?>
                            // Display the returned data in browser
                            //alert(data);
                            $('#student_profile_message').show();
                            $("#student_profile_message").html(data);
                            if (data == 'Student Successfully Added.') {
                                get_class_wise_students_list();
                                $("#addStudentForm")[0].reset();
                            }

                            });
                        });
                });

                function change_masking(value) {

                    if (value == 'Pakistani') {

                        $('#father_nic').inputmask('99999-9999999-9');
                        $('#form_b').inputmask('99999-9999999-9');
                        $('#father_nic').prop('placeholder', '11111-111111-1');
                        $('#form_b').inputmask('99999-9999999-9');
                        $('#form_b').prop('placeholder', '11111-111111-1');

                        $('#province_div').show();
                        $('#ditrict_domicile').prop('required', true);
                        $('#domicile_id').prop('required', true);
                        $('#province').prop('required', true);

                        $('#other_nationality').hide();
                        $('#foreigner').prop('checked', false);

                        $('#afghani').prop('checked', false);
                        $('#non_afghani').prop('checked', false);
                        return false;
                    }


                    if (value == 'Afghani') {
                        $('#pakistani').prop('checked', false);
                        $('#province_div').hide();
                        $('#ditrict_domicile').prop('required', false);
                        $('#domicile_id').prop('required', false);
                        $('#province').prop('required', false);

                        $('#other_nationality').show();
                        $('#pakistani').prop('checked', false);
                        $('#father_nic').inputmask('aa999-9999999-9');
                        $('#father_nic').prop('placeholder', 'FC111-111111-1');
                        $('#form_b').inputmask('aa999-9999999-9');
                        $('#form_b').prop('placeholder', 'FC111-111111-1');
                        return false;
                    }

                    if (value == 'Other') {
                        $('#father_nic').inputmask('remove');
                        $('#form_b').inputmask('remove');
                        $('#father_nic').prop('placeholder', 'XXXXXXXXXXXXXX');
                        $('#form_b').prop('placeholder', 'XXXXXXXXXXXXXX');
                        return false;

                    }
                }

                function set_district_of_domicile() {
                    $('#ditrict_domicile').val($('#domicile_id').val());
                }

                function show_ditrict_list() {

                    if ($('#province').val() == 'Khyber Pakhtunkhwa' || $('#province').val() == '') {
                        $('#ditrict_domicile').hide();
                        $('#domicile_id').show();
                        $('#ditrict_domicile').prop('required', true);
                        $('#domicile_id').prop('required', true);
                    } else {


                        $('#ditrict_domicile').show();
                        $('#domicile_id').hide();
                        $('#ditrict_domicile').prop('required', true);
                        $('#domicile_id').prop('required', false);
                        $('#ditrict_domicile').val("");
                    }
                }
</script>