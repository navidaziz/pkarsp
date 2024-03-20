<?php
$query = "SELECT isfined FROM schools WHERE schoolId = '" . $school->schools_id . "'";
$isfined = $this->db->query($query)->row()->isfined;
if ($isfined == 1) { ?>
    <div>
        <h4>
            <div class="alert alert-warning">
                <i>
                    We regret to inform you that your online application was not completed due to the school portal being locked.
                    The PSRA operation wing has closed your school portal as a result of a fine that has been imposed on your school.
                    Please check your message inbox, contact by phone or visit the PSRA office for further details regarding this matter.
                    <br />
                    Once you receive clearance from the operation wing, you may proceed with completing the online form submission
                </i>
                <br />
                <br />
                <strong>
                    Contact Details:
                    <a target="new" href="tel:+920919216194">091-9216194</a>,
                    <a target="new" href="tel:+920919216195">091-9216195</a>,
                    <a target="new" href="tel:+920919216196">091-9216196</a>
                </strong>
                <br>
            </div>
        </h4>
    </div>
<?php } else { ?>

    <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">


        <h4>Submit Deposited Challan STAN No. and Transaction Date for session <?php echo $session_detail->sessionYearTitle; ?></h4>
        <hr />
        <div style="margin: 10px;">
            <small>
                <i style="color: red;">"STAN can be found on the upper right corner of bank generated receipt"

                </i>
            </small>
            <img width="70%" src="<?php echo site_url("assets/stan.jpeg"); ?>" />
        </div>
        <script>
            function validateForm() {
                const challan_no = $('#challan_no').val();
                const regex = /^[0-9]*$/;

                if (challan_no.length < 6) {
                    event.preventDefault();
                    alert('There is an error in the stan number. The stan number contains six digits');
                    false;
                }
                if (!regex.test(challan_no)) {
                    event.preventDefault();
                    alert('The stan number contains digits only');
                    false;
                }
            }
        </script>
        <div>
            For 2018, 2019 manual bank recipt enter deposit date and 6 times zero as STAN No.
        </div>
        <form onsubmit="return validateForm();" action="<?php echo site_url("form/add_bank_challan"); ?>" method="post">
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
            <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
            <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />
            <?php if ($school->reg_type_id == 1 and $school->school_type_id == 1) { ?>
                <input type="hidden" name="challan_for" value="Registration" />
                <input type="hidden" name="reg_type_id" value="1" />
            <?php } ?>
            <?php if ($school->reg_type_id == 2 and $school->school_type_id == 1) { ?>
                <input type="hidden" name="challan_for" value="Renewal" />
                <input type="hidden" name="reg_type_id" value="2" />
            <?php } ?>
            <?php if ($school->reg_type_id == 3 and $school->school_type_id == 1) { ?>
                <input type="hidden" name="challan_for" value="Upgradation" />
                <input type="hidden" name="reg_type_id" value="3" />
            <?php } ?>
            <?php if ($school->reg_type_id == 4 and $school->school_type_id == 1) { ?>
                <input type="hidden" name="challan_for" value="Renewal+Upgradation" />
                <input type="hidden" name="reg_type_id" value="4" />
            <?php } ?>
            <?php if ($school->reg_type_id == 1 and $school->school_type_id == 7) { ?>
                <input type="hidden" name="challan_for" value="Registration" />
                <input type="hidden" name="reg_type_id" value="1" />
            <?php } ?>
            <?php if ($school->reg_type_id == 2 and $school->school_type_id == 7) { ?>
                <input type="hidden" name="challan_for" value="Renewal" />
                <input type="hidden" name="reg_type_id" value="2" />
            <?php } ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>Transaction Date</td>
                        <td>STAN No.</td>
                    </tr>
                    <tr>
                        <td><input required name="challan_date" type="date" class="form-control" min="2018-01-01" max="<?php echo date('Y-m-d'); ?>" />
                        </td>
                        <td><input required maxlength="6" id="challan_no" name="challan_no" type="text" autocomplete="off" class="form-control" />
                        </td>

                        <td><input type="submit" class="btn btn-success" name="submit" value="Add Challan" />
                        </td>
                    </tr>
        </form>
        <tr>
            <th>Transaction Date</th>
            <th>STAN No.</th>
            <th>Remove</th>
        </tr>

        <?php
        $query = "SELECT * FROM bank_transaction where school_id = '" . $school_id . "'";
        $session_bank_challans = $this->db->query($query)->result();
        if ($session_bank_challans) {
            foreach ($session_bank_challans as $session_bank_challan) { ?>
                <tr>
                    <th><?php
                        if ($session_bank_challan->bt_date) {
                            echo date("d M, Y", strtotime($session_bank_challan->bt_date));
                        }
                        ?></th>
                    <th><?php echo $session_bank_challan->bt_no; ?></th>
                    <th>

                        <a onclick="return confirm('Are you sure you want to remove?');" href="<?php echo site_url('form/remove_bank_challan/' . $school_id . '/' . $session_bank_challan->bt_id); ?>"><small>
                                <i>Remove</i>
                            </small></a>

                    </th>
                </tr>

            <?php } ?>

        <?php
            $finished = 1;
        } else {
            $finished = 0;
        ?>
            <tr>
                <td colspan="5" style="text-align: center;">
                    No Bank Challan Submitted.
                </td>
            </tr>
        <?php } ?>
        </table>
        <h5 style="text-align: center;">ایس ٹی این نمبر اور تاریخ انٹر کرنے کے بعد ایپلیکیشن کو ان لائن سبمٹ کر لیں</h5>
    </div>
    <div style="text-align: center;">
        <?php if ($finished == 1) { ?>

            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 100px;  margin: 5px; padding: 5px; background-color: white;">
                <p style="color: red;"> براہ کرم نوٹ کریں کہ ایک بار آن لائن درخواست جمع کروانے کے بعد، آپ مزید تبدیلیاں نہیں کر سکیں گے۔</p>
                <p style="color: red;">Please note that once you submit the application online, you will not be able to make any further changes.</p>

            </div>



            <a href="<?php echo site_url('form/submit_application_online/' . $school_id . '/' . $schools_id) ?>" onclick="return confirm('Are you sure. you want to submit?')" class=" btn btn-danger">
                <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                Submit Application Online</a>




        <?php } ?>

        <!-- <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_h/$school_id"); ?>">
            <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section H</a> -->

    </div>
    </div>

<?php } ?>