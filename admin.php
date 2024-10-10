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
            if ($yetki != "Admin") {
                header("Location: dashboard.php");
                die();
            }
        } else {
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

    <div id="ban_user" class="overlay" style="display:none;">
        <div class="popup-content">
            <p id="message-content">Hesap Engelleme / Banlama Sistemi</p>
            <input id="gorev_username" class="form-control mb-2" placeholder="Erişimi Engellenecek Kullanıcı Adı"></input>



            <button onclick="document.getElementById('ban_user').style.display='none';">Kapat</button>
            <button onclick="ban_user()" style="bottom: 20%;background: #444;">Erişimini Engelle</button>

        </div>
    </div>

    <div id="unban_user" class="overlay" style="display:none;">
        <div class="popup-content">
            <p id="message-content">Erişim Engelini Kaldırma Paneli</p>
            <input id="unbanuser_username" class="form-control mb-2" placeholder="Erişimi Açılacak Kullanıcı Adı"></input>



            <button onclick="document.getElementById('unban_user').style.display='none';">Kapat</button>
            <button onclick="unban_user()" style="bottom: 20%;background: #444;">Erişimini Aç</button>

        </div>
    </div>

    <div id="moderator_add" class="overlay" style="display:none;">
        <div class="popup-content">
            <p id="message-content">Yeni Moderatör Tanımlama Paneli</p>
            <input id="moderator_username" class="form-control mb-2" placeholder="Moderatör Tanımlanacak Kişi Username"></input>
            <span>Moderatörler, kullanıcılara yeni görevler tanımlama, sisteme yeni üye ekleme, ekibine üye alımı , ekibine görev tanımlama yetkilerine sahiptir. Ekipleri
                yönetecek kullanıcılarınızın moderatör olarak tanımlanması gerekmektedir.
            </span>


            <button onclick="document.getElementById('moderator_add').style.display='none';">Kapat</button>
            <button onclick="moderator_adds();" style="bottom: 20%;background: #444;">Moderatör Yetkisini Tanımla</button>

        </div>
    </div>


    <div id="admin_add" class="overlay" style="display:none;">
        <div class="popup-content">
            <p id="message-content">Yeni Admin Tanımlama Paneli</p>
            <input id="admin_username" class="form-control mb-2" placeholder="Admin Tanımlanacak Kişi Username"></input>
            <span>Admin yetkisi tanımladığınız kişi admin paneli dahil tüm yetkilere sahip olmaktadır.
            </span>


            <button onclick="document.getElementById('admin_add').style.display='none';">Kapat</button>
            <button onclick="admin_adds();" style="bottom: 20%;background: #444;">Admin Yetkisini Tanımla</button>

        </div>
    </div>



    <div class="welcome-admin">
        <h3 class="fade-in-down">Yönetici Paneline Hoşgeldiniz, Sayın <?php print_r($username); ?></h3>
    </div>

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
            <h3>Kullanıcılar</h3>

            <div class="container text-center">
                <div class="row uyeler-1">
                    <?php
                    $sql = "SELECT username, ban, email, telefon, gorev FROM users";
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
                                <div class="user-cell">Ban Durumu</div>
                            </div>
                            <?php foreach ($users as $user) { ?>
                                <div class="user-row">
                                    <div class="user-cell"><?php echo htmlspecialchars($user['username']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['email']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['telefon']); ?></div>
                                    <div class="user-cell"><?php echo htmlspecialchars($user['gorev']); ?></div>
                                    <div class="user-cell"><?php echo $user['ban'] == 1 ? 'Erişim Engeli Var' : ''; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p>Hiç kullanıcı bulunamadı.</p>
                    <?php } ?>
                </div>
            </div>

            <div class="container panelbuttons">
                <div class="admin_button" onclick="document.getElementById('ban_user').style.display='flex';">Erişim Engeli Tanımla</div>
                <div class="admin_button" onclick="document.getElementById('unban_user').style.display='flex';">Erişim Engeli Aç</div>
                <div class="admin_button" onclick="document.getElementById('moderator_add').style.display='flex';">Moderatör Tanımla</div>
                <div class="admin_button" onclick="document.getElementById('admin_add').style.display='flex';">Admin Tanımla</div>

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

    <script>
        function ban_user() {

            document.getElementById('ban_user').style.display = "none";

            const gorev_username = document.getElementById('gorev_username').value;

            if (gorev_username.trim() !== "") {



                fetch('member_ban.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            gorev_username: gorev_username

                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Başarıyla kullanıcı engellendi..");
                            window.location.reload();

                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })

                    .catch(error => console.error('Error:', error));


            } else {
                alert('Boş alan olamaz.');
            }


        }



        function unban_user() {

            document.getElementById('unban_user').style.display = "none";

            const gorev_username = document.getElementById('unbanuser_username').value;

            if (gorev_username.trim() !== "") {



                fetch('member_unban.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            gorev_username: gorev_username

                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Başarıyla kullanıcı engeli kaldırıldı.");
                            window.location.reload();

                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })

                    .catch(error => console.error('Error:', error));


            } else {
                alert('Boş alan olamaz.');
            }
        }



        function moderator_adds() {

            document.getElementById('moderator_add').style.display = "none";

            const gorev_username = document.getElementById('moderator_username').value;

            if (gorev_username.trim() !== "") {



                fetch('moderator_add.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            gorev_username: gorev_username

                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Başarıyla kullanıcı yetkilendirildi..");
                            window.location.reload();

                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })

                    .catch(error => console.error('Error:', error));


            } else {
                alert('Boş alan olamaz.');
            }

        }


        function admin_adds() {

            document.getElementById('admin_add').style.display = "none";

            const gorev_username = document.getElementById('admin_username').value;

            if (gorev_username.trim() !== "") {



                fetch('admin_add.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            gorev_username: gorev_username

                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Başarıyla kullanıcı yetkilendirildi..");
                            window.location.reload();

                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })

                    .catch(error => console.error('Error:', error));


            } else {
                alert('Boş alan olamaz.');
            }

        }
    </script>
</body>

</html>