<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPincode;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminDeliveryController extends Controller
{
    public function index()
    {
        $pincodes = DeliveryPincode::orderBy('city', 'asc')->get();
        $freeShippingThreshold = Setting::get('free_shipping_threshold', 249);
        $standardDeliveryFee = Setting::get('standard_delivery_fee', 30);

        return view('admin.delivery.index', compact('pincodes', 'freeShippingThreshold', 'standardDeliveryFee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6|unique:delivery_pincodes,pincode',
            'city' => 'required|string|max:100',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        DeliveryPincode::create([
            'pincode' => $request->pincode,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state ?? 'West Bengal',
            'delivery_charge' => $request->delivery_charge,
            'min_free_delivery' => $request->min_free_delivery ?? 249,
            'estimated_time' => $request->estimated_time ?? 'Same Day / 24 Hours',
            'is_deliverable' => $request->has('is_deliverable'),
        ]);

        return back()->with('success', 'PIN code added to delivery zone.');
    }

    public function updateRules(Request $request)
    {
        $request->validate([
            'free_shipping_threshold' => 'required|numeric|min:0',
            'standard_delivery_fee' => 'required|numeric|min:0',
        ]);

        Setting::set('free_shipping_threshold', $request->free_shipping_threshold);
        Setting::set('standard_delivery_fee', $request->standard_delivery_fee);

        return back()->with('success', 'Delivery fee rules updated successfully.');
    }

    public function toggle($id)
    {
        $pin = DeliveryPincode::findOrFail($id);
        $pin->is_deliverable = !$pin->is_deliverable;
        $pin->save();

        return back()->with('success', 'PIN code delivery status changed.');
    }

    public function destroy($id)
    {
        $pin = DeliveryPincode::findOrFail($id);
        $pin->delete();

        return back()->with('success', 'PIN code removed.');
    }
}
