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
 ** Prepend to table name
 */
define('TABLE_PREFIX', '');

# Maximum image file size in MB
define('MAX_IMAGE_UPLOAD_SIZE', '10');

# Optimize image
define('CLONE_IMAGE_IN_DIFFERENCE_SIZE', false);

# Handle installation
define('APP_INSTALLED', false);