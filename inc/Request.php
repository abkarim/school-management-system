<?php
/**
 * This file handle request method
 */

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
     * @return Request
     */
    public function get() {
        if( $this->_request['REQUEST_METHOD'] === 'GET' ) {
            // GET handler
        }
        return $this;
    }

    /**
     * Handle post request
     * @return Request
     */
    public function post() {
        if( $this->_request['REQUEST_METHOD'] === 'POST' ) {
            // POST handler
        }
        return $this;
    }

    /**
     * Handle patch request
     * @return Request
     */
    public function patch() {
        if( $this->_request['REQUEST_METHOD'] === 'PATCH' ) {
            // PATCH handler
        }
        return $this;
    }

    /**
     * Handle delete request
     * @return Request
     */
    public function delete() {
        if( $this->_request['REQUEST_METHOD'] === 'DELETE' ) {
            // DELETE handler
        }
        return $this;
    }
}