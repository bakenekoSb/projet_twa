<?php 

    session_start();      // Démarrer la session
    session_destroy();    // Détruire la session

    header("Location: ./../accueil.php"); // Redirection
    exit;

?>