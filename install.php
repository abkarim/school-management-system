<?php
# Include database connection file
require_once __DIR__ . '/core/inc/DB.php';

/**
 * Get connection
 *readDB for reading operation
 * writeDB for writing operation
 */
try {
    $writeDB = DB::connect_write_DB();
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

# Include query class
require_once __DIR__ . '/core/inc/Query.php';
$query = new Query($writeDB);

/**
 * Create table
 */
try {
    $query->create_table_school()
    . create_table_user()
    . create_table_session()
    . create_table_grade();

    echo "Done";
} catch (QueryError $e) {
    echo $e->getMessage();
}
