<style>
    .table2>thead>tr>th,
    .table2>tbody>tr>th,
    .table2>tfoot>tr>th,
    .table2>thead>tr>td,
    .table2>tbody>tr>td,
    .table2>tfoot>tr>td {
        padding: 5px;
        line-height: 1;
        vertical-align: top;
        color: black !important;
        text-align: center;


    }
</style>

<div class="modal-header">
    <h5 class="modal-title pull-left" id="exampleModalLabel">Add bank challan detail</h5>
    <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
<section style="padding:5px">
    <div class="row">
        <div class="col-md-7">
            <div style="border:1px solid #CCCCCC; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; back ground-color: white;">
                <h4><?php echo ucwords(strtolower($school->schoolName)); ?></h4>
                <h6> School ID: <?php echo $school->schools_id ?>
                    <?php if ($school->registrationNumber > 0) { ?> <span style="margin-left: 20px;"></span> Reg. ID:
                        <?php echo $school->registrationNumber ?>
                    <?php } ?>
                    <span style="margin-left: 20px;"></span>
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
                </h6>
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
                    <?php if ($school->ucTitle) {
                        echo " / <strong>" . $school->address . "</strong>";
                    } ?>
                </small>
                <hr />

                <?php
                $query = "SELECT
        `reg_type`.`regTypeTitle`,
        `levelofinstitute`.`levelofInstituteTitle`,
        `session_year`.`sessionYearTitle`,
        `session_year`.`sessionYearId`,
        `school`.`renewal_code`,
        `school`.`schoolId`,
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
        school.reg_type_id,
        school.file_status
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
         AND schoolId = " . $school_id . "
        AND school.status = 2
        ";
                $school_session = $this->db->query($query)->row();
                ?>
                <?php
                $query = "SELECT max(CONVERT(tuitionFee, SIGNED INTEGER)) as max_tution_fee  
                              FROM `fee` WHERE school_id = '" . $school_id . "'";
                $max_tuition_fee = $this->db->query($query)->row()->max_tution_fee;
                $max_tuition_fee = (int) preg_replace('/[^0-9.]/', '', $max_tuition_fee);
                ?>
                <h6>Max tuition fee charge by school for session <?php echo $school_session->sessionYearTitle; ?>: <?php echo $max_tuition_fee . " Rs. Per Month"; ?></h6>
                <p>School administration apply for session <?php echo $school_session->sessionYearTitle; ?>
                    <?php echo $school_session->regTypeTitle; ?> level <?php echo $school_session->levelofInstituteTitle; ?> and submit the following Challan detail.
                </p>

                <table class="table">
                    <tr>
                        <td>
                            <h5>School Submitted STAN and Date</h5>
                            <ul>
                                <ol><?php
                                    $query = "SELECT `bt_no`, `bt_date` FROM bank_transaction WHERE school_id='" . $school_session->schoolId . "'";
                                    $challans = $this->db->query($query)->result();
                                    foreach ($challans as $challan) { ?>
                                        <li> STAN: <?php echo $challan->bt_no ?> Date: <?php echo date('d/m/Y', strtotime($challan->bt_date)) ?> </li>
                                    <?php  } ?>
                                </ol>
                            </ul>
                        </td>
                        <td>



                        </td>
                    </tr>
                </table>




            </div>

        </div>
        <div class="col-md-5">
            <?php
            $query = "SELECT fee_min, fee_max, renewal_app_processsing_fee, renewal_app_inspection_fee, renewal_fee, up_grad_fee 
    FROM `fee_structure` WHERE fee_min <= '" . $max_tuition_fee . "' ORDER BY fee_min DESC LIMIT 1";
            $fee_sturucture = $this->db->query($query)->result()[0];
            $query = "SELECT * FROM `session_fee_submission_dates` WHERE session_id = '" . $school_session->sessionYearId . "'";
            $session_fee_submission_dates = $this->db->query($query)->result();

            ?>
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <h6>Session: <?php echo $school_session->sessionYearTitle; ?>
                    <?php echo $school_session->regTypeTitle; ?>
                    Fee Detail</h6>
                <table class="table table_reg" style="font-size: 9px;">
                    <tr>
                        <th style="width: 130px;"> Due's Date </th>
                        <th>Application Pro. Fee</th>
                        <th>Renewal Fee</th>
                        <th>Inspection Fee</th>

                        <?php if ($this->input->post('challan_type') == 'renewal_upgradation') { ?>
                            <th>Upgradation Fee</th>
                        <?php } ?>
                        <th style="width: 130px;"> Late Fee</th>
                        <th> Total </th>
                    </tr>
                    <?php
                    $count = 1;
                    $previous_last_date = '';
                    foreach ($session_fee_submission_dates as $session_fee_submission_date) {
                        $total = $fee_sturucture->renewal_app_processsing_fee + $fee_sturucture->renewal_app_inspection_fee + $fee_sturucture->renewal_fee;
                        if ($this->input->post('challan_type') == 'renewal_upgradation') {
                            $total += $fee_sturucture->up_grad_fee;
                        }
                    ?>

                        <tr>
                            <td style="width: 210px;">

                                <?php if ($count == 1) { ?> <strong> 01 Apr, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to <?php } else { ?>
                                    <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
                                        After
                                    <?php } else { ?>
                                        <strong> <?php echo $previous_last_date; ?> </strong> to
                                    <?php } ?>
                                <?php } ?>
                                <strong>
                                    <?php
                                    $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
                                    if ($count >= sizeof($session_fee_submission_dates)) {
                                        echo date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day'));
                                    } else {

                                        echo date('d M, Y', strtotime($session_fee_submission_date->last_date));
                                    }
                                    ?>
                                </strong>
                            </td>
                            <td><?php echo number_format($fee_sturucture->renewal_app_processsing_fee); ?></td>
                            <td><?php echo number_format($fee_sturucture->renewal_fee); ?></td>
                            <td><?php echo number_format($fee_sturucture->renewal_app_inspection_fee); ?></td>


                            <?php if ($this->input->post('challan_type') == 'renewal_upgradation') { ?>
                                <td><?php echo $fee_sturucture->up_grad_fee; ?></td>
                            <?php } ?>

                            <td><?php echo $session_fee_submission_date->fine_percentage; ?> % - <?php
                                                                                                    $fine = 0;
                                                                                                    $fine = ($session_fee_submission_date->fine_percentage * $total) / 100;
                                                                                                    echo number_format($fine);
                                                                                                    ?>
                            </td>

                            <td>
                                <strong> <?php echo number_format($fine + $total);  ?> </strong>
                            </td>
                        </tr>



                    <?php
                        $count++;
                    } ?>

                </table>



            </div>

        </div>


    </div>


    <div class="row">
        <div class="col-md-12">
            <div id="stan_error"></div>
            <table class="table table2 table-bordered">

                <tr>

                    <th style="text-align: center; back-ground-color:#CCFFFF !important; width:50px ">Challan For</th>
                    <th style="text-align: center; back-ground-color:lightpink !important; ">STAN No</th>
                    <th style="text-align: center; back-ground-color:lightpink !important; ">Date</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Application Pro. Fee</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Renewal Fee</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Inspection Fee</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Upgradation Fee</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Late Fee</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Fine</th>
                    <th style="text-align: center; back-ground-color:lightgreen !important;">Security</th>
                    <!-- <th style="text-align: center; back-ground-color:gray !important;">Penalty</th>
            <th style="text-align: center; back-ground-color:lightgray !important;">Miscellaneous</th> -->
                    <th style="text-align: center;">Total</th>
                    <th>Action</th>
                </tr>
                <?php
                $previous_max = NULL;
                $count = 0;
                $school_ids = '';
                if ($school_session) { ?>

                    <tr>
                        <td style="text-align: center; back-ground-color:#CCFFFF !important; width:50px ">

                            <select class="challan_heads" style="width: 100px;" id="challan_for_<?php echo $school_session->schoolId; ?>" data-index="<?php echo $count++; ?>" autofocus>
                                <?php if ($school->registrationNumber <= 0) { ?>
                                    <option value="Registration">Registration</option>
                                <?php } else { ?>
                                    <option value="">Challan For</option>
                                    <option <?php if ($school_session->reg_type_id == 2) { ?> selected <?php } ?> value="Renewal">Renewal</option>
                                    <option <?php if ($school_session->reg_type_id == 4) { ?> selected <?php } ?> value="Upgradation Renewal">Upgradation Renewal</option>
                                    <option <?php if ($school_session->reg_type_id == 3) { ?> selected <?php } ?> value="Upgradation">Upgradation</option>
                                <?php } ?>
                            </select>

                        </td>

                        <td style="text-align: center; back-ground-color:lightpink !important; ">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_no_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightpink !important; ">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" id="stan_date_<?php echo $school_session->schoolId; ?>" style="width: 100px;" type="date" max="<?php echo date("Y-m-d"); ?>" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="application_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="renewal_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="inspection_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="upgradation_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="late_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="fine_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>
                        <td style="text-align: center; back-ground-color:lightgreen !important;">
                            <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="security_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                        </td>

                        <!-- <td style="text-align: center; back-ground-color:gray !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="penalty_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td>
                    <td style="text-align: center; back-ground-color:lightgray !important;">
                        <input class="challan_heads" data-index="<?php echo $count++; ?>" onkeyup="add_all_heads('<?php echo $school_session->schoolId; ?>')" id="miscellaneous_<?php echo $school_session->schoolId; ?>" style="width: 80px;" type="number" value="0" />
                    </td> -->
                        <th id="total_<?php echo $school_session->schoolId; ?>" style="min-width:80px; text-align:center">0.00</th>
                        <th><input class="challan_heads" data-index="<?php echo $count++; ?>" onclick="add_bank_stan_no('<?php echo $school_session->schoolId; ?>')" type="button" name="add" value="Add" /> </th>
                    </tr>
                    <?php

                    $query = "SELECT * FROM bank_challans WHERE school_id = '" . $school_session->schoolId . "' and schools_id = " . $schoolid . "";
                    $challans = $this->db->query($query)->result();
                    foreach ($challans as $challan) {
                        $bank_challan_id = $challan->bank_challan_id;
                        $school_ids .= $challan->school_id . ',';
                    ?>
                        <tr id="<?php echo $bank_challan_id . "_row"; ?>">

                            <td><?php echo $challan->challan_for; ?></td>
                            <td><?php echo $challan->challan_no; ?></td>
                            <td><?php echo date("d M, Y", strtotime($challan->challan_date)); ?></td>
                            <td><?php echo number_format($challan->application_processing_fee, 2); ?></td>
                            <td><?php echo number_format($challan->renewal_fee, 2); ?></td>
                            <td><?php echo number_format($challan->inspection_fee, 2); ?></td>
                            <td><?php echo number_format($challan->upgradation_fee, 2); ?></td>
                            <td><?php echo number_format($challan->late_fee, 2); ?></td>
                            <td><?php echo number_format($challan->fine, 2); ?></td>
                            <td><?php echo number_format($challan->security_fee, 2); ?></td>
                            <!-- <td><?php echo number_format($challan->penalty, 2); ?></td>
                        <td><?php echo number_format($challan->miscellaneous, 2); ?></td> -->
                            <td><?php echo number_format($challan->total_deposit_fee, 2); ?></td>
                            <td><a href="#" onclick="$('#<?php echo $bank_challan_id . "_edit"; ?>').show();$('#<?php echo $bank_challan_id . "_row"; ?>').hide();">Edit</a></td>
                        </tr>

                        <tr style="display: none;" id="<?php echo $bank_challan_id . "_edit"; ?>">

                            <td style="text-align: center; back ground-color:#CCFFFF !important; ">
                                <select id="challan_for">

                                    <option value="">Challan For</option>
                                    <option value="Registration" <?php if ($challan->challan_for == 'Registration') { ?> selected <?php } ?>>Registration</option>
                                    <option value="Renewal" <?php if ($challan->challan_for == 'Renewal') { ?> selected <?php } ?>>Renewal</option>
                                    <option value="Upgradation Renewal" <?php if ($challan->challan_for == 'Upgradation Renewal') { ?> selected <?php } ?>>Upgradation Renewal</option>
                                    <option value="Upgradation" <?php if ($challan->challan_for == 'Upgradation') { ?> selected <?php } ?>>Upgradation</option>

                                </select>

                            </td>
                            <td style="text-align: center; back ground-color:lightpink !important; ">
                                <input value="<?php echo $challan->challan_no; ?>" id="stan_no_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" />
                            </td>
                            <td style="text-align: center; back ground-color:lightpink !important; ">
                                <input value="<?php echo $challan->challan_date; ?>" id="stan_date_<?php echo $bank_challan_id; ?>" style="width: 100px;" type="date" max="<?php echo date("Y-m-d"); ?>" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->application_processing_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="application_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->renewal_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="renewal_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->inspection_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="inspection_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->upgradation_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="upgradation_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->late_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="late_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->fine; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="fine_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>
                            <td style="text-align: center; back ground-color:lightgreen !important;">
                                <input value="<?php echo $challan->security_fee; ?>" onkeyup="add_all_heads('<?php echo $bank_challan_id; ?>')" id="security_<?php echo $bank_challan_id; ?>" style="width: 80px;" type="number" value="0" />
                            </td>

                            <th id="total_<?php echo $bank_challan_id; ?>" style="min-width:80px; text-align:center">
                                <?php echo number_format($challan->total_deposit_fee, 2); ?>
                            </th>
                            <td><input onclick="update_bank_challan('<?php echo $bank_challan_id; ?>')" type="button" name="Update" value="Update" /> </td>
                        </tr>

                    <?php } ?>


                <?php
                    $previous_max = $max_tuition_fee;
                } else { ?>
                    <tr>
                        <td colspan="12">
                            Not applied for registartion.
                        </td>
                    </tr>
                <?php }
                //@$school_session->schoolId = 0;
                ?>


            </table>
            <div style="text-align: center;" style="margin-bottom: 5px;">

                <?php if ($school_session->file_status == 5) { ?>
                    <div class="alert alert-warning" role="alert">
                        Marked as deficient case. <button onclick="$('#deficiency_message').toggle();" class="btn btn-link btn-sm" style="color:red;">View Deficiency Message</button>
                    </div>
                <?php } else { ?>
                    <button onclick="$('#deficiency_message').toggle();" class="btn btn-danger btn-sm">Send Deficiency Message</button>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row" id="deficiency_message" style="display: none; margin-top:5px">

        <div class="col-md-6" style="">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 5px; background-color: white;">
                <?php
                $query =
                    "SELECT COUNT(`message_for_all`.`message_id`) as total FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$schoolid";
                $query_result = $this->db->query($query);
                $total_messages = $query_result->result()[0]->total; ?>

                <h5><i class="fa fa-envelope-o"></i> Inbox Messages
                    <span class="label label-primary float-right"><?php echo $total_messages; ?></span>
                </h5>


                <?php
                $query =
                    "SELECT message_for_all.*,`message_school`.`school_id` FROM `message_for_all`
                     left join message_school on `message_for_all`.`message_id`=`message_school`.`message_id`
                     where `message_school`.`school_id`=$schoolid  order by `message_for_all`.`message_id` DESC LIMIT 10";
                $query_result = $this->db->query($query);
                $school_messages = $query_result->result(); ?>
                <table class="table">
                    <?php
                    foreach ($school_messages as $message) : ?>
                        <tr>

                            <td class=" message">
                                <a target="_new" href="<?php echo base_url('messages/school_message_details/'); ?><?php echo $message->message_id; ?>">
                                    <small><?php echo $message->subject; ?></small>
                                </a>
                                <small style="display: block; color:gray" class="float-right">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <?php echo date("d M, Y", strtotime($message->created_date)); ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </table>
                <?php if ($total_messages > 6) { ?>
                    <!-- <div style="text-align: center;">
                        <a class="btn btn-primary btn-sm" href="<?php echo site_url('messages/inbox'); ?>"><i class="fa fa-envelope-o"></i> All Inbox Messages</a>
                    </div> -->
                <?php } ?>
            </div>

        </div>
        <div class="col-md-6">

            <div style="border:1px solid #CCCCCC; border-radius: 10px; min-height: 100px;">
                <form id="send_deficency_message" method="post" enctype="multipart/form-data" action="<?php echo site_url("online_cases/sent_message") ?>">
                    <input type="hidden" name="school_id_for_message" id="school_id_for_message" value="<?php echo $school->schools_id ?>">
                    <input type="hidden" name="deficiency_reason" value="Fee Deficiency">
                    <input required="required" type="hidden" class="is_deficiency_message" name="is_deficiency_message" value="1">
                    <input required="required" type="hidden" class="school_session_id" name="school_session_id" value="<?php echo $school_id; ?>">


                    <div style="margin-left:10px; " class="well well-sm" id="selection">
                        <p style="text-align:center;">
                            Message Send To : <strong><?php echo ucwords(strtolower($school->schoolName)); ?></strong>
                        </p>

                        <div class="box-body">
                            <div class="  form-group col-sm-12">
                                <div class="">
                                    <label for="subject" class="control-label">Subject</label>
                                    <input type="text" required="required" placeholder="Subject" name="subject" id="subject" class="form-control">
                                </div>

                            </div>
                            <div class="  form-group col-sm-12">
                                <div class="">
                                    <label for="name" class=" control-label">Type Your Message Here</label>
                                    <textarea placeholder="Type Your Message Here" name="discription" class="form-control" rows="5"></textarea>

                                </div>

                            </div>
                            <div class="form-group col-sm-12">
                                <div style="text-align: right;">
                                    <button type="submit" class="btn btn-primary btn-flat">Send Deficiency Message</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <a class="btn btn-secondary " href="<?php echo $_SERVER['HTTP_REFERER']; //echo site_url("online_cases/combine_note_sheet/" . $school->schools_id) 
                                            ?>" class="close" aria-label="Close">Close</a>

    </div>
</section>

<script>
    // this is the id of the form
    $("#send_deficency_message").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                add_bank_challan('<?php echo $school_id; ?>');
            }
        });

    });


    $(document).ready(function() {
        //here  value for this is the document object and the id is not useful.
        $(".challan_heads").on('keyup', function(e) {

            if (e.key === 'Enter') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

            }
            if (e.key === 'ArrowLeft') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index - 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

            }

            if (e.key === 'ArrowRight') {

                event.preventDefault();
                var $this = $(event.target);
                var index = parseFloat($this.attr('data-index'));
                $('[data-index="' + (index + 1).toString() + '"]').focus();
                var value = $('[data-index="' + (index + 1).toString() + '"]').val();
                if (value == '0') {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                } else {
                    $('[data-index="' + (index + 1).toString() + '"]').val('');
                    $('[data-index="' + (index + 1).toString() + '"]').val(value);
                }

            }



        });
    });




    function formatMoney(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
            decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;

        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }

    // document.getElementById("b").addEventListener("click", event => {
    //     document.getElementById("x").innerText = "Result was: " + formatMoney(document.getElementById("d").value);
    // });

    var total = 0;

    function add_all_heads(school_session_id) {


        //var statn_number = $('#stan_no_' + school_session_id).val();
        //var date_of_deposit = $('#stan_date_' + school_session_id).val();
        application_fee = parseInt($('#application_' + school_session_id).val());
        if (isNaN(application_fee)) application_fee = 0;
        renewal_fee = parseInt($('#renewal_' + school_session_id).val());
        if (isNaN(renewal_fee)) renewal_fee = 0;
        inspection_fee = parseInt($('#inspection_' + school_session_id).val());
        if (isNaN(inspection_fee)) inspection_fee = 0;
        upgradation_fee = parseInt($('#upgradation_' + school_session_id).val());
        if (isNaN(upgradation_fee)) upgradation_fee = 0;
        security = parseInt($('#security_' + school_session_id).val());
        if (isNaN(security)) security = 0;
        late_fee = parseInt($('#late_' + school_session_id).val());
        if (isNaN(late_fee)) late_fee = 0;
        change_of_name = parseInt($('#name_' + school_session_id).val());
        if (isNaN(change_of_name)) change_of_name = 0;
        change_of_building = parseInt($('#building_' + school_session_id).val());
        if (isNaN(change_of_building)) change_of_building = 0;
        change_of_ownership = parseInt($('#ownership_' + school_session_id).val());
        if (isNaN(change_of_ownership)) change_of_ownership = 0;
        penalty = parseInt($('#penalty_' + school_session_id).val());
        if (isNaN(penalty)) penalty = 0;
        miscellaneous = parseInt($('#miscellaneous_' + school_session_id).val());
        if (isNaN(miscellaneous)) miscellaneous = 0;
        fine = parseInt($('#fine_' + school_session_id).val());
        if (isNaN(fine)) fine = 0;
        total = application_fee + renewal_fee + inspection_fee + upgradation_fee + security + late_fee + change_of_name + change_of_building + change_of_ownership + penalty + miscellaneous + fine;

        $('#total_' + school_session_id).html(formatMoney(total, 2, ".", ","));


    }





    function edit_bank_challan(bank_challan_id) {

        $.ajax({
                method: "POST",
                url: "<?php echo site_url('online_cases/edit_bank_challan'); ?>",
                data: {
                    bank_challan_id: bank_challan_id
                },
            })
            .done(function(respose) {
                $('#request_detail_body').html(respose);
                // $('#modal').modal('show');
                // $('#modal_title').html("Edit Bank Challan");
                // $('#modal_body').html(respose);
                $('#request_detail').modal('show');

            });


    }

    function add_bank_stan_no(school_session_id) {


        challan_for = $("#challan_for_" + school_session_id).val();
        // alert(challan_for);
        if (challan_for == '') {
            alert("Challan for field is required.");
            return false;
        }
        var statn_number = $('#stan_no_' + school_session_id).val();
        var date_of_deposit = $('#stan_date_' + school_session_id).val();
        application_fee = parseInt($('#application_' + school_session_id).val());
        if (isNaN(application_fee)) application_fee = 0;
        renewal_fee = parseInt($('#renewal_' + school_session_id).val());
        if (isNaN(renewal_fee)) renewal_fee = 0;
        inspection_fee = parseInt($('#inspection_' + school_session_id).val());
        if (isNaN(inspection_fee)) inspection_fee = 0;
        upgradation_fee = parseInt($('#upgradation_' + school_session_id).val());
        if (isNaN(upgradation_fee)) upgradation_fee = 0;
        security = parseInt($('#security_' + school_session_id).val());
        if (isNaN(security)) security = 0;
        late_fee = parseInt($('#late_' + school_session_id).val());
        if (isNaN(late_fee)) late_fee = 0;
        change_of_name = parseInt($('#name_' + school_session_id).val());
        if (isNaN(change_of_name)) change_of_name = 0;
        change_of_building = parseInt($('#building_' + school_session_id).val());
        if (isNaN(change_of_building)) change_of_building = 0;
        change_of_ownership = parseInt($('#ownership_' + school_session_id).val());
        if (isNaN(change_of_ownership)) change_of_ownership = 0;
        penalty = parseInt($('#penalty_' + school_session_id).val());
        if (isNaN(penalty)) penalty = 0;
        miscellaneous = parseInt($('#miscellaneous_' + school_session_id).val());
        if (isNaN(miscellaneous)) miscellaneous = 0;
        fine = parseInt($('#fine_' + school_session_id).val());
        if (isNaN(fine)) fine = 0;

        var total = application_fee + renewal_fee + inspection_fee + upgradation_fee + security + late_fee + change_of_name + change_of_building + change_of_ownership + penalty + miscellaneous + fine;
        if (isNaN(total)) total = 0;


        if (statn_number == "") {
            alert("STAN No is required.");
            return false;
        }
        if (statn_number.toString().length < 4) {
            alert("STAN number is not less than 4 digit.");
            return false;
        }

        if (date_of_deposit == "") {
            alert("Date of deposit is required.");
            return false;
        }


        if (total == 0) {
            alert("Enter bank challan amount detail.");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>online_cases/add_stan_number",
                type: "POST",
                data: {
                    school_session_id: school_session_id,
                    school_id: <?php echo $schoolid; ?>,
                    statn_number: statn_number,
                    date_of_deposit: date_of_deposit,
                    application_fee: application_fee,
                    renewal_fee: renewal_fee,
                    inspection_fee: inspection_fee,
                    upgradation_fee: upgradation_fee,
                    security: security,
                    late_fee: late_fee,
                    change_of_name: change_of_name,
                    change_of_building: change_of_building,
                    change_of_ownership: change_of_ownership,
                    penalty: penalty,
                    miscellaneous: miscellaneous,
                    fine: fine,
                    challan_for: challan_for
                },
                success: function(data) {
                    console.log(data);
                    if (data == 'success') {
                        add_bank_challan('<?php echo $school_id; ?>');
                    } else {
                        //alert(data);
                        $('#stan_error').html(data);
                    }
                }
            });
        }


    }

    function update_bank_challan(school_session_id) {

        challan_for = $("#challan_for").val();
        // alert(challan_for);
        if (challan_for == '') {
            alert("Challan for field is required.");
            return false;
        }
        var statn_number = $('#stan_no_' + school_session_id).val();
        var date_of_deposit = $('#stan_date_' + school_session_id).val();
        application_fee = parseInt($('#application_' + school_session_id).val());
        if (isNaN(application_fee)) application_fee = 0;
        renewal_fee = parseInt($('#renewal_' + school_session_id).val());
        if (isNaN(renewal_fee)) renewal_fee = 0;
        inspection_fee = parseInt($('#inspection_' + school_session_id).val());
        if (isNaN(inspection_fee)) inspection_fee = 0;
        upgradation_fee = parseInt($('#upgradation_' + school_session_id).val());
        if (isNaN(upgradation_fee)) upgradation_fee = 0;
        security = parseInt($('#security_' + school_session_id).val());
        if (isNaN(security)) security = 0;
        late_fee = parseInt($('#late_' + school_session_id).val());
        if (isNaN(late_fee)) late_fee = 0;
        change_of_name = parseInt($('#name_' + school_session_id).val());
        if (isNaN(change_of_name)) change_of_name = 0;
        change_of_building = parseInt($('#building_' + school_session_id).val());
        if (isNaN(change_of_building)) change_of_building = 0;
        change_of_ownership = parseInt($('#ownership_' + school_session_id).val());
        if (isNaN(change_of_ownership)) change_of_ownership = 0;
        penalty = parseInt($('#penalty_' + school_session_id).val());
        if (isNaN(penalty)) penalty = 0;
        miscellaneous = parseInt($('#miscellaneous_' + school_session_id).val());
        if (isNaN(miscellaneous)) miscellaneous = 0;
        fine = parseInt($('#fine_' + school_session_id).val());
        if (isNaN(fine)) fine = 0;

        var total = application_fee + renewal_fee + inspection_fee + upgradation_fee + security + late_fee + change_of_name + change_of_building + change_of_ownership + penalty + miscellaneous + fine;
        if (isNaN(total)) total = 0;


        if (statn_number == "") {
            alert("STAN No is required.");
            return false;
        }
        if (statn_number.toString().length < 4) {
            alert("STAN number is not less than 4 digit.");
            return false;
        }

        if (date_of_deposit == "") {
            alert("Date of deposit is required.");
            return false;
        }


        if (total == 0) {
            alert("Enter bank challan amount detail.");
        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>online_cases/update_bank_challan",
                type: "POST",
                data: {

                    bank_challan_id: school_session_id,
                    statn_number: statn_number,
                    date_of_deposit: date_of_deposit,
                    application_fee: application_fee,
                    renewal_fee: renewal_fee,
                    inspection_fee: inspection_fee,
                    upgradation_fee: upgradation_fee,
                    security: security,
                    late_fee: late_fee,
                    change_of_name: change_of_name,
                    change_of_building: change_of_building,
                    change_of_ownership: change_of_ownership,
                    penalty: penalty,
                    miscellaneous: miscellaneous,
                    fine: fine,
                    challan_for: challan_for
                },
                success: function(data) {
                    console.log(data);
                    if (data == 'success') {
                        add_bank_challan('<?php echo $school_id; ?>');
                    } else {
                        alert(data);
                    }
                }
            });
        }


    }
</script>