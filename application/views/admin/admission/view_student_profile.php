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
        <small> Students Admission</small>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">School Dashboard</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content ">

        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="box border blue" id="messenger">
                        <div class="box-title">
                            <h4><i class="fa fa-book" aria-hidden="true"></i> <?php echo $title; ?></h4>
                            <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
                        </div>
                        <div class="box-body">

                            <div class="table-re sponsive">
                                <div class="row" style="background-color: white; padding: 5px;">
                                    <div class="col-md-3">
                                        <div class="table-responsive">
                                            <h3 class="title"><?php echo $students[0]->student_name; ?>
                                            </h3>
                                            <h4 class="title">S/O <?php echo $students[0]->student_father_name; ?>
                                            </h4>
                                            <span style="font-size:20px !important;">

                                                <h5 class="pull-left">
                                                    <?php echo $this->lang->line('student_admission_no'); ?>: <?php echo $student->student_admission_no; ?>
                                                </h5>

                                                <h5 class="pull-right">
                                                    Status: <?php if ($students[0]->status == 1) { ?> Admitted <?php  } ?>
                                                    <?php if ($students[0]->status == 2) { ?> Struck Off <?php  } ?>
                                                    <?php if ($students[0]->status == 3) { ?> SLC <?php  } ?>
                                                    <?php if ($students[0]->status == 0) { ?> Deleted <?php  } ?>
                                                </h5>
                                            </span>
                                            <?php foreach ($students as $student) : ?>


                                                <table class="table">
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $this->lang->line('student_class_no'); ?></td>
                                                        <td style="text-align: center;"><?php echo $this->lang->line('Class_title'); ?></td>
                                                        <td style="text-align: center;"><?php echo $this->lang->line('section_title'); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $student->student_class_no; ?></td>
                                                        <td style="text-align: center;"><?php echo $student->Class_title; ?></td>
                                                        <td style="text-align: center;"><?php echo $student->section_title; ?></td>
                                                    </tr>
                                                </table>

                                                <table class="" style="width: 100%;">
                                                    <thead>
                                                    </thead>
                                                    <tbody>



                                                        <tr>
                                                            <td>Date Of Birth</td>
                                                            <td><?php echo $student->student_data_of_birth; ?>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Date Of Admission</td>
                                                            <td><?php echo $student->admission_date; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Father Mobile No.</td>
                                                            <td><?php echo $student->father_mobile_number; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Father CNIC</td>
                                                            <td><?php echo $student->father_nic; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Father Occupation</td>
                                                            <td><?php echo $student->guardian_occupation; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Previous School</td>
                                                            <td><?php echo $student->private_public_school; ?>-<?php echo $student->school_name; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nationality</td>
                                                            <td><?php echo $student->nationality; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Religion</td>
                                                            <td><?php echo $student->religion; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Orphan</td>
                                                            <td><?php echo $student->orphan; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"><?php echo $this->lang->line('student_address'); ?>: <?php echo $student->student_address; ?></td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <h3 class="title">History</h3>
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
                                                                <?php $query = "SELECT *, user_title FROM student_leaving_certificates as slc, users  as u
                                                    WHERE slc.created_by = u.user_id
                                                    AND slc.student_id = '" . $students[0]->student_id . "'
                                                    AND date(slc.created_date) = '" . date("Y-m-d", strtotime($student_history->create_date)) . "'";
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

                                    <div class="col-md-6">
                                        <h5 class="pull-right">
                                            <?php
                                            $student = $students[0];
                                            if ($student->status == 1) { ?>
                                                <button onclick="struck_off_model('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-warning btn-sm" aria-hidden="true">Struck Off</Button>
                                                <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                                            <?php  } ?>
                                            <?php if ($student->status == 2) { ?>
                                                <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                                                <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                                            <?php  } ?>
                                            <?php if ($student->status == 3) { ?>
                                                <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                                            <?php  } ?>
                                            <?php if ($student->status == 0) { ?> <?php  } ?>
                                            <a class="btn btn-primary btn-sm" target="new" href="<?php echo site_url(ADMIN_DIR . "admission/birth_certificate/" . $student->student_id); ?>"><i class="fa fa-print" aria-hidden="true"></i> Birth Certificate</a>
                                            <button onclick="update_profile()" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit Profile</button>

                                        </h5>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
    </section>
</div>


<div id="update_profile" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="">Student Profile Update</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">


                <form action="<?php echo site_url(ADMIN_DIR . "admission/update_profile/" . $students[0]->student_id) ?>" method="post" style="text-align: center;">
                    <table class="table">
                        <tr>
                            <th>Class No: </th>
                            <td><input type="text" name="student_class_no" value="<?php echo $students[0]->student_class_no; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Admission No: </th>
                            <td><input type="text" name="student_admission_no" value="<?php echo $students[0]->student_admission_no; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Student Name: </th>
                            <td><input type="text" name="student_name" value="<?php echo $students[0]->student_name; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Father Name: </th>
                            <td><input type="text" name="student_father_name" value="<?php echo $students[0]->student_father_name; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Date Of Birth: </th>
                            <td><input type="date" name="student_data_of_birth" value="<?php echo $students[0]->student_data_of_birth; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Form B No:</th>
                            <td><input type="text" name="form_b" value="<?php echo $students[0]->form_b; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Admission Date:</th>
                            <td><input type="date" name="admission_date" value="<?php echo $students[0]->admission_date; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><input type="text" name="student_address" value="<?php echo $students[0]->student_address; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Father CNIC No:</th>
                            <td><input type="text" name="father_nic" value="<?php echo $students[0]->father_nic; ?>" /></td>
                        </tr>
                        <tr>
                            <th>CNIC Issue Date:</th>
                            <td><input type="date" name="nic_issue_date" value="<?php echo $students[0]->nic_issue_date; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Contact No:</th>
                            <td><input type="text" name="father_mobile_number" value="<?php echo $students[0]->father_mobile_number; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Father Occupation:</th>
                            <td><input type="text" name="guardian_occupation" value="<?php echo $students[0]->guardian_occupation; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Religion:</th>
                            <td><input type="text" name="religion" value="<?php echo $students[0]->religion; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Nationality:</th>
                            <td><input type="text" name="nationality" value="<?php echo $students[0]->nationality; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Private / Public School:</th>

                            <td>
                                <input type="radio" name="private_public_school" value="G" <?php if ($students[0]->private_public_school == 'G') { ?>checked<?php } ?> />
                                Government
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="private_public_school" value="P" <?php if ($students[0]->private_public_school == 'P') { ?>checked<?php } ?> />
                                Private
                            </td>

                        </tr>
                        <tr>
                            <th>School Name:</th>
                            <td><input type="text" name="school_name" value="<?php echo $students[0]->school_name; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Orphan: </th>
                            <td>

                                <input type="radio" name="orphan" value="Yes" <?php if ($students[0]->orphan == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="orphan" value="No" <?php if ($students[0]->orphan == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>


                        <tr>
                            <th>Vaccinated: </th>
                            <td>
                                <input type="radio" name="vaccinated" value="Yes" <?php if ($students[0]->vaccinated == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="vaccinated" value="No" <?php if ($students[0]->vaccinated == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>

                        <tr>
                            <th>Is Disable: </th>
                            <td>
                                <input type="radio" name="is_disable" value="Yes" <?php if ($students[0]->is_disable == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="is_disable" value="No" <?php if ($students[0]->is_disable == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>

                        <tr>
                            <th>Ehsaas Program: </th>
                            <td>
                                <input type="radio" name="ehsaas" value="Yes" <?php if ($students[0]->ehsaas == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="ehsaas" value="No" <?php if ($students[0]->ehsaas == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>




                        <td colspan="2">
                            <input type="submit" class="btn btn-success btn-sm" value="Update Profile" />
                            </tr>
                    </table>




                </form>

            </div>

        </div>
    </div>
</div>

<script>
    function update_profile() {
        $('#update_profile').modal('show');
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
                    <table class="" style="width: 100%;">

                        <tr>
                            <td>Admission No:</td>
                            <td><input type="text" required name="admission_no" id="adNo" value="" /></td>
                        </tr>
                        <tr>
                            <td>Admission Date:</td>
                            <td><input type="date" required name="admission_date" id="add_date" value="" /></td>
                        </tr>
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
                            <td>Withdrawal Reason:</td>
                            <td>
                                <textarea style="width: 100%;" name="withdraw_reason"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Withdraw" /></td>
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


<div id="struck_off" class="modal" tabindex="-1" role="dialog">
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
</div>
<script>
    function struck_off_model(student_id, name, father_name, add_no) {
        $('#sof_model_title').html("Student Stuck Off Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        $('#student_ID').val(student_id);
        $('#struck_off_body').html(body);
        $('#struck_off').modal('show')
    }
</script>


<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li> <i class="fa fa-home"></i> Home </li>
                <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
                <li> <?php echo $students[0]->student_name . ""; ?> Profile</li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="col-md-6">
                <div class="clearfix">
                    <h3 class="content-title pull-left"> <?php echo $students[0]->student_name . ""; ?> Profile</li>
                    </h3>
                </div>
                <div class="description" id="message"></div>
            </div>


        </div>
    </div>
</div>


<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12" style="background-color: white; padding: 5px;">

    </div>
</div>