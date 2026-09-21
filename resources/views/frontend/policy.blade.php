@extends('layouts.app')

@php
  $titles = [
    'privacy-policy' => 'Privacy Policy',
    'terms-conditions' => 'Terms & Conditions',
    'return-refund' => 'Return & Refund Policy',
    'delivery-info' => 'Delivery Information'
  ];
  $pageTitle = $titles[$type] ?? 'Policy Details';
@endphp

@section('title', $pageTitle . ' – Nayan Mart')

@section('content')
<div class="container" style="padding: 30px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">{{ $pageTitle }}</span>
  </nav>

  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; max-width: 800px; margin: 0 auto 50px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 20px;">{{ $pageTitle }}</h1>

    <div style="color: #475569; font-size: 14px; line-height: 1.8;">
      @if($type === 'privacy-policy')
        <p>At Nayan Mart, accessible from nayanmart.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by Nayan Mart and how we use it.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">Information We Collect</h4>
        <p>When you register for an account or place an order, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">How We Use Your Information</h4>
        <p>We use customer details solely to process and deliver your grocery orders, provide order tracking updates, send delivery notifications, and improve customer support.</p>
      @elseif($type === 'return-refund')
        <p>We want you to be 100% satisfied with the fresh groceries you receive from Nayan Mart.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">Perishable Items & Dairy</h4>
        <p>If any dairy product or fresh vegetable is received damaged or not up to quality expectations, please report it within 24 hours of delivery. A replacement or instant refund to your UPI/original payment method will be issued.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">Packaged Goods</h4>
        <p>Unopened packaged products with seals intact can be returned within 7 days of delivery.</p>
      @elseif($type === 'delivery-info')
        <p>Nayan Mart operates express local grocery delivery to ensure you receive farm-fresh dairy and groceries without delays.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">Delivery Timings & Slots</h4>
        <p>We deliver 7 days a week between 7:00 AM and 10:00 PM. Local orders are dispatched in specialized temperature-safe carriers.</p>
        <h4 style="color: #0f172a; margin: 18px 0 8px;">Free Delivery Threshold</h4>
        <p>All orders of ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }} or more are delivered with zero delivery charges. Orders below this threshold carry a nominal fee of ₹{{ \App\Models\Setting::get('standard_delivery_fee', 30) }}.</p>
      @else
        <p>By accessing or using the Nayan Mart website, you agree to be bound by these Terms and Conditions. All products listed are subject to availability. Prices and promotions are subject to change without prior notice.</p>
      @endif
    </div>
  </div>

</div>
@endsection
