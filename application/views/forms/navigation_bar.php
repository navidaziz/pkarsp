<h3 style="border-left: 20px solid #9FC8E8; padding-left:5px; color: #337AB7;"> <?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></h3>



<div class="box" style="border-top: 0px solid #d2d6de !important;">
    <div class="row">
        <div class="col-md-12">

            <ul class="nav nav-pills nav-justified steps">
                <li <?php if ($this->uri->segment(2) == 'section_b') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php echo site_url("form/section_b/$school_id"); ?>"> <?php if ($form_status->form_b_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION B </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_c') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_b_status == 0) { ?> title="Please Complete Section B." <?php } ?> href="<?php if ($form_status->form_b_status == 1) { ?> <?php echo site_url("form/section_c/$school_id"); ?> <?php } else { ?> # <?php } ?>"><?php if ($form_status->form_c_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION C</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_d') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_c_status == 0) { ?>title="Please Complete Section C." <?php } ?> href="<?php if ($form_status->form_c_status == 1) { ?><?php echo site_url("form/section_d/$school_id"); ?> <?php } else { ?> # <?php } ?>"> <?php if ($form_status->form_d_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION D</a>

                </li>
                <li <?php if ($this->uri->segment(2) == 'section_e') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_d_status == 1) { ?> <?php echo site_url("form/section_e/$school_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_d_status == 0) { ?> title="Please Complete Section D." <?php } ?>>
                        <?php if ($form_status->form_e_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION E
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_f') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_e_status == 1) { ?> <?php echo site_url("form/section_f/$school_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_e_status == 0) { ?>title="Please Complete Section E." <?php } ?>>
                        <?php if ($form_status->form_f_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION F
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_g') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_f_status == 1) { ?> <?php echo site_url("form/section_g/$school_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_f_status == 0) { ?>title="Please Complete Section F." <?php } ?>>
                        <?php if ($form_status->form_g_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION G
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'section_h') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_g_status == 1) { ?> <?php echo site_url("form/section_h/$school_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_g_status == 0) { ?> title="Please Complete Section G." <?php } ?>>
                        <?php if ($form_status->form_h_status == 1) { ?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> SECTION H
                    </a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'submit_bank_challan') { ?> class="active" <?php  } ?> style="text-align: center;">
                    <a href="<?php if ($form_status->form_b_status == 1 and  $form_status->form_c_status == 1 and $form_status->form_d_status == 1 and $form_status->form_e_status == 1 and $form_status->form_f_status == 1 and $form_status->form_g_status == 1 and $form_status->form_h_status == 1) { ?> <?php echo site_url("form/submit_bank_challan/$school_id"); ?> <?php } else { ?> # <?php } ?>" data-toggle="tooltip" data-placement="top" <?php if ($form_status->form_h_status == 0) { ?> title="Please Complete Section H." <?php } ?>>
                        <?php if ($form_status->form_h_status == 1) { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } else { ?> <i class="fa fa-spinner" aria-hidden="true"></i> <?php } ?> Bank Challan
                    </a>
                </li>

            </ul>

        </div>

    </div>

</div>
<?php if ($this->uri->segment(2) == 'submit_bank_challan') { ?>
    <!-- <p style="text-align: center; color:green; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif;">
        please take a print out of this bank challan and deposit the fee in any bank of Khyber branch. Take computerized bank challan with STAN Number (shown at top right of the computerized bank challan) and transaction date provided by the bank. write STAN Number and transaction date in the feild show below and click on submit.
    </p>
    <p style="text-align: center; color:green; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; direction: rtl; ">
        براہ کرم اس بینک چالان کا پرنٹ آؤٹ لیں اور فیس خیبر کی کسی بھی بینک میں جمع کرائیں۔ بینک کے ذریعہ فراہم کردہ STAN نمبر (کمپیوٹرائزڈ بینک چالان کے اوپر دائیں طرف دکھایا گیا ہے) اور لین دین کی تاریخ کے ساتھ کمپیوٹرائزڈ بینک چالان لیں۔ ذیل میں دکھائے گئے فیلڈ میں STAN نمبر اور لین دین کی تاریخ لکھیں اور جمع پر کلک کریں۔
    </p> -->
<?php } else { ?>
    <p style="text-align: center; color:green; font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif; ">Next section will be opened after completing this section. اگلے سیکشن میں جانے کے لیے، پہلے اس سیکشن کو پُر کریں۔</p>
<?php } ?>