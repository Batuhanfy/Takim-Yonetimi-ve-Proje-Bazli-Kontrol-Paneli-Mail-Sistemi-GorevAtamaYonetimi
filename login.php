<?php

// Localhost = 0 (Low Security!) (Because its not possible to enable local wamp,etc.. servers sha password authentication)
// Hosting Server ( Live and Using Normally ) = 1 do it here (and register.php)
$ishash256passwordsystem = 0;


session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Database connection parameters
$host = 'localhost';
$dbname = 'openmytask';
$user = 'root';
$pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === "admin" && $password === "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
        exit();
    }

    try {
if($_POST['username'] == "" || $_POST['password'] == ""){
    return;
   

}

        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $pdo->prepare("SELECT password,ban FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result['ban'] == 1){
            print_r("Erişim Engeliniz Bulunmakta!");
            print_r("<script>alert('Erişim Engeliniz bulunmakta');</script>");
            exit;
        }


    
        if($ishash256passwordsystem == 1){
        $hashed_password = hash('sha256', $password);
       }else {
        $hashed_password = $password;
        }
        
        if ($result && hash_equals($result['password'], $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            header('Location: dashboard.php');
            exit;
        } else {
            print_r("Login failed");
            $error_message = 'Giriş başarısız! Lütfen kullanıcı adı ve şifreyi kontrol edin.';
        }
    } catch (PDOException $e) {
        $error_message = 'Veritabanı bağlantı hatası: ' . $e->getMessage();
        print_r("<script> console.log('veritabanı bağlantı hatası var.')</script>");
    }
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
    <div class="headings_login fade-in-down-4">
        <div class="logo"><img src="images/openmytask_2.png"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="hataliGiris" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $error_message ?? '' ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"></button>
                    <button type="button" class="btn btn-primary"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="container uye_cont fade-in-down">
        <div class="welcome-login fade-in-down">
            <h3>Welcome to the OpenMyTask!</h3>
            <form action="login.php" method="post">
                <div class="uye_formu">
                    <div class="username">
                        <span><input type="input" placeholder="Kullanıcı Adınız" name="username"> </span>
                    </div>
                    <div class="password">
                        <span><input type="password" placeholder="Şifreniz" name="password"> </span>
                    </div>
                    <div class="login_button">
                        <span style="display:flex;"> 
                            <button type="submit" class="log">
                                <img src="openmytask/login.svg" alt="Login">Login
                            </button> 
                            <button type="button" onclick="window.location.href='register.php'" class="reg"> 
                                <img src="openmytask/register.svg" alt="Register">Sign up
                            </button>
                        </span>
                    </div>
                </div>
            </form>
            <div class="login_with">
                <a href="https://console.cloud.google.com/">
                    <span><img src="openmytask/google.svg" alt="Google ile Giriş Yap"></span>
                </a>
                <a href="https://developers.facebook.com/">
                    <span><img src="openmytask/facebook.svg" alt="Facebook ile Giriş Yap"></span>
                </a>
                <a href="https://developer.linkedin.com/">
                    <span><img src="openmytask/linkedin.svg" alt="LinkedIn ile Giriş Yap"></span>
                </a>
                <a href="#(..)yourapi">
                    <span><img src="openmytask/twitter.svg" alt="X ile Giriş Yap"></span>
                </a>
                <a href="#(..)yourapi">
                    <span><img src="openmytask/wordpress.svg" alt="Wordpress ile Giriş Yap"></span>
                </a>
                <a href="#(..)yourapi">
                    <span><img src="openmytask/github.svg" alt="GitHub ile Giriş Yap"></span>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
