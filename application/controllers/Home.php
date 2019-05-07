<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Listings_Model');
		$this->load->model('Blocks_Model');
		$this->load->model('Categories_Model');
		$this->load->model('Adbanner_Model');
	}

	public function index()
	{
		$listings = $this->Listings_Model->get_listings(9);
		$single_tradeshow_merg = $this->Listings_Model->letest_trade_show();

		// get trade show
		$new_arr = [];
		$final_arr = $this->get_tradeshow_arr($single_tradeshow_merg, $new_arr);

		$data = [
			//'footer_block' => $this->Blocks_Model->get_block('footer_block'),
			'listings' => $listings,
			'buying_leads'	=> $this->Listings_Model->get_listings(4, ['buying_lead']),
			'new_listings' => $this->Listings_Model->get_latest_listings(5),
			'ad_banners'	=> $this->Adbanner_Model->get_rightside_banners(2),
			'trade_shows' => $final_arr,
			'metas_trade_show' => $new_arr,
			'main_categories'	=> $this->Categories_Model->get_main_cats_for_homepage_search()
		];


		$this->load->view('frontend/index', $data);
	}

	private function get_tradeshow_arr(array $single_tradeshow_merg, &$new_arr){
		$mergedfinal = [];

		foreach ($single_tradeshow_merg as $value) {
			$result2[] = (array)$value;
			$mergedfinal[] = array_merge(...$result2);
		}

		$id = '';
		foreach ($mergedfinal as $row) {
			if (empty($id) || (intval($id) !== $row['id'])) {
				$id = $row['id'];
				$new_arr[$id]['tradeshow_info'] = [
					'id' => $row['id'],
					'title' => $row['title'],
					'content' => $row['content'],
					'featured_image' => $row['featured_image'],
					'slug'	=> $row['slug']
				];
			}

			$new_arr[$id]['metas'][] = [
				'meta_key' => $row['meta_key'],
				'meta_value' => $row['meta_value']
			];
		}


		$new_arr = array_values($new_arr);
		$final_arr = [];

		foreach ($new_arr as $key => $single_value) {
			$final_arr[] = $single_value['tradeshow_info'];
		}

		return $final_arr;
	}

	public function ajax__get_states_by_country_id(){
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['country_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['country_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$states_std_arr = volgo_get_states_by_country_id($posted_data['country_id']);
		$states = [];
		foreach ($states_std_arr as $state){
			$states[] = (array) $state;
		}

		// Update User Session
		volgo_update_user_location_by_force($posted_data['country_id']);

		echo json_encode($states);
		exit;
	}

	public function ajax__get_child_cats_by_parent_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['parent_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['parent_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$child_cats = $this->Categories_Model->get_child_cats_by_parent_id($posted_data['parent_id']);
		echo json_encode($child_cats);
		exit;

	}

	public function ajax__header_search_form_by_child_cat_id()
	{
		$posted_data = filter_input_array(INPUT_POST);

		if (! $this->input->is_ajax_request() || !isset($posted_data['child_id'])) {
			exit('No direct script access allowed');
		}

		if (! intval($posted_data['child_id'])){
			echo json_encode(
				[
					'status' => 'error'
				]
			);
			exit;
		}

		$states_std_arr = $this->Categories_Model->get_header_form_by_id($posted_data['child_id']);
		$states = [];
		foreach ($states_std_arr as $state){
			$states[] = (array) $state;
		}
		//$states['status'] = 'success';

		echo json_encode($states);
		exit;
	}

}
