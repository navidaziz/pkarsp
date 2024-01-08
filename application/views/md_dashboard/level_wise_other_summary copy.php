<?php
$start_time = microtime(true);
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row()->sessionYearId;
?>

<?php $query = "
                SELECT 
                IF(school.level_of_school_id=1,'Primary',
                                IF(school.level_of_school_id=2, 'Middle',
                                    IF(school.level_of_school_id=3, 'High', 
                                    IF(school.level_of_school_id=4, 'High Sec.',
                                        IF(school.level_of_school_id=5, 'Academies', 'Others')
                                        )))) as level,
                                        school.level_of_school_id,
                                        COUNT(DISTINCT school.schools_id) AS total
                FROM school
                INNER JOIN schools ON(schools.schoolId = school.schools_id)
                WHERE school.level_of_school_id = (select MAX(s.level_of_school_id) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND school.status=1 ";
if ($district_id) {
    $query .= " AND schools.district_id = $district_id";
}
$query .= " GROUP BY level_of_school_id;";
$reports = $this->db->query($query)->result();
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row()->sessionYearId; ?>



<div class="jumbotron" style="padding: 9px;">
    <strong class="pull-left">Students and Staff Distribution Across Gender and Levels</strong>
    <!-- <select onchange="level_wise_other_summary('level_wise_other_summary')" class="pull-right" style="font-size: 12px;">
        <option value="0">Filter By District</option>
        <?php $query = "SELECT * FROM district";
        $districts = $this->db->query($query)->result();
        foreach ($districts as $district) { ?>
            <option id="<?php echo $district->districtId; ?>"><?php echo $district->districtTitle; ?></option>
        <?php } ?>
    </select> -->
    <table class="datatable table table_small table-bordered" style="font-size: 12px !important;">
        <thead>
            <tr>
                <th colspan="2"></th>

                <th colspan="3"> Gender of Education </th>

                <th colspan="3">Students</th>

                <th colspan="3">Non Teaching Staffs</th>

                <th colspan="3">Teaching Staffs</th>
            </tr>
            <tr>
                <th>Levels</th>


                <th>Girls</th>
                <th>Boys</th>
                <th>Co-Edu</td>
                <th>Total</th>

                <th>Girls</th>
                <th>Boys</th>
                <th>Total</th>

                <th>Female</th>
                <th>Male</th>
                <th>Total</th>

                <th>Female</th>
                <th>Male</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $total_registered = 0;
            $levels = array();
            $levels_total = 0;
            foreach ($reports as $report) {
                $levels_total += $report->total;
            ?>
                <tr>
                    <th style="text-align: left;"><?php echo $report->level ?></th>

                    <td>
                        <?php
                        $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=2
                                AND level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php
                        $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=1
                                AND level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php
                        $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=3
                                AND level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>

                    </td>
                    <th><?php echo $report->total; ?></th>
                    <td>

                        <?php
                        $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total); ?>
                    </td>
                    <td>
                        <?php
                        $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=1
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php
                        $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                        INNER JOIN school as s on(s.schoolId = e.school_id)
                        WHERE s.session_year_id = '" . $current_session . "'
                        AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>

                    </td>
                    <td>
                        <?php
                        $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=2
                                AND ss.schoolStaffType = 2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>


                    <td>
                        <?php
                        $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=2
                                AND ss.schoolStaffType = 1
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 1
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>
                    <td>
                        <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 1
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                        $total = $this->db->query($query)->row()->total;
                        echo number_format($total);
                        ?>
                    </td>

                </tr>
            <?php } ?>


        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>

                <td>
                    <?php
                    $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=2";
                    $total = $girls_schools =  $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=1";
                    $total = $boys_schools =  $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=3";
                    $total = $coeducation = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>

                </td>
                <th><?php echo $levels_total; ?></th>
                <td>

                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=2";
                    $total = $girls = $this->db->query($query)->row()->total;
                    echo number_format($total); ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=1";
                    $total = $boys = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "'";
                    $total = $total_students = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>

                </td>
                <td>
                    <?php
                    $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=2
                                AND ss.schoolStaffType = 2";
                    $total = $nts_females = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 2";
                    $total = $nts_males = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 2";
                    $total = $nts_total = $this->db->query($query)->row()->total;
                    echo  number_format($total);
                    ?>
                </td>


                <td>
                    <?php
                    $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=2
                                AND ss.schoolStaffType = 1";
                    $total = $ts_females =  $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 1";
                    $total = $ts_males = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 1";
                    $total = $ts_total =  $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>

            </tr>
            <tr>
                <th></th>
                <th><?php echo round(($girls_schools * 100) / $levels_total, 2) . "%" ?></th>
                <th><?php echo round(($boys_schools * 100) / $levels_total, 2) . "%" ?></th>
                <th><?php echo round(($coeducation * 100) / $levels_total, 2) . "%" ?></th>
                <th></th>
                <th><?php echo round(($girls * 100) / $total_students, 2) . "%" ?></th>
                <th><?php echo round(($boys * 100) / $total_students, 2) . "%" ?></th>
                <th></th>
                <th><?php echo round(($nts_females * 100) / $nts_total, 2) . "%" ?></th>
                <th><?php echo round(($nts_males * 100) / $nts_total, 2) . "%" ?></th>
                <th></th>
                <th><?php echo round(($ts_females * 100) / $ts_total, 2) . "%" ?></th>
                <th><?php echo round(($ts_males * 100) / $ts_total, 2) . "%" ?></th>

                <th></th>
            </tr>
        </tfoot>
    </table>
    <?php
    $end_time = microtime(true); // Record the end time in seconds with microseconds

    $execution_time = $end_time - $start_time; // Calculate the execution time

    echo "<small style='font-size:9px !important'>Execution Time: " . $execution_time . " seconds </small>";
    ?>
</div>
<script>
    function level_wise_other_summary(funcation_name) {
        alert(funcation_name);
        district_id = 0;
        $('#' + funcation_name).html('<h6 style="text-align: center;" class="linear-background">Please Wiat ....</h6>');
        $.ajax({
                method: "POST",
                url: "http://localhost/pkarsp/md_dashboard/" + funcation_name,
                data: {
                    district_id: district_id
                }
            })
            .done(function(respose) {
                $('#' + funcation_name).html(respose);
            });
    }
</script>