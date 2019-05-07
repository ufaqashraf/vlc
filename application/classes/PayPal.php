<?php
/**
 * Created by PhpStorm.
 * User: Ali Shan
 * Date: 2/14/2019
 * Time: 12:42 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PayPal{
	public function charge($price, $payment_description, $return_url, $cancel_url, $currency = 'usd', $intent = 'order')
	{
		$api_context = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				PAYPAL_CLIENT_ID,
				PAYPAL_SECRET_ID
			)
		);

		$api_context->setConfig(
			array(
				'log.LogEnabled' => true,
				'log.FileName' => 'application/logs/PayPal.log',
				'log.LogLevel' => 'ALL' // 'DEBUG' , 'ALL'
			)
		);

		$payer = new \PayPal\Api\Payer();
		$payer->setPaymentMethod('paypal');

		$amount = new \PayPal\Api\Amount();
		$amount->setTotal(floatval($price));
		$amount->setCurrency(strtoupper($currency));

		$item = new \PayPal\Api\Item();
		$item->setQuantity(1);
		$item->setName($payment_description);
		$item->setPrice(floatval($price));
		$item->setCurrency(strtoupper($currency));

		$itemList = new \PayPal\Api\ItemList();
		$itemList->setItems(array($item));

		$transaction = new \PayPal\Api\Transaction();
		$transaction->setAmount($amount);
		$transaction->setItemList($itemList);

		$redirectUrls = new \PayPal\Api\RedirectUrls();
		$redirectUrls->setReturnUrl($return_url)
			->setCancelUrl($cancel_url);

		$payment = new \PayPal\Api\Payment();
		$payment->setIntent($intent)
			->setPayer($payer)
			->setTransactions(array($transaction))
			->setRedirectUrls($redirectUrls);
		try {
			$payment->create($api_context);

			header('Location: ' . $payment->getApprovalLink());
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			// This will print the detailed information on the exception.
			//REALLY HELPFUL FOR DEBUGGING

			$ci = volgo_get_ci_object();

			log_message('error', $ex->getData());
			$ci->session->set_flashdata('paypal_payment_plan_error', '<h2>Sorry! </h2><p>Unable to continue. PayPal Gateway error. Kindly try again or consult with administrator.</p>');
			redirect('payment-plans');
		}

	}
}
