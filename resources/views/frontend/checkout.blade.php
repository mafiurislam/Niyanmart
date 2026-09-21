@extends('layouts.app')

@section('title', 'Checkout – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav" style="justify-content: center;">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('cart.index') }}">Shopping Cart</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Checkout</span>
  </nav>

  <h1 style="font-size: 28px; font-weight: 800; text-align: center; margin-bottom: 30px;">Checkout</h1>

  @php
    $razorpayKey = \App\Models\Setting::get('razorpay_key', config('services.razorpay.key', 'rzp_test_Tei5KSLqOMs25b'));
  @endphp

  <form id="checkout-form" action="{{ route('checkout.place_order') }}" method="POST">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">

    <div class="checkout-grid">
      <!-- Left Column: Address & Payment Method -->
      <div>
        <!-- 1. Delivery Address Card -->
        <div class="checkout-box">
          <h3 style="font-size: 17px; font-weight: 700; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="bi bi-geo-alt-fill" style="color: var(--primary);"></i>
            <span>Delivery Address</span>
          </h3>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Full Name *</label>
              <input type="text" name="customer_name" required value="{{ old('customer_name', $user->name ?? '') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. Mafiur Islam">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Mobile Number *</label>
              <input type="tel" name="customer_phone" required value="{{ old('customer_phone', $user->phone ?? '') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. 9382559266">
            </div>
          </div>

          <div style="margin-bottom: 14px;">
            <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Email Address</label>
            <input type="email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. skrousonali2024@gmail.com">
          </div>

          <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 14px; margin-bottom: 14px;">
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Flat / House / Shop No.</label>
              <input type="text" name="house_flat" value="{{ old('house_flat', '') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. Saitul chicken shop">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Street Address / Area / Locality *</label>
              <input type="text" name="street_area" required value="{{ old('street_area', $user->address ?? '') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. Ashoknagar, kalyangarh, bhatchhala">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 14px;">
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">City / Town *</label>
              <input type="text" name="city" required value="{{ old('city', $user->city ?? 'Kolkata') }}" class="pincode-input" style="width: 100%;">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">State *</label>
              <input type="text" name="state" required value="{{ old('state', $user->state ?? 'West Bengal') }}" class="pincode-input" style="width: 100%;">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">PIN Code *</label>
              <input type="text" name="pincode" required maxlength="6" value="{{ old('pincode', $user->pincode ?? '743263') }}" class="pincode-input" style="width: 100%;">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px;">
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Landmark (Optional)</label>
              <input type="text" name="landmark" value="{{ old('landmark', '') }}" class="pincode-input" style="width: 100%;" placeholder="Near Rail Gate / School / Temple">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; color: #475569; display: block; margin-bottom: 4px;">Address Type</label>
              <select name="address_type" class="pincode-input" style="width: 100%;">
                <option value="Home">Home (All Day Delivery)</option>
                <option value="Work">Work / Office (10 AM - 6 PM)</option>
                <option value="Other">Other</option>
              </select>
            </div>
          </div>
        </div>

        <!-- 2. Select Payment Method -->
        <div class="checkout-box">
          <h3 style="font-size: 17px; font-weight: 700; margin-bottom: 16px;">Select Payment Method</h3>

          <!-- Razorpay Online Payment (Recommended) -->
          <label class="payment-method-card active" style="border: 2px solid var(--primary); background: #f0fdf4;">
            <input type="radio" name="payment_method" value="razorpay" checked>
            <div style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #dcfce7; border-radius: 8px;">
              <i class="bi bi-credit-card-2-front-fill" style="font-size: 20px; color: var(--primary);"></i>
            </div>
            <div style="flex:1;">
              <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-weight: 700; font-size: 14px; color: #0f172a;">Pay Online via Razorpay</span>
                <span style="background: #16a34a; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">RECOMMENDED</span>
              </div>
              <div style="font-size: 12px; color: #475569; margin-top: 2px;">Instant Payment via UPI (GPay, PhonePe, Paytm), Debit/Credit Cards, NetBanking</div>
            </div>
          </label>

          <!-- COD -->
          <label class="payment-method-card" style="margin-top: 12px;">
            <input type="radio" name="payment_method" value="cod">
            <div style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #f1f5f9; border-radius: 8px;">
              <i class="bi bi-cash-stack" style="font-size: 20px; color: #475569;"></i>
            </div>
            <div style="flex:1;">
              <span style="font-weight: 600; font-size: 14px; color: #0f172a;">Cash On Delivery (COD)</span>
              <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Pay with cash upon delivery at your doorstep.</div>
            </div>
          </label>
        </div>
      </div>

      <!-- Right Column: Order Summary -->
      <div>
        <div class="order-summary-sidebar">
          <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 16px;">Order Summary</h3>

          <!-- Products Listing -->
          <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 16px;">
            @foreach($cart as $item)
              <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <img src="{{ str_starts_with($item['image'] ?? '', 'http') ? $item['image'] : asset(ltrim($item['image'] ?? 'assets/images/products/mother-dairy-curd.png', '/')) }}" 
                       alt="{{ $item['name'] }}" 
                       style="width: 38px; height: 38px; object-fit: contain; border-radius: 4px; border: 1px solid #f1f5f9;"
                       onerror="this.onerror=null;this.src='{{ asset('assets/images/products/mother-dairy-curd.png') }}';">
                  <div>
                    <div style="font-size: 13px; font-weight: 600; color: #0f172a;">{{ $item['name'] }} × {{ $item['quantity'] }}</div>
                    <div style="font-size: 11px; color: #64748b;">{{ $item['weight'] }}</div>
                  </div>
                </div>
                <div style="font-size: 14px; font-weight: 700; color: #0f172a;">₹{{ number_format($item['price'] * $item['quantity'], 0) }}</div>
              </div>
            @endforeach
          </div>

          <!-- Totals Breakdown -->
          <div class="summary-row">
            <span style="color: var(--text-muted);">Items ({{ array_sum(array_column($cart, 'quantity')) }})</span>
            <span style="font-weight: 600;">₹{{ number_format($subtotal, 0) }}</span>
          </div>

          <div class="summary-row">
            <span style="color: var(--text-muted);">Sub Total</span>
            <span style="font-weight: 600;">₹{{ number_format($subtotal, 0) }}</span>
          </div>

          <div class="summary-row">
            <span style="color: var(--text-muted);">Shipping</span>
            <span style="font-weight: 600;">
              @if($deliveryCharge == 0)
                <span style="color: #16a34a; font-weight: 700;">FREE</span>
              @else
                ₹{{ number_format($deliveryCharge, 2) }}
              @endif
            </span>
          </div>

          <div class="summary-row">
            <span style="color: var(--text-muted);">Taxes</span>
            <span style="font-weight: 600;">₹0.00</span>
          </div>

          @if($totalSavings > 0)
            <div class="summary-row" style="color: #16a34a;">
              <span>Product Savings</span>
              <span>- ₹{{ number_format($totalSavings, 0) }}</span>
            </div>
          @endif

          @if($discount > 0)
            <div class="summary-row" style="color: #16a34a;">
              <span>Coupon Savings</span>
              <span>- ₹{{ number_format($discount, 0) }}</span>
            </div>
          @endif

          <div class="summary-row summary-total">
            <span>Total</span>
            <span style="color: #0f172a;">₹{{ number_format($grandTotal, 2) }}</span>
          </div>

          <!-- Place Order / Pay Button -->
          <button type="button" id="btn-place-order" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 16px; margin-top: 20px;">
            <span id="btn-order-label">Proceed to Pay ₹{{ number_format($grandTotal, 2) }}</span>
          </button>

          <div style="margin-top: 14px; text-align: center; font-size: 12px; color: #16a34a; font-weight: 500;">
            <i class="bi bi-shield-check"></i> 100% Secure Payment powered by Razorpay
          </div>
        </div>
      </div>
    </div>
  </form>

</div>

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('checkout-form');
    const orderBtn = document.getElementById('btn-place-order');
    const btnLabel = document.getElementById('btn-order-label');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

    // Toggle active card styles
    paymentRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.payment-method-card').forEach(c => {
          c.classList.remove('active');
          c.style.border = '1px solid var(--border-color)';
          c.style.background = '#fff';
        });
        const parent = radio.closest('.payment-method-card');
        if (parent) {
          parent.classList.add('active');
          if (radio.value === 'razorpay') {
            parent.style.border = '2px solid var(--primary)';
            parent.style.background = '#f0fdf4';
            btnLabel.innerText = "Proceed to Pay ₹{{ number_format($grandTotal, 2) }}";
          } else {
            parent.style.border = '2px solid var(--primary)';
            btnLabel.innerText = "Confirm Order (COD)";
          }
        }
      });
    });

    orderBtn.addEventListener('click', (e) => {
      e.preventDefault();

      // Check form validity for customer address fields
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

      if (selectedMethod === 'cod') {
        orderBtn.disabled = true;
        btnLabel.innerText = "Placing your order...";
        form.submit();
        return;
      }

      // Razorpay Online Payment Flow
      orderBtn.disabled = true;
      btnLabel.innerText = "Opening Razorpay Gateway...";

      const custName = document.querySelector('input[name="customer_name"]').value;
      const custEmail = document.querySelector('input[name="customer_email"]').value || "customer@nayanmart.com";
      const custPhone = document.querySelector('input[name="customer_phone"]').value;

      const options = {
        key: "{{ $razorpayKey }}",
        amount: {{ round($grandTotal * 100) }}, // in paise
        currency: "INR",
        name: "{{ \App\Models\Setting::get('site_name', 'Nayan Mart') }}",
        description: "Order Payment ({{ count($cart) }} Items)",
        image: "{{ asset('assets/images/logo.svg') }}",
        prefill: {
          name: custName,
          email: custEmail,
          contact: custPhone
        },
        theme: {
          color: "#16a34a"
        },
        handler: function (response) {
          btnLabel.innerText = "Payment Verified! Creating Order...";
          document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
          form.submit();
        },
        modal: {
          ondismiss: function () {
            orderBtn.disabled = false;
            btnLabel.innerText = "Proceed to Pay ₹{{ number_format($grandTotal, 2) }}";
            if (typeof showToast === 'function') {
              showToast('Payment window closed. Please complete payment to place your order.', 'warning');
            }
          }
        }
      };

      try {
        const rzp = new Razorpay(options);
        rzp.on('payment.failed', function (response) {
          orderBtn.disabled = false;
          btnLabel.innerText = "Proceed to Pay ₹{{ number_format($grandTotal, 2) }}";
          alert("Payment could not be completed: " + (response.error.description || 'Unknown error'));
        });
        rzp.open();
      } catch (err) {
        console.error("Razorpay Error:", err);
        orderBtn.disabled = false;
        btnLabel.innerText = "Proceed to Pay ₹{{ number_format($grandTotal, 2) }}";
        alert("Error loading Razorpay checkout. Please check internet connection or choose Cash On Delivery.");
      }
    });
  });
</script>
@endsection
