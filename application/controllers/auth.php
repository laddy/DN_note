<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler($this->config->item('profiles'));

    }

   /**
    * Auth for this controller.
    * @var top()
    * check id and password.
    */
    public function index()
    {
        // if aleady login
        if ( $this->session->userdata('login') ) {
            redirect('/contact/?date='.date('Y-m-d'));
            return TRUE;
        }

        $this->load->view('login');
    }
    
    public function login()
    {
        if ( $this->input->post() )
        {
            $this->db->select('id, facility_id, name, login, password, img_path');
            $this->db->where('login', $this->input->post('login'));
            $this->db->where('password', streaching($this->input->post('pass'), $this->config->item('salt')));
            $query = $this->db->get('staff');
            
            // auth check
            if ($query->num_rows() > 0)
            {
                $user = $query->result_array();
                $this->session->sess_create();
                $this->session->set_userdata( array(
                    'id'        => $user[0]['id'],
                    'login'  => $user[0]['login'],
                    'name' => $user[0]['name'],
                    'facility'    => $user[0]['facility_id'],
                    'img_path'      => $user[0]['img_path'],
                    'login'     => TRUE
                ));
                redirect('/contact/?date='.date('Y-m-d'));
                return TRUE;
            }
        }
        echo "ユーザ名・パスワードが異なります";
        redirect(site_url('/')); 

        return FALSE;
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('/'));
    }
}
