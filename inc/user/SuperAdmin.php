<?php
require_once __DIR__ . '/../trait/ID.php';

class SuperAdmin {
    private static $_table_name      = 'super_admin';
    private static $_initial_user_id = STUDENT_ID_START_FROM + 1;
    
    use ID;
}
