<?php
$host = 'localhost'; // Veritabanı sunucusu
$dbname = 'openmytask'; // Veritabanı adı
$user = 'root'; // Veritabanı kullanıcı adı
$pass = ''; // Veritabanı şifresi

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($result && ($password == $result['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            print_r("istek geldi");

            header('Location: dashboard.php');
        } else {

            $error_message = 'Giriş başarısız! Lütfen kullanıcı adı ve şifreyi kontrol edin.';
            echo '<script>
                    window.onload = function() {
                        var myModalhataliGiris = new bootstrap.Modal(document.getElementById("hataliGiris"), options)
                        myModalhataliGiris.show();
                    }
                  </script>';
        }
    }
} catch (PDOException $e) {
    $error_message = 'Veritabanı bağlantı hatası: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link href="main.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <body>

        <div class="headings_login fade-in-down-4">
            <div class="logo"><img src="images/openmytask_2.png"></div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="hataliGiris" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container uye_cont fade-in-down">
            <div class="welcome-login fade-in-down">
                <h3>Welcome to the OpenMyTask!</h3>
                <form action="login.php" method="post">
                    <div class="uye_formu">
                        <div class="username"><span><input type="input" placeholder="Kullanıcı Adınız" name="username"> </span></div>
                        <div class="password"><span><input type="password" placeholder="Şifreniz" name="password"> </span></div>
                        <div class="login_button"><span style="display:flex;"> <button type="submit" class="log"><img src="openmytask/login.svg" alt="Login">Login</button> <button type="button" onclick="window.location.href='register.php'" class="reg"> <img src="openmytask/register.svg" alt="Register">Sign up</button></span></div>
                    </div>
                </form>

                <div class="login_with">
                       <span><img src="openmytask/google.svg" alt="Google"></span>
                       <span>1</span>
                       <span>1</span>
                       <span>1</span>
                       <span>1</span>
                    </div>


            </div>

        </div>


        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>

</html>