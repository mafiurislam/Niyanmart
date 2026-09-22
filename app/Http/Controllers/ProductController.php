<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryPincode;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'subcategory', 'variants', 'images', 'reviews'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(6)
            ->get();

        return view('frontend.product_details', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with('subcategories')
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(16)
            ->withQueryString();

        return view('frontend.category', compact('category', 'products'));
    }

    public function checkPincode(Request $request)
    {
        $pincode = trim($request->get('pincode', ''));
        if (strlen($pincode) !== 6 || !is_numeric($pincode)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 6-digit Indian PIN code.'
            ]);
        }

        $pin = DeliveryPincode::where('pincode', $pincode)->first();
        if ($pin && $pin->is_deliverable) {
            $freeText = $pin->delivery_charge > 0 
                ? "Delivery Charge: ₹" . number_format($pin->delivery_charge, 0) . " (Free on orders above ₹" . number_format($pin->min_free_delivery, 0) . ")"
                : "FREE Delivery!";
            return response()->json([
                'success' => true,
                'deliverable' => true,
                'message' => "Delivery available in {$pin->city}, {$pin->state}! Estimated: {$pin->estimated_time}. {$freeText}"
            ]);
        }

        // Check if standard regional pincode in West Bengal (starts with 70, 71, 72, 73, 74)
        if (str_starts_with($pincode, '7')) {
            return response()->json([
                'success' => true,
                'deliverable' => true,
                'message' => "Delivery available! Estimated delivery within 24-48 hours. Free delivery on orders above ₹249."
            ]);
        }

        return response()->json([
            'success' => false,
            'deliverable' => false,
            'message' => 'Sorry, express grocery delivery is currently not serviceable at this PIN code.'
        ]);
    }

    public function submitReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);

        // Recalculate average rating and reviews count
        $avg = Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating');
        $count = Review::where('product_id', $product->id)->where('is_approved', true)->count();
        $product->update([
            'rating' => round($avg, 1),
            'reviews_count' => $count,
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted successfully.');
    }
}
