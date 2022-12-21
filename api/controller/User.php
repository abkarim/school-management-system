<?php
/**
 * This file handle user action
 * Query class is included in index.php
 * functions are is declared in index.php
 */

# Include session
require_once __DIR__ . '/../../inc/Session.php';

class User extends Session {

    /**
     * User data
     */
    public static function me(): void {
        $data = User::verify_session();

        // Get user data
        $userData = Query::get_specific(
            $data['user_role'],
            [
                'name',
                'image',
            ],
            [
                'user_id' => $data['user_id'],
            ]
        );

        send_response(true, 200, [], $userData[0] + $data);
    }

}