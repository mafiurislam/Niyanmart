@extends('layouts.app')

@section('title', 'Track Your Order – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav" style="justify-content: center;">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Track Your Order</span>
  </nav>

  <h1 style="font-size: 28px; font-weight: 800; text-align: center; margin-bottom: 24px;">Track Your Order</h1>

  @if(!$order)
    <!-- Order Lookup Form if no order found or accessing blank -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; max-width: 540px; margin: 0 auto 40px; text-align: center;">
      <i class="bi bi-search" style="font-size: 40px; color: var(--primary); margin-bottom: 12px; display: block;"></i>
      <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">Enter Order ID to Track</h3>
      <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">You can find your Order ID in your order confirmation email or receipt (e.g. NM94821670).</p>
      
      <form action="{{ route('order.track') }}" method="GET">
        <div style="display: flex; gap: 8px; margin-bottom: 12px;">
          <input type="text" name="order_id" required placeholder="e.g. NM94821670" value="{{ $orderNum ?? '' }}" class="pincode-input" style="flex:1;">
          <button type="submit" class="btn btn-primary" style="padding: 10px 22px;">Track</button>
        </div>
      </form>
    </div>
  @else

    <!-- Top Card (Matching Image 3) -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
      <div>
        <div style="display: flex; align-items: center; gap: 12px;">
          <h3 style="font-size: 18px; font-weight: 800; color: #0f172a;">Order Status</h3>
          <span style="background: #ecfdf5; color: #059669; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: var(--radius-full); border: 1px solid #a7f3d0;">
            {{ $order->formatted_status }}
          </span>
        </div>
        <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">
          Order ID: <strong style="color: #0f172a;">#{{ $order->order_number }}</strong>
        </div>
      </div>

      <!-- Cancel Order Button if eligible -->
      @if(in_array($order->order_status, ['placed', 'confirmed']))
        <form action="{{ route('order.cancel', $order->order_number) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
          @csrf
          <button type="submit" style="background: #ffffff; border: 1px solid #f87171; color: #ef4444; border-radius: var(--radius-sm); padding: 7px 14px; font-size: 12px; font-weight: 600; cursor: pointer;">
            <i class="bi bi-x-lg"></i> Cancel Order
          </button>
        </form>
      @endif
    </div>

    <!-- Interactive 5-Step Stepper (Matching Image 3) -->
    @php
      $currentStep = $order->status_step;
      $steps = [
        1 => ['title' => 'Order Placed', 'time' => $order->created_at->format('d M Y, h:i a')],
        2 => ['title' => 'Accepted', 'time' => $order->expected_delivery_date ? 'Expected ' . $order->expected_delivery_date->format('d M Y') : 'Processing'],
        3 => ['title' => 'In Progress', 'time' => 'Packed & Checked'],
        4 => ['title' => 'On the Way', 'time' => 'Out for Delivery'],
        5 => ['title' => 'Delivered', 'time' => 'Doorstep Delivery'],
      ];
    @endphp
    <div class="tracking-stepper-box">
      <div class="stepper-progress">
        @foreach($steps as $stepNum => $step)
          <div class="stepper-step {{ $stepNum < $currentStep ? 'completed' : ($stepNum == $currentStep ? 'active' : '') }}">
            <div class="step-circle">
              @if($stepNum < $currentStep)
                <i class="bi bi-check-lg" style="font-size: 20px;"></i>
              @else
                {{ $stepNum }}
              @endif
            </div>
            <div class="step-title">{{ $step['title'] }}</div>
            <div class="step-date">{{ $step['time'] }}</div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Expected Delivery Banner (Matching Image 3) -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 14px 20px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; color: #0f7a3f;">
        <i class="bi bi-truck" style="font-size: 20px;"></i>
        <span>Expected Delivery: {{ $order->expected_delivery_date ? $order->expected_delivery_date->format('l, d F') : 'Within 24 Hours' }}</span>
      </div>
      <span style="background: #0f7a3f; color: #ffffff; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: var(--radius-full);">
        Standard Delivery
      </span>
    </div>

    <!-- 2 Column Section: Products & Payment/Address (Matching Image 3) -->
    <div class="checkout-grid">
      <!-- Left: Products List -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Products</h3>
        
        <div style="display: flex; flex-direction: column; gap: 14px;">
          @foreach($order->items as $item)
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-light); padding-bottom: 14px;">
              <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ $item->product_image ?: asset('assets/images/products/mother-dairy-curd.png') }}" alt="{{ $item->product_name }}" style="width: 48px; height: 48px; object-fit: contain;">
                <div>
                  <div style="font-weight: 700; font-size: 14px; color: #0f172a;">{{ $item->product_name }}</div>
                  <div style="font-size: 12px; color: #64748b;">{{ $item->weight }} | {{ $item->quantity }} Qty</div>
                </div>
              </div>
              <div style="font-weight: 800; font-size: 15px; color: #0f172a;">₹{{ number_format($item->subtotal, 0) }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Right: Payment & Delivery Address -->
      <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Payment Details Card -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
          <h3 style="font-size: 15px; font-weight: 800; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-credit-card" style="color: var(--primary);"></i>
            <span>Payment</span>
          </h3>

          <div style="font-size: 13px; line-height: 2;">
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-muted);">Method</span>
              <strong style="color: #0f172a;">{{ $order->payment_method_name }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-muted);">Status</span>
              <strong style="color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#ea580c' }}; text-transform: capitalize;">{{ $order->payment_status }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-light); padding-top: 6px; margin-top: 6px;">
              <span style="color: var(--text-muted);">Subtotal</span>
              <span>₹{{ number_format($order->subtotal, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: var(--text-muted);">Delivery</span>
              <span style="color: var(--primary); font-weight: 700;">{{ $order->delivery_charge == 0 ? 'FREE' : '₹' . number_format($order->delivery_charge, 0) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 15px; font-weight: 800; border-top: 2px solid var(--border-color); padding-top: 8px; margin-top: 6px;">
              <span>Total</span>
              <span style="color: #0f172a;">₹{{ number_format($order->total, 0) }}</span>
            </div>
          </div>
        </div>

        <!-- Delivery Address Card -->
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
          <h3 style="font-size: 15px; font-weight: 800; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-geo-alt" style="color: var(--primary);"></i>
            <span>Delivery Address</span>
          </h3>

          <div style="font-size: 13px; color: #334155; line-height: 1.6;">
            <strong>{{ $order->customer_name }}</strong><br>
            @if($order->house_flat) {{ $order->house_flat }}, @endif
            {{ $order->street_area }}<br>
            {{ $order->city }}, {{ $order->state }} {{ $order->pincode }}<br>
            Phone: {{ $order->customer_phone }}
          </div>

          <div style="margin-top: 10px; font-size: 12px; color: var(--primary); font-weight: 600;">
            <i class="bi bi-box-seam"></i> Delivery: Standard Delivery
          </div>
        </div>

        <!-- Continue Shopping Button (Matching Image 3) -->
        <a href="{{ route('shop') }}" class="btn btn-outline-primary" style="width: 100%; padding: 12px;">
          <i class="bi bi-bag"></i>
          <span>Continue Shopping</span>
        </a>
      </div>
    </div>
  @endif

</div>
@endsection
