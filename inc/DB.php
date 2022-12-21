<?php
# Import configuration file to get database configuration
require_once __DIR__ . '/../config.php';

class DB {
    // Static read and write connection
    private static $_readDBConnection;
    private static $_writeDBConnection;
    private static $_DBhost     = DATABASE_HOSTNAME;
    private static $_DBname     = DATABASE_NAME;
    private static $_DBusername = DATABASE_USERNAME;
    private static $_DBpassword = DATABASE_PASSWORD;
    private static $_DBcharset  = DATABASE_CHARSET;

    /**
     * Handle read only action
     * @return PDO connection
     */
    public static function connect_read_DB(): PDO {
        // Create new connection if already not connected
        if (self::$_readDBConnection === null) {
            self::$_readDBConnection = new PDO(
                "mysql:host=" . self::$_DBhost . ";dbname=" . self::$_DBname . ";charset=" . self::$_DBcharset,
                self::$_DBusername,
                self::$_DBpassword
            );
            self::$_readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$_readDBConnection;
    }

    /**
     * Handle write only action
     * @return PDO connection
     */
    public static function connect_write_DB(): PDO {
        // Create new connection if already not connected
        if (self::$_writeDBConnection === null) {
            self::$_writeDBConnection = new PDO(
                "mysql:host=" . self::$_DBhost . ";dbname=" . self::$_DBname . ";charset=" . self::$_DBcharset,
                self::$_DBusername,
                self::$_DBpassword
            );
            self::$_writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$_writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$_writeDBConnection;
    }

    /**
     * Handle write only action - while installing
     * @return PDO connection
     */
    public static function connect_installing_DB(): PDO {
        $DBConnection = new PDO(
            "mysql:host=" . INSTALLING_DATA['DATABASE_HOSTNAME'] . ";dbname=" . INSTALLING_DATA['DATABASE_NAME'] . ";charset=" . self::$_DBcharset,
            INSTALLING_DATA['DATABASE_USERNAME'],
            INSTALLING_DATA['DATABASE_PASSWORD']
        );
        $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $DBConnection;
    }

}