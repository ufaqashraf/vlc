<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/7/2019
 * Time: 2:45 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


class Packages_Model extends CI_Model{

	public function get_all_enabled_functionalities()
	{
		$this->db->cache_on();
		$this->db->select('id,title,price');
		$this->db->from('functionalities');
		$this->db->where('status', 'enabled');

		$functionalities = $this->db->get();
		$this->db->cache_off();


		return $functionalities->result();

	}

	public function get_all_packages($columns = 'id,title,amount,expiry,expiry_unit,status')
	{
		$this->db->cache_on();
		$this->db->select($columns);
		$this->db->from('packages');

		$packages = $this->db->get();
		$this->db->cache_off();


		return $packages->result();
	}

	public function get_package_by_id($package_id){


		$this->db->cache_on();
		$this->db
			->select(
				'p.id as package_id,p.title as package_title,p.description,p.amount,p.expiry,p.expiry_unit,p.status,p.is_featured,
				f.id as functionality_id,f.title as functionality_title,f.status as functionality_status'
			);
		$this->db->from('packages p');
		$this->db->join('package_functionalities pf', 'p.id = pf.packages_id', 'left');
		$this->db->join('functionalities f', 'pf.functionalities_id = f.id', 'left');
		$this->db->where('p.id', $package_id);

		$query = $this->db->get();
		$this->db->cache_off();

		$result = $query->result();

		return ( $this->combine_result($result) );
	}

	public function combine_result( $result_rows )
	{

		if (! is_array($result_rows))
			return $result_rows;

		$data = [];
		foreach ($result_rows as $index => $result_row){

			if ($index === 0){
				$data[$index]['package_data'] = [
					'package_id' => $result_row->package_id,
					'package_title'	=> $result_row->package_title,
					'description'	=> $result_row->description,
					'amount'	=> $result_row->amount,
					'expiry'	=> $result_row->expiry,
					'expiry_unit'	=> $result_row->expiry_unit,
					'status'	=> $result_row->status,
					'is_featured'	=> $result_row->is_featured
				];
			}

			$data[0]['functionality_data'][] = [
				'functionality_id' => $result_row->functionality_id,
				'functionality_title' => $result_row->functionality_title,
				'functionality_status' => $result_row->functionality_status,
			];
		}
		return $data;
	}

	public function update_package_info($package_id, $title = '', $description = '', $amount = '', $expiry = '', $expiry_unit = '', $status = '', $functionalities_id = [], $is_featured = 0)
	{
		if ($status === null || empty($status))
			$status = 'disable';
		else
			$status = 'enable';

		if (empty($is_featured) || intval($is_featured) === 0)
			$is_featured = 0;
		else
			$is_featured = 1;


		$data = array(
			'title'	=> $title,
			'description'	=> $description,
			'amount'	=> $amount,
			'expiry' => $expiry,
			'expiry_unit' => $expiry_unit,
			'status'	=> $status,
			'is_featured'	=> $is_featured
		);

		$this->db->set($data);
		$this->db->where('id', $package_id);

		$is_updated = $this->db->update(
			'packages'
		);

		if (!$is_updated)
			return false;

		// Remove old package_functionalities data
		$this->db->where("packages_id", $package_id);
		$this->db->delete("package_functionalities");

		if (! empty($functionalities_id) && is_array($functionalities_id)){
			foreach ($functionalities_id as $f_id){
				$data = array(
					'packages_id'	=> $package_id,
					'functionalities_id'	=> $f_id,
					'create_date'	=>  date("Y-m-d H:i:s")
				);

				$this->db->set($data);

				$is_inserted = $this->db->insert(
					'package_functionalities'
				);

				if (! $is_inserted){
					break;
				}
			}
			return $is_inserted;
		}else {
			return true;
		}
	}

	public function insert_package_info($title = '', $description = '', $amount = '', $expiry = '', $expiry_unit = '', $status = '', $functionalities_id = [], $is_featured = 0)
	{
		if ($status === null || empty($status))
			$status = 'disable';
		else
			$status = 'enable';

		if (empty($is_featured) || intval($is_featured) === 0)
			$is_featured = 0;
		else
			$is_featured = 1;

		$data = array(
			'title'	=> $title,
			'description'	=> $description,
			'amount'	=> $amount,
			'expiry' => $expiry,
			'expiry_unit' => $expiry_unit,
			'status'	=> $status,
			'created_date'	=>  date("Y-m-d H:i:s"),
			'is_featured'	=> $is_featured
		);

		$this->db->set($data);

		$is_inserted = $this->db->insert(
			'packages'
		);

		if (!$is_inserted)
			return false;

		if (! empty($functionalities_id) && is_array($functionalities_id)){
			$package_insert_id = $this->db->insert_id();

			foreach ($functionalities_id as $f_id){
				$data = array(
					'packages_id'	=> $package_insert_id,
					'functionalities_id'	=> $f_id,
					'create_date'	=>  date("Y-m-d H:i:s")
				);

				$this->db->set($data);

				$is_inserted = $this->db->insert(
					'package_functionalities'
				);

				if (! $is_inserted){
					break;
				}
			}
			return $is_inserted;
		}else {
			return true;
		}
	}

	public function remove($package_id)
	{
		// Remove package_functionalities data
		$this->db->where("packages_id", $package_id);
		$this->db->delete("package_functionalities");

		$this->db->where("id", $package_id);
		$this->db->delete("packages");

		return true;
	}

}
