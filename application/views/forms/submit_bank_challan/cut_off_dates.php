<div class="row">
    <div class="col-md-6">
        <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 200px;  margin: 5px; padding: 5px; background-color: white;">
            <h4>Session: <?php echo $session_detail->sessionYearTitle; ?> Cutoff Dates</h4>
            <table class="table table-bordered">
                <tr>
                    <th>S/No</th>
                    <th>Last Date</th>
                    <th>Fine's</th>
                </tr>
                <?php
                $s_no = 1;
                $count = 1;
                $previous_last_date = "";
                foreach ($session_fee_submission_dates as $session_fee_submission_date) { ?>
                    <tr>
                        <td><?php echo $s_no++; ?></td>
                        <td style="width: 200px;">
                            <?php if ($count == 1) { ?>

                                <!-- <strong> 01 Apr, <?php echo date('Y', strtotime($session_fee_submission_date->last_date)); ?></strong> to  -->

                            <?php } else { ?>
                                <?php if ($count >= sizeof($session_fee_submission_dates)) { ?>
                                    After
                                <?php } else { ?>
                                    <strong> <strong> <?php echo $previous_last_date; ?> </strong> to </strong> to
                                <?php } ?>
                            <?php } ?>
                            <?php
                            $previous_last_date = date('d M, Y', strtotime($session_fee_submission_date->last_date . ' +1 day'));
                            if ($count >= sizeof($session_fee_submission_dates)) {
                                echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date . '-1 day')) . "</strong>";
                            } else {
                                echo "<strong>" . date('d M, Y', strtotime($session_fee_submission_date->last_date)) . "</strong>";
                            }
                            ?>


                        </td>
                        <td>
                            <?php
                            if ($session_fee_submission_date->fine_percentage != 'fine') { ?>
                                <?php echo $session_fee_submission_date->fine_percentage; ?> %
                            <?php } else { ?>
                                <?php echo $session_fee_submission_date->detail; ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                    $count++;
                }
                ?>

                <?php
                $pecial_fine = 0;
                if ($session_id == 1 and $school->reg_type_id == 1) { ?>
                    <tr>
                        <td colspan="3" style="text-align: center;"> Settle Areas 2018-19 Special Fine : 1 Dec, 2019
                            <br />
                            <strong>50,000 Rs.</strong>: Primary / Middle Level<br />
                            <strong>200,000 Rs. </strong>: High / Higher Level
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;"> FATA 2018-19 Special Fine : 01 Jan, 2020
                            <br />
                            <strong>50,000 Rs.</strong>: Primary / Middle Level<br />
                            <strong>200,000 Rs. </strong>: High / Higher Level
                            <br />
                            <br />
                            <br />
                        </td>
                    </tr>



                <?php
                    if ($school->level_of_school_id == 1  or  $school->level_of_school_id == 2) {
                        $special_fine = 50000;
                    }
                    if ($school->level_of_school_id == 3  or  $school->level_of_school_id == 4) {
                        $special_fine = 200000;
                    }
                } ?>




            </table>
        </div>
    </div>
</div>