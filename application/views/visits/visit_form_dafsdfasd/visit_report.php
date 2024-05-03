<?php
$visit_start = new DateTime($input->visit_start);
$visit_end = new DateTime($input->visit_end);

// Calculate the difference between visit_end and visit_start
$time_taken = $visit_end->diff($visit_start);

// Format the difference as a string
//$time_taken_formatted = $time_taken->format('%y years, %m months, %d days, %H hours, %I minutes, %S seconds');
$time_taken_formatted = $time_taken->format('%H hours, %I minutes, %S seconds');

?>
<?php
$query = "SELECT 
                 SUM(rooms) as rooms,
                 SUM(boys) as boys,
                 SUM(girls) as girls,
                 MAX(max_fee) as max_fee
                 FROM visit_details 
                 WHERE visit_id ='" . $visit_id . "'
                 AND school_id ='" . $school_id . "' 
                 AND schools_id ='" . $schools_id . "'";
$class_summary = $this->db->query($query)->row();
?>
<div class="row" style="margin-bottom: 30px;">
    <div class="col-xs-12">

        <div class="col-xs-12">
            <h5>Data Summary</h5>
            <table class="table1 table1_small">
                <tr>
                    <th>Max Fee</th>
                    <th>Fee Category</th>
                </tr>
                <tr>
                    <td><?php echo $class_summary->max_fee; ?></td>
                    <td>
                        <?php
                        if ($max_fee <= 2000) {
                            echo 'Category 1';
                        } elseif ($max_fee > 2000 && $max_fee <= 3500) {
                            echo 'Category 2';
                        } elseif ($max_fee > 3500 && $max_fee <= 6000) {
                            echo 'Category 3';
                        } elseif ($max_fee > 6000 && $max_fee <= 10000) {
                            echo 'Category 4';
                        } elseif ($max_fee > 10000 && $max_fee <= 15000) {
                            echo 'Category 5';
                        } elseif ($max_fee > 15000 && $max_fee <= 20000) {
                            echo 'Category 6';
                        } elseif ($max_fee > 20000) {
                            echo 'Category 7';
                        }
                        ?>
                    </td>
                </tr>
            </table>

            <br />

            <table class="table1 table1_small">
                <tr>
                    <td>Class Rooms</td>
                    <td><?php echo $total_class_rooms = $class_summary->rooms; ?></td>
                </tr>
                <tr>
                    <td>Staff Rooms (M)</td>
                    <td><?php echo $input->male_staff_rooms; ?></td>
                </tr>
                <tr>
                    <td>Staff Rooms (F)</td>
                    <td><?php echo $input->female_staff_rooms; ?></td>
                </tr>
                <tr>
                    <td>Principal Office</td>
                    <td><?php echo $input->principal_office; ?></td>
                </tr>
                <tr>
                    <td>Account Office</td>
                    <td><?php echo $input->account_office; ?></td>
                </tr>
                <tr>
                    <td>Reception</td>
                    <td><?php echo $input->reception; ?></td>
                </tr>
                <tr>
                    <td>Waiting Area</td>
                    <td><?php echo $input->waiting_area; ?></td>
                </tr>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Washrooms</th>
                    <th>Males</th>
                    <th>Females</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Washrooms</td>
                    <td><?php echo $input->male_washrooms; ?></td>
                    <td><?php echo $input->female_washrooms; ?></td>
                    <td><?php echo $input->male_washrooms + $input->female_washrooms; ?></td>
                </tr>
            </table>

            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Staff</th>
                    <th>Non Teaching Staff</th>
                    <th>Teaching Staff</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Males</td>
                    <td><?php echo $input->non_teaching_male_staff; ?></td>
                    <td><?php echo $input->teaching_male_staff; ?></td>
                    <td><strong><?php echo $input->non_teaching_male_staff + $input->teaching_male_staff; ?></strong></td>
                </tr>
                <tr>
                    <td>Females</td>
                    <td><?php echo $input->non_teaching_female_staff; ?></td>
                    <td><?php echo $input->teaching_female_staff; ?></td>
                    <td><strong><?php echo $input->non_teaching_female_staff + $input->teaching_female_staff; ?></strong></td>
                </tr>

                <tr>
                    <td>Total</td>
                    <td><strong><?php echo $input->non_teaching_male_staff + $input->non_teaching_female_staff; ?></strong></td>
                    <td><strong><?php echo $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                    <td><strong><?php echo $total_teachers = $input->non_teaching_male_staff + $input->non_teaching_female_staff + $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                </tr>
            </table>


        </div>

        <div class="col-xs-12">
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Subject Lab</th>
                    <th>Lab Status</th>
                    <th>Equipments</th>
                </tr>
                <?php if ($input->high_l == 1 && $input->high_sec_l == 0) { ?>
                    <tr>
                        <td>High Level</td>
                        <td><?php echo $input->high_level_lab; ?></td>
                        <td><?php echo ($input->high_level_lab == 'Yes') ? $input->high_level_lab_equipment : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
                <?php if ($input->high_sec_l == 1) { ?>
                    <tr>
                        <td>Physics</td>
                        <td><?php echo $input->physics_lab; ?></td>
                        <td><?php echo ($input->physics_lab == 'Yes') ? $input->physics_lab_equipment : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Biology</td>
                        <td><?php echo $input->biology_lab; ?></td>
                        <td><?php echo ($input->biology_lab == 'Yes') ? $input->biology_lab_equipment : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Chemistry</td>
                        <td><?php echo $input->chemistry_lab; ?></td>
                        <td><?php echo ($input->chemistry_lab == 'Yes') ? $input->chemistry_lab_equipment : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
            </table>

            <br />
            <table class="table1 table1_small">
                <tr>

                    <td>Computer Lab</td>
                    <td><?php echo $input->computer_lab; ?></td>
                </tr>
                <?php if ($input->computer_lab == 'Yes') { ?>
                    <tr>
                        <td>Total Working Computers</td>
                        <td><?php echo $input->total_working_computers; ?></td>
                    </tr>
                    <tr>
                        <td>Total Not Working Computers</td>
                        <td><?php echo $input->total_not_working_computers; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>Library</td>
                    <td><?php echo $input->library; ?></td>
                </tr>
                <?php if ($input->library == 'Yes') { ?>
                    <tr>
                        <td>Library Books Total</td>
                        <td><?php echo $input->library_books; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Student Teacher Radio</th>
                    <td><?php
                        $total_students = $class_summary->boys + $class_summary->girls;
                        echo round($total_students / $total_teachers, 1); ?></td>
                </tr>
                <tr>
                    <th>Student Class Rooms Radio</th>
                    <td><?php echo round($total_students / $total_class_rooms, 1); ?></td>
                </tr>
            </table>
            <br />
            <table class="table1 table1_small">
                <tr>
                    <th>Boys</th>
                    <th>Girls</th>
                    <th>Total Students</th>
                </tr>
                <tr>

                    <td><?php echo $class_summary->boys; ?></td>
                    <td><?php echo $class_summary->girls; ?></td>
                    <td><?php echo $total_students = $class_summary->boys + $class_summary->girls; ?></td>
                </tr>
            </table>

        </div>



    </div>
</div>
<div class="row" style="margin-bottom: 30px;">
    <div class="col-xs-12">
        <div class="col-xs-12">
            <h4>Final Report</h4>
            <p style="color: white;">
                <?php echo "Time taken: $time_taken_formatted";  ?> <br />
                Visited By <?php echo $input->visited_by_officers; ?> and <?php echo $input->visited_by_officials; ?> on date <?php echo $input->visit_date; ?>
                <?php if ($input->recommendation == 'Recommended') { ?>
                    and <strong>recommended</strong> for
                    <strong><?php
                            if ($school->school_type_id == 1) {
                                echo ($input->r_primary_l == 1) ? 'Primary, ' : '';
                                echo ($input->r_middle_l == 1) ? 'Middle, ' : '';
                                echo ($input->r_high_l == 1) ? 'High, ' : '';
                                echo ($input->r_high_sec_l == 1) ? 'Higher Secondary' : '';
                            }
                            if ($school->school_type_id == 7) {
                                echo ($input->r_academy_l == 1) ? 'Academy' : '';
                            }
                            ?></strong>
                <?php } ?>
            </p>
            <?php if ($input->recommendation == 'Not Recommended') { ?>
                and <strong>not recommended</strong> for levels any level.
                <p style="color: white;">
                    <strong>Reasons: </strong>
                    <?php echo $input->not_recommendation_remarks; ?>
                </p>

            <?php } ?>
            <p style="color: white;">

                <strong>Other Notes:</strong>
                <?php echo $input->other_remarks; ?>

            </p>
        </div>
    </div>

</div>