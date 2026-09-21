@extends('layouts.app')

@section('title', 'My Profile – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <a href="{{ route('account.dashboard') }}">My Account</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Profile Settings</span>
  </nav>

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Profile & Address Form -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
      <h3 style="font-size: 17px; font-weight: 800; margin-bottom: 16px;">Profile & Address Information</h3>

      <form action="{{ route('account.profile.update') }}" method="POST">
        @csrf

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Full Name *</label>
          <input type="text" name="name" required value="{{ old('name', $user->name) }}" class="pincode-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Email (Account ID)</label>
          <input type="email" disabled value="{{ $user->email }}" class="pincode-input" style="width: 100%; background: #f8fafc;">
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Phone Number *</label>
          <input type="tel" name="phone" required value="{{ old('phone', $user->phone) }}" class="pincode-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Street / Area Address</label>
          <input type="text" name="address" value="{{ old('address', $user->address) }}" class="pincode-input" style="width: 100%;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
          <div>
            <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">City</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}" class="pincode-input" style="width: 100%;">
          </div>
          <div>
            <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">PIN Code</label>
            <input type="text" name="pincode" maxlength="6" value="{{ old('pincode', $user->pincode) }}" class="pincode-input" style="width: 100%;">
          </div>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 22px;">Save Profile</button>
      </form>
    </div>

    <!-- Password Change Form -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
      <h3 style="font-size: 17px; font-weight: 800; margin-bottom: 16px;">Security & Password</h3>

      <form action="{{ route('account.password.change') }}" method="POST">
        @csrf

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Current Password *</label>
          <input type="password" name="current_password" required class="pincode-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 14px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">New Password *</label>
          <input type="password" name="password" required class="pincode-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 20px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Confirm New Password *</label>
          <input type="password" name="password_confirmation" required class="pincode-input" style="width: 100%;">
        </div>

        <button type="submit" class="btn btn-outline-primary" style="padding: 10px 22px;">Change Password</button>
      </form>
    </div>
  </div>

</div>
@endsection
