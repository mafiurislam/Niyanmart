# Nayan Mart (নয়ন মার্ট) - Online Grocery & Daily Essentials

> **আপনার ঘরের বাজার, এখন হাতের মুঠোয়**  
> Fast, reliable hyper-local e-commerce store built with **Laravel 11** and powered exclusively by **SQLite**.

---

## 🚀 Key Highlights & Architecture

- **Database Engine**: **100% SQLite** (`database/database.sqlite`).
- **No External Database Server Required**: No MySQL, MariaDB, PostgreSQL, or external DB setup needed.
- **Hostinger Compatible**: Fully compatible with Hostinger PHP Web Hosting.
- **Full E-Commerce Suite**:
  - Customer & Administrator Authentication
  - Product Catalog with Variants, Images, Badges, and Stock Control
  - Multi-level Categories & Subcategories
  - Session Cart with Instant Item Updates
  - Coupons & Discount Rules (Percent & Fixed Amount)
  - Seamless Checkout (Cash on Delivery & Razorpay / UPI ready)
  - Real-time Order Tracking (Placed, Confirmed, Packed, Out for Delivery, Delivered)
  - Delivery PIN Code Checker with customizable delivery zones & charges
  - Product Reviews & Ratings calculation
  - Customer Wishlist
  - Dynamic Banners & Promotional Sliders
  - Full Admin Dashboard with live stats, orders, customers, delivery zones, and store settings

---

## 🛠️ Local Development Setup

1. **Clone & Install Dependencies**:
   ```bash
   composer install
   ```

2. **Environment Configuration**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: In `.env`, `DB_CONNECTION=sqlite` is already configured.*

3. **Database Migration & Seeding**:
   The project includes a ready-to-use seeded SQLite database at `database/database.sqlite`. If you need to re-run migrations from scratch:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Run Local Server**:
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

5. **Run Automated Tests**:
   ```bash
   php artisan test
   ```

---

## 🌐 Hostinger Deployment

See [HOSTINGER_DEPLOYMENT.md](file:///c:/Users/SIMRAN/OneDrive/Desktop/Nayanmart/HOSTINGER_DEPLOYMENT.md) for full instructions.

### Quick Deployment Summary:
1. **Upload** files to Hostinger `public_html` or domain directory.
2. **File Permissions (Crucial for SQLite write operations)**:
   ```bash
   chmod 775 database
   chmod 664 database/database.sqlite
   chmod -R 775 storage bootstrap/cache
   ```
3. **Run Migrations & Caches**:
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🔐 Default Credentials

| Role | Email | Password | Access URL |
|------|-------|----------|------------|
| **Admin** | `admin@nayanmart.com` | `admin123` | `/admin` |
| **Customer** | `skrousonali2024@gmail.com` | `password123` | `/login` |

---

## 📄 License
The application is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
