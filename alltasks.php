<!DOCTYPE html>
<?php session_start();
session_regenerate_id(true);
require 'database.php';


$username = "{username}";
$gorev = "{yetki}";
$mail = "{mail}";
$telefon = "{telefon}";
$yetki = "{yetki}";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    die();
}




try {

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
            if ($yetki == "Admin" || $yetki == "Supervisor") {

            }
        } else {
            header("Location: dashboard.php");
            die();
        }
    }
} catch (PDOException $e) {
}

if ($username == "admin")
    $gorev = "Sistem Yöneticisi";

?>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
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


</head>



<body>




    <div class="headings fade-in-down-4">
        <div class="logo"><img src="images/openmytask.png" onClick="window.location.href='dashboard.php'"></div>
        <div class="account">
            <span class="account_dev"><img src="openmytask/user.svg" alt="Notlarım"></span>
            <span class="account_dev" id="hesabim"> <span class="name"><?php echo $username; ?></span> <span class="auth"><?php echo $gorev; ?> </span> </span>
            <div class="details">
                <a href="account.php"><span class="inlinebutton mavi">Hesabım</span></a>
                <a href="logout.php"> <span class="inlinebutton darkblue">Çıkış Yap</span></a>
            </div>
        </div>
    </div>

    <div class="account-edit-tab-admin fade-in-down-4">

        <div class="account-edit-menu" id="account-edit">
            <h3>Tüm Tanımlanan Görevler</h3>

            <div class="container text-center">
                <div class="row uyeler-1">
                    <?php
                    $sql = "SELECT username, whoisset, task, aciklamasi,startDate,endDate FROM mytask order by endDate desc";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($users)) { ?>
                        <div class="users-container">
                            <div class="user-row header">
                                <div class="user-cell">Kullanıcı Adı</div>
                                <div class="user-cell">Kim Tanımladı</div>
                                <div class="user-cell">Görev</div>
                                <div class="user-cell">Açıklama</div>
                                <div class="user-cell">Başlangıç</div>
                                <div class="user-cell">Bitiş</div>
                            </div>

                            <?php 
                                    $now = new DateTime();

                            foreach ($users as $user) {
                                            $endDate = new DateTime($user['endDate']);

                                ?>
                                <div class="user-row">
                                    <div class="user-cell"><?php echo htmlspecialchars($user['username']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['whoisset']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['task']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['aciklamasi']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['startDate']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['endDate']); ?></div>
                                    <?php  if ($endDate < $now) {   ?>
                                        <div class="user-cell" style="font-weight:bold;">Süresi doldu.</div>

                                        <?php }else{
                                        ?>
                                        <div class="user-cell">Devam ediyor.</div>

                                        <?php }?>

                                   
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Hiç Görev bulunamadı.</p>
                    <?php } ?>
                </div>
            </div>

         
        </div>



        <div class="account-edit-menu" id="account-edit">
            <h3>Moderatörler</h3>
            <div class="container text-center">
                <div class="row uyeler-1">
                    <?php
                    $sql = "SELECT username,yetki, ban, email, telefon, gorev FROM users where yetki='Supervisor'";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($users)) { ?>
                        <div class="users-container">
                            <div class="user-row header">
                                <div class="user-cell">Kullanıcı Adı</div>
                                <div class="user-cell">Email</div>
                                <div class="user-cell">Telefon</div>
                                <div class="user-cell">Görev</div>
                            </div>
                            <?php foreach ($users as $user) { ?>
                                <div class="user-row">
                                    <div class="user-cell"><?php echo htmlspecialchars($user['username']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['email']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['telefon']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['gorev']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Hiç kullanıcı bulunamadı.</p>
                    <?php } ?>
                </div>
            </div>


        </div>




        <div class="account-edit-menu" id="account-edit">
<h3>Admin</h3>
<div class="container text-center">
    <div class="row uyeler-1">
        <?php
        $sql = "SELECT username,yetki, ban, email, telefon, gorev FROM users where yetki='Admin'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (!empty($users)) { ?>
            <div class="users-container">
                <div class="user-row header">
                    <div class="user-cell">Kullanıcı Adı</div>
                    <div class="user-cell">Email</div>
                    <div class="user-cell">Telefon</div>
                    <div class="user-cell">Görev</div>
                </div>
                <?php foreach ($users as $user) { ?>
                    <div class="user-row">
                        <div class="user-cell"><?php echo htmlspecialchars($user['username']); ?></div>
                        <div class="user-cell"><?php echo htmlspecialchars($user['email']); ?></div>
                        <div class="user-cell"><?php echo htmlspecialchars($user['telefon']); ?></div>
                        <div class="user-cell"><?php echo htmlspecialchars($user['gorev']); ?></div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>Hiç kullanıcı bulunamadı.</p>
        <?php } ?>
    </div>
</div>




    </div>

</body>

</html>