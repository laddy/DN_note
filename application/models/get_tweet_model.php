<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * BaseOption model
 * 2011/09/26 YuyaTanaka
 * 
 */

class Get_tweet_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
    }

    /*
     * @var get_open_tweet
     * Get Tweets before login.
     */
    function get_open_tweet($number = 0, $limit=0)
    {
        // if ( 0 != $number ) { $this->db->where('login_id', $number); }
        $this->db->where('tweet_class', 1);
        $this->db->order_by('post_date', 'desc');
        // $this->db->limit($this->config->item('tweet_limit'));
        $query = $this->db->get('stream', 20, $limit);

        return $query->result_array();                     
    }
    function get_own_open_tweet($number)
    {
        $this->db->where('login_id', $number);
        $this->db->where('tweet_class', 1);
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get('stream');

        return $query->result_array();                     
    }
        
    
    
    /*
     * @var get_follower_tweet
     * get follow user tweets.
     */
    function get_my_tweet($login_id, $limit = 0)
    { 
        // get follow list
        $follow_list = array();
        $query = $this->db->where('login_id', $login_id)->get('follow');
        foreach ( $query->result_array() as $f )
        {
            $follow_list[] = $f['honor'];
        }

        if ( 0 < count($follow_list) ) { 
            $this->db->where_in('login_id', $follow_list);
        }
        $this->db->where_in('tweet_class', array(1,2,3));
        $this->db->or_where('login_id', $login_id);

        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get('stream', 20, $limit);
        
        return $query->result_array();
    }
    

    /*
     * @var get_search_tweet
     * get search method on
     */
    function get_search_tweet($login_id, $limit = 0, $search)
    {
        $user_list = array();
        $query = $this->db->query("SELECT `id` FROM `user` WHERE `login_id` like '%{$search}%' OR `user_name` like '%{$search}%'");
        
        foreach ( $query->result_array() as $u )
        {
            $user_list[] = $u['id'];
        }

        $list = "";
        if ( 0 < count($user_list)) {
            $this->db->or_where_in('login_id', $user_list);

            $list = "`login_id` IN(";
            foreach ( $user_list as $l ) {
                $list .= "'{$l}'";
            }
            $list .= ") AND";

            if ( "`login_id` IN() AND" == $list )
                $list = "";
            else
                $list .= ' `tweet_class` = 1 OR';

        }

        $this->db->where('tweet_class', 1);
        $this->db->or_like("tweet", $search);
        $this->db->order_by('post_date', 'desc');

        $query = $this->db->get('stream', 20, $limit);

        $limit += 20;
        $query = $this->db->query("SELECT * FROM (`stream`) WHERE {$list} `tweet`  LIKE '%{$search}%' AND `tweet_class` = 1 ORDER BY `post_date` desc LIMIT {$limit} ");
        return $query->result_array();

    }

    /*
     * @var get_own_tweet
     * get own only tweets
     */
    function get_own_tweet($id, $limit = 0)
    {
        // Get follower tweet list
        $this->db->where('login_id', $id);
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get('stream', 20, $limit);
        
        return $query->result_array();
    }


    /*
     * @var get_reply_tweet
     * get user reply tweets.
     */
    function get_reply_tweet($login_name, $limit = 0)
    {
        $this->db->like('tweet', '@'.$login_name.' ');
        $this->db->or_like('tweet', '@'.$login_name.'　');
        $this->db->where('tweet_class', 1);
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get('stream', 20, $limit);

        return $query->result_array();
    }

    /*
     * @var get_org_tweet
     * get org user tweets.
     */
    function get_org_tweet($org_id, $limit = 0)
    {
        // Get follower tweet list
        $this->db->where('group_id', $org_id);
        $this->db->where('tweet_class', 2);
        $this->db->order_by('post_date', 'desc');
        $query = $this->db->get('stream', 20, $limit);

        return $query->result_array();

    }
    function get_orgname($org_id)
    {
        $org_list = array();
    	$query = $this->db->where('id', $org_id)->get('organization');
        foreach ( $query->result_array() as $o )
        {
            $org = $o['belong'];
        }

        return $org;
    }


    /*
     * @var get_project_tweet
     * get user belong project tweets.
     */
    function get_project_tweet($pj_id, $limit = 0)
    {
        // get project tweet
        $this->db->where('tweet_class', 3);
        $this->db->where('group_id', $pj_id);
        $this->db->order_by('post_date', 'desc');

        $query = $this->db->get('stream', 20, $limit);

        return $query->result_array();
    }

}
