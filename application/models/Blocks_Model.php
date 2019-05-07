<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/21/2019
 * Time: 11:33 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Blocks_Model extends CI_Model{
	private $tablename = 'blocks';

	public function get_block($unique_key){
		$this->db->cache_on();
		$this->db->select('id, title, description, code');
		$this->db->from($this->tablename);
		$this->db->where('unique_key', $unique_key);
		$result = $this->db->get();
		$this->db->cache_off();
		return ( $result->result() );
	}
}
