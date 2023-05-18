<?php
$count = 1;
$query = "SELECT  `s`.`schoolId` AS `school_id`,
        `s`.`registrationNumber` AS `reg_number`,
        (select `school_file_numbers`.`file_number` from `school_file_numbers` where (`school_file_numbers`.`school_id` = `s`.`schoolId`) limit 1) AS `file_no`,
        `s`.`yearOfEstiblishment` AS `year_of_est`,
        `s`.`schoolName` AS `school_name`,
        `d`.`districtTitle` AS `district_name`,
        `d`.`new_region` AS `new_region`,if((`d`.`new_region` = 1),'Central',if((`d`.`new_region` = 2),'South',if((`d`.`new_region` = 3),'Malakand',if((`d`.`new_region` = 4),'Hazara',if((`d`.`new_region` = 5),'Peshawar','Others'))))) AS `region`,
        (select `t`.`tehsilTitle` from `tehsils` `t` where (`t`.`tehsilId` = `s`.`tehsil_id`)) AS `tehsil_name`,
        (select `uc`.`ucTitle` from `uc` where (`uc`.`ucId` = `s`.`uc_id`)) AS `us`,
        `s`.`address` AS `address`,
        (select `l`.`levelofInstituteTitle` from `levelofinstitute` `l` where (`l`.`levelofInstituteId` = (select max(`school`.`level_of_school_id`) from `school` where (`school`.`schools_id` = `s`.`schoolId`)))) AS `level`, 
        SUM(f.fine_amount) as fine_amount,
        (SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id ) as total_waived_off,
        (SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id ) as total_fine_paid
        FROM fines as f
        INNER JOIN schools s ON (s.schoolId = f.school_id)
        INNER JOIN district d ON (`d`.`districtId` = `s`.`district_id`)
        
        GROUP BY f.school_id";

$fines = $this->db->query($query)->result();
foreach ($fines as $fine) {
?>
    <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $fine->school_id; ?></td>
        <td><?php echo $fine->reg_number; ?></td>
        <td><?php echo $fine->school_name; ?></td>
        <td><?php echo $fine->district_name; ?></td>
        <td><?php echo $fine->tehsil_name; ?></td>
        <td><?php echo $fine->uc; ?></td>
        <td><?php echo $fine->address; ?></td>
        <td><?php echo $fine->level; ?></td>
        <td><?php echo $fine->density; ?></td>
        <td><?php echo @number_format($fine->fine_amount, 2); ?></td>
        <td><?php echo @number_format($fine->total_waived_off, 2); ?></td>
        <td><?php echo @number_format($fine->fine_amount - $fine_summary->total_waived_off, 2); ?></td>
        <td><?php echo @number_format($fine->total_fine_paid, 2); ?></td>
        <td><?php echo @number_format(($fine->fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid, 2); ?></td>

        <td>
            <!-- <button onclick="get_add_fine_payment_form('<?php echo $fine->fined_school_id; ?>')" class="btn btn-link btn-sm">
                View
            </button> -->
            <a href="<?php echo site_url("fms/fine_management/view_fine_detail/" . $fine->school_id); ?>">
                View
            </a>
        </td>
    </tr>
<?php } ?>