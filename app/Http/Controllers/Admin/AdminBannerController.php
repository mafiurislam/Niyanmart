<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'banner_type' => 'required|in:hero_slider,promo_card,festival',
        ]);

        $imagePath = '/assets/images/banners/hero-basket.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banners'), $filename);
            $imagePath = '/assets/images/banners/' . $filename;
        }

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'tagline_bn' => $request->tagline_bn,
            'badge' => $request->badge,
            'image' => $imagePath,
            'button_text' => $request->button_text ?? 'Shop Now',
            'button_link' => $request->button_link ?? '/shop',
            'banner_type' => $request->banner_type,
            'sort_order' => (int) $request->sort_order,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Banner created successfully!');
    }

    public function toggle($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return back()->with('success', 'Banner status updated.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return back()->with('success', 'Banner removed.');
    }
}
