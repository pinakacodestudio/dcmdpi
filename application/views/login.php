<?php
if (isset($this->session->userdata['logged_in'])) {

	redirect("dashboard");
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view('Includes/head'); ?>
</head>
<body class="external-page sb-l-c sb-r-c">
<!-- Start: Main -->
<div id="main" class="animated fadeIn">
	<!-- Start: Content-Wrapper -->
	<section id="content_wrapper">
		<!-- Begin: Content -->
		<section id="content">

			<div class="admin-form theme-info" id="login1">
				
				<div class="panel panel-default heading-border mt10 br-n">

					<!-- end .form-header section -->
					<?php echo form_open('Main/login_process',['name'=>'loginForm','id'=>'loginForm'] ); ?>
						<div class="panel-body bg-light p30">
							<div class="row">
								<div class="col-sm-12">
									<?php
									if ($msg = $this->session->flashdata('error_msg')):
										echo '  <div class="alert alert-danger dark alert-dismissable p5">'.$msg.'</div>';
									endif;
									if ($msg = $this->session->flashdata('success_msg')) :
										echo '  <div class="alert alert-info dark alert-dismissable p5">'.$msg.'</div>';
									endif;
									?>
									<div class="section">
										<label for="username" class="field-label text-muted fs18 mb10">Username</label>
										<label for="username" class="field prepend-icon">
											<?php echo form_input(['name'=>'username','id'=>'username','placeholder'=>'Enter Username','class'=>'gui-input' ]); ?>
											<label for="username" class="field-icon">
												<i class="fa fa-user"></i>
											</label>
										</label>
									</div>
									<!-- end section -->

									<div class="section">
										<label for="username" class="field-label text-muted fs18 mb10">Password</label>
										<label for="password" class="field prepend-icon">
											<?php echo form_password(['name'=>'password','id'=>'password','placeholder'=>'Enter Password','class'=>'gui-input' ]); ?>
											<label for="password" class="field-icon">
												<i class="fa fa-lock"></i>
											</label>
										</label>
									</div>
									<!-- end section -->
									<div class="right reset">
										<?php echo anchor('forgetpass', 'Forgot Password'); ?>
									</div>
								</div>
							</div>
						</div>
						<!-- end .form-body section -->
						<div class="panel-footer clearfix p10 ph15">
							<?php echo form_submit(['value'=>'Sign In','class'=>'button btn-primary mr10 pull-right']); ?>
						</div>
					<!-- end .form-footer section -->
						<?php echo form_close(); ?>
				</div>
			</div>
		</section>
		<!-- End: Content -->
	</section>
	<!-- End: Content-Wrapper -->

</div>
<!-- End: Main -->

<?php $this->load->view('Includes/footerscript'); ?>
<script>
	jQuery(document).ready(function() {
		// validate form on keyup and submit
		jQuery("#loginForm").validate({
			rules: {
				username: "required",
				password: "required"
			},
			messages: {
				username: "Please Enter Username",
				password: "Please Enter Password"
			}
		});
</script>
</body>
</html>