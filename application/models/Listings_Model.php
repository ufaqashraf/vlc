<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/31/2019
 * Time: 4:57 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Listings_Model extends CI_Model
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

    public function get_latest_listings($limit = 9)
    {
        $this->db->cache_on();

        $this->db->select('l.id, l.title, l.slug, l.created_at');
        $this->db->from('listings as l');
        $this->db->where('l.status', 'enabled');
        $this->db->where('l.country_id', intval($this->country_info['country_id']));
        $this->db->order_by("id", "desc");
        $this->db->limit($limit);

        $result = $this->db->get();

        $this->db->cache_off();

        $listings = $result->result();

        return $listings;
    }

    public function get_save_search($idof_user){

        if ($idof_user != 'nologedin') {
            $this->db->select('id , user_id , meta_key , meta_value');
            $this->db->from('b2b_user_meta');
            $this->db->order_by('id');
            $this->db->where('user_id', $idof_user);
            $this->db->where('meta_key', 'fav_save_search');
            $query = $this->db->get();
            $fav_save_search = $query->result();
            return $fav_save_search;
        } else {
            return false;
        }

    }

    public function get_favlisting($idof_user)
    {

        if ($idof_user != 'nologedin') {



            $this->db->select('id , user_id , meta_key , meta_value');
            $this->db->from('b2b_user_meta');
            $this->db->order_by('id');
            $this->db->where('user_id', $idof_user);
            $this->db->where('meta_key', 'fav_add_dashboard');
            $query = $this->db->get();
            $fav_adds = $query->result();



            return $fav_adds;
        } else {
            return false;
        }
    }

    public function get_follow_listing($idof_user)
    {

        if ($idof_user != 'nologedin') {



            $this->db->select('id , user_id , meta_key , meta_value');
            $this->db->from('b2b_user_meta');
            $this->db->order_by('id');
            $this->db->where('user_id', $idof_user);
            $this->db->where('meta_key', 'follow_add_dashboard');
            $query = $this->db->get();
            $follow_adds = $query->result();



            return $follow_adds;
        } else {
            return false;
        }
    }

    public function get_buying_leads($limit = 4)
    {
        $this->db->cache_on();

        $this->db->select('l.id, l.title, l.created_at');
        $this->db->from('listings as l');
        $this->db->where('l.status', 'enabled');
        $this->db->where('l.country_id', intval($this->country_info['country_id']));
        $this->db->order_by("id", "desc");
        $this->db->limit($limit);

        $result = $this->db->get();

        $this->db->cache_off();

        $listings = $result->result();

        return $listings;
    }

    public function check_slug($slug)
    {
        $this->db->cache_on();

        $result = $this->db->query(
            "SELECT COUNT(*) AS NumHits FROM {$this->listing_table} WHERE slug like '$slug%'"
        );

        $row = $result->row();

        $this->db->cache_off();

        return $row->NumHits;
    }

    public function header_search($search_query, $page, $per_page_limit)
    {


        $country_id = intval($this->country_info['country_id']);
        if (intval($page) < 1)
            $page = 1;

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
					  LEFT join categories cc on cc.id = l.category_id
					  where cc.category_type = 'category' and l.status = 'enabled'
					  and l.country_id = {$country_id}
					  and l.title like '{$search_query}'
					  order by l.id desc
					  
					  {$per_page_limit}
					";

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
					  LEFT join categories cc on cc.id = l.category_id
					  where cc.category_type = 'category' and l.status = 'enabled'
					  and l.country_id = {$country_id}
					  and l.title like '{$search_query}'
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
                'result' => 'nolistingfound',
                'total_record' => 0,
            ];

            return $datapasserarray;
        }


    }

    public function header_advance_search($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit, $country_id = '')
    {
        if (intval($page) < 1)
            $page = 1;

        $use_inner_join = true;
        $search_query = '%' . $search_query . '%';
        $limit = $per_page_limit;
        $offset = (intval($per_page_limit) * intval(($page - 1))) ;
        $country_id = empty($country_id) ? volgo_get_country_id_from_session() : intval($this->country_info['country_id']);


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

        if (!empty($state))
            $extra_where .= ' and s.id = ' . intval($state);

        if (!empty($parent_cat))
            $extra_where .= ' and cc.id = ' . intval($parent_cat);

        if (!empty($child_cat))
            $extra_where .= ' and c.id = ' . intval($child_cat);

        if (!empty($search_query))
            $extra_where .= ' and l.title like \'%' . $search_query . '%\' ';

        // sorting
        if(isset($metas['sorting']) && !empty($metas['sorting'])){
            if($metas['sorting'] == 'asc'){
                $sorting = 'order by l.id ASC';
                $distict = 'DISTINCT listings_id';
                $starting_where = 'WHERE';
            }else if($metas['sorting'] == 'desc' || $metas['sorting'] == 'default'){
                $sorting = 'order by l.id DESC';
                $distict = 'DISTINCT listings_id';
                $starting_where = 'WHERE';
            }else if($metas['sorting'] == 'price-desc'){
                $sorting = 'order by CAST(lm.meta_value AS SIGNED INTEGER) DESC';
                $where_metas = "WHERE (lm.meta_key = 'price')";
                $distict = '*';
                $starting_where = ' AND';
            }else if($metas['sorting'] == 'price-asc'){
                $sorting = 'order by CAST(lm.meta_value AS SIGNED INTEGER) ASC';
                $where_metas = "WHERE (lm.meta_key = 'price')";
                $distict = '*';
                $starting_where = ' AND';
                // unset($metas);
            }
        }else{
            $sorting = 'order by l.id DESC';
            $distict = 'DISTINCT listings_id';
            $starting_where = 'WHERE';
        }
        unset($metas['sorting']);
        // Price Range
        if (isset($metas['pricefrom'], $metas['priceto']) && !empty($metas['pricefrom']) && !empty($metas['priceto'])) {
            $where_metas .= "{$starting_where} (lm.meta_key = 'price' and lm.meta_value BETWEEN ({$metas['pricefrom']}*1) and ({$metas['priceto']} * 1) )";
            $counter++;
        } else if (isset($metas['pricefrom']) && !empty($metas['pricefrom'])) {
            $where_metas .= "{$starting_where} (lm.meta_key = 'price' and lm.meta_value >= ({$metas['pricefrom']}*1) )";
            $counter++;
        } else if (isset($metas['priceto']) && !empty($metas['priceto'])) {
            $where_metas .= "{$starting_where} (lm.meta_key = 'price' and lm.meta_value <= ({$metas['priceto']}*1) )";
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

        // Seller Type - v1
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


        // Seller Type - v2
        if (isset($metas['listed']) && !empty($metas['listed'])) {

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            $where_metas .= "{$operator} (lm.meta_key = 'listed' and lm.meta_value like '{$metas['listed']}' )";
            $counter++;

        }
        unset($metas['listed']);



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


        // condition - Key Problems - Solve Key issues Here
        if (isset($metas['condition']) && !empty($metas['condition'])) {

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            $where_metas .= "{$operator} (lm.meta_key = 'condition' and lm.meta_value = '{$metas['condition']}' ) ";
            $counter++;

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            $where_metas .= "{$operator} (lm.meta_key = 'bodycondition' and lm.meta_value = '{$metas['condition']}' ) ";
            $counter++;
        }
        unset($metas['condition']);


        // ad extras - Search from serialize value
        if (isset($metas['ad_extras']) && !empty($metas['ad_extras']) && is_array($metas['ad_extras'])) {

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            foreach ($metas['ad_extras'] as $extra){
                $where_metas .= "{$operator} (lm.meta_key = 'ad_extras' and lm.meta_value REGEXP '{$extra}' ) ";

                // some values are store without underscore
                $extra = str_replace('_', ' ', $extra);
                $where_metas .= "{$operator} (lm.meta_key = 'ad_extras' and lm.meta_value REGEXP '{$extra}' ) ";

                $counter++;
            }
        }
        unset($metas['ad_extras']);


        // Check if CV is uploaded
        if ( isset($metas['cv_required']) && (strtolower($metas['cv_required']) === 'yes') ) {

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            $where_metas .= "{$operator} (lm.meta_key = 'cv_upload' and lm.meta_value != '' ) ";
            $counter++;
        }else if ( isset($metas['cv_required']) && (strtolower($metas['cv_required']) === 'no') ) {

            if ($counter === 0)
                $operator = ' WHERE ';
            else
                $operator = ' OR ';

            $where_metas .= "{$operator} (lm.meta_key = 'cv_upload' and lm.meta_value = '' ) ";
            $counter++;
        }
        unset($metas['cv_required']);

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
        unset($metas['per_page']);
        // =============================================================================
//==========================================ENDS======================================================================================


        foreach ($metas as $key => $value) {
            if (is_array($value)){

                // English Ads Only
                $value = isset($value[0]) ? $value[0] : '';

            }
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
						  {$distict}
						from listings_meta lm
						{$where_metas}  ) lm on lm.listings_id = l.id";
        }


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
					  {$sorting}
					{$per_page_limit};";

        //echo $query; exit;
        // var_dump($query);die;
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
					  {$sorting}
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

    public function get_total_rows()
    {
        $this->db->cache_on();

        $rows = $this->db->select('id')
            ->from($this->listing_table)
            ->where('status', 'enabled')
            ->where('country_id', intval($this->country_info['country_id']))->count_all_results();


        $this->db->cache_off();

        return $rows;
    }

    public function save_lisiting_and_meta($input_data)
    {
        $slug = volgo_make_slug($this->input->post('input_title'));
        $slug_count = intval($this->check_slug($slug));
        if ($slug_count > 0) {
            $slug = $slug . '-' . (++$slug_count);
        }

        $user_select = volgo_get_logged_in_user_id();
        $title_listing = $this->input->post('input_title');
        $description_listing = $this->input->post('input_description');
        $Selected_country = $this->input->post('input_country');
        $state_selected = $this->input->post('input_state');
        $selected_city = $this->input->post('input_city');
        $selected_category = $this->input->post('input_category');
        $selected_sub_category = $this->input->post('input_subcategory');

        unset($input_data['input_title']);
        unset($input_data['input_description']);
        unset($input_data['input_country']);
        unset($input_data['input_state']);
        unset($input_data['input_city']);
        unset($input_data['input_category']);
        unset($input_data['input_subcategory']);

        $data = array(
            'uid' => $user_select,
            'title' => $title_listing,
            'description' => $description_listing,
            'country_id' => $Selected_country,
            'state_id' => $state_selected,
            'city_id' => $selected_city,
            'category_id' => $selected_category,
            'sub_category_id' => $selected_sub_category,
            'slug' => $slug,
            'views' => 0,
            'status' => 'disabled', // @todo: HINT: this is disable because our team will check / verify and then enable this ad.
            'geo_location_lat_lng' => null,
            'created_at' => date("Y-m-d H:i:s"),
        );

        $this->db->set($data);

        $is_inserted = $this->db->insert(
            'listings'
        );

        if (!$is_inserted)
            return false;

        $listing_id = $this->db->insert_id();

        foreach ($input_data as $key => $value) {
            if (is_array($value)) {
                $value = serialize($value);
            }
            $data2 = array(
                'meta_key' => $key,
                'meta_value' => $value,
                'listings_id' => $listing_id,
            );

            //save data in database

            $this->db->set($data2);

            $is_inserted = $this->db->insert(
                'listings_meta'
            );
            if (!$is_inserted) {
                break;
            }
        }

        return $is_inserted;
    }

    public function get_listing_by_slug($slug)
    {
        $this->db->cache_on();

        //c.name as country_name, s.name as state, s.code as state_code
        $this->db->select('l.id as listing_id, l.title, l.slug, l.description, l.country_id, l.sub_category_id, l.created_at, c.parent_ids as sub_category,
		c.id as category_id, c.name as category_name, bu.firstname as first_name, bu.lastname as last_name, c.slug as category_slug, cn.name as country_name, ct.name as city_name, 
		bu.id as user_id, bu.username as user_name, bu.created_at as user_since, bu.email as user_email');
        $this->db->from($this->listing_table . ' as l');
        $this->db->join('b2b_countries as cn', 'cn.id = l.country_id', 'left');
        $this->db->join('b2b_cities as ct', 'ct.id = l.city_id', 'left');
        $this->db->join('b2b_users as bu', 'bu.id = l.uid', 'left');
        $this->db->join('listings_meta as lm', 'lm.listings_id = l.id', 'inner');
        $this->db->join('categories as c', 'c.id = l.category_id', 'left');

        $this->db->limit(1);
        $this->db->where('l.slug', $slug);

        $meta_result = [];
        $result = $this->db->get();
        $listing_info = $result->result();

        $this->db->cache_off();

        $listing_id = $listing_info[0]->listing_id;

        $user_id = $listing_info[0]->user_id;
        if (!empty($user_id)) {

            $this->db->cache_on();

            $this->db->select('*');
            $this->db->from('b2b_user_meta');
            $this->db->where('meta_key', 'user_image');
            $this->db->where('user_id', $user_id);
            $query = $this->db->get();
            $user_image = $query->result();

            $this->db->cache_off();

        } else {
            $user_image = '';
        }

        if (!empty($user_id)) {

            $this->db->cache_on();

            $this->db->select('*');
            $this->db->from('b2b_user_meta');
            $this->db->where('meta_key', 'Following');
            $this->db->where('meta_value', $user_id);
            $query = $this->db->get();
            $followed_by = $query->result();

            $this->db->cache_off();

        } else {
            $followed_by = '';
        }

        if (!empty($listing_id)) {

            $this->db->cache_on();

            $this->db->select('*');
            $this->db->from('b2b_user_meta');
            $this->db->where('meta_key', 'fav_add_dashboard');
            $this->db->where('meta_value', $listing_id);
            $query = $this->db->get();
            $fav_adss = $query->result();

            $this->db->cache_off();

        } else {
            $fav_adss = '';
        }


        if ($listing_info) {
            foreach ($listing_info as $single) {

                $this->db->cache_on();

                $this->db->select('*');
                $this->db->from('listings_meta');
                $this->db->where('listings_id', $single->listing_id);

                $result = $this->db->get();
                $listing_meta = $result->result();

                $this->db->cache_off();

                $meta_result['info'] = $listing_info;
                $meta_result['metas'] = $listing_meta;
                $meta_result['user_image'] = $user_image;
                $meta_result['followed_by'] = $followed_by;
                $meta_result['fav_adds'] = $fav_adss;

                return $meta_result;
            }

        }

        return [];

    }

    public function seller_send_reply($id)
    {
        $this->db->cache_on();

        $this->db->select('u.id, u.username, u.email, l.uid, l.slug');
        $this->db->from('b2b_users as u');
        $this->db->join('listings as l', 'u.id = l.uid', 'left');
        $this->db->where('u.id', $id);

        $query = $this->db->get();
        $user_data = $query->result();

        $this->db->cache_off();

        return $user_data;
    }

    public function get_autos_related_posts($related_post_current_id, $related_post_id)
    {

        $this->db->cache_on();

        $this->db->select('l.id , l.category_id , l.title, l.slug');
        $this->db->from('listings l');
        $this->db->where('l.category_id', $related_post_id);
        $this->db->where('l.status', 'enabled');
        $this->db->where('l.country_id', intval($this->country_info['country_id']));

        $array = array('category_id' => $related_post_id, 'l.id !=' => $related_post_current_id);
        $this->db->where($array);

        $this->db->order_by('l.id', 'desc');
        $this->db->limit(5);

        $meta_result = [];
        $result = $this->db->get();
        $listing_info = $result->result();

        $this->db->cache_off();

        if ($listing_info) {
            $meta_result['info'] = $listing_info;
            foreach ($listing_info as $single) {

                $this->db->cache_on();

                $this->db->select('*');
                $this->db->from('listings_meta');
                $this->db->where('listings_id', $single->id);

                $result = $this->db->get();
                $listing_meta = $result->result();

                $this->db->cache_off();

                $meta_result['metas'][] = $listing_meta;

            }

            return $meta_result;

        }
    }

    public function get_next_previous_posts($related_post_current_id, $next_previous)
    {

        $this->db->cache_on();

        $this->db->select('l.id , l.category_id , l.title, l.slug');
        $this->db->from('listings l');
        $this->db->where('l.category_id', $next_previous);
        $this->db->where('l.status', 'enabled');
        $this->db->where('l.country_id', intval($this->country_info['country_id']));

        $array = array('category_id' => $next_previous, 'l.id !=' => $related_post_current_id);
        $this->db->where($array);

        $this->db->order_by('l.id', 'desc');
        $this->db->limit(2);

        $meta_result = [];
        $result = $this->db->get();

        $this->db->cache_off();

        return $result->result();

    }

    public function letest_trade_show()
    {
        $this->db->cache_on();

        $this->db->select('p_te.id ,p_te.title, p_te.content, p_te.featured_image, p_te.slug');
        $this->db->select('pm_te.meta_value ,pm_te.meta_key');
        $this->db->from('posts as p_te');
        $this->db->join('posts_meta as pm_te', 'pm_te.post_id = p_te.id', 'left');
        $this->db->where('type', 'tradeshow');
        $this->db->order_by("id", "desc");

        $result = $this->db->get();
        $letest_trade_show = $result->result();

        $this->db->cache_off();

        return $letest_trade_show;
    }


    public function get_listings($limit = 9, array $listing_type = ['featured', 'recommended'])
    {
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $final_listings = [];
        foreach ($listing_type as $key => $type) {

            /*
             * @can be:
             * 	listings_ids_of_buying_lead_listings_4_records
             * 	listings_ids_of_featured_listings_9_records
             * 	listings_ids_of_recommended_listings_9_records
             * */
            $cache_key = 'listings_ids_of_' . $type . '_listings_' . $limit . '_records';
            if (! $listings_ids = $this->cache->get($cache_key)){
                // Query
                $listing_ids_query = "select lm.listings_id
										from listings_meta lm
										  left join listings l on l.id = lm.listings_id
										where lm.meta_key
											  = 'listing_type' and lm.meta_value = '{$type}'
										and l.status = 'enabled' and l.country_id = ".intval($this->country_info['country_id']) ." order by listings_id
										desc limit 9;";
                $listings_ids_q = $this->db->query($listing_ids_query);
                $listings_ids = $listings_ids_q->result();

                // Perform operation
                $listing_ids_arr = [];
                foreach ($listings_ids as $value){
                    $listing_ids_arr[] = $value->listings_id;
                }
                $listings_ids = implode(',', $listing_ids_arr);
                unset($listing_ids_query);
                unset($listings_ids_q);


                // Save Data
                $this->cache->save($cache_key, $listings_ids, MAX_CACHE_TTL_VALUE); // save for 72 hours

            }

            /*
             * @can be
             * 	latest_listings_of_buying_lead_listings_4_records
             *	latest_listings_of_featured_listings_9_records
             * 	latest_listings_of_recommended_listings_9_records
             * */
            $cache_key = 'latest_listings_of_' . $type . '_listings_' . $limit . '_records';
            if (! $listings = $this->cache->get($cache_key)){
                // Query
                $query = $this->db->query(
                    "SELECT l.id as listing_id, l.slug, l.title, c.id as category_id, c.name as category_name" .
                    " From listings as l" .
                    " inner JOIN categories c ON c.id = l.category_id " .
                    " WHERE l.id in ({$listings_ids})" .
                    " ORDER BY listing_id DESC" .
                    " limit {$limit}"
                );
                $listings = $query->result();
                unset($listings_ids);

                // Save Data
                $this->cache->save($cache_key, $listings, MAX_CACHE_TTL_VALUE); // save for 72 hours

            }

            $final_listings[$type] = $listings;

        }
        unset($key);
        unset($type);
        unset($listings);

        $new_arr = [];
        foreach ($final_listings as $type => $listings) {
            $listing_id = '';
            $listing_meta_info = [];
            $old_key = 0;

            foreach ($listings as $key => $val_arr) {
                if (empty($listing_id) || (intval($listing_id) !== intval($val_arr->listing_id))) {
                    $listing_id = $val_arr->listing_id;

                    $old_key = $key;
                    $new_arr[$type][$old_key]['listing_info'] = [
                        'listing_id' => $listing_id,
                        'listing_title' => $val_arr->title,
                        'listing_slug' => $val_arr->slug,
                    ];

                    $new_arr[$type][$old_key]['category_info'] = [
                        'category_id' => $val_arr->category_id,
                        'category_name' => $val_arr->category_name
                    ];


                    /*
                     * @can be
                     * 	listing_meta_35821
                     *	listing_meta_xxxxxxx (where xxxxx is listing id)
                     * */
                    $cache_key = 'listing_meta_'. $listing_id;
                    if (! $result = $this->cache->get($cache_key)){
                        // Query
                        $this->db->select('lm.id as listing_meta_id, lm.meta_key, lm.meta_value,');
                        $this->db->from('listings_meta as lm');
                        $this->db->where('listings_id', intval($listing_id));
                        $this->db->order_by("listings_id", "desc");

                        $result = $this->db->get()->result();

                        // Save Data
                        $this->cache->save($cache_key, $result, MAX_CACHE_TTL_VALUE); // save for 72 hours

                    }


                    $listing_meta_info = $result;

                }
                foreach ($listing_meta_info as $listing_meta) {
                    $new_arr[$type][$old_key]['metas'][] = [
                        'listing_meta_id' => isset($listing_meta->listing_meta_id) ? (int) $listing_meta->listing_meta_id : 0,
                        'meta_key' => $listing_meta->meta_key,
                        'meta_value' => $listing_meta->meta_value,
                    ];
                }
            }
        }


        return $new_arr;
    }




   // property search
	public function propertysearch($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit, $country_id = '')
	{
		if (intval($page) < 1)
			$page = 1;

		$use_inner_join = true;
		$limit = $per_page_limit;
		$offset = (intval($per_page_limit) * intval(($page - 1))) ;
		$country_id = empty($country_id) ? volgo_get_country_id_from_session() : intval($this->country_info['country_id']);


		if ($per_page_limit > 0) {
			$per_page_limit = " limit " . $per_page_limit . " offset " . $offset;
		} else {
			$per_page_limit = "";
		}

		// time periods
		if(isset($_GET['time']) && !empty($_GET['time'])){
			foreach($_GET['time'] as $time){
					if($time == 'day'){
							$day = 'day';
					}else if($time == 'week'){
							$week = 'day';
					}else if($time == 'month'){
							$month = 'month';
					}else{
							$year = 'year';
					}
			}
		}

		if (intval($limit) < 1)
			$limit = 1;


		$where_metas = '';
		$extra_where = '';
		$counter = 0;

		if (!empty($state))
			$extra_where .= ' and l.state_id = ' . intval($state);

		if (!empty($metas['select_city']))
			$extra_where .= ' and l.city_id = ' . intval($metas['select_city']);

		if (!empty($parent_cat))
			$extra_where .= ' and l.category_id = ' . intval($parent_cat);

		if (!empty($child_cat))
            $extra_where .= ' and l.sub_category_id = ' . intval($child_cat);
            
        if (!empty($search_query)){
            $search_query = '%' . $search_query . '%';
			$extra_where .= ' and l.title like \'' . $search_query . '\' ';
        }
		if(isset($year) && !empty($year)){
			$extra_where .= ' and l.created_at >= DATE(NOW()) - INTERVAL 365 DAY ';
		}else if(isset($month) && !empty($month)){
			$extra_where .= ' and l.created_at >= DATE(NOW()) - INTERVAL 30 DAY ';
		}else if(isset($week) && !empty($week)){
			$extra_where .= ' and l.created_at >= DATE(NOW()) - INTERVAL 7 DAY ';
		}else if(isset($day) && !empty($day)){
			$extra_where .= ' and l.created_at >= DATE(NOW()) - INTERVAL 1 DAY ';
		}
		// sorting
		if(isset($metas['sorting']) && !empty($metas['sorting'])){
			if($metas['sorting'] == 'asc'){
				$sorting = 'order by l.id ASC';
				$distict = 'DISTINCT listings_id';
				$starting_where = 'WHERE';
			}else if($metas['sorting'] == 'desc' || $metas['sorting'] == 'default'){
				$sorting = 'order by l.id DESC';
				$distict = 'DISTINCT listings_id';
				$starting_where = 'WHERE';
			}else if($metas['sorting'] == 'price-desc'){
				$sorting = 'order by CAST(lm.meta_value AS SIGNED INTEGER) DESC';
				$where_metas = "WHERE (lm.meta_key = 'price')";
				$distict = '*';
				$starting_where = ' AND';
			}else if($metas['sorting'] == 'price-asc'){
				$sorting = 'order by CAST(lm.meta_value AS SIGNED INTEGER) ASC';
				$where_metas = "WHERE (lm.meta_key = 'price')";
				$distict = '*';
				$starting_where = ' AND';
				unset($metas);
			}
	}else{
		$sorting = 'order by l.id DESC';
		$distict = 'DISTINCT listings_id';
		$starting_where = 'WHERE';
	}
	if(isset($metas)){
		// Price Range
		if(isset($metas['pricefrom']) && $metas['pricefrom'] == 0){
			unset($metas['pricefrom']);
		}
		if(isset($metas['priceto']) && $metas['priceto'] == 0){
			unset($metas['priceto']);
		}

		if (isset($metas['pricefrom'], $metas['priceto']) && !empty($metas['pricefrom']) && !empty($metas['priceto'])) {
			$where_metas .= "{$starting_where} (lm.meta_key = 'price' and CAST(lm.meta_value AS SIGNED INTEGER) BETWEEN ({$metas['pricefrom']}*1) and ({$metas['priceto']} * 1) )";
			$counter++;
		} else if (isset($metas['pricefrom']) && !empty($metas['pricefrom'])) {
			$where_metas .= "{$starting_where} (lm.meta_key = 'price' and CAST(lm.meta_value AS SIGNED INTEGER) >= ({$metas['pricefrom']}*1) )";
			$counter++;
		} else if (isset($metas['priceto']) && !empty($metas['priceto'])) {
			$where_metas .= "{$starting_where} (lm.meta_key = 'price' and CAST(lm.meta_value AS SIGNED INTEGER) <= ({$metas['priceto']}*1) )";
			$counter++;
		}
		unset($metas['pricefrom']);
		unset($metas['priceto']);
		// Buyer type
		if (isset($metas['buyertype']) && !empty($metas['buyertype'])) {

			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator} (lm.meta_key = 'listed' and lm.meta_value like '{$metas['buyertype']}' )";
			$counter++;

		}
        unset($metas['buyertype']);
		// furnished
		if (isset($metas['furnished']) && !empty($metas['furnished'])) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator}  (lm.meta_key = 'furnished' and lm.meta_value = '{$metas['furnished']}' )";
			$counter++;
		}
		unset($metas['furnished']);


		// Bedrooms Range
		if (isset($metas['rooms']) && !empty($metas['rooms']) && $metas['rooms'] != 0) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator}  (lm.meta_key = 'rooms' and CAST(lm.meta_value AS UNSIGNED INTEGER) <= ({$metas['rooms']}*1) )";
			$counter++;
		}
		unset($metas['rooms']);

		// Bathrooms Range
		if (isset($metas['bathrooms']) && !empty($metas['bathrooms']) && $metas['bathrooms'] != 0) {
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			$where_metas .= "{$operator}  (lm.meta_key = 'bathrooms' and CAST(lm.meta_value AS UNSIGNED INTEGER) <= ({$metas['bathrooms']}*1) )";
			$counter++;
		}
		unset($metas['bathrooms']);

		// Area Range
		if(isset($metas['min_area']) && !empty($metas['min_area'])){
			$min_area = $metas['min_area'];
		}
		if(isset($metas['max_area']) && !empty($metas['max_area'])){
			$max_area = $metas['max_area'];
		}
		if ($counter === 0)
			$operator = ' WHERE ';
		else
			$operator = ' OR ';

		if (isset($min_area, $max_area) && !empty($min_area) && !empty($max_area)) {
			$where_metas .= "{$operator} (lm.meta_key = 'size' and lm.meta_value BETWEEN '{$min_area}' and '{$max_area}' )";
			$counter++;
		} else if (isset($min_area) && !empty($min_area)) {
			$where_metas .= "{$operator} (lm.meta_key = 'size' and lm.meta_value >= '{$min_area}' )";
			$counter++;
		} else if (isset($max_area) && !empty($max_area)) {
			$where_metas .= "{$operator} (lm.meta_key = 'size' and lm.meta_value <= {$max_area} )";
			$counter++;
		}

		unset($metas['max_area']);
		unset($metas['min_area']);

	

		// unset meta
		unset($metas['time']);
		unset($metas['search_query']);
		unset($metas['select_city']);
		unset($metas['select_state']);
		unset($metas['parent_cat']);
		unset($metas['child_cats']);
		unset($metas['per_page']);
		unset($metas['time']);
		unset($metas['sorting']);

        // Amenities
		if (isset($metas['amenities']) && !empty($metas['amenities'])) {
            foreach($metas['amenities'] as $item){
                if ($counter === 0)
                    $operator = ' WHERE ';
                else
                    $operator = ' OR ';

                
                $where_metas .= "{$operator}  (lm.meta_key = 'amenities' and lm.meta_value = '{$item}' )";
                $counter++;
            }
			
		}
		unset($metas['bathrooms']);
			

		foreach ($metas as $key => $value) {
			if (is_array($value)){

				// English Ads Only
				$value = isset($value[0]) ? $value[0] : '';

			}
			if ($counter === 0)
				$operator = ' WHERE ';
			else
				$operator = ' OR ';

			if (empty($value))
				continue;

			$where_metas .= "{$operator} (lm.meta_key = '{$key}' and lm.meta_value = '{$value}' )";
			$counter++;
		}

	}


		if ($use_inner_join === true && !isset($inner_join_query)){
			// Inner Join
			$inner_join_query = "select {$distict}
						from listings_meta lm
						{$where_metas}  ) lm on lm.listings_id = l.id";
		}


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
					  left join b2b_states s on s.id = l.state_id
					  left join b2b_countries co on co.id = l.country_id
					inner join categories cc on cc.id = l.category_id
					inner join (
						{$inner_join_query}
					  where cc.category_type = 'category' and l.status = 'enabled' and l.country_id = {$country_id}
					   {$extra_where}
					   {$sorting}
					   {$per_page_limit};";

		//echo $query; exit;
		// var_dump($query);die;
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
						left join b2b_states s on s.id = l.state_id
					  left join b2b_countries co on co.id = l.country_id
					inner join categories cc on cc.id = l.category_id
					inner join (
						{$inner_join_query}
					  where cc.category_type = 'category' and l.status = 'enabled' and l.country_id = {$country_id}
					   {$extra_where}
						 {$sorting}
					";
		$total_records = $this->db->query($total_records);

		$this->db->cache_off();

		if (!empty($total_records->num_rows())) {

			$datapasserarray = [
				'result' => $result->result(),
				'total_record' => $total_records->num_rows(),
			];
			// save search query
			$loged_in_user_id = volgo_get_logged_in_user_id();

			// fetch data
			$search_history_data = "select * from search_history where query_title = '{$_GET['search_query']}' and category_id = {$parent_cat} and country_id = {$country_id} and users_id = 0 limit 1";
			$total_searchs = $this->db->query($search_history_data);
			$search_result = $total_searchs->result();

			// var_dump($search_result);die;
			if(count($search_result) > 0){
				$data = array(
					'count' => $search_result[0]->count+1,
				);
		
				$this->db->where('id', $search_result[0]->id);
				$this->db->update('search_history', $data);
			}else if(isset($_GET['search_query']) && !empty($_GET['search_query'])){
				// insert data in search table
                $url = 'listing/propertysearch?'.http_build_query(array_merge($_GET));
				$data = array(
					'count' => 1,
                    'country_id' => $country_id,
                    'category_id' => $parent_cat,
					'query_title' => $_GET['search_query'],
					'search_query' => $url,
					'created_at' => date("Y-m-d H:i:s")
				);

				$this->db->set($data);

				$is_inserted = $this->db->insert(
					'search_history'
				);
			}
		
			return ($this->cast_advance_header_search_result($datapasserarray));
		} else {
			$datapasserarray = [
				'result' => $result->result(),
				'total_record' => 0,
			];

			return ($this->cast_advance_header_search_result($datapasserarray));
		}


	}


// get selected city name
	public function selected_city_name($id=0){
		if($id > 0){
			$query = "select * from b2b_cities where state_id = {$id}";
			$this->db->cache_on();
			$result = $this->db->query($query);
			$this->db->cache_off();
			// var_dump($result->result());
			return $result->result();
		}
    }
    // get parent category
	public function parent_cat_id($cat_id){
        
		$query = "select parent_ids from categories where id = {$cat_id}";
        $result = $this->db->query($query);
        $data = $result->result();
        if($data[0]->parent_ids > 0){
            return $data[0]->parent_ids;
        }else{
            return $cat_id;
        }
        
	}
	// get popular search
	public function popular_searches($country_id,$cat_id){
        $parent_cat_id = $this->parent_cat_id($cat_id);
		$query = "select * from search_history where country_id = {$country_id} and category_id = {$parent_cat_id} and users_id = 0 order by count desc limit 10";
			$result = $this->db->query($query);
			// var_dump($result->result());
			return $result->result();
	}
	// get near by items
	public function nearby($country_id=0,$cat_id=0){
		if($country_id > 0 && $cat_id > 0){
          $parent_cat_id = $this->parent_cat_id($cat_id);
		  $query = "SELECT title,slug FROM `listings` where country_id = {$country_id} and category_id = {$parent_cat_id} order by id desc limit 5";
			$result = $this->db->query($query);
			// var_dump($result->result());
			return $result->result();
		}
	}

	// save search
	public function savesearch($raw_data,$user_id,$parent_cat){
        parse_str($_POST['data'], $get_data);
        // var_dump($raw_data);die;
        // countries
		$country_id = volgo_get_country_info_from_session();
		$country_id = $country_id['country_id'];
		if (isset($country_id)) {
			$country_id = $country_id;
		} else {
			$country_id = 166;
		}
		// fetch data
		$search_history_data = "select * from search_history where query_title = '{$get_data['search_query']}' and category_id = {$parent_cat} and country_id = {$country_id} and users_id = {$user_id} limit 1";
		$total_searchs = $this->db->query($search_history_data);
		$search_result = $total_searchs->result();

		// var_dump($search_result[0]->id);
		if(!empty($total_searchs->num_rows())){
			$data = array(
				'count' => $search_result[0]->count+1,
			);
	
			$this->db->where('id', $search_result[0]->id);
			$is_inserted =	$this->db->update('search_history', $data);

		}else if(isset($get_data['search_query']) && !empty($get_data['search_query'])){
			// insert data in search table
			$data = array(
				'count' => 1,
				'users_id' => $user_id,
                'country_id' => $country_id,
                'category_id' => $parent_cat,
				'query_title' => $get_data['search_query'],
				'search_query' => 'listing/propertysearch?'.$raw_data,
				'created_at' => date("Y-m-d H:i:s")
			);

			$this->db->set($data);

			$is_inserted = $this->db->insert(
				'search_history'
			);
		}
		return $is_inserted;
    }
    
    // remove search
    public function removesearch($raw_data,$user_id,$parent_cat){
        parse_str($_POST['data'], $get_data);
        // var_dump($raw_data);die;
        // countries
		$country_id = volgo_get_country_info_from_session();
		$country_id = $country_id['country_id'];
		if (isset($country_id)) {
			$country_id = $country_id;
		} else {
			$country_id = 166;
		}
		// fetch data
		$search_history_data = "select * from search_history where query_title = '{$get_data['search_query']}' and category_id = {$parent_cat} and country_id = {$country_id} and users_id = {$user_id} limit 1";
		$total_searchs = $this->db->query($search_history_data);
		$search_result = $total_searchs->result();

		// var_dump($search_result[0]->id);
		if(!empty($total_searchs->num_rows())){
			$this->db->where('id', $search_result[0]->id);
			$is_inserted =	$this->db->delete('search_history');

		}else{
            $is_inserted = false;
        }
		return $is_inserted;
	}


    // check membership
	public function user_membership_check($user_id){
        if($user_id > 0){
            $query = "select o.id as id,u.id as user_id,om.meta_value as available_connect,o.packages_id,o.order_date
            from b2b_users u
            left join orders o on o.user_id = u.id
            left join orders_meta om on om.order_id = o.id
            where u.id = {$user_id} and o.status = 'paid' order by o.order_date DESC limit 1";
            $this->db->cache_off();
            $result = $this->db->query($query);
            return $result->result(); 
        }
        
    }

    public function update_connects($id,$package_id,$connects){
        if($package_id != 3){
            $update = array(
                'meta_value' => $connects-1,
            );
            $this->db->where('order_id', $id);
            $this->db->update('orders_meta', $update);
        }
    }
    // reset membership
	public function reset_membership(){
        $query = "select id, packages_id from orders where status = 'paid' and order_date < DATE_ADD(order_date, INTERVAL 1 YEAR)";
        $this->db->cache_off();
        $result = $this->db->query($query);
        $data = $result->result(); 

        if($result->num_rows() > 0){
            foreach($data as $item){ 
                $connects = -1;
                if($item->packages_id === '1' ){
                    $connects = 10;
                }else if($item->packages_id === '2'){
                    $connects = 20;
                }
                if(isset($connects)){
                    // delete meta
                    $this->db->where('order_id', $item->id);
                    $this->db->delete('orders_meta');
                    // insert meta
                    $insert = [
                        'order_id' => $item->id,
                        'meta_key' => 'available_connect',
                        'meta_value' => $connects,
                        'orders_id' => $item->id
                    ];
                    $this->db->set($insert);
                    $this->db->insert('orders_meta');
                }
            }
        }
	}
}

