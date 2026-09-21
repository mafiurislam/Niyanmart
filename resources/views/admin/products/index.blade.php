@extends('layouts.admin')

@section('title', 'Manage Products – Nayan Mart Admin')
@section('page_title', 'Product Management')

@section('content')
<div>

  <!-- Top Action Bar -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
    <!-- Filters & Search -->
    <form action="{{ route('admin.products.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <input type="text" name="search" placeholder="Search by name, brand, SKU..." value="{{ request('search') }}" class="form-control" style="width: 240px; padding: 8px 12px;">
      
      <select name="category" class="form-control" style="width: 180px; padding: 8px 12px;" onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>

      <button type="submit" class="btn btn-outline-primary" style="padding: 8px 16px;">Filter</button>
      @if(request()->anyFilled(['search', 'category', 'stock_status']))
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" style="padding: 8px 14px;">Reset</a>
      @endif
    </form>

    <a href="{{ route('admin.products.create') }}" class="btn btn-primary" style="padding: 10px 20px;">
      <i class="bi bi-plus-lg"></i> Add New Product
    </a>
  </div>

  <!-- Products Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Category</th>
          <th>Price & MRP</th>
          <th>Weight</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Badges</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $product)
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ $product->image ?: asset('assets/images/products/mother-dairy-curd.png') }}" style="width: 40px; height: 40px; object-fit: contain; border-radius: 4px;">
                <div>
                  <div style="font-weight: 700; color: #0f172a;">{{ $product->name }}</div>
                  <div style="font-size: 11px; color: var(--text-muted);">SKU: {{ $product->sku }}</div>
                </div>
              </div>
            </td>
            <td>{{ $product->category->name ?? 'None' }}</td>
            <td>
              <strong>₹{{ number_format($product->selling_price, 0) }}</strong>
              <span style="font-size: 11px; color: #94a3b8; text-decoration: line-through;">₹{{ number_format($product->mrp, 0) }}</span>
            </td>
            <td>{{ $product->weight }}</td>
            <td>
              @if($product->stock <= 0)
                <span style="background: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">Out of Stock</span>
              @elseif($product->stock <= 10)
                <span style="background: #fef3c7; color: #b45309; font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">{{ $product->stock }} (Low)</span>
              @else
                <span style="color: #166534; font-weight: 600;">{{ $product->stock }} in stock</span>
              @endif
            </td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $product->is_active ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $product->is_active ? '#059669' : '#64748b' }};">
                {{ $product->is_active ? 'Active' : 'Disabled' }}
              </span>
            </td>
            <td>
              @if($product->badge)
                <span style="font-size: 10px; font-weight: 800; background: #ecfdf5; color: var(--primary); padding: 2px 6px; border-radius: 4px;">{{ $product->badge }}</span>
              @endif
              @if($product->is_best_seller)
                <span style="font-size: 10px; font-weight: 800; background: #fef3c7; color: #b45309; padding: 2px 6px; border-radius: 4px;">Best Seller</span>
              @endif
            </td>
            <td style="text-align: right;">
              <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-secondary" style="padding: 4px 10px; font-size: 12px;" title="Edit">
                <i class="bi bi-pencil"></i>
              </a>
              <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-secondary" style="padding: 4px 10px; font-size: 12px; color: #ef4444;" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align: center; padding: 30px; color: var(--text-muted);">No products found matching criteria.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top: 20px;">
    {{ $products->links() }}
  </div>

</div>
@endsection
