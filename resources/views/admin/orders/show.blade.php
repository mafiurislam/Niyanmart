@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number . ' – Nayan Mart Admin')
@section('page_title', 'Order Details #' . $order->order_number)

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 28px; align-items: start;">

  <!-- Left: Order Items & Delivery Information -->
  <div>
    <!-- Items Card -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px; margin-bottom: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 16px; font-weight: 800;">Ordered Grocery Items</h3>
        <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn btn-outline-secondary" style="font-size: 12px; padding: 6px 14px;">
          <i class="bi bi-printer"></i> Print Invoice
        </a>
      </div>

      <div class="admin-table-wrap" style="margin-bottom: 0;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Weight</th>
              <th>Unit Price</th>
              <th>Qty</th>
              <th style="text-align: right;">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
              <tr>
                <td>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ $item->product_image ?: asset('assets/images/products/mother-dairy-curd.png') }}" style="width: 36px; height: 36px; object-fit: contain;">
                    <div style="font-weight: 700; color: #0f172a;">{{ $item->product_name }}</div>
                  </div>
                </td>
                <td>{{ $item->weight }}</td>
                <td>₹{{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td style="text-align: right; font-weight: 700;">₹{{ number_format($item->subtotal, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- Financials -->
      <div style="display: flex; justify-content: flex-end; margin-top: 16px;">
        <div style="width: 260px; font-size: 13px; line-height: 2;">
          <div style="display: flex; justify-content: space-between;">
            <span style="color: var(--text-muted);">Subtotal:</span>
            <span>₹{{ number_format($order->subtotal, 2) }}</span>
          </div>
          @if($order->discount > 0)
            <div style="display: flex; justify-content: space-between; color: #16a34a;">
              <span>Coupon ({{ $order->coupon_code }}):</span>
              <span>- ₹{{ number_format($order->discount, 2) }}</span>
            </div>
          @endif
          <div style="display: flex; justify-content: space-between;">
            <span style="color: var(--text-muted);">Delivery Fee:</span>
            <span>{{ $order->delivery_charge == 0 ? 'FREE' : '₹' . number_format($order->delivery_charge, 2) }}</span>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; border-top: 2px solid var(--border-color); padding-top: 6px;">
            <span>Grand Total:</span>
            <span style="color: var(--primary);">₹{{ number_format($order->total, 2) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Customer & Delivery Address Card -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 14px;">Customer & Delivery Address</h3>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 13px; line-height: 1.8;">
        <div>
          <span style="color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase;">Customer Info</span><br>
          <strong>{{ $order->customer_name }}</strong><br>
          Phone: <a href="tel:{{ $order->customer_phone }}" style="color: var(--primary); font-weight: 600;">{{ $order->customer_phone }}</a><br>
          Email: {{ $order->customer_email ?: 'N/A' }}
        </div>
        <div>
          <span style="color: var(--text-muted); font-size: 12px; font-weight: 700; text-transform: uppercase;">Shipping Address ({{ $order->address_type }})</span><br>
          @if($order->house_flat) {{ $order->house_flat }}, @endif
          {{ $order->street_area }}<br>
          @if($order->landmark) Landmark: {{ $order->landmark }}<br> @endif
          {{ $order->city }}, {{ $order->state }} – {{ $order->pincode }}
        </div>
      </div>
    </div>
  </div>

  <!-- Right: Status Modifiers -->
  <div style="display: flex; flex-direction: column; gap: 20px;">
    <!-- Order Status Updater -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <h3 style="font-size: 15px; font-weight: 800; margin-bottom: 12px;">Update Order Status</h3>

      <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label">Current Status</label>
          <select name="order_status" class="form-control" style="font-weight: 600;">
            <option value="placed" {{ $order->order_status == 'placed' ? 'selected' : '' }}>Order Placed</option>
            <option value="confirmed" {{ $order->order_status == 'confirmed' ? 'selected' : '' }}>Order Confirmed</option>
            <option value="packed" {{ $order->order_status == 'packed' ? 'selected' : '' }}>Packed / In Progress</option>
            <option value="out_for_delivery" {{ $order->order_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
            <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Status Notes / Reason</label>
          <textarea name="notes" rows="2" class="form-control" placeholder="Optional notes for customer tracking..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Update Order Status</button>
      </form>
    </div>

    <!-- Payment Status Updater -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <h3 style="font-size: 15px; font-weight: 800; margin-bottom: 12px;">Payment Status</h3>

      <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST">
        @csrf
        <div style="font-size: 13px; margin-bottom: 12px;">
          Method: <strong>{{ $order->payment_method_name }}</strong>
        </div>

        <div class="form-group">
          <label class="form-label">Status</label>
          <select name="payment_status" class="form-control">
            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $order->payment_status == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
            <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
          </select>
        </div>

        <button type="submit" class="btn btn-outline-primary" style="width: 100%; padding: 8px;">Update Payment</button>
      </form>
    </div>

    <!-- Order Tracking Log History -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <h3 style="font-size: 15px; font-weight: 800; margin-bottom: 12px;">Tracking Log</h3>
      <div style="display: flex; flex-direction: column; gap: 10px; font-size: 12px;">
        @foreach($order->trackings as $track)
          <div style="border-left: 2px solid var(--primary); padding-left: 10px;">
            <strong>{{ $track->title }}</strong>
            <div style="color: var(--text-muted);">{{ $track->tracked_at->format('d M Y, h:i A') }}</div>
            @if($track->description)
              <div style="color: #475569;">{{ $track->description }}</div>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>
@endsection
