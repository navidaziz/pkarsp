<?php
$user_id = $this->session->userdata('userId');
$query = "SELECT `users`.`region_ids` FROM `users`
        WHERE `users`.`userId` = '" . $user_id . "'";
$region_ids = $this->db->query($query)->row()->region_ids;
?>
<div class="row">
    <div class="col-md-12">
        <strong>Region Wise Visit/Visit Pending Report (New Registration and Upgradation)</strong>
        <table class="table table-bordered" style="text-align:center; font-size:10px" id="test _table">
            <thead>
                <tr>
                    <th style="text-align: center;">Session</th>
                    <th style="text-align: center;">Total Registration+Upgradation</th>
                    <td>Registration</td>
                    <td>Not Define</td>
                    <td>Visited</td>
                    <td>Not Visited</td>
                    <td>Upgradation</td>
                    <td>Not Define</td>
                    <td>Visited</td>
                    <td>Not Visited</td>
                </tr>
            </thead>

            <tbody>

                <?php
                $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                   sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_define`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_define`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ") ";
                if ($institute_type_id) {
                    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                }
                if ($this->input->post('level_id')) {
                    $level_id = (int) $this->input->post('level_id');
                    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                }
                $query .= " group by `district`.`new_region`";
                $pending_files = $this->db->query($query)->result();
                foreach ($pending_files as $pending) { ?>
                    <tr>
                        <th style="text-align: center;"><?php echo $pending->region; ?></th>
                        <td><?php echo $pending->reg_upg_total; ?></td>

                        <td><?php echo $pending->registrations; ?></td>
                        <td><?php echo $pending->reg_not_define; ?></td>
                        <td><?php echo $pending->reg_visited_yes; ?></td>
                        <td><?php echo $pending->reg_visited_no; ?></td>

                        <td><?php echo $pending->re_up; ?></td>
                        <td><?php echo $pending->re_up_not_define; ?></td>
                        <td><?php echo $pending->re_up_visited_yes; ?></td>
                        <td><?php echo $pending->re_up_visited_no; ?></td>


                    </tr>
                <?php } ?>

            </tbody>
            <tfoot>
                <?php
                $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_define`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
                 sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_define`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
                 sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`
                 from (((`school` 
                 join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                 join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                 join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                 WHERE `district`.`new_region` IN (" . $region_ids . ") ";
                if ($institute_type_id) {
                    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                }
                if ($this->input->post('level_id')) {
                    $level_id = (int) $this->input->post('level_id');
                    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                }
                $query .= " group by `district`.`new_region`";

                $pending = $this->db->query($query)->row(); ?>
                <tr>
                    <th style="text-align: center;">Total</th>
                    <th style="text-align: center;"><?php echo $pending->reg_upg_total; ?></th>

                    <th style="text-align: center;"><?php echo $pending->registrations; ?></th>
                    <th style="text-align: center;"><?php echo $pending->reg_not_define; ?></th>
                    <th style="text-align: center;"><?php echo $pending->reg_visited_yes; ?></th>
                    <th style="text-align: center;"><?php echo $pending->reg_visited_no; ?></th>

                    <th style="text-align: center;"><?php echo $pending->re_up; ?></th>
                    <th style="text-align: center;"><?php echo $pending->re_up_not_define; ?></th>
                    <th style="text-align: center;"><?php echo $pending->re_up_visited_yes; ?></th>
                    <th style="text-align: center;"><?php echo $pending->re_up_visited_no; ?></th>


                </tr>
            </tfoot>

        </table>

    </div>
    <div class="col-md-5">
        <div class="blo ck_div">
            <strong>Region Wise Progress Summary Report </strong>
            <div class="table-responsive">


                <table class="table table-bordered" style="text-align:center; font-size:10px" id="test _table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Region</th>
                            <th style="text-align: center;">Applied</th>
                            <th style="text-align: center;">Pending (Queue)</th>
                            <th style="text-align: center;">Total Pending</th>
                            <td>Reg.</td>
                            <td>Ren.+Upgr</td>
                            <td>Upgr</td>
                            <td>Renewal</td>
                            <td>Fin.Deficients</td>
                            <td>(10%)</td>
                            <td>Issue Pending</td>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ") ";
                        if ($institute_type_id) {
                            $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                        }
                        if ($this->input->post('level_id')) {
                            $level_id = (int) $this->input->post('level_id');
                            $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                        }
                        $query .= " group by `district`.`new_region`";
                        $pending_files = $this->db->query($query)->result();
                        foreach ($pending_files as $pending) { ?>
                            <tr>
                                <th style="text-align: center;"><?php echo $pending->region; ?></th>
                                <td><?php echo $pending->total_applied; ?></td>
                                <td><?php echo $pending->previous_pending; ?></td>
                                <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                                <td><?php echo $pending->registrations; ?></td>
                                <td><?php echo $pending->renewal_pgradations; ?></td>
                                <td><?php echo $pending->upgradations; ?></td>
                                <td><?php echo $pending->renewals; ?></td>
                                <td><?php echo $pending->financially_deficient; ?></td>
                                <td><?php echo $pending->marked_to_operation_wing; ?></td>
                                <td><?php echo $pending->completed_pending; ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                    <tfoot>
                        <?php
                        $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ") ";
                        if ($institute_type_id) {
                            $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                        }
                        if ($this->input->post('level_id')) {
                            $level_id = (int) $this->input->post('level_id');
                            $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                        }

                        $pending = $this->db->query($query)->row(); ?>
                        <tr>
                            <th style="text-align: right;">Total: </th>
                            <td><?php echo $pending->total_applied; ?></td>
                            <td><?php echo $pending->previous_pending; ?></td>
                            <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                            <td><?php echo $pending->registrations; ?></td>
                            <td><?php echo $pending->renewal_pgradations; ?></td>
                            <td><?php echo $pending->upgradations; ?></td>
                            <td><?php echo $pending->renewals; ?></td>
                            <td><?php echo $pending->financially_deficient; ?></td>
                            <td><?php echo $pending->marked_to_operation_wing; ?></td>
                            <td><?php echo $pending->completed_pending; ?></td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="blo ck_div">
            <strong>Session Wise Progress Summary Report </strong>
            <div class="table-responsive">

                <table class="table table-bordered" style="text-align:center; font-size:10px" id="test _table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Session</th>
                            <th style="text-align: center;">Applied</th>
                            <th style="text-align: center;">Pending (Queue)</th>
                            <th style="text-align: center;">Total Pending</th>
                            <td>Reg.</td>
                            <td>Ren.+Upgr</td>
                            <td>Upgr</td>
                            <td>Renewal</td>
                            <td>Fin.Deficients</td>
                            <td>(10%)</td>
                            <td>Issue Pending</td>
                            <td>Issued</td>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $query = "select `session_year`.`sessionYearTitle` AS `sessionYearTitle`,
                    sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
                    sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
                    sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
                    sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
                    sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
                    sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
                    sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
                    sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
                    sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
                    sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
                     sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
                    from (((`school` 
                    join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
                    join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
                    join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
                    WHERE `district`.`new_region` IN (" . $region_ids . ") ";
                        if ($institute_type_id) {
                            $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                        }
                        if ($this->input->post('level_id')) {
                            $level_id = (int) $this->input->post('level_id');
                            $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                        }
                        $query .= "group by `session_year`.`sessionYearTitle`";
                        $pending_files = $this->db->query($query)->result();
                        foreach ($pending_files as $pending) { ?>
                            <tr>
                                <th style="text-align: center;"><?php echo $pending->sessionYearTitle; ?></th>
                                <td><?php echo $pending->total_applied; ?></td>
                                <td><?php echo $pending->previous_pending; ?></td>
                                <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                                <td><?php echo $pending->registrations; ?></td>
                                <td><?php echo $pending->renewal_pgradations; ?></td>
                                <td><?php echo $pending->upgradations; ?></td>
                                <td><?php echo $pending->renewals; ?></td>
                                <td><?php echo $pending->financially_deficient; ?></td>
                                <td><?php echo $pending->marked_to_operation_wing; ?></td>
                                <td><?php echo $pending->completed_pending; ?></td>
                                <td><?php echo $pending->total_issued; ?></td>

                            </tr>
                        <?php } ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="bloc k_div">
            <strong>Last 30 Days Progress Summary Report </strong>
            <div class="table-responsive">
                <table class="table" style="font-size: 11px; text-align:center !important">
                    <tr>
                        <th style="position: sticky;"></th>
                        <?php
                        $working_days = 0;
                        $current_date = time(); // get the current date and time as a Unix timestamp
                        $one_month_ago = strtotime('-1 month', $current_date); // get the Unix timestamp for one month ago

                        // loop through each day from one month ago until today and output the date in a desired format
                        for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                            $date = date('d-M', $i);

                        ?>
                            <th style="width: 20px;"> <?php echo $date;
                                                        echo '<br />';
                                                        if (date('N', $i) < 6) {
                                                            $working_days++;
                                                        }
                                                        ?></th>
                        <?php
                        }
                        ?>
                        <th style="text-align: center;">30 Days Total</th>
                        <th>Over All</th>
                        <th>AVG/Day</th>
                    </tr>
                    <tr>
                        <th style="position: sticky;">Daily Online Applied</th>
                        <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                            $date = date('Y-m-d', $i);
                            $query = "SELECT COUNT(*) as total FROM school WHERE DATE(apply_date) = '" . $date . "'"; ?>
                            <td>
                                <?php echo $this->db->query($query)->row()->total;  ?>
                            </td>
                        <?php } ?>
                        <th style="text-align: center;">
                            <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(apply_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                            echo $total = $this->db->query($query)->row()->total; ?>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>

                    <?php
                    $userId = $this->session->userdata('userId');
                    // if ($userId == 28727) {
                    $query = "SELECT users.userTitle, users.userId FROM `school`
                          INNER JOIN users ON(users.userId = school.note_sheet_completed)
                          AND school.file_status IN (10,4)
                          GROUP BY users.userId;";
                    $users = $this->db->query($query)->result();
                    foreach ($users as $user) {
                    ?>
                        <tr>
                            <th><?php echo $user->userTitle;  ?></th>
                            <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                                $date = date('Y-m-d', $i);
                                $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                                $total = $this->db->query($query)->row()->total;
                            ?>
                                <td style="background-color: rgba(255, 0, 0, <?php echo $total; ?>%);">
                                    <?php echo $total;  ?>
                                </td>
                            <?php } ?>
                            <th style="text-align: center;">
                                <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                                echo $total = $this->db->query($query)->row()->total; ?>
                            </th>
                            <th style="text-align: center;">
                                <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'";
                                echo $total = $this->db->query($query)->row()->total; ?>
                            </th>
                            <th>
                                <?php if ($total) {
                                    echo round($total / $working_days, 2);
                                }

                                ?>
                            </th>
                            <!-- <th style="text-align: center;">
                        <?php
                        // $query = "
                        // SELECT AVG(total) AS avg_daily_entries
                        // FROM (SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        // INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        // AND school.file_status IN (10,4)
                        // AND users.userId = '" . $user->userId . "'
                        //       GROUP BY DATE(note_sheet_completed_date)
                        //       )
                        // AS daily_counts;
                        // ";
                        //echo $total = round($this->db->query($query)->row()->avg_daily_entries, 2);
                        ?>
                      </th> -->
                        </tr>
                    <?php } ?>
                    <?php //} 
                    ?>
                    <tr>
                        <th style="position: sticky;">Daily Completed</th>
                        <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                            $date = date('Y-m-d', $i);
                            $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                            $total = $this->db->query($query)->row()->total;
                        ?>
                            <td style="background-color: rgba(0, 255, 0, <?php echo $total; ?>%);">
                                <?php echo $total;  ?>
                            </td>
                        <?php } ?>
                        <th style="text-align: center;">
                            <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                            echo $total = $this->db->query($query)->row()->total; ?>
                        </th>
                        <th style="text-align: center;">
                            <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)";
                            echo $total = $this->db->query($query)->row()->total; ?>
                        </th>
                        <th>
                            <?php if ($total) {
                                echo round($total / $working_days, 2);
                            }

                            ?>
                        </th>
                        <!-- <th style="text-align: center;">
                        <?php
                        // $query = "
                        // SELECT AVG(total) AS avg_daily_entries
                        // FROM (SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        // INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        // AND school.file_status IN (10,4)
                        // AND users.userId = '" . $user->userId . "'
                        //       GROUP BY DATE(note_sheet_completed_date)
                        //       )
                        // AS daily_counts;
                        // ";
                        //echo $total = round($this->db->query($query)->row()->avg_daily_entries, 2);
                        ?>
                      </th> -->
                    </tr>
                    <tr>
                        <th style="position: sticky;">Daily Cer. Issued (MIS)</th>
                        <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                            $date = date('Y-m-d', $i);
                            $query = "SELECT COUNT(*) as total FROM school WHERE DATE(cer_issue_date) = '" . $date . "'";
                            $total = $this->db->query($query)->row()->total;
                        ?>
                            <td style="background-color: rgba(0, 255, 255, <?php echo $total; ?>%);">
                                <?php echo  $total; ?>
                            </td>
                        <?php } ?>
                        <th style="text-align: center;">
                            <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(cer_issue_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                            echo $total = $this->db->query($query)->row()->total; ?>
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </table>

            </div>
        </div>

    </div>
</div>