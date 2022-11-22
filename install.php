<?php
# Include database connection file
require_once __DIR__ . '/inc/DB.php';

/**
 * Get connection
 * readDB for reading operation
 * writeDB for writing operation
 */
try {
    $writeDB = DB::connect_write_DB();
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

# Include query class
require_once __DIR__ . '/inc/Query.php';
$query = new Query($writeDB);

/**
 * Create table
 */
try {
    $query
        ->create_table_school()
        ->create_table_super_admin()
        ->create_table_admin()
        ->create_table_teacher()
        ->create_table_accountant()
        ->create_table_librarian()
        ->create_table_student()
        ->create_table_session()
        ->create_table_grade()
        ->create_table_transaction()
        ->create_table_event()
        ->create_table_notice()
        ->create_table_class()
        ->create_table_attendance()
        ->create_table_holiday()
        ->create_table_exam()
        ->create_table_routine()
        ->create_table_result()
        ->create_table_image()
        ->create_table_media()
        ->create_table_request()
        ->create_table_book()
        ->create_table_book_transaction();

    // Close connection
    $writeDB = null;

} catch (PDOException $e) {
    echo $e->getMessage();
}
// TODO remove error handler