<?php
/**
 * Handle user id
 */

trait ID {

    /**
     * Generate user id
     */
    private static function generate_id(): int {
        # Get last user id and increment one
        $user = Query::get_specific(
            self::$_table_name,
            [
                'user_id',
            ],
            [
                '1' => '1',
            ],
            false,
            1
        );

        # if id not found create an id
        if (count($user) === 0) {
            return self::$_initial_user_id;
        }

        return $user->user_id + 1;
    }

}
