<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ajout des livres</h1>
    
    <form action="./../traitement/traitement_crud_livre.php" method="post">

        <label for="">Image</label>
        <input type="text" name="image_livre" id="" required><br>

        <label for="">Titre</label>
        <input type="text" name="titre_livre" id="" required><br>

        <label for="">Description</label>
        <textarea name="description_livre" rows="3" cols="50" required></textarea><br>

        <label for="">Auteur</label>
        <input type="text" name="auteur_livre" id="" required><br>

        <button type="submit" name="btn_ajout">Ajouter</button>
    </form>

</body>
</html>