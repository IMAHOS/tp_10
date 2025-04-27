<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION['CONNECT']) ){
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 1.2em;
        }
        a {
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Bienvenue <?php echo htmlspecialchars($_SESSION['USERNAME']); ?> !</h1>
    
    <?php if ($_SESSION['USERNAME'] == 'morad'): ?>
        <p>Contenu spécial pour Morad</p>
    <?php endif; ?>
    
    <a href="validation.php?afaire=deconnexion">Déconnexion</a>
</body>
</html>