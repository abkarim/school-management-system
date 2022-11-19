<?php
/**
 * This file handle user action
 * Query class is included in index.php
 * functions are is declared in index.php
 */

# Include session
require_once __DIR__ . '/../../inc/Session.php';

class User extends Session {
    private static $_table_name = 'user';

    /**
     * Generate user id
     */
    private static function generate_user_id(): int {
        $numbers   = range(1, 10);
        $numbers[] = time();
        shuffle($numbers);
        return (int) join('', $numbers);
    }

    /**
     * Signup handler
     */
    public static function create(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required filed
        $messages = [];

        # Add messages
        !isset($data->email) ? $messages[]                                           = "email is required" : false;
        !filter_var($data->email, FILTER_VALIDATE_EMAIL) ? $messages[]               = "email must be valid" : false;
        !isset($data->password) || strlen(trim($data->password)) === 0 ? $messages[] = "password is required" : false;
        !isset($data->role) || strlen(trim($data->role)) === 0 ? $messages[]         = "user role is required" : false;

        if (count($messages) != 0) {
            send_response(false, 400, $messages);
        }

        echo json_encode(self::generate_user_id());
        exit;

        # Create user
        Query::insert(
            self::$_table_name,
            [
                'user_id'  => self::generate_user_id(),
                'role'     => trim($data->role),
                'email'    => trim(
                    filter_var(
                        $data->email,
                        FILTER_SANITIZE_EMAIL
                    )),
                'password' => password_hash(
                    trim($data->password),
                    PASSWORD_ARGON2I
                ),
            ]
        );

    }

    /**
     * Login
     */
    public static function login(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required filed
        if (
            !isset($data->email) ||
            !isset($data->password)
        ) {
            $messages = [];
            # Add messages
            !isset($data->email) ? $messages[]    = "email is required" : false;
            !isset($data->password) ? $messages[] = "password is required" : false;

            send_response(false, 400, $messages);
        }

        # Verify user
        $user = Query::get_specific(
            self::$_table_name,
            [],
            [
                'email' => filter_var($data->email, FILTER_SANITIZE_EMAIL),
            ]
        );

        # Sleep for 1 second
        sleep(1);

        # Is user exists
        if (count($user) === 0) {
            send_response(false, 400, ['email or password is wrong, please try again!']);
        }

        # Check password
        if (!password_verify($user->password, PASSWORD_ARGON2I)) {
            send_response(false, 400, ['email or password is wrong, please try again!']);
        }

        # Create session
        $sessionData = self::create_session();

        send_response(true, 200, ['']);
    }

}