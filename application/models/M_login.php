<?php

class M_login extends CI_Model{

    function UserCheck($username,$password){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$username);
        $this->db->where('password',$password);
        $result = $this->db->get();
        return $result;    
    }

    function UpdateLastLogin($tabel,$fieldid,$fieldvalue,$data=array())
    {
        $this->db->where($fieldid,$fieldvalue)->update($tabel,$data);
    }

}
