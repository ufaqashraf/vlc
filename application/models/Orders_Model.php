<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/8/2019
 * Time: 7:07 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Packages_Model.php';

class Orders_Model extends Packages_Model
{

	private $orders_table = 'orders';

	public function update_order_status($order_id, $status)
	{
		$data = array(
			'status' => $status
		);

		$this->db->set($data);
		$this->db->where('id', $order_id);

		$is_updated = $this->db->update(
			$this->orders_table
		);

		return $is_updated;
	}

	public function get_order_by_oid($order_id)
	{
		$this->db->cache_on();
		$this->db
			->select(
				'o.id as order_id,
				o.transaction_id,
				o.amount,
				o.currency_unit,
				o.status,
				o.payment_method,
				u.id as user_id,
				u.firstname,
				u.lastname,
				u.email,
				p.title,
				p.id as package_id'
			);
		$this->db->from($this->orders_table . ' o');
		$this->db->join('b2b_users u', 'u.id = o.user_id', 'left');
		$this->db->join('packages p', 'o.packages_id = p.id', 'left');
		$this->db->where('o.id', $order_id);
		$this->db->order_by('o.id', 'desc');
		$query = $this->db->get();
		$this->db->cache_off();



		return $query->result();
	}

	public function get_all_orders()
	{
		$this->db->cache_on();
		$this->db
			->select(
				'o.id as order_id,
				o.transaction_id,
				o.amount,
				o.currency_unit,
				o.status,
				o.payment_method,
				u.firstname,
				u.lastname,
				u.email,
				p.title,
				p.id as package_id'
			);
		$this->db->from($this->orders_table . ' o');
		$this->db->join('b2b_users u', 'u.id = o.user_id', 'left');
		$this->db->join('packages p', 'o.packages_id = p.id', 'left');
		$this->db->order_by('o.id', 'desc');
		$query = $this->db->get();
		$this->db->cache_off();


		return $query->result();
	}

	public function place_order($package_id, $package_user, $payment_method)
	{ 
		$package_details = (new Packages_Model())->get_package_by_id(intval($package_id));
		if (!isset($package_details[0]))
			return false;

		$package_details = $package_details[0];
		$package_data = $package_details['package_data'];

		$package_title = $package_data['package_title'];
		$amount = $package_data['amount'];
		$currency_unit = B2B_CURRENCY_UNIT;
		if ($payment_method === 'paypal') {
			// Convert Currency

			$exchange_data = volgo_do_currency_exchange($amount, $currency_unit);

			// if false
			if (!$exchange_data || !is_array($exchange_data))
				return false;

			$amount = floatval($exchange_data['converted_price']);
			$currency_unit = $exchange_data['to_currency_unit'];

		}
		// Package connects
		if($package_id == 1){
			$available_connect = 10;
		}else if($package_id == 2){
			$available_connect = 20;
		}else{
			$available_connect = -1;
		}
		$data = array(
			'user_id' => intval($package_user),
			'packages_id' => intval($package_id),
			'package_details' => serialize($package_data),
			'amount' => floatval($amount),
			'currency_unit' => $currency_unit,
			'status' => 'pending',
			'payment_method' => $payment_method,
			'order_date' => date("Y-m-d H:i:s"),
			'created_date' => date("Y-m-d H:i:s"),
			'available_connect' => $available_connect
		);

		$this->db->set($data);

		$is_inserted = $this->db->insert(
			$this->orders_table
		);

		if ($is_inserted) {
			return [
				'is_inserted' => 'yes',
				'amount' => $amount,
				'currency_unit' => $currency_unit,
				'payment_method' => $payment_method,
				'package_title' => $package_title,
				'aed_amount' => $package_data['amount'],
				'order_id' => $this->db->insert_id(),
				'package_id' => $package_id,
				'package_user' => $package_user
			];
		}

		return false;
	}

	public function update_by_order_id($order_id, $payment_id, $payment_token, $payer_id, $payment_status, $payment_gateway)
	{

		$data = array(
			'transaction_id' => $payment_id,
			'transaction_details' => serialize([
				'payment_id__transaction_id' => $payment_id,
				'payment_token' => $payment_token,
				'payer_id' => $payer_id,
				'payment_status' => $payment_status,
				'payment_gateway' => $payment_gateway
			]),
			'status' => $payment_status,
			'payment_method' => $payment_gateway
		);

		$this->db->set($data);
		$this->db->where('id', $order_id);

		$is_updated = $this->db->update(
			$this->orders_table
		);

		return $is_updated;

	}

	public function remove($order_id)
	{
		$this->db->where("id", $order_id);
		$this->db->delete($this->orders_table);
		return true;
	}

}
