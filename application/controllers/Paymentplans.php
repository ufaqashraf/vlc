<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'classes/PayPal.php';

class Paymentplans extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Paymentplans_Model');
		$this->load->model('Orders_Model');
	}

    public function index()
    {
    	$data = [
    		'packages' => $this->Paymentplans_Model->get_all_enabled_packages()
		];

        $this->load->view('frontend/payment_plans/paymentplans', $data);
    }

	public function purchase($package_id, $enc_method)
	{

		$message = 'package_id=' . $package_id . '&&enc_method=' . $enc_method;
		volgo_create_cookie(VOLGO_COOKIE_BEFORE_PURCHASING_PACKAGE_INFO, volgo_encrypt_message($message), 43200); // for 12 hours

		if (! volgo_front_is_logged_in()){
			$this->session->set_flashdata('success_msg', "Kindly signup or login to purchase package!");
			redirect('login?redirected_to=' . base_url('purchase/' . $package_id . '/' . $enc_method));
		}

		$payment_method = volgo_decrypt_message($enc_method);

		$available_payment_methods = array_map('trim', explode(',', AVAILABLE_PAYMENT_METHODS));

		if (! in_array($payment_method, $available_payment_methods)){
			$this->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to continue. Payment method is not available. Kindly retry.</p>');

			redirect('payment-plans');
		}else {
			$insert_arr = $this->Orders_Model
				->place_order(
					$package_id,
					volgo_get_logged_in_user_id(),
					$payment_method
				);

			if (is_array($insert_arr) && !empty($insert_arr)) {

				if ($insert_arr['payment_method'] === 'paypal') {

					$paypal = new PayPal();
					$paypal->charge(
						$insert_arr['amount'],
						"Order for " . $insert_arr['package_title'] . ' - (AED: ' . floatval($insert_arr['aed_amount']) . ')',
						base_url('orders/paypal_return_url_handler/' . intval($insert_arr['order_id']) . '/' . intval($insert_arr['package_id']) . '/' . intval($insert_arr['package_user'])),
						base_url('orders/paypal_cancel_url_handler/' . intval($insert_arr['order_id'])) . '/' . intval($insert_arr['package_id']) . '/' . intval($insert_arr['package_user']),
						$insert_arr['currency_unit']
					);


				} else if ($insert_arr['payment_method'] === 'network') {

					// @todo: Network call should put here.
					echo 'Payment Method NETWORK';
					exit;

				} else {
					$this->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to continue. Payment method error. Kindly retry.</p>');
					redirect('payment-plans');
				}
			} else {

				$this->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to charge. Kindly retry.</p>');
				redirect('payment-plans');
			}
		}

    }

}
