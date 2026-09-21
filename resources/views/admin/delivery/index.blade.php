@extends('layouts.admin')

@section('title', 'Delivery & PIN Codes – Nayan Mart Admin')
@section('page_title', 'Delivery Areas & PIN Codes Management')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 28px; align-items: start;">

  <div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Global Delivery Rules -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Global Delivery Fees</h3>

      <form action="{{ route('admin.delivery.rules') }}" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-label">Free Delivery Threshold (₹) *</label>
          <input type="number" step="1" name="free_shipping_threshold" required value="{{ $freeShippingThreshold }}" class="form-control">
          <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Orders equal or above this get 100% Free Delivery (Default ₹249).</div>
        </div>

        <div class="form-group">
          <label class="form-label">Standard Delivery Charge (₹) *</label>
          <input type="number" step="1" name="standard_delivery_fee" required value="{{ $standardDeliveryFee }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Update Rules</button>
      </form>
    </div>

    <!-- Add PIN Code -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
      <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Add Delivery PIN Code</h3>

      <form action="{{ route('admin.delivery.store') }}" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-label">6-Digit PIN Code *</label>
          <input type="text" name="pincode" required maxlength="6" class="form-control" placeholder="e.g. 743263">
        </div>

        <div class="form-group">
          <label class="form-label">City / Town *</label>
          <input type="text" name="city" required class="form-control" placeholder="e.g. Ashoknagar">
        </div>

        <div class="form-group">
          <label class="form-label">Estimated Delivery Time</label>
          <input type="text" name="estimated_time" class="form-control" value="Same Day (Within 4-6 Hours)">
        </div>

        <div class="form-group">
          <label class="form-label">Special Delivery Charge (₹)</label>
          <input type="number" name="delivery_charge" class="form-control" value="0">
        </div>

        <div style="margin: 16px 0;">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            <input type="checkbox" name="is_deliverable" value="1" checked>
            <span>Deliverable Area</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Add PIN Code</button>
      </form>
    </div>
  </div>

  <!-- PIN Codes Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>PIN Code</th>
          <th>City / Area</th>
          <th>Est. Delivery Time</th>
          <th>Charge</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pincodes as $pin)
          <tr>
            <td><strong>{{ $pin->pincode }}</strong></td>
            <td>{{ $pin->city }}, {{ $pin->state }}</td>
            <td>{{ $pin->estimated_time }}</td>
            <td>{{ $pin->delivery_charge == 0 ? 'FREE' : '₹' . number_format($pin->delivery_charge, 0) }}</td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $pin->is_deliverable ? '#ecfdf5' : '#fef2f2' }}; color: {{ $pin->is_deliverable ? '#059669' : '#dc2626' }};">
                {{ $pin->is_deliverable ? 'Deliverable' : 'Suspended' }}
              </span>
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.delivery.toggle', $pin->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" style="padding: 4px 8px; font-size: 11px;">
                  {{ $pin->is_deliverable ? 'Disable' : 'Enable' }}
                </button>
              </form>
              <form action="{{ route('admin.delivery.destroy', $pin->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete PIN code?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: none; color: #ef4444; padding: 4px; cursor: pointer;">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>
@endsection
