<?php
include_once 'config.php';

if (!function_exists('get_db_connection')) {
    function get_db_connection() {
        static $conn;
        if ($conn === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            try {
                $conn = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit;
            }
        }
        return $conn;
    }
}

if (!function_exists('query')) {
    function query($sql, $params = []) {
        $conn = get_db_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}

if (!function_exists('get_last_insert_id')) {
    function get_last_insert_id() {
        $conn = get_db_connection();
        return $conn->lastInsertId();
    }
}
?>