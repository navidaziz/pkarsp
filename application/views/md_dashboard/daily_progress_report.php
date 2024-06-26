<?php $start_time = microtime(true); ?>
<div class="jumbotron" style="padding: 9px;">
    <strong>Last 30 Days Progress Summary Report </strong>
    <div class="table-responsive">
        <table class="table table_small table-bordered" style="font-size: 4px; text-align:center !important">
            <tr>
                <th style="position: sticky; width:100px"></th>
                <?php
                $working_days = 0;
                $current_date = time(); // get the current date and time as a Unix timestamp
                $one_month_ago = strtotime('-1 month', $current_date); // get the Unix timestamp for one month ago

                // loop through each day from one month ago until today and output the date in a desired format
                for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                    $date = date('d M', $i);
                    $date = date('d', $i);
                    $month = date('M', $i);
                    $day = date('D', $i);

                ?>
                    <th style="width: 20px;">
                        <?php echo date('d', $i); ?>
                        <small><?php echo date('M', $i); ?>
                            <?php //echo date('D', $i) 
                            ?>
                        </small>
                        <?php if (date('N', $i) < 6) {
                            $working_days++;
                        } ?>
                    </th>
                <?php
                }
                ?>
                <th style="text-align: center;">30 Days Total</th>
                <th>Over All</th>
                <th>AVG/Day</th>
            </tr>
            <tr>
                <th style="position: sticky;"><small>Daily Online Applied<small></th>
                <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                    $date = date('Y-m-d', $i);
                    $query = "SELECT COUNT(*) as total FROM school WHERE DATE(apply_date) = '" . $date . "'"; ?>
                    <td class="daily_apply">
                        <?php echo $this->db->query($query)->row()->total;  ?>
                    </td>
                <?php } ?>
                <th style="text-align: center;">
                    <?php $query = "SELECT COUNT(*) as total FROM school WHERE (DATE(apply_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";

                    echo $total = $this->db->query($query)->row()->total; ?>
                </th>
                <th></th>
                <th><?php echo round($total / $working_days, 2); ?></th>
            </tr>

            <?php
            $userId = $this->session->userdata('userId');
            // if ($userId == 28727) {
            $query = "SELECT users.userTitle, users.userId FROM `school`
                          INNER JOIN users ON(users.userId = school.note_sheet_completed)
                          AND school.file_status IN (10,4)
                          AND DATE(note_sheet_completed_date) >= '" .  date('Y-m-d', $one_month_ago) . "'
                          AND DATE(note_sheet_completed_date) <= '" .  date('Y-m-d', $current_date) . "'
                          GROUP BY users.userId;";
            $users = $this->db->query($query)->result();
            foreach ($users as $user) {
            ?>
                <tr>
                    <th style="text-align: left;"><?php echo $user->userTitle; ?></th>
                    <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                        $date = date('Y-m-d', $i);
                        $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                        $total = $this->db->query($query)->row()->total;
                    ?>
                        <td class="daily_progress">

                            <?php
                            if ($total) {
                                echo $total;
                            }  ?>

                        </td>
                    <?php } ?>
                    <th class="days_total">
                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                        echo $thirty_day_total = $this->db->query($query)->row()->total; ?>
                    </th>
                    <th class="daily_over_all">
                        <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND users.userId = '" . $user->userId . "'";
                        echo $total = $this->db->query($query)->row()->total; ?>
                    </th>
                    <th class="days_avg">
                        <?php if ($total) {
                            echo round($thirty_day_total / $working_days, 2);
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
                <th style="position: sticky;"><small>Daily Completed</small></th>
                <?php for ($i = $one_month_ago; $i <= $current_date; $i = strtotime('+1 day', $i)) {
                    $date = date('Y-m-d', $i);
                    $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND DATE(note_sheet_completed_date) = '" . $date . "'";
                    $total = $this->db->query($query)->row()->total;
                ?>
                    <td class="daily_completed">
                        <?php echo $total;  ?>
                    </td>
                <?php } ?>
                <th style="text-align: center;">
                    <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)
                        AND (DATE(note_sheet_completed_date) BETWEEN '" . date('Y-m-d', $one_month_ago) . "' and '" . date('Y-m-d', $current_date) . "')";
                    echo $thirty_day_completed = $this->db->query($query)->row()->total; ?>
                </th>
                <th style="text-align: center;">
                    <?php $query = "SELECT COUNT(school.note_sheet_completed) as total FROM `school`
                        INNER JOIN users ON(users.userId = school.note_sheet_completed)
                        AND school.file_status IN (10,4)";
                    echo $total = $this->db->query($query)->row()->total; ?>
                </th>
                <th>
                    <?php if ($thirty_day_completed) {
                        echo round($thirty_day_completed / $working_days, 2);
                    }

                    ?>
                </th>
            </tr>
            <tr>
                <th style="position: sticky;"><small>Daily Cer. Issued (MIS)</small></th>
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
                <th><?php echo round($total / $working_days, 2) ?></th>
            </tr>
        </table>

    </div>
</div>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds
$execution_time = $end_time - $start_time; // Calculate the execution time
echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>