<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Write_tweet_model model
 * 2012/01/28 YuyaTanaka
 * 
 */

class Write_tweet_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*
     * @var write_tweet
     * Basic tweet
     */
    function write_tweet($id, $type = '', $tweet = '', $group_id = null, $img_pass = null)
    {
        if ( '' == $tweet || empty($id) || '' == $type ) { return FALSE; }

        $tweet_num = array(
            'follow'  => 4,
            'open'    => 1,
            'project' => 3,
            'org'     => 2
        );

        $this->db->insert('stream', array(
            'login_id' => $id,
            'post_date' => date('Y-m-d H:i:s'),
            'tweet_class' => $tweet_num[$type],
            'group_id' => $group_id,
            'tweet' => $tweet,
            'img_pass' => serialize($img_pass)
        ));

       return TRUE;
    }
    
}
