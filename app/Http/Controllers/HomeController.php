<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroBanners = Banner::where('banner_type', 'hero_slider')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $promoBanners = Banner::where('banner_type', 'promo_card')
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->take(3)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->take(10)
            ->get();

        $bestSellingProducts = Product::where('is_active', true)
            ->where('is_best_seller', true)
            ->take(10)
            ->get();

        $newArrivals = Product::where('is_active', true)
            ->where('is_new_arrival', true)
            ->take(10)
            ->get();

        return view('frontend.home', compact(
            'heroBanners',
            'promoBanners',
            'categories',
            'featuredProducts',
            'bestSellingProducts',
            'newArrivals'
        ));
    }

    public function shop(Request $request)
    {
        $query = Product::where('is_active', true);

        // Search
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('name_bn', 'like', "%{$searchTerm}%")
                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $catSlug = $request->category;
            $cat = Category::where('slug', $catSlug)->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('selling_price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('selling_price', '<=', $request->max_price);
        }

        // In-stock only
        if ($request->filled('in_stock') && $request->in_stock == '1') {
            $query->where('stock', '>', 0);
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $query->orderBy('rating', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percent', 'desc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->withCount('products')->get();
        $brands = Product::where('is_active', true)->whereNotNull('brand')->distinct()->pluck('brand');

        return view('frontend.shop', compact('products', 'categories', 'brands'));
    }

    public function searchSuggestions(Request $request)
    {
        $term = $request->get('term', '');
        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('name_bn', 'like', "%{$term}%")
                  ->orWhere('brand', 'like', "%{$term}%");
            })
            ->take(6)
            ->get(['id', 'name', 'name_bn', 'slug', 'selling_price', 'mrp', 'image', 'weight']);

        return response()->json($products);
    }

    public function offers()
    {
        $discountProducts = Product::where('is_active', true)
            ->where('discount_percent', '>=', 10)
            ->orderBy('discount_percent', 'desc')
            ->paginate(16);

        return view('frontend.offers', compact('discountProducts'));
    }

    public function bestSellers()
    {
        $products = Product::where('is_active', true)
            ->where('is_best_seller', true)
            ->paginate(16);

        return view('frontend.best_sellers', compact('products'));
    }

    public function newArrivals()
    {
        $products = Product::where('is_active', true)
            ->where('is_new_arrival', true)
            ->paginate(16);

        return view('frontend.new_arrivals', compact('products'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you promptly.');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function policy($type)
    {
        $validTypes = ['privacy-policy', 'terms-conditions', 'return-refund', 'delivery-info'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        return view('frontend.policy', ['type' => $type]);
    }
}
