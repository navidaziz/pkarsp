<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="form" value="<?php echo $form; ?>" />

    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
    <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />

    <?php if ($school->registrationNumber <= 0) { ?>
        <input type="hidden" name="registered" value="1" />
        <div class="block_div">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($input->property_posession == 'Rented') { ?>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label for="rent_aggrement_date" class="col-form-label">Rent Aggrement Date</label>

                                <input type="date" required id="rent_aggrement_date" name="rent_aggrement_date" value="<?php echo $input->rent_aggrement_date; ?>" class="form-control">

                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="first_enrollement_date" class="col-form-label">First Student Enrollment Date</label>

                            <input type="date" required id="first_enrollement_date" name="first_enrollement_date" value="<?php echo $input->first_enrollement_date; ?>" class="form-control">

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="first_teacher_appointment_date" class="col-form-label">First Teacher Appointment Date</label>

                            <input type="date" required id="first_teacher_appointment_date" name="first_teacher_appointment_date" value="<?php echo $input->first_teacher_appointment_date; ?>" class="form-control">

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="year_of_establisment" class="col-form-label">Confirmed Year of Establisment</label>

                            <input type="month" required id="year_of_establisment" name="year_of_establisment" value="<?php echo $input->year_of_establisment; ?>" class="form-control">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <input type="hidden" name="registered" value="1" />

    <?php } ?>



    <div class="block_div">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="portrait_quaid" class="col-form-label">Portrait of Quaid-e-Azam</label>
                    </div>
                </div>

                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->portrait_quaid) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="portrait_quaid" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="portrait_iqbal" class="col-form-label">Portrait of Allama Iqbal</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->portrait_iqbal) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="portrait_iqbal" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="student_furnitures" class="col-form-label">Furnitures Provided to All Students</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->student_furnitures) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="student_furnitures" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="staff_furnitures" class="col-form-label">Furnitures Provided to All Staff</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->staff_furnitures) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="staff_furnitures" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="cross_ventilation" class="col-form-label">Cross Ventilation in class rooms</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->cross_ventilation) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="cross_ventilation" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="notice_board" class="col-form-label">Notice board</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->notice_board) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input name="notice_board" required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="class_bell" class="col-form-label">Class Bell Exist</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->class_bell) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input name="class_bell" required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="national_flag" class="col-form-label">National Flag Exist</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->national_flag) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input name="national_flag" required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="fee_displayed" class="col-form-label">Fee Details Displayed out side</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->fee_displayed) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input name="fee_displayed" required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="annual_displayed" class="col-form-label">Annual Calendar Displayed for each class</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->annual_displayed) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input name="annual_displayed" required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Water</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->water) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="water" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Electricity</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->electricity) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="electricity" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Boundary Wall</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->boundary_wall) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="boundary_wall" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Exam Hall</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->exam_hall) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="exam_hall" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="play_ground" class="col-form-label">Play Ground</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->play_ground) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="play_ground" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="play_area" class="col-form-label">Play Area</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->play_area) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="play_area" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Canteen</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->canteen) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="canteen" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Students Hostel</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->stud_hostel) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="stud_hostel" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Staff Hostel</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->staff_hostel) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="staff_hostel" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">Transport</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->transport) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="transport" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="water" class="col-form-label">First Aid</label>
                    </div>
                </div>

                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->first_aid) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="first_aid" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>


            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="timing" class="col-form-label">Admi. / withdrawal Reg.</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->admi_withdreal_reg) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="admi_withdreal_reg" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="timing" class="col-form-label">Stud. Attendance Reg.</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->stu_attend_reg) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="stu_attend_reg" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="timing" class="col-form-label">Students Fee Reg.</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->stu_fee_reg) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="stu_fee_reg" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="timing" class="col-form-label">Teach. Attendance Reg.</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->tecah_attend_reg) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="tecah_attend_reg" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="timing" class="col-form-label">Teachers Salary Reg.</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->tecah_salary_reg) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="tecah_salary_reg" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="computer_available" class="col-form-label">Computer Availability </label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->computer_available) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="computer_available" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="internet_connection" class="col-form-label">Internet / DSL Connection </label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->internet_connection) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="internet_connection" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="mobile_connectivity" class="col-form-label">Mobile 3G / 4G Access</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->mobile_connectivity) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="mobile_connectivity" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="mardrasa" class="col-form-label">Is there a shared building for both Madrasa and School ?</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->mardrasa) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="mardrasa" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="col-xs-7">
                    <div class="form-group">
                        <label for="academy" class="col-form-label">Is there a Tuition Academy within the school?</label>
                    </div>
                </div>
                <div class="col-xs-5">
                    <?php
                    $options = array("Yes", "No");
                    foreach ($options as $option) {
                        $checked = "";
                        if ($option == $input->academy) {
                            $checked = "checked";
                        }

                    ?>
                        <span style="margin-left:5px"></span>
                        <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="academy" value="<?php echo $option; ?>" class="">
                        <span style="margin-left:3px"></span> <?php echo $option;  ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="block_div" style="margin-bottom: 35px;">
        <div class="row">
            <div id="result_response"></div>
            <div class="col-xs-4" style="text-align: center;">
                <a class="btn btn-small" href='<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/a"); ?>'><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
            </div>

            <div class="col-xs-4" style="text-align: center;">
                <button class="btn btn-small" type="submit" name="submitButton" value="same">Save (F)</button>
            </div>

            <div class="col-xs-4" style="text-align: center;">
                <button class="btn btn-small" type="submit" name="submitButton" value="next">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>


</form>


<script>
    $('#visits').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var submitButtonValue = $(document.activeElement).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visit_app/add_visit_report"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    switch (submitButtonValue) {
                        case "same":
                            location.reload();
                            break;
                        case "next":
                            window.location.href = "<?php echo site_url("visit_app/institute_visit_report/$visit_id/$schools_id/$school_id/c"); ?>";
                            break;
                        default:
                            alert("Unknown button clicked");
                    }
                } else {
                    $('#result_response').html(response);

                }

            }
        });
    });
</script>