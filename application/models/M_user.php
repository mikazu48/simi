<?php
class M_user extends CI_Model{

  public function update_password($tabel,$where,$data)
  {
    $this->db->where($where);
    $this->db->update($tabel,$data);
  }

  public function insert($tabel,$data)
  {
    $this->db->insert($tabel,$data);
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

  public function get_data_gambar($tabel,$username)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where('username_user',$username)
                      ->get();
    return $query->result();
  }

  public function delete($tabel,$where)
  {
    $this->db->where($where);
    $this->db->delete($tabel);
  }

  function UserCheck($username,$password){
    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('username',$username);
    $this->db->where('password',$password);
    $result = $this->db->get();
    return $result;    
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

public function select($tabel)
  {
    return $this->db->select()
                    ->from($tabel)
                    ->get()->result();
  }

}

 ?>
