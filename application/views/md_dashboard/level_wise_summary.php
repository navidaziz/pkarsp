<?php
$start_time = microtime(true);
$query = "

SELECT 
IF(level_of_school_id=1,'Primary',
                  IF(level_of_school_id=2, 'Middle',
                    IF(level_of_school_id=3, 'High', 
                       IF(level_of_school_id=4, 'High Sec.',
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


<br />

<table class="datatable table table_small table-bordered" style="background-color: white;">
    <thead>
        <tr>
            <th colspan="2"></th>
            <th colspan="4">Current session registration, upgradation and renewals</th>
        </tr>
        <tr>
            <th>Levels</th>
            <th>Total</th>
            <th>New Registered</th>
            <th>Upgradation</th>
            <th>Renewals</th>
            <th>Renewals Issued (%)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_registered = 0;
        $levels = array();
        foreach ($reports as $report) { ?>
            <tr>
                <th style="width: 100px;"><?php echo $report->level ?></th>
                <td class="level_total_registered">
                    <?php echo $report->total;
                    $total_registered += $report->total;
                    $levels[$report->level]['total'] = $report->total;

                    ?>
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
                <th style="width: 150px;">
                    <?php
                    $precentage = round((($current_renewal->total / ($report->total - $current_registered->total)) * 100), 2) . "";

                    ?>

                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $precentage; ?>%;" aria-valuenow="<?php echo $precentage ?>" aria-valuemin="0" aria-valuemax="100">
                            <small> <?php echo $precentage; ?>% </small>
                        </div>
                    </div>

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
    Highcharts.chart('level_pie_chart', {
        chart: {
            type: 'pie'
        },
        title: {
            text: 'Levels Wise Registered Institutes',
            style: {
                fontSize: '9px',
            }
        },
        tooltip: {
            valueSuffix: ''
        },

        plotOptions: {
            series: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: [{
                    enabled: true,
                    distance: 20
                }, {
                    enabled: true,
                    distance: -40,
                    format: '{point.percentage:.1f}%',
                    style: {
                        fontSize: '9pc',
                        textOutline: 'none',
                        opacity: 0.7
                    },
                    filter: {
                        operator: '>',
                        property: 'percentage',
                        value: 10
                    }
                }]
            }
        },
        series: [{
            name: 'Total',
            colorByPoint: true,
            data: [
                <?php foreach ($levels as $level_name => $level) { ?> {
                        name: '<?php echo $level_name; ?>',
                        y: <?php echo $level['total']; ?>
                    },
                <?php } ?>
            ]
        }]
    });

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
                type: 'bar',
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