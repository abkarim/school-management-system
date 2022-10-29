<?php
/**
 ** This file handle all database operations
 */

# Include config file
require_once __DIR__ . '/../../config.php';

class QueryError {}

class Query extends QueryError {
    private $_connection   = null;
    private $_table_prefix = TABLE_PREFIX;

    /**
     * Setup connection
     * @param Connection database connection
     */
    public function __construct($db) {
        $this->_connection = $db;
    }

################################ Create table start ###################################

    /**
     * Create table school // TODO
     * @return Query for method chaining
     */
    public function create_table_school() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "school (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            )";
        $this->_connection->exec($sql);
        return $this;
    }

    /**
     * Create user table
     * @return Query for method chaining
     */
    public function create_table_user() {

        return $this;
    }

    /**
     * Create sessions table
     * @return Query for method chaining
     */
    public function create_table_session() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "session (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            access_token VARCHAR(200) NOT NULL,
            access_token_expiry DATETIME NOT NULL,
            refresh_token VARCHAR(200) NOT NULL,
            refresh_token_expiry DATETIME NOT NULL,
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
    public function create_table_grade() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "grade (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            min INT NOT NULL,
            from INT NOT NULL,
            name VARCHAR(200) NOT NULL,
            grade_point VARCHAR(10) NOT NULL,
            grade_type VARCHAR(200) NOT NULL,
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
    public function create_table_student() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "student (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(500) NULL,
            name VARCHAR(500) NOT NULL,
            group VARCHAR(500) NULL,
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
    public function create_table_transaction() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "transaction (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(500) NULL,
            type VARCHAR(500) NULL,
            amount VARCHAR(50) NOT NULL,
            paid_by VARCHAR(500) NOT NULL,
            comment VARCHAR(500) NULL,
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
    public function create_table_teacher() {
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
    public function create_table_accountant() {

        return $this;
    }

    /**
     * Create table librarian
     * @return Query for method chaining
     */
    public function create_table_librarian() {

        return $this;
    }

    /**
     * Create table event
     * @return Query for method chaining
     */
    public function crate_table_event() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "event (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NULL,
            date DATETIME NULL,
            duration VARCHAR(500) NULL,
            comment VARCHAR(500) NULL,
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
    public function create_table_notice() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "notice (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NULL,
            visible DATETIME NOT NULL,
            duration DATETIME NULL,
            comment VARCHAR(500) NULL,
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
    public function create_table_class() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "class (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            class_id VARCHAR(500) NOT NULL,
            name VARCHAR(500) NOT NULL,
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
    public function create_table_attendance() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "attendance (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            class_id VARCHAR(500) NULL,
            student_id VARCHAR(500) NOT NULL,
            comment VARCHAR(1000) NULL,
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
    public function create_table_holiday() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "holiday (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            date DATETIME NOT NULL,
            repeat INT(1) NOT NULL DEFAULT 0,
            comment VARCHAR(1000) NULL,
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
    public function create_table_exam() {

        return $this;
    }

    /**
     * Create table result
     * @return Query for method chaining
     */
    public function create_table_result() {

        return $this;
    }

    /**
     * Create image table
     * @return Query for method chaining
     */
    public function create_table_image() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "image (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
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
    public function create_table_media() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "media (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(500) NOT NULL,
            type VARCHAR(500) NOT NULL,
            permission VARCHAR(500) NOT NULL,
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
    public function create_table_request() {
        $sql = "CREATE TABLE " . $this->_table_prefix . "request (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            subject VARCHAR(500) NOT NULL,
            text MEDIUMTEXT NOT NULL,
            permission VARCHAR(500) NOT NULL,
            status VARCHAR(100) NOT NULL,
            comment VARCHAR(500) NULL,
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
    public function create_table_book() {

        return $this;
    }

################################ Create table end ###################################

}