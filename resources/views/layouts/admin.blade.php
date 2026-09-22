<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
  <title>@yield('title', 'Admin Dashboard – Nayan Mart')</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <style>
    .admin-table-wrap { background: #fff; border: 1px solid var(--border-color); border-radius: 10px; overflow-x: auto; -webkit-overflow-scrolling: touch; margin-bottom: 24px; }
    .admin-table { width: 100%; min-width: 600px; border-collapse: collapse; font-size: 13px; text-align: left; }
    .admin-table th { background: #f8fafc; padding: 12px 16px; font-weight: 700; color: #475569; border-bottom: 1px solid var(--border-color); white-space: nowrap; }
    .admin-table td { padding: 12px 16px; border-bottom: 1px solid var(--border-light); vertical-align: middle; }
    .admin-table tr:hover { background-color: #f8fafc; }
    .status-badge { display: inline-block; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; white-space: nowrap; }
    .status-placed { background: #eff6ff; color: #1d4ed8; }
    .status-confirmed { background: #fef3c7; color: #b45309; }
    .status-packed { background: #f3e8ff; color: #7e22ce; }
    .status-out_for_delivery { background: #e0f2fe; color: #0369a1; }
    .status-delivered { background: #ecfdf5; color: #047857; }
    .status-cancelled { background: #fef2f2; color: #b91c1c; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 14px; outline: none; box-sizing: border-box; }
    .form-control:focus { border-color: var(--primary); }
    
    /* Responsive Admin Toggle & Overlays */
    .admin-menu-toggle { display: none; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; width: 40px; height: 40px; align-items: center; justify-content: center; font-size: 20px; color: #1e293b; cursor: pointer; }
    .admin-drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 998; opacity: 0; transition: opacity 0.3s ease; }
    .admin-drawer-overlay.active { display: block; opacity: 1; }
    
    @media (max-width: 992px) {
      .admin-layout { position: relative; min-height: 100vh; }
      .admin-menu-toggle { display: flex; }
      .admin-sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 280px; max-width: 85vw; z-index: 999; transform: translateX(-100%); transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 4px 0 25px rgba(0,0,0,0.25); overflow-y: auto; }
      .admin-sidebar.open { transform: translateX(0); }
      .admin-content-area { width: 100%; min-width: 0; }
      .admin-top-navbar { padding: 12px 16px; }
      .admin-main-body { padding: 16px; }
    }
  </style>
  @stack('styles')
</head>
<body>

<div class="admin-layout">
  <!-- Admin Backdrop Overlay for Mobile -->
  <div id="admin-drawer-overlay" class="admin-drawer-overlay"></div>

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar" id="admin-sidebar">
    <div class="admin-sidebar-header" style="display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 44px; height: 44px; border-radius: 50%; background: #ffffff; padding: 2px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.25); flex-shrink: 0;">
          <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" style="width: 100%; height: 100%; object-fit: contain; border-radius: 50%;">
        </div>
        <div>
          <h3 style="font-size: 17px; font-weight: 800; color: #fff; line-height: 1.1;">Nayan Mart</h3>
          <span style="font-size: 11px; color: #bbf7d0;">Admin Portal</span>
        </div>
      </div>
      <button type="button" id="admin-sidebar-close" style="display: none; background: none; border: none; color: #fff; font-size: 22px; cursor: pointer; padding: 4px;" aria-label="Close Sidebar">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>

    <ul class="admin-nav-list">
      <li class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
        <a href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> Products</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
        <a href="{{ route('admin.categories.index') }}"><i class="bi bi-grid"></i> Categories</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <a href="{{ route('admin.orders.index') }}"><i class="bi bi-cart-check"></i> Orders</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
        <a href="{{ route('admin.customers.index') }}"><i class="bi bi-people"></i> Customers</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.coupons*') ? 'active' : '' }}">
        <a href="{{ route('admin.coupons.index') }}"><i class="bi bi-tag"></i> Coupons & Offers</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.banners*') ? 'active' : '' }}">
        <a href="{{ route('admin.banners.index') }}"><i class="bi bi-image"></i> Banners & Sliders</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.delivery*') ? 'active' : '' }}">
        <a href="{{ route('admin.delivery.index') }}"><i class="bi bi-geo-alt"></i> Delivery & PIN Codes</a>
      </li>
      <li class="admin-nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <a href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> Store Settings</a>
      </li>

      <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
        <a href="{{ route('home') }}" target="_blank" style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; color: #bbf7d0; font-size: 13px;">
          <i class="bi bi-box-arrow-up-right"></i> View Live Store
        </a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 16px; color: #fca5a5; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-box-arrow-right"></i> Logout Admin
          </button>
        </form>
      </li>
    </ul>
  </aside>

  <!-- Admin Main Content Area -->
  <div class="admin-content-area">
    <!-- Top Bar -->
    <header class="admin-top-navbar">
      <div style="display: flex; align-items: center; gap: 12px;">
        <button type="button" id="admin-menu-toggle" class="admin-menu-toggle" aria-label="Toggle Menu">
          <i class="bi bi-list"></i>
        </button>
        <div style="font-weight: 700; font-size: 16px; color: #0f172a;">
          @yield('page_title', 'Admin Dashboard')
        </div>
      </div>
      <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; padding: 6px 10px;">
          <i class="bi bi-shop"></i> <span style="display: none; @media(min-width:640px){display:inline;}">Store</span>
        </a>
        <span style="font-size: 12px; color: var(--text-muted);">
          <strong>{{ Str::limit(Auth::user()->name, 12) }}</strong>
        </span>
      </div>
    </header>

    <!-- Content Body -->
    <main class="admin-main-body">
      @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
          <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
          <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        </div>
      @endif

      @yield('content')
    </main>
  </div>
</div>

<script>
  // Admin mobile drawer toggle
  document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('admin-menu-toggle');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-drawer-overlay');
    const closeBtn = document.getElementById('admin-sidebar-close');

    function openAdminDrawer() {
      if (sidebar) sidebar.classList.add('open');
      if (overlay) overlay.classList.add('active');
      if (closeBtn) closeBtn.style.display = 'block';
      document.body.style.overflow = 'hidden';
    }

    function closeAdminDrawer() {
      if (sidebar) sidebar.classList.remove('open');
      if (overlay) overlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openAdminDrawer);
    if (overlay) overlay.addEventListener('click', closeAdminDrawer);
    if (closeBtn) closeBtn.addEventListener('click', closeAdminDrawer);
  });
</script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
