<?php
function convertNumberToWord($num = false)
{
  $num = str_replace(array(',', ' '), '', trim($num));
  if (!$num) {
    return false;
  }
  $num = (int) $num;
  $words = array();
  $list1 = array(
    '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
    'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
  );
  $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
  $list3 = array(
    '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
    'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
    'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
  );
  $num_length = strlen($num);
  $levels = (int) (($num_length + 2) / 3);
  $max_length = $levels * 3;
  $num = substr('00' . $num, -$max_length);
  $num_levels = str_split($num, 3);
  for ($i = 0; $i < count($num_levels); $i++) {
    $levels--;
    $hundreds = (int) ($num_levels[$i] / 100);
    $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
    $tens = (int) ($num_levels[$i] % 100);
    $singles = '';
    if ($tens < 20) {
      $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
    } else {
      $tens = (int)($tens / 10);
      $tens = ' ' . $list2[$tens] . ' ';
      $singles = (int) ($num_levels[$i] % 10);
      $singles = ' ' . $list1[$singles] . ' ';
    }
    $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
  } //end for loop
  $commas = count($words);
  if ($commas > 1) {
    $commas = $commas - 1;
  }
  return implode(' ', $words);
}

function numToOrdinalWord($num)
{
  $num = (int) $num;
  $first_word = array('eth', 'First', 'Second', 'Third', 'Fouth', 'Fifth', 'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Elevents', 'Twelfth', 'Thirteenth', 'Fourteenth', 'Fifteenth', 'Sixteenth', 'Seventeenth', 'Eighteenth', 'Nineteenth', 'Twentieth');
  $second_word = array('', '', 'Twenty', 'Thirthy', 'Forty', 'Fifty');

  if ($num <= 20)
    return $first_word[$num];

  $first_num = substr($num, -1, 1);
  $second_num = substr($num, -2, 1);

  return $string = str_replace('y-eth', 'ieth', $second_word[$second_num] . '-' . $first_word[$first_num]);
}
?>


<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Invoice</title>
  <link rel="stylesheet" href="style.css">
  <link rel="license" href="http://www.opensource.org/licenses/mit-license/">
  <script src="script.js"></script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>CCML</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/themes/default.css" media="screen,print" id="skin-switcher" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/responsive.css" media="screen,print" />
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/custom.css" media="screen,print" />


  <style>
    body {
      background: rgb(204, 204, 204);
    }

    page {
      background: white;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
      width: 21cm;
      /* height: 29.7cm;  */
      height: auto;
    }

    page[size="A4"][layout="landscape"] {
      width: 29.7cm;
      height: 21cm;
    }

    page[size="A3"] {
      width: 29.7cm;
      height: 42cm;
    }

    page[size="A3"][layout="landscape"] {
      width: 42cm;
      height: 29.7cm;
    }

    page[size="A5"] {
      width: 14.8cm;
      height: 21cm;
    }

    page[size="A5"][layout="landscape"] {
      width: 21cm;
      height: 14.8cm;
    }

    @media print {

      body,
      page {
        margin: 0;
        box-shadow: 0;
        color: black;
      }

    }


    .table1>thead>tr>th,
    .table1>tbody>tr>th,
    .table1>tfoot>tr>th,
    .table1>thead>tr>td,
    .table1>tbody>tr>td,
    .table1>tfoot>tr>td {
      border: 1px solid black;
      text-align: center;
    }
  </style>
</head>

<body style="margin: 0px auto !important">
  <page size='A4'>
    <div style="padding: 5px; padding-top:20px;  padding-left:20px; padding-right:20px; 
    " contenteditable="true">
      <table style="width: 100%;">

        <tr>
          <td><img src="<?php echo site_url("assets/uploads/" . $system_global_settings[0]->sytem_admin_logo); ?>" width="100">
          </td>
          <td style="text-align: center;">
            <h3>GOVERNMENT CENTENNIAL MODEL HIGH SCHOOL <br /> (BOYS) CHITRAL LOWER</h3>
            <h5 style="border: 1px solid gray; width: 100%; margin: 0px auto; padding: 4px;">gcmhsbc@gmail.com - 0943 412501 - gcmhsb.chitral.com.pk</h5>
          </td>

        </tr>
        <tr>
          <td colspan="2" style="padding-left:20px ;">
            <br />
            <span class="pull-left"><strong> AWR No.
                <span style="text-decoration: underline; font-weight: bold;">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo $student->student_admission_no ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                </span></strong>
            </span>
            <span class="pull-right"> <strong> Dated:

                <span style="text-decoration: underline; font-weight: bold;">
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <?php echo date("d F, Y") ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                </span></strong></span>
          </td>

        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">
            <br />
            <h3>BIRTH CERTIFICATE</h3>
          </td>

        </tr>
        <tr>
          <td colspan="2">
            <br />
            <p style="font-size: 16px; padding-left: 20px; padding-right: 20px;">It is certified that
              <span style="text-decoration: underline; font-weight: bold;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i><?php echo ucwords(strtolower($student->student_name)) ?></i>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>&nbsp; S/O <span style="text-decoration: underline; font-weight: bold;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i><?php echo ucwords(strtolower($student->student_father_name)) ?></i>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </span>&nbsp; is / was regular student of this school. <br />
              <br />
              His date of birth according to school record is
              <span style="text-decoration: underline; font-weight: bold;">
                <?php echo date("d-m-Y", strtotime($student->student_data_of_birth)); ?>.</span> <br />
              In words (
              <span style="font-weight: bold;">
                The <?php echo numToOrdinalWord(date("d", strtotime($student->student_data_of_birth))); ?>
                of <?php echo date("F", strtotime($student->student_data_of_birth)); ?>,
                <?php echo ucwords(convertNumberToWord(date("Y", strtotime($student->student_data_of_birth)))); ?>
              </span>
              ).
            </p>
          </td>

        </tr>
        <tr>
          <td colspan="2">
            <br />
            <br />
            <p style="padding-right: 20px; padding-left: 20px; padding-top: 40px; ">
              <span class="pull-left" style="text-align: center; font-weight: bold;">Incharge Admission</span>
              <span class="pull-right" style="text-align: center; font-weight: bold;">Principal<br />GCMHS Boys Chitral</span>
            </p>
          </td>

        </tr>

      </table><br /><br /><br /><br />
      <p style="text-align: center; color: #EDEDED;">
        -----<span>&#9986;</span>---------------------------------------------------------------------------------------------------------------------------------<span>&#9986;</span>-----

      </p>
    </div>

  </page>

</body>




</html>