<?php
require_once __DIR__ . '/../../inc/trait/ID.php';
require_once __DIR__ . '/../../inc/trait/Login.php';
require_once __DIR__ . '/../../inc/trait/Password.php';

/**
 * Handle admin actions
 */
class Admin {
    private static $_table_name = 'admin';
    use ID, Password, Login;

    /**
     * Create admin
     */
    public static function create(): void {
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

        /**
         * Is user exists with this email
         */
        $prevUser = Query::get_specific(
            self::$_table_name,
            [],
            [
                'email' => $data->email,
            ]
        );

        if (count($prevUser) !== 0) {
            send_response(false, 400, ["'$data->email' is already in use, try to login or use another email"]);
        }

        # Create user id
        $user_id = self::generate_random_id();

        $dbData = [
            'name'     => trim($data->name),
            'email'    => trim($data->email),
            'password' => self::encrypt_password(trim($data->password)),
            'user_id'  => $user_id,
            'image'    => isset($data->image) ? $data->image : DEFAULT_USER_IMAGE_NAME,
        ];

        # Add to database
        Query::insert(
            self::$_table_name,
            $dbData
        );

        send_response(true, 201, ['\'super admin\' created successfully'], $dbData);
    }

    /**
     * Get single super admin
     * @param string super admin id
     */
    public static function get_specific(string $userId): void {
        self::handle_invalid_id($userId);

        $data = Query::get_specific(
            self::$_table_name,
            [
                'id',
                'user_id',
                'name',
                'email',
                'image',
                'created_by',
                'created_at',
            ],
            [
                'user_id' => $userId,
            ],
            true,
            1
        );
        if (count($data) === 0) {
            send_response(false, 404, ['user not found']);
        }

        send_response(true, 200, ["user returned successfully"], $data, true);
    }

    /**
     * Get all super admin
     */
    public static function get(): void {
        $data = Query::get_all(
            self::$_table_name,
            [
                'id',
                'user_id',
                'name',
                'email',
                'image',
                'created_by',
                'created_at',
            ]
        );
        send_response(true, 200, ['super admin list returned successfully'], $data, true);
    }

    /**
     *  Update super user
     * @param string user id
     */
    public static function update(string $userId): void {
        self::handle_invalid_id($userId);

        handle_content_type_json();
        $data = get_json_data();

        /**
         * Is user exists with this userID
         */
        $user = Query::get_specific(
            self::$_table_name,
            [],
            [
                'user_id' => $userId,
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
                'user_id' => $userId,
            ]
        );

        unset($dbData[0]['password']);
        send_response(true, 200, ['user updated successfully'], $dbData[0], true);
    }

    /**
     *  Delete super user
     * @param string user id
     */
    public static function delete(string $userId): void {
        self::handle_invalid_id($userId);

        /**
         * Match loggedin user id with current user id
         * if matched then allow edit
         */
        if (LOGGEDIN_IN_USER_ID !== $userId) {
            send_response(false, 401, ['sorry, you are not allowed to change someone else\'s info']);
        }

        /**
         * Is user exists with this userID
         */
        $user = Query::get_specific(
            self::$_table_name,
            [],
            [
                'user_id' => $userId,
            ]
        );

        if (count($user) === 0) {
            send_response(false, 400, ['user not found']);
        }

        $isDeleted = Query::delete(
            self::$_table_name,
            [
                'user_id' => $userId,
            ]
        );

        $isDeleted ? send_response(true, 204, ['user deleted successfully']) : send_response(true, 500, ['something went wrong please try again later!']);
    }

}
