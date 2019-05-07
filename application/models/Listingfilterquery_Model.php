<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/31/2019
 * Time: 4:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Listingfilterquery_Model extends CI_Model
{

	public function get_all_countries()
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('b2b_countries');

		$this->db->order_by('id');


		$query = $this->db->get();
		$this->db->cache_off();



		return ($query->result());
	}
	public function get_formdb_by_id($selected_subcat_id)
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('categories_meta');
		$this->db->where('categories_id', $selected_subcat_id);
		$this->db->where('meta_key' , 'basic_sidebar_search_form');

		$query = $this->db->get();
		$this->db->cache_off();


		return ($query->result());
	}
	public function get_form_db_retrival_advance($selected_subcat_id)
	{


		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('categories_meta');
		$this->db->where('categories_id', $selected_subcat_id);
		$this->db->where('meta_key' , 'advance_sidebar_search_form');
		$query = $this->db->get();
		$this->db->cache_off();



		return ($query->result());
	}
	public function get_state_by_id($selected_state_id)
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('b2b_states');
		$this->db->where('country_id', $selected_state_id);

		$query = $this->db->get();
		$this->db->cache_off();


		return ($query->result());
	}
	public function get_city_by_id($selected_state_id)
	{

		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('b2b_cities');
		$this->db->where('state_id', $selected_state_id);

		$query = $this->db->get();
		$this->db->cache_off();

		return ($query->result());
	}
	public function get_all_categories()
	{
		$this->db->cache_on();
		$this->db->select('a.id, a.description,a.name, b.name as parent_name , a.image_icon, a.parent_ids');
		$this->db->from('categories a');

		$this->db->order_by('id');
		$this->db->join('categories b', 'a.parent_ids = b.id', 'left');


		$query = $this->db->get();
		$this->db->cache_off();



		return ($query->result());
	}

	public function get_cat_by_id($categoryid)
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('id', $categoryid);
		$this->db->limit(1);
		$query = $this->db->get();
		$this->db->cache_off();



		return ($query->row());
	}
	public function get_child_cat_integrate($selected_parent_id)
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('parent_ids', $selected_parent_id);

		$this->db->order_by('id');
		// $this->db->join('categories b', 'a.parent_ids = b.id', 'left');
		$query = $this->db->get();
		$this->db->cache_off();



		return $query->result();
	}

	public function get_make_models($selected_sub_cat_id)
	{
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('categories_meta');
		$this->db->where('meta_key', 'form_category');
		$this->db->where('categories_id', $selected_sub_cat_id);

		$this->db->order_by('id');

		$query = $this->db->get();
		$this->db->cache_off();



		$metavalue = $query->result();

		return $metavalue[0]->meta_value;

	}



}
