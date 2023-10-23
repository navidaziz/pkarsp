<?php
$start_time = microtime(true);
$query = "

SELECT 
IF(level_of_school_id=1,'Primary',
                  IF(level_of_school_id=2, 'Middle',
                    IF(level_of_school_id=3, 'High', 
                       IF(level_of_school_id=4, 'High Secondary',
                           IF(level_of_school_id=5, 'Academies', 'Others')
                         )))) as level,
                         level_of_school_id,
                         COUNT(DISTINCT schools_id) AS total
FROM school
WHERE level_of_school_id = (select MAX(s.level_of_school_id) from school as s WHERE s.schools_id = school.schools_id and status=1)
AND status=1
GROUP BY level_of_school_id;";
$reports = $this->db->query($query)->result();
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row();
?>



<table class="datatable table table_small table-bordered" style="background-color: white;">
    <thead>
        <tr>
            <th colspan="2"></th>
            <th colspan="4">Current session detail</th>
        </tr>
        <tr>
            <th>Levels</th>
            <th>Total</th>
            <th>New Registered</th>
            <th>Upgradation</th>
            <th>Latest Renewals</th>
            <th>Renewals %</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_registered = 0;
        $levels = array();
        foreach ($reports as $report) { ?>
            <tr>
                <th><?php echo $report->level ?></th>
                <td class="level_total_registered">
                    <strong style="font-size: 12px;"><?php echo $report->total;
                                                        $total_registered += $report->total;
                                                        $levels[$report->level]['total'] = $report->total;

                                                        ?></strong>
                </td>
                <?php
                $query = "SELECT COUNT(*) as total FROM `school` 
                            WHERE renewal_code<=0 
                            AND status=1 
                            AND session_year_id= '" . $current_session->sessionYearId . "' 
                            AND level_of_school_id='" . $report->level_of_school_id . "';";
                $current_registered = $this->db->query($query)->row();
                ?>
                <th class="level_new_registration"><?php echo $current_registered->total; ?></th>
                <th class="level_upgradation"></th>
                <?php
                $query = "SELECT COUNT(*) as total FROM `school` 
                            WHERE renewal_code>0 
                            AND status=1 
                            AND session_year_id='" . $current_session->sessionYearId . "' 
                            AND level_of_school_id='" . $report->level_of_school_id . "';";
                $current_renewal = $this->db->query($query)->row();

                ?>
                <th class="level_renewal_total"><?php
                                                $levels[$report->level]['renewal'] = $current_renewal->total;
                                                echo $current_renewal->total; ?></th>
                <th class="level_precentage">
                    <?php
                    echo round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . " %";
                    ?>
                </th>

            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total</th>
            <th><?php echo $total_registered; ?></th>

            <?php
            $query = "SELECT COUNT(*) as total FROM `school` 
                            WHERE renewal_code<=0 and status=1 and session_year_id='" . $current_session->sessionYearId . "' ";
            $current_registered = $this->db->query($query)->row();
            //$session->commulative_registration = $total_registration += $report->total;
            //$session->new_registration = $report->total;
            ?>
            <th><?php echo $current_registered->total; ?></th>
            <?php
            //$query = "SELECT COUNT(*) as total FROM `school` 
            //                WHERE renewal_code>0 and status=1 and session_year_id='" . $current_session->sessionYearId . "' and upgrade=1 ;";
            //$current_upgradation = $this->db->query($query)->row();
            //$session->commulative_registration = $total_registration += $report->total;
            //$session->new_registration = $report->total;
            ?>
            <th><?php //echo $current_upgradation->total; 
                ?></th>
            <?php
            $query = "SELECT COUNT(*) as total FROM `school` 
                            WHERE renewal_code>0 and status=1 and session_year_id='" . $current_session->sessionYearId . "';";
            $current_renewal = $this->db->query($query)->row();
            //$session->commulative_registration = $total_registration += $report->total;
            //$session->new_registration = $report->total;
            ?>
            <th><?php echo $current_renewal->total; ?></th>
            <th>
                <?php
                echo round((($current_renewal->total / ($total_registered - $current_registered->total)) * 100), 2) . " %";
                ?>
            </th>

        </tr>
    </tfoot>
</table>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>

<script>
    Highcharts.chart('level_wise_summary_chart', {
        title: {
            text: 'Level Wise Registered and Current Session Renewals',
            align: 'left',
            style: {
                fontSize: '12px' // Corrected font size
            }
        },
        xAxis: {
            categories: [
                <?php foreach ($levels as $level_name => $level) { ?>
                    <?php echo "'" . $level_name . "', "; ?>
                <?php } ?>
            ]
        },
        yAxis: {
            title: {
                text: 'Total'
            }
        },
        tooltip: {
            valueSuffix: ' Total'
        },
        plotOptions: {
            series: {
                borderRadius: '25%'
            }
        },
        series: [{
                type: 'column',
                name: 'Registered (Institutes)',
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true,
                data: [
                    <?php foreach ($levels as $level_name => $level) { ?>
                        <?php echo "" . $level['total'] . ", "; ?>
                    <?php } ?>
                ]
            }, {
                type: 'column',
                name: 'Current Session Renewals',
                color: 'red',
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true,
                data: [
                    <?php foreach ($levels as $level_name => $level) { ?>
                        <?php echo "" . $level['renewal'] . ", "; ?>
                    <?php } ?>
                ],
                marker: {
                    lineWidth: 2,
                    lineColor: Highcharts.getOptions().colors[3],
                    fillColor: 'white'
                }
            },

        ]
    });
</script>