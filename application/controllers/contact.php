<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
    public $view = array();

    function __construct()
    {
        parent::__construct();
        $this->output->enable_profiler($this->config->item('profiles'));

    }

   /**
    * Index Page for this controller.
    * @var top()
    * no longin page
    */
    public function index()
    {
        // var_dump($this->session->all_userdata());
        $day = $this->input->get('date') ? $this->input->get('date') : date('Y-m-d');
        var_dump($day);
     
        // login check
        if ( $this->session->userdata('login') ) {
            $this->db->like('diary_date', $day);
            $this->db->like('office_num', $this->session->userdata('facility'));
            $result = $this->db->get('contact');
            $row = $result->result_array();

            // no data
            $dammy = array(
                'id' => '',
                'post_date' => '',
                'office_num' => $this->session->userdata('facility'),
                'update_date' => date('Y-m-d H:i:s'),
                'diary_date' => $day,
                'diary' => ''
            );
            
            $this->view['ct'] = !empty($row[0]) ? $row[0] : $dammy;

        }
        else {
            redirect(site_url('/'));
        }

        $this->load->view('diary', $this->view);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
