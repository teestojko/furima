<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Exception;
use Stripe\Stripe;
use App\Models\Cart;

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
            $totalAmount = session('discounted_amount', session('total_amount'));

            // $totalAmount = session('discounted_amount');
            // if (!$totalAmount) {
            //     // もし割引後の金額がセッションにない場合、元の金額を取得
            //     $totalAmount = session('total_amount');
            // }
            // dd($totalAmount); // 確認のため、ここで金額が正しいか確認


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

            foreach ($selectedItems as $cartId) {
            $cart = Cart::find($cartId);
            if ($cart) {
                $cart->delete();
            }
}


            return view('Payment.success');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
