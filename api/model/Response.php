<?php
/**
 * This Class is responsible for all API response
 */

class Response {
    // Define properties
    private $_success;
    private $_toCache;
    private $_httpStatusCode;
    private $_messages = [];
    private $_data;
    private $_responseArray = [];

    /**
     * Set success
     * @param Boolean is success
     * @return ResponseClass for method chaining;
     */
    public function setSuccess($success) {
        $this->_success = $success;
        return $this;
    }

    /**
     * Set cache
     * @param Boolean enable cache
     * @return ResponseClass for method chaining;
     */
    public function setCache($cache) {
        $this->_toCache = $cache;
        return $this;
    }

    /**
     * Set status code
     * @param Number status code
     * @return ResponseClass for method chaining;
     */
    public function setStatusCode($statusCode) {
        $this->_httpStatusCode = $statusCode;
        return $this;
    }

    /**
     * Add message
     * @param String message
     * @return ResponseClass for method chaining;
     */
    public function addMessage($message) {
        $this->_messages[] = $message;
        return $this;
    }

    /**
     * Set data
     * @param Array data array
     * @return ResponseClass for method chaining;
     */
    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    /**
     * Send response
     * @return void SendResponse
     */
    public function send() {
        // Set header
        header("Content-Type: application/json");

        // Cache control
        if ($this->_toCache) {
            header("Cache-Control: max-age=30"); # Cache response for 30 seconds
        } else {
            header("Cache-Control: no-cache, no-store"); # No cache
        }

        // Handle server error
        if (!is_numeric($this->_httpStatusCode) || !is_bool($this->_success)) {
            // This is a server error # Prepare data for server error
            http_response_code(500);
            $this->_responseArray['success']    = false;
            $this->_responseArray['statusCode'] = 500;
            $this->addMessage("Something went wrong, please try again");
            $this->_responseArray['message'] = $this->_messages;
        } else {
            // Prepare data
            http_response_code($this->_httpStatusCode);
            $this->_responseArray['success']    = $this->_success;
            $this->_responseArray['statusCode'] = $this->_httpStatusCode;
            $this->_responseArray['message']    = $this->_messages;
            $this->_responseArray['data']       = $this->_data;
        }

        // Send response
        echo json_encode($this->_responseArray);
        // Cose connection
        if (isset($readDB)) {
            unset($readDB);
        }
        if (isset($writeDB)) {
            unset($writeDB);
        }
        exit;
    }
}