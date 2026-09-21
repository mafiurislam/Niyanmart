@extends('layouts.app')

@section('title', 'Shop All Groceries – Nayan Mart')

@section('content')
<div class="container" style="padding: 24px 16px;">

  <!-- Breadcrumbs -->
  <nav class="breadcrumb-nav">
    <a href="{{ route('home') }}">Home</a>
    <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
    <span style="color: var(--text-main); font-weight: 500;">Shop Groceries</span>
  </nav>

  <div style="display: grid; grid-template-columns: 260px 1fr; gap: 28px; align-items: start;">
    <!-- Sidebar Filters -->
    <aside style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 20px;">
      <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-light);">Filter Products</h3>

      <form action="{{ route('shop') }}" method="GET">
        @if(request('q'))
          <input type="hidden" name="q" value="{{ request('q') }}">
        @endif

        <!-- Category Filter -->
        <div style="margin-bottom: 20px;">
          <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">Categories</label>
          <div style="display: flex; flex-direction: column; gap: 6px; max-height: 220px; overflow-y: auto;">
            <label style="font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
              <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
              <span>All Categories</span>
            </label>
            @foreach($categories as $cat)
              <label style="font-size: 13px; display: flex; align-items: center; justify-content: space-between; gap: 8px; cursor: pointer;">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                  <span>{{ $cat->name_bn ?: $cat->name }}</span>
                </div>
                <span style="font-size: 11px; color: var(--text-muted);">({{ $cat->products_count }})</span>
              </label>
            @endforeach
          </div>
        </div>

        <!-- Brand Filter -->
        @if($brands->isNotEmpty())
          <div style="margin-bottom: 20px; border-top: 1px solid var(--border-light); padding-top: 16px;">
            <label style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block;">Popular Brands</label>
            <div style="display: flex; flex-direction: column; gap: 6px; max-height: 160px; overflow-y: auto;">
              <label style="font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="radio" name="brand" value="" {{ !request('brand') ? 'checked' : '' }} onchange="this.form.submit()">
                <span>All Brands</span>
              </label>
              @foreach($brands as $brand)
                <label style="font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                  <input type="radio" name="brand" value="{{ $brand }}" {{ request('brand') == $brand ? 'checked' : '' }} onchange="this.form.submit()">
                  <span>{{ $brand }}</span>
                </label>
              @endforeach
            </div>
          </div>
        @endif

        <!-- In Stock Only -->
        <div style="margin-bottom: 20px; border-top: 1px solid var(--border-light); padding-top: 16px;">
          <label style="font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') == '1' ? 'checked' : '' }} onchange="this.form.submit()">
            <span style="font-weight: 600;">In-Stock Only</span>
          </label>
        </div>

        <a href="{{ route('shop') }}" class="btn btn-outline-secondary" style="width: 100%; font-size: 12px; padding: 8px;">
          <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
        </a>
      </form>
    </aside>

    <!-- Main Products Listing -->
    <main>
      <!-- Filter & Sort Bar -->
      <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 14px 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div style="font-size: 14px; color: #475569;">
          Showing <strong>{{ $products->total() }}</strong> grocery products
          @if(request('q')) for "<strong>{{ request('q') }}</strong>" @endif
        </div>

        <!-- Sort Select -->
        <div style="display: flex; align-items: center; gap: 8px;">
          <label for="sort-select" style="font-size: 13px; font-weight: 600; color: #475569;">Sort By:</label>
          <select id="sort-select" onchange="window.location.href = this.value" class="pincode-input" style="font-size: 13px; padding: 6px 12px;">
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" {{ request('sort') == 'default' ? 'selected' : '' }}>Featured</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popularity</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
            <option value="{{ request()->fullUrlWithQuery(['sort' => 'discount']) }}" {{ request('sort') == 'discount' ? 'selected' : '' }}>Highest Discount</option>
          </select>
        </div>
      </div>

      <!-- Products Grid -->
      @if($products->isEmpty())
        <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 48px; text-align: center;">
          <i class="bi bi-search" style="font-size: 48px; color: #94a3b8; margin-bottom: 12px; display: block;"></i>
          <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 6px;">No Products Found</h3>
          <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 18px;">Try adjusting your filters or searching for something else.</p>
          <a href="{{ route('shop') }}" class="btn btn-primary" style="padding: 10px 22px;">View All Products</a>
        </div>
      @else
        <div class="product-grid" style="grid-template-columns: repeat(4, 1fr);">
          @foreach($products as $product)
            <x-product_card :product="$product" />
          @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px;">
          {{ $products->links() }}
        </div>
      @endif
    </main>
  </div>

</div>
@endsection
