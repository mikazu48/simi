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
					</div>

					<div class="card shadow mb-4">
						<!-- Card Header -->
						<div class="card-header">
							<h3>
								<b>
									<i class="fa fa-book" aria-hidden="true"></i>
									Master Employee
								</b>
							</h3>
						</div>
						<!-- Card Header -->
						<div class="card-body">
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

							<!-- Content Row -->
							<form action="<?= base_url('admin/proses_update_employee')?>" method="post">
								<div class="row">
									<?php foreach($list_data_employee as $DTemployee){?>
									<div class="col-6">
										<div class="form-group">
											<label for="id_employee">ID Employee</label>
											<input type="text" name="id_employee" value="<?=$DTemployee->id_employee?>"
												style="margin-left:25px;width:50%;display:inline;" readonly
												class="form-control form_datetime" placeholder="EMP - ***">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="username">Username</label>
											<input type="text" name="username" value="<?=$DTemployee->username?>"
												style="margin-left:40px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Username">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="nama">Nama Lengkap</label>
											<input type="text" name="nama" value="<?=$DTemployee->nama?>"
												style="margin-left:10px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Nama Lengkap">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="password">Password</label>
											<input type="text" name="password" value="<?=$DTemployee->password?>"
												style="margin-left:45px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Password">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="alamat" style="display:inline">Alamat</label>
											<textarea name="alamat" id="alamat"
												style="margin-left:65px;width:50%;display:inline;"
												class="form-control form_datetime"
												placeholder="Alamat"><?=$DTemployee->alamat?></textarea>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" name="email" value="<?=$DTemployee->email?>"
												style="margin-left:75px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Email">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="no_telp">No Telepon</label>
											<input type="number" name="no_telp" value="<?=$DTemployee->no_telp?>"
												style="margin-left:35px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="No Telepon">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="jenis_kelamin">Jenis Kelamin</label>
											<select class="form-control" name="jenis_kelamin"
												style="margin-left:20px;width:50%;display:inline;">
												<?php if($DTemployee->jenis_kelamin == 'Perempuan'){ ?>
												<option value="Laki-Laki">Laki-Laki</option>
												<option value="Perempuan" selected="">Perempuan</option>
												<?php }else{ ?>
												<option value="Laki-Laki" selected="">Laki-Laki</option>
												<option value="Perempuan">Perempuan</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="role">Role</label>
											<select class="form-control" name="role"
												style="margin-left:85px;width:50%;display:inline;">
												<?php if($DTemployee->role == 'Admin'){ ?>
												<option value="Admin" selected="">Admin</option>
												<option value="User">User</option>
												<?php }else{ ?>
												<option value="Admin">Admin</option>
												<option value="User" selected="">User</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php } ?>
								</div>
								<a type="button" class="btn btn-default" style="width:10%;margin-right:25%"
									onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
										aria-hidden="true"></i> Kembali</a>
								<a type="button" class="btn btn-info" style="width:25%;margin-right:19%"
									href="<?=base_url('admin/employee')?>" name="btn_listusers"><i class="fa fa-table"
										aria-hidden="true"></i> Lihat List Employee</a>
								<button type="submit" style="width:20%" class="btn btn-primary"><i class="fa fa-check"
										aria-hidden="true"></i> Submit</button>

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
