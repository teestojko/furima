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
            $discountedAmount = session('discounted_amount', $totalAmount); // $totalAmountは、'discounted_amount'が存在しない場合のデフォルト値

            // 顧客情報の作成
            $customer = Customer::create([
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken,
            ]);

            // 支払い処理
            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $discountedAmount, // 出品者が設定した金額を購入者が支払う
                'currency' => 'jpy',
            ]);

            // 注文を作成
            $order = new Order([
                'user_id' => Auth::id(),
                'status_id' => 2, // 保留中などの初期状態
                'total_price' => $discountedAmount, // 合計金額
                'order_date' => now(),
            ]);
            $order->save();

            // 注文アイテムを作成
            foreach ($selectedItems as $cartId) {
                $cart = Cart::find($cartId);
                if ($cart) {
                    $productPrice = $cart->product->price;
                    $discountedProductPrice = $discountedAmount * ($productPrice * $cart->quantity) / $totalAmount;
                    $commissionRate = config('fees.commission_rate');
                    $fee = $discountedProductPrice * $commissionRate;
                    $sellerRevenue = $discountedProductPrice - $fee; // 出品者の収益

                    // OrderItemの作成
                    $orderItem = new OrderItem([
                        'order_id' => $order->id,
                        'product_id' => $cart->product_id,
                        'quantity' => $cart->quantity,
                        'price' => $discountedProductPrice,
                        'commission_fee' => $fee, // 手数料
                        'seller_revenue' => $sellerRevenue, // 出品者の収益
                    ]);
                    $orderItem->save();
                    $cart->delete();
                }
            }

            return view('payment.success');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage()); // エラーハンドリング
        }
    }
}
