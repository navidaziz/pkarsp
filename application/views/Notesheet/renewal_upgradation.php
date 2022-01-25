<!-- Content Wrapper. Contains page content -->
<script src="<?= base_url('ckeditor/ckeditor.js') ?>"></script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo @ucfirst($title); ?>
    </h2>
    <small><?php echo @$description; ?></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active"><?php echo @ucfirst($title); ?>s</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Schools list</h3>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="pull-right margin-b">
          <!-- <a href="<?php echo base_url('school/create_form'); ?>" class="btn btn-flat btn-primary">Add new <?php echo @ucfirst($title); ?></a> -->
        </div>
        <?php $role_id = $this->session->userdata('role_id'); ?>
        <div class="row">
          <div class="col-md-12">
            <!-- radio button for search... -->

            <!-- school Id search form-->

            <!-- end school id form here... -->
            <!-- <=======        ========> -->
            <!-- school area and name search -->

            <div id="area_and_like_box">
              <div class="form-group">
                <div class="col-sm-4">
                  <select class="form-control select2" id="district_id" name="district_id" onchange="getTehsilsByDistrictId(this);" required style="width: 100%;">
                    <?php echo $districts; ?>
                  </select>
                </div>
                <div class="col-sm-4">
                  <select class="form-control select2" name="tehsil_id" id="tehsil_id" style="width: 100%;" onchange="requiredOperationAfterTehsilChange(this);">
                    <option value="0">Select Tehsil</option>
                  </select>
                </div>
                <label class="col-sm-4">
                  <input type="text" class="form-control" name="like_text" onkeyup="getSchoolsDontHaveRegistrationNumberAllotedLikeCondition(this);" required="required" id="like_text" placeholder="Enter School Name" value="">
                </label>
              </div>
            </div>
            <div class="clearfix"></div>
            <div id="by_school_id">
              <form id="Form2" method="post" enctype="multipart/form-data" action="<?php echo base_url('school/get_single_school_for_renewal_by_id'); ?>">
                <div class="form-group">
                  <label class="col-sm-4">
                    <input type="text" class="form-control" name="schools_id" required="required" form="Form2" id="schools_id" placeholder="Enter School Id Examples 1,2,3 etc.">
                  </label>
                  <label class="col-sm-2">
                    <input type="submit" id="search" class="form-control btn-xs btn-primary btn-flat" form="Form2" value="Search">
                  </label>
                </div>
              </form>
            </div>
            <!-- end school area search... -->
            <div>
              <table class="table table-responsive table-hover table-bordered table-condensed table-striped">
                <thead>
                  <tr style="font-size: 12px;">
                    <th style="width: 10px">ID</th>
                    <th>School Name</th>
                    <th>Address</th>
                    <th>BISE Reg No </th>
                    <th>School Level</th>
                    <th>Reg Type </th>
                    <th>Notesheet</th>
                    <?php if ($_SESSION['user_type'] == '1' || $_SESSION['user_type'] == '2') { ?>
                      <th>Print</th>
                      <th>File Status</th><?php } ?>
                    <?php if ($_SESSION['user_type'] == 2) { ?>

                      <th>Action</th> <?php } ?>
                  </tr>
                </thead>
                <tbody id="searched_data_div">
                  <!-- <tr ></tr> -->
                  <?php $counter = 1;

                  ?>
                  <?php foreach ($schools as $school) : ?>
                    <tr>
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
                        ); ?>
                      <td><?php echo $school->schoolId; ?></td>
                      <td width="10%">
                        <a class="btn btn-link" href="<?php echo base_url('school/explore_schools_by_school_id/'); ?><?php echo $school->schoolId; ?>">
                          <?php echo $school->schoolName; ?>
                        </a><br>
                        <span class="label label-default"><?php //echo @$school->registrationNumber; 
                                                          ?></span>
                      </td>


                      <td><?php if ($school->districtTitle != NULL) {
                            echo "<span style='font-size:12px;'><strong>District: </strong>" . $school->districtTitle . "<br /><strong>Tehsil: </strong>" . $school->tehsilTitle . " " . $school->address . "</span>";
                          } else {
                            echo $school->address;
                          }
                          ?>
                      </td>



                      <td><?php echo @$school->biseregistrationNumber; ?></td>
                      <td><?php echo @$school->classTitle; ?> To <?php echo @$school->upper_class; ?></td>
                      <td><?php echo @$school->regTypeTitle; ?></td>
                      <td class="text text-center">
                        <a href="#" style="font-size: 19px;" data-toggle="modal" onclick="viewPara(<?php echo $school->schoolId; ?>,<?php echo $school->schoolId; ?>,this)" data-target="#paraViewModal" class="fa fa-file"></a>
                      </td>



                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?= $this->pagination->create_links(); ?>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Modal -->
<script type="text/javascript">
  var elem = '';


  function viewPara(id, subject, el) {
    document.getElementById('schoolId').value = id;
    // alert(id);
    document.getElementById('Paras').innerHTML = '';
    document.getElementById('subjects').innerHTML = subject;
    //   $.ajax({
    //     type :'GET',
    //     data:{ViewPara:'ViewPara',schoolId:id},
    //     url  :"<?php echo base_url(); ?>NoteSheet/renewalStatus/",
    //     contentType: "application/json",
    //     dataType: "json",
    //     success: function(data){  
    //       document.getElementById('Paras').innerHTML = data.datas;
    //       document.getElementById('subjects').innerHTML = subject;
    //     //   elem = el;
    //     }
    //   });
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
                        <input type="submit" name="renewal_upgradation" class="btn btn-info btn-block">
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

<div class="modal fade" id="modal_one" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #00a65a;color:#fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color:#fff;" id="modal_one_title">title will be goes dynamically</h4>
      </div>
      <div id="modal_one_content_goes_here">

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