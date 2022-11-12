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
    private $_valid_image = ['jpeg', 'gif', 'png'];

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
    public function handle_image(string $prefix=''): array{
        # Get file info
        $imageInfo = [];
        $info      = getimagesize($this->_file['tmp_name']);

        if (!in_array(str_replace('image/', '', $info['mime']), $this->_valid_image)) {
            throw new CustomException("invalid image! accepted format are " . join(', ', $this->_valid_image));
        }

        if ($this->_file['size'] > (1048576 * MAX_IMAGE_UPLOAD_SIZE)) {
            throw new CustomException("file size is too large! maximum image upload size is " . MAX_IMAGE_UPLOAD_SIZE . "MB");
        }

        $name = $prefix . md5(time() + rand()) . '.jpg';
        $path = __DIR__ . '/../public/image/';

        # Move image
        $imageFN = "imagecreatefrom" . str_replace('image/', '', $info['mime']);
        $image   = call_user_func($imageFN, $this->_file['tmp_name']);

        if (!imagejpeg($image, $path . $name, 90)) {
            throw new CustomException('"image uploading failed", please try again later!');
        }

        $imageInfo['name'] = $name;

        # Clone image
        if (CLONE_IMAGE_IN_DIFFERENCE_SIZE === true) {
            # Get size
            $width  = $info[0];
            $height = $info[1];

            #copy and make medium

            #copy and make small
        }

        return $imageInfo;
    }

}