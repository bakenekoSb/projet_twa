<?php
require_once('./../configDb/database.php');
session_start();

$action = $_GET['action'] ?? '';

// AJOUT
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre_livre = $_POST['titre_livre'];
    $description_livre = $_POST['description_livre'];
    $auteur_livre = $_POST['auteur_livre'];

    $query = "INSERT INTO livres (titre_livre, description_livre, auteur_livre, etat_livre)
              VALUES (:titre, :description, :auteur, 'libre')";
    $stmt = $connection->prepare($query);
    $stmt->execute([
        'titre' => $titre_livre,
        'description' => $description_livre,
        'auteur' => $auteur_livre
    ]);
}

// SUPPRESSION
if ($action === 'delete' && isset($_GET['id_livre'])) {
    $id_livre = intval($_GET['id_livre']);
    $connection->exec("DELETE FROM livres WHERE id_livre = $id_livre");
}

// MODIFICATION
if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $connection->prepare(
        "UPDATE livres SET titre_livre=?, description_livre=?, auteur_livre=? WHERE id_livre=?"
    );
    $stmt->execute([
        $_POST['titre_livre'],
        $_POST['description_livre'],
        $_POST['auteur_livre'],
        $_POST['id_livre']
    ]);
}

// LECTURE
$stmt = $connection->query("SELECT * FROM livres");
$livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Livres</title>
    <link rel="stylesheet" href="./admin.css">
</head>
<body>

<header>
    <nav>
        <div class="logo">📚 Admin Bibliothèque</div>
        <div class="menu">
            <a href="?action=add">Ajouter un livre</a>
        </div>
    </nav>
</header>

<main>
    <h1>Gestion des Livres</h1>

    <!-- FORM AJOUT / MODIFICATION -->
    <?php if ($action === 'add' || ($action === 'update' && isset($_GET['id_livre']))): 

        $book = null;
        if ($action === 'update') {
            $stmt = $connection->prepare("SELECT * FROM livres WHERE id_livre=?");
            $stmt->execute([$_GET['id_livre']]);
            $book = $stmt->fetch();
        }
    ?>
        <div class="form-card">
            <h2><?= $action === 'add' ? 'Ajouter un livre' : 'Modifier un livre' ?></h2>

            <form method="POST">
                <?php if ($book): ?>
                    <input type="hidden" name="id_livre" value="<?= $book['id_livre'] ?>">
                <?php endif; ?>

                <label>Titre</label>
                <input type="text" name="titre_livre" required value="<?= $book['titre_livre'] ?? '' ?>">

                <label>Description</label>
                <textarea name="description_livre"><?= $book['description_livre'] ?? '' ?></textarea>

                <label>Auteur</label>
                <input type="text" name="auteur_livre" required value="<?= $book['auteur_livre'] ?? '' ?>">

                <button type="submit" class="btn-primary">
                    <?= $action === 'add' ? 'Ajouter' : 'Modifier' ?>
                </button>
            </form>
        </div>
    <?php endif; ?>

    <!-- LISTE DES LIVRES -->
 <div class="table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>État</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $l): ?>
                <tr>
                    <td><?= $l['id_livre'] ?></td>
                    <td><?= htmlspecialchars($l['titre_livre']) ?></td>
                    <td><?= htmlspecialchars($l['auteur_livre']) ?></td>
                    <td>
                        <span class="etat <?= $l['etat_livre'] === 'libre' ? 'libre' : 'emprunte' ?>">
                            <?= htmlspecialchars($l['etat_livre']) ?>
                        </span>
                    </td>
                    <td class="desc-cell">
                        <?= htmlspecialchars(substr($l['description_livre'], 0, 60)) ?>…
                    </td>
                    <td class="actions">
                        <a class="btn-edit" href="?action=update&id_livre=<?= $l['id_livre'] ?>">Modifier</a>
                        <a class="btn-delete"
                           href="?action=delete&id_livre=<?= $l['id_livre'] ?>"
                           onclick="return confirm('Supprimer ce livre ?')">
                           Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</main>

</body>
</html>
