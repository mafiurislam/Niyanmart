@extends('layouts.admin')

@section('title', 'Promo Coupons – Nayan Mart Admin')
@section('page_title', 'Coupons & Promotional Discounts')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 28px; align-items: start;">

  <!-- Create Coupon Form -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Create New Coupon</h3>

    <form action="{{ route('admin.coupons.store') }}" method="POST">
      @csrf

      <div class="form-group">
        <label class="form-label">Coupon Code *</label>
        <input type="text" name="code" required class="form-control" placeholder="e.g. NAYAN10" style="text-transform: uppercase;">
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="form-group">
          <label class="form-label">Discount Type *</label>
          <select name="discount_type" class="form-control">
            <option value="percent">Percentage (%)</option>
            <option value="fixed">Fixed Flat (₹)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Discount Value *</label>
          <input type="number" step="0.01" name="discount_value" required class="form-control" placeholder="10">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="form-group">
          <label class="form-label">Min. Order (₹) *</label>
          <input type="number" step="0.01" name="min_order_amount" required value="249" class="form-control">
        </div>
        <div class="form-group">
          <label class="form-label">Max Discount (₹)</label>
          <input type="number" step="0.01" name="max_discount_amount" class="form-control" placeholder="100">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Usage Limit (Times)</label>
        <input type="number" name="usage_limit" class="form-control" placeholder="500">
      </div>

      <div class="form-group">
        <label class="form-label">Expiry Date</label>
        <input type="date" name="expiry_date" class="form-control">
      </div>

      <div style="margin: 16px 0;">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
          <input type="checkbox" name="is_active" value="1" checked>
          <span>Active Coupon</span>
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Save Coupon</button>
    </form>
  </div>

  <!-- Coupons List Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Coupon Code</th>
          <th>Discount</th>
          <th>Min Order</th>
          <th>Used</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($coupons as $coupon)
          <tr>
            <td>
              <span style="font-family: monospace; font-weight: 800; font-size: 14px; background: #ecfdf5; color: var(--primary); padding: 4px 8px; border-radius: 4px; border: 1px dashed var(--primary);">
                {{ $coupon->code }}
              </span>
            </td>
            <td>
              <strong>{{ $coupon->discount_type === 'percent' ? $coupon->discount_value . '%' : '₹' . number_format($coupon->discount_value, 0) }}</strong>
              @if($coupon->max_discount_amount)
                <div style="font-size: 11px; color: var(--text-muted);">Max: ₹{{ number_format($coupon->max_discount_amount, 0) }}</div>
              @endif
            </td>
            <td>₹{{ number_format($coupon->min_order_amount, 0) }}</td>
            <td>{{ $coupon->used_count }} times</td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $coupon->is_active ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $coupon->is_active ? '#059669' : '#64748b' }};">
                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.coupons.toggle', $coupon->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" style="padding: 4px 8px; font-size: 11px;">
                  {{ $coupon->is_active ? 'Disable' : 'Enable' }}
                </button>
              </form>
              <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this coupon?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: none; color: #ef4444; padding: 4px; cursor: pointer;">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">No coupons created yet.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection
