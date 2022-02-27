<?php
// require('php/config.php'); /* Contient la connexion à la $bdd */
$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db', 'root', '');
$categories = $bdd->query('SELECT * FROM f_categories ORDER BY nom');
$subcat = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_categorie = ? ORDER BY nom');
require('views/forum.view.php');
