# Hostinger PHP Hosting Deployment Guide (Laravel + SQLite)

This application (**Nayan Mart**) is built with **Laravel 11** and configured to run exclusively on **SQLite**. It does **NOT** require MySQL, MariaDB, or any external database server.

---

## 1. Prerequisites on Hostinger

1. **PHP Version**: Ensure PHP 8.2 or PHP 8.3 is selected in your Hostinger hPanel:
   - Navigate to **hPanel** -> **Websites** -> **Manage** -> **Advanced** -> **PHP Configuration**.
   - Select **PHP 8.2** or **PHP 8.3**.
2. **PHP SQLite Extension**:
   - In **PHP Configuration** -> **PHP Extensions**, ensure `pdo_sqlite` and `sqlite3` are checked/enabled (enabled by default on Hostinger).

---

## 2. Uploading the Project

You can upload the project using Git, FTP/SFTP (FileZilla), or the Hostinger File Manager:

1. Compress the project folder (excluding `/vendor` and `/node_modules`).
2. Upload the zip file to your domain root (e.g. `/home/u123456789/domains/yourdomain.com/public_html` or a subfolder).
3. Extract the files.
4. If you uploaded without `vendor/`, connect via SSH and run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

---

## 3. SQLite Database & Folder Permissions (CRITICAL)

On Linux/Hostinger, SQLite creates temporary lock and journal files (`database.sqlite-journal` or `database.sqlite-wal`) inside the `database/` folder during write operations (e.g., placing orders, user login, adding products).

For the website to work without errors, the web server user must have **write permissions** on both the database directory and the SQLite database file:

### Via Hostinger SSH Terminal:
```bash
# 1. Set database folder and file permissions
chmod 775 database
chmod 664 database/database.sqlite

# 2. Set storage and cache permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

*(If your Hostinger account runs with restricted user group isolation and you encounter any permission denial, run `chmod 777 database`, `chmod 666 database/database.sqlite`, and `chmod -R 777 storage bootstrap/cache`)*.

---

## 4. Environment Configuration (`.env`)

In your Hostinger File Manager:
1. Copy `.env.example` to `.env` (or edit the existing `.env`).
2. Verify that **SQLite** is the database connection:
   ```env
   APP_NAME="Nayan Mart"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com

   DB_CONNECTION=sqlite
   # Leave DB_DATABASE empty to use the default database/database.sqlite
   # Or provide absolute path if using a custom directory:
   # DB_DATABASE=/home/u123456789/domains/yourdomain.com/database/database.sqlite
   ```
3. Generate or verify your `APP_KEY`:
   ```bash
   php artisan key:generate --force
   ```

---

## 5. Running Database Migrations & Optimization

Run these commands in Hostinger SSH Terminal:

```bash
# 1. Run migrations
php artisan migrate --force

# 2. Create storage symlink for uploaded images
php artisan storage:link

# 3. Optimize configuration and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 6. Security (Database Protection)

The `database/` folder includes a `.htaccess` file:
```apache
<IfModule authz_core_module>
    Require all denied
</IfModule>
<IfModule !authz_core_module>
    Deny from all
</IfModule>
```
This ensures direct web access to `database.sqlite` via the browser is strictly blocked.

---

## 7. Default Accounts

* **Admin Portal**: `https://yourdomain.com/admin`
  * **Email**: `admin@nayanmart.com`
  * **Password**: `admin123`

* **Test Customer**: `https://yourdomain.com/login`
  * **Email**: `skrousonali2024@gmail.com`
  * **Password**: `password123`
