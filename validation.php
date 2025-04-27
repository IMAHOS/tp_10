<?php
session_start();

// Liste des utilisateurs valides avec leurs mots de passe
$valid_users = [
    'itisme' => 'justme',  // Utilisateur original
    'morad' => '123456'    // Nouvel utilisateur ajouté
];

// Gestion de la déconnexion
if (isset($_GET['afaire']) && $_GET['afaire'] == 'deconnexion') {
    session_destroy();
    header('Location: login.php?erreur=3');
    exit;
}

// Vérification des champs du formulaire
if (empty($_POST['login']) || empty($_POST['password'])) {
    header('Location: login.php?erreur=1');
    exit;
}

// Vérification des identifiants
if (array_key_exists($_POST['login'], $valid_users) && 
    $valid_users[$_POST['login']] === $_POST['password']) {
    $_SESSION['CONNECT'] = 'OK';
    $_SESSION['USERNAME'] = $_POST['login'];
    header('Location: accueil.php');
    exit;
} else {
    header('Location: login.php?erreur=2');
    exit;
}
?>