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
        if ( $this->input->post() )
        {
            $this->db->select('id, facility_id, name, login, password, img_path');
            $this->db->where('login', $this->input->post('login'));
            $this->db->where('password', streaching($this->input->post('pass'), $this->config->item('salt')));
            $query = $this->db->get('staff');
            
                // header('Content-Type: text/javascript; charset=utf-8' );
                // echo json_encode($query->result_array());
                //echo "<span class=\"push_user\">{$u['name']}</span>";
            
            // auth ok
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
                redirect('/contact/');
                return TRUE;
            }
            
            exit();
        }
        
        
        redirect(site_url('/'));
    }
    
}