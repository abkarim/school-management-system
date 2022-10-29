<?php
/**
 * This file handle all request
 *
 * Including
 ** Method
 ** Auth
 ** Permission
 */

class Request {
    # Targeted request
    private $_request = null;

    /**
     * Get request
     * @param RequestObject incoming request
     */
    public function __construct($request) {
        $this->_request = $request;
    }

}
