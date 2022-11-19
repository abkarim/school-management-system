<?php

class Session {
    private static $_table_name                 = 'session';
    private static $_cookie_name                = "asddfd"; // TODO
    private static $_expire_access_token_after  = 5; // days
    private static $_expire_refresh_token_after = 30; // days

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
     * @param * user
     * @param array session data
     */
    private static function insert_session($user, array $sessionData) {
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
    }

    /**
     * Update session
     */
    private static function update_session(array $sessionData): bool {
        $count = Query::update(
            'session',
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
            "/"
        );
    }

}
