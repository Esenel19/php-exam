<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db', 'root', '');

if (isset($_GET['id']) and $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
?>
    <html>

    <head>
        <title>TUTO PHP</title>
        <meta charset="utf-8">
    </head>

    <body>
        <div align="center">
            <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
            <br /><br />
            Pseudo = <?php echo $userinfo['pseudo']; ?>
            <br />
            Mail = <?php echo $userinfo['mail']; ?>
            <br />
            <?php
            if (isset($_SESSION['id']) and $userinfo['id'] == $_SESSION['id']) {
            ?>
                <br />
                <a href="edit_account.php">Editer mon profil</a>
                <a href="index.php">Retour à l'Acceuil</a>
                <a href="logout.php">Se déconnecter</a>
            <?php
            }
            ?>
        </div>
    </body>

    </html>
<?php
}
?>