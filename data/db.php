<?php
$host = '127.0.0.1';
$port = 3307;          // MySQL portu (XAMPP'de 3307 görünüyor)
$dbname = 'haber';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
