<?php
require ("PayPal/bootstrap.php");
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\ShippingAddress;

class Paypal
{
	private $clientId;
    private $clientSecret;
	private $apiContext;
	private $cart  = array();
	private $payer = null;
	private $infoData = null;
	public function Paypal($params) { 
		$this->clientId = $params["clientId"];
		$this->clientSecret = $params["clientSecret"];
		$this->apiContext    = $this->getApiContext();
	}
	public function CreatePaymentUsingPayPal($return_url="",$cancel_url = "",$price = 0,$product){

		$total = $price;
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");
		$item1 = new Item();
		$item1->setName(@$product["Name"])
		    ->setCurrency('USD')
		    ->setQuantity(1)
		    ->setSku("sku-". @$product["ID"]) // Similar to `item_number` in Classic API
		    ->setPrice($price);
		$itemList = new ItemList();
		$itemList->setItems(array($item1));
		$details = new Details();
		$details->setShipping(0)
		    ->setTax(0)
		    ->setSubtotal($price);
		$amount = new Amount();
		$amount->setCurrency("USD")
		    ->setTotal($price)
		    ->setDetails($details);
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		    ->setItemList($itemList)
		    ->setDescription("Book room")
		    ->setInvoiceNumber(uniqid());

		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl($return_url)
		    ->setCancelUrl($cancel_url);
	    $payment = new Payment();
		$payment->setIntent("sale")
		    ->setPayer($payer)
		    ->setRedirectUrls($redirectUrls)
		    ->setTransactions(array($transaction));

		try {
		    $payment->create($this->apiContext);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
		    echo $ex->getCode(); // Prints the Error Code
		    echo $ex->getData(); // Prints the detailed error message 
		    die($ex);
		} catch (Exception $ex) {
		    die($ex);
		}
		$data["approvalUrl"] = $payment->getApprovalLink();
		$data["payment"] = json_decode($payment,true);
		return $data;
	}
	public function getApiContext() {
	    $apiContext = new ApiContext(new OAuthTokenCredential($this->clientId,$this->clientSecret));
	    $apiContext->setConfig(
	        array(
	            'mode' => 'sandbox',
	            'log.LogEnabled' => true,
	            'log.FileName' => '../PayPal.log',
	            'log.LogLevel' => 'DEBUG',
	            'cache.enabled' => true,
	            //'service.EndPoint'=> "https://test-api.sandbox.paypal.com"  
	        )
	    );
	    return $apiContext;
	}

	public function ExecutePayment($price,$paymentId,$PayerID) {
    	$total = $price;//$this->cart["Number_Month"] * $this->cart["Price_One_Month"];
	    $paymentId = $paymentId;
	    $payment = Payment::get($paymentId, $this->apiContext);
	    $execution = new PaymentExecution();
	    $execution->setPayerId($PayerID);
	    $transaction = new Transaction();
	    $amount = new Amount();
	    $details = new Details();
	    $details->setShipping(0)
	        ->setTax(0)
	        ->setSubtotal($total);
	    $amount->setCurrency('USD');
	    $amount->setTotal($total);
	    $amount->setDetails($details);
	    $transaction->setAmount($amount);
	    $execution->addTransaction($transaction);
	    try {
	        $result = $payment->execute($execution, $this->apiContext);
	        try {
	            $payment = Payment::get($paymentId, $this->apiContext);
	        } catch (Exception $ex) { 
	            return $ex;
	        }
	    } catch (Exception $ex) {
	        return $ex;
	    }
	    if($payment != null){
	    	return json_decode($payment,true);
	    }else{
	    	return array();
	    }
	}
}