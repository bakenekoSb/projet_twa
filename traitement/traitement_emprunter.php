<?php

   require_once('./../configDb/database.php');
   session_start();

    try {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_livre'])) {
                    
                $livre_id = $_POST['id_livre'];
                $membre_id = $_SESSION['id_membre'];

                //Vérifier l'etat
                $query = "SELECT etat_livre FROM livres where id_livre = :id_livre";
                $stmt = $connection->prepare($query);
                $stmt->bindValue(':id_livre', $livre_id);
                $stmt->execute();
                $etat = $stmt->fetchColumn(); //ceci retourne tout seumplement la valeur qu lieu de tableau avec clé et valeur

                if ($etat == 'emprunte') {

                    echo "<script>
                            alert('deja emprunte');
                            window.location.href = './../accueil.php';
                        </script>";
                        exit;

                }else {

                    if (!isset($_SESSION['id_membre'])) {

                        header('Location: ./../authentification/login.php');
                        exit;

                    }
                        
                    $date_debut = date('Y-m-d');
                    $timestamp = strtotime('+14 days');
                    $date_fin = date('Y-m-d', $timestamp);

                    $query = "INSERT INTO emprunts (livre_id, membre_id, date_debut, date_fin) VALUES (:livre_id, :membre_id, :date_debut, :date_fin)";
                    $stmt = $connection->prepare($query);
                    $stmt->bindValue(':livre_id', $livre_id);
                    $stmt->bindValue(':membre_id', $membre_id);
                    $stmt->bindValue(':date_debut', $date_debut);
                    $stmt->bindValue(':date_fin', $date_fin);
                    $stmt->execute();

                    $queryEtat = "UPDATE livres SET etat_livre = 'emprunte' WHERE id_livre = :livre_id";
                    $stmtEtat = $connection->prepare($queryEtat);
                    $stmtEtat->bindValue(':livre_id', $livre_id);
                    $stmtEtat->execute();

                    $_SESSION['just_borrowed'] = true;  // Flag pour afficher la modal des emprunts

                    echo "<script>
                            alert('Emprunt avec succès');
                            window.location.href = './../accueil.php';
                        </script>";
                    exit;

                }

            }
        }
    
    }catch (PDOException $e) {

        echo "Error" . $e;

    }

?>