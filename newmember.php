<!DOCTYPE html>
<?php session_start();
session_regenerate_id(true);
require 'database.php';

$username = "{username}";
$gorev = "{yetki}";
$mail = "{mail}";
$telefon = "{telefon}";
$yetki = "{yetki}";
$ekip = 0;


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

        if (isset($row['ekip']) && $row['ekip'] !== false) {
            $ekip = $row['ekip'];
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

        if($yetki =="Admin" || $yetki == "Supervisor"){
            
        }else {
            header("Location: login.php");
            die();
        }
    }
} catch (PDOException $e) {
}

function truncateText($text, $length = 10)
{
    if (strlen($text) <= $length) {
        return $text;
    }

    return mb_substr($text, 0, $length, 'UTF-8') . '....';
}

$sql = "SELECT id,yetki,username,email,telefon,isim,soyisim FROM users WHERE ekip = :ekip ORDER BY username asc";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':ekip', $ekip, PDO::PARAM_STR);

$stmt->execute();

$ekipuyeleri = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($username == "admin")
    $gorev = "Sistem Yöneticisi";

?>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekibim</title>
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


  <div class="newmember_container">
  <div class="newmember_form">
  <form action="register.php" method="post">
                <div class="uye_formu">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Kullanıcı Adınız" name="username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Şifreniz" name="password" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Telefon" name="telefon">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Görev" name="gorev">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="İsim" name="isim" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Soyisim" name="soyisim" required>
                    </div>
                    <div class="login_button">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>
  </div>
  </div>




    <script>
        const myNotesDivs = document.querySelectorAll('.my-notes-menu');

        let selectedNoteId = null;
        const addNoteButton = document.getElementById('addNoteButton');
        const addMember = document.getElementById('addMember');
        const addNoteDiv = document.getElementById('addNoteDiv');
        const addMemberdiv = document.getElementById('addMemberdiv');
        const saveNoteButton = document.getElementById('saveNoteButton');
        const addButtons = document.getElementById('addButtons');
        const messagecontent = document.getElementById('message-content');
        const whoissentbilgi = document.getElementById('howissent');
        const deleteButton = document.getElementById('deleteButton'); // Tanımlanmamış bir öğe varsa, HTML'de eklemelisiniz



        function addMembers(isim) {
            addMemberdiv.style.display = 'flex';
        }

        function mailgonderkutusu(isim) {
            addNoteDiv.style.display = 'flex';
        }


        function openaddtaskmenu() {
            document.getElementById('addTaskMembers').style.display = 'flex';
        }

        function addTaskMembers() {

            const gorev_konusu = document.getElementById('gorev_konusu').value;
            const date1 = document.getElementById('date1').value;
            const date2 = document.getElementById('date2').value;
            const aciklamasi = document.getElementById('aciklamasi').value;
            const ekip = document.getElementById('ekipno').innerHTML;


            if (gorev_konusu.trim() !== "" && date1.trim() !== "" && date2.trim() !== "" && aciklamasi.trim() !== "") {
                fetch('add_task.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            gorev_konusu: gorev_konusu,
                            date1: date1,
                            date2: date2,
                            aciklamasi: aciklamasi,
                            ekip: ekip
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Görev ekip üyelerine başarıyla eklendi.\nKendinize de taslak olarak ekledi. ");
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


        function notGonder() {
            const newNote = document.getElementById('newNote').value;
            const konu = document.getElementById('username_sending_konu').value;
            const ekip = document.getElementById('ekipno').innerHTML;

            if (newNote.trim() !== "") {
                fetch('send_mail_ekip.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            note: newNote,
                            konu: konu,
                            ekip: ekip
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Mailiniz ekip üyelerine başarıyla gönderildi.\nKendinize de taslak olarak gönderildi. Gelen kutunuzdan kontrol ediniz.");
                            window.location.reload();
                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Not boş olamaz.');
            }
        }

        function kisiyiekle() {
            const username = document.getElementById('username').value;
            const ekip = document.getElementById('ekipno').innerHTML;

            if (username.trim() !== "") {
                fetch('uye_ekle_ekip.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            username: username,
                            ekip: ekip,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Ekip üyesi eklendi.");
                            window.location.reload();
                        } else {
                            alert('Hata: ' + data.message);
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));

                alert("İşleme alınıyor... Kullanıcı bulunursa ekibe eklenecek");
                window.location.reload();
            } else {
                alert('username boş olamaz.');
            }
        }

        saveNoteButton.addEventListener('click', () => {
            notGonder();
        });

        addButtons.addEventListener('click', () => {
            kisiyiekle();
        });

        function closePopup() {
            document.getElementById('message').style.display = 'none';
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>