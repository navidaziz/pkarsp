<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- STYLESHEETS -->
  <!--[if lt IE 9]><script src="js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/cloud-admin.css">
  <link href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- DATE RANGE PICKER -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <!-- UNIFORM -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/css/uniform.default.min.css" />
  <!-- ANIMATE -->
  <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/css/animatecss/animate.min.css" />
  <!-- FONTS -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151551956-1"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-151551956-1');
  </script>
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/" . ADMIN_DIR . "img/background.jpg"); ?>);
    background-size: cover;
    ">
  <!-- PAGE -->
  <section id="page">

    <section id="login_bg" <?php if ($this->input->get('register') != 1) { ?>class="visible" <?php } ?>>
      <div class="container">
        <div class="row" style="margin: 10px; margin-top: 70px;">
          <div class="col-md-7">
            <div id="logo">
              <div style=" width:100%; text-align: center; margin:0px auto; color:black; ">
                <img src=" <?php echo site_url("assets/" . ADMIN_DIR . "img/psra_log.png"); ?>" alt="PSRA" title="PSRA" style="width:350px !important;" />

                <h2>Private Schools Regulatory Authority</h2>
                <h4>Government Of Khyber Pakhtunkhwa</h4>
                <address><i class="fa fa-envelope"></i> psra.pmdu@gmail.com
                  <span style="margin-left: 10px;"></span> <i class="fa fa-phone" aria-hidden="true"></i> 091-5619512
                  <br />


                  <i class="fa fa-map-marker" aria-hidden="true"></i> 18-E Jamaluddi Ud Din Afghani Road, University Town, Peshawar
                </address>

              </div>
              <div style="clear:both;"></div>

            </div>
          </div>
          <div class="col-md-4">
            <div class="login-box" style="background-color:#5C9CCC; opacity:.9; margin: 5px auto; padding-top:10px !important;">
              <h2 class="bigintro">Sign In</h2>
              <div class="divide-40"></div>
              <form role="form" method="post" action="<?php echo site_url("login/validate_user"); ?>">
                <div class="form-group">
                  <label for="userName">User Name</label>
                  <i class="fa fa-user"></i>
                  <input type="text" name="userName" class="form-control" id="userName" value="<?php echo set_value("userName"); ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <i class="fa fa-lock"></i>
                  <input type="password" name="userPassword" class="form-control" id="userName" value="">
                </div>
                <div class="form-group">
                  <div class="g-recaptcha" data-sitekey="6Leuqa4ZAAAAAEBURd3DWqmwV4cdzXi5zzcljMLR" style="height: 100px;">
                  </div>
                </div>
                <div>
                  <button type="submit" class="btn btn-danger">Login</button>
                </div>
              </form>
              <!-- SOCIAL LOGIN -->
              <div class="divide-20"></div>
              <?php
              if ($this->session->flashdata("msg") || $this->session->flashdata("msg_error") || $this->session->flashdata("msg_success")) {

                $type = "";
                if ($this->session->flashdata("msg_success")) {
                  $type = "success";
                  $msg = $this->session->flashdata("msg_success");
                } elseif ($this->session->flashdata("msg_error")) {
                  $type = "danger";
                  $msg = $this->session->flashdata("msg_error");
                } else {
                  $type = "info";
                  $msg = $this->session->flashdata("msg");
                }
                echo '<div class="alert alert-' . $type . '" role="alert"> <i class="fa fa-info-circle" aria-hidden="true"></i>  ' . $msg . '</div>';
              }
              ?>

              <?php if (validation_errors()) { ?>
                <div class="alert alert-block alert-danger fade in">
                  <?php echo validation_errors(); ?>
                </div>
              <?php } ?>
              <!-- /SOCIAL LOGIN -->
              <div class="login-helpers"> <a href="<?php echo site_url(); ?>register/password_reset">Forgot Password?</a> <br>
                Don't have an account with us? <a href="<?php echo site_url(); ?>register/signup">Register
                  now!</a><br>

              </div>
            </div>

          </div>
        </div>
      </div>

    </section>

    <section id="forgot_bg">




      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <div class="login-box" style="background-color:#2C2C2C; opacity:.9; margin: 5px auto; padding-top:10px !important;">
              <h2 class="bigintro">Reset Password</h2>
              <div class="divide-40"></div>
              <form role="form">
                <div class="form-group">
                  <label for="exampleInputEmail1">Enter your Email address</label>
                  <i class="fa fa-envelope"></i>
                  <input type="email" class="form-control" id="exampleInputEmail1">
                </div>
                <div>
                  <button type="submit" class="btn btn-info">Send Me Reset Instructions</button>
                </div>
              </form>
              <div class="login-helpers"> <a href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/#" onclick="swapScreen('login_bg');return false;">Back to Login</a> <br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- FORGOT PASSWORD -->
  </section>
  <!--/PAGE -->
  <!-- JAVASCRIPTS -->
  <!-- Placed at the end of the document so the pages load faster -->
  <!-- JQUERY -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery/jquery-2.0.3.min.js"></script>
  <!-- JQUERY UI-->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
  <!-- BOOTSTRAP -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/bootstrap-dist/js/bootstrap.min.js"></script>

  <!-- UNIFORM -->
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/uniform/jquery.uniform.min.js"></script>
  <!-- BACKSTRETCH -->
  <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/backstretch/jquery.backstretch.min.js"></script>
  <!-- CUSTOM SCRIPT -->
  <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/js/script.js"></script>
  <script>
    jQuery(document).ready(function() {
      App.setPage("login_bg"); //Set current page
      App.init(); //Initialise plugins and elements
    });
  </script>
  <script type="text/javascript">
    function swapScreen(id) {
      jQuery('.visible').removeClass('visible animated fadeInUp');
      jQuery('#' + id).addClass('visible animated fadeInUp');
    }
  </script>
  <!-- /JAVASCRIPTS -->
</body>

</html>