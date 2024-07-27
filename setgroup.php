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

if (isset($data['ekip']) && !empty($data['username'])) {
    $ekip = $data['ekip'];
    $username = $data['username'];


    $hata = 0;

     
        $sql =  "UPDATE users set ekip=:ekipno where username=:username";
        $stmt = $pdo->prepare($sql);

        
        $stmt->bindParam(':ekipno', $ekip, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR); 

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $hata += 1;
        }
    

    if ($hata == 0) {
        echo json_encode(['success' => true, 'message' => 'Eklendi.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'eklenemedi.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz veya eksik veriler.']);
}
?>
