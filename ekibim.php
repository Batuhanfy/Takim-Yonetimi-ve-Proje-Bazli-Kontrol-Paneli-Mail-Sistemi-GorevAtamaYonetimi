
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

function truncateText($text, $length = 10) {
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
    <title>My Mails</title>
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
<div id="message" class="overlay" style="display:none;">
        <div class="popup-content">
            <p id="message-content">{message-content}</p>
            <p id="howissent" style="display:none"></p>
            <button onclick="closePopup()">Kapat</button>
            <button onclick="reMessage()" style="bottom: 20%;background: #444;">Cevap Yaz</button>

        </div>

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








    <div id="addNoteDiv" class="mt-3">
    <input id="username_sending_konu" class="form-control mb-2" placeholder="Konu"></input>

    <div id="ekipno" style="display: none"><?php echo $ekip; ?></div>
            <textarea id="newNote" class="form-control mb-2" placeholder="Mesajınızı buraya yazın.."></textarea>
            <button id="saveNoteButton" class="btn btn-success">Gönder</button>
        </div>

    
<?php if($ekip != 0){  ?>



    <div class="account-edit-tab fade-in-down-4">

    <div class="butonlar-notes">
    <span class="info-text">Ekibiniz</span>
        <span><span class="sendmailekip" id="addNoteButton" ><img src="openmytask/send.svg" alt="Ekle">Tüm Ekibe Mesaj Gönder</span></span>
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
  <span class="<?php echo $uye['yetki'] == "Admin" ? 'baslik' : 'text'; ?>"><img src="openmytask/user-refresh.svg" alt="MailGonderen"> <?php echo $uye['username']; ?></span>
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
        </div> </div>
    </div>


    <?php }else{
                print_r("<div class='no-ekip'><h3> Herhangi bir ekibe atama yapanmadınız.</h3></div>");

    }  ?>
    <script>

        const myNotesDivs = document.querySelectorAll('.my-notes-menu');
        const deleteButton = document.getElementById('deleteNote');
        let selectedNoteId = null;
        const addNoteButton = document.getElementById('addNoteButton');
        const addNoteDiv = document.getElementById('addNoteDiv');
        const saveNoteButton = document.getElementById('saveNoteButton');
        const messagecontent = document.getElementById('message-content');
        const whoissentbilgi = document.getElementById('howissent');
        const id= document.getElementsByClassName('my-notes-menu').getElementById;
        
        addNoteButton.addEventListener('click', () => {
            mailgonderkutusu("");
        });
      function mailgonderkutusu(isim){
        addNoteDiv.style.display = 'flex';
      

     
       document.getElementById('username_sending').value = isim;
    
      }
       
        myNotesDivs.forEach(div => {
            div.addEventListener('click', () => {
              
                myNotesDivs.forEach(d => d.classList.remove('selected_note'));
                selectedNoteId = div.id;
                deleteButton.style.display = 'flex';



                fetch('view_mail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: selectedNoteId})
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
           
                messagecontent.innerHTML=data.mail_bilgisi;
                
                whoissentbilgi.innerHTML=data.whoissent;


                document.getElementById('message').style.display = 'flex';

            } else {
                alert('Teknik Hata: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));

                
                div.classList.add('selected_note');
               
                messagecontent.innerHTML='Mesaj';
                console.log(div.id);


            
            });
        });


        deleteButton.addEventListener('click', () => {
            if (selectedNoteId && confirm("Bu maili silmek istediğinize emin misiniz?")) {


                const noteToDelete = document.getElementById(selectedNoteId);
                if (noteToDelete) {
                    
                fetch('delete_mail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: selectedNoteId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                        const noteToDelete = document.getElementById(selectedNoteId);
                        if (noteToDelete) {
                            noteToDelete.remove();
                        }
                        deleteButton.style.display = 'none';
                        selectedNoteId = null;
                    } else {
                        alert('Not silinirken bir hata oluştu.');
                    }
                })
                .catch(error => console.error('Error:', error));
                }
                
                deleteButton.style.display = 'none';
                selectedNoteId = null;
            }
        });

function notGonder(){
    const newNote = document.getElementById('newNote').value;
    const konu = document.getElementById('username_sending_konu').value;
    const ekip = document.getElementById('ekipno').innerHTML;

    if (newNote.trim() !== "" && kime.trim() !== "") {
        fetch('send_mail_ekip.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ note: newNote,konu: konu ,ekip:ekip})
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
                alert("Mailiniz ekip üyelerine başarıyla gönderildi.");
                window.location.reload(); 
            } else {
                alert('Hata: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Not ve kullanıcı adı boş olamaz.');
    }
}
        saveNoteButton.addEventListener('click', () => {
   notGonder();
});
function closePopup() {
            document.getElementById('message').style.display = 'none';
        }


        function reMessage() {
            const whosend = document.getElementById('howissent').innerHTML;

            document.getElementById('message').style.display = 'none';
          
            mailgonderkutusu(whosend);
        }
    </script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>


                        