<?php
$start_time = microtime(true);
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row()->sessionYearId;
?>

<?php $query = "
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
$current_session = $this->db->query($query)->row()->sessionYearId; ?>



<div class="jumbotron" style="padding: 9px;">
    <strong>Students and Staff Distribution Across Gender and Levels</strong>
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
                <th>Total</th>

                <th>Girls</th>
                <th>Boys</th>
                <th>Co-EDU</td>

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
                    <th><?php echo $report->level ?></th>
                    <th><?php echo $report->total; ?></th>
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
                <th><?php echo $levels_total; ?></th>
                <td>
                    <?php
                    $query = "SELECT 
                                COUNT(DISTINCT schools_id) AS total
                                FROM school
                                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                                AND status=1 and gender_type_id=2";
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
                                AND status=1 and gender_type_id=1";
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
                                AND status=1 and gender_type_id=3";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>

                </td>
                <td>

                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=2";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total); ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=1";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "'";
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
                                AND ss.schoolStaffType = 2";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 2";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 2";
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
                                AND ss.schoolStaffType = 1";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 1";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>
                <td>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 1";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </td>

            </tr>

        </tfoot>
    </table>
    <?php
    $end_time = microtime(true); // Record the end time in seconds with microseconds

    $execution_time = $end_time - $start_time; // Calculate the execution time

    echo "<small style='font-size:9px !important'>Execution Time: " . $execution_time . " seconds </small>";
    ?>
</div>