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
use App\Models\OrderItem;

class PaymentController extends Controller
{
    public function redirectToPayment()
    {
        return redirect()->route('payment-show');
    }

    public function showPaymentPage()
    {
        return view('payment.payment');
    }

    public function payment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $selectedItems = session('selected_items');
            $totalAmount = session('total_amount');
            $discountedAmount = session('discounted_amount', $totalAmount);
            $user = Auth::user();

            // 顧客情報の作成
            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);

            // 支払い処理
            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $discountedAmount,
                'currency' => 'jpy',
            ]);

            // 手数料を計算
            $commissionRate = config('fees.commission_rate'); // 例: 5% (0.05)
            $commissionFee = $discountedAmount * $commissionRate;
            $totalSellerRevenue = $discountedAmount - $commissionFee;

            // **注文を作成**
            $order = new Order([
                'user_id' => $user->id,
                'status_id' => 2, // 保留中
                'total_price' => $discountedAmount,
                'commission_fee' => $commissionFee,
                'seller_revenue' => $totalSellerRevenue,
                'order_date' => now(),
            ]);
            $order->save();

            // **注文アイテムを作成**
            foreach ($selectedItems as $cartId) {
                $cart = Cart::find($cartId);
                if ($cart) {
                    $productPrice = $cart->product->price;
                    $discountedProductPrice = $discountedAmount * ($productPrice * $cart->quantity) / $totalAmount;
                    $fee = $discountedProductPrice * $commissionRate;
                    $sellerRevenue = $discountedProductPrice - $fee;

                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $discountedProductPrice,
                        'commission_fee' => $fee,
                        'seller_revenue' => $sellerRevenue,
                    ]);
                    $orderItem->save();
                    $cart->delete();
                }
            }

            // **ポイントを付与（1%還元）**
            $pointRate = 0.01; // 1%
            $earnedPoints = floor($discountedAmount * $pointRate); // 小数点切り捨て
            $user->addPoints($earnedPoints);

            return view('payment.success')->with('message', "$earnedPoints ポイントを獲得しました！");

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

