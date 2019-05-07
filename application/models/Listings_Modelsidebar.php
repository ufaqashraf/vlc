<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/31/2019
 * Time: 4:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Listings_Modelsidebar extends CI_Model
{
	private $listing_table = 'listings';
	private $country_info = null;

	public function __construct()
	{
		parent::__construct();

		// Run Explicitly
		volgo_get_user_location();

		$this->country_info = volgo_get_country_info_from_session();
	}

	public function header_advance_search($counrty , $state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit)
	{

		if (intval($page) < 1)
			$page = 1;

		$use_inner_join = true;
		$search_query = '%' . $search_query . '%';
		$limit = $per_page_limit;
		$offset = ($page - 1) * $per_page_limit;


		if ($per_page_limit > 0) {
			$per_page_limit = " limit " . $per_page_limit . " offset " . $offset;
		} else {
			$per_page_limit = "";
		}

		if (intval($limit) < 1)
			$limit = 1;


		$where_metas = '';
		$extra_where = '';
		$counter = 0;
		if (!empty($counrty))
			$extra_where .= ' and l.country_id = ' . intval($counrty);

		if (!empty($state))
			$extra_where .= ' and s.id = ' . intval($state);

		if (!empty($parent_cat))
			$extra_where .= ' and cc.id = ' . intval($parent_cat);

		if (!empty($child_cat))
			$extra_where .= ' and c.id = ' . intval($child_cat);

		if (!empty($search_query))
			$extra_where .= ' and l.title like \'%' . $search_query . '%\' ';


		// Price Range
		if (isset($metas['pricefrom'], $metas['priceto']) && !empty($metas['pricefrom']) && !empty($metas['priceto'])) {
			$where_metas .= "WHERE (lm.meta_key = 'price' and lm.meta_value BETWEEN ({$metas['pricefrom']}*1) and ({$metas['priceto']} * 1) )";
			$counter++;
		} else if (isset($metas['pricefrom']) && !empty($metas['pricefrom'])) {
			$where_metas .= "WHERE (lm.meta_key = 'price' and lm.meta_value >= ({$metas['pricefrom']}*1) )";
			$counter++;
		} else if (isset($metas['priceto']) && !empty($metas['priceto'])) {
			$where_metas .= "WHERE (lm.meta_key = 'price' and lm.meta_value <= ({$metas['priceto']}*1) )";
			$counter++;
		}
		unset($metas['pricefrom']);
		unset($metas['priceto']);




		// Bedrooms Range
		if (isset($metas['bedroomsmin'], $metas['bedroomsmax']) && !empty($metas['bedroomsmin']) && !empty($metas['bedroomsmax'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'rooms' and lm.meta_value BETWEEN ({$metas['bedroomsmin']}*1) and ({$metas['bedroomsmax']} * 1) )";
			$counter++;
		} else if (isset($metas['bedroomsmin']) && !empty($metas['bedroomsmin'])) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator}  (lm.meta_key = 'rooms' and lm.meta_value >= ({$metas['bedroomsmin']}*1) )";
			$counter++;
		} else if (isset($metas['bedroomsmax']) && !empty($metas['bedroomsmax'])) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator}  (lm.meta_key = 'rooms' and lm.meta_value <= ({$metas['bedroomsmax']}*1) )";
			$counter++;
		}
		unset($metas['bedroomsmax']);
		unset($metas['bedroomsmin']);

		// Seller Type
		if (isset($metas['sellertype']) && !empty($metas['sellertype'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			if (strtolower($metas['sellertype']) === 'ow') {
				$seller_type = 'owner';
			} else if (strtolower($metas['sellertype']) === 'dl') {
				$seller_type = 'dealer';
			} else {
				$seller_type = 'certified';
			}

			$where_metas .= "{$operator} (lm.meta_key = 'listed' and lm.meta_value like '{$seller_type}' )";
			$counter++;

		}
		unset($metas['sellertype']);
		unset($seller_type);


		// Seller Type
		if (isset($metas['listedby']) && !empty($metas['listedby'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			if (strtolower($metas['listedby']) === 'ow') {
				$seller_type = 'owner';
			} else if (strtolower($metas['listedby']) === 'dl') {
				$seller_type = 'dealer';
			} else {
				$seller_type = 'certified';
			}

			$where_metas .= "{$operator} (lm.meta_key = 'listed' and lm.meta_value like {$seller_type} )";
			$counter++;




		}
		unset($metas['sellertype']);
		unset($seller_type);

		// make
		if (isset($metas['make']) && !empty($metas['make'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'make' and lm.meta_value like {$metas['make']} )";
			print_r($metas);
			exit();


		}

		// model
		if (isset($metas['model']) && !empty($metas['model'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'model' and lm.meta_value like {$metas['model']} )";



		}

		// model
		if (isset($metas['badges']) && !empty($metas['badges'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';


			foreach ($metas['badges']  as $key => $singlebadge){

			}

			$where_metas .= "{$operator} (lm.meta_key = 'model' and lm.meta_value like {$metas['model']} )";



		}



		// Year Range
		if (isset($metas['yearfrom'], $metas['yearto']) && !empty($metas['yearfrom']) && !empty($metas['yearto'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'year' and lm.meta_value BETWEEN {$metas['yearfrom']} and {$metas['yearto']}) ";
			$counter++;
		} else if (isset($metas['yearfrom']) && !empty($metas['yearfrom'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'year' and lm.meta_value >= {$metas['yearfrom']} ) ";
			$counter++;

		} else if (isset($metas['yearto']) && !empty($metas['yearto'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'year' and lm.meta_value <= {$metas['yearto']} ) ";
			$counter++;

		}
		unset($metas['yearfrom']);
		unset($metas['yearto']);


		// Kilometer Range
		if (isset($metas['kilometerfrom'], $metas['kilometerto']) && !empty($metas['kilometerfrom']) && !empty($metas['kilometerto'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'kilometers' and lm.meta_value BETWEEN {$metas['kilometerfrom']} and {$metas['kilometerto']}) ";
			$counter++;
		} else if (isset($metas['kilometerfrom']) && !empty($metas['kilometerfrom'])) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'kilometers' and lm.meta_value >= {$metas['kilometerfrom']} ) ";
			$counter++;
		} else if (isset($metas['kilometerto']) && !empty($metas['kilometerto'])) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'kilometers' and lm.meta_value <= {$metas['kilometerto']} ) ";
			$counter++;
		}
		unset($metas['kilometerfrom']);
		unset($metas['kilometerto']);

//================================================================================================================================
		// ==================================== Additional Meta =========================================


		// Price Only
		// Listing Type
		if (isset($metas['listing_type'], $metas['price_only'], $metas['photo_only']) && !empty($metas['listing_type'])){

			$use_inner_join = false;
			$where_metas = " (SELECT distinct ll.id
								FROM listings ll
									   INNER JOIN listings_meta lm1 ON (ll.id = lm1.listings_id)
									   INNER JOIN listings_meta AS lm2 ON (ll.id = lm2.listings_id)
									   INNER JOIN listings_meta AS lm3 ON (ll.id = lm3.listings_id)
								WHERE 1 = 1
								  AND (
									(lm1.meta_key = 'listing_type' AND lm1.meta_value = '{$metas['listing_type']}')
									AND
									(lm2.meta_key = 'price' AND lm2.meta_value > 0)
									AND
									(lm3.meta_key = 'images_from' AND lm3.meta_value != '' AND lm3.meta_value != 'a:0:{}')
								  ) 
								ORDER BY ll.id DESC )) ids on ids.id = l.id ";

			$inner_join_query = "$where_metas";

		}else if (isset($metas['listing_type'], $metas['price_only']) && !empty($metas['listing_type'])){

			$use_inner_join = false;
			$where_metas = " (SELECT distinct ll.id
								FROM listings ll
									   INNER JOIN listings_meta lm1 ON (ll.id = lm1.listings_id)
									   INNER JOIN listings_meta AS lm2 ON (ll.id = lm2.listings_id)
								WHERE 1 = 1
								  AND (
									(lm1.meta_key = 'listing_type' AND lm1.meta_value = '{$metas['listing_type']}')
									AND
									(lm2.meta_key = 'price' AND lm2.meta_value > 0)
								  ) 
								ORDER BY ll.id DESC )) ids on ids.id = l.id ";

			$inner_join_query = "$where_metas";

		}else if (isset($metas['listing_type'], $metas['photo_only']) && !empty($metas['listing_type'] )){

			$use_inner_join = false;
			$where_metas = " (SELECT ll.id
								FROM listings ll
									   INNER JOIN listings_meta lm1 ON (ll.id = lm1.listings_id)
									   INNER JOIN listings_meta AS lm2 ON (ll.id = lm2.listings_id)
								WHERE 1 = 1
								  AND (
									(lm1.meta_key = 'listing_type' AND lm1.meta_value = '{$metas['listing_type']}')
									AND
									(lm2.meta_key = 'images_from' AND lm2.meta_value != '' AND lm2.meta_value != 'a:0:{}')
								  )
								GROUP BY ll.id
								ORDER BY ll.id DESC)) ids on ids.id = l.id ";

			$inner_join_query = "$where_metas";

		}else if (isset($metas['price_only'])){

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' AND ';

			$where_metas .= "{$operator} (lm.meta_key = 'price' and lm.meta_value > 0 ) ";
			$counter++;

		}else if (isset($metas['photo_only'])){

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' AND ';

			$where_metas .= "{$operator} (lm.meta_key = 'images_from' AND lm.meta_value != '' AND lm.meta_value != 'a:0:{}' ) ";
			$counter++;

		}
		unset($metas['price_only']);
		unset($metas['photo_only']);
		unset($metas['listing_type']);

		// =============================================================================
//==========================================ENDS======================================================================================


		foreach ($metas as $key => $value) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			if (empty($value))
				continue;

			$where_metas .= "{$operator} (lm.meta_key = '{$key}' and lm.meta_value = '{$value}' )";
			$counter++;
		}

		$where_metas .= ' order by listings_id desc';


		if ($use_inner_join === true && !isset($inner_join_query)){
			// Inner Join
			$inner_join_query = "select
						  distinct listings_id
						from listings_meta lm
						{$where_metas}  ) lm on lm.listings_id = l.id";
		}

		$country_id = intval($counrty);

		$query = "select
					  l.id as listing_id,
					  u.id as user_id,
					  u.firstname,
					  u.lastname,
					  u.email,
					  cc.name as parent_category,
					  c.name as sub_category,
					  l.title,
					  l.description as listing_description,
					  l.country_id,
					  l.state_id,
					  l.city_id,
					  l.category_id,
					  l.sub_category_id,
					  l.status,
					  l.slug,
					  l.created_at,
					  ci.id as city_id,
					  ci.name as city_name,
					  ci.state_id,
					  s.name as state_name,
					  co.name as country,
					  co.phonecode,
					  co.shortname
					from listings l
					  left join b2b_users u on u.id = l.uid 
					  left join categories c on c.id = l.sub_category_id 
					  left join b2b_cities ci on ci.id = l.city_id
					  left join b2b_states s on s.id = ci.state_id
					  left join b2b_countries co on s.country_id = co.id
					inner join categories cc on cc.id = l.category_id
					inner join (
						{$inner_join_query}
					
					
					  where cc.category_type = 'category' and l.status = 'enabled' and l.country_id = {$country_id}
					   {$extra_where}
					  order by l.id desc
					{$per_page_limit};";


		$this->db->cache_on();
		$result = $this->db->query($query);
		$this->db->cache_off();




		$this->db->cache_on();
		$total_records = "select
					  l.id as listing_id,
					  u.id as user_id,
					  u.firstname,
					  u.lastname,
					  u.email,
					  cc.name as parent_category,
					  c.name as sub_category,
					  l.title,
					  l.description as listing_description,
					  l.country_id,
					  l.state_id,
					  l.city_id,
					  l.category_id,
					  l.sub_category_id,
					  l.status,
					  l.slug,
					  l.created_at,
					  ci.id as city_id,
					  ci.name as city_name,
					  ci.state_id,
					  s.name as state_name,
					  co.name as country,
					  co.phonecode,
					  co.shortname
					from listings l
					  left join b2b_users u on u.id = l.uid 
					  left join categories c on c.id = l.sub_category_id 
					  left join b2b_cities ci on ci.id = l.city_id
					  left join b2b_states s on s.id = ci.state_id
					  left join b2b_countries co on s.country_id = co.id
					inner join categories cc on cc.id = l.category_id
					inner join (
						{$inner_join_query}
					  where cc.category_type = 'category' and l.status = 'enabled' and l.country_id = {$country_id}
					   {$extra_where}
					  order by l.id desc
					";
		$total_records = $this->db->query($total_records);

		$this->db->cache_off();

		if (!empty($total_records->num_rows())) {

			$datapasserarray = [
				'result' => $result->result(),
				'total_record' => $total_records->num_rows(),
			];
			return ($this->cast_advance_header_search_result($datapasserarray));
		} else {
			$datapasserarray = [
				'result' => $result->result(),
				'total_record' => 0,
			];

			return ($this->cast_advance_header_search_result($datapasserarray));
		}


	}

	private function cast_advance_header_search_result($listings)
	{

		if (!is_array($listings['result']) || empty($listings['result']))
			return $listings;

		$return_arr = [];
		foreach ($listings['result'] as $listing) {

			$this->db->cache_on();

			$this->db->select('id, meta_key, meta_value');
			$this->db->from('listings_meta lm');
			$this->db->where('lm.listings_id', $listing->listing_id);
			$meta_data = $this->db->get();

			$this->db->cache_off();

			$meta_data = $meta_data->result_array();

			$return_arr[] = [
				'listing_details' => (array)$listing,
				'metas' => (array)$meta_data,

			];
		}
		$return_arr['total_record'] = $listings['total_record'];


		return $return_arr;

	}


}
