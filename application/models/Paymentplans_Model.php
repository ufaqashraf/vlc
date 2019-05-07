<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 3/7/2019
 * Time: 5:01 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Paymentplans_Model extends CI_Model{
	private $tablename = 'packages';

	public function get_all_enabled_packages($columns = 'id,title,amount,expiry,expiry_unit,status,is_featured')
	{
		$this->db->cache_on();
		$this->db->select($columns);
		$this->db->from($this->tablename);
		$this->db->where('status', 'enable');

		$packages = $this->db->get()->result();
		$this->db->cache_off();



		$return_data = [];
		foreach ($packages as $package){
			$functionalities = $this->get_package_functionalities($package->id);

			$return_data[] = [
				'package_info'	=> $package,
				'functionalities' => $functionalities
			];
		}


		return $return_data;
	}

	private function get_package_functionalities($package_id)
	{
		$this->db->cache_on();
		$this->db->select('f.title');
		$this->db->from('package_functionalities pf');
		$this->db->join('functionalities f', 'pf.functionalities_id = f.id', 'left');
		$this->db->where('packages_id', intval($package_id));
		$result = $this->db->get()->result();
		$this->db->cache_off();


		return $result;
	}
}
