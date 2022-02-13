<div class="modal-header">
  <h4 style="border-left: 20px solid #9FC8E8;  padding-left:5px;" class="pull-left">

    Fee Detail of Class - <?php echo $class->classTitle ?></h4>
  <button type="button pull-right" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">


  <h5 style="color: red;">Note: All fields are mandatory. pleas enter only numeric values. eg. 500, 100, 0 etc</h5>
  <form action="<?php echo site_url("form/update_class_fee") ?>" method="post">
    <table class="table table-bordered">

      <input type="hidden" name="school_id" value="<?php echo $school_id; ?>" />
      <input type="hidden" name="session_id" value="<?php echo $session_id; ?>" />
      <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
      <input type="hidden" name="schools_id" value="<?php echo $schools_id; ?>" />

      <?php
      $query = "SELECT * FROM fee WHERE school_id = '" . $school_id . "' AND class_id = '" . $class_id . "'";
      $class_fees = $this->db->query($query)->result()[0];
      ?>

      <tr>
        <th>Fee Types</th>
        <th>Total</th>
      </tr>
      <tr style="display: none;">
        <th>Admission Fee</th>
        <td><input min="0" type="number" name="addmissionFee" value="<?php echo $class_fees->addmissionFee; ?>" /> Rs.</td>
      </tr>
      <tr>
        <th>Tuition Fee</th>
        <td><input required min="0" type="number" name="tuitionFee" value="<?php echo $class_fees->tuitionFee; ?>" /> Rs.</td>
      </tr>
      <tr style="display: none;">
        <th>Security Fee</th>
        <td><input min="0" type="number" name="securityFund" value="<?php echo $class_fees->securityFund; ?>" /> Rs.</td>
      </tr>
      <tr style="display: none;">
        <th>Others Fee</th>
        <td><input min="0" type="number" name="otherFund" value="<?php echo $class_fees->otherFund; ?>" /> Rs.</td>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center;">
          <input class="btn btn-success btn-sm" type="submit" name="submit" value="Update Fee Detail" </th>
      </tr>


    </table>
  </form>


</div>