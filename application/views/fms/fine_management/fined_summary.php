<?php
$query = "SELECT 
SUM(fine_amount) as fine_amount,
(SELECT SUM(w.waived_off_amount) FROM fine_waived_off as w WHERE w.is_deleted=0 AND w.school_id = f.school_id ) as total_waived_off,
(SELECT SUM(fp.deposit_amount) FROM fine_payments as fp WHERE fp.is_deleted=0 AND fp.school_id = f.school_id ) as total_fine_paid
FROM fines as f
 WHERE f.status=1";
$fine_summary = $this->db->query($query)->result()[0];


?>

<style>
    .table2 tr td {
        text-align: center;
    }
</style>
<small>
    <table class="table table-bordered table-striped" style="text-align: center;">
        <thead>
            <tr>
                <th>Total Fine</th>

                <th>Total Waived Off</th>
                <th>Total Fine Payable</th>
                <th>Total Fine Paid</th>
                <th>Total Fine Remaining</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo @number_format($fine_summary->fine_amount, 2); ?></td>
                <td><?php echo @number_format($fine_summary->total_waived_off, 2); ?></td>
                <td><?php echo @number_format($fine_summary->fine_amount - $fine_summary->total_waived_off, 2); ?></td>
                <td><?php echo @number_format($fine_summary->total_fine_paid, 2); ?></td>
                <td><?php echo @number_format(($fine_summary->fine_amount - $fine_summary->total_waived_off) - $fine_summary->total_fine_paid, 2); ?></td>

            </tr>
        </tbody>
    </table>
</small>