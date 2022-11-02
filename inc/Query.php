<?php
/**
 ** This file handle all database operations
 */

# Include config file
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/CustomException.php';

class Query extends CustomException {
    private $_connection   = null;
    private $_table_prefix = TABLE_PREFIX;

    /**
     * Setup connection
     * @param Connection database connection
     */
    public function __construct(PDO $db) {
        $this->_connection = $db;
    }

################################ Create table start ###################################

    /**
     * Create table school
     * @return Query for method chaining
     */
    public function create_table_school(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "school (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                school_id VARCHAR(500) NOT NULL,
                name VARCHAR(500) NOT NULL,
                location VARCHAR(500) NOT NULL,
                image VARCHAR(500) NULL,
                admin_id_list VARCHAR(500) NULL,
                created_by VARCHAR(500) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create user table
     * @return Query for method chaining
     */
    public function create_table_user(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "user (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(500) NOT NULL,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NOT NULL,
            username VARCHAR(500) UNIQUE NOT NULL,
            password VARCHAR(500) NOT NULL,
            image VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create sessions table
     * @return Query for method chaining
     */
    public function create_table_session(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "session (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(500) NOT NULL,
            access_token VARCHAR(200) NOT NULL,
            access_token_expiry DATETIME NOT NULL,
            refresh_token VARCHAR(200) NOT NULL,
            refresh_token_expiry DATETIME NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            ip_address VARCHAR(200) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table grade
     * @return Query for method chaining
     */
    public function create_table_grade(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "grade (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            min INT NOT NULL,
            name VARCHAR(200) NOT NULL,
            grade_point VARCHAR(10) NOT NULL,
            grade_type VARCHAR(200) NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table student
     * @return Query for method chaining
     */
    public function create_table_student(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "student (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(500) NULL,
            name VARCHAR(500) NOT NULL,
            student_group VARCHAR(500) NULL,
            section VARCHAR(500) NULL,
            class VARCHAR(500) NULL,
            father_name VARCHAR(500) NOT NULL,
            mother_name VARCHAR(500) NOT NULL,
            blood_group VARCHAR(50) NULL,
            birth_date VARCHAR(100) NOT NULL,
            address VARCHAR(500) NULL,
            mobile_number VARCHAR(50) NULL,
            father_mother_number VARCHAR(50) NULL,
            mother_mobile_number VARCHAR(50) NULL,
            email VARCHAR(500) NULL,
            father_email VARCHAR(500) NULL,
            mother_email VARCHAR(500) NULL,
            image VARCHAR(500) NOT NULL,
            father_image VARCHAR(500) NULL,
            mother_image VARCHAR(500) NULL,
            fee_amount VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table transaction
     * @return Query for method chaining
     */
    public function create_table_transaction(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "transaction (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(500) NULL,
            type VARCHAR(500) NULL,
            amount VARCHAR(50) NOT NULL,
            paid_by VARCHAR(500) NOT NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table teacher
     * @return Query for method chaining
     */
    public function create_table_teacher(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "teacher (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            teacher_id VARCHAR(500) NULL,
            name VARCHAR(500) NOT NULL,
            father_name VARCHAR(500) NOT NULL,
            mother_name VARCHAR(500) NOT NULL,
            blood_group VARCHAR(50) NULL,
            birth_date VARCHAR(100) NOT NULL,
            address VARCHAR(500) NULL,
            mobile_number VARCHAR(50) NULL,
            department VARCHAR(500) NULL,
            designation VARCHAR(500) NULL,
            email VARCHAR(500) NULL,
            salary_amount VARCHAR(500) NULL,
            image VARCHAR(500) NOT NULL,
            join_date DATETIME NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table accountant
     * @return Query for method chaining
     */
    public function create_table_accountant(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "accountant (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            accountant_id VARCHAR(500) NULL,
            name VARCHAR(500) NOT NULL,
            father_name VARCHAR(500) NOT NULL,
            mother_name VARCHAR(500) NOT NULL,
            blood_group VARCHAR(50) NULL,
            birth_date VARCHAR(100) NOT NULL,
            address VARCHAR(500) NULL,
            mobile_number VARCHAR(50) NULL,
            email VARCHAR(500) NULL,
            salary_amount VARCHAR(500) NULL,
            image VARCHAR(500) NOT NULL,
            join_date DATETIME NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table librarian
     * @return Query for method chaining
     */
    public function create_table_librarian(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "librarian (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            librarian_id VARCHAR(500) NULL,
            name VARCHAR(500) NOT NULL,
            father_name VARCHAR(500) NOT NULL,
            mother_name VARCHAR(500) NOT NULL,
            blood_group VARCHAR(50) NULL,
            birth_date VARCHAR(100) NOT NULL,
            address VARCHAR(500) NULL,
            mobile_number VARCHAR(50) NULL,
            email VARCHAR(500) NULL,
            salary_amount VARCHAR(500) NULL,
            image VARCHAR(500) NOT NULL,
            join_date DATETIME NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table event
     * @return Query for method chaining
     */
    public function create_table_event(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "event (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NULL,
            date DATETIME NULL,
            duration VARCHAR(500) NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table notice
     * @return Query for method chaining
     */
    public function create_table_notice(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "notice (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NULL,
            visible DATETIME NOT NULL,
            duration DATETIME NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table class
     * @return Query for method chaining
     */
    public function create_table_class(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "class (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            class_id VARCHAR(500) NOT NULL,
            name VARCHAR(500) NOT NULL,
            teacher_id VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table attendance
     * @return Query for method chaining
     */
    public function create_table_attendance(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "attendance (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            class_id VARCHAR(500) NULL,
            student_id VARCHAR(500) NOT NULL,
            comment VARCHAR(1000) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table holiday
     * @return Query for method chaining
     */
    public function create_table_holiday(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "holiday (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            date DATETIME NOT NULL,
            is_repeat INT(1) NOT NULL DEFAULT 0,
            comment VARCHAR(1000) NULL,
            school_id VARCHAR(500) NOT NULL,
            created_by VARCHAR(200) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table exam
     * @return Query for method chaining
     */
    public function create_table_exam(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "exam (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NOT NULL,
            start_date VARCHAR(500) NOT NULL,
            end_date VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            comment VARCHAR(500) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table routine
     * @return Query for method chaining
     */
    public function create_table_routine(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "routine (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NOT NULL,
            date DATETIME NULL,
            duration INT NULL,
            teacher VARCHAR(500) NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            comment VARCHAR(500) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table result
     * @return Query for method chaining
     */
    public function create_table_result(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "result (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            exam_id VARCHAR(500) NOT NULL,
            user_id VARCHAR(500) NOT NULL,
            point VARCHAR(500) NULL,
            detail MEDIUMTEXT NULL,
            school_id VARCHAR(500) NOT NULL,
            comment VARCHAR(500) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create image table
     * @return Query for method chaining
     */
    public function create_table_image(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "image (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) UNIQUE NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            user_id VARCHAR(500) NOT NULL,
            common INT(1) NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create media table
     * Store all type of file info
     * @return Query for method chaining
     */
    public function create_table_media(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "media (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NOT NULL,
            permission VARCHAR(500) NOT NULL,
            school_id VARCHAR(500) NOT NULL,
            user_id VARCHAR(500) NOT NULL,
            added_by VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table request
     * @return Query for method chaining
     */
    public function create_table_request(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "request (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            subject VARCHAR(500) NOT NULL,
            text MEDIUMTEXT NOT NULL,
            permission VARCHAR(500) NOT NULL,
            status VARCHAR(100) NOT NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            added_by VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table book
     * @return Query for method chaining
     */
    public function create_table_book(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "book (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book_id VARCHAR(500) NOT NULL,
            name VARCHAR(500) NOT NULL,
            total_available VARCHAR(500) NULL,
            image VARCHAR(500) NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            added_by VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create table book transaction
     * @return Query for method chaining
     */
    public function create_table_book_transaction(): Query {
        $sql = "CREATE TABLE " . $this->_table_prefix . "book_transaction (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            book_id VARCHAR(500) NOT NULL,
            user_id VARCHAR(500) NOT NULL,
            quantity VARCHAR(500) NOT NULL,
            duration VARCHAR(500) NULL,
            comment VARCHAR(500) NULL,
            school_id VARCHAR(500) NOT NULL,
            added_by VARCHAR(500) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";
        $this->_connection->exec($sql);
        return $this;
    }

################################ Create table end ###################################

    /**
     * Insert data
     * @param string table name
     * @param array [column name => value]
     */
    public function insert(string $table_name, array $data): bool {
        $sql     = "INSERT INTO $table_name ";
        $columns = "";
        $values  = "";
        $index   = 0;

        # Handle column and value
        foreach ($data as $column => $value) {
            if ($index > 0) {
                $columns .= ", $column";
                $values .= ", $value";
            } else {
                $columns .= $column;
                $values .= $value;
            }

            $index++;
        }

        $sql .= "( $columns ) VALUES ( $values )";

        # Execute query
        return $this->_connection->exec($sql);
    }

    /**
     * Update data
     * @param string table name
     * @param array [column name => value]
     * @param array [column => value] where to update
     * @param int how many
     */
    public function update(string $table_name, array $data, array $where, int $limit): array{
        $sql = "UPDATE $table_name SET ";

        # Handle column and value to update
        foreach ($data as $column => $value) {
            $sql .= "$column = $value ";
        }

        $sql .= "WHERE ";

        # Handle column and data where to update
        foreach ($where as $column => $value) {
            $sql .= "$column = $value ";
        }

        $sql .= "LIMIT $limit"; // TODO

        # Execute query
        $this->_connection->exec($sql);
    }

}
