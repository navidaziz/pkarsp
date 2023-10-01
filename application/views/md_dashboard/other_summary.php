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