<table class="table">
    <tr>
        <td>School ID:
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
                                ?></strong>

            <br />
            <?php if ($school->isfined == 1) { ?>
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

<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
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
        `school`.`file_status`,
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
        AND schools_id = " . $schoolid . "
        ORDER BY `session_year`.`sessionYearId` ASC
        ";
    $school_sessions = $this->db->query($query)->result();

    $query = "select max(sessionYearId) as sessionYearId from session_year";
    $current_session_id = $query = $this->db->query($query)->row()->sessionYearId;

    ?>

    <div class="table-responsive">
        <table class="table table2">
            <tr>
                <th>Session</th>
                <th>Visit Report</th>
                <th>Notesheet</th>
                <th>Apply For</th>
                <th>Level</th>

                <th>Max Fee</th>
                <th style="color:red"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
                <th>Students</th>
                <th>Staffs</th>
                <!-- <th>Date</th> -->

                <th>File Status</th>
                <th>Status</th>
                <th>Cer. Issued</th>
                <th>STAN</th>
                <th>Edit</th>
            </tr>
            <?php
            $previous_max = NULL;
            $missing = 0;
            $note_sheet_count = 0;
            $session_count = 0;
            if ($school_sessions) {
                foreach ($school_sessions as $school_session) {
                    $session_count++;
                    if ($school_session->status == 0) {
                        $missing = 1;
                    }
            ?>

                    <tr <?php if ($school_session->sessionYearId == $current_session_id or $school_session->status == 2) { ?> style="background-color: #fcd4d4 !important; font-weight: bold;" <?php } ?> title="<?php echo  $school_session->schoolId; ?>">
                        <td>
                            <?php if ($school_session->status != 0) { ?>
                                <a href="<?php echo site_url("print_file/school_session_detail/" . $school_session->schoolId); ?>" target="new">
                                    <i class="fa fa-print" aria-hidden="true"></i> <?php echo $school_session->sessionYearTitle; ?></a>

                            <?php } else { ?>
                                <?php echo $school_session->sessionYearTitle; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url("print_visit_report/visit_report/" . $school_session->schoolId); ?>" target="new">
                                <i class="fa fa-print" aria-hidden="true"></i> Visit Report</a>

                        </td>
                        <td>
                            <?php if ($school_session->status == 2 and $missing == 0) {
                                $note_sheet_count++;
                            ?>
                                <a target="new" href="<?php echo site_url("online_cases/single_note_sheet/" . $school->schools_id . "/" . $school_session->schoolId) ?>">Notesheet</a>

                            <?php } ?>
                        </td>
                        <?php if ($school_session->status != 0) { ?>
                            <td>
                                <?php
                                echo $school_session->regTypeTitle;
                                if ($school_session->sessionYearId == $current_session_id) {
                                    echo "<small style=\"color:#f67800; margin-left:10px\">Current</small>";
                                    // echo '<small>
                                    // <span onclick="$(\'#edit_apply\').toggle()">Edit</span>
                                    // <select id="edit_apply" style="display:none;">
                                    // <option value="2">Renewal</option>
                                    // <option value="4">Upgradation + Renewal</option>
                                    // <option value="3">Upgradation</option>
                                    // </select>
                                    // </small>';
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
                                    <?php if ($this->session->userdata('role_id') == '34') { ?>
                                        <span style="color:<?php echo $color; ?>"><?php echo  $inc; ?></span>
                                    <?php } ?>
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


                            <td>
                                <?php if ($school_session->status != 1) {
                                    file_status($school_session->file_status);
                                } ?>
                            </td>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($school_session->status == 2) { ?>
                                    Applied
                                <?php } ?>
                                <?php if ($school_session->status == 0) { ?>
                                    Not Applied
                                <?php } ?>
                                <?php if ($school_session->status == 1) { ?>
                                    Completed
                                <?php } ?>
                            </td>
                            <td><?php
                                if ($school_session->cer_issue_date) { ?>
                                    <form target="_blank" method="post" action="<?php echo site_url("print_file/certificate"); ?>">
                                        <input type="hidden" name="school_id" value="<?php echo $school_session->schoolId ?>" />
                                        <button class="btn btn-link btn-sm">
                                            <i class="fa fa-print"></i>
                                            <?php echo date('d M, y', strtotime($school_session->cer_issue_date)); ?>
                                        </button>
                                    </form>
                                <?php
                                } else {
                                    echo '<small>Pending</small>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $query = "SELECT * FROM bank_transaction where school_id = '" . $school_session->schoolId . "'";
                                $query = $this->db->query($query);
                                $bank_stan = $query->result_array();

                                $count = 1;
                                foreach ($bank_stan as $bt) {
                                    //echo "<strong>STAN</strong> # $count: " . $bt['bt_no'] . ' ' . "<strong> Date</strong>: " . $bt['bt_date'] . "<br>";
                                    echo "" . $bt['bt_no'] . ' ' . " - " . $bt['bt_date'] . "<br>";
                                    $count++;
                                }  ?>

                            </td>
                            <td>

                                <?php if ($school_session->status == 0) { ?>
                                    <i class="fa fa-unlock" style="color:green" aria-hidden="true"></i>
                                <?php } else { ?>
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                <?php } ?>

                            </td>
                        <?php } else { ?>
                            <td colspan="12">Not applied yet ! <i class="fa fa-unlock pull-right" style="color:green" aria-hidden="true"></i></td>
                        <?php } ?>

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

    </div>

</div>
<?php
if ($this->session->userdata('role_id') == '34' or $this->session->userdata('role_id') == '26'  or $this->session->userdata('role_id') == '13' or $this->session->userdata('role_id') == '9') { ?>
    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
            Session Wise Monthly Fee
        </h4>
        <div class="table-responsive">
            <table class="table table2 table-bordered">

                <tr style="font-size:11px">
                    <th>Session</th>

                    <?php
                    $classes = $this->db->query("SELECT * FROM class")->result();
                    foreach ($classes  as $class) { ?>
                        <th><?php echo $class->classTitle ?></th>
                    <?php } ?>

                    <?php foreach ($school_sessions as $school_session) { ?>

                <tr>
                    <td>
                        <a target="new" href="<?php echo site_url("print_file/section_e/" . $school_session->schoolId); ?>">
                            <i class="fa fa-print" aria-hidden="true"></i> <?php echo $school_session->sessionYearTitle ?>
                        </a>
                    </td>
                <?php
                        foreach ($classes  as $class) {


                            $query = "SELECT
                        `fee`.`addmissionFee`
                        , `fee`.`tuitionFee`
                        , `fee`.`securityFund`
                        , `fee`.`otherFund`
                        FROM
                        `fee` WHERE `fee`.`school_id` = '" . $school_session->schoolId . "'
                        AND `fee`.`class_id` ='" . $class->classId . "'";
                            $session_fee = $this->db->query($query)->result()[0];
                            $previous_session_id = $school_session->sessionYearId - 1;
                            if ($previous_session_id) {
                                $query = "SELECT schoolId FROM school WHERE session_year_id = $previous_session_id
                        AND school.schools_id = '" . $school->schools_id . "'
                        ";
                                $previous_school_id = $this->db->query($query)->row()->schoolId;
                            } else {
                                $previous_school_id = 0;
                            }


                            if ($previous_school_id) {
                                $query = "SELECT
                        `fee`.`addmissionFee`
                        , `fee`.`tuitionFee`
                        , `fee`.`securityFund`
                        , `fee`.`otherFund`
                        FROM
                        `fee` WHERE `fee`.`school_id` = '" . $previous_school_id . "'
                        AND `fee`.`class_id` ='" . $class->classId . "'";
                                $pre_session_tution_fee = preg_replace("/[^0-9.]/", "", $this->db->query($query)->result()[0]->tuitionFee);
                            }
                            $current_fee = preg_replace("/[^0-9.]/", "", $session_fee->tuitionFee);
                            if ($session_fee->tuitionFee == 0) {
                                echo '<td style="text-align:center">' . $session_fee->tuitionFee . '</td>';
                            } else {
                                echo '<td style="text-align:center">' . $session_fee->tuitionFee;


                                if ($pre_session_tution_fee) {
                                    $incress = round((($current_fee - $pre_session_tution_fee) / $pre_session_tution_fee) * 100, 2);
                                    if ($incress > 10) {
                                        echo @" <small style='color:red;'><br /> <i class='fa fa-line-chart' aria-hidden='true'></i> (" . $incress . " %)</small>";
                                    } else {
                                        // echo @" <small style='color:green'>(" . $incress . " %)</small>";
                                    }
                                }
                                echo '</td>';
                            }
                        }
                        echo '</tr>';
                    } ?>


            </table>
        </div>
        <br />
        <?php if ($note_sheet_count >= 2) { ?>
            <p style="text-align: center;">
                <a target="_blank" class="btn btn-success" href="<?php echo site_url("online_cases/combine_note_sheet/" . $school->schools_id) ?>">Process Note Sheet</a>
            </p>
        <?php } ?>
        <p style="text-align: center;">
            <a target="_blank" class="btn btn-danger" href="<?php echo site_url("print_file/all_section_e/" . $school->schools_id) ?>">Print All Session Fee</a>
        </p>
    </div>
<?php } ?>

<script>
    function add_deficiancy(school_id, deficiency_reason) {
        alert(school_id);
        $.ajax({
            url: "<?php echo base_url(); ?>record_room/add_deficiancy",
            type: "POST",
            data: {
                school_id: school_id,
                deficiency_reason: deficiency_reason
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

    function remove_from_visit_list(school_id) {

        $.ajax({
            url: "<?php echo base_url(); ?>record_room/remove_from_visit_list",
            type: "POST",
            data: {
                school_id: school_id
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

    function add_school_in_registration_visit_list(school_id, visit_type) {
        alert(visit_type);
        $.ajax({
            url: "<?php echo base_url(); ?>record_room/add_school_in_visit_list",
            type: "POST",
            data: {
                school_id: school_id,
                visit_type: visit_type
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