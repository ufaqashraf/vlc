<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/1/2019
 * Time: 4:26 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Merge extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Merge_Model');

	}

	public function index()
	{
		echo 'this is merge';
	}

	public function users()
	{

		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->merge_users();

		if ($is_merged){
			echo '<h1>Users Merged Success!';
			exit;
		}

		volgo_debug($is_merged);

	}

	public function listings_autos($page = 0)
	{
		/*echo '<h2>Caution! Already Merged!</h2>';
		exit;*/

		$is_merged = $this->Merge_Model->merge_autos_listings($page);

		volgo_debug($is_merged);
		exit;

		$is_merged = $this->Merge_Model->update_listing_type('featured');

		if ($is_merged){
			echo '<h1>Autos Listings are Merged Successfully!';
			exit;
		}

		volgo_debug($is_merged);
	}

	public function listings_classified($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';

		exit;
		$is_merged = $this->Merge_Model->listing_classified($page);


		exit('updated');
		$is_merged = $this->Merge_Model->update_listing_type('featured');

		if ($is_merged){
			echo '<h1>Classified Listings are Merged Successfully!';
			exit;
		}

		volgo_debug($is_merged);
	}

	public function listings_jobs($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->listing_jobs($page);

		if ($is_merged){
			echo '<h1>Jobs Listings are Merged Successfully!';
			exit;
		}

		volgo_debug($is_merged);
	}

	public function listings_jobs_wanted($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->listing_jobs_wanted($page);

		if ($is_merged){
			echo '<h1>Jobs Wanted Listings are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

	public function listings_properties($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->listing_properties_merge($page);

		if ($is_merged){
			echo '<h1>Listing Properties are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

	public function services_listings($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->services_listing_merge($page);

		if ($is_merged){
			echo '<h1>Services Listings are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

	public function buying_leads($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->merge_buying_leads($page);

		if ($is_merged){
			echo '<h1>Buying Leads are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

	public function seller_leads($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->merge_selling_leads($page);

		if ($is_merged){
			echo '<h1>Selling Leads are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

	public function tradeshows_merge($page = 0)
	{
		echo '<h2>Caution! Already Merged!</h2>';
		exit;

		$is_merged = $this->Merge_Model->merge_tradeshows($page);

		if ($is_merged){
			echo '<h1>Tradeshows are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}


	public function duplicate_finder()
	{
		echo 'this is duplicate finder';
	}

	public function update_timestamps()
	{
		echo 'this is update timestamp';
	}


	public function update_images($page = 0)
	{
		$is_merged = $this->Merge_Model->update_images($page);

		if ($is_merged){
			echo '<h1>Images are Merged Successfully!';
			exit;
		}
		volgo_debug($is_merged);
	}

}
