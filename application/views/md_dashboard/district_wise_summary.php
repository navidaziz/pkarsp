<?php
$start_time = microtime(true);
$query = "SELECT 
districtTitle,
                 districtId,
                         COUNT(DISTINCT schools_id) AS total
FROM school
INNER JOIN schools ON(schools.schoolId = school.schools_id)
INNER JOIN district ON(schools.district_id = district.districtId)
WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
AND school.status=1
GROUP BY districtId;";
$reports = $this->db->query($query)->result();
$districts = array();
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row();
?>
<table class="datatable table table_small table-bordered">
    <thead>
        <tr>
            <th>District</th>
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

        foreach ($reports as $report) { ?>
            <tr>
                <th><?php
                    $districts[$report->districtTitle]['total'] = $report->total;
                    echo $report->districtTitle ?></th>
                <td class="district_reg_total"><?php echo $report->total;
                                                $total_registered += $report->total;
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
                AND district.districtId ='" . $report->districtId . "'";
                $current_registered = $this->db->query($query)->row();
                ?>
                <th class="district_registration"><?php echo $current_registered->total; ?></th>
                <th class="district_upgradation"></th>
                <?php
                $query = "SELECT COUNT(*) as total
                FROM school
                INNER JOIN schools ON(schools.schoolId = school.schools_id)
                INNER JOIN district ON(schools.district_id = district.districtId)
                WHERE school.schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND school.status=1
                AND renewal_code>0
                AND session_year_id= '" . $current_session->sessionYearId . "' 
                AND district.districtId ='" . $report->districtId . "'";
                $current_renewal = $this->db->query($query)->row();

                ?>
                <td class="district_total"><?php echo $current_renewal->total; ?></td>
                <th class="district_precentage">
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

<?php
$end_time = microtime(true); // Record the end time in seconds with microseconds

$execution_time = $end_time - $start_time; // Calculate the execution time

echo "<small>Execution Time: " . $execution_time . " seconds </small>";
?>