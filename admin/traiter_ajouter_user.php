<?php
// je charge la connexion et je verifie que c'est un admin
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

// ce fichier doit venir du formulaire uniquement
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ajouter_utilisateur.php');
    exit;
}

// je recupere les donnees du formulaire
$prenom = trim($_POST['prenom'] ?? '');
$nom    = trim($_POST['nom'] ?? '');
$email  = trim($_POST['email'] ?? '');
$mdp    = trim($_POST['mot_de_passe'] ?? '');
$role   = $_POST['role'] ?? 'utilisateur';

// je verifie que les champs sont remplis
$erreurs = [];
if ($prenom === '') $erreurs[] = "Le prenom est obligatoire.";
if ($nom === '')    $erreurs[] = "Le nom est obligatoire.";
if ($email === '')  $erreurs[] = "L'email est obligatoire.";
if (strlen($mdp) < 6) $erreurs[] = "Le mot de passe doit faire au moins 6 caracteres.";

if (!empty($erreurs)) {
    require_once '../includes/header.php';
    foreach ($erreurs as $e) {
        echo '<p class="alert alert-error">' . htmlspecialchars($e, ENT_QUOTES, 'UTF-8') . '</p>';
    }
    echo '<a href="ajouter_utilisateur.php">Retour</a>';
    require_once '../includes/footer.php';
    exit;
}

// j'insere le nouvel utilisateur dans la base
try {
    $req = $pdo->prepare("
        INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, role)
        VALUES (:prenom, :nom, :email, :mdp, :role)
    ");
    $req->execute([
        ':prenom' => $prenom,
        ':nom'    => $nom,
        ':email'  => $email,
        ':mdp'    => password_hash($mdp, PASSWORD_DEFAULT),
        ':role'   => $role,
    ]);
    header('Location: utilisateurs.php?succes=1');
    exit;
} catch (PDOException $e) {
    // l'email est deja utilise par quelqu'un d'autre
    if ($e->getCode() === '23000') {
        require_once '../includes/header.php';
        echo '<p class="alert alert-error">Cet email est deja utilise.</p>';
        echo '<a href="ajouter_utilisateur.php">Retour</a>';
        require_once '../includes/footer.php';
    } else {
        die("Erreur : " . $e->getMessage());
    }
}
