<?php $start_time = microtime(true); ?>

<strong>Region Wise Progress Summary Report </strong>
<div class="table-respons ive">


    <table class="table table_small table-bordered" style="text-align:center; font-size:7px !important" id="test _table">
        <thead>
            <tr>
                <th colspan="4"></th>
                <th colspan="5">Registration</th>
                <th colspan="5">Renewal+Upgradation</th>
            </tr>
            <tr>
                <th style="text-align: center;">Region</th>
                <th style="text-align: center;">Applied</th>
                <th style="text-align: center;">Pending (Queue)</th>
                <th style="text-align: center;">Total Pending</th>
                <th>Reg.</th>
                <th>New Reg.</th>
                <th>Visit Pending</th>
                <th>Visited</th>
                <th>Not Recom.</th>

                <th>Ren+Upgr</th>
                <th>New Ren+Upgr</th>
                <th>Visit Pending</th>
                <th>Visited</th>
                <th>Not Recom.</th>

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
            sum(if((`school`.`reg_type_id` = 1 or `school`.`reg_type_id` = 4) and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_upg_total`,

            sum(if(`school`.`reg_type_id` = 1 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `registrations`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_new`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_not_recommend`,
            sum(if(`school`.`reg_type_id` = 1 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `reg_visited_no`,

            sum(if(`school`.`reg_type_id` = 4 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewal_pgradations`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` IS NULL and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_new`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'Yes' and `school`.`recommended`='No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_not_recommend`,
            sum(if(`school`.`reg_type_id` = 4 and `school`.`visit` = 'No' and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `re_up_visited_no`,

            sum(if(`school`.`reg_type_id` = 2 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `renewals`,
            
            sum(if(`school`.`reg_type_id` = 3 and `school`.`file_status` = 1 and `school`.`status` = 2,1,0)) AS `upgradations`,
            sum(if(`school`.`file_status` = 5 and `school`.`status` = 2,1,0)) AS `financially_deficient`,
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
            $query .= " group by `district`.`new_region`";
            $pending_files = $this->db->query($query)->result();
            foreach ($pending_files as $pending) { ?>
                <tr>
                    <th style="text-align: center;"><?php echo $pending->region; ?></th>
                    <td><?php echo $pending->total_applied; ?></td>
                    <td><?php echo $pending->previous_pending; ?></td>
                    <th style="text-align: center;"><?php echo $pending->total_pending; ?></th>
                    <td><?php echo $pending->registrations; ?></td>
                    <th><?php echo $pending->reg_new; ?></th>
                    <th><?php echo $pending->reg_visited_no; ?></th>
                    <th><?php echo $pending->reg_visited_yes; ?></th>
                    <th><?php echo $pending->reg_not_recommend; ?></th>

                    <td><?php echo $pending->renewal_pgradations; ?></td>
                    <th><?php echo $pending->re_up_new; ?></th>
                    <th><?php echo $pending->re_up_visited_no; ?></th>
                    <th><?php echo $pending->re_up_visited_yes; ?></th>
                    <th><?php echo $pending->re_up_not_recommend; ?></th>


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
                                    ";
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
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds
$execution_time = $end_time - $start_time; // Calculate the execution time
echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>