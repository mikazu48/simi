<?php

class M_employee extends CI_Model{
    
    public function CheckIDemployeeExist($id_employee){
        return $this->db->select('*')
                        ->from('tb_employee')
                        ->where('id_employee',$id_employee)
                        ->get();
      }
}

?>


