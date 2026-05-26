<?php
require_once 'config/db.php';

// Ce fichier ne doit etre appele qu'en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ajouter.php');
    exit;
}

// Recuperation et nettoyage des donnees
$numero      = trim($_POST['numero'] ?? '');
$importateur = trim($_POST['importateur'] ?? '');
$montant     = trim($_POST['montant'] ?? '');
$statut      = trim($_POST['statut'] ?? 'en_attente');

// Validation
$erreurs = [];

if ($numero === '')             $erreurs[] = "Le numero de declaration est obligatoire.";
if ($importateur === '')        $erreurs[] = "L'importateur est obligatoire.";
if (!is_numeric($montant))      $erreurs[] = "Le montant doit etre un nombre.";
if ($statut === '')             $erreurs[] = "Le statut est obligatoire.";

// S'il y a des erreurs, on les affiche
if (!empty($erreurs)) {
    require_once 'includes/header.php';
    foreach ($erreurs as $erreur) {
        echo '<p class="alert alert-error">' . htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<a href="ajouter.php">Retour au formulaire</a>';
    require_once 'includes/footer.php';
    exit;
}

// Insertion en base avec requete preparee (protege contre les injections SQL)
try {
    $requete = $pdo->prepare("
        INSERT INTO declarations (numero, importateur, montant, statut)
        VALUES (:numero, :importateur, :montant, :statut)
    ");

    $requete->execute([
        ':numero'      => $numero,
        ':importateur' => $importateur,
        ':montant'     => $montant,
        ':statut'      => $statut,
    ]);

    // Succes : redirection vers l'accueil avec message
    header('Location: index.php?succes=1');
    exit;

} catch (PDOException $e) {
    // Code 23000 = doublon sur le numero (colonne UNIQUE)
    if ($e->getCode() === '23000') {
        require_once 'includes/header.php';
        echo '<p class="alert alert-error">Ce numero de declaration existe deja.</p>';
        echo '<a href="ajouter.php">Retour au formulaire</a>';
        require_once 'includes/footer.php';
    } else {
        die("Erreur inattendue : " . $e->getMessage());
    }
}
