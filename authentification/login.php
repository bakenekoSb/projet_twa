<?php 
    require_once('./../traitement/traitement_login.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>

    <div class="auth-container">
        <h1>Connexion</h1>

        <a href="signUp.php" class="auth-link">S'inscrire</a>

        <form action="./../traitement/traitement_login.php" method="post" class="auth-form">

            <label>Nom</label>
            <input type="text" name="nom_membre" required>

            <label>Mot de passe</label>
            <input type="password" name="mdp_membre" required>

            <button type="submit" name="btn_login">Se connecter</button>

        </form>
    </div>

</body>
</html>
