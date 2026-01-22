<?php 
require_once('./../configDb/database.php'); 
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_emprunts']) && is_array($_POST['id_emprunts']) && !empty($_POST['id_emprunts'])) {
            
            if (!isset($_SESSION['id_membre'])) {
                header('Location: ./../authentification/login.php');
                exit;
            }

            $id_emprunts = $_POST['id_emprunts'];  // Tableau d'IDs
            $membre_id = $_SESSION['id_membre'];
            $count_retournes = 0;
            $erreurs = 0;

            // Boucle sur chaque emprunt sélectionné
            foreach ($id_emprunts as $id_emprunt) {
                $id_emprunt = intval($id_emprunt);  // Sécurité: convertir en entier

                // Vérifier que l'emprunt appartient au membre
                $query = "SELECT livre_id FROM emprunts WHERE id_emprunt = :id_emprunt AND membre_id = :id_membre";
                $stmt = $connection->prepare($query);
                $stmt->bindValue(':id_emprunt', $id_emprunt);
                $stmt->bindValue(':id_membre', $membre_id);
                $stmt->execute();
                $emprunt = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$emprunt) {
                    $erreurs++;
                    continue;  // Passer au suivant
                }

                $livre_id = $emprunt['livre_id'];

                // Supprimer l'emprunt
                $query = "DELETE FROM emprunts WHERE id_emprunt = :id_emprunt";
                $stmt = $connection->prepare($query);
                $stmt->bindValue(':id_emprunt', $id_emprunt);
                $stmt->execute();

                // Mettre à jour l'état du livre
                $query = "UPDATE livres SET etat_livre = 'libre' WHERE id_livre = :livre_id";
                $stmt = $connection->prepare($query);
                $stmt->bindValue(':livre_id', $livre_id);
                $stmt->execute();

                $count_retournes++;
            }

            // Message personnalisé
            $message = "$count_retournes livre(s) retourné(s) avec succès";
            if ($erreurs > 0) {
                $message .= " ($erreurs erreur(s))";
            }

            echo "<script>
                alert('$message');
                window.location.href = './../accueil.php';
            </script>";
            exit;
        }
    }
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
