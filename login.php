<?php
session_start();

$isConnected = false;

$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db', 'root', '');

if (isset($_POST['formconnexion'])) {
    if (isset($_POST['mailconnect']) && isset($_POST['mdpconnect'])) {

        $mailconnect = htmlspecialchars($_POST['mailconnect']);
        $mdpconnect = md5($_POST['mdpconnect']);
        if (!empty($mailconnect) and !empty($mdpconnect)) {
            $requser = $bdd->prepare("SELECT * FROM users WHERE mail = ? AND motdepasse = ?");
            $requser->execute(array($mailconnect, $mdpconnect));
            $userexist = $requser->rowCount();
            if ($userexist == 1) {
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['pseudo'] = $userinfo['pseudo'];
                $_SESSION['mail'] = $userinfo['mail'];
                header("Location: index.php");
                $isConnected = true;
            } else {
                $erreur = "Mauvais mail ou mot de passe !";
            }
        } else {
            $erreur = "Tous les champs doivent être complétés !";
        }
    }
} else {
    include('login.html');
}
