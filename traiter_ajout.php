<?php
// je charge la connexion et je verifie la connexion utilisateur
require_once 'config/db.php';
require_once 'includes/auth.php';

// ce fichier doit etre appele uniquement depuis le formulaire
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ajouter.php');
    exit;
}

// je recupere ce que l'utilisateur a rempli dans le formulaire
$numero      = trim($_POST['numero'] ?? '');
$importateur = trim($_POST['importateur'] ?? '');
$montant     = trim($_POST['montant'] ?? '');
$statut      = trim($_POST['statut'] ?? 'en_attente');

// je verifie que les champs obligatoires sont remplis
$erreurs = [];
if ($numero === '')          $erreurs[] = "Le numero est obligatoire.";
if ($importateur === '')     $erreurs[] = "L'importateur est obligatoire.";
if (!is_numeric($montant))   $erreurs[] = "Le montant doit etre un nombre.";
if ($statut === '')          $erreurs[] = "Le statut est obligatoire.";

// si il y a des erreurs j'affiche les messages
if (!empty($erreurs)) {
    require_once 'includes/header.php';
    foreach ($erreurs as $e) {
        echo '<p class="alert alert-error">' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<a href="ajouter.php">Retour au formulaire</a>';
    require_once 'includes/footer.php';
    exit;
}

// j'insere la declaration dans la base de donnees
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
    // tout s'est bien passe je redirige vers l'accueil
    header('Location: index.php?succes=1');
    exit;
} catch (PDOException $e) {
    // si le numero existe deja dans la base j'affiche un message
    if ($e->getCode() === '23000') {
        require_once 'includes/header.php';
        echo '<p class="alert alert-error">Ce numero de declaration existe deja.</p>';
        echo '<a href="ajouter.php">Retour au formulaire</a>';
        require_once 'includes/footer.php';
    } else {
        die("Erreur : " . $e->getMessage());
    }
}
