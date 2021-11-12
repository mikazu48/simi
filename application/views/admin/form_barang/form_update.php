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
									Master Barang
								</b>
							</h3>
						</div>
						<!-- Card Header -->

						<!-- Card Body -->
						<div class="card-body">
							<form action="<?= base_url('admin/proses_update_list_barang')?>" method="post">
								<!-- Columns are always 50% wide, on mobile and desktop -->
								<div class="row">
									<?php foreach($data_list_barang as $d){ ?>
									<div class="col-6">
										<div class="form-group">
											<label for="kode_barang">Kode Barang</label>
											<input type="text" name="kode_barang" value="<?= $d->id_barang?>"
												style="margin-left:25px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="BRG - ***" readonly>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="nama_barang">Nama Barang</label>
											<input type="text" name="nama_barang" value="<?= $d->nama_barang?>"
												style="margin-left:25px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Nama barang">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="satuan">Satuan</label>
											<select class="form-control" name="satuan"
												style="margin-left:65px;width:50%;display:inline;">>
												<?php foreach($list_satuan as $s){?>
												<?php if($d->satuan == $s->nama_satuan){?>
												<option value="<?=$d->satuan?>" selected=""><?=$d->satuan?></option>
												<?php }else{?>
												<option value="<?=$s->kode_satuan?>"><?=$s->nama_satuan?></option>
												<?php } ?>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="stok">Stock</label>
											<input type="number" name="stok" value="<?= $d->stok?>"
												style="margin-left:80px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Stock">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="keterangan">Keterangan</label>
											<select class="form-control" name="keterangan" 
												style="margin-left:35px;width:50%;display:inline;">
												<option value="">-- Pilih --</option>

                                                <?php if($d->keterangan == 'Tersedia'){ ?>
                                                <option value="Tersedia" selected>Tersedia</option>
												<option value="Habis">Habis</option>
                                                <?php }else{ ?>
                                                <option value="Tersedia">Tersedia</option>
												<option value="Habis" selected>Habis</option>
                                                <?php } ?>
											</select>
										</div>
									</div>
									<?php } ?>
								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<a type="button" class="btn btn-default" style="width:10%;margin-right:10%"
										onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
											aria-hidden="true"></i> Kembali</a>

									<a type="button" class="btn btn-info" style="width:20%;margin-right:10%;"
										href="<?=base_url('admin/barang')?>" name="btn_listbarang"><i
											class="fa fa-table" aria-hidden="true"></i> Lihat List Barang</a>

									<button type="submit" style="width:20%;margin-right:10%;" class="btn btn-success"><i
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
