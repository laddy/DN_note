<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends CI_Controller {
    public $view = array();

    function __construct()
    {
        parent::__construct();
        // $this->output->enable_profiler($this->config->item('profiles'));
        $this->output->enable_profiler(FALSE);

    }
    
    /*
     * @var checkts
     * check time stamp data
     */
    public function checkts()
    {

        if ( $this->input->post('date') 
            && $this->input->post('update')
            && $this->session->userdata('login') ) 
        {
            $this->db->like('diary_date', $this->input->get('date'));
            $this->db->like('office_num', $this->session->userdata('facility'));
            $result = $this->db->get('contact');
            $row = $result->result_array();

            $compare = $this->input->post('update');

            if ( $row[0]['update_date'] == $compare )
            {
                echo json_encode(array('newdate'=>$compare));
            }
            else
            {
                $this->db->like('diary_date', $this->input->post('date'));
                $this->db->like('office_num', $this->session->userdata('facility'));
                $result = $this->db->get('contact');
                $row = $result->result_array();
                $udata['diary'] = unserialize($row[0]['diary']);
                $udata['newdate'] = $row[0]['update_date'];

                echo json_encode($udata);
            }
        }

        return TRUE;
    }

    /*
     * @var load diary
     * load diary data
     */
    public function loaddiary()
    {
        if ( $this->input->post('date') && $this->session->userdata('login') )
        {
            $this->db->where('diary_date', $this->input->post('date') );
            $this->db->where('facility', $this->session->userdata('facility') );
            
        }
        if ( $result->num_row() > 0 )
        {
            $update = !empty($row[0]) ? $row[0]['update_date'] : '';

            // output html
            foreach ( $update as $r )
            {
               echo "<p class=\"user-diary\">id={$r['user_id']}<br />diary={$r['diary']}<b    r >date={$r['date_time']}</p>";
            }

        }
        return TRUE;
    }
    
    
    /*
     * @var postdiary
     * post daiary text
     */
    public function postdiary()
    {
        if ( $this->input->post('diary_post') && $this->input->post('date') && $this->session->userdata('login') )
        {
            $this->db->like('diary_date', $this->input->post('date'));
            $this->db->like('office_num', $this->session->userdata('facility'));
            $result = $this->db->get('contact');
            $row = $result->result_array();

            // write diary data
            $update_data = array();
            if ( $result->num_rows() <= 0 )
            {
                $update_data[0] = array(
                    'user_id' => $this->session->userdata('id'),
                    'date_time' => date('Y-m-d H:i:s'),
                    'diary' => $this->input->post('diary_post')
                 );
                $this->db->insert('contact', array(
                    'id'          => null,
                    'post_date'   => date('Y-m-d H:i:s'), 
                    'office_num'  => $this->session->userdata('facility'),
                    'diary_date'  => $this->input->post('date'),
                    'diary'       => serialize($update_data),
                    'update_date' => date('Y-m-d H:i:s')
                ));

            }
            else
            {
                $row_data = unserialize($row[0]['diary']);
                foreach ( $row_data as $r )
                {
                    if ( $r['user_id'] != $this->session->userdata('id') ) {
                        $update_data[] = $r;
                    }
                    else {
                        $update_data[] = array(
                            'user_id' => $r['user_id'],
                            'date_time' => date('Y-m-d H:i:s'),
                            'diary' => $this->input->post('diary_post')
                        );
                    }

                }

                $this->db->where('id', $row[0]['id']);
                $this->db->update('contact', array(
                    'diary' => serialize($update_data),
                    'update_date' => date('Y-m-d H:i:s')
                ));
            }

            // output html
            // $update_data = array('diaries' => $update_data, 'update'=>date('Y-m-d H:i:s'));

/*
            $this->db->like('diary_date', $this->input->post('date'));
            $this->db->like('office_num', $this->session->userdata('facility'));
            $result = $this->db->get('contact');
            $row = $result->result_array();
            $udata['diary'] = unserialize($row[0]['diary']);
            $udata['newdate'] = $row[0]['update_date'];

            echo json_encode($udata);
            */
            echo 'true';
        }

        return TRUE; 
    }
    
}



