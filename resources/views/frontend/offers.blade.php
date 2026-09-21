@extends('layouts.app')

@section('title', 'Special Offers & Deals – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Offers & Deals</span>
  </nav>

  <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 32px; border: 1px solid #fcd34d;">
    <span style="background: #f59e0b; color: #fff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 999px;">TODAY'S SPECIAL DISCOUNTS</span>
    <h1 style="font-size: 32px; font-weight: 800; color: #78350f; margin: 8px 0;">Special Grocery Deals & Mega Discounts</h1>
    <p style="font-size: 15px; color: #92400e;">Huge savings on everyday kitchen essentials, ghee, dairy, pulses, and snacks.</p>
  </div>

  <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
    @foreach($discountProducts as $product)
      <x-product_card :product="$product" />
    @endforeach
  </div>

  <div style="margin-top: 24px;">
    {{ $discountProducts->links() }}
  </div>

</div>
@endsection
