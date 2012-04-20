<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * @var Get_tweet_model
 * Get Relation User 
 * 2012/01/31 YuyaTanaka
 * 
 */

class Get_user_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        
    }

    /*
     * @var get_follow_user
     * Get follow users.
     */
    function get_follow_user($id)
    {
        $follow_list = array();
        // $this->db->where('login_id', $id);
        // $query = $this->db->get('follow');
        $query = $this->db->query("SELECT * FROM `follow` WHERE `login_id` = {$id}");

        foreach ( $query->result_array() as $f )
        {
            $follow_list[] = $f['honor'];
        }

        return $follow_list;
    }

    /*
     * @var get_profile_data
     * Get profile.
     */
    function get_profile_data($id_list = null)
    {
        if ( 0 == count($id_list) ) return array();
        $prof_list = array();
        $this->db->where_in('id', $id_list);
        $query = $this->db->get('user_profile');

        foreach ( $query->result_array() as $f )
        {
            $prof_list[$f['id']] = $f;
        }

        return $prof_list;
    }


    /*
     * @var get_follower_user
     * Get follower users.
     */
    function get_follower_user($id)
    {
        $follower_list = array();
        $query = $this->db->query("SELECT * FROM `follow` WHERE `honor` = {$id}");

        foreach ( $query->result_array() as $f )
        {
            $follower_list[] = $f['login_id'];
        }

        return $follower_list;
    }



    /*
     * @var get_pj_mem
     * Get Project member. 
     */
    function get_pj_mem($pj_id)
    {
        $pj_list = array();
        $query = $this->db->query("SELECT * FROM (project_belong) WHERE group_id = {$pj_id}"); 
        
        foreach ( $query->result_array() as $f )
        {
            if ( $f['login_id'] !== $this->session->userdata('id')  )
            {
                $pj_list[] = $f['login_id'];
            }
        }
        
        return $pj_list;
    }


    /*
     * @var get_user_prof
     * Get user profiles
     */
    function get_user_prof($id)
    {
        $profile = $this->db->query("SELECT * FROM `user_profile` WHERE `id` = {$id}");
        return $profile->result_array();
    }


    /*
     * @var get_org_data
     * Get user org list
     */
    function get_org_data($id)
    {
        $query = $this->db->query("SELECT `org` FROM `user` WHERE `id` = {$id}");
        $org_id = $query->result_array();
        $org = $this->db->query("SELECT * FROM `organization` WHERE `id` = {$org_id[0]['org']}");
        return $org->result_array();
    }

}

