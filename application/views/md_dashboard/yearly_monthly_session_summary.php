<?php
$start_time = microtime(true);
$query = "SELECT YEAR(cer_issue_date) as year,
                        SUM(CASE WHEN session_year_id = 1 THEN 1 ELSE 0 END) as `one`,
                        SUM(CASE WHEN session_year_id = 2 THEN 1 ELSE 0 END) as `two`,
                        SUM(CASE WHEN session_year_id = 3 THEN 1 ELSE 0 END) as `three`,
                        SUM(CASE WHEN session_year_id = 4 THEN 1 ELSE 0 END) as `four`,
                        SUM(CASE WHEN session_year_id = 5 THEN 1 ELSE 0 END) as `five`,
                        SUM(CASE WHEN session_year_id = 6 THEN 1 ELSE 0 END) as `six`,
                        COUNT(0) as total_process
                            FROM `school` 
                            WHERE school.status=1
                        GROUP BY YEAR(cer_issue_date)
                        ORDER BY YEAR(cer_issue_date) DESC;";
$reports  = $this->db->query($query)->result();

?>
<div class="jumbotron" style="padding: 9px;">
    <table class="table table_small table-bordered" id="yearly_and_monthly_progress_report">
        <tr>
            <th colspan="14">Session and Yearly Processed Files</th>
        </tr>

        <tr>
            <th>Year</th>
            <th>2018-19</th>
            <th>2019-20</th>
            <th>2020-21</th>
            <th>2021-22</th>
            <th>2022-23</th>
            <th>2023-24</th>
            <th>Total</th>
        </tr>

        <?php foreach ($reports as $report) { ?>
            <tr>
                <th><?php echo $report->year ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->one; ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->two; ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->three; ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->four; ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->five; ?></td>
                <td class="y_m_s_s_report" style="color: black;"><?php echo $report->six; ?></td>
                <td class="y_m_s_s_current_year_report" style="color: black;"><?php echo $report->total_process; ?></td>

            </tr>
        <?php } ?>
    </table>
</div>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";

?>