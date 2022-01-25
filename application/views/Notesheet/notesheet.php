<script src="<?= base_url('ckeditor/ckeditor.js') ?>"></script>
<div class="content-wrapper" style="min-height: 845.764px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display: inline;">
      School Registration
    </h2>
    <small>info about school</small>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a>
      </li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active">School Registrations</li>
    </ol>
  </section>
  <?php //echo "<pre>"; print_r($res);exit;
  ?>
  <!-- Main content -->
  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Schools list</h3>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <form data-toggle="validator" method="POST" action="<?php echo base_url(); ?>NoteSheet/index" novalidate="novalidate">
              <div class="row gutter-xs">
                <div class="col-xs-12">
                  <div class="card">

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="schoolName" class="control-label">Name</label>
                            <input maxlength="1050" class="form-control" type="text" value="" name="schoolName" aria-required="true">
                            <span class="form-control-feedback" aria-hidden="true"><span class="icon"></span></span>
                          </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="schoolId" class="control-label">School ID</label>
                            <input maxlength="1050" class="form-control" type="text" value="" name="schoolId" aria-required="true">
                            <span class="form-control-feedback" aria-hidden="true"><span class="icon"></span></span>
                          </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-6 col-xs-12">
                      <div class="form-group has-feedback">
                        <label for="" class="control-label">Province</label>
                        <select class="form-control" name="province_id">
                          <option value="">Select Province</option>
                          <option value="1">Balochistan</option>
                          <option value="2">KPK</option>
                          <option value="3">Punjab</option>
                          <option value="4">Sind</option>
                        </select>
                       </div>
                    </div> -->

                        <div class="pull-right col-md-4 col-sm-4 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="Select-2" class="control-label">&nbsp;</label>
                            <button type="submit" name="search" class="btn btn-primary btn-block" value="search">Search</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="pull-right margin-b">
          <!-- <a href="http://localhost/PSRA/school/create_form" class="btn btn-flat btn-primary">Add new School Registration</a> -->
        </div>

        <div class="row">
          <div class="col-md-12">

            <div id="area_and_like_box">
              <div class="form-group">

              </div>
            </div>
            <!-- end school id form here... -->
            <div class="clearfix"></div>
            <div class="table-responsive">
              <table width="100%" class="table table-hover table-bordered table-condensed table-striped">
                <tbody>
                  <tr style="font-size: 12px;">
                    <th style="width: 10px;">Seq</th>
                    <th style="width: 10px;">School ID</th>
                    <th width="">School Name</th>
                    <th>Address</th>
                    <th width="">School Level</th>
                    <th width="">Location</th>
                    <th> Establishment</th>
                    <th>Upper Class</th>
                    <!--<th>Forward/Backward To</th> -->
                    <th>Notesheet</th>
                    <?php if ($_SESSION['user_type'] == '1' || $_SESSION['user_type'] == '2') { ?>
                      <th>Print</th>
                      <th>File Status</th><?php } ?>
                    <?php if ($_SESSION['user_type'] == 2) { ?>

                      <th>Action</th> <?php } ?>
                  </tr>
                </tbody>
                <tbody id="searched_data_div">
                  <?php $designations =
                    array(
                      "1" => "Computer Operator",
                      "2" => "DD-MIS",
                      "3" => "Additional Admin",
                      "4" => "DD-Registration",
                      "5" => "AD-Registration-01",
                      "6" => "AD-Registration-02",
                      "7" => "Director",
                      "8" => "Assistant Director Audit",
                    );
                  $count = 1;
                  foreach ($res as $row) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $row['schoolId']; ?></td>
                      <td><a class="btn btn-link" href="https://psra.gkp.pk/schoolReg/school/explore_school_by_id/<?php echo $row['schoolId'] ?>"><?php echo $row['schoolName']; ?></a></td>
                      <td>
                        <span style="font-size: 12px;">
                          <strong>District: </strong><?php echo $row['districtTitle']; ?><br />
                          <strong>Tehsil: </strong><?php echo $row['tehsilTitle']; ?>
                        </span>
                      </td>
                      <td><?php echo $row['levelofInstituteTitle']; ?></td>
                      <td><?php echo $row['location'] ?></td>

                      <td><?php echo $row['yearOfEstiblishment']; ?></td>
                      <td><?php echo $row['upper_class']; ?></td>
                      <?php  //$dis=''; if($row['status_type'] == 1){
                      ?>
                      <!--<td>-->
                      <!--    <input type="text" value="<?php echo $row['subjects'] ?>" class="form-control" <?php echo $dis; ?> onfocusout="addSubject(<?php echo $row['schoolId'] ?>,this)" name="subject">   -->
                      <!--</td> -->
                      <?php // } 
                      ?>

                      <td class="text text-center">
                        <a href="#" style="font-size: 19px;" data-toggle="modal" onclick="viewPara(<?php echo $row['schoolId']; ?>,'<?php echo $row['subjects']; ?>',this)" data-target="#paraViewModal" class="fa fa-file"></a>
                      </td>
                      <?php if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 2) { ?>
                        <td class="text text-center">
                          <a href="https://psra.gkp.pk/schoolReg/NoteSheet/ChangeStatus?print=print&schoolId=<?php echo $row['schoolId']; ?>&subject=<?php echo $row['subjects']; ?>" style="font-size: 19px;" class="fa fa-print"></a>
                        </td><?php } ?>

                      </td>
                      <?php if ($row['isRejected'] == '1') { ?>
                        <td>
                          <label class="label label-danger">Rejected</label>
                        </td><?php } ?>
                      <?php if ($_SESSION['user_type'] == 2) { ?>
                        <td>
                          <a onclick="CloseFile(<?php echo $row['schoolId']; ?>),this" href="#" class="btn btn-info">Close File</a> | <a href="#" onclick="RejectFile(<?php echo $row['schoolId']; ?>),this" class="btn btn-warning">Reject File</a>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>

                </tbody>
              </table>
              <?php if (isset($links)) { ?>
                <?php echo $links ?>
              <?php } ?>
            </div>

          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </section>
  <!-- /.content -->
</div>


<div id="paraViewModal" tabindex="-1" role="dialog" class="modal in">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated bounceIn">
      <div class="modal-header bg-info">
        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">×</span> <span class="sr-only">Close</span> </button>
        <h4 class="modal-title">Notesheet File</h4>
      </div>
      <div class="modal-body">

        <div class="row gutter-xs">
          <div class="col-xs-12">
            <div class="card">
              <div class="card-body">

                <div class="row">
                  <?php if ($_SESSION['user_type'] != '1') { ?>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <h3 for="subject" class="">Subject</h3>
                      <p id="subjects"></p>
                    </div>
                    <hr>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <h3 for="subject" class="">Previous Remarks </h3>
                      <span id="Paras">

                      </span>
                    </div>
                  <?php } ?>
                  <hr>
                  <form method='POST' action="<?php echo base_url(); ?>NoteSheet/ChangeStatus/">
                    <input type="hidden" id="schoolId" name="schoolId" value="">
                    <?php if ($_SESSION['user_type'] == 1) { ?>
                      <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom:20px;">
                        <strong>Type Subject</strong><br>
                        <input type="text" value="" class="form-control" name="subject"><br>
                      </div>
                    <?php } ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <label for="name" class="label label-info">Type Your Message Here</label>
                      <textarea required="required" placeholder="Type Your Message Here" name="para_text" id="" class="form-control" rows="3"><?php echo set_value('discription'); ?></textarea>

                      <!--<div class="form-group has-feedback">-->
                      <!--  <label for="comment_text" class="control-label">Enter Your remarks Here</label>-->
                      <!--  <textarea name="para_text" id="para_text" rows="4" class="form-control"></textarea>-->
                      <!-- </div>-->
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12"></div>
                    <div class="col-md-3 col-sm-12 col-xs-12"></div><br><br>


                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <h4>Select Designation to Forward your case file</h4>
                      <select class="form-control selects" name='status_type' required />
                      <option>--Select--</option>
                      <?php foreach ($designations as $key => $val) {
                        if ($key != $row['status_type']) { ?>
                          <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                        <?php } ?>
                      <?php } ?>
                      </select>
                    </div>
                    <div style="padding-top:5px;" class="pull-right col-md-2 col-sm-6 col-xs-12">
                      <div class="form-group has-feedback">
                        <input type="submit" name="submit" class="btn btn-info btn-block">
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <hr>
            </div>
            <hr>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>
<script>
  CKEDITOR.replace('para_text');

  function handleForm(e) {
    if (e.preventDefault(), !CKEDITOR.instances.para_text.getData().replace(/<[^>]*>/gi, "").length) return alert("Please enter a message"),
      e.preventDefault(), !1;
    for (var t in CKEDITOR.instances) CKEDITOR.instances[t].updateElement();
    if ($("#failed_alert").hide(), $("#success_alert").hide(), 1 == $("#select_all").prop("checked")) $(".checkbox").each(function() {
      $(this).prop("checked", !1);
    });
    else if ($(".checkbox:checked").length < 1) return alert("Please Select at least 1 School"),
      !1;
  }
</script>
<script type="text/javascript">
  var elem = '';


  function viewPara(id, subject, el) {
    document.getElementById('schoolId').value = id;

    document.getElementById('Paras').innerHTML = '';
    document.getElementById('subjects').innerHTML = subject;
    $.ajax({
      type: 'GET',
      data: {
        ViewPara: 'ViewPara',
        schoolId: id
      },
      url: "<?php echo base_url(); ?>NoteSheet/ChangeStatus/",
      contentType: "application/json",
      dataType: "json",
      success: function(data) {
        document.getElementById('Paras').innerHTML = data.datas;
        document.getElementById('subjects').innerHTML = subject;
        //   elem = el;
      }
    });
  }

  function CloseFile(id, el) {
    $.ajax({
      type: 'GET',
      url: "https://psra.gkp.pk/schoolReg/NoteSheet/ChangeStatus?closeFile=closeFile&schoolId=" + id,
      contentType: "application/json",
      dataType: "json",
      success: function(data) {
        $(function() {
          toastr.success('Sucess', 'success');
        });
        el.parentElement.parentElement.remove();
      }
    });
  }

  function RejectFile(id, el) {
    $.ajax({
      type: 'GET',
      url: "https://psra.gkp.pk/schoolReg/NoteSheet/ChangeStatus?isRejected=isRejected&schoolId=" + id,
      contentType: "application/json",
      dataType: "json",
      success: function(data) {
        $(function() {
          toastr.success('Sucess', 'success');
        });
        el.parentElement.parentElement.remove();
      }
    });
  }
</script>