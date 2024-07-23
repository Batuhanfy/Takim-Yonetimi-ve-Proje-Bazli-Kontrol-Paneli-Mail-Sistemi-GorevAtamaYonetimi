<?php
session_start();
session_regenerate_id(true);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $_SESSION['loggedin']=false;
 session_destroy();
   header("Location: login.php");
} else {
    header("Location: dashboard.php");

    // header("Location: login.php");
    // die();
}
?>