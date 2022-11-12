<?php
/**
 * This file handle api endpoint
 */

/**
 * Response header
 */
header("Access-Control-Allow-Origin: *"); // TODO remove this line
header("Access-Control-Allow-Methods: 'GET, POST, PATCH, DELETE, OPTIONS'");
header("Access-Control-Allow-Headers: 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'");

# Get request url
$url = $_SERVER['REQUEST_URI'];

# Include file
require_once __DIR__ . '/../inc/Query.php';
require_once __DIR__ . '/model/Response.php';
require_once __DIR__ . '/../inc/Request.php';

# Handle request
$request = new Request($_SERVER);
$request->options();

/**
 * Get last part of an url to handle specific task
 */
preg_match('/[a-z0-9]+$/i', $url, $specific_part);

$response = new Response();

/**
 * Send response
 * @param bool success
 * @param int status code
 * @param array message
 * @param array data
 * @param bool cache
 * @param int cache time in seconds
 */
function send_response(bool $success, int $status_code, array $messages = [], array $data = [], bool $cache = false, int $cache_time = 30): void {
    global $response;
    $response
        ->setSuccess($success)
        ->setStatusCode($status_code)
        ->setMessage($messages)
        ->setData($data)
        ->setCache($cache)
        ->setCacheTime($cache_time)
        ->send();
    exit;
}

/**
 * Check content type application/json
 * return error if not set
 */
function handle_content_type_json(): void {
    if (!isset($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] != 'application/json') {
        send_response(false, 400, ["content type must be application/json"]);
    }
}

/**
 * Check content type multipart/form-data
 * return error if not set
 */
function handle_content_type_multipart(): void {
    if (!isset($_SERVER['CONTENT_TYPE']) || !preg_match( "/multipart\/form-data; ?boundary=.+/i", $_SERVER['CONTENT_TYPE'] )) {
        send_response(false, 400, ["content type must be multipart/form-data;boundary=something"]);
    }
}

/**
 * Get json data
 */
function get_json_data() {
    $rawPostData = file_get_contents("php://input");
    if (!$postData = json_decode($rawPostData)) {
        send_response(false, 400, ["all data bust be valid json"]);
    }
    return $postData;
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
 * Return error if no valid path found on request
 * ex: /api/
 */
if (strlen(substr($url, 5)) === 0) {
    send_response(false, 404, ['endpoint not found']);
}

/**
 * Handle request endpoint
 */
switch (substr($url, 5)) {
/**
 * Handle all image action
 */
case 'image':
    $request
        ->get("Image", "return_images")
        ->post("Image", "upload");
    send_response(false, 405, ['method not allowed']);
    break;

/**
 * Handle specific image action
 */
case match_url('image'):
    $request
        ->get()
        ->post()
        ->delete();
    send_response(false, 405, ['method not allowed']);
    break;

/**
 * Handle unmatched endpoint
 */
default:
    send_response(false, 404, ['endpoint not found']);
}