<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Deja connecte → redirige vers l'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config/db.php';

    $email = trim($_POST['email'] ?? '');
    $mdp   = trim($_POST['mot_de_passe'] ?? '');

    if ($email === '' || $mdp === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $req->execute([':email' => $email]);
        $user = $req->fetch();

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            // Connexion reussie : on stocke les infos en session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_nom']  = $user['prenom'] . ' ' . $user['nom'];
            $_SESSION['user_role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Douane — Connexion</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container" style="max-width: 400px; margin-top: 5rem;">
    <h1>E-Douane</h1>
    <h2 style="margin-bottom: 1.5rem;">Connexion</h2>

    <?php if ($erreur !== ''): ?>
        <p class="alert alert-error"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php" id="form-login">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit" class="btn" style="width: 100%;">Se connecter</button>
    </form>
</div>
<script src="assets/app.js"></script>
</body>
</html>
