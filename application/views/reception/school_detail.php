<table class="table">
    <tr>
        <td>Institute ID:
            <strong><?php echo $school->schools_id ?></strong> <br />
            Registration ID: <strong style='color:green'><?php echo $school->registrationNumber  ?> </strong><br />
            File No: <strong><?php
                                $query = "SELECT * FROM `school_file_numbers` WHERE `school_id`='$school->schools_id'";
                                $file_numbers = $this->db->query($query)->result();
                                $count = 1;
                                foreach ($file_numbers as $file_number) {
                                    if ($count > 1) {
                                        echo ", ";
                                    }
                                    echo $file_number->file_number;

                                    $count++;
                                }
                                ?></strong><br />
            <?php if ($school->isfined) { ?>
                <button style="color:red">
                    <i class="fa fa-fire" aria-hidden="true"></i> Fine on school
                </button>
            <?php } ?>
        </td>
        <td>
            School Name: <strong><?php echo $school->schoolName ?></strong>
            <br />
            District: <strong><?php echo $school->districtTitle ?>

                ( Region: <?php echo $school->region ?> )</strong><br />

            Address: <strong><?php echo $school->address ?></strong><br />
            Contact No: <strong><?php echo $school->telePhoneNumber . ", " . $school->schoolMobileNumber  ?></strong><br />

        </td>
    </tr>
</table>

<div class="table-responsive" style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
        School Session's History
    </h4>
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
        `school`.`dairy_type`,
        `school`.`dairy_no`,
        school.`dairy_date`
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
        AND schools_id = " . $schoolid . "
        ORDER BY `session_year`.`sessionYearId` ASC
        ";
    $school_sessions = $this->db->query($query)->result();

    $query = "select max(sessionYearId) as sessionYearId from session_year";
    $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;

    ?>


    <table class="table table2">
        <tr>
            <th>Session</th>
            <th>Apply For</th>
            <th>Level</th>

            <th>Max Fee</th>
            <th style="color:red"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
            <th style="text-align: center;">Students</th>
            <th style="text-align: center;">Staffs</th>
            <!-- <th>Date</th> -->

            <th>Diary No</th>
            <th>Diary Date</th>
            <th>Cer. Issued</th>
            <th>STAN</th>
            <th>Status</th>
            <th></th>
        </tr>
        <?php
        $previous_max = NULL;
        $dairy = 0;
        foreach ($school_sessions as $school_session) { ?>

            <tr <?php if ($school_session->sessionYearId == $current_session_id or $school_session->status == 2) { ?> style="background-color: #fcd4d4 !important; font-weight: bold;" <?php } ?> title="<?php echo  $school_session->schoolId; ?>">
                <td>
                    <a href="<?php echo site_url("print_file/school_session_detail/" . $school_session->schoolId); ?>" target="new">
                        <?php echo $school_session->sessionYearTitle; ?></a>
                </td>
                <td>
                    <?php
                    echo $school_session->regTypeTitle;
                    if ($school_session->sessionYearId == $current_session_id) {
                        echo "<small style=\"color:#f67800; margin-left:10px\">Current</small>";
                    }
                    ?></td>
                <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>

                <td><?php
                    $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                    $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                    $max_tuition_fee = (int) preg_replace(
                        '/[^0-9.]/',
                        '',
                        $this->db->query($query)->result()[0]->max_tution_fee
                    );
                    echo $max_tuition_fee;
                    ?> Rs.</td>
                <td><?php
                    if ($previous_max) {
                        $color = '';
                        $dec = (int) $max_tuition_fee - (int) $previous_max;
                        if ($max_tuition_fee) {
                            $inc = round((@$dec / $max_tuition_fee) * 100, 2);
                        } else {
                            $inc = "";
                        }
                        if ($inc > 10) {
                            $color = 'red';
                        } else {
                            $color = 'green';
                        }
                        if ($inc < 0) {
                            $color = 'red';
                        }
                    ?>
                        <span style="color:<?php echo $color; ?>"><?php //echo  $inc; 
                                                                    ?></span>
                    <?php   } ?>
                </td>
                <td style="text-align: center;"><?php
                                                $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                    WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                                                $enrollment = $this->db->query($query)->result()[0]->total;
                                                if ($enrollment) {
                                                    echo $enrollment;
                                                } else {
                                                    echo "Section C Missing";
                                                }

                                                ?></td>

                <td style="text-align: center;"><?php
                                                $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                    WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'";
                                                echo $this->db->query($query)->result()[0]->total; ?></td>
                <!-- <td><?php
                            if ($school_session->updatedDate) {
                                echo date('d M, y', strtotime($school_session->updatedDate));
                            }
                            ?></td> -->


                <td><?php echo $school_session->dairy_no; ?></td>
                <td><?php
                    if ($school_session->dairy_date) {
                        echo date('d M, Y', strtotime($school_session->dairy_date));
                    } ?></td>
                <td><?php
                    if ($school_session->cer_issue_date) {
                        echo date('d M, y', strtotime($school_session->cer_issue_date));
                    } else {
                        echo '<small>Pending</small>';
                    }
                    ?></td>
                <td>

                </td>
                <td>
                    <?php if ($school_session->status == 1) { ?>
                        Completed
                    <?php } ?>
                    <?php if ($school_session->status == 2) { ?>
                        Applied
                    <?php } ?>
                    <?php if ($school_session->status == 0) { ?> Not Applied <?php } ?>
                </td>
                <td>
                    <?php if ($school_session->status == 2 and $school_session->dairy_no == NULL) {
                        $dairy = 1;
                        $role_id = $this->session->userdata('role_id');
                        if ($role_id == 31 or $role_id == 21) {
                    ?>

                            <input type="checkbox" class="school_session_id" name="school_session_id[]" value="<?php echo $school_session->schoolId ?>" />
                    <?php
                        }
                    } ?>


                    <?php if ($school->registrationNumber <= 0 and $school_session->dairy_no == NULL) {
                        $dairy = 1;
                        $role_id = $this->session->userdata('role_id');
                        if ($role_id == 31 or $role_id == 21) {
                    ?>

                            <input type="checkbox" class="school_session_id" name="school_session_id[]" value="<?php echo $school_session->schoolId ?>" />
                    <?php
                        }
                    } ?>
                </td>
            </tr>

        <?php
            $previous_max = $max_tuition_fee;
        } ?>

        <?php if ($dairy) { ?>
            <tr>
                <td colspan="12" style="text-align: right; padding:10px">
                    <?php if ($school_session->dairy_number) { ?>

                        <?php } else {
                        $role_id = $this->session->userdata('role_id');
                        if ($role_id == 31 or $role_id == 21) {
                        ?>

                            Receiving Type:
                            <input type="radio" name="dairy_type" value="Post"> <b><i class="fa fa-envelope" aria-hidden="true"></i></b>
                            <span style="margin-left: 10px;"></span>
                            <input type="radio" name="dairy_type" value="Hand"> <b><i class="fa fa-hand-paper-o" aria-hidden="true"></i></b>
                            <span style="margin-left: 20px;"></span>
                            Diary Number:
                            <input type="text" name="dairy_number" value="" id="dairy_name" />
                            <span style="margin-left: 20px;"></span>
                            <button onclick="add_dairy_number()" class="btn btn-success" style="padding:3px; padding-left:10px; padding-right:10px">
                                Add Diary Number
                            </button>
                    <?php
                        }
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

</div>


<script>
    function add_dairy_number() {

        dairy_type = $("input[type='radio'][name='dairy_type']:checked").val();
        if (!dairy_type) {
            alert("Select Dairy Type");
            return false;
        }
        dairy_number = $("#dairy_name").val();
        if (!dairy_number) {
            alert("Enter Diary Number");
            return false;
        }

        var school_session_ids = $('.school_session_id:checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (school_session_ids.length == 0) {
            alert("Select School Session");
            return false;

        }

        $.ajax({
            url: "<?php echo base_url(); ?>reception/add_dairy_number",
            type: "POST",
            data: {
                dairy_type: dairy_type,
                dairy_number: dairy_number,
                school_session_ids: school_session_ids
            },
            success: function(data) {
                if (data == 'success') {
                    search();
                } else {
                    alert('Something went wrong');
                }
            }
        });


    }
</script>