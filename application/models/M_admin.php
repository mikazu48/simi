<?php

class M_admin extends CI_Model
{

  public function insert($tabel,$data)
  {
    $this->db->insert($tabel,$data);
  }

  public function select($tabel)
  {
    $query = $this->db->get($tabel);
    return $query->result();
  }

  public function cek_jumlah($tabel,$id_transaksi)
  {
    return  $this->db->select('*')
               ->from($tabel)
               ->where('id_transaksi',$id_transaksi)
               ->get();

  }

  public function get_data_array($tabel,$id_transaksi)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where($id_transaksi)
                      ->get();
    return $query->result_array();
  }

  public function get_data($tabel,$id_transaksi)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where($id_transaksi)
                      ->get();
    return $query->result();
  }

  public function update($tabel,$data,$where)
  {
    $this->db->where($where);
    $this->db->update($tabel,$data);
  }

  public function delete($tabel,$where)
  {
    $this->db->where($where);
    $this->db->delete($tabel);
  }

  public function mengurangi($tabel,$id_barang,$jumlah)
  {
    $jumlah_awal = $this->db->select('stok')
                            ->from('tb_list_barang')
                            ->where('id_barang',$id_barang)
                            ->get()
                            ->result();
    $jumlah_akhir = $jumlah_awal - $jumlah;
    $this->db->set("jumlah","$jumlah_awal - $jumlah_akhir");
    $this->db->where('id_barang',$id_barang);
    $this->db->update('tb_list_barang');
  }

  public function menambah($tabel,$id_barang,$jumlah)
  {
    $this->db->set("jumlah","jumlah + $jumlah");
    $this->db->where('id_barang',$id_barang);
    $this->db->update('tb_list_barang');
  }

  public function update_password($tabel,$where,$data)
  {
    $this->db->where($where);
    $this->db->update($tabel,$data);
  }

  public function get_data_gambar($tabel,$username)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where('username_user',$username)
                      ->get();
    return $query->result();
  }

  // public function update_stok_barang_tambah($jumlah,$id_barang){
  //   $query = $this->db->query("UPDATE tb_list_barang SET stok = stok + $jumlah WHERE id_barang = $id_barang")
  // }

  public function sum($tabel,$field)
  {
    $query = $this->db->select_sum($field)
                      ->from($tabel)
                      ->get();
    return $query->result();
  }

  public function numrows($tabel)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->get();
    return $query->num_rows();
  }

  public function kecuali($tabel,$username)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where_not_in('username',$username)
                      ->get();
    return $query->result();
  } 

  public function SelectJumlahBarang($id_barang){
    return $this->db->select('jumlah')
                    ->from('tb_list_barang')
                    ->get()
                    ->result();
  }

  public function SelectDataBarang(){
    $this->db->order_by('tb_list_barang.id_barang', 'ASC');
    return $this->db->from('tb_barang_masuk')
                    ->join('tb_list_barang','tb_barang_masuk.id_barang = tb_list_barang.id_barang')
                    ->get()
                    ->result();
  }

  public function tabel_barangmasuk(){
    $this->db->order_by('tb_barang_masuk.id_transaksi','ASC');
    return $this->db->from('tb_barang_masuk')
                    ->join('tb_barang_masuk_detail','tb_barang_masuk.id_transaksi = tb_barang_masuk_detail.id_transaksi')
                    ->group_by('tb_barang_masuk.id_transaksi')
                    ->get()
                    ->result();
  }
  
  public function tabel_barangkeluar(){
    $this->db->order_by('tb_barang_keluar.id_transaksi','ASC');
    return $this->db->from('tb_barang_keluar')
                    ->join('tb_barang_keluar_detail','tb_barang_keluar.id_transaksi = tb_barang_keluar_detail.id_transaksi')
                    ->group_by('tb_barang_keluar.id_transaksi')
                    ->get()
                    ->result();
  }

  public function tabel_barangkeluar_detail($id_transaksi){
    $this->db->order_by('tb_barang_keluar.id_transaksi','ASC');
    return $this->db->from('tb_barang_keluar')
                    ->join('tb_barang_keluar_detail','tb_barang_keluar.id_transaksi = tb_barang_keluar_detail.id_transaksi')
                    ->where('tb_barang_keluar_detail.id_transaksi',$id_transaksi)
                    ->get()
                    ->result();
  }

  public function update_barangmasuk($id_transaksi){
    
    $this->db->order_by('tb_barang_masuk.id_transaksi','ASC');
    return $this->db->from('tb_barang_masuk')
                    ->join('tb_barang_masuk_detail','tb_barang_masuk.id_transaksi = tb_barang_masuk_detail.id_transaksi')
                    ->where('tb_barang_masuk.id_transaksi',$id_transaksi)
                    ->get()
                    ->result();
  }

  public function report_data_barang_masuk($id_transaksi,$tanggal){
    $this->db->order_by('tb_barang_masuk.id_transaksi','ASC');
    return $this->db->from('tb_barang_masuk')
                    ->join('tb_barang_masuk_detail','tb_barang_masuk.id_transaksi = tb_barang_masuk_detail.id_transaksi')
                    ->where('tb_barang_masuk.id_transaksi',$id_transaksi)
                    ->where('tb_barang_masuk.tanggal',$tanggal)
                    ->get()
                    ->result();
  }

  public function report_data_barang_keluar($id_transaksi,$tanggal){
    $this->db->order_by('tb_barang_keluar.id_transaksi','ASC');
    return $this->db->from('tb_barang_keluar')
                    ->join('tb_barang_keluar_detail','tb_barang_keluar.id_transaksi = tb_barang_keluar_detail.id_transaksi')
                    ->where('tb_barang_keluar.id_transaksi',$id_transaksi)
                    ->where('tb_barang_keluar.tanggal_keluar',$tanggal)
                    ->get()
                    ->result();
  }

  public function report_akumulasi_barang_keluar($tahun){
    $query = "select '$tahun' as 'tahun',A.id_barang,A.nama_barang,A.satuan,A.stok,
    (
        select
        case when 
        SUM(B.jumlah) is not null then SUM(B.jumlah)
        else 0 end as 'jumlah'
        from tb_barang_keluar_detail B 
        inner join tb_barang_keluar C on 
        B.id_transaksi = C.id_transaksi AND YEAR(C.tanggal_keluar) = $tahun
        where B.id_barang = A.id_barang 
    ) as 'akumulasi_tahun' from tb_list_barang A";
    return $this->db->query($query)->result();
  }

  public function report_akumulasi_barang_masuk($tahun){
    $query = "select '$tahun' as 'tahun',A.id_barang,A.nama_barang,A.satuan,A.stok,
    (
        select
        case when 
        SUM(B.jumlah) is not null then SUM(B.jumlah)
        else 0 end as 'jumlah'
        from tb_barang_masuk_detail B 
        inner join tb_barang_masuk C on 
        B.id_transaksi = C.id_transaksi AND YEAR(C.tanggal) = $tahun
        where B.id_barang = A.id_barang 
    ) as 'akumulasi_tahun' from tb_list_barang A";
    return $this->db->query($query)->result();
  }
  public function riwayat_peralatan(){
    $this->db->order_by('tb_riwayat_peralatan.id_riwayat_peralatan','ASC');
    return $this->db->from('tb_riwayat_peralatan')
                    ->join('tb_satuan','tb_riwayat_peralatan.id_satuan = tb_satuan.id_satuan')
                    ->get()
                    ->result();
  }
  


}



 ?>
