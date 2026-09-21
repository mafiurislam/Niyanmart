<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 249);
        $standardDeliveryFee = (float) Setting::get('standard_delivery_fee', 30);

        $subtotal = 0;
        $totalSavings = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalSavings += ($item['mrp'] - $item['price']) * $item['quantity'];
        }

        // Coupon calculation
        $coupon = session()->get('applied_coupon', null);
        $discount = 0;
        if ($coupon) {
            $couponModel = Coupon::where('code', $coupon['code'])->where('is_active', true)->first();
            if ($couponModel && $couponModel->isValidFor($subtotal)) {
                $discount = $couponModel->calculateDiscount($subtotal);
            } else {
                session()->forget('applied_coupon');
                $coupon = null;
            }
        }

        $deliveryCharge = ($subtotal >= $freeShippingThreshold || $subtotal == 0) ? 0 : $standardDeliveryFee;
        $grandTotal = max(0, $subtotal - $discount + $deliveryCharge);

        return view('frontend.cart', compact(
            'cart',
            'subtotal',
            'totalSavings',
            'discount',
            'deliveryCharge',
            'grandTotal',
            'coupon',
            'freeShippingThreshold'
        ));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);
        $variantWeight = $request->input('weight', null);

        $product = Product::findOrFail($productId);

        $price = $product->selling_price;
        $mrp = $product->mrp;
        $weight = $product->weight;

        // If specific variant chosen
        if ($variantWeight) {
            $variant = ProductVariant::where('product_id', $product->id)->where('weight', $variantWeight)->first();
            if ($variant) {
                $price = $variant->selling_price;
                $mrp = $variant->mrp;
                $weight = $variant->weight;
            }
        }

        $cartKey = $product->id . '_' . Str_replace(' ', '', $weight);
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'name_bn' => $product->name_bn,
                'slug' => $product->slug,
                'image' => $product->image,
                'weight' => $weight,
                'price' => (float) $price,
                'mrp' => (float) $mrp,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to your cart!",
                'cart_count' => $totalItems,
                'cart_total' => number_format($totalAmount, 2),
            ]);
        }

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', "{$product->name} added to cart!");
    }

    public function update(Request $request)
    {
        $key = $request->input('key');
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            if ($quantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = min(50, $quantity);
            }
            session()->put('cart', $cart);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $totalItems = array_sum(array_column($cart, 'quantity'));
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            return response()->json([
                'success' => true,
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2),
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $key = $request->input('key');
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $totalItems = array_sum(array_column($cart, 'quantity'));
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            return response()->json([
                'success' => true,
                'cart_count' => $totalItems,
                'subtotal' => number_format($subtotal, 2),
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('coupon_code')));
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $coupon = Coupon::where('code', $code)->first();
        if (!$coupon) {
            return back()->with('error', 'Invalid coupon code.');
        }

        if (!$coupon->isValidFor($subtotal)) {
            return back()->with('error', "This coupon requires a minimum order of ₹{$coupon->min_order_amount}.");
        }

        $discount = $coupon->calculateDiscount($subtotal);
        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
        ]);

        return back()->with('success', "Coupon '{$coupon->code}' applied successfully! Saved ₹{$discount}.");
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return back()->with('success', 'Coupon removed.');
    }
}
