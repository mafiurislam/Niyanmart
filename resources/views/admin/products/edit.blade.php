@extends('layouts.admin')

@section('title', 'Edit Product – Nayan Mart Admin')
@section('page_title', 'Edit Product: ' . $product->name)

@section('content')
<div style="max-width: 800px; background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 28px;">

  <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label class="form-label">Product Name (English) *</label>
      <input type="text" name="name" required value="{{ old('name', $product->name) }}" class="form-control">
    </div>

    <div class="form-group">
      <label class="form-label">Product Name (Bengali)</label>
      <input type="text" name="name_bn" value="{{ old('name_bn', $product->name_bn) }}" class="form-control">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Category *</label>
        <select name="category_id" required class="form-control">
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }} ({{ $cat->name_bn }})
            </option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Brand Name</label>
        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="form-control">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">MRP (₹) *</label>
        <input type="number" step="0.01" name="mrp" required value="{{ old('mrp', $product->mrp) }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Selling Price (₹) *</label>
        <input type="number" step="0.01" name="selling_price" required value="{{ old('selling_price', $product->selling_price) }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Stock Quantity *</label>
        <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}" class="form-control">
      </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
      <div class="form-group">
        <label class="form-label">Weight / Pack Size *</label>
        <input type="text" name="weight" required value="{{ old('weight', $product->weight) }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Unit</label>
        <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" class="form-control">
      </div>
      <div class="form-group">
        <label class="form-label">Offer Badge Text</label>
        <input type="text" name="badge" value="{{ old('badge', $product->badge) }}" class="form-control">
      </div>
    </div>

    <!-- Main Product Image Management -->
    <div class="form-group" style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
      <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 8px; display: block;">
        <i class="bi bi-image" style="color: var(--primary);"></i> Main Product Image
      </label>
      
      <div style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
        <!-- Current Image Box -->
        <div style="text-align: center;">
          <div style="font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px;">Current Image</div>
          <div style="width: 88px; height: 88px; border: 2px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #fff; display: flex; align-items: center; justify-content: center;">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          </div>
        </div>

        <!-- New Image Preview Box -->
        <div id="replace-preview-container" style="display: none; text-align: center;">
          <div style="font-size: 11px; font-weight: 700; color: var(--primary); margin-bottom: 4px;">New Replacement</div>
          <div style="width: 88px; height: 88px; border: 2px solid var(--primary); border-radius: 8px; overflow: hidden; background: #fff; display: flex; align-items: center; justify-content: center;">
            <img id="replace-image-preview" src="#" alt="New Image Preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
          </div>
        </div>

        <!-- File Input -->
        <div style="flex: 1; min-width: 240px;">
          <label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">Upload New Image to Replace Current:</label>
          <input type="file" name="image_file" id="replace_image_input" accept="image/*" class="form-control" onchange="previewReplaceImage(this)">
          <div style="font-size: 11px; color: #64748b; margin-top: 4px;">Leave blank to keep the current image. Supports PNG, JPG, WebP up to 4MB.</div>
        </div>
      </div>
    </div>

    <!-- Product Gallery Images Management -->
    <div class="form-group" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
      <label class="form-label" style="font-weight: 700; color: #0f172a; margin-bottom: 6px; display: block;">
        <i class="bi bi-images" style="color: var(--primary);"></i> Product Detail Gallery Images ({{ $product->images->count() }})
      </label>
      <div style="font-size: 12px; color: #64748b; margin-bottom: 14px;">These images appear as interactive clickable thumbnails on the customer product detail page.</div>

      @if($product->images->isNotEmpty())
        <div style="display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 16px;">
          @foreach($product->images as $galleryImg)
            <div style="position: relative; width: 80px; height: 80px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff; padding: 4px; display: flex; align-items: center; justify-content: center;">
              <img src="{{ str_starts_with($galleryImg->image_path, 'http') ? $galleryImg->image_path : asset(ltrim($galleryImg->image_path, '/')) }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
              <button type="button" 
                      onclick="if(confirm('Delete this gallery photo?')) { document.getElementById('delete-gallery-form-{{ $galleryImg->id }}').submit(); }" 
                      style="position: absolute; top: -6px; right: -6px; width: 22px; height: 22px; background: #dc2626; color: #fff; border: none; border-radius: 50%; font-size: 12px; line-height: 1; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"
                      title="Delete photo">
                <i class="bi bi-x"></i>
              </button>
            </div>
          @endforeach
        </div>
      @endif

      <div>
        <label style="font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; display: block;">+ Add More Gallery Photos:</label>
        <input type="file" name="gallery_files[]" accept="image/*" multiple class="form-control" onchange="previewMoreGallery(this)">
        <div id="more-gallery-previews" style="display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap;"></div>
      </div>
    </div>

    <script>
      function previewReplaceImage(input) {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = function(e) {
            document.getElementById('replace-image-preview').src = e.target.result;
            document.getElementById('replace-preview-container').style.display = 'block';
          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      function previewMoreGallery(input) {
        const container = document.getElementById('more-gallery-previews');
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
      <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="form-group">
      <label class="form-label">Specifications</label>
      <textarea name="specifications" rows="3" class="form-control">{{ old('specifications', $product->specifications) }}</textarea>
    </div>

    <!-- Checkbox Flags -->
    <div style="display: flex; gap: 24px; margin: 20px 0;">
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }}>
        <span>Featured</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }}>
        <span>Best Seller</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_new_arrival" value="1" {{ $product->is_new_arrival ? 'checked' : '' }}>
        <span>New Arrival</span>
      </label>
      <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
        <span>Active</span>
      </label>
    </div>

    <div style="display: flex; gap: 12px;">
      <button type="submit" class="btn btn-primary" style="padding: 12px 28px;">Update Product</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back to Products</a>
    </div>

  </form>

  <!-- Hidden Delete Forms for Gallery Images -->
  @foreach($product->images as $galleryImg)
    <form id="delete-gallery-form-{{ $galleryImg->id }}" action="{{ route('admin.products.gallery.delete', $galleryImg->id) }}" method="POST" style="display: none;">
      @csrf
      @method('DELETE')
    </form>
  @endforeach

</div>
@endsection
