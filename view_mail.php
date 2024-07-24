<?php 

require 'database.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];

    $sql = "select note FROM mymails WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $notem = $stmt->fetchColumn();

    

    if ($stmt->execute()) {
        echo json_encode(['success' => true,'mail_bilgisi'=>$notem]);


    $sql_okundu_bilgisi = "update mymails set okundu =1 where id = :id";
    $stmt2= $pdo->prepare($sql_okundu_bilgisi);
    $stmt2->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt2->execute();
    



    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID belirtilmemiş.']);
}
?>