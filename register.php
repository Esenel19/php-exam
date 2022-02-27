<?php
$bdd = new PDO('mysql:host=127.0.0.1;dbname=php_exam_db', 'root', '');

if (isset($_POST['forminscription'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = md5($_POST['mdp']);
    $mdp2 = md5($_POST['mdp2']);
    if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mail2']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {
        $pseudolength = strlen($pseudo);
        if ($pseudolength <= 255) {
            if ($mail == $mail2) {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                    $reqmail = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    $requser = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
                    $requser->execute(array($pseudo));
                    $userexist = $requser->rowCount();
                    if ($mailexist == 0 && $userexist == 0) {

                        if ($mdp == $mdp2) {
                            $insertmbr = $bdd->prepare("INSERT INTO users(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            $erreur = "Votre compte a bien été créé ! <a href=\"login.php\">Me connecter</a>";
                        } else {
                            $erreur = "Vos mots de passes ne correspondent pas !";
                        }
                    } else {
                        if ($mailexist > 0) {
                            $erreur_mail = "Adresse mail déjà utilisée !";
                        }
                        if ($userexist > 0) {
                            $erreur_pseudo = $pseudo . " déjà utilisée";
                        }
                    }
                } else {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }
            } else {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        } else {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>TUTO PHP</title>
    <meta charset="utf-8">
</head>

<body>
    <div align="center">
        <h2>Inscription</h2>
        <br /><br />
        <form method="POST" action="">
            <table>
                <tr>
                    <td align="right">
                        <label for="pseudo">Pseudo :</label>
                    </td>
                    <td>
                        <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) {
                                                                                                            echo $pseudo;
                                                                                                        } ?>" />
                        <?php
                        if (isset($erreur_pseudo)) {
                            echo '<font color="red">' . $erreur_pseudo . "</font>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if (isset($mail)) {
                                                                                                        echo $mail;
                                                                                                    } ?>" />
                        <?php
                        if (isset($erreur_mail)) {
                            echo '<font color="red">' . $erreur_mail . "</font>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail2">Confirmation du mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if (isset($mail2)) {
                                                                                                                    echo $mail2;
                                                                                                                } ?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp2">Confirmation du mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="center">
                    <br />
                    <a href="login.php">Vous avez déjà un compte, connectez vous ici.</a>
                        <br />
                        <input type="submit" name="forminscription" value="Je m'inscris" />
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($erreur)) {
            echo '<font color="red">' . $erreur . "</font>";
        }
        ?>
    </div>
</body>

</html>