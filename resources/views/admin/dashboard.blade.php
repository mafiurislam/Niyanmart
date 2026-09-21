@extends('layouts.admin')

@section('title', 'Admin Dashboard – Nayan Mart')
@section('page_title', 'Admin Dashboard Overview')

@section('content')
<div>

  <!-- 1. KPI Cards Row -->
  <div class="kpi-cards-grid">
    <div class="kpi-card">
      <div>
        <div class="kpi-val">₹{{ number_format($totalSales, 0) }}</div>
        <div class="kpi-lbl">Total Sales</div>
      </div>
      <div class="kpi-icon-pill" style="background: #ecfdf5; color: #059669;"><i class="bi bi-currency-rupee"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">₹{{ number_format($todaySales, 0) }}</div>
        <div class="kpi-lbl">Today's Sales</div>
      </div>
      <div class="kpi-icon-pill" style="background: #eff6ff; color: #2563eb;"><i class="bi bi-graph-up-arrow"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $totalOrders }}</div>
        <div class="kpi-lbl">Total Orders</div>
      </div>
      <div class="kpi-icon-pill" style="background: #fef3c7; color: #d97706;"><i class="bi bi-cart-check"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $pendingOrders }}</div>
        <div class="kpi-lbl">Pending Orders</div>
      </div>
      <div class="kpi-icon-pill" style="background: #fef2f2; color: #dc2626;"><i class="bi bi-hourglass-split"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $completedOrders }}</div>
        <div class="kpi-lbl">Delivered Orders</div>
      </div>
      <div class="kpi-icon-pill" style="background: #ecfdf5; color: #059669;"><i class="bi bi-check2-circle"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $totalCustomers }}</div>
        <div class="kpi-lbl">Customers</div>
      </div>
      <div class="kpi-icon-pill" style="background: #f3e8ff; color: #9333ea;"><i class="bi bi-people"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $totalProducts }}</div>
        <div class="kpi-lbl">Products in Catalog</div>
      </div>
      <div class="kpi-icon-pill" style="background: #e0f2fe; color: #0284c7;"><i class="bi bi-box-seam"></i></div>
    </div>

    <div class="kpi-card">
      <div>
        <div class="kpi-val">{{ $lowStockProducts }}</div>
        <div class="kpi-lbl">Low Stock Alerts</div>
      </div>
      <div class="kpi-icon-pill" style="background: #fff1f2; color: #e11d48;"><i class="bi bi-exclamation-triangle"></i></div>
    </div>
  </div>

  <!-- 2. Recent Orders & Low Stock Tables -->
  <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Recent Orders -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 16px; font-weight: 800;">Recent Orders</h3>
        <a href="{{ route('admin.orders.index') }}" style="font-size: 12px; font-weight: 700; color: var(--primary);">View All →</a>
      </div>

      <div class="admin-table-wrap" style="margin-bottom: 0;">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Customer</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recentOrders as $ord)
              <tr>
                <td><strong>#{{ $ord->order_number }}</strong></td>
                <td>{{ $ord->customer_name }}</td>
                <td>₹{{ number_format($ord->total, 0) }}</td>
                <td><span class="status-badge status-{{ $ord->order_status }}">{{ $ord->formatted_status }}</span></td>
                <td>{{ $ord->created_at->format('d M, h:i A') }}</td>
                <td>
                  <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-outline-primary" style="padding: 4px 10px; font-size: 11px;">Manage</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Low Stock Alerts -->
    <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 16px; font-weight: 800; color: #b91c1c;"><i class="bi bi-exclamation-circle-fill"></i> Low Stock Alerts</h3>
        <a href="{{ route('admin.products.index', ['stock_status' => 'low']) }}" style="font-size: 12px; font-weight: 700; color: var(--primary);">View All →</a>
      </div>

      <div style="display: flex; flex-direction: column; gap: 12px;">
        @forelse($lowStockList as $item)
          <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 10px; border-bottom: 1px solid var(--border-light);">
            <div style="display: flex; align-items: center; gap: 10px;">
              <img src="{{ $item->image ?: asset('assets/images/products/mother-dairy-curd.png') }}" style="width: 36px; height: 36px; object-fit: contain;">
              <div>
                <div style="font-size: 13px; font-weight: 600;">{{ $item->name }}</div>
                <div style="font-size: 11px; color: var(--text-muted);">{{ $item->weight }}</div>
              </div>
            </div>
            <span style="background: #fef2f2; color: #dc2626; font-size: 12px; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
              {{ $item->stock }} Left
            </span>
          </div>
        @empty
          <p style="font-size: 13px; color: var(--text-muted);">No products currently running low on stock.</p>
        @endforelse
      </div>
    </div>
  </div>

</div>
@endsection
