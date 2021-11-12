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
					<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Master Barang</h1>
						<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
					</div> -->

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
					<div class="card shadow mb-4">
						<!-- Card Header -->
						<div class="card-header">
							<h3>
								<b>
									<i class="fa fa-book" aria-hidden="true"></i>
									Master Riwayat Peralatan
								</b>
							</h3>
						</div>
						<!-- Card Header -->

						<!-- Card Body -->
						<div class="card-body">
							<form action="<?= base_url('admin/proses_riwayat_peralatan_insert')?>" method="post">
								<!-- Columns are always 50% wide, on mobile and desktop -->
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="nama_perlatan">Nama Peralatan</label>
											<input type="text" name="nama_perlatan"
												style="margin-left:25px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Nama Peralatan">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="kategori_peralatan">Kategori Peralatan</label>
											<select name="kategori_peralatan" id="kategori_peralatan"
											class="form-control form_datetime" required
											style="margin-left:25px;width:50%;display:inline;" >
											<option value="Fasilitas Listrik bandara Pembangkit">Fasilitas Listrik bandara Pembangkit</option>
											<option value="Transformator">Transformator</option>
											<option value="Swith gear">Swith gear</option>
											<option value="Fasilitas Bantu Pendaratan (Visual Aids)">Fasilitas Bantu Pendaratan (Visual Aids)</option>
											<option value="Lainnya">Lainnya</option>
											</select>
											<!-- <input type="text" name="kategori_peralatan"
												style="margin-left:25px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Kategori Peralatan"> -->
										</div>
									</div>
                                    <div class="col-6">
										<div class="form-group">
											<label for="merk">Merk</label>
											<input type="text" name="merk"
												style="margin-left:105px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Merk">
										</div>
									</div>
                                    <div class="col-6">
										<div class="form-group">
											<label for="type">Type</label>
											<input type="text" name="type"
												style="margin-left:125px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Type">
										</div>
									</div>
                                    <div class="col-6">
										<div class="form-group">
											<label for="daya">Daya</label>
											<input type="text" name="daya"
												style="margin-left:105px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Daya">
										</div>
									</div>
                                    <div class="col-6">
										<div class="form-group">
											<label for="frequency">Frequency</label>
											<input type="text" name="frequency"
												style="margin-left:85px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Frequency">
										</div>
									</div>
                                    <div class="col-6">
										<div class="form-group">
											<label for="volume">Volume</label>
											<input type="text" name="volume"
												style="margin-left:85px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Volume">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="satuan">Satuan</label>
											<select class="form-control" name="satuan"
												style="margin-left:110px;width:50%;display:inline;" required>
												<option value="" selected="">-- Pilih --</option>
												<?php foreach($list_satuan as $s){ ?>
												<option value="<?=$s->id_satuan?>"><?=$s->nama_satuan?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="kondisi">Kondisi</label>
											<input type="text" name="kondisi"
												style="margin-left:85px;width:50%;display:inline;" required
												class="form-control form_datetime" placeholder="Kondisi">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="tanggal_input">Tanggal Input</label>
											<input type="date" name="tanggal_input"
												style="margin-left:60px;width:50%;display:inline;" required
												class="form-control form_datetime">
										</div>
									</div>
								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<a type="button" class="btn btn-default" style="width:10%;margin-right:30%"
										onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
											aria-hidden="true"></i> Kembali</a>

									<button type="submit" style="width:20%;margin-right:30%;" class="btn btn-success"><i
											class="fa fa-check" aria-hidden="true"></i> Submit</button>

									<button type="reset" class="btn btn-basic" name="btn_reset"><i class="fa fa-eraser"
											aria-hidden="true"></i>
										Reset</button>
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
					<a class="btn btn-primary" href="<?php echo base_url();?>">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('admin/_partials/js.php')?>

</body>

</html>
