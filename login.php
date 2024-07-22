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

        // SQL sorgusu ile kullanıcıyı veritabanında ara
        $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kullanıcı bulunduysa, şifreyi kontrol et
        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['loggedin']=true;
            $_SESSION['username']=$username;
        } else {

        echo "hatalı";

            //
        }
    } 
} catch (PDOException $e) {
    echo 'Veritabanı bağlantı hatası: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="main.css" rel="stylesheet">

</head>
<body>
   
<body>

<div class="headings_login fade-in-down-4">
    <div class="logo"><img src="images/openmytask_2.png"></div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  <div class="username"><span><input type="input" placeholder="Kullanıcı Adınız"> </span></div>
  <div class="password"><span><input type="password" placeholder="Şifreniz"> </span></div>
  <div class="login_button"><span style="display:flex;"> <button type="submit" class="log"><img src="openmytask/login.svg" alt="Login">Login</button>  <button type="button" onclick="window.location.href='register.php'" class="reg"> <img src="openmytask/register.svg" alt="Register">Sign up</button></span></div>
</div> </form>
 
  

</div>
    
</div>


</div>

</body>
</html>