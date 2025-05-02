<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=JeuCombat', 'root', '');

// Traitement des actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'creer':
            if (!empty($_POST['nom'])) {
                // Vérification si le nom existe déjà
                $stmt = $pdo->prepare("SELECT id FROM guerrier WHERE nom = ?");
                $stmt->execute([$_POST['nom']]);
                
                if ($stmt->fetch()) {
                    $message = "Ce nom est déjà pris!";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO guerrier (nom) VALUES (?)");
                    $stmt->execute([$_POST['nom']]);
                    $message = "Guerrier créé avec succès!";
                }
            }
            break;
            
        case 'frapper':
            if (!empty($_GET['id']) && !empty($_GET['cible'])) {
                // Augmentation des dégâts
                $stmt = $pdo->prepare("UPDATE guerrier SET degats = degats + 5 WHERE id = ?");
                $stmt->execute([$_GET['cible']]);
                
                // Vérification si le guerrier est mort
                $stmt = $pdo->prepare("SELECT degats FROM guerrier WHERE id = ?");
                $stmt->execute([$_GET['cible']]);
                $degats = $stmt->fetchColumn();
                
                if ($degats >= 100) {
                    $stmt = $pdo->prepare("DELETE FROM guerrier WHERE id = ?");
                    $stmt->execute([$_GET['cible']]);
                    $message = "Le guerrier a été vaincu!";
                } else {
                    $message = "Coup porté! Dégâts totaux: $degats";
                }
            }
            break;
    }
}


$guerriers = $pdo->query("SELECT * FROM guerrier ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jeu de Combat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        form {
            margin: 0;
        }
        input[type="text"], select {
            padding: 5px;
            margin-right: 10px;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            background-color: #e7f3fe;
            border: 1px solid #b3d7ff;
            padding: 10px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h1>Jeu de Combat</h1>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
    <h2>Créer un nouveau guerrier</h2>
    <form method="post" action="?action=creer">
        <label>Nom: <input type="text" name="nom" required></label>
        <input type="submit" value="Créer">
    </form>
    <h2>Liste des guerriers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Dégâts</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($guerriers as $guerrier): ?>
        <tr>
            <td><?= $guerrier['id'] ?></td>
            <td><?= htmlspecialchars($guerrier['nom']) ?></td>
            <td><?= $guerrier['degats'] ?></td>
            <td>
                <form method="get" action="">
                    <input type="hidden" name="action" value="frapper">
                    <input type="hidden" name="id" value="<?= $guerrier['id'] ?>">
                    <select name="cible">
                        <?php foreach ($guerriers as $cible): ?>
                            <?php if ($cible['id'] != $guerrier['id']): ?>
                                <option value="<?= $cible['id'] ?>"><?= htmlspecialchars($cible['nom']) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Frapper">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>