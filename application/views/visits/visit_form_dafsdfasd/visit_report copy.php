<div class="row" style="margin-bottom: 30px;">
    <p>
        <?php
        $visit_start = new DateTime($input->visit_start);
        $visit_end = new DateTime($input->visit_end);

        // Calculate the difference between visit_end and visit_start
        $time_taken = $visit_end->diff($visit_start);

        // Format the difference as a string
        //$time_taken_formatted = $time_taken->format('%y years, %m months, %d days, %H hours, %I minutes, %S seconds');
        $time_taken_formatted = $time_taken->format('%H hours, %I minutes, %S seconds');

        ?>
    </p>
    <div class="col-xs-12">
        <?php echo "Time taken: $time_taken_formatted";  ?> <br />
        Visited By <?php echo $input->visited_by_officers; ?> and <?php echo $input->visited_by_officials; ?> on date <?php echo $input->visit_date; ?>.

        <?php
        // Initialize variables for total sum and max values
        $total_rooms = 0;
        $total_boys = 0;
        $total_girls = 0;
        $total_max_fee = 0;
        $max_rooms = 0;
        $max_boys = 0;
        $max_girls = 0;
        $max_max_fee = 0;

        $levels = NULL;
        if ($input->primary_l == 1) {
            $levels[] = 1;
        }

        if ($input->middle_l == 1) {
            $levels[] = 2;
        }

        if ($input->high_l == 1) {
            $levels[] = 3;
        }

        if ($input->high_sec_l == 1) {
            $levels[] = 4;
        }

        if ($input->academy_l == 1) {
            $levels[] = 5;
        }
        $o_a_levels = 0;
        if ($input->o_a_levels == 'No') {
            $o_a_levels = '16,17,18,19,20';
        }

        $query = "SELECT * FROM levelofinstitute WHERE levelofInstituteId IN(" . implode(', ', $levels) . ")";
        $levels = $this->db->query($query)->result();
        foreach ($levels as $level) {
            $level_rooms = 0;
            $level_boys = 0;
            $level_girls = 0;
            $level_max_fee = 0;
        ?>
            <h4><?php echo $level->levelofInstituteTitle; ?></h4>
            <table class="table1 table1_small">
                <tr>
                    <th style="width: 100px;">Classes</th>
                    <th>Rooms</th>
                    <th>Boys</th>
                    <th>Girls</th>
                    <th>Fee</th>
                </tr>
                <?php
                $classes = $this->db->query("SELECT * FROM class 
                    WHERE class.level_id = " . $level->levelofInstituteId . "
                    AND classId NOT IN (" . $o_a_levels . ")
                    order by level_id ASC, classId ASC")->result();
                foreach ($classes  as $class) {

                    $query = "SELECT * FROM visit_details 
                                WHERE visit_id ='" . $visit_id . "'
                                AND school_id ='" . $school_id . "' 
                                AND schools_id ='" . $schools_id . "'
                                AND class_id = '" . $class->classId . "'";
                    $class_detail = $this->db->query($query)->row();

                    // Calculate level sums
                    $level_rooms += $class_detail->rooms;
                    $level_boys += $class_detail->boys;
                    $level_girls += $class_detail->girls;
                    $level_max_fee += $class_detail->max_fee;

                    // Update total sums
                    $total_rooms += $class_detail->rooms;
                    $total_boys += $class_detail->boys;
                    $total_girls += $class_detail->girls;
                    $total_max_fee += $class_detail->max_fee;

                    // Update max values
                    $max_rooms = $max_rooms += $class_detail->rooms;
                    $max_boys = $max_boys += $class_detail->boys;
                    $max_girls = $max_girls += $class_detail->girls;
                    $max_max_fee = max($max_max_fee, $class_detail->max_fee);
                ?>

                    <tr>
                        <th style=""><?php echo $class->classTitle ?></th>
                        <td>
                            <?php echo $class_detail->rooms; ?>
                        </td>
                        <td>
                            <?php echo $class_detail->boys; ?>
                        </td>
                        <td>
                            <?php echo $class_detail->girls; ?>
                        </td>
                        <td>
                            <?php echo $class_detail->max_fee;
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php ?>
                <tr>
                    <th>Total</th>
                    <td><?php echo $level_rooms; ?></td>
                    <td><?php echo $level_boys; ?></td>
                    <td><?php echo $level_girls; ?></td>
                    <td></td>
                </tr>
            </table>
        <?php } ?>

        <!-- Display total sum and max for all levels -->
        <h4>Visit Report Summary</h4>

        <div class="col-xs-6">
            <table class="table1 table1_small">
                <tr>
                    <th>Max Fee</th>
                    <th>Category</th>
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
                    <th>Staffs</th>
                    <th>Males</th>
                    <th>Females</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Non Teaching Staff</td>
                    <td><?php echo $input->non_teaching_male_staff; ?></td>
                    <td><?php echo $input->non_teaching_female_staff; ?></td>
                    <td><?php echo $input->non_teaching_male_staff + $input->non_teaching_female_staff; ?></td>
                </tr>
                <tr>
                    <td>Teaching Staff</td>
                    <td><?php echo $input->teaching_male_staff; ?></td>
                    <td><?php echo $input->teaching_female_staff; ?></td>
                    <td><?php echo $input->teaching_male_staff + $input->teaching_female_staff; ?></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo $input->non_teaching_male_staff + $input->teaching_male_staff; ?></strong></td>
                    <td><strong><?php echo $input->non_teaching_female_staff + $input->teaching_female_staff; ?></strong></td>
                    <td><strong><?php echo $total_teachers = $input->non_teaching_male_staff + $input->non_teaching_female_staff + $input->teaching_male_staff + $input->teaching_female_staff; ?></strong></td>
                </tr>
            </table>

        </div>
        <div class="col-xs-6">
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
                    <td><?php echo round($total_students / $total_teachers, 1); ?></td>
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

    <div class="col-xs-12">
        <div class="col-xs-4">
            <div class="form-group">
                <label for="visit_date" class="col-form-label">Visit Date</label>
            </div>
        </div>
        <div class="col-xs-8">

        </div>
    </div>
    <div class="col-xs-12">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="recommendation" class="col-form-label">Recommendation</label>
            </div>
        </div>
        <div class="col-xs-6">
            <?php echo $input->recommendation; ?>
        </div>
    </div>
    <div class="col-md-12" id="recommendation_levels_div" <?php if ($input->recommendation != 'Recommended') { ?>style="display: none;" <?php } ?>>
        <div class="form-group">
            <div class="col-xs-6">
                <label for="recommended_levels" class="col-form-label">Recommended Levels</label>
            </div>
            <div class="col-xs-6">
                <?php
                if ($school->school_type_id == 1) {
                    echo ($input->r_primary_l == 1) ? 'Primary' : '';
                    echo ($input->r_middle_l == 1) ? 'Middle' : '';
                    echo ($input->r_high_l == 1) ? 'High' : '';
                    echo ($input->r_high_sec_l == 1) ? 'Higher Sec.' : '';
                }
                if ($school->school_type_id == 7) {
                    echo ($input->r_academy_l == 1) ? 'Academy' : '';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12" id="not_recommendation_remarks_div" <?php if ($input->recommendation != 'Not Recommended') { ?>style="display: none;" <?php } ?>>
        <label for="not_recommendation_remarks" class="col-form-label">Not Recommendation Remarks</label>
        <?php echo $input->not_recommendation_remarks; ?>
    </div>
    <div class="col-xs-12">
        <label for="other_remarks" class="col-form-label">Other Remarks</label>
        <?php echo $input->other_remarks; ?>
    </div>
    <div>

        <br />

    </div>

</div>