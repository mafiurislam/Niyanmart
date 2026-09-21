@extends('layouts.app')

@section('title', 'My Account – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">My Account</span>
  </nav>

  <div style="display: grid; grid-template-columns: 240px 1fr; gap: 28px; align-items: start;">
    <!-- Account Sidebar Menu -->
    <aside style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px;">
      <div style="text-align: center; padding: 14px 0 18px; border-bottom: 1px solid var(--border-light); margin-bottom: 12px;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--primary-subtle); color: var(--primary); font-size: 24px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
          {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 2px;">{{ $user->name }}</h4>
        <span style="font-size: 12px; color: var(--text-muted);">{{ $user->email }}</span>
      </div>

      <ul style="list-style: none; display: flex; flex-direction: column; gap: 4px;">
        <li><a href="{{ route('account.dashboard') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; background: var(--primary-subtle); color: var(--primary);"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="{{ route('account.orders') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; color: #334155;"><i class="bi bi-box-seam"></i> My Orders</a></li>
        <li><a href="{{ route('wishlist.index') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; color: #334155;"><i class="bi bi-heart"></i> Wishlist</a></li>
        <li><a href="{{ route('account.profile') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; color: #334155;"><i class="bi bi-person-gear"></i> Profile & Address</a></li>
        @if($user->isAdmin())
          <li><a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; color: #b45309; background: #fef3c7;"><i class="bi bi-shield-lock-fill"></i> Admin Panel</a></li>
        @endif
        <li style="margin-top: 10px; border-top: 1px solid var(--border-light); padding-top: 8px;">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 10px 14px; font-size: 13px; font-weight: 600; color: #ef4444; cursor: pointer; display: flex; align-items: center; gap: 10px;">
              <i class="bi bi-box-arrow-right"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </aside>

    <!-- Main Content Area -->
    <main>
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 4px;">Welcome, {{ $user->name }}!</h2>
        <p style="color: var(--text-muted); font-size: 13px;">From your account dashboard, you can view your recent orders, manage shipping addresses, and edit account information.</p>
      </div>

      <!-- Quick Metrics -->
      <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px;">
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="bi bi-bag-check"></i></div>
          <div>
            <div style="font-size: 22px; font-weight: 800;">{{ $ordersCount }}</div>
            <div style="font-size: 12px; color: var(--text-muted);">Total Orders</div>
          </div>
        </div>

        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="bi bi-heart"></i></div>
          <div>
            <div style="font-size: 22px; font-weight: 800;">{{ $wishlistCount }}</div>
            <div style="font-size: 12px; color: var(--text-muted);">Saved in Wishlist</div>
          </div>
        </div>

        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px;"><i class="bi bi-geo-alt"></i></div>
          <div>
            <div style="font-size: 14px; font-weight: 700;">{{ $user->city ?: 'Kolkata' }}</div>
            <div style="font-size: 12px; color: var(--text-muted);">Default Delivery Area</div>
          </div>
        </div>
      </div>

      <!-- Recent Orders List -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
          <h3 style="font-size: 17px; font-weight: 800;">Recent Orders</h3>
          <a href="{{ route('account.orders') }}" style="font-size: 13px; font-weight: 600; color: var(--primary);">View All Orders →</a>
        </div>

        @if($recentOrders->isEmpty())
          <p style="color: var(--text-muted); font-size: 13px;">No orders placed yet.</p>
        @else
          <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($recentOrders as $ord)
              <div style="border: 1px solid var(--border-light); border-radius: 8px; padding: 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div>
                  <div style="font-weight: 700; font-size: 14px;">Order #{{ $ord->order_number }}</div>
                  <div style="font-size: 12px; color: var(--text-muted);">{{ $ord->created_at->format('d M Y, h:i A') }} • {{ $ord->items->count() }} items</div>
                </div>
                <div style="text-align: right;">
                  <div style="font-weight: 800; font-size: 15px;">₹{{ number_format($ord->total, 0) }}</div>
                  <span style="font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 4px; background: #ecfdf5; color: var(--primary);">{{ $ord->formatted_status }}</span>
                </div>
                <a href="{{ route('order.track', $ord->order_number) }}" class="btn btn-outline-primary" style="padding: 6px 14px; font-size: 12px;">
                  Track
                </a>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </main>
  </div>

</div>
@endsection
