<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Categories_Model');
        $this->load->model('Listings_Model');
    }

    public function index()
    {
        // Some code goes here
		echo 'this is categories controller';
    }

	public function show_by_slug($slug)
	{
		$this->load->view('frontend/category/single-category.php', ['slug' => $slug]);
    }

	public function buying_lead_show_by_slug($slug)
	{
		$country_name = $this->input->get('cc');
		$id = '';
		if (! empty($country_name) && ! is_null($country_name)){

			$country_name = volgo_decrypt_message($country_name);
			$country_data = volgo_get_country_id_by_name($country_name, 'id');
			if (! empty($country_data))
				$id = $country_data->id;
		}

		$data = [
			'buying_leads' => $this->Categories_Model->get_all_listings_by_cat_slug($slug, $id)
		];



		$this->load->view('frontend/buying-lead/all', $data);
    }

	public function seller_lead_show_by_slug($slug)
	{
		$country_name = $this->input->get('cc');
		$id = '';
		if (! empty($country_name) && ! is_null($country_name)){

			$country_name = volgo_decrypt_message($country_name);
			$country_data = volgo_get_country_id_by_name($country_name, 'id');
			if (! empty($country_data))
				$id = $country_data->id;
		}

		$data = [
			'seller_leads' => $this->Categories_Model->get_all_listings_by_cat_slug($slug, $id)
		];

		$this->load->view('frontend/seller-lead/all', $data);
	}
}
