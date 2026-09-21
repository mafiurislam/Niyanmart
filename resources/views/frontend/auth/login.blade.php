@extends('layouts.app')

@section('title', 'Sign In – Nayan Mart')

@section('content')
<div class="container" style="padding: 40px 16px;">
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 440px; margin: 0 auto; padding: 36px; box-shadow: var(--shadow-sm);">
    
    <div style="text-align: center; margin-bottom: 24px;">
      <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Sign In to Nayan Mart</h2>
      <p style="color: var(--text-muted); font-size: 13px;">Manage your orders, addresses, and wishlist</p>
    </div>

    <!-- Pre-filled test credentials helper box for instant testing -->
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px; font-size: 12px; margin-bottom: 20px;">
      <strong>Demo Accounts:</strong><br>
      • Admin: <code>admin@nayanmart.com</code> / <code>admin123</code><br>
      • Customer: <code>skrousonali2024@gmail.com</code> / <code>password123</code>
    </div>

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf

      <div style="margin-bottom: 16px;">
        <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Email Address</label>
        <input type="email" name="email" required value="{{ old('email', 'admin@nayanmart.com') }}" class="pincode-input" style="width: 100%;">
      </div>

      <div style="margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155;">Password</label>
        </div>
        <input type="password" name="password" required value="admin123" class="pincode-input" style="width: 100%;">
      </div>

      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #475569; cursor: pointer;">
          <input type="checkbox" name="remember" checked>
          <span>Remember me</span>
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px;">
        <span>Sign In</span>
      </button>
    </form>

    <div style="margin-top: 24px; text-align: center; font-size: 13px; color: #475569; border-top: 1px solid var(--border-light); padding-top: 16px;">
      Don't have an account? 
      <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700;">Sign Up</a>
    </div>

  </div>
</div>
@endsection
