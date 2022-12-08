<?php
/**
 * This file handle api endpoint
 */

require_once __DIR__ . '/../config.php';

/**
 * Response header
 */
if (APP_ENVIRONMENT === 'development') {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Access-Control-Allow-Methods: 'GET, POST, PATCH, DELETE, OPTIONS'");
header("Access-Control-Allow-Headers: 'Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers'");
header("Access-Control-Allow-Credentials: true");

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
preg_match('/[A-z0-9.]+$/i', $url, $matches);
@$specific_part = $matches[0];

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
    if (!isset($_SERVER['CONTENT_TYPE']) || !preg_match("/multipart\/form-data; ?boundary=.+/i", $_SERVER['CONTENT_TYPE'])) {
        send_response(false, 400, ["content type must be multipart/form-data;boundary=something"]);
    }
}

/**
 * Get json data and decode it
 * print error if invalid data found
 * @return stdClass
 */
function get_json_data(): stdClass {
    $rawPostData = file_get_contents("php://input");
    if (!$postData = json_decode($rawPostData)) {
        send_response(false, 400, ["all data must be valid json"]);
    }
    return $postData;
}

/**
 * Sanitize phone number
 * @param string mobile number
 * @return string sanitized number
 */
function sanitize_phone_number(string $number): string {
    return preg_replace('/[^0-9+-]/', '', $number);
}

/**
 * Match url
 * @param string path regex
 * @return bool is matched
 */
function match_url(string $path): bool {
    global $url;
    return preg_match("/$path\/[A-z0-9.-]+$/i", $url);
}

/**
 * Return error if no valid path found on request
 * ex: /api/
 */
if (strlen(substr($url, 5)) === 0) {
    send_response(false, 404, ['endpoint not found']);
}

try {
    /**
     * Handle request endpoint
     * remove /api/ from user and initiate with switch
     */
    switch (substr($url, 5)) {
    /**
         * Login endpoint
         * REGEX: match login/* at last part of url
         */
    case preg_match('/login\/.+/i', substr($url, 5)) !== 0:

        # Remove /api/login/ from current path
        switch (substr($url, 11)) {
        /**
             * Super admin
             */
        case 'super-admin':
            $request->post('SuperAdmin', 'login');
            send_response(false, 405, ['method not allowed']);
            break;

        /**
             * admin
             */
        case 'admin':
            $request->post('Admin', 'login');
            send_response(false, 405, ['method not allowed']);
            break;
        }
        break;

    /**
         * User endpoint
         */
    case preg_match('/user\/.+/i', substr($url, 5)) !== 0:

        # Remove user/
        switch (substr($url, 10)) {
        /**
             * Super admin
             */
        case 'super-admin':
            $request
                ->get('SuperAdmin', 'isAvailable')
                ->post('SuperAdmin', 'create')
                ->auth('super_admin')
                ->patch('SuperAdmin', 'update');

            send_response(false, 405, ['method not allowed']);
            break;

        /**
             * Admin global access
             */
        case 'admin':
            $request
                ->auth('super_admin')
                ->get('Admin', 'get')
                ->post('Admin', 'create')
                ->patch('Admin', 'update');

            send_response(false, 405, ['method not allowed']);
            break;

        /**
             * Admin
             */
        case match_url('admin'):
            $request
                ->auth('admin')
                ->get('Admin', 'get_specific')
                ->patch('Admin', 'update')
                ->delete('Admin', 'delete');

            send_response(false, 405, ['method not allowed']);
            break;

        /**
             * Librarian
             */
        case 'librarian':
            break;

        /**
             * Accountant
             */
        case 'accountant':
            break;

        /**
             * Student
             */
        case 'student':
            break;

        default:
            send_response(false, 404, ['endpoint not found']);
        }

        break;

    /**
         * School global
         */
    case 'school':
        $request
            ->auth('super_admin')
            ->get('School', 'get')
            ->post('School', 'create')
            ->patch('School', 'update');

        send_response(false, 405, ['method not allowed']);
        break;

    /**
         * School
         */
    case match_url('school'):
        $request
            ->auth('super_admin')
            ->get('School', 'get_specific', $specific_part)
            ->patch('School', 'update', $specific_part)
            ->delete('School', 'delete', $specific_part);

        send_response(false, 405, ['method not allowed']);
        break;

    /**
         * Handle all image action
         */
    case 'image':
        $request
            ->get("Image", "return_all")
            ->post("Image", "upload");
        send_response(false, 405, ['method not allowed']);
        break;

    /**
         * Handle specific image action
         */
    case match_url('image'):
        $request
            ->get("Image", "return", $specific_part) // TODO remove if not found any use case
            ->delete("Image", "delete", $specific_part);
        send_response(false, 405, ['method not allowed']);
        break;

    /**
         * Handle unmatched endpoint
         */
    default:
        send_response(false, 404, ['endpoint not found']);
    }

} catch (CustomException $e) {
    send_response(false, 400, [$e->getMessage()]);

} catch (PDOException $e) {
    if (SHOW_PDO_ERROR === true) {
        send_response(false, 500, [$e->getMessage()]);
    } else {
        send_response(false, 500, ['something went wrong, please try again later!']);
    }
}