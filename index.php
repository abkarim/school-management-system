<?php
# Include config file
require_once __DIR__ . '/config.php';

# Load installation page if site is not installed
if (APP_INSTALLED == false) {
    require __DIR__ . '/setup.php';
    exit;
}
?>

<!doctype html><html lang="en"><head><meta charset="utf-8"/><link rel="icon" href="/public/favicon.ico"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="theme-color" content="#000000"/><meta name="description" content="Web site created using create-react-app"/><link rel="apple-touch-icon" href="/public/icon.png"/><link rel="manifest" href="/public/manifest.json"/><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"><title>School management system</title><script defer="defer" src="/public/static/js/main.4b19a60b.js"></script><link href="/public/static/css/main.52dedde9.css" rel="stylesheet"></head><body class="min-h-screen bg-gray-50 relative"><noscript>You need to enable JavaScript to run this app.</noscript><div id="root" class="min-h-screen"></div></body></html>