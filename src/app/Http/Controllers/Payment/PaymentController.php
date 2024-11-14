<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Customer;
use Stripe\Charge;
use Exception;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

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
            $discountedAmount = session('discounted_amount', $totalAmount);

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

                    // 商品ごとに金額を計算
                $productPrice = $cart->product->price;
                $discountedProductPrice = $discountedAmount * ($productPrice * $cart->quantity) / $totalAmount; // 割引後の商品価格を計算

                    $order = new Order([
                        'user_id' => Auth::id(),
                        'product_id' => $cart->product_id,
                        'status_id' => 2, // 保留中などの初期状態
                        'quantity' => $cart->quantity,
                        'total_price' => $discountedProductPrice, // 各商品に対して割引後の金額を適切に分割
                        'order_date' => now(),
                    ]);
                    $order->save();

                    $cart->delete();
                }
            }
            return view('Payment.success');
            
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
