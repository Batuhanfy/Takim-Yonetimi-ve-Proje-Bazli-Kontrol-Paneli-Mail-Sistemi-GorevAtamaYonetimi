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


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {
    echo json_encode(['success' => false, 'message' => 'Kullanıcı giriş yapmamış.']);
    exit;
}

if (isset($data['note']) && !empty($data['note']) && isset($data['ekip']) && !empty($data['ekip']) && !empty($data['konu']) ) {
    $note = $data['note'];
    $ekip = $data['ekip'];
    $konu = $data['konu'];



    $sql7 = "SELECT id, username FROM users WHERE ekip=:ekip";
    $stmt7 = $pdo->prepare($sql7);
    $stmt7->bindParam(':ekip', $ekip, PDO::PARAM_STR);
    $stmt7->execute();
    $users = $stmt7->fetchAll(PDO::FETCH_ASSOC);
 
    $errorcount=0;
    foreach ($users as $user) {
        $sql = "INSERT INTO mymails (id, user, kime, note, konu) VALUES (:id, :user, :kime, :note, :konu)";
        $stmt = $pdo->prepare($sql);
    
        $ids = rand(1, 5000);
    
        // Bind parameters
        $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
        $stmt->bindParam(':user', $username, PDO::PARAM_STR);
        $stmt->bindParam(':kime', $user['username'], PDO::PARAM_STR); 
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->bindParam(':konu', $konu, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            $id = $pdo->lastInsertId();
        } catch (PDOException $e) {
            $errorcount+=1;

        }
    }

    if($errorcount > 0){
        echo json_encode(['success' => false, 'message' => 'Başarısız işlem.']);

    }else {
        echo json_encode(['success' => true, 'message' => 'Gönderildi..']);

    }

} else {
    echo json_encode(['success' => false, 'message' => 'Mailboş olamaz.']);
}
?>
