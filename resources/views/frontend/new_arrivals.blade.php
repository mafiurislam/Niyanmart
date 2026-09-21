@extends('layouts.app')

@section('title', 'New Arrival Products – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">New Arrivals</span>
  </nav>

  <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 32px; border: 1px solid #bfdbfe;">
    <span style="background: #2563eb; color: #fff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 999px;">JUST RESTOCKED & ADDED</span>
    <h1 style="font-size: 32px; font-weight: 800; color: #1e3a8a; margin: 8px 0;">New Arrivals & Fresh Stocks</h1>
    <p style="font-size: 15px; color: #1e40af;">Discover the freshest batches of daily household essentials and tasty snacks.</p>
  </div>

  <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
    @foreach($products as $product)
      <x-product_card :product="$product" />
    @endforeach
  </div>

  <div style="margin-top: 24px;">
    {{ $products->links() }}
  </div>

</div>
@endsection
