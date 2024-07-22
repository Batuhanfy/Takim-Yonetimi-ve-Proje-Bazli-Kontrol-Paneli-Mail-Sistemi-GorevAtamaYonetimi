<?php 
session_start();
$username="{username}";
$gorev="{yetki}";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username=$_SESSION['username'];
} else {
     header("Location: login.php");
     die();
}



$host = 'localhost';
$db = 'openmytask';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


try {
    $sql = "SELECT gorev FROM users WHERE username = :username";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    
    $stmt->execute();
    
    $auth = $stmt->fetchColumn();

    if ($auth !== false) {
$gorev=$auth;
    } else {


    }
    
} catch (PDOException $e) {
}

if ($username=="admin")
    $gorev="Sistem Yöneticisi";

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cards.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="main.css" rel="stylesheet">


    <title>Dashboard</title>
  
</head>

<body>

    <div class="headings fade-in-down-4">
        <div class="logo"><img src="images/openmytask.png"></div>
        <div class="account">
        <span class="account_dev"><img src="openmytask/user.svg" alt="Notlarım"></span>
            <span class="account_dev"> <span class="name"><?php echo $username; ?></span> <span class="auth"><?php echo $gorev; ?> </span> </span>     
<div class="details">details</div>
        </div>
    </div>

    <div class="welcome">
        <h3 class="fade-in-down">Hoşgeldiniz, Sayın <?php print_r($username); ?></h3>
    </div>

    <div class="container factions">
        <div class="row">
            <div class="col faction fade-in-down-2 ">
                <div class="image"><img src="openmytask/mynotes.svg" alt="Notlarım"></div>
                <div class="card_title">Notlarım</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/mail.svg" alt="Gelen Kutusu"></div>
                <div class="card_title">Gelen Kutusu</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/alarm.svg" alt="Görevler"></div>
                <div class="card_title">Görevler</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/teams.svg" alt="Ekibim"></div>
                <div class="card_title">Ekibim</div>
            </div>

        </div>
    </div>

    <?php 
$dsn = 'mysql:host=localhost;dbname=openmytask';
$username = 'root';
$password = '';

try {
    // PDO örneği oluştur
    $pdo = new PDO($dsn, $username, $password);

    // Hata modu ayarla (Hataları exception olarak fırlatır)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Veritabanı bağlantısı başarılı!";
} catch (PDOException $e) {
    // echo "Veritabanı bağlantısı başarısız: " . $e->getMessage();
}

?>












    <!-- <div class="row">
      <div class="container">
        <div class="grid-row grid-4-4">
        <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="icons/after-effect.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 2</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
          <div class="cards">
            <div class="card_image loading">   <img src="home.svg" alt="SVG resminin açıklaması"></div>
            <div class="card_title loading">Görev 1</div>
            <div class="card_description loading">Bu görevi yapabilecek görev arkadaşları arıyoruz</div>
          </div>
        </div>
      </div>
    </div> -->

</html>