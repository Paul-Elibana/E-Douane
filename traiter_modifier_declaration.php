<?php
// je charge la connexion et je verifie la connexion utilisateur
require_once 'config/db.php';
require_once 'includes/auth.php';

// ce fichier doit venir du formulaire uniquement
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// je recupere les donnees du formulaire
$id          = intval($_POST['id'] ?? 0);
$numero      = trim($_POST['numero'] ?? '');
$importateur = trim($_POST['importateur'] ?? '');
$montant     = trim($_POST['montant'] ?? '');
$statut      = trim($_POST['statut'] ?? '');

// je verifie que tout est correct
$erreurs = [];
if ($id <= 0)               $erreurs[] = "Identifiant invalide.";
if ($numero === '')          $erreurs[] = "Le numero est obligatoire.";
if ($importateur === '')     $erreurs[] = "L'importateur est obligatoire.";
if (!is_numeric($montant))   $erreurs[] = "Le montant doit etre un nombre.";
if ($statut === '')          $erreurs[] = "Le statut est obligatoire.";

if (!empty($erreurs)) {
    require_once 'includes/header.php';
    foreach ($erreurs as $e) {
        echo '<p class="alert alert-error">' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<a href="modifier_declaration.php?id=' . $id . '">Retour</a>';
    require_once 'includes/footer.php';
    exit;
}

// je mets a jour la declaration dans la base
try {
    $req = $pdo->prepare("
        UPDATE declarations
        SET numero = :numero, importateur = :importateur,
            montant = :montant, statut = :statut
        WHERE id = :id
    ");
    $req->execute([
        ':numero'      => $numero,
        ':importateur' => $importateur,
        ':montant'     => $montant,
        ':statut'      => $statut,
        ':id'          => $id,
    ]);
    header('Location: index.php?modifie=1');
    exit;
} catch (PDOException $e) {
    // si le nouveau numero existe deja
    if ($e->getCode() === '23000') {
        require_once 'includes/header.php';
        echo '<p class="alert alert-error">Ce numero de declaration existe deja.</p>';
        echo '<a href="modifier_declaration.php?id=' . $id . '">Retour</a>';
        require_once 'includes/footer.php';
    } else {
        die("Erreur : " . $e->getMessage());
    }
}
