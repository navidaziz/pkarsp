<form id="myFrmID" method="post">
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
        <div class="row">
            <?php if ($previous_session_level > $school->level_of_school_id and $downgrade == 0) {
                $previous_level = '';
                $current_level = '';
                if ($previous_session_level == 1) {
                    $previous_level = 'Primary';
                }
                if ($previous_session_level == 2) {
                    $previous_level = 'Middle';
                }
                if ($previous_session_level == 3) {
                    $previous_level = 'High';
                }
                if ($previous_session_level == 4) {
                    $previous_level = 'High Secondary';
                }

                if ($school->level_of_school_id == 1) {
                    $current_level = 'Primary';
                }
                if ($school->level_of_school_id == 2) {
                    $current_level = 'Middle';
                }
                if ($school->level_of_school_id == 3) {
                    $current_level = 'High';
                }
                if ($school->level_of_school_id == 4) {
                    $current_level = 'High Secondary';
                }




            ?>
                <div class="col-md-12">
                    <div class="alert alert-warning" role="alert" style="text-align:center">
                        There appears to be an error with the institute's level, as the level of the previous session does not match the current level. It would be greatly appreciated if you could notify the database administrator about this issue. Please provide any additional details about the error and suggest possible actions to resolve it. Thank you.
                    </div>
                </div>
            <?php  } else { ?>
                <div class="col-md-7">

                    <h4><?php echo $title; ?></h4>
                    <table class="table">
                        <tr>
                            <th>Max Fee</th>
                            <th>App Pro Fee</th>
                            <th>Insp. Fee</th>
                            <th>Rene. Fee</th>
                            <?php if ($school->reg_type_id == 4) { ?>
                                <th>Upgrad. Fee</th>
                            <?php } ?>
                            <th>Total Renewal <?php if ($school->reg_type_id == 4) { ?>
                                    + Upgradation
                                <?php } ?>
                                Fee</th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                            FROM `fee` WHERE school_id= '" . $school_id . "'";
                                $max_tuition_fee = $this->db->query($query)->result()[0]->max_tution_fee;
                                $max_tuition_fee = (int) preg_replace('/[^0-9.]/', '', $this->db->query($query)->result()[0]->max_tution_fee);
                                echo $max_tuition_fee;
                                $query = "SELECT * FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' 
                            AND school_type_id = '" . $school->school_type_id . "'
                            ORDER BY fee_min DESC LIMIT 1";
                                $fee = $this->db->query($query)->row();
                                $total_fee = $fee->renewal_app_processsing_fee + $fee->renewal_app_inspection_fee + $fee->renewal_fee;

                                ?>
                            </td>
                            <td><?php echo $fee->renewal_app_processsing_fee; ?></td>
                            <td><?php echo $fee->renewal_app_inspection_fee; ?></td>
                            <td><?php echo $fee->renewal_fee; ?></td>
                            <?php if ($school->reg_type_id == 4) { ?>
                                <td>
                                    <?php echo $fee->up_grad_fee;
                                    $total_fee = $total_fee + $fee->up_grad_fee;
                                    ?>
                                </td>
                            <?php } ?>
                            <td><?php echo $total_dues = $total_fee; ?></td>
                        </tr>
                    </table>

                    <?php
                    $query = "SELECT challan_for FROM `bank_challans` WHERE school_id ='" . $school_id . "' GROUP BY challan_for";
                    $challan_fors = $this->db->query($query)->result();
                    $previous_percentage = "";
                    foreach ($challan_fors as $challan_for) {
                    ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>STAN</th>
                                <th>DATE</th>
                                <th>Dues</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                            </tr>
                            <?php

                            $query = "SELECT challan_no, challan_date, SUM(total_deposit_fee-security_fee) as total_deposit_fee 
                        FROM `bank_challans` WHERE school_id ='" . $school_id . "'
                        AND challan_for='" . $challan_for->challan_for . "'
                        GROUP BY challan_date
                        HAVING SUM(total_deposit_fee-security_fee) > 0;
                        ";
                            //and schools_id ='" . $schools_id . "'";
                            $challans = $this->db->query($query)->result();
                            foreach ($challans as $challan) {
                            ?>
                                <tr>
                                    <td><?php echo $challan->challan_no; ?></td>
                                    <td><?php echo $challan->challan_date;

                                        echo '<span style="margin-left:10px;"></span>';

                                        $query = "SELECT fine_percentage FROM `session_fee_submission_dates` 
                                              WHERE last_date>= '" . $challan->challan_date . "' 
                                              AND school_type_id = '" . $school->school_type_id . "'
                                              AND session_id = '" . $school->session_year_id . "'
                                              ORDER BY last_date ASC LIMIT 1;";
                                        $date_fine = $this->db->query($query)->row();
                                        if ($date_fine) {
                                            $fine_percentage = $date_fine->fine_percentage;
                                            echo $fine_percentage . "%";
                                        } else {
                                            $fine_percentage = 100;
                                            echo $fine_percentage . "%";
                                        }

                                        if ($previous_percentage != $fine_percentage) {
                                            $previous_percentage = $fine_percentage;
                                            $total_dues = ($total_dues + (($fine_percentage * $total_dues) / 100));
                                        }
                                        ?></td>
                                    <td><?php echo $total_dues; ?></td>

                                    <td><?php echo $challan->total_deposit_fee; ?></td>
                                    <td><?php echo $total_dues =  $challan->total_deposit_fee - $total_dues; ?></td>


                                </tr>
                            <?php
                            } ?>
                        </table>
                    <?php } ?>
                    <table class="table table-bordered">

                        <?php

                        $query = "SELECT SUM(total_deposit_fee) as total_deposit_fee FROM `bank_challans` WHERE school_id ='" . $school_id . "'";
                        //and schools_id ='" . $schools_id . "'";
                        $challans = $this->db->query($query)->result();
                        foreach ($challans as $challan) { ?>
                            <tr>
                                <th style="text-align: right;">
                                    Total: <?php echo $challan->total_deposit_fee; ?>
                                </th>

                            </tr>
                        <?php } ?>
                    </table>


                    <table class="" style="font-size: 10px; width:100%">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th colspan="2">
                                    STAN/Date
                                </th>
                                <th colspan="8">
                                    PSRA Fee Heads
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>STAN</th>
                                <th>Date</th>
                                <th>App. Proce.</th>
                                <th>Inspection</th>
                                <th>Renewal</th>
                                <th>Upgradation</th>
                                <th>Late</th>
                                <th>Security</th>
                                <th>Fine</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1; ?>
                            <?php
                            $query = "SELECT * FROM `bank_challans` 
                            WHERE schools_id = '" . $schools_id . "'
                            AND school_id = '" . $school_id . "'";
                            $bank_challans = $this->db->query($query)->result();
                            if ($bank_challans) {
                                foreach ($bank_challans as $bank_challan) { ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $bank_challan->challan_for; ?></td>
                                        <td><?php echo $bank_challan->challan_no; ?></td>
                                        <td><?php echo date('d M, Y', strtotime($bank_challan->challan_date)); ?></td>
                                        <td><?php echo number_format($bank_challan->application_processing_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->inspection_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->renewal_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->upgradation_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->late_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->security_fee); ?></td>
                                        <td><?php echo number_format($bank_challan->fine); ?></td>
                                        <td><?php echo number_format($bank_challan->total_deposit_fee); ?></td>
                                        <!-- <td><?php
                                                    $query = "SELECT * FROM users WHERE userId = '" . $bank_challan->verified_by . "'";
                                                    $verified_by = $this->db->query($query)->result()[0]->userTitle;
                                                    echo $verified_by;
                                                    ?></td> -->
                                    </tr>
                                <?php  } ?>
                            <?php } else { ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $school_session->sessionYearTitle ?></td>
                                    <td colspan="23" style="text-align: center;">
                                        No bank challan has been entered yet.
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>



                </div>

                <div class="col-md-3" style="display: none;">
                    <h4>
                        <?php echo $school->regTypeTitle; ?> for session <?php echo $school->sessionYearTitle; ?> approved by ?
                    </h4>
                    <ul class="list-group">
                        <?php $query = "SELECT * FROM `signatories` WHERE status=1";
                        $signatories = $this->db->query($query)->result();
                        foreach ($signatories as $signatory) { ?>
                            <li class="list-group-item">
                                <input type="radio" name="signatory" value="<?php echo  $signatory->id; ?>" />
                                <strong><?php echo  $signatory->designation; ?></strong> - <?php echo $signatory->name; ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col-md-5">
                    <div style="text-align: center;">


                        <?php
                        if ($school->reg_type_id == 2) {
                            $query = "SELECT * FROM `levelofinstitute` 
                    WHERE levelofInstituteId <= '" . $school->level_of_school_id . "'
                    AND school_type_id = '" . $school->school_type_id . "'
                    ORDER BY `levelofInstituteId` ASC";
                        } else {
                            $query = "SELECT * FROM `levelofinstitute` 
                        WHERE  school_type_id = '" . $school->school_type_id . "'
                        ORDER BY `levelofInstituteId` ASC";
                        }
                        $levels = $this->db->query($query)->result();
                        ?>
                        <?php
                        if ($school->reg_type_id == 3 || $school->reg_type_id == 4) { ?>
                            <h4>
                                Does the note sheet recommend upgrading ?
                                <input required onclick="$('.upgradation').show();" type="radio" name="upgradation" value="yes" /> Yes
                                <spna style="margin-top: 5px;;"></spna>
                                <input required onclick="$('.upgradation').hide();" type="radio" name="upgradation" value="no" /> No
                            </h4>
                        <?php } ?>
                        <table class="table" style="text-align: center;">
                            <tr>
                                <td rowspan="2" style="vertical-align: middle;">Other Levels:</td>
                                <?php foreach ($levels as $level) { ?>
                                    <th style="text-align: center;"> <?php echo $level->levelofInstituteTitle; ?></th>
                                <?php }   ?>
                            </tr>
                            <tr>
                                <?php


                                $session_levels = array();
                                if ($school->primary == 1) {
                                    $session_levels[1] = 1;
                                }
                                if ($school->middle == 1) {
                                    $session_levels[2] = 2;
                                }
                                if ($school->high == 1) {
                                    $session_levels[3] = 3;
                                }
                                if ($school->high_sec == 1) {
                                    $session_levels[4] = 4;
                                }
                                //var_dump($session_levels);

                                $upgradation = "";
                                foreach ($levels as $level) { ?>
                                    <td>
                                        <span <?php if ($level->levelofInstituteId == $school->level_of_school_id) { ?>style='display:none;' <?php } ?>>

                                            <input class="<?php echo $upgradation; ?>" <?php if (in_array($level->levelofInstituteId, $session_levels) and $level->levelofInstituteId <= $school->level_of_school_id) { ?> checked readonly <?php } ?> type="checkbox" name="levels[<?php echo $level->levelofInstituteId; ?>]" />
                                        </span>
                                        <?php if ($level->levelofInstituteId == $school->level_of_school_id) {
                                            $upgradation = "upgradation";
                                        ?>
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        <?php } ?>
                                    </td>
                                <?php }   ?>
                            </tr>
                        </table>
                        <style>
                            .upgradation {
                                display: none;
                            }
                        </style>


                        <button id="submitButton" class="btn btn-danger"> Issue <?php echo $school->regTypeTitle; ?> for session <strong><?php echo $school->sessionYearTitle; ?></strong></button>
                        <div id="Response"></div>

                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#myFrmID').submit(function(e) {

            if (confirm("Are you sure?") == false) {
                return false;
            }
            var url = '<?php echo site_url('mis_dashboard/isssue_renewal'); ?>';
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    console.log(data);
                    const response = JSON.parse(data);
                    if (response.success == true) {
                        search(response.schools_id);
                        //$('#Response').html(response.msg);
                    } else {
                        $error = '<div class="alert alert-warning" style="margin-top:5px"> <i class="fa fa-warning"></i> ' + response.msg + '</div>';
                        $('#Response').html($error);
                    }
                    // Ajax call completed successfully

                },
                error: function(data) {

                    console.log(data);
                    alert("System Error.");
                }
            });
        });
    });
</script>