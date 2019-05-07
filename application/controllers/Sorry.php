<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/1/2019
 * Time: 4:12 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Sorry extends CI_Controller
{

	public function index()
	{
		$this->load->view('frontend/sorry');
	}

}
