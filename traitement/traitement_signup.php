<?php

    require_once('./../configDb/database.php');

    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btn'])) {
                if (isset($_POST['nom_membre']) && isset($_POST['prenom_membre']) && isset($_POST['email_membre']) && isset($_POST['mdp_membre'])) {
                    
                    $nom_membre = trim($_POST['nom_membre']);
                    $prenom_membre = trim($_POST['prenom_membre']);
                    $email_membre  = trim($_POST['email_membre']);
                    $mdp_membre = trim($_POST['mdp_membre']);

                    if (!empty($nom_membre && $mdp_membre)) {

                        $query = "INSERT INTO membre (nom_membre, prenom_membre, email_membre, mdp_membre) 
                                  VALUES (:nom_membre, :prenom_membre, :email_membre, :mdp_membre)";     
                        $stmt = $connection->prepare($query);
                        $stmt->bindValue(':nom_membre', $nom_membre);
                        $stmt->bindValue(':prenom_membre', $prenom_membre);
                        $stmt->bindValue(':email_membre', $email_membre);
                        $stmt->bindValue(':mdp_membre', $mdp_membre);
                        $stmt->execute();

                        header('Location: ./../authentification/login.php');

                    }else{
                        echo "<script>
                                alert('Veuillez remplir le champ');
                                window.location.href = './../authentification/signUp.php';
                              </script>";

                    }
                }
            }else {
                echo "<script>alert('Il y une erreur');</script>";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e;
    }    

?>