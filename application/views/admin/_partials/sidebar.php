<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SIMI</div>
</a>
<div class="sidebar-brand-text mx-3">
<span style="color:white;">Sistem Informasi Manajemen Inventory</span>
</div>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?php echo base_url('admin')?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">
<?php if($_SESSION['role'] == "admin") { ?>
<!-- Heading -->
<div class="sidebar-heading">
    Master
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
        <span>Master</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Master</h6>
            <a class="collapse-item" href="<?php echo base_url('admin/barang')?>">Master Barang</a>
            <a class="collapse-item" href="<?php echo base_url('admin/employee')?>">Master Employee</a>
            <a class="collapse-item" href="<?php echo base_url('admin/tabel_satuan')?>">Master Satuan</a>
            <a class="collapse-item" href="<?php echo base_url('admin/users')?>">Master User</a>
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Transaksi
</div>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-table"></i>
        <span>Transaksi</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Transaksi:</h6>
            <a class="collapse-item" href="<?php echo base_url('admin/tabel_barangmasuk')?>">TRX Barang Masuk</a>
            <a class="collapse-item" href="<?php echo base_url('admin/tabel_barangkeluar')?>">TRX Barang Keluar</a>
            <a class="collapse-item" href="<?php echo base_url('admin/riwayat_peralatan')?>">Riwayat Peralatan</a>
            <a class="collapse-item" href="<?php echo base_url('admin/akumulasi_barang_masuk')?>">Akumulasi Barang Masuk</a>
            <a class="collapse-item" href="<?php echo base_url('admin/akumulasi_barang_keluar')?>">Akumulasi Barang Keluar</a>
        </div>
    </div>
</li> 


<!-- Divider -->
<hr class="sidebar-divider">
<?php }else{ ?>


<!-- Heading -->
<div class="sidebar-heading">
    Transaksi
</div>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-table"></i>
        <span>Transaksi</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Transaksi:</h6>
            <a class="collapse-item" href="<?php echo base_url('admin/tabel_barangmasuk')?>">TRX Barang Masuk</a>
            <a class="collapse-item" href="<?php echo base_url('admin/tabel_barangkeluar')?>">TRX Barang Keluar</a>
            <a class="collapse-item" href="<?php echo base_url('admin/riwayat_peralatan')?>">Riwayat Peralatan</a>
        </div>
    </div>
</li> 
<?php } ?>

<!-- Heading -->
<div class="sidebar-heading">
    User
</div>



<!-- Nav Item - Charts
<li class="nav-item">
    
</li> -->

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="<?php echo base_url('admin/profile')?>">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Profile</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="assets/img/undraw_rocket.svg" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div> -->

</ul>
<!-- End of Sidebar -->