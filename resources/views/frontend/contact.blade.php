@extends('layouts.app')

@section('title', 'Customer Support & Contact – Nayan Mart')

@section('content')
<div class="container" style="padding: 30px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 600;">Customer Support</span>
  </nav>

  <div style="text-align: center; max-width: 600px; margin: 0 auto 36px;">
    <h1 style="font-size: 32px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Customer Support</h1>
    <p style="color: var(--text-muted); font-size: 15px;">Have questions about your grocery order, delivery timings, or special products? We are here to help!</p>
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 32px; align-items: start; margin-bottom: 48px;">
    <!-- Contact Info Cards -->
    <div style="display: flex; flex-direction: column; gap: 16px;">
      <!-- WhatsApp Box -->
      <a href="https://wa.me/917550807912" target="_blank" style="background: #25d366; color: #ffffff; border-radius: var(--radius-md); padding: 22px; display: flex; align-items: center; gap: 16px; text-decoration: none; transition: transform 0.2s; box-shadow: var(--shadow-md);">
        <i class="bi bi-whatsapp" style="font-size: 36px;"></i>
        <div>
          <h3 style="font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 2px;">Chat on WhatsApp</h3>
          <p style="font-size: 13px; opacity: 0.95;">Get instant answers and place order on WhatsApp</p>
        </div>
      </a>

      <!-- Phone Box -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: #ecfdf5; color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px;"><i class="bi bi-telephone-fill"></i></div>
        <div>
          <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 2px;">Phone Support</h4>
          <a href="tel:7550807912" style="color: var(--primary); font-size: 16px; font-weight: 700;">+91 7550807912</a>
          <div style="font-size: 12px; color: var(--text-muted);">Available 7:00 AM – 10:00 PM daily</div>
        </div>
      </div>

      <!-- Email Box -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 22px;"><i class="bi bi-envelope-fill"></i></div>
        <div>
          <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 2px;">Email Inquiries</h4>
          <a href="mailto:skrousonali2024@gmail.com" style="color: #2563eb; font-size: 14px; font-weight: 600;">skrousonali2024@gmail.com</a>
          <div style="font-size: 12px; color: var(--text-muted);">We reply within a few hours</div>
        </div>
      </div>

      <!-- Store Address -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px; display: flex; align-items: center; gap: 16px;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: #fefce8; color: #ca8a04; display: flex; align-items: center; justify-content: center; font-size: 22px;"><i class="bi bi-geo-alt-fill"></i></div>
        <div>
          <h4 style="font-size: 15px; font-weight: 700; margin-bottom: 2px;">Store Location</h4>
          <div style="font-size: 13px; color: #475569;">Ashoknagar, Kalyangarh, North 24 Parganas, West Bengal – 743263</div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 32px; box-shadow: var(--shadow-sm);">
      <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 18px;">Send Us a Message</h3>

      <form action="{{ route('contact.submit') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Your Name *</label>
            <input type="text" name="name" required class="pincode-input" style="width: 100%;" value="{{ Auth::check() ? Auth::user()->name : old('name') }}">
          </div>
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Email Address *</label>
            <input type="email" name="email" required class="pincode-input" style="width: 100%;" value="{{ Auth::check() ? Auth::user()->email : old('email') }}">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Phone Number</label>
            <input type="tel" name="phone" class="pincode-input" style="width: 100%;" value="{{ Auth::check() ? Auth::user()->phone : old('phone') }}">
          </div>
          <div>
            <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Subject</label>
            <input type="text" name="subject" class="pincode-input" style="width: 100%;" placeholder="e.g. Order Inquiry / Delivery Timing">
          </div>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="font-size: 12px; font-weight: 600; color: #334155; display: block; margin-bottom: 4px;">Message *</label>
          <textarea name="message" rows="5" required class="pincode-input" style="width: 100%;" placeholder="How can we help you?"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 15px;">
          <span>Submit Inquiry</span>
          <i class="bi bi-send-fill"></i>
        </button>
      </form>
    </div>
  </div>

</div>
@endsection
