<?php
/**
 * This file handle all image functionality
 */

 // TODO make static query method

class Image {
    /**
     * Return all images
     * Get image name from database and sent to user
     */
    public static function return_images(): void {
        $data = $QUERY->get_all('image');
        echo json_encode($data);
        exit;
    }

    /**
     * Return image
     * Get image name from database and send to user
     *
     * @param string image name
     */
    public static function return_image(string $img): void {
        // Get image name from database
    }
}
