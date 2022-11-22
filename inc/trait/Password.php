<?php
/**
 * Handle password actions
 */

trait Password {
    private static $_salt = PASSWORD_ARGON2I;

    /**
     * Encrypt password
     * @param string password to encrypt
     * @return string encrypted password
     */
    private static function encrypt_password(string $password): string {
        return password_hash(
            $password,
            self::$_salt
        );
    }

    /**
     * Verify password
     * @param string original password
     * @param string encrypted password
     * @return bool is matched
     */
    private static function verify_password(string $originalPassword, string $encryptedPassword): bool {
        return password_verify(
            $originalPassword,
            $encryptedPassword
        );
    }

}
