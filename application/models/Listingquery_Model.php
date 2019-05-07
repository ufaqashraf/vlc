<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/31/2019
 * Time: 4:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Listingquery_Model extends CI_Model
{

	public function sub_child_cats($id)
	{
		$this->db->cache_on();

		$this->db->select('c.id, c.name , c.slug');
		$this->db->from('categories as c');
		$this->db->where('c.parent_ids', $id);
		$result = $this->db->get();

		$this->db->cache_off();

		$return_sub_cats_by_id = $result->result();

		return $return_sub_cats_by_id;
	}

	public function total_listing_get($sub_child_id, $country_id)
	{
		$db_key = 'country_id_'.$country_id.'__total_count';
		$cache_key = 'country_id_'.$country_id.'_cat_id_'.intval($sub_child_id).'__total_count';
		
		
		// try to get from cache and if cache is not created then first we will look into categories meta table.
		if (! $count = $this->cache->get($cache_key)){
			// Query
			$count_meta = $this->db->select('meta_value')
				->from('categories_meta')
				->where('categories_id', intval($sub_child_id))
				->where('meta_key', $db_key)
				->limit(1)
				->get()->row();
			
			if (empty($count_meta)){
				// try to count the records, save into database (categories meta) and create cache after this if block -- Just here for backward compatibility
				
				//1) Count Records
				$result = $this->db->query("
								SELECT count(distinct (l.id)) as count
									FROM `listings` as `l`
									  inner join (select listings_id
												  from listings_meta
												  where meta_key = 'listing_type'
														and meta_value in ('recommended', 'featured')) as lm_id on lm_id.listings_id = l.id
									WHERE `l`.`sub_category_id` = 6
										  AND `country_id` = 166
										  AND `status` = 'enabled'
							");
				
				$count_row= $result->row();
				$count = $count_row->count;
				
				//2) save into categories meta for next usage. // insert
				
				$data = [
					'categories_id' => intval($sub_child_id),
					'meta_key'	=> $db_key,
					'meta_value'	=> $count,
					'created_at' => date("Y-m-d H:i:s"),
				];
				$this->db->set($data);
				
				$this->db->insert(
					'categories_meta'
				);
			}else {
				$count = $count_meta->meta_value;
			}
			
			
			// Save Data
			$this->cache->save($cache_key, $count, MAX_CACHE_TTL_VALUE);
			
		}
		
		return $count;
	}

	public function get_category_name($id)
	{
		$this->db->cache_on();

		$this->db->select('c.id, c.name');
		$this->db->from('categories as c');

		$this->db->where('id', $id);

		$result = $this->db->get();
		$return_cats_by_id = $result->result();

		$this->db->cache_off();

		if (!empty($return_cats_by_id)) {
			return volgo_make_slug($return_cats_by_id[0]->name);
		} else {
			return $return_cats_by_id;
		}

	}

	public function get_name_of_paent_cat($id)
	{

		$this->db->cache_on();

		$this->db->select('c.id, c.name , c.parent_ids');
		$this->db->from('categories as c');

		$this->db->where('id', $id);

		$result = $this->db->get();

		$return_cats_by_id = $result->result();
		if (!empty($return_cats_by_id)) {

			$parent_id = $return_cats_by_id[0]->parent_ids;

			if ($parent_id === 'uncategorised') {
				return '';
			} else {
				$parent_id = $parent_id;
			}
		} else {
			$parent_id = '';
		}


		if ($parent_id != 0) {


			$this->db->select('c.id, c.name ');
			$this->db->from('categories as c');

			$this->db->where('id', $parent_id);

			$result = $this->db->get();

			$parent_cat_id = $result->result();
		} else {
			$parent_cat_id = '';
		}



		if (!empty($parent_cat_id)) {
			return volgo_make_slug($parent_cat_id[0]->name);
		} else {
			return $parent_cat_id;
		}

	}


	public function get_parent_category_name($id)
	{
		$this->db->cache_on();

		$this->db->select('parent_ids');
		$this->db->from('categories as c');
		$this->db->where('id', $id);
		$this->db->limit(1);

		$result = $this->db->get();
		$parent_cat = $result->row();

		$this->db->cache_off();

		$this->db->cache_on();

		$parent_name = $this->db
			->select('c.name')
			->from('categories as c')
			->where('id', $parent_cat->parent_ids)
			->limit(1)
			->get()
			->row();

		$this->db->cache_off();

		if (empty($parent_name))
			return '';

		return volgo_make_slug($parent_name->name);
	}

	public function get_id_of_cat($cat_name)
	{
		$cat_name = volgo_make_slug($cat_name);

		$this->db->cache_on();

		$this->db->select('c.id, c.name');
		$this->db->from('categories as c');

		$this->db->where('slug', $cat_name);

		$result = $this->db->get();
		$return_cats_by_id = $result->result();

		$this->db->cache_off();


		return $return_cats_by_id;
	}

	public function record_count_listing($id, $country_id)
	{
		$db_key = 'country_id_'.$country_id.'__total_count_featured';
		$cache_key = 'country_id_'.$country_id.'_cat_id_'.intval($id).'__total_count_featured';
		
		// try to get from cache and if cache is not created then first we will look into categories meta table.
		if (! $count = $this->cache->get($cache_key)){
			// Query
			$count_meta = $this->db->select('meta_value')
				->from('categories_meta')
				->where('categories_id', intval($id))
				->where('meta_key', $db_key)
				->limit(1)
				->get()->row();
			
			if (empty($count_meta)){
				// try to count the records, save into database (categories meta) and create cache after this if block -- Just here for backward compatibility
				
				//1) Count Records
				$query = $this->db->query("
										SELECT COUNT(*) as total FROM listings l
										inner join (
										  select
											distinct listings_id
										  from listings_meta lm
										  where (lm.meta_key = 'listing_type' and lm.meta_value  = 'featured')
									  ) lm on lm.listings_id = l.id
									  where l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id}  or l.sub_category_id =  {$id} )
									");
				$totalrows = $query->row();
				$count = $totalrows->total;
				
				
				//2) save into categories meta for next usage. // insert
				
				$data = [
					'categories_id' => intval($id),
					'meta_key'	=> $db_key,
					'meta_value'	=> $count,
					'created_at' => date("Y-m-d H:i:s"),
				];
				$this->db->set($data);
				
				$this->db->insert(
					'categories_meta'
				);
			}else {
				$count = $count_meta->meta_value;
			}
			
			
			// Save Data
			$this->cache->save($cache_key, $count, MAX_CACHE_TTL_VALUE);
			
		}

		return $count;

	}

	public function record_count_listing2($id, $country_id)
	{
		$db_key = 'country_id_'.$country_id.'__total_count_recommended';
		$cache_key = 'country_id_'.$country_id.'_cat_id_'.intval($id).'__total_count_recommended';
		
		// try to get from cache and if cache is not created then first we will look into categories meta table.
		if (! $count = $this->cache->get($cache_key)){
			// Query
			$count_meta = $this->db->select('meta_value')
				->from('categories_meta')
				->where('categories_id', intval($id))
				->where('meta_key', $db_key)
				->limit(1)
				->get()->row();
			
			if (empty($count_meta)){
				// try to count the records, save into database (categories meta) and create cache after this if block -- Just here for backward compatibility
				
				//1) Count Records
				$query = $this->db->query("
										SELECT COUNT(*) as total FROM listings l
										inner join (
										  select
											distinct listings_id
										  from listings_meta lm
										  where (lm.meta_key = 'listing_type' and lm.meta_value  = 'recommended')
									  ) lm on lm.listings_id = l.id
									  where l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id}  or l.sub_category_id =  {$id} )
									");
				$totalrows = $query->row();
				$count = $totalrows->total;
				
				
				//2) save into categories meta for next usage. // insert
				
				$data = [
					'categories_id' => intval($id),
					'meta_key'	=> $db_key,
					'meta_value'	=> $count,
					'created_at' => date("Y-m-d H:i:s"),
				];
				$this->db->set($data);
				
				$this->db->insert(
					'categories_meta'
				);
			}else {
				$count = $count_meta->meta_value;
			}
			
			
			// Save Data
			$this->cache->save($cache_key, $count, MAX_CACHE_TTL_VALUE);
			
		}
		
		return $count;

	}


	public function listing_by_cat_id_featured($id, $per_page_limit = 0, $page, $country_id, $type = 'featured')
	{

		$limit = $per_page_limit;
		$offset = ($page - 1) * $per_page_limit;
		
		if ($per_page_limit === 0)
			$meta_limit = 10;
		else
			$meta_limit = $per_page_limit;

		if ($per_page_limit > 0) {
			$per_page_limit = " limit " . $per_page_limit . " offset " . $offset;
		} else {
			$per_page_limit = "";
		}

		if (intval($limit) < 1)
			$limit = 1;
		
		
		// ---- Get Listings IDS ---
		$cache_key = 'listing_ids_of_type_' . $type . '_limit_' . $meta_limit . '_records_cat_id_' . $id;
		if (! $listing_ids = $this->cache->get($cache_key)){
			// Query
			$result_data = $this->db->query(
				"select
				  distinct lm.listings_id
				from listings_meta lm
				  join listings l on l.id = lm.listings_id
				where (
				  lm.meta_key = 'listing_type' and lm.meta_value  = 'featured'
				)
				and l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id} or l.sub_category_id = {$id})
				order by lm.listings_id desc
				limit 10;"
			);
			
			$ids_arr = $result_data->result();
			
			$ids = [];
			foreach ($ids_arr as $id_arr){
				$ids[] = $id_arr->listings_id;
			}
			$listing_ids = implode(',', $ids);
			
			// Save Data
			$this->cache->save($cache_key, $listing_ids, MAX_CACHE_TTL_VALUE);
		}

		if(empty($listing_ids))
		    $listing_ids = 0;

//		volgo_debug($listing_ids);
		
		// ---- Get Listings Data ---
		$cache_key = 'listing_data_of_type_' . $type . '_limit_' . $meta_limit . '_records_cat_id_' . $id;
		if (! $listing_data = $this->cache->get($cache_key)){
			// Query
			$result = $this->db->query("
					select l.id, l.title , l.created_at , l.category_id, l.sub_category_id ,
						   l.country_id , l.state_id , l.city_id, l.slug ,cat.id as listingcatid, cat.name as catgory_name,
						   l.sub_category_id as listingsubcatid,  sub_cat.name as subcategoryname ,
						   cntry.name as country_name, cntry.id as country_id ,
						   cites.name as city_name, cites.id as city_id ,
						   stats.name as state_name, stats.id as state_id
					from listings l
			
				   inner join b2b_countries cntry on cntry.id = l.country_id
				   LEFT JOIN b2b_cities cites on cites.id = l.city_id
			
				   LEFT JOIN categories sub_cat on sub_cat.id = l.sub_category_id
				   LEFT join categories cat on cat.id = l.category_id
				   LEFT join b2b_states stats on stats.id = l.state_id
			
					where l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id} or l.sub_category_id = {$id})
					AND l.id in ({$listing_ids})
					order by l.id desc
					{$per_page_limit}
			");
			$listing_data = $result->result();
			
			// Save Data
			$this->cache->save($cache_key, $listing_data, MAX_CACHE_TTL_VALUE); // save for 72 hours
			
		}

		$anewarr = [];
		foreach ($listing_data as $single_cat_id) {
			
			$cache_key = 'listing_meta_' . intval($single_cat_id->id);
			if (! $meta_data = $this->cache->get($cache_key)){
				// Query
				$this->db->select('meta_key , meta_value');
				$this->db->from('listings_meta');
				$this->db->where('listings_id', intval($single_cat_id->id));
				$result = $this->db->get();
				$meta_data = $result->result();
				
				// Save Data
				$this->cache->save($cache_key, $meta_data, MAX_CACHE_TTL_VALUE); // save for 72 hours
				
			}
			$anewarr[] = [
				'lisitng_info' => $single_cat_id,
				'meta_info' => $meta_data
			];
		}

		return $anewarr;


	}

    public function listing_by_cat_id_recommended($id, $per_page_limit = 0, $page, $country_id, $type = 'recommended')
    {

        $limit = $per_page_limit;
        $offset = ($page - 1) * $per_page_limit;

        if ($per_page_limit === 0)
            $meta_limit = 10;
        else
            $meta_limit = $per_page_limit;

        if ($per_page_limit > 0) {
            $per_page_limit = " limit " . $per_page_limit . " offset " . $offset;
        } else {
            $per_page_limit = "";
        }

        if (intval($limit) < 1)
            $limit = 1;


        // ---- Get Listings IDS ---
        $cache_key = 'listing_ids_of_type_' . $type . '_limit_' . $meta_limit . '_records_cat_id_' . $id;
        if (! $listing_ids = $this->cache->get($cache_key)){
            // Query
            $result_data = $this->db->query(
                "select
				  distinct lm.listings_id
				from listings_meta lm
				  join listings l on l.id = lm.listings_id
				where (
				  lm.meta_key = 'listing_type' and lm.meta_value  = 'recommended'
				)
				and l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id} or l.sub_category_id = {$id})
				order by lm.listings_id desc
				limit 10;"
            );

            $ids_arr = $result_data->result();

            $ids = [];
            foreach ($ids_arr as $id_arr){
                $ids[] = $id_arr->listings_id;
            }
            $listing_ids = implode(',', $ids);

            // Save Data
            $this->cache->save($cache_key, $listing_ids, MAX_CACHE_TTL_VALUE);
        }

        if(empty($listing_ids))
            $listing_ids = 0;


        // ---- Get Listings Data ---
        $cache_key = 'listing_data_of_type_' . $type . '_limit_' . $meta_limit . '_records_cat_id_' . $id;
        if (! $listing_data = $this->cache->get($cache_key)){
            // Query
            $result = $this->db->query("
					select l.id, l.title , l.created_at , l.category_id, l.sub_category_id ,
						   l.country_id , l.state_id , l.city_id, l.slug ,cat.id as listingcatid, cat.name as catgory_name,
						   l.sub_category_id as listingsubcatid,  sub_cat.name as subcategoryname ,
						   cntry.name as country_name, cntry.id as country_id ,
						   cites.name as city_name, cites.id as city_id ,
						   stats.name as state_name, stats.id as state_id
					from listings l
			
				   inner join b2b_countries cntry on cntry.id = l.country_id
				   LEFT JOIN b2b_cities cites on cites.id = l.city_id
			
				   LEFT JOIN categories sub_cat on sub_cat.id = l.sub_category_id
				   LEFT join categories cat on cat.id = l.category_id
				   LEFT join b2b_states stats on stats.id = l.state_id
			
					where l.country_id = {$country_id} and  l.status = 'enabled' and (l.category_id =  {$id} or l.sub_category_id = {$id})
					AND l.id in ({$listing_ids})
					order by l.id desc
					{$per_page_limit}
			");
            $listing_data = $result->result();

            // Save Data
            $this->cache->save($cache_key, $listing_data, MAX_CACHE_TTL_VALUE); // save for 72 hours

        }

        $anewarr = [];
        foreach ($listing_data as $single_cat_id) {

            $cache_key = 'listing_meta_' . intval($single_cat_id->id);
            if (! $meta_data = $this->cache->get($cache_key)){
                // Query
                $this->db->select('meta_key , meta_value');
                $this->db->from('listings_meta');
                $this->db->where('listings_id', intval($single_cat_id->id));
                $result = $this->db->get();
                $meta_data = $result->result();

                // Save Data
                $this->cache->save($cache_key, $meta_data, MAX_CACHE_TTL_VALUE); // save for 72 hours

            }
            $anewarr[] = [
                'lisitng_info' => $single_cat_id,
                'meta_info' => $meta_data
            ];
        }

        return $anewarr;


    }
	
}

