<div class="content-wrapper">
	<style>
		.btn-danger {
			color: #fff;
			background-color: #d9534f;
			border-color: #d43f3a;
		}

		.btn {
			display: inline-block;
			margin-bottom: 0;
			font-weight: 400;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			background-image: none;
			border: 1px solid transparent;
			padding: 6px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			border-radius: 4px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
	</style>

	<section class="content" style="background-image:url(img/fairview-hospital-hero.jpg); background-repeat:no-repeat; min-height:500px;">

		<div style=" margin:0px auto; width:100%; text-align:center !important;">
			<div style="margin:150px !important;">

				<h1 style="color: #d9534f;  font-size: 80px;  ">Access Denied</h1>
				<div class="content">
					<h3>Oops! Something went wrong</h3>

					<div class="btn-group">
						Go Back To Home Page<br />
						<a href="<?php echo site_url($this->session->userdata("role_homepage_uri")); ?>" class="btn btn-danger"><i class="fa fa-chevron-left"></i> Click Here</a>

					</div>
					<br />
					<p>
						<small>
							You are not allowed to access this module <span style="color:red;">( <i><?php echo $_GET['module'] ?></i> )</span>. <br />
							If you suspect an error, please contact KPPSRA MIS Wing <a style="font-weight: bold; color:red" href="tel:+92091-9216205">
								<i class="fa fa-phone" aria-hidden="true"></i>
								091-9216205 </a> for assistance. Thank you.
						</small>
					</p>

				</div>

			</div>

		</div>

	</section>
</div>