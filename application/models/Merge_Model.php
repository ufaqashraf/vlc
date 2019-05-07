<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/1/2019
 * Time: 4:28 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Merge_Model extends CI_Model
{

	private $old_users_table = 'users';
	private $new_users_table = 'b2b_users';
	private $new_users_meta_table = 'b2b_user_meta';

	private $old_autos_listings_table = 'listing_autos';
	private $old_classified_listings_table = 'listing_classified';
	private $old_job_listings_table = 'listing_jobs';
	private $old_job_wanted_listings_table = 'listing_jobs_wanted';
	private $old_properties_listings_table = 'listing_property';
	private $old_services_listings_table = 'listing_services';
	private $old_buying_leads_table = 'listing_leads';
	private $old_seller_leads_table = 'listing_sellerleads';
	private $old_tradeshows_table = 'trade_event';

	public function print_header_info($page)
	{
		date_default_timezone_set('Asia/Karachi');

		echo '<h1>Starting Time: ' . date('d-M-y H:i:s') . '</h1>';
		echo '<hr />';

		if ( ( $page -1 ) <= 0 ){
			echo '<h1>Previous Page: 0</h1>';
		}else {
			echo '<h1>Previous Page: ' . ( $page -1 ) . '</h1>';
		}


		echo '<h1>Current Page: ' . $page . '</h1>';
		echo '<h1>Next Page: ' . ($page + 1) . '</h1>';
		echo '<hr />';
		echo '<h1>Ending Time: ' . date('d-M-y H:i:s') . '</h1>';
	}

	/*
	 * --- Users Merge ---
	 * */
	private function get_all_old_users()
	{
		$this->db->select('*');
		$this->db->from($this->old_users_table);

		$query = $this->db->get();
		return $query->result();
	}
	public function merge_users()
	{

		exit('already merged');

		foreach ($this->get_all_old_users() as $user) {
			$arr = [
				'username' => $user->email,
				'firstname' => $user->firstname,
				'lastname' => $user->lastname,
				'email' => $user->email,
				'password' => password_hash($user->password, PASSWORD_BCRYPT),
				'is_deleted' => '0',
				'created_at' => $user->timestamp,
				'updated_at' => date("Y-m-d H:i:s"),
				'user_type' => 'subscriber'
			];

			$this->db->set($arr);
			$is_inserted = $this->db->insert($this->new_users_table);

			if (!$is_inserted)
				break;


			$metas = [
				'user_company' => $user->comapny,
				'user_oauth_provider' => $user->oauth_provider,
				'user_oauth_uid' => $user->oauth_uid,
				'user_gender' => $user->gender,
				'user_dob' => $user->dob,
				'user_nationality' => $user->nationality,
				'user_seniority' => $user->seniority,
				'user_curpos' => $user->curpos,
				'user_curcompany' => $user->curcompany,
				'user_curcuntry' => $user->curcuntry,
				'user_degree' => $user->degree,
				'user_phone' => $user->phone,
				'user_country' => $user->country,
				'user_state' => $user->state,
				'user_city' => $user->city,
				'user_image' => $user->image,
				'user_lat' => $user->lat,
				'user_lan' => $user->lan,
				'user_visitor_ip' => $user->visitor_ip,
				'user_session_id' => $user->session_id,
				'user_leads_pkg' => $user->leads_pkg,
				'user_forget_key' => $user->forget_key,
				'user_offer_status' => $user->offer_status,
				'user_status' => $user->status,
				'user_timestamp' => $user->timestamp,
				'user_cv' => $user->cv,
			];

			$insert_id = $this->db->insert_id();

			foreach ($metas as $key => $meta) {
				$arr = [
					'meta_key' => $key,
					'meta_value' => $meta,
					'user_id' => $insert_id
				];

				$this->db->set($arr);
				$is_inserted = $this->db->insert(
					$this->new_users_meta_table
				);

				if (!$is_inserted)
					break;
			}
		}

		if (!$is_inserted) {
			volgo_debug("Unable to insert user");
		}

		return true;
	}

	/*
	 * --- Autos Merge ---
	 * */
	function get_autos_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_autos_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();

	}
	function merge_autos_listings($page)
	{

		// Autos Listing ID: 5

		exit('already merged');

		$this->print_header_info($page);

		$per_page = 700;
		$offset = 700;
		$limit = 700;
		$offset = $offset + ( ($page-1) * $per_page );

		$autos_listings = $this->get_autos_listings($limit, $offset);

		if (empty($autos_listings))
			return true;

		foreach ($autos_listings as $auto_listing) {

			$ad_extras = [];
			if ($auto_listing->ad_extras !== null || !empty($auto_listing->ad_extras))
				$ad_extras = explode(';', $auto_listing->ad_extras);

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $auto_listing->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $auto_listing->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/

			if (intval($auto_listing->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')->where('ad_id', intval($auto_listing->id))->where('ad_type_id', $auto_listing->formsubid)->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);

			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $auto_listing->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category = '';
			} else {
				$category_id = '';
			}
			unset($old_subcategory_name);
			unset($category);

			$data = [
				'title' => $auto_listing->ad_title,
				'slug' => $auto_listing->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => 5,
				'sub_category_id' => $category_id,
				'description' => $auto_listing->ad_description,
				'status' => $status,
				'views' => $auto_listing->views,
				'seo_description' => ($auto_listing->seo_description === null) ? '' : $auto_listing->seo_description,
				'seo_keywords' => $auto_listing->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($auto_listing->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			$listing_types = ['featured', 'recommended'];

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $auto_listing->id,
					'phone' => $auto_listing->ad_contact,
					'make' => $auto_listing->ad_make,
					'model' => $auto_listing->ad_model,
					'price' => $auto_listing->ad_price,
					'kilometers' => $auto_listing->ad_km,
					'year' => $auto_listing->ad_year,
					'color' => $auto_listing->ad_color,
					'transmission' => $auto_listing->ad_transm,
					'cylinder' => $auto_listing->ad_no_cylinc,
					'doors' => $auto_listing->ad_door,
					'horspower' => $auto_listing->ad_horspower,
					'warranty' => $auto_listing->ad_warnty,
					'fueltype' => $auto_listing->ad_fueltype,
					'bodycondition' => $auto_listing->ad_condition_b,
					'mechanicalcondition' => $auto_listing->ad_condition_m,
					'images_from' => $ad_images,
					'ad_extras' => serialize($ad_extras),
					'is_from_old_table' => 1,
					'listing_type' => $listing_types[ rand(0,1) ],
					'old_listing_data__trim' => $auto_listing->ad_trim,
					'old_listing_data__ad_vinno' => $auto_listing->ad_vinno,
					'old_listing_data__ad_bodytype' => $auto_listing->ad_bodytype,
					'old_listing_data__ad_reg_specs' => $auto_listing->ad_reg_specs,
					'old_listing_data__ad_technical' => $auto_listing->ad_technical,
					'old_listing_data__ad_location' => $auto_listing->ad_location,
					'old_listing_data__ad_agent_id' => $auto_listing->ad_agent_id,
					'old_listing_data__ad_state' => $auto_listing->ad_state,

				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);


					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;

		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;

	}

	/*
	 * --- Classified Listing Merge ---
	 * */
	public function get_all_old_classified_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_classified_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function listing_classified($page)
	{
		// Classified ID: 28

		// 1,2 3 page

		exit('already merged');

		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$classifieds = $this->get_all_old_classified_listings($limit, $offset);

		foreach ($classifieds as $classified) {

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $classified->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $classified->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;

			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($classified->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($classified->id))->where('ad_type_id', $classified->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $classified->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category = '';
			} else {
				$category_id = '';
			}
			unset($old_subcategory_name);
			unset($category);

			$data = [
				'title' => $classified->ad_title,
				'slug' => $classified->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => 28,
				'sub_category_id' => $category_id,
				'description' => $classified->ad_description,
				'status' => $status,
				'views' => $classified->views,
				'seo_description' => $classified->seo_description,
				'seo_keywords' => $classified->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($classified->ad_post_datetime))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $classified->id,
					'phone' => $classified->ad_contact,
					'price' => $classified->ad_price,
					'currency_code' => $classified->currency_code,
					'images_from' => $ad_images,
					'usage' => $classified->ad_usage,
					'condition' => $classified->ad_condition,
					'is_from_old_table' => 1,
					'listing_type' => 'featured',

					'old_listing_data__ad_age' => $classified->ad_age,
					'old_listing_data__ad_my_company' => $classified->ad_my_company,
					'old_listing_data__ad_company_size' => $classified->ad_company_size,
					'old_listing_data__ad_listed_by' => $classified->ad_listed_by,
					'old_listing_data__ad_location' => $classified->ad_location,
					'old_listing_data__ad_post_datetime' => $classified->ad_post_datetime,
					'old_listing_data__timestamp' => $classified->timestamp,
					'old_listing_data__state' => $classified->state
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);


					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;

		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;

	}

	/**
	 * --- Jobs Listings ---
	 */
	public function get_all_old_jobs_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_job_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function listing_jobs($page = 0)
	{
		// Jobs Listing ID: 50

		// 1,2 3 page

		exit('already merged');
		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$jobs = $this->get_all_old_jobs_listings($limit, $offset);

		if (empty($jobs))
			return true;

		foreach ($jobs as $job) {

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $job->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $job->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($job->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($job->id))->where('ad_type_id', $job->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $job->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = '';
			} else {
				$category_id = '';
			}
			unset($old_subcategory_name);
			unset($category);

			$data = [
				'title' => $job->ad_title,
				'slug' => $job->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => 50,
				'sub_category_id' => $category_id,
				'description' => $job->ad_description,
				'status' => $status,
				'views' => $job->views,
				'seo_description' => $job->seo_description,
				'seo_keywords' => $job->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($job->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			$listing_types = ['featured', 'recommended'];

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $job->id,
					'old_listing_user_id' => $job->user_id,
					'phone' => $job->ad_contact,
					'career' => $job->ad_career,
					'minimumexperience' => $job->ad_work_exp,
					'min-education' => $job->ad_edu_level,
					'salary' => $job->ad_salary,
					'currency_code' => $job->currency_code,
					'companyname' => $job->ad_company,
					'cv_req' => $job->ad_cv_req,
					'beneifts' => $job->ad_benefits,
					'skill' => $job->ad_skills,
					'listed' => $job->ad_listed,
					'companysize' => $job->ad_co_size,
					'images_from' => $ad_images,
					'is_from_old_table' => 1,
					'listing_type' => $listing_types[ rand(0,1) ],
					'old_listing_data__ad_state' => $job->ad_state,
					'old_listing_data__ad_city' => $job->ad_city,
					'old_listing_data__ad_geolocation' => $job->ad_geolocation,
					'old_listing_data__formsubid' => $job->formsubid,
					'old_listing_data__ad_emp_type' => $job->ad_emp_type,
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);


					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;

		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;

	}


	/**
	 * --- Jobs Wanted Listings ---
	 */
	public function get_all_old_jobs_wanted_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_job_wanted_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function listing_jobs_wanted($page)
	{
		// Jobs Wanted Listing ID: 108

		// 1,2 3 page

		exit('already merged');

		$this->print_header_info($page);

		$per_page = 500;
		$offset = 500;
		$limit = 500;
		$offset = $offset + ( ($page-1) * $per_page );

		$jobs_wanted = $this->get_all_old_jobs_wanted_listings($limit, $offset);

		if (empty($jobs_wanted))
			return true;

		foreach ($jobs_wanted as $job_wanted) {

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $job_wanted->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $job_wanted->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($job_wanted->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($job_wanted->id))
				->where('ad_type_id', $job_wanted->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $job_wanted->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = '';
			} else {
				$category_id = '';
			}
			unset($old_subcategory_name);
			unset($category);

			$data = [
				'title' => $job_wanted->job_title,
				'slug' => $job_wanted->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => 108,
				'sub_category_id' => ($category_id === null) ? 0 : $category_id,
				'description' => $job_wanted->description,
				'status' => $status,
				'views' => ($job_wanted->views === null) ? 0 : $job_wanted->views,
				'seo_description' => ($job_wanted->seo_description === null) ? '' : $job_wanted->seo_description,
				'seo_keywords' => ($job_wanted->seo_keyword === null) ? '' : $job_wanted->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($job_wanted->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $job_wanted->id,
					'old_listing_user_id' => $job_wanted->user_id,
					'phone' => $job_wanted->contact,
					'minimumexperience' => $job_wanted->Experience,
					'min-education' => $job_wanted->Education,
					'currentposition' => $job_wanted->current_postion,
					'currentcompany' => $job_wanted->current_company,
					'gender' => $job_wanted->gender,
					'jobtype' => $job_wanted->emp_type,
					'skill' => $job_wanted->skills,
					'cv' => $job_wanted->post_cv,
					'name' => $job_wanted->name,
					'address' => $job_wanted->address,
					'salary' => $job_wanted->salary,
					'currency_code' => $job_wanted->currency_code,
					'companyname' => $job_wanted->current_company,
					'is_from_old_table' => 1,
					'listing_type' => 'recommended',
					'old_listing_data__formsubid' => $job_wanted->formsubid,
					'old_listing_data__ad_state' => $job_wanted->ad_state,
					'old_listing_data__ad_location' => $job_wanted->ad_location,
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);


					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;

		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}


	/**
	 * --- Properties Listings ---
	 */
	public function get_all_old_properties_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_properties_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function listing_properties_merge($page)
	{
		exit('already merged');

		$property_for_rend_id = 17;
		$property_for_sale_id = 10;

		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$properties = $this->get_all_old_properties_listings($limit, $offset);

		if (empty($properties))
			return true;

		foreach ($properties as $property) {

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $property->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $property->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($property->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($property->id))
				->where('ad_type_id', $property->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $property->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = 0;
			} else {
				$category_id = 0;
			}
			unset($old_subcategory_name);
			unset($category);

			// Parent Category ID
			if (! empty($category_id)){
				$parent_ids_arr = $this->db->select('parent_ids')
					->from('categories')
					->where('id', $category_id)
					->get()->row();

				if (empty($parent_ids_arr) || $parent_ids_arr === null){
					$parent_id = 0;
				}else {
					$parent_id = $parent_ids_arr->parent_ids;
				}
			}else {
				$parent_id = 0;
			}
			unset($parent_ids_arr);



			$data = [
				'title' => $property->ad_title,
				'slug' => $property->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => $parent_id,
				'sub_category_id' => ($category_id === null) ? 0 : $category_id,
				'description' => $property->ad_description,
				'status' => $status,
				'views' => ($property->views === null) ? 0 : $property->views,
				'seo_description' => ($property->seo_description === null) ? '' : $property->seo_description,
				'seo_keywords' => ($property->seo_keyword === null) ? '' : $property->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($property->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			$listing_types = ['featured', 'recommended'];


			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $property->id,
					'old_listing_user_id' => $property->user_id,
					'phone' => ($property->ad_contact === null) ? '' : $property->ad_contact,
					'price' => $property->ad_price,
					'currency_code' => ($property->currency_code === null) ? '' : $property->currency_code,
					'size' => $property->ad_size,
					'zone' => $property->ad_zone_for,
					'listed' => $property->ad_listed_by,
					'rooms' => $property->ad_bedrooms,
					'bathrooms' => $property->ad_bathrooms,
					'furnished' => $property->ad_is_furnished,
					'rentpaid' => $property->ad_rent_paid,
					'propertylocation' => $property->ad_property_location,
					'listing_type' => $listing_types[ rand(0,1) ],
					'images_from' => $ad_images,

					'old_listing_data__ad_total_closing_fee' => $property->ad_total_closing_fee,
					'old_listing_data__ad_property_ref_id' => $property->ad_property_ref_id,
					'old_listing_data__ad_free_hold' => $property->ad_free_hold,
					'old_listing_data__ad_post_datetime' => $property->ad_post_datetime,
					'old_listing_data__ad_my_company' => $property->ad_my_company,
					'old_listing_data__ad_company_size' => $property->ad_company_size,
					'old_listing_data__ad_country' => $property->ad_country,
					'old_listing_data__state' => $property->state,
					'old_listing_data__ad_location' => $property->ad_location,
					'old_listing_data__timestamp' => $property->timestamp,
					'old_listing_data__ad_rera_landlord' => $property->ad_rera_landlord,
					'old_listing_data__ad_rera_property_status' => $property->ad_rera_property_status,
					'old_listing_data__ad_rera_title_dead_num' => $property->ad_rera_title_dead_num,
					'old_listing_data__ad_rera_pre_reg_num' => $property->ad_rera_pre_reg_num
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);

					if (!$is_inserted) {
						break;
					}


				}
			} else
				break;


		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}

	/**
	 * --- Services Listings ---
	 */
	public function get_all_old_services_listings($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_services_listings_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function services_listing_merge($page)
	{
		// Service Cat ID: 110

		exit('already merged');

		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$services = $this->get_all_old_services_listings($limit, $offset);

		if (empty($services))
			return true;

		foreach ($services as $service) {

			//volgo_debug($service);

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $service->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $service->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info) || empty($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($service->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($service->id))
				->where('ad_type_id', $service->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Sub Category name
			$old_subcategory_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $service->formsubid)->get()->row();

			if ($old_subcategory_name !== NULL && is_object($old_subcategory_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_subcategory_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = 0;
			} else {
				$category_id = 0;
			}
			unset($old_subcategory_name);
			unset($category);

			// Parent Category ID
			$parent_id = 110;



			$data = [
				'title' => $service->ad_title,
				'slug' => $service->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => $parent_id,
				'sub_category_id' => ($category_id === null) ? 0 : $category_id,
				'description' => $service->ad_description,
				'status' => $status,
				'views' => ($service->views === null) ? 0 : $service->views,
				'seo_description' => ($service->seo_description === null) ? '' : $service->seo_description,
				'seo_keywords' => ($service->seo_keyword === null) ? '' : $service->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($service->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $service->id,
					'old_listing_user_id' => $service->user_id,
					'phone' => ($service->ad_contact === null) ? '' : $service->ad_contact,
					'price' => ($service->ad_price === null) ? '' : $service->ad_price,
					'currency_code' => ($service->currency_code === null) ? '' : $service->currency_code,
					'listing_type' => 'featured',
					'images_from' => $ad_images,
					'listed' => $service->ad_listed_by,

					'old_listing_data__ad_my_company' => $service->ad_my_company,
					'old_listing_data__ad_company_size' => $service->ad_company_size,
					'old_listing_data__ad_country' => $service->ad_country,
					'old_listing_data__state' => $service->state,
					'old_listing_data__ad_location' => $service->ad_location,
					'old_listing_data__ad_post_datetime' => $service->ad_post_datetime
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);

					if (!$is_inserted) {
						break;
					}


				}
			} else
				break;


		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}


	/**
	 * --- Buying Leads ---
	 */
	public function get_all_old_buying_leads($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_buying_leads_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function merge_buying_leads($page)
	{
		exit('merged-already');
		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$buying_leads = $this->get_all_old_buying_leads($limit, $offset);

		if (empty($buying_leads))
			return true;

		foreach ($buying_leads as $buying_lead) {

			//volgo_debug($service);

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $buying_lead->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $buying_lead->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info) || empty($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($buying_lead->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($buying_lead->id))
				->where('ad_type_id', $buying_lead->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Category name
			$old_category_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $buying_lead->formsubid)->get()->row();

			if ($old_category_name !== NULL && is_object($old_category_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_category_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = 0;
			} else {
				$category_id = 0;
			}
			unset($old_category_name);
			unset($category);


			// Sub Category name
			$old_sub_category_name = $this->db->select('s.fs_name')
				->from('features_cat s')
				->where('s.id', $buying_lead->ad_category)->get()->row();

			if ($old_sub_category_name !== NULL && is_object($old_sub_category_name)) {
				$sub_category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_sub_category_name->fs_name)
					->get()
					->row();

				if (! empty($sub_category))
					$sub_category_id = $sub_category->id;
				else
					$sub_category_id = 0;
			} else {
				$sub_category_id = 0;
			}
			unset($old_sub_category_name);
			unset($sub_category);

			$data = [
				'title' => $buying_lead->ad_title,
				'slug' => $buying_lead->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => ($category_id === null) ? 0 : $category_id,
				'sub_category_id' => ($sub_category_id === null) ? 0 : $sub_category_id,
				'description' => $buying_lead->ad_description,
				'status' => $status,
				'views' => ($buying_lead->views === null) ? 0 : $buying_lead->views,
				'seo_description' => ($buying_lead->seo_description === null) ? '' : $buying_lead->seo_description,
				'seo_keywords' => ($buying_lead->seo_keyword === null) ? '' : $buying_lead->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($buying_lead->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $buying_lead->id,
					'old_listing_user_id' => $buying_lead->user_id,
					'phone' => ($buying_lead->ad_contact === null) ? '' : $buying_lead->ad_contact,
					'email' => $buying_lead->ad_email,
					'fname' => $buying_lead->ad_first_name,
					'lname' => $buying_lead->ad_last_name,
					'listed' => ($buying_lead->ad_listed_by === null) ? '' : $buying_lead->ad_listed_by,
					'companyname' => $buying_lead->ad_my_company,
					'listing_type' => 'buying_lead',
					'images_from' => $ad_images,

					'old_listing_data__ad_location' => $buying_lead->ad_location,
					'old_listing_data__ad_company_size' => $buying_lead->ad_company_size,
					'old_listing_data__ad_country' => $buying_lead->ad_country,
					'old_listing_data__ad_post_datetime' => $buying_lead->ad_post_datetime,
					'old_listing_data__excel_site' => $buying_lead->excel_site,
					'old_listing_data__excel_status' => $buying_lead->excel_status,
					'old_listing_data__state' => $buying_lead->state,
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);

					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;


		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}


	/**
	 * --- Selling Leads ---
	 */
	public function get_all_old_selling_leads($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_seller_leads_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function merge_selling_leads($page)
	{
		exit('already merged');

		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$selling_leads = $this->get_all_old_selling_leads($limit, $offset);

		if (empty($selling_leads))
			return true;

		foreach ($selling_leads as $selling_lead) {

			//volgo_debug($service);

			// GET user email from user id - from old table
			$old_user_data = $this->db->select('email')->from('users')->where('id', $selling_lead->user_id)->get()->row();

			// Get user id from user email - from new table
			if ($old_user_data !== NULL && is_object($old_user_data)) {
				$new_user_data = $this->db->select('id')->from('b2b_users')->where('email', $old_user_data->email)->get()->row();
				$user_id = $new_user_data->id;

				unset($new_user_data);
			} else {
				$user_id = '1';
			}
			unset($old_user_data);


			// Get State Id and City id from Country Id
			$country_info = $this->db->select('id')->from('b2b_countries')->where('shortname', $selling_lead->ad_country)->limit(1)->get()->row();

			if ($country_info === NULL || !is_object($country_info) || empty($country_info))
				$country_id = 0;
			else
				$country_id = $country_info->id;


			//@todo: State is pending because we don't have the short name field in our new states table..
			/*if ($country_id && ($country_id !== 0)){
				$state_info = $this->db->select('id')->from('b2b_states')->where('country_id', $country_id)->limit(1)->get()->row();

				if ($state_info === NULL || !is_object($state_info))
					$state_id = 0;
				else
					$state_id = $state_info->id;
			}*/


			if (intval($selling_lead->status) === 1)
				$status = 'enabled';
			else
				$status = 'disabled';

			unset($country_info);

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')
				->where('ad_id', intval($selling_lead->id))
				->where('ad_type_id', $selling_lead->formsubid)
				->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Category name
			$old_category_name = $this->db->select('s.heading')
				->from('subpages s')
				->where('s.id', $selling_lead->formsubid)->get()->row();

			if ($old_category_name !== NULL && is_object($old_category_name)) {
				$category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_category_name->heading)
					->get()
					->row();

				if (! empty($category))
					$category_id = $category->id;
				else
					$category_id = 0;
			} else {
				$category_id = 0;
			}
			unset($old_category_name);
			unset($category);


			// Sub Category name
			$old_sub_category_name = $this->db->select('s.fs_name')
				->from('features_cat s')
				->where('s.id', $selling_lead->ad_category)->get()->row();

			if ($old_sub_category_name !== NULL && is_object($old_sub_category_name)) {
				$sub_category = $this->db->select('id')
					->from('categories c')
					->where('c.name', $old_sub_category_name->fs_name)
					->get()
					->row();

				if (! empty($sub_category))
					$sub_category_id = $sub_category->id;
				else
					$sub_category_id = 0;
			} else {
				$sub_category_id = 0;
			}
			unset($old_sub_category_name);
			unset($sub_category);


			$data = [
				'title' => $selling_lead->ad_title,
				'slug' => $selling_lead->ad_shortname,
				'uid' => $user_id,
				'country_id' => $country_id,
				'category_id' => ($category_id === null) ? 0 : $category_id,
				'sub_category_id' => ($sub_category_id === null) ? 0 : $sub_category_id,
				'description' => $selling_lead->ad_description,
				'status' => $status,
				'views' => ($selling_lead->views === null) ? 0 : $selling_lead->views,
				'seo_description' => ($selling_lead->seo_description === null) ? '' : $selling_lead->seo_description,
				'seo_keywords' => ($selling_lead->seo_keyword === null) ? '' : $selling_lead->seo_keyword,
				'created_at' =>  date("Y-m-d H:i:s", (strtotime($selling_lead->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_listing_id' => $selling_lead->id,
					'old_listing_user_id' => $selling_lead->user_id,
					'phone' => ($selling_lead->ad_contact === null) ? '' : $selling_lead->ad_contact,
					'email' => $selling_lead->ad_email,
					'fname' => $selling_lead->ad_first_name,
					'lname' => $selling_lead->ad_last_name,
					'listed' => $selling_lead->ad_listed_by,
					'companyname' => $selling_lead->ad_my_company,
					'listing_type' => 'seller_lead',
					'images_from' => $ad_images,

					'old_listing_data__ad_location' => $selling_lead->ad_location,
					'old_listing_data__ad_company_size' => $selling_lead->ad_company_size,
					'old_listing_data__ad_country' => $selling_lead->ad_country,
					'old_listing_data__ad_post_datetime' => $selling_lead->ad_post_datetime,
					'old_listing_data__excel_site' => $selling_lead->excel_site,
					'old_listing_data__excel_status' => $selling_lead->excel_status,
					'old_listing_data__state' => $selling_lead->state,
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'listings_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'listings_meta'
					);

					if (!$is_inserted) {
						break;
					}


				}
			} else
				break;


		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}

	/**
	 * --- Tradeshow ---
	 */
	public function get_all_old_tradeshows($limit, $offset)
	{
		$this->db->select('*');
		$this->db->from($this->old_tradeshows_table);

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}
	public function merge_tradeshows($page)
	{
		exit('already done');
		$this->print_header_info($page);

		$per_page = 1000;
		$offset = 1000;
		$limit = 1000;
		$offset = $offset + ( ($page-1) * $per_page );

		$tradeshows = $this->get_all_old_tradeshows($limit, $offset);

		if (empty($tradeshows))
			return true;

		foreach ($tradeshows as $tradeshow) {
			$user_id = '1';

			// Ad images
			if (! empty($tradeshow->img)){
				$img_url = $tradeshow->img;
				$img_url_arr = explode('images/tradeshows/', $img_url);

				$ad_img = 'old-tradeshow-images/' . $img_url_arr[1];
				$ad_images = serialize($ad_img);
			}else {
				$ad_images = serialize([]);
			}


			$data = [
				'title' => $tradeshow->head,
				'slug' => ($tradeshow->slug === null) ? volgo_make_slug($tradeshow->head) : $tradeshow->slug,
				'user_id' => $user_id,
				//'content'	=> $tradeshow->detail,
				'type'	=> 'tradeshow',
				'featured_image'	=> $ad_images,
				'seo_title'	=> $tradeshow->head,
				'seo_slug'	=> ($tradeshow->slug === null) ? volgo_make_slug($tradeshow->head) : $tradeshow->slug,
				'seo_description'	=> htmlentities($tradeshow->detail),
				'date_time' =>  date("Y-m-d H:i:s", (strtotime($tradeshow->timestamp))),
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'posts'
			);
			unset($data);

			if ($is_inserted) {
				$meta_data = [
					'old_tradeshow_id' => $tradeshow->id,
					'starting_date' => $tradeshow->start_date,
					'ending_date' => $tradeshow->end_date,
					'ts_venue' => $tradeshow->venue,
					'old_listing_data__status' => $tradeshow->status,
					'old_listing_data__img_thumb' => $tradeshow->img_thumb,
					'old_listing_data__img' => $tradeshow->img
				];

				$last_insert_id = $this->db->insert_id();

				foreach ($meta_data as $meta_key => $meta_value) {
					$single_meta_data = [
						'meta_key' => $meta_key,
						'meta_value' => $meta_value,
						'post_id' => $last_insert_id
					];

					$this->db->set($single_meta_data);
					$is_inserted = $this->db->insert(
						'posts_meta'
					);

					if (!$is_inserted) {
						break;
					}
				}
			} else
				break;

		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}



	public function get_listing_ids_from_images($limit, $offset)
	{
		$this->db->select('listings_id');
		$this->db->from('listings_meta');
		$this->db->where('meta_key', 'images_from');

		return $this->db->limit($limit)->offset($offset)->get()->result();
	}

	public function get_listing_meta_by_id( $listing_id )
	{
		$this->db->select('*');
		$this->db->from('listings_meta');
		$this->db->where('meta_key', 'old_listing_id');
		$this->db->where('listings_id', $listing_id);

		return $this->db->get()->result();
	}

	public function update_images($page)
	{
		$per_page = 700;
		$offset = 700;
		$limit = 700;
		$offset = $offset + ( ($page-1) * $per_page );

		$autos_listings = $this->get_autos_listings($limit, $offset);

		if ( ( $page -1 ) <= 0 ){
			echo '<h1>Previous Page: 0</h1>';
		}else {
			echo '<h1>Previous Page: ' . ( $page -1 ) . '</h1>';
		}

		echo '<h1>Current Page: ' . $page . '</h1>';
		echo '<h1>Next Page: ' . ($page + 1) . '</h1>';

		if (empty($autos_listings))
			return true;


		foreach ($autos_listings as $auto_listing) {

			// Ad images
			$ad_images_arr = $this->db->select('full_image')->from('listing_images')->where('ad_id', intval($auto_listing->id))->where('ad_type_id', $auto_listing->formsubid)->get()->result();
			if ($ad_images_arr === null || !is_array($ad_images_arr) || empty($ad_images_arr)) {
				$ad_images = serialize([]);
			} else {
				$ad_images = [];
				foreach ($ad_images_arr as $image) {
					$ad_images [] = 'old-listing-images/' . $image->full_image;
				}

				$ad_images = serialize($ad_images);
			}
			unset($ad_images_arr);


			// Select This listing from new listings
			$listing_meta = $this->db->select('*')
				->from('listings_meta')
				->where('meta_key', 'old_listing_id')
				->where('meta_value', $auto_listing->id)
				->get()->result();


			echo $auto_listing->id . '<br />';
			echo $auto_listing->formsubid . '<br />';



			volgo_debug($listing_meta, true, false);
			echo '<hr />';



		}

	}

	/**
	 * @var $type string Either recommended or featured
	 */
	public function update_listing_type($type = 'recommended')
	{
		$listing_ids = $this->db->select('listings_id')->from('listings_meta')->group_by('listings_id')->get()->result();

		foreach ($listing_ids as $listing_id) {
			$meta_value = $this->db->select('meta_value')->from('listings_meta')->where('meta_key', 'listing_type')->where('listings_id', intval($listing_id->listings_id))->get()->result();

			if (!empty($meta_value))
				continue;

			$data = [
				'meta_key' => 'listing_type',
				'meta_value' => $type,
				'listings_id' => $listing_id->listings_id
			];

			$this->db->set($data);
			$is_inserted = $this->db->insert(
				'listings_meta'
			);

			if (!$is_inserted)
				break;
		}

		if (!$is_inserted)
			volgo_debug("Data not inserted");

		return true;
	}

}
