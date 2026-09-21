@extends('layouts.app')

@section('title', 'My Wishlist ❤️ – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">My Wishlist</span>
  </nav>

  <h1 style="font-size: 26px; font-weight: 800; margin-bottom: 24px;">My Wishlist ❤️</h1>

  @if($wishlistItems->isEmpty())
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 48px; text-align: center; margin-bottom: 40px;">
      <i class="bi bi-heart" style="font-size: 54px; color: #fca5a5; margin-bottom: 16px; display: block;"></i>
      <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Your Wishlist is Empty</h3>
      <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Explore our catalog and save your favorite groceries for later.</p>
      <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 12px 28px;">
        <i class="bi bi-basket2-fill"></i> Discover Products
      </a>
    </div>
  @else
    <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
      @foreach($wishlistItems as $item)
        @if($item->product)
          <x-product_card :product="$item->product" />
        @endif
      @endforeach
    </div>
  @endif

</div>
@endsection
