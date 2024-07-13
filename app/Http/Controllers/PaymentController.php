<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment as PayPalPayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'),     // ClientID
                env('PAYPAL_CLIENT_SECRET')  // ClientSecret
            )
        );

        $this->apiContext->setConfig([
            'mode' => env('PAYPAL_MODE', 'sandbox'), // or 'live'
        ]);
    }

    public function index()
    {
        $payments = Payment::with('orders.user', 'orders.orderProducts.product')->get();
        return response()->json($payments, 200);
    }

    public function createPaymentIntent(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($request->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Payment description");

        $redirectUrls = new RedirectUrls();
        // $redirectUrls->setReturnUrl(env('PAYPAL_RETURN_URL', 'https://your-domain.com/api/paypal/return'))
        //     ->setCancelUrl(env('PAYPAL_CANCEL_URL', 'https://your-domain.com/api/paypal/cancel'));
        $redirectUrls->setReturnUrl('myapp://success')
             ->setCancelUrl('myapp://cancel');


        $payment = new PayPalPayment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return response()->json([
                'error' => $ex->getData()
            ], 500);
        }

        return response()->json([
            'approval_url' => $payment->getApprovalLink(),
        ], 200);
    }

    public function handlePayPalReturn(Request $request)
    {
        $paymentId = $request->query('paymentId');
        $payerId = $request->query('PayerID');

        if (!$paymentId || !$payerId) {
            return response()->json(['error' => 'Payment was not successful.'], 400);
        }

        $payment = PayPalPayment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            if ($result->getState() == 'approved') {
                // Handle successful payment here
                return response()->json(['success' => 'Payment was successful.'], 200);
            }
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            return response()->json(['error' => 'Payment was not successful.'], 500);
        }

        return response()->json(['error' => 'Payment was not successful.'], 400);
    }

    public function handlePayPalCancel()
    {
        // Handle payment cancellation here
        return response()->json(['error' => 'Payment was cancelled.'], 400);
    }

    public function handlePaymentSuccess(Request $request)
    {
        $requestData = $request->all();
    
        // Extract relevant data
        $totalAmount = $requestData['totalAmount'];
        $userId = $requestData['userID'];
        $paymentId = $requestData['paymentId']; // Ensure this is included in the frontend request
        $orderAddress = $requestData['orderAddress'] ?? 'Default Address'; // Use actual key for address
        $items = $requestData['items'];
    
        // Insert into payment table
        $payment = Payment::create([
            'total_price' => $totalAmount,
            'payment_method' => 'PayPal',
            'transaction_id' => $paymentId,
        ]);
    
        // Insert into order table
        $order = Order::create([
            'user_id' => $userId,
            'order_status' => 'pending',
            'total_amount' => $totalAmount,
            'order_address' => $orderAddress,
            'payment_id' => $payment->id,
        ]);
    
        // Insert into order_product table
        foreach ($items as $item) {
            Order_Product::create([
                'order_id' => $order->id,
                'product_id' => 1, // Replace with actual product ID from your database
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    
        return response()->json(['message' => 'Payment processed successfully'], 200);
    }
    
}
