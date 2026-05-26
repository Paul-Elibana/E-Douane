<?php
// Copier ce fichier en db.php et renseigner les identifiants
// Ne jamais committer db.php dans git

$host   = 'VOTRE_HOST';          // ex: localhost (local) ou sql123.infinityfree.com (InfinityFree)
$dbname = 'VOTRE_BASE';          // ex: edouane
$user   = 'VOTRE_USER';          // ex: root (local) ou if0_12345678 (InfinityFree)
$pass   = 'VOTRE_MOT_DE_PASSE';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
