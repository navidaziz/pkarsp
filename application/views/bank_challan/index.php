<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($title)); ?>
    </h2>
    <br />
    <small><?php echo ucwords(strtolower($description)); ?></small>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active"><?php echo @ucfirst($title); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">

    <div class="box box-primary box-solid">


      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
              <h3 style="line-height: 40px;">
                The KP-PSRA Online Portal has introduced a new bank challan generation system for private school registration, renewal, renewal with upgradation, and upgradation only. Blank bank challans are no longer accessible online, and schools must apply through the portal to obtain a computer-generated bank challan.
                <br />
                <br />
                However, deposit slips for school security, change of name, building, location, and applicant certificate are still available as blank. To access them, please print or download the deposit slips listed.
              </h3>
            </div>
          </div>
          <div class="col-md-6">
            <div style="border:1px solid #9FC8E8; border-radius: 10px; min-height: 10px;  margin: 10px; padding: 10px; background-color: white;">
              <h3> Please print / download the following deposit slips: </h3>
              <h4>
                <ul class="list-group">
                  <li class="list-group-item">Institute security deposit slip
                    <a onclick="$('#security').toggle();" class="pull-right" class="btn btn-primary" href="javascirpt:return false;">
                      <i class="fa fa-print"></i> Print Slip</a>
                    <br />
                    <table id="security" class="table" style="text-align: center; margin-top:5px; display:none;">
                      <tr>
                        <th>Primary</th>
                        <th>Middle</th>
                        <th>High</th>
                        <th>High Secondary</th>
                      </tr>
                      <tr>
                        <td>10,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/security_slip/1') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>15,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/security_slip/2') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>15,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/security_slip/3') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>25,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/security_slip/4') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                      </tr>
                    </table>
                  </li>
                  <li class="list-group-item">Change of Name deposit slip
                    <a onclick="$('#name_change').toggle();" class="pull-right" class="btn btn-primary" href="javascirpt:return false;">
                      <i class="fa fa-print"></i> Print Slip</a>
                    <br />
                    <table id="name_change" class="table" style="text-align: center; margin-top:5px; display:none;">
                      <tr>
                        <th>Primary</th>
                        <th>Middle</th>
                        <th>High</th>
                        <th>High Secondary</th>
                      </tr>
                      <tr>
                        <td>10,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_name_bank_challan/1') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>15,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_name_bank_challan/2') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>20,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_name_bank_challan/3') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>20,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_name_bank_challan/4') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                      </tr>
                    </table>
                  </li>
                  <li class="list-group-item">Change of Location deposit slip
                    <a onclick="$('#change_location').toggle();" class="pull-right" class="btn btn-primary" href="javascirpt:return false;">
                      <i class="fa fa-print"></i> Print Slip</a>
                    <br />
                    <table id="change_location" class="table" style="text-align: center; margin-top:5px; display:none;">
                      <tr>
                        <th>Primary</th>
                        <th>Middle</th>
                        <th>High</th>
                        <th>High Secondary</th>
                      </tr>
                      <tr>
                        <td>10,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_building_bank_challan/1') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>15,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_building_bank_challan/2') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>20,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_building_bank_challan/3') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>20,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_building_bank_challan/4') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                      </tr>
                    </table>
                  </li>
                  <li class="list-group-item">Change of Ownership deposit slip
                    <a onclick="$('#change_ownership').toggle();" class="pull-right" class="btn btn-primary" href="javascirpt:return false;">
                      <i class="fa fa-print"></i> Print Slip</a>
                    <br />
                    <table id="change_ownership" class="table" style="text-align: center; margin-top:5px; display:none;">

                      <tr>
                        <th>Primary</th>
                        <th>Middle</th>
                        <th>High</th>
                        <th>High Secondary</th>
                      </tr>
                      <tr>
                        <td>20,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_ownership_bank_challan/1') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>40,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_ownership_bank_challan/2') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>60,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_ownership_bank_challan/3') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                        <td>60,000
                          <br />
                          <a target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_ownership_bank_challan/4') ?>">
                            <i class="fa fa-print"></i> Print Slip</a>
                        </td>
                      </tr>
                    </table>
                  </li>

                  <li class="list-group-item">Fine deposit slip
                    <a class="pull-right" target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/security_slip/') ?>">
                      <i class="fa fa-print"></i> Print Slip</a>
                  </li>
                  <li class="list-group-item">Applicant Cerificate deposit slip
                    <a class="pull-right" target="_blank" class="btn btn-primary" href="<?php echo site_url('print_file/print_change_of_ownership_bank_challan/') ?>">
                      <i class="fa fa-print"></i> Print Slip</a>
                  </li>
                </ul>
              </h4>
            </div>
          </div>
        </div>
      </div>


    </div>

  </section>

</div>