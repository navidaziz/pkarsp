<h3 style="border-left: 20px solid #9FC8E8; padding-left:5px; color: #337AB7;"> <?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>


<div class="box" style="border-top: 0px solid #d2d6de !important;">
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-pills nav-justified steps">
                <li <?php if ($this->uri->segment(2) == 'section_b') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_b/$session_id"); ?>"> <?php if ($form_status->form_b_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION B </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_c') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" title="Please Complete Section B." href="<?php if ($form_status->form_b_status == 1) { ?> <?php echo site_url("form/section_c/$session_id"); ?> <?php } else { ?> # <?php } ?>"><?php if ($form_status->form_c_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION C</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_d') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" title="Please Complete Section C." href="<?php if ($form_status->form_c_status == 1) { ?><?php echo site_url("form/section_d/$session_id"); ?> <?php } else { ?> # <?php } ?>"> <?php if ($form_status->form_d_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION D</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_e') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_c_status == 1) { ?> <?php echo site_url("form/section_e/$session_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section D.">
                        <?php if ($form_status->form_e_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION E
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_f') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_d_status == 1) { ?> <?php echo site_url("form/section_f/$session_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section E.">
                        <?php if ($form_status->form_f_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION F
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_g') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_f_status == 1) { ?> <?php echo site_url("form/section_g/$session_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section F.">
                        <?php if ($form_status->form_g_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION G
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_h') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_g_status == 1) { ?> <?php echo site_url("form/section_c/$session_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section F.">
                        <?php if ($form_status->form_h_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION H
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'submit_bank_challan') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_b_status == 1 and  $form_status->form_c_status == 1 and $form_status->form_d_status == 1 and $form_status->form_e_status == 1 and $form_status->form_f_status == 1 and $form_status->form_g_status == 1 and $form_status->form_h_status == 1) { ?> <?php echo site_url("form/submit_bank_challan/$session_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" title="Please Complete Section H.">
                        <?php if ($form_status->form_h_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> Bank Challan
                    </a>
                </li>

            </ul>
        </div>

    </div>

</div>