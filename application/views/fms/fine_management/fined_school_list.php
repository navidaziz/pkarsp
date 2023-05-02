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
								SUM(IF(f.status=1,1,0)) as density,
								SUM(IF(f.status=1,f.fine_amount,0)) as total_fine,
								SUM(IF(f.status=3,1,0)) as w_offed,
								(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id ) as paid_amount
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
        <td><?php echo $fine->total_fine; ?></td>
        <td><?php echo $fine->w_offed; ?></td>
        <td><?php echo $fine->paid_amount; ?></td>
        <td><?php echo $fine->total_fine - $fine->paid_amount; ?></td>
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