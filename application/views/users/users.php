  <!-- Content Wrapper. Contains page content -->
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
              <li class="active"><?php echo @$title; ?></li>
          </ol>
      </section>

      <!-- Main content -->
      <section class="content">

          <div class="box box-primary box-solid">
              <div class="box-header with-border">
                  <h3 class="box-title"><?php echo @ucfirst($title); ?>s list</h3>
                  <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">


                  <div class="table-responsive">
                      <?php foreach ($roles as $role) { ?>
                          <h4><?php echo $role->role_title; ?></h4>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>User ID</th>
                                      <th><?php echo $this->lang->line('user_title'); ?></th>
                                      <th><?php echo $this->lang->line('user_email'); ?></th>
                                      <th><?php echo $this->lang->line('user_mobile_number'); ?></th>
                                      <th><?php echo $this->lang->line('user_name'); ?></th>
                                      <th><?php echo $this->lang->line('user_password'); ?></th>
                                      <th><?php echo $this->lang->line('user_image'); ?></th>
                                      <th><?php echo $this->lang->line('role_title'); ?></th>
                                      <th><?php echo $this->lang->line('Status'); ?></th>
                                      <th><?php echo $this->lang->line('Action'); ?></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $count = 1;
                                    foreach ($role->users as $user) : ?>
                                      <?php if ($user->userId != 1) { ?>
                                          <tr>

                                              <td>
                                                  <?php echo $count++; ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->userId; ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->userTitle; ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->userEmail; ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->contactNumber; ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->userName; ?>
                                              </td>
                                              <td>
                                                  *****
                                              </td>
                                              <td>
                                                  <?php
                                                    // echo file_type(base_url("assets/uploads/" . $user->user_image));
                                                    ?>
                                              </td>
                                              <td>
                                                  <?php echo $user->role_title; ?>
                                              </td>
                                              <td>
                                                  <?php echo status($user->userStatus,  $this->lang); ?>
                                                  <?php

                                                    //set uri segment
                                                    if (!$this->uri->segment(4)) {
                                                        $page = 0;
                                                    } else {
                                                        $page = $this->uri->segment(4);
                                                    }

                                                    if ($user->userStatus == 0) {
                                                        echo "<a href='" . site_url("users/publish/" . $user->userId . "/" . $page) . "'> &nbsp;" . $this->lang->line('Publish') . "</a>";
                                                    } elseif ($user->userStatus == 1) {
                                                        echo "<a href='" . site_url("users/draft/" . $user->userId . "/" . $page) . "'> &nbsp;" . $this->lang->line('Draft') . "</a>";
                                                    }
                                                    ?>
                                              </td>
                                              <td><a class="llink llink-trash" href="<?php echo site_url("users/delete/" . $user->userId . "/" . $this->uri->segment(4)); ?>"><i class="fa fa-trash-o"></i></a>
                                              </td>
                                          </tr>
                                      <?php } ?>
                                  <?php endforeach; ?>
                              </tbody>
                          </table>

                      <?php } ?>

                  </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                  <!-- Footer -->
              </div>
              <!-- /.box-footer-->
          </div>
          <!-- /.box -->

      </section>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->