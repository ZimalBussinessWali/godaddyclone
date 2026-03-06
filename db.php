<?php
// Database connection configuration
$host = 'localhost';
$dbname = 'rsk80_41';
$username = 'rsk80_41';
$password = '123456';

try {
    // Establishing a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // If connection fails, output error and stop
    die("Connection failed: " . $e->getMessage());
}

// Start user session for global authentication
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
