@extends('layouts.app')

@section('title', 'Nayan Mart – আপনার ঘরের বাজার, এখন হাতের মুঠোয় | Fresh Groceries & Daily Essentials')

@section('content')
<div class="container">

  <!-- 1. Hero Banner Section -->
  <section class="hero-section">
    <div class="hero-banner-card">
      <div class="hero-content">
        <span class="hero-badge">
          <i class="bi bi-patch-check-fill"></i>
          <span>Your Trusted Online Grocery Store</span>
        </span>
        <h1 class="hero-title">Nayan Mart</h1>
        <div class="hero-tagline-bn">“আপনার ঘরের বাজার, এখন হাতের মুঠোয়”</div>
        <p class="hero-subtitle">Quality Products • Best Price • Fast Delivery</p>

        <!-- Feature Pills -->
        <div class="hero-features-strip">
          <div class="hero-feature-pill">
            <i class="bi bi-lightning-charge-fill"></i>
            <span>Fast Delivery</span>
          </div>
          <div class="hero-feature-pill">
            <i class="bi bi-shield-check"></i>
            <span>Best Quality</span>
          </div>
          <div class="hero-feature-pill">
            <i class="bi bi-lock-fill"></i>
            <span>100% Secure</span>
          </div>
          <div class="hero-feature-pill">
            <i class="bi bi-headset"></i>
            <span>24/7 Support</span>
          </div>
        </div>

        <!-- Hero Action Buttons -->
        <div class="hero-cta-btns">
          <a href="{{ route('shop') }}" class="btn btn-primary">
            <span>Shop Now</span>
            <i class="bi bi-arrow-right"></i>
          </a>
          <a href="{{ route('deals') }}" class="btn btn-outline-primary" style="background:#fff;">
            <i class="bi bi-lightning-fill" style="color:var(--accent);"></i>
            <span>Today's Deals</span>
          </a>
        </div>
      </div>

      <!-- Hero Basket Media -->
      <div class="hero-media-wrapper">
        <img src="{{ asset('assets/images/banners/hero-basket.png') }}" alt="Nayan Mart Fresh Grocery Basket">
      </div>
    </div>
  </section>

  <!-- 2. Value Propositions Bar (4-Column Trust Row) -->
  <section class="value-props-section">
    <div class="value-props-grid">
      <div class="value-prop-card">
        <div class="value-prop-icon"><i class="bi bi-truck"></i></div>
        <div class="value-prop-info">
          <h4>Free Delivery</h4>
          <p>On orders above ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }}</p>
        </div>
      </div>
      <div class="value-prop-card">
        <div class="value-prop-icon"><i class="bi bi-clock-history"></i></div>
        <div class="value-prop-info">
          <h4>24/7 Support</h4>
          <p>We are available anytime</p>
        </div>
      </div>
      <div class="value-prop-card">
        <div class="value-prop-icon"><i class="bi bi-shield-lock"></i></div>
        <div class="value-prop-info">
          <h4>Secure Payment</h4>
          <p>100% secure payment</p>
        </div>
      </div>
      <div class="value-prop-card">
        <div class="value-prop-icon"><i class="bi bi-gift"></i></div>
        <div class="value-prop-info">
          <h4>Best Offers</h4>
          <p>Grab exciting deals</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. Shop By Category (Circular Cards) -->
  <section style="margin-bottom: 36px;">
    <div class="section-header">
      <h2 class="section-title">
        <i class="bi bi-grid" style="color: var(--primary);"></i>
        <span>Shop By Category</span>
      </h2>
      <a href="{{ route('shop') }}" class="view-all-link">
        <span>View All</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="categories-grid">
      @foreach($categories as $category)
        <a href="{{ route('category.show', $category->slug) }}" class="category-circle-card">
          <div class="category-circle-icon">
            <img src="{{ $category->image ?: asset('assets/images/categories/rice.png') }}" alt="{{ $category->name }}">
          </div>
          <span class="category-name-bn">{{ $category->name_bn ?: $category->name }}</span>
          <span class="category-name-en">{{ $category->name }}</span>
        </a>
      @endforeach
    </div>
  </section>

  <!-- 4. Featured Products -->
  <section style="margin-bottom: 40px;">
    <div class="section-header">
      <h2 class="section-title">
        <i class="bi bi-stars" style="color: var(--primary);"></i>
        <span>Featured Products</span>
      </h2>
      <a href="{{ route('shop') }}" class="view-all-link">
        <span>View All</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="product-grid">
      @foreach($featuredProducts as $product)
        <x-product_card :product="$product" />
      @endforeach
    </div>
  </section>

  <!-- 5. Best Selling Products -->
  <section style="margin-bottom: 40px;">
    <div class="section-header">
      <h2 class="section-title">
        <i class="bi bi-trophy-fill" style="color: var(--accent);"></i>
        <span>Best Selling</span>
      </h2>
      <a href="{{ route('best_sellers') }}" class="view-all-link">
        <span>View All</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="product-grid">
      @foreach($bestSellingProducts as $product)
        <x-product_card :product="$product" />
      @endforeach
    </div>
  </section>

  <!-- 6. 3 Promotional Banners -->
  <section class="promo-banners-section">
    <div class="promo-banners-grid">
      <div class="promo-banner-card promo-banner-1">
        <div>
          <span class="promo-badge">SPECIAL DISCOUNT 10% OFF</span>
          <h3 class="promo-title">Fresh Daily Dairy</h3>
          <p class="promo-sub">Directly from verified farms to your kitchen</p>
        </div>
        <a href="{{ route('shop', ['category' => 'daily-essentials']) }}" class="promo-btn">
          <span>Shop Now</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="promo-banner-card promo-banner-2">
        <div>
          <span class="promo-badge">FREE DELIVERY</span>
          <h3 class="promo-title">On Orders Above ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }}</h3>
          <p class="promo-sub">Speedy, sanitized, temperature-safe grocery delivery</p>
        </div>
        <a href="{{ route('shop') }}" class="promo-btn">
          <span>Order Now</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="promo-banner-card promo-banner-3">
        <div>
          <span class="promo-badge">BIG SAVINGS</span>
          <h3 class="promo-title">Monthly Grocery Pack</h3>
          <p class="promo-sub">Save up to 25% on Atta, Dal, Spices & Cooking Oils</p>
        </div>
        <a href="{{ route('shop', ['category' => 'rice-and-pulses']) }}" class="promo-btn">
          <span>Shop Now</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- 7. New Arrival Products -->
  <section style="margin-bottom: 40px;">
    <div class="section-header">
      <h2 class="section-title">
        <i class="bi bi-sparkles" style="color: var(--primary);"></i>
        <span>New Arrivals</span>
      </h2>
      <a href="{{ route('new_arrivals') }}" class="view-all-link">
        <span>View All</span>
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    <div class="product-grid">
      @foreach($newArrivals as $product)
        <x-product_card :product="$product" />
      @endforeach
    </div>
  </section>

</div>
@endsection
