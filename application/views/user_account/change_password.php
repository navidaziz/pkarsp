<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h2 style="display:inline;">
      <?php echo ucwords(strtolower($title)); ?>
    </h2>
    <br />
    <h4><?php echo $description; ?></h4>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>"> Home </a></li>
      <!-- <li><a href="#">Examples</a></li> -->
      <li class="active"><?php echo @ucfirst($title); ?> Session: <?php echo $session_detail->sessionYearTitle; ?></li>
    </ol>
  </section>



  <!-- Main content -->
  <section class="content" style="padding-top: 0px !important;">

    <div class="box box-primary box-solid">


      <div class="box-body">
        <div class="row">
          <div class="col-md-12" style="text-align: center;">
            <h4>Change Account Password</h4>

            <form action="<?php echo site_url("user_account/submit_changed_password"); ?>" method="post">
              <table class="table " style="width: 50% !important; margin: 0px auto;">
                <tr>
                  <th>Current Account Password</th>
                  <td><input type="password" name="old_password" required /></td>
                </tr>
                <tr>
                  <th>New Password</th>
                  <td><input type="password" name="new_password" required /></td>
                </tr>
                <tr>
                  <th>Repeat New Password</th>
                  <td><input type="password" name="re_new_password" required /></td>
                </tr>
                <?php if (validation_errors()) { ?>
                  <tr>
                    <td colspan="2">

                      <div class="alert alert-block alert-warning fade in">
                        <?php echo validation_errors(); ?>
                      </div>

                    </td>
                  </tr>
                <?php } ?>
                <?php if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) { ?>
                  <tr>
                    <td colspan="2">
                      <?php if ($this->session->flashdata('msg_error')) { ?>
                        <div class="alert alert-block alert-danger fade in">
                          <?php echo $this->session->flashdata('msg_error'); ?>
                        </div>
                      <?php } ?>
                      <?php if ($this->session->flashdata('msg_success')) { ?>
                        <div class="alert alert-block alert-success fade in">
                          <?php echo $this->session->flashdata('msg_success'); ?>
                        </div>
                      <?php } ?>
                    </td>
                  <?php } ?>
                  <tr>
                    <td colspan="2"><input type="submit" class="btn btn-danger" value="Change Account Password" /></td>
                  </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>

  </section>

</div>