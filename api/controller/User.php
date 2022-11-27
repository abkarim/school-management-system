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
}