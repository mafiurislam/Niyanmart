@extends('layouts.app')

@section('title', 'My Orders – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('account.dashboard') }}">My Account</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">My Orders</span>
  </nav>

  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
    <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px;">My Orders</h2>

    @if($orders->isEmpty())
      <div style="text-align: center; padding: 40px 0;">
        <i class="bi bi-box2" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">No orders found</h4>
        <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 16px;">You have not placed any orders with us yet.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 10px 24px;">Start Shopping</a>
      </div>
    @else
      <div style="display: flex; flex-direction: column; gap: 16px;">
        @foreach($orders as $order)
          <div style="border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
              <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-weight: 800; font-size: 15px; color: #0f172a;">Order #{{ $order->order_number }}</span>
                <span style="font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 4px; background: #ecfdf5; color: var(--primary);">
                  {{ $order->formatted_status }}
                </span>
              </div>
              <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                Placed on {{ $order->created_at->format('d M Y, h:i A') }} • {{ $order->items->count() }} items • Payment: {{ $order->payment_method_name }} ({{ ucfirst($order->payment_status) }})
              </div>
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
              <div style="text-align: right;">
                <div style="font-size: 17px; font-weight: 800; color: #0f172a;">₹{{ number_format($order->total, 2) }}</div>
              </div>
              <a href="{{ route('order.track', $order->order_number) }}" class="btn btn-primary" style="padding: 8px 18px; font-size: 13px;">
                <i class="bi bi-geo-alt"></i> Track
              </a>
              <a href="{{ route('order.invoice', $order->order_number) }}" target="_blank" class="btn btn-outline-secondary" style="padding: 8px 14px; font-size: 13px;" title="Invoice">
                <i class="bi bi-receipt"></i>
              </a>
            </div>
          </div>
        @endforeach
      </div>

      <div style="margin-top: 20px;">
        {{ $orders->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
