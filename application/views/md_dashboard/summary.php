<?php
$query = "SELECT * FROM session_year";
$sessions  = $this->db->query($query)->result();

?>
<table class="datatable table table_small table-bordered" id="yearly_and_monthly_progress_report">
    <thead>
        <tr>
            <th colspan="7">Session Wise Registration / Renewals / Upgradation Report</th>
        </tr>
        <tr>
            <th>Type</th>
            <?php foreach ($sessions as $session) { ?>
                <th><?php echo $session->sessionYearTitle; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Registration</td>
            <?php
            $total_registration = 0;
            foreach ($sessions as $session) {
                $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code<=0 and  status=1 and  session_year_id='" . $session->sessionYearId . "';";
                $report = $this->db->query($query)->row();
                $session->commulative_registration = $total_registration += $report->total;
                $session->new_registration = $report->total;
            ?>
                <td><?php echo $report->total; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Comulative</th>
                <?php
                foreach ($sessions as $session) { ?>
            <td><?php echo $session->commulative_registration; ?></td>
        <?php } ?>
        </tr>
        <tr>
            <td>Renewals</td>
            <?php
            foreach ($sessions as $session) {
                $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code>0 and session_year_id='" . $session->sessionYearId . "';";
                $report = $this->db->query($query)->row();
                $session->renewals = $report->total;
            ?>
                <td><?php echo $report->total; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Renewals %</td>
            <?php
            foreach ($sessions as $session) {
            ?>
                <td><?php
                    if ($session->commulative_registration - $session->new_registration > 0) {
                        echo  round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2) . " % ";
                    } ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Remaining</td>
            <?php
            foreach ($sessions as $session) {
            ?>
                <td><?php echo ($session->commulative_registration - $session->new_registration) - $session->renewals; ?></td>
            <?php } ?>
        </tr>
        <!-- <tr>
            <td>Upgradation</td>
            <?php
            //foreach ($sessions as $session) {
            //$query = "SELECT COUNT(*) as total FROM `processed_cases` WHERE upgrade = 1 and session_year_id='" . $session->sessionYearId . "';";
            //$report = $this->db->query($query)->row();
            ?>
            <td><?php //echo $report->total; 
                ?></td>
            <?php //} 
            ?>
        </tr> -->
    </tbody>

</table>