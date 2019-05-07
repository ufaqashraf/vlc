<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('frontend/about_us/aboutus');
	}

	public function testing()
	{
		$this->load->driver('cache');

		echo '<pre>';
		var_dump($this->cache->memcached->cache_info());
		echo '</pre>';

		if ($this->cache->memcached->is_supported())
		{
			$data = $this->cache->memcached->get('foo');
			if (!$data){
				echo 'cache miss!<br />';
				$data = 'bar';
				$this->cache->memcached->save('foo',$data, 60);
			}
			echo $data;
			echo '<pre>';
			var_dump($this->cache->memcached->cache_info());
			echo '</pre>';
		}else
			exit('not supported');

		if (class_exists('memcached'))
			exit ('Loaded');
		else
			exit ('Not Loaded');


		if ($this->cache->get('all_countries')){
			return $this->cache->get('all_countries');
		}

		$this->cache->memcached->save('foo', 'bar', 10);
		$this->cache->save('all_countries', $all_countries = volgo_get_countries(), 300);

		var_dump($this->cache->cache_info());
		return $all_countries;
	}



}
