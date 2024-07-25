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


    $sql5 = "select count(*) from users where username=:user";
    $stmt5 = $pdo->prepare($sql5);
    $stmt5->bindParam(':user', $kime, PDO::PARAM_STR);
    $stmt5->execute();
    $isuser = $stmt5->fetchColumn();

   if($isuser <= 0){
    echo json_encode(['success'=> false,'message'=> 'Kullanıcı Mevcut Değil']);
    exit;
   }

    
   $sql7 = "select count(*) from users where ekip=:ekip";
   $stmt7 = $pdo->prepare($sql7);
   $stmt7->bindParam(':ekip', $ekip, PDO::PARAM_STR);
   $stmt7->execute();
   $howmany = $stmt7->fetchColumn();

   for($i=0; $i<$howmany; $i+=1){
   

    $sql = "INSERT INTO mymails (id,user, kime, note,konu) VALUES (:id,:user, :kime, :note,:konu)";
    $stmt = $pdo->prepare($sql);

    $ids=rand(1,5000);
    
    $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
    $stmt->bindParam(':kime', $kime, PDO::PARAM_STR);
    $stmt->bindParam(':konu', $konu, PDO::PARAM_STR);

    $stmt->bindParam(':note', $note, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'id' => $id]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Mail gönderilirken bir hata oluştu: ' . $e->getMessage()]);
    }


   }


} else {
    echo json_encode(['success' => false, 'message' => 'Mailboş olamaz.']);
}
?>
