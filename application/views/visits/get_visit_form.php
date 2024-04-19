<style>
    .block_div {
        border: 1px solid #9FC8E8;
        border-radius: 10px;
        min-height: 3px;
        margin: 3px;
        padding: 10px;
        background-color: white;
    }
</style>
<form id="visits" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="visit_id" value="<?php echo $input->visit_id; ?>" />
    <div class="block_div">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-2">
                    <div class="form-group" style="padding:5px; ">
                        <label for="rent_aggrement_date" class="col-form-label">Gender of Edu.</label>
                        <br />
                        <?php
                        $options = array("Boys", "Girls", "Co-Edu");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->gender_of_edu) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="gender_of_edu" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="timing" class="col-form-label">Timing</label>
                        <br />
                        <?php
                        $options = array("Morning", "Evening", "Both");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->timing) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="timing" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="padding:5px; ">
                        <label for="land_type" class="col-form-label">Land Type</label>
                        <br />
                        <?php
                        $options = array("Commercial", "Residential");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->land_type) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="land_type" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="property_posession" class="col-form-label">Property Possession</label>
                        <br />
                        <?php
                        $options = array("Owned", "Rented", "Donated/Trusted");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->property_posession) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="property_posession" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="padding:5px; ">
                        <label for="o_a_levels" class="col-form-label">O Level and A level</label>
                        <br />
                        <?php
                        $options = array("Yes", "No");
                        foreach ($options as $option) {
                            $checked = "";
                            if ($option == $input->o_a_levels) {
                                $checked = "checked";
                            }

                        ?>
                            <span style="margin-left:5px"></span>
                            <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="o_a_levels" value="<?php echo $option; ?>" class="">
                            <span style="margin-left:3px"></span> <?php echo $option;  ?>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block_div">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="rent_aggrement_date" class="col-form-label">Rent Aggrement Date</label>
                        <br />
                        <input type="date" required id="rent_aggrement_date" name="rent_aggrement_date" value="" class="form-control">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="first_enrollement_date" class="col-form-label">First Student Enrollment Date</label>
                        <br />
                        <input type="date" required id="first_enrollement_date" name="first_enrollement_date" value="" class="form-control">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="first_teacher_appointment_date" class="col-form-label">First Teacher Appointment Date</label>
                        <br />
                        <input type="date" required id="first_teacher_appointment_date" name="first_teacher_appointment_date" value="" class="form-control">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" style="padding:5px; ">
                        <label for="year_of_establisment" class="col-form-label">Confirmed Year of Establisment</label>
                        <br />
                        <input type="month" required id="year_of_establisment" name="year_of_establisment" value="" class="form-control">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block_div">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group row">
                        <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                        <div class="col-sm-8">
                            <input type="text" required id="latitude" name="latitude" value="<?php echo $input->latitude; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                        <div class="col-sm-8">
                            <input type="text" required id="longitude" name="longitude" value="<?php echo $input->longitude; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="altitude" class="col-sm-4 col-form-label">Altitude</label>
                        <div class="col-sm-8">
                            <input type="text" required id="altitude" name="altitude" value="<?php echo $input->altitude; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="total_area" class="col-sm-6 col-form-label">Total Area</label>
                        <div class="col-sm-6">
                            <input type="text" required id="total_area" name="total_area" value="<?php echo $input->total_area; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="covered_area" class="col-sm-6 col-form-label">Covered Area</label>
                        <div class="col-sm-6">
                            <input type="text" required id="covered_area" name="covered_area" value="<?php echo $input->covered_area; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row" style="display:none;">
                        <label for="precision" class="col-sm-4 col-form-label">Precision</label>
                        <div class="col-sm-8">
                            <input type="hidden" required id="precision" name="precision" value="0" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block_div">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="portrait_quaid" class="col-sm-6 col-form-label">Portrait of Quaid-e-Azam</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="portrait_iqbal" class="col-sm-6 col-form-label">Portrait of Allama Iqbal</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="student_furnitures" class="col-sm-6 col-form-label">Furnitures Provided to All Students</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="staff_furnitures" class="col-sm-6 col-form-label">Furnitures Provided to All Staff</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="cross_ventilation" class="col-sm-6 col-form-label">Cross Ventilation in class rooms</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="notice_board" class="col-sm-6 col-form-label">Notice board</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="class_bell" class="col-sm-6 col-form-label">Class Bell Exist</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="national_flag" class="col-sm-6 col-form-label">National Flag Exist</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="fee_displayed" class="col-sm-6 col-form-label">Fee Details Displayed out side</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="annual_displayed" class="col-sm-6 col-form-label">Annual Calendar Displayed for each class</label>
                        <div class="col-sm-6">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Water</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Electricity</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Boundary Wall</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Exam Hall</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Play Ground</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Play Area</label>
                        <div class="col-sm-6">
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


                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Canteen</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Students Hostel</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Staff Hostel</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Transport</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">First Aid</label>
                        <div class="col-sm-6">
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
                    <div class="form-group row">
                        <label for="water" class="col-sm-6 col-form-label">Play Area</label>
                        <div class="col-sm-6">
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
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="timing" class="col-sm-7 col-form-label">Admi. / withdrawal Reg.</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="timing" class="col-sm-7 col-form-label">Stud. Attendance Reg.</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="timing" class="col-sm-7 col-form-label">Students Fee Reg.</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="timing" class="col-sm-7 col-form-label">Teach. Attendance Reg.</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="timing" class="col-sm-7 col-form-label">Teachers Salary Reg.</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="computer_available" class="col-sm-7 col-form-label">Computer Availability </label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="internet_connection" class="col-sm-7 col-form-label">Internet / DSL Connection </label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="mobile_connectivity" class="col-sm-7 col-form-label">Mobile 3G / 4G Access</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="mardrasa" class="col-sm-7 col-form-label">Is there a shared building for both Madrasa and School ?</label>
                        <div class="col-sm-5">
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
                    <div class="form-group">
                        <label for="academy" class="col-sm-7 col-form-label">Is there a Tuition Academy within the school?</label>
                        <div class="col-sm-5">
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
        </div>
    </div>

    <div class="block_div">
        <div class="row">
            <div class="col-md-6">
                <style>
                    .table_small>thead>tr>th,
                    .table_small>tbody>tr>th,
                    .table_small>tfoot>tr>th,
                    .table_small>thead>tr>td,
                    .table_small>tbody>tr>td,
                    .table_small>tfoot>tr>td {
                        padding: 1px;
                        line-height: 1;
                        vertical-align: top;
                        border-top: 1px solid #ddd;
                        color: black;
                        margin: 0px !important;
                    }
                </style>
                <table class="table table_small table-bordered">
                    <tr>
                        <th style="width: 300px !important;">Classes</th>
                        <th>Rooms</th>
                        <th>Boys</th>
                        <th>Girls</th>
                        <th>Max Fee</th>

                    </tr>




                    <?php
                    $query = "SELECT * FROM levelofinstitute";
                    $levels = $this->db->query($query)->result();
                    foreach ($levels as $level) { ?>

                        <?php
                        $classes = $this->db->query("SELECT * FROM class 
                        WHERE class.level_id = " . $level->levelofInstituteId . "
                        order by level_id ASC, classId ASC")->result();
                        $count = 1;
                        $count2 = 1;
                        foreach ($classes  as $class) { ?>
                            <tr>

                                <th style=""><?php echo $class->classTitle ?></th>
                                <td><input style="width: 50px;" type="number" value="" name="" /></td>
                                <td><input style="width: 40px;" type="number" value="" name="" /></td>
                                <td><input style="width: 40px;" type="number" value="" name="" /></td>
                                <td><input style="width: 60px;" type="number" value="" name="" /></td>

                            </tr>
                    <?php }
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>

    <div class="block_div">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3">

                    <div class="form-group row">
                        <label for="total_class_rooms" class="col-sm-7 col-form-label">Total C-Rooms</label>
                        <div class="col-sm-5">
                            <input type="text" required id="total_class_rooms" name="total_class_rooms" value="<?php echo $input->total_class_rooms; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="avg_class_rooms_size" class="col-sm-7 col-form-label">AVG C-Rooms Size</label>
                        <div class="col-sm-5">
                            <input type="text" required id="avg_class_rooms_size" name="avg_class_rooms_size" value="<?php echo $input->avg_class_rooms_size; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group row">
                        <label for="male_staff_rooms" class="col-sm-7 col-form-label">Staff Rooms (M)</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->male_staff_rooms) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="male_staff_rooms" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="female_staff_rooms" class="col-sm-7 col-form-label">Staff Rooms (F)</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->female_staff_rooms) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="female_staff_rooms" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="principal_office" class="col-sm-7 col-form-label">Principal Office</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->principal_office) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="principal_office" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="account_office" class="col-sm-7 col-form-label">Account Office</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->account_office) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="account_office" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="reception" class="col-sm-7 col-form-label">Reception</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->reception) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="reception" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waiting_area" class="col-sm-7 col-form-label">Waiting Area</label>
                        <div class="col-sm-5">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->waiting_area) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="waiting_area" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="form-group row">
                        <label for="male_washrooms" class="col-sm-6 col-form-label">Washrooms (M)</label>
                        <div class="col-sm-6">
                            <input type="text" required id="male_washrooms" name="male_washrooms" value="<?php echo $input->male_washrooms; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="female_washrooms" class="col-sm-6 col-form-label">Washrooms (F)</label>
                        <div class="col-sm-6">
                            <input type="text" required id="female_washrooms" name="female_washrooms" value="<?php echo $input->female_washrooms; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="total_male_students" class="col-sm-6 col-form-label">Students (Boys)</label>
                        <div class="col-sm-6">
                            <input type="text" required id="total_male_students" name="total_male_students" value="<?php echo $input->total_male_students; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="total_female_students" class="col-sm-6 col-form-label">Students (Girls)</label>
                        <div class="col-sm-6">
                            <input type="text" required id="total_female_students" name="total_female_students" value="<?php echo $input->total_female_students; ?>" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group row">
                        <label for="non_teaching_male_staff" class="col-sm-8 col-form-label">Non Teaching Staff (M)</label>
                        <div class="col-sm-4">
                            <input type="number" required id="non_teaching_male_staff" name="non_teaching_male_staff" value="<?php echo $input->non_teaching_male_staff; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="non_teaching_female_staff" class="col-sm-8 col-form-label">Non Teaching Staff (F)</label>
                        <div class="col-sm-4">
                            <input type="number" required id="non_teaching_female_staff" name="non_teaching_female_staff" value="<?php echo $input->non_teaching_female_staff; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="teaching_male_staff" class="col-sm-8 col-form-label">Teaching Staff (M)</label>
                        <div class="col-sm-4">
                            <input type="text" required id="teaching_male_staff" name="teaching_male_staff" value="<?php echo $input->teaching_male_staff; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="teaching_female_staff" class="col-sm-8 col-form-label">Teaching Staff (F)</label>
                        <div class="col-sm-4">
                            <input type="text" required id="teaching_female_staff" name="teaching_female_staff" value="<?php echo $input->teaching_female_staff; ?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block_div">
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-3">
                    <?php if ($input->high_l == 1 and $input->high_sec_l == 0) { ?>
                        <div class="form-group row">
                            <label for="high_level_lab" class="col-sm-5 col-form-label">High Level Lab</label>
                            <div class="col-sm-7">
                                <?php
                                $options = array("Yes", "No");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->high_level_lab) {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input required <?php if ($option == 'Yes') { ?> onclick="$('#high_level_lab_div').show();$('.high_level_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#high_level_lab_div').hide();$('.high_level_lab_equipment').prop('required', false);$('.high_level_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="high_level_lab" value="<?php echo $option; ?>" class="">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row" id="high_level_lab_div" <?php if ($input->high_level_lab == 'No') { ?>style="display: none;" <?php } ?>>
                            <label for="high_level_lab_equipment" class="col-sm-4 col-form-label">High Level Lab Equipments</label>
                            <div class="col-sm-8">
                                <?php
                                $options = array("Sufficient", "Deficient");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->high_level_lab_equipment and $input->high_level_lab == 'Yes') {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="high_level_lab_equipment" value="<?php echo $option; ?>" class="high_level_lab_equipment">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($input->high_sec_l == 1) { ?>
                        <div class="form-group row">
                            <label for="physics_lab" class="col-sm-5 col-form-label">Physics Lab</label>
                            <div class="col-sm-7">
                                <?php
                                $options = array("Yes", "No");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->physics_lab) {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input required <?php if ($option == 'Yes') { ?> onclick="$('#physics_lab_equipment_div').show();$('.physics_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#physics_lab_equipment_div').hide();$('.physics_lab_equipment').prop('required', false);$('.physics_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="physics_lab" value="<?php echo $option; ?>" class="">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row" id="physics_lab_equipment_div" <?php if ($input->physics_lab == 'No') { ?>style="display: none;" <?php } ?>>
                            <label for="physics_lab_equipment" class="col-sm-4 col-form-label">Phy. Lab Equipments</label>
                            <div class="col-sm-8">
                                <?php
                                $options = array("Sufficient", "Deficient");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->physics_lab_equipment  and $input->physics_lab == 'Yes') {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="physics_lab_equipment" value="<?php echo $option; ?>" class="physics_lab_equipment">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="biology_lab" class="col-sm-5 col-form-label">Biology Lab</label>
                            <div class="col-sm-7">
                                <?php
                                $options = array("Yes", "No");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->biology_lab) {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input <?php if ($option == 'Yes') { ?> onclick="$('#biology_lab_equipment_div').show();$('.biology_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#biology_lab_equipment_div').hide();$('.biology_lab_equipment').prop('required', false);$('.biology_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab" value="<?php echo $option; ?>" class="">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row" id="biology_lab_equipment_div" <?php if ($input->biology_lab == 'No') { ?>style="display: none;" <?php } ?>>
                            <label for="biology_lab_equipment" class="col-sm-4 col-form-label">Bio. Lab Equipments</label>
                            <div class="col-sm-8">
                                <?php
                                $options = array("Sufficient", "Deficient");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->biology_lab_equipment  and $input->biology_lab == 'Yes') {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="biology_lab_equipment" value="<?php echo $option; ?>" class="biology_lab_equipment">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="chemistry_lab" class="col-sm-5 col-form-label">Chemistry Lab</label>
                            <div class="col-sm-7">
                                <?php
                                $options = array("Yes", "No");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->chemistry_lab) {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input required <?php if ($option == 'Yes') { ?> onclick="$('#chemistry_lab_equipment_div').show();$('.chemistry_lab_equipment').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#chemistry_lab_equipment_div').hide();$('.chemistry_lab_equipment').prop('required', false);$('.chemistry_lab_equipment').prop('checked', false);" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab" value="<?php echo $option; ?>" class="">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group row" id="chemistry_lab_equipment_div" <?php if ($input->chemistry_lab == 'No') { ?>style="display: none;" <?php } ?>>
                            <label for="chemistry_lab_equipment" class="col-sm-4 col-form-label">Chem. Lab Equipments</label>
                            <div class="col-sm-8">
                                <?php
                                $options = array("Sufficient", "Deficient");
                                foreach ($options as $option) {
                                    $checked = "";
                                    if ($option == $input->chemistry_lab_equipment  and $input->chemistry_lab == 'Yes') {
                                        $checked = "checked";
                                    }

                                ?>
                                    <span style="margin-left:5px"></span>
                                    <input <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="chemistry_lab_equipment" value="<?php echo $option; ?>" class="chemistry_lab_equipment">
                                    <span style="margin-left:3px"></span> <?php echo $option;  ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>


                    <div class="form-group row">
                        <label for="computer_lab" class="col-sm-5 col-form-label">Computer Lab</label>
                        <div class="col-sm-7">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->computer_lab) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php if ($option == 'Yes') { ?> onclick="$('#computers_div').show();$('.computers').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#computers_div').hide();$('.computers').prop('required', false);$('.computers').val('');" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="computer_lab" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="computers_div" <?php if ($input->computer_lab == 'No') { ?>style="display: none;" <?php } ?>>
                        <div class="form-group row">
                            <label for="total_working_computers" class="col-sm-9 col-form-label">Total Working Computers</label>
                            <div class="col-sm-3">
                                <input type="text" id="total_working_computers" name="total_working_computers" value="<?php echo $input->total_working_computers; ?>" class="form-control computers">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_non_working_computers" class="col-sm-9 col-form-label">Total Non Working Computers</label>
                            <div class="col-sm-3">
                                <input type="number" id="total_non_working_computers" name="total_non_working_computers" value="<?php echo $input->total_non_working_computers; ?>" class="form-control computers">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="library" class="col-sm-5 col-form-label">Library</label>
                        <div class="col-sm-7">
                            <?php
                            $options = array("Yes", "No");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->library) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php if ($option == 'Yes') { ?> onclick="$('#library_books_div').show();$('.library_books').prop('required', true);" <?php } ?> <?php if ($option == 'No') { ?> onclick="$('#library_books_div').hide();$('.library_books').prop('required', false);$('.library_books').val('');" <?php } ?> <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="library" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row" id="library_books_div" <?php if ($input->library == 'No') { ?>style="display: none;" <?php } ?>>
                        <label for="library_books" class="col-sm-8 col-form-label">Library Books Total</label>
                        <div class="col-sm-4">
                            <input type="text" id="library_books" name="library_books" value="<?php echo $input->library_books; ?>" class="form-control library_books">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group row">
                        <label for="visited_by_officers" class="col-sm-6 col-form-label">Visited By Officers</label>
                        <div class="col-sm-6">
                            <input type="text" required id="visited_by_officers" name="visited_by_officers" value="<?php echo $input->visited_by_officers; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="visited_by_officials" class="col-sm-6 col-form-label">Visited By Officials</label>
                        <div class="col-sm-6">
                            <input type="text" required id="visited_by_officials" name="visited_by_officials" value="<?php echo $input->visited_by_officials; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="visit_date" class="col-sm-4 col-form-label">Visit Date</label>
                        <div class="col-sm-8">
                            <input type="date" required id="visit_date" name="visit_date" value="<?php echo $input->visit_date; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="recommendation" class="col-sm-4 col-form-label">Recommendation</label>
                        <div class="col-sm-8">
                            <?php
                            $options = array("Recommended", "Not Recommended");
                            foreach ($options as $option) {
                                $checked = "";
                                if ($option == $input->timing) {
                                    $checked = "checked";
                                }

                            ?>
                                <span style="margin-left:5px"></span>
                                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="recommendation" value="<?php echo $option; ?>" class="">
                                <span style="margin-left:3px"></span> <?php echo $option;  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="remarks" class="col-sm-4 col-form-label">Remarks</label>
                        <div class="col-sm-8">
                            <textarea required id="remarks" name="remarks" class="form-control"><?php echo $input->remarks; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>










    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->visit_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Visit Report</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Visit Report</button>
        <?php } ?>
    </div>
</form>
</div>

<script>
    $('#visits').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("visits/add_visit"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    location.reload();
                } else {
                    $('#result_response').html(response);
                }

            }
        });
    });
</script>