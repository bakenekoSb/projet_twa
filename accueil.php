<?php 
    require_once('./configDb/database.php'); 
    session_start();

    $show_modal_emprunts = false;
    $show_modal_retour = false;
    $emprunts_modal = [];
    $message = '';

    if (isset($_POST['btn_retourner']) && !isset($_SESSION['id_membre'])) {
    $_SESSION['open_modal_after_login'] = 'retour';
    header('Location: ./authentification/login.php');
    exit;
}

    // Déterminer quel bouton a été cliqué
    $just_borrowed = isset($_SESSION['just_borrowed']) ? $_SESSION['just_borrowed'] : false;
    $clicked_retourner = isset($_POST['btn_retourner']) ? true : false;

    // Charger les emprunts si connecté
    if (isset($_SESSION['id_membre']) && $_SESSION['id_membre']) {
        $query = "SELECT e.*, l.titre_livre 
                FROM emprunts e 
                JOIN livres l ON e.livre_id = l.id_livre 
                WHERE e.membre_id = :membre_id";
        $stmt = $connection->prepare($query);
        $stmt->bindValue(':membre_id', $_SESSION['id_membre']);
        $stmt->execute();
        $emprunts_modal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Afficher la modal appropriée
        // if ($just_borrowed) {
        //     // Juste après un emprunt réussi, afficher les emprunts actifs
        //     $show_modal_emprunts = true;
        //     unset($_SESSION['just_borrowed']);  // Supprimer le flag
        // } else if ($clicked_retourner) {
        //     // Quand le bouton retourner est cliqué
        //     $show_modal_retour = true;
        // }
        
    // -----------------------------
    // 4️⃣ Ouvrir la modal après login (AJOUT DEMANDÉ)
    // -----------------------------
    if (isset($_SESSION['open_modal_after_login']) 
        && $_SESSION['open_modal_after_login'] === 'retour') {

        $show_modal_retour = true;
        unset($_SESSION['open_modal_after_login']);
    }

    // -----------------------------
    // 5️⃣ Gestion normale des modals
    // -----------------------------
    if ($just_borrowed) {
        $show_modal_emprunts = true;
        unset($_SESSION['just_borrowed']);
    } elseif ($clicked_retourner) {
        $show_modal_retour = true;
    }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque - Accueil</title>
    <link rel="stylesheet" href="./accueil.css">
    <style>
        #modalEmprunts { display: <?= $show_modal_emprunts ? 'block' : 'none' ?>; }
        #modalRetour { display: <?= $show_modal_retour ? 'block' : 'none' ?>; }
    </style>
</head>
<body>
    <header>
        <nav>
            <div style="font-weight: 700; font-size: 1.2rem; color: var(--color-accent);">📚 Bibliothèque</div>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="./authentification/signUp.php">Inscrire</a>
                <a href="./authentification/login.php">Se connecter</a>
                <a href="./authentification/deconnexion.php">Se déconnecter</a>
                <!-- <a href="./livre/crud_livre.php">Gérer les livres</a> -->
            </div>
        </nav>
    </header>

    <main>
        <?php if ($message): ?>
            <div class="alert alert-error">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <h1><img src="img.png" alt="erreur" width="50px" height="40px">  Bibliothèque</h1>

        <!-- Barre de recherche -->
        <div class="search-container">
            <form action="./traitement/traitement_recherche.php" method="post" style="display: flex; gap: 0.5rem; flex: 1;">
                <input type="text" name="recherche_livre" placeholder="Rechercher un livre par titre ou auteur..." required>
                <button type="submit"><img src="search.png" alt="Rechercher" style="width: 25px; height: 25px;"></button>
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <form method="POST">
                <button type="submit" name="btn_retourner">📖 Retourner un livre</button>
            </form>
        </div>

        <!-- liste des livres -->
        <div class="books-container">
            <?php 
            $query = "SELECT * FROM livres ORDER BY id_livre DESC";
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $livres = $stmt->fetchAll();
            
            foreach($livres as $l): ?>
                <div class="livre">
                    <!-- <img src="./<?= htmlspecialchars($l['image_livre']) ?>" alt="" width=100px> -->
                    <h3><?= htmlspecialchars($l['titre_livre']) ?></h3>
                    <div class="livre-meta">
                        <p><strong>Auteur:</strong> <?= htmlspecialchars($l['auteur_livre']) ?></p>
                    </div>
                    <div class="livre-description">
                        <p><?= htmlspecialchars(substr($l['description_livre'], 0, 80)) ?><?= strlen($l['description_livre']) > 80 ? '...' : '' ?></p>
                    </div>
                    <div class="livre-actions">
                        <form action="./traitement/traitement_emprunter.php" method="post">
                            <input type="hidden" name="id_livre" value="<?= $l['id_livre'] ?>">
                            <button type="submit">📤 Emprunter</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- MODAL EMPRUNTS ACTIFS (après emprunt réussi) -->
    <div id="modalEmprunts">
        <div class="modal-content">
            <h2>Emprunt réussi!</h2>
            <p>Voici vos emprunts en cours:</p>
            <div id="selectEmprunts" style="border: 1px solid #ccc; padding: 10px; height: 150px; overflow-y: auto;">
                <?php if (!empty($emprunts_modal)): ?>
                    <?php foreach($emprunts_modal as $emp): ?>
                        <div style="margin: 8px 0; padding: 5px; background: #f5f5f5; border-radius: 3px;">
                            <strong><?= htmlspecialchars($emp['titre_livre']) ?></strong>
                            <br><small style="color: #666;">Retour: <?= date('d/m/Y', strtotime($emp['date_fin'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #999; margin: 0;">Aucun emprunt en cours</p>
                <?php endif; ?>
            </div>
            <br>
            <button type="button" onclick="fermerModalEmprunts()" style="padding:8px 16px; background:#4CAF50; color:white; cursor:pointer; width:100%;">Continuer</button>
        </div>
    </div>

    <!-- MODAL RETOUR (quand clique sur retourner) -->
    <div id="modalRetour">
        <div class="modal-content">
            <h2>Retourner des livres</h2>
            <form method="POST" action="./traitement/traitement_retourner.php">
                <div id="selectLivre" style="border: 1px solid #ccc; padding: 10px; height: 150px; overflow-y: auto;">
                    <?php if ($show_modal_retour && !empty($emprunts_modal)): ?>
                        <?php foreach($emprunts_modal as $emp): ?>
                            <div style="margin: 8px 0;">
                                <input type="checkbox" name="id_emprunts[]" value="<?= $emp['id_emprunt'] ?>" id="emprunt_<?= $emp['id_emprunt'] ?>">
                                <label for="emprunt_<?= $emp['id_emprunt'] ?>" style="cursor: pointer;">
                                    <?= htmlspecialchars($emp['titre_livre']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #999; margin: 0;">Aucun emprunt en cours</p>
                    <?php endif; ?>
                </div>
                <br><br>
                <button type="submit" style="padding:8px 16px; background:#4CAF50; color:white; cursor:pointer;">Confirmer le retour</button>
                <button type="button" onclick="fermerModalRetour()" style="padding:8px 16px; background:#f44336; color:white; cursor:pointer;">Fermer</button>
            </form>
        </div>
    </div>

    <br>

    <script>
    function fermerModalEmprunts() {
        document.getElementById('modalEmprunts').style.display = 'none';
    }
    function fermerModalRetour() {
        document.getElementById('modalRetour').style.display = 'none';
    }
    </script>
</body>
</html>
