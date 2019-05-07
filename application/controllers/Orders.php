<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/8/2019
 * Time: 6:47 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'classes/PayPal.php';

class Orders extends CI_Controller{

	public function __construct() {
		parent::__construct();

		if (! volgo_front_is_logged_in()){
			header('Location: ' . base_url('login'));
		}
		$this->load->library('form_validation');
		$this->load->model('Orders_Model');
	}

	public function index()
	{
		$this->load->view('frontend/orders/index');
	}

	// paymentId=PAYID-LRSAGNY0H458119UL042784J&token=EC-7VW95664R0171212Y&PayerID=7F48HGB2ATNJG
	public function paypal_return_url_handler($order_id = '', $package_id = '', $package_user = '')
	{
		if (empty($order_id) || empty($package_id) || empty($package_user)){
			$this->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to continue. Kindly retry or contact administrator.</p>');
			redirect('payment-plans');
		}

		$get_data = filter_input_array(INPUT_GET);

		$is_updated = $this->Orders_Model->update_by_order_id(
			$order_id,
			$get_data['paymentId'],
			$get_data['token'],
			$get_data['PayerID'],
			'paid',
			'paypal'
		);

		if ($is_updated){

			$message = "<h2>Success! </h2>";
			$message .= '<p>Order has been successfully paid and charged.</p>';

			$this->session->set_flashdata('paypal_payment_plan_success', $message);
			redirect('payment-plans');

		}else {
			$this->session->set_flashdata('paypal_payment_plan_error',
				'<h2>Sorry! </h2><p>Unable to continue. Kindly contact to site administrator.</p>');
			redirect('payment-plans');

		}
	}

	//token=EC-20C48771VC8353923
	public function paypal_cancel_url_handler($order_id = '', $package_id = '', $package_user = '')
	{
		if (empty($order_id) || empty($package_id) || empty($package_user)){
			$this->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to continue. Kindly retry or contact administrator.</p>');
			redirect('payment-plans');
		}


		$get_data = filter_input_array(INPUT_GET);

		$is_updated = $this->Orders_Model->update_by_order_id(
			$order_id,
			'',
			$get_data['token'],
			'',
			'cancelled',
			'paypal'
		);

		if ($is_updated){

			$message = "<h2>Cancelled!</h2>";
			$message .= '<p>Order has been cancelled</p>';

			$this->session->set_flashdata('paypal_payment_plan_success', $message);
			redirect('payment-plans');

		}else {
			$this->session->set_flashdata('paypal_payment_plan_error',
				'<h2>Cancelled Successfully ! </h2><p>Unable to continue. Kindly contact to site administrator.</p>');
			redirect('payment-plans');
		}
	}

}
