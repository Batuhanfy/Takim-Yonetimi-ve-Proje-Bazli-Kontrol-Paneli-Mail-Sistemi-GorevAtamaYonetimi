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







    <div id="addTaskMembers" class="mt-3" style="display:none;">
        <input id="gorev_konusu" class="form-control mb-2" placeholder="Görevi Giriniz"></input>
        <input id="date1" type="datetime-local" class="form-control mb-2"></input>
        <input id="date2" type="datetime-local" class="form-control mb-2"></input>


        <div id="ekipno" style="display: none"><?php echo $ekip; ?></div>
        <textarea id="aciklamasi" class="form-control mb-2" placeholder="Açıklamasını buraya yazın.."></textarea>
        <button id="addTaskMembersButton" class="btn btn-success" onclick="addTaskMembers()">Gönder</button>
    </div>

    <div id="addNoteDiv" class="mt-3">
        <input id="username_sending_konu" class="form-control mb-2" placeholder="Konu"></input>

        <div id="ekipno" style="display: none"><?php echo $ekip; ?></div>
        <textarea id="newNote" class="form-control mb-2" placeholder="Mesajınızı buraya yazın.."></textarea>
        <button id="saveNoteButton" class="btn btn-success" >Gönder</button>
    </div>
    
    <div id="addMemberdiv" class="mt-3" style="display:none;">
        <input id="username" class="form-control mb-2" placeholder="Kullanıcı Adı"></input>

        <div id="ekipno" style="display: none"><?php echo $ekip; ?></div>
        <button id="addButtons" class="btn btn-success">Ekle</button>
    </div>

    <?php if ($ekip != 0) {  ?>



        <div class="account-edit-tab fade-in-down-4">

            <div class="butonlar-notes">
                <span class="info-text">Ekibiniz</span>
                <?PHP if ($yetki == "Supervisor") { ?> <span  onclick="addMembers('')"><span class="sendmailekip" id="addMember"><img src="openmytask/add.svg" alt="Ekle">Ekibe Üye Ekle</span></span><?php } ?>

                <?PHP if ($yetki == "Supervisor") { ?> <span onclick="openaddtaskmenu()"><span class="addtaskekip" id="addTaskEkip"><img src="openmytask/add.svg" alt="Ekle" >Ekibe Yeni Görev Ekle</span></span><?php } ?>
                <span><span class="sendmailekip" id="addNoteButton"><img src="openmytask/send.svg" alt="Ekle">Tüm Ekibe Mesaj Gönder</span></span>
            </div>
            <div class="gelenkutusu">
                <div class="mailler">
                    <?php
                    foreach ($ekipuyeleri as $uye) {
                    ?>
                        <div class="my-notes-menu" id="<?php print_r($uye['id']); ?>">


                            <div class="container text-center">
                                <div class="row">



                                    <div class="col">
                                        <span class="<?php echo $uye['yetki'] == "Supervisor" ? 'baslik' : 'text'; ?>"><img src="openmytask/user-refresh.svg" alt="MailGonderen"> <?php echo $uye['username']; ?><?php echo $uye['yetki'] == "Supervisor" ? ' (Moderator)' : ''; ?></span>
                                    </div>
                                    <div class="col">
                                        <span class="text"> <?php echo $uye['email']; ?></span>
                                    </div>
                                    <div class="col">
                                        <span class="text"><?php echo $uye['telefon']; ?></span>
                                    </div>
                                    <div class="col">
                                        <span class="text"><?php echo $uye['isim']; ?></span>
                                    </div>
                                    <div class="col">
                                        <span class="text"><?php echo $uye['soyisim']; ?></span>
                                    </div>

                                </div>
                            </div>

                        </div>






                    <?php } ?>
                </div>
            </div>
        </div>


    <?php } else {
        print_r("<div class='no-ekip'><h3> Herhangi bir ekibe atama yapanmadınız.</h3></div>");
    }  ?>
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

addNoteButton.addEventListener('click', () => {
    mailgonderkutusu("");
});



function addMembers(isim) {
    addMemberdiv.style.display = 'flex';
}

function mailgonderkutusu(isim) {
    addNoteDiv.style.display = 'flex';
}


function openaddtaskmenu(){
    document.getElementById('addTaskMembers').style.display = 'flex';
}
function addTaskMembers() {
    
    const gorev_konusu = document.getElementById('gorev_konusu').value;
    const date1 = document.getElementById('date1').value;
    const date2 = document.getElementById('date2').value;
    const aciklamasi = document.getElementById('aciklamasi').value;
    const ekip = document.getElementById('ekipno').innerHTML;


    if (gorev_konusu.trim()!== "" && date1.trim()!== "" && date2.trim()!== "" && aciklamasi.trim()!== "") {
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