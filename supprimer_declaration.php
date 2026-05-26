<?php
require_once 'config/db.php';
require_once 'includes/auth.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$req = $pdo->prepare("DELETE FROM declarations WHERE id = :id");
$req->execute([':id' => $id]);

header('Location: index.php?supprime=1');
exit;
