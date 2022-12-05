<?php
# Include config file
require_once __DIR__ . '/config.php';

# Load installation page if site is not installed
if (APP_INSTALLED == false) {
    require __DIR__ . '/setup.php';
    exit;
}
?>

<!doctype html><html lang="en"><head><meta charset="utf-8"/><link rel="icon" href="/public/favicon.png"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Web site created using create-react-app"/><link rel="apple-touch-icon" href="/public/icon.png"/><link rel="manifest" href="/public/manifest.json"/><script defer="defer" src="/public/static/js/main.0609e3de.js"></script><link href="/public/static/css/main.bd4c7f39.css" rel="stylesheet"></head><body class="min-h-screen bg-gray-50"><noscript>You need to enable JavaScript to run this app.</noscript><div id="root" class="min-h-screen"></div></body></html>