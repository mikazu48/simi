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
		<?php $this->load->view('user/_partials/sidebar.php')?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Navbar -->
				<?php $this->load->view('user/_partials/navbar.php')?>

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
							<form action="<?= base_url('user/proses_data_keluar')?>" method="post">
								<!-- Columns are always 50% wide, on mobile and desktop -->
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<label for="id_transaksi">ID Transaksi</label>
											<input type="text" name="id_transaksi"
												style="margin-left:37px;width:45%;display:inline;" class="form-control"
												readonly="readonly" required
												value="WG-<?=date("Y");?><?=random_string('numeric', 8);?>">
										</div>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="user">User</label>
											<input type="text" name="user" required
												style="margin-left:37px;width:45%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$_SESSION['name']?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="tanggal">Tanggal Keluar</label>
											<input type="date" name="tanggal" required
												style="margin-left:15px;width:45%;display:inline;"
												class="form-control form_datetime" placeholder="Klik Disini">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="lokasi">Lokasi</label>
											<select class="form-control" name="lokasi" required style="margin-left:25px;width:45%;display:inline;">
												<option value="">-- Pilih --</option>
												<option value="Aceh">Aceh</option>
												<option value="Bali">Bali</option>
												<option value="Bengkulu">Bengkulu</option>
												<option value="Jakarta">Jakarta Raya</option>
												<option value="Jambi">Jambi</option>
												<option value="Jawa Tengah">Jawa Tengah</option>
												<option value="Jawa Timur">Jawa Timur</option>
												<option value="Jawa Barat">Jawa Barat</option>
												<option value="Papua">Papua</option>
												<option value="Yogyakarta">Yogyakarta</option>
												<option value="Kalimantan Barat">Kalimantan Barat</option>
												<option value="Kalimantan Selatan">Kalimantan Selatan</option>
												<option value="Kalimantan Tengah">Kalimantan Tengah</option>
												<option value="Kalimantan Timur">Kalimantan Timur</option>
												<option value="Lampung">Lampung</option>
												<option value="NTB">Nusa Tenggara Barat</option>
												<option value="NTT">Nusa Tenggara Timur</option>
												<option value="Riau">Riau</option>
												<option value="Sulawesi Selatan">Sulawesi Selatan</option>
												<option value="Sulawesi Tengah">Sulawesi Tengah</option>
												<option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
												<option value="Sumatera Barat">Sumatera Barat</option>
												<option value="Sumatera Utara">Sumatera Utara</option>
												<option value="Maluku">Maluku</option>
												<option value="Maluku Utara">Maluku Utara</option>
												<option value="Sulawesi Utara">Sulawesi Utara</option>
												<option value="Sulawesi Selatan">Sumatera Selatan</option>
												<option value="Banten">Banten</option>
												<option value="Gorontalo">Gorontalo</option>
												<option value="Bangka">Bangka Belitung</option>
											</select>
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="notes">Notes</label>
											<textarea name="notes" id="notes" class="form-control"  required
											placeholder="Notes" style="margin-left:80px;width:45%;display:inline;"></textarea>
										</div>
									</div>

									<div class="table-responsive" style="overflow-x:scroll;">
										<a href="#" style="margin-bottom:10px;" onclick="AddBarangDetail()"  type="button"
										class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle"
										aria-hidden="true"></i> Tambah Barang</a>

										<table class="table table-bordered" id="TambahBarang" width="120%" style="overflow-x:scroll;">
											<thead>
												<tr>
													<th width="15%">Kode Barang</th>
													<th width="25%">Nama Barang</th>
													<th width="15%">Satuan</th>
													<th>Jumlah</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="AddBarangDetail">
												
											</tbody>
										</table>
									</div>



								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<a type="button" class="btn btn-default" style="width:10%;margin-right:7%"
										onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
											aria-hidden="true"></i> Kembali</a>

									<a type="button" class="btn btn-info" style="width:20%; margin-right:10%"
										href="<?=base_url('user/tabel_barangmasuk')?>" name="btn_listbarang"><i
											class="fa fa-table" aria-hidden="true"></i> Lihat List Barang</a>

									<!-- <button type="reset" class="btn btn-basic" name="btn_reset"><i class="fa fa-eraser"
											aria-hidden="true"></i>
										Reset</button> -->
									<button type="button" class="btn btn-primary" style="width:20%;margin-right:10%;"
										data-toggle="modal" data-target="#DataBarangModal"><i class="fa fa-table"
											aria-hidden="true"></i>
										Pilih Barang
									</button>

									<button type="submit" style="width:20%;" class="btn btn-success"><i
											class="fa fa-check" aria-hidden="true"></i> Submit</button>
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

	<!-- Large modal -->
	<div class="modal fade bd-example-modal-lg" id="DataBarangModal" tabindex="-1" role="dialog"
		aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Satuan</th>
										<th>Stock</th>
										<th>Keterangan</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<?php if(is_array($list_barang)){ ?>
										<?php foreach($list_barang as $dd): ?>
										<td><?=$dd->id_barang?></td>
										<td><?=$dd->nama_barang?></td>
										<td><?=$dd->satuan?></td>
										<td><?=$dd->stok?></td>
										<td><?=$dd->keterangan?></td>
										<td><a type="button" data-dismiss="modal" class="btn btn-info" href="#"
												onclick="GetDataBarang()">
												Select
											</a>
										</td>
										<!-- <td><a type="button" class="btn btn-danger btn-delete"
													href="<?=base_url('admin/proses_delete_list_barang/'.$dd->id_barang)?>"
													name="btn_delete" style="margin:auto;"><i class="fa fa-trash"
														aria-hidden="true"></i></a></td> -->
									</tr>
									<?php endforeach;?>
									<?php }else { ?>
									<td colspan="7" align="center"><strong>Data Kosong</strong></td>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('admin/_partials/js.php')?>

</body>

</html>
