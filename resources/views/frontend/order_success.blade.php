@extends('layouts.app')

@section('title', 'Order Completed – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav" style="justify-content: center;">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Order Completed</span>
  </nav>

  <div class="order-success-card">
    <div style="display: flex; justify-content: center; align-items: center; gap: 12px; margin-bottom: 16px;">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" style="width: 58px; height: 58px; object-fit: contain; border-radius: 50%; box-shadow: 0 2px 10px rgba(15, 122, 63, 0.18);">
      <!-- Success Icon -->
      <div class="success-check-icon" style="margin: 0;">
        <i class="bi bi-check-lg"></i>
      </div>
    </div>

    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Your order is completed!</h1>
    <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Thank you for shopping with Nayan Mart. Your order has been received.</p>

    <!-- Yellow Order Summary Card (Matching Image 4) -->
    <div class="order-yellow-badge-box">
      <div class="yellow-badge-item">
        <span class="lbl">Order ID</span>
        <span class="val">#{{ $order->order_number }}</span>
      </div>
      <div class="yellow-badge-item">
        <span class="lbl">Payment Method</span>
        <span class="val">{{ $order->payment_method_name }}</span>
      </div>
      <div class="yellow-badge-item">
        <span class="lbl">Transaction ID</span>
        <span class="val">{{ $order->transaction_id ?: 'TR' . strtoupper(substr(md5($order->id), 0, 8)) }}</span>
      </div>
      <div class="yellow-badge-item">
        <span class="lbl">Estimated Delivery</span>
        <span class="val">{{ $order->expected_delivery_date ? $order->expected_delivery_date->format('d M Y') : now()->addDays(2)->format('d M Y') }}</span>
      </div>
      <div>
        <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn btn-primary" style="background-color: #06401f; border-radius: 6px; padding: 10px 18px; font-size: 13px;">
          <i class="bi bi-download"></i>
          <span>Download Invoice</span>
        </a>
      </div>
    </div>

    <!-- Products Table (Matching Image 4) -->
    <div style="text-align: left; margin-bottom: 30px; border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden;">
      <div style="display: flex; justify-content: space-between; padding: 12px 20px; background: #f8fafc; font-weight: 700; font-size: 13px; color: #475569; border-bottom: 1px solid var(--border-color);">
        <span>Products</span>
        <span>Sub Total</span>
      </div>

      @foreach($order->items as $item)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; border-bottom: 1px solid var(--border-light);">
          <div style="display: flex; align-items: center; gap: 14px;">
            <img src="{{ $item->product_image ?: asset('assets/images/products/mother-dairy-curd.png') }}" alt="{{ $item->product_name }}" style="width: 44px; height: 44px; object-fit: contain;">
            <div>
              <div style="font-weight: 700; font-size: 14px; color: #0f172a;">{{ $item->product_name }}</div>
              <div style="font-size: 12px; color: #64748b;">{{ $item->weight }} × {{ $item->quantity }}</div>
            </div>
          </div>
          <div style="font-weight: 700; font-size: 14px; color: #0f172a;">₹{{ number_format($item->subtotal, 2) }}</div>
        </div>
      @endforeach

      <!-- Financials Breakdown -->
      <div style="padding: 14px 20px; background: #f8fafc; border-top: 1px solid var(--border-color);">
        <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 6px; color: #475569;">
          <span>Shipping</span>
          <span>{{ $order->delivery_charge == 0 ? '₹0.00' : '₹' . number_format($order->delivery_charge, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 10px; color: #475569;">
          <span>Taxes</span>
          <span>₹0.00</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 800; color: #0f172a; border-top: 1px solid var(--border-color); padding-top: 8px;">
          <span>Total</span>
          <span>₹{{ number_format($order->total, 2) }}</span>
        </div>
      </div>
    </div>

    <!-- Action Buttons (Matching Image 4) -->
    <div style="display: flex; justify-content: center; gap: 16px;">
      <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-primary" style="padding: 12px 28px;">
        <i class="bi bi-geo-alt"></i>
        <span>Track Your Order</span>
      </a>
      <a href="{{ route('shop') }}" class="btn btn-outline-primary" style="padding: 12px 28px;">
        <i class="bi bi-cart3"></i>
        <span>Continue Shopping</span>
      </a>
    </div>

  </div>

</div>
@endsection
