<?php
header('Content-Type: application/json');

// JSON verisini al
$data = json_decode(file_get_contents('php://input'), true);

// İd'yi kontrol et
if (isset($data['id'])) {
    $id = $data['id'];

    // Veritabanı bağlantısı
    $pdo = new PDO('mysql:host=localhost;dbname=openmytask', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL sorgusu
    $sql = "DELETE FROM mynotes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    // Sorguyu çalıştır ve sonucu kontrol et
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID belirtilmemiş.']);
}
?>