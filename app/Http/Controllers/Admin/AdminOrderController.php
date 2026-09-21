<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTracking;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%")
                  ->orWhere('city', 'like', "%{$s}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'trackings', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:placed,confirmed,packed,out_for_delivery,delivered,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $request->order_status;

        $order->update([
            'order_status' => $newStatus,
            'notes' => $request->notes ?: $order->notes,
        ]);

        // If cancelled, restore stock
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product_id) {
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                }
            }
        }

        // Add tracking step
        $statusTitles = [
            'placed' => 'Order Placed',
            'confirmed' => 'Order Confirmed',
            'packed' => 'Order Packed & Ready',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered to Customer',
            'cancelled' => 'Order Cancelled',
        ];

        OrderTracking::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'title' => $statusTitles[$newStatus] ?? ucfirst($newStatus),
            'description' => $request->notes ?: "Status updated to " . ($statusTitles[$newStatus] ?? $newStatus),
            'tracked_at' => now(),
        ]);

        return back()->with('success', "Order status updated to " . ($statusTitles[$newStatus] ?? $newStatus));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'payment_status' => 'required|in:pending,processing,paid,failed,refunded',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', "Payment status updated to " . ucfirst($request->payment_status));
    }
}
