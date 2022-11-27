<?php

require_once __DIR__ . '/../../inc/trait/ID.php';

/**
 * Manage school actions
 */
class School {
    private static $_table_name = 'school';

    use ID;

    /**
     * Get schools
     */
    public static function get(): void {
        $data = Query::get_all(
            self::$_table_name
        );
        send_response(true, 200, ['schools returned successfully'], $data, true);
    }

    /**
     * Get school
     */
    public static function get_specific(string $schoolId): void {
        self::handle_invalid_id($schoolId);
        $data = Query::get_specific(
            self::$_table_name,
            [],
            [
                'school_id' => $schoolId,
            ]
        );
        if (count($data) === 0) {
            send_response(false, 404, ['school not found']);
        }
        send_response(true, 200, ['school returned successfully'], $data[0], true);
    }

    /**
     * Create school
     */
    public static function create(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required field
        $errorMessages = [];

        !isset($data->name) || empty(trim($data->name)) ? $errorMessages[]                                                             = "name is required" : false;
        !isset($data->address) || empty(trim($data->address)) ? $errorMessages[]                                                       = "address is required" : false;
        !isset($data->email) || empty(trim($data->email)) || !filter_var(trim($data->email), FILTER_VALIDATE_EMAIL) ? $errorMessages[] = "email is required" : false;
        !isset($data->phone) || empty(trim($data->phone)) ? $errorMessages[]                                                           = "phone number is required" : false;
        isset($data->description) && (empty(trim($data->description)) || strlen(trim($data->description)) > 499) ? $errorMessages[]    = "description must be less than 500 character" : false;

        # Return error if error found
        if (count($errorMessages) > 0) {
            send_response(false, 400, $errorMessages);
        }

        /**
         * Generate random school if not provided
         */
        if (!isset($data->school_id) || empty(trim($data->school_id))) {
            $schoolId = self::generate_random_id();
        } else {
            self::handle_invalid_id();
            $schoolId = $data->school_id;
            /**
             * is id already exists
             */
            $school = Query::get_specific(
                self::$_table_name,
                [],
                [
                    'school_id' => $data->school_id,
                ]
            );
            if (count($school) !== 0) {
                send_response(false, 400, ['id already exists, please use another id or keep empty for generating auto id']);
            }
        }

        /**
         * Prepare data
         */
        $PreData = [
            'school_id'     => $schoolId,
            'name'          => filter_var(trim($data->name), FILTER_SANITIZE_STRING),
            'address'       => filter_var(trim($data->address), FILTER_SANITIZE_STRING),
            'email'         => filter_var(trim($data->email), FILTER_SANITIZE_EMAIL),
            'mobile_number' => sanitize_phone_number($data->phone),
        ];

        /**
         * Add description if exists
         */
        if (isset($data->description) && !empty(trim($data->description))) {
            $PreData['description'] = filter_var(trim($data->description), FILTER_SANITIZE_STRING);
        }

        /**
         * Handle image
         */
        if (isset($data->image) && !empty(trim($data->image))) {
            # Is image exists
            $image = Query::get_specific(
                'image',
                [],
                [
                    'name' => filter_var(trim($data->image), FILTER_SANITIZE_STRING),
                ]
            );
            if (count($image) > 0) {
                $PreData['image'] = $image[0]['name'];
            }
        }

        /**
         * Add to database
         */
        Query::insert(
            self::$_table_name,
            $PreData
        );

        send_response(true, 201, ['school added successfully'], $PreData);
    }

    /**
     * Update school
     * @param string school id
     */
    public static function update(string $school_id): void {
        handle_content_type_json();
        $data = get_json_data();
        self::handle_invalid_id($school_id);
        /**
         * Check is school exists to update
         */
        $isFound = Query::get_specific(
            self::$_table_name,
            [],
            [
                'school_id' => $school_id,
            ]
        );
        if (count($isFound) === 0) {
            send_response(false, 404, ['school not found']);
        }

        /**
         * If no data found return error
         */
        if (count((array) $data) === 0) {
            send_response(false, 400, ['nothing to update']);
        }

        $columns = [];

        # Check required field
        $errorMessages = [];

        if (isset($data->name)) {
            $columns['name']                            = filter_var(trim($data->name), FILTER_SANITIZE_STRING);
            empty(trim($data->name)) ? $errorMessages[] = 'name is required' : false;
        }
        if (isset($data->email)) {
            $columns['email']                                                                                  = filter_var(trim($data->email), FILTER_SANITIZE_EMAIL);
            empty(trim($data->email)) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ? $errorMessages[] = 'email is required' : false;
        }
        if (isset($data->address)) {
            $columns['address']                            = filter_var(trim($data->address), FILTER_SANITIZE_STRING);
            empty(trim($data->address)) ? $errorMessages[] = "address is required" : false;
        }
        if (isset($data->phone)) {
            $columns['mobile_number']                    = sanitize_phone_number($data->phone);
            empty(trim($data->phone)) ? $errorMessages[] = "phone number is required" : false;
        }
        if (isset($data->description)) {
            $columns['description']                                                                      = filter_var(trim($data->description), FILTER_SANITIZE_STRING);
            empty(trim($data->description)) || strlen(trim($data->description)) > 499 ? $errorMessages[] = "description must be less than 500 character" : false;
        }

        # Return error if error found
        if (count($errorMessages) > 0) {
            send_response(false, 400, $errorMessages);
        }

        /**
         * Generate random school if not provided
         */
        if (isset($data->school_id) && !empty(trim($data->school_id))) {
            self::handle_invalid_id($data->school_id);
            $columns['school_id'] = trim($data->school_id);
            /**
             * is id already exists
             */
            $school = Query::get_specific(
                self::$_table_name,
                [],
                [
                    'school_id' => $school_id,
                ]
            );
            if (count($school) !== 0) {
                send_response(false, 400, ['id already exists, please use another id or keep empty for generating auto id']);
            }
        }

        /**
         * Add description if exists
         */
        if (isset($data->description) && !empty(trim($data->description))) {
            $PreData['description'] = filter_var(trim($data->description), FILTER_SANITIZE_STRING);
        }

        /**
         * Handle image
         */
        if (isset($data->image) && !empty(trim($data->image))) {
            # Is image exists
            $image = Query::get_specific(
                'image',
                [],
                [
                    'name' => filter_var(trim($data->image), FILTER_SANITIZE_STRING),
                ]
            );
            if (count($image) > 0) {
                $PreData['image'] = $image[0]['name'];
            }
        }

        /**
         * Add to database
         */
        $DBdata = Query::update(
            self::$_table_name,
            $columns,
            [
                'school_id' => $school_id,
            ]
        );

        send_response(true, 202, ['school updated successfully'], $DBdata);
    }

    /**
     * Delete school
     * @param string school id
     */
    public static function delete(string $school_id): void {
        self::handle_invalid_id($school_id);
        /**
         * Check is school exists to update
         */
        $isFound = Query::get_specific(
            self::$_table_name,
            [],
            [
                'school_id' => $school_id,
            ]
        );
        if (count($isFound) === 0) {
            send_response(false, 404, ['school not found']);
        }

        /**
         * Delete school
         */
        $isDeleted = Query::delete(
            self::$_table_name,
            [
                'school_id' => $school_id,
            ]
        );

        if (!$isDeleted) {
            send_response(false, 500, ['something went wrong, please try again later']);
        }

        send_response(true, 204, []);

    }

}
