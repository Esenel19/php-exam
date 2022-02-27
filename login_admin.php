<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db', 'root', '');

if (isset($_POST['formconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = md5($_POST['mdpconnect']);
    if (!empty($mailconnect) and !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT * FROM users WHERE mail = ? AND motdepasse = ? AND admin = 1");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: admin_panel.php");
        } else {
            $erreur = "Mauvais mail ou mot de passe ou compte non administrateur!";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>
<html>

<head>
    <title>Connexion Admin</title>
    <meta charset="utf-8">
</head>


<a href="index.php">Retour à l'Acceuil</a>


<body>
    <div align="center">
        <h2>Connexion Admin</h2>
        <br /><br />
        <form method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Se connecter !" />
        </form>
        <?php
        if (isset($erreur)) {
            echo '<font color="red">' . $erreur . "</font>";
        }
        ?>
    </div>
</body>

</html>