<?php
/**
 * This file handle all media
 */

/**
 * Include config file
 * config file contains max image upload size
 */
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/CustomException.php';

class Media extends CustomException {
    private $_valid_image = ['jpg', 'jpeg', 'png', 'gif'];

    /**
     * Initiate file
     * @param file
     */
    public function __construct($file) {
        $this->_file = $file;
    }

    /**
     * Handle image
     * validate and move to location
     * @return filename
     */
    public function handle_image() {
        # Get file path info
        $pathInfo = pathinfo($this->_file['name']);

        if (!in_array($pathInfo['extension'], $this->_valid_image)) {
            throw new CustomException("invalid image! accepted format are " . join(', ', $this->_valid_image));
        }

        if ($this->_file['size'] > (1048576 * MAX_IMAGE_UPLOAD_SIZE)) {
            throw new CustomException("file size is too large! maximum image upload size is " . MAX_IMAGE_UPLOAD_SIZE . "MB");
        }

        $name = md5(time() + rand()) . '.' . $pathInfo['extension'];
        $path = __DIR__ . '/../public/image/' . $name;

        #move file
        if (!move_uploaded_file($this->_file['tmp_name'], $path)) {
            throw new CustomException("file moving failed! please try again");
        }
        return $name;
    }

}
