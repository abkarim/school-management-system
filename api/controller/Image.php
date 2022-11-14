<?php
/**
 * This file handle all image functionality
 * Query class is included in index.php
 * functions are is declared in index.php
 */

require_once __DIR__ . '/../../inc/Media.php';

class Image {
    private static $_table_name = 'image';

    /**
     * Return all images
     * Get image name from database
     */
    public static function return_all(): void {
        $data = Query::get_all('image');
        send_response(true, 200, ['data returned successfully'], $data, true, 10);
    }

    /**
     * Return image
     * Get specific image name from database
     *
     * @param string image name
     */
    public static function return (string $img): void {
        $data = Query::get_specific(
            self::$_table_name,
            [],
            [
                'name' => $img,
            ]
        );
        send_response(true, 200, ['data returned successfully'], $data, true, 30);
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

        # Handle image action
        $media = new Media($_FILES['image']);
        $name  = $media->handle_image();

        # Upload image name in database
        Query::insert(
            self::$_table_name,
            [
                'name'      => $name,
                'user_id'   => 23435467,
                'school_id' => 243253,
            ]);
        send_response(true, 200, ['image uploaded successfully'], ['name' => $name]);
    }

    /**
     * Delete image
     * @param string image name
     */
    public static function delete(string $img): void {
        $isDeleted = Query::delete(
            self::$_table_name,
            [
                'name' => $img,
            ]
        );
        if ($isDeleted) {
            # Remove image
            $media = new Media($img);
            $media->delete_image();

            send_response(true, 200, ['image deleted successfully']);
        } else {
            send_response(false, 410, ['image deletion failed, maybe it\'s already deleted. Please try again later!']);
        }
    }

}