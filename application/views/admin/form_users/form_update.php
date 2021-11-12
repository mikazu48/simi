<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SIMI Dashboard</title>

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
						<!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
						<!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
					</div>

					<?php if($this->session->flashdata('msg_berhasil')){ ?>
					<div class="alert alert-success alert-dismissible" style="width:100%">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
					</div>
					<?php } ?>

					<?php if($this->session->flashdata('msg_warn')){ ?>
					<div class="alert alert-warning alert-dismissible" style="width:100%">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Warning !</strong><br> <?php echo $this->session->flashdata('msg_warn');?>
					</div>
					<?php } ?>

					<?php if(validation_errors()){ ?>
					<div class="alert alert-warning alert-dismissible" style="width:100%">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>Warning !</strong><br> <?php echo validation_errors();?>
					</div>
					<?php } ?>

					<div class="card shadow mb-4">
						<div class="card-header">
							<h3>
								<b>
									<i class="fa fa-book" aria-hidden="true"></i>
									Master User
								</b>
							</h3>
						</div>
						<div class="card-body">
							<!-- Content Row -->
							<form action="<?= base_url('admin/proses_update_user')?>" method="post">
								<?php foreach($list_data as $d){ ?>
								<input type="hidden" name="id" value="<?=$d->UserID?>">

								<div class="row">

									<div class="col-6">
										<div class="form-group" style="display:block;">
											<label for="username">Username</label>
											<input type="text" name="username"
												style="margin-left:25px;width:50%;display:inline;" required=""
												class="form-control" id="username" value="<?=$d->username?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group" style="display:block;">
											<label for="password">Password</label>
											<input type="password" name="password"
												style="margin-left:90px;width:50%;display:inline;" class="form-control"
												id="password" placeholder="Password">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group" style="display:block;">
											<label for="email">Email</label>
											<input type="email" name="email"
												style="margin-left:60px;width:50%;display:inline;" class="form-control"
												id="email" required="" value="<?=$d->email?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group" style="display:block;">
											<label for="confirm_password">Confirm Password</label>
											<input type="password" name="confirm_password"
												style="margin-left:30px;width:50%;display:inline;" class="form-control"
												id="confirm_password" placeholder="Confirm Password">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group" style="display:block;">
											<label for="role">Role</label>
											<select class="form-control" name="role"
												style="margin-left:65px;width:50%;display:inline;">
												<?php if($d->role == 1){ ?>
												<option value="1" selected="">User Admin</option>
												<option value="0">User Biasa</option>
												<?php }else{ ?>
												<option value="1">User Admin</option>
												<option value="0" selected="">User Biasa</option>
												<?php } ?>
											</select>
										</div>
									</div>

								</div>

								<?php } ?>
								<a type="button" class="btn btn-default" style="width:10%;margin-right:25%"
									onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
										aria-hidden="true"></i> Kembali</a>
								<a type="button" class="btn btn-info" style="width:20%;margin-right:23%"
									href="<?=base_url('admin/users')?>" name="btn_listusers"><i class="fa fa-table"
										aria-hidden="true"></i> Lihat Users</a>
								<button type="submit" style="width:20%" class="btn btn-primary"><i class="fa fa-check"
										aria-hidden="true"></i> Submit</button>

								<!-- <php if(isset($token_generate)){ ?>
								<input type="hidden" name="token" class="form-control" value="<= $token_generate?>">
								<php }else { 
							redirect(base_url('admin/form_user'));
							}?> -->


							</form>
						</div>
					</div>

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
