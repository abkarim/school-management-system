<?php
# Include config file
require_once __DIR__ . '/config.php';

# Load installation page if site is not installed
if (APP_INSTALLED === false) {
    header('Location: /install.php');
    exit;
}
