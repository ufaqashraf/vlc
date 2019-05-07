<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 4:03 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Page_Model');
	}

	public function index()
	{

	}


	public function show_by_slug($slug = '')
	{
		$page = $this->Page_Model->get_by_slug($slug);

		// @ todo: Pending
		echo '<h1>Write functionality for single page.</h1>';
		var_export($page);
	}

}
