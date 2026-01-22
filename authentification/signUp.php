<?php 
    require_once('./../traitement/traitement_signup.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>

    <div class="auth-container">
        <h1>Inscription</h1>

        <a href="./../accueil.php" class="auth-link">← Retour à l'accueil</a>

        <form action="./../traitement/traitement_signup.php" method="post" class="auth-form">

            <label>Nom</label>
            <input type="text" name="nom_membre" required>

            <label>Prénom</label>
            <input type="text" name="prenom_membre" required>

            <label>Email</label>
            <input type="email" name="email_membre" required>

            <label>Mot de passe</label>
            <input type="password" name="mdp_membre" required>

            <button type="submit" name="btn">Enregistrer</button>

        </form>
    </div>

</body>
</html>
