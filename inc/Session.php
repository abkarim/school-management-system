<?php

class Session {
    private static $_table_name                 = 'session';
    private static $_cookie_name                = "token";
    private static $_expire_access_token_after  = 3; // days
    private static $_expire_refresh_token_after = 20; // days

    /**
     * Create user session
     */
    public static function create_session(): array{
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
     * Verify session token
     */
    public static function verify_session(): array{
        define('CURRENT_TIME', );

        # Get session data from cookie
        if (
            !isset($_COOKIE[self::$_cookie_name]) ||
            !$cookieData = json_decode($_COOKIE[self::$_cookie_name])
        ) {
            send_response(false, 401, ['you must be a logged in user to continue']);
        }

        /**
         * Verify session
         */
        $data = Query::get_specific(
            self::$_table_name,
            [],
            [
                'access_token'  => $cookieData['access_token'],
                'refresh_token' => $cookieData['refresh_token'],
            ]
        );

        if (count($data) === 0) {
            send_response(false, 401, ['you must be a logged in user to continue']);
        }

        # Check refresh token expiry
        if (CURRENT_TIME > $data->refresh_token_expiry) {
            send_response(false, 401, ['token expired, please login again']);
        }

        # check access token expiry
        if (CURRENT_TIME > $data->access_token_expiry) {
            # Regenerate token

            # send cookie
        }

        # Return user role

    }

    /**
     * Insert session
     * send cookie
     * @param array user
     * @param array session data
     */
    public static function insert_session(array $user, array $sessionData): void {
        Query::insert(
            self::$_table_name,
            [
                'user_id'              => $user['user_id'],
                'role'                 => $user['role'],
                'school_id'            => $user['role'] === 'super_admin' ? '' : $user['school_id'],
                'ip_address'           => filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP) ? $_SERVER['REMOTE_ADDR'] : 'invalid ip',
                'access_token'         => $sessionData['access_token'],
                'access_token_expiry'  => $sessionData['access_token_expiry'],
                'refresh_token'        => $sessionData['refresh_token'],
                'refresh_token_expiry' => $sessionData['refresh_token_expiry'],
            ]
        );
        self::set_cookie($sessionData);
    }

    /**
     * Update session
     */
    private static function update_session(array $sessionData): bool {
        $count = Query::update(
            self::$_table_name,
            [
                'access_token'         => $sessionData['access_token'],
                'access_token_expiry'  => $sessionData['access_token_expiry'],
                'refresh_token'        => $sessionData['refresh_token'],
                'refresh_token_expiry' => $sessionData['refresh_token_expiry'],
            ],
            [
                'id' => $id,
            ]
        );
        self::set_cookie($sessionData);
        return $count === 1;
    }

    /**
     * Set cookie
     */
    private static function set_cookie(array $sessionData): void {
        # Set cookie
        setcookie(
            self::$_cookie_name,
            json_encode($sessionData),
            time() + (86400 * self::$_expire_refresh_token_after), # 86400 = 1 day
            "/",
            $_SERVER['SERVER_NAME'],
            true
        );
    }

}
