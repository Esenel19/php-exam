<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db;charset=utf8', 'root', '');
session_start();
$requser = $bdd->prepare("SELECT * FROM users WHERE id = ?");
$requser->execute(array($_SESSION['id']));
$user = $requser->fetch();
// var_dump($user);
if (isset($_SESSION['id']) and $user['admin'] != 0) {
    if (isset($_GET['type']) and $_GET['type'] == 'membre') {

        if (isset($_GET['supprime']) and !empty($_GET['supprime'])) {
            $supprime = (int) $_GET['supprime'];
            $req = $bdd->prepare('DELETE FROM users WHERE id = ?');
            $req->execute(array($supprime));
        }
    }
    if (isset($_GET['type']) and $_GET['type'] == 'article') {

        if (isset($_GET['supprime']) and !empty($_GET['supprime'])) {
            $supprime = (int) $_GET['supprime'];
            $req = $bdd->prepare('DELETE FROM articles WHERE id = ?');
            $req->execute(array($supprime));
        }
    }
} else {
    $message = "Vous n'êtes pas autorisé ici.";
}
$membres = $bdd->query('SELECT * FROM users ORDER BY id DESC LIMIT 0,5');
$articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT 0,5');

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Administration</title>
</head>

<body>
    <?php if (!isset($message)) { ?>
        <ul>
            <?php while ($m = $membres->fetch()) { ?>
                <li><?= $m['id'] ?> : <?= $m['pseudo'] ?> - <a href="admin_panel.php?type=membre&supprime=<?= $m['id'] ?>">Supprimer</a></li>
            <?php } ?>
        </ul>
        <br>
        <ul>

            <?php while ($a = $articles->fetch()) { ?>
                <?= var_dump($a); ?>
                <li><?= $a['id'] ?> : <?= $a['sujet'] ?> - <a href="admin_panel.php?type=article&supprime=<?= $a['id'] ?>">Supprimer</a></li>
            <?php } ?>
        </ul>
        <a href="logout.php">Se déconnecter</a>
    <?php } else {
        echo $message;
    } ?>
    


</body>

</html>