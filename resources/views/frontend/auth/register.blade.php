@extends('layouts.app')

@section('title', 'Sign Up – Nayan Mart')

@section('content')
<div class="container" style="padding: 40px 16px;">
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); max-width: 480px; margin: 0 auto; padding: 36px; box-shadow: var(--shadow-sm);">
    
    <div style="text-align: center; margin-bottom: 22px;">
      <a href="{{ route('home') }}" style="display: inline-block;">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Nayan Mart" style="width: 76px; height: 76px; object-fit: contain; border-radius: 50%; margin: 0 auto 12px; display: block; box-shadow: 0 4px 16px rgba(15, 122, 63, 0.18);">
      </a>
      <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Create an Account</h2>
      <p style="color: var(--text-muted); font-size: 13px;">আপনার প্রতিদিনের বাজার • Fresh Groceries at Best Prices</p>
    </div>

    <form action="{{ route('register.submit') }}" method="POST">
      @csrf

      <div style="margin-bottom: 14px;">
        <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Full Name *</label>
        <input type="text" name="name" required value="{{ old('name') }}" class="pincode-input" style="width: 100%;" placeholder="e.g. Rahul Sharma">
      </div>

      <div style="margin-bottom: 14px;">
        <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Email Address *</label>
        <input type="email" name="email" required value="{{ old('email') }}" class="pincode-input" style="width: 100%;" placeholder="name@example.com">
      </div>

      <div style="margin-bottom: 14px;">
        <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Mobile Number *</label>
        <input type="tel" name="phone" required value="{{ old('phone') }}" class="pincode-input" style="width: 100%;" placeholder="10-digit mobile number">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
        <div>
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Password *</label>
          <input type="password" name="password" required class="pincode-input" style="width: 100%;" placeholder="At least 6 characters">
        </div>
        <div>
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Confirm Password *</label>
          <input type="password" name="password_confirmation" required class="pincode-input" style="width: 100%;">
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px;">
        <span>Create Account</span>
      </button>
    </form>

    <div style="margin-top: 24px; text-align: center; font-size: 13px; color: #475569; border-top: 1px solid var(--border-light); padding-top: 16px;">
      Already have an account? 
      <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Sign In</a>
    </div>

  </div>
</div>
@endsection
