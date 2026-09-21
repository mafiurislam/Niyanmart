<?php

/**
 * NAYAN MART - Hostinger Shared Hosting Bridge
 * 
 * If your hosting root points directly to this root folder (e.g. public_html),
 * this file bridges directly into the Laravel public/ front controller.
 */

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Illuminate\Http\Request::capture());
