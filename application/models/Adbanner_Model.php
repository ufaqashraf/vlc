<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/4/2019
 * Time: 6:28 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Adbanner_Model extends CI_Model{
	private $tablename = 'ad_banners';

	public function get_rightside_banners($limit = 1, $where_display_unit = 'right-sidebar')
	{
		$this->db->cache_on();
		$this->db->select('id, unique_key, title, description, ad_code_image, ad_type, url');
		$this->db->from($this->tablename);

		if (! empty($where_display_unit))
			$this->db->where('display_unit', 'right-sidebar');

		$this->db->limit($limit);

		$query = $this->db->get();
		$banners = $query->result();
		$this->db->cache_off();

		return $banners;

	}
}
