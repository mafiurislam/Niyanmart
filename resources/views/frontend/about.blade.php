@extends('layouts.app')

@section('title', 'About Us – Nayan Mart | Your Trusted Grocery Store')

@section('content')
<div class="container" style="padding: 30px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">About Us</span>
  </nav>

  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 40px; margin-bottom: 36px;">
    <div style="max-width: 800px; margin: 0 auto;">
      <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart Official Logo" style="width: 90px; height: 90px; object-fit: contain; border-radius: 50%; box-shadow: 0 4px 18px rgba(15, 122, 63, 0.2); flex-shrink: 0;">
        <div>
          <span style="color: var(--primary); font-weight: 800; font-size: 13px; text-transform: uppercase;">About Nayan Mart</span>
          <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin: 4px 0 6px;">“আপনার প্রতিদিনের বাজার, এখন হাতের মুঠোয়”</h1>
        </div>
      </div>
      <p style="font-size: 16px; color: #475569; line-height: 1.8; margin-bottom: 24px;">
        Welcome to <strong>NAYAN MART</strong>! We are dedicated to providing fresh, high-quality groceries, dairy, cooking oils, grains, packaged snacks, and everyday household essentials delivered quickly to your doorstep.
      </p>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 32px 0;">
        <div style="background: #f0fdf4; border-radius: 12px; padding: 24px; border: 1px solid #bbf7d0;">
          <h3 style="color: #06401f; font-size: 18px; font-weight: 800; margin-bottom: 8px;"><i class="bi bi-patch-check-fill" style="color: var(--primary);"></i> Quality Products</h3>
          <p style="color: #166534; font-size: 14px; line-height: 1.6;">Directly sourced from trusted brands and verified farmers. No compromises on purity or fresh packaging.</p>
        </div>

        <div style="background: #fefce8; border-radius: 12px; padding: 24px; border: 1px solid #fef08a;">
          <h3 style="color: #713f12; font-size: 18px; font-weight: 800; margin-bottom: 8px;"><i class="bi bi-lightning-charge-fill" style="color: #eab308;"></i> Fast & Reliable Delivery</h3>
          <p style="color: #854d0e; font-size: 14px; line-height: 1.6;">Orders packed with utmost care and delivered in temperature-safe packaging within hours across our service zones.</p>
        </div>
      </div>

      <h3 style="font-size: 20px; font-weight: 800; margin: 30px 0 12px;">Contact & Store Details</h3>
      <ul style="list-style: none; font-size: 14px; line-height: 2; color: #334155;">
        <li><strong>Brand:</strong> NAYAN MART</li>
        <li><strong>Customer Support Phone:</strong> <a href="tel:7550807912" style="color: var(--primary); font-weight: 600;">7550807912</a></li>
        <li><strong>Email:</strong> <a href="mailto:skrousonali2024@gmail.com" style="color: var(--primary); font-weight: 600;">skrousonali2024@gmail.com</a></li>
        <li><strong>Headquarters & Dispatch:</strong> West Bengal, India</li>
      </ul>
    </div>
  </div>

</div>
@endsection
