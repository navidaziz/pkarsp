<h3 style="border-left: 20px solid #9FC8E8; padding-left:5px; color: #337AB7;"> <?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>
<?php
$query = "SELECT * FROM `forms_process` WHERE school_id = '" . $school_id . "'";
$form_status = $this->db->query($query)->result()[0];
?>



<div class="box" style="border-top: 0px solid #d2d6de !important;">
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-pills nav-justified steps">
                <li <?php if ($this->uri->segment(2) == 'section_b') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_b/$session_id"); ?>">
                        <?php if ($form_status->form_a_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"> <?php } ?>
                                </i>
                                SECTION B </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_c') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" title="Please Complete Section B." href="<?php echo site_url("form/section_c/$session_id"); ?>"><i class="fa fa-spinner" aria-hidden="true"></i> SECTION C</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_d') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" title="Please Complete Section C." href="<?php echo site_url("form/section_d/$session_id"); ?>"> <i class="fa fa-spinner" aria-hidden="true"></i> SECTION D</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_e') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_e/$session_id"); ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section D.">
                        <i class="fa fa-spinner" aria-hidden="true"></i> SECTION E
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_f') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_f/$session_id"); ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section E.">
                        <i class="fa fa-spinner" aria-hidden="true"></i> SECTION F
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_g') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_g/$session_id"); ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section F.">
                        <i class="fa fa-spinner" aria-hidden="true"></i> SECTION G
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_h') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_h/$session_id"); ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section F.">
                        <i class="fa fa-spinner" aria-hidden="true"></i> SECTION H
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_i') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <span class="step" data-toggle="tooltip" data-placement="top" title="Please Complete Section H.">
                        <span class="step"><i class="fa fa-spinner" aria-hidden="true"></i>SUBMIT</span>
                    </span>
                </li>

            </ul>
        </div>

    </div>

</div>