<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\DeliveryPincode;
use App\Models\Setting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings
        $settings = [
            'site_name' => 'Nayan Mart',
            'tagline' => 'আপনার প্রতিদিনের বাজার',
            'sub_tagline' => 'Quality Products • Best Price • Fast Delivery',
            'phone' => '7550807912',
            'email' => 'skrousonali2024@gmail.com',
            'address' => 'Ashoknagar, Kalyangarh, North 24 Parganas, West Bengal, 743263',
            'free_shipping_threshold' => '249',
            'standard_delivery_fee' => '30',
            'upi_id' => '7550807912@paytm',
            'upi_name' => 'NAYAN MART',
            'currency_symbol' => '₹',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 2. Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@nayanmart.com'],
            [
                'name' => 'Nayan Mart Admin',
                'phone' => '7550807912',
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make('admin123'),
                'address' => 'Admin Office, Nayan Mart',
                'city' => 'Kolkata',
                'state' => 'West Bengal',
                'pincode' => '700001',
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'skrousonali2024@gmail.com'],
            [
                'name' => 'Mafiur Islam',
                'phone' => '9382559266',
                'role' => 'customer',
                'status' => 'active',
                'password' => Hash::make('password123'),
                'address' => 'Ashoknagar, kalyangarh, bhatchhala Saitul chicken shop',
                'city' => 'Delhi',
                'state' => 'West Bengal',
                'pincode' => '743263',
            ]
        );

        // 3. Categories & Subcategories
        $categoriesData = [
            [
                'name' => 'Rice & Pulses',
                'name_bn' => 'চাল ও ডাল',
                'slug' => 'rice-and-pulses',
                'icon' => 'bi-basket',
                'image' => '/assets/images/categories/rice.png',
                'subcategories' => ['Basmati Rice', 'Gobindobhog Rice', 'Miniket Rice', 'Masoor Dal', 'Moong Dal', 'Chana Dal']
            ],
            [
                'name' => 'Flours & Grains',
                'name_bn' => 'আটা / ময়দা / সুজি',
                'slug' => 'flours-and-grains',
                'icon' => 'bi-egg',
                'image' => '/assets/images/categories/flour.png',
                'subcategories' => ['Chakki Fresh Atta', 'Maida', 'Roasted Sooji', 'Besan']
            ],
            [
                'name' => 'Oils & Spices',
                'name_bn' => 'তেল ও মশলা',
                'slug' => 'oils-and-spices',
                'icon' => 'bi-droplet',
                'image' => '/assets/images/categories/oil.png',
                'subcategories' => ['Mustard Oil', 'Sunflower Oil', 'Garam Masala', 'Turmeric Powder', 'Chilli Powder']
            ],
            [
                'name' => 'Biscuits & Cookies',
                'name_bn' => 'বিস্কুট',
                'slug' => 'biscuits',
                'icon' => 'bi-cookie',
                'image' => '/assets/images/categories/biscuit.png',
                'subcategories' => ['Marie Gold', 'Cream Biscuits', 'Digestive Biscuits', 'Cookies']
            ],
            [
                'name' => 'Chanachur & Namkeen',
                'name_bn' => 'চানাচুর / নিমকি / নমকিন',
                'slug' => 'chanachur-namkeen',
                'icon' => 'bi-cup-hot',
                'image' => '/assets/images/categories/chanachur.png',
                'subcategories' => ['Mukharochak Chanachur', 'Bhujia', 'Nimki', 'Salted Peanuts']
            ],
            [
                'name' => 'Noodles & Vermicelli',
                'name_bn' => 'নুডলস / সেমাই',
                'slug' => 'noodles-vermicelli',
                'icon' => 'bi-patch-check',
                'image' => '/assets/images/categories/noodles.png',
                'subcategories' => ['Instant Noodles', 'Hakka Noodles', 'Roasted Sevai', 'Macaroni Pasta']
            ],
            [
                'name' => 'Tea & Coffee',
                'name_bn' => 'চা / কফি',
                'slug' => 'tea-coffee',
                'icon' => 'bi-cup-straw',
                'image' => '/assets/images/categories/tea.png',
                'subcategories' => ['CTC Tea', 'Green Tea', 'Instant Coffee', 'Filter Coffee']
            ],
            [
                'name' => 'Sugar & Salt',
                'name_bn' => 'চিনি / লবণ',
                'slug' => 'sugar-salt',
                'icon' => 'bi-boxes',
                'image' => '/assets/images/categories/sugar.png',
                'subcategories' => ['Refined Sugar', 'Jaggery Gur', 'Iodized Salt', 'Rock Salt']
            ],
            [
                'name' => 'Baby Food & Care',
                'name_bn' => 'বেবি ফুড',
                'slug' => 'baby-food',
                'icon' => 'bi-heart',
                'image' => '/assets/images/categories/babyfood.png',
                'subcategories' => ['Baby Cereal', 'Diapers', 'Baby Wipes', 'Baby Soap']
            ],
            [
                'name' => 'Cold Drinks & Juices',
                'name_bn' => 'কোল্ড ড্রিংকস',
                'slug' => 'cold-drinks',
                'icon' => 'bi-cup',
                'image' => '/assets/images/categories/drinks.png',
                'subcategories' => ['Soft Drinks', 'Fruit Juices', 'Energy Drinks', 'Mineral Water']
            ],
            [
                'name' => 'Snacks & Packed Food',
                'name_bn' => 'স্ন্যাকস',
                'slug' => 'snacks',
                'icon' => 'bi-bag-check',
                'image' => '/assets/images/categories/snacks.png',
                'subcategories' => ['Potato Chips', 'Kurkure', 'Popcorn', 'Sweets']
            ],
            [
                'name' => 'Daily Essentials',
                'name_bn' => 'দৈনন্দিন প্রয়োজনীয় পণ্য',
                'slug' => 'daily-essentials',
                'icon' => 'bi-house-heart',
                'image' => '/assets/images/categories/essentials.png',
                'subcategories' => ['Dairy & Eggs', 'Soaps & Shampoos', 'Detergent & Cleaners', 'Oral Care']
            ],
        ];

        $categoryModels = [];
        $subCatModels = [];
        $sort = 1;
        foreach ($categoriesData as $cData) {
            $cat = Category::updateOrCreate(
                ['slug' => $cData['slug']],
                [
                    'name' => $cData['name'],
                    'name_bn' => $cData['name_bn'],
                    'icon' => $cData['icon'],
                    'image' => $cData['image'],
                    'description' => $cData['name'] . ' fresh and best quality products at Nayan Mart.',
                    'is_featured' => true,
                    'is_active' => true,
                    'sort_order' => $sort++,
                ]
            );
            $categoryModels[$cat->slug] = $cat;

            $sSort = 1;
            foreach ($cData['subcategories'] as $subName) {
                $sub = Subcategory::updateOrCreate(
                    [
                        'category_id' => $cat->id,
                        'slug' => Str::slug($subName),
                    ],
                    [
                        'name' => $subName,
                        'name_bn' => $subName,
                        'is_active' => true,
                        'sort_order' => $sSort++,
                    ]
                );
                $subCatModels[$sub->slug] = $sub;
            }
        }

        // 4. Products (Matching user's screenshots exactly!)
        $productsData = [
            [
                'name' => 'Mother Dairy Curd',
                'name_bn' => 'মাদার ডেইরি দই',
                'slug' => 'mother-dairy-curd',
                'category_slug' => 'daily-essentials',
                'brand' => 'Mother Dairy',
                'mrp' => 56.00,
                'selling_price' => 50.00,
                'discount_percent' => 11,
                'weight' => '500 g',
                'unit' => 'g',
                'stock' => 85,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 4.0,
                'reviews_count' => 125,
                'image' => '/assets/images/products/mother-dairy-curd.png',
                'description' => 'Mother Dairy Mother Dairy Curd - 400 g / 500 g. Premium quality grocery product from Nayan Mart. Made from pasteurized toned milk, thick, creamy and delicious. Rich in probiotics for good gut health.',
                'specifications' => "Brand: Mother Dairy\nQuantity: 500 g\nIngredients: Pasteurized Toned Milk, Active Culture\nStorage: Keep refrigerated at 4°C or below\nShelf Life: 15 Days",
                'variants' => [
                    ['weight' => '100 g', 'mrp' => 15.00, 'selling_price' => 12.00, 'stock' => 40],
                    ['weight' => '200 g', 'mrp' => 28.00, 'selling_price' => 25.00, 'stock' => 50],
                    ['weight' => '500 g', 'mrp' => 56.00, 'selling_price' => 50.00, 'stock' => 85, 'is_default' => true],
                    ['weight' => '1 Kg', 'mrp' => 110.00, 'selling_price' => 98.00, 'stock' => 30],
                    ['weight' => '2 Kg', 'mrp' => 210.00, 'selling_price' => 190.00, 'stock' => 15],
                    ['weight' => '3 Kg', 'mrp' => 310.00, 'selling_price' => 280.00, 'stock' => 10],
                ]
            ],
            [
                'name' => 'Amul Butter',
                'name_bn' => 'আমুল মাখন',
                'slug' => 'amul-butter',
                'category_slug' => 'daily-essentials',
                'brand' => 'Amul',
                'mrp' => 58.00,
                'selling_price' => 52.00,
                'discount_percent' => 10,
                'weight' => '100 g',
                'unit' => 'g',
                'stock' => 120,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '10% OFF',
                'rating' => 3.9,
                'reviews_count' => 88,
                'image' => '/assets/images/products/amul-butter.png',
                'description' => 'Utterly Butterly Delicious Amul Butter! Made with pure fresh cream from cows and buffaloes. Great on toasted bread, in parathas, and cooking.',
                'specifications' => "Brand: Amul\nWeight: 100 g\nMilk Fat: 80%\nMoisture: 16%\nSalt: 3%",
                'variants' => [
                    ['weight' => '100 g', 'mrp' => 58.00, 'selling_price' => 52.00, 'stock' => 120, 'is_default' => true],
                    ['weight' => '500 g', 'mrp' => 285.00, 'selling_price' => 265.00, 'stock' => 45],
                ]
            ],
            [
                'name' => 'Paneer Fresh',
                'name_bn' => 'তাজা পনির',
                'slug' => 'paneer-fresh',
                'category_slug' => 'daily-essentials',
                'brand' => 'Amul',
                'mrp' => 95.00,
                'selling_price' => 85.00,
                'discount_percent' => 11,
                'weight' => '200 g',
                'unit' => 'g',
                'stock' => 60,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '11% OFF',
                'rating' => 4.6,
                'reviews_count' => 42,
                'image' => '/assets/images/products/paneer-fresh.png',
                'description' => 'Soft, moist and fresh dairy paneer cottage cheese. Perfect for matar paneer, shahi paneer, or frying for snacks.',
                'specifications' => "Brand: Amul Fresh\nWeight: 200 g\nSource: Cow & Buffalo Milk\nRefrigerate: Yes",
                'variants' => [
                    ['weight' => '200 g', 'mrp' => 95.00, 'selling_price' => 85.00, 'stock' => 60, 'is_default' => true],
                    ['weight' => '500 g', 'mrp' => 230.00, 'selling_price' => 205.00, 'stock' => 25],
                ]
            ],
            [
                'name' => 'Fresh Milk Toned',
                'name_bn' => 'তাজা টোনড দুধ',
                'slug' => 'fresh-milk-toned',
                'category_slug' => 'daily-essentials',
                'brand' => 'Mother Dairy',
                'mrp' => 28.00,
                'selling_price' => 25.00,
                'discount_percent' => 11,
                'weight' => '500 ml',
                'unit' => 'ml',
                'stock' => 150,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 4.4,
                'reviews_count' => 95,
                'image' => '/assets/images/products/fresh-milk.png',
                'description' => 'Fresh pasteurized toned milk with 3.0% Fat and 8.5% SNF. Wholesome and nourishing for the whole family.',
                'specifications' => "Volume: 500 ml\nFat: 3.0%\nSNF: 8.5%\nFortified with Vitamin A & D",
            ],
            [
                'name' => 'Amul Cheese Slices',
                'name_bn' => 'আমুল চিজ স্লাইস',
                'slug' => 'amul-cheese-slices',
                'category_slug' => 'daily-essentials',
                'brand' => 'Amul',
                'mrp' => 145.00,
                'selling_price' => 129.00,
                'discount_percent' => 11,
                'weight' => '200 g',
                'unit' => 'g',
                'stock' => 70,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 5.0,
                'reviews_count' => 60,
                'image' => '/assets/images/products/amul-cheese.png',
                'description' => 'Individually wrapped processed cheese slices. Melts deliciously on burgers, sandwiches, and toasts.',
                'specifications' => "Slices: 10 Slices\nWeight: 200 g\nBrand: Amul",
            ],
            [
                'name' => 'Frooti Mango Drink',
                'name_bn' => 'ফ্রুটি আম জুস',
                'slug' => 'frooti-mango-drink',
                'category_slug' => 'cold-drinks',
                'brand' => 'Parle Agro',
                'mrp' => 45.00,
                'selling_price' => 38.00,
                'discount_percent' => 15,
                'weight' => '600 ml',
                'unit' => 'ml',
                'stock' => 90,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '15% OFF',
                'rating' => 4.3,
                'reviews_count' => 54,
                'image' => '/assets/images/products/frooti.png',
                'description' => 'Real mango pulp juice drink with natural sweetness. India\'s favorite mango refreshment.',
                'specifications' => "Volume: 600 ml\nIngredients: Mango pulp, water, sugar",
            ],
            [
                'name' => 'Real Mixed Fruit Juice',
                'name_bn' => 'রিয়েল মিক্সড ফ্রুট জুস',
                'slug' => 'real-mixed-fruit-juice',
                'category_slug' => 'cold-drinks',
                'brand' => 'Real',
                'mrp' => 130.00,
                'selling_price' => 110.00,
                'discount_percent' => 15,
                'weight' => '1 L',
                'unit' => 'L',
                'stock' => 45,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '15% OFF',
                'rating' => 4.5,
                'reviews_count' => 38,
                'image' => '/assets/images/products/real-juice.png',
                'description' => 'Loaded with goodness of 9 chosen fruits. No added preservatives. Refreshing taste packed with vitamins.',
                'specifications' => "Volume: 1 Litre\nFruits: Apple, Mango, Guava, Banana, Orange, Apricot, Peach, Pineapple, Passion Fruit",
            ],
            [
                'name' => 'Limca Lemon Drink',
                'name_bn' => 'লিমকা লেমন ড্রিংক',
                'slug' => 'limca-lemon-drink',
                'category_slug' => 'cold-drinks',
                'brand' => 'Coca Cola',
                'mrp' => 40.00,
                'selling_price' => 38.00,
                'discount_percent' => 5,
                'weight' => '750 ml',
                'unit' => 'ml',
                'stock' => 80,
                'is_featured' => true,
                'is_best_seller' => false,
                'is_new_arrival' => false,
                'badge' => '5% OFF',
                'rating' => 4.2,
                'reviews_count' => 29,
                'image' => '/assets/images/products/limca.png',
                'description' => 'Crisp, fizzy lime and lemon refreshment that quenches your thirst immediately.',
                'specifications' => "Volume: 750 ml\nCarbonated soft drink",
            ],
            [
                'name' => 'Pepsi Soft Drink',
                'name_bn' => 'পেপসি সফট ড্রিংক',
                'slug' => 'pepsi-soft-drink',
                'category_slug' => 'cold-drinks',
                'brand' => 'PepsiCo',
                'mrp' => 40.00,
                'selling_price' => 38.00,
                'discount_percent' => 5,
                'weight' => '750 ml',
                'unit' => 'ml',
                'stock' => 110,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '5% OFF',
                'rating' => 4.3,
                'reviews_count' => 48,
                'image' => '/assets/images/products/pepsi.png',
                'description' => 'Swag se chug! Bold, refreshing cola taste served chilled.',
                'specifications' => "Volume: 750 ml\nPackaging: Pet Bottle",
            ],
            [
                'name' => 'Eggs Farm Fresh 6 Pcs',
                'name_bn' => 'তাজা দেশি ডিম ৬ পিস',
                'slug' => 'eggs-farm-fresh-6-pcs',
                'category_slug' => 'daily-essentials',
                'brand' => 'Farm Fresh',
                'mrp' => 48.00,
                'selling_price' => 42.00,
                'discount_percent' => 12,
                'weight' => '6 Pcs',
                'unit' => 'pcs',
                'stock' => 200,
                'is_featured' => true,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '12% OFF',
                'rating' => 4.6,
                'reviews_count' => 112,
                'image' => '/assets/images/products/eggs.png',
                'description' => 'Grade-A farm fresh white eggs packed safely in protective carton. Rich source of protein.',
                'specifications' => "Pack: 6 Eggs\nSource: Certified Poultry Farms",
            ],
            [
                'name' => 'Colgate Strong Teeth Toothpaste',
                'name_bn' => 'কোলগেট টুথপেস্ট',
                'slug' => 'colgate-strong-teeth-toothpaste',
                'category_slug' => 'daily-essentials',
                'brand' => 'Colgate',
                'mrp' => 118.00,
                'selling_price' => 105.00,
                'discount_percent' => 11,
                'weight' => '150 g',
                'unit' => 'g',
                'stock' => 95,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 4.7,
                'reviews_count' => 74,
                'image' => '/assets/images/products/colgate.png',
                'description' => 'Colgate Strong Teeth with Amino Shakti formula strengthens teeth from within. Fights cavities all day.',
                'specifications' => "Weight: 150 g\nFeature: Calcium Boost formula",
            ],
            [
                'name' => 'Parle-G Gold Biscuits',
                'name_bn' => 'পারলে-জি গোল্ড বিস্কুট',
                'slug' => 'parle-g-gold-biscuits',
                'category_slug' => 'biscuits',
                'brand' => 'Parle',
                'mrp' => 50.00,
                'selling_price' => 45.00,
                'discount_percent' => 10,
                'weight' => '1 kg',
                'unit' => 'kg',
                'stock' => 140,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '10% OFF',
                'rating' => 4.5,
                'reviews_count' => 130,
                'image' => '/assets/images/products/parle-g.png',
                'description' => 'Bigger, crispier and more golden Parle-G biscuits. Great with hot tea.',
                'specifications' => "Weight: 1 kg\nContains Wheat, Milk, Glucose",
            ],
            [
                'name' => 'Surf Excel Detergent Powder',
                'name_bn' => 'সার্ফ এক্সেল ডিটারজেন্ট',
                'slug' => 'surf-excel-detergent-powder',
                'category_slug' => 'daily-essentials',
                'brand' => 'Surf Excel',
                'mrp' => 145.00,
                'selling_price' => 130.00,
                'discount_percent' => 10,
                'weight' => '1 kg',
                'unit' => 'kg',
                'stock' => 85,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '10% OFF',
                'rating' => 4.8,
                'reviews_count' => 67,
                'image' => '/assets/images/products/surf-excel.png',
                'description' => 'Surf Excel Easy Wash removes tough stains like mud, ink, and oil without harming clothes.',
                'specifications' => "Weight: 1 kg\nBrand: Unilever",
            ],
            [
                'name' => 'Maggi 2-Minute Noodles 4-Pack',
                'name_bn' => 'ম্যাগি ২-মিনিট নুডলস',
                'slug' => 'maggi-2-minute-noodles-4-pack',
                'category_slug' => 'noodles-vermicelli',
                'brand' => 'Maggi',
                'mrp' => 56.00,
                'selling_price' => 48.00,
                'discount_percent' => 14,
                'weight' => '280 g',
                'unit' => 'g',
                'stock' => 130,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '14% OFF',
                'rating' => 4.8,
                'reviews_count' => 210,
                'image' => '/assets/images/products/maggi.png',
                'description' => 'Favorite masala noodles made with authentic Indian spices. Ready in just 2 minutes.',
                'specifications' => "Pack of: 4 individual cakes (70g each)\nBrand: Nestle Maggi",
            ],
            [
                'name' => 'Fortune Sunlite Refined Sunflower Oil',
                'name_bn' => 'ফরচুন সূর্যমুখী তেল',
                'slug' => 'fortune-sunlite-sunflower-oil',
                'category_slug' => 'oils-and-spices',
                'brand' => 'Fortune',
                'mrp' => 155.00,
                'selling_price' => 138.00,
                'discount_percent' => 11,
                'weight' => '1 L',
                'unit' => 'L',
                'stock' => 100,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 4.7,
                'reviews_count' => 84,
                'image' => '/assets/images/products/fortune-oil.png',
                'description' => 'Light, healthy and cholesterol-friendly cooking oil enriched with Vitamins A and D.',
                'specifications' => "Volume: 1 Litre\nPouch packaging\nLight on digestion",
                'variants' => [
                    ['weight' => '1 L', 'mrp' => 155.00, 'selling_price' => 138.00, 'stock' => 100, 'is_default' => true],
                    ['weight' => '5 L Jar', 'mrp' => 760.00, 'selling_price' => 670.00, 'stock' => 30],
                ]
            ],
            [
                'name' => 'Pampers Baby Dry Diaper Pants',
                'name_bn' => 'প্যাম্পার্স ডায়াপার প্যান্টস',
                'slug' => 'pampers-baby-dry-diaper-pants',
                'category_slug' => 'baby-food',
                'brand' => 'Pampers',
                'mrp' => 350.00,
                'selling_price' => 319.00,
                'discount_percent' => 9,
                'weight' => 'Small 22 pcs',
                'unit' => 'pcs',
                'stock' => 40,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '9% OFF',
                'rating' => 4.8,
                'reviews_count' => 52,
                'image' => '/assets/images/products/pampers.png',
                'description' => 'Magic Gel technology locks wetness for up to 12 hours. Soft waistband with anti-rash lotion.',
                'specifications' => "Size: Small (4-8 kg)\nCount: 22 Diapers\nBrand: Procter & Gamble",
            ],
            [
                'name' => 'Tata Tea Gold Leaf Tea',
                'name_bn' => 'টাটা টি গোল্ড পাতা চা',
                'slug' => 'tata-tea-gold-leaf-tea',
                'category_slug' => 'tea-coffee',
                'brand' => 'Tata Tea',
                'mrp' => 135.00,
                'selling_price' => 120.00,
                'discount_percent' => 11,
                'weight' => '250 g',
                'unit' => 'g',
                'stock' => 95,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '11% OFF',
                'rating' => 4.6,
                'reviews_count' => 64,
                'image' => '/assets/images/products/tata-tea.png',
                'description' => 'A unique blend of fine CTC tea along with gently rolled 15% long leaves for rich aroma and brisk taste.',
                'specifications' => "Weight: 250 g\nOrigin: Assam Tea Gardens",
            ],
            [
                'name' => 'Madhur Pure & Hygienic Sugar',
                'name_bn' => 'মধুর খাঁটি চিনি',
                'slug' => 'madhur-pure-hygienic-sugar',
                'category_slug' => 'sugar-salt',
                'brand' => 'Madhur',
                'mrp' => 54.00,
                'selling_price' => 49.00,
                'discount_percent' => 9,
                'weight' => '1 kg',
                'unit' => 'kg',
                'stock' => 250,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '9% OFF',
                'rating' => 4.9,
                'reviews_count' => 108,
                'image' => '/assets/images/products/sugar.png',
                'description' => 'Sulphur-free, untouched by hands, sparkling white sugar crystals.',
                'specifications' => "Weight: 1 kg\n100% Vegetarian\nSulphur Free",
            ],
            [
                'name' => 'Aashirvaad Superior MP Atta',
                'name_bn' => 'আশীর্বাদ এম পি আটা',
                'slug' => 'aashirvaad-superior-mp-atta',
                'category_slug' => 'flours-and-grains',
                'brand' => 'Aashirvaad',
                'mrp' => 260.00,
                'selling_price' => 230.00,
                'discount_percent' => 12,
                'weight' => '5 kg',
                'unit' => 'kg',
                'stock' => 110,
                'is_featured' => false,
                'is_best_seller' => true,
                'is_new_arrival' => false,
                'badge' => '12% OFF',
                'rating' => 4.8,
                'reviews_count' => 142,
                'image' => '/assets/images/products/aashirvaad-atta.png',
                'description' => 'Made from heavy grains with golden sheen sourced from fields of Madhya Pradesh. Makes soft rotis that stay fresh for longer.',
                'specifications' => "Weight: 5 kg\n100% Whole Wheat\n0% Maida",
                'variants' => [
                    ['weight' => '1 kg', 'mrp' => 55.00, 'selling_price' => 49.00, 'stock' => 80],
                    ['weight' => '5 kg', 'mrp' => 260.00, 'selling_price' => 230.00, 'stock' => 110, 'is_default' => true],
                    ['weight' => '10 kg', 'mrp' => 510.00, 'selling_price' => 450.00, 'stock' => 50],
                ]
            ],
            [
                'name' => 'Aashirvaad Shahi Garam Masala',
                'name_bn' => 'আশীর্বাদ শাহী গরম মশলা',
                'slug' => 'aashirvaad-shahi-garam-masala',
                'category_slug' => 'oils-and-spices',
                'brand' => 'Aashirvaad',
                'mrp' => 70.00,
                'selling_price' => 62.00,
                'discount_percent' => 11,
                'weight' => '100 g',
                'unit' => 'g',
                'stock' => 75,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '11% OFF',
                'rating' => 4.6,
                'reviews_count' => 41,
                'image' => '/assets/images/products/garam-masala.png',
                'description' => 'Aashirvaad Shahi Garam Masala is a balanced blend of aromatic whole spices that gives rich restaurant-style flavor to everyday curries.',
                'specifications' => "Brand: Aashirvaad\nWeight: 100 g\nIngredients: Coriander, Cumin, Black Pepper, Cinnamon, Cardamom, Clove, Nutmeg",
            ],
            [
                'name' => 'Tang Instant Orange Drink',
                'name_bn' => 'ট্যাং অরেঞ্জ ড্রিংক',
                'slug' => 'tang-instant-orange-drink',
                'category_slug' => 'tea-coffee',
                'brand' => 'Tang',
                'mrp' => 110.00,
                'selling_price' => 99.00,
                'discount_percent' => 10,
                'weight' => '500 g',
                'unit' => 'g',
                'stock' => 65,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '10% OFF',
                'rating' => 4.5,
                'reviews_count' => 33,
                'image' => '/assets/images/products/tang.png',
                'description' => 'Instant refreshing fruit powder loaded with Vitamin C and iron. Just mix with chilled water.',
                'specifications' => "Weight: 500 g\nFlavor: Juicy Orange",
            ],
            [
                'name' => 'Gillette Mach3 Razor',
                'name_bn' => 'জিলেট রেজোর',
                'slug' => 'gillette-mach3-razor',
                'category_slug' => 'daily-essentials',
                'brand' => 'Gillette',
                'mrp' => 240.00,
                'selling_price' => 219.00,
                'discount_percent' => 9,
                'weight' => '1 Unit',
                'unit' => 'pcs',
                'stock' => 50,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '9% OFF',
                'rating' => 4.9,
                'reviews_count' => 45,
                'image' => '/assets/images/products/gillette.png',
                'description' => '3 high-definition blades with lubrication strip for a smooth, irritation-free glide.',
                'specifications' => "Blades: 3\nBrand: P&G Gillette",
            ],
            [
                'name' => 'Nivea Men Deep Clean Face Wash',
                'name_bn' => 'নিভিয়া ফেস ওয়াশ',
                'slug' => 'nivea-men-deep-clean-face-wash',
                'category_slug' => 'daily-essentials',
                'brand' => 'Nivea',
                'mrp' => 165.00,
                'selling_price' => 145.00,
                'discount_percent' => 12,
                'weight' => '100 g',
                'unit' => 'g',
                'stock' => 70,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '12% OFF',
                'rating' => 4.7,
                'reviews_count' => 58,
                'image' => '/assets/images/products/nivea.png',
                'description' => 'Black charcoal deep cleansing formula purifies pores and controls excess oil without drying.',
                'specifications' => "Volume: 100 g\nWith Black Carbon",
            ],
            [
                'name' => 'Domex Disinfectant Bleach',
                'name_bn' => 'ডমেক্স ফ্লোর ক্লিনার',
                'slug' => 'domex-disinfectant-bleach',
                'category_slug' => 'daily-essentials',
                'brand' => 'Domex',
                'mrp' => 125.00,
                'selling_price' => 110.00,
                'discount_percent' => 12,
                'weight' => '500 ml',
                'unit' => 'ml',
                'stock' => 60,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '12% OFF',
                'rating' => 4.4,
                'reviews_count' => 26,
                'image' => '/assets/images/products/domex.png',
                'description' => 'Kills 99.9% germs and viruses. Provides power disinfectant action for bathrooms and floor.',
                'specifications' => "Volume: 500 ml\nBrand: Unilever",
            ],
            [
                'name' => 'Lactogen 1 Infant Formula',
                'name_bn' => 'ল্যাকটোজেন ফর্মুলা দুধ',
                'slug' => 'lactogen-1-infant-formula',
                'category_slug' => 'baby-food',
                'brand' => 'Nestle',
                'mrp' => 415.00,
                'selling_price' => 385.00,
                'discount_percent' => 7,
                'weight' => '400 g',
                'unit' => 'g',
                'stock' => 35,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '7% OFF',
                'rating' => 4.8,
                'reviews_count' => 40,
                'image' => '/assets/images/products/lactogen.png',
                'description' => 'Spray dried infant milk formula with probiotic L. reuteri for babies up to 6 months.',
                'specifications' => "Weight: 400 g Bag-in-box\nStage: 1 (Up to 6 Months)",
            ],
            [
                'name' => 'Haldiram All In One Namkeen',
                'name_bn' => 'হলদিরাম অল ইন ওয়ান চানাচুর',
                'slug' => 'haldiram-all-in-one-namkeen',
                'category_slug' => 'chanachur-namkeen',
                'brand' => 'Haldirams',
                'mrp' => 50.00,
                'selling_price' => 45.00,
                'discount_percent' => 10,
                'weight' => '200 g',
                'unit' => 'g',
                'stock' => 110,
                'is_featured' => false,
                'is_best_seller' => false,
                'is_new_arrival' => true,
                'badge' => '10% OFF',
                'rating' => 4.6,
                'reviews_count' => 53,
                'image' => '/assets/images/products/haldiram.png',
                'description' => 'Crunchy mixture of chickpea flour noodles, lentils, nuts, and spices. Delightful tea-time snack.',
                'specifications' => "Weight: 200 g\nBrand: Haldirams",
            ]
        ];

        $createdProducts = [];
        foreach ($productsData as $p) {
            $cat = $categoryModels[$p['category_slug']] ?? Category::first();
            $product = Product::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'category_id' => $cat->id,
                    'name' => $p['name'],
                    'name_bn' => $p['name_bn'],
                    'brand' => $p['brand'],
                    'sku' => 'NM' . strtoupper(substr(md5($p['slug']), 0, 8)),
                    'description' => $p['description'],
                    'specifications' => $p['specifications'],
                    'mrp' => $p['mrp'],
                    'selling_price' => $p['selling_price'],
                    'discount_percent' => $p['discount_percent'],
                    'weight' => $p['weight'],
                    'unit' => $p['unit'],
                    'stock' => $p['stock'],
                    'image' => $p['image'],
                    'badge' => $p['badge'],
                    'is_featured' => $p['is_featured'],
                    'is_best_seller' => $p['is_best_seller'],
                    'is_new_arrival' => $p['is_new_arrival'],
                    'is_active' => true,
                    'rating' => $p['rating'],
                    'reviews_count' => $p['reviews_count'],
                ]
            );

            // Add variants if any
            if (isset($p['variants'])) {
                foreach ($p['variants'] as $v) {
                    ProductVariant::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'weight' => $v['weight'],
                        ],
                        [
                            'unit' => 'g',
                            'mrp' => $v['mrp'],
                            'selling_price' => $v['selling_price'],
                            'stock' => $v['stock'],
                            'is_default' => $v['is_default'] ?? false,
                            'image' => $v['image'] ?? null,
                        ]
                    );
                }
            }

            // Add main image to ProductImage gallery
            ProductImage::firstOrCreate([
                'product_id' => $product->id,
                'image_path' => $product->image,
            ], [
                'sort_order' => 1,
            ]);

            $createdProducts[$product->slug] = $product;
        }

        // 5. Banners
        Banner::updateOrCreate(
            ['title' => 'Fresh Groceries Delivered at Your Doorstep'],
            [
                'subtitle' => 'Quality Products • Best Price • Fast Delivery',
                'tagline_bn' => 'আপনার ঘরের বাজার, এখন হাতের মুঠোয়',
                'badge' => 'Welcome to Nayan Mart',
                'image' => '/assets/images/banners/hero-basket.png',
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
                'banner_type' => 'hero_slider',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Special Discount 10% OFF'],
            [
                'subtitle' => 'On Fresh Vegetables & Dairy',
                'tagline_bn' => 'দৈনন্দিন কেনাকাটায় ১০% ছাড়',
                'badge' => '10% OFF',
                'image' => '/assets/images/banners/promo-1.png',
                'button_text' => 'Shop Now',
                'button_link' => '/shop?category=daily-essentials',
                'banner_type' => 'promo_card',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Free Delivery'],
            [
                'subtitle' => 'On Orders Above ₹249',
                'tagline_bn' => '₹২৪৯ এর উপরে অর্ডারে ফ্রি ডেলিভারি',
                'badge' => 'FREE DELIVERY',
                'image' => '/assets/images/banners/promo-2.png',
                'button_text' => 'Order Now',
                'button_link' => '/shop',
                'banner_type' => 'promo_card',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        Banner::updateOrCreate(
            ['title' => 'Big Savings'],
            [
                'subtitle' => 'On Monthly Grocery Pack 25% OFF',
                'tagline_bn' => 'মাসিক বাজারের জন্য বিশাল সঞ্চয়',
                'badge' => '25% OFF',
                'image' => '/assets/images/banners/promo-3.png',
                'button_text' => 'Shop Now',
                'button_link' => '/shop?category=rice-and-pulses',
                'banner_type' => 'promo_card',
                'sort_order' => 3,
                'is_active' => true,
            ]
        );

        // 6. Coupons
        Coupon::updateOrCreate(
            ['code' => 'NAYAN10'],
            [
                'discount_type' => 'percent',
                'discount_value' => 10,
                'min_order_amount' => 249,
                'max_discount_amount' => 100,
                'usage_limit' => 500,
                'used_count' => 14,
                'expiry_date' => now()->addMonths(6),
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'FREESHIP'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 30,
                'min_order_amount' => 199,
                'usage_limit' => 1000,
                'used_count' => 28,
                'expiry_date' => now()->addMonths(6),
                'is_active' => true,
            ]
        );

        Coupon::updateOrCreate(
            ['code' => 'FESTIVAL50'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 50,
                'min_order_amount' => 499,
                'usage_limit' => 300,
                'used_count' => 6,
                'expiry_date' => now()->addMonths(3),
                'is_active' => true,
            ]
        );

        // 7. Delivery Pincodes
        $pincodes = [
            ['pincode' => '743263', 'city' => 'Ashoknagar', 'district' => 'North 24 Parganas', 'state' => 'West Bengal', 'delivery_charge' => 0.00, 'min_free_delivery' => 249.00, 'estimated_time' => 'Same Day (Within 4-6 Hours)'],
            ['pincode' => '700001', 'city' => 'Kolkata GPO', 'district' => 'Kolkata', 'state' => 'West Bengal', 'delivery_charge' => 30.00, 'min_free_delivery' => 249.00, 'estimated_time' => '24 Hours Delivery'],
            ['pincode' => '700091', 'city' => 'Salt Lake', 'district' => 'North 24 Parganas', 'state' => 'West Bengal', 'delivery_charge' => 30.00, 'min_free_delivery' => 249.00, 'estimated_time' => 'Same Day Delivery'],
            ['pincode' => '700156', 'city' => 'New Town', 'district' => 'North 24 Parganas', 'state' => 'West Bengal', 'delivery_charge' => 30.00, 'min_free_delivery' => 249.00, 'estimated_time' => 'Same Day Delivery'],
            ['pincode' => '743272', 'city' => 'Habra', 'district' => 'North 24 Parganas', 'state' => 'West Bengal', 'delivery_charge' => 0.00, 'min_free_delivery' => 249.00, 'estimated_time' => 'Within 2-4 Hours'],
            ['pincode' => '110001', 'city' => 'New Delhi', 'district' => 'Central Delhi', 'state' => 'Delhi', 'delivery_charge' => 40.00, 'min_free_delivery' => 249.00, 'estimated_time' => '2-3 Business Days'],
        ];

        foreach ($pincodes as $pin) {
            DeliveryPincode::updateOrCreate(['pincode' => $pin['pincode']], $pin);
        }

        // 8. Sample Completed / Trackable Order matching Screenshot 3 & 4
        $sampleOrder = Order::updateOrCreate(
            ['order_number' => 'NM94821670'],
            [
                'user_id' => $customer->id,
                'customer_name' => 'Mafiur Islam',
                'customer_phone' => '9382559266',
                'customer_email' => 'skrousonali2024@gmail.com',
                'house_flat' => 'Saitul chicken shop',
                'street_area' => 'Ashoknagar, kalyangarh, bhatchhala',
                'city' => 'Delhi',
                'state' => 'West Bengal',
                'pincode' => '743263',
                'landmark' => 'Near Rail Gate',
                'address_type' => 'Home',
                'subtotal' => 112.00,
                'discount' => 0.00,
                'delivery_charge' => 0.00,
                'total' => 112.00,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'transaction_id' => 'TR747B1AD5',
                'order_status' => 'placed',
                'notes' => 'Deliver before 7 PM please.',
                'expected_delivery_date' => now()->addDays(4),
            ]
        );

        // Add items to sample order
        $p1 = $createdProducts['mother-dairy-curd'] ?? null;
        $p2 = $createdProducts['aashirvaad-shahi-garam-masala'] ?? null;

        if ($p1) {
            OrderItem::updateOrCreate(
                ['order_id' => $sampleOrder->id, 'product_id' => $p1->id],
                [
                    'product_name' => 'Mother Dairy Curd',
                    'product_image' => $p1->image,
                    'weight' => '500 g',
                    'price' => 50.00,
                    'quantity' => 1,
                    'subtotal' => 50.00,
                ]
            );
        }

        if ($p2) {
            OrderItem::updateOrCreate(
                ['order_id' => $sampleOrder->id, 'product_id' => $p2->id],
                [
                    'product_name' => 'Aashirvaad Shahi Garam Masala',
                    'product_image' => $p2->image,
                    'weight' => '100 g',
                    'price' => 62.00,
                    'quantity' => 1,
                    'subtotal' => 62.00,
                ]
            );
        }

        // Add tracking steps
        OrderTracking::updateOrCreate(
            ['order_id' => $sampleOrder->id, 'status' => 'placed'],
            [
                'title' => 'Order Placed',
                'description' => 'Your order has been received and is waiting for confirmation.',
                'tracked_at' => now()->subMinutes(15),
            ]
        );

        // 9. Sample Product Reviews
        if ($p1) {
            Review::updateOrCreate(
                ['product_id' => $p1->id, 'customer_name' => 'Subhashree Roy'],
                [
                    'user_id' => null,
                    'rating' => 5,
                    'comment' => 'Very fresh and thick curd. Best quality delivered fast by Nayan Mart!',
                    'is_approved' => true,
                ]
            );
            Review::updateOrCreate(
                ['product_id' => $p1->id, 'customer_name' => 'Tanmoy Das'],
                [
                    'user_id' => null,
                    'rating' => 4,
                    'comment' => 'Good packaging, ice cool even in afternoon delivery.',
                    'is_approved' => true,
                ]
            );
        }
    }
}
