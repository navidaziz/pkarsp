<?php
$query = "SELECT * FROM session_year";
$sessions  = $this->db->query($query)->result();

?>
<?php
$total_registration = 0;
foreach ($sessions as $session) {
    $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code<=0 and  status=1 and  session_year_id='" . $session->sessionYearId . "';";
    $report = $this->db->query($query)->row();
    $session->commulative_registration = $total_registration += $report->total;
    $session->new_registration = $report->total;
    $query = "SELECT COUNT(*) as total FROM `school` WHERE renewal_code>0 and session_year_id='" . $session->sessionYearId . "';";
    $report = $this->db->query($query)->row();
    $session->renewals = $report->total;
}
?>

<table class="datatable table table_small2" style="background-color: white;">
    <?php
    $precetange = 0;
    foreach ($sessions as $session) {

    ?>
        <?php
        if ($session->commulative_registration - $session->new_registration > 0) {
            $session->renewal_percantage = $precetange = round(($session->renewals / ($session->commulative_registration - $session->new_registration)) * 100, 2);
            //echo   $precetange;
        } ?>
        <tr>
            <th style="width: 80px;"><?php echo  $session->sessionYearTitle; ?></th>
            <td>
                <div class="progress" style="margin: 2px;">
                    <div class="progress-bar" role="progressbar" style="text-align: center; width: <?php echo $precetange; ?>%;" aria-valuenow="<?php echo $precetange; ?>" aria-valuemin="0" aria-valuemax="100">
                        <small> <?php echo $precetange; ?>% </small>
                    </div>
                </div>
            </td>
        </tr>
    <?php
    } ?>

</table>



<table class="datatable table table_small table-bordered" id="yearly_and_monthly_progress_report" style="background-color: white;">
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
            // $total_registration = 0;
            foreach ($sessions as $session) { ?>
                <td class="new_registrations"><?php echo $session->new_registration; ?></td>
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
            text: 'Trends - Registration and Renewals',
            align: '',
            style: {
                fontSize: '12px' // Set the font size for the yAxis title
            }
        },



        yAxis: {
            title: {
                text: 'Total',
                style: {
                    fontSize: '7px' // Set the font size for the yAxis title
                }
            },
            labels: {
                style: {
                    fontSize: '7px' // Set the font size for y-axis labels
                }
            },
            plotLines: [{
                color: '#FF0000', // Red
                width: 1,
                dashStyle: 'dash',
                value: <?php echo $total_registration; ?> // Position, you'll have to translate this to the values on your x axis
            }]
        },

        xAxis: {
            categories: [<?php foreach ($sessions as $session) { ?> '<?php echo  substr(str_replace("-20", "-", $session->sessionYearTitle), 2); ?>',
                <?php } ?>
            ],
            labels: {
                style: {
                    fontSize: '9px'
                }
            }
        },

        legend: {
            layout: 'vertical',
            align: 'left',
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
                style: {
                    fontSize: '8px'
                },
                enableMouseTracking: false,
            }


        },

        series: [{
                name: 'Comm.Reg.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->commulative_registration ?>,
                    <?php } ?>
                ],
                type: 'spline',
                dataLabels: {
                    enabled: true, // Enable data labels
                    style: {
                        fontSize: '7px' // Set the font size for data labels
                    }
                }
            },
            {
                name: 'Ren.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->renewals ?>,
                    <?php } ?>
                ],
                type: 'spline',
                color: 'rgb(152, 251, 152)',
                width: '1',
                dataLabels: {
                    enabled: true, // Enable data labels
                    style: {
                        fontSize: '7px' // Set the font size for data labels
                    }
                }
            },

            {
                name: 'Reg.',
                data: [<?php foreach ($sessions as $session) { ?>
                        <?php echo $session->new_registration ?>,
                    <?php } ?>
                ],
                type: 'spline',
                dataLabels: {
                    enabled: true, // Enable data labels
                    style: {
                        fontSize: '7px' // Set the font size for data labels
                    }
                }
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