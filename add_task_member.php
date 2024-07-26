<?php
session_start();
session_regenerate_id(true);

require 'database.php';

$usernames = "";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $usernames = $_SESSION['username'];
} else {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı giriş yapmamış.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['gorev_konusu']) && !empty($data['date1']) && isset($data['date2']) && !empty($data['aciklamasi']) && !empty($data['gorev_username'])) {
    $gorev_konusu = $data['gorev_konusu'];
    $date1 = $data['date1'];
    $date2 = $data['date2'];
    $aciklamasi = $data['aciklamasi'];
    $gorev_username = $data['gorev_username'];

    $hata = 0;

        $sql = "INSERT INTO mytask (id, username, whoisset, task, aciklamasi, startDate, endDate) VALUES (:id, :username, :whoisset, :task, :aciklamasi, :startDate, :endDate)";
        $stmt = $pdo->prepare($sql);

        // Güvenli ID oluşturma yöntemi
        $ids = bin2hex(random_bytes(5));

        // Parametreleri bağlama
        $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
        $stmt->bindParam(':whoisset', $usernames, PDO::PARAM_STR); 
        $stmt->bindParam(':username', $gorev_username, PDO::PARAM_STR);
        $stmt->bindParam(':task', $gorev_konusu, PDO::PARAM_STR);
        $stmt->bindParam(':aciklamasi', $aciklamasi, PDO::PARAM_STR);
        $stmt->bindParam(':startDate', $date1, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $date2, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $hata += 1;
        }
    

    if ($hata == 0) {
        echo json_encode(['success' => true, 'message' => 'Eklendi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Bazı görevler eklenemedi.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz veya eksik veriler.']);
}
?>
