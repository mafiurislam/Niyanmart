@extends('layouts.admin')

@section('title', 'Manage Categories – Nayan Mart Admin')
@section('page_title', 'Grocery Categories Management')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 28px; align-items: start;">

  <!-- Add Category Form -->
  <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 24px;">
    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 16px;">Add New Category</h3>

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label class="form-label">Category Name (English) *</label>
        <input type="text" name="name" required class="form-control" placeholder="e.g. Rice & Pulses">
      </div>

      <div class="form-group">
        <label class="form-label">Category Name (Bengali) *</label>
        <input type="text" name="name_bn" required class="form-control" placeholder="e.g. চাল ও ডাল">
      </div>

      <div class="form-group">
        <label class="form-label">Display Icon (Bootstrap Icon)</label>
        <input type="text" name="icon" class="form-control" value="bi-basket">
      </div>

      <div class="form-group">
        <label class="form-label">Category Image</label>
        <input type="file" name="image_file" accept="image/*" class="form-control">
      </div>

      <div class="form-group">
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="0">
      </div>

      <div style="display: flex; gap: 16px; margin: 16px 0;">
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">
          <input type="checkbox" name="is_featured" value="1" checked>
          <span>Featured</span>
        </label>
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">
          <input type="checkbox" name="is_active" value="1" checked>
          <span>Active</span>
        </label>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Create Category</button>
    </form>
  </div>

  <!-- Categories Table -->
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Category</th>
          <th>Bengali Name</th>
          <th>Slug</th>
          <th>Products</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $cat)
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: #ecfdf5; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                  <i class="bi {{ $cat->icon ?: 'bi-basket' }}"></i>
                </div>
                <strong style="color: #0f172a;">{{ $cat->name }}</strong>
              </div>
            </td>
            <td><strong>{{ $cat->name_bn }}</strong></td>
            <td><code>{{ $cat->slug }}</code></td>
            <td><span style="font-weight: 700; color: var(--primary);">{{ $cat->products_count }}</span> items</td>
            <td>
              <span style="font-size: 11px; font-weight: 700; padding: 2px 6px; border-radius: 4px; background: {{ $cat->is_active ? '#ecfdf5' : '#f1f5f9' }}; color: {{ $cat->is_active ? '#059669' : '#64748b' }};">
                {{ $cat->is_active ? 'Active' : 'Disabled' }}
              </span>
            </td>
            <td style="text-align: right;">
              <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete category?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px;" title="Delete">
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
