  <?php
  function convertNumberToWord($num)
  {

    $ones = array(
      0 => "ZERO",
      1 => "ONE",
      2 => "TWO",
      3 => "THREE",
      4 => "FOUR",
      5 => "FIVE",
      6 => "SIX",
      7 => "SEVEN",
      8 => "EIGHT",
      9 => "NINE",
      10 => "TEN",
      11 => "ELEVEN",
      12 => "TWELVE",
      13 => "THIRTEEN",
      14 => "FOURTEEN",
      15 => "FIFTEEN",
      16 => "SIXTEEN",
      17 => "SEVENTEEN",
      18 => "EIGHTEEN",
      19 => "NINETEEN",
      "014" => "FOURTEEN"
    );
    $tens = array(
      0 => "ZERO",
      1 => "TEN",
      2 => "TWENTY",
      3 => "THIRTY",
      4 => "FORTY",
      5 => "FIFTY",
      6 => "SIXTY",
      7 => "SEVENTY",
      8 => "EIGHTY",
      9 => "NINETY"
    );
    $hundreds = array(
      "HUNDRED",
      "THOUSAND",
      "MILLION",
      "BILLION",
      "TRILLION",
      "QUARDRILLION"
    ); /*limit t quadrillion */
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr, 1);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {

      while (substr($i, 0, 1) == "0")
        $i = substr($i, 1, 5);
      if ($i < 20) {
        /* echo "getting:".$i; */
        $rettxt .= $ones[$i];
      } elseif ($i < 100) {
        if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
        if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
      } else {
        if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
        if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
        if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
      }
      if ($key > 0) {
        $rettxt .= " " . $hundreds[$key] . " ";
      }
    }
    if ($decnum > 0) {
      $rettxt .= " and ";
      if ($decnum < 20) {
        $rettxt .= $ones[$decnum];
      } elseif ($decnum < 100) {
        $rettxt .= $tens[substr($decnum, 0, 1)];
        $rettxt .= " " . $ones[substr($decnum, 1, 1)];
      }
    }
    return $rettxt;
  }

  ?>
  <!-- Modal -->
  <script>
    function update_class_fee_detail(class_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url("form/update_class_fee_from"); ?>",
        data: {
          class_id: class_id,
          school_id: <?php echo $school_id; ?>,
          session_id: <?php echo $session_id; ?>
        }
      }).done(function(data) {

        $('#update_class_ages_body').html(data);
      });

      $('#update_class_ages').modal('toggle');
    }
  </script>
  <div class="modal fade" id="update_class_ages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="update_class_ages_body">

        ...

      </div>
    </div>
  </div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->load->view('forms/form_header');   ?>

    <!-- Main content -->
    <section class="content" style="padding-top: 0px !important;">

      <?php $this->load->view('forms/navigation_bar');   ?>


      <div class="box box-primary box-solid">
        <style>
          @media (max-width:629px) {
            .guideline {
              font-size: 6px !important;
            }

            .table {
              font-size: 9px !important;
            }
          }
        </style>

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <h4 style="border-left: 20px solid #9FC8E8; padding-left:5px"><strong>SECTION E</strong> (SCHOOL FEE DETAIL)<br />
                <small class="guideline" style="color: red;">
                  Note: Please fill exact fee details as this data will be used in making PSRA fee bank challan for you at the end of this application form.
                  <br />
                  <p style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl;">
                    براہ کرم ٹیوشن فیس کی صحیح تفصیلات پُر کریں کیونکہ اس ڈیٹا کو اس درخواست فارم کے آخر میں آپ کے لیے PSRA فیس بینک چالان بنانے میں استعمال کیا جائے گا۔
                  </p>
                </small>
              </h4>
            </div>
            <div class="col-md-3">
              <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 2px;  margin: 5px; padding: 15px; background-color: white;">

                <div style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl; line-height: 30px;">
                  <h4 style="font-weight: bold; font-family: 'Noto Nastaliq Urdu Draft', serif !important; direction: rtl;"> ضروری انتباہ
                  </h4>
                  KP-PSRA ریگولیشنز ایکٹ 2018 کے مطابق کوئی بھی پرائیویٹ اسکول داخلہ فیس، سالانہ فیس اور کیپٹیشن فیس کسی بھی نام سے نہیں لے سکتا اور پشاور ہائی کورٹ نے ایک رٹ پٹیشن میں فیصلہ دیا جس کا نمبر WP-NO-1995- 2020 مورخہ 14.12.2021 ہے۔
                </div>

                <br />

                <h4 style="font-weight: bold;"> Warning</h4>
                <p style="font-size: 16px; line-height: 22px;">No private school can charge admission fee, annual fee and capitation fee under whatever name as per KP-PSRA Regulations Act 2018 and also peshawar high court judgment in a writ petition bearing number WP-NO-1995- of 2020 Dated 14.12.2021</p>



              </div>
            </div>
            <div class="col-md-9">
              <style>
                .table>tbody>tr>td,
                .table>tbody>tr>th,
                .table>tfoot>tr>td,
                .table>tfoot>tr>th,
                .table>thead>tr>td,
                .table>thead>tr>th {
                  padding: 5px !important;
                }
              </style>



              <p>


                </small>
              </p>

              <table class="table table-bordered">

                <tr>

                  <?php
                  $query = "SELECT
                          `session_year`.`sessionYearTitle`
                          , `session_year`.`sessionYearId`
                          , `school`.`schoolId`
                          FROM
                          `school`
                          INNER JOIN `session_year` 
                          ON (`school`.`session_year_id` = `session_year`.`sessionYearId`)
                          WHERE `session_year`.`sessionYearId` <= $session_id
                          AND  `school`.`schools_id` = '" . $school->schools_id . "'
                          ORDER BY `session_year`.`sessionYearId` DESC LIMIT 2";

                  // WHERE `session_year`.`sessionYearId`= $session_id
                  // AND  `school`.`schoolId` = '" . $school->school_id . "'
                  // ORDER BY `session_year`.`sessionYearId` DESC LIMIT 1";
                  $sessions =  $this->db->query($query)->result();

                  asort($sessions);
                  foreach ($sessions  as $session) { ?>
                    <th colspan="2" style="text-align: center;"><?php echo $session->sessionYearTitle; ?></th>
                  <?php } ?>

                </tr>
                <tr>
                  <th>Classes</th>
                  <?php
                  foreach ($sessions  as $session) { ?>
                    <th style="text-align: center;">Maximum Fee in class</th>
                  <?php } ?>
                  <th>Action</th>
                </tr>

                <?php
                $form_complete = 1;
                foreach ($classes  as $class) {
                  $add = 1;
                ?>
                  <tr>
                    <th><?php echo $class->classTitle ?></th>
                    <?php

                    foreach ($sessions  as $session) {
                      $query = "SELECT 
                                  `fee`.`addmissionFee`
                                , `fee`.`tuitionFee`
                                , `fee`.`securityFund`
                                , `fee`.`otherFund`
                            FROM
                                `fee`  WHERE `fee`.`school_id` = '" . $session->schoolId . "'
                                AND `fee`.`class_id` ='" . $class->classId . "'";

                      $session_fee = $this->db->query($query)->result()[0];
                      if ($session_fee) {
                        $add = 1;
                      } else {
                        $add = 0;
                      }

                    ?>
                      </td>
                      <td style="text-align: center; ">
                        <strong><?php echo $session_fee->tuitionFee; ?></strong>
                        <small style="margin-left: 10px;">
                          <i>
                            <?php
                            //$f = new NumberFormatter("in", NumberFormatter::SPELLOUT);
                            echo ucwords(strtolower(convertNumberToWord($session_fee->tuitionFee)));
                            ?>
                          </i>
                        </small>
                      </td>
                      <?php if ($session->sessionYearId == $session_id and $school_id == $session->schoolId) { ?>
                        <?php if ($add) {  ?>
                          <td style="text-align: center;">
                            <button type="button" class="btn btn-success btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_fee_detail(<?php echo $class->classId ?>)">
                              Edit
                            </button>
                          </td>
                        <?php  } else {
                          $form_complete = 0;
                        ?>
                          <td style="text-align: center;">
                            <button type="button" class="btn btn-danger btn-sm" style="padding: 1px !important; width: 100%;" onclick="update_class_fee_detail(<?php echo $class->classId ?>)">
                              Add
                            </button>
                          </td>

                        <?php } ?>


                      <?php  }  ?>

                    <?php } ?>

                  </tr>
                <?php } ?>


              </table>
              <?php if ($form_complete) { ?>
                <div class="col-sm-12">

                  <?php
                  $query = "SELECT * FROM `fee_mentioned_in_form_or_prospectus` WHERE school_id = '" . $school_id . "'";
                  $fee_mention = $this->db->query($query)->result()[0];

                  ?>
                  <form method="post" action="<?php echo site_url("form/complete_section_e/"); ?>">
                    <input type="hidden" value="<?php echo $school_id; ?>" name="school_id" />
                    <input type="hidden" value="<?php echo $fee_mention->feeMentionedInFormId; ?>" name="feeMentionedInFormId" />
                    Whether the above fees are mentioned in the prospectus/admission form ? <span style="margin-left: 15px;"></span>
                    <input value="Yes" required <?php if ($fee_mention->feeMentionedInForm == 'Yes') { ?> checked <?php } ?> type="radio" name="pro"> Yes <span style="margin-left: 15px;"></span>
                    <input value="No" required <?php if ($fee_mention->feeMentionedInForm == 'No') { ?> checked <?php } ?> type="radio" name="pro"> No <br>
                    Whether the fee structure is displayed both inside and outside school at a prominent place? <span style="margin-left: 15px;"></span>
                    <input value="Yes" required <?php if ($fee_mention->FeeMentionOutside == 'Yes') { ?> checked <?php } ?> type="radio" name="outside"> Yes <span style="margin-left: 15px;"></span>
                    <input value="No" required <?php if ($fee_mention->FeeMentionOutside == 'No') { ?> checked <?php } ?> type="radio" name="outside"> No

                </div>

              <?php } ?>


            </div>







          </div>
          <br />
          <div style="text-align: center;">

            <?php if ($form_complete and $form_status->form_e_status == 0) { ?>
              <input class="btn btn-danger" style="margin: 2px;" type="submit" name="Add Section E Data" value="Add Section E Data" />
            <?php }  ?>

            <?php if ($form_complete and $form_status->form_e_status == 1) { ?>
              <input class="btn btn-primary" style="margin: 2px;" type="submit" name="Add Section E Data" value="Update Section E Data" />
            <?php }  ?>
            </form>
          </div>
          <div style=" font-size: 16px; text-align: center; border:1px solid #9FC8E8; border-radius: 10px; min-height: 30px;  margin: 10px; padding: 10px; background-color: white;">

            <div class="row">
              <div class="col-md-6">
                <a class="btn btn-success" href="<?php echo site_url("form/section_d/$school_id"); ?>">
                  <i class="fa fa-arrow-left" aria-hidden="true" style="margin-right: 10px;"></i> Previous Section ( School Fee Detail ) </a>
              </div>

              <div class="col-md-6">
                <?php if ($form_status->form_e_status == 1) { ?>
                  <a class="btn btn-success" style="margin: 2px;" href="<?php echo site_url("form/section_f/$school_id"); ?>">
                    Next Section ( Security Measures )<i class="fa fa-arrow-right" aria-hidden="true" style="margin-left: 10px;"></i></a>

                <?php } ?>

              </div>
            </div>
          </div>
        </div>


      </div>

  </div>
  </section>

  </div>