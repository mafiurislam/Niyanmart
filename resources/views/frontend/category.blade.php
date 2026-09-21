@extends('layouts.app')

@section('title', ($category->name_bn ?: $category->name) . ' – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('shop') }}">Categories</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">{{ $category->name_bn ?: $category->name }}</span>
  </nav>

  <!-- Category Banner Header -->
  <div style="background: linear-gradient(135deg, #ecfdf5 0%, #dcfce7 100%); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; border: 1px solid var(--primary-border);">
    <div>
      <span style="font-size: 12px; font-weight: 700; color: var(--primary); text-transform: uppercase;">Grocery Category</span>
      <h1 style="font-size: 32px; font-weight: 800; color: #06401f; margin: 4px 0;">{{ $category->name_bn ?: $category->name }}</h1>
      <p style="font-size: 15px; color: #334155;">{{ $category->name }} – Fresh stock, everyday low prices and fast 24-hour home delivery.</p>
    </div>
    <div style="width: 80px; height: 80px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-md);">
      <img src="{{ $category->image ?: asset('assets/images/categories/rice.png') }}" alt="{{ $category->name }}" style="width: 60px; height: 60px; object-fit: contain;">
    </div>
  </div>

  <!-- Subcategory Badges -->
  @if($category->subcategories->isNotEmpty())
    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px;">
      @foreach($category->subcategories as $sub)
        <a href="{{ route('shop', ['category' => $category->slug, 'subcategory' => $sub->slug]) }}" style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-full); padding: 6px 16px; font-size: 13px; font-weight: 600; color: #334155; transition: all 0.15s;">
          {{ $sub->name }}
        </a>
      @endforeach
    </div>
  @endif

  <!-- Products Grid -->
  @if($products->isEmpty())
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 48px; text-align: center;">
      <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">No products in this category currently.</h3>
      <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 18px;">Check back soon as fresh items are restocked daily.</p>
      <a href="{{ route('shop') }}" class="btn btn-primary">Browse All Categories</a>
    </div>
  @else
    <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
      @foreach($products as $product)
        <x-product_card :product="$product" />
      @endforeach
    </div>

    <div style="margin-top: 24px;">
      {{ $products->links() }}
    </div>
  @endif

</div>
@endsection
