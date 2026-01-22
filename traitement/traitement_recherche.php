<?php
require_once('./../configDb/database.php');
session_start();

$search_query = '';
$livres = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recherche_livre'])) {
    $search_query = trim($_POST['recherche_livre']);

    if (!empty($search_query)) {
        $query = "SELECT * FROM livres 
                  WHERE titre_livre LIKE :search 
                  OR auteur_livre LIKE :search 
                  ORDER BY id_livre DESC";
        $stmt = $connection->prepare($query);
        $stmt->bindValue(':search', '%' . $search_query . '%');
        $stmt->execute();
        $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($livres)) {
            $message = 'Aucun livre trouvé pour "' . htmlspecialchars($search_query) . '"';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche - Bibliothèque</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f1e9;
            color: #5d4a3a;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        a {
            text-decoration: none;
            color: #6a4f3a;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            font-size: 2.6rem;
            margin-bottom: 25px;
        }

        /* BACK LINK */
        .back-link {
            margin-bottom: 20px;
        }

        /* SEARCH FORM */
        .search-form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .search-form input {
            width: 60%;
            padding: 12px;
            border: 1px solid #d8c9b7;
            border-radius: 4px;
            font-size: 15px;
        }

        .search-form button {
            padding: 12px 20px;
            background: #a47a5c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        /* MESSAGE */
        .message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* LIVRE CARD */
        .livre {
            background: white;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .livre h3 {
            margin-bottom: 8px;
            font-size: 1.4rem;
        }

        .livre p {
            margin: 6px 0;
            font-size: 14px;
        }

        /* BUTTONS */
        .btn-emprunter {
            margin-top: 10px;
            padding: 10px 16px;
            background: #6a4f3a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-disabled {
            margin-top: 10px;
            padding: 10px 16px;
            background: #ccc;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
        }

        /* NO RESULT */
        .no-results {
            text-align: center;
            color: #999;
            padding: 40px;
            font-size: 1.1rem;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="back-link">
        <a href="./../accueil.php">← Retour à l'accueil</a>
    </div>

    <h1>Résultats de recherche</h1>

    <form method="POST" class="search-form">
        <input type="text" name="recherche_livre"
               placeholder="Rechercher un livre..."
               value="<?= htmlspecialchars($search_query) ?>" required>
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!empty($livres)): ?>
        <p><strong><?= count($livres) ?> résultat(s) trouvé(s)</strong></p>

        <?php foreach ($livres as $livre): ?>
            <div class="livre">
                <h3><?= htmlspecialchars($livre['titre_livre']) ?></h3>
                <p><strong>Auteur :</strong> <?= htmlspecialchars($livre['auteur_livre']) ?></p>
                <p><strong>Description :</strong>
                    <?= htmlspecialchars(substr($livre['description_livre'], 0, 100)) ?>…
                </p>
                <p><strong>État :</strong>
                    <?= $livre['etat_livre'] === 'libre' ? '📗 Disponible' : '📕 Emprunté' ?>
                </p>

                <?php if ($livre['etat_livre'] === 'libre'): ?>
                    <form action="./../traitement/traitement_emprunter.php" method="post">
                        <input type="hidden" name="id_livre" value="<?= $livre['id_livre'] ?>">
                        <button class="btn-emprunter">📤 Emprunter</button>
                    </form>
                <?php else: ?>
                    <button class="btn-disabled" disabled>Non disponible</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    <?php elseif ($search_query): ?>
        <div class="no-results">
            Aucun livre trouvé pour votre recherche.
        </div>
    <?php endif; ?>

</div>

</body>
</html>
