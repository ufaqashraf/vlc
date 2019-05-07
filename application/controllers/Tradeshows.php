<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 4:29 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Tradeshows extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Tradeshow_Model');
        $this->load->model('Listingquery_Model');
        $this->load->model('Listingfilterquery_Model');
        $this->load->model('Listings_Model');
        $this->load->model('Blocks_Model');
	}

	public function index()
	{
		$trade_shows = $this->Tradeshow_Model->get_all();

		$this->load->view('frontend/tradeshows/all-tradeshows', ['tradeshows' => $trade_shows]);
	}
	public function show_by_slug($slug = '')
	{
		$tradeshow = [
		    'tradeshow_detail' => $this->Tradeshow_Model->get_by_slug($slug)
        ];

        $related_post_current_id = $tradeshow['tradeshow_detail']['0']['post_info']['post_id'];
        $next_previous = $tradeshow['tradeshow_detail']['0']['post_info']['post_id'];

        $tradeshow['related_tradeshows'] = $this->Tradeshow_Model->get_trade_related_posts($related_post_current_id);
        $tradeshow['next_previous_trade'] = $this->Tradeshow_Model->get_trade_next_previous_posts($next_previous);


        $this->load->view('frontend/tradeshows_detail_page/tradeshows_detail', $tradeshow);
	}

}
