@extends('layouts.admin')

@section('title', 'Registered Customers – Nayan Mart Admin')
@section('page_title', 'Registered Customer Accounts')

@section('content')
<div>

  <!-- Search -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 16px 20px; margin-bottom: 20px;">
    <form action="{{ route('admin.customers.index') }}" method="GET" style="display: flex; gap: 12px; align-items: center;">
      <input type="text" name="search" placeholder="Search by name, email, or phone..." value="{{ request('search') }}" class="form-control" style="width: 320px;">
      <button type="submit" class="btn btn-primary" style="padding: 8px 18px;">Search</button>
      @if(request('search'))
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary" style="padding: 8px 14px;">Reset</a>
      @endif
    </form>
  </div>

  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Customer Name</th>
          <th>Contact Information</th>
          <th>Delivery Address</th>
          <th>Orders Count</th>
          <th>Status</th>
          <th>Joined</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($customers as $customer)
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 34px; height: 34px; border-radius: 50%; background: #ecfdf5; color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                  {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <strong>{{ $customer->name }}</strong>
              </div>
            </td>
            <td>
              <div>{{ $customer->email }}</div>
              <div style="font-size: 11px; color: var(--text-muted);">{{ $customer->phone ?: 'No phone added' }}</div>
            </td>
            <td>
              <div style="font-size: 12px; color: #475569;">
                {{ $customer->address ? Str::limit($customer->address, 35) : 'No address saved' }}
              </div>
            </td>
            <td>
              <span style="font-weight: 700; color: var(--primary);">{{ $customer->orders_count }}</span> orders
            </td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $customer->status === 'active' ? '#ecfdf5' : '#fef2f2' }}; color: {{ $customer->status === 'active' ? '#059669' : '#dc2626' }};">
                {{ ucfirst($customer->status) }}
              </span>
            </td>
            <td style="font-size: 12px; color: var(--text-muted);">
              {{ $customer->created_at->format('d M Y') }}
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.customers.toggle_status', $customer->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" style="padding: 4px 10px; font-size: 11px;">
                  {{ $customer->status === 'active' ? 'Suspend' : 'Activate' }}
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-muted);">No customers found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top: 20px;">
    {{ $customers->links() }}
  </div>

</div>
@endsection
