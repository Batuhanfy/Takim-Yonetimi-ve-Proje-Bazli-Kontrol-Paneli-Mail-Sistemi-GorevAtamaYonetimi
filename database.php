<?php

$host = 'localhost'; // Veritabanı sunucu adı (IP adresi veya localhost)
$db = 'openmytask'; // Veritabanı adı
$user = 'root'; // Veritabanı kullanıcı adı
$pass = ''; // Veritabanı şifresi

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanına bağlanırken bir hata oluştu: ' . $e->getMessage()]);
    exit;
}
?>