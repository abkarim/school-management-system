<?php
/**
 * This file handle request method
 */

/**
 * Implement autoload for controller classes
 */
spl_autoload_register(function ($className) {
    $file = __DIR__ . '/../api/controller/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

class Request {
    # Targeted request
    private $_request = null;

    /**
     * Initiate request
     * @param RequestObject incoming request
     */
    public function __construct($request) {
        $this->_request = $request;
    }

    /**
     * Handle get request
     * @param string class name
     * @param string method name
     * @param string parameter
     * @return Request
     */
    public function get(string $class, string $method, string $parameter = ''): Request {
        if ($this->_request['REQUEST_METHOD'] === 'GET') {
            call_user_func(array($class, $method), $parameter);
        }
        return $this;
    }

    /**
     * Handle post request
     * @param string class name
     * @param string method name
     * @param string parameter
     * @return Request
     */
    public function post(string $class, string $method, $parameter = ''): Request {
        if ($this->_request['REQUEST_METHOD'] === 'POST') {
            call_user_func(array($class, $method), $parameter);
        }
        return $this;
    }

    /**
     * Handle patch request
     * @param string class name
     * @param string method name
     * @param string parameter
     * @return Request
     */
    public function patch(string $class, string $method, $parameter = ''): Request {
        if ($this->_request['REQUEST_METHOD'] === 'PATCH') {
            call_user_func(array($class, $method), $parameter);
        }
        return $this;
    }

    /**
     * Handle delete request
     * @param string class name
     * @param string method name
     * @param string parameter
     * @return Request
     */
    public function delete(string $class, string $method, $parameter = ''): Request {
        if ($this->_request['REQUEST_METHOD'] === 'DELETE') {
            call_user_func(array($class, $method), $parameter);
        }
        return $this;
    }

    /**
     * Handle options request
     * @return Request
     */
    public function options(): Request {
        if ($this->_request['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
        return $this;
    }

    /**
     * Handle authentication
     * @param string user role
     */
    public function auth(string $role): Request {
        $data = User::verify_session();

        /**
         * Match logged in user role with provided role
         */
        if ($data['user_role'] !== $role) {
            send_response(false, 403, ['you don\'t have access to complete this request']);
        }

        /**
         * Define user role and user id to access later in code
         */
        define('LOGGEDIN_IN_USER_ROLE', $data['user_role']);
        define('LOGGEDIN_IN_USER_ID', $data['user_id']);

        return $this;
    }
}