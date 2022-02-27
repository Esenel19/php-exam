<?php
session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=php_exam_db;charset=utf8", "root", "");
$articles = $bdd->query('SELECT * FROM articles ORDER BY date_heure_creation DESC');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css" />
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Faut-Reum</h1>
            <?php
                if(isset($_SESSION['pseudo'])) {
                    // echo "<a href=\"index.php\">Acceuil</a>
                    echo "<a href=\"new_topic.php\">Créer un nouveau topic</a>
                    <a href=\"account.php?id=".$_SESSION['id']."\"><i class=\"fas fa-user-circle\"></i>Profile</a>
                    <a href=\"logout.php\"><i class=\"fas fa-sign-out-alt\"></i>Logout</a>";
                } else {
                    echo "<a href=\"login.php\"><i class=\"fas fa-user-circle\"></i>Se Connecter</a>
                    <a href=\"login_admin.php\"<i class=\"fas fa-user-circle\"></i>Se Connecter (admin)</a>";
                }
                ?>
        </div>
    </nav>

    <ul>
        <?php while ($a = $articles->fetch()) { ?>
            <ul><a href="topic_info.php?id=<?= $a['id'] ?>"><?= $a['sujet'] ?></a> | <a href="edit_topic.php?edit=<?= $a['id'] ?>">Modifier</a> | <a href="delete_topic.php?id=<?= $a['id'] ?>">Supprimer</a></ul>
        <?php } ?>
</body>

</html>