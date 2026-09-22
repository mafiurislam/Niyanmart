<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DeliveryPincode;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SqliteDatabaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }
    public function test_database_driver_is_sqlite(): void
    {
        $connection = DB::connection()->getDriverName();
        $this->assertEquals('sqlite', $connection);
    }

    public function test_can_read_and_authenticate_users(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());

        $customer = User::where('role', 'customer')->first();
        $this->assertNotNull($customer);
        $this->assertFalse($customer->isAdmin());
    }

    public function test_can_query_catalog_and_relations(): void
    {
        $this->assertGreaterThan(0, Category::count());
        $this->assertGreaterThan(0, Product::count());

        $product = Product::with(['category', 'variants'])->first();
        $this->assertNotNull($product);
        $this->assertNotNull($product->category);
    }

    public function test_can_query_orders_and_settings(): void
    {
        $this->assertGreaterThan(0, Setting::count());
        $siteName = Setting::get('site_name');
        $this->assertEquals('Nayan Mart', $siteName);

        $this->assertGreaterThan(0, Order::count());
        $order = Order::with('items')->first();
        $this->assertNotNull($order);
    }

    public function test_sqlite_write_update_delete_transactions(): void
    {
        // 1. Create
        $testInquiry = Inquiry::create([
            'name' => 'Hostinger SQLite Verification',
            'email' => 'hostinger-test@nayanmart.com',
            'subject' => 'SQLite Verification',
            'message' => 'Testing SQLite database write operations for Hostinger.',
            'status' => 'open',
        ]);
        $this->assertDatabaseHas('inquiries', ['id' => $testInquiry->id]);

        // 2. Update
        $testInquiry->update(['status' => 'closed']);
        $this->assertDatabaseHas('inquiries', ['id' => $testInquiry->id, 'status' => 'closed']);

        // 3. Delete
        $testInquiryId = $testInquiry->id;
        $testInquiry->delete();
        $this->assertDatabaseMissing('inquiries', ['id' => $testInquiryId]);
    }

    public function test_user_authentication_flow(): void
    {
        // Test Customer Login
        $response = $this->post('/login', [
            'email' => 'skrousonali2024@gmail.com',
            'password' => 'password123',
        ]);
        $response->assertRedirect('/account');
        $this->assertAuthenticated();

        // Logout
        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_admin_authentication_and_dashboard_access(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    public function test_catalog_pages_work(): void
    {
        $category = Category::first();
        $product = Product::first();

        // Home
        $this->get('/')->assertStatus(200);

        // Shop
        $this->get('/shop')->assertStatus(200);

        // Category
        $this->get('/category/' . $category->slug)->assertStatus(200);

        // Product Details
        $this->get('/product/' . $product->slug)->assertStatus(200);
    }

    public function test_pincode_check_api(): void
    {
        $pincode = DeliveryPincode::first();
        $response = $this->getJson('/check-pincode?pincode=' . $pincode->pincode);
        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'deliverable' => true]);
    }

    public function test_cart_and_order_placement_flow(): void
    {
        $product = Product::first();

        // 1. Add to cart
        $addResponse = $this->postJson('/cart/add', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $addResponse->assertJson(['success' => true]);

        // 2. View cart
        $cartResponse = $this->get('/cart');
        $cartResponse->assertStatus(200);

        // 3. Place Order
        $orderData = [
            'customer_name' => 'Test Customer',
            'customer_phone' => '9876543210',
            'customer_email' => 'test@customer.com',
            'street_area' => '123 Test Street',
            'city' => 'Kolkata',
            'state' => 'West Bengal',
            'pincode' => '700001',
            'address_type' => 'Home',
            'payment_method' => 'cod',
        ];

        $checkoutResponse = $this->post('/checkout/place-order', $orderData);
        $checkoutResponse->assertRedirect();

        // Verify order saved in SQLite database
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test Customer',
            'customer_phone' => '9876543210',
            'payment_method' => 'cod',
            'order_status' => 'placed',
        ]);
    }
}
