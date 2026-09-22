<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
  <meta name="theme-color" content="#0f7a3f">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Nayan Mart – আপনার ঘরের বাজার, এখন হাতের মুঠোয় | Online Grocery Store')</title>
  <meta name="description" content="@yield('meta_description', 'Nayan Mart delivers fresh groceries, daily essentials, flours, oils, milk, and household goods right to your doorstep with superfast delivery and best prices.')">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
  
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  @stack('styles')
</head>
<body>

  <!-- Top Announcement Bar (Desktop & Tablet) -->
  <header class="top-bar">
    <div class="container">
      <div class="top-bar-msg">
        <span>Welcome to Nayan Mart - Your Trusted Grocery Partner!</span>
        <span style="opacity: 0.7;">|</span>
        <span style="color: #facc15; font-weight: 600;">Free Delivery on Orders Above ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }} | Fast Delivery in 24 Hours</span>
      </div>
      <div class="top-bar-social">
        <a href="https://wa.me/91{{ \App\Models\Setting::get('phone', '7550807912') }}" target="_blank" title="WhatsApp Us"><i class="bi bi-whatsapp"></i></a>
        <a href="tel:{{ \App\Models\Setting::get('phone', '7550807912') }}" title="Call Us"><i class="bi bi-telephone"></i> {{ \App\Models\Setting::get('phone', '7550807912') }}</a>
        <a href="#" title="Facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" title="Instagram"><i class="bi bi-instagram"></i></a>
      </div>
    </div>
  </header>

  <!-- Mobile App Header Bar (Displayed on Mobile <= 768px) -->
  <header class="mobile-app-header">
    <div class="mobile-header-top">
      <button type="button" id="mobile-drawer-toggle" class="mobile-header-btn" aria-label="Open Navigation Menu">
        <i class="bi bi-list"></i>
      </button>

      <a href="{{ route('home') }}" class="mobile-logo-brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" width="40" height="40">
        <div>
          <span class="mobile-logo-title">Nayan Mart</span>
          <span class="mobile-logo-tagline">আপনার প্রতিদিনের বাজার</span>
        </div>
      </a>

      <div class="mobile-header-actions">
        @php
          $wishlistCount = Auth::check() 
            ? \App\Models\Wishlist::where('user_id', Auth::id())->count()
            : \App\Models\Wishlist::where('session_id', session()->getId())->count();
          $sessionCart = session()->get('cart', []);
          $cartItemCount = array_sum(array_column($sessionCart, 'quantity'));
          $cartSubtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $sessionCart));
        @endphp

        <a href="https://wa.me/91{{ \App\Models\Setting::get('phone', '7550807912') }}" target="_blank" class="mobile-action-icon mobile-wa-btn" title="Chat on WhatsApp">
          <i class="bi bi-whatsapp"></i>
        </a>

        <a href="{{ route('wishlist.index') }}" class="mobile-action-icon" title="Wishlist">
          <i class="bi bi-heart"></i>
          <span class="mobile-badge-count header-wishlist-count">{{ $wishlistCount }}</span>
        </a>

        <a href="{{ route('cart.index') }}" class="mobile-action-icon" title="Cart">
          <i class="bi bi-cart3"></i>
          <span class="mobile-badge-count header-cart-count">{{ $cartItemCount }}</span>
        </a>
      </div>
    </div>

    <!-- Mobile Search Bar (Directly accessible under brand bar) -->
    <div class="mobile-header-search">
      <form action="{{ route('shop') }}" method="GET" class="mobile-search-form">
        <i class="bi bi-search mobile-search-icon"></i>
        <input type="text" name="q" id="mobile-search-input" class="mobile-search-input" placeholder="Search 100+ fresh groceries, atta, oil, milk..." value="{{ request('q') }}" autocomplete="off">
        @if(request('q'))
          <a href="{{ route('shop') }}" class="mobile-search-clear" aria-label="Clear Search"><i class="bi bi-x-circle-fill"></i></a>
        @endif
      </form>
      <div id="mobile-search-dropdown" class="search-autocomplete mobile-autocomplete"></div>
    </div>
  </header>

  <!-- Main Desktop Navigation Header -->
  <nav class="main-header desktop-header-only">
    <div class="container header-inner">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="logo-brand">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" class="site-logo-img" width="52" height="52">
        <div class="logo-brand-info">
          <span class="logo-brand-title">Nayan Mart</span>
          <span class="logo-brand-tagline">আপনার প্রতিদিনের বাজার</span>
        </div>
      </a>

      <!-- Search with Live Autocomplete -->
      <div class="header-search">
        <form action="{{ route('shop') }}" method="GET" class="search-form">
          <input type="text" name="q" id="main-search-input" class="search-input" placeholder="Search for products, dal, atta, milk, oil, snacks..." value="{{ request('q') }}" autocomplete="off">
          <button type="submit" class="search-btn" aria-label="Search">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <div id="search-autocomplete-dropdown" class="search-autocomplete"></div>
      </div>

      <!-- User Actions -->
      <div class="header-actions">
        <!-- Account / Login -->
        @auth
          <a href="{{ route('account.dashboard') }}" class="action-item">
            <span class="action-icon"><i class="bi bi-person-circle"></i></span>
            <div class="action-text">
              <span class="action-label">Hello,</span>
              <span class="action-val">{{ Str::limit(Auth::user()->name, 10) }}</span>
            </div>
          </a>
        @else
          <a href="{{ route('login') }}" class="action-item">
            <span class="action-icon"><i class="bi bi-person"></i></span>
            <div class="action-text">
              <span class="action-label">Sign In</span>
              <span class="action-val">Account</span>
            </div>
          </a>
        @endauth

        <!-- Wishlist -->
        <a href="{{ route('wishlist.index') }}" class="action-item" title="Wishlist">
          <span class="action-icon">
            <i class="bi bi-heart"></i>
            <span id="header-wishlist-count" class="badge-count header-wishlist-count">{{ $wishlistCount }}</span>
          </span>
          <span class="action-val">Wishlist</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('cart.index') }}" class="action-item" title="Shopping Cart">
          <span class="action-icon">
            <i class="bi bi-cart3"></i>
            <span id="header-cart-count" class="badge-count header-cart-count">{{ $cartItemCount }}</span>
          </span>
          <div class="action-text">
            <span class="action-label">Cart</span>
            <span id="header-cart-total" class="action-val header-cart-total">₹{{ number_format($cartSubtotal, 0) }}</span>
          </div>
        </a>
      </div>
    </div>
  </nav>

  <!-- Categories Desktop Sub-Bar -->
  <div class="sub-nav desktop-header-only">
    <div class="container">
      <div style="position: relative;">
        <button type="button" id="all-categories-trigger" class="categories-trigger-btn">
          <i class="bi bi-grid-fill"></i>
          <span>All Categories</span>
          <i class="bi bi-chevron-down" style="font-size: 11px;"></i>
        </button>
        <div id="categories-dropdown-menu" class="categories-dropdown-menu">
          @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order', 'asc')->take(10)->get() as $cat)
            <a href="{{ route('category.show', $cat->slug) }}" class="category-dropdown-item">
              <span>{{ $cat->name_bn ?: $cat->name }}</span>
              <i class="bi bi-chevron-right" style="font-size: 10px; opacity: 0.6;"></i>
            </a>
          @endforeach
        </div>
      </div>

      <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') ? 'active' : '' }}">Categories</a></li>
        <li><a href="{{ route('offers') }}" class="{{ request()->routeIs('offers') ? 'active' : '' }}">Offers</a></li>
        <li><a href="{{ route('best_sellers') }}" class="{{ request()->routeIs('best_sellers') ? 'active' : '' }}">Best Selling</a></li>
        <li><a href="{{ route('new_arrivals') }}" class="{{ request()->routeIs('new_arrivals') ? 'active' : '' }}">New Arrivals</a></li>
        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a></li>
        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a></li>
      </ul>

      <a href="{{ route('deals') }}" class="todays-deals-btn">
        <i class="bi bi-lightning-charge-fill"></i>
        <span>Today's Deals</span>
      </a>
    </div>
  </div>

  <!-- Mobile Slide-Out App Drawer -->
  <div id="mobile-drawer-overlay" class="mobile-drawer-overlay"></div>
  <aside id="mobile-nav-drawer" class="mobile-nav-drawer" aria-hidden="true">
    <!-- Drawer Top Banner -->
    <div class="drawer-header">
      <div class="drawer-user-info">
        <div class="drawer-avatar">
          <i class="bi bi-person-circle"></i>
        </div>
        <div>
          @auth
            <div class="drawer-user-name">{{ Auth::user()->name }}</div>
            <div class="drawer-user-sub">{{ Auth::user()->phone ?: Auth::user()->email }}</div>
          @else
            <div class="drawer-user-name">Welcome to Nayan Mart</div>
            <a href="{{ route('login') }}" class="drawer-login-btn">Sign In / Register <i class="bi bi-arrow-right"></i></a>
          @endauth
        </div>
      </div>
      <button type="button" id="mobile-drawer-close" class="drawer-close-btn" aria-label="Close Menu">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <!-- Drawer Quick Actions Strip -->
    <div class="drawer-quick-actions">
      <a href="https://wa.me/91{{ \App\Models\Setting::get('phone', '7550807912') }}" target="_blank" class="drawer-quick-btn wa">
        <i class="bi bi-whatsapp"></i>
        <span>WhatsApp Order</span>
      </a>
      <a href="tel:{{ \App\Models\Setting::get('phone', '7550807912') }}" class="drawer-quick-btn call">
        <i class="bi bi-telephone-fill"></i>
        <span>Call Hotline</span>
      </a>
    </div>

    <!-- Drawer Scrollable Content -->
    <div class="drawer-body">
      <!-- Fast Grocery Categories -->
      <div class="drawer-section-title">Shop by Category</div>
      <div class="drawer-categories-list">
        @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order', 'asc')->get() as $cat)
          <a href="{{ route('category.show', $cat->slug) }}" class="drawer-category-item">
            <span class="drawer-cat-icon">
              <i class="bi {{ $cat->icon ?: 'bi-bag' }}"></i>
            </span>
            <span class="drawer-cat-text">
              <strong class="drawer-cat-title">{{ $cat->name }}</strong>
              @if($cat->name_bn)
                <span class="drawer-cat-bn">{{ $cat->name_bn }}</span>
              @endif
            </span>
            <i class="bi bi-chevron-right drawer-chevron"></i>
          </a>
        @endforeach
      </div>

      <!-- Quick Navigation -->
      <div class="drawer-section-title" style="margin-top: 20px;">Quick Links</div>
      <ul class="drawer-nav-list">
        <li>
          <a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a>
        </li>
        <li>
          <a href="{{ route('deals') }}"><i class="bi bi-lightning-charge-fill" style="color: #ea580c;"></i> Today's Deals</a>
        </li>
        <li>
          <a href="{{ route('offers') }}"><i class="bi bi-tag-fill" style="color: #0f7a3f;"></i> Offers & Coupons</a>
        </li>
        <li>
          <a href="{{ route('best_sellers') }}"><i class="bi bi-fire" style="color: #dc2626;"></i> Best Selling</a>
        </li>
        <li>
          <a href="{{ route('new_arrivals') }}"><i class="bi bi-stars" style="color: #8b5cf6;"></i> New Arrivals</a>
        </li>
        <li>
          <a href="{{ route('order.track') }}"><i class="bi bi-truck"></i> Track Your Order</a>
        </li>
        <li>
          <a href="{{ route('wishlist.index') }}"><i class="bi bi-heart"></i> My Wishlist (<span class="header-wishlist-count">{{ $wishlistCount }}</span>)</a>
        </li>
        @auth
          <li>
            <a href="{{ route('account.orders') }}"><i class="bi bi-receipt"></i> Order History</a>
          </li>
          <li>
            <a href="{{ route('account.dashboard') }}"><i class="bi bi-person-gear"></i> My Account Profile</a>
          </li>
          @if(Auth::user()->is_admin)
            <li>
              <a href="{{ route('admin.dashboard') }}" style="color: #0f7a3f; font-weight: 700;"><i class="bi bi-speedometer2"></i> Admin Panel</a>
            </li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="drawer-logout-btn"><i class="bi bi-box-arrow-right"></i> Sign Out</button>
            </form>
          </li>
        @endauth
      </ul>

      <!-- Help & Policies -->
      <div class="drawer-section-title" style="margin-top: 20px;">Help & Information</div>
      <ul class="drawer-nav-list subtle">
        <li><a href="{{ route('about') }}">About Nayan Mart</a></li>
        <li><a href="{{ route('contact') }}">Contact Us</a></li>
        <li><a href="{{ route('faq') }}">FAQ</a></li>
        <li><a href="{{ route('policy.show', 'delivery-info') }}">Delivery Information</a></li>
        <li><a href="{{ route('policy.show', 'return-refund') }}">Return & Refund Policy</a></li>
        <li><a href="{{ route('policy.show', 'privacy-policy') }}">Privacy Policy</a></li>
      </ul>
      
      <div class="drawer-footer-text">
        <p>Nayan Mart – আপনার ঘরের বাজার</p>
        <small>v2.0 • Fast & Fresh Delivery</small>
      </div>
    </div>
  </aside>

  <!-- Mobile Floating Mini-Cart Bar (App-like persistent purchase bar) -->
  <div id="mobile-floating-cart" class="mobile-floating-cart {{ $cartItemCount > 0 ? 'visible' : '' }}">
    <a href="{{ route('cart.index') }}" class="floating-cart-inner">
      <div class="floating-cart-left">
        <div class="floating-cart-icon-wrap">
          <i class="bi bi-bag-check-fill"></i>
          <span class="floating-cart-count header-cart-count">{{ $cartItemCount }}</span>
        </div>
        <div class="floating-cart-text">
          <span class="floating-cart-title"><span class="header-cart-count">{{ $cartItemCount }}</span> {{ Str::plural('Item', $cartItemCount) }} added</span>
          <span class="floating-cart-total header-cart-total">₹{{ number_format($cartSubtotal, 0) }}</span>
        </div>
      </div>
      <div class="floating-cart-right">
        <span>View Cart</span>
        <i class="bi bi-arrow-right"></i>
      </div>
    </a>
  </div>

  <!-- Mobile App Bottom Navigation Bar (Fixed 5-Tab Bar) -->
  <nav class="mobile-bottom-nav" id="mobile-bottom-nav">
    <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
      <i class="bi {{ request()->routeIs('home') ? 'bi-house-door-fill' : 'bi-house-door' }}"></i>
      <span>Home</span>
    </a>
    <a href="{{ route('shop') }}" class="bottom-nav-item {{ request()->routeIs('shop*') || request()->routeIs('category*') ? 'active' : '' }}">
      <i class="bi {{ request()->routeIs('shop*') || request()->routeIs('category*') ? 'bi-grid-fill' : 'bi-grid' }}"></i>
      <span>Categories</span>
    </a>
    <a href="{{ route('offers') }}" class="bottom-nav-item {{ request()->routeIs('offers') || request()->routeIs('deals') ? 'active' : '' }}">
      <i class="bi {{ request()->routeIs('offers') || request()->routeIs('deals') ? 'bi-percent' : 'bi-tag' }}"></i>
      <span>Offers</span>
    </a>
    <a href="{{ route('order.track') }}" class="bottom-nav-item {{ request()->routeIs('order.track') ? 'active' : '' }}">
      <i class="bi bi-truck"></i>
      <span>Track</span>
    </a>
    @auth
      <a href="{{ route('account.dashboard') }}" class="bottom-nav-item {{ request()->routeIs('account*') ? 'active' : '' }}">
        <i class="bi {{ request()->routeIs('account*') ? 'bi-person-circle' : 'bi-person' }}"></i>
        <span>Account</span>
      </a>
    @else
      <a href="{{ route('login') }}" class="bottom-nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
        <i class="bi bi-person"></i>
        <span>Sign In</span>
      </a>
    @endauth
  </nav>

  <!-- Flash Notification Messages -->
  <div class="container" style="margin-top: 14px;">
    @if(session('success'))
      <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: 8px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-size: 14px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 18px; border-radius: 8px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-size: 14px;">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
      </div>
    @endif

    @if(session('warning'))
      <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 12px 18px; border-radius: 8px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-size: 14px;">
        <i class="bi bi-info-circle-fill"></i> {{ session('warning') }}
      </div>
    @endif
  </div>

  <!-- Main View Body -->
  <main>
    @yield('content')
  </main>

  <!-- Footer Matching Exact Design -->
  <footer class="main-footer">
    <div class="container">
      <!-- 4 Trust Perks -->
      <div class="footer-trust-strip">
        <div class="footer-trust-grid">
          <div class="footer-trust-item">
            <i class="bi bi-truck"></i>
            <div>
              <h5>Free Delivery</h5>
              <p>On orders above ₹{{ \App\Models\Setting::get('free_shipping_threshold', 249) }}</p>
            </div>
          </div>
          <div class="footer-trust-item">
            <i class="bi bi-clock-history"></i>
            <div>
              <h5>24/7 Support</h5>
              <p>We are available anytime</p>
            </div>
          </div>
          <div class="footer-trust-item">
            <i class="bi bi-shield-check"></i>
            <div>
              <h5>Secure Payment</h5>
              <p>100% secure payment</p>
            </div>
          </div>
          <div class="footer-trust-item">
            <i class="bi bi-percent"></i>
            <div>
              <h5>Best Offers</h5>
              <p>Grab exciting offers & deals</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Footer Columns -->
      <div class="footer-main-grid">
        <!-- Brand Info -->
        <div class="footer-col">
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffffff; padding: 2px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2); flex-shrink: 0;">
              <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%;">
            </div>
            <div>
              <h3 style="color: #ffffff; font-size: 20px; font-weight: 800; line-height: 1.1;">Nayan Mart</h3>
              <p style="color: #cbd5e1; font-size: 11px;">“আপনার প্রতিদিনের বাজার, এখন হাতের মুঠোয়”</p>
            </div>
          </div>
          <p style="color: #cbd5e1; font-size: 13px; line-height: 1.6; margin-bottom: 18px;">
            Your trusted grocery partner. Quality products, best prices, and fast delivery right to your doorstep.
          </p>
          <div style="display: flex; gap: 10px;">
            <a href="https://wa.me/91{{ \App\Models\Setting::get('phone', '7550807912') }}" target="_blank" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; color: #fff;"><i class="bi bi-whatsapp"></i></a>
            <a href="#" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; color: #fff;"><i class="bi bi-facebook"></i></a>
            <a href="#" style="width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; color: #fff;"><i class="bi bi-instagram"></i></a>
          </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-col">
          <h4>Quick Links</h4>
          <ul class="footer-links">
            <li><a href="{{ route('about') }}">About Us</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li><a href="{{ route('offers') }}">Offers & Deals</a></li>
            <li><a href="{{ route('shop') }}">All Categories</a></li>
            <li><a href="{{ route('contact') }}">Customer Support</a></li>
            <li><a href="{{ route('order.track') }}">Track Order</a></li>
          </ul>
        </div>

        <!-- Policies -->
        <div class="footer-col">
          <h4>Policies</h4>
          <ul class="footer-links">
            <li><a href="{{ route('policy.show', 'privacy-policy') }}">Privacy Policy</a></li>
            <li><a href="{{ route('policy.show', 'terms-conditions') }}">Terms & Conditions</a></li>
            <li><a href="{{ route('policy.show', 'return-refund') }}">Refund / Return Policy</a></li>
            <li><a href="{{ route('policy.show', 'delivery-info') }}">Delivery Information</a></li>
            <li><a href="{{ route('faq') }}">Frequently Asked Questions</a></li>
          </ul>
        </div>

        <!-- Contact Us -->
        <div class="footer-col">
          <h4>Contact Us</h4>
          <ul class="footer-contact-info">
            <li>
              <i class="bi bi-telephone-fill"></i>
              <span><a href="tel:{{ \App\Models\Setting::get('phone', '7550807912') }}" style="color: #cbd5e1;">{{ \App\Models\Setting::get('phone', '7550807912') }}</a></span>
            </li>
            <li>
              <i class="bi bi-envelope-fill"></i>
              <span><a href="mailto:{{ \App\Models\Setting::get('email', 'skrousonali2024@gmail.com') }}" style="color: #cbd5e1;">{{ \App\Models\Setting::get('email', 'skrousonali2024@gmail.com') }}</a></span>
            </li>
            <li>
              <i class="bi bi-geo-alt-fill"></i>
              <span>Serving your local area with fast doorstep delivery</span>
            </li>
            <li>
              <i class="bi bi-clock-fill"></i>
              <span>7 Days a Week: 7:00 AM – 10:00 PM</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <div class="footer-bottom-bar">
      <div class="container">
        <p>© 2026 Nayan Mart. All rights reserved. | Quality Products • Best Price • Fast Delivery</p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  @stack('scripts')
</body>
</html>
