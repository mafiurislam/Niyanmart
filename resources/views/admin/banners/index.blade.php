@extends('layouts.admin')

@section('title', 'Manage Banners – Nayan Mart Admin')
@section('page_title', 'Homepage Banners & Sliders')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 28px; align-items: start;">

  <!-- Add Banner Form -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Add New Banner</h3>

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label class="form-label">Banner Title *</label>
        <input type="text" name="title" required class="form-control" placeholder="e.g. Special Discount 10% OFF">
      </div>

      <div class="form-group">
        <label class="form-label">Subtitle</label>
        <input type="text" name="subtitle" class="form-control" placeholder="e.g. On Fresh Vegetables & Dairy">
      </div>

      <div class="form-group">
        <label class="form-label">Bengali Tagline</label>
        <input type="text" name="tagline_bn" class="form-control" placeholder="e.g. দৈনন্দিন কেনাকাটায় ১০% ছাড়">
      </div>

      <div class="form-group">
        <label class="form-label">Banner Type *</label>
        <select name="banner_type" class="form-control">
          <option value="promo_card">Promo Card (3-Column Grid)</option>
          <option value="hero_slider">Hero Slider (Main Top)</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">Badge Text</label>
        <input type="text" name="badge" class="form-control" placeholder="e.g. 10% OFF / WEEKEND OFFER">
      </div>

      <div class="form-group">
        <label class="form-label">Banner Image</label>
        <input type="file" name="image_file" accept="image/*" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label">Button Link</label>
        <input type="text" name="button_link" class="form-control" value="/shop">
      </div>

      <div style="margin: 16px 0;">
        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
          <input type="checkbox" name="is_active" value="1" checked>
          <span>Active on Homepage</span>
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Save Banner</button>
    </form>
  </div>

  <!-- Banners Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Banner Preview</th>
          <th>Title & Subtitle</th>
          <th>Type</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($banners as $banner)
          <tr>
            <td>
              <img src="{{ $banner->image }}" style="width: 90px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-color);">
            </td>
            <td>
              <div style="font-weight: 700; color: #0f172a;">{{ $banner->title }}</div>
              <div style="font-size: 11px; color: var(--text-muted);">{{ $banner->subtitle }}</div>
            </td>
            <td>
              <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #475569;">{{ str_replace('_', ' ', $banner->banner_type) }}</span>
            </td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $banner->is_active ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $banner->is_active ? '#059669' : '#64748b' }};">
                {{ $banner->is_active ? 'Active' : 'Disabled' }}
              </span>
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-secondary" style="padding: 4px 8px; font-size: 11px;">
                  {{ $banner->is_active ? 'Disable' : 'Enable' }}
                </button>
              </form>
              <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete banner?');">
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
