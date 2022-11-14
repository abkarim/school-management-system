<?php
/**
 * This file handle user action
 * Query class is included in index.php
 * functions are is declared in index.php
 */

class User {
    private static $_table_name                 = 'user';
    private static $_expire_access_token_after  = 5; // days
    private static $_expire_refresh_token_after = 30; // days
    private static $_cookie_name                = "asddfd";

    /**
     * Create user session
     */
    private static function create_session_token(): array{
        # Handle time
        $currentTime = time();

        # Create access token
        $accessToken       = base64_encode(bin2hex(openssl_random_pseudo_bytes(32)));
        $accessTokenExpiry = date('Y-m-d h:i:s', $currentTime + (self::$_expire_access_token_after * 24 * 60 * 60));

        # Create refresh token
        $refreshToken       = base64_encode(bin2hex(openssl_random_pseudo_bytes(32)));
        $refreshTokenExpiry = date('Y-m-d h:i:s', $currentTime + (self::$_expire_refresh_token_after * 24 * 60 * 60));

        return [
            'access_token'         => $accessToken,
            'access_token_expiry'  => $accessTokenExpiry,
            'refresh_token'        => $refreshToken,
            'refresh_token_expiry' => $refreshTokenExpiry,
        ];
    }

    /**
     * Signup handler
     */
    public static function sign_up(): void {
        handle_content_type_json();
        $data = get_json_data();

        # Check required filed
        if (
            !isset($data->email) ||
            !isset($data->password) ||
            !isset($data->role)
        ) {
            $messages = [];

            # Add messages
            !isset($data->email) ? $messages[]    = "email is required" : false;
            !isset($data->password) ? $messages[] = "password is required" : false;
            !isset($data->role) ? $messages[]     = "user role is required" : false;

            send_response(false, 400, $messages);
        }

        # Create user

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
        $sessionData = self::create_session_token();

        # Insert session to database
        Query::insert(
            'session',
            [
                'user_id'              => $user->id,
                'school_id'            => $user->school_id,
                'ip_address'           => $_SERVER['REMOTE_ADDR'],
                'access_token'         => $sessionData['access_token'],
                'access_token_expiry'  => $sessionData['access_token_expiry'],
                'refresh_token'        => $sessionData['refresh_token'],
                'refresh_token_expiry' => $sessionData['refresh_token_expiry'],
            ]
        );

        # Set cookie
        setcookie(
            self::$_cookie_name,
            $data,
            time() + (86400 * self::$_expire_refresh_token_after),
            "/"
        ); // 86400 = 1 day // TODO encrypt cookie value

        send_response(true, 200, ['']);
    }

}
