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
    public function get(string $class, string $method, $parameter = ''): Request {
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
}