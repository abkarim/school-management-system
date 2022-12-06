<?php
/**
 * Handle login action
 */

# include password trait
require_once __DIR__ . '/Password.php';
require_once __DIR__ . '/../Session.php';

trait Login {
    use Password;

    /**
     * Login
     */
    public static function login(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required filed

        $messages = [];
        # Add messages
        !isset($data->email) ? $messages[]    = "email is required" : false;
        !isset($data->password) ? $messages[] = "password is required" : false;

        # onetime login
        $onetime = isset($data->onetime) && $data->onetime == true ? true : false;

        if (count($messages) !== 0) {
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
        if (!self::verify_password(trim($data->password), $user[0]['password'])) {
            send_response(false, 400, ['email or password is wrong, please try again!']);
        }

        # Create session
        $sessionData = Session::create_session($onetime);

        # Add role to user
        $user[0]['role'] = self::$_table_name;

        # insert session
        Session::insert_session($user[0], $sessionData);

        send_response(true, 200, ['logged in successful']);
    }
}
