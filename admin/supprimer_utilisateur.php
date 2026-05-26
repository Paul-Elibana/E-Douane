<?php
// je charge la connexion et je verifie que c'est un admin
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

// je recupere l'id dans l'URL
$id = intval($_GET['id'] ?? 0);

// je bloque si l'admin essaie de se supprimer lui meme
if ($id <= 0 || $id === $_SESSION['user_id']) {
    header('Location: utilisateurs.php');
    exit;
}

// je supprime l'utilisateur
$req = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
$req->execute([':id' => $id]);

header('Location: utilisateurs.php?succes=1');
exit;
