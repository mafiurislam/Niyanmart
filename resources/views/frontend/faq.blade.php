@extends('layouts.app')

@section('title', 'Frequently Asked Questions – Nayan Mart')

@section('content')
<div class="container" style="padding: 30px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">FAQ</span>
  </nav>

  <div style="max-width: 800px; margin: 0 auto 50px;">
    <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 24px; text-align: center;">Frequently Asked Questions</h1>

    <div style="display: flex; flex-direction: column; gap: 16px;">
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">How long does delivery take?</h3>
        <p style="font-size: 14px; color: #475569; line-height: 1.6;">Orders within local service areas are delivered same-day (within 2 to 6 hours). Regional orders are delivered within 24 to 48 hours.</p>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">What is the minimum order for Free Delivery?</h3>
        <p style="font-size: 14px; color: #475569; line-height: 1.6;">Orders totaling ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }} or above qualify automatically for 100% Free Doorstep Delivery!</p>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">Is Cash on Delivery (COD) available?</h3>
        <p style="font-size: 14px; color: #475569; line-height: 1.6;">Yes! We support Cash on Delivery, UPI (PhonePe, Google Pay, Paytm), and card payments.</p>
      </div>

      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">How can I track my order?</h3>
        <p style="font-size: 14px; color: #475569; line-height: 1.6;">Click "Track Order" in the top bar or footer and enter your Order ID (e.g. #NM94821670) to view live progress from packing to delivery.</p>
      </div>
    </div>
  </div>

</div>
@endsection
