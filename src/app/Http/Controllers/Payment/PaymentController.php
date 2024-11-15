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
            $totalAmount = session('total_amount');
            $discountedAmount = session('discounted_amount', $totalAmount);

            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);

            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $totalAmount, // 出品者が設定した金額を購入者が支払う
                'currency' => 'jpy',
            ]);

            foreach ($selectedItems as $cartId) {
                $cart = Cart::find($cartId);
                if ($cart) {
                    $productPrice = $cart->product->price;
                    $discountedProductPrice = $discountedAmount * ($productPrice * $cart->quantity) / $totalAmount;
                    $commissionRate = config('fees.commission_rate');
                    $fee = $discountedProductPrice * $commissionRate;
                    $sellerRevenue = $discountedProductPrice - $fee; // 出品者の収益

                    $order = new Order([
                        'user_id' => Auth::id(),
                        'product_id' => $cart->product_id,
                        'status_id' => 2, // 保留中などの初期状態
                        'quantity' => $cart->quantity,
                        'total_price' => $discountedProductPrice,
                        'commission_fee' => $fee, // 手数料を記録
                        'seller_revenue' => $sellerRevenue, // 出品者の収益を記録
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
