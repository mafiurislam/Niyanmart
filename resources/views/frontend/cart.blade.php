@extends('layouts.app')

@section('title', 'Shopping Cart – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 500;">Shopping Cart</span>
  </nav>

  <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 24px;">Your Shopping Cart 🛒</h1>

  @if(empty($cart))
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 48px; text-align: center; margin-bottom: 40px;">
      <i class="bi bi-cart-x" style="font-size: 54px; color: #94a3b8; margin-bottom: 16px; display: block;"></i>
      <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Your Cart is Empty</h3>
      <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Looks like you haven't added any fresh groceries to your cart yet.</p>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 12px 28px;">
        <i class="bi bi-basket2-fill"></i> Start Shopping
      </a>
    </div>
  @else

    <!-- Free Delivery Progress Meter -->
    @php
      $amountNeeded = max(0, $freeShippingThreshold - $subtotal);
      $progressPercent = min(100, round(($subtotal / $freeShippingThreshold) * 100));
    @endphp
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 18px 24px; margin-bottom: 24px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 14px; font-weight: 600;">
        @if($amountNeeded > 0)
          <span style="color: #0f172a;"><i class="bi bi-truck" style="color: var(--primary);"></i> Add <strong style="color: var(--primary);">₹{{ number_format($amountNeeded, 0) }}</strong> more to get <strong>FREE Delivery!</strong></span>
        @else
          <span style="color: var(--primary);"><i class="bi bi-check-circle-fill"></i> Congratulations! You've unlocked <strong>FREE Delivery!</strong></span>
        @endif
        <span style="color: var(--text-muted); font-size: 12px;">₹{{ number_format($subtotal, 0) }} / ₹{{ number_format($freeShippingThreshold, 0) }}</span>
      </div>
      <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
        <div style="width: {{ $progressPercent }}%; height: 100%; background: linear-gradient(90deg, #16a34a, #0f7a3f); transition: width 0.3s;"></div>
      </div>
    </div>

    <!-- 2 Column Layout -->
    <div class="checkout-grid">
      <!-- Items List -->
      <div style="display: flex; flex-direction: column; gap: 16px;">
        @foreach($cart as $key => $item)
          <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px 20px; display: flex; align-items: center; gap: 18px;">
            <img src="{{ str_starts_with($item['image'] ?? '', 'http') ? $item['image'] : asset(ltrim($item['image'] ?? 'assets/images/products/mother-dairy-curd.png', '/')) }}" alt="{{ $item['name'] }}" style="width: 70px; height: 70px; object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/mother-dairy-curd.png') }}';">
            
            <div style="flex: 1;">
              <h4 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ $item['name'] }}</h4>
              <span style="font-size: 12px; color: var(--text-muted);">Pack: {{ $item['weight'] }}</span>
              <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 4px;">
                ₹{{ number_format($item['price'], 0) }}
                @if($item['mrp'] > $item['price'])
                  <span style="font-size: 12px; color: #94a3b8; text-decoration: line-through; margin-left: 6px;">₹{{ number_format($item['mrp'], 0) }}</span>
                @endif
              </div>
            </div>

            <!-- Quantity Counter -->
            <div style="display: flex; align-items: center; gap: 12px;">
              <form action="{{ route('cart.update') }}" method="POST" style="display: flex; align-items: center;">
                @csrf
                <input type="hidden" name="key" value="{{ $key }}">
                <div class="qty-counter" style="height: 36px;">
                  <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="qty-btn">−</button>
                  <span class="qty-input" style="line-height: 36px;">{{ $item['quantity'] }}</span>
                  <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="qty-btn">+</button>
                </div>
              </form>

              <!-- Item Subtotal -->
              <span style="font-weight: 800; font-size: 16px; min-width: 60px; text-align: right;">₹{{ number_format($item['price'] * $item['quantity'], 0) }}</span>

              <!-- Remove Item Button -->
              <form action="{{ route('cart.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="key" value="{{ $key }}">
                <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 18px; cursor: pointer; padding: 4px;" title="Remove Item">
                  <i class="bi bi-trash3"></i>
                </button>
              </form>
            </div>
          </div>
        @endforeach

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
          <a href="{{ route('shop') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Continue Shopping
          </a>
        </div>
      </div>

      <!-- Order Summary Card -->
      <div class="order-summary-sidebar">
        <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 16px;">Order Summary</h3>

        <!-- Coupon Input Form -->
        <div style="margin-bottom: 20px; border-bottom: 1px solid var(--border-light); padding-bottom: 18px;">
          <form action="{{ route('cart.apply_coupon') }}" method="POST">
            @csrf
            <label style="font-size: 12px; font-weight: 700; color: #475569; display: block; margin-bottom: 6px;">Have a Promo Coupon?</label>
            <div style="display: flex; gap: 8px;">
              <input type="text" name="coupon_code" placeholder="e.g. NAYAN10" value="{{ $coupon['code'] ?? '' }}" style="flex:1; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: var(--radius-sm); font-size: 13px; text-transform: uppercase;">
              <button type="submit" class="btn btn-outline-primary" style="padding: 8px 16px; font-size: 13px;">Apply</button>
            </div>
          </form>

          @if($coupon)
            <div style="margin-top: 8px; font-size: 12px; color: var(--primary); display: flex; justify-content: space-between; align-items: center;">
              <span>Coupon <strong>{{ $coupon['code'] }}</strong> applied!</span>
              <form action="{{ route('cart.remove_coupon') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 11px; cursor: pointer; text-decoration: underline;">Remove</button>
              </form>
            </div>
          @endif
        </div>

        <!-- Breakdown -->
        <div class="summary-row">
          <span style="color: var(--text-muted);">Items Subtotal</span>
          <span style="font-weight: 600;">₹{{ number_format($subtotal, 2) }}</span>
        </div>

        @if($totalSavings > 0)
          <div class="summary-row" style="color: #16a34a;">
            <span>Product Discount Savings</span>
            <span>- ₹{{ number_format($totalSavings, 2) }}</span>
          </div>
        @endif

        @if($discount > 0)
          <div class="summary-row" style="color: #16a34a;">
            <span>Coupon Discount</span>
            <span>- ₹{{ number_format($discount, 2) }}</span>
          </div>
        @endif

        <div class="summary-row">
          <span style="color: var(--text-muted);">Estimated Delivery</span>
          <span style="font-weight: 600;">
            @if($deliveryCharge == 0)
              <span style="color: var(--primary); font-weight: 700;">FREE</span>
            @else
              ₹{{ number_format($deliveryCharge, 2) }}
            @endif
          </span>
        </div>

        <div class="summary-row summary-total">
          <span>Grand Total</span>
          <span style="color: var(--primary);">₹{{ number_format($grandTotal, 2) }}</span>
        </div>

        <div style="margin-top: 24px;">
          <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 15px;">
            <span>Proceed to Checkout</span>
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>

        <div style="margin-top: 16px; text-align: center; font-size: 12px; color: var(--text-muted);">
          <i class="bi bi-shield-check" style="color: var(--primary);"></i> 100% Safe & Secure Checkout
        </div>
      </div>
    </div>
  @endif

</div>
@endsection
