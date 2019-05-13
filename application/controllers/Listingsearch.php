<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/21/2019
 * Time: 4:18 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Listingsearch extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Blocks_Model');
		$this->load->model('Listingquery_Model');
		$this->load->model('Listingfilterquery_Model');
		$this->load->model('Dashboard_Model');
		$this->load->model('Listings_Model');
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}


	public function sidebar()
	{
		//select_country=166
		//&selected_city=5755
		//&make=acura
		//&model=
		//&phone=phone
		//&listedby=
		//&currency_code=PKR
		//&price=
		//&kilometers=kilometers
		//&bodycondition=0
		//&mechanicalcondition=0
		//&color=0
		//&year=
		//&cylinder=0
		//&transmission=0
		//&doors=0
		//&horspower=0
		//&warranty=0
		//&fueltype=0
		//&search_query=

		$get_data = $this->input->get();


		$counrty = isset($get_data['country_search']) ? $get_data['country_search'] : '';
		$state = isset($get_data['select_state']) ? $get_data['select_state'] : '';
		$city = isset($get_data['selected_city']) ? $get_data['selected_city'] : '';
		$parent_cat = isset($get_data['parent_cat_select']) ? $get_data['parent_cat_select'] : '';
		$child_cat = isset($get_data['child_cats']) ? $get_data['child_cats'] : '';
		$search_query = isset($get_data['search_query']) ? $get_data['search_query'] : '';

		unset ($get_data['country_search']);
		unset ($get_data['select_state']);
		unset ($get_data['selected_city']);
		unset ($get_data['parent_cat_select']);
		unset ($get_data['child_cats']);
		unset ($get_data['search_query']);


		$page = $this->input->get('per_page', TRUE);
		if (! isset($page)) {
			$page = 1;
		}
		$metas = $get_data;
 		$per_page_limit = 10;

		$listings = $this->Listings_Model->header_advance_search($state, $parent_cat, $child_cat, $search_query, $metas, $page, $per_page_limit, $counrty);

		$totalcounts = $listings['total_record'];

		unset ($listings['total_record']);


		$query_string =  $this->input->server('QUERY_STRING');

		$config = array();
		$config['page_query_string'] = TRUE;
		$config["base_url"] = base_url('/listingsearch/sidebar?').http_build_query(array_merge($_GET));

		$config['display_pages'] = TRUE;
		$config["total_rows"] = $totalcounts;
		$config["per_page"] = $per_page_limit;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 10;
		$config['uri_segment'] = 4;


		$config['full_tag_open'] = "<ul class='pagination dynamic_pagination'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active page-link"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '</a></li>';


		$config['attributes'] = array('class' => 'page-link');
		$config['prev_link'] = '<';
		$config['prev_tag_open'] = '<li class="page-link ">';
		$config['prev_tag_close'] = '</li>';


		$config['next_link'] = '>';
		$config['next_tag_open'] = '<li class="page-link page-link-next">';
		$config['next_tag_close'] = '</li>';


		$this->pagination->initialize($config);

		$str_links = $this->pagination->create_links();
		$total_count_row = '';

		$data = [
			'sub_childs_cats' => $total_count_row,
			'all_cuntry' => $this->Listingfilterquery_Model->get_all_countries(),
			'listing_by_cat_featured' => $listings,
			'all_cats' => $this->Listingfilterquery_Model->get_all_categories(),
			'cat_name' => '',
			'total_add' => $totalcounts,
		];

		if (isset($str_links))
			$data["links"] = explode('&nbsp;', $str_links);


		$this->load->view('frontend/listing_page/default-listing', $data);


	}


}
