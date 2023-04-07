<h4>Bank Challan List</h4>
<table class="table table-bordered table2 table-responsive" style="table-layout:auto" id="stan_list">
    <thead>
        <tr>
            <th>S.No</th>
            <th>#</th>
            <th>SID</th>
            <th style="min-width: 200px;">School Name</th>
            <th style="min-width:50px">Session</th>
            <th style="min-width:80px">Challan For</th>
            <th>STAN No</th>
            <th style="min-width:70px">Challan Date</th>
            <th>App. Pro.</th>
            <th>Renewal</th>
            <th>Inspection</th>
            <th>Upgradation</th>
            <th>Late</th>
            <th>Fine</th>
            <th>Security</th>
            <th>C-Name</th>
            <th>C-Building</th>
            <th>C-Ownership</th>
            <th>Penalty</th>
            <th>Miscellaneous</th>
            <th style="text-align: center;">Total</th>
            <th>Created</th>
            <!--<th>Status</th>-->
        </tr>
    </thead>
    <tbody>
        <?php $count = 1;
        if ($school_session_challans) {
            foreach ($school_session_challans as $school_session_challan) { ?>
                <tr>
                    <td><?php echo $count++; ?></td>
                     <td><?php echo $school_session_challan->bank_challan_id; ?></td>
                    <td><?php echo $school_session_challan->schoolId; ?></td>
                    <td><small><i><?php echo substr($school_session_challan->schoolName,0,40); ?></i></small></td>
                    <td><small><?php echo $school_session_challan->sessionYearTitle;  ?></small></td>
                    <td><small><i><?php echo $school_session_challan->challan_for; ?></i></td>
                    <td><?php echo $school_session_challan->challan_no; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($school_session_challan->challan_date)); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->application_processing_fee) echo number_format($school_session_challan->application_processing_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->renewal_fee) echo number_format($school_session_challan->renewal_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->inspection_fee) echo number_format($school_session_challan->inspection_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->upgradation_fee) echo number_format($school_session_challan->upgradation_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->late_fee) echo number_format($school_session_challan->late_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->fine) echo number_format($school_session_challan->fine, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->security_fee) echo number_format($school_session_challan->security_fee, 2); ?></td>

                    <td style="text-align:center"><?php if($school_session_challan->change_of_name_fee) echo number_format($school_session_challan->change_of_name_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->change_of_building_fee) echo number_format($school_session_challan->change_of_building_fee, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->change_of_ownership_fee) echo number_format($school_session_challan->change_of_ownership_fee, 2); ?></td>

                    <td style="text-align:center"><?php if($school_session_challan->penalty) echo number_format($school_session_challan->penalty, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->miscellaneous) echo number_format($school_session_challan->miscellaneous, 2); ?></td>
                    <td style="text-align:center"><?php if($school_session_challan->total_deposit_fee) echo number_format($school_session_challan->total_deposit_fee, 2); ?></td>
                    <td style="text-align:center"><small><?php echo date("d-m-Y", strtotime($school_session_challan->created_date)); ?></small></td>
                    <!--<td>-->
                    <?php if ($school_session_challan->verified == 0) {
                         //   echo '<small><i>Pending</i></small>';
                        } ?>
                        <?php if ($school_session_challan->verified == 1) {
                         //   echo '<small><i>Verified</i></small>';
                        } ?>
                    <!--</td>-->

                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="21" style="text-align: center;">No Record Found</td>
            </tr>
        <?php } ?>
    </tbody>

</table>

<script>
    $(document).ready(function() {
        document.title = "Bank Challans";


        var table = $('#stan_list').DataTable({
            "bPaginate": false,
            dom: 'Bfrtip',
            /* buttons: [
                 'print'
                 
                 
             ],*/

            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ]
        });


        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
                table.cell(cell).invalidate('dom');
            });
        }).draw();
    });
</script>