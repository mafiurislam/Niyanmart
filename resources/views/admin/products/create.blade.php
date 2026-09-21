@extends('layouts.admin')

@section('title', 'Add New Product – Nayan Mart Admin')
@section('page_title', 'Add New Grocery Product')

@section('content')
<div style="max-width: 800px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 28px;">

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label class="form-label">Product Name (English) *</label>
      <input type="text" name="name" required value="{{ old('name') }}" class="form-control" placeholder="e.g. Mother Dairy Curd">
    </div>

    <div class="form-group">
      <label class="form-label">Product Name (Bengali)</label>
      <input type="text" name="name_bn" value="{{ old('name_bn') }}" class="form-control" placeholder="e.g. মাদার ডেইরি দই">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Category *</label>
        <select name="category_id" required class="form-control">
          <option value="">Select Category</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->name_bn }})</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Brand Name</label>
        <input type="text" name="brand" value="{{ old('brand') }}" class="form-control" placeholder="e.g. Mother Dairy / Amul">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">MRP (₹) *</label>
        <input type="number" step="0.01" name="mrp" required value="{{ old('mrp') }}" class="form-control" placeholder="56.00">
      </div>
      <div class="form-group">
        <label class="form-label">Selling Price (₹) *</label>
        <input type="number" step="0.01" name="selling_price" required value="{{ old('selling_price') }}" class="form-control" placeholder="50.00">
      </div>
      <div class="form-group">
        <label class="form-label">Stock Quantity *</label>
        <input type="number" name="stock" required value="{{ old('stock', 50) }}" class="form-control">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Weight / Pack Size *</label>
        <input type="text" name="weight" required value="{{ old('weight', '500 g') }}" class="form-control" placeholder="e.g. 500 g or 1 L">
      </div>
      <div class="form-group">
        <label class="form-label">Unit</label>
        <input type="text" name="unit" value="{{ old('unit', 'g') }}" class="form-control" placeholder="g, kg, ml, L, pcs">
      </div>
      <div class="form-group">
        <label class="form-label">Offer Badge Text</label>
        <input type="text" name="badge" value="{{ old('badge') }}" class="form-control" placeholder="e.g. 10% OFF / Buy 1 Get 1">
      </div>
    </div>

    <!-- Main Image Upload with Live Preview -->
    <div class="form-group" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
      <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
        <i class="bi bi-image" style="color: var(--primary);"></i> Main Product Image *
      </label>
      <div style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
        <div id="main-preview-container" style="display: none; width: 84px; height: 84px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #fff; text-align: center;">
          <img id="main-image-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div style="flex: 1;">
          <input type="file" name="image_file" id="image_file_input" accept="image/*" class="form-control" onchange="previewMainImage(this)">
          <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Recommended: High-resolution PNG or JPG (600x600 px or higher on transparent/white background)</div>
        </div>
      </div>
    </div>

    <!-- Additional Gallery Photos -->
    <div class="form-group" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 18px; margin-bottom: 20px;">
      <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
        <i class="bi bi-images" style="color: var(--primary);"></i> Additional Gallery Images (Optional)
      </label>
      <input type="file" name="gallery_files[]" id="gallery_files_input" accept="image/*" multiple class="form-control" onchange="previewGalleryImages(this)">
      <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Select multiple images for the product detail gallery (side view, ingredients, size comparison).</div>
      <div id="gallery-previews" style="display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap;"></div>
    </div>

    <script>
      function previewMainImage(input) {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            document.getElementById('main-image-preview').src = e.target.result;
            document.getElementById('main-preview-container').style.display = 'block';
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      function previewGalleryImages(input) {
        const container = document.getElementById('gallery-previews');
        container.innerHTML = '';
        if (input.files) {
          Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
              const div = document.createElement('div');
              div.style.cssText = 'width: 60px; height: 60px; border: 1px solid #cbd5e1; border-radius: 6px; overflow: hidden; background: #fff;';
              div.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:contain;">`;
              container.appendChild(div);
            };
            reader.readAsDataURL(file);
          });
        }
      }
    </script>

    <div class="form-group">
      <label class="form-label">Product Description</label>
      <textarea name="description" rows="3" class="form-control" placeholder="Detailed product description..."></textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Specifications / Ingredients</label>
      <textarea name="specifications" rows="3" class="form-control" placeholder="Key ingredients, storage conditions, shelf life..."></textarea>
    </div>

    <!-- Checkbox Flags -->
    <div style="display: flex; gap: 24px; margin: 20px 0;">
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_featured" value="1">
        <span>Featured Product</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_best_seller" value="1">
        <span>Best Seller</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_new_arrival" value="1" checked>
        <span>New Arrival</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_active" value="1" checked>
        <span>Active in Catalog</span>
      </label>
    </div>

    <div style="display: flex; gap: 12px;">
      <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">Save Product</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>

  </form>

</div>
@endsection
