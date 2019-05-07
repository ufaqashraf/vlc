<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/31/2019
 * Time: 4:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard_Model extends CI_Model
{
	public function get_curent_user_detail($logedin_user_email)
	{
		$this->db->cache_on();
		$this->db->select('id , username , firstname , lastname , email , created_at , updated_at , user_type');
		$this->db->from('b2b_users');
		$this->db->order_by('id');
		$this->db->where('email', $logedin_user_email);
		$query = $this->db->get();
		$this->db->cache_off();

		return ($query->result());
	}

	public function get_user_meta($user_id)
	{
		$this->db->cache_on();
		$this->db->select('id , user_id , meta_key , meta_value');
		$this->db->from('b2b_user_meta');
		$this->db->order_by('id');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();
		$this->db->cache_off();
		return ($query->result());
	}

	public function update_firstname($name, $id)
	{

		$data = array(
			'firstname' => $name,
		);

		$this->db->set($data);
		$this->db->where('id', $id);
		return $this->db->update(
			'b2b_users'
		);

	}

	public function update_lastname($name, $id)
	{

		$data = array(
			'lastname' => $name,
		);

		$this->db->set($data);
		$this->db->where('id', $id);
		return $this->db->update(
			'b2b_users'
		);

	}

	public function insert_metas_for_user($input_post, $id)
	{
		$data = [];
		$this->db->delete('b2b_user_meta', array('user_id' => $id));
		foreach ($input_post as $key => $userdetail) {
			$data = [
				'meta_key' => $key,
				'meta_value' => $userdetail,
				'user_id' => $id,
			];

			$this->db->set($data);

			$this->db->insert(
				'b2b_user_meta'
			);
		}
		return true;

	}

	public function store_followers($user_id_of_user, $loged_in_user_id)
	{
		$this->db->cache_on();
		$this->db->select('id , user_id , meta_key , meta_value');
		$this->db->from('b2b_user_meta');
		$this->db->order_by('id');
		$this->db->where('user_id', $loged_in_user_id);
		$this->db->where('meta_key', 'Following');
		$this->db->where('meta_value', $user_id_of_user);
		$query = $this->db->get();
		$this->db->cache_off();
		$followeding = $query->result();

		if (empty($followeding)) {
			$data = [
				'meta_key' => 'Following',
				'meta_value' => $user_id_of_user,
				'user_id' => $loged_in_user_id,
			];

			$this->db->set($data);

			$this->db->insert(
				'b2b_user_meta'
			);

			return true;
		} else {
			return true;
		}

	}

	public function unstore_followings($user_id_of_user, $loged_in_user_id)
	{

		$this->db->delete('b2b_user_meta', ['user_id' => $loged_in_user_id, 'meta_key' => 'Following', 'meta_value' => $user_id_of_user,]);

		return true;
	}

	public function unstore_followers($user_id_of_user, $loged_in_user_id)
	{

		$this->db->delete('b2b_user_meta', ['user_id' => $loged_in_user_id, 'meta_key' => 'Following', 'meta_value' => $user_id_of_user,]);

		return true;
	}


	public function get_followers($loged_in_user_id)
	{

		$this->db->cache_on();
		$this->db->select('id , user_id , meta_key , meta_value');
		$this->db->from('b2b_user_meta');
		$this->db->order_by('id');
		$this->db->where('meta_value', $loged_in_user_id);
		$this->db->where('meta_key', 'Following');
		$query = $this->db->get();
		$followed_by = $query->result();
		$this->db->cache_off();
		$ids_of_followers = [];

		foreach ($followed_by as $key => $single_follower_id) {
			$ids_of_followers[] = $single_follower_id->user_id;

		}

		return $ids_of_followers;

	}


	public function get_followings($loged_in_user_id)
	{

		$this->db->cache_on();
		$this->db->select('id , user_id , meta_key , meta_value');
		$this->db->from('b2b_user_meta');
		$this->db->order_by('id');
		$this->db->where('user_id', $loged_in_user_id);
		$this->db->where('meta_key', 'Following');
		$query = $this->db->get();
		$followed_by = $query->result();
		$this->db->cache_off();
		$ids_of_followers = [];
		foreach ($followed_by as $key => $single_follower_id) {
			$ids_of_followers[] = $single_follower_id->meta_value;

		}

		return $ids_of_followers;

	}

	public function get_users_detail($id_of_user)
	{
		$this->db->cache_on();
		$this->db->select('id , firstname , lastname');
		$this->db->from('b2b_users');
		$this->db->order_by('id');
		$this->db->where('id', $id_of_user);

		$query = $this->db->get();
		$this->db->cache_off();
		$followed_by_user_detail = $query->result();

		$this->db->cache_on();
		$this->db->select('id , uid');
		$this->db->from('listings');
		$this->db->order_by('id');
		$this->db->where('uid', $id_of_user);
		$countpost = $this->db->get();
		$this->db->cache_off();
		$total_post = $countpost->num_rows();

		$displayname = [];
		$displayname['id'] = $followed_by_user_detail[0]->id;
		$displayname['name'] = $followed_by_user_detail[0]->firstname . ' ' . $followed_by_user_detail[0]->lastname;
		$displayname['postcount'] = $total_post;

		return $displayname;
	}

	public function soft_delete($id)
	{

		$data = array(
			'is_deleted' => '1',
		);

		$this->db->where('id', $id);
		return $this->db->update('b2b_users', $data);

	}

	public function save_search_add($loged_in_userid){
		$data = [
			'meta_key' => 'fav_save_search',
			'user_id' => $loged_in_userid,
		];
		$this->db->set($data);
		$this->db->insert('b2b_user_meta');
		return "fav_search_added";
	}

	public function fav_add($listing_id, $loged_in_userid)
	{

		$data = [
			'meta_key' => 'fav_add_dashboard',
			'meta_value' => $listing_id,
			'user_id' => $loged_in_userid,
		];

		$this->db->set($data);

		$this->db->insert(
			'b2b_user_meta'
		);

		return "fav_added";

	}

	public function follow_add($listing_id, $loged_in_userid)
	{

		$data = [
			'meta_key' => 'follow_add_dashboard',
			'meta_value' => $listing_id,
			'user_id' => $loged_in_userid,
		];

		$this->db->set($data);

		$this->db->insert(
			'b2b_user_meta'
		);

		return "follow_added";

	}

	public function remove_fav_add($listing_id, $loged_in_userid)
	{

		$this->db->delete('b2b_user_meta', ['user_id' => $loged_in_userid, 'meta_key' => 'fav_add_dashboard', 'meta_value' => $listing_id,]);
		return "fav_removed";
	}

	public function remove_follow_add($listing_id, $loged_in_userid)
	{

		$this->db->delete('b2b_user_meta', ['user_id' => $loged_in_userid, 'meta_key' => 'follow_add_dashboard', 'meta_value' => $listing_id,]);
		return "follow_removed";
	}
	public function remove_save_search_add($loged_in_userid)
	{

		$this->db->delete('b2b_user_meta', ['user_id' => $loged_in_userid, 'meta_key' => 'fav_save_search']);
		return "fav_save_search_removed";
	}

	public function listing_delete($listing_id)
	{

		$this->db->delete('listings_meta', ['listings_id' => $listing_id,]);
		$this->db->delete('listings', ['id' => $listing_id,]);
		return true;
	}

	public function get_save_listing_ids($loged_in_userid)
	{
		$this->db->cache_on();
		$this->db->select('id , user_id , meta_key , meta_value');
		$this->db->from('b2b_user_meta');
		$this->db->order_by('id');
		$this->db->where('user_id', $loged_in_userid);
		$this->db->where('meta_key', 'fav_add_dashboard');
		$query = $this->db->get();
		$fav_adds = $query->result();
		$this->db->cache_off();
		$ids_of_listings = [];

		foreach ($fav_adds as $key => $single_fav_id) {
			$ids_of_listings[] = $single_fav_id->meta_value;
		}
		return $ids_of_listings;
	}

	public function get_saved_listings($ids)
	{

		$newarray = [];
		$count = 0;
		foreach ($ids as $id) {
			$this->db->cache_on();
			$this->db->select('id, title, description');
			$this->db->from('listings');
			$this->db->order_by('id');
			$this->db->where('id', $id);
			$query = $this->db->get();
			$fav_adds[] = $query->result();
			$this->db->cache_off();

			if (!empty($fav_adds)) {
				$this->db->cache_on();

				$this->db->select('id , listings_id , meta_key , meta_value');
				$this->db->from('listings_meta');
				$this->db->order_by('id');
				$this->db->where('listings_id', $id);
				$query = $this->db->get();
				$this->db->cache_off();

				$metas[] = $query->result();

				/*
                 *
                 * for city name
                 * */

				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_cities');
				$this->db->where('id', $fav_adds[$count][0]->city_id);
				$cityname = $this->db->get();
				$result = $cityname->result();
				$this->db->cache_off();

				if (isset($result[0]->name)) {
					$cityname = $result[0]->name;
				} else {
					$cityname = "";
				}

				/*
                 * for country name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_countries');
				$this->db->where('id', $fav_adds[$count][0]->country_id);
				$ccountryname = $this->db->get();
				$result = $ccountryname->result();
				$this->db->cache_off();

				if (isset($result[0]->name)) {
					$ccountryname = $result[0]->name;
				} else {
					$ccountryname = '';
				}


				/*
                 * for state name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_states');
				$this->db->where('id', $fav_adds[$count][0]->state_id);
				$statename = $this->db->get();
				$result = $statename->result();
				$this->db->cache_off();
				if (isset($result[0]->name)) {
					$statename = $result[0]->name;
				} else {
					$statename = '';
				}



				/*
                 * Category Name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('categories');
				$this->db->where('id', $fav_adds[$count][0]->category_id);
				$catname = $this->db->get();
				$this->db->cache_off();
				$result = $catname->result();

				if (isset($result[0]->name)) {
					$catname = $result[0]->name;
				} else {
					$catname = "";
				}


				/*
             * Sub Category Name
             *
             * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('categories');
				$this->db->where('id', $fav_adds[$count][0]->sub_category_id);
				$subcatname = $this->db->get();
				$result = $subcatname->result();
				$this->db->cache_off();

				if (isset($result[0]->name)) {
					$subcatname = $result[0]->name;
				} else {
					$subcatname = "";
				}


				$fav_adds['lisitng_detial'][] = [
					'id' => $fav_adds[$count][0]->id,
					'title' => $fav_adds[$count][0]->title,
					'country_id' => $fav_adds[$count][0]->country_id,
					'description' => $fav_adds[$count][0]->description,
					'state_id' => $fav_adds[$count][0]->state_id,
					'city_id' => $fav_adds[$count][0]->city_id,
					'city_name' => $cityname,
					'country_name' => $ccountryname,
					'state_name' => $statename,
					'cat_name' => $catname,
					'sub_cat_name' => $subcatname,
					'category_id' => $fav_adds[$count][0]->category_id,
					'sub_category_id' => $fav_adds[$count][0]->sub_category_id,
					'slug' => $fav_adds[$count][0]->slug,

					'metas' => $metas[$count],
				];
				$count++;
			}

		}


		return $fav_adds['lisitng_detial'];


	}

	public function get_user_listing($id)
	{

		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('listings');
		$this->db->order_by('id');
		$this->db->where('uid', $id);
		$query = $this->db->get();
		$this->db->cache_off();

		$myadds = $query->result();


		if (!empty($myadds)) {
			$count = 0;
			foreach ($myadds as $single_add) {

				$this->db->cache_on();
				$this->db->select('id , listings_id , meta_key , meta_value');
				$this->db->from('listings_meta');
				$this->db->order_by('id');
				$this->db->where('listings_id', $single_add->id);
				$query = $this->db->get();
				$this->db->cache_off();
				$metas[] = $query->result();


				/*
                 *
                 * for city name
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_cities');
				$this->db->where('id', $single_add->city_id);
				$cityname = $this->db->get();
				$result = $cityname->result();
				$cityname = $result[0]->name;
				$this->db->cache_off();

				/*
                 * for country name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_countries');
				$this->db->where('id', $single_add->country_id);
				$ccountryname = $this->db->get();
				$result = $ccountryname->result();
				$ccountryname = $result[0]->name;
				$this->db->cache_off();
				/*
                 * for state name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('b2b_states');
				$this->db->where('id', $single_add->state_id);
				$statename = $this->db->get();
				$result = $statename->result();
				$this->db->cache_off();
				$statename = $result[0]->name;


				/*
                 * Category Name
                 *
                 * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('categories');
				$this->db->where('id', $single_add->category_id);
				$catname = $this->db->get();
				$this->db->cache_off();
				$result = $catname->result();
				$catname = $result[0]->name;


				/*
             * Sub Category Name
             *
             * */
				$this->db->cache_on();
				$this->db->select('name');
				$this->db->from('categories');
				$this->db->where('id', $single_add->sub_category_id);
				$subcatname = $this->db->get();
				$this->db->cache_off();
				$result = $subcatname->result();
				$subcatname = $result[0]->name;


				$myadds['lisitng_detial'][] = [
					'id' => $single_add->id,
					'title' => $single_add->title,
					'country_id' => $single_add->country_id,
					'description' => $single_add->description,
					'state_id' => $single_add->state_id,
					'city_id' => $single_add->city_id,
					'city_name' => $cityname,
					'country_name' => $ccountryname,
					'state_name' => $statename,
					'cat_name' => $catname,
					'sub_cat_name' => $subcatname,
					'category_id' => $single_add->category_id,
					'sub_category_id' => $single_add->sub_category_id,
					'slug' => $single_add->slug,
					'created_at' => $single_add->created_at,
					'status' => $single_add->status,

					'metas' => $metas[$count],
				];
				$count++;
			}


			return $myadds['lisitng_detial'];
		}

	}


	public function save_search($user_id, $meta_value)
	{
		if(!empty($meta_value)){
			$data = array(
				'user_id' => $user_id,
				'meta_key' => 'save_search',
				'meta_value' => $meta_value
			);

			$this->db->insert('b2b_user_meta', $data);
			$insert_id = $this->db->insert_id();
			return  $insert_id;

		}
	}

	public function remove_search_history($id){
		$this->db->delete('listings', ['id' => $id,]);
	}

}
