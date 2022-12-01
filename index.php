<?php
# Include config file
require_once __DIR__ . '/config.php';

# Load installation page if site is not installed
if (APP_INSTALLED == false) {
    require __DIR__ . '/setup.php';
    exit;
}

echo "home page";