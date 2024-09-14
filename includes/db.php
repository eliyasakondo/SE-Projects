<?php
include_once 'config.php';
/*
// Function to query the database
function query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    */
/*
    function get_db_connection() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            return new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
    
    function query($sql, $params = []) {
        $conn = get_db_connection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    function get_last_insert_id() {
        $conn = get_db_connection();
        return $conn->lastInsertId();
    }
        */

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
        
        function query($sql, $params = []) {
            $conn = get_db_connection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        
        function get_last_insert_id() {
            $conn = get_db_connection();
            return $conn->lastInsertId();
        }      
?>
