<?php
/**
 *! Please Don't edit this file if you don't know what you are doing
 *
 ** This file contains all the settings and DataBase configuration
 *
 * all configuration will be automatically saved here in installation time
 *
 * This file contains the following configuration
 ** Database credentials
 ** Database table prefix
 ** Secret keys
 ** Core settings
 */

/**
 * Database host
 * require to connect with database
 */
define('DATABASE_HOSTNAME', 'localhost');

/**
 * Database name
 * require to connect with database
 ** Which database to connect
 */
define('DATABASE_NAME', 'sc_management');

/**
 * Database user username
 * require to connect with database
 ** Username to use in connection
 */
define('DATABASE_USERNAME', 'root');

/**
 * Database user password
 * require to connect with database
 ** Password for the use to use in connection
 */
define('DATABASE_PASSWORD', 'root');

/**
 * Database charset
 * require to create table in database
 */
define('DATABASE_CHARSET', 'utf8');

/**
 * Database table prefix
 * Prepend to table name
 */
define('TABLE_PREFIX', '');

/**
 * Default user image name
 * when user doesn't uploaded an image this image will be in use
 * Image should be placed in public/uploads/image/ directory with this name
 */
define('DEFAULT_USER_IMAGE_NAME', 'user.png');

/**
 * Student id initialization
 * start student id from
 */
define('STUDENT_ID_START_FROM', '000000000000001');

# Maximum image file size in MB
define('MAX_IMAGE_UPLOAD_SIZE', 10);

# Handle installation
define('APP_INSTALLED', '');

/**
 * Installer IP
 * If same required to create super admin
 */
define('APP_INSTALLER_IP', '');

/**
 * Environment
 */
define('APP_ENVIRONMENT', 'development');

/**
 * Show pdo error mode - bool
 * turn off in production
 */
if (APP_ENVIRONMENT === 'development') {
    define('SHOW_PDO_ERROR', true);
} else {
    define('SHOW_PDO_ERROR', false);
}