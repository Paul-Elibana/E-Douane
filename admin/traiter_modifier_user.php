<?php
// je charge la connexion et je verifie que c'est un admin
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

// ce fichier doit venir du formulaire uniquement
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: utilisateurs.php');
    exit;
}

// je recupere les donnees du formulaire
$id     = intval($_POST['id'] ?? 0);
$prenom = trim($_POST['prenom'] ?? '');
$nom    = trim($_POST['nom'] ?? '');
$email  = trim($_POST['email'] ?? '');
$mdp    = trim($_POST['mot_de_passe'] ?? '');
$role   = $_POST['role'] ?? 'utilisateur';

// verification basique
if ($id <= 0 || $prenom === '' || $nom === '' || $email === '') {
    header('Location: utilisateurs.php');
    exit;
}

// si l'utilisateur a tape un nouveau mot de passe je le mets a jour aussi
// sinon je change juste les autres infos
if ($mdp !== '') {
    $req = $pdo->prepare("
        UPDATE utilisateurs
        SET prenom = :prenom, nom = :nom, email = :email,
            mot_de_passe = :mdp, role = :role
        WHERE id = :id
    ");
    $req->execute([
        ':prenom' => $prenom, ':nom' => $nom, ':email' => $email,
        ':mdp'    => password_hash($mdp, PASSWORD_DEFAULT),
        ':role'   => $role,   ':id'  => $id,
    ]);
} else {
    // pas de nouveau mot de passe donc je le touche pas
    $req = $pdo->prepare("
        UPDATE utilisateurs
        SET prenom = :prenom, nom = :nom, email = :email, role = :role
        WHERE id = :id
    ");
    $req->execute([
        ':prenom' => $prenom, ':nom'  => $nom,
        ':email'  => $email,  ':role' => $role, ':id' => $id,
    ]);
}

header('Location: utilisateurs.php?succes=1');
exit;
