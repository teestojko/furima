<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Exception;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function redirectToPayment()
    {
        return redirect()->route('payment-show');
    }

    public function showPaymentPage()
    {
        return view('Payment.payment');
    }

		public function payment(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $selectedItems = session('selected_items');
            $totalAmount = session('total_amount');

            // Stripe決済処理
            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);

            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $totalAmount,
                'currency' => 'jpy',
            ]);

            // 決済成功後、カートのアイテムを削除
            foreach ($selectedItems as $cart) {
                $cart->delete();
            }

            return view('Payment.success');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
