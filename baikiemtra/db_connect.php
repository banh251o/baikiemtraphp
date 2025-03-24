<?php
$host = 'localhost';
$dbname = 'kiemtra';
$username = 'root'; // Mặc định của XAMPP
$password = '';     // Mặc định của XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>