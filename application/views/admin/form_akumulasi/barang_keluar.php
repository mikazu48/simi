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

	<!-- Custom styles for this page -->
	<link href="<?php echo base_url('vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">

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
					<h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Akumulasi Barang Keluar</h3>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-body">
						<form action="<?= base_url('admin/generate_akumulasi_barang_keluar')?>" method="post">
							<?php if($this->session->flashdata('msg_berhasil')){ ?>
							<div class="alert alert-success alert-dismissible" style="width:100%">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
							</div>
							<?php } ?>

							<?php if($this->session->flashdata('msg_berhasil_keluar')){ ?>
							<div class="alert alert-success alert-dismissible" style="width:100%">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Success!</strong><br>
								<?php echo $this->session->flashdata('msg_berhasil_keluar');?>
							</div>
							<?php } ?>
							<div class="col-6">
								<div class="form-group">
									<label for="tahun">Tahun</label>
									<select class="form-control" name="tahun"
												style="margin-left:35px;width:50%;display:inline;">
												<option value="2018">2018</option>
												<option value="2019">2019</option>
												<option value="2020">2020</option>
												<option value="2021" selected>2021</option>
												<option value="2022">2022</option>
												<option value="2023">2023</option>
												<option value="2024">2024</option>
									</select>
									
									<button type="submit" style="width:100%;margin-right:10%;" class="btn btn-success"><i
											class="fas fa-file-alt" aria-hidden="true"></i> Generate Laporan</button>

								</div>
							</div>
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
					<a class="btn btn-primary" href="<?php echo base_url()?>">Logout</a>
				</div>
			</div>
		</div>
	</div>

	

	<?php $this->load->view('admin/_partials/js.php')?>

</body>

</html>
