@extends('layouts.app')

@section('title', 'Best Selling Groceries – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Best Selling</span>
  </nav>

  <div style="background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 32px; border: 1px solid #a7f3d0;">
    <span style="background: var(--primary); color: #fff; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 999px;">TOP RATED BY THOUSANDS</span>
    <h1 style="font-size: 32px; font-weight: 800; color: #06401f; margin: 8px 0;">Most Popular & Best Selling Products</h1>
    <p style="font-size: 15px; color: #166534;">Customer favorites based on everyday repeat orders and highest ratings.</p>
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
