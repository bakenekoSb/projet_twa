<?php 

    require_once('./../configDb/database.php');

    try {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btn_ajout'])) {
                if (isset($_POST['image_livre']) && isset($_POST['titre_livre']) && isset($_POST['description_livre'] )&& isset($_POST['auteur_livre'])) {
                    
                    $image_livre = trim($_POST['image_livre']);
                    $titre_livre = trim($_POST['titre_livre']);
                    $description_livre = trim($_POST['description_livre']);
                    $auteur_livre = trim($_POST['auteur_livre']);

                    $query = "INSERT INTO livres (image_livre, titre_livre, description_livre, auteur_livre, etat_livre) VALUES (:image_livre, :titre_livre, :description_livre, :auteur_livre, 'libre')";
                    $stmt = $connection->prepare($query);
                    $stmt->bindValue(':image_livre', $image_livre);
                    $stmt->bindValue(':titre_livre', $titre_livre);
                    $stmt->bindValue(':description_livre', $description_livre);
                    $stmt->bindValue(':auteur_livre', $auteur_livre);
                    $stmt->execute();

                    echo "<script>
                            alert('Ajout réussi');
                            window.location.href = './../accueil.php';
                        </script>";

                }
            }
        }    

    } catch (PDOException $e) {
        echo "Erreur: " . $e;
    }
    

?>