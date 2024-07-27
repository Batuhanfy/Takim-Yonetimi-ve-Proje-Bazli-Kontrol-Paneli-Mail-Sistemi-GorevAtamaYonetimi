<?php 
// Localhost = 0 (Low Security!) (Because its not possible to enable local wamp,etc.. servers sha password authentication)
// Hosting Server ( Live and Using Normally ) = 1 do it here (and go login.php and change this variable)
$ishash256passwordsystem = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    session_start();
    session_regenerate_id(true);
    require 'database.php';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $usernamess = $_SESSION['username'];
    } else {
        header("Location: login.php");
        exit();
    }
    

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $yetki = "Member";
    $gorev = $_POST['gorev'] ?? '';
    $isim = $_POST['isim'] ?? '';
    $soyisim = $_POST['soyisim'] ?? '';

    $id = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

    if($ishash256passwordsystem == 1){
    $hashed_password = hash('sha256', $password);}else {
    $hashed_password = $password;
    }

    
    try {
     

        $stmt = $pdo->prepare("INSERT INTO users (id, username, password, email, telefon, yetki, gorev, isim, soyisim) VALUES (:id, :username, :password, :email, :telefon, :yetki, :gorev, :isim, :soyisim)");
        $stmt->execute([
            'id' => $id,
            'username' => $username,
            'password' => $hashed_password,
            'email' => $email,
            'telefon' => $telefon,
            'yetki' => $yetki,
            'gorev' => $gorev,
            'isim' => $isim,
            'soyisim' => $soyisim
        ]);

        echo "Kayıt başarılı!";
        print_r("<script>alert('Kayıt başarılı');</script>");
        $geldigi_sayfa = $_SERVER['HTTP_REFERER'];  
        echo "<script>document.location.href=\"$geldigi_sayfa\"</script>"; 
    } catch (PDOException $e) {
        echo "Veritabanı bağlantı hatası: " . $e->getMessage();
    }
}
?>