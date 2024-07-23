<?php

$host = 'localhost'; 
$db = 'openmytask'; 
$user = 'root'; 
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Veritabanına bağlanırken bir hata oluştu: ' . $e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['note']) && !empty($data['note'])) {
    $note = $data['note'];

    $sql = "INSERT INTO mynotes (note, date) VALUES (:note, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':note', $note, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'id' => $id]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Not eklenirken bir hata oluştu: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Not boş olamaz.']);
}
?>
