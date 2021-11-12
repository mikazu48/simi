<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('M_login');
	}

	public function index(){
        $this->load->view('login/V_login');
	}

    public function register(){
		$this->load->view('login/V_register');
	}

    public function login(){
        //Aktifkan rules agar textbox tidak boleh kosong dan harus diisi
        $this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

        //check jika textbox telah ter isi keduanya username maupun password
        if($this->form_validation->run() == TRUE){
            //set variable username dan variable password sesuai dengan isi textbox
            $username = $this->input->post('username',TRUE);
			$password = $this->input->post('password',TRUE);

            //check apakah user dengan username dan password tersebut ada di database
            $UserCheck =  $this->M_login->UserCheck($username,$password);
            
            //jika username ada maka lanjut
            if($UserCheck->num_rows() > 0){
                //tampung data user dalamn variable $DataUser
                $DataUser = $UserCheck->row_array();

                //check role dari user tersebut
                if($DataUser['role'] == 'admin'){
                    //tampung data UserID dari user di variable $UserID
                    $UserID = $DataUser['UserID'];
                    //tampung data last login user dalam variable $LastLogin
                    $Update['last_login'] = date('d-m-Y G:i');
                    //tampung beberapa data untuk session di $SessionData
                    $SessionData = array(
                                    'UserID' => $UserID,
                                    'name' => $username,
									'email' => $DataUser['email'],
									'status' => 'login',
									'role' => $DataUser['role'],
									'last_login' => $DataUser['last_login']
                    );
                    //set session dengan data dari variable $SessionData
                    $this->session->set_userdata($SessionData);
                    //Update Last Login user
                    $this->M_login->UpdateLastLogin('user','UserID',$UserID,$Update);
                    //Arahkan user ke menu admin
                    redirect(base_url('admin'));
                }else{
                    //tampung data UserID dari user di variable $UserID
                    $UserID = $DataUser['UserID'];
                    //tampung data last login user dalam variable $LastLogin
                    $Update['last_login'] = date('d-m-Y G:i');
                    //tampung beberapa data untuk session di $SessionData
                    $SessionData = array(
                                    'UserID' => $UserID,
                                    'name' => $username,
									'email' => $DataUser['email'],
									'status' => 'login',
									'role' => $DataUser['role'],
									'last_login' => $DataUser['last_login']
                    );
                    //set session dengan data dari variable $SessionData
                    $this->session->set_userdata($SessionData);
                    //Update Last Login user
                    $this->M_login->UpdateLastLogin('user','UserID',$UserID,$Update);
                    //Arahkan user ke menu user
                    redirect(base_url('user'));
                }
            }else{
                //jika username dan password tidak terdaftar munculkan pesan
                $this->session->set_flashdata('msg','Username Dan Password Salah');
				redirect(base_url());
            }
        }
    }
}
