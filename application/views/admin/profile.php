<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SIMI Profile</title>

	<!-- Custom fonts for this template-->
	<link href="<?php echo base_url('assets/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet"
		type="text/css">
	<link
		href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
		rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?php echo base_url('assets/css/sb-admin-2.min.css')?>" rel="stylesheet">

</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">


		<!-- sidebar -->
		<?php $this->load->view('admin/_partials/sidebar.php')?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Navbar -->
				<?php $this->load->view('admin/_partials/navbar.php')?>

				<!-- Begin Page Content -->
				<div class="container-fluid">


					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Profile</h1>
						<!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
					</div>
                
					<!-- Content Row -->
					<div class="row">
						<div class="col-md-5">
							<div class="card">
								<div class="card-body" style="text-align:center;">
									<?php foreach($avatar as $a){ ?>
									<img class="profile-user-img img-responsive img-circle"
										src="<?php echo base_url()?>assets/upload/user/img/<?= $a->nama_file?>"
										alt="User profile picture">
									<?php } ?>
									<h3 class="profile-username text-center"><?=$this->session->userdata('name')?>
									</h3>

									<p class="text-muted text-center">Software Engineer</p><br>

									<?php if($this->session->flashdata('msg_berhasil_gambar')){ ?>
									<div class="alert alert-success alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Success</strong><br>
										<?php echo $this->session->flashdata('msg_berhasil_gambar');?>
									</div>
									<?php } ?>

									<?php if($this->session->flashdata('msg_error_gambar')){ ?>
									<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Warning !</strong><br>
										<?php echo $this->session->flashdata('msg_error_gambar');?>
									</div>
									<?php } ?>

									<?php if(isset($pesan_error)){ ?>
									<div class="alert alert-danger alert-dismissible">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Warning!</strong><br> <?php echo $pesan; ?>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<ul class="nav nav-tabs">
								<li class="nav-item-active">
									<a class="nav-link active" href="#settings" data-toggle="tab">Change Password</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="#picture" data-toggle="tab">Change Picture</a>
								</li>
							</ul>
							<div class="tab-content">

								<!-- /.tab-pane -->

								<!-- /.tab-pane -->

								<div class="tab-pane" id="picture">
									<form class="form-horizontal" action="<?=base_url('admin/proses_gambar_upload')?>"
										method="post" enctype="multipart/form-data">

										<div class="form-group">
											<label for="username" class="col-sm-4 control-label">Open
												Picture</label>

											<div class="col-sm-12">
												<input type="file" name="userpicture" class="form-control"
													id="username">
											</div>
										</div>
										<?php if(isset($token_generate)){ ?>
										<input type="hidden" name="token" class="form-control"
											value="<?= $token_generate?>">
										<?php }else {
                                                redirect(base_url('admin/profile'));
                                                }?>

										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-success"><i class="fa fa-send"
														aria-hidden="true"></i>&nbsp;Submit</button>
											</div>
										</div>
									</form>
								</div>

								<div class="tab-pane active" id="settings">
									<form class="form-horizontal" action="<?=base_url('admin/proses_new_password')?>"
										method="post">

										<?php if($this->session->flashdata('msg_berhasil')){ ?>
										<div class="alert alert-success alert-dismissible">
											<a href="#" class="close" data-dismiss="alert"
												aria-label="close">&times;</a>
											<strong>Success</strong><br>
											<?php echo $this->session->flashdata('msg_berhasil');?>
										</div>
										<?php }elseif ($this->session->flashdata('msg_gagal')) { ?>
										<div class="alert alert-warning alert-dismissible" style="width:100%">
											<a href="#" class="close" data-dismiss="alert"
												aria-label="close">&times;</a>
											<strong>Warning!</strong><br>
											<?php echo $this->session->flashdata('msg_gagal');?>
										</div>
										<?php } ?>

										<?php if(validation_errors()){ ?>
										<div class="alert alert-warning alert-dismissible">
											<a href="#" class="close" data-dismiss="alert"
												aria-label="close">&times;</a>
											<strong>Warning!</strong><br> <?php echo validation_errors(); ?>
										</div>
										<?php } ?>

										<div class="form-group">
											<label for="username" class="col-sm-2 control-label">Username</label>

											<div class="col-sm-10">
												<input type="text" name="username" class="form-control" id="username"
													disabled="" value="<?= $this->session->userdata('name')?>">
											</div>
										</div>
										<div class="form-group">
											<label for="email" class="col-sm-2 control-label">Email</label>

											<div class="col-sm-10">
												<input type="email" name="email" class="form-control" id="email"
													value="<?=$this->session->userdata('email')?>">
											</div>
										</div>
										<div class="form-group">
											<label for="new_password" class="col-sm-3 control-label">New
												Password</label>

											<div class="col-sm-10">
												<input type="password" name="new_password" class="form-control"
													id="new_password" placeholder="New Password">
											</div>
										</div>
										<div class="form-group">
											<label for="confirm_new_password" class="col-sm-4 control-label">Confirm
												New Password</label>

											<div class="col-sm-10">
												<input type="password" name="confirm_new_password" class="form-control"
													id="confirm_new_password" placeholder="Confirm New Password">
											</div>
										</div>
										<?php if(isset($token_generate)){ ?>
										<input type="hidden" name="token" class="form-control"
											value="<?= $token_generate?>">
										<?php }else {
                                                redirect(base_url('admin/profile'));
                                                }?>

										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<button type="submit" class="btn btn-success"><i class="fa fa-send"
														aria-hidden="true"></i>&nbsp;Submit</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div>
					</div>
					<!-- Content Row -->

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; Your Website 2021</span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?php echo base_url();?>">Logout</a>
				</div>
			</div>
		</div>
	</div>
	

	<?php $this->load->view('admin/_partials/js.php')?>

</body>

</html>
