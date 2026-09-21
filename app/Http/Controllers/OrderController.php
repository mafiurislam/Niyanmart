<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function track(Request $request, $order_number = null)
    {
        $orderNum = $order_number ?? $request->get('order_id');
        
        // Clean leading '#' if entered
        if ($orderNum) {
            $orderNum = ltrim(trim($orderNum), '#');
        }

        $order = null;
        if ($orderNum) {
            $order = Order::where('order_number', $orderNum)
                ->with(['items', 'trackings'])
                ->first();
        }

        return view('frontend.order_track', compact('order', 'orderNum'));
    }

    public function cancel(Request $request, $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        // Check if cancellable
        if (!in_array($order->order_status, ['placed', 'confirmed'])) {
            return back()->with('error', 'This order cannot be cancelled as it is already being packed or dispatched.');
        }

        $order->update([
            'order_status' => 'cancelled',
            'notes' => ($order->notes ? $order->notes . ' | ' : '') . 'Cancelled by customer on ' . now()->toDayDateTimeString(),
        ]);

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->product_id) {
                Product::where('id', $item->product_id)->increment('stock', $item->quantity);
            }
        }

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => 'cancelled',
            'title' => 'Order Cancelled',
            'description' => 'Order was cancelled by the customer.',
            'tracked_at' => now(),
        ]);

        return back()->with('success', "Order #{$order->order_number} has been cancelled successfully.");
    }
}
