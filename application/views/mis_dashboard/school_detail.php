<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">

    <table style="width: 100%;">
        <tr>
            <td>
                <div>
                    <h4>
                        <?php echo ucwords(strtolower($school->schoolName)); ?><br />

                    </h4>
                    <h5> School ID: <?php echo $school->schools_id ?>
                        <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> REG. ID:
                            <?php echo $school->registrationNumber ?>
                        <?php } ?>
                        <span style="margin-left: 20px;"></span>
                        File No: <?php
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
                                    ?>
                        <span style="margin-left: 20px;"></span>
                        <?php $query = "SELECT isfined FROM schools WHERE schoolId = '" . $school->schools_id . "'";
                        $isfined = $this->db->query($query)->row()->isfined;
                        if ($isfined == 1) {
                            echo '<span class="alert alert-danger" style="padding:2px; padding-left:5px; padding-right:5px;"><i>';
                            echo 'School has been fined';
                            echo '</i></span>';
                        }
                        ?>

                    </h5>
                    <small><strong>Address:</strong>
                        <?php if ($school->division) {
                            echo "Region: <strong>" . $school->division . "</strong>";
                        } ?>
                        <?php if ($school->districtTitle) {
                            echo " / District: <strong>" . $school->districtTitle . "</strong>";
                        } ?>
                        <?php if ($school->tehsilTitle) {
                            echo " / Tehsil: <strong>" . $school->tehsilTitle . "</strong>";
                        } ?>

                        <?php if ($school->ucTitle) {
                            echo " / Unionconsil: <strong>" . $school->ucTitle . "</strong>";
                        } ?>
                        <?php if ($school->address) {
                            echo " Address:  <strong>" . $school->address . "</strong>";
                        } ?>
                    </small>
                </div>
            </td>
            <td style="width: 250px; vertical-align: top;">
                <strong>School Contact Details</strong>
                <ol style="margin-left: 5px;">
                    <li>Phone No: <strong><?php echo $school->phone_no; ?></strong></li>
                    <li>Mobile No: <strong><?php echo $school->mobile_no; ?></strong></li>
                    <li>Email: <strong><?php echo $school->principal_email; ?></strong></li>
                    <oul>
            </td>
            <td style="width: 250px; vertical-align: top;">
                <strong>Owner Info</strong>
                <ol style="margin-left: 5px;">
                    <li>Owner Name: <strong><?php echo $school->userTitle; ?></strong></li>
                    <li>Owner CNIC: <strong><?php echo $school->cnic; ?></strong></li>
                    <li>Owner No: <strong><?php echo $school->owner_no; ?></strong></li>
                    <oul>
            </td>
            <td style="width: 250px; vertical-align: top;">
                <strong>Account info</strong>
                <ol style="margin-left: 5px;">
                    <li>User Name: <strong><?php echo $school->userName; ?></strong></li>
                    <li>Password: <strong><?php echo $school->userPassword; ?></strong></li>
                    <oul>
            </td>
        </tr>
    </table>
</div>


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
        school.pending_type,
        school.pending_date,
        school.pending_reason,
        school.dairy_type,
        school.dairy_no,
        school.dairy_date,
        school.updatedBy,
        school.primary,
        school.middle,
        school.high,
        school.high_sec,
        school.level_of_school_id,
        school.gender_type_id,
        school.reg_type_id,
        school.section_e

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
                <th>Applied For</th>
                <th>Level</th>
                <th>Gender Of Edu.</th>
                <th>Max Fee</th>
                <th>Section E</th>
                <th>Students</th>
                <th>Staffs</th>
                <th>Status</th>
                <th>Cer. Issued</th>
                <th>Primary</th>
                <th>Middle</th>
                <th>High</th>
                <th>High Sec.</th>
                <!-- <th>Issued By</th> -->
                <th>Code:</th>


            </tr>
            <?php
            $previous_max = NULL;
            $missing = 0;
            $note_sheet_count = 0;
            $pending = 0;
            if ($school_sessions) {
                foreach ($school_sessions as $school_session) {
                    if ($school_session->status == 0) {
                        $missing = 1;
                    }

            ?>

                    <tr title="<?php echo  $school_session->schoolId; ?>">

                        <?php if ($school_session->status != 0) { ?>
                            <td>
                                <a href="<?php echo site_url("print_file/school_session_detail/" . $school_session->schoolId); ?>" target="new">
                                    <i class="fa fa-print" aria-hidden="true"></i> <?php echo $school_session->sessionYearTitle; ?></a>
                            </td>
                        <?php } else { ?>
                            <td style="color:#b2aeae;">
                                <?php echo $school_session->sessionYearTitle; ?>
                            </td>
                        <?php } ?>


                        <?php if ($school_session->status != 0) { ?>
                            <td> <?php echo $school_session->regTypeTitle; ?></td>
                            <td><?php echo substr($school_session->levelofInstituteTitle, 0, 15); ?></td>
                            <td>
                                <?php if ($school_session->gender_type_id == 1) { ?> BOYS <?php } ?>
                                <?php if ($school_session->gender_type_id == 2) { ?> GIRLS <?php } ?>
                                <?php if ($school_session->gender_type_id == 3) { ?> CO-EDU <?php } ?>
                            </td>
                            <td>
                                <strong>
                                    <?php
                                    $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                                              FROM `fee` WHERE school_id= '" . $school_session->schoolId . "'";
                                    $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                                    $max_tuition_fee = (int) preg_replace('/[^0-9.]/', '', $this->db->query($query)->result()[0]->max_tution_fee);
                                    echo $max_tuition_fee;
                                    ?>
                                </strong>
                            </td>

                            <td style="text-align: center;">

                                <?php if ($school_session->section_e == 0 and $school_session->status == 2) { ?>
                                    <a href="#" onclick="lock_editing('<?php echo $school_session->schoolId; ?>')">
                                        <i class="fa fa-unlock" style="color:red" aria-hidden="true"></i>
                                    </a>
                                <?php } ?>

                                <?php if ($school_session->section_e == 1 and $school_session->status == 2) { ?>
                                    <a href="#" onclick="unlock_editing('<?php echo $school_session->schoolId; ?>')">
                                        <i class="fa fa-lock" style="color:green" aria-hidden="true"></i>
                                    </a>
                                <?php } ?>

                            </td>

                            <td style="text-align: center;"><?php
                                                            $query = "SELECT SUM(`enrolled`) as total FROM `age_and_class`
                                                                      WHERE `age_and_class`.`school_id`= '" . $school_session->schoolId . "'";
                                                            $enrollment = $this->db->query($query)->result()[0]->total;
                                                            if ($enrollment) {
                                                                echo $enrollment;
                                                            } else {
                                                                echo "<strong style='color:red'>Section C Missing</strong>";
                                                            }

                                                            ?></td>

                            <td style="text-align: center;"><?php
                                                            $query = "SELECT COUNT(`schoolStaffId`) as total FROM `school_staff`
                                                            WHERE `school_staff`.`school_id`= '" . $school_session->schoolId . "'";
                                                            echo $this->db->query($query)->result()[0]->total; ?></td>


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
                                if ($school_session->cer_issue_date) {
                                    echo date('d M, y', strtotime($school_session->cer_issue_date));
                                } else {

                                    echo '<small>Pending</small>';
                                }
                                ?></td>
                            <td><?php if ($school_session->primary or $school_session->level_of_school_id == 1) {
                                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                } else {
                                    //echo '<i class="fa fa-times" aria-hidden="true"></i>';
                                } ?>
                            </td>
                            <td><?php if ($school_session->middle or $school_session->level_of_school_id == 2) {
                                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                } else {
                                    // echo '<i class="fa fa-times" aria-hidden="true"></i>';
                                }  ?></td>
                            <td>
                                <?php if ($school_session->high or $school_session->level_of_school_id == 3) {
                                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                } else {
                                    //echo '<i class="fa fa-times" aria-hidden="true"></i>';
                                } ?>
                            </td>
                            <td>
                                <?php if ($school_session->high_sec or $school_session->level_of_school_id == 4) {
                                    echo '<i class="fa fa-check" aria-hidden="true"></i>';
                                } else {
                                    //echo '<i class="fa fa-times" aria-hidden="true"></i>';
                                } ?>
                            </td>
                            <?php if ($school_session->status == 1) { ?>
                                <!-- <td>
                                    <?php

                                    $query = "SELECT * FROM users WHERE users.userId = '" . $school_session->updatedBy . "'";
                                    echo $issued_by = $this->db->query($query)->row()->userTitle;
                                    ?>
                                </td> -->

                                <td>
                                    <form target="_blank" method="post" action="<?php echo site_url("print_file/certificate"); ?>">
                                        <input type="hidden" name="school_id" value="<?php echo $school_session->schoolId ?>" />
                                        <button class="btn btn-link btn-sm">
                                            <?php
                                            if ($school_session->renewal_code) {
                                                echo $school_session->renewal_code;
                                            } else {
                                                if ($school_session->renewal_code == 0 and $school_session->status == 1) {
                                                    echo '<strong>' . $school->registrationNumber . '</strong>';
                                                }
                                            } ?>
                                        </button>
                                    </form>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <?php if ($school_session->status == 2 and $pending == 0) {
                                        $pending = 1;
                                    ?>
                                        <button onclick="get_renewal_issue_interface('<?php echo $school_session->schoolId; ?>')" class="<?php if ($school_session->reg_type_id == 1) { ?> btn btn-success <?php } ?> <?php if ($school_session->reg_type_id == 2) { ?> btn btn-danger <?php } ?> <?php if ($school_session->reg_type_id == 3) { ?> btn btn-primary <?php } ?> <?php if ($school_session->reg_type_id == 4) { ?> btn btn-warning <?php } ?>"><?php echo $school_session->regTypeTitle; ?></button>
                                    <?php } else { ?>
                                        Not Issue Yet
                                    <?php } ?>
                                </td>
                            <?php } ?>


                        <?php } else { ?>

                            <td colspan="14" style="text-align: center; color:#b2aeae;">
                                <small><i> Not applied yet. </i></small>
                            </td>
                        <?php } ?>



                    </tr>
                <?php
                    $previous_max = $max_tuition_fee;
                }
            } else { ?>
                <tr style="color:#b2aeae;">
                    <td colspan="12">
                        Not applied for registartion.
                    </td>
                </tr>
            <?php } ?>

        </table>

    </div>

</div>
<div id="get_renewal_issue_interface"></div>
<script>
    function get_renewal_issue_interface(school_id) {
        $('#get_renewal_issue_interface').html('Please Wait .....');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("mis_dashboard/get_renewal_issue_interface"); ?>",
            data: {
                school_id: school_id,
                schools_id: <?php echo $school->schools_id; ?>
            }
        }).done(function(data) {

            $('#get_renewal_issue_interface').html(data);
        });
    }
</script>

<div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
    <h4> <i class="fa fa-info-circle" aria-hidden="true"></i>
        Session Wise Monthly Tuition Fee
    </h4>
    <div class="table-responsive">
        <table class="table table2 table-bordered" style="font-size:10px">

            <tr>
                <th>Session</th>

                <?php
                $classes = $this->db->query("SELECT * FROM class")->result();
                foreach ($classes  as $class) { ?>
                    <th><?php echo $class->classTitle ?></th>
                <?php } ?>
            </tr>

            <?php foreach ($school_sessions as $school_session) { ?>
                <?php if ($school_session->status > 0) { ?>
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
                                        echo @" <small style='color:red; font-weight: bold;'><br /> <i class='fa fa-line-chart' aria-hidden='true'></i> (" . $incress . " %)</small>";
                                    } else {
                                        // echo @" <small style='color:green'>(" . $incress . " %)</small>";
                                    }
                                } ?>
                                </td>
                        <?php  }
                        } ?>
                    </tr>
                <?php   } else { ?>
                    <tr>
                        <td style="color:#b2aeae;">
                            <a target="new" href="<?php echo site_url("print_file/section_e/" . $school_session->schoolId); ?>">
                                <i class="fa fa-print" aria-hidden="true"></i> <?php echo $school_session->sessionYearTitle ?>
                            </a>
                        </td>
                        <td colspan="21" style="color:#b2aeae;">
                            <small><i> Not applied yet. </i></small>
                        </td>
                    </tr>
                <?php } ?>
            <?php   } ?>


        </table>
    </div>

</div>

<script>
    function lock_editing(school_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>section_access/lock_editing",
            type: "POST",
            data: {
                school_id: school_id,
                schools_id: '<?php echo $school->schools_id ?>'
            },
            success: function(data) {
                console.log(data);
                if (data == 'success') {

                    search(<?php echo $school->schools_id ?>);
                } else {
                    alert('Something went wrong');
                }
            }
        });
    }

    function unlock_editing(school_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>section_access/unlock_editing",
            type: "POST",
            data: {
                school_id: school_id,
                schools_id: '<?php echo $school->schools_id ?>'
            },
            success: function(data) {
                console.log(data);
                if (data == 'success') {

                    search(<?php echo $school->schools_id ?>);
                } else {
                    alert('Something went wrong');
                }
            }
        });
    }
</script>