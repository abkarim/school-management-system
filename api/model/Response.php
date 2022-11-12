<?php
/**
 * This Class is responsible for all API response
 */

class Response {
    private $_success;
    private $_toCache;
    private $_httpStatusCode;
    private $_messages = [];
    private $_data;
    private $_responseArray = [];
    private $_cache_second  = 30;

    /**
     * Set success
     * @param bool is success
     * @return Response for method chaining
     */
    public function setSuccess($success): Response {
        $this->_success = $success;
        return $this;
    }

    /**
     * Set cache
     * @param bool enable cache
     * @return Response for method chaining
     */
    public function setCache(bool $cache): Response {
        $this->_toCache = $cache;
        return $this;
    }

    /**
     * Set cache time
     * @param int cache time in seconds
     * @return Response for method chaining
     */
    public function setCacheTime(int $time): Response {
        $this->_cache_second = $time;
        return $this;
    }

    /**
     * Set status code
     * @param int status code
     * @return Response for method chaining
     */
    public function setStatusCode(int $statusCode): Response {
        $this->_httpStatusCode = $statusCode;
        return $this;
    }

    /**
     * Add message
     * @param array message
     * @return Response for method chaining
     */
    public function setMessage(array $message): Response {
        $this->_messages = $message;
        return $this;
    }

    /**
     * Set data
     * @param array data array
     * @return Response for method chaining
     */
    public function setData(array $data): Response {
        $this->_data = $data;
        return $this;
    }

    /**
     * Send response
     */
    public function send(): void {
        header("Content-Type: application/json");

        if ($this->_toCache) {
            header("Cache-Control: max-age=" . $this->_cache_second);
        } else {
            header("Cache-Control: no-cache, no-store");
        }

        // Handle server error
        if (!is_numeric($this->_httpStatusCode) || !is_bool($this->_success)) {
            $this->setMessage(["something went wrong, please try again"]);
            http_response_code(500);
            $this->_responseArray['success']    = false;
            $this->_responseArray['statusCode'] = 500;
            $this->_responseArray['message']    = $this->_messages;
        } else {
            http_response_code($this->_httpStatusCode);
            $this->_responseArray['success']    = $this->_success;
            $this->_responseArray['statusCode'] = $this->_httpStatusCode;
            $this->_responseArray['message']    = $this->_messages;
            if ($this->_success) {
                $this->_responseArray['data']   = $this->_data;
                $this->_responseArray['length'] = count($this->_data);
            }
        }

        echo json_encode($this->_responseArray);
    }
}