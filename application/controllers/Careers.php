<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/28/2019
 * Time: 4:29 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Careers extends CI_Controller{

	public function index()
	{
		$this->load->view('frontend/careers/careers');
	}

}
