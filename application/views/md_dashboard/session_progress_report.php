<?php $start_time = microtime(true);
$query = "SELECT `district`.`districtTitle`,
sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
from (((`school` 
join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
";
if ($institute_type_id) {
    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
}
if ($this->input->post('level_id')) {
    $level_id = (int) $this->input->post('level_id');
    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
}
$query .= " GROUP BY `district`.`districtId` ORDER BY `district`.`districtTitle`";
$pending_files = $this->db->query($query)->result();
?>
<div class="jumbotron" style="padding: 9px;">
    <strong>District Wise Progress Summary Report </strong>
    <div class="table-responsive">


        <table class="table table_small table-bordered" style="text-align:center; font-size:7px !important" id="test _table">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th style="background-color: rgb(255, 165, 0);">Pending (Queue)</th>
                    <th style="background-color: rgb(255, 99, 71);">Pending</th>
                    <th colspan="5" style="background-color: rgb(241, 194, 50);">New Registration Cases</th>
                    <th colspan="5" style="background-color: rgba(102, 211, 252);">Renewal+Upgradation Cases</th>
                    <th style="background-color: rgb(152, 250, 152);">Renewal Cases</th>
                    <th style="background-color: rgb(224,149,247);">Only Upgradataions</th>
                    <th colspan="4" style="background-color: rgb(253, 92, 99)">Financial Deficiency Cases</th>
                    <th style="background-color: rgb(222, 49, 99)">10%</th>
                    <td style="background-color: rgb(230, 32, 32);">Issue Pend.</td>
                </tr>
                <tr style="background-color: lightgray">
                    <td style="text-align: center; background-color: lightgray">District</td>
                    <td style="text-align: center; background-color: lightgray">Applied</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td>Total</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">Regi</td>
                    <td style="background-color: lightgray;">Ren+Upg</td>
                    <td style="background-color: lightgray;">Renewal</td>
                    <td>Total</td>
                    <td>Total</td>
                </tr>
            </thead>

            <tbody>

                <?php
                foreach ($pending_files as $pending) { ?>
                    <tr>
                        <th style="text-align: center;">
                            <?php echo $pending->districtTitle; ?>
                        </th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td class="region_preding_previous"><?php echo $pending->previous_pending; ?></td>
                        <th class="region_pending_cases" style="text-align: center;"><?php echo $pending->total_pending; ?></th>

                        <td class="registration_total"><?php echo $pending->registrations; ?></td>
                        <th class="registration_other"><?php echo $pending->reg_new; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_no; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_yes; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_not_recommend; ?></th>

                        <td class="re_upg_total"><?php echo $pending->renewal_pgradations; ?></td>
                        <th class="re_upg_other"><?php echo $pending->re_up_new; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_no; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_yes; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_not_recommend; ?></th>

                        <td class="renew"><?php echo $pending->renewals; ?></td>
                        <td class="upgra"><?php echo $pending->upgradations; ?></td>

                        <td class="deficient"><?php echo $pending->financially_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->reg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->ren_upg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->rene_deficient; ?></td>
                        <td class="operation_wing"><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td class="issue_pending"><?php echo $pending->completed_pending; ?></td>

                    </tr>
                <?php } ?>

            </tbody>
            <tfoot>
                <?php $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
            sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
            sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
            sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
            sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

            sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

            sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

            sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

            sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
            sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
            sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
            sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
            sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
            from (((`school` 
            join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
            join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
            join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
            ";
                if ($institute_type_id) {
                    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                }
                if ($this->input->post('level_id')) {
                    $level_id = (int) $this->input->post('level_id');
                    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                }
                //$query .= " group by `district`.`new_region`";
                $pending = $this->db->query($query)->row();
                ?>
                <tr>
                    <th style="text-align: center;">Total</th>
                    <th class=""><?php echo $pending->total_applied; ?></th>
                    <td class="pending_total"><?php echo $pending->previous_pending; ?></th>
                    <th style="text-align: center;" class="pending_total"><?php echo $pending->total_pending; ?></th>
                    <th class="pending_total"><?php echo $pending->registrations; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_new; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewal_pgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_new; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewals; ?></th>
                    <th class="pending_total"><?php echo $pending->upgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->financially_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->ren_upg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->rene_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->marked_to_operation_wing; ?></th>
                    <th class="pending_total"><?php echo $pending->completed_pending; ?></th>

                </tr>
            </tfoot>

        </table>
    </div>
</div>

<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds
$execution_time = $end_time - $start_time; // Calculate the execution time
echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>


<?php $start_time = microtime(true);
$query = "SELECT `session_year`.`sessionYearTitle`,
sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
from (((`school` 
join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
";
if ($institute_type_id) {
    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
}
if ($this->input->post('level_id')) {
    $level_id = (int) $this->input->post('level_id');
    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
}
$query .= " GROUP BY `school`.`session_year_id`";
$pending_files = $this->db->query($query)->result();
?>
<div class="jumbotron" style="padding: 9px;">
    <strong>Session Wise Progress Summary Report </strong>
    <div class="table-responsive">


        <table class="table table_small table-bordered" style="text-align:center; font-size:7px !important" id="test _table">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th style="background-color: rgb(255, 165, 0);">Pending (Queue)</th>
                    <th style="background-color: rgb(255, 99, 71);">Pending</th>
                    <th colspan="5" style="background-color: rgb(241, 194, 50);">New Registration Cases</th>
                    <th colspan="5" style="background-color: rgba(102, 211, 252);">Renewal+Upgradation Cases</th>
                    <th style="background-color: rgb(152, 250, 152);">Renewal Cases</th>
                    <th style="background-color: rgb(224,149,247);">Only Upgradataions</th>
                    <th colspan="4" style="background-color: rgb(253, 92, 99)">Financial Deficiency Cases</th>
                    <th style="background-color: rgb(222, 49, 99)">10%</th>
                    <td style="background-color: rgb(230, 32, 32);">Issue Pend.</td>
                </tr>
                <tr style="background-color: lightgray">
                    <td style="text-align: center; background-color: lightgray">Session</td>
                    <td style="text-align: center; background-color: lightgray">Applied</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td>Total</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">Regi</td>
                    <td style="background-color: lightgray;">Ren+Upg</td>
                    <td style="background-color: lightgray;">Renewal</td>
                    <td>Total</td>
                    <td>Total</td>
                </tr>
            </thead>

            <tbody>

                <?php
                foreach ($pending_files as $pending) { ?>
                    <tr>
                        <th style="text-align: center;">
                            <?php echo $pending->sessionYearTitle; ?>
                        </th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td class="region_preding_previous"><?php echo $pending->previous_pending; ?></td>
                        <th class="region_pending_cases" style="text-align: center;"><?php echo $pending->total_pending; ?></th>

                        <td class="registration_total"><?php echo $pending->registrations; ?></td>
                        <th class="registration_other"><?php echo $pending->reg_new; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_no; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_yes; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_not_recommend; ?></th>

                        <td class="re_upg_total"><?php echo $pending->renewal_pgradations; ?></td>
                        <th class="re_upg_other"><?php echo $pending->re_up_new; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_no; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_yes; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_not_recommend; ?></th>

                        <td class="renew"><?php echo $pending->renewals; ?></td>
                        <td class="upgra"><?php echo $pending->upgradations; ?></td>

                        <td class="deficient"><?php echo $pending->financially_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->reg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->ren_upg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->rene_deficient; ?></td>
                        <td class="operation_wing"><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td class="issue_pending"><?php echo $pending->completed_pending; ?></td>

                    </tr>
                <?php } ?>

            </tbody>
            <tfoot>
                <?php $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
            sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
            sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
            sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
            sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

            sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

            sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

            sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

            sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
            sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
            sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
            sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
            sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
            from (((`school` 
            join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
            join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
            join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
            ";
                if ($institute_type_id) {
                    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                }
                if ($this->input->post('level_id')) {
                    $level_id = (int) $this->input->post('level_id');
                    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                }
                //$query .= " group by `district`.`new_region`";
                $pending = $this->db->query($query)->row();
                ?>
                <tr>
                    <th style="text-align: center;">Total</th>
                    <th class=""><?php echo $pending->total_applied; ?></th>
                    <td class="pending_total"><?php echo $pending->previous_pending; ?></th>
                    <th style="text-align: center;" class="pending_total"><?php echo $pending->total_pending; ?></th>
                    <th class="pending_total"><?php echo $pending->registrations; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_new; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewal_pgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_new; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewals; ?></th>
                    <th class="pending_total"><?php echo $pending->upgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->financially_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->ren_upg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->rene_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->marked_to_operation_wing; ?></th>
                    <th class="pending_total"><?php echo $pending->completed_pending; ?></th>

                </tr>
            </tfoot>

        </table>
    </div>
</div>

<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds
$execution_time = $end_time - $start_time; // Calculate the execution time
echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>




<?php $start_time = microtime(true);
$query = "SELECT `district`.`bise`,
sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
from (((`school` 
join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
WHERE  `school`.`level_of_school_id` IN('3,4') 
 GROUP BY `district`.`bise` ORDER BY `district`.`bise`";
$pending_files = $this->db->query($query)->result();
?>
<div class="jumbotron" style="padding: 9px;">
    <strong>BISE Wise High and High Secondary Institutes Progress Summary Report </strong>
    <div class="table-responsive">


        <table class="table table_small table-bordered" style="text-align:center; font-size:7px !important" id="test _table">
            <thead>
                <tr>
                    <th colspan="2"></th>
                    <th style="background-color: rgb(255, 165, 0);">Pending (Queue)</th>
                    <th style="background-color: rgb(255, 99, 71);">Pending</th>
                    <th colspan="5" style="background-color: rgb(241, 194, 50);">New Registration Cases</th>
                    <th colspan="5" style="background-color: rgba(102, 211, 252);">Renewal+Upgradation Cases</th>
                    <th style="background-color: rgb(152, 250, 152);">Renewal Cases</th>
                    <th style="background-color: rgb(224,149,247);">Only Upgradataions</th>
                    <th colspan="4" style="background-color: rgb(253, 92, 99)">Financial Deficiency Cases</th>
                    <th style="background-color: rgb(222, 49, 99)">10%</th>
                    <td style="background-color: rgb(230, 32, 32);">Issue Pend.</td>
                </tr>
                <tr style="background-color: lightgray">
                    <td style="text-align: center; background-color: lightgray">District</td>
                    <td style="text-align: center; background-color: lightgray">Applied</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="text-align: center; background-color: lightgray">Total</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">New</td>
                    <td style="background-color: lightgray;">Not Visited</td>
                    <td style="background-color: lightgray;">Visited</td>
                    <td style="background-color: lightgray;">Not Recom.</td>
                    <td style="background-color: lightgray;">Total</td>
                    <td>Total</td>

                    <td style="background-color: lightgray;">Total</td>
                    <td style="background-color: lightgray;">Regi</td>
                    <td style="background-color: lightgray;">Ren+Upg</td>
                    <td style="background-color: lightgray;">Renewal</td>
                    <td>Total</td>
                    <td>Total</td>
                </tr>
            </thead>

            <tbody>

                <?php
                foreach ($pending_files as $pending) { ?>
                    <tr>
                        <th style="text-align: center;">
                            <?php echo $pending->bise; ?>
                        </th>
                        <td><?php echo $pending->total_applied; ?></td>
                        <td class="region_preding_previous"><?php echo $pending->previous_pending; ?></td>
                        <th class="region_pending_cases" style="text-align: center;"><?php echo $pending->total_pending; ?></th>

                        <td class="registration_total"><?php echo $pending->registrations; ?></td>
                        <th class="registration_other"><?php echo $pending->reg_new; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_no; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_visited_yes; ?></th>
                        <th class="registration_other"><?php echo $pending->reg_not_recommend; ?></th>

                        <td class="re_upg_total"><?php echo $pending->renewal_pgradations; ?></td>
                        <th class="re_upg_other"><?php echo $pending->re_up_new; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_no; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_visited_yes; ?></th>
                        <th class="re_upg_other"><?php echo $pending->re_up_not_recommend; ?></th>

                        <td class="renew"><?php echo $pending->renewals; ?></td>
                        <td class="upgra"><?php echo $pending->upgradations; ?></td>

                        <td class="deficient"><?php echo $pending->financially_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->reg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->ren_upg_deficient; ?></td>
                        <td class="deficient"><?php echo $pending->rene_deficient; ?></td>
                        <td class="operation_wing"><?php echo $pending->marked_to_operation_wing; ?></td>
                        <td class="issue_pending"><?php echo $pending->completed_pending; ?></td>

                    </tr>
                <?php } ?>

            </tbody>
            <tfoot>
                <?php $query = "SELECT if((`district`.`new_region` = 1),'Central',if((`district`.`new_region` = 2),'South',if((`district`.`new_region` = 3),'Malakand',if((`district`.`new_region` = 4),'Hazara',if((`district`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
            sum(if(`school`.`file_status` >=1 and school.status>0 ,1,0)) AS `total_applied`,
            sum(if(`school`.`file_status` =3 and school.status=2 ,1,0)) AS `previous_pending`,
            sum(if(`school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `total_pending`,
            sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

            sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_yes`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

            sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes'  and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_yes`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

            sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,

            sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
            sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 1 and `school`.`status` = 2,1,0)) AS `reg_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 2 and `school`.`status` = 2,1,0)) AS `rene_deficient`,
            sum(if(`school`.`file_status` = 5 and `school`.`reg_type_id` = 4 and `school`.`status` = 2,1,0)) AS `ren_upg_deficient`,
            sum(if(`school`.`file_status` = 4 and `school`.`status` = 2,1,0)) AS `marked_to_operation_wing`,
            sum(if(`school`.`file_status` = 10 and `school`.`status` = 2,1,0)) AS `completed_pending`,
            sum(if(`school`.`status` = 1,1,0)) AS `total_issued`
            from (((`school` 
            join `schools` on(`schools`.`schoolId` = `school`.`schools_id`)) 
            join `district` on(`district`.`districtId` = `schools`.`district_id`)) 
            join `session_year` on(`session_year`.`sessionYearId` = `school`.`session_year_id`)) 
            ";
                if ($institute_type_id) {
                    $query .= " AND `schools`.`school_type_id`= '" . $institute_type_id . "' ";
                }
                if ($this->input->post('level_id')) {
                    $level_id = (int) $this->input->post('level_id');
                    $query .= " AND `school`.`level_of_school_id`= '" . $level_id . "' ";
                }
                //$query .= " group by `district`.`new_region`";
                $pending = $this->db->query($query)->row();
                ?>
                <tr>
                    <th style="text-align: center;">Total</th>
                    <th class=""><?php echo $pending->total_applied; ?></th>
                    <td class="pending_total"><?php echo $pending->previous_pending; ?></th>
                    <th style="text-align: center;" class="pending_total"><?php echo $pending->total_pending; ?></th>
                    <th class="pending_total"><?php echo $pending->registrations; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_new; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewal_pgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_new; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_no; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_visited_yes; ?></th>
                    <th class="pending_total"><?php echo $pending->re_up_not_recommend; ?></th>

                    <th class="pending_total"><?php echo $pending->renewals; ?></th>
                    <th class="pending_total"><?php echo $pending->upgradations; ?></th>
                    <th class="pending_total"><?php echo $pending->financially_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->reg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->ren_upg_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->rene_deficient; ?></th>
                    <th class="pending_total"><?php echo $pending->marked_to_operation_wing; ?></th>
                    <th class="pending_total"><?php echo $pending->completed_pending; ?></th>

                </tr>
            </tfoot>

        </table>
    </div>
</div>

<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds
$execution_time = $end_time - $start_time; // Calculate the execution time
echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>