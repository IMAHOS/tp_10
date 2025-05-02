<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=TP10', 'root', '');

// Gestion des actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'ajouter':
            if (!empty($_POST['titre']) && !empty($_POST['auteur'])) {
                $stmt = $pdo->prepare("INSERT INTO exercice VALUES (NULL, ?, ?, ?)");
                $stmt->execute([$_POST['titre'], $_POST['auteur'], date('Y-m-d')]);
                $message = "Ajout effectué avec succès !";
            }
            break;
            
        case 'modifier':
            if (!empty($_POST['titre']) && !empty($_POST['auteur']) && !empty($_GET['id'])) {
                $stmt = $pdo->prepare("UPDATE exercice SET titre = ?, auteur = ? WHERE id = ?");
                $stmt->execute([$_POST['titre'], $_POST['auteur'], $_GET['id']]);
                $message = "Modification effectuée avec succès !";
            }
            break;
            
        case 'supprimer':
            if (!empty($_GET['id'])) {
                $stmt = $pdo->prepare("DELETE FROM exercice WHERE id = ?");
                $stmt->execute([$_GET['id']]);
                $message = "Suppression effectuée avec succès !";
            }
            break;
    }
}

// Récupération de tous les exercices
$exercices = $pdo->query("SELECT * FROM exercice ORDER BY date_creation DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Système de gestion des livre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: ltr;
            text-align: left;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="submit"] {
            padding: 5px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Système de gestion des livres</h1>
    
    <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
    
    <h2>Ajouter un nouvel livre</h2>
    <form method="post" action="?action=ajouter">
        <label>Titre : <input type="text" name="titre" required></label>
        <label>Auteur : <input type="text" name="auteur" required></label>
        <input type="submit" value="Ajouter">
    </form>
    
    <h2>Liste des livers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Date de création</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($exercices as $exercice): ?>
        <tr>
            <td><?= $exercice['id'] ?></td>
            <td><?= htmlspecialchars($exercice['titre']) ?></td>
            <td><?= htmlspecialchars($exercice['auteur']) ?></td>
            <td><?= $exercice['date_creation'] ?></td>
            <td>
                <a href="modifier.php?id=<?= $exercice['id'] ?>">Modifier</a> |
                <a href="?action=supprimer&id=<?= $exercice['id'] ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html></td></tr></body>