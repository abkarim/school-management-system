<?php
/**
 * This file handle all image functionality
 */

require_once __DIR__ . '/../../inc/Media.php';

class Image {
    /**
     * Return all images
     * Get image name from database
     */
    public static function return_images(): void {
        $data = Query::get_all('image');
        send_response(true, 200, ['data returned successfully'], $data, true, 10);
    }

    /**
     * Return image
     * Get specific image name from database
     *
     * @param string image name
     */
    public static function return_image(string $img): void {
        // Get image name from database
    }

    /**
     * Upload image
     * @return string image name
     */
    public static function upload() {
        # Check content type multipart/form-data
        handle_content_type_multipart();

        # Is file exists
        if (!array_key_exists('image', $_FILES) || empty($_FILES['image']['tmp_name'])) {
            send_response(false, 400, ['image is required']);
        }

        // echo json_encode($_FILES['image']); // TODO

        # Handle image action 
        $media = new Media($_FILES['image']);
        $data = $media->handle_image();

        send_response(true, 200, ['image uploaded successfully']);
    }

}