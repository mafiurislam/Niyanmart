@extends('layouts.app')

@section('title', $product->name . ' – Nayan Mart | Fast Grocery Delivery')

@section('content')
<div class="container">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('shop') }}">Shop</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('category.show', $product->category->slug ?? 'all') }}">{{ $product->category->name ?? 'Category' }}</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 500;">{{ $product->name }}</span>
  </nav>

  <!-- Product Detail Layout (2 Columns) -->
  <div class="product-detail-layout">
    <!-- Left: Gallery -->
    <div class="product-detail-gallery">
      <div class="gallery-main-img" style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; text-align: center; display: flex; align-items: center; justify-content: center; min-height: 380px;">
        <img id="main-product-display" 
             src="{{ $product->image_url }}" 
             alt="{{ $product->name }}" 
             style="max-width: 100%; max-height: 350px; object-fit: contain; transition: transform 0.3s ease;"
             onerror="this.onerror=null;this.src='{{ asset('assets/images/products/mother-dairy-curd.png') }}';">
      </div>

      <!-- Gallery Thumbnails Strip -->
      @php
        $galleryImages = $product->gallery_urls;
      @endphp
      @if(count($galleryImages) > 1)
        <div class="gallery-thumbnails-strip" style="display: flex; gap: 10px; margin-top: 14px; overflow-x: auto; padding-bottom: 6px;">
          @foreach($galleryImages as $idx => $gUrl)
            <button type="button" 
                    class="gallery-thumb-btn {{ $loop->first ? 'active' : '' }}" 
                    onclick="switchMainImage('{{ $gUrl }}', this)"
                    style="width: 68px; height: 68px; border: 2px solid {{ $loop->first ? 'var(--primary)' : '#e2e8f0' }}; border-radius: 8px; background: #ffffff; padding: 4px; cursor: pointer; transition: all 0.2s; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
              <img src="{{ $gUrl }}" alt="{{ $product->name }} view {{ $idx + 1 }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" onerror="this.onerror=null;this.src='{{ asset('assets/images/products/mother-dairy-curd.png') }}';">
            </button>
          @endforeach
        </div>
      @endif
    </div>

    <!-- Right: Product Information -->
    <div class="product-detail-info">
      <!-- In Stock Badge -->
      <div>
        @if($product->stock > 0)
          <span class="stock-status-pill stock-in">
            <i class="bi bi-check2-circle"></i> In Stock
          </span>
        @else
          <span class="stock-status-pill stock-out">
            <i class="bi bi-x-circle"></i> Out of Stock
          </span>
        @endif
      </div>

      <!-- Title -->
      <h1 class="detail-title">{{ $product->name }}</h1>

      <!-- Rating & Reviews -->
      <div class="detail-rating-row">
        <div style="color: #f59e0b; font-size: 16px;">
          @for($i = 1; $i <= 5; $i++)
            <i class="bi bi-star{{ $i <= round($product->rating) ? '-fill' : '' }}"></i>
          @endfor
        </div>
        <span style="font-weight: 700; font-size: 14px;">{{ number_format($product->rating, 1) }}</span>
        <span style="color: var(--text-muted); font-size: 13px;">({{ $product->reviews_count ?: 125 }} Reviews)</span>
      </div>

      <!-- Price Section -->
      <div class="detail-price-box">
        <span id="selected-product-price" class="detail-price">₹{{ number_format($product->selling_price, 0) }}</span>
        @if($product->mrp > $product->selling_price)
          <span id="selected-product-mrp" class="detail-mrp">₹{{ number_format($product->mrp, 0) }}</span>
          <span id="selected-product-savings" class="detail-savings-badge">
            Save ₹{{ number_format($product->mrp - $product->selling_price, 0) }}
          </span>
        @endif
      </div>

      <!-- Short Description -->
      <p style="color: #475569; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
        {{ $product->description }}
      </p>

      <!-- Weight Selector Pills -->
      <div class="weight-selector-wrap">
        <span class="selector-label">Weight / Pack Size</span>
        <div class="weight-pills-list">
          @if($product->variants->isNotEmpty())
            @foreach($product->variants as $variant)
              <button type="button" 
                      class="weight-pill-btn {{ $variant->is_default || $loop->first ? 'active' : '' }}" 
                      data-weight="{{ $variant->weight }}" 
                      data-price="{{ $variant->selling_price }}" 
                      data-mrp="{{ $variant->mrp }}"
                      data-image="{{ $variant->image_url }}">
                {{ $variant->weight }}
              </button>
            @endforeach
          @else
            <!-- Standard sample weight options if no variants defined -->
            <button type="button" class="weight-pill-btn active" data-weight="{{ $product->weight }}" data-price="{{ $product->selling_price }}" data-mrp="{{ $product->mrp }}" data-image="{{ $product->image_url }}">{{ $product->weight }}</button>
          @endif
        </div>
      </div>

      <!-- Form for Add to Cart / Buy Now -->
      <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="weight" id="selected-weight-input" value="{{ $product->weight }}">

        <div class="actions-row">
          <!-- Quantity Counter -->
          <div class="qty-counter">
            <button type="button" class="qty-btn qty-dec">−</button>
            <input type="text" name="quantity" class="qty-input" value="1" readonly>
            <button type="button" class="qty-btn qty-inc">+</button>
          </div>

          <!-- Add To Cart Button -->
          <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 15px;">
            <i class="bi bi-cart3"></i>
            <span>Add To Cart</span>
          </button>

          <!-- Buy Now Button -->
          <button type="submit" name="buy_now" value="1" class="btn btn-accent" style="padding: 12px 24px; font-size: 15px;">
            <i class="bi bi-lightning-fill"></i>
            <span>Buy Now</span>
          </button>

          <!-- Wishlist Heart Button -->
          <button type="button" class="btn-wishlist" data-product-id="{{ $product->id }}" style="position:static; width:44px; height:44px; font-size:18px;">
            <i class="bi bi-heart"></i>
          </button>
        </div>
      </form>

      <!-- SKU & Meta Details -->
      <div style="font-size: 13px; color: #64748b; line-height: 1.8; border-top: 1px solid var(--border-light); padding-top: 16px; margin-bottom: 20px;">
        <div><strong>SKU:</strong> {{ $product->sku ?: 'NM' . strtoupper(substr(md5($product->slug), 0, 8)) }}</div>
        <div><strong>Category:</strong> <a href="{{ route('category.show', $product->category->slug ?? '') }}" style="color:var(--primary); font-weight:600;">{{ $product->category->name ?? 'Grocery' }}</a></div>
        <div><strong>Brand:</strong> {{ $product->brand ?: 'Nayan Mart' }}</div>
      </div>

      <!-- Trust Badges Row -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; border-top: 1px solid var(--border-light); padding-top: 16px;">
        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; color: #334155;">
          <i class="bi bi-truck" style="color: var(--primary); font-size: 18px;"></i>
          <span>Free Delivery above ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; color: #334155;">
          <i class="bi bi-arrow-repeat" style="color: var(--primary); font-size: 18px;"></i>
          <span>Easy Returns in 24 Hours</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 600; color: #334155;">
          <i class="bi bi-shield-check" style="color: var(--primary); font-size: 18px;"></i>
          <span>100% Genuine Fresh</span>
        </div>
      </div>

      <!-- Delivery PIN code checker -->
      <div class="pincode-checker-box" style="margin-top: 24px;">
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #0f172a;">
          <i class="bi bi-geo-alt-fill" style="color: var(--primary);"></i>
          <span>Check Delivery Availability in Your Area</span>
        </div>
        <div class="pincode-input-group">
          <input type="text" id="pincode-input" class="pincode-input" placeholder="Enter 6-digit PIN code (e.g. 743263, 700001)" maxlength="6">
          <button type="button" id="btn-check-pincode" class="btn btn-primary" style="padding: 8px 18px; font-size: 13px;">Check</button>
        </div>
        <div id="pincode-result" style="font-size: 12px; margin-top: 8px;"></div>
      </div>

    </div>
  </div>

  <!-- Product Specifications & Details Tabs -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; margin-bottom: 40px;">
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; border-bottom: 2px solid var(--primary); display: inline-block; padding-bottom: 6px;">Product Specifications & Quality Promise</h3>
    <ul style="list-style: none; margin-bottom: 20px; font-size: 14px; color: #334155; line-height: 1.8;">
      <li><i class="bi bi-check-circle-fill" style="color: var(--primary); margin-right: 8px;"></i> 100% genuine and farm-fresh product</li>
      <li><i class="bi bi-check-circle-fill" style="color: var(--primary); margin-right: 8px;"></i> Carefully sanitized and safely packed</li>
      <li><i class="bi bi-check-circle-fill" style="color: var(--primary); margin-right: 8px;"></i> Best price guaranteed across local markets</li>
      <li><i class="bi bi-check-circle-fill" style="color: var(--primary); margin-right: 8px;"></i> Fast, temperature-maintained doorstep delivery</li>
    </ul>

    @if($product->specifications)
      <div style="background: #f8fafc; border-radius: 8px; padding: 16px; font-size: 13px; color: #475569; white-space: pre-line;">
        {{ $product->specifications }}
      </div>
    @endif

    <!-- Reviews Section -->
    <div style="margin-top: 36px; border-top: 1px solid var(--border-color); padding-top: 24px;">
      <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">Customer Reviews ({{ $product->reviews->count() }})</h3>
      
      @if($product->reviews->isNotEmpty())
        <div style="display: grid; gap: 16px; margin-bottom: 28px;">
          @foreach($product->reviews as $review)
            <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: 8px; padding: 16px;">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                <span style="font-weight: 700; font-size: 14px;">{{ $review->customer_name }}</span>
                <span style="color: #f59e0b; font-size: 13px;">
                  @for($s = 1; $s <= 5; $s++)
                    <i class="bi bi-star{{ $s <= $review->rating ? '-fill' : '' }}"></i>
                  @endfor
                </span>
              </div>
              <p style="font-size: 13px; color: #475569;">{{ $review->comment }}</p>
            </div>
          @endforeach
        </div>
      @else
        <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">No customer reviews yet. Be the first to review this product!</p>
      @endif

      <!-- Add Review Form -->
      <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px; max-width: 600px;">
        <h4 style="font-size: 15px; font-weight: 700; color: #06401f; margin-bottom: 12px;">Write a Review</h4>
        <form action="{{ route('product.review', $product->id) }}" method="POST">
          @csrf
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
            <div>
              <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">Your Name *</label>
              <input type="text" name="customer_name" required class="pincode-input" style="width: 100%;" value="{{ Auth::check() ? Auth::user()->name : '' }}">
            </div>
            <div>
              <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">Rating (1 to 5 Stars) *</label>
              <select name="rating" required class="pincode-input" style="width: 100%;">
                <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
                <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                <option value="3">⭐⭐⭐ (3 Stars)</option>
                <option value="2">⭐⭐ (2 Stars)</option>
                <option value="1">⭐ (1 Star)</option>
              </select>
            </div>
          </div>
          <div style="margin-bottom: 12px;">
            <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">Your Review / Experience *</label>
            <textarea name="comment" rows="3" required class="pincode-input" style="width: 100%;" placeholder="Share your experience about product quality and delivery..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="padding: 8px 20px; font-size: 13px;">Submit Review</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Related Products (Matching Image 1) -->
  <section style="margin-bottom: 50px;">
    <div style="text-align: center; margin-bottom: 24px;">
      <span style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Related Products</span>
      <h2 style="font-size: 24px; font-weight: 800; color: #0f172a;">Explore Related Products</h2>
    </div>

    <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
      @foreach($relatedProducts as $relProduct)
        <x-product_card :product="$relProduct" />
      @endforeach
    </div>
  </section>

</div>

<script>
  function switchMainImage(url, btn) {
    const mainImg = document.getElementById('main-product-display');
    if (mainImg) {
      mainImg.style.opacity = '0.4';
      mainImg.src = url;
      setTimeout(() => { mainImg.style.opacity = '1'; }, 150);
    }
    document.querySelectorAll('.gallery-thumb-btn').forEach(b => {
      b.style.borderColor = '#e2e8f0';
    });
    if (btn) {
      btn.style.borderColor = 'var(--primary)';
    }
  }
</script>
@endsection
