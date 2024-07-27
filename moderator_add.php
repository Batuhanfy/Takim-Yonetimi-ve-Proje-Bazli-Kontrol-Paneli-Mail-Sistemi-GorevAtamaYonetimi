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

if ( !empty($data['gorev_username'])) {
    $gorev_username = $data['gorev_username'];

    $hata = 0;

        $sql =  "UPDATE users set yetki='Supervisor' where username=:usernames";
        $stmt = $pdo->prepare($sql);

        $ids = bin2hex(random_bytes(5));

        $stmt->bindParam(':usernames', $gorev_username, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $hata += 1;
        }
    

    if ($hata == 0) {
        echo json_encode(['success' => true, 'message' => 'Erişimi engellendi..']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Veritabanı Kaynaklı Erişim Engeli Sağlanamadı.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz veya eksik veriler.']);
}
?>
