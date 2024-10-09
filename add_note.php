<?php
session_start();
session_regenerate_id(true);

require 'database.php';

$username="";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {

}


$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['note']) && !empty($data['note'])) {
    $note = $data['note'];
   $ids=rand(1,5000);
    $sql = "INSERT INTO mynotes (id,user,note, date) VALUES (:id,:user,:note, NOW())";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
    $stmt->bindParam(':user', $username, PDO::PARAM_STR);
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
