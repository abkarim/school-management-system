<?php
require_once __DIR__ . '/../../inc/trait/ID.php';
require_once __DIR__ . '/../../inc/trait/Login.php';
require_once __DIR__ . '/../../inc/trait/Password.php';

class Student {
    private static $_table_name      = 'student';
    private static $_initial_user_id = STUDENT_ID_START_FROM + 1;

    use ID, Password, Login; # TO generate user id

    /**
     * Create student
     */
    public static function create_student(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required field
        $errorMessages = [];

        # Return error if error found
        if (count($errorMessages) !== 0) {
            send_response(false, 400, $errorMessages);
        }

        /**
         * Handle student id
         * if supplied
         * @true match with other students and check is unique
         * @false generate a new user id
         */

        # Add to database

        /**
         * Handle parent login access
         */

        send_response(true, 201, ['student account created successfully'], $data);
    }

    /**
     * Update student
     */
    public static function update_student(): void {

        send_response(true, 201, ['student account updated successfully'], $data);
    }

}