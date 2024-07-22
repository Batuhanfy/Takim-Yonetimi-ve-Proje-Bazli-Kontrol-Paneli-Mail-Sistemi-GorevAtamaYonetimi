<?php 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo 'Merhaba, ' . htmlspecialchars($_SESSION['username']) . '!';
} else {
    // header("Location: login.php");
    // die();
}
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


    <title>Dashboard</title>
    <style>
        .headings {
            display: flex;
            width: 100%;
            height: 100px;
            background-color: aliceblue;
            align-content: center;
            align-items: center;
        }

        .headings img {
            height: 75px;
        }

        .welcome {
            margin-top: 70px;
            display: flex;
            justify-content: center;
            align-content: center;
            align-items: center;
        }

        .welcome h3 {
            font-family: Montserrat;
            font-weight: 400;

        }

        .fade-in-down {
            opacity: 0;
            transform: translateY(-70px);
            animation: fadeInDown 1s ease forwards;
        }

        .fade-in-down-2 {
            opacity: 0;
            transform: translateY(-10px);
            animation: fadeInDown 1s ease forwards;
        }


        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .factions {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .faction {
            font-family: 'Open Sans';
            box-shadow: 1px 1px 10px 0px #f2f2f2;
            margin: 20px;
            display: flex;
            width: 150px;
            font-weight: 400;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            flex-direction: column;
            background: #ffffff;
            padding: 20px;
        }

        .faction:hover {
            background: #b9b9b912;
            cursor: pointer;
        }

        .faction.image {
            width: 100%;
            height: 100%;
        }

        .image {
            height: 75px;
        }

        .image img {
            height: 100%;
        }

        .card_title {
            text-align: center;
            margin: 3px;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .account {
            box-shadow: 1px 1px 11px 0px #f6f6f6;
    padding: 3px 15px 3px 15px;
    border-radius: 100px;
    background: #fff;
    display: flex;
    position: absolute;
    right: 50px;
    flex-wrap: nowrap;
    align-content: center;
    justify-content: center;
    align-items: center;
        }
        .account:hover{
            background: #fffff8;
            cursor: pointer;
        }

        .account_dev {
            display: flex;
    font-family: Montserrat;
    font-size: 11px;
    font-weight: 500;
    color: #042651;
    flex-direction: column;
    align-content: center;
    justify-content: center;
    align-items: flex-start;
        }
        .account_dev .name{
            font-weight:400;
        }
        .account_dev .auth{
            font-weight:600;
        }

        .account_dev img{
            height: 15px;
    margin-right: 15px;
        }
    </style>
</head>

<body>

    <div class="headings">
        <div class="logo"><img src="images/openmytask.png"></div>
        <div class="account">
        <span class="account_dev"><img src="openmytask/user.svg" alt="Notlarım"></span>
            <span class="account_dev"> <span class="name">Batuhan Korkmaz</span> <span class="auth">Proje Yöneticisi </span> </span>     

        </div>
    </div>

    <div class="welcome">
        <h3 class="fade-in-down">Hoşgeldiniz, Bay Batuhan!</h3>
    </div>

    <div class="container factions">
        <div class="row">
            <div class="col faction fade-in-down-2 ">
                <div class="image"><img src="openmytask/mynotes.svg" alt="Notlarım"></div>
                <div class="card_title">Notlarım</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/mail.svg" alt="Notlarım"></div>
                <div class="card_title">Gelen Kutusu</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/alarm.svg" alt="Notlarım"></div>
                <div class="card_title">Görevler</div>
            </div>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/calendar.svg" alt="Notlarım"></div>
                <div class="card_title">Takvim</div>
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

    echo "Veritabanı bağlantısı başarılı!";
} catch (PDOException $e) {
    echo "Veritabanı bağlantısı başarısız: " . $e->getMessage();
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