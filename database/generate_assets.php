<?php

// Asset generator for Nayan Mart using PHP GD

function createCategoryIcon($filePath, $bgColor, $fgColor, $text, $iconChar = '🛒') {
    $w = 160;
    $h = 160;
    $im = imagecreatetruecolor($w, $h);
    imagesavealpha($im, true);
    $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
    imagefill($im, 0, 0, $trans);

    // Outer soft circular background
    $bg = imagecolorallocate($im, $bgColor[0], $bgColor[1], $bgColor[2]);
    imagefilledellipse($im, 80, 80, 140, 140, $bg);

    // Inner subtle ring
    $ring = imagecolorallocate($im, max(0, $bgColor[0] - 20), max(0, $bgColor[1] - 20), max(0, $bgColor[2] - 20));
    imageellipse($im, 80, 80, 132, 132, $ring);

    // Icon text representation
    $fg = imagecolorallocate($im, $fgColor[0], $fgColor[1], $fgColor[2]);
    $font = 5; // built-in font
    $tw = imagefontwidth($font) * strlen($text);
    $th = imagefontheight($font);
    imagestring($im, $font, (int)((160 - $tw) / 2), 70, $text, $fg);

    imagepng($im, $filePath);
    imagedestroy($im);
}

function createProductImage($filePath, $brand, $name, $variant, $themeColor) {
    $w = 400;
    $h = 400;
    $im = imagecreatetruecolor($w, $h);

    // Background: clean crisp studio off-white/subtle radial
    $bg = imagecolorallocate($im, 252, 253, 254);
    imagefilledrectangle($im, 0, 0, $w, $h, $bg);

    // Card border subtle
    $borderColor = imagecolorallocate($im, 241, 245, 249);
    imagerectangle($im, 0, 0, $w - 1, $h - 1, $borderColor);

    // Soft shadow below product pack
    $shadowColor = imagecolorallocate($im, 226, 232, 240);
    imagefilledellipse($im, 200, 340, 240, 40, $shadowColor);

    // Product Container/Pack shape
    $primaryColor = imagecolorallocate($im, $themeColor[0], $themeColor[1], $themeColor[2]);
    $white = imagecolorallocate($im, 255, 255, 255);
    $darkText = imagecolorallocate($im, 30, 41, 59);
    $accentColor = imagecolorallocate($im, 245, 158, 11); // Amber
    $green = imagecolorallocate($im, 15, 122, 63);

    // Pack box
    imagefilledrectangle($im, 90, 80, 310, 310, $white);
    imagerectangle($im, 90, 80, 310, 310, $primaryColor);
    imagerectangle($im, 91, 81, 309, 309, $primaryColor);

    // Header strip on pack
    imagefilledrectangle($im, 90, 80, 310, 140, $primaryColor);

    // Brand on header
    $font = 5;
    $bw = imagefontwidth($font) * strlen($brand);
    imagestring($im, $font, (int)((400 - $bw) / 2), 102, strtoupper($brand), $white);

    // Product Title
    $fontTitle = 5;
    $words = explode(' ', $name);
    $line1 = implode(' ', array_slice($words, 0, 2));
    $line2 = implode(' ', array_slice($words, 2));
    
    $tw1 = imagefontwidth($fontTitle) * strlen($line1);
    imagestring($im, $fontTitle, (int)((400 - $tw1) / 2), 170, $line1, $darkText);
    
    if (!empty($line2)) {
        $tw2 = imagefontwidth($fontTitle) * strlen($line2);
        imagestring($im, $fontTitle, (int)((400 - $tw2) / 2), 195, $line2, $darkText);
    }

    // Weight badge
    imagefilledrectangle($im, 140, 230, 260, 260, $primaryColor);
    $vw = imagefontwidth(4) * strlen($variant);
    imagestring($im, 4, (int)((400 - $vw) / 2), 237, $variant, $white);

    // Green Veg Mark / Quality Symbol
    imagefilledrectangle($im, 110, 275, 130, 295, $white);
    imagerectangle($im, 110, 275, 130, 295, $green);
    imagefilledellipse($im, 120, 285, 10, 10, $green);

    // 100% Original badge
    imagestring($im, 2, 140, 280, "100% QUALITY", $darkText);

    imagepng($im, $filePath);
    imagedestroy($im);
}

function createPromoBanner($filePath, $title, $sub, $badge, $bgColor) {
    $w = 600;
    $h = 320;
    $im = imagecreatetruecolor($w, $h);

    $bg = imagecolorallocate($im, $bgColor[0], $bgColor[1], $bgColor[2]);
    imagefilledrectangle($im, 0, 0, $w, $h, $bg);

    $white = imagecolorallocate($im, 255, 255, 255);
    $yellow = imagecolorallocate($im, 254, 240, 138);
    $dark = imagecolorallocate($im, 15, 23, 42);

    // Geometric decoration
    $circleBg = imagecolorallocatealpha($im, 255, 255, 255, 105);
    imagefilledellipse($im, 500, 160, 240, 240, $circleBg);
    imagefilledellipse($im, 500, 160, 180, 180, $circleBg);

    // Badge pill
    $badgeBg = imagecolorallocate($im, 245, 158, 11);
    imagefilledrectangle($im, 40, 40, 200, 70, $badgeBg);
    imagestring($im, 4, 55, 47, $badge, $white);

    // Title
    imagestring($im, 5, 40, 100, $title, $white);
    imagestring($im, 4, 40, 130, $sub, $yellow);

    // Button
    imagefilledrectangle($im, 40, 190, 180, 230, $white);
    imagestring($im, 4, 60, 202, "SHOP NOW ->", $dark);

    imagepng($im, $filePath);
    imagedestroy($im);
}

// Generate Categories
$categories = [
    'rice.png' => ['bg' => [236, 253, 245], 'fg' => [15, 122, 63], 'text' => 'CHAL & DAL'],
    'flour.png' => ['bg' => [254, 243, 199], 'fg' => [180, 83, 9], 'text' => 'ATTA & SUJI'],
    'oil.png' => ['bg' => [254, 242, 242], 'fg' => [185, 28, 28], 'text' => 'OIL & SPICES'],
    'biscuit.png' => ['bg' => [255, 237, 213], 'fg' => [194, 65, 12], 'text' => 'BISCUITS'],
    'chanachur.png' => ['bg' => [254, 249, 195], 'fg' => [161, 98, 7], 'text' => 'CHANACHUR'],
    'noodles.png' => ['bg' => [239, 246, 255], 'fg' => [29, 78, 216], 'text' => 'NOODLES'],
    'tea.png' => ['bg' => [240, 253, 244], 'fg' => [21, 128, 61], 'text' => 'TEA & COFFEE'],
    'sugar.png' => ['bg' => [243, 244, 246], 'fg' => [75, 85, 99], 'text' => 'SUGAR & SALT'],
    'babyfood.png' => ['bg' => [253, 242, 248], 'fg' => [190, 24, 93], 'text' => 'BABY FOOD'],
    'drinks.png' => ['bg' => [240, 249, 255], 'fg' => [3, 105, 161], 'text' => 'COLD DRINKS'],
    'snacks.png' => ['bg' => [254, 243, 199], 'fg' => [217, 119, 6], 'text' => 'SNACKS'],
    'essentials.png' => ['bg' => [236, 253, 245], 'fg' => [15, 122, 63], 'text' => 'DAILY CARE'],
];

foreach ($categories as $file => $cfg) {
    createCategoryIcon(__DIR__ . '/../public/assets/images/categories/' . $file, $cfg['bg'], $cfg['fg'], $cfg['text']);
}

// Generate Product Packshots
$products = [
    'mother-dairy-curd.png' => ['Mother Dairy', 'Curd Dahi', '500 g', [37, 99, 235]],
    'amul-butter.png' => ['Amul', 'Butter Salted', '100 g', [234, 179, 8]],
    'paneer-fresh.png' => ['Amul', 'Fresh Paneer', '200 g', [16, 185, 129]],
    'fresh-milk.png' => ['Mother Dairy', 'Toned Milk', '500 ml', [59, 130, 246]],
    'amul-cheese.png' => ['Amul', 'Cheese Slices', '200 g', [245, 158, 11]],
    'frooti.png' => ['Parle Agro', 'Frooti Mango', '600 ml', [234, 179, 8]],
    'real-juice.png' => ['Real', 'Mixed Fruit', '1 Litre', [225, 29, 72]],
    'limca.png' => ['Coca Cola', 'Limca Lemon', '750 ml', [16, 185, 129]],
    'pepsi.png' => ['PepsiCo', 'Pepsi Cola', '750 ml', [30, 58, 138]],
    'eggs.png' => ['Farm Fresh', 'White Eggs', '6 Pcs', [148, 163, 184]],
    'colgate.png' => ['Colgate', 'Strong Teeth', '150 g', [220, 38, 38]],
    'parle-g.png' => ['Parle', 'Gold Biscuits', '1 kg', [202, 138, 4]],
    'surf-excel.png' => ['Surf Excel', 'Easy Wash', '1 kg', [37, 99, 235]],
    'maggi.png' => ['Maggi', '2-Min Noodles', '280 g', [220, 38, 38]],
    'fortune-oil.png' => ['Fortune', 'Sunflower Oil', '1 Litre', [202, 138, 4]],
    'pampers.png' => ['Pampers', 'Diaper Pants', 'Small 22', [13, 148, 136]],
    'tata-tea.png' => ['Tata Tea', 'Gold Leaf Tea', '250 g', [180, 83, 9]],
    'sugar.png' => ['Madhur', 'Pure Sugar', '1 kg', [2, 132, 199]],
    'aashirvaad-atta.png' => ['Aashirvaad', 'MP Sharbati Atta', '5 kg', [180, 83, 9]],
    'garam-masala.png' => ['Aashirvaad', 'Shahi Garam Masala', '100 g', [153, 27, 27]],
    'tang.png' => ['Tang', 'Instant Orange', '500 g', [234, 88, 12]],
    'gillette.png' => ['Gillette', 'Mach3 Razor', '1 Unit', [30, 41, 59]],
    'nivea.png' => ['Nivea Men', 'Face Wash', '100 g', [30, 58, 138]],
    'domex.png' => ['Domex', 'Floor Cleaner', '500 ml', [79, 70, 229]],
    'lactogen.png' => ['Nestle', 'Lactogen 1', '400 g', [59, 130, 246]],
    'haldiram.png' => ['Haldiram', 'All In One', '200 g', [217, 119, 6]],
];

foreach ($products as $file => $cfg) {
    createProductImage(__DIR__ . '/../public/assets/images/products/' . $file, $cfg[0], $cfg[1], $cfg[2], $cfg[3]);
}

// Generate Promo Banners
createPromoBanner(__DIR__ . '/../public/assets/images/banners/promo-1.png', 'Special Discount 10% OFF', 'Fresh Groceries & Essentials', 'LIMITED OFFER', [15, 118, 110]);
createPromoBanner(__DIR__ . '/../public/assets/images/banners/promo-2.png', 'FREE Delivery on 249+', 'Speedy Delivery In 24 Hours', 'NO CHARGE', [16, 122, 63]);
createPromoBanner(__DIR__ . '/../public/assets/images/banners/promo-3.png', 'Big Savings on Monthly Pack', 'Save up to 25% on Pulses & Flours', 'MEGA PACK', [194, 65, 12]);

echo "All images generated successfully.\n";
