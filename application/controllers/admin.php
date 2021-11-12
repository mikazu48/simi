<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

  public function __construct(){
		parent::__construct();
    $this->load->model('M_admin');
    $this->load->model('M_barang');
    $this->load->model('M_employee');
    $this->load->library('upload');
	}

  public function index(){
    if($this->session->userdata('status') == 'login' && $this->session->userdata('role') == 'admin'){
      $data['stokBarangMasuk'] = $this->M_admin->sum('tb_barang_masuk_detail','jumlah');
      $data['stokBarangKeluar'] = $this->M_admin->sum('tb_barang_keluar_detail','jumlah');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $data['dataUser'] = $this->M_admin->numrows('user');
      $this->load->view('admin/V_admin',$data);
    }else {
      $this->load->view('login/V_login');
    }
  }

  public function sigout(){
    session_destroy();
    redirect('login');
  }

  ####################################
              // Profile
  ####################################

  public function profile()
  {
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->session->set_userdata($data);
    $this->load->view('admin/profile',$data);
  }

  public function token_generate()
  {
    return $tokens = md5(uniqid(rand(), true));
  }

  private function hash_password($password)
  {
    return password_hash($password,PASSWORD_DEFAULT);
  }

  public function proses_new_password()
  {
    $this->form_validation->set_rules('email','Email','required');
    $this->form_validation->set_rules('new_password','New Password','required');
    $this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]');

    if($this->form_validation->run() == TRUE)
    {
      if($this->session->userdata('token_generate') === $this->input->post('token'))
      {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $new_password = $this->input->post('new_password');

        $data = array(
            'email'    => $email,
            'password' => $new_password
        );

        $where = array(
            'UserID' =>$this->session->userdata('UserID')
        );

        $this->M_admin->update_password('user',$where,$data);

        $this->session->set_flashdata('msg_berhasil','Password Telah Diganti');
        redirect(base_url('admin/profile'));
      }
    }else {
        $this->session->set_flashdata('msg_gagal','Password Harus Sama');
        $this->load->view('admin/profile');
    }
  }

  public function proses_gambar_upload()
  {
    $config =  array(
        'upload_path'     => "./assets/upload/user/img/",
        'allowed_types'   => "gif|jpg|png|jpeg",
        'encrypt_name'    => False, //
        'max_size'        => "50000",  // ukuran file gambar
        'max_height'      => "9680",
        'max_width'       => "9024"
      );
    $this->load->library('upload',$config);
    $this->upload->initialize($config);

    if( ! $this->upload->do_upload('userpicture'))
    {
    $this->session->set_flashdata('msg_error_gambar', $this->upload->display_errors());
    $this->load->view('admin/profile',$data);
    }else{
    $upload_data = $this->upload->data();
    $nama_file = $upload_data['file_name'];
    $ukuran_file = $upload_data['file_size'];

    //resize img + thumb Img -- Optional
    $config['image_library']     = 'gd2';
        $config['source_image']      = $upload_data['full_path'];
        $config['create_thumb']      = FALSE;
        $config['maintain_ratio']    = TRUE;
        $config['width']             = 150;
        $config['height']            = 150;

    $this->load->library('image_lib', $config);
    $this->image_lib->initialize($config);
        if (!$this->image_lib->resize())
    {
    $data['pesan_error'] = $this->image_lib->display_errors();
    $this->load->view('admin/profile',$data);
    }

        $where = array(
            'username_user' => $this->session->userdata('name')
        );

        $Username_User = $this->session->userdata('name');

        $data = array(
                'nama_file' => $nama_file,
                'ukuran_file' => $ukuran_file
        );

        $this->M_admin->update('tb_upload_gambar_user',$data,$where);
        $this->session->set_flashdata('msg_berhasil_gambar','Gambar Berhasil Di Upload');
        redirect(base_url('admin/profile'));
      }
  }

  ####################################
           // End Profile
  ####################################



  ####################################
              // Users
  ####################################
  public function users()
  {
    $data['list_users'] = $this->M_admin->kecuali('user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/users',$data);
  }

  public function form_user()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/form_users/form_insert',$data);
  }

  public function update_user()
  {
    $id = $this->uri->segment(3);
    $where = array('UserID' => $id);
    $data['token_generate'] = $this->token_generate();
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['list_data'] = $this->M_admin->get_data('user',$where);
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/form_users/form_update',$data);
  }

  public function proses_delete_user()
  {
    $id = $this->uri->segment(3);
    $where = array('UserID' => $id);
    $this->M_admin->delete('user',$where);
    
    $this->session->set_flashdata('msg_berhasil','User Behasil Di Delete');
    redirect(base_url('admin/users'));

  }

  public function proses_tambah_user()
  {
    $this->form_validation->set_rules('username','Username','required');
    $this->form_validation->set_rules('email','Email','required|valid_email');
    $this->form_validation->set_rules('password','Password','required');
    $this->form_validation->set_rules('confirm_password','Confirm password','required|matches[password]');

    if($this->form_validation->run() == TRUE)
    {

        $username     = $this->input->post('username',TRUE);
        $email        = $this->input->post('email',TRUE);
        $password     = $this->input->post('password',TRUE);
        $role         = $this->input->post('role',TRUE);

        $data = array(
              'username'     => $username,
              'email'        => $email,
              'password'     => $password,
              'role'         => $role
        );
        $tb_upload_gambar_data = array('username_user'     => $username);
        $this->M_admin->insert('user',$data);
        $this->M_admin->insert('tb_upload_gambar_user',$tb_upload_gambar_data);

        $this->session->set_flashdata('msg_berhasil','User Berhasil Ditambahkan');
        redirect(base_url('admin/form_user'));
        
      }else {
        $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
        $this->load->view('admin/form_users/form_insert',$data);
    }
  }

  public function proses_update_user()
  {
    $this->form_validation->set_rules('username','Username','required');
    $this->form_validation->set_rules('email','Email','required|valid_email');

    $id           = $this->input->post('id',TRUE);        
    if($this->form_validation->run() == TRUE)
    {
        
        $username     = $this->input->post('username',TRUE);
        $email        = $this->input->post('email',TRUE);
        $role         = $this->input->post('role',TRUE);

        $where = array('UserID' => $id);
        $data = array(
              'username'     => $username,
              'email'        => $email,
              'role'         => $role,
        );
        $this->M_admin->update('user',$data,$where);
        $this->session->set_flashdata('msg_berhasil','Data User Berhasil Diupdate');
        redirect(base_url('admin/users'));
       
    }else{
      $where = array('UserID' => $id);
      $data['list_data'] = $this->M_admin->get_data('user',$where);
      $this->load->view('admin/form_users/form_update',$data);
    }
  }


  ####################################
           // End Users
  ####################################




  ####################################
          // DATA BARANG
  ####################################
  public function barang()
  {
    $data['list_barang'] = $this->M_barang->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/barang',$data);
  }

  public function form_barang(){
    $data['list_barang'] = $this->M_admin->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/form_barang/form_insert',$data);
  }

  public function proses_list_barang_insert(){
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
    $this->form_validation->set_rules('satuan','Satuan','required');
    $this->form_validation->set_rules('nama_barang','Nama Barang','required');
    $this->form_validation->set_rules('stok','Stok','required|numeric');
    $this->form_validation->set_rules('keterangan','Keterangan','required');

    $kode_barang  = $this->input->post('kode_barang',TRUE);
    $nama_barang  = $this->input->post('nama_barang',TRUE);
    $satuan       = $this->input->post('satuan',TRUE);
    $stok         = $this->input->post('stok',TRUE);
    $keterangan   = $this->input->post('keterangan',TRUE);

    if($this->form_validation->run() == TRUE)
    {
      $IDBarangExist = $this->M_barang->CheckIDbarangExist($kode_barang);
      if($IDBarangExist->num_rows() > 0){

        $data['list_satuan'] = $this->M_admin->select('tb_satuan');
        $this->session->set_flashdata('msg_warn','ID Barang Sudah Terdaftar');
        $this->load->view('admin/form_barang/form_insert',$data);  

      }else{

        $data = array(
              'id_barang'    => $kode_barang,
              'nama_barang'  => $nama_barang,
              'satuan'       => $satuan,
              'stok'         => $stok,
              'keterangan'   => $keterangan
        );

        $this->M_admin->insert('tb_list_barang',$data);

        $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Ditambahkan');
        redirect(base_url('admin/form_barang'));
      }

    }else {
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('admin/form_barang/form_insert',$data);
    }
  }

  public function update_list_barang(){
    $id_barang = $this->uri->segment(3);
    $where = array('id_barang' => $id_barang);
    $data['data_list_barang'] = $this->M_admin->get_data('tb_list_barang',$where);
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('admin/form_barang/form_update',$data);
  }

  public function proses_update_list_barang(){
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
    $this->form_validation->set_rules('satuan','Satuan','required');
    $this->form_validation->set_rules('nama_barang','Nama Barang','required');
    $this->form_validation->set_rules('stok','Stok','required|numeric');
    $this->form_validation->set_rules('keterangan','Keterangan','required');

    $kode_barang  = $this->input->post('kode_barang',TRUE);
    $nama_barang  = $this->input->post('nama_barang',TRUE);
    $satuan       = $this->input->post('satuan',TRUE);
    $stok         = $this->input->post('stok',TRUE);
    $keterangan   = $this->input->post('keterangan',TRUE);

    if($this->form_validation->run() == TRUE)
    {
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $this->session->set_flashdata('msg_warn','ID Barang Sudah Terdaftar');
      $this->load->view('admin/form_barang/form_insert',$data);  
    
      $where = array('id_barang' => $kode_barang);
      $data = array(
            'id_barang'    => $kode_barang,
            'nama_barang'  => $nama_barang,
            'satuan'       => $satuan,
            'stok'         => $stok,
            'keterangan'   => $keterangan
       );
      $this->M_admin->update('tb_list_barang',$data,$where);
      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Diupdate');
      redirect(base_url('admin/barang'));
    }else {
      $where = array('id_barang' => $kode_barang);
      $data['data_list_barang'] = $this->M_admin->get_data('tb_list_barang',$where);
      
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $this->load->view('admin/form_barang/form_update',$data);
    }
  }

  public function proses_delete_list_barang($id_barang){
    $where = array('id_barang' => $id_barang);
    $this->M_admin->delete('tb_list_barang',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(base_url('admin/barang'));
  }



  ####################################
          // DATA BARANG
  ####################################



  ####################################
              // Employee
  ####################################
  public function employee()
  {
    $data['list_employee'] = $this->M_admin->select('tb_employee');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $this->session->set_userdata($data);
    $this->load->view('admin/employee',$data);
  }

  public function form_employee()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $this->session->set_userdata($data);
    $this->load->view('admin/form_employee/form_insert',$data);
  }

  public function update_employee()
  {
    $id = $this->uri->segment(3);
    $where = array('id_employee' => $id);
    $data['token_generate'] = $this->token_generate();
    $data['list_data_employee'] = $this->M_admin->get_data('tb_employee',$where);
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->session->set_userdata($data);
    $this->load->view('admin/form_employee/form_update',$data);
  }

  public function proses_delete_employee()
  {
    $id = $this->uri->segment(3);
    $where = array('id_employee' => $id);
    $this->M_admin->delete('tb_employee',$where);
    $this->session->set_flashdata('msg_berhasil','Data Employee Behasil Di Delete');
    redirect(base_url('admin/employee'));

  }

  public function proses_tambah_employee()
  {
    $this->form_validation->set_rules('id_employee','ID Employee','required');
    $this->form_validation->set_rules('nama','Nama Lengkap','required');
    $this->form_validation->set_rules('alamat','Alamat','required');
    $this->form_validation->set_rules('username','Username','required');
    $this->form_validation->set_rules('password','Password','required');
    $this->form_validation->set_rules('email','Email','required|valid_email');
    $this->form_validation->set_rules('no_telp','No Telepon','required');
    $this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
    $this->form_validation->set_rules('role','Role','required');

    $id_employee   = $this->input->post('id_employee',TRUE);
    $nama          = $this->input->post('nama',TRUE);
    $username      = $this->input->post('username',TRUE);
    $alamat        = $this->input->post('alamat',TRUE);
    $email         = $this->input->post('email',TRUE);
    $password      = $this->input->post('password',TRUE);
    $jenis_kelamin = $this->input->post('jenis_kelamin',TRUE);
    $no_telp       = $this->input->post('no_telp',TRUE);
    $role          = $this->input->post('role',TRUE);
    
    if($this->form_validation->run() == TRUE)
    {
      $IDemployeeExist = $this->M_employee->CheckIDemployeeExist($id_employee);
      if($IDemployeeExist->num_rows() == 0)
      {
        $data = array(
              'id_employee'   => $id_employee, 
              'nama'          => $nama,
              'alamat'        => $alamat,
              'username'      => $username,
              'password'      => $password,
              'email'         => $email,
              'no_telp'       => $no_telp,
              'jenis_kelamin' => $jenis_kelamin,
              'role'          => $role
        );
        $this->M_admin->insert('tb_employee',$data);

        $this->session->set_flashdata('msg_berhasil','User Berhasil Ditambahkan');
        redirect(base_url('admin/form_employee'));
        }else{
          $this->session->set_flashdata('msg_warn','User Telah Terdaftar');
          $this->load->view('admin/form_employee/form_insert');
        }
      }else {
        $this->load->view('admin/form_employee/form_insert');
    }
  }

  public function proses_update_employee()
  {
    $this->form_validation->set_rules('nama','nama','required');
    $this->form_validation->set_rules('alamat','alamat','required');
    $this->form_validation->set_rules('username','username','required');
    $this->form_validation->set_rules('password','password','required');
    $this->form_validation->set_rules('email','email','required|valid_email');
    $this->form_validation->set_rules('no_telp','no_telp','required');
    $this->form_validation->set_rules('jenis_kelamin','jenis_kelamin','required');
    $this->form_validation->set_rules('role','role','required');

    $id_employee   = $this->input->post('id_employee',TRUE);
    if($this->form_validation->run() == TRUE)
    {
      $nama          = $this->input->post('nama',TRUE);
      $alamat        = $this->input->post('alamat',TRUE);
      $username      = $this->input->post('username',TRUE);
      $password      = $this->input->post('password',TRUE);
      $email         = $this->input->post('email',TRUE);
      $no_telp       = $this->input->post('no_telp',TRUE);
      $jenis_kelamin = $this->input->post('jenis_kelamin',TRUE);
      $role          = $this->input->post('role',TRUE);

        $where = array('id_employee' => $id_employee);
        $data = array(
          'nama'          => $nama,
          'alamat'        => $alamat,
          'username'      => $username,
          'password'      => $password,
          'email'         => $email,
          'no_telp'       => $no_telp,
          'jenis_kelamin' => $jenis_kelamin,
          'role'          => $role
        );
        $this->M_admin->update('tb_employee',$data,$where);
        $this->session->set_flashdata('msg_berhasil','Data User Berhasil Diupdate');
        redirect(base_url('admin/employee'));
       
    }else{
        $where = array('id_employee' => $id_employee);
        $data['list_data_employee'] = $this->M_admin->get_data('tb_employee',$where);
        $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
        $this->load->view('admin/form_employee/form_update',$data);
    }
  }


  ####################################
           // End Employee
  ####################################





  ####################################
        // DATA BARANG MASUK
  ####################################

  public function form_barangmasuk()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['list_barang'] = $this->M_admin->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('admin/form_barangmasuk/form_insert',$data);
  }

  public function tabel_barangmasuk()
  {
    $data = array(
              'list_data' => $this->M_admin->tabel_barangmasuk(),
              'list_barang' => $this->M_admin->select('tb_list_barang'),
              'stokBarang' => $this->M_barang->select('tb_list_barang')
            );
    $this->load->view('admin/tabel/tabel_barangmasuk',$data);
  }

  public function update_barang($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_update_header'] = $this->M_admin->get_data('tb_barang_masuk',$where);
		$data['data_barang_update_header_detail'] = $this->M_admin->get_data('tb_barang_masuk_detail',$where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['list_barang'] = $this->M_admin->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('admin/form_barangmasuk/form_update',$data);
  }

  public function delete_barang($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $this->M_admin->delete('tb_barang_masuk',$where);
    $this->M_admin->delete('tb_barang_masuk_detail',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(base_url('admin/tabel_barangmasuk'));
  }

  public function detail_barang_masuk($id_transaksi){
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_masuk_header'] = $this->M_admin->get_data('tb_barang_masuk',$where);
		$data['data_barang_masuk_detail'] = $this->M_admin->get_data('tb_barang_masuk_detail',$where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_barangmasuk/form_detail',$data);
  }


  public function proses_databarang_masuk_insert()
  {
    $this->form_validation->set_rules('lokasi','Lokasi','required');
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
    $this->form_validation->set_rules('nama_barang','Nama Barang','required');
    $this->form_validation->set_rules('jumlah','Jumlah','required');
    $this->form_validation->set_rules('satuan','Satuan','required');
    $this->form_validation->set_rules('tanggal','Tanggal Masuk','required');
    
    if($this->input->server('REQUEST_METHOD') === 'POST')
    {
      $id_transaksi = $this->input->post('id_transaksi',TRUE);
      $tanggal      = $this->input->post('tanggal',TRUE);
      $notes        = $this->input->post('notes',TRUE);
      $kode_barang  = $this->input->post('kode_barang',TRUE);
      $lokasi       = $this->input->post('lokasi',TRUE);
      $jumlah       = $this->input->post('jumlah',TRUE);
      $nama_barang  = $this->input->post('nama_barang',TRUE);
      $satuan       = $this->input->post('satuan',TRUE);
      $user         = $_SESSION['name'];

      $data = array(
            'id_transaksi' => $id_transaksi,
            'tanggal'      => $tanggal,
            'notes'        => $notes,
            'lokasi'       => $lokasi,
            'user'         => $user
      );
      $this->M_admin->insert('tb_barang_masuk',$data);

      $dataDetail = array(
        'id_transaksi' => $id_transaksi,
        'lokasi'       => $lokasi,
        'id_barang'    => $kode_barang,
        'nama_barang'  => $nama_barang,
        'satuan'       => $satuan,
        'jumlah'       => $jumlah
      );

      foreach ($dataDetail['nama_barang'] as $key => $item) {
				$detail = [
					'id_transaksi' => $id_transaksi,
          'id_barang'    => $dataDetail['id_barang'][$key],
					'nama_barang'  => $item,
          'satuan'       => $dataDetail['satuan'][$key],
					'jumlah'       => $dataDetail['jumlah'][$key]
				];

				$this->db->insert('tb_barang_masuk_detail',$detail);
			}

      foreach ($dataDetail['id_barang'] as $key => $value) {
        $CheckStockBarang = $this->M_barang->CheckIDbarangExist($value);
        if($CheckStockBarang->num_rows() > 0){
          $StockSisa = $CheckStockBarang->row_array();
          if($StockSisa['stok'] > 0){
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Tersedia');
            $this->M_admin->update('tb_list_barang',$data,$where);
          }else{
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Habis');
            $this->M_admin->update('tb_list_barang',$data,$where);
          }
        }
      }
      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Ditambahkan');
      redirect(base_url('admin/form_barangmasuk'));
    }else {
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $data['list_barang'] = $this->M_admin->select('tb_list_barang');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('admin/form_barangmasuk/form_insert',$data);
    }
  }

  public function proses_databarang_masuk_update()
  {
    $this->form_validation->set_rules('lokasi','Lokasi','required');
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
    $this->form_validation->set_rules('nama_barang','Nama Barang','required');
    $this->form_validation->set_rules('jumlah','Jumlah','required');

    $id_transaksi = $this->input->post('id_transaksi',TRUE);
    if($this->input->server('REQUEST_METHOD') === 'POST')
    {
      $tanggal      = $this->input->post('tanggal',TRUE);
      $lokasi       = $this->input->post('lokasi',TRUE);
      $kode_barang  = $this->input->post('kode_barang',TRUE);
      $nama_barang  = $this->input->post('nama_barang',TRUE);
      $jumlah       = $this->input->post('jumlah',TRUE);
      $satuan       = $this->input->post('satuan',TRUE);
      $notes        = $this->input->post('notes',TRUE);
      $user         = $_SESSION['name'];
      $jumlah_barang_awal = $this->db->SelectJumlahBarang($kode_barang);

      $where = array('id_transaksi' => $id_transaksi);
      $data = array(
            'id_transaksi' => $id_transaksi,
            'tanggal'      => $tanggal,
            'notes'        => $notes,
            'user'         => $user
      );

      $this->M_admin->update('tb_barang_masuk',$data,$where);

      $dataDetail = array(
        'id_transaksi' => $id_transaksi,
        'lokasi'       => $lokasi,
        'id_barang'    => $kode_barang,
        'nama_barang'  => $nama_barang,
        'satuan'       => $satuan,
        'jumlah'       => $jumlah
      );
      $this->db->where('id_transaksi',$id_transaksi);
      $this->db->delete('tb_barang_masuk_detail');
      foreach ($dataDetail['nama_barang'] as $key => $item) {
				$detail = [
					'id_transaksi' => $id_transaksi,
          'lokasi'       => $dataDetail['lokasi'][$key],
          'id_barang'    => $dataDetail['id_barang'][$key],
					'nama_barang'  => $item,
          'satuan'       => $dataDetail['satuan'][$key],
					'jumlah'       => $dataDetail['jumlah'][$key]
				];
				$this->M_admin->insert('tb_barang_masuk_detail',$detail);
			}

      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Diupdate');
      redirect(base_url('admin/tabel_barangmasuk'));
    }else{
      $where = array('id_transaksi' => $id_transaksi);
      $data['data_barang_update'] = $this->M_admin->get_data('tb_barang_masuk',$where);
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $data['list_barang'] = $this->M_admin->select('tb_list_barang');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('admin/form_barangmasuk/form_update',$data);
    }
  }
  ####################################
      // END DATA BARANG MASUK
  ####################################


  ####################################
              // SATUAN
  ####################################

  public function form_satuan()
  {
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_satuan/form_insert',$data);
  }

  public function tabel_satuan()
  {
    $data['list_data'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/tabel/tabel_satuan',$data);
  }

  public function update_satuan()
  {
    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);
    $data['data_satuan'] = $this->M_admin->get_data('tb_satuan',$where);
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_satuan/form_update',$data);
  }

  public function delete_satuan()
  {
    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);
    $this->M_admin->delete('tb_satuan',$where);
    $this->session->set_flashdata('msg_berhasil','Data satuan Berhasil Dihapus');
    redirect(base_url('admin/tabel_satuan'));
  }

  public function proses_satuan_insert()
  {
    $this->form_validation->set_rules('kode_satuan','Kode Satuan','trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan','Nama Satuan','trim|required|max_length[100]');

    if($this->form_validation->run() ==  TRUE)
    {
      $kode_satuan = $this->input->post('kode_satuan' ,TRUE);
      $nama_satuan = $this->input->post('nama_satuan' ,TRUE);

      $data = array(
            'kode_satuan' => $kode_satuan,
            'nama_satuan' => $nama_satuan
      );
      $this->M_admin->insert('tb_satuan',$data);

      $this->session->set_flashdata('msg_berhasil','Data satuan Berhasil Ditambahkan');
      redirect(base_url('admin/form_satuan'));
    }else {
      $this->load->view('admin/form_satuan/form_insert');
    }
  }

  public function proses_satuan_update()
  {
    $this->form_validation->set_rules('kode_satuan','Kode Satuan','trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan','Nama Satuan','trim|required|max_length[100]');

    $id_satuan   = $this->input->post('id_satuan' ,TRUE);
    if($this->form_validation->run() ==  TRUE)
    {
      
      $kode_satuan = $this->input->post('kode_satuan' ,TRUE);
      $nama_satuan = $this->input->post('nama_satuan' ,TRUE);

      $where = array(
            'id_satuan' => $id_satuan
      );

      $data = array(
            'kode_satuan' => $kode_satuan,
            'nama_satuan' => $nama_satuan
      );
      $this->M_admin->update('tb_satuan',$data,$where);

      $this->session->set_flashdata('msg_berhasil','Data satuan Berhasil Di Update');
      redirect(base_url('admin/tabel_satuan'));
    }else {
      $where = array('id_satuan' => $id_satuan);
      $data['data_satuan'] = $this->M_admin->get_data('tb_satuan',$where);
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('admin/form_satuan/form_update',$data);
    }
  }

  ####################################
            // END SATUAN
  ####################################


  ####################################
     // DATA MASUK KE DATA KELUAR
  ####################################

  public function form_barangkeluar()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['list_barang'] = $this->M_admin->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('admin/form_barangkeluar/form_insert',$data);
  }

  public function barang_keluar()
  {
    $uri = $this->uri->segment(3);
    $where = array( 'id_transaksi' => $uri);
    $data['data_barang_update_header'] = $this->M_admin->get_data('tb_barang_masuk',$where);
		$data['data_barang_update_header_detail'] = $this->M_admin->get_data('tb_barang_masuk_detail',$where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/perpindahan_barang/form_update',$data);
  }

  public function proses_data_keluar()
  {
    $this->form_validation->set_rules('tanggal_keluar','Tanggal Keluar','trim|required');
    $id_transaksi   = $this->input->post('id_transaksi',TRUE);
    if($this->input->server('REQUEST_METHOD') === 'POST')
    {
      $tanggal_masuk  = $this->input->post('tanggal_masuk',TRUE);
      $tanggal_keluar = $this->input->post('tanggal',TRUE);
      $lokasi         = $this->input->post('lokasi',TRUE);
      $kode_barang    = $this->input->post('kode_barang',TRUE);
      $nama_barang    = $this->input->post('nama_barang',TRUE);
      $satuan         = $this->input->post('satuan',TRUE);
      $jumlah         = $this->input->post('jumlah',TRUE);
      $notes          = $this->input->post('notes',TRUE);
      $user           = $_SESSION['name'];

      $where = array( 'id_transaksi' => $id_transaksi);
      $data = array(
              'id_transaksi' => $id_transaksi,
              'notes' => $notes,
              'tanggal_keluar' => $tanggal_keluar,
              'lokasi' => $lokasi,
              'user' => $user
              
      );
      $this->M_admin->insert('tb_barang_keluar',$data);

      $dataDetail = array(
        'id_transaksi' => $id_transaksi,
        'tanggal_masuk' => $tanggal_masuk,
        'tanggal_keluar' => $tanggal_keluar,
        'id_barang'    => $kode_barang,
        'nama_barang'  => $nama_barang,
        'satuan'       => $satuan,
        'jumlah'       => $jumlah
      );

      foreach ($dataDetail['nama_barang'] as $key => $item) {
        $detail = [
          'id_transaksi'   => $id_transaksi,
          'id_barang'      => $dataDetail['id_barang'][$key],
          'nama_barang'    => $item,
          'satuan'         => $dataDetail['satuan'][$key],
          'jumlah'         => $dataDetail['jumlah'][$key]
        ];
  
        $this->db->insert('tb_barang_keluar_detail',$detail);
      }
      
      foreach ($dataDetail['id_barang'] as $key => $value) {
        $CheckStockBarang = $this->M_barang->CheckIDbarangExist($value);
        if($CheckStockBarang->num_rows() > 0){
          $StockSisa = $CheckStockBarang->row_array();
          if($StockSisa['stok'] > 0){
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Tersedia');
            $this->M_admin->update('tb_list_barang',$data,$where);
          }else{
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Habis');
            $this->M_admin->update('tb_list_barang',$data,$where);
          }
        }
      }
        $this->session->set_flashdata('msg_berhasil_keluar','Data Berhasil Keluar');
        redirect(base_url('admin/tabel_barangkeluar'));
    }else {
      $where = array( 'id_transaksi' => $id_transaksi);
      $data['list_data_keluar'] = $this->M_admin->get_data('tb_barang_masuk',$where);
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('admin/form_barangkeluar/form_insert',$data);
    }

  }
  ####################################
    // END DATA MASUK KE DATA KELUAR
  ####################################


  ####################################
        // DATA BARANG KELUAR
  ####################################

  public function tabel_barangkeluar()
  {
    $data['list_data'] = $this->M_admin->tabel_barangkeluar();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/tabel/tabel_barangkeluar',$data);
  }

  public function detail_barang_keluar($id_transaksi){
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_keluar_header'] = $this->M_admin->get_data('tb_barang_keluar',$where);
		$data['data_barang_keluar_detail'] = $this->M_admin->get_data('tb_barang_keluar_detail',$where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_barangkeluar/form_detail',$data);
  }
  public function akumulasi_barang_keluar()
  {
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_akumulasi/barang_keluar',$data);
  }

  public function generate_akumulasi_barang_keluar()
  {
    $tahun      = $this->input->post('tahun',TRUE);
    $view_url = 'report/akumulasi_stock_barangKeluar/' .$tahun; 
    redirect($view_url);
  }
  public function akumulasi_barang_masuk()
  {
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('admin/form_akumulasi/barang_masuk',$data);
  }

  public function generate_akumulasi_barang_masuk()
  {
    $tahun      = $this->input->post('tahun',TRUE);
    $view_url = 'report/akumulasi_stock_barangmasuk/' .$tahun; 
    redirect($view_url);
  }
  public function delete_barang_keluar($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $this->M_admin->delete('tb_barang_keluar',$where);
    $this->M_admin->delete('tb_barang_keluar_detail',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(base_url('admin/tabel_barangkeluar'));
  }


  ####################################
        // RIWAYAT PERALATAN
  ####################################
  public function riwayat_peralatan()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['list_riwayat_peralatan'] = $this->M_admin->riwayat_peralatan();
    $data['stokBarang'] = $this->M_admin->select('tb_list_barang');
    $data['token_generate'] = $this->token_generate();
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/riwayat_peralatan',$data);
  }

  public function form_riwayat_peralatan_insert()
  {
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('admin/form_riwayat_peralatan/form_insert',$data);
  }

  public function proses_riwayat_peralatan_insert()
  {
    $nama_peralatan      = $this->input->post('nama_perlatan',TRUE);
    $kategori_peralatan  = $this->input->post('kategori_peralatan',TRUE);
    $merk                = $this->input->post('merk',TRUE);
    $type                = $this->input->post('type',TRUE);
    $daya                = $this->input->post('daya',TRUE);
    $frequency           = $this->input->post('frequency',TRUE);
    $volume              = $this->input->post('volume',TRUE);
    $satuan              = $this->input->post('satuan',TRUE);
    $kondisi             = $this->input->post('kondisi',TRUE);
    $tanggal_input       = $this->input->post('tanggal_input',TRUE);

    if($this->input->server('REQUEST_METHOD') === 'POST'){
      $data = array(
        'nama_peralatan'       => $nama_peralatan, 
        'kategori_peralatan'  => $kategori_peralatan,
        'merk'                => $merk,
        'type'                => $type,
        'daya'                => $daya,
        'frequency'           => $frequency,
        'volume'              => $volume,
        'id_satuan'           => $satuan,
        'kondisi'             => $kondisi,
        'tanggal_input'       => $tanggal_input
      );
      $this->M_admin->insert('tb_riwayat_peralatan',$data);
      $this->session->set_flashdata('msg_berhasil','Data Riwayat Berhasil Ditambahkan');
      redirect(base_url('admin/riwayat_peralatan')); 
    }else{
      $this->load->view('admin/form_riwayat_peralatan/form_insert'); 
    }
  }

  public function form_riwayat_peralatan_update()
  {
    $id_riwayat_peralatan = $this->uri->segment(3);
    $where = array('id_riwayat_peralatan' => $id_riwayat_peralatan);
    $data['list_riwayat_peralatan'] = $this->M_admin->get_data('tb_riwayat_peralatan',$where);
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('admin/form_riwayat_peralatan/form_update',$data);
  }

  public function proses_riwayat_peralatan_update()
  {
    $id_riwayat_peralatan = $this->input->post('id_riwayat_peralatan',TRUE);
    $nama_peralatan       = $this->input->post('nama_perlatan',TRUE);
    $kategori_peralatan   = $this->input->post('kategori_peralatan',TRUE);
    $merk                 = $this->input->post('merk',TRUE);
    $type                 = $this->input->post('type',TRUE);
    $daya                 = $this->input->post('daya',TRUE);
    $frequency            = $this->input->post('frequency',TRUE);
    $volume               = $this->input->post('volume',TRUE);
    $satuan               = $this->input->post('satuan',TRUE);
    $kondisi              = $this->input->post('kondisi',TRUE);
    $tanggal_input        = $this->input->post('tanggal_input',TRUE);

    if($this->input->server('REQUEST_METHOD') === 'POST'){
      $where = array('id_riwayat_peralatan' => $id_riwayat_peralatan);
      $data  = array(
        'nama_peralatan'       => $nama_peralatan, 
        'kategori_peralatan'   => $kategori_peralatan,
        'merk'                 => $merk,
        'type'                 => $type,
        'daya'                 => $daya,
        'frequency'            => $frequency,
        'volume'               => $volume,
        'id_satuan'            => $satuan,
        'kondisi'              => $kondisi,
        'tanggal_input'        => $tanggal_input
      );
      $this->M_admin->update('tb_riwayat_peralatan',$data,$where);
      $this->session->set_flashdata('msg_berhasil','Data Riwayat Berhasil DiUpdate');
      redirect(base_url('admin/riwayat_peralatan')); 
    }else{
      $where = array('id_riwayat_peralatan' => $id_riwayat_peralatan);
      $data['list_riwayat_peralatan'] = $this->M_admin->get_data('tb_riwayat_peralatan',$where);
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $this->load->view('admin/form_riwayat_peralatan/form_update',$data);
    }
  }

  public function delete_riwayat_peralatan()
  {
    $id_riwayat_peralatan = $this->uri->segment(3);
    $where = array('id_riwayat_peralatan' => $id_riwayat_peralatan);
    $this->M_admin->delete('tb_riwayat_peralatan',$where);
    $this->session->set_flashdata('msg_berhasil','Data Riwayat Peralatan Berhasil Dihapus');
    redirect(base_url('admin/riwayat_peralatan'));
  }
}
?>
