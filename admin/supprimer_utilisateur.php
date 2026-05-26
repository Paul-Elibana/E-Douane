<?php
require_once '../config/db.php';
require_once '../includes/auth.php';
exigerAdmin();

$id = intval($_GET['id'] ?? 0);

// Securite : on ne peut pas se supprimer soi-meme
if ($id <= 0 || $id === $_SESSION['user_id']) {
    header('Location: utilisateurs.php');
    exit;
}

$req = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
$req->execute([':id' => $id]);

header('Location: utilisateurs.php?succes=1');
exit;
