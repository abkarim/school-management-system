<?php
/**
 * This file handle api endpoint
 */

# Get request url
$url = $_SERVER['REQUEST_URI'];

# Include request
require_once __DIR__ . '/../inc/Request.php';
$request = new Request($_SERVER);

/**
 * Get last part of an url to handle specific task
 */
preg_match('/[a-z0-9]+$/i', $url, $specific_part);

/**
 * Print error and exit
 * @param int status code
 * @param string message
 */
function print_error(int $code, string $message): void {
    http_response_code($code);
    echo json_encode([
        "success" => false,
        "message" => $message,
    ]);
    exit;
}

/**
 * Match url
 * @param string path regex
 * @return bool is matched
 */
function match_url(string $path): bool {
    global $url;
    return preg_match("/$path\/[a-z0-9]+$/i", $url);
}

/**
 * Handle request endpoint
 */
switch (substr($url, 5)) {
/**
 * Handle all image action
 */
case 'image':
    $request->get("Image", "return_images");
    print_error(405, "method not allowed");
    break;

/**
 * Handle specific image action
 */
case match_url('image'):
    $request
        ->get()
        ->post()
        ->delete();
    print_error(405, "method not allowed");
    break;

/**
 * Handle unmatched endpoint
 */
default:
    print_error(404, "endpoint not found");
}