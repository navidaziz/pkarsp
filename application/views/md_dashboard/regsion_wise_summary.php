<?php
$start_time = microtime(true);
$query = "SELECT 
if((`new_region` = 1),'Central',if((`new_region` = 2),'South',if((`new_region` = 3),'Malakand',if((`new_region` = 4),'Hazara',if((`new_region` = 5),'Peshawar','Others'))))) AS `region`,
new_region,
                         COUNT(DISTINCT schools_id) AS total
FROM school
INNER JOIN schools ON(schools.schoolId = school.schools_id)
INNER JOIN district ON(schools.district_id = district.districtId)
WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
AND school.status=1
GROUP BY new_region;";
$reports = $this->db->query($query)->result();
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row();
?>
<div class="jumbotron" style="padding: 9px;">
    <table class="datatable table table_small table-bordered">
        <thead>
            <tr>
                <th>Regions</th>
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

            $regions = array();

            foreach ($reports as $report) { ?>
                <tr>
                    <th><?php echo $report->region ?></th>
                    <td><?php echo $report->total;
                        $total_registered += $report->total;
                        $regions[$report->region]['total'] = $report->total;
                        ?></td>
                    <?php
                    $query = "SELECT COUNT(*) as total
                FROM school
                INNER JOIN schools ON(schools.schoolId = school.schools_id)
                INNER JOIN district ON(schools.district_id = district.districtId)
                WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND school.status=1
                AND renewal_code<=0 
                AND session_year_id= '" . $current_session->sessionYearId . "' 
                AND district.new_region ='" . $report->new_region . "'";
                    $current_registered = $this->db->query($query)->row();
                    ?>
                    <th class="region_registered"><?php echo $current_registered->total; ?></th>
                    <th class="region_upgradation"></th>
                    <?php
                    $query = "SELECT COUNT(*) as total
                FROM school
                INNER JOIN schools ON(schools.schoolId = school.schools_id)
                INNER JOIN district ON(schools.district_id = district.districtId)
                WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND school.status=1
                AND renewal_code>0
                AND session_year_id= '" . $current_session->sessionYearId . "' 
                AND district.new_region ='" . $report->new_region . "'";
                    $current_renewal = $this->db->query($query)->row();

                    ?>
                    <th class="region_total"><?php echo $current_renewal->total;
                                                $regions[$report->region]['renewal'] = $current_renewal->total;
                                                ?></th>
                    <th class="region_precentage">
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
                $query = "SELECT COUNT(*) as total
            FROM school
            INNER JOIN schools ON(schools.schoolId = school.schools_id)
            INNER JOIN district ON(schools.district_id = district.districtId)
            WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
            AND school.status=1
            AND renewal_code<=0 
            AND session_year_id= '" . $current_session->sessionYearId . "'";
                $current_registered = $this->db->query($query)->row();
                ?>
                <th><?php echo $current_registered->total; ?></th>
                <th></th>
                <?php
                $query = "SELECT COUNT(*) as total
           FROM school
           INNER JOIN schools ON(schools.schoolId = school.schools_id)
           INNER JOIN district ON(schools.district_id = district.districtId)
           WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
           AND school.status=1
           AND renewal_code>0
           AND session_year_id= '" . $current_session->sessionYearId . "'";
                $current_renewal = $this->db->query($query)->row();
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
</div>
<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>

<script>
    Highcharts.chart('region_wise_summary_chart', {
        title: {
            text: 'Region wise Registered Schools and Current Session Renewals',
            align: 'left',
            style: {
                fontSize: '12px' // Corrected font size
            }
        },
        xAxis: {
            categories: [
                <?php foreach ($regions as $region_name => $region) { ?>
                    <?php echo "'" . $region_name . "', "; ?>
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
                name: 'Registered',
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true,
                data: [
                    <?php foreach ($regions as $region_name => $region) { ?>
                        <?php echo "" . $region['total'] . ", "; ?>
                    <?php } ?>
                ]
            }, {
                type: 'bar',
                name: 'Renewals',
                color: 'red',
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true,
                data: [
                    <?php foreach ($regions as $region_name => $region) { ?>
                        <?php echo "" . $region['renewal'] . ", "; ?>
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