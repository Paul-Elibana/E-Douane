<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Deja connecte → redirige vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erreur  = '';
$succes  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php';

    $prenom = trim($_POST['prenom'] ?? '');
    $nom    = trim($_POST['nom'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $mdp    = trim($_POST['mot_de_passe'] ?? '');

    // Validation
    if ($prenom === '' || $nom === '' || $email === '' || $mdp === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (strlen($mdp) < 6) {
        $erreur = "Le mot de passe doit faire au moins 6 caracteres.";
    } else {
        try {
            $req = $pdo->prepare("
                INSERT INTO utilisateurs (prenom, nom, email, mot_de_passe, role)
                VALUES (:prenom, :nom, :email, :mdp, 'utilisateur')
            ");
            $req->execute([
                ':prenom' => $prenom,
                ':nom'    => $nom,
                ':email'  => $email,
                ':mdp'    => password_hash($mdp, PASSWORD_DEFAULT),
            ]);
            $succes = "Compte cree avec succes. Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $erreur = "Cet email est deja utilise.";
            } else {
                die("Erreur : " . $e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Douane — Inscription</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container" style="max-width: 400px; margin-top: 5rem;">
    <h1>E-Douane</h1>
    <h2 style="margin-bottom: 1.5rem;">Inscription</h2>

    <?php if ($erreur !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <?php if ($succes !== ''): ?>
        <p class="alert alert-success"><?= htmlspecialchars($succes, ENT_QUOTES, 'UTF-8') ?></p>
        <p><a href="login.php">Se connecter</a></p>
    <?php else: ?>
        <form method="POST" action="inscription.php">

            <label for="prenom">Prenom</label>
            <input type="text" id="prenom" name="prenom" required maxlength="100">

            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required maxlength="100">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required maxlength="150">

            <label for="mot_de_passe">Mot de passe <small>(6 caracteres minimum)</small></label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">

            <button type="submit" class="btn" style="width: 100%;">Creer mon compte</button>
        </form>

        <p style="margin-top: 1rem; text-align: center;">
            Deja un compte ? <a href="login.php">Se connecter</a>
        </p>
    <?php endif; ?>
</div>
<script src="assets/app.js"></script>
</body>
</html>
