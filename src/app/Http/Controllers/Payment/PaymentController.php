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

    public function process(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $selectedItems = session('selected_items');
            $totalAmount = session('total_amount');
            $discountedAmount = session('discounted_amount', $totalAmount);
            $usedPoints = session('used_points', 0); // 使ったポイント
            $user = Auth::user();

            // 使用ポイントを適用
            $finalAmount = max(0, $discountedAmount - $usedPoints);
            session(['final_amount' => $finalAmount]);

            if ($finalAmount > 0) {
                // Stripe決済を実行
                $customer = Customer::create([
                    'email' => $request->stripeEmail,
                    'source' => $request->stripeToken,
                ]);

                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => $finalAmount,
                    'currency' => 'jpy',
                ]);
            }

            // ポイントを減算
            $user->points -= $usedPoints;
            $user->save();

            // 手数料を計算
            $commissionRate = config('fees.commission_rate'); // 例: 5% (0.05)
            $commissionFee = $finalAmount * $commissionRate;
            $totalSellerRevenue = $finalAmount - $commissionFee;

            // **注文を作成**
            $order = new Order([
                'user_id' => $user->id,
                'status_id' => 2,
                'total_price' => $finalAmount,
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
                    $discountedProductPrice = $finalAmount * ($productPrice * $cart->quantity) / $totalAmount;
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

            // 新しいポイントを付与（1%還元）
            $earnedPoints = floor($finalAmount * 0.01);
            $user->addPoints($earnedPoints);

            // セッションをクリア
            session()->forget(['used_points', 'selected_items', 'total_amount', 'discounted_amount' , 'final_amount']);

            return redirect()->route('payment-success')->with('success', "$earnedPoints ポイントを獲得しました！");


        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function success()
    {
        return view('payment.success')->with('success', session('success'));
    }
}

