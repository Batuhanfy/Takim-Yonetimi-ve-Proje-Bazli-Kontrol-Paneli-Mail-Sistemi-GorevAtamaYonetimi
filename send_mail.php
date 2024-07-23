<?php
session_start();
session_regenerate_id(true);

require 'database.php';

$username = "";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı giriş yapmamış.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['note']) && !empty($data['note']) && isset($data['kime']) && !empty($data['kime'])) {
    $note = $data['note'];
    $kime = $data['kime'];

    $sql = "INSERT INTO mymails (user, kime, note, date) VALUES (:user, :kime, :note, NOW())";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    $stmt->bindParam(':kime', $kime, PDO::PARAM_STR);
    $stmt->bindParam(':note', $note, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'id' => $id]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Mail gönderilirken bir hata oluştu: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Mailboş olamaz.']);
}
?>
