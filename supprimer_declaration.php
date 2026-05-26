<?php
// je charge la connexion et je verifie que l'utilisateur est connecte
require_once 'config/db.php';
require_once 'includes/auth.php';

// je recupere l'id dans l'URL
$id = intval($_GET['id'] ?? 0);

// si l'id est pas valide je renvoie a l'accueil
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// je supprime la declaration qui a cet id
$req = $pdo->prepare("DELETE FROM declarations WHERE id = :id");
$req->execute([':id' => $id]);

// je redirige avec un message de succes
header('Location: index.php?supprime=1');
exit;
