<?php
$start_time = microtime(true);
$query = "SELECT
                                    YEAR(cer_issue_date) as Year,
                                    SUM(IF(cer_issue_date,1,0)) as `total`,
                                    SUM(IF(MONTH(cer_issue_date)=04,1,0)) as `Apr`,
                                    SUM(IF(MONTH(cer_issue_date)=05,1,0)) as `May`,
                                    SUM(IF(MONTH(cer_issue_date)=06,1,0)) as `Jun`,
                                    SUM(IF(MONTH(cer_issue_date)=07,1,0)) as `Jul`,
                                    SUM(IF(MONTH(cer_issue_date)=08,1,0)) as `Aug`,
                                    SUM(IF(MONTH(cer_issue_date)=09,1,0)) as `Sep`,
                                    SUM(IF(MONTH(cer_issue_date)=10,1,0)) as `Oct`,
                                    SUM(IF(MONTH(cer_issue_date)=11,1,0)) as `Nov`,
                                    SUM(IF(MONTH(cer_issue_date)=12,1,0)) as `Dec`,
                                    SUM(IF(MONTH(cer_issue_date)=01,1,0)) as `Jan`,
                                    SUM(IF(MONTH(cer_issue_date)=02,1,0)) as `Feb`,
                                    SUM(IF(MONTH(cer_issue_date)=03,1,0)) as `Mar`
                                    FROM `school` 
                                    WHERE school.status=1
                                    GROUP BY YEAR(cer_issue_date)
                                    ORDER BY YEAR(cer_issue_date) DESC";
$reports  = $this->db->query($query)->result();

?>
<table class="table table_small table-bordered" id="yearly_and_monthly_progress_report">
    <tr>
        <th colspan="14">Yearly and monthly progress report</th>
    </tr>

    <tr>
        <th>Year</th>
        <th>Apr</th>
        <?php if (date('m') == '04') { ?> <td> * </td><?php } ?>
        <th>May</th>
        <?php if (date('m') == '05') { ?> <td> * </td><?php } ?>
        <th>Jun</th>
        <?php if (date('m') == '06') { ?> <td> * </td><?php } ?>
        <th>Jul</th>
        <?php if (date('m') == '07') { ?> <td> * </td><?php } ?>
        <th>Aug</th>
        <?php if (date('m') == '08') { ?> <td> * </td><?php } ?>
        <th>Sep</th>
        <?php if (date('m') == '09') { ?> <td> * </td><?php } ?>
        <th>Oct</th>
        <?php if (date('m') == '10') { ?> <td> * </td><?php } ?>
        <th>Nov</th>
        <?php if (date('m') == '11') { ?> <td> * </td><?php } ?>
        <th>Dec</th>
        <?php if (date('m') == '12') { ?> <td> * </td><?php } ?>
        <th>Jan</th>
        <?php if (date('m') == '01') { ?> <td> * </td><?php } ?>
        <th>Feb</th>
        <?php if (date('m') == '02') { ?> <td> * </td><?php } ?>
        <th>Mar</th>
        <?php if (date('m') == '03') { ?> <td> * </td><?php } ?>
        <th>Yearly Total</th>
    </tr>

    <?php foreach ($reports as $report) { ?>
        <tr>
            <th><?php echo $report->Year ?></td>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Apr ?></td>
            <?php if (date('m') == '04') { ?> <td class="y_m_current_month"> <?php echo $report->Apr; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->May ?></td>
            <?php if (date('m') == '05') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Jun ?></td>
            <?php if (date('m') == '06') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Jul ?></td>
            <?php if (date('m') == '07') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Aug ?></td>
            <?php if (date('m') == '08') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Sep ?></td>
            <?php if (date('m') == '09') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Oct ?></td>
            <?php if (date('m') == '10') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Nov ?></td>
            <?php if (date('m') == '11') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Dec ?></td>
            <?php if (date('m') == '12') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Jan ?></td>
            <?php if (date('m') == '01') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Feb ?></td>
            <?php if (date('m') == '02') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan + $report->Feb; ?> </td><?php } ?>
            <td class="y_m_summary_report" style="color: black;"><?php echo $report->Mar ?></td>
            <?php if (date('m') == '03') { ?> <td class="y_m_current_month"> <?php echo $report->Apr + $report->May + $report->Jun + $report->Jul + $report->Aug + $report->Sep + $report->Oct + $report->Nov + $report->Dec + $report->Jan + $report->Feb + $report->Mar; ?> </td><?php } ?>
            <td class="yearly_total" style="color: black;"><?php echo $report->total ?></td>
        </tr>
    <?php } ?>
</table>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";

?>