<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: utilisateurs.php');
    exit;
}

$id     = intval($_POST['id'] ?? 0);
$prenom = trim($_POST['prenom'] ?? '');
$nom    = trim($_POST['nom'] ?? '');
$email  = trim($_POST['email'] ?? '');
$mdp    = trim($_POST['mot_de_passe'] ?? '');
$role   = $_POST['role'] ?? 'utilisateur';

if ($id <= 0 || $prenom === '' || $nom === '' || $email === '') {
    header('Location: utilisateurs.php');
    exit;
}

// Mise a jour avec ou sans changement de mot de passe
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
        ':role'   => $role, ':id'   => $id,
    ]);
} else {
    $req = $pdo->prepare("
        UPDATE utilisateurs
        SET prenom = :prenom, nom = :nom, email = :email, role = :role
        WHERE id = :id
    ");
    $req->execute([
        ':prenom' => $prenom, ':nom' => $nom,
        ':email'  => $email,  ':role' => $role, ':id' => $id,
    ]);
}

header('Location: utilisateurs.php?succes=1');
exit;
