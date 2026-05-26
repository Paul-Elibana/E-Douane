<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ajouter.php');
    exit;
}

$numero      = trim($_POST['numero'] ?? '');
$importateur = trim($_POST['importateur'] ?? '');
$montant     = trim($_POST['montant'] ?? '');
$statut      = trim($_POST['statut'] ?? 'en_attente');

$erreurs = [];
if ($numero === '')          $erreurs[] = "Le numero est obligatoire.";
if ($importateur === '')     $erreurs[] = "L'importateur est obligatoire.";
if (!is_numeric($montant))   $erreurs[] = "Le montant doit etre un nombre.";
if ($statut === '')          $erreurs[] = "Le statut est obligatoire.";

if (!empty($erreurs)) {
    require_once 'includes/header.php';
    foreach ($erreurs as $e) {
        echo '<p class="alert alert-error">' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<a href="ajouter.php">Retour au formulaire</a>';
    require_once 'includes/footer.php';
    exit;
}

try {
    $req = $pdo->prepare("
        INSERT INTO declarations (numero, importateur, montant, statut)
        VALUES (:numero, :importateur, :montant, :statut)
    ");
    $req->execute([
        ':numero'      => $numero,
        ':importateur' => $importateur,
        ':montant'     => $montant,
        ':statut'      => $statut,
    ]);
    header('Location: index.php?succes=1');
    exit;
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        require_once 'includes/header.php';
        echo '<p class="alert alert-error">Ce numero de declaration existe deja.</p>';
        echo '<a href="ajouter.php">Retour au formulaire</a>';
        require_once 'includes/footer.php';
    } else {
        die("Erreur : " . $e->getMessage());
    }
}
