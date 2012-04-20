<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * BaseOption model
 * load option, user, etc..
 * 2012/01/29 YuyaTanaka
 * 
 */

class Option_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
    }

    /*
     * load options
     * Setting load in DataBase
     * table: option
     */
    function load_option()
    {
        $op = array();
    	// $query = $this->db->get('option');
        $query = $this->db->query('SELECT `var`,`value` FROM `option`');
        foreach ( $query->result_array() as $o )
        {
        	$op[$o['var']] = $o['value'];
        }
        
        return $op;
        
    }

    /*
     * user array create
     */
    function load_users()
    {
        $query = $this->db->query('SELECT `id`,`login_id`,`user_name`,`org`,`hash` FROM `user`');
        $uarray = array();
        foreach ( $query->result_array() as $user )
        {
        	$uarray[$user['id']] = $user;
        }

        return $uarray;
    }

    /*
     * load org list data.
     */
    function load_org()
    {
        $query = $this->db->query('SELECT * FROM `organization`');
        return $query->result_array();
    }

} // end Class
