<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect admin to admin panel if admin logged in
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('account.dashboard'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('account.dashboard');
        }
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('account.dashboard')->with('success', 'Your account has been created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $ordersCount = Order::where('user_id', $user->id)->count();
        $recentOrders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();

        return view('frontend.account.dashboard', compact('user', 'ordersCount', 'recentOrders', 'wishlistCount'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('frontend.account.orders', compact('orders'));
    }

    public function wishlist()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $query = Wishlist::with('product');
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $wishlistItems = $query->orderBy('created_at', 'desc')->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    public function toggleWishlist(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        $userId = Auth::id();
        $sessionId = session()->getId();

        $condition = $userId ? ['user_id' => $userId, 'product_id' => $product->id] : ['session_id' => $sessionId, 'product_id' => $product->id];

        $item = Wishlist::where($condition)->first();

        if ($item) {
            $item->delete();
            $added = false;
            $message = "{$product->name} removed from wishlist.";
        } else {
            Wishlist::create(array_merge($condition, ['product_id' => $product->id]));
            $added = true;
            $message = "{$product->name} added to wishlist ❤️";
        }

        $count = $userId 
            ? Wishlist::where('user_id', $userId)->count()
            : Wishlist::where('session_id', $sessionId)->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'added' => $added,
                'message' => $message,
                'wishlist_count' => $count,
            ]);
        }

        return back()->with('success', $message);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('frontend.account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
        ]);

        $user->update($request->only('name', 'phone', 'address', 'city', 'state', 'pincode'));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
