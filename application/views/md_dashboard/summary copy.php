<?php
$query = "SELECT * FROM session_year";
$sessions  = $this->db->query($query)->result();

?>
<table class="datatable table table_small2 table-bordered" id="yearly_and_monthly_progress_report">
    <thead>
        <tr>
            <th colspan="7">Session Wise Registration / Renewals / Upgradation Report</th>
        </tr>
        <tr>
            <th>Type</th>
            <?php foreach ($sessions as $session) { ?>
                <th><?php echo  str_replace("-20", "-", $session->sessionYearTitle); ?></th>
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
                <td class="new_registrations"><?php echo $report->total; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Comulative</th>
                <?php
                foreach ($sessions as $session) { ?>
            <td class="commulative_registration"><?php echo $session->commulative_registration; ?></td>
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
                <td class="renewals"><?php echo $report->total; ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Renewals %</td>
            <?php
            foreach ($sessions as $session) {
            ?>
                <td><?php
                    if ($session->commulative_registration - $session->new_registration > 0) {
                        $session->renewal_percantage = round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2);
                        echo  round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2) . " % ";
                    } ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td>Remaining</td>
            <?php
            foreach ($sessions as $session) {
            ?>
                <td class="renewals_remanings"><?php
                                                $session->remaning = ($session->commulative_registration - $session->new_registration) - $session->renewals;
                                                echo ($session->commulative_registration - $session->new_registration) - $session->renewals; ?></td>
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

<script>
    Highcharts.chart('container', {

        title: {
            text: '',
            align: ''
        },

        subtitle: {
            text: '',
            align: ''
        },

        yAxis: {
            title: {
                text: 'Total Renewals'
            },
            style: {
                fontSize: '9px' // Set the font size for the xAxis labels
            },
            plotLines: [{
                color: '#FF0000', // Red
                width: 1,
                dashStyle: 'dash',

                value: <?php echo $total_registration; ?> // Position, you'll have to translate this to the values on your x axis
            }]
        },

        xAxis: {
            // accessibility: {
            //     rangeDescription: 'Range: 2018 to 2023'
            // }

            categories: [<?php foreach ($sessions as $session) { ?> '<?php echo  str_replace("-20", "-", $session->sessionYearTitle); ?>',
                <?php } ?>
            ],
            style: {
                fontSize: '9px' // Set the font size for the xAxis labels
            },
            labels: {
                style: {
                    fontSize: '8px'
                }
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            itemStyle: {
                "fontSize": "9px"
            }

        },

        plotOptions: {

            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                },
            },

            spline: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false,
            }


        },

        series: [




            {
                name: 'Comm.Reg.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->commulative_registration ?>,
                    <?php } ?>
                ],
                type: 'line'
            },
            // {
            //     name: 'Renewals Remaning',
            //     data: [<?php foreach ($sessions as $session) { ?>
            //             <?php echo $session->remaning ?>,
            //         <?php } ?>
            //     ],
            //     type: 'line',
            //     color: '#F29B9B'
            // },
            {
                name: 'Ren.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->renewals ?>,
                    <?php } ?>
                ],
                type: 'spline',
                color: 'rgb(152, 251, 152)',
                width: '2'
            },

            {
                name: 'Reg.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->new_registration ?>,
                    <?php } ?>
                ],
                type: 'spline'
            },


        ],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>
<script>
    <?php //var_dump($sessions);

    $sessionYearTitles = array_column($sessions, 'sessionYearTitle');

    // Sort the original array based on the extracted "sessionYearTitle" values
    array_multisort($sessionYearTitles, SORT_DESC, $sessions);

    ?>
    Highcharts.chart('container2', {
        colors: ['#FFD700', '#C0C0C0', '#CD7F32'],
        chart: {
            type: 'column',
            inverted: true,
            polar: true
        },
        title: {
            text: '',
            align: 'left'
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        tooltip: {
            outside: true
        },
        pane: {
            size: '100%',
            innerSize: '10%',
            endAngle: 15,
        },
        xAxis: {
            tickInterval: 1,
            labels: {
                align: 'right',
                useHTML: true,
                allowOverlap: true,
                step: 1,
                y: 3,
                style: {
                    fontSize: '9px'
                }
            },
            lineWidth: 0,
            categories: [
                <?php foreach ($sessions as $session) { ?> '<?php echo $session->sessionYearTitle . '<span class="f16"><span id="flag" class="flag no"></span></span>'; ?>',
                <?php } ?>

            ]
        },
        yAxis: {
            crosshair: {
                enabled: true,
                color: '#333'
            },
            lineWidth: 0,
            tickInterval: 25,
            reversedStacks: false,
            endOnTick: true,
            showLastLabel: true,

        },
        plotOptions: {
            column: {
                stacking: 'normal',
                borderWidth: 0,
                pointPadding: 0,
                groupPadding: 0.15,

            }

        },
        series: [{
                name: 'Renewals',
                data: [
                    <?php foreach ($sessions as $session) { ?>
                        <?php
                        echo $session->renewal_percantage;
                        ?>,
                    <?php } ?>

                ],
                color: 'rgb(152, 251, 152)'
            },
            {
                name: 'Remanings',
                data: [
                    <?php foreach ($sessions as $session) { ?>
                        <?php echo 100 - $session->renewal_percantage;
                        ?>,
                    <?php } ?>

                ],
                color: '#F29B9B'
            }
        ]
    });
</script>