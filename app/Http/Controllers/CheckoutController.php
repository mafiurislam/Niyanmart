<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Your cart is empty. Please add items before checkout.');
        }

        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 249);
        $standardDeliveryFee = (float) Setting::get('standard_delivery_fee', 30);

        $subtotal = 0;
        $totalSavings = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalSavings += ($item['mrp'] - $item['price']) * $item['quantity'];
        }

        $coupon = session()->get('applied_coupon', null);
        $discount = $coupon['discount'] ?? 0;

        $deliveryCharge = ($subtotal >= $freeShippingThreshold) ? 0 : $standardDeliveryFee;
        $grandTotal = max(0, $subtotal - $discount + $deliveryCharge);

        $user = auth()->user();

        return view('frontend.checkout', compact(
            'cart',
            'subtotal',
            'totalSavings',
            'discount',
            'deliveryCharge',
            'grandTotal',
            'user'
        ));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|min:10|max:15',
            'customer_email' => 'nullable|email|max:100',
            'street_area' => 'required|string|max:255',
            'house_flat' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|size:6',
            'payment_method' => 'required|string|in:cod,razorpay,upi,gpay,phonepe,card',
            'address_type' => 'nullable|string|in:Home,Work,Other',
            'razorpay_payment_id' => 'nullable|string',
        ]);

        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 249);
        $standardDeliveryFee = (float) Setting::get('standard_delivery_fee', 30);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('applied_coupon', null);
        $discount = $coupon['discount'] ?? 0;
        $couponCode = $coupon['code'] ?? null;

        $deliveryCharge = ($subtotal >= $freeShippingThreshold) ? 0 : $standardDeliveryFee;
        $grandTotal = max(0, $subtotal - $discount + $deliveryCharge);

        // Generate Order Number
        $orderNumber = 'NM' . rand(10000000, 99999999);

        // Determine Payment Status & Transaction ID (Razorpay Support)
        if ($request->filled('razorpay_payment_id')) {
            $transactionId = $request->razorpay_payment_id;
            $paymentStatus = 'paid';
        } elseif ($request->payment_method === 'cod') {
            $transactionId = 'COD-' . strtoupper(Str::random(8));
            $paymentStatus = 'pending';
        } else {
            $transactionId = 'TR' . strtoupper(Str::random(8));
            $paymentStatus = 'paid';
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'house_flat' => $request->house_flat,
            'street_area' => $request->street_area,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'landmark' => $request->landmark,
            'address_type' => $request->address_type ?? 'Home',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'coupon_code' => $couponCode,
            'delivery_charge' => $deliveryCharge,
            'total' => $grandTotal,
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'transaction_id' => $transactionId,
            'order_status' => 'placed',
            'notes' => $request->notes,
            'expected_delivery_date' => now()->addDays(2),
        ]);

        // Create Order Items and decrease stock
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['name'],
                'product_image' => $item['image'],
                'weight' => $item['weight'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Decrement product inventory
            Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
        }

        // Increment coupon count if used
        if ($couponCode) {
            Coupon::where('code', $couponCode)->increment('used_count');
        }

        // Create initial tracking record
        OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'placed',
            'title' => 'Order Placed',
            'description' => 'Your order has been received and is being verified by our team.',
            'tracked_at' => now(),
        ]);

        // Clear session cart and coupon
        session()->forget(['cart', 'applied_coupon']);

        return redirect()->route('order.success', $order->order_number);
    }

    public function success($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->with('items')
            ->firstOrFail();

        return view('frontend.order_success', compact('order'));
    }

    public function invoice($order_number)
    {
        $order = Order::where('order_number', $order_number)
            ->with(['items', 'user'])
            ->firstOrFail();

        return view('frontend.invoice', compact('order'));
    }
}
