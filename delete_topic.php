<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=php_exam_db;charset=utf8", "root", "");
session_start();
if (isset($_SESSION['id'])) {
    if (isset($_GET['id']) and !empty($_GET['id'])) {
        $edit_id = htmlspecialchars($_GET['id']);
        $edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');

        $edit_article->execute(array($edit_id));
        if ($edit_article->rowCount() > 0) {
            $info_article = $edit_article->fetch();
            if ($_SESSION['id'] != $info_article['id_createur']) {
                echo "Vous ne pouvez supprimer que vos articles.";
            } else {
                $suppr_id = htmlspecialchars($_GET['id']);
                $suppr = $bdd->prepare('DELETE FROM articles WHERE id = ?');
                $suppr->execute(array($suppr_id));
                header('Location: http://127.0.0.1/php_exam/');
            }
        } else {
            die('Erreur : l\'article n\'existe pas...');
        }
    } else {
        echo "Article inexistant.";
    }
} else {
    echo 'Erreur, veuillez vous connecter pour supprimer un article';
}
