<?php

namespace App\Http\Controllers;

use App\Repositories\Image\ImageRepository;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OrderSuccess;
use Carbon\Carbon;
use App\Product;
use App\Order;
use App\OrderItem;
use App\Customer;
use Paypal;
use Redirect;

class PaypalController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
        $this->_apiContext = PayPal::ApiContext(
            config('services.paypal.client_id'),
            config('services.paypal.secret'));

		$this->_apiContext->setConfig(array(
			'mode' => 'sandbox',
			'service.EndPoint' => 'https://api.sandbox.paypal.com',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => true,
			'log.FileName' => storage_path('logs/paypal.log'),
			'log.LogLevel' => 'FINE'
		));

    }

    public function checkout()
    {
        if(sizeof(session('cart.item')) == 0)
            return redirect('/cart');

    	$payer = PayPal::Payer();
    	$payer->setPaymentMethod('paypal');

        $detail = PayPal::Details();
        $detail->setSubtotal(session('cart.subtotal'));
        $detail->setShipping(10);

    	$amount = PayPal::Amount();
    	$amount->setCurrency('MYR');
    	$amount->setTotal(session('cart.subtotal') + 10);
        $amount->setDetails($detail);

        $items = PayPal::ItemList();
        foreach(session('cart.item') as $cartItem) {
            $item = PayPal::Item();
            $item->setSku($cartItem['id']);
            $item->setName($cartItem['name']);
            $item->setQuantity($cartItem['quantity']);
            $item->setCurrency('MYR');
            $item->setPrice($cartItem['price']);
            $items->addItem($item);
        }

        $transaction = PayPal::Transaction();
    	$transaction->setAmount($amount);
        $transaction->setDescription('Creating a payment');
        $transaction->setItemList($items);

    	$redirectUrls = PayPal:: RedirectUrls();
    	$redirectUrls->setReturnUrl(action('PaypalController@getDone'));
    	$redirectUrls->setCancelUrl(action('CartController@index'));

    	$payment = PayPal::Payment();
    	$payment->setIntent('sale');
    	$payment->setPayer($payer);
    	$payment->setRedirectUrls($redirectUrls);
    	$payment->setTransactions(array($transaction));
        $payment->setExperienceProfileId($this->createWebProfile());

    	$response = $payment->create($this->_apiContext);
    	$redirectUrl = $response->links[1]->href;

    	return Redirect::to($redirectUrl);
    }

    public function getDone(Request $request)
    {
    	$id = $request->get('paymentId');
    	$token = $request->get('token');
    	$payer_id = $request->get('PayerID');
    	$payment = PayPal::getById($id, $this->_apiContext);

        // check shipping country here

    	$paymentExecution = PayPal::PaymentExecution();
    	$paymentExecution->setPayerId($payer_id);
    	$executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        $transactionID = $executePayment->getTransactions()[0]->getRelatedResources()[0]->getSale()->getId();
        if($executePayment->getState() == 'approved') {
            $payerInfo = $executePayment->getPayer()->getPayerInfo();
            $transaction = $executePayment->getTransactions()[0];
            $amount = $transaction->getAmount();
            $items = $transaction->getItemList()->getItems();
            $address = $transaction->getItemList()->getShippingAddress();

            $customer = Customer::firstOrCreate([
                'name' => $address->getRecipientName(),
                'email' => $payerInfo->getEmail(),
                'country' => $address->getCountryCode()
            ]);

            $order = Order::create([
                'customer_id' => $customer->id,
                'name' => $address->getRecipientName(),
                'email' => $payerInfo->getEmail(),
                'phone' => $address->getPhone() ? $address()->getPhone() : $payerInfo->getPhone(),
                'address_line_1' => $address->getLine1(),
                'address_line_2' => $address->getLine2(),
                'city' => $address->getCity(),
                'postcode' => $address->getPostalCode(),
                'state' => $address->getState(),
                'country' => $address->getCountryCode(),
                'shipping_cost' => $amount->getDetails()->getShipping(),
                'paypal_id' => $executePayment->getId(),
                'payment_status' => 1
            ]);
            $order->save();

            foreach($items as $item){
                $orderItem = $order->items()->create([
                    'product_id' => $item->sku,
                    'price' => $item->price,
                    'quantity' => $item->quantity
                ]);
                $orderItem->save();
                // minus quantity
                $product = Product::find($item->sku);
                $product->quantity =  $product->quantity - $item->quantity;
                $product->save();
            }
            $order->save();

            session()->forget("cart");
            $order->notify(new OrderSuccess($order));
            return redirect('/checkout/success');
        }
        else {
            return redirect('/cart');
        }
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function createWebProfile()
    {
    	$flowConfig = PayPal::FlowConfig();
    	$presentation = PayPal::Presentation();
    	$inputFields = PayPal::InputFields();
    	$webProfile = PayPal::WebProfile();
    	$flowConfig->setLandingPageType("Billing");
        // user_action=commit

    	$webProfile->setName("FOMO".uniqid())
    		->setFlowConfig($flowConfig)
    		// Parameters for style and presentation.
    		->setPresentation($presentation)
    		// Parameters for input field customization.
    		->setInputFields($inputFields);

    	$createProfileResponse = $webProfile->create($this->_apiContext);

    	return $createProfileResponse->getId(); //The new webprofile's id
    }
}
