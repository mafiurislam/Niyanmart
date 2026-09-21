@extends('layouts.admin')

@section('title', 'Store Settings – Nayan Mart Admin')
@section('page_title', 'Store Settings & Brand Information')

@section('content')
<div style="max-width: 760px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 28px;">

  <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Brand & Header Information</h3>

    <div class="form-group">
      <label class="form-label">Store Brand Name *</label>
      <input type="text" name="site_name" required value="{{ $settings['site_name'] ?? 'Nayan Mart' }}" class="form-control">
    </div>

    <div class="form-group">
      <label class="form-label">Bengali Tagline *</label>
      <input type="text" name="tagline" required value="{{ $settings['tagline'] ?? '“আপনার ঘরের বাজার, এখন হাতের মুঠোয়”' }}" class="form-control">
    </div>

    <div class="form-group">
      <label class="form-label">English Sub-Tagline / Value Proposition</label>
      <input type="text" name="sub_tagline" value="{{ $settings['sub_tagline'] ?? 'Quality Products • Best Price • Fast Delivery' }}" class="form-control">
    </div>

    <h3 style="font-size: 16px; font-weight: 800; margin: 24px 0 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Contact & Customer Support</h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Customer Support Phone *</label>
        <input type="text" name="phone" required value="{{ $settings['phone'] ?? '7550807912' }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Support & Orders Email *</label>
        <input type="email" name="email" required value="{{ $settings['email'] ?? 'skrousonali2024@gmail.com' }}" class="form-control">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Warehouse & Dispatch Address</label>
      <textarea name="address" rows="2" class="form-control">{{ $settings['address'] ?? 'Ashoknagar, Kalyangarh, North 24 Parganas, West Bengal, 743263' }}</textarea>
    </div>

    <h3 style="font-size: 16px; font-weight: 800; margin: 24px 0 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">UPI Payment Details</h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">UPI ID / VPA</label>
        <input type="text" name="upi_id" value="{{ $settings['upi_id'] ?? '7550807912@paytm' }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">UPI Payee Name</label>
        <input type="text" name="upi_name" value="{{ $settings['upi_name'] ?? 'NAYAN MART' }}" class="form-control">
      </div>
    <h3 style="font-size: 16px; font-weight: 800; margin: 24px 0 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">
      <i class="bi bi-credit-card-2-front" style="color: #0284c7;"></i> Razorpay Payment Gateway
    </h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Razorpay Key ID *</label>
        <input type="text" name="razorpay_key" value="{{ $settings['razorpay_key'] ?? 'rzp_test_Tei5KSLqOMs25b' }}" class="form-control" placeholder="rzp_test_Tei5KSLqOMs25b">
      </div>
      <div class="form-group">
        <label class="form-label">Razorpay Key Secret</label>
        <input type="password" name="razorpay_secret" value="{{ $settings['razorpay_secret'] ?? '' }}" class="form-control" placeholder="Optional webhook/signature secret">
      </div>
    </div>

    <div style="margin-top: 24px;">
      <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 15px;">Save Settings</button>
    </div>

  </form>

</div>
@endsection
