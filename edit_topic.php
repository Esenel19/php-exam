<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=php_exam_db;charset=utf8", "root", "");
session_start();
$r = session_id();
$mode_edition = 0;
// echo $r;
// echo "<br>";
// echo  $_SESSION['id'];
if (isset($_SESSION['id'])) {
    // $$bdd->prepare('SELECT * FROM f_topics WHERE id = ?');

    if (isset($_GET['edit']) and !empty($_GET['edit'])) {
        $mode_edition = 1;
        $edit_id = htmlspecialchars($_GET['edit']);
        $edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
        $edit_article->execute(array($edit_id));
        if ($edit_article->rowCount() > 0) {
            $info_article = $edit_article->fetch();
            if ($_SESSION['id'] != $info_article['id_createur']) {
                $message = "Vous ne pouvez éditer que vos articles.";
            }
        } else {
            die('Erreur : l\'article n\'existe pas...');
        }
    }
    if (isset($_POST['article_titre'], $_POST['article_contenu'])) {
        if (!empty($_POST['article_titre']) and !empty($_POST['article_contenu'])) {

            $article_titre = htmlspecialchars($_POST['article_titre']);
            $article_contenu = htmlspecialchars($_POST['article_contenu']);
            if ($mode_edition == 0) {
                $ins = $bdd->prepare('INSERT INTO articles (sujet, contenu, date_heure_creation) VALUES (?, ?, NOW())');
                $ins->execute(array($article_titre, $article_contenu));
                $message = 'Votre article a bien été posté';
            } else {
                $update = $bdd->prepare('UPDATE articles SET sujet = ?, contenu = ?, date_time_edition = NOW() WHERE id = ?');
                $update->execute(array($article_titre, $article_contenu, $edit_id));
                header('Location: http://127.0.0.1/php_exam/edit_topic.php?edit=' . $edit_id);
                $message = 'Votre article a bien été mis à jour !';
            }
        } else {
            $message = 'Veuillez remplir tous les champs';
        }
    }
} else {
    $message = "Veuillez vous connecter pour poster un nouveau topic";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Rédaction / Edition</title>
    <meta charset="utf-8">
</head>

<body>

    <?php if (!isset($message)) { ?>
        <!-- //var_dump($message); -->
        <form method="POST">
            <input type="text" name="article_titre" placeholder="Titre" <?php if ($mode_edition == 1) { ?> value="<?=
                                                                                                                    $info_article['sujet'] ?>" <?php } ?> /><br />
            <textarea name="article_contenu" placeholder="Contenu de l'article"><?php if ($mode_edition == 1) { ?><?=
                                                                                                                    $info_article['contenu'] ?><?php } ?></textarea><br />
            <input type="submit" value="Envoyer l'article" />
        </form>
        <br />
    <?php } else {
        echo $message;
    } ?>
</body>
<a href="index.php">Retour à l'Acceuil</a>

</html>