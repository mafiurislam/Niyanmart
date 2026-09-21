<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('brand', 'like', "%{$s}%")
                  ->orWhere('sku', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('stock', '<=', 10)->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'mrp' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'weight' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = '/assets/images/products/mother-dairy-curd.png'; // default fallback
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $filename);
            $imagePath = '/assets/images/products/' . $filename;
        }

        $mrp = (float) $request->mrp;
        $sellingPrice = (float) $request->selling_price;
        $discountPercent = $mrp > $sellingPrice ? round((($mrp - $sellingPrice) / $mrp) * 100) : 0;

        $product = Product::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999),
            'brand' => $request->brand,
            'sku' => $request->sku ?: 'NM' . strtoupper(Str::random(8)),
            'description' => $request->description,
            'specifications' => $request->specifications,
            'mrp' => $mrp,
            'selling_price' => $sellingPrice,
            'discount_percent' => $discountPercent,
            'weight' => $request->weight,
            'unit' => $request->unit ?? 'g',
            'stock' => $request->stock,
            'image' => $imagePath,
            'badge' => $request->badge ?: ($discountPercent > 0 ? "{$discountPercent}% OFF" : null),
            'is_featured' => $request->has('is_featured'),
            'is_best_seller' => $request->has('is_best_seller'),
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_active' => $request->has('is_active'),
        ]);

        // Create main image in gallery
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $imagePath,
            'sort_order' => 1,
        ]);

        // Handle additional gallery images if uploaded
        if ($request->hasFile('gallery_files')) {
            $sort = 2;
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = time() . '_' . rand(1000, 9999) . '_' . Str::slug($request->name) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('assets/images/products'), $gFilename);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/assets/images/products/' . $gFilename,
                    'sort_order' => $sort++,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully with product images!');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();

        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'mrp' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'weight' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'image_file' => 'nullable|image|max:4096',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/products'), $filename);
            $imagePath = '/assets/images/products/' . $filename;

            // Also update the primary gallery record
            $primaryImg = ProductImage::where('product_id', $product->id)->where('sort_order', 1)->first();
            if ($primaryImg) {
                $primaryImg->update(['image_path' => $imagePath]);
            } else {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'sort_order' => 1,
                ]);
            }
        }

        // Handle additional gallery images if uploaded
        if ($request->hasFile('gallery_files')) {
            $nextSort = (ProductImage::where('product_id', $product->id)->max('sort_order') ?? 1) + 1;
            foreach ($request->file('gallery_files') as $gFile) {
                $gFilename = time() . '_' . rand(1000, 9999) . '_' . Str::slug($request->name) . '.' . $gFile->getClientOriginalExtension();
                $gFile->move(public_path('assets/images/products'), $gFilename);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/assets/images/products/' . $gFilename,
                    'sort_order' => $nextSort++,
                ]);
            }
        }

        $mrp = (float) $request->mrp;
        $sellingPrice = (float) $request->selling_price;
        $discountPercent = $mrp > $sellingPrice ? round((($mrp - $sellingPrice) / $mrp) * 100) : 0;

        $product->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'name_bn' => $request->name_bn,
            'brand' => $request->brand,
            'sku' => $request->sku ?: $product->sku,
            'description' => $request->description,
            'specifications' => $request->specifications,
            'mrp' => $mrp,
            'selling_price' => $sellingPrice,
            'discount_percent' => $discountPercent,
            'weight' => $request->weight,
            'unit' => $request->unit ?? $product->unit,
            'stock' => $request->stock,
            'image' => $imagePath,
            'badge' => $request->badge,
            'is_featured' => $request->has('is_featured'),
            'is_best_seller' => $request->has('is_best_seller'),
            'is_new_arrival' => $request->has('is_new_arrival'),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $image->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
