<?php
class M_barang extends CI_Model{

public function select($tabel)
  {
    return $this->db->select()
                    ->from($tabel)
                    ->get()->result();
    

    // $this->db->select('*');
    // $this->db->from($tabel);
    // $this->db->join('tb_satuan','tb_satuan.id_satuan = tb_list_barang.id_satuan');
    // $queryResult =  $this->db->get();
    // return $queryResult;
  }

  public function CheckIDbarangExist($id_barang){
    return $this->db->select('*')
                    ->from('tb_list_barang')
                    ->where('id_barang',$id_barang)
                    ->get();
  }
  
  public function CheckStockBarang($id_barang){
    return $this->select('*')
                ->from('tb_list_barang')
                ->where('id_barang',$id_barang)
                ->get();

  }
}



 ?>
