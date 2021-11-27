<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                <li> <i class="fa fa-home"></i> Home </li>
                <li> <a href="<?php echo site_url("student/class_and_section/"); ?>"> Classes and Sections</a> </li>
                <li> <a href="<?php echo site_url("student/students_list/" . $this->session->userdata('class_id') . "/" . $this->session->userdata('section_id')); ?>"> Students List</a> </li>
                <li> <a href="<?php echo site_url("student/view_student/" . $this->session->userdata('student_id')); ?>"> Detail</a> </li>

                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->



        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>

            </div>
            <div class="box-body">

                <?php
                $edit_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart("student/update_data/$student->student_id", $edit_form_attr);
                ?>
                <?php echo form_hidden("student_id", $student->student_id); ?>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_class_no'), "student_class_no", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "student_class_no",
                            "id"            =>  "student_class_no",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('student_class_no'),
                            "value"         =>  set_value("student_class_no", $student->student_class_no),
                            "placeholder"   =>  $this->lang->line('student_class_no'),
                            "readonly" => "readonly"
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("student_class_no", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_name'), "student_name", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "student_name",
                            "id"            =>  "student_name",
                            "class"         =>  "form-control",
                            "style"         =>  "", "required"      => "required", "title"         =>  $this->lang->line('student_name'),
                            "value"         =>  set_value("student_name", $student->student_name),
                            "placeholder"   =>  $this->lang->line('student_name')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("student_name", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_father_name'), "student_father_name", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "student_father_name",
                            "id"            =>  "student_father_name",
                            "class"         =>  "form-control",
                            "style"         =>  "", "title"         =>  $this->lang->line('student_father_name'),
                            "value"         =>  set_value("student_father_name", $student->student_father_name),
                            "placeholder"   =>  $this->lang->line('student_father_name')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("student_father_name", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_data_of_birth'), "student_data_of_birth", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $date = array(
                            "type"          =>  "date",
                            "name"          =>  "student_data_of_birth",
                            "id"            =>  "student_data_of_birth",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('student_data_of_birth'),
                            "value"         =>  set_value("student_data_of_birth", $student->student_data_of_birth),
                            "placeholder"   =>  $this->lang->line('student_data_of_birth')
                        );
                        echo  form_input($date);
                        ?>
                        <?php echo form_error("student_data_of_birth", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_address'), "student_address", $label);
                    ?>

                    <div class="col-md-10">
                        <?php

                        $textarea = array(
                            "name"          =>  "student_address",
                            "id"            =>  "student_address",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('student_address'),
                            "rows"          =>  "",
                            "cols"          =>  "",
                            "value"         => set_value("student_address", $student->student_address),
                            "placeholder"   =>  $this->lang->line('student_address')
                        );
                        echo form_textarea($textarea);
                        ?>
                        <?php echo form_error("student_address", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>

                </div>

                <div class="form-group">

                    <?php
                    $label = array(
                        "class" => "col-md-2 control-label",
                        "style" => "",
                    );
                    echo form_label($this->lang->line('student_admission_no'), "student_admission_no", $label);      ?>

                    <div class="col-md-10">
                        <?php

                        $text = array(
                            "type"          =>  "text",
                            "name"          =>  "student_admission_no",
                            "id"            =>  "student_admission_no",
                            "class"         =>  "form-control",
                            "style"         =>  "",
                            "title"         =>  $this->lang->line('student_admission_no'),
                            "value"         =>  set_value("student_admission_no", $student->student_admission_no),
                            "placeholder"   =>  $this->lang->line('student_admission_no')
                        );
                        echo  form_input($text);
                        ?>
                        <?php echo form_error("student_admission_no", "<p class=\"text-danger\">", "</p>"); ?>
                    </div>



                </div>

                <!--<div class="form-group">
            
                <?php
                $label = array(
                    "class" => "col-md-2 control-label",
                    "style" => "",
                );
                echo form_label($this->lang->line('student_image') . "<br />" . file_type(base_url("assets/uploads/" . $student->student_image)), "student_image", $label);     ?>

                <div class="col-md-10">
                <?php

                $file = array(
                    "type"          =>  "file",
                    "name"          =>  "student_image",
                    "id"            =>  "student_image",
                    "class"         =>  "form-control",
                    "style"         =>  "", "title"         =>  $this->lang->line('student_image'),
                    "value"         =>  set_value("student_image", $student->student_image),
                    "placeholder"   =>  $this->lang->line('student_image')
                );
                echo  form_input($file);
                ?>
                    <!--<?php echo file_type(base_url("assets/uploads/$student->student_image")); ?>-->

                <?php echo form_error("student_image", "<p class=\"text-danger\">", "</p>"); ?>
            </div>



        </div>-->

        <input type="hidden" name="class_id" value="<?php echo $student->class_id ?>" />
        <input type="hidden" name="section_id" value="<?php echo $student->section_id ?>" />






        <div class="col-md-offset-2 col-md-10">
            <?php
            $submit = array(
                "type"  =>  "submit",
                "name"  =>  "submit",
                "value" =>  $this->lang->line('Update'),
                "class" =>  "btn btn-primary",
                "style" =>  ""
            );
            echo form_submit($submit);
            ?>



            <?php
            $reset = array(
                "type"  =>  "reset",
                "name"  =>  "reset",
                "value" =>  $this->lang->line('Reset'),
                "class" =>  "btn btn-default",
                "style" =>  ""
            );
            echo form_reset($reset);
            ?>
        </div>
        <div style="clear:both;"></div>

        <?php echo form_close(); ?>

    </div>

</div>
</div>
<!-- /MESSENGER -->
</div>