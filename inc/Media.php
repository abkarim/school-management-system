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
    private $_image_folder   = __DIR__ . '/../public/uploads/image/';
    private $_valid_image    = ['jpeg', 'gif', 'png'];
    private $_maxImageUpload = (1048576 * MAX_IMAGE_UPLOAD_SIZE); # Mb to bytes

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
     * @param string prefix
     * @return array image info
     */
    public function handle_image(string $prefix = ''): string {
        # Get file info
        $info = getimagesize($this->_file['tmp_name']);

        # is valid image
        if (!is_array($info) || !in_array(str_replace('image/', '', $info['mime']), $this->_valid_image)) {
            throw new CustomException("invalid image! accepted format are " . join(', ', $this->_valid_image));
        }

        if ($this->_file['size'] > $this->_maxImageUpload) {
            throw new CustomException("file size is too large! maximum image upload size is " . MAX_IMAGE_UPLOAD_SIZE . "MB");
        }

        $name = $prefix . md5(time() + rand()) . '.jpg';

        # Move image
        $imageFN = "imagecreatefrom" . str_replace('image/', '', $info['mime']);
        $image   = call_user_func($imageFN, $this->_file['tmp_name']);

        if (!imagejpeg($image, $this->_image_folder . $name, 75)) {
            throw new CustomException('"image uploading failed", please try again later!');
        }

        return $name;
    }

    /**
     * Delete image
     * @return bool is deleted
     */
    public function delete_image(): bool {
        return unlink($this->_image_folder . $this->_file);
    }

}