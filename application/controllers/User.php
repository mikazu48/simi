<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('M_user');
    $this->load->model('M_admin');
    $this->load->model('M_barang');
  }

  public function index()
  {
    if($this->session->userdata('status') == 'login' && $this->session->userdata('role') == 'user')
    {
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      // $this->load->view('user/templates/header.php');
      $this->load->view('user/V_user',$data);
      // $this->load->view('user/templates/footer.php');
    }else {
      $this->load->view('login/login');
    }
  }

  public function token_generate()
  {
    return $tokens = md5(uniqid(rand(), true));
  }

  

  public function signout()
  {
      session_destroy();
      redirect(base_url());
  }

  ####################################
        // DATA BARANG MASUK
  ####################################

  public function form_barangmasuk()
  {
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['list_barang'] = $this->M_admin->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_admin->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('user/form_barangmasuk/form_insert',$data);
  }

  public function tabel_barangmasuk()
  {
    $data = array(
      'list_data' => $this->M_user->tabel_barangmasuk(),
      'list_barang' => $this->M_user->select('tb_list_barang'),
      'stokBarang' => $this->M_barang->select('tb_list_barang')
    );
    $this->load->view('user/tabel/tabel_barangmasuk',$data);
  }

  public function proses_databarang_masuk_insert(){

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
      $this->M_user->insert('tb_barang_masuk',$data);

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
            $this->M_user->update('tb_list_barang',$data,$where);
          }else{
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Habis');
            $this->M_user->update('tb_list_barang',$data,$where);
          }
        }
      }
      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Ditambahkan');
      redirect(base_url('user/tabel_barangmasuk'));
    }else {
      $data['list_satuan'] = $this->M_user->select('tb_satuan');
      $data['list_barang'] = $this->M_user->select('tb_list_barang');
      $data['stokBarang'] = $this->M_user->select('tb_list_barang');
      $this->load->view('user/form_barangmasuk/form_insert',$data);
    }
  }

  public function detail_barang_masuk($id_transaksi){
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_masuk_header'] = $this->M_user->get_data('tb_barang_masuk',$where);
		$data['data_barang_masuk_detail'] = $this->M_user->get_data('tb_barang_masuk_detail',$where);
    $data['list_satuan'] = $this->M_user->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('user/form_barangmasuk/form_detail',$data);
  }


  public function delete_barang($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $this->M_user->delete('tb_barang_masuk',$where);
    $this->M_user->delete('tb_barang_masuk_detail',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(base_url('user/tabel/tabel_barangmasuk'));
  }

  ####################################
        // DATA BARANG KELUAR
  ####################################

  public function form_barangkeluar()
  {
    $data['list_satuan'] = $this->M_user->select('tb_satuan');
    $data['list_barang'] = $this->M_user->select('tb_list_barang');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_user->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->load->view('user/form_barangkeluar/form_insert',$data);
  }


  public function tabel_barangkeluar()
  {
    $data['list_data'] = $this->M_user->tabel_barangkeluar();
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('user/tabel/tabel_barangkeluar',$data);
  }

  public function detail_barang_keluar($id_transaksi){
    $where = array('id_transaksi' => $id_transaksi);
    $data['data_barang_keluar_header'] = $this->M_user->get_data('tb_barang_keluar',$where);
		$data['data_barang_keluar_detail'] = $this->M_user->get_data('tb_barang_keluar_detail',$where);
    $data['list_satuan'] = $this->M_user->select('tb_satuan');
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $this->load->view('user/form_barangkeluar/form_detail',$data);
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
      $this->M_user->insert('tb_barang_keluar',$data);

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
            $this->M_user->update('tb_list_barang',$data,$where);
          }else{
            $where = array('id_barang' => $value);
            $data = array('keterangan' => 'Habis');
            $this->M_user->update('tb_list_barang',$data,$where);
          }
        }
      }
        $this->session->set_flashdata('msg_berhasil_keluar','Data Berhasil Keluar');
        redirect(base_url('user/tabel_barangkeluar'));
    }else {
      $where = array( 'id_transaksi' => $id_transaksi);
      $data['list_data_keluar'] = $this->M_user->get_data('tb_barang_masuk',$where);
      $data['list_satuan'] = $this->M_user->select('tb_satuan');
      $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
      $this->load->view('user/form_barangkeluar/form_insert',$data);
    }

  }

  public function delete_barang_keluar($id_transaksi)
  {
    $where = array('id_transaksi' => $id_transaksi);
    $this->M_user->delete('tb_barang_keluar',$where);
    $this->M_user->delete('tb_barang_keluar_detail',$where);
    $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
    redirect(base_url('user/tabel_barangkeluar'));
  }

  ####################################
              // Profile
  ####################################

  public function profile()
  {
    $data['token_generate'] = $this->token_generate();
    $data['stokBarang'] = $this->M_barang->select('tb_list_barang');
    $data['avatar'] = $this->M_user->get_data_gambar('tb_upload_gambar_user',$this->session->userdata('name'));
    $this->session->set_userdata($data);
    $this->load->view('user/profile',$data);
  }

  private function hash_password($password)
  {
    return password_hash($password,PASSWORD_DEFAULT);
  }

  public function setting()
  {
      $data['token_generate'] = $this->token_generate();
      $this->session->set_userdata($data);

      $this->load->view('user/templates/header.php');
      $this->load->view('user/setting',$data);
      $this->load->view('user/templates/footer.php');
  }

  public function proses_new_password()
  {
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

        $this->M_user->update_password('user',$where,$data);

        $this->session->set_flashdata('msg_berhasil','Password Telah Diganti');
        redirect(base_url('user/profile'));
      }
    }else {
      $this->load->view('user/profile');
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
    $this->load->view('user/profile',$data);
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
        redirect(base_url('user/profile'));
      }
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
    $this->load->view('user/riwayat_peralatan',$data);
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
      redirect(base_url('user/riwayat_peralatan')); 
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
      redirect(base_url('user/riwayat_peralatan')); 
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
    redirect(base_url('user/riwayat_peralatan'));
  }

}
?>
