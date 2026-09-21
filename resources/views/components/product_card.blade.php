@props(['product'])

@php
  $isWishlisted = false;
  if (Auth::check()) {
    $isWishlisted = \App\Models\Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
  } else {
    $isWishlisted = \App\Models\Wishlist::where('session_id', session()->getId())->where('product_id', $product->id)->exists();
  }
@endphp

<div class="product-card">
  <!-- Discount Badge -->
  @if($product->badge || $product->discount_percent > 0)
    <span class="product-badge">{{ $product->badge ?: $product->discount_percent . '% OFF' }}</span>
  @endif

  <!-- Wishlist Heart Button -->
  <button type="button" class="btn-wishlist {{ $isWishlisted ? 'active' : '' }}" data-product-id="{{ $product->id }}" title="Add to Wishlist" aria-label="Add to Wishlist">
    <i class="bi {{ $isWishlisted ? 'bi-heart-fill' : 'bi-heart' }}"></i>
  </button>

  <!-- Product Image -->
  <a href="{{ route('product.show', $product->slug) }}" class="product-image-wrap">
    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/mother-dairy-curd.png') }}';">
  </a>

  <!-- Category & Rating -->
  <div class="product-category">{{ $product->category->name ?? 'Daily Essentials' }}</div>
  <div class="product-rating">
    <i class="bi bi-star-fill"></i>
    <span>{{ number_format($product->rating, 1) }}</span>
  </div>

  <!-- Product Name -->
  <a href="{{ route('product.show', $product->slug) }}" class="product-title" title="{{ $product->name }}">
    {{ $product->name }}
  </a>

  <!-- Weight / Size -->
  <div class="product-weight">{{ $product->weight }}</div>

  <!-- Price & MRP -->
  <div class="product-price-row">
    <span class="product-price">₹{{ number_format($product->selling_price, 0) }}</span>
    @if($product->mrp > $product->selling_price)
      <span class="product-mrp">₹{{ number_format($product->mrp, 0) }}</span>
    @endif
  </div>

  <!-- Add to Cart Button -->
  <button type="button" class="btn-add-cart" onclick="addToCartAjax({{ $product->id }})">
    <i class="bi bi-plus-lg"></i>
    <span>Add</span>
  </button>
</div>
