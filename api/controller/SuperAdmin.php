<?php
require_once __DIR__ . '/../../inc/trait/ID.php';
require_once __DIR__ . '/../../inc/trait/Login.php';
require_once __DIR__ . '/../../inc/trait/Password.php';

/**
 * Handle super admin actions
 */
class SuperAdmin {
    private static $_table_name = 'super_admin';
    use ID, Password, Login;

    /**
     * Create super admin
     */
    public static function create(): void {

        /**
         * Only one super user is allowed
         * this method should only work when installing app
         * after installation complete don't create a new user
         */
        if (APP_INSTALLED === true) {
            send_response(false, 400, ['any action in this route is not allowed']);
        }
        // TODO replace condition with user exists

        handle_content_type_json();
        $data = get_json_data();

        # Check required field
        $errorMessages = [];

        !isset($data->name) || empty(trim($data->name)) ? $errorMessages[]                                                             = "name is required" : false;
        !isset($data->email) || empty(trim($data->email)) || !filter_var(trim($data->email), FILTER_VALIDATE_EMAIL) ? $errorMessages[] = "email is required" : false;
        !isset($data->password) || empty(trim($data->password)) || strlen(trim($data->password)) < 10 ? $errorMessages[]               = "password is required and length must be at least 10 character" : false;

        # Return error if error found
        if (count($errorMessages) > 0) {
            send_response(false, 400, $errorMessages);
        }

        # Create user id
        $user_id = self::generate_random_id();

        $dbData = [
            'name'     => filter_var(trim($data->name), FILTER_SANITIZE_STRING),
            'email'    => filter_var(trim($data->email), FILTER_SANITIZE_EMAIL),
            'password' => self::encrypt_password(trim($data->password)),
            'user_id'  => $user_id,
            'image'    => isset($data->image) ? $data->image : DEFAULT_USER_IMAGE_NAME,
        ];

        Query::insert(
            self::$_table_name,
            $dbData
        );
        unset($dbData['password']);
        send_response(true, 201, ['super admin created successfully'], $dbData);
    }

    /**
     *  Update super user
     */
    public static function update(): void {
        handle_content_type_json();
        $data = get_json_data();

        /**
         * Is user exists with this userID
         */
        $user = Query::get_specific(
            self::$_table_name,
            [],
            [
                'user_id' => LOGGEDIN_IN_USER_ID,
            ]
        );

        if (count($user) === 0) {
            send_response(false, 400, ['user not found']);
        }

        # Check required field
        $errorMessages = [];
        $allowedField = [];

        /**
         * Check only specific item that we allow to change
         */
        if (isset($data->name)) {
            $name                                                           = trim($data->name);
            preg_match('/[A-z .]+$/i', $name) !== 0 ? $allowedField['name'] = $name : $errorMessages['name'] = "name is invalid";
        }

        if (isset($data->image)) {
            $image                           = filter_var(trim($data->image), FILTER_SANITIZE_STRING);
            empty($image) ? $errorMessages[] = "invalid image" : $allowedField['image'] = $image;
        }

        # Return error if error found
        if (count($errorMessages) !== 0) {
            send_response(false, 400, $errorMessages);
        }

        $dbData = Query::update(
            self::$_table_name,
            $allowedField,
            [
                'user_id' => LOGGEDIN_IN_USER_ID,
            ]
        );

        unset($dbData[0]['password']);
        send_response(true, 200, ['user updated successfully'], $dbData[0], true);
    }

}