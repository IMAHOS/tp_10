<?php
// الاتصال بقاعدة البيانات
$pdo = new PDO('mysql:host=localhost;dbname=TP10', 'root', '');

// جلب التمرين للتعديل
if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM exercice WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $exercice = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$exercice) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un exercice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            text-align: right;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], a {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover, a:hover {
            background-color: #0056b3;
        }
        a {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <h1>modifier </h1>
    
    <form method="post" action="index.php?action=modifier&id=<?= $exercice['id'] ?>">
        <label>titre: <input type="text" name="titre" value="<?= htmlspecialchars($exercice['titre']) ?>" required></label><br>
        <label>auteur: <input type="text" name="auteur" value="<?= htmlspecialchars($exercice['auteur']) ?>" required></label><br>
        <input type="submit" value="حفظ">
        <a href="index.php">annuler</a>
    </form>
</body>
</html>