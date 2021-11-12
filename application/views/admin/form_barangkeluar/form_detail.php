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
					<!-- Content Row -->
					<div class="card shadow mb-4">
						<!-- Card Header -->
						<div class="card-header">
							<h3>
								<b>
									<i class="fa fa-book" aria-hidden="true"></i>
									Detail Barang Keluar 
								</b>
							</h3>
						</div>
						<!-- Card Header -->
						<div class="card-body">
							<form action="<?=base_url('admin/proses_databarang_masuk_update')?>" method="post">

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
								<div class="row">
									<div class="col-6">
										<div class="form-group">
											<?php foreach($data_barang_keluar_header as $key => $d){ ?>
											<label for="id_transaksi">ID Transaksi</label>
											<input type="text" name="id_transaksi"
												style="margin-left:37px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$d->id_transaksi?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="user">User</label>
											<input type="text" name="user" required
												style="margin-left:37px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$_SESSION['name']?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="tanggal">Tanggal Masuk</label>
											<input type="text" name="tanggal" required
												style="margin-left:15px;width:50%;display:inline;"
												class="form-control form_datetime" placeholder="Klik Disini" readonly
												value="<?=$d->tanggal_keluar?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="lokasi">Lokasi</label>
											<input type="text" name="user" required
												style="margin-left:25px;width:50%;display:inline;" class="form-control"
												readonly="readonly" value="<?=$d->lokasi?>">
										</div>
									</div>

									<div class="col-6">
										<div class="form-group">
											<label for="notes">Notes</label>
											<textarea name="notes" id="notes" class="form-control"  required
											placeholder="Notes" style="margin-left:80px;width:50%;display:inline;" readonly><?=$d->notes?></textarea>
										</div>
									</div>


									<div class="table-responsive" style="overflow-x:scroll;">
										<!-- <a href="#" style="margin-bottom:10px;" onclick="AddBarangDetail()"  type="button"
										class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle"
										aria-hidden="true"></i> Tambah Barang</a> -->

										<table class="table table-bordered" id="dataTable" width="110%" style="overflow-x:scroll;">
											<thead>
												<tr>
                                                    <th width="5%">Kode Barang</th>
                                                    <th width="25%">Nama Barang</th>
													<th width="5%">Satuan</th>
                                                    <th width="5%">jumlah</th>
												</tr>
											</thead>
											<tbody id="AddBarangDetail">
												<?php $tableRowIndex = 0;
												foreach ($data_barang_keluar_detail as $key) { $tableRowIndex++ ?>
													<tr id="<?=$tableRowIndex?>">
														<td><input type="text" name="kode_barang[]" readonly class="form-control" placeholder="Kode Barang" value="<?=$key->id_barang?>" required></td>
														<td><textarea name="nama_barang[]" readonly class="form-control" placeholder="Nama Barang" required><?=$key->nama_barang?></textarea></td>
                                                        <td><input type="text" name="satuan[]" readonly class="form-control" placeholder="Satuan Barang" value="<?=$key->satuan?>" required></td>
														<td><input type="number" required name="jumlah[]" id="jumlah<?=$tableRowIndex?>" class="form-control" placeholder="Jumlah" value="<?=$key->jumlah?>" readonly></td>
              										</tr>
													  <?php } ?>
											</tbody>
										</table>
									</div>

								</div>
								<?php } ?>
								<!-- /.box-body -->

								<div class="box-footer">
									<a type="button" class="btn btn-default" style="width:10%; margin-right:25%"
										onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left"
											aria-hidden="true"></i> Kembali</a>

									
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
