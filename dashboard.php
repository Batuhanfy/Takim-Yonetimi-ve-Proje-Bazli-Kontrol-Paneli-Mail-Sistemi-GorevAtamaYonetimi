<?php
session_start();
session_regenerate_id(true);

require 'database.php';


$mail = "{mail}";
$telefon = "{telefon}";
$yetki = "{yetki}";
$unread_mail =0;
$send_message_permission=1;
$use_notes_permission=1;

$username = "{username}";
$gorev = "{yetki}";
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    die();
}





try {
    $sql = "SELECT gorev FROM users WHERE username = :username";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':username', $username, PDO::PARAM_STR);

    $stmt->execute();

    $auth = $stmt->fetchColumn();

    if ($auth !== false) {
        $gorev = $auth;
    } else {
    }
} catch (PDOException $e) {
}

if ($username == "admin")
    $gorev = "Sistem Yöneticisi";

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
  <?php 

try {

  $sqlmail = "SELECT COUNT(*) FROM mymails WHERE kime = :username and okundu=0";
  $stmtmail = $pdo->prepare($sqlmail);
  $stmtmail->bindParam(':username', $username, PDO::PARAM_STR);
  $stmtmail->execute();
  
  $okunmamis_mailler = $stmtmail->fetchColumn();
  $unread_mail=$okunmamis_mailler;




  $sql = "SELECT * FROM users WHERE username = :username";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->execute();

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


  foreach ($rows as $row) {
      if (isset($row['gorev']) && $row['gorev'] !== false) {
          $gorev = $row['gorev'];
      } else {
      }

      if (isset($row['send_message_permission']) && $row['send_message_permission'] !== false) {
        $send_message_permission = $row['send_message_permission'];
    }

    if (isset($row['use_notes_permission']) && $row['use_notes_permission'] !== false) {
      $use_notes_permission = $row['use_notes_permission'];
  }

      if (isset($row['email']) && $row['email'] !== false) {
          $mail = $row['email'];
      } else {
      }

      if (isset($row['telefon']) && $row['telefon'] !== false) {
          $telefon = $row['telefon'];
      } else {
      }

      if (isset($row['yetki']) && $row['yetki'] !== false) {
          $yetki = $row['yetki'];
      } else {
      }
  }
} catch (PDOException $e) {
}
  ?>

    <div class="headings fade-in-down-4">
        <div class="logo"><img src="images/openmytask.png"></div>
        <div class="account">
            <span class="account_dev"><img src="openmytask/user.svg" alt="User"></span>
            <span class="account_dev" id="hesabim"> <span class="name"><?php echo $username; ?></span> <span class="auth"><?php echo $gorev; ?> </span> </span>
            <div class="details">
               <a href="account.php"><span class="inlinebutton mavi">Hesabım</span></a> 
               <a href="logout.php"> <span class="inlinebutton darkblue">Çıkış Yap</span></a>

            </div>




        </div>
    </div>

    <div class="welcome">
        <h3 class="fade-in-down">Hoşgeldiniz, Sayın <?php print_r($username); ?></h3>
    </div>

    <div class="container factions">
        <div class="row">
          <?php if($yetki == "Admin"){?>
<div class="col faction fade-in-down-2 " onClick="window.location.href = 'admin.php';">
<div class="image"><img src="openmytask/admin.svg" alt="Admin"></div>
<div class="card_title">Admin</div>
</div>
        <?php } ?>
        <?php if($use_notes_permission==1){?>

            <div class="col faction fade-in-down-2 " onClick="window.location.href = 'mynotes.php';">
                <div class="image"><img src="openmytask/mynotes.svg" alt="Notlarım"></div>
                <div class="card_title">Notlarım</div>
            </div>
            <?php } ?>

            <?php if($send_message_permission==1){?>
            <div class="col faction fade-in-down-2" onClick="window.location.href = 'gelenkutusu.php';">
                <div class="image"><img src="openmytask/mail.svg" alt="Gelen Kutusu"></div>
                <div class="card_title">Gelen Kutusu</div>
                <?php if ($unread_mail>0){?><span class="notification-badge"><?php echo $unread_mail; ?> Yeni Mesaj</span> <?php }?>
            </div>
            <?php } ?>
            <div class="col faction fade-in-down-2">
                <div class="image"><img src="openmytask/alarm.svg" alt="Görevler"></div>
                <div class="card_title">Görevler</div>
            </div>

            <div class="col faction fade-in-down-2" onClick="window.location.href = 'ekibim.php';">
                <div class="image"><img src="openmytask/teams.svg" alt="Ekibim"></div>
                <div class="card_title">Ekibim</div>
            </div>

        </div>
    </div>

   











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
    <script>

    </script>
</body>

</html>