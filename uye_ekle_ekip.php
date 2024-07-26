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

if (isset($data['username']) && !empty($data['username']) && isset($data['ekip']) && !empty($data['ekip'])) {
    $note = isset($data['note']) ? $data['note'] : '';
    $username = $data['username'];
    $ekip = $data['ekip'];

    $hata = 0;

    $sql5 = "SELECT count(*) FROM users WHERE username=:user";
    $stmt5 = $pdo->prepare($sql5);
    $stmt5->bindParam(':user', $username, PDO::PARAM_STR);
    $stmt5->execute();
    $isuser = $stmt5->fetchColumn();

    if ($isuser <= 0) {
        echo json_encode(['success' => false, 'message' => 'Kullanıcı mevcut değil']);
        exit;
    }

    $sql = "UPDATE users SET ekip = :ekipno WHERE username = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    $stmt->bindParam(':ekipno', $ekip, PDO::PARAM_STR);
    $eklendi=0;
    try {
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Başarıyla eklendi.']);
        $eklendi=1;
    } catch (PDOException $e) {
        $hata += 1;
        echo json_encode(['success' => false, 'message' => 'Bir hata oluştu: ' . $e->getMessage()]);
    }

    if($eklendi==1){

        $sql = "INSERT INTO mymails (id,user, kime, note,konu) VALUES (:id,:user, :kime, :note,:konu)";
        $stmt = $pdo->prepare($sql);
    
        $ids=rand(1,50700);

        $konu="Ekibiniz Değiştirildi.";
        $notes="Ekibinizde değişiklik yapıldığını belirtmek isteriz. Bu bir otomatik mesajdır";

        $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
        $stmt->bindParam(':user', $usernames, PDO::PARAM_STR);
        $stmt->bindParam(':kime', $username, PDO::PARAM_STR);
        $stmt->bindParam(':konu', $konu, PDO::PARAM_STR);
    
        $stmt->bindParam(':note', $notes, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            $id = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'id' => $id]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Mail gönderilirken bir hata oluştu: ' . $e->getMessage()]);
        }
    }




} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz veya eksik veriler.']);
}
?>
