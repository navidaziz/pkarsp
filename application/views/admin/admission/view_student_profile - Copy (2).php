<?php

$class_id = $students[0]->class_id;
$section_id = $students[0]->section_id;

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2 style="display:inline;">
            <?php echo ucwords(strtolower($school->schoolName)); ?>
        </h2><br />
        <small> Students Profile Detail</small>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
            <li><a href="<?php echo site_url("admin/admission"); ?>">Admission</a></li>
            <li><a href="<?php echo site_url("admin/admission/view_students/$class_id"); ?>"><?php echo $student->class_title; ?> Students List</a></li>
            <li><a href="#">Student Profile</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content ">

        <div class="box box-primary box-solid">
            <div class="box-body">
                <?php $student = $students[0]; ?>
                <div class="row">
                    <div class="col-md-3">
                        <div style="border:1px solid #9FC8E8; border-radius: 10px;   padding: 10px; background-color: white;">
                            <h4>Student Profile Detail</h4>
                            <h3 class="title"><?php echo ucwords(strtolower($students[0]->student_name)); ?>
                            </h3>

                            <h4 class="title">
                                <?php if ($students[0]->gender == 'Male') {
                                    echo "S/O ";
                                } else {
                                    echo "D/O ";
                                }
                                echo ucwords(strtolower($students[0]->student_father_name)); ?>
                            </h4>
                            <h4>
                                Admission No:
                                <?php echo $students[0]->student_admission_no; ?>
                            </h4>
                            <h4>
                                PSRA Student-ID:
                                <?php echo $students[0]->psra_student_id; ?>
                            </h4>
                            <h5 style="font-weight: bold;">
                                Gender:
                                <?php echo $students[0]->gender; ?>
                            </h5>
                            <h5 style="font-weight: bold;">
                                Domicile:
                                <?php
                                $query = "SELECT districtTitle FROM district WHERE districtId = '" . $students[0]->domicile_id . "'";
                                echo $this->db->query($query)->result()[0]->districtTitle; ?>
                            </h5>
                            <hr />




                            <table class="table">
                                <tr>
                                    <th style="text-align: center;">Class</th>
                                    <th style="text-align: center;">Session</th>
                                    <th style="text-align: center;">Status</th>
                                </tr>
                                <tr>
                                    <td style="text-align: center;"><?php echo $student->Class_title; ?></td>
                                    <td style="text-align: center;"><?php $query = "SELECT `sessionYearTitle` FROM `session_year` 
                                              WHERE sessionYearId='" . $student->session_id . "'";
                                                                    echo $this->db->query($query)->result()[0]->sessionYearTitle; ?> </td>
                                    <td style="text-align: center;"><?php if ($students[0]->status == 1) { ?> Admitted <?php  } ?>
                                        <?php if ($students[0]->status == 2) { ?> Struck Off <?php  } ?>
                                        <?php if ($students[0]->status == 3) { ?> SLC <?php  } ?>
                                        <?php if ($students[0]->status == 0) { ?> <span style="color:red"> <i class="fa fa-trash" aria-hidden="true"></i> Deleted <?php  } ?> </span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <h5 style="font-weight: bold;">

                                            <?php
                                            $query = "SELECT `schoolId`,`registrationNumber`,`schoolName` 
                                                FROM `schools` 
                                                WHERE schoolId='" . $students[0]->school_id . "'";
                                            echo "School: " . $this->db->query($query)->result()[0]->schoolName; ?><br />
                                            <?php echo "Institute ID: " . $this->db->query($query)->result()[0]->schoolId; ?><br />
                                            <?php echo "Registration ID: " . $this->db->query($query)->result()[0]->registrationNumber; ?><br />

                                        </h5>
                                    </td>
                                </tr>
                            </table>







                        </div>
                    </div>
                    <?php if (1 == 1) {  ?>
                        <div class="col-md-3">



                            <table class="table table-bordered" style="font-size: 14px;">
                                <thead>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th style="text-align: center;" colspan="2">Other Detail</td>
                                    </tr>

                                    <tr>
                                        <th>Date Of Birth</th>
                                        <td><?php echo date("d M, Y", strtotime($student->student_data_of_birth)); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Date Of Admission</th>
                                        <td><?php echo date("d M, Y", strtotime($student->admission_date)); ?>
                                    </tr>
                                    <tr>
                                        <th>Father Mobile No.</th>
                                        <td><?php echo $student->father_mobile_number; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Father CNIC</th>
                                        <td><?php echo $student->father_nic; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Form B No</th>
                                        <td><?php echo $student->form_b; ?></td>
                                    </tr>

                                    <tr>
                                        <th>Nationality</th>
                                        <td>
                                            <?php if ($student->nationality == 'Pakistani') { ?>
                                                <?php echo $student->nationality; ?></td>
                                    <?php } else { ?>
                                        Foreigner: <?php echo $student->nationality; ?></td>
                                    <?php } ?>
                                    </tr>
                                    <tr>
                                        <th>Religion</th>
                                        <td><?php echo $student->religion; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Orphan</th>
                                        <td><?php echo $student->orphan; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Disable</th>
                                        <td><?php echo $student->is_disable; ?></td>
                                    </tr>

                                    <tr>
                                        <th colspan="2">
                                            <?php echo $this->lang->line('student_address'); ?>: <?php echo $student->student_address; ?></th>
                                    </tr>


                                </tbody>
                            </table>

                        </div>


                        <div class="col-md-4">
                            <div style="border:1px solid #9FC8E8; min-height:400px; border-radius: 10px;   padding: 10px; background-color: white;">
                                <h4>Student History </h4>
                                <?php $query = "SELECT *,  c.class_title, se.sessionYearTitle as session_title 
                                            FROM `student_history` as sh,  classes as c, `session_year` as se 
                                                WHERE 
                                                sh.class_id = c.class_id
                                                AND sh.session_id = se.sessionYearId
                                                AND sh.student_id = '" . $students[0]->student_id . "'";
                                $student_history_list = $this->db->query($query)->result();
                                foreach ($student_history_list as $student_history) { ?>
                                    <div style="margin-bottom: 5px;">
                                        <?php if ($student_history->history_type == 'Promoted') { ?>
                                            <span class="pull-left"><?php echo $student_history->history_type; ?> </span>
                                            <span class="pull-right"><?php echo date("d M, Y", strtotime($student_history->create_date)); ?></span> <br />
                                            <small style="margin-left: 5px; margin-right: 5px;"> Promoted From Class <?php echo $student_history->class_title; ?> To Class
                                                <?php $query = "SELECT * FROM classes WHERE class_id > $student_history->class_id LIMIT 1";
                                                echo $this->db->query($query)->result()[0]->Class_title; ?>.
                                            </small>
                                        <?php } else { ?>
                                            <?php if ($student_history->history_type == 'Struck Off') { ?>
                                                <span class="pull-left"><?php echo $student_history->history_type; ?> </span>
                                                <span class="pull-right"><?php echo date("d M, Y", strtotime($student_history->create_date)); ?></span> <br />
                                                <small style="margin-left: 5px; margin-right: 5px;">
                                                    Struck Off Due to <?php echo $student_history->remarks; ?>
                                                </small>
                                            <?php } else { ?>
                                                <?php if ($student_history->history_type == 'Withdraw') { ?>
                                                    <span class="pull-left"><?php echo $student_history->history_type; ?> </span>
                                                    <span class="pull-right"><?php echo date("d M, Y", strtotime($student_history->create_date)); ?></span> <br />
                                                    <small style="margin-left: 5px; margin-right: 5px;">
                                                        <?php $query = "SELECT *, userTitle FROM student_leaving_certificates as slc, users  as u
                                                    WHERE slc.student_id = '" . $students[0]->student_id . "'
                                                    AND date(slc.created_date) <= '" . date("Y-m-d", strtotime($student_history->create_date)) . "'";
                                                        $slc = $this->db->query($query)->result()[0];
                                                        ?>
                                                        Got School leaving Certificate.<br />
                                                        School Leaving Date: <?php echo date("d M, Y", strtotime($slc->school_leaving_date)); ?> <br />
                                                        SLC issue Date: <?php echo date("d M, Y", strtotime($slc->slc_issue_date)); ?> <br />
                                                        File Ref. No: <?php echo $slc->slc_file_no; ?> Certificate Ref. No: <?php echo $slc->slc_certificate_no; ?><br />
                                                        School leaving Reason: <i><?php echo $slc->leaving_reason; ?></i><br />
                                                        User: <?php echo $slc->user_title; ?>
                                                    </small>
                                                <?php } else { ?>
                                                    <span class="pull-left"><?php echo $student_history->history_type; ?></span>
                                                    <span class="pull-right"><?php echo date("d M, Y", strtotime($student_history->create_date)); ?></span> <br />
                                                    <small><?php echo $student_history->remarks; ?></small>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php  } ?>
                            </div>
                        </div>

                        <style>
                            .profile_buttons>button,
                            .profile_buttons>a {
                                display: block;
                                width: 100%;
                            }
                        </style>

                        <div class="col-md-2">
                            <h5 class="profile_buttons">
                                <?php
                                //$student = $students[0];

                                if ($students[0]->status != 0) {
                                    if ($student->status == 1) { ?>
                                        <!-- <button onclick="struck_off_model('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-warning btn-sm" aria-hidden="true">Struck Off</Button>-->
                                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger " aria-hidden="true">Admission Withdraw</button>
                                        <br />
                                    <?php  } ?>
                                    <?php if ($student->status == 2) { ?>

                                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger " aria-hidden="true">Admission Withdraw</button>
                                        <br />
                                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success " aria-hidden="true"> <i class="fa fa-undo" aria-hidden="true"></i> Re-Admit</button>
                                        <br />
                                    <?php  } ?>
                                    <?php if ($student->status == 3) {

                                        $query = "SELECT `slc_id` FROM student_leaving_certificates WHERE student_id = '" . $student->student_id . "' 
                                        ORDER  BY `student_leaving_certificates`.`slc_id` DESC LIMIT 1";
                                        $slc_id = $this->db->query($query)->result()[0]->slc_id;

                                    ?>

                                        <a class="btn btn-danger " target="new" href="<?php echo site_url(ADMIN_DIR . "admission/slc_certificate/" . $slc_id); ?>"><i class="fa fa-print" aria-hidden="true"></i> School Leaving Certificate</a>
                                        <br />

                                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-primary " aria-hidden="true"> <i class="fa fa-undo" aria-hidden="true"></i> Re-Admit</button>
                                        <br />

                                    <?php  } ?>
                                    <?php if ($student->status == 0) { ?> <?php  } ?>
                                    <a class="btn btn-primary " target="new" href="<?php echo site_url(ADMIN_DIR . "admission/birth_certificate/" . $student->student_id); ?>"><i class="fa fa-print" aria-hidden="true"></i> Birth Certificate</a>
                                    <br />
                                    <button onclick="update_profile('<?php echo $student->student_id; ?>')" class="btn btn-success"><i class="fa fa-edit" aria-hidden="true"></i> Edit Profile</button>
                                    <br />
                                    <button onclick="change_class_form('<?php echo $student->student_id; ?>')" class="btn btn-warning"><i class="fa fa-edit" aria-hidden="true"></i> Change Class</button>
                                    <br />
                                    <a href="<?php echo site_url(ADMIN_DIR . "admission/delete_student_profile/$student->student_id"); ?>" onclick="return confirm('Are you sure? You want to remove student profile.')" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete Student Profile</a>
                                    <br />
                                <?php } else { ?>
                                    <br />
                                    <a href="<?php echo site_url(ADMIN_DIR . "admission/restore_student_profile/$student->student_id"); ?>" onclick="return confirm('Are you sure? You want to restore student profile.')" class="btn btn-danger"><i class="fa fa-undo" aria-hidden="true"></i> Restore Student Profile</a>
                                    <br />
                                <?php   }  ?>
                            </h5>
                        </div>

                    <?php } else { ?>
                        <div class="col-md-9" style="text-align: center;">
                            <h4 style="margin-top: 20px; color:red"> <i class="fa fa-info-circle" aria-hidden="true"></i> You are not allowed to access student profile information.</h4>

                        </div>
                    <?php } ?>

                </div>
    </section>
</div>


<div id="general_model" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="general_model_body">


        </div>
    </div>
</div>

<script>
    function update_profile(student_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "admission/update_student_profile"); ?>",
            data: {
                student_id: student_id
            }
        }).done(function(data) {

            $('#general_model_body').html(data);
        });

        $('#general_model').modal('show');
    }

    function change_class_form(student_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "admission/change_class_form"); ?>",
            data: {
                student_id: student_id
            }
        }).done(function(data) {

            $('#general_model_body').html(data);
        });

        $('#general_model').modal('show');
    }
</script>



<div id="re_admit" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="readmit_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="re_admit_body">Please Wait .....</h4>
                <p style="text-align: center;">


                <form action="<?php echo site_url(ADMIN_DIR . "admission/re_admit_again") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="studentID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    Admission No: <input type="text" name="admission_no" id="admission_no" value="" />
                    <br />
                    Re-Admission Detail:
                    <input required type="text" class="form-control" style="margin: 10px;" name="re_admit_again_reason" />
                    <input type="submit" class="btn btn-success btn-sm" value="Admit Again" />
                </form>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
    function re_admit(student_id, name, father_name, add_no) {
        $('#readmit_model_title').html("Student Re Admit Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        $('#admission_no').val(add_no);

        $('#studentID').val(student_id);
        $('#re_admit_body').html(body);
        $('#re_admit').modal('show');
    }
</script>

<div id="withdrawal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="withdrawal_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="withdrawal_admit_body">Please Wait .....</h4>
                <p style="text-align: center;">
                <form action="<?php echo site_url(ADMIN_DIR . "admission/withdraw_student") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="stID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    <table class="table table-bordered" style="width: 100%;">

                        <tr>
                            <td>Schoool Leaving Date:</td>
                            <td> <input type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>SLC Issue Date:</td>
                            <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
                        </tr>
                        <tr>
                            <td>SLC File No:</td>
                            <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
                        </tr>
                        <tr>
                            <td>SLC Certificate No:</td>
                            <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
                        </tr>
                        <tr>
                            <td>Character and Conduct</td>
                            <?php
                            $scales = array("Excellent", "Very Good", "Good", "Fair", "Poor")
                            ?>
                            <td>
                                <?php foreach ($scales as $scale) { ?>
                                    <input type="radio" name="character_and_conduct" value="<?php echo $scale; ?>" required="">
                                    <?php echo $scale; ?>
                                    <span style="margin-left: 10px;"></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Academic Record</td>
                            <td>
                                <?php foreach ($scales as $scale) { ?>
                                    <input type="radio" name="academic_record" value="<?php echo $scale; ?>" required="">
                                    <?php echo $scale; ?>
                                    <span style="margin-left: 10px;"></span>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>

                            <td colspan="2">
                                <?php $query = "SELECT class_title FROM classes WHERE class_id ='" . $students[0]->class_id . "'";
                                $class_name = $this->db->query($query)->result()[0]->class_title;
                                ?>
                                Student is currently in class - <strong><?php echo $class_name; ?>.
                                    <input type="hidden" name="current_class" value="<?php echo $class_name; ?>" /> </strong>
                                <?php $query = "SELECT class_id, class_title FROM classes WHERE class_id >= '" . $students[0]->class_id . "' LIMIT 2";
                                $classes = $this->db->query($query)->result();
                                ?>

                                Promote to class
                                <select name="promoted_to_class">
                                    <?php foreach ($classes as $class) { ?>
                                        <option <?php if ($class->class_id == $students[0]->class_id) { ?> selected <?php } ?> value="<?php echo $class->class_title; ?>"><?php echo $class->class_title; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Withdrawal Reason:</td>
                            <td>
                                <input style="width: 100%;" type="text" required name="withdraw_reason" id="withdraw_reason" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Withdraw Admission" /></td>
                        </tr>
                    </table>
                </form>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
    function withdraw(student_id, name, father_name, add_no, admission_date) {
        $('#withdrawal_model_title').html("Student Withdraw Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + '<br /> Admission Date: ' + admission_date + '<br /> ';
        $('#adNo').val(add_no);
        $('#add_date').val(admission_date);


        $('#stID').val(student_id);
        $('#withdrawal_admit_body').html(body);
        $('#withdrawal').modal('show');
    }
</script>


<!-- <div id="struck_off" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="sof_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="struck_off_body">Please Wait .....</h4>
                <p style="text-align: center;">Stuck Off Reason:
                <form action="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/struck_off_student") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="student_ID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    <input required type="text" class="form-control" style="margin: 10px;" name="struck_off_reason" />
                    <input type="submit" class="btn btn-danger btn-sm" value="Struck Off" />
                </form>
                </p>
            </div>

        </div>
    </div>
</div> -->
<script>
    // function struck_off_model(student_id, name, father_name, add_no) {
    //     $('#sof_model_title').html("Student Stuck Off Form");
    //     var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
    //     $('#student_ID').val(student_id);
    //     $('#struck_off_body').html(body);
    //     $('#struck_off').modal('show')
    // }
</script>