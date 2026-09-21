@extends('layouts.admin')

@section('title', 'Manage Orders – Nayan Mart Admin')
@section('page_title', 'Customer Orders Management')

@section('content')
<div>

  <!-- Filters & Search Bar -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 20px;">
    <form action="{{ route('admin.orders.index') }}" method="GET" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
      <input type="text" name="search" placeholder="Search by Order ID, name, phone, city..." value="{{ request('search') }}" class="form-control" style="width: 280px;">

      <select name="status" class="form-control" style="width: 180px;" onchange="this.form.submit()">
        <option value="all">All Order Statuses</option>
        <option value="placed" {{ request('status') == 'placed' ? 'selected' : '' }}>Placed</option>
        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
        <option value="packed" {{ request('status') == 'packed' ? 'selected' : '' }}>Packed / Processing</option>
        <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
      </select>

      <button type="submit" class="btn btn-primary" style="padding: 8px 18px;">Filter</button>
      @if(request()->anyFilled(['search', 'status']))
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary" style="padding: 8px 14px;">Reset</a>
      @endif
    </form>
  </div>

  <!-- Orders Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Order Number</th>
          <th>Customer Details</th>
          <th>Delivery Location</th>
          <th>Items</th>
          <th>Total</th>
          <th>Payment</th>
          <th>Order Status</th>
          <th>Date</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
            <td><strong>#{{ $order->order_number }}</strong></td>
            <td>
              <div style="font-weight: 700; color: #0f172a;">{{ $order->customer_name }}</div>
              <div style="font-size: 11px; color: var(--text-muted);">{{ $order->customer_phone }}</div>
            </td>
            <td>
              <div style="font-size: 12px;">{{ $order->city }} ({{ $order->pincode }})</div>
            </td>
            <td>{{ $order->items->count() }} items</td>
            <td><strong>₹{{ number_format($order->total, 0) }}</strong></td>
            <td>
              <div style="font-weight: 600; font-size: 12px;">{{ $order->payment_method_name }}</div>
              <span style="font-size: 10px; font-weight: 700; color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#d97706' }}; text-transform: uppercase;">
                {{ $order->payment_status }}
              </span>
            </td>
            <td>
              <span class="status-badge status-{{ $order->order_status }}">
                {{ $order->formatted_status }}
              </span>
            </td>
            <td style="font-size: 12px; color: var(--text-muted);">
              {{ $order->created_at->format('d M Y, h:i A') }}
            </td>
            <td style="text-align: right;">
              <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-primary" style="padding: 6px 14px; font-size: 12px;">
                Manage
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" style="text-align: center; padding: 36px; color: var(--text-muted);">No orders found matching criteria.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top: 20px;">
    {{ $orders->links() }}
  </div>

</div>
@endsection
