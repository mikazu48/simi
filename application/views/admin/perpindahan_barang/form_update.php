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
									Transaksi Barang Keluar
								</b>
							</h3>
						</div>
						<!-- Card Header -->
						<div class="card-body">
							<form action="<?=base_url('admin/proses_data_keluar')?>" method="post">
								<div class="row">

									<div class="col-6">
										<div class="form-group">
											<?php foreach($data_barang_update_header as $d){ ?>
											<label for="id_transaksi">ID Transaksi</label>
											<input type="text" name="id_transaksi"
												style="margin-left:37px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$d->id_transaksi?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="tanggal_masuk">Tanggal Masuk</label>
											<input type="text" name="tanggal_masuk"
												style="margin-left:10px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$d->tanggal?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="tanggal_keluar">Tanggal Keluar</label>
											<input type="date" name="tanggal_keluar" required
												style="margin-left:3%;width:50%;display:inline;" class="form-control">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="user">User</label>
											<input type="text" name="user"
												style="margin-left:85px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$d->user?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="notes">Notes</label>
											<textarea name="notes" id="notes" class="form-control"  required
											placeholder="Notes" style="margin-left:80px;width:50%;display:inline;" cols="50"></textarea>
										</div>
									</div>

									<div class="table-responsive" style="overflow-x:scroll;">
										<table class="table table-bordered" id="TambahBarang" width="120%" style="overflow-x:scroll;">
											<thead>
												<tr>
													<th width="15%">Kode Barang</th>
													<th width="25%">Nama Barang</th>
													<th width="15%">Satuan</th>
													<th>Jumlah</th>
													<th>Lokasi</th>
												</tr>
											</thead>
											<tbody id="AddBarangDetail">
												<?php $tableRowIndex = 0;
												foreach ($data_barang_update_header_detail as $key) { ?>
													<tr id="<?=$tableRowIndex?>">
														<td><input type="text" name="kode_barang[]" id="kode_barang<?=$tableRowIndex?>" readonly class="form-control" placeholder="Kode Barang" value="<?=$key->id_barang?>" required></td>
														<td><textarea name="nama_barang[]" id="nama_Barang<?=$tableRowIndex?>" readonly class="form-control" placeholder="Nama Barang" required><?=$key->nama_barang?></textarea></td>
														<td><select class="form-control" name="satuan[]" id="satuan<?=$tableRowIndex?>" required>
														<option value="" selected="">Pilih</option>
														<?php foreach($list_satuan as $s){ ?>
															<?php if($key->satuan == $s->nama_satuan){?>
															<option value="<?=$key->satuan?>" selected=""><?=$key->satuan?></option>
															<?php }else{?>
															<option value="<?=$s->kode_satuan?>"><?=$s->nama_satuan?></option>
															<?php } ?>
															<?php } ?>
														</select></td>
														<td><input type="number" required name="jumlah[]" id="jumlah<?=$tableRowIndex?>" class="form-control" placeholder="Jumlah" value="<?=$key->jumlah?>"></td>
														<td><input type="text" required name="lokasi[]" id="lokasi<?=$tableRowIndex?>" class="form-control" placeholder="Lokasi" value="<?=$key->lokasi?>" readonly></td>
              										</tr>
													  <?php } ?>
											</tbody>
										</table>
									</div>



								</div>
								<?php } ?>
								<!-- /.box-body -->

								<div class="box-footer">
									<a type="button" class="btn btn-default" style="width:10%; margin-right:65%"
										onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
											aria-hidden="true"></i> Kembali</a>

									<button type="submit" style="width:20%;" class="btn btn-success"><i
											class="fa fa-check" aria-hidden="true"></i>
										Submit</button>&nbsp;&nbsp;&nbsp;
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
