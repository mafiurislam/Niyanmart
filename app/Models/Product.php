<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'name_bn',
        'slug',
        'brand',
        'sku',
        'description',
        'specifications',
        'mrp',
        'selling_price',
        'discount_percent',
        'weight',
        'unit',
        'stock',
        'min_order_qty',
        'max_order_qty',
        'image',
        'badge',
        'is_featured',
        'is_best_seller',
        'is_new_arrival',
        'is_active',
        'rating',
        'reviews_count',
    ];

    protected $casts = [
        'mrp' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'rating' => 'float',
        'discount_percent' => 'integer',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'NM' . strtoupper(Str::random(8));
            }
            if ($product->mrp > $product->selling_price && $product->discount_percent == 0) {
                $product->discount_percent = round((($product->mrp - $product->selling_price) / $product->mrp) * 100);
            }
        });
    }

    public function getSavingsAttribute()
    {
        return max(0, $this->mrp - $this->selling_price);
    }

    public function getInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            return asset(ltrim($this->image, '/'));
        }
        return asset('assets/images/products/mother-dairy-curd.png');
    }

    public function getGalleryUrlsAttribute()
    {
        $urls = [$this->image_url];
        foreach ($this->images as $img) {
            if (!empty($img->image_path)) {
                if (str_starts_with($img->image_path, 'http://') || str_starts_with($img->image_path, 'https://')) {
                    $urls[] = $img->image_path;
                } else {
                    $urls[] = asset(ltrim($img->image_path, '/'));
                }
            }
        }
        return array_values(array_unique($urls));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->orderBy('created_at', 'desc');
    }
}
