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

/*
        $query = $this->db->get('facility');
        $this->view['fc'] = $query->result_array();
*/
        $this->load->view('login', $this->view);
    }

    public function diary()
    {
        if ( !empty($this->uri->rsegments[3] ) && !empty($this->uri->rsegments[4]) ) {
            $this->db->like('diary_date', $this->uri->rsegments[4]);
            $this->db->like('office_num', $this->uri->rsegments[3]);
            $result = $this->db->get('contact');
            $row = $result->result_array();

            $dammy = array(
                'id' => '',
                'post_date' => '',
                'office_num' => $this->uri->rsegments[3],
                'update_date' => date('Y-m-d H:i:s'),
                'diary_date' => date('Y-m-d'),
                'diary' => ''
            );
                
            $this->view['ct'] = !empty($row[0]) ? $row[0] : $dammy;

        }

        $this->load->view('index', $this->view);
    }

    
    /*
     * @var checkts
     * check time stamp data
     */
    public function checkts()
    {
        $this->output->enable_profiler(FALSE);

       
        if ( !empty($this->uri->rsegments[4]) && !empty($this->uri->rsegments[3]) ) 
        {
            $this->db->like('diary_date', $this->uri->rsegments[4]);
            $this->db->like('office_num', $this->uri->rsegments[3]);
            $result = $this->db->get('contact');
            $row = $result->result_array();

            $update = !empty($row[0]) ? $row[0]['update_date'] : '';

            echo $update;

        }
    }
    
    
    /*
     * @var postdiary
     * post daiary text
     */
    public function postdiary()
    {
        $this->output->enable_profiler(FALSE);
        
        
    
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
