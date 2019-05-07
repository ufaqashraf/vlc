<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/7/2019
 * Time: 5:01 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Flagreports_Model extends CI_Model
{

    private $tablename = 'flag_reports';

    public function create_flag_report($user_name, $listing_title, $descirption)
    {
        $user_id = $user_name[0]->id;
        $listing_id = $listing_title[0]->id;

        $data = [
            'user_id' => $user_id,
            'listing_id' => $listing_id,
            'description' => $descirption,
            'status' => 'in-progress',
            'created_date' => date('Y-m-d H:i:s'),
        ];

        $this->db->set($data);
        return $is_inserted = $this->db->insert(
            'flag_reports'
        );

    }


    public function get_title_of_listing($listing_slug)
    {

    	$this->db->cache_on();
        $this->db->select('slug, title , id');
        $this->db->from('listings');
        $this->db->order_by('id');
        $this->db->where('slug', $listing_slug);
        $query = $this->db->get();
        $this->db->cache_off();
        return ($query->result());

    }

    public function get_username($user_id)
    {

    	$this->db->cache_on();
        $this->db->select('username , id');
        $this->db->from('b2b_users');
        $this->db->order_by('id');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        $this->db->cache_off();
        return ($query->result());

    }

}
