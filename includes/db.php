<?php
include_once 'config.php';

// Function to query the database
function query($sql, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
