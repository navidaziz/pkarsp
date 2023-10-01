<?php
$query = "SELECT sessionYearId FROM `session_year` WHERE status=1";
$current_session = $this->db->query($query)->row()->sessionYearId;
?>
<table class="datatable table table_small table-bordered" style="background-color: white;">
    <tr>
        <th>Gender Wise Schools</th>
        <th>Total Students</th>
        <th>Non Teaching Staff's</th>
        <th>Teaching Staff's</th>
    </tr>
    <tr>
        <td style="text-align: left;">
            <span class="female">Girls:
                <strong>
                    <?php
                    $query = "SELECT 
                COUNT(DISTINCT schools_id) AS total
                FROM school
                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND status=1 and gender_type_id=2;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="male">Boys:
                <strong>
                    <?php
                    $query = "SELECT 
                COUNT(DISTINCT schools_id) AS total
                FROM school
                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND status=1 and gender_type_id=1;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="female_male">
                Co-Edu:
                <strong>
                    <?php
                    $query = "SELECT 
                COUNT(DISTINCT schools_id) AS total
                FROM school
                WHERE schoolId = (select MAX(s.schoolId) from school as s WHERE s.schools_id = school.schools_id and status=1)
                AND status=1 and gender_type_id=3;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>
        </td>
        <td style="text-align: left;">
            <span class="female">Girls:
                <strong>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "'
                    AND e.gender_id=2;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total); ?>
                </strong>
            </span>

            <span class="male">Boys:
                <strong>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "'
                    AND e.gender_id=1;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="female_male"> Total:
                <strong>
                    <?php
                    $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "';";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

        </td>
        <td style="text-align: left;">
            <span class="female">Females:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffGender=2
                AND ss.schoolStaffType = 2;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="male"> Males:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffGender=1
                AND ss.schoolStaffType = 2;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="female_male"> Total:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffType = 2;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>
        </td>
        <td style="text-align: left;">
            <span class="female">Females:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffGender=2
                AND ss.schoolStaffType = 1;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="male"> Males:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffGender=1
                AND ss.schoolStaffType = 1;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>

            <span class="female_male"> Total:
                <strong>
                    <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                INNER JOIN school as s on(s.schoolId = ss.school_id)
                WHERE s.session_year_id = '" . $current_session . "'
                AND ss.schoolStaffType = 1;";
                    $total = $this->db->query($query)->row()->total;
                    echo number_format($total);
                    ?>
                </strong>
            </span>
        </td>
    </tr>

</table>

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
<p>
<table class="datatable table table_small table-bordered">
    <thead>
        <tr>
            <!-- <th></th> -->
            <?php foreach ($reports as $report) {  ?>
                <th><?php echo $report->level ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- <td style="width: 20%;">Levels</td> -->
            <?php
            $total_registered = 0;
            $levels = array();
            foreach ($reports as $report) { ?>
                <th class="level_new_registration" style="width: 20%;"><?php echo $report->total; ?></th>
            <?php } ?>
        </tr>
        <tr>
            <th colspan="4">Gender of Education</th>
        </tr>
        <tr>
            <?php foreach ($reports as $report) { ?>
                <td style="text-align: left;">
                    <span class="female">Girls:
                        <strong>
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
                        </strong>
                    </span>

                    <span class="male">Boys:
                        <strong>
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
                        </strong>
                    </span>

                    <span class="female_male">
                        Co-Edu:
                        <strong>
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
                        </strong>
                    </span>
                </td>
            <?php } ?>

        </tr>
        <tr>
            <th colspan="4">Students</th>
        </tr>
        <tr>
            <?php foreach ($reports as $report) { ?>
                <td style="text-align: left;">
                    <span class="female">Girls:
                        <strong>
                            <?php
                            $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                            $total = $this->db->query($query)->row()->total;
                            echo number_format($total); ?>
                        </strong>
                    </span>

                    <span class="male">Boys:
                        <strong>
                            <?php
                            $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                                INNER JOIN school as s on(s.schoolId = e.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND e.gender_id=1
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                            $total = $this->db->query($query)->row()->total;
                            echo number_format($total);
                            ?>
                        </strong>
                    </span>

                    <span class="female_male"> Total:
                        <strong>
                            <?php
                            $query = "SELECT SUM(enrolled) as total FROM age_and_class as e
                    INNER JOIN school as s on(s.schoolId = e.school_id)
                    WHERE s.session_year_id = '" . $current_session . "'
                     AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                            $total = $this->db->query($query)->row()->total;
                            echo number_format($total);
                            ?>
                        </strong>
                    </span>

                </td>
            <?php } ?>


        </tr>
        <tr>
            <th colspan="4">Non Teaching Staff's</th>
        </tr>
        <tr>
            <?php foreach ($reports as $report) { ?>
                <td style="text-align: left;">
                    <span class="female">Females:
                        <strong>
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
                        </strong>
                    </span>

                    <span class="male"> Males:
                        <strong>
                            <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffGender=1
                                AND ss.schoolStaffType = 2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                            $total = $this->db->query($query)->row()->total;
                            echo number_format($total);
                            ?>
                        </strong>
                    </span>

                    <span class="female_male"> Total:
                        <strong>
                            <?php $query = "SELECT COUNT(schoolStaffId) as total FROM school_staff as ss
                                INNER JOIN school as s on(s.schoolId = ss.school_id)
                                WHERE s.session_year_id = '" . $current_session . "'
                                AND ss.schoolStaffType = 2
                                AND s.level_of_school_id = '" . $report->level_of_school_id . "';";
                            $total = $this->db->query($query)->row()->total;
                            echo number_format($total);
                            ?>
                        </strong>
                    </span>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <th colspan="4">Teaching Staff's</th>
        </tr>
        <tr>
            <td style="text-align: left;">Females: <br />
                Males: <br />
                Total: <br />
            </td>
            <td style="text-align: left;">Females: <br />
                Males: <br />
                Total: <br />
            </td>
            <td style="text-align: left;">Females: <br />
                Males: <br />
                Total: <br />
            </td>
            <td style="text-align: left;">Females: <br />
                Males: <br />
                Total: <br />
            </td>
        </tr>
        <tr>

            <td>
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                    60%
                </div>
            </td>
            <td>
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                    60%
                </div>
            </td>
            <td>
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                    60%
                </div>
            </td>
            <td>
                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                    60%
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>

    </tfoot>
</table>