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
</head>

<body class="log in" style="position: relative;
    height: 100%;
    background-image: url(<?php echo site_url("assets/" . ADMIN_DIR . "/img/background.jpg"); ?>);
    background-size: cover;
    ">
	<!-- PAGE -->
	<section id="page">
		<!-- HEADER -->
		<header>
			<!-- NAV-BAR -->
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div id="logo" style=" margin-top:20px;">
							<div style=" width:100%; margin:0px auto; color:#FFF; text-shadow: 2px 4px 3px rgba(0,0,0,0.3);">
								<img class="pull-left" src="<?php echo site_url("assets/uploads/" . $system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" style="width:70px !important; margin-right:10px; " /> <span class="pull-left">
									<h3><?php echo $system_global_settings[0]->system_title ?></h3>
									<h6 style="margin-top:-7px;"><?php echo $system_global_settings[0]->system_sub_title ?></h6>
								</span>
							</div>
							<div style="clear:both;"></div>
							<hr />
						</div>

					</div>
				</div>
			</div>
			<!--/NAV-BAR -->
		</header>


		<section id="forgot _bg">




			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="login-box-plain">
							<h2 class="bigintro">Reset Password</h2>
							<div class="divide-40"></div>
							<form role="form" method="post" action="<?php echo site_url("register/password_reset_submit"); ?>">
								<div class="form-group">
									<label for="user_email">Enter your Email address</label>
									<?php if (validation_errors()) { ?>
										<div class="alert alert-block alert-danger fade in">
											<?php echo validation_errors(); ?>
										</div>
									<?php } ?>
									<i class="fa fa-envelope"></i>
									<input type="email" class="form-control" name="user_email" id="user_email">
								</div>
								<div class="form-ac tions">
									<button type="submit" class="btn btn-danger">Send Me Reset Instructions</button>
								</div>
							</form>
							<div class="login-helpers">
								<a href="<?php echo site_url(); ?>">Back to Login</a>
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