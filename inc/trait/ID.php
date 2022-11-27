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

    /**
     * Generate random unique id
     * @return int return id
     */
    private static function generate_random_id(): int {
        $numbers = range(1, 13);
        shuffle($numbers);
        return (int) join('', $numbers);
    }

    /**
     * Handle invalid
     * return error response on invalid id
     *
     * @param string id
     */
    private static function handle_invalid_id(string $id): void {
        if (0 === preg_match('/^[0-9]+$/', $id)) {
            send_response(false, 400, ['invalid id']);
        }
    }

}
