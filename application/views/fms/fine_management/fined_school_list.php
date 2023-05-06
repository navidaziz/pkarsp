<?php
$count = 1;
$query = "SELECT s.schoolId as school_id, 
          s.registrationNumber as reg_number, 
          s.schoolName as school_name, 
          s.districtTitle as district_name,
          s.tehsil_name, 
          s.uc,
          s.address,
          s.level,
          SUM(fine_amount) as fine_amount,
		(SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id ) as total_waived_off,
		(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id ) as total_fine_paid
	                            FROM fines as f
								INNER JOIN registered_schools s ON (s.schoolId = f.school_id)
								GROUP BY f.school_id
								";
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