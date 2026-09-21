-- NAYAN MART - E-Commerce Database Dump for Hostinger MySQL / phpMyAdmin
-- Generated: 2026-09-21 13:09:37
-- Brand: Nayan Mart (আপনার ঘরের বাজার, এখন হাতের মুঠোয়)

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+00:00';
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'customer',
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `role`, `address`, `city`, `state`, `pincode`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nayan Mart Admin', 'admin@nayanmart.com', 7550807912, 'admin', 'Admin Office, Nayan Mart', 'Kolkata', 'West Bengal', 700001, 'active', NULL, '$2y$12$MBO.o/55Cb.JRSdGlAxdQuFR9s7vVp26uRE1jLxYzVXqvhoomqH1G', NULL, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(2, 'Mafiur Islam', 'skrousonali2024@gmail.com', 9382559266, 'customer', 'Ashoknagar, kalyangarh, bhatchhala Saitul chicken shop', 'Delhi', 'West Bengal', 743263, 'active', NULL, '$2y$12$JD6lFbUQH1ZLt2JcDNP7GOSO6XBMOpkNta.0QovVNjZ7P9eAwiqLC', NULL, '2026-09-21 13:08:42', '2026-09-21 13:08:42');

-- --------------------------------------------------------
-- Table structure for table `categories`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `categories`
INSERT INTO `categories` (`id`, `name`, `name_bn`, `slug`, `icon`, `image`, `description`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Rice & Pulses', 'চাল ও ডাল', 'rice-and-pulses', 'bi-basket', '/assets/images/categories/rice.png', 'Rice & Pulses fresh and best quality products at Nayan Mart.', 1, 1, 1, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(2, 'Flours & Grains', 'আটা / ময়দা / সুজি', 'flours-and-grains', 'bi-egg', '/assets/images/categories/flour.png', 'Flours & Grains fresh and best quality products at Nayan Mart.', 1, 1, 2, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(3, 'Oils & Spices', 'তেল ও মশলা', 'oils-and-spices', 'bi-droplet', '/assets/images/categories/oil.png', 'Oils & Spices fresh and best quality products at Nayan Mart.', 1, 1, 3, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(4, 'Biscuits & Cookies', 'বিস্কুট', 'biscuits', 'bi-cookie', '/assets/images/categories/biscuit.png', 'Biscuits & Cookies fresh and best quality products at Nayan Mart.', 1, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(5, 'Chanachur & Namkeen', 'চানাচুর / নিমকি / নমকিন', 'chanachur-namkeen', 'bi-cup-hot', '/assets/images/categories/chanachur.png', 'Chanachur & Namkeen fresh and best quality products at Nayan Mart.', 1, 1, 5, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(6, 'Noodles & Vermicelli', 'নুডলস / সেমাই', 'noodles-vermicelli', 'bi-patch-check', '/assets/images/categories/noodles.png', 'Noodles & Vermicelli fresh and best quality products at Nayan Mart.', 1, 1, 6, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(7, 'Tea & Coffee', 'চা / কফি', 'tea-coffee', 'bi-cup-straw', '/assets/images/categories/tea.png', 'Tea & Coffee fresh and best quality products at Nayan Mart.', 1, 1, 7, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(8, 'Sugar & Salt', 'চিনি / লবণ', 'sugar-salt', 'bi-boxes', '/assets/images/categories/sugar.png', 'Sugar & Salt fresh and best quality products at Nayan Mart.', 1, 1, 8, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(9, 'Baby Food & Care', 'বেবি ফুড', 'baby-food', 'bi-heart', '/assets/images/categories/babyfood.png', 'Baby Food & Care fresh and best quality products at Nayan Mart.', 1, 1, 9, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(10, 'Cold Drinks & Juices', 'কোল্ড ড্রিংকস', 'cold-drinks', 'bi-cup', '/assets/images/categories/drinks.png', 'Cold Drinks & Juices fresh and best quality products at Nayan Mart.', 1, 1, 10, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(11, 'Snacks & Packed Food', 'স্ন্যাকস', 'snacks', 'bi-bag-check', '/assets/images/categories/snacks.png', 'Snacks & Packed Food fresh and best quality products at Nayan Mart.', 1, 1, 11, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(12, 'Daily Essentials', 'দৈনন্দিন প্রয়োজনীয় পণ্য', 'daily-essentials', 'bi-house-heart', '/assets/images/categories/essentials.png', 'Daily Essentials fresh and best quality products at Nayan Mart.', 1, 1, 12, '2026-09-21 13:08:43', '2026-09-21 13:08:43');

-- --------------------------------------------------------
-- Table structure for table `subcategories`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subcategories_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `subcategories`
INSERT INTO `subcategories` (`id`, `category_id`, `name`, `name_bn`, `slug`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Basmati Rice', 'Basmati Rice', 'basmati-rice', NULL, 1, 1, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(2, 1, 'Gobindobhog Rice', 'Gobindobhog Rice', 'gobindobhog-rice', NULL, 1, 2, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(3, 1, 'Miniket Rice', 'Miniket Rice', 'miniket-rice', NULL, 1, 3, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(4, 1, 'Masoor Dal', 'Masoor Dal', 'masoor-dal', NULL, 1, 4, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(5, 1, 'Moong Dal', 'Moong Dal', 'moong-dal', NULL, 1, 5, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(6, 1, 'Chana Dal', 'Chana Dal', 'chana-dal', NULL, 1, 6, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(7, 2, 'Chakki Fresh Atta', 'Chakki Fresh Atta', 'chakki-fresh-atta', NULL, 1, 1, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(8, 2, 'Maida', 'Maida', 'maida', NULL, 1, 2, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(9, 2, 'Roasted Sooji', 'Roasted Sooji', 'roasted-sooji', NULL, 1, 3, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(10, 2, 'Besan', 'Besan', 'besan', NULL, 1, 4, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(11, 3, 'Mustard Oil', 'Mustard Oil', 'mustard-oil', NULL, 1, 1, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(12, 3, 'Sunflower Oil', 'Sunflower Oil', 'sunflower-oil', NULL, 1, 2, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(13, 3, 'Garam Masala', 'Garam Masala', 'garam-masala', NULL, 1, 3, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(14, 3, 'Turmeric Powder', 'Turmeric Powder', 'turmeric-powder', NULL, 1, 4, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(15, 3, 'Chilli Powder', 'Chilli Powder', 'chilli-powder', NULL, 1, 5, '2026-09-21 13:08:42', '2026-09-21 13:08:42'),
(16, 4, 'Marie Gold', 'Marie Gold', 'marie-gold', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(17, 4, 'Cream Biscuits', 'Cream Biscuits', 'cream-biscuits', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(18, 4, 'Digestive Biscuits', 'Digestive Biscuits', 'digestive-biscuits', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(19, 4, 'Cookies', 'Cookies', 'cookies', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(20, 5, 'Mukharochak Chanachur', 'Mukharochak Chanachur', 'mukharochak-chanachur', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(21, 5, 'Bhujia', 'Bhujia', 'bhujia', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(22, 5, 'Nimki', 'Nimki', 'nimki', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(23, 5, 'Salted Peanuts', 'Salted Peanuts', 'salted-peanuts', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(24, 6, 'Instant Noodles', 'Instant Noodles', 'instant-noodles', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(25, 6, 'Hakka Noodles', 'Hakka Noodles', 'hakka-noodles', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(26, 6, 'Roasted Sevai', 'Roasted Sevai', 'roasted-sevai', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(27, 6, 'Macaroni Pasta', 'Macaroni Pasta', 'macaroni-pasta', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(28, 7, 'CTC Tea', 'CTC Tea', 'ctc-tea', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(29, 7, 'Green Tea', 'Green Tea', 'green-tea', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(30, 7, 'Instant Coffee', 'Instant Coffee', 'instant-coffee', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(31, 7, 'Filter Coffee', 'Filter Coffee', 'filter-coffee', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(32, 8, 'Refined Sugar', 'Refined Sugar', 'refined-sugar', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(33, 8, 'Jaggery Gur', 'Jaggery Gur', 'jaggery-gur', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(34, 8, 'Iodized Salt', 'Iodized Salt', 'iodized-salt', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(35, 8, 'Rock Salt', 'Rock Salt', 'rock-salt', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(36, 9, 'Baby Cereal', 'Baby Cereal', 'baby-cereal', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(37, 9, 'Diapers', 'Diapers', 'diapers', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(38, 9, 'Baby Wipes', 'Baby Wipes', 'baby-wipes', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(39, 9, 'Baby Soap', 'Baby Soap', 'baby-soap', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(40, 10, 'Soft Drinks', 'Soft Drinks', 'soft-drinks', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(41, 10, 'Fruit Juices', 'Fruit Juices', 'fruit-juices', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(42, 10, 'Energy Drinks', 'Energy Drinks', 'energy-drinks', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(43, 10, 'Mineral Water', 'Mineral Water', 'mineral-water', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(44, 11, 'Potato Chips', 'Potato Chips', 'potato-chips', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(45, 11, 'Kurkure', 'Kurkure', 'kurkure', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(46, 11, 'Popcorn', 'Popcorn', 'popcorn', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(47, 11, 'Sweets', 'Sweets', 'sweets', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(48, 12, 'Dairy & Eggs', 'Dairy & Eggs', 'dairy-eggs', NULL, 1, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(49, 12, 'Soaps & Shampoos', 'Soaps & Shampoos', 'soaps-shampoos', NULL, 1, 2, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(50, 12, 'Detergent & Cleaners', 'Detergent & Cleaners', 'detergent-cleaners', NULL, 1, 3, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(51, 12, 'Oral Care', 'Oral Care', 'oral-care', NULL, 1, 4, '2026-09-21 13:08:43', '2026-09-21 13:08:43');

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `name_bn` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `brand` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT 0,
  `weight` varchar(255) NOT NULL DEFAULT '500 g',
  `unit` varchar(50) NOT NULL DEFAULT 'g',
  `stock` int(11) NOT NULL DEFAULT 50,
  `min_order_qty` int(11) NOT NULL DEFAULT 1,
  `max_order_qty` int(11) NOT NULL DEFAULT 20,
  `image` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new_arrival` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `rating` decimal(3,1) NOT NULL DEFAULT 4.5,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `name`, `name_bn`, `slug`, `brand`, `sku`, `description`, `specifications`, `mrp`, `selling_price`, `discount_percent`, `weight`, `unit`, `stock`, `min_order_qty`, `max_order_qty`, `image`, `badge`, `is_featured`, `is_best_seller`, `is_new_arrival`, `is_active`, `rating`, `reviews_count`, `created_at`, `updated_at`) VALUES
(1, 12, NULL, 'Mother Dairy Curd', 'মাদার ডেইরি দই', 'mother-dairy-curd', 'Mother Dairy', 'NMCE644D00', 'Mother Dairy Mother Dairy Curd - 400 g / 500 g. Premium quality grocery product from Nayan Mart. Made from pasteurized toned milk, thick, creamy and delicious. Rich in probiotics for good gut health.', 'Brand: Mother Dairy\nQuantity: 500 g\nIngredients: Pasteurized Toned Milk, Active Culture\nStorage: Keep refrigerated at 4°C or below\nShelf Life: 15 Days', 56, 50, 11, '500 g', 'g', 85, 1, 20, '/assets/images/products/mother-dairy-curd.png', '11% OFF', 1, 1, 0, 1, 4, 125, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(2, 12, NULL, 'Amul Butter', 'আমুল মাখন', 'amul-butter', 'Amul', 'NMBF3B1B66', 'Utterly Butterly Delicious Amul Butter! Made with pure fresh cream from cows and buffaloes. Great on toasted bread, in parathas, and cooking.', 'Brand: Amul\nWeight: 100 g\nMilk Fat: 80%\nMoisture: 16%\nSalt: 3%', 58, 52, 10, '100 g', 'g', 120, 1, 20, '/assets/images/products/amul-butter.png', '10% OFF', 1, 1, 0, 1, 3.9, 88, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(3, 12, NULL, 'Paneer Fresh', 'তাজা পনির', 'paneer-fresh', 'Amul', 'NM7DCCB935', 'Soft, moist and fresh dairy paneer cottage cheese. Perfect for matar paneer, shahi paneer, or frying for snacks.', 'Brand: Amul Fresh\nWeight: 200 g\nSource: Cow & Buffalo Milk\nRefrigerate: Yes', 95, 85, 11, '200 g', 'g', 60, 1, 20, '/assets/images/products/paneer-fresh.png', '11% OFF', 1, 0, 1, 1, 4.6, 42, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(4, 12, NULL, 'Fresh Milk Toned', 'তাজা টোনড দুধ', 'fresh-milk-toned', 'Mother Dairy', 'NM4FCE1C5F', 'Fresh pasteurized toned milk with 3.0% Fat and 8.5% SNF. Wholesome and nourishing for the whole family.', 'Volume: 500 ml\nFat: 3.0%\nSNF: 8.5%\nFortified with Vitamin A & D', 28, 25, 11, '500 ml', 'ml', 150, 1, 20, '/assets/images/products/fresh-milk.png', '11% OFF', 1, 1, 0, 1, 4.4, 95, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(5, 12, NULL, 'Amul Cheese Slices', 'আমুল চিজ স্লাইস', 'amul-cheese-slices', 'Amul', 'NME9932C3D', 'Individually wrapped processed cheese slices. Melts deliciously on burgers, sandwiches, and toasts.', 'Slices: 10 Slices\nWeight: 200 g\nBrand: Amul', 145, 129, 11, '200 g', 'g', 70, 1, 20, '/assets/images/products/amul-cheese.png', '11% OFF', 1, 0, 0, 1, 5, 60, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(6, 10, NULL, 'Frooti Mango Drink', 'ফ্রুটি আম জুস', 'frooti-mango-drink', 'Parle Agro', 'NM7AFD4953', 'Real mango pulp juice drink with natural sweetness. India\'s favorite mango refreshment.', 'Volume: 600 ml\nIngredients: Mango pulp, water, sugar', 45, 38, 15, '600 ml', 'ml', 90, 1, 20, '/assets/images/products/frooti.png', '15% OFF', 1, 1, 0, 1, 4.3, 54, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(7, 10, NULL, 'Real Mixed Fruit Juice', 'রিয়েল মিক্সড ফ্রুট জুস', 'real-mixed-fruit-juice', 'Real', 'NMA641183C', 'Loaded with goodness of 9 chosen fruits. No added preservatives. Refreshing taste packed with vitamins.', 'Volume: 1 Litre\nFruits: Apple, Mango, Guava, Banana, Orange, Apricot, Peach, Pineapple, Passion Fruit', 130, 110, 15, '1 L', 'L', 45, 1, 20, '/assets/images/products/real-juice.png', '15% OFF', 1, 0, 1, 1, 4.5, 38, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(8, 10, NULL, 'Limca Lemon Drink', 'লিমকা লেমন ড্রিংক', 'limca-lemon-drink', 'Coca Cola', 'NM28A7F3D0', 'Crisp, fizzy lime and lemon refreshment that quenches your thirst immediately.', 'Volume: 750 ml\nCarbonated soft drink', 40, 38, 5, '750 ml', 'ml', 80, 1, 20, '/assets/images/products/limca.png', '5% OFF', 1, 0, 0, 1, 4.2, 29, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(9, 10, NULL, 'Pepsi Soft Drink', 'পেপসি সফট ড্রিংক', 'pepsi-soft-drink', 'PepsiCo', 'NM71796FF0', 'Swag se chug! Bold, refreshing cola taste served chilled.', 'Volume: 750 ml\nPackaging: Pet Bottle', 40, 38, 5, '750 ml', 'ml', 110, 1, 20, '/assets/images/products/pepsi.png', '5% OFF', 1, 1, 0, 1, 4.3, 48, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(10, 12, NULL, 'Eggs Farm Fresh 6 Pcs', 'তাজা দেশি ডিম ৬ পিস', 'eggs-farm-fresh-6-pcs', 'Farm Fresh', 'NM6311D384', 'Grade-A farm fresh white eggs packed safely in protective carton. Rich source of protein.', 'Pack: 6 Eggs\nSource: Certified Poultry Farms', 48, 42, 12, '6 Pcs', 'pcs', 200, 1, 20, '/assets/images/products/eggs.png', '12% OFF', 1, 1, 0, 1, 4.6, 112, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(11, 12, NULL, 'Colgate Strong Teeth Toothpaste', 'কোলগেট টুথপেস্ট', 'colgate-strong-teeth-toothpaste', 'Colgate', 'NM3F6643B7', 'Colgate Strong Teeth with Amino Shakti formula strengthens teeth from within. Fights cavities all day.', 'Weight: 150 g\nFeature: Calcium Boost formula', 118, 105, 11, '150 g', 'g', 95, 1, 20, '/assets/images/products/colgate.png', '11% OFF', 0, 1, 0, 1, 4.7, 74, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(12, 4, NULL, 'Parle-G Gold Biscuits', 'পারলে-জি গোল্ড বিস্কুট', 'parle-g-gold-biscuits', 'Parle', 'NM86987D27', 'Bigger, crispier and more golden Parle-G biscuits. Great with hot tea.', 'Weight: 1 kg\nContains Wheat, Milk, Glucose', 50, 45, 10, '1 kg', 'kg', 140, 1, 20, '/assets/images/products/parle-g.png', '10% OFF', 0, 1, 0, 1, 4.5, 130, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(13, 12, NULL, 'Surf Excel Detergent Powder', 'সার্ফ এক্সেল ডিটারজেন্ট', 'surf-excel-detergent-powder', 'Surf Excel', 'NMDE763D4E', 'Surf Excel Easy Wash removes tough stains like mud, ink, and oil without harming clothes.', 'Weight: 1 kg\nBrand: Unilever', 145, 130, 10, '1 kg', 'kg', 85, 1, 20, '/assets/images/products/surf-excel.png', '10% OFF', 0, 1, 0, 1, 4.8, 67, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(14, 6, NULL, 'Maggi 2-Minute Noodles 4-Pack', 'ম্যাগি ২-মিনিট নুডলস', 'maggi-2-minute-noodles-4-pack', 'Maggi', 'NMC5747A7E', 'Favorite masala noodles made with authentic Indian spices. Ready in just 2 minutes.', 'Pack of: 4 individual cakes (70g each)\nBrand: Nestle Maggi', 56, 48, 14, '280 g', 'g', 130, 1, 20, '/assets/images/products/maggi.png', '14% OFF', 0, 1, 0, 1, 4.8, 210, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(15, 3, NULL, 'Fortune Sunlite Refined Sunflower Oil', 'ফরচুন সূর্যমুখী তেল', 'fortune-sunlite-sunflower-oil', 'Fortune', 'NM237A9283', 'Light, healthy and cholesterol-friendly cooking oil enriched with Vitamins A and D.', 'Volume: 1 Litre\nPouch packaging\nLight on digestion', 155, 138, 11, '1 L', 'L', 100, 1, 20, '/assets/images/products/fortune-oil.png', '11% OFF', 0, 1, 0, 1, 4.7, 84, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(16, 9, NULL, 'Pampers Baby Dry Diaper Pants', 'প্যাম্পার্স ডায়াপার প্যান্টস', 'pampers-baby-dry-diaper-pants', 'Pampers', 'NM0AA057D7', 'Magic Gel technology locks wetness for up to 12 hours. Soft waistband with anti-rash lotion.', 'Size: Small (4-8 kg)\nCount: 22 Diapers\nBrand: Procter & Gamble', 350, 319, 9, 'Small 22 pcs', 'pcs', 40, 1, 20, '/assets/images/products/pampers.png', '9% OFF', 0, 1, 0, 1, 4.8, 52, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(17, 7, NULL, 'Tata Tea Gold Leaf Tea', 'টাটা টি গোল্ড পাতা চা', 'tata-tea-gold-leaf-tea', 'Tata Tea', 'NM6BEC8E46', 'A unique blend of fine CTC tea along with gently rolled 15% long leaves for rich aroma and brisk taste.', 'Weight: 250 g\nOrigin: Assam Tea Gardens', 135, 120, 11, '250 g', 'g', 95, 1, 20, '/assets/images/products/tata-tea.png', '11% OFF', 0, 1, 0, 1, 4.6, 64, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(18, 8, NULL, 'Madhur Pure & Hygienic Sugar', 'মধুর খাঁটি চিনি', 'madhur-pure-hygienic-sugar', 'Madhur', 'NMFB648DD1', 'Sulphur-free, untouched by hands, sparkling white sugar crystals.', 'Weight: 1 kg\n100% Vegetarian\nSulphur Free', 54, 49, 9, '1 kg', 'kg', 250, 1, 20, '/assets/images/products/sugar.png', '9% OFF', 0, 1, 0, 1, 4.9, 108, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(19, 2, NULL, 'Aashirvaad Superior MP Atta', 'আশীর্বাদ এম পি আটা', 'aashirvaad-superior-mp-atta', 'Aashirvaad', 'NMA44A8381', 'Made from heavy grains with golden sheen sourced from fields of Madhya Pradesh. Makes soft rotis that stay fresh for longer.', 'Weight: 5 kg\n100% Whole Wheat\n0% Maida', 260, 230, 12, '5 kg', 'kg', 110, 1, 20, '/assets/images/products/aashirvaad-atta.png', '12% OFF', 0, 1, 0, 1, 4.8, 142, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(20, 3, NULL, 'Aashirvaad Shahi Garam Masala', 'আশীর্বাদ শাহী গরম মশলা', 'aashirvaad-shahi-garam-masala', 'Aashirvaad', 'NM3FA30B24', 'Aashirvaad Shahi Garam Masala is a balanced blend of aromatic whole spices that gives rich restaurant-style flavor to everyday curries.', 'Brand: Aashirvaad\nWeight: 100 g\nIngredients: Coriander, Cumin, Black Pepper, Cinnamon, Cardamom, Clove, Nutmeg', 70, 62, 11, '100 g', 'g', 75, 1, 20, '/assets/images/products/garam-masala.png', '11% OFF', 0, 0, 1, 1, 4.6, 41, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(21, 7, NULL, 'Tang Instant Orange Drink', 'ট্যাং অরেঞ্জ ড্রিংক', 'tang-instant-orange-drink', 'Tang', 'NMF01525F0', 'Instant refreshing fruit powder loaded with Vitamin C and iron. Just mix with chilled water.', 'Weight: 500 g\nFlavor: Juicy Orange', 110, 99, 10, '500 g', 'g', 65, 1, 20, '/assets/images/products/tang.png', '10% OFF', 0, 0, 1, 1, 4.5, 33, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(22, 12, NULL, 'Gillette Mach3 Razor', 'জিলেট রেজোর', 'gillette-mach3-razor', 'Gillette', 'NM43E58E9A', '3 high-definition blades with lubrication strip for a smooth, irritation-free glide.', 'Blades: 3\nBrand: P&G Gillette', 240, 219, 9, '1 Unit', 'pcs', 50, 1, 20, '/assets/images/products/gillette.png', '9% OFF', 0, 0, 1, 1, 4.9, 45, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(23, 12, NULL, 'Nivea Men Deep Clean Face Wash', 'নিভিয়া ফেস ওয়াশ', 'nivea-men-deep-clean-face-wash', 'Nivea', 'NMBC3A6002', 'Black charcoal deep cleansing formula purifies pores and controls excess oil without drying.', 'Volume: 100 g\nWith Black Carbon', 165, 145, 12, '100 g', 'g', 70, 1, 20, '/assets/images/products/nivea.png', '12% OFF', 0, 0, 1, 1, 4.7, 58, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(24, 12, NULL, 'Domex Disinfectant Bleach', 'ডমেক্স ফ্লোর ক্লিনার', 'domex-disinfectant-bleach', 'Domex', 'NM48D55132', 'Kills 99.9% germs and viruses. Provides power disinfectant action for bathrooms and floor.', 'Volume: 500 ml\nBrand: Unilever', 125, 110, 12, '500 ml', 'ml', 60, 1, 20, '/assets/images/products/domex.png', '12% OFF', 0, 0, 1, 1, 4.4, 26, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(25, 9, NULL, 'Lactogen 1 Infant Formula', 'ল্যাকটোজেন ফর্মুলা দুধ', 'lactogen-1-infant-formula', 'Nestle', 'NMCD9114FA', 'Spray dried infant milk formula with probiotic L. reuteri for babies up to 6 months.', 'Weight: 400 g Bag-in-box\nStage: 1 (Up to 6 Months)', 415, 385, 7, '400 g', 'g', 35, 1, 20, '/assets/images/products/lactogen.png', '7% OFF', 0, 0, 1, 1, 4.8, 40, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(26, 5, NULL, 'Haldiram All In One Namkeen', 'হলদিরাম অল ইন ওয়ান চানাচুর', 'haldiram-all-in-one-namkeen', 'Haldirams', 'NM5B8A284E', 'Crunchy mixture of chickpea flour noodles, lentils, nuts, and spices. Delightful tea-time snack.', 'Weight: 200 g\nBrand: Haldirams', 50, 45, 10, '200 g', 'g', 110, 1, 20, '/assets/images/products/haldiram.png', '10% OFF', 0, 0, 1, 1, 4.6, 53, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `product_images`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `product_variants`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `weight` varchar(255) NOT NULL,
  `unit` varchar(50) NOT NULL DEFAULT 'g',
  `mrp` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 50,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `product_variants`
INSERT INTO `product_variants` (`id`, `product_id`, `weight`, `unit`, `mrp`, `selling_price`, `stock`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, '100 g', 'g', 15, 12, 40, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(2, 1, '200 g', 'g', 28, 25, 50, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(3, 1, '500 g', 'g', 56, 50, 85, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(4, 1, '1 Kg', 'g', 110, 98, 30, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(5, 1, '2 Kg', 'g', 210, 190, 15, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(6, 1, '3 Kg', 'g', 310, 280, 10, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(7, 2, '100 g', 'g', 58, 52, 120, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(8, 2, '500 g', 'g', 285, 265, 45, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(9, 3, '200 g', 'g', 95, 85, 60, 1, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(10, 3, '500 g', 'g', 230, 205, 25, 0, '2026-09-21 13:08:43', '2026-09-21 13:08:43'),
(11, 15, '1 L', 'g', 155, 138, 100, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(12, 15, '5 L Jar', 'g', 760, 670, 30, 0, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(13, 19, '1 kg', 'g', 55, 49, 80, 0, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(14, 19, '5 kg', 'g', 260, 230, 110, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(15, 19, '10 kg', 'g', 510, 450, 50, 0, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL UNIQUE,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `house_flat` varchar(255) DEFAULT NULL,
  `street_area` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL DEFAULT 'Kolkata',
  `state` varchar(255) NOT NULL DEFAULT 'West Bengal',
  `pincode` varchar(10) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `address_type` varchar(50) NOT NULL DEFAULT 'Home',
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'placed',
  `notes` text DEFAULT NULL,
  `expected_delivery_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `orders`
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `customer_name`, `customer_phone`, `customer_email`, `house_flat`, `street_area`, `city`, `state`, `pincode`, `landmark`, `address_type`, `subtotal`, `discount`, `coupon_code`, `delivery_charge`, `total`, `payment_method`, `payment_status`, `transaction_id`, `order_status`, `notes`, `expected_delivery_date`, `created_at`, `updated_at`) VALUES
(1, 'NM94821670', 2, 'Mafiur Islam', 9382559266, 'skrousonali2024@gmail.com', 'Saitul chicken shop', 'Ashoknagar, kalyangarh, bhatchhala', 'Delhi', 'West Bengal', 743263, 'Near Rail Gate', 'Home', 112, 0, NULL, 0, 112, 'cod', 'pending', 'TR747B1AD5', 'placed', 'Deliver before 7 PM please.', '2026-09-25 13:08:44', '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `order_items`
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_image`, `weight`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Mother Dairy Curd', '/assets/images/products/mother-dairy-curd.png', '500 g', 50, 1, 50, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(2, 1, 20, 'Aashirvaad Shahi Garam Masala', '/assets/images/products/garam-masala.png', '100 g', 62, 1, 62, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `order_trackings`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `tracked_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_trackings_order_id_foreign` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `order_trackings`
INSERT INTO `order_trackings` (`id`, `order_id`, `status`, `title`, `description`, `tracked_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'placed', 'Order Placed', 'Your order has been received and is waiting for confirmation.', '2026-09-21 12:53:44', '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `coupons`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL UNIQUE,
  `discount_type` varchar(50) NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount_amount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `start_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `coupons`
INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount_amount`, `usage_limit`, `used_count`, `start_date`, `expiry_date`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'NAYAN10', 'percent', 10, 249, 100, 500, 14, NULL, '2027-03-21 13:08:44', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(2, 'FREESHIP', 'fixed', 30, 199, NULL, 1000, 28, NULL, '2027-03-21 13:08:44', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(3, 'FESTIVAL50', 'fixed', 50, 499, NULL, 300, 6, NULL, '2026-12-21 13:08:44', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `banners`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `tagline_bn` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(255) NOT NULL DEFAULT 'Shop Now',
  `button_link` varchar(255) NOT NULL DEFAULT '/shop',
  `banner_type` varchar(50) NOT NULL DEFAULT 'hero_slider',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `banners`
INSERT INTO `banners` (`id`, `title`, `subtitle`, `tagline_bn`, `badge`, `image`, `button_text`, `button_link`, `banner_type`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Groceries Delivered at Your Doorstep', 'Quality Products • Best Price • Fast Delivery', 'আপনার ঘরের বাজার, এখন হাতের মুঠোয়', 'Welcome to Nayan Mart', '/assets/images/banners/hero-basket.png', 'Shop Now', '/shop', 'hero_slider', 1, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(2, 'Special Discount 10% OFF', 'On Fresh Vegetables & Dairy', 'দৈনন্দিন কেনাকাটায় ১০% ছাড়', '10% OFF', '/assets/images/banners/promo-1.png', 'Shop Now', '/shop?category=daily-essentials', 'promo_card', 1, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(3, 'Free Delivery', 'On Orders Above ₹249', '₹২৪৯ এর উপরে অর্ডারে ফ্রি ডেলিভারি', 'FREE DELIVERY', '/assets/images/banners/promo-2.png', 'Order Now', '/shop', 'promo_card', 2, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(4, 'Big Savings', 'On Monthly Grocery Pack 25% OFF', 'মাসিক বাজারের জন্য বিশাল সঞ্চয়', '25% OFF', '/assets/images/banners/promo-3.png', 'Shop Now', '/shop?category=rice-and-pulses', 'promo_card', 3, 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `wishlists`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `reviews`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `reviews`
INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `customer_name`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Subhashree Roy', 5, 'Very fresh and thick curd. Best quality delivered fast by Nayan Mart!', 1, '2026-09-21 13:08:45', '2026-09-21 13:08:45'),
(2, 1, NULL, 'Tanmoy Das', 4, 'Good packaging, ice cool even in afternoon delivery.', 1, '2026-09-21 13:08:45', '2026-09-21 13:08:45');

-- --------------------------------------------------------
-- Table structure for table `delivery_pincodes`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `delivery_pincodes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pincode` varchar(10) NOT NULL UNIQUE,
  `city` varchar(255) NOT NULL DEFAULT 'Kolkata',
  `district` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL DEFAULT 'West Bengal',
  `delivery_charge` decimal(8,2) NOT NULL DEFAULT 30.00,
  `min_free_delivery` decimal(8,2) NOT NULL DEFAULT 249.00,
  `estimated_time` varchar(255) NOT NULL DEFAULT 'Same Day / 24 Hours',
  `is_deliverable` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `delivery_pincodes`
INSERT INTO `delivery_pincodes` (`id`, `pincode`, `city`, `district`, `state`, `delivery_charge`, `min_free_delivery`, `estimated_time`, `is_deliverable`, `created_at`, `updated_at`) VALUES
(1, 743263, 'Ashoknagar', 'North 24 Parganas', 'West Bengal', 0, 249, 'Same Day (Within 4-6 Hours)', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(2, 700001, 'Kolkata GPO', 'Kolkata', 'West Bengal', 30, 249, '24 Hours Delivery', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(3, 700091, 'Salt Lake', 'North 24 Parganas', 'West Bengal', 30, 249, 'Same Day Delivery', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(4, 700156, 'New Town', 'North 24 Parganas', 'West Bengal', 30, 249, 'Same Day Delivery', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(5, 743272, 'Habra', 'North 24 Parganas', 'West Bengal', 0, 249, 'Within 2-4 Hours', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44'),
(6, 110001, 'New Delhi', 'Central Delhi', 'Delhi', 40, 249, '2-3 Business Days', 1, '2026-09-21 13:08:44', '2026-09-21 13:08:44');

-- --------------------------------------------------------
-- Table structure for table `inquiries`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `settings`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL UNIQUE,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Nayan Mart', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(2, 'tagline', 'আপনার ঘরের বাজার, এখন হাতের মুঠোয়', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(3, 'sub_tagline', 'Quality Products • Best Price • Fast Delivery', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(4, 'phone', 7550807912, '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(5, 'email', 'skrousonali2024@gmail.com', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(6, 'address', 'Ashoknagar, Kalyangarh, North 24 Parganas, West Bengal, 743263', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(7, 'free_shipping_threshold', 249, '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(8, 'standard_delivery_fee', 30, '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(9, 'upi_id', '7550807912@paytm', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(10, 'upi_name', 'NAYAN MART', '2026-09-21 13:08:41', '2026-09-21 13:08:41'),
(11, 'currency_symbol', '₹', '2026-09-21 13:08:41', '2026-09-21 13:08:41');

COMMIT;
